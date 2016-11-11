<?php
namespace Api\Controller;

use Api\Common\CommonController;

class ActivityController extends CommonController {
    /**
     *活动特色
     */
    public function get_partytype(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("partycate")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *活动列表
     */
    public function get_activity(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $hid=intval(trim($ret['hid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        $area=trim($ret['area']);
        $money=trim($ret['money']);
        $catid=trim($ret['catid']);
        $partytype=intval(trim($ret['partytype']));
        $partytime=intval(trim($ret['partytime']));


        if($p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            if(!empty($area)){
                $where['a.area']=$area;
            }
            if(!empty($catid)){
                $where['a.catid']=$catid;
            }
            if(!empty($partytype)){
                $where['a.partytype']=$partytype;
            }
            if(!empty($partytime)){
                $where['a.starttime']=array('elt',$partytime);
                $where['a.endtime']=array('egt',$partytime);
            }
            if(!empty($money)){
                $moneybox=explode("|",$money);
                if(!empty($moneybox[0])&&!empty($moneybox[1])){
                    if(($moneybox[0]==$moneybox[1])&&($moneybox[0]==-1)){
                        $where['a.isfree']=1;
                    }else{
                        if($moneybox[0]==0){
                            $where['a.money'] = array('ELT', $moneybox[1]);
                        }elseif($moneybox[1]==0){
                            $where['a.money'] = array('EGT', $moneybox[0]);
                        }else{
                            $where['a.money'] = array(array('EGT', $moneybox[0]), array('ELT', $moneybox[1]));
                        }
                    }
                    
                }else{
                    $where['a.money'] =$money;
                }
            }
            if(!empty($hid)){
                $hosteluid=M("Hostel")->where(array('id'=>$hid))->getField("uid");
                $where['a.uid']=$hosteluid;
            }
            $where['a.status']=2;
            $where['a.isdel']=0;
            $where['a.isoff']=0;
            $data=M("activity a")->join("left join zz_member b on a.uid=b.id")->where($where)->order(array('id'=>"desc"))->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')->page($p,$num)->select();
            foreach ($data as $key => $value) {
                # code...
                $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
                $data[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->limit(5)->select();
                $data[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
                $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
                if(!empty($joinstatus)){
                    $data[$key]['isjoin']=1;
                }else{
                    $data[$key]['isjoin']=0;
                }
                $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
                if(!empty($collectstatus)){
                    $data[$key]['iscollect']=1;
                }else{
                    $data[$key]['iscollect']=0;
                }
                $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
                if(!empty($hitstatus)){
                    $data[$key]['ishit']=1;
                }else{
                    $data[$key]['ishit']=0;
                }
            }
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *首页推荐活动列表
     */
    public function get_pushactivity(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $city=intval(trim($ret['city']));
        $where=array();
        if(!empty($city)){
            $where['a.city']=$city;
        }
        $where['a.status']=2;
        $where['a.index']=1;
        $where['a.isdel']=0;
        $where['a.isoff']=0;
        $data=M("activity a")->join("left join zz_member b on a.uid=b.id")->where($where)->order(array('id'=>"desc"))->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')->limit(3)->select();
        foreach ($data as $key => $value) {
            # code...
            $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
            $data[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
            $data[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
            $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
            if(!empty($joinstatus)){
                $data[$key]['isjoin']=1;
            }else{
                $data[$key]['isjoin']=0;
            }
        }
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
        }else{
            exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
        }
    }
    /**
     *我的活动列表
     */
    public function get_myactivity(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        $type=intval(trim($ret['type']));

        if($uid==''||$p==''||$num==''||$type==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            switch ($type) {
                case "2":
                    $where['a.starttime']=array('elt',time());
                    $where['a.endtime']=array('egt',time());
                    break;
                case "3":
                    $where['a.endtime']=array('lt',time());
                    break;

            }
            $where['a.uid']=$uid;
            $where['a.status']=2;
            $where['a.isdel']=0;
            $where['a.isoff']=0;
            $count=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->count();
            $list=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.address,a.status,a.uid,a.starttime,a.endtime,a.inputtime')->page($p,$num)->select();
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *我的活动列表
     */
    public function get_releaseactivity(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        $type=intval(trim($ret['type']));

        if($uid==''||$p==''||$num==''||$type==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            switch ($type) {
                case "2":
                    $where['a.starttime']=array('elt',time());
                    $where['a.endtime']=array('egt',time());
                    break;
                case "3":
                    $where['a.endtime']=array('lt',time());
                    break;

            }
            $where['a.uid']=$uid;
            $where['a.isdel']=0;
            $where['a.isoff']=0;
            $count=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->count();
            $list=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.address,a.status,a.uid,a.starttime,a.endtime,a.inputtime')->page($p,$num)->select();
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *删活动
     */
    public function delete(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $aid=trim($ret['aid']);
        $uid=intval(trim($ret['uid']));

        $where=array();
        $aidbox=explode(",",$aid);
        if(is_array($aidbox)){
            $where['id']=array('in',$aidbox);
        }else{
            $where['id']=array('eq',$aid);
        }
        $activity=M("activity")->where($where)->count();
        $where=array();
        $where['id']=$uid;
        $user=M('Member')->where($where)->find();
        if($aid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($activity)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $where=array();
            $aidbox=explode(",",$aid);
            if(is_array($aidbox)){
                $where['id']=array('in',$aidbox);
            }else{
                $where['id']=array('eq',$aid);
            }
            $id=M("activity")->where($where)->save(array('isdel'=>1,'deletetime'=>time()));
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"删除成功")));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"删除失败")));
            }
        }
    }
    /**
     *查看活动
     */
    public function show(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $id=intval(trim($ret['id']));
        $uid=intval(trim($ret['uid']));
        $lat=floatval(trim($ret['lat']));
        $lng=floatval(trim($ret['lng']));

        if($id==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            M('activity')->where(array('id'=>$id))->setInc("view");
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'party'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where(array('a.id'=>$id))
            ->field('a.id,a.title,a.description,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.starttime,a.endtime,a.content,a.start_numlimit,a.end_numlimit,a.yes_num,a.cancelrule,a.vouchersrange,a.vouchersdiscount,a.status,a.remark,a.uid,b.nickname,b.head,b.realname_status,b.rongyun_token,a.inputtime,c.reviewnum')
            ->find();
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            $reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'party'))->field("a.id as vid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->order(array('a.id'=>'desc'))->limit(4)->select();
            $data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
            $joinnum=M('activity_apply')->where(array('aid'=>$data['id'],'paystatus'=>1))->sum("num");
            $data['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$data['id'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->select();
            $data['joinlist']=!empty($joinlist)?$joinlist:null;
            $joinstatus= M('activity_apply a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.aid'=>$data['id'],'a.uid'=>$uid,'b.status'=>array('in','2,4')))->find();
            if(!empty($joinstatus)){
                $data['isjoin']=1;
            }else{
                $data['isjoin']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$data['id']))->find();
            if(!empty($collectstatus)){
                $data['iscollect']=1;
            }else{
                $data['iscollect']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$data['id']))->find();
            if(!empty($hitstatus)){
                $data['ishit']=1;
            }else{
                $data['ishit']=0;
            }
            $Map=A("Api/Map");
            $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$data['lat'].",".$data['lng']);
            $data['distance']=!empty($distance)?$distance:0.00;

            $note_party=M('tags_content a')->join("left join zz_activity b on a.contentid=b.id")->where(array('a.varname'=>'party','a.contentid'=>$data['id'],'a.type'=>'party'))->field("a.title,a.hid,a.place,b.city,'party' as type")->find();
            $data['note_party']=!empty($note_party)?$note_party:null;

            $where=array();
            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;
            $where['a.isoff']=0;

            $recoords=getcoords($data['lat'],$data['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $party_near_activity=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                ->limit(5)
                ->select();
            foreach ($party_near_activity as $key => $value) {
                # code...
                $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
                $party_near_activity[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
                $party_near_activity[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
                $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
                if(!empty($joinstatus)){
                    $party_near_activity[$key]['isjoin']=1;
                }else{
                    $party_near_activity[$key]['isjoin']=0;
                }
            }
            $data['party_near_activity']=!empty($party_near_activity)?$party_near_activity:null;

            $where=array();
            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;
            $where['a.isoff']=0;

            $recoords=getcoords($data['lat'],$data['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $party_near_hostel=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
                ->limit(5)
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
                $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
                $party_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
            }
            $data['party_near_hostel']=!empty($party_near_hostel)?$party_near_hostel:null;
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"获取活动详情失败")));
            }
        }
    }
    /**
     *活动报名
     */
    public function join_apply(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
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
        $activity= M('activity')->where(array('id'=>$aid))->find();
        $apply= M('activity_apply a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.aid'=>$aid,'a.uid'=>$uid,'b.status'=>array('in','2,4')))->find();
        
        if($uid==''||$aid==''||$realname==''||$idcard==''||$num==''||$phone==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($activity)||$activity['isdel']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif($activity['uid']==$uid){
            exit(json_encode(array('code'=>-200,'msg'=>"不能参加自己的活动")));
        }elseif($activity['end_numlimit']-$activity['yes_num']<$num){
            exit(json_encode(array('code'=>-200,'msg'=>"活动人数超过限制")));
        }elseif($activity['endtime']<time()){
            exit(json_encode(array('code'=>-200,'msg'=>"活动已经过期")));
        }elseif(!empty($apply)){
            exit(json_encode(array('code'=>-200,'msg'=>"已经报名")));
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
            $orderid="ac".date("YmdHis", time()) . rand(100, 999);
            
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
                $data['orderid']=$orderid;
                exit(json_encode(array('code'=>200,'msg'=>"提交成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"提交失败")));
            }
        }
    }
    /**
     *活动报名支付
     */
    public function join_pay(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));
        $paytype=intval(trim($ret['paytype']));
        $channel=trim($ret['channel']);
        $couponsid=intval(trim($ret['couponsid']));
        $discount=intval(trim($ret['discount']));
        $money=floatval(trim($ret['money']));

        $orderid=trim($ret['orderid']);
        $order=M('order')->where(array('orderid'=>$orderid))->find();
        $activity= M('activity')->where(array('id'=>$aid))->find();
        $apply= M('activity_apply a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('a.aid'=>$aid,'a.uid'=>$uid,'b.status'=>4))->find();
        
        if($orderid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(!$order){
            exit(json_encode(array('code'=>-200,'msg'=>"订单不存在")));
        }elseif(empty($activity)||$activity['isdel']==1){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif($activity['end_numlimit']-$activity['yes_num']<$apply['num']){
            exit(json_encode(array('code'=>-200,'msg'=>"活动人数超过限制")));
        }elseif($activity['endtime']<time()){
            exit(json_encode(array('code'=>-200,'msg'=>"活动已经过期")));
        }elseif(!empty($apply)){
            exit(json_encode(array('code'=>-200,'msg'=>"已经报名")));
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
            //M('vouchers_order')->where(array('id'=>$couponsid))->setField('status',1);
            $title="参加活动";
            $body="参加".$activity['title'];
            $Pay=A("Api/Pay");
            $paycharge=$Pay->pay($orderid,$title,$body,$money,$channel);
            exit($paycharge);
        }
    }
    /**
     *评论
     */
    public function review(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $activity=M('activity')->where(array('id'=>$aid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($aid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($activity)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['value']=$aid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='party';
            $data['inputtime']=time();
            $id=M("review")->add($data);
            if($id){
                UtilController::addmessage($activity['uid'],"活动评论","您的活动(".$activity['title'].")被其他用户评论了","您的活动(".$activity['title'].")被其他用户评论了","partyreview",$activity['id']);
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
        $aid=intval(trim($ret['aid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($aid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$aid;
            $where['a.isdel']=0;
            $where['a.varname']='party';
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
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));

        $party=M('activity')->where(array('id'=>$aid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'party','value'=>$aid))->find();
        if($aid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($party)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($collectstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户已经收藏")));
        }else{
            $id=M("collect")->add(array(
            	'uid'=>$uid,
            	'value'=>$aid,
            	'varname'=>"party",
            	'inputtime'=>time()
            ));
            if($id){
                UtilController::addmessage($party['uid'],"活动收藏","您的活动(".$party['title'].")被其他用户收藏了","您的活动(".$party['title'].")被其他用户收藏了","partycollect",$party['id']);
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
        $aid=trim($ret['aid']);
        $uid=intval(trim($ret['uid']));

        $aidbox=explode(",",$aid);
        if(is_array($aidbox)){
            $where['id']=array('in',$aidbox);
        }else{
            $where['id']=array('eq',$aid);
        }
        $party=M('activity')->where($where)->count();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if(is_array($aidbox)){
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'party','value'=>$aid))->find();
        }else{
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'party','value'=>array('in',$aidbox)))->find();
        }
        
        if($aid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($party)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($collectstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户尚未收藏")));
        }else{
            $where=array();
            $aidbox=explode(",",$aid);
            if(is_array($aidbox)){
                $where['value']=array('in',$aidbox);
            }else{
                $where['value']=array('eq',$aid);
            }
            $where['uid']=$uid;
            $where['varname']="party";
            $id=M('collect')->where($where)->delete();
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
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));

        $party=M('activity')->where(array('id'=>$aid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>'party','value'=>$aid))->find();
        if($aid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($party)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($hitstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户已经点赞")));
        }else{
            M('activity')->where('id=' .$aid)->setInc("hit");
            $id=M("hit")->add(array(
                'uid'=>$uid,
                'value'=>$aid,
                'varname'=>"party",
                'inputtime'=>time()
            ));
            if($id){
                UtilController::addmessage($party['uid'],"活动点赞","您的活动(".$party['title'].")获得1个赞","您的活动(".$party['title'].")获得1个赞","partyhit",$party['id']);
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
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));

        $party=M('activity')->where(array('id'=>$aid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>'party','value'=>$aid))->find();
        if($aid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($party)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($hitstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户尚未点赞")));
        }else{
            M('activity')->where('id=' .$aid)->setDec("hit");
            $id=M("hit")->delete($hitstatus['id']);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"取消点赞成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"取消点赞失败")));
            }
        }
    }
    /**
     *活动附近推荐活动列表
     */
    public function get_activity_nearactivity(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $aid=intval(trim($ret['aid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        $Party=M('activity')->where(array('id'=>$aid))->find();
        if($aid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Party)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }else{
            $where=array();
            
            $activityset=M("activity")->where(array('id'=>$aid))->getField("id,lat,lng");

            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;
            $where['a.isoff']=0;

            $recoords=getcoords($activityset[$aid]['lat'],$activityset[$aid]['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $data=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                ->page($p,$num)
                ->select();
            foreach ($data as $key => $value) {
                # code...
                $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
                $data[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
                $data[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
                $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
                if(!empty($joinstatus)){
                    $data[$key]['isjoin']=1;
                }else{
                    $data[$key]['isjoin']=0;
                }
            }
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *活动附近推荐美宿列表
     */
    public function get_activity_nearhostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $aid=intval(trim($ret['aid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        
        $Party=M('activity')->where(array('id'=>$aid))->find();
        if($aid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Party)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }else{
            $where=array();
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $activityset=M("activity")->where(array('id'=>$aid))->getField("id,lat,lng");

            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;
            $where['a.isoff']=0;

            $recoords=getcoords($activityset[$aid]['lat'],$activityset[$aid]['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $count=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->count();
            $list=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.acreage,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
                ->page($p,$num)
                ->select();
            $Map=A("Api/Map");
            foreach ($list as $key => $value) {
                # code...
                if(empty($value['reviewnum'])) $list[$key]['reviewnum']=0;
                $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
                if(!empty($hitstatus)){
                    $list[$key]['ishit']=1;
                }else{
                    $list[$key]['ishit']=0;
                }
                $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
                if(!empty($collectstatus)){
                    $list[$key]['iscollect']=1;
                }else{
                    $list[$key]['iscollect']=0;
                }
                $distance=$Map->get_distance_baidu_simple("driving",$Party['lat'].",".$Party['lng'],$value['lat'].",".$value['lng']);
                $list[$key]['distance']=!empty($distance)?$distance:0.00;
            }
            $data=array('data'=>$list,'num'=>$count);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
}