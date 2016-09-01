<?php
namespace Web\Controller;
use Web\Common\CommonController;

class HostelController extends CommonController {

    public function index() {
    	$uid=session("uid");
        $where=array();
        $where['a.status']=2;
        $where['a.isdel']=0;
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Hostel a")
        ->join("left join zz_member b on a.uid=b.id")
        ->join("left join {$sqlI} c on a.id=c.value")
        ->where($where)->order(array('id'=>"desc"))
        ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.id uid,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
        ->select();
        $Map=A("Api/Map");
        foreach ($data as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $data[$key]['reviewnum']=0;
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $data[$key]['ishit']=1;
            }else{
                $data[$key]['ishit']=0;
            }
           
            // 经度
            $lat=cookie('longitude');
            // 纬度
            $lng=cookie('latitude');
            // print_r($value['lat']);
            // print_r($value['lng']);
            // die;
            $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            $data[$key]['distance']=!empty($distance)?$distance:0.00;
             $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $data[$key]['iscollect']=1;
            }else{
                $data[$key]['iscollect']=0;
            }
            // $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            // $data[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        // print_r($data);
        // die;
        // print_r(M("Hostel a")->getlastsql());
        // 特色
        $hostelcate = M("hostelcate")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("hostelcate", $hostelcate);
        // 特色服务
        $roomcate=M("roomcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("roomcate",$roomcate);
        // 床型
        $bedcate=M("bedcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("bedcate",$bedcate);
        // 面积
        $acreagecate = M("linkage")->where("catid=7")->field('value,name')->select();
        $this->assign("acreagecate", $acreagecate);
        // 评分
        $scorecate = M("linkage")->where("catid=8")->field('value,name')->select();
        $this->assign("scorecate", $scorecate);
        // 名宿特色
        $hosteltype = M("hosteltype")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("hosteltype", $hosteltype);
        $areaArray=M('area')->where(array('parentid'=>0))->select();
        $this->assign("areaArray",$areaArray);
        // print_r($data);
        // die;
        $this->assign('data',$data);
        $this->display();
    }

    public function select(){
        $Map=A("Api/Map");
        // 价格
        if(isset($_POST['minmoney'])){
            $where['a.money'] = array(array('EGT', $_POST['minmoney']), array('ELT', $_POST['maxmoney']));
        }
        // 城市
        if(isset($_POST['city'])){
           $where['a.area']=$_POST['city'];
        }
        // 特色
        if(isset($_POST['catid'])){
            $where['a.catid']=$_POST['catid'];
        }
        // 服务设施
        if(isset($_POST['support']) && $_POST['support']!=0){
            $where['a.support']=array('like',"%,".$_POST['support'].",%");
        }
        // 类型
        if(isset($_POST['type'])){
            $where['a.style']=array('style'=>$_POST['type']);
        }
        // 床型
        if(isset($_POST['bedtype'])){
            $where['a.bedtype']=array('like',"%,".$_POST['bedtype'].",%");
        }
        // 面积
        if(isset($_POST['acreage'])){
            $acreagebox=explode("|", $acreage);
            if(is_array($acreagebox)&&count($acreagebox)>1){
                if($acreagebox[1]!=0){
                    $where['a.acreage'] = array(array('EGT', $acreagebox[0]), array('ELT', $acreagebox[1]));
                }else{
                    $where['a.acreage'] = array('EGT', $acreagebox[0]);
                }
                
            }else{
                $where['a.acreage'] =$_POST['acreage'];
            }
        }
        // 评分
        if(isset($_POST['score'])){
            $where['a.score'] =array('EGT', $_POST['score']);
        }
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.id uid,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->select();
        foreach ($data as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $data[$key]['reviewnum']=0;
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $data[$key]['ishit']=1;
            }else{
                $data[$key]['ishit']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $data[$key]['iscollect']=1;
            }else{
                $data[$key]['iscollect']=0;
            }

            // 经度
            $lat=cookie('longitude');
            // 纬度
            $lng=cookie('latitude');
            // print_r($value['lat']);
            // print_r($value['lng']);
            // die;
            $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            $data[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        // print_r(M("Hostel a")->getlastsql());

        if(count($data)>0){
            $data=$data;
        }
        else
        {
            $data=array();
        }
        $this->ajaxReturn($data,'json');
    }
    public function map(){
        $where['a.status']=2;
        $where['a.isdel']=0;
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->select();
        $jsonlist="[";
        foreach ($data as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $data[$key]['reviewnum']=0;
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $data[$key]['ishit']=1;
            }else{
                $data[$key]['ishit']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $data[$key]['iscollect']=1;
            }else{
                $data[$key]['iscollect']=0;
            }
            // $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            // $data[$key]['distance']=!empty($distance)?$distance:0.00;
            if(!empty($value['lng'])&&!empty($value['lat'])){
                if($key==0){
                    $jsonlist.="{ title: \"￥{$value['money']}起\", content: \"{$value['title']}\", point: \"{$value['lng']}|{$value['lat']}\", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }";
                }else{
                    $jsonlist.=",{ title: \"￥{$value['money']}起\", content: \"{$value['title']}\", point: \"{$value['lng']}|{$value['lat']}\", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }";
                }
            }
            
        }
        $jsonlist.="]";
        $this->assign('jsonlist',$jsonlist);
        $this->display();
    }
    public function add() {
        if ($_POST) {
            $uid=session("uid");
            $member=M('Member')->where(array('id'=>$uid))->find();
            $Map=A("Api/Map");
            $area="";
            if(!empty($_POST['town'])){
                $area=$_POST['province'] . ',' . $_POST['city'] . ',' . $_POST['town'];
            }else{
                $area=$_POST['province'] . ',' . $_POST['city'];
            }
            $location=$Map->get_position_complex($area,$_POST['address']);
            if(in_array($_POST['province'],array(2,3,4,5))){
                $city=$_POST['province'];
            }else{
                $city=$_POST['city'];
            }
            $imglist=json_encode($_POST['imglist']);
            if (D("Hostel")->create()) {
                D("Hostel")->uid = $uid;
                D("Hostel")->lng = $location['lng'];
                D("Hostel")->lat = $location['lat'];
                D("Hostel")->city = $city;
                D("Hostel")->area = $area;
                D("Hostel")->imglist = $imglist;
                D("Hostel")->begintime=strtotime($_POST['begintime']);
                D("Hostel")->endtime=strtotime($_POST['endtime']);
                D("Hostel")->inputtime = time();
                D("Hostel")->username = !empty($member['nickname'])?$member['nickname']:$member['username'];
                $id = D("Hostel")->add();
                if($id){
                    $this->success("发布游记成功，等待管理员审核！", U("Home/Hostel/index"));
                } else {
                    $this->error("新增游记失败！");
                }
            } else {
                $this->error(D("Hostel")->getError());
            }
        } else {
            if (!session('uid')) {
                $this->redirect('Home/Member/login');
            } else {
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $hostelstyle=M("hostelstyle")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("hostelstyle",$hostelstyle);
                $hostelman=M("hostelman")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("hostelman",$hostelman);
                $this->display();
            }
        }
    }
    public function show() {
        $id=I('id');
        $uid=session("uid");
        M('Hostel')->where(array('id'=>$id))->setInc("view");
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Hostel a")
        ->join("left join zz_member b on a.uid=b.id")
        ->join("left join {$sqlI} c on a.id=c.value")
        ->where(array('a.id'=>$id))
        ->field('a.id,a.title,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.description,a.imglist,a.content,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.realname_status,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime,c.reviewnum')
        ->find();
        $imglist=json_decode($data['imglist'],true);
        $this->assign("imglist", $imglist);
        $support=M("roomcate")->where(array('id'=>array('in',$data['support'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("support", $support);
        if(empty($data['reviewnum'])) $data['reviewnum']=0;
        // $evaluation=gethouse_evaluation($data['id']);
        // $house['evaluation']=!empty($evaluation['evaluation'])?$evaluation['evaluation']:0.0;
        // $house['evaluationpercent']=!empty($evaluation['percent'])?$evaluation['percent']:0.00;
        $onlinereply=0.00;
        $data['onlinereply']=!empty($onlinereply)?$onlinereply:0.00;

        $evaluationconfirm=0.0;
        $data['evaluationconfirm']=!empty($evaluationconfirm)?$evaluationconfirm:0.0;

        $orderconfirm=0.00;
        $data['orderconfirm']=!empty($orderconfirm)?$orderconfirm:0.00;
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$data['id']))->find();
        if(!empty($collectstatus)){
            $data['iscollect']=1;
        }else{
            $data['iscollect']=0;
        }
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$data['id']))->find();
        if(!empty($hitstatus)){
            $data['ishit']=1;
        }else{
            $data['ishit']=0;
        }
        $Map=A("Api/Map");
        $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$data['lat'].",".$data['lng']);
        $data['distance']=!empty($distance)?$distance:0.00;
        //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'hostel'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->select();
        //$data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $room=M('room a')->join("left join {$sqlI} c on a.id=c.value")->join("left join zz_bedcate b on a.roomtype=b.id")->where(array('a.hid'=>$data['id'],'a.isdel'=>0,))->order(array('a.id'=>'desc'))->field("a.id as rid,a.title,a.thumb,a.area,a.money,a.roomtype,a.support,a.mannum,c.reviewnum,b.catname as bedtype")->select();
        $tese=array();
        foreach ($room as $key => $value) {
            $tese[$key]=$value['support'];
            $room[$key]['support']=M("roomcate")->where(array('ishot'=>1,'id'=>array('in',$value['support'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        }
        $data['room']=!empty($room)?$room:null;
        $roomnum=M('room')->where(array('hid'=>$data['id']))->count();
        $data['roomnum']=!empty($roomnum)?$roomnum:0;
        $data['imglist']=json_decode($data['imglist']);
        $where=array();
        $where['a.status']=2;
        $where['a.uid']=$data['uid'];
        $where['a.isdel']=0;
        $house_owner_activity=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->where($where)->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
            ->select();
        foreach ($house_owner_activity as $key => $value) {
            # code...
            // $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
            // $house_owner_activity[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
            // $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
            // $house_owner_activity[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
            // $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
            // if(!empty($joinstatus)){
            //     $house_owner_activity[$key]['isjoin']=1;
            // }else{
            //     $house_owner_activity[$key]['isjoin']=0;
            // }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $house_owner_activity[$key]['iscollect']=1;
            }else{
                $house_owner_activity[$key]['iscollect']=0;
            }
        }
        $data['house_owner_activity']=!empty($house_owner_activity)?$house_owner_activity:null;

        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;

        $recoords=getcoords($data['lat'],$data['lng'],2);
        $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
        $house_near_activity=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
            ->limit(4)
            ->select();
        foreach ($house_near_activity as $key => $value) {
            # code...
            // $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
            // $house_near_activity[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
            // $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
            // $house_near_activity[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
            // $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
            // if(!empty($joinstatus)){
            //     $house_near_activity[$key]['isjoin']=1;
            // }else{
            //     $house_near_activity[$key]['isjoin']=0;
            // }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $house_near_activity[$key]['iscollect']=1;
            }else{
                $house_near_activity[$key]['iscollect']=0;
            }
        }
        $data['house_near_activity']=!empty($house_near_activity)?$house_near_activity:null;

        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;

        $recoords=getcoords($data['lat'],$data['lng'],2);
        $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
        $house_near_hostel=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit(4)
            ->select();
        $Map=A("Api/Map");
        foreach ($house_near_hostel as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $note[$key]['reviewnum']=0;
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $house_near_hostel[$key]['ishit']=1;
            }else{
                $house_near_hostel[$key]['ishit']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $house_near_hostel[$key]['iscollect']=1;
            }else{
                $house_near_hostel[$key]['iscollect']=0;
            }
            $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            $house_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        $data['house_near_hostel']=!empty($house_near_hostel)?$house_near_hostel:null;
        $roomcate=M("roomcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $str='';
        foreach ($tese as $key => $value) {
            $str.=''.$value.',';
        }
        $tese=explode(",",$str);
        $tese=array_filter(array_unique($tese));
        $rarray=array();
        // die;
        foreach ($roomcate as $key => $value) {
            $rarray[$key]['catname']=$value['catname'];
            $rarray[$key]['thumb']=$value['gray_thumb'];

            foreach ($tese as $k => $v) {
                if($v==$value['id']){
                    $rarray[$key]['thumb']=$value['red_thumb'];
                }
            }
        }
        $this->assign("roomcate",array_chunk($rarray,2,true));
        $this->assign("data",$data);
        $this->assign("roomcount",count($data['room']));
        $this->display();
    }
    public function appshow() {
        $id=I('id');
        
        $data=M("Hostel")->where(array('id'=>$id))->getField("content");


        
        $this->assign("data",$data);
        $this->display();
    }
    public function approomshow() {
        $id=I('id');
        
        $data=M("room")->where(array('id'=>$id))->getField("content");


        
        $this->assign("data",$data);
        $this->display();
    }
    public function ajax_hit(){
        if(IS_POST){
            $hid=$_POST['hid'];
            $where['uid']=session("uid");
            $where['varname']='hostel';
            $where['value']=$hid;
            $num=M('hit')->where($where)->count();
            if($num==0){
                $where['inputtime']=time();
                M('hostel')->where('id=' . $hid)->setInc('hit');
                $id=M('hit')->add($where);
                if($id){
                    $data['status']=1;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }else{
                    $data['status']=0;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }
            }else{
                M('hostel')->where('id=' . $hid)->setDec('hit');
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
            $hid=$_POST['hid'];
            $where['uid']=session("uid");
            $where['varname']='hostel';
            $where['value']=$hid;
            $num=M('collect')->where($where)->count();
            if($num==0){
                $where['inputtime']=time();
                $id=M('collect')->add($where);
                if($id){
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

    function room(){
        $id=I('id');
        $hid=I('hid');
        $uid=session("uid");
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Room a")
        ->join("left join {$sqlI} c on a.id=c.value")
        ->join("left join zz_hostel b on a.hid=b.id")
        ->join("left join zz_bedcate d on a.roomtype=d.id")
        ->where(array('a.id'=>$id))
        ->field('a.id as rid,a.hid,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.imglist,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.inputtime,c.reviewnum,b.title as hostel,b.area as hostelarea,b.address as hosteladdress,b.lat,b.lng,d.catname as bedtype')
        ->find();
        if(empty($data['reviewnum'])) $data['reviewnum']=0;
        $imglist=explode("|", $data['imglist']);
        $this->assign("imglist", $imglist);
        $support=M("roomcate")->where(array('id'=>array('in',$data['support'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("support", $support);
        
        $data['support']=M("roomcate")->where(array('ishot'=>1,'id'=>array('in',$data['support'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        //$evaluation=getroom_evaluation($data['rid']);
        $data['evaluation']=!empty($evaluation['evaluation'])?$evaluation['evaluation']:0.0;
        $data['evaluationpercent']=!empty($evaluation['percent'])?$evaluation['percent']:0.00;
        //$data['evaluationset']=$evaluation;
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
        $data['support']=array_chunk($data['support'],2,true);
        $data['imglist']=explode("|",$data['imglist']);
        $this->assign("data",$data);
        $this->assign("hid",$hid);
        $this->display();
    }
}