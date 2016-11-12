<?php

namespace Api\Controller;

use Api\Common\CommonController;

class VoucherController extends CommonController {

  public function generateVoucherToMember($uid, $vid, $remark = '', $starttime = 0, $endtime = 0) {
    $voucher = M('vouchers')->where(array('id' => $vid))->find();
    $user = M('member')->where(array('id' => $uid))->find();

    try {
      $new = array(
        'uid' => $uid,
        'vid' => $vid,
        'title' => $voucher['title'],
        'content' => $voucher['content'],
        'validity_starttime' => $starttime ? $starttime : $voucher['validity_starttime'],
        'validity_endtime' => $endtime ? $endtime : $voucher['validity_endtime'],
        'price' => $voucher['price'],
        'thumb' => $voucher['thumb'],
        'updated_at' => time()
      );
      $newId = M('memberVouchers')->add($new);

      if($newId) {
        $log = array(
          'uid' => $uid,
          'vid' => $vid,
          'change_type' => 'generate',
          'client_ip' => 0,
          'uvid' => $new,
          'updated_at' => time(),
          'remark' => $remark
        );
        $logId = M('voucherChangeLog')->add($log);
        if($logId) {
          return $newId;
        } else {
          return NULL;
        }
      }

    } catch(Exception $e) {
      #todo log error.
      return false; 
    }
  }
}
