<?php

namespace Web\Controller;

use Web\Common\CommonController;

class OtherController extends CommonController {
	// 关于我们
	public function about(){
		$data=M('config')->select();
		$array=array();
		foreach ($data as $key => $value) {
			if($value['groupid']==6 && $value['info']=='关于我们'){
				$array['title']=$value['info'];
				$array['value']=$value['value'];
			}
		}
		$this->assign('data',$array);
		$this->display();
	}
	// 关于我们
	public function aboutWeb(){
		$data=M('config')->select();
		$array=array();
		foreach ($data as $key => $value) {
			if($value['groupid']==6 && $value['info']=='关于我们'){
				$array['title']=$value['info'];
				$array['value']=$value['value'];
			}
		}
		$this->assign('data',$array);
		$this->display();
	}
	// 软件信息
	public function info(){
		$data=M('config')->select();
		$array=array();
		foreach ($data as $key => $value) {
			if($value['groupid']==6 && $value['info']=='关于我们'){
				$array['title']=$value['info'];
				$array['value']=$value['value'];
			}
		}
		$this->assign('data',$array);
		$this->display();
	}
	// 使用说明
	public function explain(){
		$data=M('config')->select();
		$array=array();
		foreach ($data as $key => $value) {
			if($value['groupid']==6 && $value['info']=='使用说明'){
				$array['title']=$value['info'];
				$array['value']=$value['value'];
			}
		}
		$this->assign('data',$array);
		$this->display();
	}	
	// 使用说明
	public function explainWeb(){
		$data=M('config')->select();
		$array=array();
		foreach ($data as $key => $value) {
			if($value['groupid']==6 && $value['info']=='使用说明'){
				$array['title']=$value['info'];
				$array['value']=$value['value'];
			}
		}
		$this->assign('data',$array);
		$this->display();
	}
	// 问答
	public function qna(){
		$this->display();
	}
	public function tripUes(){
		$data=M('config')->select();
		$array=array();
		foreach ($data as $key => $value) {
			if($value['groupid']==6 && $value['info']=='行程使用说明'){
				$array['title']=$value['info'];
				$array['value']=$value['value'];
			}
		}
		$this->assign('data',$array);
		$this->display();
	}
}