<?php

namespace Home\Controller;

use Think\Controller;

class OauthController extends Controller {

    public function _initialize() {
        $this->wxlogin=array(
            'appid'    => "wxdc7412969e0ea991",
            'secret'   => "40190eaf383b6d89d71bd42e8576733a",
            'callback' => "http://".$_SERVER['HTTP_HOST'].U('Home/Oauth/weixinlogin'),
            'scope'    => "snsapi_login"
          );
        $this->qqlogin=array(
            'appid'    => "101341858",
            'appkey'   => "101b679787fe8a319c8907aa906d065c", 
            'callback' => "http://".$_SERVER['HTTP_HOST'].U('Home/Oauth/qqlogin'),
            'scope'    => "get_user_info"
          );
        $this->sinalogin=array(
            'appid'    => "2571654359",
            'appkey'   => "dda05b172f3321c0b7b518f4adcf6713", 
            'callback' => "http://".$_SERVER['HTTP_HOST'].U('Home/Oauth/sinalogin'),
          );
        
    }
    public function weixin() {
        $_SESSION['weixin_state'] = md5(uniqid(rand(), TRUE));
        $login_url = 'https://open.weixin.qq.com/connect/qrconnect?appid=' . $this->wxlogin['appid'] . '&redirect_uri=' . urlencode($this->wxlogin['callback']) . '&response_type=code&scope=' . $this->wxlogin['scope'] . '&state=' . $_SESSION['weixin_state'] . '#wechat_redirect';
        header("location: " . $login_url);
    }
    public function weixinlogin() {
        $code = $_GET['code'];
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->wxlogin['appid'] . '&secret=' . $this->wxlogin['secret'] . '&code=' . $code . '&grant_type=authorization_code';
        $tokenstr = file_get_contents($get_token_url);
        if($_GET['state'] == $_SESSION['weixin_state']){
            $token = json_decode($tokenstr, true);
            $get_user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $token['access_token'] . '&openid=' . $token['openid'];
            $user_info_obj = file_get_contents($get_user_info_url);
            $user_info = json_decode($user_info_obj, true);
            $data['openid']=$user_info['unionid'];
            $data['site'] = 'weixin';
            $data['nickname']=$user_info['nickname'];
            $data['sex']=$user_info['sex'];
            $data['info']=$user_info['sex'];
            $data['head']=substr($user_info['headimgurl'],0,-1);
            $this->applogin($data);
        }else{
            $this->error("The state does not match. You may be a victim of CSRF.");
        }
    }
    public function qq(){
        $_SESSION['qq_state'] = md5(uniqid(rand(), TRUE));
        $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" . $this->qqlogin['appid'] . "&redirect_uri=" . urlencode($this->qqlogin['callback']) . "&state=" . $_SESSION['qq_state'] . "&scope=" . $this->qqlogin['scope'];
        header("location: " . $login_url);
    }
    public function qqlogin(){
        $code = $_GET['code'];
        $get_token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&" . "client_id=" . $this->qqlogin['appid']. "&redirect_uri=" . urlencode($this->qqlogin['callback'])  . "&client_secret=" . $this->qqlogin['appkey']. "&code=" . $code;
        $tokenstr = file_get_contents($get_token_url);
        if($_GET['state'] == $_SESSION['qq_state']){
            $token=array();
            if($tokenstr!='')parse_str($tokenstr, $token);
            $get_openid_url = "https://graph.qq.com/oauth2.0/me?access_token="  . $token['access_token'];
            $get_openid_str  = file_get_contents($get_openid_url);
            $get_openid_obj=array();
            if($get_openid_str!=''){
                preg_match('/callback\(\s+(.*?)\s+\)/i', $get_openid_str, $get_openid_obj);
                $get_openid_obj=json_decode($get_openid_obj[1], true);
            }
            $get_user_info_url = "https://graph.qq.com/user/get_user_info?access_token=" . $token['access_token']."&oauth_consumer_key=" . $this->qqlogin['appid'] . "&openid=" . $get_openid_obj['openid'] . "&format=json";
            $user_info_obj  = file_get_contents($get_user_info_url);
            $user_info = json_decode($user_info_obj, true);
            $data['openid'] = $get_openid_obj['openid'];
            $data['site'] = 'qq';
            $data['nickname']=$user_info['nickname'];
            $gender=$user_info['gender'];
            if($gender=="男"){
                $data['sex']=1;
            }elseif($gender=="女"){
                $data['sex']=2;
            }
            $data['info']="";
            $data['head']=$user_info['figureurl_2'];
            $this->applogin($data);
        }else{
            $this->error("The state does not match. You may be a victim of CSRF.");
        }
    }
    public function sina(){
        $_SESSION['sina_state'] = md5(uniqid(rand(), TRUE));
        $login_url = "https://api.weibo.com/oauth2/authorize?client_id=" . $this->sinalogin['appid'] . "&redirect_uri=" . urlencode($this->sinalogin['callback']) . "&state=" . $_SESSION['sina_state'] . "&scope=" . $this->sinalogin['scope'];
        header("location: " . $login_url);
    }
    public function sinalogin(){
        $code = $_GET['code'];
        $params=array(
            'grant_type'=>'authorization_code',
            'code'=>$code,
            'client_id'=>$this->sinalogin['appid'],
            'client_secret'=>$this->sinalogin['appkey'],
            'redirect_uri'=>$this->sinalogin['callback']
        );
        $tokenstr=$this->httppost("https://api.weibo.com/oauth2/access_token",http_build_query($params));
        if($_GET['state'] == $_SESSION['sina_state']){
            $token = json_decode($tokenstr, true);
            $get_user_info_url = "https://api.weibo.com/2/users/show.json?access_token="  . $token['access_token'] . "&uid=" . $token['uid'];
            $user_info_obj  = file_get_contents($get_user_info_url);
            $user_info = json_decode($user_info_obj, true);
            $data['openid'] = $token['uid'];
            $data['site'] = 'sina';
            $data['nickname']=$user_info['name'];
            $gender=$user_info['gender'];
            if($gender=="m"){
                $data['sex']=1;
            }elseif($gender=="w"){
                $data['sex']=2;
            }
            $data['info']=$user_info['description'];
            $data['head']=$user_info['profile_image_url'];
            $this->applogin($data);
        }
    }
    function httppost($reurl='',$rearray=array('')){
        if (empty($reurl) || empty($rearray)) {
            return (false);
        }

        $post_data = $rearray;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $reurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'LightPass/X1 (With CURL)');
        $output = curl_exec($ch);
        if (!$output){
            return (false);
        }else {
            curl_close($ch);
            return $output;

        }
    }
    private function appCk($map,$data){
        $result=M('oauth')->where($map)->find();
        if($result){
            if($result['is_bind']==1){
                $user=M('member')->where('id='. $result['bind_uid'])->find();
                session('uid', $user['id']);
                session('username', $user['username']);
                M("member")->where(array("id" => $user['id']))->save(array(
                    "head"=>$data['head'],
                    "nickname"=>$data['nickname'],
                    "lastlogin_time" => time(),
                    "login_num" => $user["login_num"] + 1,
                    "lastlogin_ip" => get_client_ip()
                ));
                M("oauth")->where($map)->save(array(
                    "logintime" => time(),
                    "logintimes" => $result["logintimes"] + 1
                ));
                
                echo "<script>window.opener.location.href='/index.php/Home/Index/personal.html';</script>";
                echo "<script>window.close();</script>";
            }else{
                $select['nickname']= $result['nickname'];
                $user=M('member')->where($select)->find();
                session('uid', $user['id']);
                session('username', $user['username']);
                M("member")->where(array("id" => $user['id']))->save(array(
                    "head"=>$data['head'],
                    "nickname"=>$data['nickname'],
                    "lastlogin_time" => time(),
                    "login_num" => $user["login_num"] + 1,
                    "lastlogin_ip" => get_client_ip()
                ));
                M("oauth")->where($map)->save(array(
                    "logintime" => time(),
                    "logintimes" => $result["logintimes"] + 1
                ));
                
                echo "<script>window.opener.location.href='/index.php/Home/Index/personal.html';</script>";
                echo "<script>window.close();</script>";
            }
        }else{
            $map['nickname']=$data['nickname'];
            $map['inputtime']=time();
            M("oauth")->add($map);

            $data['username']=$map['openid'];
            $data['reg_time']=time();
            $data['reg_ip']=get_client_ip();
            $id=M("member")->add($data);
            if($id){
                M("member_info")->add(array("uid"=>$id));
                session('uid', $id);
                session('username', $map['openid']);
                M("member")->where(array("id" => $id))->save(array(
                    "lastlogin_time" => time(),
                    "login_num" => $user["login_num"] + 1,
                    "lastlogin_ip" => get_client_ip()
                ));
                M("oauth")->where($map)->save(array(
                    "logintime" => time(),
                    "logintimes" => 1
                ));
                
                echo "<script>window.opener.location.href='/index.php/Home/Index/personal.html';</script>";
                echo "<script>window.close();</script>";
                //$this->redirect('Home/Member/personal');
            }else{
                $this->error("登录失败");
            }
        }
    }
    private function applogin($logindata) {
        $openid = $logindata['openid'];
        $site = $logindata['site'];
        $sex = $logindata['sex'];
        $nickname = $logindata['nickname'];
        $head = $logindata['head'];
        $info=$logindata['info'];

        $bind = M('oauth')->field('id,bind_uid,logintimes')->where(array('openid' => $openid, 'site' => $site))->find();
        $user = M('member')->where(array('username' => $openid))->find();
        if ($openid == '' || $site == '' || $nickname == '' || $head == '') {
            $this->error("获取用户信息失败");
        } elseif (!$user) {
            $data['username'] = $openid;
            $data['password'] = "123456";
            $data['nickname'] = $nickname;
            $data['head'] = $head;
            $data['sex'] = $sex;
            $data['info']=$info;
            $id = D("Member")->addUser($data);
            $Rongrun=A("Api/Rongyun");
            $Rongrun->savetoken($id);

            $map['bind_uid'] = $id;
            $map['is_bind'] = 1;
            $map['nickname'] = $nickname;
            $map['openid'] = $openid;
            $map['site'] = $site;
            $map['logintimes'] = 1;
            $map['inputtime'] = time();
            $map['logintime'] = time();
            M('oauth')->add($map);
            
            echo "<script>window.opener.location.href='/index.php/Home/Member/bindphone/uid/".$id.".html';</script>";
            echo "<script>window.close();</script>";
        } else {
            if($bind){
                $save['id'] = $bind['id'];
                $save['logintimes'] = ($bind['logintimes'] + 1);
                $save['logintime'] = time();
                M('oauth')->save($save);
            }else{
                $map['bind_uid'] = $id;
                $map['is_bind'] = 1;
                $map['nickname'] = $nickname;
                $map['openid'] = $openid;
                $map['site'] = $site;
                $map['logintimes'] = 1;
                $map['inputtime'] = time();
                $map['logintime'] = time();
                M('oauth')->add($map);
            }
            M('member')->where(array('id' => $bind['bind_uid']))->save(array(
                'nickname' => $nickname,
                'head' => $head,
                'info'=>$info,
                'sex'=>$sex
                ));
            if(empty($user['phone'])){
                echo "<script>window.opener.location.href='/index.php/Home/Member/bindphone/uid/".$user['id'].".html';</script>";
            }else{
                session('username', $user['username']);
                session('uid', $user['id']);
                if ($autotype == 1) {
                    $autoinfo = $user['id'] . "|" . $user['username'] . "|" . get_client_ip();
                    $auto = \Home\Common\CommonController::authcode($autoinfo, "ENCODE");
                    cookie('auto', $auto, C('AUTO_TIME_LOGIN'));
                }
                echo "<script>window.opener.location.href='/index.php/Home/Member/index.html';</script>";
            }
            
            echo "<script>window.close();</script>";
        }

    }
}

?>
