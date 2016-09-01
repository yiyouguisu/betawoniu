<?php

namespace Api\Controller;

use Api\Common\CommonController;

class YmsmsController extends CommonController {

	var $sms_config;

	public function _initialize(){
        parent::_initialize();
		set_time_limit(0);
        $this->Configobj = D("Config");
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=$this->Configobj->order(array('id'=>'desc'))->select();
            F("web_config",$ConfigData);
        }
        foreach ($ConfigData as $r) {
            if($r['groupid'] == 5){
                $this->sms_config[$r['varname']] = $r['value'];
            }
        }
    }
    public function test(){
    	//$statuscode=self::sendsms_get("15225071509","【蜗牛客】您的验证码是：：1234，请在五分钟内输入！");
        $ret = '{"phone":"18221265103","content":"sdjfdsljfsdljflsdj"}';
        $statuscode=self::sendbsmsapi($ret);
        echo $statuscode;
    }
	public function sendsmsapi($ret){
		$ret=json_decode($ret,true);
		$phone=$ret['phone'];
        if(is_array($phone)){
            $phone=implode(",",$phone);
        }
		$content=trim($ret['content']);
		$statuscode=self::sendsms_post($phone,$content);
        $ret['inputtime']=time();
        M('sms')->add($ret);
        return $statuscode;
	}
    public function sendbsmsapi($ret){
        $ret=json_decode($ret,true);
        $phone=$ret['phone'];
        if(is_array($phone)){
            $phone=implode(",",$phone);
        }        
        $content=trim($ret['content']);
        $statuscode=self::sendbsms_post($phone,$content);
        $ret['inputtime']=time();
        M('sms')->add($ret);
        \Think\Log::write("statuscode:{$statuscode}",'WARN');
        return $statuscode;
    }
    public function sendsms($ret){
        $ret=json_decode($ret,true);
        $uid=$ret['r_id'];
        $ret['phone']=M('Member')->where(array('id'=>$uid))->getField("phone");
        $content=trim($ret['content']);
        $statuscode=self::sendsms_post($ret['phone'],$content);
        $ret['inputtime']=time();
        M('sms')->add($ret);
        return $statuscode;
    }
    public function getsmstemplate($varname,$parm=array()){
        $content=M('config')->where(array('groupid'=>9,'varname'=>$varname))->getField("value");
        foreach ($parm as $key => $value)
        {
            $content=str_replace("{#".$key."#}",$value,$content);
        }
        return $content;
    }
    public function reg_service(){
        $url="http://hprpt2.eucp.b2m.cn:8080/sdkproxy/regist.action?";
        $url.="cdkey=".$this->sms_config['smsUser'];
        $url.="&password=".$this->sms_config['smsPass'];
        $result=file_get_contents($url);
        return $result;
    }
    public function querybalance(){
        $url="http://hprpt2.eucp.b2m.cn:8080/sdkproxy/querybalance.action?";
        $url.="cdkey=".$this->sms_config['smsUser'];
        $url.="&password=".$this->sms_config['smsPass'];
        $result=file_get_contents($url);
        return $result;
    }
    
    public function logout(){
        $url="http://hprpt2.eucp.b2m.cn:8080/sdkproxy/logout.action?";
        $url.="cdkey=".$this->sms_config['smsUser'];
        $url.="&password=".$this->sms_config['smsPass'];
        $result=file_get_contents($url);
        return $result;
    }
    public function sendsms_get($phone,$content){
        $url="http://hprpt2.eucp.b2m.cn:8080/sdkproxy/sendsms.action?";
        $url.="cdkey=".$this->sms_config['smsUser'];
        $url.="&password=".$this->sms_config['smsPass'];
        $url.="&phone=".$phone;
        $url.="&message=".$content;
        $result=file_get_contents($url);
        return $result;
    }

	public function sendsms_post($phone,$content){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, "http://hprpt2.eucp.b2m.cn:8080/sdkproxy/sendsms.action");
        $data=array(
            'cdkey'=>$this->sms_config['smsUser'],
            'password'=>$this->sms_config['smsPass'],
            'phone'=>$phone,
            'message'=>$content
            );

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $return_content;

    }
    public function sendbsms_post($phone,$content){
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, "http://sdktaows.eucp.b2m.cn:8080/sdkproxy/sendsms.action");
        $data=array(
            'cdkey'=>$this->sms_config['bsmsUser'],
            'password'=>$this->sms_config['bsmsPass'],
            'phone'=>$phone,
            'message'=>$content
            );
        \Think\Log::write("sms:{$data["cdkey"]},{$data["password"]},{$data["phone"]},{$data["message"]}",'WARN');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $return_content;

    }
}