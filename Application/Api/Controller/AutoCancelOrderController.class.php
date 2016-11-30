<?php

namespace Api\Controller;

use Api\Common\CommonController;

class AutoCancelOrderController extends CommonController {
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
	
	public function cancelorder(){
        $strOut="";
        $time=strtotime("-30 minutes");
        $where=array('c.pay_status'=>0,'a.inputtime'=>array('lt',$time));
        $field=array('a.orderid,a.uid,a.ordertype');
        $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                          ->where($where)
                          ->field($field)
                          ->select();
        foreach ($data as $value)
        {
        	$id=M('order_time')->where(array('orderid'=>$value['orderid']))->save(array(
                'status'=>3,
                'cancel_status'=>1,
                'cancel_time'=>time()
            ));
            if($id){
                $strOut.="系统自动取消订单处理成功\r\n";
            }else{
                $strOut.="系统自动取消订单处理失败\r\n";
            }
        }
        $log = array(
	        "task_info" => $strOut,
	        "add_time" => date("Y-m-d H:i:s"),
	        "run_time" => (microtime(true)-$this->runTime_1)
	    );
	    M("task_log")->add($log);


        $strOut="";
        $time=strtotime("-25 minutes");
        $where=array('c.pay_status'=>0,'a.inputtime'=>array('lt',$time));
        $field=array('a.orderid,a.uid,a.ordertype');
        $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                          ->where($where)
                          ->field($field)
                          ->select();
        $Ymsms = A("Api/Ymsms");
        foreach ($data as $value)
        {
            if($value['ordertype']==1){
                $hostel=M('book_room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.orderid'=>$value['orderid']))->find();
                $content=$Ymsms->getsmstemplate("sms_waitpay_hostel",array('hostel'=>$hostel['title']));
                $data=json_encode(array('content'=>$content,'type'=>"sms_waitpay_hostel",'r_id'=>$order['uid']));
            }else if($value['ordertype']==2){
                $party=M('activity_apply a')->join("left join zz_activity b on a.aid=b.id")->where(array('a.orderid'=>$value['orderid']))->find();
                $content=$Ymsms->getsmstemplate("sms_waitpay_party",array('party'=>$party['title']));
                $data=json_encode(array('content'=>$content,'type'=>"sms_waitpay_party",'r_id'=>$order['uid']));
            }
            $statuscode=$Ymsms->sendsms($data);
        }
    }
}