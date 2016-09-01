<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class CouponsgivenController extends CommonController {
    public function _initialize(){
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["a.inputtime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["a.inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['a.inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
        }
    
        $count = D("coupons_givenlog a")->join("left join zz_coupons b on a.catid=b.id")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("coupons_givenlog a")->join("left join zz_coupons b on a.catid=b.id")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->field("a.*,b.title,b.validity_starttime,b.validity_endtime")->select();
        foreach ($data as $key => $value) {
            # code...
            $data[$key]['house']=M('house a')->join("left join zz_coupons_order b on a.id=b.hid")->where(array('b.id'=>$value['couponsid']))->getField("a.title");
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function delete() {
        $id = $_GET['id'];
        if (D("coupons_givenlog")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function del(){
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("coupons_givenlog")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function review(){
        if (IS_POST) {
            $status=I('status');
            $data=M('coupons_givenlog')->where('id=' . I('id'))->find();
            if($data['status']!=1){
                $this->error("不能重复审核！");
            }
            $id=M('coupons_givenlog')->where('id=' . I('id'))->save(array(
                'status'=>$status,
                'verify_time' => time(),
                'verify_user' => $_SESSION['user'],
                'remark'=>I('remark')
            ));
            if($id>0&&$status==2){
                M('member')->where(array('id'=>$data['uid']))->save(array('realname'=>$data['realname'],'idcard'=>$data['idcard'],'realname_status'=>1));
                $this->success("审核成功！");
            }elseif($id>0&&$status==3){
                $this->success("审核成功！");
            }elseif(!$id){
                $this->error("审核失败！");
            }
        } else {
            $id=I('id');
            $data=M('coupons_givenlog')->where(array('id'=>$id))->find();
            $this->assign("data",$data);
            $this->display();
        }
    }
}