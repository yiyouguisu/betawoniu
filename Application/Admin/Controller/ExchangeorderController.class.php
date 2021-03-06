<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class ExchangeorderController extends CommonController {
    public function _initialize() {
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    /*
     * 订单列表
     */
    public function index() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
                $start_time = strtotime($start_time);
                $where["inputtime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("exchangeorder")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("exchangeorder")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach($data as $key => $value){
            $data[$key]['house']=M('house')->where(array('id'=>$value['hid']))->getField("title");
            $data[$key]['productinfo']= M('exchangeorder_info')->where(array('orderid'=>$value['orderid']))->select();
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    /**
     *  删除
     */
    public function delete() {
        $orderid = $_GET['orderid'];
        if (D("exchangeorder")->where(array('orderid'=>$orderid))->delete()) {
            $this->success("删除订单成功！");
        } else {
            $this->error("删除订单失败！");
        }
    }

    /*
     * 删除内容
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                $orderid=M('exchangeorder')->where(array('id'=>$id))->getField("orderid");
                M("exchangeorder")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}