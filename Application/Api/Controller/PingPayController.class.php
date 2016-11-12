<?php

namespace Api\Controller;

use Api\Common\CommonController;

class PingPayController extends CommonController {

    var $pingpay_config;

	public function _initialize(){
        parent::_initialize();
        Vendor("pingpp.init");
        $this->Configobj = D("Config");
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=$this->Configobj->order(array('id'=>'desc'))->select();
            F("web_config",$ConfigData);
        }
        foreach ($ConfigData as $r) {
            if($r['groupid'] == 5){
                $this->pingpay_config[$r['varname']] = $r['value'];
            }
        }
    }
    public function pingpp($orderid,$title,$body,$money,$channel){
        $extra = array();
        $orderid=$orderid.rand(100000, 999999);
        $money=0.01;
        \Pingpp\Pingpp::setApiKey($this->pingpay_config['pingKey']);
        try {
            $ch = \Pingpp\Charge::create(
                array(
                    "subject"   => $title,
                    "body"      => $body,
                    "amount"    => $money*100,
                    "order_no"  => $orderid,
                    "currency"  => "cny",
                    "extra"     => $extra,
                    "channel"   => $channel,
                    "client_ip" => $_SERVER["REMOTE_ADDR"],
                    "app"       => array("id" => $this->pingpay_config['pingAppid'])
                )
            );
            \Think\Log::write('ping++生成支付Charge数据：'.$ch,\Think\Log::INFO);
            M('thirdparty_send')->add(array(
                'data'=>serialize(json_decode($ch,true)),
                'type'=>"ping++",
                'ispc'=>0,
                'inputtime'=>time()
                ));
            return $ch;
        }
        catch (\Pingpp\Error\Base $e) {
            $Status = $e->getHttpStatus();
            $body = $e->getHttpBody();
            return 'Status: ' . $Status ." body:".$body;
        }

    }
    public function pingppcalback(){
        $notifydata = file_get_contents("php://input");
        \Think\Log::write('ping++回调数据：'.$notifydata,\Think\Log::INFO);
        $notify = json_decode($notifydata,true);
        M('thirdparty_data')->add(array(
          'post'=>serialize($notify),
          'type'=>"ping++",
          'ispc'=>0,
          'inputtime'=>time()
          ));
        $notifyarray=$notify['data']['object'];

        if( !isset($notifyarray['object'])){
            exit("fail");
        }
        switch($notifyarray['object']){
            case "charge":
                $orderid=$notifyarray['order_no'];
                $type=substr($orderid,0,2);
                switch ($type)
                {
                    case "ac":
                        M('activity_apply')->where(array('orderid'=> $orderid))->save(array(
                            'paystatus'=>1,
                            'paytime'=>time()
                        ));
                        $data=M('activity_apply')->where(array('orderid'=> $orderid))->find();
                        M("activity")->where(array("id"=> $data['aid']))->setInc("yes_num",$data['num']);
                        exit("success");
                        break;
                    case "hc":
                        M('book_room')->where(array('orderid'=> $orderid))->save(array(
                            'paystatus'=>1,
                            'paytime'=>time()
                        ));
                        $data=M('book_room')->where(array('orderid'=> $orderid))->find();
                        M("room")->where(array("id"=> $data['rid']))->setInc("yes_num",$data['num']);
                        M("room")->where(array("id"=> $data['rid']))->setDec("wait_num",$data['num']);
                        exit("success");
                        break;
                    case "rc":
                        M('recharge')->where(array('orderid'=> $orderid))->save(array(
                            'paystatus'=>1,
                            'paytime'=>time()
                        ));
                        $data=M('recharge')->where(array('orderid'=> $orderid))->find();
                        $account=M("account")->where(array("uid"=>$data['uid']))->find();
                        M("account")->where(array("uid"=>$data['uid']))->save(array(
                            "usemoney"=>$data['money']+$account['usemoney'],
                            "recharemoney"=>$data['money']+$account['recharemoney'],
                            "total"=>$data['money']+$account['total'],
                            ));
                        M('account_log')->add(array(
                            'uid'=>$data['uid'],
                            'type'=>$data['type'].'_recharge',
                            'money'=>$data['money'],
                            'total'=>$account['total']+floatval($data['money']),
                            'usemoney'=>$account['usemoney']+floatval($data['money']),
                            'nousemoney'=>$account['nousemoney'],
                            'status'=>1,
                            'dcflag'=>1,
                            'remark'=>'充值'.$data['money'].'元',
                            'addip'=>get_client_ip(),
                            'addtime'=>time()
                            ));
                        exit("success");
                        break;
                }

            case "refund":
                exit("success");
            default:
                exit("fail");
        }
    }
}
