<?php

namespace Web\Controller;

use Web\Common\CommonController;

class ReviewController extends CommonController {
	public function _initialize() {
        parent::_initialize();
        $this->cart_total_num();
    }
	//首页
	public function index(){
		if (!session('uid')) {
            $returnurl=urlencode($_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
            $this->error('请先登录！',U('Web/Member/login')."?returnurl=".$returnurl);
        } else {
            $uid=session('uid');
            $type=I('get.type');
            $id=I('get.id');
            $this->assign('id',$id);
            $this->assign('type',$type);
            $this->display();
		}		
	}
    public function send(){
        $data['uid']=session('uid');
        $data['content']=$_POST['content'];
        $data['inputtime']=time();
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
            default:
                # code...
                break;
        }
        $data['value']=$_POST['id'];
        $id=M('review')->add($data);
        if(!empty($id)){
            $returnd=array('code'=>200,'msg'=>"评论成功");
        }
        else{
            $returnd=array('code'=>500,'msg'=>"添加评论失败");
        }
        $this->ajaxReturn($returnd,'json');
    }

}