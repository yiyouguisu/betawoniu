<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class OrderController extends CommonController {
    public function _initialize() {
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $search = I('get.search');
        $where = array();
        $where['close_status']=0;
        $where['cancel_status']=0;
        if (!empty($search)) {
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
                $start_time = strtotime($start_time);
                $where["a.inputtime"] = array("EGT", $start_time);
            }
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["a.inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['a.inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function hostel() {
        $search = I('get.search');
        $where = array();
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        $where['a.ordertype']=1;
        if(!empty($_GET['rid'])){
            $where['c.rid']=$_GET['rid'];
        }
        if (!empty($search)) {
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
                $start_time = strtotime($start_time);
                $where["a.inputtime"] = array("EGT", $start_time);
            }
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["a.inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['a.inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_book_room c on a.orderid=c.orderid")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_book_room c on a.orderid=c.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function party() {
        $search = I('get.search');
        $where = array();
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        $where['a.ordertype']=2;
        if(!empty($_GET['aid'])){
            $where['c.aid']=$_GET['aid'];
        }
        if (!empty($search)) {
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
                $start_time = strtotime($start_time);
                $where["a.inputtime"] = array("EGT", $start_time);
            }
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["a.inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['a.inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_activity_apply c on a.orderid=c.orderid")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_activity_apply c on a.orderid=c.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function bookmember(){
        $where = array();
        if(!empty($_GET['orderid'])){
            $where['orderid']=$_GET['orderid'];
        }
        if($_GET['type']=='party'){
            $count = M('activity_member')->where($where)->count();
        }else if($_GET['type']=='hostel'){
            $count = M('book_member')->where($where)->count();
        }
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_activity_apply c on a.orderid=c.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        if($_GET['type']=='party'){
            $data = M('activity_member')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        }else if($_GET['type']=='hostel'){
            $data = M('book_member')->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function show() {
        $orderid = I('orderid');
        if (empty($orderid)) {
            $this->error("订单号参数错误");
        }
        $data = M("order a")
            ->join("left join zz_order_time b on a.orderid=b.orderid")
            ->where(array('a.orderid'=>$orderid))
            ->find();
        if(!empty($data['error_thumb'])){
            $data['error_thumb']=explode("|",$data['error_thumb']);
        }
        
        $data['productinfo']= M('order_productinfo a')->join("zz_product b on a.pid=b.id")->field("a.*,b.title,b.unit,b.standard")->where(array('a.orderid'=>$orderid))->select();
        $feedback=M('order_feedback')->where(array('orderid'=>$data['orderid']))->find();
        if($feedback){
            $data['isfeedback']=1;
        }else{
            $data['isfeedback']=0;
        }
        $this->assign("data", $data);
        $this->display();
    }
    public function delete() {
        $orderid = $_GET['orderid'];
        if (D("order")->where(array('orderid'=>$orderid))->delete()) {
            M('order_time')->where(array('orderid'=>$orderid))->delete();
            M('order_productinfo')->where(array('orderid'=>$orderid))->delete();
            M('order_distance')->where(array('orderid'=>$orderid))->delete();
            $this->success("删除订单成功！");
        } else {
            $this->error("删除订单失败！");
        }
    }
    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                $orderid=M('order')->where(array('id'=>$id))->getField("orderid");
                M("order")->delete($id);
                M('order_time')->where(array('orderid'=>$orderid))->delete();
                M('order_productinfo')->where(array('orderid'=>$orderid))->delete();
                M('order_distance')->where(array('orderid'=>$orderid))->delete();
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function review(){
        if (IS_POST) {
            $status=I('status');
            $remark=I('review');
            $data=M('order_time')->where('orderid=' . I('orderid'))->find();
            if($data['status']!=1){
                $this->error("不能重复审核！");
            }
            $id=M('order_time')->where('orderid=' . I('orderid'))->save(array(
                'status'=>$status,
                'review_remark'=>$remark,
                'review_status'=>1,
                'review_time'=>time()
            ));
            $orderid=I('orderid');
            $room= M('book_room a')->join("left join zz_room b on a.rid=b.id")->join("left join zz_hostel c on b.hid=c.id")->where(array('a.orderid'=>$orderid))->field("a.*,c.area,c.address")->find();
            if($id>0&&$status==2){
                \Api\Controller\UtilController::addmessage($room['uid'],"申请入住","您预定的房间，已经通过房东审核，请尽快支付。","您预定的房间，已经通过房东审核，请尽快支付。","successbookhouse",$orderid);
                $this->success("审核成功！", U("Admin/Order/waitpay"));
            }elseif($id>0&&$status==5){
                \Api\Controller\UtilController::addmessage($room['uid'],"申请入住","您预定的房间，没有通过房东的审核，请尽快修改订单。","您预定的房间，没有通过房东的审核，请尽快修改订单。","failbookhouse",$orderid);
                $this->success("审核成功！", U("Admin/Order/waitreview"));
            }elseif(!$id){
                $this->error("审核失败！");
            }
        } else {
            $orderid = I('get.orderid');
            $data = M("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where("a.orderid=" . $orderid)->find();
            $this->assign("data", $data);
            $this->display();
        }
    }
    public function today(){
        $search = I('get.search');
        $where = array();
        if(!empty($_SESSION['storeid'])){
            $where['storeid']=$this->storeid;
        }
        $where['close_status']=0;
        $where['cancel_status']=0;
        $end_time=mktime(23,59,59,date("m"),date("d"),date("Y"));
        $start_time=mktime(0,0,0,date("m"),date("d"),date("Y"));
        $where['a.inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
        if (!empty($search)) {
            $isthirdparty = I('get.isthirdparty');
            if ($isthirdparty != "" && $isthirdparty != null) {
                if($isthirdparty==1){
                    $where['a.ordersource']=array('in','3,4');
                }else{
                    $where['a.ordersource']=array('in','1,2');
                }
            }
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $issend = I('get.issend');
            if ($issend != "" && $issend != null) {
                if($issend==1){
                    $where['a.storeid']=array('gt',0);
                }else{
                    $where['a.storeid']=array('eq',0);
                }
            }
            $ordersource = I('get.ordersource');
            if ($ordersource != "" && $ordersource != null) {
                $where["a.ordersource"] = array("EQ", $ordersource);
            }
            $storeid = I('get.storeid');
            if ($storeid != "" && $storeid != null) {
                $where["a.storeid"] = array("EQ", $storeid);
            }
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        foreach($data as $key => $value){
            $data[$key]['productinfo']= M('order_productinfo a')->join("zz_product b on a.pid=b.id")->field("a.*,b.title,b.unit,b.standard")->where(array('a.orderid'=>$value['orderid']))->select();
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);

        $store = M("store")->where(array('status'=>2))->select();
        $this->assign("store", $store);
        $this->assign("storeid", $_SESSION['storeid']);
        $this->display();
    }
    public function waitpay(){
        $search = I('get.search');
        $where = array();
        $where['b.status']=2;
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
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
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function waitreview(){
        $search = I('get.search');
        $where = array();
        $where['b.status']=1;
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
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
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function done(){
        $search = I('get.search');
        $where = array();
        $where['b.status']=4;
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
                $start_time = strtotime($start_time);
                $where["b.donetime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["b.donetime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['b.donetime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }

            
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function closeorder(){
        $search = I('get.search');
        $where = array();
        $where['b.status']=6;
        $where['b.close_status']=1;
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
                $start_time = strtotime($start_time);
                $where["b.close_time"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["b.close_time"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['b.close_time'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function cancelorder() {
        $search = I('get.search');
        $where = array();
        $where['b.close_status']=0;
        $where['b.status']=3;
        $where['b.cancel_status']=1;
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_timgete)) {
                $start_time = strtotime($start_time);
                $where["c.cancel_time"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["c.cancel_time"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['c.cancel_time'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }

            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }

            
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }

        $count = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 12);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function docancel(){
        $orderid=I('orderid');
        $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->find();
        $id=M('order_time')->where(array('orderid'=>$orderid))->save(array(
                    'status'=>3,
                    'cancel_status'=>1,
                    'cancel_time'=>time(),
                    ));
        if($id){
            $c="您好！系统管理员在".date("Y年m月d日 H时i分s秒") ."成功取消了一笔订单。";
            M("message")->add(array(
                'uid'=>0,
                'tuid'=>$order['uid'],
                'title'=>"系统管理员取消订单",
                'description'=>$c,
                'content'=>$c,
                'value'=>$order['orderid'],
                'varname'=>"system",
                'inputtime'=>time()
            ));
            M("message")->add(array(
                'uid'=>0,
                'tuid'=>0,
                'title'=>"系统管理员取消订单成功",
                'value'=>$order['orderid'],
                'varname'=>"order",
                'inputtime'=>time()
            ));
            
            $this->success("操作成功");
        }else{
            $this->error("操作失败");
        }
        
    }
    public function doclose(){
        $orderid=I('orderid');
        $id=M('order_time')->where(array('orderid'=>$orderid))->save(array(
                    'status'=>6,
                    'close_status'=>1,
                    'close_time'=>time(),
                    ));
        if($id){
            $this->success("操作成功");
        }else{
            $this->error("操作失败");
        }
    }
    public function ajax_getneworder(){
        $where=array();
        ///$where['a.inputtime']=array(array('ELT', $lasttime),array('EGT', strtotime("- 7days",$lasttime)));
        if(!empty($_SESSION['storeid'])){
            $where['a.storeid']=$this->storeid;
        }
        $where['b.status']=2;
        $where['b.package_status']=0;
        $where['b.delivery_status']=0;
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        $where['a.puid']=0;
        $where['_string']="(a.paystyle=2 and b.pay_status=0 and ((a.ordertype=2 and a.yes_money_total>=a.total)or a.ordertype!=2)) or (a.paystyle!=2 and b.pay_status=1) or (a.iscontainsweigh=0 and b.pay_status=1) or a.iscontainsweigh=1";
        $order=M('Order a')
            ->join("left join zz_order_time b on a.orderid=b.orderid")
            ->order(array('a.inputtime'=>'desc'))
            ->where($where)
            ->field("a.orderid")
            ->find();
        if(!empty($order)){
            $data['status']=1;
            $data['msg']="有一笔新订单";
            $data['order']=$order;
            //$data['sql']=M('Order a')->_sql();
            $this->ajaxReturn($data,'json');
        }else{
            $data['status']=0;
            $data['msg']="暂无新订单";
            $this->ajaxReturn($data,'json');
        }
    }
    public function newordernotice(){
        $orderid=I('orderid');
        $data=M('Order a')
            ->join("left join zz_order_time b on a.orderid=b.orderid")
            ->where(array('a.orderid'=>$orderid))
            ->find();
        $this->assign("data",$data);
        $uid = $_SESSION["userid"];
        if (!$uid) {
            if (isset($_COOKIE['admin_auto'])) {
                $auto = explode('|', $this->authcode($_COOKIE['admin_auto']));
                $ip = get_client_ip();
                if ($auto[2] == $ip) {
                    $uid = $auto[0];
                }
            }else{
                $this->error('请先登录！', U('Admin/Public/Login')); 
            }

        } 
        $User = D("user")->where(array("id" => $uid))->find();
        $this->assign("User", $User);
        $this->display();
    }
    public function getchildren() {
        $parentid = $_GET['id'];
        $result = M("area")->where(array("parentid" => $parentid,'status'=>1))->select();
        $result = json_encode($result);
        echo $result;
    }
    
}