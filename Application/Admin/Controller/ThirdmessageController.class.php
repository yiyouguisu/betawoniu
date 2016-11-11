<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class ThirdmessageController extends CommonController {

    public function index() {
    	$uid=I('uid');
    	if(empty($uid)){
    		$this->error("ID不能为空");
    	}
    	$data=M('member')->where(array('id'=>$uid))->find();

    	$fuids=M('thirdmessage_log')->where(array('fromUserId'=>$uid))->getField("toUserId",true);
    	$tuids=M('thirdmessage_log')->where(array('toUserId'=>$uid))->getField("fromUserId",true);
    	$uids=array_merge($fuids,$tuids);
    	$uids=array_unique($uids);

    	$messagelist=array();
    	$messagelist=M('member')->where(array('id'=>array('in',$uids)))->select();

    	foreach ($messagelist as $key => $value) {
    		# code...
    		$message=M('thirdmessage_log a')->where(array('_string'=>"(a.fromUserId=".$uid." and a.toUserId=".$value['id'].") or (a.fromUserId=".$value['id']." and a.toUserId=".$uid.")",'a.objectName'=>array('in','RC:TxtMsg,RC:ImgMsg','a.channelType'=>'PERSON')))->field("a.*")->order(array('a.inputtime'=>'desc'))->find();
    		$contentobj=json_decode($message['content'],true);
    	 	$messagelist[$key]['messagecontent']=$contentobj['content'];
    	 	$messagelist[$key]['messagetime']=$message['timestamp']/1000;
    	 	$messagelist[$key]['objectName']=$message['objectName'];
    	}
    	$this->assign("data",$data);
    	$this->assign("messagelist",$messagelist);
    	
    	$this->display();
    }
    public function log(){
    	$uid=I('uid');
    	$this->assign("uid",$uid);
    	$tuid=I('tuid');
    	$this->assign("tuid",$tuid);
    	$data=M('thirdmessage_log a')->join("left join zz_member b on a.fromUserId=b.id")->join("left join zz_member c on a.toUserId=c.id")->where(array('_string'=>"(a.fromUserId=".$uid." and a.toUserId=".$tuid.") or (a.fromUserId=".$tuid." and a.toUserId=".$uid.")",'a.objectName'=>array('in','RC:TxtMsg,RC:ImgMsg','a.channelType'=>'PERSON')))->field("a.*,b.id as fuid,b.username as fusername,b.nickname as fnickname,b.head as fhead,c.id as tuid,c.username as tusername,c.nickname as tnickname,c.head as thead")->order(array('a.inputtime'=>'desc'))->select();
    	foreach ($data as $key => $value) {
    		# code...
    		$contentobj=json_decode($value['content'],true);
    		$data[$key]['messagecontent']=$contentobj['content'];
    		$data[$key]['messagetime']=$value['timestamp']/1000;
    	}
    	$this->assign("data",$data);
    	$this->display();
    }
}