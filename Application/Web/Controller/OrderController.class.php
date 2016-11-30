<?php

namespace Web\Controller;

use Web\Common\CommonController;

use Org\Util\Page;

class OrderController extends CommonController {

    public function _initialize() {
      if(!session('uid')) {
        return $this->redirect('member/login');
      }
    }
    
    public function index(){
      $uid = session('uid');
      if (!$uid) {
          $this->error('请先登录！',U('Web/Member/login'));
      } else {
        $waitpay=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.uid'=>$uid,'c.pay_status'=>0,'c.cancel_status'=>0,'c.close_status'=>0,'a.paystyle'=>array("in","1,3"),'a.isserviceorder'=>0,'_string'=>'(a.paystyle!=2 and a.iscontainsweigh=1 and c.package_status=1) or (a.paystyle!=2 and a.iscontainsweigh=0)'))->count();
        $waitpackage=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.uid'=>$uid,'c.package_status'=>0,'c.cancel_status'=>0,'c.close_status'=>0,'a.isserviceorder'=>0,'a.isserviceorder'=>0,'_string'=>'(c.pay_status=0 and (a.iscontainsweigh=1 or a.paystyle=2)) or (c.pay_status=1 and a.iscontainsweigh=0 and ((a.ordertype!=3)or (a.ordertype=3 and a.puid=0)))'))->count();
        $waitconfirm=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.uid'=>$uid,'c.delivery_status'=>1,'a.ruid'=>array('neq',0),'c.cancel_status'=>0,'c.close_status'=>0,'a.isserviceorder'=>0))->count();
        $waitevaluate=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.uid'=>$uid,'c.pay_status'=>1,'c.delivery_status'=>4,'c.status'=>5,'c.evaluate_status'=>0,'c.cancel_status'=>0,'c.close_status'=>0,'a.isserviceorder'=>0))->count();           
        
        $this->assign('waitpay',$waitpay);
        $this->assign('waitpackage',$waitpackage);
        $this->assign('waitconfirm',$waitconfirm);
        $this->assign('waitevaluate',$waitevaluate);
        $this->display();
      }
    }
    
    //订单全部列表json返回
    public function init(){
        $uid = session('uid');
        $pagenum = isset($_REQUEST['Page']) ? intval($_REQUEST['Page']) :1;
        $type = $_REQUEST['type'];
        if (empty($type)){
            $type = "all";
        }
        
        $num=10;
        $p = new \Think\Page($count, 10);
        
        $user=M('Member')->where(array('id'=>$uid))->find();
        if ($uid == ''||$p==''||$num=='') {
            exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
        } elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        } else {
            $where=array();
            $order=array();
            $field=array();
            $field=array('a.orderid,a.ruid,a.puid,a.ruid,a.storeid,a.wallet,a.discount,b.title as storename,b.thumb as storethumb,a.money,a.total,a.inputtime,a.paystyle,a.paytype,c.status,c.pay_status,c.package_status,c.delivery_status,c.buyer_sendstatus,c.evaluate_status,a.ordertype,a.yes_money,a.wait_money,c.donetime');
            switch ($type) {
                case 'all':
                    # code...
                    $where=array('a.uid'=>$uid,'c.close_status'=>0,'a.isserviceorder'=>0);
                    $order=array('a.inputtime'=>'desc');
                    break;
                case 'waitpay':
                    # code...
                    $where=array('a.uid'=>$uid,'c.pay_status'=>0,'c.cancel_status'=>0,'c.close_status'=>0,'a.paystyle'=>array("in","1,3"),'a.isserviceorder'=>0,'_string'=>'(a.paystyle!=2 and a.iscontainsweigh=1 and c.package_status=1) or (a.paystyle!=2 and a.iscontainsweigh=0)');
                    $order=array('a.inputtime'=>'desc');
                    break;
                case 'waitpackage':
                    # code...
                    $where=array('a.uid'=>$uid,'c.package_status'=>0,'c.cancel_status'=>0,'c.close_status'=>0,'a.isserviceorder'=>0,'_string'=>'(c.pay_status=0 and (a.iscontainsweigh=1 or a.paystyle=2)) or (c.pay_status=1 and a.iscontainsweigh=0 and ((a.ordertype!=3)or (a.ordertype=3 and a.puid=0)))');
                    $order=array('a.inputtime'=>'desc');
                    break;
                case 'waitconfirm':
                    # code...
                    $where=array('a.uid'=>$uid,'c.delivery_status'=>1,'a.ruid'=>array('neq',0),'c.cancel_status'=>0,'c.close_status'=>0,'a.isserviceorder'=>0);
                    $order=array('c.delivery_time'=>'asc','c.id'=>'desc');
                    break;
                case 'waitevaluate':
                    # code...
                    $where=array('a.uid'=>$uid,'c.pay_status'=>1,'c.delivery_status'=>4,'c.status'=>5,'c.evaluate_status'=>0,'c.cancel_status'=>0,'c.close_status'=>0,'a.isserviceorder'=>0);
                    $order=array('a.inputtime'=>'desc');
                    break;
            }
            $data=M('order a')->join("left join zz_store b on a.storeid=b.id")
                              ->join("left join zz_order_time c on a.orderid=c.orderid")
                              ->where($where)
                              ->order($order)
                              ->field($field)
                              ->page($pagenum,$num)
                              ->select();
            
            foreach ($data as $key => $value) {
                # code...
                $productinfo=M('order_productinfo a')
                    ->join("left join zz_product b on a.pid=b.id")
                    ->where(array('a.orderid'=>$value['orderid']))
                    ->field("a.pid,a.nums,b.thumb,b.title,b.description,b.nowprice,b.oldprice,b.standard,b.unit,b.ishot,a.product_type,a.isweigh,a.weigh,b.selltime,b.advanceprice,b.price")->select();
                foreach ($productinfo as $k => $val)
                {
                    $productinfo[$k]['unit']=getunit($val['unit']);
                    $productinfo[$k]['title']=str_cut($val['title'],10);
                    //预购订单判断时间来显示是否显示去支付下笔订单
                    if ($val['product_type']=='3')
                    {
                        $temptime = $val['selltime'] - time();
                        if ($temptime < 0){
                            $productinfo[$k]['yugoustatus']  = '1';
                        }else{
                            $productinfo[$k]['yugoustatus']  = '0';
                        }
                    }
                    if($val['product_type'] == '4' && $val['isweigh'] == '0'){
                        if($productinfo[$k]['isweights'] != '2')
                            $productinfo[$k]['isweights'] = '1';
                    }else if($val['product_type'] == '4' && $val['isweigh'] == '1'){
                        $productinfo[$k]['isweights'] = '2';
                    }else{
                        if($productinfo[$k]['isweights'] != '2' && $productinfo[$k]['isweights'] != '1')
                            $productinfo[$k]['isweights'] = '0';
                    }
                }
                
                $data[$key]['productinfo']=$productinfo;

            }
            //            echo json_encode(M('order_productinfo a')->_sql());
            //            exit;
            if($data){
                exit(json_encode($data));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"There is no such order information!")));
            }
        }
    }




    public function closeorder(){
        $uid = session('uid');
        $orderid = $_REQUEST['orderid'];
        $user=M('Member')->where(array('id'=>$uid))->find();
        $order=M('order')->where(array('orderid'=>$orderid))->find();
        if($uid==''||$orderid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"The Order is not exist!")));
        }elseif($order['paystatus']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"订单已付款不能关闭交易")));
        }else{
            //$select['uid']=$user['id'];
            $select['orderid']=$orderid;
            //$this->ajaxReturn($select);
            //exit;
            $id=M('order_time')->where($select)->save(array(
                'status'=>3,
                'cancel_status'=>1,
                'cancel_time'=>time()
                ));
            
            if($id){
                
                $c="您好！您在".date("Y年m月d日 H时i分s秒") ."成功取消了一笔订单。";
                M("message")->add(array(
                    'uid'=>0,
                    'tuid'=>$uid,
                    'title'=>"取消订单",
                    'description'=>$c,
                    'content'=>$c,
                    'value'=>$order['orderid'],
                    'varname'=>"system",
                    'inputtime'=>time()
                ));
                M("message")->add(array(
                    'uid'=>0,
                    'tuid'=>0,
                    'title'=>"取消订单成功",
                    'value'=>$order['orderid'],
                    'varname'=>"order",
                    'inputtime'=>time()
                ));
                $this->ajaxReturn("success");
            }else{
                $this->ajaxReturn("faild");
            }
        }
    }

    

    public function getlngandlat(){
        $uid = session('uid');
        if (!$uid) {
            $this->error('请先登录！',U('Web/Member/login'));
        } else {
            $user=M('Member')->where(array('id'=>$uid))->find();
            if(empty($user)){
                exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
            } else {
                $where=array();
                $order=array('a.inputtime'=>'desc');
                $field=array('a.orderid,d.realname as runerrealname,d.username as runerusername,d.phone as runerphone,d.head as runerhead,c.delivery_time,c.donetime,c.inputtime,a.lat,a.lng');                
                $where=array('a.uid'=>$uid,'c.delivery_status'=>1,'a.ruid'=>array('neq',0),'c.cancel_status'=>0,'c.close_status'=>0,'a.isserviceorder'=>0);
                        
                $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                                  ->join("left join zz_member d on a.ruid=d.id")
                                  ->where($where)
                                  ->order($order)
                                  ->field($field)
                                  ->select();
                foreach ($data as $key => $value) {
                    # code...
                    $lat=M('order_distance')->where(array('orderid'=>$value['orderid']))->order(array('inputtime'=>'desc'))->getField("lat");
                    if(!empty($lat)){
                        $data[$key]['order_lat']=$lat;
                    }else{
                        $data[$key]['order_lat']=$value['lat'];
                    }
                    $lng=M('order_distance')->where(array('orderid'=>$value['orderid']))->order(array('inputtime'=>'desc'))->getField("lng");
                    if(!empty($lat)){
                        $data[$key]['order_lng']=$lng;
                    }else{
                        $data[$key]['order_lng']=$value['lng'];
                    }
                }
                if($data){
                    $this->ajaxReturn($data);
                }else{
                    exit(json_encode(array('code'=>-201,'msg'=>"订单数据为空")));
                }
            }
        }
    }
    public function logistics(){
        $this->display();
    }

    public function bookroom(){
        /*
         * 预定房间逻辑重构 @2016-11-11 by Meroc.
         */

        //判断用户是否登录.
        $uid = session('uid');
        if (!$uid) {
          if($_GET['weixin'] == 1) {
            $this->redirect(U('Web/Member/wxlogin'));
          } else {
            $this->error('请先登录！',U('Web/Member/login'));
          }
        }

        //为表单添加token，避免重复提交。
        $this->assign('uid', $uid);
        $_token = md5($uid . time());
        $this->assign('_token', $_token);

        //查询房间信息
        $rid=I('id');
        $data=array();
        $htitle=M('hostel a')
          ->join("left join zz_room b on b.hid=a.id")
          ->where(array('b.id'=>$rid))
          ->field('a.bookremark,a.id as hid,a.thumb,a.title t,b.title,b.thumb,b.mannum,b.nomal_money,b.id,b.holiday_money,b.week_money')
          ->select();
        $data=$htitle[0];

        //获取明天, 后天的时间
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $afterTomorrow = date('Y-m-d', strtotime('+2 day'));

        $member = M('member')
          ->where(array('id' => session('uid')))
          ->find();
        $data['rid'] = $rid;

        //获取常用人
        $linkmen = M('linkman')
          ->where(array('uid' => $uid))
          ->order('id desc')
          ->select();

        $this->assign('linkmen', $linkmen);
        $this->assign('pcount', $pcount);
        $this->assign('member', $member);
        $this->assign('tomorrow', $tomorrow);
        $this->assign('afterTomorrow', $afterTomorrow);
        $this->assign('people',$people);
        $this->assign('data',$data);
        $this->assign('id',$rid);

        $hid=$data['hid'];

        //获取用户优惠券
        $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
        $city=M('hostel')->where(array('id'=>$hid))->getField("city");
        $where=array();
        $where['a.uid']=$uid;
        $where['a.status']=0;
        $where['b.validity_endtime']=array('egt',time());
        $where['_string']="(b.voucherstype='hostel' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%')))";
        $where['b.id']=array('in',$catids);
        $coupon = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,b.price,b.hid,b.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->select();

        $this->assign("coupon",$coupon);
        $this->display();

    }

    public function createbook(){
      //先判断表单是否被重复提交，如果是，重定向到美宿详情页.
      $origin_token = session('bookroom_token');   
      $_token = $_POST['_token'];
      if($origin_token != $_token) {
        //若token值不相等，则该表单是最新提交的表单，应该接受，并覆盖session中的token值。
        session('bookroom_token', $_token);
      } else {
        //若token值相等，则说明该表单已被提交的过，该表单不被接受。
        $this->error('该订单已经提交，请勿重复提交，可到我的订单查看订单详情！'); 
      }

      // 房间id
      $rid=intval(trim($_POST['rid']));
      $uid=session("uid");

      // 真实姓名
      $realname=trim($_POST['realname']);
      $idcard=trim($_POST['idcard']);
      $phone=trim($_POST['phone']);
      $num=intval(trim($_POST['people']));
      $rooms = intval(trim($_POST['rooms']));
      $starttime=intval(strtotime(trim($_POST['starttime'])));
      $endtime=intval(strtotime(trim($_POST['endtime'])));
      $days=intval(trim($_POST['days']));

      // 获取入住人信息
      $ret['partners']= $_POST['partners'];
      $partners =$ret['partners'];

      // 优惠券没做
      $couponsid=intval(trim($_POST['couponsid']));
      $discount=floatval(trim($_POST['discount']));
      // 总金额
      $money=floatval(trim($_POST['money']));

      //获取房间信息
      $user=M('Member')->where(array('id'=>$uid))->find();
      $room= M('Room a')
        ->join("left join zz_hostel b on a.hid=b.id")
        ->where(array('a.id'=>$rid))
        ->field("a.*,b.title as hostel,b.uid as houseownerid")
        ->find();
      $apply= M('book_room')->where(array('rid'=>$rid,'uid'=>$uid))->find();

      $booknum=M('book_room')
        ->where(array('_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))
        ->sum('num');
      $orderid="hc".date("YmdHis", time()) . rand(100, 999);
      $premoney=$room['money'];

      //构造订单
      if(empty($premoney)||$premoney=='0.00'||$money=='0.00'){
          $data['paystatus']=1;
      }
      $data['rid']=$rid;
      $data['hid']=$room['hid'];
      $data['uid']=$uid;
      $data['orderid']=$orderid;
      $data['num']=$num;
      $data['roomnum'] = $rooms;
      $data['days']=$days;
      $data['realname']=$realname;
      $data['idcard']=$idcard;
      $data['phone']=$phone;
      $data['starttime']=$starttime;
      $data['endtime']=$endtime;
      $data['couponsid']=$couponsid;
      $data['discount']=$discount;
      $data['money']=$money;
      $data['total']=$money;
      $data['inputtime']=time();

      $hOwnerId = M('hostel')->where(array('id' => $room['hid']))->getField('uid');

      //生成美宿预订订单
      $id=M("book_room")->add($data);
      if($id){
        $bookin = false;
        if(!empty($partners)){
          //添加入住人信息。
          $links = '';
          foreach ($partners as $value)
          {
            $info = explode(',', $value);
            if($info[0] == $realname && $info[1] == $phone && $info[2] == $idcard) {
              $bookin = true; 
            }
            M('book_member')->add(array(
                'uid'=>$uid,
                'rid'=>$rid,
                'orderid'=>$orderid,
                'realname'=>$info[0],
                'phone'=>$info[1],
                'idcard'=>$info[2],
                'inputtime'=>time()
            ));
            $exist = M('linkman')->where(array('phone' => $info[1], 'idcard' => $info[2]))->find();
            if(!$exist) {
              $adl = M('linkman')
                ->add(array(
                  'uid' => $uid,
                  'realname' => $info[0],
                  'phone' => $info[1],
                  'idcard' => $info[2],
                  'inputtime' => time()
                ));  
              $links .= $adl . ',';
            } else {
              $links .= $exist['id'] . ',';
            }
          }
          $links = substr($links, 0, strlen($links) - 1);
          M('book_room')->where(array('orderid' => $orderid))->setFeild('memberids', $links);
        }

        //预订人必须入住，所以，入住人中没有预订人的，将预定人信息添加到入住人信息里
        if(!$bookin) {
          M('book_member')->add(array(
              'rid'=>$rid,
              'uid'=>$uid,
              'orderid'=>$orderid,
              'realname'=>$realname,
              'idcard'=>$idcard,
              'phone'=>$phone,
              'inputtime'=>time()
          ));
        }

        //生成订单
        $order=M('order')->add(array(
            'title'=>"蜗牛客慢生活-订单编号".$orderid,
            'uid'=>$uid,
            'orderid'=>$orderid,
            'nums'=>1,
            'money'=>$money,
            'total'=>$money,
            'discount'=>$discount,
            'couponsid'=>$couponsid,
            'inputtime'=>time(),
            'ordertype'=>1
            ));
        if($order){
            if(empty($premoney)||$premoney=='0.00'){
                M('order_time')->add(array(
                'orderid'=>$orderid,
                'status'=>1,
                'pay_status'=>1,
                'pay_time'=>time(),
                'inputtime'=>time()
                ));
            }else{
                M('order_time')->add(array(
                'orderid'=>$orderid,
                'status'=>1,
                'inputtime'=>time()
                ));
            }
        }
        $data['orderid']=$orderid;
        M("message")->add(array(
            'r_id'=>$room['houseownerid'],
            'title'=>"申请入住",
            'content'=>"您有新的房间预定订单需要审核，请尽快处理。",
            'varname'=>"applybookhouse",
            'value'=>$orderid,
            'inputtime'=>time()
        ));

        $data['orderid']=$orderid;

        \Api\Controller\UtilController::addmessage($hOwnerId,"申请入住","您有新的房间预定订单需要审核，请尽快处理。","您有新的房间预定订单需要审核，请尽快处理。","applybookhouse",$orderid);
        $Ymsms = A("Api/Ymsms");
        $content=$Ymsms->getsmstemplate("sms_applybookhouse");
        $data=json_encode(
          array(
            'content'=>$content,
            'type'=>"sms_applybookhouse",
            'r_id'=>$hOwnerId
          )
        );
        $statuscode=$Ymsms->sendsms($data);

        if(empty($premoney)||$premoney=='0.00'){
            $this->redirect("Home/Order/bookfinish",array('orderid'=>$orderid));
        }else{
            $this->redirect("Web/Order/bookconfirm",array('orderid'=>$orderid));
        }
      }else{
          $this->error("提交失败");
      }
    }
    // 预定成功 
    public function bookconfirm() {
        if (!session('uid')) {
            $this->redirect('Home/Member/login');
        } else {
            $orderid=I('orderid');
            $order=M('book_room')->where(array('orderid'=>$orderid))->find();
            $id=$order['rid'];
            $uid=session("uid");
            
            $data=M("Room a")
                ->join("left join zz_hostel b on a.hid=b.id")
                ->join("left join zz_member d on b.uid=d.id")
                ->where(array('a.id'=>$id))
                ->field('a.id as rid,a.hid,b.uid,d.nickname,d.head,d.realname_status,d.houseowner_status,d.rongyun_token,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.mannum,a.support,a.mannum,a.inputtime,b.title as hostel,b.area as hostelarea,b.address as hosteladdress,b.lat,b.lng')
                ->find();
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            $this->assign("data",$data);
            $this->assign("order",$order);

            $where=array();
            $where['a.hid']=$data['hid'];
            $where['a.isdel']=0;
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $house_owner_room=M("Room a")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->join("left join zz_bedcate b on a.roomtype=b.id")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.inputtime,c.reviewnum,b.catname')
                ->select();
            //     print_r(M("Room a")->getlastsql());
            // print_r($house_owner_room);
            $this->assign("house_owner_room",$house_owner_room);
            $this->assign("count",count($house_owner_room));
            $this->display();
        }
    }

    public function editconfirm() {
      $uid = session('uid');
      if (!$uid) {
          $this->redirect('Home/Member/login');
      } else {
        $orderid=I('orderid');
        $bookinfo=M('book_room')->where(array('orderid'=>$orderid))->find();
        if(!$bookinfo) {
          $this->error('订单错误，请联系系统管理员！', U('Order/party_order_detail', array('orderid' => $orderid)));
        }
        $id=$bookinfo['rid'];
        $starttime = strtotime(I('starttime'));
        $endtime = strtotime(I('endtime'));
        $days = I('days');
        $roomnum = I('rooms');
        $pnum = I('people');
        $money = I('money');
        $realname = I('realname');
        $phone = I('phone');
        $idcard = I('idcard');
        $partners = I('partners');

        //修改预订信息
        if($starttime) {
          $bookinfo['starttime'] = $starttime;
        }
        if($endtime) {
          $bookinfo['endtime'] = $endtime;
        }
        if($days) {
          $bookinfo['days'] = $days;
        }
        if($roomnum) {
          $bookinfo['roomnum'] = $roomnum;
        }
        if($realname) {
          $bookinfo['realname'] = $realname;
        }
        if($phone) {
          $bookinfo['phone'] = $phone;
        }
        if($idcard) {
          $bookinfo['idcard'] = $idcard;
        }

        $bookinfo['money'] = $money;

        //保存修改后的订单
        D('book_room')->save($bookinfo);

          //修改入住人
        M('book_member')->where(array('orderid' => $orderid))->delete();
        foreach($partners as $partner) {
          $infos = explode(',', $partner); 
          $m = M('book_member')->add(array(
            'uid' => $uid,
            'rid' => $bookinfo['rid'],
            'orderid' => $orderid,
            'realname' => $infos[0],
            'phone' => $infos[1],
            'idcard' => $infos[2],
            'inputtime' => time()
          ));
        }
        M('book_member')->add(array(
          'uid' => $uid,
          'rid' => $bookinfo['rid'],
          'orderid' => $orderid,
          'realname' => $realname,
          'phone' => $phone,
          'idcard' => $infos[2],
          'inputtime' => time()
        ));

        //修改订单
        $order=M('order')->where(array('orderid' => $orderid))->find();
        $order['money'] = $money;
        $order['total'] = $money;
        $order['discount'] = $discount;
        $order['couponsid'] = $couponsid;
        $result = D('order')->save($order);
        if($result){
          if(empty($money)||$money=='0.00'){
            M('order_time')->add(array(
              'orderid'=>$orderid,
              'status'=>1,
              'pay_status'=>1,
              'pay_time'=>time(),
              'inputtime'=>time()
            ));
          }else{
            M('order_time')->add(array(
              'orderid'=>$orderid,
              'status'=>1,
              'inputtime'=>time()
            ));
          }
        }
        
        $this->assign('data', $bookinfo);
        $this->display();
      }
    }

    // 参加活动
    public function joinparty(){
        /*
         * 参加活动重构 @2016-11-11 by Meroc.
         */
        $uid=session('uid');

        //判断登录
        if (!$uid) {
          $this->error('请先登录！',U('Web/Member/login'));
        }

        $this->assign('uid', $uid);

        //为表单添加token，防止重复提交.
        $token = md5($uid . time());
        $this->assign('_token', $token);

        $pid=I('id');

        //获取活动详情
        $data=M('activity')->where(array('id'=>$pid))->find();
        $this->assign('data',$data);
        $this->assign('pid',$pid);

        //获取常用人
        $linkmen = M('linkman')
          ->where(array('uid' => $uid))
          ->order('id desc')
          ->select();

        $this->assign('linkmen', $linkmen);

        $where=array();
        $member = M('member')->where(array('id' => $uid))->find();
        $this->assign('member', $member);
        $aid=$data['id'];
        $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
        $city=$data['city'];
        $where['a.uid']=$uid;
        $where['a.status']=0;
        $where['b.validity_endtime']=array('egt',time());
        $where['_string']="(b.voucherstype='party' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%')))";
        $where['b.id']=array('in',$catids);
        $coupon = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,b.price,b.hid,b.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->select();
        $this->assign("coupon",$coupon);
        $this->display();

    }
      
    // 生成活动订单
    public function createAct(){
        $uid=session('uid');
        $data['aid']=$_POST['aid'];
        $data['uid']=$uid;
        $orderid="ac".date("YmdHis", time()) . rand(100, 999);
        $data['orderid']=$orderid;
        $data['realname']=$_POST['realname'];
        $data['idcard']=$_POST['idcard'];
        $data['phone']=$_POST['phone'];
        $data['num']=$_POST['num'];
        $data['couponsid']=intval(trim($_POST['couponsid']));
        $data['discount']=intval(trim($_POST['discount']));
        $data['money']=floatval(trim($_POST['money']));
        $data['total']=$_POST['money'];

        //获取入住人信息
        $memberids=$_POST['partners'];
        $data['inputtime']=time();

        /*
         * 生成预订信息
         */
        $id=M("activity_apply")->add($data);

        /*
         * 记录参与人
         */
        $links = '';
        foreach ($memberids as $value)
        {
          $infos = explode(',', $value);
          $res = M('activity_member')->add(array(
            'uid'=>$uid,
            'aid'=>$aid,
            'orderid'=>$orderid,
            'realname'=>$infos[0],
            'phone'=>$infos[1],
            'idcard'=>$infos[2],
            'inputtime'=>time()
          ));
          $exist = M('linkman')->where(array('phone' => $infos[1], 'idcard' => $infos[2]))->find();
          if(!$exist) {
            $lid = M('linkman')
              ->add(array(
                'realname' => $infos[0],
                'phone' => $infos[1],
                'idcard' => $infos[2],
                'uid' => $uid,
                'inputtime' => time()
              ));
            $links .= $lid . ',';
          } else {
            $links .= $exist['id'] . ',';
          }
        }
        M('activity_apply')
          ->where(array('orderid' => $orderid))
          ->setField('memberids', substr($links, 0, strlen($links) - 1));

        /*
         * 将报名人加入参与人
         */
        M('activity_member')->add(array(
          'uid'=>$uid,
          'aid'=>$aid,
          'orderid'=>$orderid,
          'realname'=>$data['realname'],
          'idcard'=>$data['idcard'],
          'phone'=>$data['phone'],
          'inputtime'=>time()
        ));

        //生成订单
        $order=M('order')->add(array(
            'title'=>"蜗牛客慢生活-订单编号".$orderid,
            'uid'=>$uid,
            'orderid'=>$orderid,
            'nums'=>1,
            'money'=>$data['money'],
            'total'=>$data['total'],
            'discount'=>$data['discount'],
            'couponsid'=>$data['couponsid'],
            'inputtime'=>time(),
            'ordertype'=>2
        ));
        if($order){
           if(empty($data['total'])||$data['total']=='0.00'){
                M('order_time')->add(array(
                'orderid'=>$orderid,
                'status'=>4,
                'pay_status'=>1,
                'pay_time'=>time(),
                'inputtime'=>time()
                ));
            }else{
                M('order_time')->add(array(
                'orderid'=>$orderid,
                'status'=>2,
                'inputtime'=>time()
                ));
            }

            $data['orderid']=$orderid;
            \Api\Controller\UtilController::addmessage($room['houseownerid'],"申请入住","您有新的房间预定订单需要审核，请尽快处理。","您有新的房间预定订单需要审核，请尽快处理。","applybookhouse",$orderid);
            $Ymsms = A("Api/Ymsms");
            $content=$Ymsms->getsmstemplate("sms_applybookhouse");
            $data=json_encode(array('content'=>$content,'type'=>"sms_applybookhouse",'r_id'=>$room['houseownerid']));
            $statuscode=$Ymsms->sendsms($data);

            $data['orderid']=$orderid;
            $premoney=$data['total'];
            if(empty($premoney)||$premoney=='0.00'){
                $this->redirect("Web/Order/joinsuccess",array('orderid'=>$orderid));
            }else{
                $this->redirect("Web/Order/partyPay",array('orderid'=>$orderid));
            }
        }
    }

    public function joinsuccess(){
        $orderid=I('orderid');
        $order=M('activity_apply')->where(array('orderid'=>$orderid))->find();
        $id=$order['aid'];
        $uid=session("uid");
        $this->assign('order', $order);

        $data=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->where(array('a.id'=>$id))
            ->field('a.id,a.catid,a.title,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.partytype,a.starttime,a.endtime,a.content,a.start_numlimit,a.end_numlimit,a.yes_num,a.view,a.uid,b.nickname,b.head,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime')
            ->find();
        $data['catname']=M('partycate')->where(array('id'=>$data['catid']))->getField("catname");  

        $where=array();
        $where['a.status']=2;
        $where['a.isdel']=0;

        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $recoords=getcoords($data['lat'],$data['lng'],2);

        $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
        $party_near_hostel=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit(4)
            ->select();
        $Map=A("Api/Map");
        foreach ($party_near_hostel as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $party_near_hostel[$key]['reviewnum']=0;
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $party_near_hostel[$key]['ishit']=1;
            }else{
                $party_near_hostel[$key]['ishit']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $party_near_hostel[$key]['iscollect']=1;
            }else{
                $party_near_hostel[$key]['iscollect']=0;
            }
            $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            $party_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        $data['party_near_hostel']=!empty($party_near_hostel)?$party_near_hostel:null;
        $this->assign("data",$data);
        $this->display();
    }
    public function partyPay(){
        $uid=session('uid');
        if(!$uid) {
          $this->error('请先登录！', U('member/login')); 
        }
        $orderid=I('orderid');
        $order=M('activity_apply')->where(array('orderid'=>$orderid))->find();
        $coupons=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$order['couponsid']))->field("b.title,a.price")->find();
        $order['coupon_name']=$coupons['title']."(￥".$coupons['price']."元)";
        $id=$order['aid'];
        $uid=session("uid");
        $data=M("activity a")
        ->join("left join zz_member b on a.uid=b.id")
        ->where(array('a.id'=>$id))
        ->field('a.id,a.catid,a.title,a.thumb,a.city,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.partytype,a.starttime,a.endtime,a.content,a.start_numlimit,a.end_numlimit,a.yes_num,a.view,a.uid,b.nickname,b.head,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime')
        ->find();
        $data['catname']=M('partycate')->where(array('id'=>$data['catid']))->getField("catname");  
        if(empty($data['reviewnum'])) $data['reviewnum']=0;
        $joinnum=M('activity_apply')->where(array('aid'=>$data['id'],'paystatus'=>1))->sum("num");
        $data['joinnum']=!empty($joinnum)?$joinnum:0;
        $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$data['id'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->limit(6)->select();
        $data['joinlist']=!empty($joinlist)?$joinlist:null;

        // $coupon=M('member a')
        // ->join('left join zz_coupons_order b on a.id=b.uid')
        // ->join('left join zz_coupons c on c.id=b.catid')->where(array('a.id'=>$uid,'c.status'=>0))->field('c.*,b.id coid')->select();
        // foreach ($coupon as $key => $value) {
        //     if($order['couponsid']==$value['coid']){
        //         $order['coupon_name']=$value['title'];
        //     }
        // }
        // $this->assign("coupon",$coupon);

        $aid=$data['id'];
        $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
        $city=$data['city'];
        $where=array();
        $where['a.uid']=$uid;
        $where['a.status']=0;
        $where['b.validity_endtime']=array('egt',time());
        $where['_string']="(b.voucherstype='party' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%')))";
        $where['b.id']=array('in',$catids);
        $coupon = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,a.price,b.hid,b.aid,b.city,b.`range`,b.validity_starttime,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->select();
        $this->assign("coupon",$coupon);
        // 活动信息
        $this->assign("data",$data);
        // 订单信息
        $this->assign("order",$order);
        $this->display();
    }
    // 使用优惠券
    public function uCoupon(){
        $coid=$_POST['coid'];
        $orderid=$_POST['orderid'];
        $data=M('activity_apply')->where(array('orderid'=>$orderid))->find();
        if($data['couponsid']!=''){
            $total=$data['money']+$data['discount'];
            $odata['total']=$total;
            $odata['money']=$total;
            $odata['discount']='';
            $odata['couponsid']='';
            M('activity_apply')->where(array('orderid'=>$orderid))->setField($odata);
            M('order')->where(array('orderid'=>$orderid))->setField($odata);
        }
        $where['b.id']=$coid;
        $cprice=M('coupons a')
        ->join('left join zz_coupons_order b on a.id=b.catid')
        ->where($where)->getField('a.price');
        $data=M('activity_apply')->where(array('orderid'=>$orderid))->find();
        $total=$data['money']-$cprice;
        $sdata['couponsid']=$coid;
        $sdata['discount']=$cprice;
        $sdata['money']=$total;
        $sdata['total']=$total;
        $resApply=M('activity_apply')->where(array('orderid'=>$orderid))->setField($sdata);
        if($resApply){
            $order=M('order')->where(array('orderid'=>$orderid))->setField($sdata);
        }
        $this->ajaxReturn(array('code'=>200,'money'=>$total),'json');
    }

    public function dopay(){
        $paytype=I('paytype');
        $money=I('money');
        $discount= I('discount');
        $couponsid = I('couponsid');
        $orderid=I('orderid');
        $order=M('order a')
          ->join("left join zz_order_time b on a.orderid=b.orderid")
          ->where(array('a.orderid'=>$orderid))
          ->find();

        if(empty($order)){
            $this->error("该笔订单不存在");
        }
        if($order['pay_status']==1){
            $this->error("该笔订单已经支付");
        }
        $paytypeconfig=C("paytypeconfig");

        $channel=$paytypeconfig[$paytype];
        M('order')->where(array('orderid'=>$orderid))->save(array(
            'paytype'=>$paytype,
            'channel'=>$paytypeconfig[$paytype],
        ));

        if (!empty($discount) && $discount != 0.00 && $order['couponsid'] != 0) {
            M('vouchers_order')->where(array('id' => $order['couponsid']))->setField('status', 1);
        }
        switch ($order['ordertype']) {
            case '1':
                # code...
                $id = M('order')->where(array('orderid' => $orderid))->save(array(
                    'paytype' => $paytype,
                    'channel' => $channel,
                    'money' => $money,
                    'discount' => $discount,
                    'couponsid' => $couponsid
                ));
                if ($id) {
                  M("book_room")->where(array('orderid' => $order['orderid']))->save(array(
                      'paytype' => $paytype,
                      'channel' => $channel,
                      'money' => $money,
                      'discount' => $discount,
                      'couponsid' => $couponsid
                  ));
                }
                break;
            case '2':
                # code...
                $id = M('order')->where(array('orderid' => $orderid))->save(array(
                    'paytype' => $paytype,
                    'channel' => $channel,
                    'money' => $money,
                    'discount' => $discount,
                    'couponsid' => $couponsid
                ));
                if ($id) {
                    M("activity_apply")->where(array('orderid' => $order['orderid']))->save(array(
                        'paytype' => $paytype,
                        'channel' => $channel,
                        'money' => $money,
                        'discount' => $discount,
                        'couponsid' => $couponsid
                    ));
                }
                break;
            }

        if($order['ordertype']==1){
            $room= M('book_room a')->join("left join zz_room b on a.rid=b.id")->where(array('a.orderid'=>$orderid))->find();
            $title="预定房间";
            $body="预定".$room['title']."支付".$money;
            $value=$room['rid'];
        }else if($order['ordertype']==2){
          $activity= M('activity_apply a')
            ->join("left join zz_activity b on a.aid=b.id")
            ->where(array('a.orderid'=>$orderid))->find();
            $title="参加活动";
            $body="参加".$activity['title'].",支付".$money;
            $value=$activity['aid'];
        }

        $orderid=$orderid.rand(100000, 999999);

        if ($paytype == 1) {
            $this->alipay_wappay($orderid,$title,$body,$money,$order['ordertype'],$value);
        } elseif ($paytype == 2) {
            $this->weixin_wappay($orderid,$title,$body,$money,$order['ordertype'],$value);
        } elseif ($paytype == 3) {
            $this->union_webpay($orderid,$title,$body,$money,$order['ordertype'],$value);
        }else{
            $this->error("支付方式无效");
        }
    }

    public function weixin_wappay($orderid,$title,$body,$money,$ordertype,$value) {
        $Wxhelp=A('Web/Wxhelp');
        //$openid = $Wxhelp->GetOpenid();
        $openid = M('member')->where(array('id' => session('uid')))->getField('openid');
        Vendor('Wxpay.lib.WxPay#Api');
        Vendor('Wxpay.lib.WxPay#JsApiPay');
        $notify_url = 'http://' . $_SERVER['HTTP_HOST'] . U('Api/Pay/weixinwapnotify');
        $tools = new \JsApiPay();
        $order = M('order')->where(array('orderid' => $_GET['orderid']))->find();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($order['title']);
        $input->SetAttach($order['orderid']);
        $input->SetOut_trade_no($order['orderid'] . rand(100000, 999999));
        $input->SetTotal_fee(1);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($order['ordertype']);
        $input->SetNotify_url($notify_url);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openid);
        $input->SetAppid("wx670ea712732e93f5");//公众账号ID
        $input->SetMch_id("1355088902");//商户号
        $jsWxOrder = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($jsWxOrder);
        $this->assign('total', 1);
        $this->assign('orderid', $_GET['orderid']);
        $this->assign('parameters', $jsApiParameters);
        $this->display('js_pay');
    }

    public function alipay_wappay($orderid,$title,$body,$money,$ordertype,$value) {
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
      $body = $body;//$_POST['WIDbody'];
      $AliPayConfig=array(
          'partner' => '2088221764898885',
          'seller_id'=>'3221586551@qq.com'
      );
      $order = M('order')->where(array('orderid' => $orderid))->find();
      $return_url = '';
      $returnOrderid = substr($orderid,0,strlen($orderid)-6);
      if($ordertype == 2) {
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] .U('Web/Order/joinsuccess') . "?orderid={$returnOrderid}"; 
      } else {
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] .U('Web/Order/bookpaysuccess') . "?orderid={$returnOrderid}"; 
      }
      $notify_url = 'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/alipaynotify');
      $parameter = array(
          "partner" => trim($AliPayConfig['partner']),
          "seller_id" => $AliPayConfig['seller_id'],
          "out_trade_no" => $orderid,
          "subject" => 'test',
          "body" => 'test',
          "total_fee" => "0.1",
          "notify_url" => $notify_url,
          "return_url" => $return_url,
          "service" => "alipay.wap.create.direct.pay.by.user",
          "payment_type" => "1",
          "exter_invoke_ip"=>get_client_ip(),
          "input_charset" => 'utf-8',
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

    //支付宝
    public function alipay_webpay($orderid,$subject,$body,$money,$ordertype,$value) {
        require_once( VENDOR_PATH . "Alipay/alipay.config.php");
        require_once( VENDOR_PATH . "Alipay/lib/alipay_submit.class.php");
        $AliPayConfig=array(
            'partner' => '2088221764898885',
            'seller_email'=>'3221586551@qq.com'
        );
        $notify_url = 'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/alipaynotify'); 
        $return_url = 'http://' . $_SERVER['HTTP_HOST'] .U('Home/Order/returnurl'); 
        $total_fee = 0.01; 
        //$total_fee = $money; 
        $parameter = array(
            "service" => "create_direct_pay_by_user",
            "partner" => $AliPayConfig['partner'],
            "seller_id"=> $AliPayConfig['partner'],
            "payment_type"  => "1",
            "notify_url"    => $notify_url,
            "return_url"    => $return_url,
            "anti_phishing_key"=>"",
            "exter_invoke_ip"=>get_client_ip(),
            "out_trade_no"  => $orderid,
            "subject"   => $subject,
            "total_fee" => $total_fee,
            "body"  => $body,
            "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
        );
        M('thirdparty_send')->add(array(
            'data'=>serialize($parameter),
            'type'=>"alipay",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        $alipaySubmit = new \AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"post", "确认");
        echo $html_text;
    }
    public function returnurl() {
        require_once( VENDOR_PATH . "Alipay/alipay.config.php");
        require_once( VENDOR_PATH . "Alipay/lib/alipay_submit.class.php");
        $AliPayConfig=array(
            'partner' => '2088221764898885',
            'seller_email'=>'3221586551@qq.com'
        );
        $alipayNotify = new \AlipayNotify($alipay_config); //计算得出通知验证结果
        $verify_result = $alipayNotify->verifyReturn();
        M('thirdparty_data')->add(array(
            'get'=>serialize($_GET),
            'type'=>"alipayreturn",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        if ($verify_result) {
            $orderid=$_GET['out_trade_no'];
            $orderid=substr($orderid,0,strlen($orderid)-6);
            $trade_no = $_GET['trade_no'];          //支付宝交易号
            $trade_status = $_GET['trade_status'];      //交易状态
            $total_fee = $_GET['total_fee'];         //交易金额
            $notify_id = $_GET['notify_id'];         //通知校验ID。
            $notify_time = $_GET['notify_time'];       //通知的发送时间。
            $buyer_email = $_GET['buyer_email'];       //买家支付宝帐号；

            $parameter = array(
                "out_trade_no" => $orderid, //商户订单编号；
                "trade_no" => $trade_no, //支付宝交易号；
                "total_fee" => $total_fee, //交易金额；
                "trade_status" => $trade_status, //交易状态
                "notify_id" => $notify_id, //通知校验ID。
                "notify_time" => $notify_time, //通知的发送时间。
                "buyer_email" => $buyer_email, //买家支付宝帐号
            );

            if ($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                $status = self::checkorderstatus($orderid);
                if (!$status) {
                    self::orderhandle($parameter);
                }
                $type=substr($orderid,0,2);
                switch ($type)
                {
                    case "ac":
                        $successurl=U('Home/Order/joinsuccess', array('orderid' => $orderid));
                        break;
                    case "hc":
                        $successurl=U('Home/Order/bookfinish', array('orderid' => $orderid));
                        break;
                }
                $this->redirect($successurl);
            } else {
                $this->error("支付失败",U('Home/Member/myorder'));
            }
        } else {
            $this->error("校验失败,数据可疑",U('Home/Member/myorder'));
        }
    }
    //银联
    public function union_webpay($orderid,$subject,$body,$money,$ordertype,$value) {
        Vendor('Union.utf8.func.common');
        Vendor('Union.utf8.func.SDKConfig');
        Vendor('Union.utf8.func.secureUtil');
        Vendor('Union.utf8.func.httpClient');

        $UnionPayConfig=array(
             'merId' => '898320548160545',
             'FRONT_NOTIFY_URL'=>'http://' . $_SERVER['HTTP_HOST'] .U('Home/Order/unionreturn'),
             'BACK_NOTIFY_URL'=>'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/unionnotify'),
             'SDK_FRONT_TRANS_URL'=>'https://gateway.95516.com/gateway/api/frontTransReq.do'
             );
        $total_fee = 1; 
        //$total_fee = $money*100; 
        $params = array(
            'version' => '5.0.0',               //版本号
            'encoding' => 'utf-8',              //编码方式
            'certId' => getSignCertId(),           //证书ID
            'txnType' => '01',              //交易类型  
            'txnSubType' => '01',               //交易子类
            'bizType' => '000201',              //业务类型
            'frontUrl' =>  $UnionPayConfig['FRONT_NOTIFY_URL'],         //前台通知地址，控件接入的时候不会起作用
            'backUrl' => $UnionPayConfig['BACK_NOTIFY_URL'],        //后台通知地址    
            'signMethod' => '01',       //签名方法
            'channelType' => '07',      //渠道类型，07-PC，08-手机
            'accessType' => '0',        //接入类型
            'merId' => $UnionPayConfig['merId'],               //商户代码，请改自己的测试商户号
            'orderId' => $orderid,    //商户订单号
            'txnTime' => date('YmdHis'),    //订单发送时间
            'txnAmt' => $total_fee,      //交易金额，单位分
            'currencyCode' => '156',    //交易币种
            'reqReserved' =>' 透传信息', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现
            );
        sign($params);
        M('thirdparty_send')->add(array(
            'data'=>serialize($params),
            'type'=>"union",
            'ispc'=>1,
            'action'=>$UnionPayConfig['SDK_FRONT_TRANS_URL'],
            'inputtime'=>time()
            ));
        $html_form = create_html($params, $UnionPayConfig['SDK_FRONT_TRANS_URL']);
        echo $html_form;
    }
    public function unionreturn() {
        Vendor('Union.utf8.func.common');
        Vendor('Union.utf8.func.secureUtil');
        M('thirdparty_data')->add(array(
            'post'=>serialize($_POST),
            'type'=>"unionFrontReceive",
            'ispc'=>1,
            'inputtime'=>time()
            ));
        if (verify ($_POST)) {
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
                $type=substr($orderid,0,2);
                switch ($type)
                {
                    case "ac":
                        $successurl=U('Home/Order/joinsuccess', array('orderid' => $orderid));
                        break;
                    case "hc":
                        $successurl=U('Home/Order/bookfinish', array('orderid' => $orderid));
                        break;
                }
                $this->redirect($successurl);
            } else {
                $this->error("支付失败",U('Home/Member/myorder'));
            }
        } else {
            $this->error("校验失败,数据可疑",U('Home/Member/myorder'));
        }
    }
    //微信
    public function weixin_webpay($orderid,$subject,$body,$money,$ordertype,$value){
        Vendor('Wxpay.lib.WxPay#Api');
        Vendor('Wxpay.lib.WxPay#NativePay');
        $WxPayConfig=array(
         'APPID' => 'wxea98c16a0c02eefa',
         'MCHID' => '1354896002',
         'KEY' => 'shanghainonglvxinxiwoniuke201606',
         'NOTIFY_URL'=>'http://' . $_SERVER['HTTP_HOST'] .U('Api/Pay/weixinnotify')
        );

        $notify = new \NativePay();
        // $url = $notify->GetPrePayUrl($orderid);
        $total_fee = 1; 
        //$total_fee = $money*100; 
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($body);
        $input->SetAttach($body);
        $input->SetOut_trade_no($orderid);
        $input->SetTotal_fee($total_fee);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url($WxPayConfig['NOTIFY_URL']);
        $input->SetAppid($WxPayConfig['APPID']);
        $input->SetMch_id($WxPayConfig['MCHID']);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($orderid);
        $result = $notify->GetPayUrl($input);
        $url = $result["code_url"];

        import("Vendor.phpqrcode.phpqrcode","",".php");
        $filename = "Uploads/member/order/".date("Ymdhis") .'.png'; 
        $errorCorrectionLevel = 'L';
        $matrixPointSize = 4;
        $QRcode=new \QRcode();
        $QRcode->png($url, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
        $filename="/".$filename;
        $orderid=substr($orderid,0,strlen($orderid)-6);
        M('order')->where(array('orderid'=>$orderid))->save(array(
            'wxcode'=>$filename
            ));
        $this->redirect("Home/Order/weixinpay",array('orderid'=>$orderid));
    }
    public function weixinpay(){
        $orderid=I('orderid');
        $field=array();
        $type=M('order')->where(array('orderid'=>$orderid))->getField("ordertype");
        switch ($type) {
            case '1':
                # code...
                $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,a.wxcode,c.*,a.ordertype');
                break;
            case '2':
                # code...
                $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,a.wxcode,c.*,a.ordertype');
                break;
        }
        $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.orderid'=>$orderid))->field($field)->find();
        $productinfo=array();
        switch ($type) {
            case '1':
                # code...
                $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
                $productinfo=M('book_room a')
                    ->join("left join zz_room c on a.rid=c.id")
                    ->join("left join zz_hostel b on c.hid=b.id")
                    ->join("left join {$sqlI} d on a.id=d.value")
                    ->where(array('a.orderid'=>$data['orderid']))
                    ->field("a.rid,c.title,b.id as hid,b.thumb,b.title as hostel,b.area,b.address,a.money,a.realname,a.phone,a.num,a.days,a.discount,a.couponsid,a.starttime,a.endtime,a.paystatus,d.reviewnum")
                    ->find();

                break;
            case '2':
                # code...
                $productinfo=M('activity_apply a')
                    ->join("left join zz_activity b on a.aid=b.id")
                    ->where(array('a.orderid'=>$data['orderid']))
                    ->field("a.aid,b.thumb,b.title,a.money,b.isfree,b.area,b.address,b.starttime,b.endtime,a.realname,a.phone,a.idcard,a.num,a.paystatus,b.start_numlimit,b.end_numlimit")
                    ->find();
                $joinnum=M('activity_apply')->where(array('aid'=>$productinfo['aid'],'paystatus'=>1))->sum("num");
                $productinfo['joinnum']=!empty($joinnum)?$joinnum:0;
                $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$productinfo['aid'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->limit(6)->select();
                $productinfo['joinlist']=!empty($joinlist)?$joinlist:null;
                break;
        }
        $data['couponstitle']=M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->where(array('a.id'=>$data['couponsid']))->getField("b.title");
        $data['productinfo']=$productinfo;
        $this->assign("data",$data);
        $this->display();
    }
    static public function orderhandle($parameter){
        $ret=$parameter;
        $orderid=trim($ret['out_trade_no']);
        $trade_no=trim($ret['trade_no']);

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
                        'pay_status'=>1,
                        'pay_time'=>time()
                    ));
                    M('activity_apply')->where(array('orderid'=> $orderid))->save(array(
                        'paystatus'=>1,
                        'paytime'=>time()
                    ));
                    $data=M('activity_apply')->where(array('orderid'=> $orderid))->find();
                    M("activity")->where(array("id"=> $data['aid']))->setInc("yes_num",$data['num']);
                    break;
                case "hc":
                    M('order_time')->where(array('orderid'=>$orderid))->save(array(
                        'status'=>4,
                        'pay_status'=>1,
                        'pay_time'=>time()
                    ));
                    M('book_room')->where(array('orderid'=> $orderid))->save(array(
                        'paystatus'=>1,
                        'paytime'=>time()
                    ));
                    $data=M('book_room')->where(array('orderid'=> $orderid))->find();
                    // M("room")->where(array("id"=> $data['rid']))->setInc("yes_num",$data['num']);
                    // M("room")->where(array("id"=> $data['rid']))->setDec("wait_num",$data['num']);
                    break;
            }
        }
    }

    public function hotel_order_detail() {
      $orderid = $_GET['orderid'];
      $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,c.refund_status,a.ordertype,c.donetime,c.review_remark,d.endtime,f.remark as refundreview_remark,e.uid as huid,c.cancel_status,c.review_status');
      $order=M('order a')
          ->join("left join zz_order_time c on a.orderid=c.orderid")
          ->join("left join zz_book_room d on a.orderid=d.orderid")
          ->join("left join zz_hostel e on d.hid=e.id")
          ->join("left join zz_refund_apply f on a.orderid=f.orderid")
          ->where(array('a.orderid' => $orderid))
          ->field($field)
          ->find();
      if(session('uid') == $order['huid']) {
        $this->assign('is_owner', 1); 
      } else {
        $this->assign('is_owner', 0); 
      }
      if($order['status'] == 4 && $order['endtime'] < time()) {
        $order['finished'] = 1; 
      } else {
        $order['finished'] = 0; 
      }

      $productinfo=M('book_room a')
          ->join("left join zz_room c on a.rid=c.id")
          ->join("left join zz_hostel b on c.hid=b.id")
          ->where(array('a.orderid'=>$orderid))
          ->field("a.idcard,a.phone,a.realname,a.rid,b.id as hid,b.thumb,b.title,b.money,a.starttime,a.endtime,b.uid as ownerid,c.title as room_name,a.roomnum, a.days")
          ->find();
      $uid = session('uid');
      if($uid == $productinfo['ownerid']) {
        $this->assign('isowner', 1); 
      }
      $order['productinfo']=$productinfo;
      $clients = M('book_member')->where(array('orderid' => $orderid))->select();
      $ccount = count($clients);
      $this->assign('ccount', $ccount);
      $this->assign('order', $order); 
      $this->assign('clients', $clients);
      $this->display(); 
    }

    private function wxPrepay() {
       
    
    }

    public function hotelPay() {
      $uid=session("uid");
      $orderid = $_GET['orderid'];
      $orderTime = M('orderTime')->where(array('orderid' => $orderid))->find();
      if($orderTime['pay_status']) {
        $detailUrl = U('Order/hotel_order_detail') . '?orderid=' . $orderid;
        $this->error('该订单已支付', $detailUrl);
      }
      $field=array('a.uid,a.orderid,a.couponsid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,c.refund_status,a.ordertype,c.donetime,c.review_remark,d.endtime,f.remark as refundreview_remark,e.address');
      $order=M('order a')
        ->join("left join zz_order_time c on a.orderid=c.orderid")
        ->join("left join zz_book_room d on a.orderid=d.orderid")
        ->join("left join zz_hostel e on d.hid=e.id")
        ->join("left join zz_refund_apply f on a.orderid=f.orderid")
        ->where(array('a.orderid' => $orderid))
        ->field($field)
        ->find();
        $coupons=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$order['couponsid']))->field("b.title,a.price")->find();
        $order['coupon_name']=$coupons['title']."(￥".$coupons['price']."元)";
      $productinfo=M('book_room a')
        ->join("left join zz_room c on a.rid=c.id")
        ->join("left join zz_hostel b on c.hid=b.id")
        ->where(array('a.orderid'=>$orderid))
        ->field("a.realname,a.phone,a.idcard,a.rid,b.id as hid,b.thumb,b.title,b.money,a.starttime,a.endtime,b.uid as ownerid,c.title as room_name")
        ->find();
      $order['productinfo']=$productinfo;
      $this->assign('data', $order); 

       $hid=$productinfo['hid'];
       $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
       $city=M('hostel')->where(array('id'=>$hid))->getField("city");
       $where=array();
        $where['a.uid']=$uid;
        $where['a.status']=0;
        $where['b.validity_endtime']=array('egt',time());
        $where['_string']="(b.voucherstype='hostel' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%')))";
        $where['b.id']=array('in',$catids);
        $coupon = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,a.price,b.hid,b.aid,b.city,b.`range`,b.validity_starttime,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->select();
        //echo M('vouchers_order a')->_sql();
        $this->assign("coupon",$coupon);
      $this->display(); 
    }

    public function go_audio () {
      $orderid = $_GET['orderid'];
      $order = M('order a')
        ->join('zz_book_room b on a.orderid = b.orderid')
        ->join('zz_member c on a.uid = c.id')
        ->join('zz_room d on d.id = b.rid')
        ->where(array(
            'a.orderid' => $orderid
          ))
        ->field('a.orderid, a.inputtime, b.realname, b.phone, d.title as room_name, b.starttime, b.endtime,c.head,c.phone, c.id as uid')
        ->find();
      $memberCount = M('book_member')
        ->where(array('orderid' => $orderid))
        ->count();
      $order['num'] = $memberCount + 1;
      $this->assign('data', $order);
      $this->display(); 
    }

    public function cancel_audit() {
      $orderid = $_GET['orderid'];
      $order = M('order a')
        ->join('zz_book_room b on a.orderid = b.orderid')
        ->join('zz_member c on a.uid = c.id')
        ->join('zz_room d on d.id = b.rid')
        ->where(array(
            'a.orderid' => $orderid
          ))
        ->field('a.orderid, a.inputtime, b.realname, b.phone, d.title as room_name, b.starttime, b.endtime,c.head,c.phone, c.id as uid')
        ->find();
      $memberCount = M('book_member')
        ->where(array('orderid' => $orderid))
        ->count();
      $order['num'] = $memberCount + 1;
      $this->assign('data', $order);
      $this->display(); 
    }

    public function bookpaysuccess() {
      $orderid=I('orderid');
      $order=M('book_room')->where(array('orderid'=>$orderid))->find();
      $id=$order['rid'];
      $uid=session("uid");
      
      $data=M("Room a")
          ->join("left join zz_hostel b on a.hid=b.id")
          ->join("left join zz_member d on b.uid=d.id")
          ->where(array('a.id'=>$id))
          ->field('a.id as rid,a.hid,b.uid,d.nickname,d.head,d.realname_status,d.houseowner_status,d.rongyun_token,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.mannum,a.support,a.mannum,a.inputtime,b.title as hostel,b.area as hostelarea,b.address as hosteladdress,b.lat,b.lng')
          ->find();
      if(empty($data['reviewnum'])) $data['reviewnum']=0;
      $this->assign("data",$data);
      $this->assign("order",$order);

      $where=array();
      $where['a.hid']=$data['hid'];
      $where['a.isdel']=0;
      $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
      $house_owner_room=M("Room a")
          ->join("left join {$sqlI} c on a.id=c.value")
          ->join("left join zz_bedcate b on a.roomtype=b.id")
          ->where($where)
          ->order(array('id'=>"desc"))
          ->field('a.id,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.inputtime,c.reviewnum,b.catname')
          ->select();
      $this->assign("house_owner_room",$house_owner_room);
      $this->assign("count",count($house_owner_room));
      $this->display(); 
    }

    public function editOrder() {
      $orderid = I('get.orderid');
      $bookroom = M('bookRoom')->where(array('orderid' => $orderid))->find();
      $rid=$bookroom['rid'];
      $data=array();
      $htitle=M('hostel a')
        ->join("left join zz_room b on b.hid=a.id")
        ->where(array('b.id'=>$rid))
        ->field('a.bookremark,a.thumb,a.title t,b.title,b.thumb,b.mannum,b.nomal_money,b.id,b.holiday_money,b.week_money')
        ->select();
      $data=$htitle[0];
      $origPeople =M('book_member')->where(array('orderid' => $orderid))->select();
      $people = array();
      $cookied = json_decode(cookie('add'));
      if($cookied) {
        foreach($cookied as $key => $cook) {
          $cookied[$key] = (array)$cook;
        }
        $people = array_merge($origPeople, $cookied);
      } else {
        $people = $origPeople; 
      }
      $pcount = count($people);
      $member = M('member')
        ->where(array('id' => session('uid')))
        ->find();

      $data['rid'] = $rid;
      $startTime = $bookroom['starttime'];
      $endTime =  $bookroom['endtime'];
      $roomNum =  $bookroom['roomnum'];
      $days =  $bookroom['days'];

      if($startTime) {
        $this->assign('startTime', $startTime);
      }
      if($endTime) {
        $this->assign('endTime', $endTime); 
      }
      if($roomNum) {
        $this->assign('roomNum', $roomNum);
      }
      if($days) {
        $this->assign('days', $days); 
      }
      $this->assign('pcount', $pcount);
      $this->assign('member', $member);
      $this->assign('people',$people);
      $this->assign('data',$data);
      $this->assign('id',$rid);
      $this->assign('bookroom', $bookroom);
      $this->display(); 
    }

    public function editbook() {

      /*
       * 修改房间逻辑重构 @2016-11-12 by Meroc.
       */

      //判断用户是否登录.
      $uid = session('uid');
      if (!$uid) {
          $this->error('请先登录！',U('Web/Member/login'));
      }

      //为表单添加token，避免重复提交。
      $this->assign('uid', $uid);
      $_token = md5($uid . time());
      $this->assign('_token', $_token);

      //查询房间信息
      $orderid = I('orderid');

      $bookinfo = M('book_room a')
        ->join('zz_room b on a.rid = b.id')
        ->join('zz_hostel c on a.hid = c.id')
        ->where(array('a.orderid' => $orderid))
        ->field('a.id,a.hid,a.rid,a.realname,a.idcard,a.days,a.phone,a.num,a.roomnum as room_num,a.starttime,a.endtime,a.orderid,a.money,a.total,a.discount,b.title as room_name,b.thumb as room_img,b.nomal_money,b.holiday_money,b.week_money,c.title as hotel_name,c.thumb as hotel_img,c.bookremark')
        ->find();

      if(!$bookinfo) {
        $this->error('订单信息错误，无法修改，请联系系统管理员！');
      }

      //获取入住人信息，但是排除预约人
      $partners = M('book_member')
        ->where(array(
          'orderid' => $orderid,
          'phone' => array('neq', $bookinfo['phone'])
        ))
        ->select();

      //获取常用人
      $linkmen = M('linkman')
        ->where(array('uid' => $uid))
        ->order('id desc')
        ->select();

      $this->assign('linkmen', $linkmen);
      $this->assign('pcount', count($partners) + 1);
      $this->assign('partners',$partners);
      $this->assign('data',$bookinfo);

      $hid=$data['hid'];

      //获取用户优惠券
      $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
      $city=M('hostel')->where(array('id'=>$hid))->getField("city");
      $where=array();
      $where['a.uid']=$uid;
      $where['a.status']=0;
      $where['b.validity_endtime']=array('egt',time());
      $where['_string']="(b.voucherstype='hostel' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%')))";
      $where['b.id']=array('in',$catids);
      $coupon = M('vouchers_order a')
        ->join("left join zz_vouchers b on a.catid=b.id")
        ->where($where)
        ->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,b.price,b.hid,b.aid,b.city,b.`range`,b.validity_endtime,a.`status`")
        ->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))
        ->select();

      $this->assign("coupon",$coupon);
      $this->display();

    }

    /*
     * 活动订单详情。
     */
    public function party_order_detail() {
      $uid = session('uid');
      if(!$uid) {
        return $this->redirect('Member/login'); 
      }
      $orderid = $_GET['orderid'];
      $order = M('order a')
        ->join('zz_order_time b on a.orderid = b.orderid') 
        ->join('zz_activity_apply c on a.orderid = c.orderid')
        ->join('zz_activity d on c.aid = d.id')
        ->join('zz_refund_apply e on a.orderid = e.orderid')
        ->where(array('a.orderid' => $orderid))
        ->field('a.orderid, a.money, a.total, a.paytype, b.inputtime, b.status, b.pay_status,b.cancel_status, b.refund_status, b.evaluate_status, d.title, d.thumb, d.starttime, d.endtime, d.address, c.idcard, c.phone, c.realname,d.id as aid, d.uid, e.remark as review_remark')
        ->find();
      $partners = M('activity_member')
        ->where(array('orderid' => $orderid))
        ->select();
      if($order['endtime'] < time()) {
        $order['finished'] = 1;
      }
      $partnerNumber = count($partners);
      $partnerStr = '';
      if(is_array($partners)) {
        foreach($partners as $partner) {
          $partnerStr .= $partner['realname'] . '，';
        }
        $partnerStr = substr($partnerStr, 0, strlen($partnerStr) - 3);
      }
      if($uid == $order['uid']) {
        $this->assign('is_owner', 1);
      } else {
        $this->assign('is_owner', 0);
      }
      $this->assign('partnerNumber', $partnerNumber);
      $this->assign('partners', $partnerStr);
      $this->assign('partnerArr', $partners);
      $this->assign('order', $order);
      $this->display(); 
    }

    public function audit_party() {
      $orderid = $_GET['orderid'];
      $order = M('activity_apply a')
        ->join('zz_activity b on a.aid = b.id')
        ->join('zz_member c on a.uid = c.id')
        ->where(array('a.orderid' => $orderid))
        ->field('a.realname, a.idcard, a.phone, a.orderid, a.uid, a.aid, a.money, b.title, a.inputtime, c.head,b.starttime,b.endtime')
        ->find();
      $pnum = M('activity_member')->where(array('orderid' => $orderid))->count();
      $this->assign('data', $order); 
      $this->assign('pnum', $pnum);
      $this->display();  
    }

    public function editParty() {
      $uid = session('uid');
      if(!$uid) {
        $this->error('请先登录！', U('Member/login'));
      }

      $orderid = $_GET['orderid'];
      $uid = session('uid');

      $this->assign('uid', $uid);

      //查询订单
      $order = M('activity_apply a')
        ->join('zz_activity b on a.aid = b.id')
        ->join('zz_order c on a.orderid = c.orderid')
        ->where(array('a.orderid' => $orderid))
        ->field('a.aid, a.realname, a.phone, a.idcard, a.uid, b.title, b.thumb, a.orderid, b.money, b.starttime, b.endtime, b.address')
        ->find();

      //查询不到订单
      if(!$order) {
        $this->error('查询订单错误，请联系管理员！');
      }

      //查询常用人
      $linkmen = M('linkman')
        ->where(array('uid' => session('uid')))
        ->select();

      $this->assign('linkmen', $linkmen);

      //查询参与人
      $partners = M('activity_member')
        ->where(array('orderid' => $orderid, 'phone' => array('neq', $order['phone'])))
        ->select();
      
      $lcount = count($partners) + 1;
      $this->assign('lcount', $lcount);

      $this->assign('data', $order);
      $this->assign('partners', $partners);
      $this->display(); 
    }

    public function editpartyconfirm() {
      $uid = session('uid');
      if(!$uid) {
        $this->error('请先登录！', U('member/login'));
      }

      $ret = $_POST;

      //获取修改提交信息
      $orderid = trim($ret['orderid']);
      $aid = intval(trim($ret['aid']));
      $uid = session('uid');
      $realname = trim($ret['realname']);
      $idcard = trim($ret['idcard']);
      $phone = trim($ret['phone']);
      $num = intval(trim($ret['num']));
      $couponsid = intval(trim($ret['couponsid']));
      $discount = intval(trim($ret['discount']));
      $money = floatval(trim($ret['money']));

      $memberids = json_encode($_POST['partners']);
      $partners = $_POST['partners'];

      $user = M('Member')->where(array('id' => $uid))->find();
      $order = M('order')->where(array('orderid' => $orderid))->find();
      $activity = M('activity')->where(array('id' => $aid))->find();
      $apply = M('activity_apply')->where(array('aid' => $aid, 'uid' => $uid))->find();
      
      $premoney = $activity['money'];
      if (empty($premoney) || $premoney == '0.00' || $activity['isfree'] == 1 || $money == '0.00') {
          $data['paystatus'] = 1;
      }
      $data['aid'] = $aid;
      $data['uid'] = $uid;
      $data['orderid'] = $orderid;
      $data['realname'] = $realname;
      $data['idcard'] = $idcard;
      $data['phone'] = $phone;
      $data['num'] = $num;
      $data['couponsid'] = $couponsid;
      $data['discount'] = $discount;
      $data['money'] = $money;
      $data['total'] = $premoney * $num;
      $data['inputtime'] = time();
      $data['memberids'] = $memberids;
      $id = M("activity_apply")->where(array('orderid' => $orderid))->save($data);
      if($id) {
        M('activity_member')->where(array('orderid' => $orderid))->delete();
        if ($partners) {
          foreach ($partners as $partner) {
            $infos = explode(',', $partner);
            M('activity_member')->add(array(
              'uid' => $uid,
              'aid' => $aid,
              'orderid' => $orderid,
              'realname' => $infos[0],
              'idcard' => $infos[1],
              'phone' => $infos[2],
              'inputtime' => time()
            ));
          }
        }
        M('activity_member')->add(array(
            'uid' => $uid,
            'aid' => $aid,
            'orderid' => $orderid,
            'realname' => $realname,
            'idcard' => $idcard,
            'phone' => $phone,
            'inputtime' => time()
        ));
        $order = M('order')->where(array('orderid' => $orderid))->save(array(
            'title' => "蜗牛客慢生活-订单编号" . $orderid,
            'uid' => $uid,
            'orderid' => $orderid,
            'nums' => 1,
            'money' => $money,
            'total' => $premoney * $num,
            'discount' => $discount,
            'couponsid' => $couponsid,
            'inputtime' => time(),
            'ordertype' => 2
        ));
        if ($order) {
          if (empty($premoney) || $premoney == '0.00') {
            M('order_time')->where(array('orderid' => $orderid))->save(array(
                'orderid' => $orderid,
                'status' => 4,
                'pay_status' => 1,
                'pay_time' => time(),
                'donetime' => time(),
                'inputtime' => time()
            ));
          }
        }
        $data['orderid'] = $orderid;
        $this->assign('data', $data);
        $this->display(); 
      } else {
        $this->error('修改失败！');
      }
    }
}
