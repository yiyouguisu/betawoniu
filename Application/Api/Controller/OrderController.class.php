<?php

namespace Api\Controller;

use Api\Common\CommonController;

class OrderController extends CommonController {

    /*
     *我的订单
     *美宿
     */
    public function orderlist_hostel(){
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid = intval(trim($ret['uid']));
        $type=trim($ret['type']);
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        $user=M('Member')->where(array('id'=>$uid))->find();
        if ($uid == ''||$type == ''||$p==''||$num=='') {
            exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
        } elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        } else {
            $where=array();
            $order=array();
            $field=array();
            switch ($type) {
                case 'all':
                    # code...
                    $where=array('a.uid|e.uid'=>$uid,'c.cancel_status'=>0,'a.ordertype'=>1);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime,c.review_remark');
                    break;
                case 'waitpay':
                    # code...
                    $where=array('a.uid|e.uid'=>$uid,'c.status'=>2,'c.pay_status'=>0,'c.cancel_status'=>0,'a.ordertype'=>1);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
                case 'waitreview':
                    # code...
                    $where=array('a.uid|e.uid'=>$uid,'c.status'=>1,'c.pay_status'=>0,'c.cancel_status'=>0,'a.ordertype'=>1);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
                case 'done':
                    # code...
                    $where=array('a.uid|e.uid'=>$uid,'c.status'=>4,'c.pay_status'=>1,'c.cancel_status'=>0,'a.ordertype'=>1);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
            }
            $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                              ->join("left join zz_book_room d on a.orderid=d.orderid")
                              ->join("left join zz_hostel e on d.hid=e.id")
                              ->where($where)
                              ->order($order)
                              ->field($field)
                              ->page($p,$num)
                              ->select();

            foreach ($data as $key => $value) {
                # code...
                $productinfo=M('book_room a')
                    ->join("left join zz_room c on a.rid=c.id")
                    ->join("left join zz_hostel b on c.hid=b.id")
                    ->where(array('a.orderid'=>$value['orderid']))
                    ->field("a.rid,b.id as hid,b.thumb,b.title,b.money,a.starttime,a.endtime")
                    ->find();
                //$productinfo['sql']=M('order_productinfo a')->_sql();
                $data[$key]['productinfo']=$productinfo;
            }
            //$data['sql']=M('order a')->_sql();
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /*
     *我的订单
     *活动
     */
    public function orderlist_party(){
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid = intval(trim($ret['uid']));
        $type=trim($ret['type']);
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        $user=M('Member')->where(array('id'=>$uid))->find();
        if ($uid == ''||$type == ''||$p==''||$num=='') {
            exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
        } elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        } else {
            $where=array();
            $order=array();
            $field=array();
            switch ($type) {
                case 'all':
                    # code...
                    $where=array('a.uid|e.uid'=>$uid,'c.cancel_status'=>0,'a.ordertype'=>2);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
                case 'waitpay':
                    # code...
                    $where=array('a.uid|e.uid'=>$uid,'c.status'=>2,'c.pay_status'=>0,'c.cancel_status'=>0,'a.ordertype'=>2);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
                case 'done':
                    # code...
                    $where=array('a.uid|e.uid'=>$uid,'c.status'=>4,'c.pay_status'=>1,'c.cancel_status'=>0,'a.ordertype'=>2);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
            }
            $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                              ->join("left join zz_activity_apply d on a.orderid=d.orderid")
                              ->join("left join zz_activity e on d.aid=e.id")
                              ->where($where)
                              ->order($order)
                              ->field($field)
                              ->page($p,$num)
                              ->select();
            foreach ($data as $key => $value) {
                # code...
                $productinfo=M('activity_apply a')
                    ->join("left join zz_activity b on a.aid=b.id")
                    ->where(array('a.orderid'=>$value['orderid']))
                    ->field("a.aid,b.thumb,b.title,b.money,b.isfree,a.memberids,b.starttime,b.endtime")
                    ->find();
                //$productinfo['paystatus']=$value['pay_status'];
                //$productinfo['sql']=M('activity_apply a')->_sql();
                $data[$key]['productinfo']=$productinfo;
            }
            // $data['sql']=M('order a')->_sql();
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /*
     *我的订单
     *美宿
     */
    public function orderlist_houseowner_hostel(){
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid = intval(trim($ret['uid']));
        $type=trim($ret['type']);
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        $user=M('Member')->where(array('id'=>$uid))->find();
        if ($uid == ''||$type == ''||$p==''||$num=='') {
            exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
        } elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        } else {
            $where=array();
            $order=array();
            $field=array();
            switch ($type) {
                case 'all':
                    # code...
                    $where=array('c.cancel_status'=>0,'a.ordertype'=>1);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
                case 'waitpay':
                    # code...
                    $where=array('c.status'=>2,'c.pay_status'=>0,'c.cancel_status'=>0,'a.ordertype'=>1);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
                case 'waitreview':
                    # code...
                    $where=array('c.status'=>1,'c.pay_status'=>0,'c.cancel_status'=>0,'a.ordertype'=>1);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;

                case 'done':
                    # code...
                    $where=array('c.status'=>4,'c.pay_status'=>1,'c.cancel_status'=>0,'a.ordertype'=>1);
                    $order=array('a.inputtime'=>'desc');
                    $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime');
                    break;
            }
            $data=M('order a')
                        ->join("left join zz_order_time c on a.orderid=c.orderid")
                        ->join("left join zz_book_room d on a.orderid=d.orderid")
                        ->join("left join zz_hostel e on d.hid=e.id")
                        ->where(array('e.uid'=>$uid))
                        ->where($where)
                        ->order($order)
                        ->field($field)
                        ->page($p,$num)
                        ->select();

            foreach ($data as $key => $value) {
                # code...
                $productinfo=M('book_room a')
                    ->join("left join zz_room c on a.rid=c.id")
                    ->join("left join zz_hostel b on c.hid=b.id")
                    ->where(array('a.orderid'=>$value['orderid']))
                    ->field("a.rid,b.id as hid,b.thumb,b.title,b.money,a.memberids")
                    ->find();
                //$productinfo['sql']=M('order_productinfo a')->_sql();
                $data[$key]['productinfo']=$productinfo;
            }
            // $data['sql']=M('order a')->_sql();
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /*
     **订单祥情
     */
    public function ordershow(){
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $orderid = trim($ret['orderid']);

        if ($orderid=='') {
            exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
        }else {
            $field=array();
            $type=M('order')->where(array('orderid'=>$orderid))->getField("ordertype");
            switch ($type) {
                case '1':
                    # code...
                    $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,c.*,a.ordertype,d.content as refundcontent,d.remark as refundreview_remark');
                    break;
                case '2':
                    # code...
                    $field=array('a.uid,a.orderid,a.discount,a.couponsid,a.money,a.total,a.inputtime,a.paytype,c.*,a.ordertype,d.content as refundcontent,d.remark as refundreview_remark');
                    break;
            }
            $data=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")->join("left join zz_refund_apply d on a.orderid=d.orderid")->where(array('a.orderid'=>$orderid))->field($field)->find();
            $productinfo=array();
            switch ($type) {
                case '1':
                    # code...
                    $productinfo=M('book_room a')
                        ->join("left join zz_room c on a.rid=c.id")
                        ->join("left join zz_hostel b on c.hid=b.id")
                        ->where(array('a.orderid'=>$data['orderid']))
                        ->field("a.rid,c.title,b.id as hid,b.thumb,b.title as hostel,b.area,b.address,a.money,a.realname,a.phone,a.num,a.roomnum,a.days,a.discount,a.couponsid,a.memberids,a.starttime,a.endtime,a.paystatus")
                        ->find();
                    $book_member=M('book_member')->where(array('orderid'=>$data['orderid']))->order(array('id'=>'desc'))->select();
                    $productinfo['book_member']=!empty($book_member)?$book_member:null;

                    break;
                case '2':
                    # code...
                    $productinfo=M('activity_apply a')
                        ->join("left join zz_activity b on a.aid=b.id")
                        ->where(array('a.orderid'=>$data['orderid']))
                        ->field("a.aid,b.thumb,b.title,a.money,b.isfree,b.area,b.address,a.memberids,b.starttime,b.endtime,a.realname,a.phone,a.idcard,a.num,a.paystatus")
                        ->find();
                    $book_member=M('activity_member')->where(array('orderid'=>$data['orderid']))->order(array('id'=>'desc'))->select();
                    $productinfo['book_member']=!empty($book_member)?$book_member:null;
                    break;
            }
            $data['couponstitle']=M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.id'=>$data['couponsid']))->getField("b.title");
            $data['productinfo']=$productinfo;

            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *活动订单修改
     */
    public function editorder_party(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $orderid=trim($ret['orderid']);
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));
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
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"订单不存在")));
        }elseif(empty($activity)||$activity['isdel']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif($activity['end_numlimit']-$activity['yes_num']<$num){
            exit(json_encode(array('code'=>-200,'msg'=>"活动人数超过限制")));
        }elseif(!empty($apply)&&$apply['paystatus']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"已经报名")));
        }else{
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
                exit(json_encode(array('code'=>200,'msg'=>"提交成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"提交失败")));
            }
        }
    }
    /**
     *预定房间
     */
    public function editorder_hostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $orderid=trim($ret['orderid']);
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
        $order=M('order')->where(array('orderid'=>$orderid))->find();
        $room= M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.title as hostel,b.uid as houseownerid")->find();
        $apply= M('book_room')->where(array('rid'=>$rid,'uid'=>$uid,'_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))->find();

        $booknum=M('book_room')->where(array('_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))->sum('num');
        if($uid==''||$rid==''||$num==''||$roomnum==''||$days==''||$starttime==''||$endtime==''||$realname==''||$idcard==''||$phone==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"订单不存在")));
        }elseif(empty($room)||$room['isdel']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
        }elseif($roomnum>$room['mannum']){
            exit(json_encode(array('code'=>-200,'msg'=>"房间数超过限制")));
        }elseif($room['mannum']-$booknum<$num){
            exit(json_encode(array('code'=>-200,'msg'=>"入住人数超过限制")));
        }elseif(!empty($apply)&&$apply['paystatus']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"已经预定")));
        }else{
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
                $data['orderid']=$orderid;
                exit(json_encode(array('code'=>200,'msg'=>"提交成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"提交失败")));
            }
        }
    }
    /*
     **审核订单
     */
    public function revieworder(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
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
        }else{
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
                    UtilController::addmessage($room['uid'],"申请入住","您预定的房间，已经通过房东审核，请尽快支付。","您预定的房间，已经通过房东审核，请尽快支付。","successbookhouse",$orderid);
                }elseif($status==5){
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_failbookhouse");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_failbookhouse",'r_id'=>$room['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    UtilController::addmessage($room['uid'],"申请入住","您预定的房间，没有通过房东的审核，请尽快修改订单。","您预定的房间，没有通过房东的审核，请尽快修改订单。","failbookhouse",$orderid);
                }
                exit(json_encode(array('code'=>200,'msg'=>"审核订单成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"审核订单失败")));
            }
        }
    }
    /*
     **取消订单
     */
    public function closeorder(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
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
    public function refundapply(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
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
            $refundorderid=date("YmdHis", time()) . rand(100, 999);
            $id=M('refund_apply')->add(array(
                    'uid'=>$uid,
                    'orderid'=>$orderid,
                    'refundorderid'=>$refundorderid,
                    'transaction_id'=>$order['trade_no'],
                    'content'=>$content,
                    'total'=>$order['money'],
                    'channel'=>$order['channel'],
                    'money'=>0.00,
                    'status'=>1,
                    'refund_status'=>0,
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
                    UtilController::addmessage($room['uid'],"申请退订","您预定的房间，已经成功申请退订，请等待审核。","您预定的房间，已经成功申请退订，请等待审核。","refundhostelapply",$orderid);

                    $content=$Ymsms->getsmstemplate("sms_brefundhostelapply");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_brefundhostelapply",'r_id'=>$room['houseownerid']));
                    $statuscode=$Ymsms->sendsms($data);
                    UtilController::addmessage($room['houseownerid'],"申请退订","您有新的退订申请，请尽快审核。","您有新的退订申请，请尽快审核。","brefundhostelapply",$orderid);
                }else if($order['ordertype']==2){
                    $party= M('activity_apply a')->join("left join zz_activity b on a.aid=b.id")->where(array('a.orderid'=>$orderid))->field("a.*,b.area,b.address,b.uid as houseownerid")->find();
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_refundpartyapply");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_refundpartyapply",'r_id'=>$party['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    UtilController::addmessage($party['uid'],"取消报名","您报名的活动，已经成功申请取消，请等待审核。","您报名的活动，已经成功申请取消，请等待审核。","refundpartyapply",$orderid);

                    $content=$Ymsms->getsmstemplate("sms_brefundpartyapply");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_brefundpartyapply",'r_id'=>$party['houseownerid']));
                    $statuscode=$Ymsms->sendsms($data);
                    UtilController::addmessage($party['houseownerid'],"取消报名","您有新的取消报名申请，请尽快审核。","您有新的取消报名申请，请尽快审核。","brefundpartyapply",$orderid);
                }
                exit(json_encode(array('code'=>200,'msg'=>"退订申请成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"退订申请失败")));
            }
        }
    }
    public function refundreview(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
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
                    UtilController::addmessage($room['uid'],"退订申请审核通过","您申请的退订已经审核通过。","您申请的退订已经审核通过。","refundreviewsuccess",$orderid);
                }else if($status==3){
                    M('order_time')->where(array('orderid'=>$orderid))->save(array("refund_status"=>3));
                    $room= M('book_room a')->join("left join zz_room b on a.rid=b.id")->join("left join zz_hostel c on b.hid=c.id")->where(array('a.orderid'=>$orderid))->field("a.*,c.area,c.address")->find();
                    $Ymsms = A("Api/Ymsms");
                    $content=$Ymsms->getsmstemplate("sms_refundreviewfail");
                    $data=json_encode(array('content'=>$content,'type'=>"sms_refundreviewfail",'r_id'=>$room['uid']));
                    $statuscode=$Ymsms->sendsms($data);
                    UtilController::addmessage($room['uid'],"退订申请审核不通过","您申请的退订审核不通过，请联系管理员。","您申请的退订审核不通过，请联系管理员。","refundreviewfail",$orderid);
                }
                exit(json_encode(array('code'=>200,'msg'=>"退订申请审核成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"退订申请审核失败")));
            }
        }
    }
    /*
     **评价订单
     */
    public function evaluate(){
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid = intval(trim($ret['uid']));
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
                UtilController::addmessage($Hostel['uid'],"美宿评论","您的美宿(".$Hostel['title'].")被其他用户评论了","您的美宿(".$Hostel['title'].")被其他用户评论了","hostelreview",$Hostel['id']);
                $data['value']=$room['id'];
                $data['uid']=$uid;
                $data['content']=$content;
                $data['varname']='room';
                $data['inputtime']=time();
                $data['evaluation']=$evaluationset['evaluation'];
                $data['evaluationpercent']=$evaluationset['evaluationpercent'];
                M("review")->add($data);
                UtilController::addmessage($Hostel['uid'],"房间评论","您的房间(".$room['title'].")被其他用户评论了","您的房间(".$room['title'].")被其他用户评论了","roomreview",$room['id']);
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
    /*
     **订单反馈
     */
    public function feedback(){
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid = intval(trim($ret['uid']));
        $orderid = trim($ret['orderid']);
        $thumb = trim($ret['thumb']);
        $content = trim($ret['content']);

        $user=M('Member')->where(array('id'=>$uid))->find();
        $order=M('order')->where(array('orderid'=>$orderid))->find();
        $orderfeedback=M('order_feedback')->where(array('uid'=>$uid,'orderid'=>$orderid))->find();
        if ($uid == ''||$orderid==''||$content==''||$thumb=='') {
            exit(json_encode(array('code' =>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }elseif(empty($order)){
            exit(json_encode(array('code'=>-200,'msg'=>"The Order is not exist!")));
        }elseif(!empty($orderfeedback)){
            exit(json_encode(array('code'=>-200,'msg'=>"您已经提交售后反馈，不能重复提交。")));
        }else {
            $id=M('order_feedback')->add(array(
                'uid'=>$uid,
                'orderid'=>$orderid,
                'content'=>$content,
                'thumb'=>$thumb,
                'status'=>1,
                'inputtime'=>time()
                ));
            if($id){
                $phone=M('order a')->join("left join zz_store b on a.storeid=b.id")->where(array('a.orderid'=>$orderid))->getField("b.contact");
                $data=json_encode(array('phone'=>$phone,'datas'=>array($orderid),'templateid'=>"74017"));
                $CCPRest = A("Api/CCPRest");
                $CCPRest->sendsmsapi($data);
                $c="您好！您在".date("Y年m月d日 H时i分s秒") ."成功提交了订单反馈。";
                M("message")->add(array(
                    'uid'=>0,
                    'tuid'=>$uid,
                    'title'=>"订单反馈",
                    'description'=>$c,
                    'content'=>$c,
                    'value'=>$order['orderid'],
                    'varname'=>"system",
                    'inputtime'=>time()
                ));
                exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
            }
        }
    }
    /*
     **订单再次支付
     */
    public function orderpayagain(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $orderid=trim($ret['orderid']);
        $paytype=intval(trim($ret['paytype']));
        $couponsid=intval(trim($ret['couponsid']));
        $money=floatval(trim($ret['money']));
        $channel=trim($ret['channel']);
        $discount=floatval(trim($ret['discount']));

        $user=M('Member')->where(array('id'=>$uid))->find();
        $order=M('order')->where(array('orderid'=>$orderid))->find();
        if($uid==''||$orderid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(!$user){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!$order){
            exit(json_encode(array('code'=>-200,'msg'=>"订单不存在")));
        }else{
            $paycharge=null;
            if(!empty($discount)&&$discount!=0.00&&$order['couponsid']!=0){
                M('vouchers_order')->where(array('id'=>$order['couponsid']))->setField('status',1);
            }
            switch ($order['ordertype']) {
                case '1':
                    # code...
                    $apply= M('book_room')->where(array('orderid'=>$order['orderid']))->find();
                    $room= M('room')->where(array('id'=>$apply['rid']))->find();
                    if(empty($room)||$room['isdel']==1){
                        exit(json_encode(array('code'=>-200,'msg'=>"房间不存在")));
                    }elseif($apply['roomnum']>$room['mannum']){
                        exit(json_encode(array('code'=>-200,'msg'=>"房间数超过限制")));
                    }elseif(!empty($apply)&&$apply['paystatus']==1){
                        exit(json_encode(array('code'=>-200,'msg'=>"已经预定")));
                    }else{
                        $id=M('order')->where(array('orderid'=>$orderid))->save(array(
                            'paytype'=>$paytype,
                            'channel'=>$channel,
                            'money'=>$money,
                            'discount'=>$discount,
                            'couponsid'=>$couponsid
                            ));
                        if($id){
                            M("book_room")->where(array('orderid'=>$order['orderid']))->save(array(
                                'paytype'=>$paytype,
                                'channel'=>$channel,
                                'money'=>$money,
                                'discount'=>$discount,
                                'couponsid'=>$couponsid
                                ));
                            $title="预定房间";
                            $body="预定".$room['title']."支付".$money;
                            $Pay=A("Api/Pay");
                            $paycharge=$Pay->pay($orderid,$title,$body,$money,$channel);
                        }
                        
                    }
                    break;
                case '2':
                    # code...
                    $apply= M('activity_apply')->where(array('orderid'=>$order['orderid']))->find();
                    $activity= M('activity')->where(array('id'=>$apply['aid']))->find();
                    if(empty($activity)||$activity['isdel']==1){
                        exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
                    }elseif($activity['end_numlimit']-$activity['yes_num']<$apply['num']){
                        exit(json_encode(array('code'=>-200,'msg'=>"活动人数超过限制")));
                    }elseif(!empty($apply)&&$apply['paystatus']==1){
                        exit(json_encode(array('code'=>-200,'msg'=>"已经报名")));
                    }else{
                        $id=M('order')->where(array('orderid'=>$orderid))->save(array(
                            'paytype'=>$paytype,
                            'channel'=>$channel,
                            'money'=>$money,
                            'discount'=>$discount,
                            'couponsid'=>$couponsid
                            ));
                        if($id){
                            M("activity_apply")->where(array('orderid'=>$order['orderid']))->save(array(
                                'paytype'=>$paytype,
                                'channel'=>$channel,
                                'money'=>$money,
                                'discount'=>$discount,
                                'couponsid'=>$couponsid
                                ));
                            $title="参加活动";
                            $body="参加".$activity['title'].",支付".$money;
                            $Pay=A("Api/Pay");
                            $paycharge=$Pay->pay($orderid,$title,$body,$money,$channel);
                        }
                        
                    }
                    break;
            }
            exit($paycharge);
        }
    }
    public function get_ordernum(){
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid = intval(trim($ret['uid']));

        $user=M('Member')->where(array('id'=>$uid))->find();
        if ($uid == '') {
            exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
        } elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        } else {
            if($user['houseowner_status']==1) {
                $ordernum=M('order a')
                          ->join("left join zz_order_time c on a.orderid=c.orderid")
                          ->join("left join zz_book_room d on a.orderid=d.orderid")
                          ->join("left join zz_hostel e on d.hid=e.id")
                          ->where(array('e.uid'=>$uid,'c.status'=>1,'c.pay_status'=>0,'c.cancel_status'=>0,'a.ordertype'=>1))
                          ->count();
            }else{
                $ordernum=M('Order a')
                          ->join("left join zz_order_time b on a.orderid=b.orderid")
                          ->where(array('a.uid'=>$uid,'b.status'=>2,'b.pay_status'=>0,'c.cancel_status'=>0))
                          ->count();
            }
            $ordernum=!empty($ordernum)?$ordernum:0;
            exit(json_encode(array('code'=>200,'msg'=>"success",'data'=>array('ordernum'=>$ordernum))));
        }
    }
}
