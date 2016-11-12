<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class ReviewController extends CommonController {

    public function index() {
        $search = I('get.search');
        $where = array();
        if(!empty($_GET['uid'])){
            $where['uid']=$_GET['uid'];
        }
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
            //状态
            $varname = $_GET["varname"];
            if ($varname != "" && $varname != null) {
                $where["varname"] = array("EQ", $varname);
            }
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = I('get.keyword');
            if (!empty($keyword)) {
                if ($searchtype == 2) {
                    $where["id"] = array("EQ", (int) $keyword);
                }elseif($searchtype == 0){
                    $where["content"] = array("like", "%{$keyword}%");
                }else if($searchtype == 0){
                    $select["username"] = array("LIKE", "%" . $keyword . "%");
                    $uids=M('member')->where($select)->getField("id",true);
                    $where['uid']=array('in',$uids);
                }
            }
        }
        $count = M("review")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = M("review")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $key => $value) {
            if($value['varname']=='note'){
                $data[$key]['vaname']="游记";
                $data[$key]['title']=M('note')->where(array('id'=>$value['value']))->getField("title");
            }else if($value['varname']=='party'){
                $data[$key]['vaname']="活动";
                $data[$key]['title']=M('activity')->where(array('id'=>$value['value']))->getField("title");
            }else if($value['varname']=='hostel'){
                $data[$key]['vaname']="美宿";
                $data[$key]['title']=M('hostel')->where(array('id'=>$value['value']))->getField("title");
            }else if($value['varname']=='room'){
                $data[$key]['vaname']="房间";
                $data[$key]['title']=M('room')->where(array('id'=>$value['value']))->getField("title");
            }else if($value['varname']=='trip'){
                $data[$key]['vaname']="行程";
                $data[$key]['title']=M('trip')->where(array('id'=>$value['value']))->getField("title");
            }
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->assign("searchtype", $searchtype);
        $this->display();
    }

    /**
     *  删除
     */
    public function delete() {
        $id = $_GET['id'];
        if (D("review")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
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
                M("review")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }


}