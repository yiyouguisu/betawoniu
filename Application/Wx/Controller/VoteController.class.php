<?php

namespace Wx\Controller;

use Wx\Common\CommonController;

class VoteController extends CommonController {

	public function index() {
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $where['status']=2;
            $where['isdel']=0;
            $count = M('voteparty')->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('voteparty')->where($where)->order(array("listorder"=>'desc','id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $this->display("morelist_index");
            }else{
                $this->display();
            }
        }
    }
    public function show() {
        $vaid=I('id');
        $voteparty=M('voteparty')->where(array('id'=>$vaid))->find();
        $data=M('coupons_order a')->join("left join zz_member b on a.uid=b.id")->where(array('a.vaid'=>$vaid))->field("a.*,b.head,b.nickname")->order(array('a.id'=>'desc'))->select();
        foreach ($data as $key => $value) {
            # code...
            $house=M('house')->where(array('id'=>$voteparty['hid']))->find();
            $data[$key]['house']=$house;
        }
        $this->assign("data",$data);
        $house=M('house')->where(array('id'=>$data['hid']))->find();
        $this->assign("house", $house);
        $this->display();

    }
    public function turntable(){
        $gift= M('gift')->where(array('rank'=>array('neq',6)))->field('id,rank,prize')->order(array('id'=>asc))->select();
        $this->assign("gift",$gift);

        $turntablerule=M('config')->where(array('varname'=>'turntablerule'))->getField("value");
        $this->assign("turntablerule", $turntablerule);
        $this->display();
    }
    public function turntablelog(){
        $where['rid']=array('neq',6);
        $count = D("Choujianglog")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $data = D("Choujianglog")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["prize"] = M('gift')->where('rank=' . $r['rid'])->getField("prize");
            $data[$k]['validity_starttime']=M('Coupons')->where('id=' . $r['rid'])->getField("validity_starttime");
            $data[$k]['validity_endtime']=M('Coupons')->where('id=' . $r['rid'])->getField("validity_endtime");
        }
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