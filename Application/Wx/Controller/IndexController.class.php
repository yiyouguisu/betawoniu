<?php
namespace Wx\Controller;
use Wx\Common\CommonController;

class IndexController extends CommonController {

    public function index() {
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
              	dump($user_info_obj);die;
                
            }
        $this->display();
    }
    public function test(){
    	$pool=M('pool')->where(array('id'=>array('elt',114)))->select();
    	foreach ($pool as $key => $value) {
    		# code...
    		$code=sprintf("%06d", $value['id']);
    		M('pool')->where(array('id'=>array('eq',$value['id'])))->setField("code",$code);
    	}
    }
}
