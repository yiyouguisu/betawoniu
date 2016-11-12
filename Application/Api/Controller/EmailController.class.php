<?php

namespace Api\Controller;

use Api\Common\CommonController;

class EmailController extends CommonController {

    var $mailconfig;
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
            if($r['groupid'] == 2){
                $this->mailconfig[$r['varname']] = $r['value'];
            }
        }
    }
    /**
     * 根据用户输入的Email跳转到相应的电子邮箱首页
     * @param String $mail  邮箱地址
     * @return String
     */
    public function gotomail($mail) {
        $t = explode('@', $mail);
        $t = strtolower($t[1]);
        if ($t == '163.com') {
            return 'http://mail.163.com';
        } else if ($t == 'vip.163.com') {
            return 'http://vip.163.com';
        } else if ($t == '126.com') {
            return 'http://mail.126.com';
        } else if ($t == 'qq.com' || $t == 'vip.qq.com' || $t == 'foxmail.com') {
            return 'http://mail.qq.com';
        } else if ($t == 'gmail.com') {
            return 'http://mail.google.com';
        } else if ($t == 'sohu.com') {
            return 'http://mail.sohu.com';
        } else if ($t == 'tom.com') {
            return 'http://mail.tom.com';
        } else if ($t == 'vip.sina.com') {
            return 'http://vip.sina.com';
        } else if ($t == 'sina.com.cn' || $t == 'sina.com') {
            return 'http://mail.sina.com.cn';
        } else if ($t == 'tom.com') {
            return 'http://mail.tom.com';
        } else if ($t == 'yahoo.com.cn' || $t == 'yahoo.cn') {
            return 'http://mail.cn.yahoo.com';
        } else if ($t == 'tom.com') {
            return 'http://mail.tom.com';
        } else if ($t == 'yeah.net') {
            return 'http://www.yeah.net';
        } else if ($t == '21cn.com') {
            return 'http://mail.21cn.com';
        } else if ($t == 'hotmail.com') {
            return 'http://www.hotmail.com';
        } else if ($t == 'sogou.com') {
            return 'http://mail.sogou.com';
        } else if ($t == '188.com') {
            return 'http://www.188.com';
        } else if ($t == '139.com') {
            return 'http://mail.10086.cn';
        } else if ($t == '189.cn') {
            return 'http://webmail15.189.cn/webmail';
        } else if ($t == 'wo.com.cn') {
            return 'http://mail.wo.com.cn/smsmail';
        } else {
            return "http://mail." . $t;
        }
    }
    /**
     * 系统邮件模版
     * @param string $type    邮件模版代号 email_reg注册激活email_password密码找回
     * @param string $username 用户名
     * @param string $link 链接
     * @return string $body 邮件主题
     */
    public function mail_template($type, $username, $company, $companynumber, $link) {
        $body = D("Config")->where('varname="' . $type . '"')->getField("value");
        if(!empty($username)){
            $body = str_replace("{#username#}", $username, $body);
        }
        if(!empty($link)){
            $body = str_replace("{#link#}", $link, $body);
        }
        if(!empty($company)){
            $body = str_replace("{#company#}", $company, $body);
        }
        if(!empty($companynumber)){
            $body = str_replace("{#companynumber#}", $companynumber, $body);
        }
        return $body;
    }
    /**
     * 系统邮件发送函数
     * @param string $to    接收邮件者邮箱
     * @param string $name  接收邮件者名称
     * @param string $subject 邮件主题
     * @param string $body    邮件内容
     * @param string $attachment 附件列表
     * @return boolean
     */
    public function send_mail($to, $name, $subject = '', $body = '', $attachment = null) {
        import("Vendor.PHPMailer.phpmailer");
        $mail = new \PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->IsSMTP();
        $mail->SMTPDebug = true;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = $this->mailconfig['mail_server'];
        $mail->Port = $this->mailconfig['mail_port'];
        $mail->Username = $this->mailconfig['mail_user'];
        $mail->Password = $this->mailconfig['mail_password'];
        $mail->SetFrom($this->mailconfig['mail_from'], $this->mailconfig['mail_fname']);
        $replyEmail = $this->mailconfig['mail_from'];
        $replyName = $this->mailconfig['mail_fname'];
        $mail->AddReplyTo($replyEmail, $replyName);
        $mail->Subject = $subject;
        $mail->MsgHTML($body);
        $mail->AddAddress($to, $name);
        if (is_array($attachment)) {
            foreach ($attachment as $file) {
                is_file($file) && $mail->AddAttachment($file);
            }
        }else{
            is_file($attachment) && $mail->AddAttachment($attachment);
        }
        return $mail->Send() ? true : $mail->ErrorInfo;
    }


}
