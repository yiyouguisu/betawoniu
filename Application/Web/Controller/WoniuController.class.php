<?php

namespace Web\Controller;

use Web\Common\CommonController;

class WoniuController extends CommonController {

    public function _initialize(){
    	parent::_initialize();
        Vendor("pingpp.init");
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=D("Config")->order(array('id'=>'desc'))->select();
            F("web_config",$ConfigData);
        }
        $this->ConfigData=$ConfigData;
    }
	
    public function index(){
        if (!session('uid')) {
            $this->redirect('Web/Member/login');
        } else {
            $uid=session("uid");
            $uids=M('attention')->where(array('fuid'=>$uid))->getField("tuid",true);
            $count=M('attention a')->join("left join zz_member b on a.fuid=b.id")->where(array('a.tuid'=>$uid,'a.fuid'=>array('in',$uids)))->count();
            $data=M('attention a')
                ->join("left join zz_member b on a.fuid=b.id")
                ->where(array('a.tuid'=>$uid,'a.fuid'=>array('in',$uids)))
                ->field('b.id as uid,b.nickname,b.head,b.info,b.area,b.rongyun_token')
                ->select();
            foreach ($data as $key => $value) {
                # code...
                $data[$key]['fansnum']=M('attention')->where('tuid=' . $value['uid'])->count();
                $data[$key]['attentionnum']=M('attention')->where('fuid=' . $value['uid'])->count();
            }
            $data=!empty($data)?$data:null;
            $this->assign("data",$data);
            $this->assign("totalnum",$count);
            $this->display();
        }
    	
    }
    
    public function message(){
        $uid=session("uid");
        $count = M("message")->where(array('r_id'=>$uid,'isdel'=>'0'))->count();
        $data=M("message")->where(array('r_id'=>$uid,'isdel'=>'0'))->order(array('id'=>"desc"))->field("id,title,content,status,varname,value,inputtime")->select();
        if(IS_AJAX){
            $id=$_POST['id'];
            $res=M('message')->where(array('id'=>$id))->save(array('status'=>1));
            if($res){
                $this->ajaxReturn(array('code'=>200),'json');
            }
            else{
                $this->ajaxReturn(array('code'=>500),'json');
            }
        }
        $this->assign('data',$data);
        $this->display();
    }
    public function chat(){
        if (!session('uid')) {
            $this->redirect('Home/Member/login');
        } else {
            $this->display();
        }
    }

    public function get_user_info(){
        $uids=I('post.uids');
        // 组合where数组条件
        $map=array(
            'id'=>array('in',$uids)
            );
        $data=M('member')
            ->field('id,nickname,head,rongyun_token')
            ->where($map)
            ->select();
        foreach ($data as $key => $value) {
            # code...
            $data[$key]['showurl']=U('Home/Member/detail',array('uid'=>$value['id']));
        }
        $this->ajaxReturn($data,'json');
    }

    public function chatdetail(){
        if (!session('uid')) {
            $this->redirect('Home/Member/login');
        } else {
            $tuid=I('tuid');
            $user_data=M('Member')->field('id,nickname,head,rongyun_token')->find($tuid);
            $data=array(
                'id'=>$user_data['id'], // 用户id
                'head'=>$user_data['head'],// 头像
                'nickname'=>$user_data['nickname'],// 用户名
                'rong_key'=>"cpj2xarljz3ln",// 融云key
                'rong_token'=>$user_data['rongyun_token']//获取融云token
                );
            $this->assign('data',$data);
            $this->display();
        }
    }
}