<?php

namespace Web\Controller;

use Web\Common\CommonController;

class TripController extends CommonController {
	
  public function _initialize() {
    $this->assign('TRIPCTRL', true); 
    if(!session('uid')) {
      $this->redirect('Web/Member/login');
    }
  }

  public function userInfo(){
      $this->display();
  }

  public function app_use(){
		$data=M('config')->where(array('varname'=>'tripinfo'))->find();
		$this->assign('data',$data);
		$this->display();
	}
  
  /**
   *  Display my trips list.
   *
   *  @author meroc
   *  @return mixed
   */
  public function myTrips() {
    $trips = M('trip')
      ->where(array(
        'uid' => session('uid')
      ))
      ->field('id,description,starttime,endtime,status')
      ->order('starttime desc')
      ->select();
    foreach($trips as $key => $trip) {
      $trips[$key]['status'] = $trip['starttime'] > time() ? 1 : $trip['endtime'] > time() ? 2 : 3; 
    }
    $publics = M('trip')
      ->where(array(
        'ispublic' => 1
      ))
      ->field('id,description,starttime,endtime,status')
      ->order('starttime desc')
      ->select();
    foreach($publics as $key => $pub) {
      $publics[$key]['status'] = $pub['starttime'] > time() ? 1 : $pub['endtime'] > time() ? 2 : 3; 
    }
    $this->assign('trips', $trips); 
    $this->assign('publics', $publics);
    $this->display(); 
  }

  /**
   *  Display public trips list.
   *
   *  @author meroc
   *  @return mixed
   */
  public function publicTrips() {
    $this->display();
  }
  
  /**
   *  Show trip details.
   *
   *  @author meroc
   *  @return mixed
   */
  public function detail() {
    $id = I('id');
    if(empty($id)) {
      $this->error('选择错误！');
    }
    $trip = M('trip')
      ->where(array('id' => $id))
      ->find();
    $trip['status'] = $trip['starttime'] > time() ? 1 : $trip['endtime'] > time() ? 2 : 3;
    $startTime = getChStartTime($trip['starttime']);
    $startDate = date('Y-m-d', $trip['starttime']);
    $endTime = getChEndTime($trip['starttime'], $trip['endtime']);
    $tripinfos = M('tripinfo')
      ->where(array('tid' => $id))
      ->order('day desc')
      ->select();
    $places = array();
    foreach($tripinfos as $key => $tripinfo) {
      array_push($places, $tripinfo['place']);
    }
    $placeStr = implode(',', $places);
    $edit = session('uid') == $trip['uid'] ? true : false;
    if($edit) {
      $this->assign('edit', $edit);
    }
    $comments = M('review a')
      ->join('zz_member b on a.uid = b.id')
      ->where(array('value' => $trip['id'], 'varname' => 'trip'))
      ->field('a.*, b.head, b.nickname')
      ->select();
    $ccount = count($comments);
    $this->assign('ccount', $ccount);
    $this->assign('comments', $comments);
    $this->assign('trip', $trip);
    $this->assign('tripinfos', $tripinfos);
    $this->assign('placeStr', $placeStr);
    $this->assign('startDate', $startDate);
    $this->display(); 
  }

  /**
   *  Create new trip.
   *
   *  @author meroc
   *  @return mixed
   */
  public function add() {
    $title = $_POST['trip_title'];
    $startDate = $_POST['start_date'];
    $tripDays = $_POST['trip_days'];
    $endDate = date('Y-m-d', strtotime($startDate) + $tripDays * 3600 * 24);
    $hotelIds = $_POST['hotels'];
    if($hotelIds) {
      $hotels = M('tags_content a')
        ->join('zz_hostel b on a.contentid = b.id')
        ->join('zz_area c on b.city = c.id')
        ->where(array('contentid' => array('in', $hotelIds), 'varname' => 'hostel'))
        ->field('a.place,c.name as cityname,a.hostel as event,a.contentid,b.city,b.title')
        ->select();
      $this->assign('hotels', $hotels);
    }
    $this->assign('title', $title);
    $this->assign('start_date', $startDate);
    $this->assign('end_date', $endDate);
    $this->assign('starttime', strtotime($startDate));
    $this->assign('endtime', strtotime($endDate));
    $this->assign('uid', session('uid'));
    $this->assign('trip_days', $tripDays);
    $this->assign('circleDays', $tripDays + 1);
    $this->assign('uid', session('uid'));
    $this->display();
  }

  public function edit() {
    $title = $_POST['trip_title'];
    $startDate = $_POST['start_date'];
    $tripDays = $_POST['trip_days'];
    $tid = $_POST['tid'];
    $endDate = date('Y-m-d', strtotime($startDate) + $tripDays * 3600 * 24);
    $trip = M('trip')->where(array('id' => $tid))->find();
    if(empty($tid)) {
      $this->error('无效的行程.');
    }
    $tripinfos = M('tripinfo')->where(array('tid' => $tid))->select();
    $this->assign('trip', $trip);
    $this->assign('tripinfos', $tripinfos); 
    $this->assign('title', $title);
    $this->assign('start_date', $startDate);
    $this->assign('end_date', $endDate);
    $this->assign('starttime', strtotime($startDate));
    $this->assign('endtime', strtotime($endDate));
    $this->assign('uid', session('uid'));
    $this->assign('trip_days', $tripDays);
    $this->assign('circleDays', $tripDays + 1);
    $this->assign('uid', session('uid'));
    $this->display();
  }

  public function comment() {
    $content = $_POST['content'];
    $tid = $_POST['tid'];
    if(empty($content)) {
      $this->error('评论内容不能为空！'); 
    }
    $uid = session('uid');

    $data = array(
      'uid' => $uid,
      'content' => $content,
      'value' => $tid,
      'varname' => 'trip',
      'evaluation' => 10,
      'evaluationpercent' => 100,
      'hit' => 0,
      'status' => 0,
      'inputtime' => time(),
      'isdel' => 0
    );
    $res = M('review')->add($data);
    if($res) {
      $this->success('评论成功！');
    } else {
      $this->error('评论失败！');
    }
  }
}
