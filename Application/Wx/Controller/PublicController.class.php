<?php

namespace Wx\Controller;

use  Think\Controller;

class PublicController extends Controller {

    public function wxlogin() {
        $uid=session("uid");
        if(!$uid){
            $appid = C('WEI_XIN_INFO.APP_ID');
            $secret = C("WEI_XIN_INFO.APP_SECRET");

            if (!isset($_GET['code'])){
                $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'];
                $get_token_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri='.$url.'&response_type=code&scope=snsapi_base&state=123#wechat_redirect';
                Header("Location: {$get_token_url}");
                exit();
            }else{
                $code = $_GET['code'];
                $get_openid_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
                $res = file_get_contents($get_openid_url);
                $user_obj = json_decode($res, true);
                $openId=$user_obj["openid"];

                $access_token=S("access_token");
                if(empty($access_token)){
                    $get_access_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $secret;
                    $res1 = file_get_contents($get_access_token_url);
                    $user_obj1 = json_decode($res1, true);
                    $access_token=$user_obj1["access_token"];
                    S("access_token",$access_token,7200);
                }

                $get_user_info_url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openId."&lang=zh_CN";
                $user_info = file_get_contents($get_user_info_url);
                $user_info_obj = json_decode($user_info, true);

                $invitecode=session("invitecode");
                $tuijianuser=M('member')->where(array('tuijiancode'=>$invitecode))->find();
                $groupid_id=0;
                if($tuijianuser&&!empty($invitecode)){
                    $groupid_id = $tuijianuser['id'];
                }
                $data=array(
                            'openid'=>$user_info_obj['openid'],
                            'username'=>$user_info_obj['unionid'],
                            'password'=>"123456",
                            'groupid_id'=>$groupid_id,
                            'head'=>"/default_head.png",
                            'unionid'=>$user_info_obj['unionid'],
                            'subscribe_time'=>$user_info_obj['subscribe_time'],
                            'subscribestatus'=>$user_info_obj['subscribe']
                            );

                $user=M('Member')->where(array('username'=>$user_info_obj['unionid']))->find();

                if($user){
                    session("uid",$user['id']);
                    D('Member')->where(array('id'=>$user['id']))->editUser($data);
                }else{
                    $uid=D('Member')->addUser($data);
                    if($user_info_obj['subscribe']==1){
                        $userinfo=array(
                            'nickname'=>$user_info_obj['nickname'],
                            'sex'=>intval($user_info_obj['sex']),
                            'head'=>$user_info_obj['headimgurl'],
                            );
                        D('Member')->where(array('id'=>$uid))->editUser($userinfo);
                    }
                    session("uid",$uid);
                    if($tuijianuser&&!empty($invitecode)){
                        M('invite')->add(array(
                            'uid'=>$tuijianuser['id'],
                            'tuid'=>$uid,
                            'tuijiancode'=>$invitecode,
                            'status'=>2,
                            'inputtime'=>time()
                            ));
                        
                    }
                }

                cookie('openid', $user_info_obj['openid'], C('AUTO_TIME_LOGIN'));
                cookie('unionid', $user_info_obj['unionid'], C('AUTO_TIME_LOGIN'));
                $returnurl=cookie("returnurl");
                if(!empty($returnurl)){
                    $returnurl=urldecode($returnurl);
                    Header("Location: {$returnurl}");
                }else{
                    $this->redirect("Wx/Member/index");
                }
                
            }
        }

    }
}
