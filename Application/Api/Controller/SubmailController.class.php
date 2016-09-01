<?php

namespace Api\Controller;

use Api\Common\CommonController;

class SubmailController extends CommonController {
    var $submail_config;
    public function _initialize(){
        parent::_initialize();
        set_time_limit(0);
        Vendor("SUBMAIL.SUBMAILAutoload");
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=D("Config")->order(array('id'=>'desc'))->select();
            F("web_config",$ConfigData);
        }
        foreach ($ConfigData as $r) {
            if($r['groupid'] == 5){
                $this->submail_config[$r['varname']] = $r['value'];
            }
        }
    }
    private function getsmstemplate($varname,$parm=array()){
        $content=M('config')->where(array('groupid'=>4,'varname'=>$varname))->getField("value");
        foreach ($parm as $key => $value)
        {
            $content=str_replace("{#".$key."#}",$value,$content);
        }
        return $content;
    }
    public function sendSMS($receiver,$projectid,$AddVar=array()){
        $message_configs['appid']=$this->submail_config['submail_message_appid'];
        $message_configs['appkey']=$this->submail_config['submail_message_appkey'];
        $message_configs['sign_type']='normal';
        
        $submail=new \MESSAGEXsend($message_configs);
        $submail->setTo($receiver);
        $submail->SetProject($projectid);
        if(!empty($AddVar)){
            foreach ($AddVar as $key => $value) {
                # code...
                $submail->AddVar($key, $value);
            }
        }
        $xsend=$submail->xsend();
        return $xsend;
    }
    //$contacts=array(
    //             array(
    //                   "to"=>"18*********",
    //                   "vars"=>array(
    //                                 "name"=>"jack",
    //                                 "code1"=>"FAD62979791",
    //                                 "code1"=>"FAD62979792",
    //                                 )
    //                   ),
    //             array(
    //                   "to"=>"15*********",
    //                   "vars"=>array(
    //                                 "name"=>"tom",
    //                                 "code1"=>"FAD62979793",
    //                                 "code1"=>"FAD62979794",
    //                                 )
    //                   )
    //             );
    public function sendMultiSMS($mbox=array(),$projectid){
        $message_configs['appid']=$this->submail_config['submail_message_appid'];
        $message_configs['appkey']=$this->submail_config['submail_message_appkey'];
        $message_configs['sign_type']='normal';
        
        $submail=new \MESSAGEMultiXsend($message_configs);
        foreach($mbox as $contact){
            $multi=new \Multi();
            $multi->setTo($contact['to']);
            foreach($contact['vars'] as $key=>$value){
                $multi->addVar($key,$value);
            }
            $submail->addMulti($multi->build());
        }
        $submail->SetProject($projectid);
        $xsend=$submail->multixsend();
        return $xsend;
    }

    public function sendMAIl($receiver,$projectid,$AddVar=array()){
        $mail_configs['appid']=$this->submail_config['submail_mail_appid'];
        $mail_configs['appkey']=$this->submail_config['submail_mail_appkey'];
        $mail_configs['sign_type']='normal';
        
        $submail=new \MAILXsend($mail_configs);
        $submail->AddTo($receiver);
        $submail->SetProject($projectid);
        if(!empty($AddVar)){
            foreach ($AddVar as $key => $value) {
                # code...
                $submail->AddVar($key, $value);
            }
        }
        $xsend=$submail->xsend();
        return $xsend;
    }

    //$contacts=array("12331@qq.com","1233dfdas@qq.com");
    public function sendMultiMAIl($mbox=array(),$projectid,$AddVar=array()){
        $mail_configs['appid']=$this->submail_config['submail_mail_appid'];
        $mail_configs['appkey']=$this->submail_config['submail_mail_appkey'];
        $mail_configs['sign_type']='normal';
        
        $submail=new \MAILXsend($mail_configs);
        foreach($mbox as $contact){
            $submail->AddTo($contact);
        }
        $submail->SetProject($projectid);
        if(!empty($AddVar)){
            foreach ($AddVar as $key => $value) {
                # code...
                $submail->AddVar($key, $value);
            }
        }
        $xsend=$submail->xsend();
        return $xsend;
    }

    public function testsms(){
        $Submail=A("Api/Submail");
        $AddVar=array("code"=>"1234");
        $sendresult=$Submail->sendSMS("15225071509","r3rL52",$AddVar);
        dump($sendresult);
    }

    public function testemail(){
        $Submail=A("Api/Submail");
        $AddVar=array("code"=>"1234");
        $sendresult=$Submail->sendMAIl("2391157750@qq.com","r3rL52",$AddVar);
        dump($sendresult);
    }
}


