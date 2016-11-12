<?php

namespace Wx\Controller;

use Wx\Common\CommonController;

class VoteController extends CommonController {
    public function test(){
        // $model = new T\Model();
        $flag = false;
        M()->startTrans();
        $innid = I('innid');

        $inn = M('innvote')->add(array(
            'uid'=>1,
            'innid'=>1,
            'inputtime'=>time(),
            'status'=>10
        ));
        if($inn){
            $log = M('innvotelog')->add(array(
                'id'=>1,
                'uid'=>1,
                'innid'=>1,
                'inputtime'=>time(),
                'status'=>10,
                'voteresult'=>10
            ));
            if($log)
                $flag = true;
        }

        if($flag){
            M()->commit();
            $this->ajaxReturn(array('success'=>true));
        }
        else{
            M()->rollback();
            $this->ajaxReturn(array('success'=>false));
        }
    }

    public function rule(){
        $activity = M('wxactivity')->where(array('status'=>2))->find();
        if($activity){
            M('wxactivity')->where(array('status'=>2))->setInc('accessnum');
            $this->assign('rule', $activity['description']);
            $this->display();
        }
    }

	public function index() {
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $uid=session("uid");
            $rule=M('page')->where(array('catid'=>1))->find();
            $this->assign("rule",$rule);

            $activity = M('wxactivity')->where(array('status'=>2))->find();
            if($activity){
                M('wxactivity')->where(array('status'=>2))->setInc('accessnum');
                $this->assign("hot",$activity['accessnum']);
                $this->assign("logo",$activity['logo']);
                $this->assign('rule', $activity['description']);
                $this->assign('link', $activity['link']);
            }

            $joinlist=M('inn')->where(array('status'=>2))->field('uid')->select();
            $this->assign("joinnum",count($joinlist));
            $votenum=M('innvote')->where(array('status'=>1))->count();
            $this->assign("votenum",$votenum);
            // $totalnum=M('vote')->count();
            // $this->assign("totalnum",$totalnum);
            $type=I('type');
            $condition=I("condition");
            $order=array();
            if($type){
                $order=array('votenum'=>'desc','id'=>'desc');
            }else{
                $order=array('id'=>'desc');
            }
            $where['status']=2;
            if($condition && $condition != ""){
                $where1['name']  = array('like', '%'.$condition.'%');
                $where1['id']  = $condition;
                $where1['_logic'] = 'or';
                $where['_complex'] = $where1;
    
            }
            $this->assign("condition",$condition);
            $page = new \Think\Page(count($joinlist),6);
            $data = M('inn')->where($where)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();
            // var_dump($data);
            foreach ($data as $key => $value)
            {
                // $votestatus=M("innvote")->where(array('uid'=>$uid,'innid'=>$value['id'],'status'=>'1',"DATE_FORMAT(FROM_UNIXTIME(inputtime),'%Y-%m-%d')"=>date("Y-m-d")))->find();
                $votedata = M("innvote")->where(array('uid'=>$uid,'innid'=>$value['id'],'status'=>'1'))->order(array('inputtime'=>'desc'))->find();
                if($votedata != null){
                    if(date('Y-m-d',$votedata["inputtime"]) == date("Y-m-d"))
                        $data[$key]['isvote']=1;
                    else
                        $data[$key]['isvote']=2;
                }else{
                    $data[$key]['isvote']=2;
                }
            }
            // var_dump($data);
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);

            $this->assign("type", $type);

            $share['link'] = C("WEB_URL").U('Wx/News/bridge',array('invitecode'=>$tuijiancode));
            $share['title'] = $activity['title'];
            $share['content'] = $activity['abstract'];
            $share['image'] = C("WEB_URL").$activity['logo'];
            $this->assign("share",$share);

            if($_GET['isAjax']==1){
                $this->display("morelist_index");
            }else{
                $this->display();
            }
        }
        
    }

    //中奖后处理
    public function getcoupons($rank,$innid,$uid){
        $flag = false;
        if($this->takeoffcoupons(1,$innid,$uid))
        {
            $res = M('innvotelog')->add(array(
                'uid'=>$uid,
                'innid'=>$innid,
                'inputtime'=>time(),
                'status'=>1,
                'voteresult'=>$rank
            ));
            if($rank == 6){
                $flag = true;
            } else {
                //中奖处理
                $res = false;
                $res = M('innprize')->where(array('innid'=>$innid,'level'=>$rank))->setDec('leftquantity',1);
                if($res){
                    $res = M('coupons_order')->add(array(
                        'catid'=>$rank,
                        'uid'=>$uid,
                        'num'=>1,
                        'status'=>0,
                        'inputtime'=>time(),
                        'updatetime'=>time(),
                        'vaid'=>0,
                        'hid'=>$innid,
                        'givenstatus'=>0
                    ));
                    if($res)
                        $flag = true;
                }
            }
        }
        if($flag)
            return ($rank - 1) * 60;
        else
            return -1;
    }

    //是否扣除抽奖券
    public function takeoffcoupons($type,$innid,$uid){
        $flag = false;
        $y = date("Y");
        $m = date("m");
        $d = date("d");
        if($type == 1){
            
            //type为1表示客栈抽奖
            $count = M('innvotelog')->where(array('status'=>1,'innid'=>$innid,'uid'=>$uid,'_string'=>" inputtime <= ".mktime(23,59,59,$m,$d,$y)." and inputtime >= ".mktime(0,0,0,$m,$d,$y)))->find();
            if($count > 0){
                //今日非首次抽奖，扣除抽奖券
                $res = M('innuserinfo')->where(array('uid'=>$uid,'status'=>1))->setDec('votecouponscount',10);

                if($res){
                    $res = M('inncoupons_log')->add(array(
                        'uid'=>$uid,
                        'innid'=>$innid,
                        'status'=>1,
                        'inputtime'=>time(),
                        'type'=>2,
                        'num'=>10,
                        'description'=>'客栈抽奖'
                    ));
                    if($res){
                        // $res = M('innvote')->where(array('status'=>1,'innid'=>$innid,'uid'=>$uid))->limit(10)->save(array('status'=>2));
                        if($res)
                            $flag = true;
                    }
                }
                
            }else{
                $flag = true;
            }
        }else if($type == 2){
            //type为2表示平台抽奖
            $count = M('innvotelog')->where(array('status'=>2,'uid'=>$uid,'_string'=>" inputtime <= ".mktime(23,59,59,$m,$d,$y)." and inputtime >= ".mktime(0,0,0,$m,$d,$y)))->find();
            if($count > 0){
                //今日非首次抽奖，扣除抽奖券
                $res = M('innuserinfo')->where(array('uid'=>$uid,'status'=>1))->setDec('invitecouponscount',10);
                if($res){
                    $res = M('inncoupons_log')->add(array(
                        'uid'=>$uid,
                        'innid'=>0,
                        'status'=>1,
                        'inputtime'=>time(),
                        'type'=>2,
                        'num'=>10,
                        'description'=>'客栈抽奖'
                    ));
                    if($res)
                        $flag = true;
                }
            }else{
                $flag = true;
            }
        }
        return $flag;
    }
    public function ajax_checkvotecount(){
        $innid = I('innid');
        $uid = session('uid');
        $y = date("Y");$m = date("m");$d = date("d");
        $count = M('innvotelog')->where(array('status'=>1,'innid'=>$innid,'uid'=>$uid,'_string'=>" inputtime <= ".mktime(23,59,59,$m,$d,$y)." and inputtime >= ".mktime(0,0,0,$m,$d,$y)))->find();
        if($count == 0)
            $this->ajaxReturn(array('status'=>1),'json');
        else
            $this->ajaxReturn(array('status'=>2),'json');
    }

    //判断抽奖券是否足够
    public function isenoughcoupons($type,$innid,$uid){
        $y = date("Y");$m = date("m");$d = date("d");
        $count = M('innvotelog')->where(array('status'=>1,'innid'=>$innid,'uid'=>$uid,'_string'=>" inputtime <= ".mktime(23,59,59,$m,$d,$y)." and inputtime >= ".mktime(0,0,0,$m,$d,$y)))->find();
        if($count == 0)
            return 1;
        $innuser = M('innuserinfo')->where(array('status'=>1,'uid'=>$uid))->find();
        if($type == 1){
            //type为1表示客栈抽奖
            if($innuser['votecouponscount'] < 10)
                return 0;
            else {
                $innvote = M('innvote')->where(array('status'=>1,'innid'=>$innid,'uid'=>$uid))->count();
                if($innvote < 0)
                    return 0;
                else
                    return 1;    
            }
        }else if($type == 2){
            //type为2表示平台抽奖
            if($innuser['invitecouponscount'] < 10)
                return 0;
            else 
                return 1;
        }
    }

    //检测是否前一时间段是否有该抽完的奖项但是还没抽掉,或者当前时间段是否中奖
    public function hasleftcoupons($starttime,$duration,$num,$leftnum){
        $used = $num - $leftnum;  //已经抽掉的优惠券数量
        $period = intval($duration / $num);  //每个时间段
        if(($used + 1) * $period < time() - $starttime)
            return 1;   //前段时间有未抽中的奖项
        else if (($used + 1) * $period > time() - $starttime && $used * $period < time() - $starttime) {
            return 2; //当前时间未中
        }
        else
            return 0;   //当前时间已中
    }

    //用户抽奖
    public function makevote(){
        $innid = I('innid');  //获取客栈id
        // $uid = session('uid');
        $uid = session('uid');
        if($innid){
            //若innid存在，则为客栈抽奖
            $inn = M('inn')->where(array('id'=>$innid))->find();
            if($inn == false || $inn == null || $inn['status'] == 1 || $inn['status'] == 3){
                //未审核和审核失败的都归类为找不到
                $this->ajaxReturn(array('success'=>false,'msg'=>'找不到该客栈！'));
            }else if($inn['status'] == 4){
                //4代表下架
                $this->ajaxReturn(array('success'=>false,'msg'=>'该客栈已下架!'));
            }else if($inn['isvote'] == 2){
                $this->ajaxReturn(array('success'=>false,'msg'=>'该客栈未参加抽奖活动!'));
            }else if($this->isenoughcoupons(1,$innid,$uid) == 0){
                $this->ajaxReturn(array('success'=>false,'msg'=>'抽奖券不足!'));
            }

            M()->startTrans();
            $proSum = 0; //总权重
            $proArr = array(); //数组
            //奖项列表
            $prize_arr = M('gift')->field('id,rank,prize,v,remark')->order(array('rank'=>asc))->select();
            $prizeArr = M('innprize')->where(array('innid'=>$innid))->order(array('level'=>asc))->select();
            foreach ($prizeArr as $key => $value) {
                # code...
                $prizeArr[$key]['v'] = $prize_arr[$key]['v'];
                $prizeArr[$key]['remark'] = $prize_arr[$key]['remark'];
            }
            // $mm = "";
            foreach ($prizeArr as $key => $value) {
                # code...
                $res = 0;
                $duration = $inn['endtime'] - $inn['starttime'];
                $res = $this->hasleftcoupons($inn['starttime'],$duration,$prizeArr[$key]["quantity"],$prizeArr[$key]["leftquantity"]);
                // $mm .= $res." ";
                if($res == 1){
                    $radius = $this->getcoupons($value['level'],$innid,$uid);  //中奖处理,返回角度
                    if($radius != -1){
                        M()->commit();
                        $this->ajaxReturn(array('success'=>true, 'data'=>$radius, 'msg'=>$prizeArr[$result]["remark"]));
                           
                    }else{
                        M()->rollback();
                        $this->ajaxReturn(array('success'=>false, 'msg'=>'系统错误'));
                            
                    }
                }
                $proSum += $value['v'];
                array_push($proArr, $value['v']);
            }

            $totaltime = intval(($inn['endtime'] - time()) / 60);
            $result = '';
            $prizeArr[5]['remark'] = $prize_arr[5]['remark'];
            $prizeArr[5]['v'] = $prize_arr[5]['v'];
            array_push($proArr, $prizeArr[5]['v']);
            $proSum += $totaltime + $prizeArr[5]['v'];
            $proArr[5] += $totaltime;
            $a1 = $proSum;
            $randomArr = array();
            //概率数组循环
            foreach ($proArr as $key => $proCur) { 
                $randNum = mt_rand(1, $proSum);
                array_push($randomArr, $randNum); 
                if ($randNum <= $proCur) { 
                    $result = $key; 
                    $res = 0;
                    $duration = $inn['endtime'] - $inn['starttime'];
                    $res = $this->hasleftcoupons($inn['starttime'],$duration,$prizeArr[$key]["quantity"],$prizeArr[$key]["leftquantity"]);
                    if($res == 2){
                        $radius = $this->getcoupons($key+1,$innid,$uid);
                        if($radius != -1){
                            M()->commit();
                            $this->ajaxReturn(array('success'=>true, 'data'=>$radius, 'msg'=>$prizeArr[$result]["remark"].$a1.'|||'.$proArr[0]."_".$proArr[1]."_".$proArr[2]."_".$proArr[3]."_".$proArr[4]."_".$proArr[5]."|||".$randomArr[0]."_".$randomArr[1]."_".$randomArr[2]."_".$randomArr[3]."_".$randomArr[4]."_".$randomArr[5]));
                        }else{
                            M()->rollback();
                            $this->ajaxReturn(array('success'=>false, 'msg'=>'系统错误'));                       
                        }
                    }
                    else{
                        // M()->commit();
                        $radius = $this->getcoupons(6,$innid,$uid);
                        if($radius != -1){
                            M()->commit();
                            $this->ajaxReturn(array('success'=>true, 'data'=>300, 'msg'=>$prize_arr[5]["remark"].$a1.'|||'.$proArr[0]."_".$proArr[1]."_".$proArr[2]."_".$proArr[3]."_".$proArr[4]."_".$proArr[5]."|||".$randomArr[0]."_".$randomArr[1]."_".$randomArr[2]."_".$randomArr[3]."_".$randomArr[4]."_".$randomArr[5]));
                        }else{
                            M()->rollback();
                            $this->ajaxReturn(array('success'=>false, 'msg'=>'系统错误'));       
                        }
                    }
                    
                    break; 
                } else { 
                    $proSum -= $proCur; 
                } 
            } 
        }else{
            //若innid不存在，则为平台抽奖

        }
    }

    public function apply(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $activity=M('wxactivity')->where(array('status'=>2))->find();
            $this->assign('title',$activity['title']);
            $this->display();
        }
    }
    public function ajax_submit(){
        if(IS_POST){
            $uid=session("uid");
            $hasapplyed = M('inn')->where(array('status'=>1,'uid'=>$uid))->order('inputtime desc')->limit(1)->select();
            if(count($hasapplyed) != 0){
                $this->ajaxReturn(array('code'=>0,'msg'=>'您已提交过一份申请，请等待前一份申请审核后在提交新的申请！'),'json');
            }
            $name=I('name');
            $address=I('address');
            $logo = I('logo');
            $des1 = I('des1');
            $des2 = I('des2');
            $des3 = I('des3');
            $description  = I('description');
            $ownner = I('ownner');
            $contact = I('contact');
            $isvote = I('isvote');
            $starttime = intval(strtotime(date('Y-m-d 00:00:00',strtotime(I('starttime')))));
            $endtime = intval(strtotime(date('Y-m-d 23:59:59',strtotime(I('endtime')))));
            $roomnum = I('roomnum');
            $prizeArr = array();
            $prizeArrDesc = array();
            $prize1 = I('prize1');
            $prizeArr[0] = $prize1; 
            $prize2 = I('prize2');
            $prizeArr[1] = $prize2; 
            $prize3 = I('prize3');
            $prizeArr[2] = $prize3;
            $prize4 = I('prize4');
            $prizeArr[3] = $prize4; 
            $prize5 = I('prize5');
            $prizeArr[4] = $prize5; 

            $prize1desc = I('prize1desc');
            $prizeArrDesc[0] = $prize1desc;
            $prize2desc = I('prize2desc');
            $prizeArrDesc[1] = $prize2desc;
            $prize3desc = I('prize3desc');
            $prizeArrDesc[2] = $prize3desc;
            $prize4desc = I('prize4desc');
            $prizeArrDesc[3] = $prize4desc;
            $prize5desc = I('prize5desc');
            $prizeArrDesc[4] = $prize5desc;
            if(empty($name)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'美宿名称不能为空'),'json');
            }
            if(empty($address)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'美宿地址不能为空'),'json');
            }
            if(empty($description)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'美宿描述不能为空'),'json');
            }
            if(empty($ownner)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'联系人不能为空'),'json');
            }
            if(empty($contact)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'联系方式不能为空'),'json');
            }
            if(empty($isvote)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'是否试睡不能为空'),'json');
            }else{
                if($isvote == 1){
                    if(empty($roomnum)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'奖品数量不能为空'),'json');
                    }
                    if(empty($prize1desc)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'一等奖描述不能为空'),'json');
                    }
                    if(empty($prize2desc)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'二等奖描述不能为空'),'json');
                    }
                    if(empty($prize3desc)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'三等奖描述不能为空'),'json');
                    }
                    if(empty($prize4desc)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'四等奖描述不能为空'),'json');
                    }
                    if(empty($prize5desc)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'五等奖描述不能为空'),'json');
                    }
                    if(empty($prize1)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'一等奖数量不能为空'),'json');
                    }
                    if(empty($prize2)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'二等奖数量不能为空'),'json');
                    }
                    if(empty($prize3)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'三等奖数量不能为空'),'json');
                    }
                    if(empty($prize4)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'四等奖数量不能为空'),'json');
                    }
                    if(empty($prize5)){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'五等奖数量不能为空'),'json');
                    }
                    if($roomnum != $prize1 * 1 + $prize2 * 1 + $prize3 * 1 + $prize4 * 1 + $prize5 * 1){
                        $this->ajaxReturn(array('code'=>0,'msg'=>'奖品数量应等于各奖品数量之和！'),'json');
                    }
                    
                }
            }
            if($logo != '' && $logo != null){
                if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $logo, $result)){
                    $type = $result[2];
                    $new_file = "./Uploads/images/wx/logo".time().".{$type}";
                    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $logo)))){
                        // echo '新文件保存成功：', $new_file;
                        $data['logo'] = substr($new_file, 1);
                    }
                }
            }
            $jsonImg = array();
            $i = 0;
            if($des1 != '' && $des1 != null){
                if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $des1, $result)){
                    $type = $result[2];
                    $new_file = "./Uploads/images/wx/des1".time().".{$type}";
                    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $des1)))){
                        // echo '新文件保存成功：', $new_file;
                        // $strImg = substr($new_file, 1);

                        $new_file = substr($new_file, 1);
                        $jsonImg[$i++]["thumb"] = $new_file;
                    }
                }
            }
            if($des2 != '' && $des2 != null){
                if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $des2, $result)){
                    $type = $result[2];
                    $new_file = "./Uploads/images/wx/des2".time().".{$type}";
                    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $des2)))){
                        // echo '新文件保存成功：', $new_file;
                        $new_file = substr($new_file, 1);
                        $jsonImg[$i++]["thumb"] = $new_file;
                    }
                }
            }
            if($des3 != '' && $des3 != null){
                if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $des3, $result)){
                    $type = $result[2];
                    $new_file = "./Uploads/images/wx/des3".time().".{$type}";
                    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $des3)))){
                        // echo '新文件保存成功：', $new_file;
                        $new_file = substr($new_file, 1);
                        $jsonImg[$i++]["thumb"] = $new_file;
                    }
               }
            }
            $data['imglist'] = json_encode($jsonImg);
            $data['uid'] = $uid;
            $data['name'] = $name;
            $data['address'] = $address;
            $data['description'] = $description;
            $data['ownner'] = $ownner;
            $data['contact'] = $contact;
            $data['isvote'] = $isvote;
            $data['starttime'] = $starttime;
            $data['endtime'] = $endtime;
            $data['roomnum'] = $roomnum;
            $data['status'] = 1;
            $data['inputtime'] = time();
            $data['votenum'] = 0;
            M()->startTrans();
            $flag = true;
            $id = M('inn')->data($data)->add();
            if($id!==false){
                if($data['isvote'] == 1){
                    for($i = 1; $i < 6; $i ++){
                        $key = 'prize'.$i;
                        $prize = M('innprize')->data(array('innid'=>$id,'quantity'=>$prizeArr[$i-1],'leftquantity'=>$prizeArr[$i-1],'level'=>$i,'desc'=>$prizeArrDesc[$i-1]))->add();
                        if(!$prize)
                            $flag = false;
                    }
                }
                if($flag == true){
                    M()->commit();
                    $this->ajaxReturn(array('code'=>1,'msg'=>'提交成功'),'json');
                }else{
                    M()->rollback();
                    $this->ajaxReturn(array('code'=>2,'msg'=>'提交失败'),'json');
                }
            }else{
                M()->rollback();
                $this->ajaxReturn(array('code'=>2,'msg'=>'提交失败'),'json');
            }

            
        }else{
            $this->ajaxReturn(array('code'=>0,'msg'=>'请求非法'),'json');
        }
    }
    public function ajax_vote(){
        if(IS_POST){
            $innid=$_POST['innid'];
            $inn = M('inn')->where(array('id'=>$innid,'status'=>2))->find();
            if(!$inn || $inn == null){
                $this->ajaxReturn(array('status'=>-1),'json');
            }
            $uid=session("uid");

            $y = date("Y");$m = date("m");$d = date("d");
            $innvote = M('innvote')->where(array('uid'=>$uid,'innid'=>$innid,'_string'=>" inputtime <= ".mktime(23,59,59,$m,$d,$y)." and inputtime >= ".mktime(0,0,0,$m,$d,$y)))->find();
            if($innvote){
                $this->ajaxReturn(array('status'=>-1),'json');
            }
            $user=M('member')->where(array('id'=>$uid))->find();
  
            $starttime=mktime(0,0,0,(int)date("m"),(int)date("d"),(int)date("Y"));
            $endtime=mktime(23,59,59,(int)date("m"),(int)date("d"),(int)date("Y"));
            $where['uid']=$uid;
            $where['inputtime']=array(array('egt',$starttime),array('elt',$endtime));
            $where['status'] = 1;
            $votenum=M("innvote")->where($where)->count();
            if($votenum>=5){
                $this->ajaxReturn(array('status'=>-3),'json');
            }
            $id=M('innvote')->add(array(
                'uid'=>$uid,
                'innid'=>$innid,
                'inputtime'=>time(),
                'status'=>1
                ));
            if($id){
                M('inn')->where(array('id'=>$innid))->setInc("votenum");
                M('inncoupons')->add(array(
                    'uid'=>$uid,
                    'innid'=>$innid,
                    'status'=>1,
                    'inputtime'=>time()
                ));
                M('inncoupons_log')->add(array(
                    'uid' => $uid,
                    'innid' => $innid,
                    'inputtime' => time(),
                    'status' => 1,
                    'type' => 1,
                    'num' => 1,
                    'description' => '客栈投票'
                ));
                $innuserinfo = M('innuserinfo')->where(array('status'=>1,'uid'=>$uid))->find();
                if($innuserinfo)
                    M('innuserinfo')->where(array('status'=>1,'uid'=>$uid))->setInc('votecouponscount');
                else
                    M('innuserinfo')->add(array(
                        'status' => 1,
                        'uid' => $uid,
                        'invitecouponscount' => 0,
                        'votecouponscount' => 1,
                    ));
                if(!empty($user['groupid_id']) && $user['groupid_id'] != 0){
                    M('inncoupons')->add(array(
                        'uid'=>$user['groupid_id'],
                        'innid'=>0,
                        'status'=>1,
                        'inputtime'=>time()
                    ));
                    M('inncoupons_log')->add(array(
                        'uid' => $user['groupid_id'],
                        'innid' => 0,
                        'inputtime' => time(),
                        'status' => 1,
                        'type' => 1,
                        'num' => 1,
                        'description' => '邀请好友投票'
                    ));
                    $innuserinfo = M('innuserinfo')->where(array('status'=>1,'uid'=>$user['groupid_id']))->find();
                    if($innuserinfo)
                        M('innuserinfo')->where(array('status'=>1,'uid'=>$user['groupid_id']))->setInc('invitecouponscount');
                    else
                        M('innuserinfo')->add(array(
                            'status' => 1,
                            'uid' => $user['groupid_id'],
                            'invitecouponscount' => 1,
                            'votecouponscount' => 0,
                        ));
                }
                $newvotenum = M('inn')->where(array('id'=>$innid))->find();
                $this->ajaxReturn(array('status'=>1,'msg'=>$newvotenum['votenum']),'json');
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>"投票失败"),'json');
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>"请求非法"),'json');
        }
    }
    public function myinfo(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session("uid");
            $user = M('member')->where(array('id'=>$uid))->find();
            if(!$user)
                $this->error("找不到该用户!");
            else{
                $tmp = M('innvote')->where(array('status'=>1,'uid'=>$uid))->distinct(true)->field('innid')->select();
                $user['votedinncount'] = count($tmp);
                $tmp = M('member')->where(array('groupid_id'=>$uid))->distinct(true)->field('id')->select();
                $user['sharemembercount'] = count($tmp);
                $innuserinfo = M('innuserinfo')->where(array('status'=>1,'uid'=>$uid))->find();
                if(!$innuserinfo){
                    M('innuserinfo')->add(array(
                        'status' => 1,
                        'uid' => $uid,
                        'invitecouponscount' => 0,
                        'votecouponscount' => 0,
                    ));
                    $user['invitecouponscount'] = 0;
                    $user['votecouponscount'] = 0;
                }else{
                    $user['invitecouponscount'] = $innuserinfo['invitecouponscount'];
                    $user['votecouponscount'] = $innuserinfo['votecouponscount'];
                }

            }
            $this->assign('user',$user);
            $this->display();
        }
    }
    public function votedinn(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session("uid");
            $order=array();
            $order=array('innid'=>'desc');
            $where['status']=1;
            $where['uid'] = $uid;
            $tmp = M('innvote')->where($where)->distinct(true)->field('innid')->select();
            $datacount = count($tmp);
            $page = new \Think\Page($datacount,6);
            $data = M('innvote')->where($where)->distinct(true)->field('innid')->limit($page->firstRow . ',' . $page->listRows)->select();
            foreach ($data as $key => $value)
            {
                $inn = M("inn")->where(array('id'=>$value['innid']))->find();
                if(!$inn)
                    $this->error("查找客栈异常！");
                else{
                    $data[$key]['name'] = $inn['name'];
                    $data[$key]['id'] = $inn['id'];
                    // $data[''] = $inn[''];
                    $data[$key]['address'] = $inn['address'];
                    $data[$key]['votenum'] = $inn['votenum'];
                    $data[$key]['logo'] = $inn['logo'];

                    $votedata = M("innvote")->where(array('uid'=>$uid,'innid'=>$value['innid'],'status'=>'1'))->order(array('inputtime'=>'desc'))->find();
                    if($votedata != null){
                        if(date('Y-m-d',$votedata["inputtime"]) == date("Y-m-d"))
                            $data[$key]['isvote']=1;
                        else
                            $data[$key]['isvote']=2;
                    }else{
                        $data[$key]['isvote']=2;
                    }
                }
            }
            // var_dump($data);
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);

            if($_GET['isAjax']==1){
                $this->display("morelist_index");
            }else{
                $this->display();
            }
        }
        
    }
    public function inncouponslog(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session("uid");
            $where['status']=1;
            $where['uid']=$uid;
            $count = M('inncoupons_log')->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('inncoupons_log')->where($where)->order("id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
            $show = $page->show();
            $innuserinfo = M('innuserinfo')->where(array('uid'=>$uid))->find();
            if(!$innuserinfo){
                M('innuserinfo')->add(array(
                    'status' => 1,
                    'uid' => $uid,
                    'invitecouponscount' => 0,
                    'votecouponscount' => 0,
                ));
                $this->assign("invitecouponscount",0);
                $this->assign("votecouponscount",0);
            }else{
                $this->assign("invitecouponscount",$innuserinfo['invitecouponscount']);
                $this->assign("votecouponscount",$innuserinfo['votecouponscount']);
            }

            $this->assign("data", $data);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $this->display("morelist_log");
            }else{
                $this->display();
            }
        }
    }
    public function show() {
       if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $innid=I('id');

            $uid=session("uid");
            $data=M('inn')->where(array('id'=>$innid,'status'=>'2'))->find();
            if(!$data){
                $this->error("该客栈已下架或者删除！");
            }
            
            $votedata = M("innvote")->where(array('uid'=>$uid,'innid'=>$innid,'status'=>'1'))->order(array('inputtime'=>'desc'))->find();
            if($votedata != null){
                if(date('Y-m-d',$votedata["inputtime"]) == date("Y-m-d"))
                    $data['hasvote']=1;
                else
                    $data['hasvote']=2;
            }else{
                $data['hasvote']=2;
             }
            $usedcoupons = '';
            $data['imglist'] = json_decode($data['imglist'],true);
            if($data['isvote'] == 1){
                if($data['couponlevelone'] > 0)
                    $usedcoupons .= '全额/';
                if($data['couponlevelsec'] > 0)
                    $usedcoupons .= '五折/';
                if($data['couponlevelthd'] > 0)
                    $usedcoupons .= '八折/';
                if($usedcoupons != '')
                    $usedcoupons = substr($usedcoupons, 0, strlen($usedcoupons) - 1);
            }
            $tuijiancode = M('member')->where(array('id'=>$uid))->getField('tuijiancode');
            $share['link'] = C("WEB_URL").U('Wx/News/bridge',array('innid'=>$innid,'invitecode'=>$tuijiancode));
            $share['title'] = $data['name'];
            $share['content'] = $data['description'];
            $share['image'] = C("WEB_URL").$data['logo'];
            $this->assign("share",$share);
            $this->assign('usedcoupons',$usedcoupons);
            // var_dump($data['imglist']);
            $this->assign("imglist",$data['imglist']);
            $this->assign("data",$data);
            $this->display();
        }

    }
    public function turntable(){
        $gift= M('gift')->where(array('rank'=>array('neq',6)))->field('id,rank,prize')->order(array('id'=>asc))->select();
        $this->assign("gift",$gift);
        $innid = I('innid');
        $this->assign('innid',$innid);
        $inn = M('inn')->where(array('id'=>$innid))->find();
        $this->assign('inn',$inn);
        $turntablerule=M('config')->where(array('varname'=>'turntablerule'))->getField("value");
        $this->assign("turntablerule", $turntablerule);
        $this->display();
    }
    public function turntablelog(){
        $where['rid']=array('neq',6);
        $count = D("Choujianglog")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $data = D("Choujianglog")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["prize"] = M('gift')->where('rank=' . $r['rid'])->getField("prize");
            $data[$k]['validity_starttime']=M('Coupons')->where('id=' . $r['rid'])->getField("validity_starttime");
            $data[$k]['validity_endtime']=M('Coupons')->where('id=' . $r['rid'])->getField("validity_endtime");
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        if($_GET['isAjax']==1){
            $this->display("morelist_log");
        }else{
            $this->display();
        }
    }
}