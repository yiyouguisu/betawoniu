<?php

namespace Web\Controller;

use Web\Common\CommonController;

class WoniuController extends CommonController {

    public function _initialize(){
    	parent::_initialize();
      if(!session('uid')) {
        return $this->redirect('Member/wxlogin');
      }
      Vendor("pingpp.init");
      $ConfigData=F("web_config");
      if(!$ConfigData){
          $ConfigData=D("Config")->order(array('id'=>'desc'))->select();
          F("web_config",$ConfigData);
      }
      $this->ConfigData=$ConfigData;
      $this->assign('WONIUCTRL', 'true');
    }
	
    public function index(){
      if (!session('uid')) {
        $this->redirect('Web/Member/login');
      } else {
        $uid=session("uid");
        $uids=M('attention')->where(array('fuid'=>$uid))->getField("tuid",true);
        $count=M('attention a')->join("left join zz_member b on a.fuid=b.id")->where(array('a.tuid'=>$uid,'a.fuid'=>array('in',$uids)))->count();
        $data=M('attention a')
          ->join("left join zz_member b on a.fuid=b.id")
          ->where(array('a.tuid'=>$uid,'a.fuid'=>array('in',$uids)))
          ->field('b.id as uid,b.nickname,b.head,b.info,b.area,b.rongyun_token')
          ->select();
        foreach ($data as $key => $value) {
          $data[$key]['fansnum']=M('attention')->where('tuid=' . $value['uid'])->count();
          $data[$key]['attentionnum']=M('attention')->where('fuid=' . $value['uid'])->count();
          $lastMessage = M('thirdmessage_log')
            ->where(array(
              'fromUserId' => $uid,
              'toUserId' => $value['uid'],
              '_logic' => 'OR'
            ))
            ->order('id desc')
            ->limit(1)
            ->find();
          $time = '';
          if($lastMessage) {
            if($lastMessage['inputtime'] > strtotime(date('Y-m-d'))) {
              $time = date('H:i:s', $lastMessage['inputtime']);
            } else {
              $time = date('Y-m-d', $lastMessage['inputtime']);
            }
          }
          $data[$key]['last_time'] = $time;
        }
        $data=!empty($data)?$data:null;
        $this->assign("data",$data);
        $this->assign("totalnum",$count);
        $this->display();
      }
    }
    
    public function message(){
    	if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
        	$uid=session("uid");
        	$count = M("message")->where(array('r_id'=>$uid,'isdel'=>'0'))->count();
          /*
	        $page = new \Think\Page($count,6);
	        $page->setConfig("prev","上一页");
	        $page->setConfig("next","下一页");
	        $page->setConfig("first","第一页");
	        $page->setConfig("last","最后一页");
          */
          $data=M("message")
            ->where(array('r_id'=>$uid,'isdel'=>'0'))
            ->order(array('id'=>"desc"))
            ->field("id,title,content,status,varname,value,inputtime")
           // ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
          $this->assign('data',$data);
	    	$this->display();
	    }
    }

    public function chat(){
      if (!session('uid')) {
          $this->redirect('Home/Member/login');
      } else {
        $ids = session('targetIds');
        $members = M('member')
          ->where(array('id' => array('in', $ids)))
          ->select();
        $this->assign('members', $members);
        $this->display();
      }
    }

    public function get_user_info(){
        $uids=I('post.uids');
        // 组合where数组条件
        $map=array(
            'id'=>array('in',$uids)
            );
        $data=M('member')
            ->field('id,nickname,head,rongyun_token')
            ->where($map)
            ->select();
        foreach ($data as $key => $value) {
            # code...
            $data[$key]['showurl']=U('Home/Member/detail',array('uid'=>$value['id']));
        }
        $this->ajaxReturn($data,'json');
    }

    public function chatdetail(){
        if (!session('uid')) {
            $this->redirect('Home/Member/login');
        } else {
            $tuid=I('tuid');
            $user_data=M('Member')->field('id,nickname,head,rongyun_token')->find($tuid);
            $data=array(
                'id'=>$user_data['id'], // 用户id
                'head'=>$user_data['head'],// 头像
                'nickname'=>$user_data['nickname'],// 用户名
                'rong_key'=>"cpj2xarljz3ln",// 融云key
                'rong_token'=>$user_data['rongyun_token']//获取融云token
                );
            $this->assign('data',$data);
            $this->display();
        }
    }

    public function moreFriends() {
      $where=array();
      $where['a.status']=1;
      $Map=A("Api/Map");

      //获取当前坐标
      $location=$Map->getlocation();
      if(empty($location)){
          $location=array("x"=>"121.428075","y"=>"31.238356");
      }
      $this->assign("location",$location);
      $recoords=getcoords($location['y'],$location['x'],5);
      $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
      $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
      $data=M("member a")
          ->where($where)
          ->order(array('a.id'=>"desc"))
          ->field('a.id as uid,a.nickname,a.head,a.lat,a.lng')
          ->select();
      foreach ($data as $key => $value) {
          # code...
          $data[$key]['url']=U('Web/Member/detail',array('uid',$value['uid']));
      }
      $josnlist=json_encode($data);
      $this->assign("data",$josnlist);
      $this->display();
    }
}
