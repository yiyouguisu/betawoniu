<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class TripController extends CommonController {

  public function _initialize() {
  
  }

  public function index() {
    $where = array();
    if(I('get.search')) {
      $starttime = I('get.start_time');
      if($starttime) {
        $where['a.starttime'] = array(array('eq', strtotime($starttime)));
      }
      $endtime = I('get.end_time');
      if($endtime) {
        $where['a.endtime'] = array(array('eq', strtotime($endtime)));
      }
      $inputStart = I('get.input_start');
      $inputEnd = I('get.input_end');
      if($inputStart && $inputEnd) {
        $where['a.inputtime'] = array('between', strtotime($inputStart) - 1 . ',' . strtotime($inputEnd . ' 23:59:59'));
      } elseif($inputStart) {
        $where['a.inputtime'] = array('gt', $inputStart);
      } elseif($inputEnd) {
        $where['a.inputtime'] = array('lt', $inputEnd);
      }
      $status = I('get.status');
      switch ($status) {
        case 1:
          $where['a.starttime'][] = array('gt', time());
          break;
        case 2:
          $where['a.starttime'][] = array('elt', time());
          $where['a.endtime'][] = array('egt', time());
          break;
        case 3:
          $where['a.endtime'][] = array('lt', time());
          break; 
      }
      $kType = I('get.searchtype');
      $keywords = I('get.keyword');
      if($keywords) {
        switch($kType) {
          case 0:
            $where['a.title'] = array('like', "%{$keywords}%");
            break;  
          case 1:
            $where['a.description'] = array('like', "%{$keywords}%");
            break;
          case 2:
            $where['a.username'] = array('like', "%{$keywords}%");
            break;
          case 3:
            $where['b.phone'] = array('like', "%{$keywords}%");
            break;
        }
      }
    }

    $count = M('trip a')
      ->join('zz_member b on a.uid = b.id')
      ->where($where)
      ->count();
    $page = new \Think\Page($count, 15);
    $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
    $page->setConfig("prev","上一页");
    $page->setConfig("next","下一页");
    $page->setConfig("first","第一页");
    $page->setConfig("last","最后一页");
    $trips = M('trip a')
      ->join('zz_member b on a.uid = b.id')
      ->where($where)
      ->field('a.id,a.title,a.description,a.starttime,a.endtime,a.inputtime,a.username,a.days,a.ispublic,b.phone')
      ->order('a.id desc')
      ->limit($page->firstRow . ',' . $page->listRows)
      ->select();
    foreach($trips as $key => $trip) {
      if($trip['starttime'] > time()) {
        $trips[$key]['status'] = '未开始';
      } elseif ($trip['endtime'] > time()) {
        $trips[$key]['status'] = '进行中';
      } else {
        $trips[$key]['status'] = '已结束';
      }
    }

    $show = $page->show();
    $this->assign("Page", $show);
    $this->assign('data', $trips);
    $this->display(); 
  }

  public function delete() {
    $id = I('post.id');
    $trip = M('trip')->where(array('id' => $id))->find();
    if(!$trip) {
      return $this->jsonFailed('未查找到对应行程！');
    } else {
      M('tripInfo')->where(array('tid' => $id))->delete();
      $res = M('trip')->where(array('id' => $id))->delete();
      if($res) {
        return $this->jsonSucceed(1);
      } else {
        return $this->jsonFailed('数据异常，请联系管理员！');
      }
    }
  }
}
