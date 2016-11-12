<?php

namespace Wx\Controller;

use  Think\Controller;

class PublicController extends Controller {
    public function _initialize() {
        $this->appid = C('WEI_XIN_INFO.APP_ID');
        $this->appsecret = C("WEI_XIN_INFO.APP_SECRET");
    }
    public function InterfaceTest(){
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];  
        $echoStr = $_GET["echostr"];  
                
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );
    
        if( $tmpStr == $signature ){
            echo $echoStr;
            exit;
        }else{
            return false;
        }
        // $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        // if (!empty($postStr)){
        //     $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        //     $fromUsername = $postObj->FromUserName;
        //     $toUsername = $postObj->ToUserName;
        //     $msgType = $postObj->MsgType;
        //     $event = $postObj->Event;
        //     \Think\Log::write("xml:{$fromUsername},{$toUsername},{$msgType},{$event}",'WARN');
        //     exit;
        // }              
    }

    public function wxlogin() {
        $uid=session("uid");
        $nowUrl = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

        if(!$uid){
            $appid = C('WEI_XIN_INFO.APP_ID');
            $secret = C("WEI_XIN_INFO.APP_SECRET");

            $aa = $_GET['code'];

            if (!isset($_GET['code'])){
                $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING']);
                $url = $this->__CreateOauthUrlForCode($baseUrl,'snsapi_userinfo');
                Header("Location: $url");


                // session("sendid",null);
                // $returnurl=cookie("returnurl");
                // $url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'];
                // $get_token_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri='.$url.'&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect';
                // $sendid=M('wxsenddata')->add(array('appid'=>$appid,'sourceurl'=>urldecode($returnurl),'redirect_uri'=>$url,'inputtime'=>date("Y-m-d H:i:s")));
                // session("sendid",$sendid);
                // Header("Location: {$get_token_url}");
                exit();
            }else{
                // $code = $_GET['code'];
                // $get_openid_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
                // $res = file_get_contents($get_openid_url);
                // $user_obj = json_decode($res, true);
                // $openId=$user_obj["openid"];

                $code = $_GET['code'];
                $get_user_url = $this->__CreateOauthUrlForOpenid($code);

                $user_obj_res = file_get_contents($get_user_url);
                $user_obj = json_decode($user_obj_res, true);

                $get_user_info_url = $this->__CreateGetUserInfoUrl($user_obj["access_token"],$user_obj["openid"]);
   
                $res = file_get_contents($get_user_info_url);
 
                $user_info_obj = json_decode($res, true);

                // $access_token=S("access_token");
                // if(empty($access_token)){
                //     $get_access_token_url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $secret;
                //     $res1 = file_get_contents($get_access_token_url);
                //     $user_obj1 = json_decode($res1, true);
                //     $access_token=$user_obj1["access_token"];
                //     S("access_token",$access_token,7200);
                // }
                
                // $get_user_info_url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openId."&lang=zh_CN";
                // $user_info = file_get_contents($get_user_info_url);
                // $user_info_obj = json_decode($user_info, true);
                // $sendid=session("sendid");
                // M('wxbackdata')->add(array('sendid'=>$sendid,'code'=>$code,'access_token'=>$access_token,'openId'=>$openId,'user_info'=>$user_info,'inputtime'=>date("Y-m-d H:i:s")));
                $invitecode=session("invitecode");
                // \Think\Log::write("invitecode:".$invitecode,'WARN');
                $tuijianuser=M('member')->where(array('tuijiancode'=>$invitecode))->find();
                $groupid_id=0;
                if($tuijianuser&&!empty($invitecode)){
                    $groupid_id = $tuijianuser['id'];
                }
                // \Think\Log::write("groupid_id:".$groupid_id,'WARN');
                // if(empty($user_info_obj)){
                //     $get_user_info_url="https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openId."&lang=zh_CN";
                //     $user_info = file_get_contents($get_user_info_url);
                //     $user_info_obj = json_decode($user_info, true);
                //     M('wxbackdata')->add(array('sendid'=>$sendid,'code'=>$code,'access_token'=>$access_token,'openId'=>$openId,'user_info'=>$user_info,'inputtime'=>date("Y-m-d H:i:s")));
                // }

                $user=M('Member')->where(array('username'=>$user_info_obj['unionid']))->find();

                if($user){

                    session("uid",$user['id']);
                    //if($user_info_obj['subscribe']==1){
                        $data=array(
                            'nickname'=>$user_info_obj['nickname'],
                            'sex'=>intval($user_info_obj['sex']),
                            'nickname'=>$user_info_obj['nickname'],
                            'sex'=>intval($user_info_obj['sex']),
                            'head'=>$user_info_obj['headimgurl']
                            );
                        D('Member')->where(array('id'=>$user['id']))->editUser($data);
                    //}
                }else{
 
                    $data=array(
                            'openid'=>$user_info_obj['openid'],
                            'username'=>$user_info_obj['unionid'],
                            'password'=>"123456",
                            'groupid_id'=>$groupid_id,
                            'nickname'=>$user_info_obj['nickname'],
                            'sex'=>intval($user_info_obj['sex']),
                            'head'=>$user_info_obj['headimgurl'],
                            'unionid'=>$user_info_obj['unionid']
                            );
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
        }else{
            $returnurl=cookie("returnurl");
            if(!empty($returnurl)){
                $returnurl=urldecode($returnurl);
                Header("Location: {$returnurl}");
            }else{
                $this->redirect("Wx/Member/index");
            }
        }

    }
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }
    
    private function __CreateOauthUrlForCode($redirectUrl,$scope='snsapi_base')
    {
        $urlObj["appid"] = $this->appid;
        $urlObj["redirect_uri"] = "$redirectUrl";
        $urlObj["response_type"] = "code";
        $urlObj["scope"] = $scope;
        $urlObj["state"] = "STATE"."#wechat_redirect";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
    }
    
    private function __CreateOauthUrlForOpenid($code)
    {
        $urlObj["appid"] = $this->appid;
        $urlObj["secret"] = $this->appsecret;
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }
    private function __CreateGetUserInfoUrl($access_token,$openId){
        $urlObj["access_token"] = $access_token;
        $urlObj["openid"] = $openId;
        $urlObj["lang"] = "zh_CN";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/userinfo?".$bizString;
    }
}
