<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class ApplyController extends CommonController {
    public function _initialize(){
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function realname() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
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
            
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('realname','idcard');
                if ($searchtype < 2) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 2) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
            //状态
            $status = $_GET["status"];
            if ($status != "" && $status != null) {
                $where["status"] = array("EQ", $status);
            }
        }
    
        $count = D("realname_apply")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("realname_apply")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function realnamedelete() {
        $id = $_GET['id'];
        if (D("realname_apply")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function realnamedel(){
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("realname_apply")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function realnamereview(){
        if (IS_POST) {
            $status=I('status');
            $data=M('realname_apply')->where('id=' . I('id'))->find();
            if($data['status']!=1){
                $this->error("不能重复审核！");
            }
            $id=M('realname_apply')->where('id=' . I('id'))->save(array(
                'status'=>$status,
                'verify_time' => time(),
                'verify_user' => $_SESSION['user'],
                'remark'=>I('remark')
            ));
            if($id>0&&$status==2){
                M('member')->where(array('id'=>$data['uid']))->save(array('realname'=>$data['realname'],'idcard'=>$data['idcard'],'realname_status'=>1));
                M("alipayaccount")->where(array('uid'=>$data['uid']))->save(array('alipayaccount'=>$data['alipayaccount']));
                \Api\Controller\UtilController::addmessage($data['uid'],"申请实名认证审核成功","恭喜您，您的实名认证通过蜗牛客平台审核！","恭喜您，您的实名认证通过蜗牛客平台审核！","applyrealnamesuccess",$data['uid']);
                $Ymsms = A("Api/Ymsms");
                $content=$Ymsms->getsmstemplate("sms_applyrealnamesuccess");
                $data=json_encode(array('content'=>$content,'type'=>"sms_applyrealnamesuccess",'r_id'=>$data['uid']));
                $statuscode=$Ymsms->sendsms($data);
                $this->success("操作成功！");
            }elseif($id>0&&$status==3){
                \Api\Controller\UtilController::addmessage($data['uid'],"申请实名认证审核失败","很抱歉，您的实名认证没有通过审核！","很抱歉，您的实名认证没有通过审核！","applyrealnamefail",$data['uid']);
                $Ymsms = A("Api/Ymsms");
                $content=$Ymsms->getsmstemplate("sms_applyrealnamefail");
                $data=json_encode(array('content'=>$content,'type'=>"sms_applyrealnamefail",'r_id'=>$data['uid']));
                $statuscode=$Ymsms->sendsms($data);
                $this->success("操作成功！");
            }elseif(!$id){
                $this->error("操作失败！");
            }
        } else {
            $id=I('id');
            $data=M('realname_apply')->where(array('id'=>$id))->find();
            $this->assign("data",$data);
            $this->display();
        }
    }
    public function houseowner() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
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
            
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('realname','housename', 'address');
                if ($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 3) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
            //状态
            $status = $_GET["status"];
            if ($status != "" && $status != null) {
                $where["status"] = array("EQ", $status);
            }
        }
    
        $count = D("houseowner_apply")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("houseowner_apply")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function houseownerdelete() {
        $id = $_GET['id'];
        if (D("houseowner_apply")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function houseownerdel(){
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("houseowner_apply")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function houseownerreview(){
        if (IS_POST) {
            $status=I('status');
            $data=M('houseowner_apply')->where('id=' . I('id'))->find();
            if($data['status']!=1){
                $this->error("不能重复审核！");
            }
            $id=M('houseowner_apply')->where('id=' . I('id'))->save(array(
                'status'=>$status,
                'verify_time' => time(),
                'verify_user' => $_SESSION['user'],
                'remark'=>I('remark')
            ));
            if($id>0&&$status==2){
                M('member')->where(array('id'=>$data['uid']))->save(array('realname'=>$data['realname'],'houseowner_status'=>1));
                M("alipayaccount")->where(array('uid'=>$data['uid']))->save(array('alipayaccount'=>$data['alipayaccount']));
                \Api\Controller\UtilController::addmessage($data['uid'],"申请房东认证审核成功","恭喜您，您的商家认证已经通过平台审核！","恭喜您，您的商家认证已经通过平台审核！","applyhouseownersuccess",$data['uid']);
                $Ymsms = A("Api/Ymsms");
                $content=$Ymsms->getsmstemplate("sms_applyhouseownersuccess");
                $data=json_encode(array('content'=>$content,'type'=>"sms_applyhouseownersuccess",'r_id'=>$data['uid']));
                $statuscode=$Ymsms->sendsms($data);
                $this->success("操作成功！");
            }elseif($id>0&&$status==3){
                \Api\Controller\UtilController::addmessage($data['uid'],"申请房东认证审核成功","很抱歉，您的商家认证没有通过平台审核！","很抱歉，您的商家认证没有通过平台审核！","applyhouseownerfail",$data['uid']);
                $Ymsms = A("Api/Ymsms");
                $content=$Ymsms->getsmstemplate("sms_applyhouseownerfail");
                $data=json_encode(array('content'=>$content,'type'=>"sms_applyhouseownerfail",'r_id'=>$data['uid']));
                $statuscode=$Ymsms->sendsms($data);
                $this->success("操作成功！");
            }elseif(!$id){
                $this->error("操作失败！");
            }
        } else {
            $id=I('id');
            $data=M('houseowner_apply')->where(array('id'=>$id))->find();
            $this->assign("data",$data);
            $this->display();
        }
    }
    public function action() {
        $submit = trim($_POST["submit"]);
        if ($submit == "del") {
            $this->del();
        } elseif ($submit == "realnamedel") {
            $this->realnamedel();
        } elseif ($submit == "houseownerdel") {
            $this->houseownerdel();
        } elseif ($submit == "withdrawdel") {
            $this->withdrawdel();
        }
    }
    public function withdraw() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
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
            
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('realname','alipayaccount');
                if ($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 3) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
            //状态
            $status = $_GET["status"];
            if ($status != "" && $status != null) {
                $where["status"] = array("EQ", $status);
            }
        }
    
        $count = D("withdraw")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("withdraw")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function withdrawdelete() {
        $id = $_GET['id'];
        if (D("withdraw")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function withdrawdel(){
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("withdraw")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function withdrawreview(){
        if (IS_POST) {
            $status=I('status');
            $data=M('withdraw')->where('id=' . I('id'))->find();
            if($data['status']!=1){
                $this->error("不能重复审核！");
            }
            $id=M('withdraw')->where('id=' . I('id'))->save(array(
                'status'=>$status,
                'verify_time' => time(),
                'verify_user' => $_SESSION['user'],
                'remark'=>I('remark')
            ));
            $account=M('account')->where(array('uid'=>$data['uid']))->find();
            if($id>0&&$status==2){
                $mid=M('account')->where(array('uid'=>$data['uid']))->save(array(
                    'nousemoney'=>$account['nousemoney']-floatval($data['money']),
                    ));
                if($mid){
                    M('account_log')->add(array(
                      'uid'=>$data['uid'],
                      'type'=>'withdrawsuccess',
                      'money'=>$data['money'],
                      'total'=>$account['total'],
                      'usemoney'=>$account['usemoney'],
                      'nousemoney'=>$account['nousemoney']-floatval($data['money']),
                      'status'=>1,
                      'dcflag'=>2,
                      'remark'=>'申请提现审核通过',
                      'addip'=>get_client_ip(),
                      'addtime'=>time()
                      ));
                }
                \Api\Controller\UtilController::addmessage($data['uid'],"申请提现审核通过","恭喜您，您申请的提现已经通过平台审核！","恭喜您，您申请的提现已经通过平台审核！","withdrawsuccess",$data['uid']);
                $Ymsms = A("Api/Ymsms");
                $content=$Ymsms->getsmstemplate("sms_withdrawsuccess");
                $data=json_encode(array('content'=>$content,'type'=>"sms_withdrawsuccess",'r_id'=>$data['uid']));
                $statuscode=$Ymsms->sendsms($data);
                $this->success("操作成功！");
            }elseif($id>0&&$status==3){
                $mid=M('account')->where(array('uid'=>$data['uid']))->save(array(
                    'nousemoney'=>$account['nousemoney']-floatval($data['money']),
                    'usemoney'=>$account['usemoney']+floatval($data['money']),
                    ));
                if($mid){
                    M('account_log')->add(array(
                      'uid'=>$data['uid'],
                      'type'=>'withdrawfail',
                      'money'=>$data['money'],
                      'total'=>$account['total'],
                      'usemoney'=>$account['usemoney']+floatval($data['money']),
                      'nousemoney'=>$account['nousemoney']-floatval($data['money']),
                      'status'=>1,
                      'dcflag'=>1,
                      'remark'=>'申请提现审核不通过',
                      'addip'=>get_client_ip(),
                      'addtime'=>time()
                      ));
                }
                \Api\Controller\UtilController::addmessage($data['uid'],"申请提现审核不通过","很抱歉，您申请的提现没有通过平台审核！","很抱歉，您申请的提现没有通过平台审核！","withdrawfail",$data['uid']);
                $Ymsms = A("Api/Ymsms");
                $content=$Ymsms->getsmstemplate("sms_withdrawfail");
                $data=json_encode(array('content'=>$content,'type'=>"sms_withdrawfail",'r_id'=>$data['uid']));
                $statuscode=$Ymsms->sendsms($data);
                $this->success("操作成功！");
            }elseif(!$id){
                $this->error("操作失败！");
            }
        } else {
            $id=I('id');
            $data=M('withdraw')->where(array('id'=>$id))->find();
            $this->assign("data",$data);
            $this->display();
        }
    }
    public function refund() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
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
            
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('realname','alipayaccount');
                if ($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 3) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
            //状态
            $status = $_GET["status"];
            if ($status != "" && $status != null) {
                $where["status"] = array("EQ", $status);
            }
        }
    
        $count = D("refund_apply")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("refund_apply")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function refundpay(){
        $id = $_GET['id'];
        $refunddata=M('refund_apply')->where(array('id'=>$id))->find();
        if($refunddata['refund_status']==1){
            $this->error("已经退款");
        }
        switch ($refunddata['channel'])
        {
            case "alipay":
                $refundorderid=date("YmdHis", time()) . rand(100, 999);
                M('refund_apply')->where(array('id'=>$id))->setField("refundorderid",$refundorderid);
                $Refund=A("Api/Refund");
                $refundcharge=$Refund->refund($refunddata['transaction_id'],$refunddata['total'],$refunddata['money'],$refundorderid,$refunddata['channel']);
                exit($refundcharge);
                break;
            case "wxpay":
                $Refund=A("Api/Refund");
                $refundcharge=$Refund->refund($refunddata['transaction_id'],$refunddata['total'],$refunddata['money'],$refunddata['refundorderid'],$refunddata['channel']);
                $this->success("退款成功",U('Admin/Apply/refund'));
                break;
            case "unionpay":
                $this->error("暂不支持银联退款",U('Admin/Apply/refund'));
                break;
            default:
                $this->error("数据校验错误",U('Admin/Apply/refund'));
                break;
        }
        
    }
    public function refunddelete() {
        $id = $_GET['id'];
        if (D("refund_apply")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function refunddel(){
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("refund_apply")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}