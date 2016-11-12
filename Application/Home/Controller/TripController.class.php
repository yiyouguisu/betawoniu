<?php
namespace Home\Controller;
use Home\Common\CommonController;

class TripController extends CommonController {

    public function index() {
        $uid=session("uid");
        $order=array('a.id'=>'desc');
        $where['a.ispublic']=1;
        $where['a.isdel']=0;

        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'trip'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $count = M("Trip a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->count();
        $page = new \Think\Page($count,10);
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $trip = M("Trip a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->limit($page->firstRow . ',' . $page->listRows)
                ->order($order)
                ->field('a.id,a.title,a.description,a.starttime,a.endtime,a.days,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->select();
        foreach ($trip as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $trip[$key]['reviewnum']=0;
            //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$value['id'],'a.isdel'=>0,'a.varname'=>'trip'))->field("a.id as vid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->select();
            //$trip[$key]['reviewlist']=!empty($reviewlist)?$reviewlist:"";
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $trip[$key]['iscollect']=1;
            }else{
                $trip[$key]['iscollect']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $trip[$key]['ishit']=1;
            }else{
                $trip[$key]['ishit']=0;
            }
        }
        $show = $page->show();
        $this->assign("trip", $trip);
        $this->assign("Page", $show);

        $where=array();
        $where['a.status']=2;
        $where['a.isdel']=0;
        $hotnote=M("note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order(array("a.hit" => "desc","a.listorder" => "desc","a.id" => "desc"))
                ->limit(4)
                ->field('a.id,a.title,a.thumb,a.description,a.area,a.address,a.lat,a.lng,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                ->select();
        $this->assign("hotnote", $hotnote);
        $this->display();
    }
    public function mytrip() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $order=array('a.id'=>'desc');
            $where['a.uid']=$uid;
            $where['a.isdel']=0;

            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'trip'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $count = M("Trip a")
                    ->join("left join zz_member b on a.uid=b.id")
                    ->join("left join {$sqlI} c on a.id=c.value")
                    ->where($where)
                    ->count();
            $page = new \Think\Page($count,10);
            $page->setConfig("prev","上一页");
            $page->setConfig("next","下一页");
            $page->setConfig("first","第一页");
            $page->setConfig("last","最后一页");
            $trip = M("Trip a")
                    ->join("left join zz_member b on a.uid=b.id")
                    ->join("left join {$sqlI} c on a.id=c.value")
                    ->where($where)
                    ->limit($page->firstRow . ',' . $page->listRows)
                    ->order($order)
                    ->field('a.id,a.title,a.description,a.starttime,a.endtime,a.days,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                    ->select();
            foreach ($trip as $key => $value) {
                # code...
                if(empty($value['reviewnum'])) $trip[$key]['reviewnum']=0;
                //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$value['id'],'a.isdel'=>0,'a.varname'=>'trip'))->field("a.id as vid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->select();
                //$trip[$key]['reviewlist']=!empty($reviewlist)?$reviewlist:"";
                $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$value['id']))->find();
                if(!empty($collectstatus)){
                    $trip[$key]['iscollect']=1;
                }else{
                    $trip[$key]['iscollect']=0;
                }
                $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$value['id']))->find();
                if(!empty($hitstatus)){
                    $trip[$key]['ishit']=1;
                }else{
                    $trip[$key]['ishit']=0;
                }
            }
            $show = $page->show();
            $this->assign("trip", $trip);
            $this->assign("Page", $show);

            $where=array();
            $where['a.status']=2;
            $where['a.isdel']=0;
            $hotnote=M("note a")
                    ->join("left join zz_member b on a.uid=b.id")
                    ->where($where)
                    ->order(array("a.hit" => "desc","a.listorder" => "desc","a.id" => "desc"))
                    ->limit(4)
                    ->field('a.id,a.title,a.thumb,a.description,a.area,a.address,a.lat,a.lng,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                    ->select();
            $this->assign("hotnote", $hotnote);
            $this->display();
        }
    }
    public function add() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $data=M('cachetrip')->where(array('uid'=>$uid))->find();
            $cachetripdo=cookie("cachetripdo");
            if(!empty($cachetripdo)&&$cachetripdo=='edit'){
                M('cachetrip')->where(array('uid'=>$uid))->delete();
                M('cachetripinfo')->where(array('tid'=>$data['id']))->delete();
            }

            for ($i=1; $i <= $data['days']; $i++) { 
                # code...
                $daytext=IntToCn($i);
                $data['dayarr'][]=array(
                    'day'=>$i,
                    'daytext'=>$daytext,
                    'date'=>strtotime("+{$i} days",strtotime($data['starttime']))
                    );
            }
            foreach ($data['dayarr'] as $key => $value) {
                # code...
                $eventcity=M('cachetripinfo')->where(array('tid'=>$data['id'],'day'=>$value['day']))->group("city")->order(array('city'=>'asc'))->field("city,cityname")->select();
                foreach ($eventcity as $ke => $valu) {
                    # code...
                    $eventcity[$ke]['event']=M('cachetripinfo')->where(array('tid'=>$data['id'],'day'=>$value['day'],'city'=>$valu['city']))->order(array('listorder'=>'asc'))->field("place,event,varname,eventid,listorder")->select();
                }
                $data['dayarr'][$key]['eventcity']=$eventcity;
            }

            $alltripinfo=M('cachetripinfo')->where(array('tid'=>$data['id'],'day'=>0))->group("city")->order(array('city'=>'asc'))->field("city,cityname")->select();
            foreach ($alltripinfo as $ke => $valu) {
                # code...
                $alltripinfo[$ke]['event']=M('cachetripinfo')->where(array('tid'=>$data['id'],'day'=>0,'city'=>$valu['city']))->order(array('listorder'=>'asc'))->field("place,event,varname,eventid,listorder")->select();
            }
            $data['alltripinfo']=!empty($alltripinfo)?$alltripinfo:null;
            $this->assign("data",$data);
            cookie("cachetripdo",'add');
            $this->display();
        }
    }
    public function doadd(){
        if(IS_POST){
            $uid=session("uid");
            $ret=M('cachetrip')->where(array('uid'=>$uid))->find();
            $title=trim($ret['title']);
            $starttime=intval(trim($ret['starttime']));
            $endtime=intval(trim($ret['endtime']));
            $days=intval(trim($ret['days']));
            $money=floatval(trim($ret['money']));
            $ispublic=intval(trim($ret['ispublic']));

            $tripinfo=M('cachetripinfo')->where(array('tid'=>$ret['id']))->select();
            if(empty($tripinfo)){
                $this->error("请先制定行程!");
            }
            $user=M('Member')->where(array('id'=>$uid))->find();
            if($uid==''||$title==''||$starttime==''||$endtime==''||$days==''){
                exit(json_encode(array('code'=>-200,'msg'=>"数据错误")));
            }elseif(empty($user)){
                exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
            }else{
                $data['uid']=$uid;
                $data['username']=$user['nickname'];
                $data['title']=$title;
                $data['description']=$description;
                $data['starttime']=$starttime;
                $data['endtime']=$endtime;
                $data['days']=$days;
                $data['money']=$money;
                $data['ispublic']=$ispublic;
                $data['inputtime']=time();
                $data['updatetime']=time();
                if(!empty($_POST['tid'])){
                    $tid=$_POST['tid'];
                    $id=M("trip")->where(array('id'=>$tid))->save($data);
                }else{
                    $tid=M("trip")->add($data);
                }
                
                if($tid){
                    if(!empty($_POST['tid'])){
                        M('tripinfo')->where(array('tid'=>$tid))->delete();
                    }
                    $citynamearray=array();
                    foreach ($tripinfo as $value) {
                        # code...
                        $orderid="";
                        if(trim($value['varname'])=='party'){
                            $orderid="ac".date("YmdHis", time()) . rand(100, 999);
                        }elseif(trim($value['varname'])=='hostel'){
                            $orderid="hc".date("YmdHis", time()) . rand(100, 999);
                        }
                        $cityname=M('area')->where(array('id'=>$value['city']))->getField("name");
                        $citynamearray[]=$cityname;
                        M('tripinfo')->add(array(
                            'tid'=>$tid,
                            'orderid'=>$orderid,
                            'day'=>intval(trim($value['day'])),
                            'city'=>intval(trim($value['city'])),
                            'cityname'=>$cityname,
                            'place'=>trim($value['place']),
                            'event'=>trim($value['event']),
                            'varname'=>trim($value['varname']),
                            'eventid'=>intval(trim($value['eventid'])),
                            'listorder'=>intval(trim($value['listorder'])),
                            'date'=>intval(trim($value['date'])),
                            'money'=>floatval(trim($value['money']))
                            ));
                        
                    }
                    if($citynamearray){
                        $citynamearray=array_unique($citynamearray);
                        $description=implode(",", $citynamearray).$days."日游";
                        M("trip")->where(array('id'=>$tid))->setField("description",$description);
                    }
                    cookie("iscachetripday",null);
                    cookie("iscachetrip",null);
                    cookie("cachetripdo",null);
                    cookie("tripedittid",null);
                    M('cachetrip')->where(array('uid'=>$uid))->delete();
                    M('cachetripinfo')->where(array('tid'=>$ret['id']))->delete();
                    exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
                }else{
                    exit(json_encode(array('code'=>-200,'msg'=>"提交失败")));
                }
            }
        }else{
            exit(json_encode(array('code'=>-200,'msg'=>"请求非法")));
        }
        
    }
    public function edit() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $id=I('id');
            $cachetrip=M('cachetrip')->where(array('uid'=>$uid))->find();
            if(!empty($id)){
                M('cachetrip')->where(array('uid'=>$uid))->delete();
                M('cachetripinfo')->where(array('tid'=>$cachetrip['id']))->delete();
                $trip=M('trip')->where(array('id'=>$id))->find();
                $data=array(
                    'uid'=>$uid,
                    'title'=>$trip['title'],
                    'starttime'=>$trip['starttime'],
                    'endtime'=>$trip['endtime'],
                    'days'=>$trip['days'],
                    'ispublic'=>$trip['ispublic']
                    );
                $tid=M('cachetrip')->add($data);
                cookie("tripedittid",$tid);
                $tripinfo=M('tripinfo')->where(array('tid'=>$id))->select();
                foreach ($tripinfo as $key => $value) {
                    # code...
                    $tripinfovalue=$value;
                    unset($tripinfovalue['orderid']);
                    unset($tripinfovalue['money']);
                    $tripinfovalue['daytext']=IntToCn($tripinfovalue['day']);
                    $tripinfovalue['tid']=$tid;
                    M('cachetripinfo')->add($tripinfovalue);
                }
            }else{
                $id=session("tid");
                $tid=cookie("tripedittid");
                $data=$cachetrip;              
            }
            session("tid",$id);
            $this->assign("id",$id);

            for ($i=1; $i <= $data['days']; $i++) { 
                # code...
                $daytext=IntToCn($i);
                $data['dayarr'][]=array(
                    'day'=>$i,
                    'daytext'=>$daytext,
                    'date'=>strtotime("+{$i} days",strtotime($data['starttime']))
                    );
            }
            
            foreach ($data['dayarr'] as $key => $value) {
                # code...
                $eventcity=M('cachetripinfo')->where(array('tid'=>$tid,'day'=>$value['day']))->group("city")->order(array('city'=>'asc'))->field("city,cityname")->select();
                foreach ($eventcity as $ke => $valu) {
                    # code...
                    $eventcity[$ke]['event']=M('cachetripinfo')->where(array('tid'=>$tid,'day'=>$value['day'],'city'=>$valu['city']))->order(array('listorder'=>'asc'))->field("place,event,varname,eventid,listorder")->select();
                }
                $data['dayarr'][$key]['eventcity']=$eventcity;
            }

            $alltripinfo=M('cachetripinfo')->where(array('tid'=>$tid,'day'=>0))->group("city")->order(array('city'=>'asc'))->field("city,cityname")->select();
            foreach ($alltripinfo as $ke => $valu) {
                # code...
                $alltripinfo[$ke]['event']=M('cachetripinfo')->where(array('tid'=>$tid,'day'=>0,'city'=>$valu['city']))->order(array('listorder'=>'asc'))->field("place,event,varname,eventid,listorder")->select();
            }
            $data['alltripinfo']=!empty($alltripinfo)?$alltripinfo:null;
            $this->assign("data",$data);
            cookie("iscachetrip",1);
            cookie("cachetripdo",'edit');
            $this->display();
        }
    }
    public function show() {
        $uid=session("uid");
        $id=$_GET['id'];
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'trip'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Trip a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where(array('a.id'=>$id))
            ->field('a.id,a.title,a.description,a.starttime,a.endtime,a.days,a.ispublic,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
            ->find();
        $tripinfo=M('tripinfo')->where(array('tid'=>$id))->group("day")->order(array('day'=>'asc'))->field("day,date,money")->select();
        foreach ($tripinfo as $key => $value) {
            # code..
            $eventcity=M('tripinfo')->where(array('tid'=>$id,'day'=>$value['day']))->group("city")->order(array('city'=>'asc'))->field("city,cityname,place")->select();
            foreach ($eventcity as $ke => $valu) {
                # code...
                $event=M('tripinfo')->where(array('tid'=>$id,'day'=>$value['day'],'city'=>$valu['city']))->order(array('listorder'=>'asc'))->field("orderid,place,event,varname,eventid,listorder")->select();
                foreach ($event as $k => $val) {
                    # code...
                    $paystatus=M('order_time')->where(array('orderid'=>$val['orderid']))->getField("pay_status");
                    $event[$k]['paystatus']=!empty($paystatus)?$paystatus:0;
                }
                $eventcity[$ke]['event']=$event;
            }
            $tripinfo[$key]['eventcity']=$eventcity;
            
        }
        $data['tripinfo']=!empty($tripinfo)?$tripinfo:null;

        if(empty($data['reviewnum'])) $data['reviewnum']=0;
        // $reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'trip'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->select();
        // $data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
        // $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$data['id']))->find();
        // !empty($collectstatus)?$data['iscollect']=1:$data['iscollect']=0;

        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$data['id']))->find();
        !empty($hitstatus)?$data['ishit']=1:$data['ishit']=0;

        $this->assign("data", $data);
        $this->display();
    }
    public function tripshow() {
        $uid=session("uid");
        $id=$_GET['id'];
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'trip'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Trip a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where(array('a.id'=>$id))
            ->field('a.id,a.title,a.description,a.starttime,a.endtime,a.days,a.ispublic,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
            ->find();
        $tripinfo=M('tripinfo')->where(array('tid'=>$id))->group("day")->order(array('day'=>'asc'))->field("day,date,money")->select();
        foreach ($tripinfo as $key => $value) {
            # code..
            $eventcity=M('tripinfo')->where(array('tid'=>$id,'day'=>$value['day']))->group("city")->order(array('city'=>'asc'))->field("city,cityname,place")->select();
            foreach ($eventcity as $ke => $valu) {
                # code...
                $event=M('tripinfo')->where(array('tid'=>$id,'day'=>$value['day'],'city'=>$valu['city']))->order(array('listorder'=>'asc'))->field("orderid,place,event,varname,eventid,listorder")->select();
                foreach ($event as $k => $val) {
                    # code...
                    $paystatus=M('order_time')->where(array('orderid'=>$val['orderid']))->getField("pay_status");
                    $event[$k]['paystatus']=!empty($paystatus)?$paystatus:0;
                }
                $eventcity[$ke]['event']=$event;
            }
            $tripinfo[$key]['eventcity']=$eventcity;
            
        }
        $data['tripinfo']=!empty($tripinfo)?$tripinfo:null;

        if(empty($data['reviewnum'])) $data['reviewnum']=0;
        // $reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'trip'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->select();
        // $data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
        // $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$data['id']))->find();
        // !empty($collectstatus)?$data['iscollect']=1:$data['iscollect']=0;

        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$data['id']))->find();
        !empty($hitstatus)?$data['ishit']=1:$data['ishit']=0;

        $this->assign("data", $data);
        $this->display();
    }
    public function get_review(){
        $ret=$_GET;
        $tid=intval(trim($ret['tid']));

        if($tid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$tid;
            $where['a.isdel']=0;
            $where['a.varname']='trip';
            $count=M('review a')
                  ->join("left join zz_member b on a.uid=b.id")
                  ->where($where)
                  ->count();
            $page = new \Think\Page($count,10);
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order($order)
                ->field('a.id as rid,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->limit($page->firstRow . ',' . $page->listRows)->select();
            $this->assign("reviewdata",$list);
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            $this->assign("reviewnum", $count);
            $jsondata['html']  = $this->fetch("review");
            $this->ajaxReturn($jsondata,'json');
            
        }
    }
    public function add_review(){
        $ret=$_POST;
        $tid=intval(trim($ret['tid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $trip=M('trip')->where(array('id'=>$tid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($tid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($trip)){
            exit(json_encode(array('code'=>-200,'msg'=>"行程不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['value']=$tid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='trip';
            $data['inputtime']=time();
            $id=M("review")->add($data);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"评论成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"评论失败")));
            }
        }
    }
    public function add_reviewreply(){
        $ret=$_POST;
        $rid=intval(trim($ret['rid']));
        $tid=intval(trim($ret['tid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $review=M('review')->where(array('id'=>$rid))->find();
        $trip=M('trip')->where(array('id'=>$tid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($rid==''||$tid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($review)){
            exit(json_encode(array('code'=>-200,'msg'=>"评论不存在")));
        }elseif(empty($trip)){
            exit(json_encode(array('code'=>-200,'msg'=>"行程不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['rid']=$rid;
            $data['value']=$tid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='trip';
            $data['inputtime']=time();
            $data['type']='reply';
            $id=M("review")->add($data);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"回复成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"回复失败")));
            }
        }
    }
    public function add_reviewquote(){
        $ret=$_POST;
        $rid=intval(trim($ret['rid']));
        $tid=intval(trim($ret['tid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $review=M('review')->where(array('id'=>$rid))->find();
        $trip=M('trip')->where(array('id'=>$tid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($rid==''||$tid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($review)){
            exit(json_encode(array('code'=>-200,'msg'=>"评论不存在")));
        }elseif(empty($trip)){
            exit(json_encode(array('code'=>-200,'msg'=>"行程不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['rid']=$rid;
            $data['value']=$tid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='trip';
            $data['inputtime']=time();
            $data['type']='quote';
            $id=M("review")->add($data);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"评论成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"评论失败")));
            }
        }
    }
    public function add_report(){
        $ret=$_POST;
        $rid=intval(trim($ret['rid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $review=M('review')->where(array('id'=>$rid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($rid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($review)){
            exit(json_encode(array('code'=>-200,'msg'=>"评论不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['rid']=$rid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['status']=1;
            $data['inputtime']=time();
            $id=M("report")->add($data);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"举报成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"举报失败")));
            }
        }
    }
    public function ajax_hit(){
        if(IS_POST){
            $tid=$_POST['tid'];
            $where['uid']=session("uid");
            $where['varname']='trip';
            $where['value']=$tid;
            $num=M('hit')->where($where)->count();
            $trip=M('trip')->where('id=' . $tid)->find();
            if($num==0){
                $where['inputtime']=time();
                M('trip')->where('id=' . $tid)->setInc('hit');
                $id=M('hit')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($trip['uid'],"行程点赞","您的行程(".$trip['title'].")获得1个赞","您的行程(".$trip['title'].")获得1个赞","triphit",$trip['id']);
                    $data['status']=1;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }else{
                    $data['status']=0;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }
            }else{
                M('trip')->where('id=' . $tid)->setDec('hit');
                $id=M('hit')->where($where)->delete();
                if($id){
                    $data['status']=1;
                    $data['type']=2;
                    $this->ajaxReturn($data,'json');
                }else{
                    $data['status']=0;
                    $data['type']=2;
                    $this->ajaxReturn($data,'json');
                }
            }
        }else{
            $data['status']=0;
            $this->ajaxReturn($data,'json');
        }
    }
    public function ajax_collect(){
        if(IS_POST){
            $tid=$_POST['tid'];
            $where['uid']=session("uid");
            $where['varname']='trip';
            $where['value']=$tid;
            $num=M('collect')->where($where)->count();
            $trip=M('trip')->where('id=' . $tid)->find();
            if($num==0){
                $where['inputtime']=time();
                $id=M('collect')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($trip['uid'],"行程收藏","您的行程(".$trip['title'].")被其他用户收藏了","您的行程(".$trip['title'].")被其他用户收藏了","tripcollect",$trip['id']);
                    $data['status']=1;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }else{
                    $data['status']=0;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }
            }else{
                $id=M('collect')->where($where)->delete();
                if($id){
                    $data['status']=1;
                    $data['type']=2;
                    $this->ajaxReturn($data,'json');
                }else{
                    $data['status']=0;
                    $data['type']=2;
                    $this->ajaxReturn($data,'json');
                }
            }
        }else{
            $data['status']=0;
            $this->ajaxReturn($data,'json');
        }
    }
    public function ajax_cachetripinfo(){
        if(IS_POST){
            $uid=session("uid");
            $day=cookie("iscachetripday");
            $iscachetrip=cookie("iscachetrip");
            $daytext=IntToCn($day);
            $cachetrip=M('cachetrip')->where(array('uid'=>$uid))->find();
            if($cachetrip&&!$iscachetrip){
                M('cachetrip')->where(array('uid'=>$uid))->delete();
                M('cachetripinfo')->where(array('tid'=>$cachetrip['id']))->delete();
                $cachetrip=array();
            }
            if(!empty($cachetrip)){
                $hid=$_POST['hid'];
                if(!empty($hid)){
                    $hidbox=explode(",", $hid);
                    foreach ($hidbox as $value) {
                        # code...
                        $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->join("left join zz_area c on a.city=c.id")->where(array('a.id'=>$value))->field("a.id as eventid,a.title as event,a.city,c.name as cityname,b.title as place,'hostel' as varname")->find();
                        $cachetripinfo=M('cachetripinfo')->where(array('tid'=>$cachetrip['id'],'eventid'=>$hostel['eventid'],'varname'=>$hostel['varname']))->find();
                        if(!empty($day)){
                            $hostel['day']=$day;
                            $hostel['daytext']=$daytext;
                            $hostel['date']=strtotime("+{$day} days",$cachetrip['starttime']);
                        }
                        if($cachetripinfo){
                            M('cachetripinfo')->where(array('id'=>$cachetripinfo['id']))->save($hostel);
                        }else{
                            $hostel['tid']=$cachetrip['id'];
                            M('cachetripinfo')->add($hostel);
                        }
                    }
                }

                $aid=$_POST['aid'];
                if(!empty($aid)){
                    $party=M('activity a')->join("left join zz_hostel b on a.hid=b.id")->join("left join zz_place c on b.place=c.id")->join("left join zz_area d on a.city=d.id")->where(array('a.id'=>$aid))->field("a.id as eventid,a.title as event,a.city,d.name as cityname,c.title as place,'party' as varname")->find();
                    $cachetripinfo=M('cachetripinfo')->where(array('tid'=>$cachetrip['id'],'eventid'=>$party['eventid'],'varname'=>$party['varname']))->find();
                    if(!empty($day)){
                        $party['day']=$day;
                        $party['daytext']=$daytext;
                        $party['date']=strtotime("+{$day} days",$cachetrip['starttime']);
                    }
                    if($cachetripinfo){
                        M('cachetripinfo')->where(array('id'=>$cachetripinfo['id']))->save($party);
                    }else{
                        $party['tid']=$cachetrip['id'];
                        M('cachetripinfo')->add($party);
                    }
                }
            }else{
                $cachetrip=array();
                $cachetrip['uid']=$uid;  
                $cachetrip['title']=$_POST['title'];  
                $cachetrip['starttime']=strtotime($_POST['starttime']);  
                $cachetrip['endtime']=strtotime("+{$_POST['days']} days",strtotime($_POST['starttime']));
                $cachetrip['days']=$_POST['days'];  
                $tid=M('cachetrip')->add($cachetrip);

                $hid=$_POST['hid'];
                if(!empty($hid)){
                    $hidbox=explode(",", $hid);
                    foreach ($hidbox as $value) {
                        # code...
                        $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->join("left join zz_area c on a.city=c.id")->where(array('a.id'=>$value))->field("a.id as eventid,a.title as event,a.city,c.name as cityname,b.title as place,'hostel' as varname")->find();
                        if(!empty($day)){
                            $hostel['day']=$day;
                            $hostel['daytext']=$daytext;
                            $hostel['date']=strtotime("+{$day} days",$cachetrip['starttime']);
                        }
                        $hostel['tid']=$tid;
                        M('cachetripinfo')->add($hostel);
                    }
                }
                $aid=$_POST['aid'];
                if(!empty($aid)){
                    if(!empty($day)){
                        $party['day']=$day;
                        $party['daytext']=$daytext;
                        $party['date']=strtotime("+{$day} days",$cachetrip['starttime']);
                    }
                    $party=M('activity a')->join("left join zz_hostel b on a.place=b.id")->join("left join zz_place c on b.place=c.id")->join("left join zz_area d on a.city=d.id")->where(array('a.id'=>$aid))->field("a.id as eventid,a.title as event,a.city,d.name as cityname,c.title as place,'party' as varname")->find();
                    $party['tid']=$tid;
                    M('cachetripinfo')->add($party);
                }
                cookie("iscachetrip",1);
            }
            $sql=M('cachetripinfo')->_sql();
            $this->ajaxReturn(array('code'=>200,'msg'=>"success",'sql'=>$sql),'json');
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"请求非法"),'json');
        }
    }
    public function ajax_addday(){
        if(IS_POST){
            $uid=session("uid");
            $cachetrip=M('cachetrip')->where(array('uid'=>$uid))->find();
            $cachetrip['endtime']=strtotime("+1 days",$cachetrip['endtime']);
            $cachetrip['days']=$cachetrip['days']+1;
            $aid=M('cachetrip')->where(array('uid'=>$uid))->save($cachetrip);
            
            $daytext=IntToCn($cachetrip['days']);
            
            $data=array(
                'endtime'=>$cachetrip['endtime'],
                'day'=>$cachetrip['days'],
                'daytext'=>$daytext,
                'date'=>$cachetrip['endtime'],
                'listorder'=>0
                );
            
            if($aid){
                $this->ajaxReturn(array('code'=>200,'msg'=>"success",'data'=>$data),'json');
            }else{
                $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
            }
            
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
        }
    }
    public function ajax_deltripinfo(){
        if(IS_POST){
            $uid=session("uid");
            $cachetrip=M('cachetrip')->where(array('uid'=>$uid))->find();
            $did=M('cachetripinfo')->where(array('tid'=>$cachetrip['id'],'day'=>$_POST['day'],'eventid'=>$_POST['eventid']))->delete();
            if($did){
                $this->ajaxReturn(array('code'=>200,'msg'=>"success"),'json');
            }else{
                $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
            }
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
        }
    }
    public function ajax_updatetripinfo(){
        if(IS_POST){
            $uid=session("uid");
            $cachetrip=M('cachetrip')->where(array('uid'=>$uid))->find();
            $mid=M('cachetripinfo')->where(array('tid'=>$cachetrip['id'],'eventid'=>$_POST['eventid']))->save(array(
                "day"=>$_POST['day'],
                'daytext'=>IntToCn($_POST['day']),
                'date'=>strtotime("+{$_POST['day']} days",$cachetrip['starttime'])
                ));
            if($mid){
                $this->ajaxReturn(array('code'=>200,'msg'=>"success"),'json');
            }else{
                $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
            }
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
        }
    }
    public function ajax_listordertripinfo(){
        if(IS_POST){
            $uid=session("uid");
            $cachetrip=M('cachetrip')->where(array('uid'=>$uid))->find();
            $mid=M('cachetripinfo')->where(array('tid'=>$cachetrip['id'],'eventid'=>$_POST['feventid']))->setField("listorder",$_POST['tlistorder']);
            if($mid){
                M('cachetripinfo')->where(array('tid'=>$cachetrip['id'],'eventid'=>$_POST['teventid']))->setField("listorder",$_POST['flistorder']);
                $this->ajaxReturn(array('code'=>200,'msg'=>"success"),'json');
            }else{
                $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
            }
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
        }
    }
    public function ajax_cookieday(){
        if(IS_POST){
            cookie("iscachetripday",$_POST['day']);
            $this->ajaxReturn(array('code'=>200,'msg'=>"success"),'json');
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
        }
    }
    public function ajax_setpublic(){
        if(IS_POST){
            $tid=I('tid');
            $ispublic=I('ispublic');
            $mid=M('trip')->where(array('id'=>$tid))->setField("ispublic",$ispublic);
            if($mid){
                $this->ajaxReturn(array('code'=>200,'msg'=>"success"),'json');
            }else{
                $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
            }
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
        }
    }
    public function ajax_editcachetrip(){
        if(IS_POST){
            $uid=session("uid");
            $id=I('id');
            $cachetrip=M('cachetrip')->where(array('uid'=>$uid))->find();
            if($cachetrip){
                M('cachetrip')->where(array('uid'=>$uid))->delete();
                M('cachetripinfo')->where(array('tid'=>$cachetrip['id']))->delete();
            }
            $trip=M('trip')->where(array('id'=>$id))->find();
            $data=array(
                'uid'=>$uid,
                'title'=>$_POST['title'],
                'starttime'=>strtotime($_POST['starttime']),
                'endtime'=>strtotime("+{$_POST['days']} days",strtotime($_POST['starttime'])),
                'days'=>$_POST['days'],
                'ispublic'=>$trip['ispublic']
                );
            $tid=M('cachetrip')->add($data);
            cookie("tripedittid",$tid);
            $tripinfo=M('tripinfo')->where(array('tid'=>$id))->select();
            foreach ($tripinfo as $key => $value) {
                # code...
                $tripinfovalue=$value;
                unset($tripinfovalue['orderid']);
                unset($tripinfovalue['money']);
                $tripinfovalue['daytext']=IntToCn($tripinfovalue['day']);
                $tripinfovalue['tid']=$tid;
                M('cachetripinfo')->add($tripinfovalue);
            }
            session("tid",$id);
            if($tid){
                $this->ajaxReturn(array('code'=>200,'msg'=>"success"),'json');
            }else{
                $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
            }
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"error"),'json');
        }
    }
}