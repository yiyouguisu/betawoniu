<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class PackageController extends CommonController {
    public function _initialize() {
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
        $this->storeid=!empty($_SESSION['storeid'])? $_SESSION['storeid'] : 0;
    }
    public function index() {
        $search = I('get.search');
        $where = array();
        $where['a.puid']=$this->userid;
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        //$where['a.storeid']=$this->storeid;
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
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $ordersource= I('get.ordersource');
            if ($ordersource != "" && $ordersource != null) {
                $where["a.ordersource"] = array("EQ", $ordersource);
            }
            $ordertype= I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                $where["a.ordertype"] = array("EQ", $ordertype);
            }
            $paytype = I('get.paytype');
            if ($paytype != "" && $paytype != null) {
                if($paytype!=3){
                    $where['a.paystyle']=1;
                    $where["a.paytype"] = array("EQ", $paytype);
                }else{
                    $where['a.paystyle']=2;
                }
            }
            //状态
            $package_status = $_GET["package_status"];
            if ($package_status != "" && $package_status != null) {
                $where["b.package_status"] = array("EQ", $package_status);
            }
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }
        //$where['b.pay_status']=1;
        $count = M("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = M("order a")
            ->join("left join zz_order_time b on a.orderid=b.orderid")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order(array("b.package_status" => "asc",'a.id'=>'desc'))
            ->select();
            //M("order a")->_sql();die;
        foreach($data as $key => $value){
            $data[$key]['productinfo']= M('order_productinfo a')
                                        ->join("left join zz_product b on a.pid=b.id")
                                        ->join("left join zz_storehouse c on b.storehouse=c.id")
                                        ->field("a.*,b.title,b.unit,c.title as storehouse,b.standard")
                                        ->where(array('a.orderid'=>$value['orderid']))->select();
                                        //echo M('order_productinfo a')->_sql();
        }
        //die;
        //dump($data);die;
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function waitpackage() {
        $search = I('get.search');
        $where = array();
        $where['a.puid']=$this->userid;
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        $where["b.package_status"]=0;
        //$where['a.storeid']=$this->storeid;
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
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $ordersource= I('get.ordersource');
            if ($ordersource != "" && $ordersource != null) {
                $where["a.ordersource"] = array("EQ", $ordersource);
            }
            $ordertype= I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                $where["a.ordertype"] = array("EQ", $ordertype);
            }
            $paytype = I('get.paytype');
            if ($paytype != "" && $paytype != null) {
                if($paytype!=3){
                    $where['a.paystyle']=1;
                    $where["a.paytype"] = array("EQ", $paytype);
                }else{
                    $where['a.paystyle']=2;
                }
            }
            //状态
            $package_status = $_GET["package_status"];
            if ($package_status != "" && $package_status != null) {
                $where["b.package_status"] = array("EQ", $package_status);
            }
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }
        //$where['b.pay_status']=1;
        $count = M("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = M("order a")
            ->join("left join zz_order_time b on a.orderid=b.orderid")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order(array("b.package_status" => "asc",'a.id'=>'desc'))
            ->select();
            //M("order a")->_sql();die;
        foreach($data as $key => $value){
            $data[$key]['productinfo']= M('order_productinfo a')
                                        ->join("left join zz_product b on a.pid=b.id")
                                        ->join("left join zz_storehouse c on b.storehouse=c.id")
                                        ->field("a.*,b.title,b.unit,c.title as storehouse,b.standard")
                                        ->where(array('a.orderid'=>$value['orderid']))->select();
                                        //echo M('order_productinfo a')->_sql();
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function packaging() {
        $search = I('get.search');
        $where = array();
        $where['a.puid']=$this->userid;
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        $where["b.package_status"]=1;
        //$where['a.storeid']=$this->storeid;
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
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $ordersource= I('get.ordersource');
            if ($ordersource != "" && $ordersource != null) {
                $where["a.ordersource"] = array("EQ", $ordersource);
            }
            $ordertype= I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                $where["a.ordertype"] = array("EQ", $ordertype);
            }
            $paytype = I('get.paytype');
            if ($paytype != "" && $paytype != null) {
                if($paytype!=3){
                    $where['a.paystyle']=1;
                    $where["a.paytype"] = array("EQ", $paytype);
                }else{
                    $where['a.paystyle']=2;
                }
            }
            //状态
            $package_status = $_GET["package_status"];
            if ($package_status != "" && $package_status != null) {
                $where["b.package_status"] = array("EQ", $package_status);
            }
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }
        //$where['b.pay_status']=1;
        $count = M("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = M("order a")
            ->join("left join zz_order_time b on a.orderid=b.orderid")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order(array("b.package_status" => "asc",'a.id'=>'desc'))
            ->select();
           //echo  M("order a")->_sql();die;
        foreach($data as $key => $value){
            $data[$key]['productinfo']= M('order_productinfo a')
                                        ->join("left join zz_product b on a.pid=b.id")
                                        ->join("left join zz_storehouse c on b.storehouse=c.id")
                                        ->field("a.*,b.title,b.unit,c.title as storehouse,b.standard")
                                        ->where(array('a.orderid'=>$value['orderid']))->select();
                                        //echo M('order_productinfo a')->_sql();
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function packagdone() {
        $search = I('get.search');
        $where = array();
        $where['a.puid']=$this->userid;
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        $where["b.package_status"]=2;
        //$where['a.storeid']=$this->storeid;
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
            $ordertype = I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                if($ordertype==4){
                    $where['a.iscontainsweigh']=1;
                    $where['a.ordertype']=1;
                }else{
                    $where['a.ordertype']=$ordertype;
                }
            }
            $ordersource= I('get.ordersource');
            if ($ordersource != "" && $ordersource != null) {
                $where["a.ordersource"] = array("EQ", $ordersource);
            }
            $ordertype= I('get.ordertype');
            if ($ordertype != "" && $ordertype != null) {
                $where["a.ordertype"] = array("EQ", $ordertype);
            }
            $paytype = I('get.paytype');
            if ($paytype != "" && $paytype != null) {
                if($paytype!=3){
                    $where['a.paystyle']=1;
                    $where["a.paytype"] = array("EQ", $paytype);
                }else{
                    $where['a.paystyle']=2;
                }
            }
            //状态
            $package_status = $_GET["package_status"];
            if ($package_status != "" && $package_status != null) {
                $where["b.package_status"] = array("EQ", $package_status);
            }
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                $where["a.orderid"] = array("LIKE", "%{$keyword}%");
            }
        }
        //$where['b.pay_status']=1;
        $count = M("order a")->join("left join zz_order_time b on a.orderid=b.orderid")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = M("order a")
            ->join("left join zz_order_time b on a.orderid=b.orderid")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order(array("b.package_status" => "asc",'a.id'=>'desc'))
            ->select();
            //M("order a")->_sql();die;
        foreach($data as $key => $value){
            $data[$key]['productinfo']= M('order_productinfo a')
                                        ->join("left join zz_product b on a.pid=b.id")
                                        ->join("left join zz_storehouse c on b.storehouse=c.id")
                                        ->field("a.*,b.title,b.unit,c.title as storehouse,b.standard")
                                        ->where(array('a.orderid'=>$value['orderid']))->select();
                                        //echo M('order_productinfo a')->_sql();
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    /**
     *  包装产品
     */
    public function package() {
        $orderid = $_GET['orderid'];
        $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->find();
        switch ($order['ordertype']) {
            case '1':
                # code...
                if($order['iscontainsweigh']==0){
                    if($order['pay_status']==0&&$order['paystyle']!=2){
                        $this->error("该订单尚未支付完成！");
                    }
                }
                break;
            case '2':
                # code...
                if($order['pay_status']==0&&$order['paystyle']!=2){
                    $this->error("该订单尚未支付完成！");
                }
                break;
        }
        $did=M("order_time")->where(array('orderid'=>$orderid))->save(array(
            'package_status'=>1,
            'package_time'=>time()
            ));
        if ($did) {
            M("message")->add(array(
                    'uid'=>0,
                    'tuid'=>0,
                    'title'=>"订单开始包装",
                    'value'=>$orderid,
                    'varname'=>"order",
                    'inputtime'=>time()
                ));
            $this->success("操作成功！");
        } else {
            $this->error("操作失败！");
        }
    }
    /**
     *  包装完成产品
     */
    public function packagedone() {
        $orderid = $_GET['orderid'];
        $status=M('order_productinfo')->where(array('orderid'=>$orderid,'product_type'=>4,'isweigh'=>0))->count();
        if($status!=0){
            $this->error("该订单中称重商品尚未填写称重信息！");
        }
        $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->find();
        if($order['pay_status']==0&&$order['paystyle']!=2){
            $this->error("该订单尚未支付完成！");
        }
        $did=M("order_time")->where(array('orderid'=>$orderid))->save(array(
                    'package_status'=>2,
                    'package_donetime'=>time()
                    ));
        if ($did) {
            M("message")->add(array(
                    'uid'=>0,
                    'tuid'=>0,
                    'title'=>"订单包装完成",
                    'value'=>$orderid,
                    'varname'=>"order",
                    'inputtime'=>time()
                ));
            $this->success("操作成功！");
        } else {
            $this->error("操作失败！");
        }
    }
    /*
     * 操作判断
     */

    public function action() {
        $submit = trim($_POST["submit"]);
        if ($submit == "packages") {
            $this->packages();
        } elseif ($submit == "packagedones") {
            $this->packagedones();
        }
    }
    /*
     * 批量包装
     */

    public function packages() {
        if (IS_POST) {
            if (empty($_POST['orderids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['orderids'] as $id) {
                $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$id))->find();
                switch ($order['ordertype']) {
                    case '1':
                        # code...
                        if($order['iscontainsweigh']==0){
                            if(($order['pay_status']==1&&$order['paystyle']!=2)||($order['pay_status']==0&&$order['paystyle']==2)){
                                M("order_time")->where(array('orderid'=>$id))->save(array(
                                    'package_status'=>1,
                                    'package_time'=>time()
                                    ));
                            }
                        }else{
                            M("order_time")->where(array('orderid'=>$id))->save(array(
                                'package_status'=>1,
                                'package_time'=>time()
                                ));
                        }
                        break;
                    case '2':
                        # code...
                        if(($order['pay_status']==1&&$order['paystyle']!=2)||($order['pay_status']==0&&$order['paystyle']==2)){
                            M("order_time")->where(array('orderid'=>$id))->save(array(
                                'package_status'=>1,
                                'package_time'=>time()
                                ));
                        }
                        break;
                    case '3';
                        M("order_time")->where(array('orderid'=>$id))->save(array(
                            'package_status'=>1,
                            'package_time'=>time()
                            ));
                        break;
                }
                M("message")->add(array(
                    'uid'=>0,
                    'tuid'=>0,
                    'title'=>"订单开始包装",
                    'value'=>$id,
                    'varname'=>"order",
                    'inputtime'=>time()
                ));
                
            }
            $this->success("操作成功！");
        } else {
            $this->error("操作失败！");
        }
    }
    /*
     * 批量包装完成
     */

    public function packagedones() {
        if (IS_POST) {
            if (empty($_POST['orderids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['orderids'] as $id) {
                $status=M('order_productinfo')->where(array('orderid'=>$id,'product_type'=>4,'isweigh'=>0))->count();
                $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$id))->find();
                if($status==0){
                    if(($order['pay_status']==1&&$order['paystyle']!=2)||($order['pay_status']==0&&$order['paystyle']==2)){
                        M("order_time")->where(array('orderid'=>$id))->save(array(
                            'package_status'=>2,
                            'package_donetime'=>time()
                            ));
                    }
                    
                }
                M("message")->add(array(
                    'uid'=>0,
                    'tuid'=>0,
                    'title'=>"订单包装完成",
                    'value'=>$id,
                    'varname'=>"order",
                    'inputtime'=>time()
                ));
            }
            $this->success("操作成功！");
        } else {
            $this->error("操作失败！");
        }
    }

    
    public function weigh() {
        if (IS_POST) {
            $id = $_POST['id'];
            $data=M("order_productinfo")->where(array('id'=>$id))->find();
            $package_status=M('order_time')->where(array('orderid'=>$data['orderid']))->getField("package_status");
            if($package_status==0){
                $this->error("该订单尚未包装，不能称重！");
            }
            $did=M("order_productinfo")->where(array('id'=>$id))->save(array(
                        'weigh'=>$_POST['weigh'],
                        'isweigh'=>1,
                        'weightime'=>time()
                        ));
            if ($did) {
                $order=M('order')->where(array('orderid'=>$data['orderid']))->find();
                if($order['isserviceorder']==0){
                    $total=0.00;
                    $weighnum=0;
                    $weighdonenum=0;
                    $productinfo=M('order_productinfo')->where(array('orderid'=>$data['orderid']))->select();
                    foreach ($productinfo as $key => $value) {
                        # code...
                        $product=M('product')->where(array('id'=>$value['pid']))->find();
                        if($product['type']==4){
                            $weighnum++;
                            if($value['isweigh']==1){
                                $weighdonenum++;
                                $total+=$value['weigh']*$product['price'];
                            }else{
                                $total+=$value['nums']*$product['nowprice'];
                            }
                            
                        }elseif($product['type']==3){
                            $total=$product['nums']*$product['advanceprice'];
                        }else{
                            $total+=$value['nums']*$product['nowprice']; 
                        }
                    }
                    
                    $money=$total-$order['discount']-$order['wallet'];
                    M('order')->where(array('orderid'=>$data['orderid']))->save(array(
                        'total'=>$total,
                        'money'=>$money
                        ));
                    $paystyle=M('order')->where(array('orderid'=>$data['orderid']))->getField("paystyle");
                    if($weighnum==$weighdonenum&&$paystyle==1&&$weighnum!=0){
                        $phone=M('order a')->join("left join zz_member b on a.uid=b.id")->where(array('a.orderid'=>$data['orderid']))->getField("b.phone");
                        $smsdata=json_encode(array('phone'=>$phone,'datas'=>array($data['orderid'],$money),'templateid'=>"74018"));
                        $CCPRest = A("Api/CCPRest");
                        $CCPRest->sendsmsapi($smsdata);

                        $message_type='weighorderpaynotice';
                        $push['title']="称重订单付款通知";
                        $push['description']="[蔬果先生]尊敬的客户,你的订单(".$data['orderid'].")已经完成称重，称重后订单实际应付金额为【".$money."】元,请您尽快完成支付，我们将在订单付款完成后开始为您配送。";
                        $push['content']="[蔬果先生]尊敬的客户,你的订单(".$data['orderid'].")已经完成称重，称重后订单实际应付金额为【".$money."】元,请您尽快完成支付，我们将在订单付款完成后开始为您配送。";
                        $push['isadmin']=1;
                        $push['inputtime']=time();
                        $push['username']=M('user')->where(array('role'=>1,'group_id'=>2))->getField("username");
                        $mid = M("Push")->add($push);
                        if ($mid) {
                            $registration_id=M('order a')->join("left join zz_member b on a.uid=b.id")->where(array('a.orderid'=>$data['orderid']))->getField("b.deviceToken");
                            $extras = array("orderid"=>$data['orderid'],'message_type'=>$message_type);
                            if(!empty($registration_id)){
                                PushQueue($mid,$message_type,$registration_id, $push['title'],$push['description'], serialize($extras),1);
                            }
                        }
                        M("message")->add(array(
                            'uid'=>0,
                            'tuid'=>0,
                            'title'=>"订单称重完成",
                            'value'=>$data['orderid'],
                            'varname'=>"order",
                            'inputtime'=>time()
                        ));
                    }elseif($weighnum==$weighdonenum&&$paystyle==2&&$weighnum!=0){
                        $phone=M('order a')->join("left join zz_member b on a.uid=b.id")->where(array('a.orderid'=>$data['orderid']))->getField("b.phone");
                        $smsdata=json_encode(array('phone'=>$phone,'datas'=>array($data['orderid'],$money),'templateid'=>"74019"));
                        $CCPRest = A("Api/CCPRest");
                        $CCPRest->sendsmsapi($smsdata);

                        $message_type='weighorderpaynotice';
                        $push['title']="称重订单付款通知";
                        $push['description']="【蔬果先生】尊敬的客户,你的订单(".$data['orderid'].")已经完成称重, 称重后订单实际应付金额为【".$money."】元,您选择的是货到付款,请按称重后的订单金额支付,谢谢您的配合!";
                        $push['content']="【蔬果先生】尊敬的客户,你的订单(".$data['orderid'].")已经完成称重, 称重后订单实际应付金额为【".$money."】元,您选择的是货到付款,请按称重后的订单金额支付,谢谢您的配合!";
                        $push['isadmin']=1;
                        $push['inputtime']=time();
                        $push['username']=M('user')->where(array('role'=>1,'group_id'=>2))->getField("username");
                        $mid = M("Push")->add($push);
                        if ($mid) {
                            $registration_id=M('order a')->join("left join zz_member b on a.uid=b.id")->where(array('a.orderid'=>$data['orderid']))->getField("b.deviceToken");
                            $extras = array("orderid"=>$data['orderid'],'message_type'=>$message_type);
                            if(!empty($registration_id)){
                                PushQueue($mid,$message_type,$registration_id, $push['title'],$push['description'], serialize($extras),1);
                            }
                        }
                        M("message")->add(array(
                            'uid'=>0,
                            'tuid'=>0,
                            'title'=>"订单称重完成",
                            'value'=>$data['orderid'],
                            'varname'=>"order",
                            'inputtime'=>time()
                        ));
                    }
                }else{
                    M("message")->add(array(
                                'uid'=>0,
                                'tuid'=>0,
                                'title'=>"订单称重完成",
                                'value'=>$data['orderid'],
                                'varname'=>"order",
                                'inputtime'=>time()
                            ));
                }
                
                
                
                $this->success("操作成功！");
            } else {
                $this->error("操作失败！");
            }
            
        } else {
            $data = M("order_productinfo a")->join("left join zz_product b on a.pid=b.id")->where(array("a.id" => $_GET["id"]))->find();
            $this->assign("data", $data);
            $this->assign("id",$_GET['id']);
            $this->display();
        }
    }
    public function ajax_getneworder(){
        $lasttime=$_POST['lasttime'];
        $where=array();
        ///$where['a.inputtime']=array(array('ELT', $lasttime),array('EGT', strtotime("- 7days",$lasttime)));
        $where['a.puid']=$this->userid;
        $where['b.status']=2;
        $where['b.package_status']=0;
        $where['b.delivery_status']=0;
        $where['b.close_status']=0;
        $where['b.cancel_status']=0;
        $order=M('Order a')
            ->join("left join zz_order_time b on a.orderid=b.orderid")
            ->order(array('b.distribute_time'=>'desc'))
            ->where($where)
            ->field("a.orderid")
            ->find();
        if(!empty($order)){
            $data['status']=1;
            $data['msg']="有一笔新订单";
            $data['order']=$order;
            $this->ajaxReturn($data,'json');
        }else{
            $data['status']=0;
            $data['msg']="暂无新订单";
            $this->ajaxReturn($data,'json');
        }
    }
    //public function ajax_setnoticestatus(){
    //    $orderid=I('orderid');
    //    $uid = $_SESSION["userid"];
    //    M('noticestatus')->add(array(
    //        'orderid'=>$orderid,
    //        'uid'=>$uid,
    //        'type'=>'package',
    //        'inputtime'=>time()
    //        ));
    //}
}