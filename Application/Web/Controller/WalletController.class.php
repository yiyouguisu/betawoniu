<?php

namespace Web\Controller;

use Web\Common\CommonController;

class WalletController extends CommonController {

  protected $uid;
  protected $account;
  protected $member;

  public function _initialize() {
    $uid = session('uid');
    if(empty($uid)) {
      return $this->redirect('Member/login'); 
    } else {
      $this->uid = $uid;
      $this->account = M('account')->where(array('uid' => $uid))->find();
    }
  }

  /**
   * 钱包首页
   */
  public function index() {
    $uid = session('uid');
    $member = M('member')->where(array('id' => $this->uid))->find();
    $this->assign('account', $this->account);
    $this->assign('member', $member);
    $this->display(); 
  }

  /**
   * 使用记录
   */
  public function use_log() {
    $member = M('member')->where(array('id' => $this->uid))->find();

    #TODO 后期换ajax 刷新模式，整体钱包都需要改版
    $accountLog = M('account_log')
      ->where(array('uid' => $uid))
      ->order('id desc')
      ->select();
    $this->assign('logs', $accountLog);
    $this->display();
  }

  /**
   * 提现
   */
  public function withdraw_cash() {
    $alipayaccount = M('alipayaccount')->where(array('uid' => $this->uid))->find();
    $this->assign('waitmoney', $this->account['waitmoney']);
    $this->assign('alipayaccount', $alipayaccount);
    $this->display();
  }

}
