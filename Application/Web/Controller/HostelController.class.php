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
      $llat = cookie('lat');
      $llng = cookie('lng');
      $this->assign('llat', $llat);
      $this->assign('llng', $llng);
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
          $distance = 0.00; //$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
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
      $stayStart = date('m-d', time() + 3600 * 24);
      $stayEnd = date('m-d', time() + 3600 * 48);
      $stayStartValue = date('Y-m-d',  time() + 3600 * 24);
      $stayEndValue = date('Y-m-d',  time() + 3600 * 48);
      $this->assign('stayStartValue', $stayStartValue);
      $this->assign('stayEndValue', $stayEndValue);
      $this->assign('stayStart', $stayStart);
      $this->assign('stayEnd', $stayEnd);
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
          ->where($where)
          ->order(array('id'=>"desc"))
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
          //$distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
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
      ->field('a.id,a.title,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.description,a.imglist,a.content,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.id as oid,b.head,b.realname_status,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime,c.reviewnum')
      ->find();
      $imglist=json_decode($data['imglist'],true);
      $this->assign("imglist", $imglist);

      $support=M("roomcate")
        ->where(array('id'=>array('in',$data['support'])))
        ->field('id,gray_thumb,blue_thumb,red_thumb,catname')
        ->order(array('listorder'=>'desc','id'=>'asc'))
        ->select();
      //  dump($support);
      $this->assign("support", $support);
      if(empty($data['reviewnum'])) $data['reviewnum']=0;
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
      $lat = cookie('lat');
      $lng = cookie('lng');
      $distance = $Map->get_distance_baidu("driving",$lat.",".$lng,$data['lat'].",".$data['lng']);
      $data['distance']=!empty($distance)?$distance:0.00;
      $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
      $room=M('room a')
        ->join("join zz_hostel x on a.hid = x.id")
        ->join("left join {$sqlI} c on a.id=c.value")
        ->join("left join zz_bedcate b on a.roomtype=b.id")
        ->where(array('a.hid'=>$data['id'],'a.isdel'=>0,))
        ->order(array('a.id'=>'desc'))
        ->field("x.uid, a.id as rid,a.title,a.thumb,a.area,a.money,a.roomtype,a.support,a.mannum,c.reviewnum,b.catname as bedtype")->select();
      $tese=array();
      foreach ($room as $key => $value) {
          $tese[$key]=$value['support'];
          $room[$key]['support']=M("roomcate")
            ->where(array('ishot'=>1,'id'=>array('in',$value['support'])))
            ->field('id,gray_thumb,blue_thumb,red_thumb,catname')
            ->order(array('listorder'=>'desc','id'=>'asc'))
            ->select();
          if($value['uid'] == session('uid')) {
            $room[$key]['isowner'] = 1;
          }
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
          $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
          if(!empty($collectstatus)){
              $house_owner_activity[$key]['iscollect']=1;
          }else{
              $house_owner_activity[$key]['iscollect']=0;
          }
          $house_owner_activity[$key]['starttime']=date("Y-m-d",$value['starttime']);
          $house_owner_activity[$key]['endtime']=date("Y-m-d",$value['endtime']);
      }
      $data['house_owner_activity']=!empty($house_owner_activity)?json_encode($house_owner_activity):null;
      $house_owner_activity_num=count($house_owner_activity);
      $this->assign("house_owner_activity_num",$house_owner_activity_num);
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
          if(empty($value['reviewnum'])) $house_near_hostel[$key]['reviewnum']=0;
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
          $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
          $house_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
          $house_near_hostel[$key]['address']=getarea($value['area']).$value['address'];
      }
      $data['house_near_hostel']=!empty($house_near_hostel)?json_encode($house_near_hostel):null;
      $house_near_hostel_num=count($house_near_hostel);
      $this->assign("house_near_hostel_num",$house_near_hostel_num);
      $roomcate=M("roomcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
      //dump($roomcate);
      $str='';
      foreach ($tese as $key => $value) {
          $str.=''.$value.',';
      }
      $tese=explode(",",$str);
      $tese=array_filter(array_unique($tese));
      $rarray=array();

      foreach ($roomcate as $key => $value) {
        $rarray[$key]['catname']=$value['catname'];
        $rarray[$key]['thumb']=$value['gray_thumb'];
        foreach ($tese as $k => $v) {
          if($v==$value['id']){
              $rarray[$key]['thumb']=$value['black_thumb'];
              $rarray[$key]['iscolor']=1;
              $arrtrue[]=$rarray[$key];
              unset($rarray[$key]);
          }
        }
      }
      $rarray=array_merge_recursive($arrtrue,$rarray);
      //dump($rarray);
      if($data['oid'] == session('uid')) {
        $data['is_owner'] = true;
      }
      $this->assign("roomcate",array_chunk($rarray,2,true));
      $this->assign("data",$data);
      $this->assign("roomcount",count($data['room']));
      $this->display();
  }
  public function app_show() {
      $id=I('id');
      $data=M("Hostel")->where(array('id'=>$id))->find();
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

  public function pay() {
    $orderid = $_GET['orderid'];
    $order = M('order a')
      ->join('zz_book_room b on a.orderid = b.orderid')
      ->join('zz_room c on b.rid = c.id')
      ->join('zz_hostel d on b.hid = d.id')
      ->join('zz_member e on e.id = a.uid')
      ->field('a.orderid, a.uid, e.nickname, e.phone, b.starttime, b.endtime, d.address, c.title as room_name, d.title as hotel_name,a.money')
      ->where(array(
        'a.orderid' => $orderid,
      ))
      ->find();
    if(!$order) {
      $this->error('订单未找到！'); 
    }
    $this->assign('order', $order); 
    $this->display(); 
  }

  public function ajax_getlist() {
      $uid=session("uid");
      $order=array(); $where=array();
      $type=I('order',0,'intval');

      $province = $_GET['province'] == 0 ? '' : $_GET['province'];
      $city = $_GET['city'] == 0 ? '' : $_GET['city'];
      $town = $_GET['town'] == 0 ? '' : $_GET['town'];
      $area = '';
      $where=array();
      if($_GET['pointed']) {
        $city = $_GET['city'];
        $like = "%{$city}%";
        $cid = M('area')
          ->where(array('name' => array('like', $like)))
          ->getField('id');
        $where['a.city'] = $cid;
      } else {
        if($province) {
          $area .= $province;
          if($city) {
            $area .= ',' . $city;
            if($town) {
              $area .= ',' . $town; 
            } 
          }
        }
        $where['a.area'] = array('like', "{$area}%");
      }
      $where['a.status']=2;
      $where['a.isdel']=0;
      $where['a.isoff']=0;
      if(!empty($catid)){
          $where['a.catid']=$catid;
      }
      if(!empty($style)){
          $where['a.style']=$style;
      }
      if(!empty($money)){
          $moneybox=explode("|", $money);
          if(is_array($moneybox)&&count($moneybox)>1){
              if($moneybox[0]==0){
                  $where['a.money'] = array('ELT', $moneybox[1]);
              }elseif($moneybox[1]==0){
                  $where['a.money'] = array('EGT', $moneybox[0]);
              }else{
                  $where['a.money'] = array(array('EGT', $moneybox[0]), array('ELT', $moneybox[1]));
              }
          }else{
              $where['a.money'] =$money;
          }
      }
      if(!empty($acreage)){
          $acreagebox=explode("|", $acreage);
          if(is_array($acreagebox)&&count($acreagebox)>1){
              $where['a.acreage'] = array(array('EGT', $acreagebox[0]), array('ELT', $acreagebox[1]));
          }else{
              $where['a.acreage'] =$acreage;
          }
      }
      if(!empty($score)){
          $where['a.score'] =array('EGT', $score);
      }
      if(!empty($support)){
          $where['a.support']=array('like',"%,".$support.",%");
      }
      if(!empty($bedtype)){
          $where['a.bedtype']=array('like',"%,".$bedtype.",%");
      }
      
      $sqlI=M('review')
        ->where(array('isdel'=>0,'varname'=>'hostel'))
        ->group("value")
        ->field("value,count(value) as reviewnum")
        ->buildSql();
      $count=M("Hostel a")
          ->join("left join zz_member b on a.uid=b.id")
          ->join("left join {$sqlI} c on a.id=c.value")
          ->where($where)
          ->count();
      $page = new \Think\Page($count,10);
      $page->setConfig("prev","上一页");
      $page->setConfig("next","下一页");
      $page->setConfig("first","第一页");
      $page->setConfig("last","最后一页");

      $data=M("Hostel a")
          ->join("left join zz_member b on a.uid=b.id")
          ->join("left join {$sqlI} c on a.id=c.value")
          ->where($where)
          ->order(array('id'=>"desc"))
          ->field('a.id,a.title,a.thumb,a.money,a.area,a.acreage,a.address,a.lat,a.lng,a.hit,a.bookremark,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
          ->limit($page->firstRow . ',' . $page->listRows)
          ->order('a.id desc')
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
          $collectstatus=M('collect')
            ->where(array(
              'uid'=>$uid,
              'varname'=>"hostel",
              'value'=>$value['id']
            ))
            ->find();
          if(empty($collectstatus)){
              $data[$key]['iscollect']=0;
          }else{
              $data[$key]['iscollect']=1;
          }
      }
      $hostelnum=M("Hostel a")
          ->join("left join zz_member b on a.uid=b.id")
          ->join("left join {$sqlI} c on a.id=c.value")
          ->where($where)->count();

      $hidbox=M("Hostel a")->where($where)->getField("id",true);
      $where=array();
      $where['a.hid']=array('in',$hidbox);
      $where['a.isdel']=0;
      if(!empty($support)){
          $where['a.support']=array('like',"%,".$support.",%");
      }
      if(!empty($bedtype)){
          $where['a.bedtype']=array('like',"%,".$bedtype.",%");
      }
      if(!empty($money)){
          $moneybox=explode("|", $money);
          if(is_array($moneybox)&&count($moneybox)>1){
              $where['a.money'] = array(array('EGT', $moneybox[0]), array('ELT', $moneybox[1]));
          }else{
              $where['a.money'] =$money;
          }
      }
      $roomnum=M("room a")->where($where)->count();
      
      $this->assign('data', $data);

      if (empty($data)) {
          $jsondata['status']  = 0;
      }else{
          $jsondata['status']  = 1;
          $jsondata['num']  = count($count);
          $jsondata['html']  = $this->fetch("morelist_index");
      }
      $this->ajaxReturn($jsondata,'json');
  }

  public function landlord_info() {
    $hid = I('hid');
    $Hostel=M('Hostel')->where(array('id'=>$hid))->find();
    if($hid==''){
      exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
    }elseif(empty($Hostel)){
      exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
    }else{
      $hosteluid=M("Hostel")->where(array('id'=>$hid))->getField("uid");
      $user=M('Member')->where(array('id'=>$hosteluid))->find();
      $data=array();
      $data['uid'] = $user['id'];
      $data['username'] = $user['username'];
      $data['head'] = $user['head'];
      $data['nickname'] = $user['nickname'];
      $data['phone'] = $user['phone'];
      $data['sex'] = $user['sex'];
      $data['birthday'] = $user['birthday'];
      $data['hometown'] = $user['hometown'];
      $data['area'] = $user['area'];
      $data['education'] = $user['education'];
      $data['school'] = $user['school'];
      $data['zodiac'] = $user['zodiac'];
      $data['constellation'] = $user['constellation'];
      $data['bloodtype'] = $user['bloodtype'];
      $data['realname_status'] = $user['realname_status'];
      $data['houseowner_status'] = $user['houseowner_status'];
      $data['rongyun_token']=$user['rongyun_token'];

      $areas = M('area')->where(array('id' => array('in', $data['area'])))->select();
      $areaStr = '';
      foreach($areas as $area) {
        $areaStr .= $area['name'] . ',';
      }
      $areaStr = substr($areaStr, 0, strlen($areaStr) - 1);
      $this->assign('areas', $areaStr);
      $hostel=M('hostel')
          ->where(array('uid'=>$hosteluid,'status'=>2,'isdel'=>0))
          ->order(array('id'=>'desc'))
          ->field("id,title,thumb,money,area,description,address,lat,lng,hit,support,score as evaluation,scorepercent as evaluationpercent")
          ->select();
      $data['hostel']=!empty($hostel)?$hostel:null;
      
      $replyasknum=M('bookask')->where(array('tuid'=>$hosteluid,'status'=>1))->count();
      $totalasknum=M('bookask')->where(array('tuid'=>$hosteluid))->count();
      $onlinereply=($replyasknum/$totalasknum)*100;
      $data['onlinereply']=!empty($onlinereply)?sprintf("%.2f",$onlinereply):"100.00";

      $evaluationconfirm=M()->query("SELECT AVG(b.sufftime) FROM(SELECT(b.review_time - b.inputtime) / 60 AS sufftime FROM zz_book_room a LEFT JOIN zz_order_time b ON a.orderid = b.orderid LEFT JOIN zz_hostel c ON a.hid = c.id WHERE(b.status = 4)AND (b.review_status > 0)AND (c.uid = ".$hosteluid.")) b");
      $data['evaluationconfirm']=!empty($evaluationconfirm)?sprintf("%.2f",$evaluationconfirm):"0.0";

      $successordernum=M('book_room a')->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_hostel c on a.hid=c.id")->where(array('c.uid'=>$hosteluid,'b.review_status'=>1,'b.status'=>array('not in','1,5')))->count();
      $totalordernum=M('book_room a')->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_hostel c on a.hid=c.id")->where(array('c.uid'=>$hosteluid))->count();
      $orderconfirm=($successordernum/$totalordernum)*100;
      $data['orderconfirm']=!empty($orderconfirm)?sprintf("%.2f",$orderconfirm):"100.00";
      $this->assign('data', $data);
      $this->display(); 
    }
  }

  public function all_map() {
    $Map=A("Api/Map");
    $location=$Map->getlocation();
    if(empty($location)){
        $location=array("x"=>"121.428075","y"=>"31.238356");
    }
    $this->assign("location",$location);
    $uid=session("uid");
    $where=array();
    $hidbox=array();
    $where['a.status']=2;
    $where['a.isdel']=0;
    $where['a.isoff']=0;
    $keyword=I('keyword');
    if(!empty($keyword)){
        $where['a.title|a.description']=array('like',"%".$keyword."%");
    }

    $catid= $_REQUEST['catid'];
    if(!empty($catid)){
        $where['a.catid']=array('in',$catid);
    }

    $area="";
    if(!empty($_GET['province'])&&!empty($_GET['city'])){
        if(!empty($_GET['town'])){
            $area=$_GET['province'] . ',' . $_GET['city'] . ',' . $_GET['town'];
        }else{
            $area=$_GET['province'] . ',' . $_GET['city'];
        }
    }
    if(!empty($area)){
        $where['a.area']=$area;
    }
    $minmoney=I('minmoney');
    $maxmoney=I('maxmoney');
    if(!empty($minmoney)&&!empty($maxmoney)){
        $where['a.money'] = array(array('EGT', $minmoney), array('ELT', $maxmoney));

    }
    $acreage=I('acreage');
    if(!empty($acreage)){
        $acreagebox=explode("|", $acreage);
        if(is_array($acreagebox)&&count($acreagebox)>1){
            if($acreagebox[1]!=0){
                $where['a.acreage'] = array(array('EGT', $acreagebox[0]), array('ELT', $acreagebox[1]));
            }else{
                $where['a.acreage'] = array('EGT', $acreagebox[0]);
            }

        }else{
            $where['a.acreage'] =$acreage;
        }
    }
    $score=I('score');
    if(!empty($score)){
        $where['a.score'] =array('EGT', $score);
    }
    $support=I('support');
    if(!empty($support)){
        $where['a.support']=array('like',"%,".$support.",%");
    }
    $bedtype=I('bedtype');
    if(!empty($bedtype)){
        $where['a.bedtype']=array('like',"%,".$bedtype.",%");
    }
    $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
    $count = M("Hostel a")
        ->join("left join zz_member b on a.uid=b.id")
        ->join("left join {$sqlI} c on a.id=c.value")
        ->where($where)
        ->count();
    $page = new \Think\Page($count,12);
    $page->setConfig("prev","上一页");
    $page->setConfig("next","下一页");
    $page->setConfig("first","第一页");
    $page->setConfig("last","最后一页");
    $data=M("Hostel a")
        ->join("left join zz_member b on a.uid=b.id")
        ->join("left join {$sqlI} c on a.id=c.value")
        ->where($where)->order(array('id'=>"desc"))
        ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
        ->limit($page->firstRow . ',' . $page->listRows)
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
    }
    $show = $page->show();
    $this->assign("data", $data);
    $this->assign("Page", $show);
    $this->assign("hostelnum",$count);
    $pagenum=round($count/16);
    $this->assign("pagenum",$pagenum);
    $this->assign("jsonlist", json_encode($data));
    $this->display();
  }

  public function review() {
    $hid = $_GET['hid'];
    $evaluation=gethouse_evaluation($hid);
    $reviewlist = M('review a')
      ->join('zz_member b on a.uid = b.id')
      ->where(array('a.varname' => 'hostel', 'a.value' => $hid))
      ->field('b.head, b.id, b.nickname, a.content,a.inputtime')
      ->select();
    $this->assign('reviewlist', $reviewlist);
    $this->assign('evaluation', $evaluation);
    $this->display(); 
  }


  public function hotel_list() {
    $city = $_GET['city'];
    $this->assign('city', $city);
    $this->display(); 
  }
}
