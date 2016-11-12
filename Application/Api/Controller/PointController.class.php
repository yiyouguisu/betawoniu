<?php

namespace Api\Controller;

use Api\Common\CommonController;

class PointController extends CommonController {

  /**
   * 增加积分
   * @param type: 1.签到, 2.注册
   *
   */
  public function addPoint($uid, $points, $remark = '', $type = 1, $relatId = 0) {
    $point = M('account')
      ->where(array('uid' => $uid))
      ->getField('point');

    //新增积分记录
    $newPointLog = array(
      'uid' => $uid,
      'points' => $points,
      'remark' => $remark,
      'type' => 1,
      'relat_id' => $relatId,
      'type_name' => $remark,
      'time' => time(),
      'total_point' => $point + $points
    );

    if(M('memberPointLog')->add($newPointLog)) {
      //账户记录最终积分
      $res = M('account')->where(array('uid' => $uid))->setField('point', $point + $points);
      return $res;
    } else {
      return false; 
    }
  }

  /**
   * 扣除积分
   * @param type: 1.兑换优惠券
   *
   */
  public function minuPoint($uid, $points, $remark = '', $type = 1, $relatId = 0) {
    $point = M('account')
      ->where(array('uid' => $uid))
      ->getField('point');

    //新增积分记录
    $newPointLog = array(
      'uid' => $uid,
      'points' => $points * -1,
      'remark' => $remark,
      'relat_id' => $relatId,
      'type' => $type,
      'type_name' => $remark,
      'time' => time(),
      'total_point' => $point + $points
    );

    if(M('memberPointLog')->add($newPointLog)) {
      //账户记录最终积分
      $res = M('account')->where(array('uid' => $uid))->setField('point', $point - $points);
      return $res;
    } else {
      return false; 
    }
  }

}



