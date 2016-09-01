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
            $sharenum=M('invite')->where(array('uid'=>$uid))->count();
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
                $where['a.status']=0;
                $where['b.validity_endtime']=array('gt',time());
                $field="a.id,b.hid,b.thumb,b.type,b.title,b.price,b.validity_starttime,b.validity_endtime,a.num,a.`status`,b.`range`";

                $catids=M('coupons')->where(array('status'=>1))->getField("id",true);
                $where['b.id']=array('in',$catids);
                $count = M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->where($where)->count();
                $this->assign("count", $count);
                $page = new \Think\Page($count,6);
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
            }else{
                $where['a.status']=0;
                $where['a.uid']=$uid;
                $count = M('pool a')
                    ->join("left join zz_house b on a.hid=b.id")
                    ->join("left join zz_voteparty c on a.vaid=c.id")
                    ->where($where)->count();
                $this->assign("count", $count);
                $page = new \Think\Page($count,6);
                $data = M('pool a')
                    ->join("left join zz_house b on a.hid=b.id")
                    ->join("left join zz_voteparty c on a.vaid=c.id")
                    ->where($where)->field("a.code,a.hid,c.starttime as validity_starttime,c.endtime as validity_endtime,b.title as house")
                    ->order(array('a.inputtime'=>'asc'))
                    ->limit($page->firstRow . ',' . $page->listRows)->select();
                $show = $page->show();
                $this->assign("data", $data);
                $this->assign("Page", $show);
            }
            $this->assign("type", $type);

            if($_GET['isAjax']==1){
                $this->display("morelist_reward");
            }else{
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
            $where['b.status']=1;
            $where['a.uid']=$uid;
            $count = M('invite a')->join("left join zz_member b on a.tuid=b.id")->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('invite a')->join("left join zz_member b on a.tuid=b.id")->where($where)->order("a.id desc")->limit($page->firstRow . ',' . $page->listRows)->select();
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
            $uid=$_POST["uid"];
            $data=M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->where(array('a.id'=>$coupons_orderid))->field("a.id,b.validity_starttime,b.validity_endtime,a.`status`")->find();
            if($data['status']==1){
                $this->ajaxReturn(array('status'=>-1),'json');
            }
            $nowtime=time();
            if($data['validity_endtime']<$nowtime){
                $this->ajaxReturn(array('status'=>-2),'json');
            }
            $id=M('coupons_order')->save(array(
                'id'=>$coupons_orderid,
                'uid'=>$uid,
                ));
            if($id){
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
        $id=I('id');
        session("nid",$id);
        $data=M('house')->where(array('id'=>$id))->find();
        $share['id']=$data['id'];
        $share['title']=$data['title'];
        $share['content']=$this->str_cut(trim(strip_tags($data['content'])), 100);
        $uid = session('uid');
        if($uid){
            $tuijiancode = M('member')->where(array('id'=>$uid))->getField("tuijiancode");
            $share['link']=C("WEB_URL").U('Wx/News/show',array('nid'=>$id,'invitecode'=>$tuijiancode));
        }else{
            $share['link']=C("WEB_URL").U('Wx/News/show',array('nid'=>$id));
        }

        $share['image']=C("WEB_URL").$data['thumb'];
        $this->assign("share",$share);
        $this->display();
    }
    public function ajax_setphone(){
        if(IS_POST){
            $phone=I('phone');
            $uid=session("uid");
            if(empty($phone)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'手机号码不能为空'),'json');
            }
            if(!isMobile($phone)){
                $this->ajaxReturn(array('code'=>0,'msg'=>'手机号码格式错误'),'json');
            }
            $user=M('member')->where(array('id'=>$uid))->find();
            if($user['phone']==$phone){
                $this->ajaxReturn(array('code'=>1,'msg'=>'提交成功'),'json');
            }else{
                $id=M('member')->where(array('id'=>$uid))->setField("phone",$phone);
                if($id){
                    $this->ajaxReturn(array('code'=>1,'msg'=>'提交成功'),'json');
                }else{
                    $this->ajaxReturn(array('code'=>0,'msg'=>'提交失败'),'json');
                }
            }
            
        }else{
            $this->ajaxReturn(array('code'=>0,'msg'=>'请求非法'),'json');
        }

        
    }
    public function ajax_share(){
        $sharestatus=$_POST['sharestatus'];
        $nid=$_POST['mid'];
        $uid=session("uid");
        $user=M('member')->where(array('id'=>$uid))->find();
        if($sharestatus=='success'){
            $code=\Api\Common\CommonController::genNumberString(8);
            $voteparty=M('voteparty')->order(array('id'=>'desc'))->find();
            $status=M('pool')->where(array('hid'=>$nid,'uid'=>$uid))->find();
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
            
            if(!empty($user['groupid_id'])){
                $code=\Api\Common\CommonController::genNumberString(8);
                $voteparty=M('voteparty')->order(array('id'=>'desc'))->find();
                M('pool')->add(array(
                    'uid'=>$user['groupid_id'],
                    'code'=>$code,
                    'hid'=>$nid,
                    'vaid'=>$voteparty['id'],
                    'status'=>0,
                    'inputtime'=>time()
                    ));
                
            }
        }
    }
}