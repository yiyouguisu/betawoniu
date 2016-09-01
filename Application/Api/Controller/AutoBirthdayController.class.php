<?php

namespace Api\Controller;

use Api\Common\CommonController;

class AutoBirthdayController extends CommonController {
	var $runTime_1;
	protected $Config, $ConfigData;

    public function _initialize(){
    	$this->runTime_1 = microtime(true);
        parent::_initialize();
        set_time_limit(0);
        $this->Config = D("Config");
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=$this->Config->order(array('id'=>'desc'))->select();
            F("web_config",$ConfigData);
        }
    }
	
	public function birthdaypush(){
        $strOut="";
        $time=strtotime("+3 days");
        $data=M('member')->where(array('_string'=>"birthday <> ''"))->select();
        $Vouchers= M("Vouchers")->where(array('id'=>6))->find();
        foreach ($data as $value)
        {
            $birthdayset=explode("-", $value['birthday']);
            $month=sprintf("%02d", date("m",$time));
            $day=sprintf("%02d", date("d",$time));

            $status=M('Vouchers_order')->where(array('catid'=>6,'_string'=>'year(FROM_UNIXTIME( inputtime )) = '.date("Y")))->find();
            if(empty($status)){
                if(($month==$birthdayset[1])&&($day==$birthdayset[2])){
                    $vouchers_order_id=M("Vouchers_order")->add(array(
                        'catid'=>6,
                        'uid'=>$value['id'],
                        'num'=>1,
                        'price'=>$Vouchers['price'],
                        'hid'=>$Vouchers['hid'],
                        'aid'=>$Vouchers['aid'],
                        'status'=>0,   
                        'inputtime'=>time(),
                        'updatetime'=>time()
                        ));
                    if($vouchers_order_id){
                        $url='http://' . $_SERVER['HTTP_HOST'] . U('Web/Coupons/bcoupone',array('id'=>$vouchers_order_id));
                        \Api\Controller\UtilController::addmessage($order['uid'],"获取生日券","蜗牛客恭祝您生日快乐！","蜗牛客恭祝您生日快乐！","birthday",$url);
                        $Ymsms = A("Api/Ymsms");
                        $content=$Ymsms->getsmstemplate("sms_birthday");
                        $data=json_encode(array('content'=>$content,'type'=>"sms_birthday",'r_id'=>$order['uid']));
                        $statuscode=$Ymsms->sendsms($data);
                        $strOut.="生日到了，系统自动发放生日券处理成功\r\n";
                    }else{
                        $strOut.="生日到了，系统自动发放生日券处理失败\r\n";
                    }
                }
            }
            
            
        }
        $log = array(
	        "task_info" => $strOut,
	        "add_time" => date("Y-m-d H:i:s"),
	        "run_time" => (microtime(true)-$this->runTime_1)
	    );
	    M("task_log")->add($log);
    }
}