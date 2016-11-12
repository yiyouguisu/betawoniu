<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class HolidayController extends CommonController {

    public function index() {
        $search = I('post.search');
        $where = array();
        if (!empty($search)) {
             //添加开始时间
            $start_time = I('post.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["inputtime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('post.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            
        }
        $data = M("Holiday")->where($where)->order(array('listorder'=>'desc',"id" => "asc"))->select();
        $this->assign("data", $data);
        $this->display();
    }
    public function add() {
        if (IS_POST) {
        	$data=$_POST;
            $data['startdate']=strtotime($_POST['startdate']);
            $data['enddate']=strtotime($_POST['enddate']);
        	$data['inputtime']=time();
            if (false !== D("Holiday")->add($data)) {
                $this->success("提交成功！", U("Admin/Holiday/index"));
            } else {
                $this->error(D("Holiday")->getError());
            }
        } else {
            $this->display();
        }
    }
    public function edit() {
        if (IS_POST) {
        	$data=$_POST;
            $data['startdate']=strtotime($_POST['startdate']);
            $data['enddate']=strtotime($_POST['enddate']);
        	$data['updatetime']=time();
            if (false !== M("Holiday")->save($data)) {
                $this->success("更新成功！", U("Admin/Holiday/index"));
            } else {
                $this->error(D("Holiday")->getError());
            }
        } else {
            $data = M("Holiday")->where(array("id" => $_GET["id"]))->find();
            $this->assign("data", $data);
            $this->display();
        }
    }
    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Holiday")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Holiday")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    
}