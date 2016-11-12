<?php

namespace Web\Controller;

use Web\Common\CommonController;

class AboutController extends CommonController {
	public function index(){
		$data=M('page')->where(array('catid'=>8))->find();
    	$this->assign('data',$data);
        $this->display();
	}
	public function about(){
		$data=M('page')->where(array('catid'=>8))->find();
    	$this->assign('data',$data);
        $this->display();
	}
    public function explain(){
        $data=M('config')->where(array('varname'=>'instruction'))->find();
        $this->assign('data',$data);
        $this->display();
    }
	// 使用说明
	public function instruction(){
		$data=M('config')->where(array('varname'=>'instruction'))->find();
		$this->assign('data',$data);
		$this->display();
	}
	// 问答
	public function help(){
        $data=M("question")->where(array('status'=>1))->order(array('id'=>"desc"))->field('id,title,content,inputtime')->select();
        $this->assign('data',$data);
		$this->display();
	}
	public function feedback(){
		$uid=session('uid');
        if (IS_POST) {
            if (D("feedback")->create()) {
                D("feedback")->inputtime = time();
                D("feedback")->uid =$uid;
                $id = D("feedback")->add();
                if (!empty($id)) {
                    $this->success("留言成功",U('Web/Member/index'));
                } else {
                    $this->error("留言失败");
                }
            } else {
                $this->error(D("feedback")->getError());
            }
        }
        $this->display();
    }
	
}