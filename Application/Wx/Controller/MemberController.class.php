<?php

namespace Wx\Controller;

use Wx\Common\CommonController;

class MemberController extends CommonController {
    public function index(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session("uid");
            $votenum=M('vote')->where(array('uid'=>$uid))->count();
            $this->assign("votenum",$votenum);
            $where['b.status']=1;
            $uids=M('Member')->where(array('groupid_id'=>$uid))->getField("id",true);
            $where['a.uid']=array('in',$uids);
            $sharenum = M('pool a')->join("left join zz_member b on a.tuid=b.id")->where($where)->count();
            $this->assign("sharenum",$sharenum);

            $catids=M('coupons')->where(array('status'=>1))->getField("id",true);
            $rewardmoney=M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->where(array('a.uid'=>$uid,'b.id'=>array('in',$catids)))->field("a.id,b.thumb,b.title,b.price,b.validity_endtime,a.`status`")->sum("price");
            $this->assign("rewardmoney",$rewardmoney);
            $this->display();
        }
    }
    public function myvote(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session("uid");
            $where['b.status']=2;
            $where['b.isdel']=0;
            $where['a.uid']=$uid;
            $count = M('vote a')->join("left join zz_house b on a.hid=b.id")->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('vote a')->join("left join zz_house b on a.hid=b.id")->where($where)->order("a.id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $this->display("morelist_myvote");
            }else{
                $this->display();
            }
        }
    }
    public function othershare(){
        $share['title']="蜗牛客民宿50元代金券";
            $share['content']="关注蜗牛客，回复“代金券”，马上领取50元代金券哦";
            $share['image']=C("WEB_URL")."/Public/Wx/img/111.png";
            $share['link']=C("WEB_URL").U('Wx/Member/othershare');
            $this->assign("share",$share);
            $this->display();
    }
    public function reward(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session('uid');
            $where['a.uid']=$uid;
            $type=(int)$_GET['type'];
            if($type!=6){
                if(!empty($type)&&$type!=6){
                    $where['b.type']=$type;
                }
                //$where['a.status']=0;
                // $where['c.in_endtime']=array('gt',time());
                $where['_string'] = " c.in_endtime > ".time()." or a.vaid = 0 ";
                $field="a.id,a.code,a.givenstatus,a.hid,b.thumb,b.type,b.title,b.price,b.validity_starttime,b.validity_endtime,c.in_starttime,c.in_endtime,a.num,a.`status`,b.`range`,a.vaid,a.catid";

                $catids=M('coupons')->where(array('status'=>1))->getField("id",true);
                $where['b.id']=array('in',$catids);
                $count = M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->join("left join zz_voteparty c on c.id=a.vaid")->where($where)->count();
                $this->assign("count", $count);
                $page = new \Think\Page($count,6);
                $data = M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->join("left join zz_voteparty c on c.id=a.vaid")->where($where)->field($field)->order(array('a.givenstatus'=>'asc','b.type'=>'asc','b.price'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
                
                foreach ($data as $key => $value)
                {   
                    if($value['vaid'] != 0){
                        $data[$key]['house']=M('house')->where(array('id'=>$value['hid']))->getField("title");
                        $data[$key]['link']=M('house')->where(array('id'=>$value['hid']))->getField("link");
                    }else{
                        $inn = M('inn')->where(array('id'=>$value['hid']))->find();
                        $data[$key]['house']=$inn['name'];
                        $data[$key]['in_starttime'] = $inn['starttime'];
                        $data[$key]['in_endtime'] = $inn['endtime'];
                    
                    }                  
                }
                $show = $page->show();
                $this->assign("data", $data);
                $this->assign("Page", $show);
            }else{
                $where['a.status']=0;
                $where['a.uid']=$uid;
                $where['c.ischoujiang']=0;
                $count = M('pool a')
                    ->join("left join zz_house b on a.hid=b.id")
                    ->join("left join zz_voteparty c on a.vaid=c.id")
                    ->where($where)->count();
                $this->assign("count", $count);
                $page = new \Think\Page($count,6);
                $data = M('pool a')
                    ->join("left join zz_house b on a.hid=b.id")
                    ->join("left join zz_voteparty c on a.vaid=c.id")
                    ->where($where)->field("a.code,a.hid,c.starttime as validity_starttime,c.endtime as validity_endtime,b.title as house,zz.in_starttime,zz.in_endtime")
                    ->order(array('a.inputtime'=>'asc'))
                    ->limit($page->firstRow . ',' . $page->listRows)->select();

                $show = $page->show();
                $this->assign("data", $data);
                $this->assign("Page", $show);
            }
            $this->assign("type", $type);

            $nowtime=time();
                $map['updatetime'] = array('ELT' , $nowtime);
                $map['status'] = 0;
                $map['uid'] = $uid;
                $hasCoupons = 0;
                $couponsCount = M('coupons_order')->where($map)->count();
                if($couponsCount > 0)
                    $hasCoupons = 1;
                $this->assign("hasCoupons", $hasCoupons);

            if($_GET['isAjax']==1){
                $this->display("morelist_reward");
            }else{
                $where=array();
                $uid=session('uid');
                $vaids=M('pool')->where(array('uid'=>$uid))->getField("vaid",true);
                $where['status']=2;
                $where['isdel']=0;
                $where['ischoujiang']=1;
                $where['id']=array('in',$vaids);
                $endnum = M('voteparty')->where($where)->count();
                $this->assign("endnum", $endnum);
                $where['ischoujiang']=0;
                $waitnum = M('voteparty')->where($where)->count();
                $this->assign("waitnum", $waitnum);
                $this->display();
            }
        }
    }
    public function share(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session("uid");
            $where['status']=1;
            $uids=M('Member')->where(array('groupid_id'=>$uid))->getField("id",true);
            // $uidss=M('pool')->getField("uid",true);
            // $uidss=array_unique($uidss);
            // $uidsss=array_intersect($uids,$uidss);
                        
            $where['id']=array('in',$uids);
            $count = M('member')->where($where)->count();
            $page = new \Think\Page($count,1000);
            $data = M('member')->where($where)->order("id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);
            $type=I('type');
            $this->assign("type", $type);
            if($_GET['isAjax']==1){
                $this->display("morelist_share");
            }else{
                $this->display();
            }
        }
    }
    public function givencoupons(){
        if (!session('uid')) {
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $id=I('id');
            $this->assign("id",$id);
            $this->display();
        }
    }
    public function ajax_given(){
        if(IS_POST){
            $coupons_orderid=$_POST['coupons_orderid'];
            $tuid=$_POST["uid"];
            $phone=$_POST['phone'];
            $nickname=$_POST['nickname'];
            if(empty($tuid)){
                if(empty($nickname))
                    $this->ajaxReturn(array('status'=>-4),'json');
                else if(empty($phone))
                    $this->ajaxReturn(array('status'=>-5),'json');
            }
            $data=M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->where(array('a.id'=>$coupons_orderid))->field("a.id,a.catid,a.vaid,a.hid,b.validity_starttime,b.validity_endtime,a.`status`")->find();
            if($data['status']==1){
                $this->ajaxReturn(array('status'=>-1),'json');
            }
            $nowtime=time();
            if($data['a.vaid'] != 0){
                if($data['validity_endtime']<$nowtime){
                    $this->ajaxReturn(array('status'=>-2),'json');
                }
            }else{
                $inn = M('inn')->where(array('id'=>$data['hid']))->find();
                if(!$inn){
                    $this->ajaxReturn(array('status'=>-2),'json');
                }else{
                    if($inn['endtime'] < $nowtime)
                        $this->ajaxReturn(array('status'=>-2),'json');
                }
            }
            if(empty($tuid)){
                $tuid=M('Member')->where(array('phone'=>$phone))->getField("id");
                $user = M('Member')->where(array('phone'=>$phone,'nickname'=>$nickname,'unionid'=>array('EXP','IS NULL')))->find();
                $nickname = $use['nickname'];
                $phone = $use['phone'];
            }
            if($tuid == '')
                $this->ajaxReturn(array('status'=>-3),'json');
            $id=M('coupons_order')->save(array(
                'id'=>$coupons_orderid,
                'uid'=>$tuid
                ));
            if($id){
                $uid=session('uid');
                M('coupons_givenlog')->add(array(
                    'uid'=>$uid,
                    'tuid'=>$tuid,
                    'nickname'=>$nickname,
                    'phone'=>$phone,
                    'couponsid'=>$coupons_orderid,
                    'catid'=>$data['catid'],
                    'inputtime'=>time()
                    ));
                $this->ajaxReturn(array('status'=>1,'msg'=>"赠送成功"),'json');
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>"赠送失败"),'json');
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>"请求非法"),'json');
        }
    }
    public function couponslog(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session("uid");
            $where['status']=1;
            $where['uid']=$uid;
            $count = M('coupons_log')->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('coupons_log')->where($where)->order("id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
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
    public function useservice(){
        $type=I('type');
        if($type==1){
            $content=M('config')->where(array('varname'=>'coupons_rule'))->getField("value");
        }else if($type==2){
            $content=M('config')->where(array('varname'=>'chongjiangcode_rule'))->getField("value");
        }
        $this->assign("content", $content);
        $this->display();
    }
    public function setphone(){

        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $id=I('id');
            $houseid=I('houseid',$id);
            $from=I('from','notwaitreward');
            
            session("nid",$id);
            $uid = session('uid');

            // $joinstatus=M("pool")->where(array('uid'=>$uid,'hid'=>$id,'isowner'=>1))->find();
            // if($joinstatus){
            //     $this->redirect("Wx/News/backshow",array('nid'=>$id));

            // }
            $isend = M("voteparty")->where(array('hid'=>$houseid))->find();
            if($isend['ischoujiang'] == 1)
                $this->redirect("Wx/Member/endreward");
            $joinstatus=M("pool")->where(array('uid'=>$uid,'hid'=>$houseid,'isowner'=>1))->find();
            if($joinstatus && $from == 'notwaitreward'){
                $this->redirect("Wx/Member/waitreward");
            }
            $data=M('house')->where(array('id'=>$houseid))->find();
            $data['from'] = $from;
            $share['id']=$data['id'];
            $share['title']=$data['title'];
            //$share['content']=$this->str_cut(trim(strip_tags($data['content'])), 100);
            $share['content']=$data['description'];
            if($uid){
                $tuijiancode = M('member')->where(array('id'=>$uid))->getField("tuijiancode");
                //$share['link']=C("WEB_URL").U('Wx/News/show',array('nid'=>$id,'invitecode'=>$tuijiancode));
                // $share['link']="{$data['link']}&nid={$houseid}&invitecode={$tuijiancode}";
                $share['link']=C("WEB_URL").U('Wx/News/bridge',array('nid'=>$houseid,'invitecode'=>$tuijiancode));
            }else{
                //$share['link']=C("WEB_URL").U('Wx/News/show',array('nid'=>$id));
                //$share['link']="{$data['link']}&nid={$houseid}";
                $share['link']=C("WEB_URL").U('Wx/News/bridge',array('nid'=>$houseid));
            }

            $share['image']=C("WEB_URL").$data['thumb'];
            $this->assign("share",$share);
            $this->assign("data",$data);
            $this->display();
        }
    }
    public function ajax_setphone(){
        if(IS_POST){
            $phone=I('phone');
            $nickname=I('nickname');
            $uid=session("uid");
            if(empty($phone)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'手机号码不能为空'),'json');
            }
            if(!isMobile($phone)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'手机号码格式错误'),'json');
            }
            if(empty($nickname)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'联系人不能为空'),'json');
            }
            // $user=M('member')->where(array('id'=>$uid))->find();
            // if($user['phone']==$phone&&$user['nickname']==$nickname){
            //     $this->ajaxReturn(array('code'=>1,'msg'=>'提交成功'),'json');
            // }else{
                $id=M('member')->where(array('id'=>$uid))->save(array("phone"=>$phone,"nickname"=>$nickname));
                if($id!==false){
                    $this->ajaxReturn(array('code'=>1,'msg'=>'提交成功'),'json');
                }else{
                    $this->ajaxReturn(array('code'=>0,'msg'=>'找不到改用户'),'json');
                }
            //}
            
        }else{
            $this->ajaxReturn(array('code'=>0,'msg'=>'请求非法'),'json');
        }

        
    }
    public function ajax_share(){
        $sharestatus=$_POST['sharestatus'];
        $nid=$_POST['mid'];
        $uid=session("uid");
        $user=M('member')->where(array('id'=>$uid))->find();
        $votePartyData=M('voteparty')->where(array('hid'=>$nid))->order(array('id'=>'desc'))->find();
        $ischoujiang = $votePartyData['ischoujiang'];

        if($sharestatus=='success'){
            if($ischoujiang != 1){
            $pool=M('pool')->where(array('hid'=>$nid))->order(array('id'=>'desc'))->find();
            if($pool){
                $code=(int)$pool['code']+1;
                $code=sprintf("%06d", $code);//生成4位数，不足前面补0   
            }else{
                $code="000001";
            }
            //$code=\Api\Common\CommonController::genNumberString(8);
            $voteparty=M('voteparty')->where(array('hid'=>$nid))->order(array('id'=>'desc'))->find();
            $status=M('pool')->where(array('hid'=>$nid,'uid'=>$uid,'isowner'=>1))->find();
            if(!$status){
                M('pool')->add(array(
                    'uid'=>$uid,
                    'code'=>$code,
                    'hid'=>$nid,
                    'vaid'=>$voteparty['id'],
                    'status'=>0,
                    'inputtime'=>time()
                    ));
                
            }
            
            if(!$status&&!empty($user['groupid_id'])){
                    $code=(int)$code+1;
                    $code=sprintf("%06d", $code);//生成4位数，不足前面补0   
                    //$code=\Api\Common\CommonController::genNumberString(8);
                    $voteparty=M('voteparty')->where(array('hid'=>$nid))->order(array('id'=>'desc'))->find();
                    M('pool')->add(array(
                        'uid'=>$user['groupid_id'],
                        'code'=>$code,
                        'hid'=>$nid,
                        'vaid'=>$voteparty['id'],
                        'status'=>0,
                        'isowner'=>0,
                        'inputtime'=>time()
                        ));
                    
                }
            }
            // $access_token=S("access_token");
            // $openId = $user['openid'];
            // $appid = C('WEI_XIN_INFO.APP_ID');
            // $secret = C("WEI_XIN_INFO.APP_SECRET");
            // // if(empty($access_token)){
            //     $get_access_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $secret;
            //     $res1 = file_get_contents($get_access_token_url);
            //     $user_obj1 = json_decode($res1, true);
            //     $access_token=$user_obj1["access_token"];
            //     S("access_token",$access_token,7200);
            // // }
       
            // $get_user_info_url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openId."&lang=zh_CN";
            // // \Think\Log::write("ssurl:{$get_user_info_url}",'WARN');
            // $user_info = file_get_contents($get_user_info_url);

            // $user_info_obj = json_decode($user_info, true);
            // // \Think\Log::write("ss:{$user_info_obj['subscribe']},{$user_info_obj['nickname']}",'WARN');
            $data=array();
            $data["subscribestatus"] = 1;
            if($user['subscribestatus'] == 1){
                M("member")->where(array('id'=>$uid))->save($data);
                exit(json_encode(array('subscribe'=>1,'ischoujiang'=>$ischoujiang)));
            }
            else{
                M("member")->where(array('id'=>$uid))->save($data);
                exit(json_encode(array('subscribe'=>0,'ischoujiang'=>$ischoujiang)));
            }
        }
    }


    public function usecoupons(){
        $couponsid=I('id');
        $this->assign("couponsid",$couponsid);
        $data=M('coupons_order a')->join("left join zz_voteparty b on a.vaid=b.id")->where(array('a.id'=>$couponsid))->find();
        $date1 = time();
        $data['in_starttime'] = date('Y-m-d',strtotime("+1 week"));
        $this->assign("data",$data);
        $this->display();
    }
    public function ajax_usecoupons(){
        if(IS_POST){
            $phone=I('phone');
            $realname=I('realname');
            $mannum=I('mannum');
            $date=I('date');
            $content=I('content');
            $couponsid=I('couponsid');
            $uid=session("uid");
            if(empty($phone)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'手机号码不能为空'),'json');
            }
            if(!isMobile($phone)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'手机号码格式错误'),'json');
            }
            if(empty($realname)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'姓名不能为空'),'json');
            }
            if(empty($mannum)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'意向入住人数不能为空'),'json');
            }
            if(empty($date)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'意向入住时间不能为空'),'json');
            }
            $user=M('member')->where(array('id'=>$uid))->find();
            $coupons_order=M('coupons_order')->where(array('id'=>$couponsid))->find();
            if(empty($coupons_order)||$coupons_order['status']==1){
                $this->ajaxReturn(array('code'=>0,'msg'=>'优惠券不存在或已使用'),'json');
            }else{
                $id=M('coupons_exchangelog')->add(array(
                        "uid"=>$uid,
                        "phone"=>$phone,
                        "realname"=>$realname,
                        "mannum"=>$mannum,
                        "date"=>$date,
                        "content"=>$content,
                        "catid"=>$coupons_order['catid'],
                        "couponsid"=>$couponsid,
                        "inputtime"=>time()
                    ));
                if($id){
                    M('coupons_order')->where(array('id'=>$couponsid))->setField("givenstatus",1);
                    $this->ajaxReturn(array('code'=>1,'msg'=>'提交成功'),'json');
                }else{
                    $this->ajaxReturn(array('code'=>0,'msg'=>'提交失败'),'json');
                }
            }
            
        }else{
            $this->ajaxReturn(array('code'=>0,'msg'=>'请求非法'),'json');
        }
    }
    public function exchangeerror(){
        $where=array();
        $ids=M('pool')->where(array('uid'=>$uid))->getField("hid",true);
        $jsonStr="[{";
        $house = M('house')->where(array('status'=>2,'isdel'=>0,'id'=>array('not in',$ids)))->order(array("listorder"=>'desc','id'=>'desc'))->select();
        foreach ($house as $key => $value) {
            # code...
            if($key!=0){
                $jsonStr.="}, {";
            }
            $jsonStr.="'height': '100%','width': '100%','content': '<div  onClick=\"aa(".$value['id'].");\" data-id=\"".$value['id']."\" class=\"recom_list pr\"><div class=\"recom_a pr\"><img class=\"aa\" src=\"".$value['thumb']."\"><div class=\"recom_g f18 center pa\"><div class=\"recom_g1 fl\">".$value['title']."</div></div></div></div>'";
        }
        $jsonStr.="}]";
        $this->assign("jsonStr", $jsonStr);
        $totalnum=count($house);
        $this->assign("totalnum", $totalnum);
        $this->display();
    }
    public function exchangesuccess(){
        $where=array();
        $ids=M('pool')->where(array('uid'=>$uid))->getField("hid",true);
        $jsonStr="[{";
        $house = M('house')->where(array('status'=>2,'isdel'=>0,'id'=>array('not in',$ids)))->order(array("listorder"=>'desc','id'=>'desc'))->select();
        foreach ($house as $key => $value) {
            # code...
            if($key!=0){
                $jsonStr.="}, {";
            }
            $jsonStr.="'height': '100%','width': '100%','content': '<div  onClick=\"aa(".$value['id'].");\" data-id=\"".$value['id']."\" class=\"recom_list pr\"><div class=\"recom_a pr\"><img class=\"aa\" src=\"".$value['thumb']."\"><div class=\"recom_g f18 center pa\"><div class=\"recom_g1 fl\">".$value['title']."</div></div></div></div>'";
        }
        $jsonStr.="}]";
        $this->assign("jsonStr", $jsonStr);
        $totalnum=count($house);
        $this->assign("totalnum", $totalnum);
        $this->display();
    }
    public function endreward(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session('uid');
            $vaids=M('pool')->where(array('uid'=>$uid))->getField("vaid",true);
            $where['status']=2;
            $where['isdel']=0;
            $where['ischoujiang']=1;
            $where['id']=array('in',$vaids);
            $count = M('voteparty')->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('voteparty')->where($where)->order(array("listorder"=>'desc','id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
            foreach ($data as $key => $value) {
                # code...
                $data[$key]['house']=M('house')->where(array('id'=>$value['hid']))->getField("title");
                $data[$key]['link']=M('house')->where(array('id'=>$value['hid']))->getField("link");
                $data[$key]['pool']=M('pool')->where(array('uid'=>$uid,'vaid'=>$value['id']))->limit(6)->getField("code",true);
                $zhongjiangstatus=M('pool')->where(array('uid'=>$uid,'vaid'=>$value['id'],'status'=>1))->count("id");
                if($zhongjiangstatus>0){
                    $data[$key]['iszhongjiang']=1;
                }else{
                    $data[$key]['iszhongjiang']=0;
                }
                $data[$key]['link']=M('house')->where(array('id'=>$value['hid']))->getField("link");
            }
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);
            $nowtime=time();
            $map['updatetime'] = array('ELT' , $nowtime);
            $map['status'] = 0;
            $map['uid'] = $uid;
            $hasCoupons = 0;
            $couponsCount = M('coupons_order')->where($map)->count();
            if($couponsCount > 0)
                $hasCoupons = 1;
            $this->assign("hasCoupons", $hasCoupons);
            if($_GET['isAjax']==1){
                $this->display("morelist_endreward");
            }else{
                $endnum=$count;
                $this->assign("endnum", $endnum);
                $where['ischoujiang']=0;
                $waitnum = M('voteparty')->where($where)->count();
                $this->assign("waitnum", $waitnum);

                $where=array();
                $ids=M('pool')->where(array('uid'=>$uid))->getField("hid",true);
                if($ids != '')
                    $house = M('house')->where(array('status'=>2,'isdel'=>0,'id'=>array('not in',$ids)))->order(array("listorder"=>'desc','id'=>'desc'))->select();
                else
                    $house = M('house')->where(array('status'=>2,'isdel'=>0))->order(array("listorder"=>'desc','id'=>'desc'))->select();
                $jsonStr="[{";
                // $house = M('house')->where(array('status'=>2,'isdel'=>0,'id'=>array('not in',$ids)))->order(array("listorder"=>'desc','id'=>'desc'))->select();
                foreach ($house as $key => $value) {
                    # code...
                    if($key!=0){
                        $jsonStr.="}, {";
                    }
                    $jsonStr.="'height': '100%','width': '100%','content': '<div  onClick=\"return aa(\'".$value['link']."\');\" data-id=\"".$value['id']."\" class=\"recom_list pr\"><div class=\"recom_a pr\"><img class=\"aa\"  src=\"".$value['thumb']."\"><div class=\"recom_g f18 center pa\"><div class=\"recom_g1 fl\">".$value['title']."</div></div></div></div>'";
                }
                $jsonStr.="}]";
                $this->assign("jsonStr", $jsonStr);
                $totalnum=count($house);
                $this->assign("totalnum", $totalnum);
                $this->display();
            }
        }
    }
    public function waitreward(){

        $cc = session('uid');  
        // session(null);
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $uid=session('uid');
            $vaids=M('pool')->where(array('uid'=>$uid))->getField("vaid",true);
            $where['status']=2;
            $where['isdel']=0;
            $where['ischoujiang']=0;
            $where['id']=array('in',$vaids);
            $count = M('voteparty')->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('voteparty')->where($where)->order(array("listorder"=>'desc','id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
            foreach ($data as $key => $value) {
                # code...
                $data[$key]['link']=M('house')->where(array('id'=>$value['hid']))->getField("link");
                $data[$key]['house']=M('house')->where(array('id'=>$value['hid']))->getField("title");
                $data[$key]['houseid']=M('house')->where(array('id'=>$value['hid']))->getField("id");
                $data[$key]['pool']=M('pool')->where(array('uid'=>$uid,'vaid'=>$value['id']))->limit(6)->getField("code",true);
            }
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $this->display("morelist_waitreward");
            }else{
                $waitnum=$count;
                $this->assign("waitnum", $waitnum);
                $where['ischoujiang']=1;
                $endnum = M('voteparty')->where($where)->count();
                $this->assign("endnum", $endnum);


                $where=array();
                $ids=M('pool')->where(array('uid'=>$uid))->getField("hid",true);
                $jsonStr="[{";

                if($ids != '')
                    $house = M('house')->where(array('status'=>2,'isdel'=>0,'id'=>array('not in',$ids)))->order(array("listorder"=>'desc','id'=>'desc'))->select();
                else
                    $house = M('house')->where(array('status'=>2,'isdel'=>0))->order(array("listorder"=>'desc','id'=>'desc'))->select();
                foreach ($house as $key => $value) {
                    # code...
                    if($key!=0){
                        $jsonStr.="}, {";
                    }

                    $title = mb_substr($value['title'], 0,18);
                    if(mb_strlen($title) == 18){
                        $title = mb_substr($title, 0,16);
                        $title = "{$title}...";
                    }
                    $jsonStr.="'height': '100%','width': '100%','content': '<div  onClick=\"aa(\'".$value['link']."\');\" data-id=\"".$value['id']."\" class=\"recom_list pr\"><div class=\"recom_a pr\"><img class=\"aa\" src=\"".$value['thumb']."\"><div class=\"recom_g f18 center pa\"><div class=\"recom_g1 fl\">".$title."</div></div></div></div>'";
                }
                $jsonStr.="}]";
                $this->assign("jsonStr", $jsonStr);
                $totalnum=count($house);
                $this->assign("totalnum", $totalnum);
                $nowtime=time();
                $map['updatetime'] = array('ELT' , $nowtime);
                $map['status'] = 0;
                $map['uid'] = $uid;
                $hasCoupons = 0;
                $couponsCount = M('coupons_order')->where($map)->count();
                if($couponsCount > 0)
                    $hasCoupons = 1;
                $this->assign("hasCoupons", $hasCoupons);
                $this->display();
            }
        }
    }
    public function pool(){
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else {
            $vaid=I('vaid');
            $uid=session('uid');
            $data=M('voteparty')->where(array('id'=>$vaid))->find();
            $pool=M('pool')->where(array('uid'=>$uid,'vaid'=>$vaid))->order(array('id'=>'desc'))->select();
            foreach ($pool as $key => $value) {
                # code...
                $pool[$key]['number']=sprintf("%02d", $key+1);
            }
            $data['pool']=$pool;
            $data['num']=count($pool);
            $this->assign("data", $data);
            $this->display();
        }
    }
}