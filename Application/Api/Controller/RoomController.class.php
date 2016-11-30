<?php
namespace Api\Controller;

use Api\Common\CommonController;

class RoomController extends CommonController {
    /**
     *房间床型
     */
    public function get_bedtype(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("bedcate")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *房间配套设施
     */
    public function get_roomtype(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("roomcate")->field('id,gray_thumb,blue_thumb,red_thumb,black_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *房间列表
     */
    public function get_room(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $hid=intval(trim($ret['hid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($hid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('id'=>'desc');
            $where['hid']=$hid;
            $where['isdel']=0;
            $count=M("room")->where($where)->count();
            $list=M("room")
                ->where($where)
                ->order($order)
                ->field('id as rid,title,thumb,area,money,roomtype')
                ->page($p,$num)->select();
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *查看房间
     */
    public function show(){
        //$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=file_get_contents("php://input");
        $ret=json_decode($ret,true);
        $id=intval(trim($ret['id']));
        $uid=intval(trim($ret['uid']));

        if($id==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("Room a")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->join("left join zz_hostel b on a.hid=b.id")
            ->where(array('a.id'=>$id))
            ->field('a.id as rid,a.hid,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.imglist,a.content,a.inputtime,a.score as evaluation,a.scorepercent as evaluationpercent,c.reviewnum,b.title as hostel,b.area as hostelarea,b.address as hosteladdress,b.lat,b.lng')
            ->find();
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            //$data['hostel']=M('hostel')->where(array('id'=>$data['hid']))->getField("title");
            $evaluation=getroom_evaluation($data['rid']);
            // $data['evaluation']=!empty($evaluation['evaluation'])?$evaluation['evaluation']:0.0;
            // $data['evaluationpercent']=!empty($evaluation['percent'])?$evaluation['percent']:0.00;
            $data['evaluationset']=$evaluation;

            $data['imglist']=explode("|", $data['imglist']);
            
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"room",'value'=>$data['rid']))->find();
            if(!empty($collectstatus)){
                $data['iscollect']=1;
            }else{
                $data['iscollect']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"room",'value'=>$data['rid']))->find();
            if(!empty($hitstatus)){
                $data['ishit']=1;
            }else{
                $data['ishit']=0;
            }
            


            $bookdate=getmonth();
            foreach ($bookdate as $key => $value) {
                # code...
                $bookdate[$key]['price']=$data['nomal_money'];
                $week=date("w",$value['value']);
                $date = date("d", $value['value']);
                $bookdate[$key]['date'] = $date;
                $mon = date("m", $value['value']);
                $bookdate[$key]['month'] = $mon;
                if(in_array($week, array(0,6))) {
                    $bookdate[$key]['isweek']=1;
                    $bookdate[$key]['price']=$data['week_money'];
                }else{
                    $bookdate[$key]['isweek']=0;
                }
                $holiday=M('holiday')->where(array('status'=>1,'_string'=>$value['value']." <= enddate and ".$value['value']." >= startdate"))->field("id,name,days")->find();
                if(!empty($holiday)){
                    $bookdate[$key]['isholiday']=1;
                    $bookdate[$key]['holiday']=$holiday;
                    $bookdate[$key]['price']=$data['holiday_money'];
                }else{
                    $bookdate[$key]['isholiday']=0;
                }

                $booknum=M('book_room')->where(array('_string'=>$value['value']." <= endtime and ".$value['value']." >= starttime"))->sum('num');
                if($booknum>=$data['mannum']){
                    $bookdate[$key]['isgone']=1;
                }elseif($booknum<$data['mannum']){
                    $bookdate[$key]['isgone']=0;
                    $bookdate[$key]['wait_num']=$data['mannum']-$booknum;
                }
                $book_status=M('book_room a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('_string'=>$value['value']." <= a.endtime and ".$value['value']." >= a.starttime",'a.uid'=>$uid,'a.rid'=>$id,'b.status'=>4))->find();
                if(!empty($book_status)){
                    $bookdate[$key]['isbook']=1;
                }else{
                    $bookdate[$key]['isbook']=0;
                }
            }
            $data['bookdate']=!empty($bookdate)?$bookdate:null;
            $info = M('hostel')->find($id);
            $data['couponsinfo'] = "满" . $info['vouchersrange'] . "送" . $info['vouchersdiscount'] . "优惠券";
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"获取房间详情失败")));
            }
        }
    }
    /**
     *评论
     */
    public function review(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $rid=intval(trim($ret['rid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $Room=M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.uid")->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($rid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Room)){
            exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['value']=$rid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='room';
            $data['inputtime']=time();
            $id=M("review")->add($data);
            if($id){
                UtilController::addmessage($Room['uid'],"房间评论","您的房间(".$Room['title'].")被其他用户评论了","您的房间(".$Room['title'].")被其他用户评论了","roomreview",$Room['id']);
                exit(json_encode(array('code'=>200,'msg'=>"评论成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"评论失败")));
            }
        }
    }
    /**
     *评论列表
     */
    public function get_review(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $rid=intval(trim($ret['rid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($rid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$rid;
            $where['a.isdel']=0;
            $where['a.varname']='room';
            $count=M("review a")->where($where)->count();
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order($order)
                ->field('a.id as rid,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->page($p,$num)->select();
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *收藏
     */
    public function collect(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $rid=intval(trim($ret['rid']));
        $uid=intval(trim($ret['uid']));

        $Room=M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.uid")->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'Room','value'=>$rid))->find();
        if($rid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Room)){
            exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($collectstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户已经收藏")));
        }else{
            $id=M("collect")->add(array(
            	'uid'=>$uid,
            	'value'=>$rid,
            	'varname'=>"room",
            	'inputtime'=>time()
            ));
            if($id){
                UtilController::addmessage($Room['uid'],"房间收藏","您的房间(".$Room['title'].")被其他用户收藏了","您的房间(".$Room['title'].")被其他用户收藏了","roomcollect",$Room['id']);
                exit(json_encode(array('code'=>200,'msg'=>"收藏成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"收藏失败")));
            }
        }
    }
    /**
     *取消收藏
     */
    public function uncollect(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $rid=intval(trim($ret['rid']));
        $uid=intval(trim($ret['uid']));

        $Room=M('Room')->where(array('id'=>$rid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'room','value'=>$rid))->find();
        if($rid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Room)){
            exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($collectstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户尚未收藏")));
        }else{
            $id=M("collect")->delete($collectstatus['id']);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"取消收藏成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"取消收藏失败")));
            }
        }
    }
    /**
     *点赞
     */
    public function hit(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $rid=intval(trim($ret['rid']));
        $uid=intval(trim($ret['uid']));

        $Room=M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.uid")->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>'room','value'=>$rid))->find();
        if($rid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Room)){
            exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($hitstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户已经点赞")));
        }else{
            M('Room')->where('id=' .$rid)->setInc("hit");
            $id=M("hit")->add(array(
                'uid'=>$uid,
                'value'=>$rid,
                'varname'=>"room",
                'inputtime'=>time()
            ));
            if($id){
                UtilController::addmessage($Room['uid'],"房间点赞","您的房间(".$Room['title'].")获得1个赞","您的房间(".$Room['title'].")获得1个赞","roomhit",$Room['id']);
                exit(json_encode(array('code'=>200,'msg'=>"点赞成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"点赞失败")));
            }
        }
    }
    /**
     *取消点赞
     */
    public function unhit(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $rid=intval(trim($ret['rid']));
        $uid=intval(trim($ret['uid']));

        $Room=M('Room')->where(array('id'=>$rid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>'room','value'=>$rid))->find();
        if($rid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Room)){
            exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($hitstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户尚未点赞")));
        }else{
            M('Room')->where('id=' .$rid)->setDec("hit");
            $id=M("hit")->delete($hitstatus['id']);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"取消点赞成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"取消点赞失败")));
            }
        }
    }
    /**
     *预定房间
     */
    public function book(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $rid=intval(trim($ret['rid']));
        $uid=intval(trim($ret['uid']));
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
        $room= M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.title as hostel,b.uid as houseownerid")->find();
        $apply= M('book_room')->where(array('rid'=>$rid,'uid'=>$uid,'_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))->find();

        $booknum=M('book_room')->where(array('_string'=>$endtime." <= endtime and ".$starttime." >= starttime",'rid'=>$rid))->sum('roomnum');
        if($uid==''||$rid==''||$num==''||$roomnum==''||$days==''||$starttime==''||$endtime==''||$realname==''||$idcard==''||$phone==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($room)||$room['isdel']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
        }elseif($room['houseownerid']==$uid){
            exit(json_encode(array('code'=>-200,'msg'=>"不能预定自己的房间")));
        }elseif($roomnum>$room['mannum']){
            exit(json_encode(array('code'=>-200,'msg'=>"房间数超过限制")));
        }elseif($room['mannum']-intval($booknum)<$num){
            exit(json_encode(array('code'=>-200,'msg'=>"入住人数超过限制")));
        }elseif(!empty($apply)&&$apply['paystatus']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"已经预定")));
        }else{
            if(!empty($couponsid)){
                $coupons=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$couponsid))->find();
                if($coupons){
                    if($coupons['status']==1){
                        exit(json_encode(array('code'=>-200,'msg'=>"优惠券已经被使用")));
                    }else if($coupons['validity_endtime']<time()){
                        exit(json_encode(array('code'=>-200,'msg'=>"优惠券已经被使用")));
                    }
                }else{
                    exit(json_encode(array('code'=>-200,'msg'=>"尚未购买此种优惠券")));
                }
            }
            $orderid="hc".date("YmdHis", time()) . rand(100, 999);
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
                            'linkmanid'=>$value['id'],
                            'rid'=>$rid,
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
                $data['orderid']=$orderid;
                UtilController::addmessage($room['houseownerid'],"申请入住","您有新的房间预定订单需要审核，请尽快处理。","您有新的房间预定订单需要审核，请尽快处理。","applybookhouse",$orderid);
                $Ymsms = A("Api/Ymsms");
                $content=$Ymsms->getsmstemplate("sms_applybookhouse");
                $data=json_encode(array('content'=>$content,'type'=>"sms_applybookhouse",'r_id'=>$room['houseownerid']));
                $statuscode=$Ymsms->sendsms($data);
                exit(json_encode(array('code'=>200,'msg'=>"提交成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"提交失败")));
            }
        }
    }
    /**
     *预定支付
     */
    public function book_pay(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $rid=intval(trim($ret['rid']));
        $uid=intval(trim($ret['uid']));
        $paytype=intval(trim($ret['paytype']));
        $channel=trim($ret['channel']);
        $couponsid=intval(trim($ret['couponsid']));
        $discount=intval(trim($ret['discount']));
        $money=floatval(trim($ret['money']));

        $orderid=trim($ret['orderid']);
        $order=M('order a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->find();
        $room= M('room')->where(array('id'=>$rid))->find();
        $apply= M('book_room')->where(array('rid'=>$rid,'uid'=>$uid))->find();
        $booknum=M('book_room')->where(array('_string'=>$apply['endtime']." <= endtime and ".$apply['starttime']." >= starttime"))->sum('num');
        if($orderid==''||$rid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(!$order){
            exit(json_encode(array('code'=>-200,'msg'=>"订单不存在")));
        }elseif($order['status']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"订单待审核中")));
        }elseif($order['status']==5){
            exit(json_encode(array('code'=>-200,'msg'=>"订单待审核失败")));
        }elseif(empty($room)||$room['isdel']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
        }elseif($apply['roomnum']>=$room['mannum']){
            exit(json_encode(array('code'=>-200,'msg'=>"房间数超过限制")));
        }elseif($room['mannum']-$booknum<$apply['num']){
            exit(json_encode(array('code'=>-200,'msg'=>"入住人数超过限制")));
        }elseif(!empty($apply)&&$apply['paystatus']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"已经预定")));
        }else{
            if(!empty($couponsid)){
                $coupons=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$couponsid))->field("a.*,b.validity_endtime")->find();
                if($coupons){
                    if($coupons['status']==1){
                        exit(json_encode(array('code'=>-200,'msg'=>"优惠券已经被使用")));
                    }else if($coupons['validity_endtime']<time()){
                        exit(json_encode(array('code'=>-200,'msg'=>"优惠券已经被使用")));
                    }
                }else{
                    exit(json_encode(array('code'=>-200,'msg'=>"尚未购买此种优惠券")));
                }
            }
            M('order')->where(array('orderid'=>$orderid))->save(array(
                'paytype'=>$paytype,
                'channel'=>$channel,
                'money'=>$money,
                'couponsid'=>$couponsid,
                'discount'=>$discount
                ));
           // M('vouchers_order')->where(array('id'=>$couponsid))->setField('status',1);
            $title="预定房间";
            $body="预定".$room['title'];
            $Pay=A("Api/Pay");
            $paycharge=$Pay->pay($orderid,$title,$body,$money,$channel);
            exit($paycharge);
        }
    }
    public function get_linkman(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        if($p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $data=M("linkman")
            ->where(array('uid'=>$uid))
                ->order(array('id'=>"desc"))
                ->field('id,realname,idcard,phone,inputtime')
                ->page($p,$num)
                ->select();
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    public function add_linkman(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $realname=trim($ret['realname']);
        $idcard=trim($ret['idcard']);
        $phone=trim($ret['phone']);
        $user=M('Member')->where(array('id'=>$uid))->find();
        $linkman= M('linkman')->where(array('realname'=>$realname,'idcard'=>$idcard,'phone'=>$phone))->find();
        $linkman_idcard=M('linkman')->where(array('idcard'=>$idcard))->find();
        $linkman_phone=M('linkman')->where(array('phone'=>$phone))->find();
        if($uid==''||$realname==''||$idcard==''||$phone==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($linkman)){
            exit(json_encode(array('code'=>-200,'msg'=>"联系人已经存在")));
        }elseif(!empty($linkman_idcard)){
            exit(json_encode(array('code'=>-200,'msg'=>"身份证号已经存在")));
        }elseif(!empty($linkman_phone)){
            exit(json_encode(array('code'=>-200,'msg'=>"手机号码已经存在")));
        }else{
            $data['uid']=$uid;
            $data['realname']=$realname;
            $data['idcard']=$idcard;
            $data['phone']=$phone;
            $data['inputtime']=time();
            $id=M('linkman')->add($data);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"提交成功",'linkmanid'=>$id)));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
            }
        }
    }
    public function edit_linkman(){
        //$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=file_get_contents('php://input');
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $lmid=intval(trim($ret['lmid']));
        $realname=trim($ret['realname']);
        $idcard=trim($ret['idcard']);
        $phone=trim($ret['phone']);
        $user=M('Member')->where(array('id'=>$uid))->find();
        $linkman= M('linkman')->where(array('id'=>$lmid))->find();
        //$linkman_idcard=M('linkman')->where(array('idcard'=>$idcard))->find();
        //$linkman_phone=M('linkman')->where(array('phone'=>$phone))->find();
        if($uid==''||$lmid==''||$realname==''||$idcard==''||$phone==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($linkman)){
            exit(json_encode(array('code'=>-200,'msg'=>"联系人不存在")));
        //}elseif(!empty($linkman_idcard)){
           // exit(json_encode(array('code'=>-200,'msg'=>"身份证号已经存在")));
        //}elseif(!empty($linkman_phone)){
            //exit(json_encode(array('code'=>-200,'msg'=>"手机号码已经存在")));
        }else{
            $data['uid']=$uid;
            $data['realname']=$realname;
            $data['idcard']=$idcard;
            $data['phone']=$phone;
            $data['updatetime']=time();
            $id=M('linkman')->where(array('id'=>$lmid))->save($data);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
            }
        }
    }
    
    public function del_linkman(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $lmid=intval(trim($ret['lmid']));
        
        $user=M('Member')->where(array('id'=>$uid))->find();
        $linkman= M('linkman')->where(array('id'=>$lmid))->find();
        if($uid==''||$lmid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($linkman)){
            exit(json_encode(array('code'=>-200,'msg'=>"联系人不存在")));
        }else{
            $id=M('linkman')->where(array('id'=>$lmid))->delete();
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
            }
        }
    }
    public function bookask(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $tuid=intval(trim($ret['tuid']));
        
        $fuser=M('Member')->where(array('id'=>$uid))->find();
        $tuser= M('Member')->where(array('id'=>$tuid))->find();
        if($uid==''||$tuid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($fuser)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($tuser)){
            exit(json_encode(array('code'=>-200,'msg'=>"房东不存在")));
        }else{
            $id=M('bookask')->add(array(
                'uid'=>$uid,
                'tuid'=>$tuid,
                'status'=>0,
                'inputtime'=>time(),
                'updatetime'=>time()
                ));
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
            }
        }
    }
    public function update_bookask_status(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $tuid=intval(trim($ret['tuid']));
        
        $fuser=M('Member')->where(array('id'=>$uid))->find();
        $tuser= M('Member')->where(array('id'=>$tuid))->find();
        if($uid==''||$tuid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($fuser)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($tuser)){
            exit(json_encode(array('code'=>-200,'msg'=>"咨询者不存在")));
        }else{
            $id=M('bookask')->where(array('tuid'=>$uid,'uid'=>$tuid))->save(array(
                'status'=>1,
                'updatetime'=>time()
                ));
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
            }
        }
    }
}
