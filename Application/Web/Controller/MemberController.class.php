<?php

namespace Web\Controller;

use Web\Common\CommonController;

class MemberController extends CommonController {
	//首页
	public function index(){
		if (!session('uid')) {
            $returnurl=urlencode($_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
            $this->error('请先登录！',U('Web/Member/login')."?returnurl=".$returnurl);
        } else {
            $uid=$this->getSessionId();
            $data=$this->userInfo($uid);
            $this->assign('data',$data['data']);
            $this->assign('follow',$data['follow']);
            $this->assign('fans',$data['fans']);
            $this->display();
		}
		
	}
    public function userInfo($uid){
        $data=M('member')->where(array('id'=>$uid))->find();
        $this->assign('data',$data);
        $count=M("attention")->where(array('fuid'=>$uid))->count();
        $fans= M("attention")->where(array('tuid'=>$uid))->count();
        $data=array('data'=>$data,'follow'=>$count,'fans'=>$fans);
        return $data;
    }


    /**
     * 会员注册
     * @author yiyouguisu<741459065@qq.com> time|20151219
     * @retrun void
     */
    public function reg() {
        $icode=I('invitecode');
        $this->assign('invitecode',$icode);
        $this->display();
    }

    public function ajax_reg(){
        $telverify = trim($_POST['telverify']);
        $password = trim($_POST['password']);
        $phone = trim($_POST['phone']);

        $resdata=array();
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
        if(empty($password)||empty($telverify)||empty($phone)){
            $resdata['code']=-200;
            $resdata['msg']='请将信息填写完整';
        }elseif (strtolower($telverify) != strtolower($verify)) {
            $resdata['code']=-200;
            $resdata['msg']='验证码错误';
        }elseif(!check_phone($phone)){
            $resdata['code']=-200;
            $resdata['msg']='手机号已被注册';
        }else{
            $data=$_POST;
            $data['group_id']=1;
            $data['username']=$_POST['phone'];
            $data['head']="/default_head.png";
            $data['tuijiancode']=$_POST['invite_code'];
            if($_COOKIE['web_user_openid']){
                $data['user_openid']=$_COOKIE['web_user_openid'];
            }
            $id = D("member")->addUser($data);
            if ($id) {
                cookie("username",$data['username']);
                cookie("userid",$id);
                cookie("groupid",$data['group_id']);
                cookie("tuijiancode",$data['tuijiancode']);
                $resdata=array('code'=>200,'msg'=>'注册成功');
            } else {
                $resdata['code']=-200;
                $resdata['msg']='注册失败';
            }
        }
        $this->ajaxReturn($resdata,'json');
    }
    // 注册成功
    public function regSuccess(){
        $this->display();
    }
    // 注册成功后完善信息
    public function information(){
        if(IS_POST){
            $data['nickname']=$_POST['nickname'];
            $data['sex']=$_POST['sex'];
            $uid=cookie("userid");
            $rel=M('member')->where(array('id'=>$uid))->save($data);
            if($rel){
                if(cookie('tuijiancode')){
                    cookie('tuijiancode',null);
                    $this->success('信息完善成功',U('Web/Member/download'));
                }
                else{
                    session('uid',cookie('userid'));
                    $this->success('信息完善成功',U('Web/Index/Index'));
                }
            }
            else{

            }
        }

        $this->display();
    }
    // 注册成功下载页面
    public function download(){
        $this->display();
    }
    /**
     * 会员登录
     * @author yiyouguisu<741459065@qq.com> time|20151219
     * @retrun void
     */
    public function login() {
        if (session('uid')) {
            $this->redirect('Web/Member/index');
        } else {
            $this->display();
        }
    }

    public function ajax_login(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $autotype = 1;
        $status=$this->loginHome($username, $password, $autotype);
        $data=array();
        if ($status==2) {
            $data['code']=200;
            $data['msg']='登入成功';
        }elseif($status==0) {
            $data['code']=-200;
            $data['msg']='登录失败';
        }elseif($status==1) {
            $data['code']=-200;
            $data['msg']='帐号被禁用,请联系管理员';
        }
        $this->ajaxReturn($data,'json');
    }


    public function wxlogin(){
        if (session('uid')) {
            $this->redirect('Web/Member/index');
        } else {
            $Wxhelp=A('Web/Wxhelp');
            $userinfo = $Wxhelp->GetUserInfo();
            if(empty($userinfo['unionid'])){
                $this->error('授权失败',U('Member/login'));
            }
            cookie("user_unionid",$userinfo['unionid'],C('AUTO_TIME_LOGIN'));
            $user=M('Member')->where(array('username'=>$userinfo['unionid']))->find();
            if (!$user) {
                $this->error('登录失败',U('Member/login'));
            }elseif ($user['status'] == 0) {
                $this->error('帐号被禁用,请联系管理员',U('Member/login'));
            }else{
                session('username', $user['username']);
                session('uid', $user['id']);
                session('groupid',$user['group_id']);
                if($_COOKIE['web_user_openid']){
                    M('member')->where(array('id'=>$user['id']))->setField('user_openid',$_COOKIE['web_user_openid']);
                }
                M("member")->where(array("id" => $user['id']))->save(array(
                    "lastlogin_time" => time(),
                    "login_num" => $user["login_num"] + 1,
                    "lastlogin_ip" => get_client_ip()
                ));
                $this->redirect('Web/Member/index');
            }
        }
    }
    /**
     * 会员退出登录
     * @author yiyouguisu<741459065@qq.com> time|20151219
     * @retrun void
     */
    public function loginout() {
        if (session('uid')) {
            cookie('auto', null);
            cookie('user_openid', null);
            session('uid', null);
            session('username', null);
            session('groupid', null);
            $this->redirect('Web/Member/login');
        } else {
            $this->redirect('Web/Member/login');
        }
    }
    /**
     * 会员忘记密码
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function forgot() {
        if(IS_POST){
            $telverify = trim($_POST['telverify']);
            $password = trim($_POST['password']);
            $phone = trim($_POST['phone']);

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
            $user = M("Member")->where(array('phone'=>$phone))->find();
            if(empty($password)||empty($telverify)||empty($phone)){
                $this->error('请将信息填写完整');
            }elseif (strtolower($telverify) != strtolower($verify)) {
                $this->error('验证码错误');
            }elseif(!$user){
                $this->error('用户不存在');
            }else{
                if ($rs = D("Member")->ChangePassword($user['username'], $password)) {
                    $this->success("设置成功，请登录",U('Member/login'));
                } else {
                    $this->error("设置失败！");
                }
            }
        }else{
            $this->display();
        }
    }
	//个人信息展示
	public function view(){
		$userid = session('uid');
		$data=D("member")->where("id=".$userid)->find();
        if($data['companyid'] == '0') {
            $data['companyid'] = '未绑定';
        }else{
            $data['companyid']=M('company')->where('id='.$data['companyid'])->getField('title');
        }
        $data['level'] = getlevel($data['id']);
		$this->assign("data",$data);
		$this->display();
	}
	
	//个人信息修改
	public function edit(){
		$uid = session('uid');
        $preference = $_REQUEST['preference'];
		$userinfo = M('member')->where(array("id"=>$uid))->find();
		if ($_POST){
			if (D("member")->create()) {
	    		D("member")->id = $uid;
                if(!empty($preference)){
                    D("member")->preference = $preference;
                }
	    		if (empty($_POST['head'])){
	    			D("member")->head = $userinfo['head'];
	    		}
		        $id = D("member")->save();
		        
	            if ($id===false) {
                    $this->show('<script>alert("用户信息修改失败")</script>');
                    echo "<script>history.go(-1)</script>";
	            }else {
	            	$this->redirect('Web/Member/index');
	            }
            }
            else {
                $this->show('<script>alert("用户信息修改失败1")</script>');
                echo "<script>history.go(-1)</script>";
            }
		}
	}
	
	//图片上传
    public function fileupload() {
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts= array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->savePath = 'Uploads/images/pc/'; // 设置附件上传目录
        $upload->subName = array('date','Ymd');
        $info   =   $upload->upload();    
        if(!$info) {// 上传错误提示错误信息        
            $this->error($upload->getError());    
        }else{
            foreach($info as $file){        
                echo "/".$file['savepath'].$file['savename'];    
            }
        }
    }
    
    //签到
	public function sign(){
		$uid = session('uid');
		if (!$uid) {
            exit(json_encode(array('code'=>-200,'msg'=>'请登录')));
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
                    $count = $count+1;
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
    
    
    /*
     **更新用户积分
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
        self::addmessage($uid,$content,$content,$content,'system');
	}
	public static function addmessage($uid,$title,$description,$content,$message_type = 'system',$value=''){
		$mid=M('message')->add(array(
	  		'uid'=>0,
	  		'tuid'=>$uid,
	  		'varname'=>$message_type,
	  		'value'=>$value,
	  		'title'=>$title,
	  		'description'=>$description,
	  		'content'=>$content,
	  		'inputtime'=>time()
	  		));

        $registration_id=M('member')->where(array('id'=>array('eq',$uid)))->getField("deviceToken");
        $receiver = $registration_id;
        $extras = array("mid"=>$mid,'message_type'=>$message_type);
        if(!empty($receiver)){
            PushQueue($mid, $message_type,$receiver, $title,$description, serialize($extras),1);
        }
	}

    

    public function mylove(){
        $uid = session('uid');
        $data = M('member')->where("id=".$uid)->find();
        $arrf = array_filter(explode(",", $data["preference"]));
        
        $data = M("linkage")->where("catid=1")->field('value,name')->select();
        foreach ($data as $key=>$value)
        {
        	foreach ($arrf as $k=>$v)
            {
                if($data[$key]['value'] == $arrf[$k])
                {
                    $data[$key]['islove'] = 1;
                }
            }
            
        }
        //dump($data);
        $this->assign('data',$data);
    	$this->display();
    }
	public function setup(){
        $this->display();
    }
    /*
     **获取服务协议配置
     */
    public function about(){
        $type='about_us';
        if($type==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }else{
            $data = M("config")->where(array('groupid'=>6,'varname'=>$type))->getField("value");
            if($data){
                //dump($data);
                $this->assign('data',$data);
            }else{
                
            }
        }
        $this->display();
    }

    public function invitecode(){
        $uid=I('get.uid');
        if (!empty($uid))
        {
        	$data = M('member')->where('id='.$uid)->find();
        }else{
            $uid=session("uid");
            $data = M('member')->where('id='.$uid)->find();
        }
        $this->assign('data',$data);
        $url = '';
        $userclient = get_browsers();
        if ($userclient == 'Chrome'||$userclient == 'Firefox'||$userclient == 'Opera'||$userclient == 'Android')
        {   
            $member_anzhuo=M('version')->where('type=1 and group_id=1')->order(array('inputtime'=>'desc'))->find();
            $url=$member_anzhuo['url'];
        	//$url = 'http://android.myapp.com/myapp/detail.htm?apkName=com.snda.wifilocating';
        }else if($userclient == 'iPhone'||$userclient == 'Safari'){
            $member_ios=M('version')->where('type=2 and group_id=1')->order(array('inputtime'=>'desc'))->find();
            $url=$member_ios['url'];
            //$url = 'https://appsto.re/cn/65Lj8.i';
        }else if($userclient == 'iPad'||$userclient == 'Safari'){
            $member_ios=M('version')->where('type=2 and group_id=1')->order(array('inputtime'=>'desc'))->find();
            $url=$member_ios['url'];
            //$url = 'https://appsto.re/cn/65Lj8.i';
        }else{
            $url = '';
        }
        if(!empty($url)){
            $this->assign('downurl',$url);
        }
        $this->display();
    }
    /**
     * 登陆
     * @param int|string $identifier 用户ID,或者用户名
     * @param string $password 用户密码，不能为空
     * @param int $autotype 是否记住用户自动登录
     * @return int 
     */
    public function loginHome($identifier, $password, $autotype = 0) {
        if (empty($identifier) || empty($password)) {
            return 0;
        }else{
            $user = D("member")->getLocalAdminUser($identifier, $password);
            if (!$user) {
                $this->recordLoginHome($identifier, $password, 0, "帐号密码错误");
                return 0;
            }elseif ($user['status'] == 0) {
                $this->recordLoginHome($identifier, $password, 0, "帐号被禁止");
                return 1;
            }else{
                session('username', $user['username']);
                session('uid', $user['id']);
                session('groupid',$user['group_id']);
                if ($autotype == 1) {
                    $autoinfo = $user['id'] . "|" . $user['username'] . "|" . get_client_ip();
                    $auto = \Web\Common\CommonController::authcode($autoinfo, "ENCODE");
                    cookie('auto', $auto, C('AUTO_TIME_LOGIN'));
                }
                if($_COOKIE['web_user_openid']){
                    M('member')->where(array('id'=>$user['id']))->setField('user_openid',$_COOKIE['web_user_openid']);
                }
                M("member")->where(array("id" => $user['id']))->save(array(
                    "lastlogin_time" => time(),
                    "login_num" => $user["login_num"] + 1,
                    "lastlogin_ip" => get_client_ip()
                ));
                return 2;
            }
        }
        
        
    }

    /**
     * 记录前台登陆信息
     * @param string $identifier 用户名
     * @param string $password 用户密码
     * @param int $status 状态 1登录成功 0登录失败
     * @param string $info 备注
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function recordLoginHome($identifier, $password, $status, $info = "") {
        M("userlog")->add(array(
            "username" => $identifier,
            "logintime" => date("Y-m-d H:i:s"),
            "loginip" => get_client_ip(),
            "status" => $status,
            "password" => "***" . substr($password, 3, 4) . "***",
            "info" => $info
        ));
    }

    // 优惠券记录
    public function couponInfo(){
        // $uid=47;
        $uid=$this->getSessionId();
        $data=M('member a')
        ->join('left join zz_vouchers_order b on a.id=b.uid')
        ->join('left join zz_vouchers c on c.id=b.catid')
        ->where(array('a.id'=>$uid))
        ->field('b.status,c.title,c.validity_starttime,c.validity_endtime,c.price,c.id')->select();

        // echo M('member a')->getlastsql();
        // print_r(M('member a')->getlastsql());
        // die;
        $this->assign('data',$data);
        $this->display();
    }

    public function orderlist(){
        $uid=$this->getSessionId();
        // 名宿
        $httorder=M('order a')
        ->join('left join zz_activity_apply b on a.orderid=b.orderid')
        ->join('left join zz_activity d on d.id=b.aid')
        ->join('left join zz_member c on c.id=b.uid')
        ->where(array('c.id'=>$uid,'a.ordertype'=>1))
        ->order(array('a.inputtime'=>'desc'))
        ->select();
        $this->assign('ht',$httorder);
        // 活动
        $actorder=M('order a')
        ->join('left join zz_activity_apply b on a.orderid=b.orderid')
        ->join('left join zz_activity d on d.id=b.aid')
        ->join('left join zz_member c on c.id=b.uid')
        ->where(array('c.id'=>$uid,'a.ordertype'=>2))
        ->order(array('a.inputtime'=>'desc'))
        ->getField('a.orderid,b.paystatus,d.title,d.money,d.thumb,d.id');
        $this->assign('act',$actorder);
        $this->display();
    }

    // 我的游记
    public function mynote(){
        $uid=$this->getSessionId();
        $data=M('note a')->where(array('uid'=>$uid))->select();
        $this->assign('data',$data);
        $this->display();
    }
    // 编辑我的游记列表
    public function editmynote(){
        $uid=$this->getSessionId();
        $data=M('note a')
        ->join('left join zz_member b on b.id=a.uid')
        ->where(array('b.id'=>$uid))
        ->getField('a.id nid,a.title,a.inputtime,a.thumb,b.*');
        if(IS_AJAX){
            $id=$_POST['id'];
            M('note')->delete($id);
            $this->ajaxReturn(array('code'=>200,'msg'=>'删除成功'),'json');
        }
        $this->assign('data',$data);
        $this->display();
    }
    // 编辑我的游记详情
    public function editnoteinfo(){
        $uid=$this->getSessionId();
        $id=I('id');
        if(IS_POST){
            $data['uid']=$uid;
            $data['title']=$_POST['title'];
            $data['begintime']=strtotime($_POST['begintime']);
            $data['endtime']=strtotime($_POST['endtime']);
            $data['address']=$_POST['address'];
            $data['description']=$_POST['description'];
            $data['days']=$_POST['days'];
            $data['fee']=$_POST['fee'];
            $data['man']=$_POST['noteman'];
            $data['style']=$_POST['notestyle'];
            $data['imglist']=json_encode($_POST['content']);
            $data['updatetime']=time();
            $data['notetype']=1;
            $thumb=json_decode($_POST['content']);
            $thumb=$thumb[0]->thumb;
            $data['thumb']=$thumb;
            $data['lat']=(cookie('longitude')) ? cookie('longitude') : '';
            $data['lng']=(cookie('latitude')) ? cookie('latitude') : '';
            $data['imglist']=$_POST['content'];
            if($_POST['city']==$_POST['county']){
                $county=$_POST['city'];
            }
            else{
                $county=$_POST['city'].','.$_POST['county'];
            }
            $data['area']=$_POST['area'].','.$county;
            $data['city']=$_POST['county'];
            $res=M('note')->where(array('id'=>$_POST['id']))->save($data);
            if($res){
                $this->success('更新成功',U('Web/Member/index'));
            }else{
                $this->error('更新失败');
            }
        }
        $data=M('note a')->where(array('id'=>$id,'uid'=>$uid))->find();
        $notestyle=M("notestyle")->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("notestyle",$notestyle);
        $noteman=M("noteman")->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("noteman",$noteman);
        $carray=split(',',$data['area']);
        $allprovince=array();
        foreach ($carray as $key => $value) {
            $allprovince[$key]=M('area')->where(array('parentid'=>$value))->select();
        }
        $data['carray']=$carray;
        $this->assign('data',$data);
        $this->assign('allprovince',$allprovince);
        $province=M('area')->where(array('parentid'=>0))->select();
        $this->assign('province',$province);
        $this->display();
    }
    // 收藏
    public function collect(){
        $uid=$this->getSessionId();
        $notelist=M('collect a')
            ->join("left join zz_note b on a.value=b.id")
            ->join("left join zz_member c on b.uid=c.id")
            ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'note'))
            ->field('a.id,b.id as nid,b.title,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.hit,b.begintime,b.endtime,b.uid,c.nickname,c.head,c.rongyun_token,a.inputtime')
            ->order(array('a.inputtime'=>'desc'))
            ->select();
        foreach ($notelist as $key => $value)
        {   
            $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'note','value'=>$value['nid']))->count();
            $notelist[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

            $collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['nid']))->count();
            $notelist[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
        }
        $this->assign('note',$notelist);

        $houselist=M('collect a')
            ->join("left join zz_hostel b on a.value=b.id")
            ->join("left join zz_member c on b.uid=c.id")
            ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'hostel'))
            ->field('a.id,b.id as hid,b.title,b.thumb,b.money,b.area,b.city,b.address,b.lat,b.lng,b.hit,b.uid,c.nickname,c.head,c.rongyun_token,a.inputtime')
            ->order(array('a.inputtime'=>'desc'))
            ->select();
        foreach ($houselist as $key => $value)
        {
            $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'hostel','value'=>$value['hid']))->count();
            $houselist[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

            $collectnum=M('collect')->where(array('varname'=>'hostel','value'=>$value['hid']))->count();
            $houselist[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
        }

        $this->assign('houselist',$houselist);

        $partylist=M('collect a')
        ->join("left join zz_activity b on a.value=b.id")
        ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'party'))
        ->field('a.id,b.id as aid,b.title,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.starttime,b.endtime')
        ->order(array('a.inputtime'=>'desc'))
        ->select();
        foreach ($partylist as $key => $value)
        {
            $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'hostel','value'=>$value['hid']))->count();
            $partylist[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

            $collectnum=M('collect')->where(array('varname'=>'hostel','value'=>$value['hid']))->count();
            $partylist[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
        }
        $this->assign('party',$partylist);
        $this->display();
    }
    // 编辑收藏
    public function editcollect(){
        $uid=$this->getSessionId();
        $notelist=M('collect a')
            ->join("left join zz_note b on a.value=b.id")
            ->join("left join zz_member c on b.uid=c.id")
            ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'note'))
            ->field('a.id,b.id as nid,b.title,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.hit,b.begintime,b.endtime,b.uid,c.nickname,c.head,c.rongyun_token,a.inputtime')
            ->order(array('a.inputtime'=>'desc'))
            ->select();
        foreach ($notelist as $key => $value)
        {   
            $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'note','value'=>$value['nid']))->count();
            $notelist[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

            $collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['nid']))->count();
            $notelist[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
        }
        $this->assign('note',$notelist);

        $houselist=M('collect a')
            ->join("left join zz_hostel b on a.value=b.id")
            ->join("left join zz_member c on b.uid=c.id")
            ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'hostel'))
            ->field('a.id,b.id as hid,b.title,b.thumb,b.money,b.area,b.city,b.address,b.lat,b.lng,b.hit,b.uid,c.nickname,c.head,c.rongyun_token,a.inputtime')
            ->order(array('a.inputtime'=>'desc'))
            ->select();
        foreach ($houselist as $key => $value)
        {
            $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'hostel','value'=>$value['hid']))->count();
            $houselist[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

            $collectnum=M('collect')->where(array('varname'=>'hostel','value'=>$value['hid']))->count();
            $houselist[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
        }
        $this->assign('houselist',$houselist);

        $partylist=M('collect a')
        ->join("left join zz_activity b on a.value=b.id")
        ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'party'))
        ->field('a.id,b.id as aid,b.title,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.starttime,b.endtime')
        ->order(array('a.inputtime'=>'desc'))
        ->select();
        foreach ($partylist as $key => $value)
        {
            $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'hostel','value'=>$value['hid']))->count();
            $partylist[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

            $collectnum=M('collect')->where(array('varname'=>'hostel','value'=>$value['hid']))->count();
            $partylist[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
        }
        $this->assign('party',$partylist);
        if(IS_AJAX){
            $data=$_POST['id'];
            $dataarray=explode("|",$data);
            $n=array();
            $h=array();
            $p=array();
            foreach ($dataarray as $key => $value) {
                if(strpos($value,'n')!== false){
                    $n[$key]=substr($value,2);
                }
                if(strpos($value,'h')!== false){
                    $h[$key]=substr($value,2);
                }
                if(strpos($value,'p')!== false){
                    $p[$key]=substr($value,2);
                }

            }
            if(count($n)>0 || count($h)>0 || count($p)>0){
                if(count($n)>0){
                    foreach ($n as $key => $value) {
                        M('collect')->where(array('id'=>$value))->delete();
                    }        
                }
                if(count($h)>0){
                    foreach ($h as $key => $value) {
                        M('collect')->where(array('id'=>$value))->delete();
                    }     
                }
                if(count($p)>0){
                    foreach ($p as $key => $value) {
                        M('collect')->where(array('id'=>$value))->delete();
                    }    
                }
                $data=array('code'=>200,'msg'=>'删除成功');
            }
            else{
                $data=array('code'=>500,'msg'=>'删除失败');
            }
            $this->ajaxReturn($data,'json');
        }
        $this->display();
    }

    public function memberHome(){
        $uid=I('id');
        $data=$this->userInfo($uid);
        // 我的游记
        $notedata=M('note')->where(array('uid'=>$uid))->select();
        $this->assign('note',$notedata);
        $this->assign('cnote',count($notedata));
        // 我的评论
        // 游记评论
        $notedata=M('note a')
        ->join('left join zz_review b on a.id=b.value')
        ->where(array('b.uid'=>$uid,'b.varname'=>'note'))
        ->order('b.inputtime desc')
        ->field('a.title,a.id nid,a.inputtime,b.id,b.content')->select();
        // 活动评论
        $activityreview=M('activity a')
        ->join('left join zz_review b on a.id=b.value')
        ->where(array('b.uid'=>$uid,'b.varname'=>'party'))->order('b.inputtime desc')->field('a.title,a.id pid,b.*')->select();
        $this->assign('notedata',$notedata);
        $this->assign('activityreview',$activityreview);
        $this->assign('creview',count($activityreview)+count($notedata));
        // die;
        // 个人信息
        $this->assign('data',$data['data']);
        $this->assign('follow',$data['follow']);
        $this->assign('fans',$data['fans']);
        // 是否是当前登入的人
        $ismy=1;
        if($uid==session('uid')){
            $ismy=0;
        }
        // 当前登入用户
        $fuid=session('uid');
        $attention=M('attention')->where(array('fuid'=>$fuid,'tuid'=>$uid))->find();
        // print_r(M('attention')->getlastsql());
        $attention = !empty($attention)?1:0;
        // print_r($attention);
        $this->assign('attention',$attention);
        $this->assign('ismy',$ismy);
        $this->display();
    }
    // 关注
    public function ajax_attention(){
        $ret=$_POST;
        $uid = session("uid");
        $tuid=intval(trim($ret['tuid']));

        $fuser=M('Member')->where(array('id'=>$uid))->find();
        $tuser=M('Member')->where(array('id'=>$tuid))->find();
        $attentionstatus=M('attention')->where(array('fuid'=>$uid,'tuid'=>$tuid))->find();
        if($tuid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($fuser)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($tuser)){
            exit(json_encode(array('code'=>-200,'msg'=>"好友不存在")));
        }elseif($uid==$tuid){
            exit(json_encode(array('code'=>-200,'msg'=>"用户与好友为同一人")));
        }else{
            if(!empty($attentionstatus)){
            $id=M('attention')->where(array(
                'fuid'=>$fuser['id'],
                'tuid'=>$tuser['id']
            ))->delete();
            if($id){
                $fansnum=M('attention')->where(array('tuid'=>$tuid))->count();
                exit(json_encode(array('code'=>200,'msg'=>"取消关注成功",'fansnum'=>$fansnum)));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"取消关注失败")));
            }
            }else{
                $id=M('attention')->add(array(
                'fuid'=>$fuser['id'],
                'tuid'=>$tuser['id'],
                'inputtime'=>time()
                ));
                if($id){
                    $fansnum=M('attention')->where(array('tuid'=>$tuid))->count();
                    exit(json_encode(array('code'=>200,'msg'=>"关注成功",'fansnum'=>$fansnum)));
                }else{
                    exit(json_encode(array('code'=>-202,'msg'=>"关注失败")));
                }
            }
        }
    }
    public function myfans(){
        $uid=I('id');
        $data=$this->userinfo($uid);
        // 我关注的人
        $list['followArray']=M('attention a')
        ->join("left join zz_member b on a.tuid=b.id")
        ->where(array('a.fuid'=>$uid))
        ->field('b.id,b.head,b.info,b.area,b.nickname')
        ->select();
        // 关注我的人
        $list['fansArray']=M('attention a')
        ->join("left join zz_member b on a.fuid=b.id")
        ->field('b.id,b.head,b.info,b.area,b.nickname')
        ->where(array('a.tuid'=>$uid))->select();
        $this->assign('list',$list);
        // 数量
        $this->assign('follow',$data['follow']);
        $this->assign('fans',$data['fans']);
        $this->display();
    }
    // 个人信息
    public function myinfo(){
        $uid=$this->getSessionId();
        $data=$this->userInfo($uid);
        $adarray=explode(",",$data['data']['hometown']);
        $ararray=explode(",",$data['data']['area']);
        $hometown=array();
        $area=array();
        $i=0;
        // 故乡
        foreach ($adarray as $key => $value) {
            $hometown[$i]=M('area')->where(array('id'=>$value))->getField('name');
            $i++;
        }
        // 现在位置
        foreach ($ararray as $key => $value) {
            $area[$i]=M('area')->where(array('id'=>$value))->getField('name');
            $i++;
        }
        $this->assign('area',$area);
        $this->assign('hometown',$hometown);
        $this->assign('follow',$data['follow']);
        $this->assign('fans',$data['fans']);
        $this->assign('data',$data['data']);
        if(IS_AJAX){
            if(isset($_POST['blood'])){
                $blood=$_POST['blood'];
                M('member')->where(array('id'=>$uid))->save(array('bloodtype'=>$blood));
                $this->ajaxReturn(array('code'=>200,'msg'=>'更新成功'),'json'); 
            }
            if(isset($_POST['education'])){
                $education=$_POST['education'];
                M('member')->where(array('id'=>$uid))->save(array('education'=>$education));
                $this->ajaxReturn(array('code'=>200,'msg'=>'更新成功'),'json'); 
            }
            if(isset($_POST['zodiac'])){
                $zodiac=$_POST['zodiac'];
                M('member')->where(array('id'=>$uid))->save(array('zodiac'=>$zodiac));
                $this->ajaxReturn(array('code'=>200,'msg'=>'更新成功'),'json'); 
            }
            if(isset($_POST['constellation'])){
                $constellation=$_POST['constellation'];
                M('member')->where(array('id'=>$uid))->save(array('constellation'=>$constellation));
                $this->ajaxReturn(array('code'=>200,'msg'=>'更新成功'),'json'); 
            }
        }
        $this->display();

    }
    // 修改手机号码
    public function editphone(){
        $this->display();
    }
    public function phone(){
        $uid=$this->getSessionId();
        $where['phone']=$_POST['phone'];
        $where['verify']=$_POST['code'];
        $is=M('verify')->where($where)->find();
        if(!empty($is) && $is['status']==0){
            M('Member')->where(array('id'=>$uid))->save(array('phone'=>$_POST['phone']));
            M('verify')->where($where)->save(array('status'=>1));
            $data=array('code'=>200,'msg'=>'修改成功');
            $this->ajaxReturn($data,'json');
        }
        else{
            $data=array('code'=>500,'msg'=>'修改失败');
            $this->ajaxReturn($data,'json');  
        }
    }
    // 修改性别
    public function editsex(){
        $uid=$this->getSessionId();
        $data=$this->userInfo($uid);
        if(IS_POST){
            M('Member')->where(array('id'=>$uid))->save(array('sex'=>$_POST['sex']));
            $this->success("修改成功", U("Web/Member/myinfo"));
        }
        $this->assign('sex',$data['data']['sex']);
        $this->display();
    }
    // 修改出生年月
    public function editbirthday(){
        $uid=$this->getSessionId();
        $data=$this->userInfo($uid);
        if(IS_POST){

            if($_POST['year']>0 && $_POST['month']>0 && $_POST['day']>0){
                $birthday=$_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
                M('Member')->where(array('id'=>$uid))->save(array('birthday'=>strtotime($birthday)));
                $this->success("修改成功", U("Web/Member/myinfo"));
            }
            else{
                $this->error("请选择正确的日期");
            }
            
        }
        $birthday=date("Y-m-d",$data['data']['birthday']);
        $birthday=explode("-",$birthday);
        $this->assign('birthday',$birthday);
        $this->display();
    }
    // 修改个性签名
    public function editinfo(){
        $uid=$this->getSessionId();
        if(IS_POST){
            M('Member')->where(array('id'=>$uid))->save(array('info'=>$_POST['info']));
            $this->success("修改成功", U("Web/Member/myinfo"));
        }
        else{
            $info=M('Member')->where(array('id'=>$uid))->getField('info');
            $this->assign('info',$info);
        }
        $this->display();
    }
    // 修改学校
    public function editschool(){
        $uid=$this->getSessionId();
        if(IS_POST){
            M('Member')->where(array('id'=>$uid))->save(array('school'=>$_POST['school']));
            $this->success("修改成功", U("Web/Member/myinfo"));
        }
        else{
            $school=M('Member')->where(array('id'=>$uid))->getField('school');
            $this->assign('school',$school);
        }
        $this->display();
    }
    // 修改我的故乡
    public function edithometown(){
        $uid=$this->getSessionId();
        $province=M('area')->where(array('parentid'=>0))->select();
        $this->assign('province',$province);
        if(IS_POST){
            if($_POST['province']>0 && $_POST['city']>0){
                $data=$_POST['province'].','.$_POST['city'];
                if(isset($_POST['county']) && $_POST['county']>0 )
                {   
                    $data=$data.','.$_POST['county'];
                }
                M('member')->where(array('id'=>$uid))->save(array('hometown'=>$data));
                $this->success("修改成功", U("Web/Member/myinfo"));
            }
            else{
                $this->error("修改失败");
            }
        }
        $this->display();
    }
    // 修改所在地址
    public function editarea(){
        $uid=$this->getSessionId();
        $province=M('area')->where(array('parentid'=>0))->select();
        $this->assign('province',$province);
        if(IS_POST){
            if($_POST['province']>0 && $_POST['city']>0){
                $data=$_POST['province'].','.$_POST['city'];
                if(isset($_POST['county']) && $_POST['county']>0 )
                {   
                    $data=$data.','.$_POST['county'];
                }
                M('member')->where(array('id'=>$uid))->save(array('area'=>$data));
                $this->success("修改成功", U("Web/Member/myinfo"));
            }
            else{
                $this->error("修改失败");
            }
        }
        $this->display();
    }
    // 城市联动获取子集ajax
    public function getcity(){
        $data=M('area')->where(array('parentid'=>$_POST['city']))->select();
        if(count($data)>0){
            $data=array('code'=>200,'data'=>$data);
        }
        else
        {
            $data=array('code'=>500);
        }
        $this->ajaxReturn($data,'json');
    }


    // 实名认证
    public function realname(){
        $uid=$this->getSessionId();
        $mdata=M('member')->where(array('id'=>$uid))->find();
        if(IS_POST){
            $data['uid']=$uid;
            $data['realname']=$_POST['realname'];
            $data['idcard']=$_POST['idcard'];
            $data['idcard_front']=$_POST['idcard_front'];
            $data['idcard_back']=$_POST['idcard_back'];
            $data['status']=1;
            $data['inputtime']=time();
            $id=M('realname_apply')->add($data);
            if($id){
                $this->success('申请成功');
            }
        }
        $this->assign('data',$mdata);
        $this->display();
    }
    // 更改头像
    public function uphead(){
        $uid=$this->getSessionId();
        $url=$_POST['url'];
        $data['head']=$url;
        M('member')->where(array('id'=>$uid))->save($data);
    }
    // 我发布的民宿
    public function mymerchant(){
        $uid=$this->getSessionId();
        $data=M('hostel')->where(array('uid'=>$uid,'isdel'=>0))->select();
        $this->assign('count',count($data));
        $this->assign('data',$data);
        $this->display();
    }
    // 修改我发布的名宿
    public function editmymerchant(){
        $uid=$this->getSessionId();
        $data=M('hostel')->where(array('uid'=>$uid,'isdel'=>0))->select();
        $this->assign('count',count($data));
        if(IS_AJAX){
            $idarray=explode(",", $_POST['id']);
            foreach ($idarray as $key => $value) {
                M('hostel')->where(array('id'=>$value))->save(array('isdel'=>1));
            }
            $this->ajaxReturn(array('code'=>200,'msg'=>'删除成功'),'json');
        }
        $this->assign('data',$data);
        $this->display();
    }
    // 我发布的活动
    public function myact(){
        $uid=$this->getSessionId();
        $data=M('activity')->where(array('uid'=>$uid))->select();
        $this->assign('data',$data);
        $this->display();
    }
    // 修改我发布的活动
    public function editmyact(){
        $uid=$this->getSessionId();
        $data=M('activity')->where(array('uid'=>$uid))->select();
        $this->assign('data',$data);
        if(IS_AJAX){
            $id=$_POST['id'];
            // $array=explode("|",$id);
            // print_r($id);
            M('activity')->delete($id);
            $this->ajaxReturn(array('code'=>200,'msg'=>'删除成功'),'json');
        }
        $this->display();
    }
    
    public function getSessionId(){
        $uid=session('uid');
        if(!session('uid')){
            $returnurl=urlencode($_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
            $this->error('请先登录！',U('Web/Member/login')."?returnurl=".$returnurl);
        }
        else{
            $uid=session('uid');
        }
        return $uid;
    }

    // 常用联系人
    public function topContacts(){
        $uid=session('uid');
        $data['people']=M('linkman')->where(array('uid'=>$uid))->select();
        if(isset($_GET['url']))
        {
            $data['url']=$_GET['url'];
        }
        else{
            $data['url']=I('server.HTTP_REFERER');
            $data['url']=str_replace("/",",",$data['url']);
        }
        // die;
        $this->assign('data',$data);
        $this->display();
    }

    // 常用联系人
    public function editContacts(){
        $uid=session('uid');
        $url=I('url');
        // die;
        if(IS_POST){
            // print_r($_POST);
            if($_POST['id']!=''){
                $data['realname']=$_POST['realname'];
                $data['phone']=$_POST['phone'];
                $data['idcard']=$_POST['idcard'];
                M('linkman')->where(array('id'=>$_POST['id']))->save($data);
                $this->success("修改成功", U("Web/Member/topContacts",array('url'=>$_POST['url'])));
            }
            else{
                $data['realname']=$_POST['realname'];
                $data['phone']=$_POST['phone'];
                $data['idcard']=$_POST['idcard'];
                $data['uid']=$uid;
                $id=M('linkman')->add($data);
                if($id){
                    $this->success("新增成功！", U("Web/Member/topContacts",array('url'=>$_POST['url'])));
                }
                else{
                    $this->error('添加失败');
                }
            }
        }
        $edata=M('linkman')->where(array('id'=>$_GET['id']))->find();
        $edata['url']=$url;
        $this->assign('data',$edata);
        $this->assign('id',$_GET['id']);
        $this->display();
    }
    public function addPeople(){
        // 获取当前参加人数数组
        $uid=session('uid');
        $res=M('linkman')->where("uid=%d AND (realname='%s' or idcard='%s' or phone='%s')",array($uid,$_POST['realname'],$_POST['idcard'],$_POST['phone']))->select();
        if(!$res){
            $data['uid']=$uid;
            $data['realname']=$_POST['realname'];
            $data['idcard']=$_POST['idcard'];
            $data['phone']=$_POST['phone'];
            $id=M('linkman')->add($data);
            if($id){
                $addArray=cookie('add');
                if(empty($addArray)){
                    $data['id']=$id;
                    $addArray[0]=$data;
                    cookie('add',json_encode($addArray));
                }
                else{
                    $data['id']=$id;
                    $addArray=json_decode(cookie('add'));
                    array_push($addArray,$data);
                    cookie('add',json_encode($addArray));
                }   
            }
            echo str_replace(",","/",$_POST['url']);
        }
        else{
            $this->ajaxReturn(array('code'=>500),'json');
        }
        // print_r($addArray);
        // 
        // print_r($addArray);
        // cookie('add',$addArray);
    }
    public function addContacts(){
        $addArray=cookie('add');
        if(empty($addArray)){
            $addArray[0]=$_POST;
            cookie('add',json_encode($addArray));
        }
        else{
            $addArray=json_decode(cookie('add'));
            array_push($addArray,$_POST);
            cookie('add',json_encode($addArray));
        }
        echo str_replace(",","/",$_POST['url']);
    }
    public function delContacts(){
        $res=M('linkman')->where(array('id'=>$_POST['id']))->delete();
        if($res){
            $data=array('code'=>200);
        }   
        else{
            $data=array('code'=>500);
        }
        $this->ajaxReturn($data,'json');
    }

    public function delcookie(){
        $addArray=json_decode(cookie('add'));
        foreach ($addArray as $key => $value) {
            if($_POST['id']==$value->id){
                array_splice($addArray, $key, 1);
            }
        } 
        cookie('add',json_encode($addArray));
    }

    // 设置
    public function set(){
        $this->display();
    }
    public function useinfo(){
        $this->display();
    }
}