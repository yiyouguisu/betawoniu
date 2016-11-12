<?php

namespace Api\Controller;

use Api\Common\CommonController;

class RefundController extends CommonController {

    var $pay_config;
    public function _initialize(){
        parent::_initialize();
        $this->Configobj = D("Config");
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=$this->Configobj->order(array('id'=>'desc'))->select();
            F("web_config",$ConfigData);
        }
        foreach ($ConfigData as $r) {
            if($r['groupid'] == 5){
                $this->pay_config[$r['varname']] = $r['value'];
            }
        }
    }
    public function refund($transaction_id,$total,$money,$orderid,$channel){
        switch ($channel)
        {
            case "alipay":
                $this->alipay_refund($transaction_id,$total,$money,$orderid);
                break;
            case "wxpay":
                $this->weixin_refund($transaction_id,$total,$money,$orderid);
                break;
            case "unionpay":
                $this->union_refund($transaction_id,$total,$money,$orderid);
                break;
        }
    }
    public function weixin_refund($transaction_id,$total,$money,$orderid){
        Vendor('Wxpay.lib.WxPay#Api');
        $WxPayApi = new \WxPayApi();
        $WxPayConfig=array(
             'APPID' => 'wxea98c16a0c02eefa',
             'MCHID' => '1354896002'
            );
        $money="0.01";
        $total="0.01";
        $input = new \WxPayRefund();
        $input->SetAppid($WxPayConfig['APPID']);
        $input->SetMch_id($WxPayConfig['MCHID']);
        $input->SetTransaction_id($transaction_id);
        $input->SetTotal_fee($total*100);
        $input->SetRefund_fee($money*100);
        $input->SetOut_refund_no($orderid);
        $input->SetOp_user_id($WxPayConfig['MCHID']);

        M('thirdparty_send')->add(array(
            'data'=>serialize($input),
            'type'=>"wxrefund",
            'ispc'=>1,
            'inputtime'=>time()
            ));

        $data=$WxPayApi->refund($input);
        $result_code=$data['result_code'];
        if ($result_code == "SUCCESS") {
            $status = self::checkorderstatus($data['out_refund_no']);
            if (!$status) {
                $parameter = array(
                    "out_refund_no" => $data['out_refund_no'], //商户订单编号；
                    "refund_id" => $data['refund_id'],
                    "refund_fee" => $data['refund_fee']/100, //交易金额；
                    "refund_status" => $result_code, //交易状态
                    "sign" => $data['sign'], //通知校验ID。
                    "refund_time" => date("Y-m-d H:i:s", time()), //通知的发送时间。
                );
                self::orderhandle($parameter);
            }
        }
        return $data;
    }
    public function union_refund($transaction_id,$total,$money,$orderid){
        Vendor('Union.utf8.func.common');
        Vendor('Union.utf8.func.SDKConfig');
        Vendor('Union.utf8.func.secureUtil');
        Vendor('Union.utf8.func.httpClient');

        $UnionPayConfig=array(
             'merId' => '898320548160545',
             'BACK_NOTIFY_URL'=>'http://' . $_SERVER['HTTP_HOST'] .U('Api/Refund/unionnotify'),
             'SDK_BACK_TRANS_URL'=>'https://gateway.95516.com/gateway/api/backTransReq.do'
             );
        $money="0.01";
        $total="0.01";
        $total_fee = $money*100; 
        $params = array(
                'version' => '5.0.0',       //版本号
                'encoding' => 'utf-8',      //编码方式
                'certId' => getSignCertId (),   //证书ID  
                'signMethod' => '01',       //签名方法
                'txnType' => '04',      //交易类型  
                'txnSubType' => '00',       //交易子类
                'bizType' => '000201',      //业务类型
                'accessType' => '0',        //接入类型
                'channelType' => '07',      //渠道类型
                'orderId' => $orderid,    //商户订单号，重新产生，不同于原消费
                'merId' => $UnionPayConfig['merId'],   //商户代码，请修改为自己的商户号
                'origQryId' => $transaction_id,    //原消费的queryId，可以从查询接口或者通知接口中获取
                'txnTime' => date('YmdHis'),    //订单发送时间，重新产生，不同于原消费
                'txnAmt' => $total_fee,              //交易金额，退货总金额需要小于等于原消费
                'backUrl' => $UnionPayConfig['BACK_NOTIFY_URL'],      //后台通知地址 
                'reqReserved' =>' 透传信息', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
            );
        
        sign ( $params );
        M('thirdparty_send')->add(array(
            'data'=>getRequestParamString ( $params ),
            'type'=>"unionrefundsend",
            'ispc'=>0,
            'inputtime'=>time()
            ));
        $result = sendHttpRequest ( $params, $UnionPayConfig['SDK_BACK_TRANS_URL'] );
        
        $result_arr = coverStringToArray ( $result );
        //dump($result_arr);die;
        M('thirdparty_data')->add(array(
          'post'=>serialize($result_arr),
          'type'=>"unionrefundback",
          'ispc'=>0,
          'inputtime'=>time()
          ));
        return $result_arr;
    }
    public function unionnotify() {
        Vendor('Union.utf8.func.common');
        Vendor('Union.utf8.func.secureUtil');
        M('thirdparty_data')->add(array(
            'post'=>serialize($_POST),
            'type'=>"unionrefundbacknotify",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        if (verify ( $_POST )) {
            $respCode=$_POST['respCode'];
            if ($respCode == "00") {
                $orderid=$_POST['orderId'];
                $status = self::checkorderstatus($orderid);
                if (!$status) {
                    $parameter = array(
                        "out_refund_no" => $orderid, //商户订单编号；
                        "refund_id" => $_POST['queryId'],
                        "total_fee" => $_POST['txnAmt']/100, //交易金额；
                        "refund_status" => $respCode, //交易状态
                        "refund_time" => date("Y-m-d H:i:s", time()), //通知的发送时间。
                    );
                    self::orderhandle($parameter);
                }
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "error";
        }
    }
    public function alipay_refund($transaction_id,$total,$money,$orderid){
        require_once( VENDOR_PATH . "Alipay/alipay.config.php");
        require_once( VENDOR_PATH . "Alipay/lib/alipay_submit.class.php");
        $AliPayConfig=array(
            'partner' => '2088221764898885',
            'seller_email'=>'3221586551@qq.com'
        );
        $money="0.01";
        $total="0.01";
        $notify_url = 'http://' . $_SERVER['HTTP_HOST'] .U('Api/Refund/alipaynotify');
        $seller_email = $AliPayConfig['seller_email'];
        $refund_date = date("Y-m-d H:i:s", time());
        $batch_no = $orderid;
        $batch_num = 1;
        $detail_data = $transaction_id."^".$money."^协商退款";

        $parameter = array(
                "service" => "refund_fastpay_by_platform_pwd",
                "partner" => trim($AliPayConfig['partner']),
                "notify_url"    => $notify_url,
                "seller_email"  => $seller_email,
                "refund_date"   => $refund_date,
                "batch_no"  => $batch_no,
                "batch_num" => $batch_num,
                "detail_data"   => $detail_data,
                "_input_charset"    => 'utf-8'
        );
        M('thirdparty_send')->add(array(
            'data'=>serialize($parameter),
            'type'=>"alipayrefund",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        //建立请求
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }
    public function alipaynotify(){
        require_once( VENDOR_PATH . "Alipay/alipay.config.php");
        require_once( VENDOR_PATH . "Alipay/lib/alipay_notify.class.php");
        $AliPayConfig=array(
            'partner' => '2088221764898885',
        );
        $alipayNotify = new \AlipayNotify($alipay_config);
        $verify_result = $alipayNotify->verifyNotify();
        M('thirdparty_data')->add(array(
            'post'=>serialize($_POST),
            'type'=>"alipayrefundnotify",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        if ($verify_result) {
            $orderid=$_POST['batch_no'];

            $success_num = $_POST['success_num'];
            $parameter = array(
                "out_refund_no" => $orderid, //商户订单编号；
                "refund_id" => "",
                "refund_time" => date("Y-m-d H:i:s", time()), //通知的发送时间。
            );
            $status = self::checkorderstatus($orderid);
            if (!$status) {
                self::orderhandle($parameter);
            }
            echo "success";
        } else {
            echo "fail";
        }
    }
    static public function orderhandle($parameter){
        $ret=$parameter;
        $out_refund_no=trim($ret['out_refund_no']);
        $refund_id=trim($ret['refund_id']);
        $order=M('refund_apply')->where(array('refundorderid'=>$out_refund_no))->find();

        $id=M('refund_apply')->where(array('refundorderid'=>$out_refund_no))->save(array(
            'refund_id'=>$refund_id,
            'refund_status'=>1,
            'refund_time'=>date("Y-m-d H:i:s"),
            'paynotifydata'=>json_encode($ret)
        ));
    }
    static public function checkorderstatus($orderid) {
        $ordstatus = M('refund_apply')->where('refundorderid=' . $orderid)->getField('refund_status');
        if ($ordstatus == 1) {
            return true;
        } else {
            return false;
        }
    }

}