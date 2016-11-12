<?php

namespace Web\Controller;

use Web\Common\CommonController;

class MyController extends CommonController {

	public function index() {
		$uid=47;
        $data=M('member')->where(array('id'=>$uid))->find();
        $this->assign('data',$data);

        $this->display();
    }
    public function userInfo(){

    }
    public function couponInfo(){
        $uid=47;
        $data=M('member a')
        ->join('left join zz_coupons_order b on a.id=b.uid')
        ->join('left join zz_coupons c on c.id=b.catid')->where(array('a.id'=>$uid))->select();
        // echo M('member a')->getlastsql();
        // print_r($data);
        // die;
        $this->assign('data',$data);
        $this->display();
    }
    public function orderlist(){
        $uid=89;
        $actorder=M('order a')
        ->join('left join zz_activity_apply b on a.orderid=b.orderid')
        ->join('left join zz_activity d on d.id=b.aid')
        ->join('left join zz_member c on c.id=b.uid')
        ->where(array('c.id'=>$uid,'a.ordertype'=>2))
        ->select();
        // foreach ($actorder as $key => $value) {
        //     print_r($value['title']);
        // }
        // echo M('order a')->getlastsql();
        // die;

        $this->assign('data',$actorder);
        $this->display();
    }
    public function mynote(){
        $uid=89;
        $data=M('note a')
        ->join('left join zz_member b on b.id=a.uid')
        ->where(array('b.id'=>$uid))
        ->select();

        $this->assign('data',$data);
        $this->display();
    }

}
