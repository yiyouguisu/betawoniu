<?php
namespace Wx\Controller;
use Wx\Common\CommonController;

class RecruitController extends CommonController {

    public function index() {
    	$where['status']=1;
        $count = M('recruit')->where($where)->count();
        $page = new \Think\Page($count,6);
        $data = M('recruit')->where($where)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($data as $key => $value) {
        	# code...
        	$house=M('house')->where(array('id'=>$value['hid']))->find();
        	$data[$key]['housename']=$house['title'];
        	$data[$key]['housethumb']=$house['thumb'];
        	$data[$key]['area']=$house['area'];
        	$data[$key]['address']=$house['address'];
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