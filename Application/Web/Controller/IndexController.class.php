<?php
namespace Web\Controller;
use Web\Common\CommonController;

class IndexController extends CommonController {

    public function _initialize() {
      $this->assign('INDEXCTRL', true);
    }
    
    public function index() {
        $uid=session('uid');
        $user['id'] = $uid;
        $this->assign("user",$user);
        $_GET['city'] ? session('city', $_GET['city']) : NULL;
        $city=session('city');
        $lat=cookie('lat');
        $lng=cookie('lng');

        $where=array();
        if(!empty($city)){
            $where['a.city']=$city;
        }
        $where['a.status']=2;
        $where['a.isindex']=1;
        $where['a.isdel']=0;
        $where['a.isoff']=0;
        $sqlI=M('review')
          ->where(array('isdel'=>0,'varname'=>'note'))
          ->group("value")
          ->field("value,count(value) as reviewnum")
          ->buildSql();
        $note=M("Note a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>'desc'))
            ->field('a.id,a.title,a.description,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,a.type,c.reviewnum')
            ->limit(5)
            ->select();
        foreach ($note as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $note[$key]['reviewnum']=0;
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $note[$key]['iscollect']=1;
            }else{
                $note[$key]['iscollect']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $note[$key]['ishit']=1;
            }else{
                $note[$key]['ishit']=0;
            }
        }
        $sqlII=M('review')->where(array('isdel'=>0,'varname'=>'party'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $party=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlII} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit(5)
            ->select();
        foreach ($party as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $party[$key]['reviewnum']=0;
            $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
            $party[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->limit(5)->select();
            $party[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
            $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
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
        $sqlIII=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $house=M("hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlIII} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit(5)
            ->select();
        $Map=A("Api/Map");
        foreach ($house as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $house[$key]['reviewnum']=0;
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $house[$key]['iscollect']=1;
            }else{
                $house[$key]['iscollect']=0;
            }
            $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            $house[$key]['distance']=!empty($distance)?$distance:0.00;
            $evaluation=gethouse_evaluation($value['id']);
            $house[$key]['evaluation']=!empty($evaluation['evaluation'])?$evaluation['evaluation']:0.0;
            $house[$key]['evaluationpercent']=!empty($evaluation['percent'])?$evaluation['percent']:0.00;
        }
        $data=array("note"=>$note,'party'=>$party,'house'=>$house);
        $this->assign('data',$data);
        $this->assign('city', getCityInfo(session('city')));
        $ad=M("ad")->where(array('status'=>1,'catid'=>4))
            ->order(array('listorder'=>"desc",'id'=>"desc"))
            ->field('id,title,image,hid,aid,nid,url,type,content,description,inputtime')
            ->select();
        $this->assign('ad',$ad);
        $this->display();
    }
    public function cacheposition(){
        $Map=A('Api/Map');
        $ad=$_POST['position'];
        $res=$Map->geoconv($ad);
        cookie('lng',$res[0]['x']);
        cookie('lat',$res[0]['y']);
        $pos = array('lng' => $res[0]['x'], 'lat' => $res[0]['y']);
        $this->ajaxReturn(json_encode($pos),'json');
    }

    public function search() {
    
      $this->display(); 
    }
}
