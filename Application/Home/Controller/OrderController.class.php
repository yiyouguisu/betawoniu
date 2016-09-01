<?php
namespace Home\Controller;
use Home\Common\CommonController;

class OrderController extends CommonController {

    public function show(){
        $orderid=I('orderid');
        $ordertype=M('order')->where(array('orderid'=>$orderid))->getField("ordertype");
        if(!empty($ordertype)){
            switch ($ordertype) {
                case '1':
                    # code...
                    $url=U('Home/Order/hostelshow',array('orderid'=>$orderid));
                    break;
                case '2':
                    # code...
                    $url=U('Home/Order/partyshow',array('orderid'=>$orderid));
                    break;
            }
        }else{
            session("orderid",$orderid);
            $event=M('tripinfo')->where(array('orderid'=>$orderid))->find();
            $type=substr($orderid,0,2);
            switch ($type) {
                case 'ac':
                    # code...
                    $url=U('Home/Party/show',array('id'=>$event['eventid']));
                    break;
                case 'hc':
                    # code...
                    $url=U('Home/Hostel/show',array('id'=>$event['eventid']));
                    break;
            }
        }
        header("location: " . $url);
    }

    public function bookroom() {
    	if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
        	$rid=I('rid');
        	$starttime=I('starttime');
        	$endtime=I('endtime');
        	$mannum=I('mannum');
        	$roomnum=I('roomnum');
            $totalmoney=I('totalmoney');
        	$data=M("Room a")
	            ->join("left join zz_hostel b on a.hid=b.id")
	            ->join("left join zz_member c on b.uid=c.id")
	            ->where(array('a.id'=>$rid))
	            ->field('a.id as rid,a.hid,b.uid,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.imglist,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.inputtime,b.title as hostel,b.area as hostelarea,b.address as hosteladdress,b.lat,b.lng,c.nickname')
	            ->find();
	        $this->assign("data",$data);
	        $this->assign("starttime",$starttime);
	        $this->assign("endtime",$endtime);
	        $this->assign("mannum",$mannum);
	        $this->assign("roomnum",$roomnum);
            $this->assign("totalmoney",$totalmoney);
            $linkman=M("linkman")
                ->where(array('uid'=>$uid))
                ->order(array('id'=>"desc"))
                ->field('id,realname,idcard,phone,inputtime')
                ->select();
            $this->assign("linkman",$linkman);

            $hid=$data['hid'];
            $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
            $city=M('hostel')->where(array('id'=>$hid))->getField("city");
            $where=array();
            $where['a.uid']=$uid;
            $where['a.status']=0;
            $where['b.validity_endtime']=array('egt',time());
            $where['_string']="(b.voucherstype='hostel' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%')))";
            $where['b.id']=array('in',$catids);
            $coupons = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,b.price,b.hid,b.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->select();
            $this->assign("coupons",$coupons);

            $orderid=session("orderid");
            $this->assign("orderid",$orderid);
	    	$this->display();
	    }
    }
    public function edithostelorder(){
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $orderid=I('orderid');
            $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,c.*,a.ordertype');
            $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.orderid'=>$orderid))->field($field)->find();
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $productinfo=M('book_room a')
                ->join("left join zz_room c on a.rid=c.id")
                ->join("left join zz_hostel b on c.hid=b.id")
                ->join("left join zz_member d on a.uid=d.id")
                ->join("left join {$sqlI} e on c.id=e.value")
                ->where(array('a.orderid'=>$data['orderid']))
                ->field("a.rid,a.uid,c.title,c.score as evaluation,c.nomal_money,c.week_money,c.holiday_money,b.id as hid,b.thumb,b.title as hostel,b.area,b.address,a.money,a.realname,a.idcard,a.phone,a.num,a.roomnum,a.days,a.discount,a.couponsid,a.starttime,a.endtime,a.paystatus,a.memberids,d.nickname,d.head,d.realname_status,d.houseowner_status,e.reviewnum,b.uid as houseownerid")
                ->find();
            $book_member=M('book_member')->where(array('orderid'=>$data['orderid'],'linkmanid'=>array('gt',0)))->order(array('id'=>'desc'))->select();
            $productinfo['book_member']=!empty($book_member)?$book_member:null;
            $data['couponstitle']=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$data['couponsid']))->getField("b.title");
            $data['productinfo']=$productinfo;

            $totalmoney=$money=0.00;
            $starttime=$data['productinfo']['starttime'];
            $endtime=$data['productinfo']['endtime'];
            while ( $starttime < $endtime) {
                # code...
                $money=$data['productinfo']['nomal_money'];
                $week=date("w",$value['value']);
                if(in_array($week, array(0,6))) {
                    $money=$data['productinfo']['week_money'];
                }
                $holiday=M('holiday')->where(array('status'=>1,'_string'=>$starttime." <= enddate and ".$starttime." >= startdate"))->field("id,name,days")->find();
                if(!empty($holiday)){
                    $money=$data['productinfo']['holiday_money'];
                }
                $totalmoney+=$money;
                $starttime=strtotime("+1 days",$starttime);
            }
            $data['totalmoney']=$totalmoney;
            $this->assign("data",$data);

            $houseowner=M('member')->where(array('id'=>$productinfo['houseownerid']))->field("id,head,nickname")->find();
            $this->assign("houseowner",$houseowner);

            $ownid=session("uid");
            $this->assign("ownid",$ownid);

            $linkman=M("linkman")
                ->where(array('uid'=>$uid))
                ->order(array('id'=>"desc"))
                ->field('id,realname,idcard,phone,inputtime')
                ->select();
            $this->assign("linkman",$linkman);

            $hid=$data['hid'];
            $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
            $city=M('hostel')->where(array('id'=>$hid))->getField("city");
            $where=array();
            $where['a.uid']=$uid;
            $where['a.status']=0;
            $where['b.validity_endtime']=array('egt',time());
            $where['_string']="(b.voucherstype='hostel' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%')))";
            $where['b.id']=array('in',$catids);
            $coupons = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,b.price,b.hid,b.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->select();
            $this->assign("coupons",$coupons);

            $this->display();
        }
    }
    /**
     *预定房间
     */
    public function dobookroom(){
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $ret=$_POST;
            $rid=intval(trim($ret['rid']));
            $uid=session("uid");
            $realname=trim($ret['realname']);
            $idcard=trim($ret['idcard']);
            $phone=trim($ret['phone']);
            $num=intval(trim($ret['num']));
            $roomnum=intval(trim($ret['roomnum']));
            $starttime=intval(strtotime(trim($ret['starttime'])));
            $endtime=intval(strtotime(trim($ret['endtime'])));
            $days=intval(trim($ret['days']));
            $memberids=trim($ret['memberids']);
            $couponsid=intval(trim($ret['couponsid']));
            $discount=floatval(trim($ret['discount']));
            $money=floatval(trim($ret['money']));

            $user=M('Member')->where(array('id'=>$uid))->find();
            $room= M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.title as hostel,b.uid as houseownerid")->find();
            $apply= M('book_room')->where(array('rid'=>$rid,'uid'=>$uid,'_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))->find();

            $booknum=M('book_room')->where(array('_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))->sum('num');
            if($uid==''||$rid==''||$num==''||$roomnum==''||$days==''||$starttime==''||$endtime==''||$realname==''||$idcard==''||$phone==''){
                $this->error("请求参数错误");
            }elseif(empty($user)){
                $this->error("用户不存在");
            }elseif(empty($room)||$room['isdel']==1){
                $this->error("房间不存在");
            }elseif($room['houseownerid']==$uid){
                $this->error("不能预定自己的房间");
            }elseif($roomnum>$room['mannum']){
                $this->error("房间数超过限制");
            }elseif($room['mannum']-$booknum<$num){
                $this->error("入住人数超过限制");
            }elseif(!empty($apply)&&$apply['paystatus']==1){
                $this->error("已经预定");
            }else{
                if(!empty($couponsid)){
                    $coupons=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$couponsid))->field("a.*,b.validity_endtime")->find();
                    if($coupons){
                        if($coupons['status']==1){
                            $this->error("优惠券已经被使用");
                        }else if($coupons['validity_endtime']<time()){
                            $this->error("优惠券已经被使用");
                        }
                    }else{
                        $this->error("尚未购买此种优惠券");
                    }
                }
                $orderid="hc".date("YmdHis", time()) . rand(100, 999);
                if(!empty($ret['orderid'])){
                    $orderid=$ret['orderid'];
                }
                
                $premoney=$room['money'];
                if(empty($premoney)||$premoney=='0.00'||$money=='0.00'){
                    $data['paystatus']=1;
                }
                $data['rid']=$rid;
                $data['hid']=$room['hid'];
                $data['uid']=$uid;
                $data['orderid']=$orderid;
                $data['num']=$num;
                $data['roomnum']=$roomnum;
                $data['days']=$days;
                $data['realname']=$realname;
                $data['idcard']=$idcard;
                $data['phone']=$phone;
                $data['starttime']=$starttime;
                $data['endtime']=$endtime;
                $data['couponsid']=$couponsid;
                $data['discount']=$discount;
                $data['money']=$money;
                $data['total']=$premoney*$num;
                $data['memberids']=$memberids;
                $data['inputtime']=time();
                $id=M("book_room")->add($data);
                if($id){
                    
                    if(!empty($memberids)){
                        $infobox=M('linkman')->where(array('id'=>array('in',$memberids)))->select();
                        foreach ($infobox as $value)
                        {
                            M('book_member')->add(array(
                                'uid'=>$uid,
                                'rid'=>$rid,
                                'linkmanid'=>$value['id'],
                                'orderid'=>$orderid,
                                'realname'=>$value['realname'],
                                'idcard'=>$value['idcard'],
                                'phone'=>$value['phone'],
                                'inputtime'=>time()
                                ));
                        }
                    }
                    M('book_member')->add(array(
                        'rid'=>$rid,
                        'uid'=>$uid,
                        'orderid'=>$orderid,
                        'realname'=>$realname,
                        'idcard'=>$idcard,
                        'phone'=>$phone,
                        'inputtime'=>time()
                    ));
                    $order=M('order')->add(array(
                        'title'=>"蜗牛客慢生活-订单编号".$orderid,
                        'uid'=>$uid,
                        'orderid'=>$orderid,
                        'nums'=>1,
                        'money'=>$money,
                        'total'=>$premoney*$roomnum,
                        'discount'=>$discount,
                        'couponsid'=>$couponsid,
                        'inputtime'=>time(),
                        'ordertype'=>1
                        ));
                    if($order){
                        if(empty($premoney)||$premoney=='0.00'){
                            M('order_time')->add(array(
                            'orderid'=>$orderid,
                            'status'=>4,
                            'pay_status'=>1,
                            'pay_time'=>time(),
                            'donetime'=>time(),
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
                    M('vouchers_order')->where(array('id'=>$couponsid))->setField('status',1);
                    $data['orderid']=$orderid;
                    \Api\Controller\UtilController::addmessage($room['houseownerid'],"申请入住","您有新的房间预定订单需要审核，请尽快处理。","您有新的房间预定订单需要审核，请尽快处理。","applybookhouse",$orderid);
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_applybookhouse");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_applybookhouse",'r_id'=>$room['houseownerid']));
                    $statuscode=$Ymsms->sendsms($data);
                    if(empty($premoney)||$premoney=='0.00'){
                        $this->redirect("Home/Order/bookfinish",array('orderid'=>$orderid));
                    }else{
                        $this->redirect("Home/Order/bookconfirm",array('orderid'=>$orderid));
                    }
                }else{
                    $this->error("提交失败");
                }
            }
        }
    }
    public function editorder_hostel(){
       if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $ret=$_POST;
            $rid=intval(trim($ret['rid']));
            $uid=session("uid");
            $orderid=trim($ret['orderid']);
            $realname=trim($ret['realname']);
            $idcard=trim($ret['idcard']);
            $phone=trim($ret['phone']);
            $num=intval(trim($ret['num']));
            $roomnum=intval(trim($ret['roomnum']));
            $starttime=intval(trim($ret['starttime']));
            $endtime=intval(trim($ret['endtime']));
            $days=intval(trim($ret['days']));
            $memberids=trim($ret['memberids']);
            $couponsid=intval(trim($ret['couponsid']));
            $discount=floatval(trim($ret['discount']));
            $money=floatval(trim($ret['money']));

            $user=M('Member')->where(array('id'=>$uid))->find();
            $order=M('order')->where(array('orderid'=>$orderid))->find();
            $room= M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.title as hostel,b.uid as houseownerid")->find();
            $apply= M('book_room')->where(array('rid'=>$rid,'uid'=>$uid,'_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))->find();

            $booknum=M('book_room')->where(array('_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))->sum('num');
            if($uid==''||$rid==''||$num==''||$roomnum==''||$days==''||$starttime==''||$endtime==''||$realname==''||$idcard==''||$phone==''){
                $this->error("请求参数错误");
            }elseif(empty($user)){
                $this->error("用户不存在");
            }elseif(empty($room)||$room['isdel']==1){
                $this->error("房间不存在");
            }elseif($room['houseownerid']==$uid){
                $this->error("不能预定自己的房间");
            }elseif($roomnum>$room['mannum']){
                $this->error("房间数超过限制");
            }elseif($room['mannum']-$booknum<$num){
                $this->error("入住人数超过限制");
            }elseif(!empty($apply)&&$apply['paystatus']==1){
                $this->error("已经预定");
            }else{
                if(!empty($couponsid)){
                    $coupons=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$couponsid))->field("a.*,b.validity_endtime")->find();
                    if($coupons){
                        if($coupons['status']==1){
                            $this->error("优惠券已经被使用");
                        }else if($coupons['validity_endtime']<time()){
                            $this->error("优惠券已经被使用");
                        }
                    }else{
                        $this->error("尚未购买此种优惠券");
                    }
                }
                $premoney=$room['money'];
                if(empty($premoney)||$premoney=='0.00'||$money=='0.00'){
                    $data['paystatus']=1;
                }
                $data['rid']=$rid;
                $data['hid']=$room['hid'];
                $data['uid']=$uid;
                $data['orderid']=$orderid;
                $data['num']=$num;
                $data['roomnum']=$roomnum;
                $data['days']=$days;
                $data['realname']=$realname;
                $data['idcard']=$idcard;
                $data['phone']=$phone;
                $data['starttime']=$starttime;
                $data['endtime']=$endtime;
                $data['couponsid']=$couponsid;
                $data['discount']=$discount;
                $data['money']=$money;
                $data['total']=$premoney*$num;
                $data['memberids']=$memberids;
                $data['inputtime']=time();
                $id=M("book_room")->where(array('orderid'=>$orderid))->save($data);
                if($id){
                    M('book_member')->where(array('orderid'=>$orderid))->delete();
                    if(!empty($memberids)){
                        $infobox=M('linkman')->where(array('id'=>array('in',$memberids)))->select();
                        foreach ($infobox as $value)
                        {
                            M('book_member')->add(array(
                                'uid'=>$uid,
                                'rid'=>$rid,
                                'linkmanid'=>$value['id'],
                                'orderid'=>$orderid,
                                'realname'=>$value['realname'],
                                'idcard'=>$value['idcard'],
                                'phone'=>$value['phone'],
                                'inputtime'=>time()
                                ));
                        }
                    }
                    M('book_member')->add(array(
                        'uid'=>$uid,
                        'rid'=>$rid,
                        'orderid'=>$orderid,
                        'realname'=>$realname,
                        'idcard'=>$idcard,
                        'phone'=>$phone,
                        'inputtime'=>time()
                    ));
                    $order=M('order')->where(array('orderid'=>$orderid))->save(array(
                        'title'=>"蜗牛客慢生活-订单编号".$orderid,
                        'uid'=>$uid,
                        'orderid'=>$orderid,
                        'nums'=>1,
                        'money'=>$money,
                        'total'=>$premoney*$roomnum,
                        'discount'=>$discount,
                        'couponsid'=>$couponsid,
                        'inputtime'=>time(),
                        'ordertype'=>1
                        ));
                    if($order){
                        if(empty($premoney)||$premoney=='0.00'){
                            M('order_time')->where(array('orderid'=>$orderid))->save(array(
                            'orderid'=>$orderid,
                            'status'=>4,
                            'pay_status'=>1,
                            'pay_time'=>time(),
                            'donetime'=>time(),
                            'inputtime'=>time()
                            ));
                        }
                    }
                    M('vouchers_order')->where(array('id'=>$couponsid))->setField('status',1);
                    $data['orderid']=$orderid;
                    \Api\Controller\UtilController::addmessage($room['houseownerid'],"申请入住","您有新的房间预定订单需要审核，请尽快处理。","您有新的房间预定订单需要审核，请尽快处理。","applybookhouse",$orderid);
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_applybookhouse");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_applybookhouse",'r_id'=>$room['houseownerid']));
                    $statuscode=$Ymsms->sendsms($data);
                    if(empty($premoney)||$premoney=='0.00'){
                        $this->redirect("Home/Order/bookfinish",array('orderid'=>$orderid));
                    }else{
                        $this->redirect("Home/Order/bookconfirm",array('orderid'=>$orderid));
                    }
                }else{
                    $this->error("提交失败");
                }
            }
        }
    }
    public function bookconfirm() {
    	if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
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
            $evaluationconfirm=M()->query("SELECT AVG(b.sufftime) FROM(SELECT(b.review_time - b.inputtime) / 60 AS sufftime FROM zz_book_room a LEFT JOIN zz_order_time b ON a.orderid = b.orderid LEFT JOIN zz_hostel c ON a.hid = c.id WHERE(b.status = 4)AND (b.review_status > 0)AND (c.uid = ".$data['uid'].")) b");
            $data['evaluationconfirm']=!empty($evaluationconfirm)?sprintf("%.2f",$evaluationconfirm):0.0;
            $this->assign("data",$data);
            $this->assign("order",$order);

            $where=array();
            $where['a.hid']=$data['hid'];
            $where['a.isdel']=0;
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $house_owner_room=M("Room a")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.inputtime,c.reviewnum')
                ->limit(4)
                ->select();
            foreach ($house_owner_room as $key => $value) {
                # code...
                $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"room",'value'=>$value['id']))->find();
                if(!empty($hitstatus)){
                    $house_owner_room[$key]['ishit']=1;
                }else{
                    $house_owner_room[$key]['ishit']=0;
                }
                $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"room",'value'=>$value['id']))->find();
                if(!empty($collectstatus)){
                    $house_owner_room[$key]['iscollect']=1;
                }else{
                    $house_owner_room[$key]['iscollect']=0;
                }
            }
            $this->assign("house_owner_room",$house_owner_room);
            $this->display();
        }
    }

    public function bookpay() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $orderid=I('orderid');
            $reviewstatus=M('order_time')->where(array('orderid'=>$orderid))->getField("status");
            if($reviewstatus!=2){
                $this->error("该订单尚未审核通过，请等待商家审核！");
            }
            $order=M('book_room')->where(array('orderid'=>$orderid))->find();
            $id=$order['rid'];
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("Room a")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->join("left join zz_hostel b on a.hid=b.id")
                ->join("left join zz_member d on b.uid=d.id")
                ->where(array('a.id'=>$id))
                ->field('a.id,a.hid,b.uid,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.inputtime,a.score as evaluation,a.scorepercent as evaluationpercent,c.reviewnum,b.title as hostel,b.area as hostelarea,b.address as hosteladdress,b.lat,b.lng,d.nickname,d.head,d.realname_status,d.houseowner_status,d.rongyun_token')
                ->find();
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            $this->assign("data",$data);
            $this->assign("order",$order);
        	$this->display();
        }
    }

    public function bookfinish() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
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
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.inputtime,c.reviewnum')
                ->limit(4)
                ->select();
            foreach ($house_owner_room as $key => $value) {
                # code...
                $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"room",'value'=>$value['id']))->find();
                if(!empty($hitstatus)){
                    $house_owner_room[$key]['ishit']=1;
                }else{
                    $house_owner_room[$key]['ishit']=0;
                }
                $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"room",'value'=>$value['id']))->find();
                if(!empty($collectstatus)){
                    $house_owner_room[$key]['iscollect']=1;
                }else{
                    $house_owner_room[$key]['iscollect']=0;
                }
            }
            $this->assign("house_owner_room",$house_owner_room);
            $this->display();
        }
    }



    public function joinparty(){
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $id=I('aid');
            $uid=session("uid");
            $data=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.id'=>$id))
                ->field('a.id,a.catid,a.city,a.title,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.partytype,a.starttime,a.endtime,a.content,a.start_numlimit,a.end_numlimit,a.yes_num,a.view,a.uid,b.nickname,b.head,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime')
                ->find();
            $data['catname']=M('partycate')->where(array('id'=>$data['catid']))->getField("catname");  
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            $joinnum=M('activity_apply')->where(array('aid'=>$data['id'],'paystatus'=>1))->sum("num");
            $data['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$data['id'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->limit(6)->select();
            $data['joinlist']=!empty($joinlist)?$joinlist:null;
            $this->assign("data",$data);

            $linkman=M("linkman")
                ->where(array('uid'=>$uid))
                ->order(array('id'=>"desc"))
                ->field('id,realname,idcard,phone,inputtime')
                ->select();
            $this->assign("linkman",$linkman);

            $aid=$data['id'];
            $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
            $city=$data['city'];
            $where['a.uid']=$uid;
            $where['a.status']=0;
            $where['b.validity_endtime']=array('egt',time());
            $where['_string']="(b.voucherstype='party' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%')))";
            $where['b.id']=array('in',$catids);
            $coupons = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,b.price,b.hid,b.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->select();
            $this->assign("coupons",$coupons);
            $orderid=session("orderid");
            $this->assign("orderid",$orderid);
            $this->display();
        }
    }
    public function editpartyorder(){
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $orderid=I('orderid');
            $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,c.*,a.ordertype');
            $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.orderid'=>$orderid))->field($field)->find();
            $productinfo=M('activity_apply a')
                ->join("left join zz_activity b on a.aid=b.id")
                ->join("left join zz_member c on a.uid=c.id")
                ->where(array('a.orderid'=>$data['orderid']))
                ->field("a.aid,a.uid,b.thumb,b.title,b.catid,a.money,a.memberids,b.isfree,b.area,b.address,b.starttime,b.endtime,b.start_numlimit,b.end_numlimit,a.realname,a.phone,a.idcard,a.num,a.paystatus,b.uid as houseownerid,c.nickname,c.head,c.realname_status,c.houseowner_status")
                ->find();
            $productinfo['catname']=M('partycate')->where(array('id'=>$productinfo['catid']))->getField("catname");  
            $joinnum=M('activity_apply')->where(array('aid'=>$productinfo['aid'],'paystatus'=>1))->sum("num");
            $productinfo['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$productinfo['aid'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->limit(6)->select();
            $productinfo['joinlist']=!empty($joinlist)?$joinlist:null;
            $book_member=M('activity_member')->where(array('orderid'=>$data['orderid'],'linkmanid'=>array('gt',0)))->order(array('id'=>'desc'))->select();
            $productinfo['book_member']=!empty($book_member)?$book_member:null;
            $data['couponstitle']=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$data['couponsid']))->getField("b.title");
            $data['productinfo']=$productinfo;
            $this->assign("data",$data);

            $houseowner=M('member')->where(array('id'=>$productinfo['houseownerid']))->field("id,head,nickname")->find();
            $this->assign("houseowner",$houseowner);

            $ownid=session("uid");
            $this->assign("ownid",$ownid);

            $linkman=M("linkman")
                ->where(array('uid'=>$uid))
                ->order(array('id'=>"desc"))
                ->field('id,realname,idcard,phone,inputtime')
                ->select();
            $this->assign("linkman",$linkman);

            $aid=$data['aid'];
            $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
            $city=$data['city'];
            $where['a.uid']=$uid;
            $where['a.status']=0;
            $where['b.validity_endtime']=array('egt',time());
            $where['_string']="(b.voucherstype='party' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%')))";
            $where['b.id']=array('in',$catids);
            $coupons = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,b.price,b.hid,b.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->select();
            $this->assign("coupons",$coupons);

            $this->display();
        }
    }
    /**
     *活动报名
     */
    public function dojoinparty(){
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $ret=$_POST;
            $aid=intval(trim($ret['aid']));
            $uid=session("uid");
            $realname=trim($ret['realname']);
            $idcard=trim($ret['idcard']);
            $phone=trim($ret['phone']);
            $num=intval(trim($ret['num']));
            $couponsid=intval(trim($ret['couponsid']));
            $discount=intval(trim($ret['discount']));
            $money=floatval(trim($ret['money']));
            $memberids=trim($ret['memberids']);

            $user=M('Member')->where(array('id'=>$uid))->find();
            $activity= M('activity')->where(array('id'=>$aid))->find();
            $apply= M('activity_apply')->where(array('aid'=>$aid,'uid'=>$uid))->find();
            if($uid==''||$aid==''||$realname==''||$idcard==''||$num==''||$phone==''){
                $this->error("请求参数错误");
            }elseif(empty($user)){
                $this->error("用户不存在");
            }elseif(empty($activity)||$activity['isdel']==1){
                $this->error("活动不存在");
            }elseif($activity['uid']==$uid){
                $this->error("不能参加自己的活动");
            }elseif($activity['end_numlimit']-$activity['yes_num']<$num){
                $this->error("活动人数超过限制");
            }elseif($activity['endtime']<time()){
                $this->error("活动已经过期");
            }elseif(!empty($apply)&&$apply['paystatus']==1){
                $this->error("已经报名");
            }else{
                if(!empty($couponsid)){
                    $coupons=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$couponsid))->field("a.*,b.validity_endtime")->find();
                    if($coupons){
                        if($coupons['status']==1){
                            $this->error("优惠券已经被使用");
                        }else if($coupons['validity_endtime']<time()){
                            $this->error("优惠券已经被使用");
                        }
                    }else{
                        $this->error("尚未购买此种优惠券");
                    }
                }
                $orderid="ac".date("YmdHis", time()) . rand(100, 999);
                if(!empty($ret['orderid'])){
                    $orderid=$ret['orderid'];
                }
                $premoney=$activity['money'];
                if(empty($premoney)||$premoney=='0.00'||$activity['isfree']==1||$money=='0.00'){
                    $data['paystatus']=1;
                }
                $data['aid']=$aid;
                $data['uid']=$uid;
                $data['orderid']=$orderid;
                $data['realname']=$realname;
                $data['idcard']=$idcard;
                $data['phone']=$phone;
                $data['num']=$num;
                $data['couponsid']=$couponsid;
                $data['discount']=$discount;
                $data['money']=$money;
                $data['total']=$premoney*$num;
                $data['memberids']=$memberids;
                $data['inputtime']=time();
                $id=M("activity_apply")->add($data);
                if($id){
                    if(!empty($memberids)){
                        $infobox=M('linkman')->where(array('id'=>array('in',$memberids)))->select();
                        foreach ($infobox as $value)
                        {
                            M('activity_member')->add(array(
                                'uid'=>$uid,
                                'aid'=>$aid,
                                'linkmanid'=>$value['id'],
                                'orderid'=>$orderid,
                                'realname'=>$value['realname'],
                                'idcard'=>$value['idcard'],
                                'phone'=>$value['phone'],
                                'inputtime'=>time()
                                ));
                        }
                    }
                    M('activity_member')->add(array(
                        'uid'=>$uid,
                        'aid'=>$aid,
                        'orderid'=>$orderid,
                        'realname'=>$realname,
                        'idcard'=>$idcard,
                        'phone'=>$phone,
                        'inputtime'=>time()
                    ));
                    $order=M('order')->add(array(
                        'title'=>"蜗牛客慢生活-订单编号".$orderid,
                        'uid'=>$uid,
                        'orderid'=>$orderid,
                        'nums'=>1,
                        'money'=>$money,
                        'total'=>$premoney*$num,
                        'discount'=>$discount,
                        'couponsid'=>$couponsid,
                        'inputtime'=>time(),
                        'ordertype'=>2
                        ));
                    if($order){
                       if(empty($premoney)||$premoney=='0.00'){
                            M('order_time')->add(array(
                            'orderid'=>$orderid,
                            'status'=>4,
                            'pay_status'=>1,
                            'pay_time'=>time(),
                            'donetime'=>time(),
                            'inputtime'=>time()
                            ));
                        }else{
                            M('order_time')->add(array(
                            'orderid'=>$orderid,
                            'status'=>2,
                            'inputtime'=>time()
                            ));
                        }
                    }
                    M('vouchers_order')->where(array('id'=>$couponsid))->setField('status',1);
                    $data['orderid']=$orderid;
                    if(empty($premoney)||$premoney=='0.00'){
                        $this->redirect("Home/Order/joinsuccess",array('orderid'=>$orderid));
                    }else{
                        $this->redirect("Home/Order/joinpay",array('orderid'=>$orderid));
                    }
                    
                }else{
                    $this->error("提交失败");
                }
            }
        }
    }
    public function editorder_party(){
       if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $ret=$_POST;
            $aid=intval(trim($ret['aid']));
            $uid=session("uid");
            $orderid=trim($ret['orderid']);
            $aid=intval(trim($ret['aid']));
            $realname=trim($ret['realname']);
            $idcard=trim($ret['idcard']);
            $phone=trim($ret['phone']);
            $num=intval(trim($ret['num']));
            $couponsid=intval(trim($ret['couponsid']));
            $discount=intval(trim($ret['discount']));
            $money=floatval(trim($ret['money']));
            $memberids=trim($ret['memberids']);

            $user=M('Member')->where(array('id'=>$uid))->find();
            $order=M('order')->where(array('orderid'=>$orderid))->find();
            $activity= M('activity')->where(array('id'=>$aid))->find();
            $apply= M('activity_apply')->where(array('aid'=>$aid,'uid'=>$uid))->find();
            if($orderid==''||$uid==''||$aid==''||$realname==''||$idcard==''||$num==''||$phone==''){
                $this->error("请求参数错误");
            }elseif(empty($user)){
                $this->error("用户不存在");
            }elseif(empty($activity)||$activity['isdel']==1){
                $this->error("活动不存在");
            }elseif($activity['uid']==$uid){
                $this->error("不能参加自己的活动");
            }elseif($activity['end_numlimit']-$activity['yes_num']<$num){
                $this->error("活动人数超过限制");
            }elseif(!empty($apply)&&$apply['paystatus']==1){
                $this->error("已经报名");
            }else{
                if(!empty($couponsid)){
                    $coupons=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$couponsid))->field("a.*,b.validity_endtime")->find();
                    if($coupons){
                        if($coupons['status']==1){
                            $this->error("优惠券已经被使用");
                        }else if($coupons['validity_endtime']<time()){
                            $this->error("优惠券已经被使用");
                        }
                    }else{
                        $this->error("尚未购买此种优惠券");
                    }
                }
                $premoney=$activity['money'];
                if(empty($premoney)||$premoney=='0.00'||$activity['isfree']==1||$money=='0.00'){
                    $data['paystatus']=1;
                }
                $data['aid']=$aid;
                $data['uid']=$uid;
                $data['orderid']=$orderid;
                $data['realname']=$realname;
                $data['idcard']=$idcard;
                $data['phone']=$phone;
                $data['num']=$num;
                $data['couponsid']=$couponsid;
                $data['discount']=$discount;
                $data['money']=$money;
                $data['total']=$premoney*$num;
                $data['inputtime']=time();
                $data['memberids']=$memberids;
                $id=M("activity_apply")->where(array('orderid'=>$orderid))->save($data);
                if($id){
                    M('activity_member')->where(array('orderid'=>$orderid))->delete();
                    if(!empty($memberids)){
                        $infobox=M('linkman')->where(array('id'=>array('in',$memberids)))->select();
                        foreach ($infobox as $value)
                        {
                            M('activity_member')->add(array(
                                'uid'=>$uid,
                                'aid'=>$aid,
                                'linkmanid'=>$value['id'],
                                'orderid'=>$orderid,
                                'realname'=>$value['realname'],
                                'idcard'=>$value['idcard'],
                                'phone'=>$value['phone'],
                                'inputtime'=>time()
                                ));
                        }
                    }
                    M('activity_member')->add(array(
                        'uid'=>$uid,
                        'aid'=>$aid,
                        'orderid'=>$orderid,
                        'realname'=>$realname,
                        'idcard'=>$idcard,
                        'phone'=>$phone,
                        'inputtime'=>time()
                    ));
                    $order=M('order')->where(array('orderid'=>$orderid))->save(array(
                        'title'=>"蜗牛客慢生活-订单编号".$orderid,
                        'uid'=>$uid,
                        'orderid'=>$orderid,
                        'nums'=>1,
                        'money'=>$money,
                        'total'=>$premoney*$num,
                        'discount'=>$discount,
                        'couponsid'=>$couponsid,
                        'inputtime'=>time(),
                        'ordertype'=>2
                        ));
                    if($order){
                        if(empty($premoney)||$premoney=='0.00'){
                            M('order_time')->where(array('orderid'=>$orderid))->save(array(
                            'orderid'=>$orderid,
                            'status'=>4,
                            'pay_status'=>1,
                            'pay_time'=>time(),
                            'dnoetime'=>time(),
                            'inputtime'=>time()
                            ));
                        }
                    }
                    $data['orderid']=$orderid;
                    M('vouchers_order')->where(array('id'=>$couponsid))->setField('status',1);
                    $data['orderid']=$orderid;
                    if(empty($premoney)||$premoney=='0.00'){
                        $this->redirect("Home/Order/joinsuccess",array('orderid'=>$orderid));
                    }else{
                        $this->redirect("Home/Order/joinpay",array('orderid'=>$orderid));
                    }
                    
                }else{
                    $this->error("提交失败");
                }
            }
        }
    }
    public function joinpay(){
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $orderid=I('orderid');
            $order=M('activity_apply')->where(array('orderid'=>$orderid))->find();
            $id=$order['aid'];
            $data=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.id'=>$id))
                ->field('a.id,a.catid,a.title,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.partytype,a.starttime,a.endtime,a.content,a.start_numlimit,a.end_numlimit,a.yes_num,a.view,a.uid,b.nickname,b.head,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime')
                ->find();
            $data['catname']=M('partycate')->where(array('id'=>$data['catid']))->getField("catname");  
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            $joinnum=M('activity_apply')->where(array('aid'=>$data['id'],'paystatus'=>1))->sum("num");
            $data['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$data['id'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->limit(6)->select();
            $data['joinlist']=!empty($joinlist)?$joinlist:null;
            $this->assign("data",$data);
            $this->assign("order",$order);


            $this->display();
        }
    }
    public function joinsuccess(){
        $orderid=I('orderid');
        $order=M('activity_apply')->where(array('orderid'=>$orderid))->find();
        $id=$order['aid'];
        $uid=session("uid");
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
            $distance=$Map->get_distance_baidu("driving",$data['lat'].",".$data['lng'],$value['lat'].",".$value['lng']);
            $party_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        $data['party_near_hostel']=!empty($party_near_hostel)?$party_near_hostel:null;
        $this->assign("data",$data);
        $this->display();
    }
    public function evaluate(){
        $orderid=I('orderid');
        $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,c.*,a.ordertype');
        $data=M('book_room a')
            ->join("left join zz_room c on a.rid=c.id")
            ->join("left join zz_hostel b on c.hid=b.id")
            ->join("left join zz_member d on a.uid=d.id")
            ->where(array('a.orderid'=>$orderid))
            ->field("a.rid,a.uid,a.orderid,c.title,b.score as evaluation,b.id as hid,b.thumb,b.title as hostel,b.area,b.address,a.money,a.realname,a.idcard,a.phone,a.num,a.roomnum,a.days,a.discount,a.couponsid,a.starttime,a.endtime,a.paystatus,d.nickname,d.head,d.realname_status,d.houseowner_status,b.uid as houseownerid")
            ->find();
        $this->assign("data",$data);
        $this->display();
    }
    /*
     **评价订单
     */
    public function doevaluate(){
        $ret = $_POST;
        $uid = session("uid");
        $orderid = trim($ret['orderid']);
        $neat = intval(trim($ret['neat']));
        $safe = intval(trim($ret['safe']));
        $match = intval(trim($ret['match']));
        $position = intval(trim($ret['position']));
        $cost = intval(trim($ret['cost']));
        $thumb = trim($ret['thumb']);
        $content = trim($ret['content']);
        $isanonymous = intval(trim($ret['isanonymous']));

        $user=M('Member')->where(array('id'=>$uid))->find();
        $order=M('order')->where(array('orderid'=>$orderid))->find();
        if ($uid == ''||$orderid==''||$neat==''||$safe==''||$match==''||$position==''||$cost=='') {
            exit(json_encode(array('code' =>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"The Order is not exist!")));
        }else {
            $room=M('book_room a')->join("left join zz_room b on a.rid=b.id")->where(array('a.orderid'=>$orderid))->find();
            $id=M('evaluation')->add(array(
                'rid'=>$room['id'],
                'hid'=>$room['hid'],
                'uid'=>$uid,
                'orderid'=>$orderid,
                'neat'=>$neat,
                'safe'=>$safe,
                'match'=>$match,
                'position'=>$position,
                'cost'=>$cost,
                'content'=>$content,
                'isanonymous'=>$isanonymous,
                'thumb'=>$thumb,
                'status'=>0,
                'inputtime'=>time()
                ));
            if($id){
                M('order_time')->where(array('orderid'=>$orderid))->save(array(
                    'evaluate_status'=>1,
                    'evaluate_time'=>time()
                    ));
                $Hostel=M('Hostel')->where(array('id'=>$room['hid']))->find();

                $evaluationset=get_evaluationset($id);
                $data['value']=$room['hid'];
                $data['uid']=$uid;
                $data['content']=$content;
                $data['varname']='hostel';
                $data['inputtime']=time();
                $data['evaluation']=$evaluationset['evaluation'];
                $data['evaluationpercent']=$evaluationset['evaluationpercent'];
                M("review")->add($data);
                \Api\Controller\UtilController::addmessage($Hostel['uid'],"美宿评论","您的美宿(".$Hostel['title'].")被其他用户评论了","您的美宿(".$Hostel['title'].")被其他用户评论了","hostelreview",$Hostel['id']);
                $data['value']=$room['id'];
                $data['uid']=$uid;
                $data['content']=$content;
                $data['varname']='room';
                $data['inputtime']=time();
                $data['evaluation']=$evaluationset['evaluation'];
                $data['evaluationpercent']=$evaluationset['evaluationpercent'];
                M("review")->add($data);
                \Api\Controller\UtilController::addmessage($Hostel['uid'],"房间评论","您的房间(".$room['title'].")被其他用户评论了","您的房间(".$room['title'].")被其他用户评论了","roomreview",$room['id']);
                $evaluationset=gethouse_evaluation($room['hid']);
                $evaluation=!empty($evaluationset['evaluation'])?$evaluationset['evaluation']:10.0;
                $evaluationpercent=!empty($evaluationset['percent'])?$evaluationset['percent']:100.00;
                M('hostel')->where(array('id'=>$room['hid']))->save(array('score'=>$evaluation,'scorepercent'=>$evaluationpercent));
                $evaluationset=getroom_evaluation($room['id']);
                $evaluation=!empty($evaluationset['evaluation'])?$evaluationset['evaluation']:10.0;
                $evaluationpercent=!empty($evaluationset['percent'])?$evaluationset['percent']:100.00;
                M('room')->where(array('id'=>$room['id']))->save(array('score'=>$evaluation,'scorepercent'=>$evaluationpercent));
                exit(json_encode(array('code'=>200,'msg'=>"评价成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"评价失败")));
            }
        }
    }
    public function hostelshow(){
        $orderid=I('orderid');
        $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,c.*,a.ordertype');
        $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.orderid'=>$orderid))->field($field)->find();
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $productinfo=M('book_room a')
            ->join("left join zz_room c on a.rid=c.id")
            ->join("left join zz_hostel b on c.hid=b.id")
            ->join("left join zz_member d on a.uid=d.id")
            ->join("left join {$sqlI} e on c.id=e.value")
            ->where(array('a.orderid'=>$data['orderid']))
            ->field("a.rid,a.uid,c.title,c.score as evaluation,c.scorepercent as evaluationpercent,b.id as hid,b.thumb,b.title as hostel,b.area,b.address,b.content,a.money,a.realname,a.idcard,a.phone,a.num,a.roomnum,a.days,a.discount,a.couponsid,a.starttime,a.endtime,a.paystatus,d.nickname,d.head,d.realname_status,d.houseowner_status,e.reviewnum,b.uid as houseownerid")
            ->find();
        $book_member=M('book_member')->where(array('orderid'=>$data['orderid'],'linkmanid'=>array('gt',0)))->order(array('id'=>'desc'))->select();
        $productinfo['book_member']=!empty($book_member)?$book_member:null;
        $data['couponstitle']=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$data['couponsid']))->getField("b.title");
        $data['productinfo']=$productinfo;
        $this->assign("data",$data);

        $houseowner=M('member')->where(array('id'=>$productinfo['houseownerid']))->field("id,head,nickname")->find();
        $this->assign("houseowner",$houseowner);

        $ownid=session("uid");
        $this->assign("ownid",$ownid);
        $this->display();
    }
    public function partyshow(){
        $orderid=I('orderid');
        $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,c.*,a.ordertype');
        $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->where(array('a.orderid'=>$orderid))->field($field)->find();
        $productinfo=M('activity_apply a')
            ->join("left join zz_activity b on a.aid=b.id")
            ->join("left join zz_member c on a.uid=c.id")
            ->where(array('a.orderid'=>$data['orderid']))
            ->field("a.aid,a.uid,b.thumb,b.title,b.catid,a.money,b.isfree,b.area,b.address,b.starttime,b.endtime,b.start_numlimit,b.end_numlimit,b.cancelrule,a.realname,a.phone,a.idcard,a.num,a.paystatus,b.uid as houseownerid,c.nickname,c.head,c.realname_status,c.houseowner_status")
            ->find();
        $productinfo['catname']=M('partycate')->where(array('id'=>$productinfo['catid']))->getField("catname");  
        $joinnum=M('activity_apply')->where(array('aid'=>$productinfo['aid'],'paystatus'=>1))->sum("num");
        $productinfo['joinnum']=!empty($joinnum)?$joinnum:0;
        $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$productinfo['aid'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->limit(6)->select();
        $productinfo['joinlist']=!empty($joinlist)?$joinlist:null;
        $book_member=M('activity_member')->where(array('orderid'=>$data['orderid'],'linkmanid'=>array('gt',0)))->order(array('id'=>'desc'))->select();
        $productinfo['book_member']=!empty($book_member)?$book_member:null;
        $data['couponstitle']=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$data['couponsid']))->getField("b.title");
        $data['productinfo']=$productinfo;
        $this->assign("data",$data);

        $houseowner=M('member')->where(array('id'=>$productinfo['houseownerid']))->field("id,head,nickname")->find();
        $this->assign("houseowner",$houseowner);

        $ownid=session("uid");
        $this->assign("ownid",$ownid);
        $this->display();
    }
    public function dopay(){
        $paytype=I('paytype');
        $orderid=I('orderid');
        $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->find();
        if(empty($order)){
            $this->error("该笔订单不存在");
        }
        if($order['pay_status']==1){
            $this->error("该笔订单已经支付");
        }
        $paytypeconfig=C("paytypeconfig");
        M('order')->where(array('orderid'=>$orderid))->save(array(
            'paytype'=>$paytype,
            'channel'=>$paytypeconfig[$paytype],
        ));
        $title=$body=$value="";
        if($order['ordertype']==1){
            $room= M('book_room a')->join("left join zz_room b on a.rid=b.id")->where(array('a.orderid'=>$orderid))->find();
            $title="预定房间";
            $body="预定".$room['title']."支付".$order['money'];
            $value=$room['rid'];
        }else if($order['ordertype']==2){
            $activity= M('activity_apply a')->join("left join zz_activity b on a.aid=b.id")->where(array('a.orderid'=>$orderid))->find();
            $title="参加活动";
            $body="参加".$activity['title'].",支付".$order['money'];
            $value=$activity['aid'];
        }
        $orderid=$orderid.rand(100000, 999999);
        if ($paytype == 1) {
            $this->alipay_webpay($orderid,$title,$body,$order['money'],$order['ordertype'],$value);
        } elseif ($paytype == 2) {
            $this->weixin_webpay($orderid,$title,$body,$order['money'],$order['ordertype'],$value);
        } elseif ($paytype == 3) {
            $this->union_webpay($orderid,$title,$body,$order['money'],$order['ordertype'],$value);
        }else{
            $this->error("支付方式无效");
        }
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
        require_once( VENDOR_PATH . "Alipay/lib/alipay_notify.class.php");
        $AliPayConfig=array(
            'partner' => '2088221764898885',
        );
        $alipayNotify = new \AlipayNotify($alipay_config);
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
                        $this->redirect('Home/Order/joinsuccess', array('orderid' => $orderid));
                        break;
                    case "hc":
                        $this->redirect('Home/Order/bookfinish', array('orderid' => $orderid));
                        break;
                }
                
            } else {
                $this->error("支付失败",U('Home/Member/myorder_hostel'));
            }
        } else {
            $this->error("校验失败,数据可疑",U('Home/Member/myorder_hostel'));
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
                        $this->redirect('Home/Order/joinsuccess', array('orderid' => $orderid));
                        break;
                    case "hc":
                        $this->redirect('Home/Order/bookfinish', array('orderid' => $orderid));
                        break;
                }
            } else {
                $this->error("支付失败",U('Home/Member/myorder_hostel'));
            }
        } else {
            $this->error("校验失败,数据可疑",U('Home/Member/myorder_hostel'));
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
        $data['couponstitle']=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$data['couponsid']))->getField("b.title");
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
                        'donetime'=>time(),
                        'pay_status'=>1,
                        'pay_time'=>time()
                    ));
                    M('activity_apply')->where(array('orderid'=> $orderid))->save(array(
                        'paystatus'=>1,
                        'paytime'=>time()
                    ));
                    $data=M('activity_apply a')->join("left join zz_activity b on a.aid=b.id")->where(array('a.orderid'=> $orderid))->field("a.*,b.vouchersrange,b.vouchersdiscount,b.uid as houseownerid")->find();
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
                        'donetime'=>time(),
                        'pay_status'=>1,
                        'pay_time'=>time()
                    ));
                    M('book_room')->where(array('orderid'=> $orderid))->save(array(
                        'paystatus'=>1,
                        'paytime'=>time()
                    ));
                    $data=M('book_room a')->join("left join zz_room b on a.rid=b.id")->join("left join zz_hostel c on a.hid=c.id")->where(array('a.orderid'=> $orderid))->field("a.*,c.vouchersrange,c.vouchersdiscount,c.uid as houseownerid")->find();
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

            \Api\Controller\UtilController::addmessage($order['uid'],"订单支付成功","恭喜您，您有一笔预定订单支付成功！","恭喜您，您有一笔预定订单支付成功！","payordersuccess",$orderid);
            $Ymsms = A("Api/Ymsms");
            $content=$Ymsms->getsmstemplate("sms_payordersuccess");
            $data=json_encode(array('content'=>$content,'type'=>"sms_payordersuccess",'r_id'=>$order['uid']));
            $statuscode=$Ymsms->sendsms($data);
            \Api\Controller\UtilController::addmessage($data['houseownerid'],"订单支付成功","恭喜您，您有一笔预定订单支付成功！","恭喜您，您有一笔预定订单支付成功！","bpayordersuccess",$orderid);
            $data=json_encode(array('content'=>$content,'type'=>"sms_payordersuccess",'r_id'=>$data['houseownerid']));
            $statuscode=$Ymsms->sendsms($data);
            if($vouchers_order_id){
                \Api\Controller\UtilController::addmessage($order['uid'],"订单支付成功","恭喜您，获得我们的优惠券！","恭喜您，获得我们的优惠券！","getcoupons",$vouchers_order_id);
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
    public function ajax_getpaystatus(){
        $orderid=$_POST['orderid'];
        $ordstatus = M('order_time')->where(array('orderid' => $orderid))->getField('pay_status');
        if ($ordstatus == 1) {
            $this->ajaxReturn(array('code'=>200,'msg'=>'paysuccess'),'json');
        } else {
            $this->ajaxReturn(array('code'=>-200,'msg'=>'payerror','data'=>$_POST),'json');
        }
    }
    /*
     **审核订单
     */
    public function ajax_revieworder(){
        $ret=$_POST;
        $uid=session("uid");
        $orderid=trim($ret['orderid']);
        $status=intval(trim($ret['status']));
        $remark=trim($ret['remark']);

        $user=M('Member')->where(array('id'=>$uid))->find();
        $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->find();
        if($uid==''||$orderid==''||$status==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"The Order is not exist!")));
        }elseif($order['status']==2){
           exit(json_encode(array('code'=>-200,'msg'=>"该订单不能关闭")));
        }
        else{
            $select['orderid']=$orderid;
            $id=M('order_time')->where($select)->save(array(
                'status'=>$status,
                'review_remark'=>$remark,
                'review_status'=>1,
                'review_time'=>time()
                ));
            if($id){
                $room= M('book_room a')->join("left join zz_room b on a.rid=b.id")->join("left join zz_hostel c on b.hid=c.id")->where(array('a.orderid'=>$orderid))->field("a.*,c.area,c.address")->find();
                if($status==2){
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_successbookhouse");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_successbookhouse",'r_id'=>$room['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    \Api\Controller\UtilController::addmessage($room['uid'],"申请入住","您预定的房间，已经通过房东审核，请尽快支付。","您预定的房间，已经通过房东审核，请尽快支付。","successbookhouse",$orderid);
                }elseif($status==5){
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_failbookhouse");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_failbookhouse",'r_id'=>$room['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    \Api\Controller\UtilController::addmessage($room['uid'],"申请入住","您预定的房间，没有通过房东的审核，请尽快修改订单。","您预定的房间，没有通过房东的审核，请尽快修改订单。","failbookhouse",$orderid);
                }
                exit(json_encode(array('code'=>200,'msg'=>"审核订单成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"审核订单失败")));
            }
        }
    }
    public function ajax_refundreview(){
        $ret=$_POST;
        $uid=session("uid");
        $orderid=trim($ret['orderid']);
        $money=floatval(trim($ret['money']));
        $status=intval(trim($ret['status']));
        $remark=trim($ret['remark']);


        $user=M('Member')->where(array('id'=>$uid))->find();
        $order=M('refund_apply')->where(array('orderid'=>$orderid))->find();
        if($uid==''||$orderid==''||$status==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"该订单尚未申请退订！")));
        }elseif($order['status']!=1){
            exit(json_encode(array('code'=>-200,'msg'=>"该订单不能重复审核")));
        }elseif($status==2&&empty($money)){
            exit(json_encode(array('code'=>-200,'msg'=>"请填写退款金额")));
        }else{
            $id=M('refund_apply')->where(array('orderid'=>$orderid))->save(array(
                    'money'=>$money,
                    'status'=>$status,
                    'remark'=>$remark,
                    'verify_user'=>$user['nickname'],
                    'verify_time'=>time()
                ));
            if($id){
                if($status==2){
                    M('order_time')->where(array('orderid'=>$orderid))->save(array("status"=>3,"cancel_status"=>1,"cancel_time"=>time(),"refund_status"=>2,"refund_donetime"=>time()));
                    $room= M('book_room a')->join("left join zz_room b on a.rid=b.id")->join("left join zz_hostel c on b.hid=c.id")->where(array('a.orderid'=>$orderid))->field("a.*,c.area,c.address")->find();
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_refundreviewsuccess");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_refundreviewsuccess",'r_id'=>$room['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    \Api\Controller\UtilController::addmessage($room['uid'],"退订申请审核通过","您申请的退订已经审核通过。","您申请的退订已经审核通过。","refundreviewsuccess",$orderid);
                }else if($status==3){
                    M('order_time')->where(array('orderid'=>$orderid))->save(array("refund_status"=>3));
                    $room= M('book_room a')->join("left join zz_room b on a.rid=b.id")->join("left join zz_hostel c on b.hid=c.id")->where(array('a.orderid'=>$orderid))->field("a.*,c.area,c.address")->find();
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_refundreviewfail");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_refundreviewfail",'r_id'=>$room['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    \Api\Controller\UtilController::addmessage($room['uid'],"退订申请审核不通过","您申请的退订审核不通过，请联系管理员。","您申请的退订审核不通过，请联系管理员。","refundreviewfail",$orderid);
                }
                exit(json_encode(array('code'=>200,'msg'=>"退订申请审核成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"退订申请审核失败")));
            }
        }
    }
    public function ajax_cancelorder(){
        $ret=$_POST;
        $uid=session("uid");
        $orderid=trim($ret['orderid']);

        $user=M('Member')->where(array('id'=>$uid))->find();
        $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->find();
        if($uid==''||$orderid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"The Order is not exist!")));
        }elseif($order['pay_status']==1){
           exit(json_encode(array('code'=>-200,'msg'=>"该订单不能关闭")));
        }
        else{
            $select['orderid']=$orderid;
            $id=M('order_time')->where($select)->save(array(
                'status'=>3,
                'cancel_status'=>1,
                'cancel_time'=>time()
                ));
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"取消订单成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"取消订单失败")));
            }
        }
    }
    public function ajax_refundapply(){
        $ret=$_POST;
        $uid=session("uid");
        $orderid=trim($ret['orderid']);
        $content=trim($ret['content']);

        $user=M('Member')->where(array('id'=>$uid))->find();
        $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->find();
        $refund_apply=M('refund_apply')->where(array('orderid'=>$orderid))->find();
        if($uid==''||$orderid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"The Order is not exist!")));
        }elseif($order['pay_status']==0){
            exit(json_encode(array('code'=>-200,'msg'=>"该订单尚未预定成功")));
        }elseif(!empty($refund_apply)){
            exit(json_encode(array('code'=>-200,'msg'=>"该订单已经申请退订")));
        }else{
            $id=M('refund_apply')->add(array(
                    'uid'=>$uid,
                    'orderid'=>$orderid,
                    'content'=>$content,
                    'money'=>0.00,
                    'status'=>1,
                    'inputtime'=>time()
                ));
            if($id){
                M('order_time')->where(array('orderid'=>$orderid))->save(array("refund_status"=>1,"refund_applytime"=>time()));
                if($order['ordertype']==1){
                    $room= M('book_room a')->join("left join zz_room b on a.rid=b.id")->join("left join zz_hostel c on b.hid=c.id")->where(array('a.orderid'=>$orderid))->field("a.*,c.area,c.address,c.uid as houseownerid")->find();
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_refundhostelapply");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_refundhostelapply",'r_id'=>$room['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    \Api\Controller\UtilController::addmessage($room['uid'],"申请退订","您预定的房间，已经成功申请退订，请等待审核。","您预定的房间，已经成功申请退订，请等待审核。","refundhostelapply",$orderid);

                    $content=$Ymsms->getsmstemplate("sms_brefundhostelapply");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_brefundhostelapply",'r_id'=>$room['houseownerid']));
                    $statuscode=$Ymsms->sendsms($data);
                    \Api\Controller\UtilController::addmessage($room['houseownerid'],"申请退订","您有新的退订申请，请尽快审核。","您有新的退订申请，请尽快审核。","brefundhostelapply",$orderid);
                }else if($order['ordertype']==2){
                    $party= M('activity_apply a')->join("left join zz_activity b on a.aid=b.id")->where(array('a.orderid'=>$orderid))->field("a.*,b.area,b.address,b.uid as houseownerid")->find();
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_refundpartyapply");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_refundpartyapply",'r_id'=>$party['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    \Api\Controller\UtilController::addmessage($party['uid'],"取消报名","您报名的活动，已经成功申请取消，请等待审核。","您报名的活动，已经成功申请取消，请等待审核。","refundpartyapply",$orderid);

                    $content=$Ymsms->getsmstemplate("sms_brefundpartyapply");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_brefundpartyapply",'r_id'=>$party['houseownerid']));
                    $statuscode=$Ymsms->sendsms($data);
                    \Api\Controller\UtilController::addmessage($party['houseownerid'],"取消报名","您有新的取消报名申请，请尽快审核。","您有新的取消报名申请，请尽快审核。","brefundpartyapply",$orderid);
                }
                exit(json_encode(array('code'=>200,'msg'=>"退订申请成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"退订申请失败")));
            }
        }
    }
}