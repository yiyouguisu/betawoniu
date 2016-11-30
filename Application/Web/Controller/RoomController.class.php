<?php
namespace Web\Controller;
use Web\Common\CommonController;

class RoomController extends CommonController {
	
    public function show(){
        $id=I('id');
        $hid=I('hid');
        $uid=session("uid");
        $this->assign('uid', $uid);
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Room a")
        ->join("left join {$sqlI} c on a.id=c.value")
        ->join("left join zz_hostel b on a.hid=b.id")
        ->join("left join zz_bedcate d on a.roomtype=d.id")
        ->where(array('a.id'=>$id))
        ->field('a.id as rid,a.hid,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.imglist,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.inputtime,c.reviewnum,b.title as hostel,b.area as hostelarea,b.address as hosteladdress,b.lat,b.lng,d.catname as bedtype, b.uid as oid')
        ->find();

        if($data['oid'] == session('uid')) {
          $data['is_owner'] = 1;
        }

        if(empty($data['reviewnum'])) $data['reviewnum']=0;
        $imglist=explode("|", $data['imglist']);
        $this->assign("imglist", $imglist);
        $support=M("roomcate")->where(array('id'=>array('in',$data['support'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("support", $support);
        
        cookie('days', null);
        cookie('room_num', null);
        cookie('start_time', null);
        cookie('end_time', null);
        $data['support']=M("roomcate")->where(array('id'=>array('in',$data['support'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();

        $data['evaluation']=!empty($evaluation['evaluation'])?$evaluation['evaluation']:0.0;
        $data['evaluationpercent']=!empty($evaluation['percent'])?$evaluation['percent']:0.00;

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

    public function app_show() {
    	$id=I('id');
        $data=M("room")->where(array('id'=>$id))->find();
        $this->assign("data",$data);
        $this->display();
    }
}
