<?php
namespace Web\Controller;
use Web\Common\CommonController;
class AjaxapiController extends CommonController {
	
	public function collection(){
		$uid=$this->getuid();
		if($uid){
			$data['uid']=$uid;
			$data['inputtime']=time();
			$data['value']=$_POST['id'];
			$count=M('collect')->where(array('value'=>$_POST['id'],'uid'=>$uid))->count();
			if($count>0){
				M('collect')->where(array('value'=>$_POST['id'],'uid'=>$uid))->delete();
				$rel=array('code'=>300,'msg'=>'已经收藏了');
			}
			else{
				switch ($_POST['type']) {
					case 0:
						$data['varname']='note';
						$this->ncolle($data['value']);
						break;
					case 1:
						$data['varname']='party';
						$this->pcolle($data['value']);
						break;
					case 2:
						$data['varname']='hostel';
						$this->hcolle($data['value']);
						break;
					case 3:
						$data['varname']='room';
						$this->rcolle($data['value']);
						break;
				}
				M('collect')->add($data);
				$rel=array('code'=>200,'msg'=>'收藏成功');
			}
			
		}
		else{
			$rel=array('code'=>500,'msg'=>'收藏失败,请登入');
		}
		$this->ajaxReturn($rel,'json');
	}
	function ncolle($nid){
		$note=M('note')->where(array('id'=>$nid))->find();
		\Api\Controller\UtilController::addmessage($note['uid'],"游记收藏","您的游记(".$note['title'].")被其他用户收藏了","您的游记(".$note['title'].")被其他用户收藏了","notecollect",$note['id']);
	}
	function pcolle($aid){
		$party=M('activity')->where('id=' . $aid)->find();
		\Api\Controller\UtilController::addmessage($party['uid'],"活动收藏","您的活动(".$party['title'].")被其他用户收藏了","您的活动(".$party['title'].")被其他用户收藏了","partycollect",$party['id']);
	}
	function hcolle($hid){
		$hostel=M('hostel')->where('id=' . $hid)->find();
       	\Api\Controller\UtilController::addmessage($hostel['uid'],"美宿收藏","您的美宿(".$hostel['title'].")被其他用户收藏了","您的美宿(".$hostel['title'].")被其他用户收藏了","hostelcollect",$hostel['id']);
	}
	function rcolle($rid){
		$Room=M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.uid")->find();
		\Api\Controller\UtilController::addmessage($Room['uid'],"房间收藏","您的房间(".$Room['title'].")被其他用户收藏了","您的房间(".$Room['title'].")被其他用户收藏了","roomcollect",$Room['id']);
	}
	// 点赞
	public function hit(){
		$uid=$this->getuid();
		if($uid){
			switch ($_POST['type']) {
				case 0:
					$data['varname']='note';
					break;
				case 1:
					$data['varname']='party';
					break;
				case 2:
					$data['varname']='hostel';
					break;
				case 3:
					$data['varname']='voteparty';
					break;
				case 4:
					$data['varname']='room';
					break;
			}
			$data['uid']=$uid;
			$data['inputtime']=time();
			$data['value']=$_POST['id'];
			$count=M('hit')->where(array('value'=>$_POST['id'],'uid'=>$uid))->count();
			if($count>0){
				M('hit')->where(array('value'=>$_POST['id'],'uid'=>$uid))->delete();
				if($_POST['type']==0){
					M('note')->where(array('id'=>$_POST['id']))->setDec('hit');
				}
				elseif($_POST['type']==1){
					M('activity')->where(array('id'=>$_POST['id']))->setDec('hit');
				}				
				elseif($_POST['type']==2){
					M('hostel')->where(array('id'=>$_POST['id']))->setDec('hit');
				}
				elseif($_POST['type']==4){
					M('room')->where(array('id'=>$_POST['id']))->setDec('hit');
				}
				
				$rel=array('code'=>300,'msg'=>'已经赞过了');
			}
			else{
				M('hit')->add($data);
				if($_POST['type']==0){
					$this->nhit($data['value']);
					M('note')->where(array('id'=>$_POST['id']))->setInc('hit');
				}
				elseif($_POST['type']==1){
					$this->phit($data['value']);
					M('activity')->where(array('id'=>$_POST['id']))->setInc('hit');
				}				
				elseif($_POST['type']==2){
					$this->hhit($data['value']);
					M('hostel')->where(array('id'=>$_POST['id']))->setInc('hit');
				}
				elseif($_POST['type']==4){
					$this->rhit($data['value']);
					M('room')->where(array('id'=>$_POST['id']))->setInc('hit');
				}
				$rel=array('code'=>200,'msg'=>'点赞成功');
			}
		}
		else{
			$rel=array('code'=>500,'msg'=>'点赞失败,请登入');
		}
		$this->ajaxReturn($rel,'json');
	}
	function nhit($nid){
		$note=M('note')->where('id=' . $nid)->find();
		\Api\Controller\UtilController::addmessage($note['uid'],"游记点赞","您的游记(".$note['title'].")获得1个赞","您的游记(".$note['title'].")获得1个赞","notehit",$note['id']);
	}
	function phit($aid){
		$party=M('activity')->where('id=' . $aid)->find();
		\Api\Controller\UtilController::addmessage($party['uid'],"活动点赞","您的活动(".$party['title'].")获得1个赞","您的活动(".$party['title'].")获得1个赞","partyhit",$party['id']);
	}
	function hhit($hid){
		$hostel=M('hostel')->where('id=' . $hid)->find();
		\Api\Controller\UtilController::addmessage($hostel['uid'],"美宿点赞","您的美宿(".$hostel['title'].")获得1个赞","您的美宿(".$hostel['title'].")获得1个赞","hostelhit",$hostel['id']);
	}
	function rhit($rid){
		$Room=M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.uid")->find();
		\Api\Controller\UtilController::addmessage($Room['uid'],"房间点赞","您的房间(".$Room['title'].")获得1个赞","您的房间(".$Room['title'].")获得1个赞","roomhit",$Room['id']);
	}


	public function getuid(){
		if(!session('uid')){
			return false;
		}
		else{
			return session('uid');
		}
	}
}