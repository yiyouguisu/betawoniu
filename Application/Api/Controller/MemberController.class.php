<?php

namespace Api\Controller;

use Api\Common\CommonController;

class MemberController extends CommonController {
	public function _initialize(){
		parent::_initialize();
		Vendor("pingpp.init");
		$ConfigData=F("web_config");
		if(!$ConfigData){
			$ConfigData=D("Config")->order(array('id'=>'desc'))->select();
			F("web_config",$ConfigData);
		}
		$this->ConfigData=$ConfigData;
	}
	/**
	 * 会员注册测试
	 */
	public function test() {
		$ret = $GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt_des($ret['data']);
		$password = trim($ret['password']);
		$phone = trim($ret['phone']);
		if ($phone == '' || $password == '') {
			exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null")));
		} else {
			$data['username'] = $phone;
			$data['thirdname'] = $phone;
			$data['password'] = $password;
			$data['phone'] = $phone;
			$data['phone_status'] = 1;
			if ($data) {
				exit(json_encode(array('code' => 200, 'msg' => "success", 'data' => CommonController::encrypt_des($data))));
			} else {
				exit(json_encode(array('code' => -200, 'msg' => "error")));
			}
		}
	}
	/**
	 * 会员注册
	 */
	public function reg() {
		$ret = $GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$telverify = trim($ret['telverify']);
		$password = trim($ret['password']);
		$phone = trim($ret['phone']);
		$deviceToken=trim($ret['deviceToken']);
		$invite_code = trim($ret['invite_code']);
		$verifyset = M('verify')->where('phone=' . $phone)->find();
		$time = time() - $verifyset['expiretime'];
		if ($time > 0) {
			$verify = "";
			M('verify')->where('phone=' . $phone)->save(array(
					'status' => 1
			));
		} else {
			$verify = $verifyset['verify'];
			M('verify')->where('phone=' . $phone)->save(array(
					'status' => 1
			));
		}
		$tuijianuser=M('member')->where(array('tuijiancode'=>$invite_code))->find();
		if ($phone == '' || $password == '' || $telverify == '') {
			exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
		} elseif (strtolower($telverify) != strtolower($verify)) {
			exit(json_encode(array('code' => -200, 'msg' => "验证码错误")));
		} elseif (!isMobile($phone)) {
			exit(json_encode(array('code' => -200, 'msg' => "手机号码格式错误")));
		} elseif (!check_phone($phone)) {
			exit(json_encode(array('code' => -200, 'msg' => "手机号已被注册")));
		} elseif (!$tuijianuser&&!empty($invite_code)) {
			exit(json_encode(array('code' => -200, 'msg' => "推荐用户不存在")));
		} else {
			$data['username'] = $phone;
			$data['password'] = $password;
			$data['phone'] = $phone;
			$data['phone_status'] = 1;
			$data['group_id'] = 1;
			$data['head']="/default_head.png";
			if($tuijianuser&&!empty($invite_code)){
				$data['groupid_id'] = $tuijianuser['id'];
			}
			$id = D("Member")->addUser($data);
			if ($id) {
				$Rongrun=A("Api/Rongyun");
				$rongyun_token=$Rongrun->savetoken($id);
				$dataset['uid'] = $id;
				$dataset['username'] = $phone;
				$dataset['rongyun_token'] = $rongyun_token;

				if(!empty($deviceToken)){
					M('member')->where(array('deviceToken'=>$deviceToken))->setField('deviceToken','');
					M('member')->where(array('id'=>$id))->setField('deviceToken',$deviceToken);
				}
				if($tuijianuser&&!empty($invite_code)){
					M('invite')->add(array(
							'uid'=>$tuijianuser['id'],
							'tuid'=>$id,
							'tuijiancode'=>$invite_code,
							'status'=>2,
							'inputtime'=>time()
					));
				}
				UtilController::addmessage($id,"恭喜你注册成功","恭喜你注册成功","恭喜你注册成功","reg",$id);

        //注册送积分，edit by meroc@2016-10-20
        $Point = A('Api/Point');
        $Point->addPoint($id, 100, '注册送积分', 2, 0);

				exit(json_encode(array('code' => 200, 'msg' => "注册成功", 'data' => $dataset)));
			} else {
				exit(json_encode(array('code' => -200, 'msg' => "注册失败")));
			}
		}
	}
	/**
	 * 会员登录
	 */
	public function login() {
		$ret = $GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$username = trim($ret['username']);
		$password = trim($ret['password']);
		$deviceToken=trim($ret['deviceToken']);

		$user = $this->loginHome($username, $password);
		if ($username == '' || $password == '') {
			exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
		} elseif (!$user) {
			M("userlog")->add(array(
					"username" => $username,
					"logintime" => time(),
					"loginip" => get_client_ip(),
					"status" => 0,
					"password" => "***" . substr($password, 3, 4) . "***",
					"info" => "登录失败"
			));
			exit(json_encode(array('code' => -200, 'msg' => "登录失败")));
		} elseif ($user['status']==0) {
			exit(json_encode(array('code' => -200, 'msg' => "账户已被禁用")));
		} else {
			M("userlog")->add(array(
					"username" => $username,
					"logintime" => time(),
					"loginip" => get_client_ip(),
					"status" => 1,
					"password" => "***" . substr($password, 3, 4) . "***",
					"info" => "登录成功"
			));
      if(empty($user['rongyun_token'])) {
			  $Rongrun=A("Api/Rongyun");
			  $rongyun_token=$Rongrun->savetoken($user['id']);
      }
      $account = M('account')->where(array('uid' => $user['id']))->find();
			if(!empty($deviceToken)&&$deviceToken!=$user['deviceToken']){
				M('member')->where(array('deviceToken'=>$deviceToken))->setField('deviceToken','');
				M('member')->where(array('id'=>$user['id']))->setField('deviceToken',$deviceToken);
			}
			//根据用户的type显示不同的结果集
			$dataset = array();
			$dataset['uid'] = $user['id'];
			$dataset['username'] = $user['username'];
			$dataset['head'] = $user['head'];
			$dataset['realname'] = $user['realname'];
			$dataset['idcard'] = $user['idcard'];
			$dataset['nickname'] = $user['nickname'];
			$dataset['phone'] = $user['phone'];
			$dataset['sex'] = $user['sex'];
			$dataset['alipay_status'] = $user['alipay_status'];
			if($dataset['alipay_status']==1){
				$alipayaccount=M('alipayaccount')->where(array('uid'=>$user['id']))->field("realname,alipayaccount")->find();
				$dataset['alipayaccount'] = $alipayaccount;
			}
			$dataset['birthday'] = $user['birthday'];
			$dataset['hometown'] = $user['hometown'];
			$dataset['area'] = $user['area'];
			$dataset['education'] = $user['education'];
			$dataset['school'] = $user['school'];
			$dataset['zodiac'] = $user['zodiac'];
			$dataset['constellation'] = $user['constellation'];
			$dataset['bloodtype'] = $user['bloodtype'];
			$dataset['info'] = $user['info'];
			$dataset['characteristic'] = $user['characteristic'];
			$dataset['hobby'] = $user['hobby'];
			$dataset['realname_status'] = $user['realname_status'];
			$dataset['houseowner_status'] = $user['houseowner_status'];
			$dataset['rongyun_token']=$user['rongyun_token'];
      $dataset['point'] = $account['point'];
      $signToday = M('memberSignLog')->where(array('time' => array('gt', strtotime(date('Y-m-d')))))->getField('days');
      $dataset['sign_today'] = $signToday ? $signToday : 0;
			$account=M('account')->where(array('uid'=>$user['id']))->find();
			$dataset['usemoney'] = !empty($account['usemoney'])?$account['usemoney']:0.00;
			$dataset['waitmoney'] = !empty($account['waitmoney'])?$account['waitmoney']:0.00;
			$attention=M('attention')->where(array('fuid'=>$user['id']))->count();
			$dataset['attention'] = !empty($attention)?$attention:0;
			$fans=M('attention')->where(array('tuid'=>$user['id']))->count();
			$dataset['fans'] = !empty($fans)?$fans:0;
			exit(json_encode(array('code' => 200, 'msg' => "登录成功", 'data' =>$dataset)));
		}
	}
	/**
	 * 会员登录-第三方登陆
	 */
	public function applogin() {
		$ret = $GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$openid = trim($ret['openid']);
		$site = trim($ret['site']);
		$nickname = trim($ret['nickname']);
		$head = trim($ret['head']);
		$info=trim($ret['info']);
		$deviceToken=trim($ret['deviceToken']);

		$bind = M('oauth')->field('id,bind_uid,logintimes')->where(array('openid' => $openid, 'site' => $site))->find();
		$user = M('member')->where(array('id' => $bind['bind_uid']))->find();
		if ($openid == '' || $site == '' || $nickname == '' || $head == '') {
			exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
		} elseif (!$user) {
			$data['username'] = $openid;
			$data['password'] = "123456";
			$data['nickname'] = $nickname;
			$data['head'] = $head;
			$data['info']=$info;
			if(!empty($deviceToken)){
				M('member')->where(array('deviceToken'=>$deviceToken))->setField('deviceToken','');
				$data['deviceToken'] = $deviceToken;
			}
			$id = D("Member")->addUser($data);
			$Rongrun=A("Api/Rongyun");
			$rongyun_token=$Rongrun->savetoken($id);

			$map['bind_uid'] = $id;
			$map['is_bind'] = 1;
			$map['nickname'] = $nickname;
			$map['openid'] = $openid;
			$map['site'] = $site;
			$map['logintimes'] = 1;
			$map['inputtime'] = time();
			$map['logintime'] = time();
			M('oauth')->add($map);

			$dataset = array();
			$dataset['uid'] = $id;
			$dataset['username'] = $openid;
			$dataset['realname'] = "";
			$dataset['head'] = $head;
			$dataset['nickname'] = $nickname;
			$dataset['phone'] = "";
			$dataset['sex'] = 0;
			$dataset['birthday'] ="" ;
			$dataset['hometown'] = "";
			$dataset['area'] = "";
			$dataset['education'] = "";
			$dataset['school'] = "";
			$dataset['zodiac'] = "";
			$dataset['constellation'] = "";
			$dataset['bloodtype'] = "";
			$dataset['info'] = $info;
			$dataset['characteristic'] = "";
			$dataset['hobby'] = "";
			$dataset['realname_status'] = 0;
			$dataset['houseowner_status'] = 0;
			$dataset['rongyun_token']=$rongyun_token;
			$dataset['usemoney'] = 0.00;
			$dataset['waitmoney'] = 0.00;
			$dataset['attention'] = 0;
			$dataset['fans'] = 0;
			exit(json_encode(array('code' => 200, 'msg' => "登录成功", 'data' =>$dataset)));
		} else {
			$save['id'] = $bind['id'];
			$save['logintimes'] = ($bind['logintimes'] + 1);
			$save['logintime'] = time();
			M('oauth')->save($save);

			if(!empty($deviceToken)){
				M('member')->where(array('deviceToken'=>$deviceToken))->setField('deviceToken','');
				M('member')->where(array('id' => $bind['bind_uid']))->save(array(
						'nickname' => $nickname,
						'head' => $head,
						'deviceToken'=>$deviceToken
				));
			}else{
				M('member')->where(array('id' => $bind['bind_uid']))->save(array(
						'nickname' => $nickname,
						'head' => $head,
						'info'=>$info
				));
			}

			$dataset = array();
			$dataset['uid'] = $user['id'];
			$dataset['username'] = $user['username'];
			$dataset['realname'] = $user['realname'];
			$dataset['head'] = $user['head'];
			$dataset['nickname'] = $user['nickname'];
			$dataset['phone'] = $user['phone'];
			$dataset['sex'] = $user['sex'];
			$dataset['alipay_status'] = $user['alipay_status'];
			if($dataset['alipay_status']==1){
				$alipayaccount=M('alipayaccount')->where(array('uid'=>$user['id']))->field("realname,alipayaccount")->find();
				$dataset['alipayaccount'] = $alipayaccount;
			}
			$dataset['birthday'] = $user['birthday'];
			$dataset['hometown'] = $user['hometown'];
			$dataset['area'] = $user['area'];
			$dataset['education'] = $user['education'];
			$dataset['school'] = $user['school'];
			$dataset['zodiac'] = $user['zodiac'];
			$dataset['constellation'] = $user['constellation'];
			$dataset['bloodtype'] = $user['bloodtype'];
			$dataset['info'] = $user['info'];
			$dataset['characteristic'] = $user['characteristic'];
			$dataset['hobby'] = $user['hobby'];
			$dataset['realname_status'] = $user['realname_status'];
			$dataset['houseowner_status'] = $user['houseowner_status'];
			$dataset['rongyun_token']=$user['rongyun_token'];
			$account=M('account')->where(array('uid'=>$uid))->find();
			$dataset['usemoney'] = !empty($account['usemoney'])?$account['usemoney']:0.00;
			$dataset['waitmoney'] = !empty($account['waitmoney'])?$account['waitmoney']:0.00;
			$attention=M('attention')->where(array('fuid'=>$user['id']))->count();
			$dataset['attention'] = !empty($attention)?$attention:0;
			$fans=M('attention')->where(array('tuid'=>$user['id']))->count();
			$dataset['fans'] = !empty($fans)?$fans:0;
			exit(json_encode(array('code' => 200, 'msg' => "登录成功", 'data' => $dataset)));
		}
	}
	/**
	 *绑定手机号
	 **第三方登录后完善信息
	 */
	public function bindphone(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$password=trim($ret['password']);
		$phone=trim($ret['phone']);
		$telverify = trim($ret['telverify']);
		$sex=intval(trim($ret['sex']));

		$verifyset = M('verify')->where('phone=' . $phone)->find();
		$time = time() - $verifyset['expiretime'];
		if ($time > 0) {
			$verify = "";
			M('verify')->where('phone=' . $phone)->save(array(
					'status' => 1
			));
		} else {
			$verify = $verifyset['verify'];
			M('verify')->where('phone=' . $phone)->save(array(
					'status' => 1
			));
		}

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();

		if($phone==''||$password==''||$uid==''||$telverify==''||$sex==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif (strtolower($telverify) != strtolower($verify)) {
			exit(json_encode(array('code' => -200, 'msg' => "验证码错误")));
		}elseif(!$user){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(!check_phone($phone)){
			exit(json_encode(array('code'=>-200,'msg'=>"手机号已经被使用!")));
		}else{
			$verify = CommonController::genRandomString(6);
			$data['verify'] = $verify;
			$data['password'] = D("Member")->encryption($user['username'], $password, $verify);
			$data['phone']=$phone;
			$data['sex']=$sex;
			$id=M('Member')->where("id=" . $user['id'])->save($data);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
			}
		}
	}
	/**
	 *补充信息
	 *普通注册后完善信息
	 */
	public function addinfo(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$nickname=trim($ret['nickname']);
		$sex=intval(trim($ret['sex']));

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();

		if($nickname==''||$uid==''||$sex==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(!$user){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$data['nickname']=$nickname;
			$data['sex']=$sex;
			$id=M('Member')->where("id=" . $user['id'])->save($data);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
			}
		}
	}
	/**
	 * 登陆
	 * @param string|int $identifier 用户ID,或者用户名
	 * @param string $password 用户密码，不能为空
	 * @param int $autotype 是否记住用户自动登录
	 * @return array|bool 成功返回true，否则返回false
	 */
	public function loginHome($identifier, $password, $autotype = 0) {
		if (empty($identifier) || empty($password)) {
			return false;
		}
		$user = D("member")->getLocalAdminUser($identifier, $password);
		if (!$user) {
			//$this->recordLoginAdmin($identifier, $password, 0, "帐号密码错误");
			return false;
		}
		//判断帐号状态
		if ($user['status'] == 0) {
			//记录登陆日志
			// $this->recordLoginAdmin($identifier, $password, 0, "帐号被禁止");
			return false;
		}
		//设置用户名
		M("member")->where(array("id" => $user['id']))->save(array(
				"lastlogin_time" => time(),
				"login_num" => $user["login_num"] + 1,
				"lastlogin_ip" => get_client_ip()
		));
		return $user;
	}
	/**
	 * 获取会员的基本信息
	 */
	public function ucenter(){
		//$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
    $ret = file_get_contents('php://input');
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();

		if($uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$dataset['uid'] = $user['id'];
			$dataset['username'] = $user['username'];
			$dataset['realname'] = $user['realname'];
			$dataset['idcard'] = $user['idcard'];
			$dataset['head'] = $user['head'];
			$dataset['nickname'] = $user['nickname'];
			$dataset['phone'] = $user['phone'];
			$dataset['sex'] = $user['sex'];
			$dataset['birthday'] = $user['birthday'];
			$dataset['hometown'] = $user['hometown'];
			$dataset['area'] = $user['area'];
			$dataset['education'] = $user['education'];
			$dataset['school'] = $user['school'];
			$dataset['zodiac'] = $user['zodiac'];
			$dataset['constellation'] = $user['constellation'];
			$dataset['bloodtype'] = $user['bloodtype'];
			$dataset['info'] = $user['info'];
			$dataset['characteristic'] = $user['characteristic'];
			$dataset['hobby'] = $user['hobby'];
			$dataset['alipay_status'] = $user['alipay_status'];
			if($dataset['alipay_status']==1){
				$alipayaccount=M('alipayaccount')->where(array('uid'=>$uid))->field("realname,alipayaccount")->find();
				$dataset['alipayaccount'] = $alipayaccount;
			}


			$realname_status=$user['realname_status'];
			$apply=M('realname_apply')->where(array('uid'=>$uid))->find();
			if(intval($apply['status'])===1){
				$realname_status=-1;
			}
      if(intval($apply['status'])===2) {
        $dataset['alipayaccount'] = $apply['alipayaccount'];
      }
			$dataset['realname_status'] = $realname_status;
			$houseowner_status=$user['houseowner_status'];
			$apply=M('houserowner_apply')->where(array('uid'=>$uid))->find();
			if(intval($apply['status'])===1){
				$houseowner_status=-1;
			}
			$dataset['houseowner_status'] = $houseowner_status;
			$dataset['rongyun_token']=$user['rongyun_token'];
			$account=M('account')->where(array('uid'=>$uid))->find();
			$dataset['usemoney'] = !empty($account['usemoney'])?$account['usemoney']:0.00;
			$dataset['waitmoney'] = !empty($account['waitmoney'])?$account['waitmoney']:0.00;

      //Start edit by meroc@20161022
			$dataset['point'] = $account['point'];
      $todayStart = strtotime(date('Y-m-d'));
      $todayEnd = $todayStart + 3600 * 24;
      $signDays = M('memberSignLog')
        ->where(array(
            'uid' => $uid,
            'time' => array('between', array($todayStart, $todayEnd))
        ))
        ->getField('days'); 
      $dataset['sign_today'] = $signDays ? $signDays : 0;
			$attention=M('attention')->where(array('fuid'=>$uid))->count();
			$dataset['attention'] = !empty($attention)?$attention:0;
			$fans=M('attention')->where(array('tuid'=>$uid))->count();
			$dataset['fans'] = !empty($fans)?$fans:0;
			exit(json_encode(array('code' => 200, 'msg' => "获取数据成功", 'data' =>$dataset)));
		}
	}
	/**
	 * 获取会员的基本信息
	 */
	public function get_userinfo(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
		$tuid = intval(trim($ret['tuid']));

		$user=M('Member')->where(array('id'=>$uid))->find();
		$tuser=M('Member')->where(array('id'=>$tuid))->find();

		if($uid==''||$tuid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(empty($tuser)){
			exit(json_encode(array('code'=>-200,'msg'=>"The TUser is not exist!")));
		}else{
			$num=M('view')->where('fuid=' . $uid . " and tuid=" . $tuid)->count();
			$todaynum=M('view')->where('day(inputtime) = day(NOW()) and month(inputtime) = month(NOW()) and year(inputtime)=year(now()) and fuid=' . $uid . " and tuid=" . $tuid)->count();
			if($num==0){
				M('Member')->where('id=' . $tuid)->setInc("viewnum");
				if($todaynum==0){
					M('Member')->where('id=' . $tuid)->setInc("todayviewnum");
				}
				M('view')->add(array(
						'fuid'=>$uid,
						'tuid'=>$tuid,
						'inputtime'=>time()
				));
			}
			$dataset['uid'] = $tuser['id'];
			$dataset['username'] = $tuser['username'];
			$dataset['realname'] = $tuser['realname'];
			$dataset['head'] = $tuser['head'];
			$dataset['nickname'] = $tuser['nickname'];
			$dataset['phone'] = $tuser['phone'];
			$dataset['sex'] = $tuser['sex'];
			$dataset['birthday'] = $tuser['birthday'];
			$dataset['hometown'] = $tuser['hometown'];
			$dataset['area'] = $tuser['area'];
			$dataset['education'] = $tuser['education'];
			$dataset['school'] = $tuser['school'];
			$dataset['zodiac'] = $tuser['zodiac'];
			$dataset['constellation'] = $tuser['constellation'];
			$dataset['bloodtype'] = $tuser['bloodtype'];
			$dataset['info'] = $tuser['info'];
			$dataset['characteristic'] = $tuser['characteristic'];
			$dataset['hobby'] = $tuser['hobby'];
			$realname_status=$tuser['realname_status'];
			$apply=M('realname_apply')->where(array('uid'=>$tuid))->find();
			if($apply['status']==1){
				$realname_status=-1;
			}
			$dataset['realname_status'] = $realname_status;
			$houseowner_status=$tuser['houseowner_status'];
			$apply=M('houserowner_apply')->where(array('uid'=>$tuid))->find();
			if($apply['status']==1){
				$houseowner_status=-1;
			}
			$dataset['houseowner_status'] = $houseowner_status;
			$dataset['rongyun_token']=$tuser['rongyun_token'];
			$usemoney=M('account')->where(array('uid'=>$tuid))->getField("usemoney");
			$dataset['usemoney'] = !empty($usemoney)?$usemoney:0.00;
			$attention=M('attention')->where(array('fuid'=>$tuid))->count();
			$dataset['attention'] = !empty($attention)?$attention:0;
			$fans=M('attention')->where(array('tuid'=>$tuid))->count();
			$dataset['fans'] = !empty($fans)?$fans:0;
			$attention=M('attention')->where(array('fuid'=>$uid,'tuid'=>$tuid))->find();
			$dataset['isattention'] = !empty($attention)?1:0;
			exit(json_encode(array('code' => 200, 'msg' => "获取数据成功", 'data' =>$dataset)));
		}
	}
	/**
	 * 修改绑定手机号码
	 */
	public function changephone(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$phone=trim($ret['phone']);
		$telverify = trim($ret['telverify']);

		$verifyset = M('verify')->where('phone=' . $phone)->find();
		$time = time() - $verifyset['expiretime'];
		if ($time > 0) {
			$verify = "";
			M('verify')->where('phone=' . $phone)->save(array(
					'status' => 1
			));
		} else {
			$verify = $verifyset['verify'];
			M('verify')->where('phone=' . $phone)->save(array(
					'status' => 1
			));
		}

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();

		if($phone==''||$uid==''||$telverify==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif (strtolower($telverify) != strtolower($verify)) {
			exit(json_encode(array('code' => -200, 'msg' => "验证码错误")));
		}elseif(!$user){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(!check_phone($phone)){
			exit(json_encode(array('code'=>-200,'msg'=>"手机号已经被使用!")));
		}else{
			$data['phone']=$phone;
			$id=M('Member')->where("id=" . $user['id'])->save($data);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
			}
		}
	}
	/**
	 * 会员完善资料
	 */
	public function change_info(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
		$filed=trim($ret['filed']);
		$value=trim($ret['value']);

		$where['id']=$uid;
		$user=M('Member')->where($where)->field('id')->find();
		if($uid==''||$filed==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$id=M('member')->where(array('id'=>$uid))->setField($filed,$value);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"修改成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"修改失败")));
			}
		}
	}
	/**
	 *会员完善资料(一次性提交)
	 */
	public function change_info_once(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
		$updatedata=$ret['updatedata'];

		$where['id']=$uid;
		$user=M('Member')->where($where)->field('id')->find();
		if($uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($updatedata)){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$id=M('member')->where(array('id'=>$uid))->save($updatedata);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"修改成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"修改失败")));
			}
		}
	}
	/**
	 *会员绑定支付宝账号
	 */
	public function bindalipay(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$realname=trim($ret['realname']);
		$alipayaccount=trim($ret['alipayaccount']);

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		if($uid==''||$realname==''||$alipayaccount==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}elseif($result['alipay_status']==1){
			exit(json_encode(array('code'=>-200,'msg'=>"用户已经绑定支付宝账号")));
		}else{
			$id=M('alipayaccount')->add(array(
					'uid'=>$uid,
					'realname'=>$realname,
					'alipayaccount'=>$alipayaccount,
					'inputtime'=>time()
			));
			if($id){
				M('member')->where(array('id'=>$uid))->setField("alipay_status",1);
				exit(json_encode(array('code'=>200,'msg'=>"绑定成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"绑定失败")));
			}
		}
	}
	/**
	 *会员实名认证
	 */
	public function realname(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$realname=trim($ret['realname']);
		$idcard=trim($ret['idcard']);
		$idcard_front=trim($ret['idcard_front']);
		$idcard_back=trim($ret['idcard_back']);
		$alipayaccount=trim($ret['alipayaccount']);


		$user=M('Member')->where(array('id'=>$uid))->find();
		$apply=M('realname_apply')->where(array('uid'=>$uid))->find();

		if($uid==''||$realname==''||$idcard==''||$idcard_front==''||$idcard_back==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}elseif($user['realname_status']==1){
			exit(json_encode(array('code'=>-200,'msg'=>"用户已经实名认证")));
		}elseif(!empty($apply)&&$apply['status']==1){
			exit(json_encode(array('code'=>-200,'msg'=>"正在审核中")));
		}elseif(!funccard($idcard)){
			exit(json_encode(array('code'=>-200,'msg'=>"身份证号码格式错误")));
		}elseif(!check_idcard($idcard)){
			exit(json_encode(array('code'=>-200,'msg'=>"身份证号码已被使用")));
		}else{
			$id=M('realname_apply')->add(array(
					'uid'=>$uid,
					'realname'=>$realname,
					'idcard'=>$idcard,
					'idcard_front'=>$idcard_front,
					'idcard_back'=>$idcard_back,
					'alipayaccount'=>$alipayaccount,
					'inputtime'=>time()
			));
      M('alipayaccount')->add(array(
        'realname' => $realname,
        'uid' => $uid,
        'alipayaccount' => $alipayaccount,
        'idcard' => $idcard,
        'inputtime' => time()
      ));
			if($id){
				UtilController::addmessage($uid,"申请实名认证","申请认证成功，等待审核！","申请认证成功，等待审核！","applyrealname",$uid);
				exit(json_encode(array('code'=>200,'msg'=>"申请成功")));
			}else{
				UtilController::addmessage($uid,"申请实名认证","申请认证失败！","申请认证成功，等待审核！","applyrealname",$uid);
				exit(json_encode(array('code'=>-200,'msg'=>"申请失败")));
			}
		}
	}
	/**
	 *会员房东认证
	 */
	public function houseowner(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$realname=trim($ret['realname']);
		$alipayaccount=trim($ret['alipayaccount']);
		$housename=trim($ret['housename']);
		$address=trim($ret['address']);
		$thumb=trim($ret['thumb']);

		$user=M('Member')->where(array('id'=>$uid))->find();
		$apply=M('houseowner_apply')->where(array('uid'=>$uid))->find();

		if($uid==''||$realname==''||$alipayaccount==''||$housename==''||$address==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}elseif($user['houseowner_status']==1){
			exit(json_encode(array('code'=>-200,'msg'=>"用户已经职场认证")));
		}elseif(!empty($apply)&&$apply['status']==1){
			exit(json_encode(array('code'=>-200,'msg'=>"正在审核中")));
		}else{
			$id=M('houseowner_apply')->add(array(
					'uid'=>$uid,
					'housename'=>$housename,
					'alipayaccount'=>$alipayaccount,
					'realname'=>$realname,
					'address'=>$address,
					'thumb'=>$thumb,
					'inputtime'=>time()
			));
			if($id){
				UtilController::addmessage($uid,"申请房东认证","申请房东认证，等待审核！","申请房东认证，等待审核！","applyhouseowner",$uid);
				exit(json_encode(array('code'=>200,'msg'=>"申请成功")));
			}else{
				UtilController::addmessage($uid,"申请房东认证","申请认证失败！","申请认证失败！","applyhouseowner",$uid);
				exit(json_encode(array('code'=>-200,'msg'=>"申请失败")));
			}
		}
	}
	/**
	 *设置密码
	 */
	public function setpassword(){
		//$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
    $ret = file_get_contents("php://input");
		$ret=json_decode($ret,true);
		$telverify=trim($ret['telverify']);
		$new_password=trim($ret['new_password']);
		$phone=trim($ret['phone']);

		$where['phone']=$phone;
		$user=M('Member')->where($where)->find();

		$verifyset=M('verify')->where('phone=' . $phone)->find();
		$time=time()-$verifyset['expiretime'];
		if($time>0){
			$verify="";
			M('verify')->where('phone=' . $phone)->save(array(
					'status'=>1
			));
		}else{
			$verify=$verifyset['verify'];
			M('verify')->where('phone=' . $phone)->save(array(
					'status'=>1
			));
		}
		if($phone==''||$new_password==''||$telverify==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(strtolower($telverify)!=strtolower($verify)){
			exit(json_encode(array('code'=>-200,'msg'=>"验证码错误")));
		}elseif(!$user){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$verify = CommonController::genRandomString(6);
			$data['verify'] = $verify;
			$data['password'] = D("Member")->encryption($user['username'], $new_password, $verify);
			$id=M('Member')->where("id=" . $user['id'])->save($data);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"重置密码成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"重置密码失败")));
			}
		}
	}
	/**
	 *修改密码
	 */
	public function changepassword(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$old_password=trim($ret['old_password']);
		$new_password=trim($ret['new_password']);
		$uid = intval(trim($ret['uid']));

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();

		$verify = CommonController::genRandomString(6);
		$old_password1 = D("Member")->encryption($user['username'], $old_password, $user['verify']);

		if($uid==''||$old_password==''||$new_password==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif($user['password']!=$old_password1){
			exit(json_encode(array('code'=>-200,'msg'=>"旧密码错误")));
		}else{
			$data['verify'] = $verify;
			$data['password'] = D("Member")->encryption($user['username'], $new_password, $verify);
			$id=M('Member')->where($where)->save($data);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"修改成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"修改失败")));
			}
		}
	}
	/**
	 *忘记密码
	 */
	public function findpassword(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$telverify=trim($ret['telverify']);
		$new_password=trim($ret['new_password']);
		$phone=trim($ret['phone']);

		$where['phone']=$phone;
		$user=M('Member')->where($where)->find();

		$verifyset=M('verify')->where('phone=' . $phone)->find();
		$time=time()-$verifyset['expiretime'];
		if($time>0){
			$verify="";
			M('verify')->where('phone=' . $phone)->save(array(
					'status'=>1
			));
		}else{
			$verify=$verifyset['verify'];
			M('verify')->where('phone=' . $phone)->save(array(
					'status'=>1
			));
		}
		if($phone==''||$new_password==''||$telverify==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(strtolower($telverify)!=strtolower($verify)){
			exit(json_encode(array('code'=>-200,'msg'=>"验证码错误")));
		}elseif(!$user){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$verify = CommonController::genRandomString(6);
			$data['verify'] = $verify;
			$data['password'] = D("Member")->encryption($user['username'], $new_password, $verify);
			$id=M('Member')->where("id=" . $user['id'])->save($data);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"重置密码成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"重置密码失败")));
			}
		}
	}
	/**
	 *签到
	 */
  /*
	public function sign() {
		$ret = $GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
		$user=M('Member')->where(array('id'=>$uid))->find();
		if ($uid == '') {
			exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
		} elseif(!$user){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		} else{
			$hasSign=M('signlog')->where(array('uid'=>$uid))->find();
			$count=!empty($hasSign['continuesign'])?$hasSign['continuesign']:1;
			$lastintegral=!empty($hasSign['integral'])?$hasSign['integral']:0;
			$totalsign=!empty($hasSign['totalsign'])?$hasSign['totalsign']:0;
			if($hasSign){
				$lastSignDay=$hasSign['lastsigntime'];
				$lastSign=date('Y-m-d',$lastSignDay);
				$today=date('Y-m-d',time());
				if($lastSign==$today){
					exit(json_encode(array('code'=>-200,'msg'=>'今天已签到,您已连续签到'.$count.'天!')));
				}
				$residueHour=24+24-date('H',$lastSignDay); //有效的签到时间  (签到当天剩余的小时+1天的时间)
				$formatHour=strtotime(date('Y-m-d H',$lastSignDay).':00:00');//签到当天 2014-12-07 18:00:00
				$lastSignDate=strtotime("+{$residueHour}hour",$formatHour);//在2014-12-07 18:00:00 基础上+ 有效的签到时间
				if(time()>$lastSignDate){ //当前时间 >  上一次签到时间
					$count=1;
				}else{
					$count=$count+1;
				}
				//$signintegral=getsignintegral($lastintegral,$count);
				$signintegral=5;
				$sign=M('signlog')->where(array('uid'=>$uid))->save(array(
						'continuesign'=>$count,
						'integral'=>$signintegral,
						'content'=>'签到+'.$signintegral.'分',
						'status'=>1,
						'totalsign'=>$totalsign+1,
						'lastsigntime'=>time()
				));
			}else{
				$signintegral=getsignintegral($lastintegral,$count);
				$sign=M('signlog')->add(array(
						'uid'=>$uid,
						'continuesign'=>$count,
						'integral'=>$signintegral,
						'content'=>'签到+'.$signintegral.'分',
						'status'=>1,
						'totalsign'=>1,
						'lastsigntime'=>time(),
						'inputtime'=>time()
				));
			}

			if($sign){
				self::update_integral($uid,$signintegral,1,'签到+'.$signintegral.'分','sign');
				if($count>0){
					exit(json_encode(array('code'=>200,'msg'=>'签到成功,您已连续签到'.$count.'天!')));
				}else{
					exit(json_encode(array('code'=>200,'msg'=>'签到成功')));
				}
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>'签到失败,请稍后重试！')));
			}
		}
	}
  */

	/**
	 *改进建议
	 */
	public function feedback(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
		$title=trim($ret['title']);
		$content=trim($ret['content']);

		$where['id']=$uid;
		$user=M('Member')->where($where)->field('id')->find();
		if($uid==''||$title==''||$content==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$id=M('feedback')->add(array(
					'uid'=>$uid,
					'title'=>$title,
					'content'=>$content,
					'inputtime'=>time()
			));
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
			}
		}
	}
	/**
	 *钱包充值--积分充值
	 */
	public function recharge_integral(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
		$money=floatval(trim($ret['money']));

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();
		$integral=M('integral')->where(array('uid'=>$uid))->getField("useintegral");
		if($uid==''||$money==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif($integral<$money*100){
			exit(json_encode(array('code'=>-200,'msg'=>"可用积分不足！")));
		}else{
			$account=M('account')->where(array('uid'=>$uid))->find();

			$mid=M('account')->where(array('uid'=>$uid))->save(array(
					'recharemoney'=>$account['recharemoney']+floatval($money),
					'total'=>$account['total']+floatval($money),
					'usemoney'=>$account['usemoney']+floatval($money),
			));
			if($mid){
				M('recharge')->add(array(
						'uid'=>$uid,
						'type'=>'integral',
						'money'=>$money,
						'status'=>1,
						'addip'=>get_client_ip(),
						'addtime'=>time()
				));
				M('account_log')->add(array(
						'uid'=>$uid,
						'type'=>'integral_recharge',
						'money'=>$money,
						'total'=>$account['total']+floatval($money),
						'usemoney'=>$account['usemoney']+floatval($money),
						'nousemoney'=>$account['nousemoney'],
						'status'=>1,
						'dcflag'=>1,
						'remark'=>'使用积分充值'.$money.'元',
						'addip'=>get_client_ip(),
						'addtime'=>time()
				));
				self::update_integral($uid,$money*100,2,'使用积分充值'.$money.'元','integral_recharge');
				exit(json_encode(array('code'=>200,'msg'=>"充值成功")));
			}else{
				M('recharge')->add(array(
						'uid'=>$uid,
						'type'=>'integral',
						'money'=>$money,
						'status'=>0,
						'addip'=>get_client_ip(),
						'addtime'=>time()
				));
				exit(json_encode(array('code'=>-202,'msg'=>"充值失败")));
			}
		}
	}
	/**
	 *钱包充值--在线充值
	 */
	public function recharge_online(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
		$money=floatval(trim($ret['money']));
		$paytype=intval(trim($ret['paytype']));

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();
		if($uid==''||$money==''||$paytype==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif($money<200){
			exit(json_encode(array('code'=>-200,'msg'=>"充值最小金额为200元")));
		}elseif(fmod($money,100)!=0){
			exit(json_encode(array('code'=>-200,'msg'=>"充值的递增金额必须为100的倍数")));
		}else{
			$channel="";
			$paytypevalue="";
			$orderid="rc".date("YmdHis", time()) . rand(100, 999);
			switch ($paytype) {
				case '1':
					# code...
					$paytypevalue="alipay";
					$channel='alipay';
					break;
				case '2':
					# code...
					$paytypevalue="weixin";
					$channel='wx';
					break;
			}
			$mid=M('recharge')->add(array(
					'uid'=>$uid,
					'title'=>"钱包充值--在线充值",
					'orderid' => $orderid,
					'type'=>$paytypevalue,
					'money'=>$money,
					'status'=>1,
					'channel'=>$channel,
					'addip'=>get_client_ip(),
					'addtime'=>time()
			));
			if($mid){
				$title="钱包充值";
				$body="钱包在线充值".$money;
				$PingPay=A("Api/PingPay");
				$pingpp=$PingPay->pingpp($orderid,$title,$body,$money,$channel);
				exit($pingpp);
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"充值失败")));
			}

		}
	}
	/**
	 *我的收藏
	 */
	public function mycollect(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$p=intval(trim($ret['p']));
		$num=intval(trim($ret['num']));
		$uid=intval(trim($ret['uid']));
		$type=trim($ret['type']);

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();

		if($uid==''||$p==''||$num==''||$type==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$data=array();
			$list=array();
			switch ($type) {
				case "note":
					$count=M('collect a')
							->join("left join zz_note b on a.value=b.id")
							->join("left join zz_member c on b.uid=c.id")
							->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'note'))
							->count();
					$list=M('collect a')
							->join("left join zz_note b on a.value=b.id")
							->join("left join zz_member c on b.uid=c.id")
							->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'note'))
							->field('a.id,b.id as nid,b.title,b.description,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.hit,b.begintime,b.endtime,b.uid,c.nickname,c.head,c.rongyun_token,a.inputtime')
							->page($p,$num)
							->order(array('a.inputtime'=>'desc'))
							->select();
					foreach ($list as $key => $value)
					{
						$reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'note','value'=>$value['nid']))->count();
						$list[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

						$collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['nid']))->count();
						$list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
					}
					$data=array('num'=>$count,'data'=>$list);
					break;
				case "house":
					$count=M('collect a')
							->join("left join zz_hostel b on a.value=b.id")
							->join("left join zz_member c on b.uid=c.id")
							->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'hostel'))
							->count();
					$list=M('collect a')
							->join("left join zz_hostel b on a.value=b.id")
							->join("left join zz_member c on b.uid=c.id")
							->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'hostel'))
							->field('a.id,b.id as hid,b.title,b.thumb,b.money,b.area,b.city,b.address,b.lat,b.lng,b.hit,b.uid,c.nickname,c.head,c.rongyun_token,a.inputtime')
							->order(array('a.inputtime'=>'desc'))
							->select();
					foreach ($list as $key => $value)
					{
						$reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'hostel','value'=>$value['hid']))->count();
						$list[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

						$collectnum=M('collect')->where(array('varname'=>'hostel','value'=>$value['hid']))->count();
						$list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
					}
					$data=array('num'=>$count,'data'=>$list);
					break;
				case "party":
					$count=M('collect a')
							->join("left join zz_activity b on a.value=b.id")
							->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'party'))
							->count();
					$list=M('collect a')
							->join("left join zz_activity b on a.value=b.id")
							->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'party'))
							->field('a.id,b.id as aid,b.title,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.starttime,b.endtime')
							->order(array('a.inputtime'=>'desc'))
							->select();
					foreach ($list as $key => $value)
					{
						$reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'party','value'=>$value['aid']))->count();
						$list[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

						$collectnum=M('collect')->where(array('varname'=>'party','value'=>$value['aid']))->count();
						$list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;

						$joinnum=M('activity_apply')->where(array('aid'=>$value['aid'],'paystatus'=>1))->sum("num");
						$list[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
					}
					$data=array('num'=>$count,'data'=>$list);
					break;
			}
			if($data){
				exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data'=>$data)));
			}else{
				exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
			}
		}
	}
	/**
	 *我的评论列表
	 */
	public function myreview(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$p=intval(trim($ret['p']));
		$num=intval(trim($ret['num']));

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();
		if($uid==''||$p==''||$num==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$where=array();
			$order=array('a.id'=>'desc');
			$where['a.uid']=$uid;
			$where['a.isdel']=0;
			$where['a.varname'] = array('neq','trip');//
			$count=M("review a")->where($where)->count();
			$list=M("review a")
					->join("left join zz_member b on a.uid=b.id")
					->where($where)
					->order($order)
					->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
					->page($p,$num)->select();
			foreach ($list as $key => $value)
			{
				if($value['varname']=='note'){
					$list[$key]['title']=M('note')->where(array('id'=>$value['value']))->getField("title");
				}else if($value['varname']=='party'){
					$list[$key]['title']=M('activity')->where(array('id'=>$value['value']))->getField("title");
				}else if($value['varname']=='hostel'){
					$list[$key]['title']=M('hostel')->where(array('id'=>$value['value']))->getField("title");
				}else if($value['varname']=='room'){
					$list[$key]['title']=M('room')->where(array('id'=>$value['value']))->getField("title");
				}
			}
			$data=array('num'=>$count,'data'=>$list);
			if($data){
				exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
			}else{
				exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
			}
		}
	}
	/**
	 *更新用户积分
	 * uid 用户id
	 * integral  操作积分
	 * type 1 增 2减
	 * content 积分变更说明
	 */
	public static function update_integral($uid,$integral,$type,$content,$update_type){
		if($type==1){
			M('integral')->where(array('uid'=>$uid))->setInc("useintegral",intval($integral));
			M('integral')->where(array('uid'=>$uid))->setInc("totalintegral",intval($integral));
		}elseif($type==2){
			M('integral')->where(array('uid'=>$uid))->setDec("useintegral",intval($integral));
			M('integral')->where(array('uid'=>$uid))->setInc("payed",intval($integral));
		}

		M('integrallog')->add(array(
				'uid'=>$uid,
				'paytype'=>$type,
				'content'=>$content,
				'integral'=>$integral,
				'varname'=>$update_type,
				'useintegral'=>M('integral')->where(array('uid'=>$uid))->getField('useintegral'),
				'totalintegral'=>M('integral')->where(array('uid'=>$uid))->getField('totalintegral'),
				'inputtime'=>time()
		));
		UtilController::addmessage($uid,$content,$content,$content,'system',$uid);
	}
	/**
	 *我的积分
	 */
	public function get_integrallog(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$p=intval(trim($ret['p']));
		$num=intval(trim($ret['num']));

		if($uid==''||$p==''||$num==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}else{
			$data=M("integrallog")->where(array('uid'=>$uid))->order(array('id'=>"desc"))->field('id,uid,paytype,content,integral,inputtime')->page($p,$num)->select();
			if($data){
				exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data' => $data)));
			}else{
				exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
			}
		}
	}
	public function walletlog(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$p=intval(trim($ret['p']));
		$num=intval(trim($ret['num']));
		$uid=intval(trim($ret['uid']));

		$where['id']=$uid;
		$user=M('Member')->where($where)->find();

		if($uid==''||$p==''||$num==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$data=M("account_log")->where(array('uid'=>$uid))->order(array('id'=>"desc"))->field("id,money,usemoney,waitmoney,total,dcflag,remark,status,addtime")->page($p,$num)->select();
			if($data){
				exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data' => $data)));
			}else{
				exit(json_encode(array('code'=>-201,'msg'=>"无使用记录")));
			}
		}
	}

	/**
	 *房东申请体现
	 */
	public function withdraw(){
		//$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
    $ret = file_get_contents("php://input");
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$alipayaccount=trim($ret['alipayaccount']);
		$realname=trim($ret['realname']);
		$money=floatval(trim($ret['money']));
		$fee=floatval(trim($ret['fee']));

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		$usemoney=M('account')->where(array('uid'=>$uid))->getField("usemoney");

		if($uid==''||$realname==''||$money==''||$alipayaccount==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}elseif($usemoney<$money||empty($usemoney)){
			exit(json_encode(array('code'=>-200,'msg'=>"可用金额不足")));
		}else{
			$id=M('withdraw')->add(array(
					'uid'=>$uid,
					'alipayaccount'=>$alipayaccount,
					'realname'=>$realname,
					'money'=>$money,
					'fee'=>$fee,
					'ip'=>get_client_ip(),
					'inputtime'=>time()
			));
			if($id){
				$account=M('account')->where(array('uid'=>$uid))->find();

				$mid=M('account')->where(array('uid'=>$uid))->save(array(
						'nousemoney'=>$account['nousemoney']+floatval($money),
						'usemoney'=>$account['usemoney']-floatval($money),
				));
				if($mid){
					M('account_log')->add(array(
							'uid'=>$uid,
							'type'=>'applywithdraw',
							'money'=>$money,
							'total'=>$account['total'],
							'usemoney'=>$account['usemoney']-floatval($money),
							'nousemoney'=>$account['nousemoney']+floatval($money),
							'status'=>1,
							'dcflag'=>2,
							'remark'=>'申请提现',
							'addip'=>get_client_ip(),
							'addtime'=>time()
					));
				}
				exit(json_encode(array('code'=>200,'msg'=>"申请成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"申请失败")));
			}
		}
	}
	public function send_position(){
		$ret = $GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
		$lat=floatval(trim($ret['lat']));
		$lng=floatval(trim($ret['lng']));

		$user=M('Member')->where(array('id'=>$uid))->find();
		if($uid==''||$lat==''||$lng==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif (empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$id=M('member')->where(array('id'=>$uid))->save(array(
					'lat'=>$lat,
					'lng'=>$lng
			));
			if($id){
				exit(json_encode(array('code' => 200, 'msg' => "操作成功")));
			} else {
				exit(json_encode(array('code' => -202, 'msg' => "操作失败")));
			}
		}
	}
	/**
	 *附近会员
	 */
	public function get_nearmember(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$lat=floatval(trim($ret['lat']));
		$lng=floatval(trim($ret['lng']));
		$radis=floatval(trim($ret['radis']));

		$User=M('Member')->where(array('id'=>$uid))->find();
		if($uid==''||$lat==''||$lng==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($User)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}else{
			$where=array();
			$where['a.status']=1;
			if(!empty($radis)){
				$radis=5;
			}
			$recoords=getcoords($lat,$lng,$radis);
			$where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
			$where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
			$data=M("member a")
					->where($where)
					->order(array('a.id'=>"desc"))
					->field('a.id as uid,a.username,a.sex,a.nickname,a.head,a.info,a.realname_status,a.houseowner_status,a.lat,a.lng,a.rongyun_token')
					->select();
			$Map=A("Api/Map");
			foreach ($data as $key => $value) {
				# code...
				$attention=M('attention')->where(array('fuid'=>$uid,'tuid'=>$value['uid']))->find();
				$data[$key]['isattention'] = !empty($attention)?1:0;

				$distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
				$data[$key]['distance']=!empty($distance)?$distance:0.00;
			}
			if($data){
				exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
			}
		}
	}

  /**
   *  会员积分记录 
   *  Edit by Meroc@2016-10-20
   */
  public function pointLog() {
    $jsonData = $this->getInputs();
    $uid = $jsonData['uid'];
    $page = $jsonData['p'];
    $num = $jsonData['num'];

    if(empty($uid)) {
      return $this->jsonFailedResponse('uid_required', -200); 
    }
    if(empty($page) || $page <= 0) {
      return $this->jsonFailedResponse('page_required', -200); 
    }
    if(empty($num) || $num <= 0) {
      return $this->jsonFailedResponse('num_required', -200); 
    }

    $pointsLog = M('memberPointLog')
      ->where(array('uid' => $uid))
      ->order('created_at desc')
      ->limit(($page - 1) * $num, $num)
      ->select();
    
    if($pointsLog === false) {
      return $this->jsonFailedResponse('db_err', -202);
    } elseif ($pointsLog === NULL) {
      return $this->jsonFailedResponse(NULL, -201);
    } else {
      return $this->jsonSuccessResponse($pointsLog);
    }
  }

  /**
   * 用户签到.
   * Edit by Meroc@2016-10-20
   */
  public function sign() {
    $jsonData = $this->getInputs();
    $uid = $jsonData['uid'];
          
    if(!$uid) {
      return $this->jsonFailedResponse('uid_required', -200);
    }

    $todayStart = strtotime(date('Y-m-d'));
    $todayEnd = $todayStart + 3600 * 24;
     
    //判断今日是否已签到
    $signed = M('memberSignLog')
      ->where(array(
          'uid' => $uid,
          'time' => array('between', array($todayStart, $todayEnd))
      ))
      ->find(); 

    if(!empty($signed)) {
      return $this->jsonFailedResponse('signed', -200); 
    }

    $yesterdayStart = $todayStart - 3600 * 24;

    //判断昨天是否签到
    $lastSigned = M('memberSignLog')
      ->where(array(
        'uid' => $uid,
        'time' => array('between', array($yesterdayStart, $todayStart))
      ))
      ->find();

    M('memberSignLog')->startTrans();

    $newSign = NULL;
    if(empty($lastSigned)) {
      $newSign = array(
        'uid' => $uid,
        'time' => time(),
        'days' => 1
      );
    } else {
      $days = $lastSigned['days'] + 1;
      $newSign = array(
        'uid' => $uid,
        'time' => time(),
        'days' => $days
      );
    }

    //记录签到
    if(M('memberSignLog')->add($newSign)) {
      $Point = A('Point');
      $res = $Point->addPoint($uid, 100, '签到送积分', 1, 0);
      if($res) {//赠送积分.
        M('memberSignLog')->commit();
        return $this->jsonSuccessResponse(array(
          'days' => $newSign['days'],
          'points' => 100,
          'next_points' => 100
        ));  
      } else {
        M('memberSignLog')->rollback();
        return $this->jsonFailedResponse('signed_fail', -200);
      }
    } else {
      M('memberSignLog')->rollback();
      return $this->jsonFailedResponse('db_err', -202); 
    }
  }

  /**
   * 签到记录
   * Edit by Meroc@2016-10-20
   */ 
  public function signLog() {
    $data = $this->getInputs(); 
    $uid = $data['uid'];
    $page = $data['p'];
    $num = $data['num'];
    if(!$uid) {
      return $this->jsonFailedResponse('uid_required', -200);
    }
    if(!$page || $page <=0) {
      return $this->jsonFailedResponse('page_required', -200);
    }
    if(!$num || $num <= 0) {
      return $this->jsonFailedResponse('num_required', -200);
    }
    
    $signLogs = M('memberSignLog')
      ->where(array('uid' => $uid))
      ->order('time desc')
      ->limit(($page - 1) * $num, $num)
      ->select();

    if($signLogs === false) {
      return $this->jsonFailedResponse('db_err', -202); 
    } elseif ($signLogs === NULL) {
      return $this->jsonFailedResponse(NULL, -201); 
    } else {
      return $this->jsonSuccessResponse($signLogs);
    }
  }

  /**
   * 内部调用，增加积分.
   * Edit by Meroc@2016-10-20
   */
  public function addPoints($uid, $points, $remark) {
    $point = M('account')
      ->where(array('uid' => $uid))
      ->getField('point');
    $newPoint = array(
      'uid' => $uid,
      'points' => $points,
      'remark' => $remark,
      'type' => 2,
      'type_name' => $remark,
      'time' => time(),
      'total_point' => $point + $points
    );
    if(M('memberPointLog')->add($newPoint)) {
      $res = M('account')
        ->where(array('uid' => $uid))
        ->setField('point', $point + $points);
      return $res;
    } else {
      return false; 
    }
  }

  /**
   * 积分兑换优惠券列表
   * Edit by Meroc@2016-10-20
   */
  public function exchangeVoucherList() {
    $jsonData = $this->getInputs(); 
    $uid = $jsonData['uid'];

    if(!$uid) {
      return $this->jsonFailedResponse('uid_required', -200);
    }

    $account = M('account')
      ->where(array('id' => $uid))
      ->find();

    if(empty($account)) {
      return $this->jsonFailedResponse('member_account_not_found', -200);
    }

    $vouchers = M('vouchers')
      ->where(array(
        'validity_endtime' => array('gt', time()),
        'exchange_integral' => array('egt', 0)
      ))
      ->select();

    if($vouchers === false) {
      return $this->jsonFailedResponse('db_err', -202); 
    } elseif($vouchers === NULL) {
      return $this->jsonFailedResponse(NULL, -201); 
    } else {
      return $this->jsonSuccessResponse(
        array(
          'member_point' => $account['point'], 
          'vouchers' => $vouchers
        )
      ); 
    }
  }

  /**
   * 积分兑换优惠券
   * Edit by Meroc@2016-10-20
   */
  public function exchangeIntegralVoucher() {
    $jsonData = $this->getInputs(); 
    $uid = $jsonData['uid'];
    $vid = $jsonData['vid'];
    if(!$uid) {
      return $this->jsonFailedResponse('uid_required', -200); 
    }
    if(!$vid) {
      return $this->jsonFailedResponse('vid_required', -200);
    }
    $account = M('account')->where(array('uid' => $uid))->find();
    if($account === false) {
      return $this->jsonFailedResponse('db_err', -202);
    } elseif($account === NULL) {
      return $this->jsonFailedResponse('member_not_found', -200); 
    }
    $voucher = M('vouchers')
      ->where(array(
        'id' => $vid,
        'exchange_integral' => array('egt', 0),
        'validity_endtime' => array('gt', time())
      ))
      ->find();
    if($voucher === false) {
      return $this->jsonFailedResponse('db_err', -202);
    } elseif($voucher === NULL) {
      return $this->jsonFailedResponse('voucher_invalid', -200); 
    }

    if(intval($account['point']) < intval($voucher['exchange_integral'])) {
      return $this->jsonFailedResponse('point_deficiency', -200); 
    } else {
      $Voucher = A('Api/Voucher');

      /*
       * 事务开始
       */
      M('vouchers')->startTrans();
      $res = $Voucher->generateVoucherToMember($uid, $vid, '积分兑换');
      if($res) {
        //优惠券发放成功，扣除积分。
        $Point = A('Api/Point');
        $newAccount = $Point->minuPoint($uid, $voucher['exchange_integral'], '兑换优惠券', 1, $res);
        if($newAccount) {
          M('vouchers')->commit();

          return $this->jsonSuccessResponse(
            array(
              'old_point' => $account['point'], 
              'new_point' => $account['point'] - $voucher['exchange_integral'],
              'consume' => $voucher['exchange_integral']
            )
          );
        } else {
          /*
           * 事务回滚
           */
          M('vouchers')->rollback();
          return $this->jsonFailedResponse('error', -200); 
        }
      } elseif ($res === false) {
      /*
       * 事务回滚
       */
        M('vouchers')->rollback();
        return $this->jsonFailedResponse('expected_err', -200);
      } elseif ($res == NULL) {
      /*
       * 事务回滚
       */
        M('vouchers')->rollback();
        return $this->jsonFailedResponse('db_err', -202);
      }
    }
  }

  /**
   * 我的优惠券列表
   * Edit by Meroc@2016-10-20
   */
  public function myVoucherList() {
    $jsonData = $this->getInputs();
    $uid = $jsonData['uid'];
    $p = $jsonData['p'];
    $num = $jsonData['num'];
    $status = $jsonData['status'];

    if(!$uid) {
      return $this->jsonFailedResponse('uid_empty', -200); 
    } elseif(!$p) {
      $p = 1;
    } elseif(!$num) {
      $num = 10;
    } elseif(!$status) {
      $status = 1; 
    }

    $member = M('member')->where(array('id' => $uid))->find();
    if($member == false) {
      return $this->jsonFailedResponse('db_err', -202);
    } elseif ($member == NULL) {
      return $this->jsonFailedResponse('user_not_found', -200);
    }

    $where = array(
      'uid' => $member['id'],
      'validity_endtime' => array('gt', time())
    );

    switch($status) {
      case 1:
        $where['used'] = 0;
        $where['validity_endtime'] = array('gt', time());
        break; 
      case 2:
        $where['used'] = 1;
        $where['validity_endtime'] = array('gt', time());
        break;
      case 3:
        $where['validity_endtime'] = array('lt', time());
        $where['used'] = 0;
        break;
    }


    $vouchers = M('memberVouchers')
      ->where($where)
      ->limit(($p - 1) * $num, $num)
      ->order('id desc')
      ->select();

    if($vouchers) {
      return $this->jsonSuccessResponse($vouchers); 
    } elseif($vouchers == NULL) {
      return $this->jsonFailedResponse(NULL, -201);
    } elseif($vouchers == false) {
      return $this->jsonFailedResponse('db_err', -202);
    }
  }

  /*
   * 获取用户支付宝账号信息(用户实名认证通过后可获得)
   */
  public function get_alipayaccount() {
    $inputs = json_decode(file_get_contents("php://input"), true);

    if(!$inputs) {
      $this->jsonFailedResponse("Request parameter is null", -200);
    } 
    $uid = $inputs['uid'];

    $status = M('realname_apply')->where(array('uid' => $uid))->getField('status');
    if($status != 2) {
      return $this->jsonFailedResponse('not pass', -200); 
    }
    
    $account = M('alipayaccount')->where(array('uid' => $uid))->find();
    if($account == false) {
      $this->jsonFailedResponse('db error.', -202); 
    } elseif ($account == null) {
      $this->jsonFailedResponse('empty data.', -201);
    } else {
      $this->jsonSuccessResponse($account); 
    }
  }

  /*
   * 用户推荐名宿
   */
  public function recommend_hotel() {
    $inputs = json_decode(file_get_contents("php://input"), true); 
    if(!$inputs) {
      return $this->jsonFailedResponse('empty inputs.', -200); 
    }

    $data = array(
      'uid' => $inputs['uid'],
      'hotel_name' => $inputs['hotel_name'],
      'province' => $inputs['province'],
      'city' => $inputs['city'],
      'address' => $inputs['address'],
      'low_price' => $inputs['low_price'],
      'high_price' => $inputs['high_price'],
      'contact' => $inputs['contact'],
      'phone' => $inputs['phone'],
      'img_list' => json_encode($inputs['img_list']),
      'description' => $inputs['description']
    );

    foreach($data as $key => $value) {
      if($value == null || strlen($value) == 0) {
        return $this->jsonFailedResponse($key . ' empty.', -200); 
      } 
    }

    $res = M('recommend_hotel')->add($data);

    if($res == false) {
      return $this->jsonFailedResponse('db err.', -202); 
    } else {
      return $this->jsonSuccessResponse(NULL); 
    }
  }

  public function get_last_realname_apply() {
    $inputs = json_decode(file_get_contents("php://input"), true);
    if(empty($inputs)) {
      return $this->jsonFailedResponse('empty inputs.', -200); 
    }
    $apply = M('realname_apply')->where(array('uid' => $inputs['uid']))->order('id desc')->select();
    if($apply == false) {
      return $this->jsonFailedResponse('db err.', -202); 
    } elseif($apply == null) {
      return $this->jsonFailedResponse('empty data', -201); 
    } else {
      return $this->jsonSuccessResponse($apply[0]);
    }
  }

  public function check_register() {
    $inputs = $this->getInputs(); 
    $member = M('member')->where(array('phone' => $inputs['phone']))->find();
    if(!$member) {
      return $this->jsonFailedResponse('not found', -200); 
    } else {
      return $this->jsonSuccessResponse('found'); 
    }
  }
}
