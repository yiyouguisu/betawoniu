<?php

namespace Api\Controller;

use Api\Common\CommonController;

class PayController extends CommonController {

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

    public function testPay() {
      $this->pay('testorder123456', '测试订单', '测试订单', '0.1', 'aliwap');
    }
    public function pay($orderid,$title,$body,$money,$channel){
        $orderid=$orderid.rand(100000, 999999);
        switch ($channel)
        {
            case "alipay":
                $this->alipay_apppay($orderid,$title,$body,$money);
                break;
            case "wxpay":
                $this->weixin_apppay($orderid,$title,$body,$money);
                break;
            case "wxh5":
                $this->wxMobileWebPay($orderid,$title,$body,$money);
                break;
            case "unionpay":
                $this->union_apppay($orderid,$title,$body,$money);
                break;
            case "aliwap":
              $this->alipay_wappay($orderid,$title,$body,$money);
              break;
        }
    }
    public function alipay_wappay($orderid,$title,$body,$money) {
      require_once( VENDOR_PATH . "Alipay/alipay.config.php");
      require_once( VENDOR_PATH . "Alipay/lib/alipay_submit.class.php");

      //商户订单号，商户网站订单系统中唯一订单号，必填
      $out_trade_no = $orderid;//$_POST['WIDout_trade_no'];
      
      //订单名称，必填
      $subject = $title;//$_POST['WIDsubject'];
     
      //付款金额，必填
      $total_fee = '0.01';//$_POST['WIDtotal_fee'];
      
      //收银台页面上，商品展示的超链接，必填
      $show_url = "http://beta.nclouds.net/index.php/Web/Note/show/id/272.html";//$_POST['WIDshow_url'];
     
      //商品描述，可空
      //$body = $body;//$_POST['WIDbody'];

      $AliPayConfig=array(
          'partner' => '2088221764898885',
          'seller_id'=>'3221586551@qq.com'
      );

      $parameter = array(
          "partner" => trim($AliPayConfig['partner']),
          "seller_id" => $AliPayConfig['seller_id'],
          "out_trade_no" => $orderid,
          "subject" => "test",
          "body" => "test",
          "total_fee" => "0.01",
          "notify_url" => 'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/alipaynotify'),
          "service" => "alipay.wap.create.direct.pay.by.user",
          "payment_type" => "1",
          "_input_charset" => 'utf-8',
      );

      M('thirdparty_send')->add(array(
          'data'=>serialize($parameter),
          'type'=>"alipay",
          'ispc'=>1,
          'inputtime'=>time()
          ));
      $alipaySubmit = new \AlipaySubmit($alipay_config);
      $html_txt = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
      echo $html_txt;
    }
    public function weixin_apppay($orderid,$title,$body,$money){
        Vendor('Wxpay.lib.WxPay#Api');
        Vendor('Wxpay.lib.WxPay#JsApiPay');
        $WxPayApi = new \WxPayApi();
        $WxPayConfig=array(
             'APPID' => 'wxea98c16a0c02eefa',
	           'MCHID' => '1354896002',
	           'KEY' => 'shanghainonglvxinxiwoniuke201606',
             'NOTIFY_URL'=>'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/weixinnotify')
            );
        $money="0.01";
        $tools = new \JsApiPay();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($body);
        $input->SetAttach($body);
        $input->SetOut_trade_no($orderid);
        $input->SetTotal_fee($money*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($WxPayConfig['NOTIFY_URL']);
        $input->SetAppid($WxPayConfig['APPID']);
        $input->SetMch_id($WxPayConfig['MCHID']);
        $input->SetTrade_type("APP");
        M('thirdparty_send')->add(array(
            'data'=>serialize($input),
            'type'=>"wxpay",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        $order = $WxPayApi->unifiedOrder($input);
        $jsApiParameters = $tools->GetAPPParameters($order);
        $jsApiParameters=json_decode($jsApiParameters,true);
        $data=array();
        if(!empty($jsApiParameters['sign'])){
            $data['code']=200;
            $data['msg']="success";
            $jsApiParameters['packageStr']=$jsApiParameters['package'];
            unset($jsApiParameters['package']);
            $data['data']=$jsApiParameters;

        }else{
            $data['code']=-200;
            $data['msg']="error";
        }
        echo json_encode($data);
    }
    public function weixinnotify(){
        // require_once VENDOR_PATH."/Wxpay/lib/WxPay.Api.php";
        // require_once VENDOR_PATH."/Wxpay/lib/WxPay.Notify.php";
        Vendor('Wxpay.lib.WxPay#Api');
        Vendor('Wxpay.lib.WxPay#Notify');
        $xml=$GLOBALS['HTTP_RAW_POST_DATA']; 
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);  
        $input = new \WxPayOrderQuery();
        M('thirdparty_data')->add(array(
            'post'=>serialize($data),
            'type'=>"weixinnotify",
            'ispc'=>0,
            'inputtime'=>time()
            ));
        $input->SetTransaction_id($data["transaction_id"]);
        $WxPayApi = new \WxPayApi();
        $result = $WxPayApi->orderQuery($input);
        M('thirdparty_data')->add(array(
            'post'=>serialize($result),
            'type'=>"weixinquery",
            'ispc'=>0,
            'inputtime'=>time()
            ));
        $orderid=$result['out_trade_no'];
        $orderid=substr($orderid,0,strlen($orderid)-6);
        $trade_state=$result['trade_state'];
        if ($trade_state == "SUCCESS") {
            $status = self::checkorderstatus($orderid);
            if (!$status) {
                $parameter = array(
                    "out_trade_no" => $orderid, //商户订单编号；
                    "trade_no" => $result['transaction_id'],
                    "total_fee" => $result['total_fee']/100, //交易金额；
                    "trade_status" => $trade_state, //交易状态
                    "notify_id" => $result['sign'], //通知校验ID。
                    "notify_time" => date("Y-m-d H:i:s", time()), //通知的发送时间。
                );
                self::orderhandle($parameter);
                echo "SUCCESS";
            }else{
                echo "SUCCESS";
            }
        } else {
            echo "FAIL";
        }
    }
    public function union_apppay($orderid,$title,$body,$money){
        // include_once VENDOR_PATH . '/Union/utf8/func/common.php';
        // include_once VENDOR_PATH . '/Union/utf8/func/SDKConfig.php';
        // include_once VENDOR_PATH . '/Union/utf8/func/secureUtil.php';
        // include_once VENDOR_PATH . '/Union/utf8/func/httpClient.php';
        Vendor('Union.utf8.func.common');
        Vendor('Union.utf8.func.SDKConfig');
        Vendor('Union.utf8.func.secureUtil');
        Vendor('Union.utf8.func.httpClient');

        $UnionPayConfig=array(
	         'merId' => '898320548160545',
             'FRONT_NOTIFY_URL'=>'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/unionnotify'),
             'BACK_NOTIFY_URL'=>'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/unionnotify'),
             'App_Request_Url'=>'https://gateway.95516.com/gateway/api/appTransReq.do'
             );
        $total_fee = 1; 
        //$total_fee = $money*100; 
        $params = array(
                'version' => '5.0.0',				//版本号
                'encoding' => 'utf-8',				//编码方式
                'certId' => getSignCertId(),			//证书ID
                'txnType' => '01',				//交易类型	
                'txnSubType' => '01',				//交易子类
                'bizType' => '000201',				//业务类型
                'frontUrl' =>  $UnionPayConfig['FRONT_NOTIFY_URL'],  		//前台通知地址，控件接入的时候不会起作用
                'backUrl' => $UnionPayConfig['BACK_NOTIFY_URL'],		//后台通知地址	
                'signMethod' => '01',		//签名方法
                'channelType' => '08',		//渠道类型，07-PC，08-手机
                'accessType' => '0',		//接入类型
                'merId' => $UnionPayConfig['merId'],	//商户代码，请改自己的测试商户号
                'orderId' => $orderid,	//商户订单号，8-40位数字字母
                'txnTime' => date('YmdHis'),	//订单发送时间
                'txnAmt' => $total_fee,		//交易金额，单位分
                'currencyCode' => '156',	//交易币种
                // 'orderDesc' => $body,  //订单描述，可不上送，上送时控件中会显示该信息
                'reqReserved' =>' 透传信息', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
                );
        
        sign ( $params );
        M('thirdparty_send')->add(array(
            'data'=>getRequestParamString ( $params ),
            'type'=>"unionsend",
            'ispc'=>0,
            'inputtime'=>time()
            ));
        dump($params);
        $result = sendHttpRequest ( $params, $UnionPayConfig['App_Request_Url'] );
        $result_arr = coverStringToArray ( $result );
        M('thirdparty_data')->add(array(
          'post'=>serialize($result_arr),
          'type'=>"unionback",
          'ispc'=>0,
          'inputtime'=>time()
          ));
        $data=array();
        if(verify($result_arr)){
            $data['code']=200;
            $data['msg']="success";
            $data['tn']=$result_arr['tn'];
        }else{
            $data['code']=-200;
            $data['msg']=$result_arr;
        }
        echo json_encode($data);
    }
    public function unionnotify() {
        // include_once VENDOR_PATH . '/Union/utf8/func/common.php';
        // include_once VENDOR_PATH . '/Union/utf8/func/secureUtil.php';

        Vendor('Union.utf8.func.common');
        Vendor('Union.utf8.func.secureUtil');
        M('thirdparty_data')->add(array(
            'post'=>serialize($_POST),
            'type'=>"unionbacknotify",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        if (verify ( $_POST )) {
            $respCode=$_POST['respCode'];
            if ($respCode == "00") {
                $orderid=$_POST['orderId'];
                $orderid=substr($orderid,0,strlen($orderid)-6);
                $status = self::checkorderstatus($orderid);
                if (!$status) {
                    $parameter = array(
                        "out_trade_no" => $orderid, //商户订单编号；
                        "trade_no" => $_POST['queryId'],
                        "total_fee" => $_POST['txnAmt']/100, //交易金额；
                        "trade_status" => $respCode, //交易状态
                        "notify_time" => date("Y-m-d H:i:s", time()), //通知的发送时间。
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
    public function alipay_apppay($orderid,$title,$body,$money){
        require_once( VENDOR_PATH . "Alipay/alipay.config.php");
        require_once( VENDOR_PATH . "Alipay/lib/alipay_submit.class.php");
        $AliPayConfig=array(
            'partner' => '2088221764898885',
            'seller_id'=>'3221586551@qq.com'
        );
        $parameter = array(
            "partner" => trim($AliPayConfig['partner']),
            "seller_id" => $AliPayConfig['seller_id'],
            "out_trade_no" => $orderid,
            "subject" => "test",
            "body" => "test",
            "total_fee" => "0.01",
            "notify_url" => 'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/alipaynotify'),
            "service" => "mobile.securitypay.pay",
            "payment_type" => "1",
            "_input_charset" => 'utf-8',
        );
        M('thirdparty_send')->add(array(
            'data'=>serialize($parameter),
            'type'=>"alipay",
            'ispc'=>1,
            'inputtime'=>time()
            ));

        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $result = $alipaySubmit->buildRequestPara($parameter,true);
        $data=array();
        if(!empty($result['sign'])){
            $data['code']=200;
            $data['msg']="success";
            $data['data']=$result;
        }else{
            $data['code']=-200;
            $data['msg']="error";
        }
        echo json_encode($data);
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
            'type'=>"alipaynotify",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        if ($verify_result) {
            $orderid=$_POST['out_trade_no'];
            $orderid=substr($orderid,0,strlen($orderid)-6);
            $trade_no = $_POST['trade_no'];          //支付宝交易号
            $trade_status = $_POST['trade_status'];      //交易状态
            $total_fee = $_POST['total_fee'];         //交易金额
            $notify_id = $_POST['notify_id'];         //通知校验ID。
            $notify_time = $_POST['notify_time'];       //通知的发送时间。格式为yyyy-MM-dd HH:mm:ss。
            $buyer_email = $_POST['buyer_email'];       //买家支付宝帐号；
            $parameter = array(
                "out_trade_no" => $orderid, //商户订单编号；
                "trade_no" => $trade_no, //支付宝交易号；
                "total_fee" => $total_fee, //交易金额；
                "trade_status" => $trade_status, //交易状态
                "notify_id" => $notify_id, //通知校验ID。
                "notify_time" => $notify_time, //通知的发送时间。
                "buyer_email" => $buyer_email, //买家支付宝帐号；
            );
            if ($_POST['trade_status'] == 'TRADE_FINISHED') {
                $status = self::checkorderstatus($orderid);
                if (!$status) {
                    self::orderhandle($parameter);
                }
            } else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                $status = self::checkorderstatus($orderid);
                if (!$status) {
                    self::orderhandle($parameter);
                }
            }
            echo "success";
        } else {
            echo "fail";
        }
    }
    static public function orderhandle($parameter){
        $ret=$parameter;
        $orderid=trim($ret['out_trade_no']);
        $trade_no=trim($ret['trade_no']);
        $order=M('order')->where(array('orderid'=>$orderid))->find();

        $id=M('order')->where(array('orderid'=>$orderid))->save(array(
            'trade_no'=>$trade_no,
            'paynotifydata'=>json_encode($ret)
        ));
        if($id){
            $type=substr($orderid,0,2);
            switch ($type)
            {
                case "ac":
                    M('order_time')->where(array('orderid'=>$orderid))->save(array(
                        'status'=>4,
                        'donetime'=>time(),
                        'pay_status'=>1,
                        'pay_time'=>time()
                    ));
                    M('activity_apply')->where(array('orderid'=> $orderid))->save(array(
                        'paystatus'=>1,
                        'paytime'=>time()
                    ));
                    $data=M('activity_apply a')->join("left join zz_activity b on a.aid=b.id")->where(array('a.orderid'=> $orderid))->field("a.*,b.uid as houseownerid,b.vouchersrange,b.vouchersdiscount")->find();
                    M("activity")->where(array("id"=> $data['aid']))->setInc("yes_num",$data['num']);
                    if(!empty($data['vouchersrange'])&&($order['total']>=$data['vouchersrange'])){
                        $vouchers_order_id=M("Vouchers_order")->add(array(
                            'catid'=>4,
                            'uid'=>$order['uid'],
                            'num'=>1,
                            'price'=>$data['vouchersdiscount'],
                            'aid'=>",".$data['aid'].",",
                            'status'=>0,
                            'inputtime'=>time(),
                            'updatetime'=>time()
                            ));
                    }
                    break;
                case "hc":
                    M('order_time')->where(array('orderid'=>$orderid))->save(array(
                        'status'=>4,
                        'pay_status'=>1,
                        'donetime'=>time(),
                        'pay_time'=>time()
                    ));
                    M('book_room')->where(array('orderid'=> $orderid))->save(array(
                        'paystatus'=>1,
                        'paytime'=>time()
                    ));
                    $data=M('book_room a')->join("left join zz_room b on a.rid=b.id")->join("left join zz_hostel c on a.hid=c.id")->where(array('a.orderid'=> $orderid))->field("a.*,c.uid as houseownerid,c.vouchersrange,c.vouchersdiscount")->find();
                    // M("room")->where(array("id"=> $data['rid']))->setInc("yes_num",$data['num']);
                    // M("room")->where(array("id"=> $data['rid']))->setDec("wait_num",$data['num']);
                    if(!empty($data['vouchersrange'])&&($order['total']>=$data['vouchersrange'])){
                        $vouchers_order_id=M("Vouchers_order")->add(array(
                            'catid'=>3,
                            'uid'=>$order['uid'],
                            'num'=>1,
                            'price'=>$data['vouchersdiscount'],
                            'hid'=>",".$data['hid'].",",
                            'status'=>0,   
                            'inputtime'=>time(),
                            'updatetime'=>time()
                            ));
                    }
                    break;
            }
            $money=$order['money'];
            $account=M('account')->where(array('uid'=>$data['houseownerid']))->find();

            $mid=M('account')->where(array('uid'=>$data['houseownerid']))->save(array(
                'total'=>$account['total']+floatval($money),
                'waitmoney'=>$account['waitmoney']+floatval($money),
                ));
            if($mid){
                switch ($type)
                {
                    case "ac":
                        M('account_log')->add(array(
                          'uid'=>$data['houseownerid'],
                          'type'=>'paysuccess',
                          'money'=>$money,
                          'total'=>$account['total']+floatval($money),
                          'usemoney'=>$account['usemoney'],
                          'waitmoney'=>$account['waitmoney']+floatval($money),
                          'status'=>1,
                          'dcflag'=>1,
                          'remark'=>'用户活动报名成功支付订单',
                          'addip'=>get_client_ip(),
                          'addtime'=>time()
                          ));
                        break;
                    case "hc":
                        M('account_log')->add(array(
                          'uid'=>$data['houseownerid'],
                          'type'=>'paysuccess',
                          'money'=>$money,
                          'total'=>$account['total']+floatval($money),
                          'usemoney'=>$account['usemoney'],
                          'waitmoney'=>$account['waitmoney']+floatval($money),
                          'status'=>1,
                          'dcflag'=>1,
                          'remark'=>'用户预定房间成功支付订单',
                          'addip'=>get_client_ip(),
                          'addtime'=>time()
                          ));
                }
            }
            M('vouchers_order')->where(array('id'=>$order['couponsid']))->setField('status',1);
            UtilController::addmessage($order['uid'],"订单支付成功","恭喜您，您有一笔预定订单支付成功！","恭喜您，您有一笔预定订单支付成功！","payordersuccess",$orderid);
            $Ymsms = A("Api/Ymsms");
            $content=$Ymsms->getsmstemplate("sms_payordersuccess");
            $smsdata=json_encode(array('content'=>$content,'type'=>"sms_payordersuccess",'r_id'=>$order['uid']));
            //$statuscode=$Ymsms->sendsms($smsdata);
            UtilController::addmessage($data['houseownerid'],"订单支付成功","恭喜您，您有一笔预定订单支付成功！","恭喜您，您有一笔预定订单支付成功！","bpayordersuccess",$orderid);
            $smsdata=json_encode(array('content'=>$content,'type'=>"sms_payordersuccess",'r_id'=>$data['houseownerid']));
            //$statuscode=$Ymsms->sendsms($smsdata);
            if($vouchers_order_id){
                UtilController::addmessage($order['uid'],"订单支付成功","恭喜您，获得我们的优惠券！","恭喜您，获得我们的优惠券！","getcoupons",$vouchers_order_id);
            }
       }
    }
    static public function checkorderstatus($orderid) {
        $ordstatus = M('order_time')->where('orderid=' . $orderid)->getField('pay_status');
        if ($ordstatus == 1) {
            return true;
        } else {
            return false;
        }
    }


    public function test_alipay_apppay(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $orderid=trim($ret['orderid']);

        require_once( VENDOR_PATH . "Alipay/alipay.config.php");
        require_once( VENDOR_PATH . "Alipay/lib/alipay_submit.class.php");
        $AliPayConfig=array(
            'partner' => '2088221764898885',
            'seller_id'=>'3221586551@qq.com'
        );
        $parameter = array(
            "partner" => trim($AliPayConfig['partner']),
            "seller_id" => $AliPayConfig['seller_id'],
            "out_trade_no" => $orderid,
            "subject" => "test",
            "body" => "test",
            "total_fee" => "0.01",
            "notify_url" => 'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/alipaynotify'),
            "service" => "mobile.securitypay.pay",
            "payment_type" => "1",
            "_input_charset" => 'utf-8',
        );
        M('thirdparty_send')->add(array(
            'data'=>serialize($parameter),
            'type'=>"alipay",
            'ispc'=>1,
            'inputtime'=>time()
            ));

        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $result = $alipaySubmit->buildRequestPara($parameter);
        $data=array();
        if(!empty($result['sign'])){
            $data['code']=200;
            $data['msg']="success";
            $data['data']=$result;
        }else{
            $data['code']=-200;
            $data['msg']="error";
        }
        echo json_encode($data);
    }
    
    public function testnotify(){
        $signstr='a:22:{s:8:"discount";s:4:"0.00";s:12:"payment_type";s:1:"1";s:7:"subject";s:4:"test";s:8:"trade_no";s:28:"2016071821001004100292048029";s:11:"buyer_email";s:22:"zlongchao1755@yeah.net";s:10:"gmt_create";s:19:"2016-07-18 17:53:30";s:11:"notify_type";s:17:"trade_status_sync";s:8:"quantity";s:1:"1";s:12:"out_trade_no";s:25:"ac20160718175248636664422";s:9:"seller_id";s:16:"2088221764898885";s:11:"notify_time";s:19:"2016-07-18 18:07:46";s:4:"body";s:4:"test";s:12:"trade_status";s:14:"WAIT_BUYER_PAY";s:19:"is_total_fee_adjust";s:1:"Y";s:9:"total_fee";s:4:"0.01";s:12:"seller_email";s:17:"3221586551@qq.com";s:5:"price";s:4:"0.01";s:8:"buyer_id";s:16:"2088102550639102";s:9:"notify_id";s:34:"c8697318541df87e92842880d63496agru";s:10:"use_coupon";s:1:"N";s:9:"sign_type";s:3:"RSA";s:4:"sign";s:172:"ixzPGPZG4cYYwkku3azU0Ku0zwOpvTUIqBS+25aQdOwvKve3BrtSLT9TvtMGIgZqBtON6SpJOieTo6FvtWYLmbBi6eDa8rRogyUsNHEFtM2gAfwJ7V+n1EHw6f5H6Z9hCg9FexH5JkUaI3kM/HuU8DHkWcjyhd8em6yFn+hs15o=";}';
        $signarray=unserialize($signstr);
        dump($signarray);
        require_once(VENDOR_PATH . "Alipay/lib/alipay_core.function.php");
        require_once(VENDOR_PATH . "Alipay/lib/alipay_rsa.function.php");
        $para_filter = paraFilter($signarray);
        
        //对待签名参数数组排序
        $para_sort = argSort($para_filter);
        
        
        $prestr = createLinkstring($para_sort,false);
        dump($prestr);
        $pubKey = file_get_contents(VENDOR_PATH . 'Alipay/key/alipay_public_key.pem');
        $res = openssl_get_publickey($pubKey);
        $isSgin = (bool)openssl_verify($prestr, base64_decode($signarray['sign']), $res);
        openssl_free_key($res);     
        dump($isSgin);
    }

    public function wxMobileWebPay($orderid,$title,$body,$money) {
        Vendor('Wxpay.lib.WxPay#Api');
        Vendor('Wxpay.lib.WxPay#JsApiPay');
        $WxPayApi = new \WxPayApi();
        $WxPayConfig=array(
             'APPID' => 'wxea98c16a0c02eefa',
	           'MCHID' => '1354896002',
	           'KEY' => 'shanghainonglvxinxiwoniuke201606',
             'NOTIFY_URL'=>'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/weixinnotify')
            );
        $money = "0.1";
        $tools = new \JsApiPay();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($body);
        $input->SetAttach($body);
        $input->SetOut_trade_no($orderid);
        $input->SetTotal_fee($money*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url($WxPayConfig['NOTIFY_URL']);
        $input->SetAppid($WxPayConfig['APPID']);
        $input->SetMch_id($WxPayConfig['MCHID']);
        $input->SetTrade_type("MWEB");
        $input->SetSpbill_create_ip($this->get_client_ip());
        M('thirdparty_send')->add(array(
            'data'=>serialize($input),
            'type'=>"wxpay",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        $order = $WxPayApi->unifiedOrder($input);
        dump($order);
        $jsApiParameters = $tools->GetAPPParameters($order);
        $jsApiParameters=json_decode($jsApiParameters,true);
        $data=array();
        if(!empty($jsApiParameters['sign'])){
            $data['code']=200;
            $data['msg']="success";
            $jsApiParameters['packageStr']=$jsApiParameters['package'];
            unset($jsApiParameters['package']);
            $data['data']=$jsApiParameters;

        }else{
            $data['code']=-200;
            $data['msg']="error";
        }
        echo json_encode($data);
    }

    private function get_client_ip() {
      $cip = "unknown";
      if($_SERVERA['REMOTE_ADDR']) {
        $cip = $_SERVER['REMOTE_ADDR'];
      } elseif (getenv("REMOTE_ADDR")) {
        $cip = getenv("REMOTE_ADDT"); 
      }
      return $cip; 
    }
}
