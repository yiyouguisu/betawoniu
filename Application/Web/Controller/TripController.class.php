<?php

namespace Web\Controller;

use Web\Common\CommonController;

class TripController extends CommonController {
	
    public function userInfo(){
        $this->display();
    }
    public function app_use(){
		$data=M('config')->where(array('varname'=>'tripinfo'))->find();
		$this->assign('data',$data);
		$this->display();
	}
}