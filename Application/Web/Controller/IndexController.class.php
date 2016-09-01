<?php
namespace Web\Controller;
use Web\Common\CommonController;

class IndexController extends CommonController {
    public function _initialize() {
      parent::_initialize();
      $this->cart_total_num();
    }
    
    public function index() {
      // 游记
      $uid=session('uid');
      $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
      $notedate=M('note a')
      ->join("left join zz_member b on a.uid=b.id")
      ->join("left join {$sqlI} c on c.value=a.id")
      ->where(array('a.status'=>2,'a.type'=>1,'a.isindex'=>1))->order(array('a.inputtime'=>'desc'))
      ->field('a.id,a.thumb,a.title,a.begintime,b.head,b.id uid,c.reviewnum,a.hit')
      ->select();
      foreach ($notedate as $key => $value) {
          $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
          if(!empty($collectstatus)){
              $notedate[$key]['iscollect']=1;
          }else{
              $notedate[$key]['iscollect']=0;
          }
          $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
          if(!empty($hitstatus)){
              $notedate[$key]['ishit']=1;
          }else{
              $notedate[$key]['ishit']=0;
          }
      }
      // print_r($notedate);
      // die;

      // 活动
      $party = M("Activity a")
      ->join("left join zz_member b on a.uid=b.id")
      ->join("left join {$sqlI} c on a.id=c.value")
      ->where(array('a.status'=>2,'a.type'=>1,'a.isindex'=>1))
      ->order(array('a.inputtime'=>'desc'))
      ->field('a.id,a.title,a.thumb,a.address,a.hit,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.id uid,c.reviewnum')
      ->select();
      foreach ($party as $key => $value) {
          if(empty($value['reviewnum'])) $party[$key]['reviewnum']=0;
          $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
          $party[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
          $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->select();
          $party[$key]['joinlist']=!empty($joinlist)?$joinlist:"";
          $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid))->find();
          if(!empty($joinstatus)){
              $party[$key]['isjoin']=1;
          }else{
              $party[$key]['isjoin']=0;
          }
          $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
          if(!empty($collectstatus)){
              $party[$key]['iscollect']=1;
          }else{
              $party[$key]['iscollect']=0;
          }
          $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
          if(!empty($hitstatus)){
              $party[$key]['ishit']=1;
          }else{
              $party[$key]['ishit']=0;
          }
      }
      // 名宿
      $hsqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
      $hdata=M("Hostel a")
      ->join("left join zz_member b on a.uid=b.id")
      ->join("left join {$hsqlI} c on a.id=c.value")
      ->where(array('a.status'=>2,'a.type'=>1,'a.isindex'=>1))->order(array('id'=>"desc"))
      ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.id uid,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
      ->select();
      $Map=A("Api/Map");
      foreach ($hdata as $key => $value) {
          # code...
          if(empty($value['reviewnum'])) $hdata[$key]['reviewnum']=0;
          $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
          if(!empty($hitstatus)){
              $hdata[$key]['ishit']=1;
          }else{
              $hdata[$key]['ishit']=0;
          }
          // 经度
          $lat=cookie('longitude');
          // 纬度
          $lng=cookie('latitude');
          $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
          $hdata[$key]['distance']=!empty($distance)?$distance:0.00;
           $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
          if(!empty($collectstatus)){
              $hdata[$key]['iscollect']=1;
          }else{
              $hdata[$key]['iscollect']=0;
          }
      }
      // print_r($hdata);
      // foreach ($hdata as $key => $value) {
      //   print_r($value);
      //   die;
      // }
      // die;
      $this->assign('party',$party);
      $this->assign('notedate',$notedate);
      $this->assign('hotel',$hdata);
      $Advertisement=M("ad")->where(array('status'=>1,'catid'=>4))
      ->order(array('listorder'=>"desc",'id'=>"desc"))
      ->field('id,title,image,hid,aid,nid,url,type,content,description,inputtime')
      ->select();
      $this->assign('Advertisement',$Advertisement);
      $this->display();
    }
    
    public function getstore(){
        $lat = $_REQUEST['lat'];
        $lng = $_REQUEST['lng'];
    	//没正式进入微信状态这段代码注释掉
    	cookie("lng",$lng);
        cookie("lat",$lat);
    	$Map=A("Api/Map");
        $areadata=$Map->get_areainfo_baidu_simple($lat.",".$lng);
        $storeid=session('storeid');
        if (!$storeid)
        {
            $data=M('store')->where(array('servicearea'=>array('like','%,'.$areadata['district'].',%')))->field('id as storeid,title as storename')->find();
        }else
        {
            $data=M('store')->where('id='.$storeid)->field('id as storeid,title as storename')->find();
        }
        $data['sql']=M('store')->_sql();
    	//cookie("storeid",$data['storeid'],43200);
    	$this->ajaxReturn($data);
    }


    public function view(){
        $id=I('get.id');
        $data = M('ad')->where('id='.$id)->find();
        $this->assign('data',$data);
        $this->display();
    }
    
    public function sendview(){
        $id=I('get.id');
        $data = M('ad')->where('id='.$id)->find();
        $this->assign('data',$data);
        $this->display();
    }

    public function pushview(){
        $id=I('get.id');
        $data = M('push')->where('id='.$id)->find();
        $this->assign('data',$data);
        $this->display();
    }
    public function latitude_longitude(){
        $Map=A('Api/Map');
        $ad=$_POST['ad'];
        $res=$Map->geoconv($ad);
        // print_r($res[0]['x']);
        // print_r($res[0]['y']);
        // 经度
        cookie('longitude',$res[0]['x']);
        // 纬度
        cookie('latitude',$res[0]['y']);
        $this->ajaxReturn(json_encode($res),'json');
    }
}