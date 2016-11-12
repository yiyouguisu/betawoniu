<?php

namespace Api\Controller;

use Api\Common\CommonController;

class AutoUpdateAccountController extends CommonController {
	var $runTime_1;

    public function _initialize(){
    	$this->runTime_1 = microtime(true);
        parent::_initialize();
        set_time_limit(0);
    }
	
	public function updateaccount(){
        $strOut="";
        $where=array('c.pay_status'=>1,'c.updateaccount_status'=>0);
        $field=array('a.orderid,a.money,a.ordertype');
        $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                          ->where($where)
                          ->field($field)
                          ->select();
        foreach ($data as $value)
        {   
            switch ($value['ordertype']) {
                case '1':
                    # code...
                    $productinfo=M('book_room a')
                        ->join("left join zz_room c on a.rid=c.id")
                        ->join("left join zz_hostel b on c.hid=b.id")
                        ->where(array('a.orderid'=>$value['orderid']))
                        ->field("a.starttime,a.endtime,a.paystatus,b.uid as houseownerid")
                        ->find();

                    break;
                case '2':
                    # code...
                    $productinfo=M('activity_apply a')
                        ->join("left join zz_activity b on a.aid=b.id")
                        ->where(array('a.orderid'=>$value['orderid']))
                        ->field("a.starttime,a.endtime,a.paystatus,b.uid as houseownerid")
                        ->find();
                    break;
            }
            if($productinfo['endtime']<time()){
                $money=$value['money'];
                $account=M('account')->where(array('uid'=>$productinfo['houseownerid']))->find();

                $mid=M('account')->where(array('uid'=>$productinfo['houseownerid']))->save(array(
                    'usemoney'=>$account['usemoney']+floatval($money),
                    'waitmoney'=>$account['waitmoney']-floatval($money),
                    ));
                if($mid){
                  switch ($value['ordertype']) {
                    case '1':
                        M('account_log')->add(array(
                          'uid'=>$productinfo['houseownerid'],
                          'type'=>'updateaccount',
                          'money'=>$money,
                          'total'=>$account['total'],
                          'usemoney'=>$account['usemoney']+floatval($money),
                          'waitmoney'=>$account['waitmoney']-floatval($money),
                          'status'=>1,
                          'dcflag'=>1,
                          'remark'=>'用户成功离店获取房费',
                          'addip'=>get_client_ip(),
                          'addtime'=>time()
                          ));
                         break;
                    case '2':
                        M('account_log')->add(array(
                          'uid'=>$productinfo['houseownerid'],
                          'type'=>'updateaccount',
                          'money'=>$money,
                          'total'=>$account['total'],
                          'usemoney'=>$account['usemoney']+floatval($money),
                          'waitmoney'=>$account['waitmoney']-floatval($money),
                          'status'=>1,
                          'dcflag'=>1,
                          'remark'=>'用户成功参加活动获取报名费',
                          'addip'=>get_client_ip(),
                          'addtime'=>time()
                          ));
                        break;
                }

                $id=M('order_time')->where(array('orderid'=>$value['orderid']))->save(array(
                    'updateaccount_status'=>1,
                    'updateaccount_time'=>time()
                ));
                if($id){
                    $strOut.="系统自动更新房东账户余额处理成功\r\n";
                }else{
                    $strOut.="系统自动更新房东账户余额处理失败\r\n";
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