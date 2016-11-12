<?php
namespace Wx\Controller;
use Wx\Common\CommonController;

class PartyController extends CommonController {

    public function index() {
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $uid=session("uid");
            $rule=M('page')->where(array('catid'=>1))->find();
            $this->assign("rule",$rule);

            $joinlist=M('vote')->distinct(true)->field('uid')->select();
            $this->assign("joinnum",count($joinlist));
            $rewardnum=M('reward')->count();
            $this->assign("rewardnum",$rewardnum);
            $totalnum=M('vote')->count();
            $this->assign("totalnum",$totalnum);
            $type=I('type');
            $order=array();
            if($type){
                $order=array('votenum'=>'desc','id'=>'desc');
            }else{
                $order=array('id'=>'desc');
            }
            $where['status']=2;
            $where['isdel']=0;
            $count = M('house')->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('house')->where($where)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();
            foreach ($data as $key => $value)
            {
                $votestatus=M("vote")->where(array('uid'=>$uid,'hid'=>$value['id']))->find();
                if($votestatus){
                    $data[$key]['isvote']=1;
                }else{
                    $data[$key]['isvote']=0;
                }
            }
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);

            $this->assign("type", $type);

            if($_GET['isAjax']==1){
                $this->display("morelist_index");
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
            $id=I('id');
            $uid=session("uid");
            $data=M('house')->where(array('id'=>$id))->find();
            $hitstatus=M("hit")->where(array('uid'=>$uid,'value'=>$id,'varname'=>'voteparty'))->find();
            if($hitstatus){
                $data['isvhit']=1;
            }else{
                $data['isvhit']=0;
            }
            $this->assign("data",$data);

            $share['title']=$data['title'];
            $share['content']=trim(strip_tags($data['content']));
            $uid = session('uid');
            if($uid){
                $tuijiancode = M('member')->where(array('id'=>$uid))->getField("tuijiancode");
                $share['link']=C("WEB_URL").U('Wx/Party/show',array('id'=>$id,'invitecode'=>$tuijiancode));
            }else{
                $share['link']=C("WEB_URL").U('Wx/Party/show',array('id'=>$id));
            }

            $share['image']=C("WEB_URL").$data['thumb'];
            $this->assign("share",$share);
            $this->display();
        }
    }
    public function ajax_vote(){
        if(IS_POST){
            $hid=$_POST['hid'];
            $uid=session("uid");
            $user=M('member')->where(array('id'=>$uid))->find();
            if($user['subscribestatus']==0){
                $this->ajaxReturn(array('status'=>-2),'json');
            }
            $votestatus=M("vote")->where(array('uid'=>$uid,'hid'=>$hid))->find();
            if($votestatus){
                $this->ajaxReturn(array('status'=>-1),'json');
            }
            $starttime=mktime(0,0,0,(int)date("m"),(int)date("d"),(int)date("Y"));
            $endtime=mktime(23,59,59,(int)date("m"),(int)date("d"),(int)date("Y"));
            $where['uid']=$uid;
            $where['inputtime']=array(array('egt',$starttime),array('elt',$endtime));
            $votenum=M("vote")->where($where)->count();
            if($votenum>5){
                $this->ajaxReturn(array('status'=>-3),'json');
            }
            $id=M('vote')->add(array(
                'uid'=>$uid,
                'hid'=>$hid,
                'inputtime'=>time()
                ));
            if($id){
                M('house')->where(array('id'=>$hid))->setInc("votenum");
                $coupons=M('coupons')->where(array('id'=>4))->find();
                $code="000000";
                if($votenum%2==0){
                    $pool=M('pool')->where(array('hid'=>$hid))->order(array('id'=>'desc'))->find();
                    if($pool){
                        $code=(int)$pool['code']+1;
                        $code=sprintf("%06d", $code);//生成4位数，不足前面补0   
                    }
                    //$code=\Api\Common\CommonController::genNumberString(8);
                    $voteparty=M('voteparty')->where(array('hid'=>$hid))->order(array('id'=>'desc'))->find();
                    M('pool')->add(array(
                        'uid'=>$uid,
                        'code'=>$code,
                        'hid'=>$hid,
                        'vaid'=>$voteparty['id'],
                        'status'=>0,
                        'inputtime'=>time()
                        ));
                }
                M("coupons_order")->add(array(
                        'catid'=>$coupons['id'],
                        'uid'=>$uid,
                        'num'=>1,
                        'status'=>0,
                        'inputtime'=>time(),
                        'updatetime'=>time()
                        ));
                M('coupons_log')->add(array(
                    'uid'=>$uid,
                    'money'=>$coupons['price'],
                    'addtime'=>time(),
                    'addip'=>get_client_ip(),
                    'status'=>1,
                    'dcflag'=>1,
                    'remark'=>"投票奖励"
                    ));
                if(!empty($user['groupid_id'])){
                    if($votenum%4==0){
                        $pool=M('pool')->where(array('hid'=>$hid))->order(array('id'=>'desc'))->find();
                        if($pool){
                            $code=(int)$pool['code']+1;
                        }else{
                            $code=(int)$code+1;
                        }
                        
                        $code=sprintf("%06d", $code);//生成4位数，不足前面补0   
                        //$code=\Api\Common\CommonController::genNumberString(8);
                        $voteparty=M('voteparty')->where(array('hid'=>$hid))->order(array('id'=>'desc'))->find();
                        M('pool')->add(array(
                            'uid'=>$user['groupid_id'],
                            'code'=>$code,
                            'hid'=>$hid,
                            'vaid'=>$voteparty['id'],
                            'status'=>0,
                            'isowner'=>0,
                            'inputtime'=>time()
                            ));
                    }
                    $coupons=M('coupons')->where(array('id'=>5))->find();
                    M("coupons_order")->add(array(
                            'catid'=>$coupons['id'],
                            'uid'=>$user['groupid_id'],
                            'num'=>1,
                            'status'=>0,
                            'inputtime'=>time(),
                            'updatetime'=>time()
                            ));
                    M('coupons_log')->add(array(
                        'uid'=>$user['groupid_id'],
                        'money'=>$coupons['price']*($coupons['percent']/100),
                        'addtime'=>time(),
                        'addip'=>get_client_ip(),
                        'status'=>1,
                        'dcflag'=>1,
                        'remark'=>"投票奖励"
                        ));
                }
                $this->ajaxReturn(array('status'=>1,'msg'=>"投票成功"),'json');
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>"投票失败"),'json');
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>"请求非法"),'json');
        }
    }
    public function ajax_hit(){
        if(IS_POST){
            $hid=$_POST['hid'];
            $uid=session("uid");
            $user=M('member')->where(array('id'=>$uid))->find();
            if($user['subscribestatus']==0){
                $this->ajaxReturn(array('status'=>-2),'json');
            }
            $hitstatus=M("hit")->where(array('uid'=>$uid,'value'=>$hid,'varname'=>'voteparty'))->find();
            if($hitstatus){
                $this->ajaxReturn(array('status'=>-1),'json');
            }
            $id=M('hit')->add(array(
                'uid'=>$uid,
                'varname'=>'voteparty',
                'value'=>$hid,
                'inputtime'=>time()
                ));
            if($id){
                M('house')->where(array('id'=>$hid))->setInc("hit");
                $this->ajaxReturn(array('status'=>1,'msg'=>"点赞成功"),'json');
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>"点赞失败"),'json');
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>"请求非法"),'json');
        }
    }
    public function exchange() {
        $id=I('id');
        $data=M('house')->where(array('id'=>$id))->find();
        $this->assign("data",$data);
        $num=session("num");
        $this->assign("num",$num);
        $couponsnum=session("couponsnum");
        $this->assign("couponsnum",$couponsnum);
        $couponstotal=session("couponstotal");
        $this->assign("couponstotal",$couponstotal);
        session("couponsnum",null);
        session("couponstotal",null);
        session("num",null);
        session("couponsid",null);
        $this->display();
    }
    public function useservice(){
        $content=M('config')->where(array('varname'=>'use_service'))->getField("value");
        $this->assign("content", $content);
        $this->display();
    }
    public function coupons(){
        $uid=session('uid');
        $where['a.uid']=$uid;
        $where['a.status']=0;
        $where['b.validity_endtime']=array('gt',time());
        $field="a.id,b.hid,b.thumb,b.title,b.price,b.validity_starttime,b.validity_endtime,a.num,a.`status`,b.`range`,b.type";

        $catids=M('coupons')->where(array('status'=>1))->getField("id",true);
        $where['b.id']=array('in',$catids);
        $count = M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->where($where)->count();
        $page = new \Think\Page($count,100);
        $data = M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->where($where)->field($field)->order(array('b.type'=>'asc','b.price'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($data as $key => $value)
        {
            $hid=$value['hid'];
                $hidbox=explode(",",$hid);
                if(count($hidbox)>2){
                    $data[$key]['house']="多家民宿";
                }else{
                    $data[$key]['house']=M('house')->where(array('id'=>$value['hid']))->getField("title");
                }
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);

        $couponsid=session("couponsid");
        $this->assign("couponsid",$couponsid);

        if($_GET['isAjax']==1){
            $this->display("morelist_coupons");
        }else{
            $this->display();
        }

	}
    public function doexchange(){
        if($_POST){
            $couponsid=$_POST['couponsid'];
            $couponsidbox=explode(",",$couponsid);
            session("couponsnum",$_POST['couponsnum']);
            session("couponstotal",$_POST['couponstotal']);
            session("num",$_POST['num']);
            session("couponsid",$couponsid);
            $uid=session("uid");
            $hid=$_POST['hid'];
            $data=M('House')->where(array('id'=>$hid))->find();
            if($data['mannum']<$_POST['num']){
                $this->error("入住人数超过民宿入住人数上限");
            }
            $orderid=date("YmdHis").rand(1000,9999);
            $id=M('exchangeorder')->add(array(
                'orderid'=>$orderid,
                'hid'=>$hid,
                'uid'=>$uid,
                'num'=>$_POST['num'],
                'money'=>$_POST['exchangemoney'],
                'couponsnum'=>$_POST['couponsnum'],
                'couponstotal'=>$_POST['couponstotal'],
                'expectdate'=>$_POST['expectdate'],
                'expectnum'=>$_POST['expectnum'],
                'inputtime'=>time(),
                'status'=>1
                ));
            if($id){
                //M('House')->where(array('id'=>$hid))->setDec("wait_num",$_POST['num']);
                M('coupons_order')->where(array('id'=>array('in',$couponsidbox)))->setField("status",1);
                for ($i = 0; $i <= $_POST['num']; $i++) {
                    M("exchangeorder_info")->add(array(
                        'orderid'=>$orderid,
                        'realname'=>$_POST['realname'][$i],
                        'idcard'=>$_POST['idcard'][$i],
                        'tel'=>$_POST['tel'][$i],
                        'inputtime'=>time()
                        ));
                }
                session("couponsnum",null);
                session("couponstotal",null);
                session("num",null);
                session("couponsid",null);
                $this->success("您的优惠券兑换申请成功，请保证电话畅通，我们会尽快与您联系",U('Wx/Party/show',array('id'=>$hid)));
            }else{
                $this->error("兑换失败");
            }
        }else{
            $this->error("请求失败");
        }
    }
}
