<?php

namespace Web\Controller;

use Web\Common\CommonController;

class TravelController extends CommonController {

	public function index() {
		$sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
		// print_r($sqlI);
		// die;
		$dataArray=M('note a')
			->join("left join zz_member b on a.uid=b.id")
			->join("left join {$sqlI} c on c.value=a.id")
			->where(array('a.status'=>2,'a.type'=>1))->order(array('a.inputtime'=>'desc'))
            ->field('a.id,a.thumb,a.title,a.begintime,b.head,b.id uid,c.reviewnum,a.hit,a.description')
            ->select();
		// echo M('note a')->getlastsql();		
		// die;
		$areaArray=M('area')->where(array('parentid'=>0))->select();
		$this->assign("areaArray",$areaArray);
        foreach ($dataArray as $key => $value) {
            if(mb_strlen($value['description'],'utf-8')>50){
                $value['description']=mb_substr($value['description'],0,50,'utf-8');
                $dataArray[$key]['description']=$value['description'].'...';
            }
        }
		$this->assign("dataArray", $dataArray);

        $this->display();
    }
    public function show() {
    	$id=$_GET['id'];
        $uid=session("uid");

        $data=$this->getdata($id);
        // 收藏
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$id))->find();
        !empty($collectstatus)?$data['iscollect']=1:$data['iscollect']=0;
        // 点赞
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$id))->find();
        !empty($hitstatus)?$data['ishit']=1:$data['ishit']=0;
        // print_r($data['iscollect']);
        // print_r($data['ishit']);
        $contentlist=json_decode($data['imglist']);
		$comment=M('review r')
		->join("left join zz_member b on r.uid=b.id")
		->where(array('r.value'=>$id))->select();
        // foreach ($contentlist as $key => $value) {
        //     print_r($value->content);
        // }
        // foreach ($contentlist as $key => $value) {
        //     $contentlist[$key]=(array)$value;
        // }
        // $contentlist=json_decode($data['imglist'],ture);
        // print_r($contentlist);
        // $this->assign("content",$contentlist);
        $data['imglist']=json_decode($data['imglist'],ture);
		$this->assign("comment",$comment);
		$this->assign("data",$data);
        $this->assign("id",$id);
        $this->display();

    }
    public function turntable(){
        $gift= M('gift')->where(array('rank'=>array('neq',6)))->field('id,rank,prize')->order(array('id'=>asc))->select();
        $this->assign("gift",$gift);

        $turntablerule=M('config')->where(array('varname'=>'turntablerule'))->getField("value");
        $this->assign("turntablerule", $turntablerule);
        $this->display();
    }
    public function turntablelog(){
        $where['rid']=array('neq',6);
        $count = D("Choujianglog")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $data = D("Choujianglog")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["prize"] = M('gift')->where('rank=' . $r['rid'])->getField("prize");
            $data[$k]['validity_starttime']=M('Coupons')->where('id=' . $r['rid'])->getField("validity_starttime");
            $data[$k]['validity_endtime']=M('Coupons')->where('id=' . $r['rid'])->getField("validity_endtime");
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        if($_GET['isAjax']==1){
            $this->display("morelist_log");
        }else{
            $this->display();
        }
    }

    public function ajaxcity(){
    	$id=$_POST['id'];
    	$cityarray=M('area')->where(array('parentid'=>$id))->select();
    	if(count($cityarray)<=0){
    		$cityarray=M('area')->where(array('id'=>$id))->select();
    	}
    	$this->ajaxReturn($cityarray,'json');
    }

    public function select(){
   		if(!empty($_POST['month']) && $_POST['month']!=0){
			$where['_string'] = "month(FROM_UNIXTIME( a.inputtime )) = ".$_POST['month'];
		}
		if(!empty($_POST['city'])){
			$where['a.city']=$_POST['city'];
		}
		if(!empty($_POST['order']) && $_POST['order']!=0){
			if($_POST['order']==1){
				$order=array('a.inputtime'=>'desc');
			}
			else{
				$order=array('c.reviewnum'=>'desc');
			}
		}

		$sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
		// print_r($sqlI);
		// die;
		$dataArray=M('note a')
			->join("left join zz_member b on a.uid=b.id")
			->join("left join {$sqlI} c on c.value=a.id")
			->where($where)->order($order)
            ->field('a.id,a.thumb,a.title,a.begintime,b.head,b.id uid,c.reviewnum,a.hit,a.description')
            ->select();
		if(count($dataArray)<=0){
    		$dataArray=array('code'=>500,'msg'=>'无记录');
    	}
    	$dataArray[0]['begintime']=date('Y-m-d',$dataArray[0]['begintime']);
    	// $dataArray['begintime']=date('Y-m-d',$dataArray['begintime']);
		$this->ajaxReturn($dataArray,'json');

    }
    // 民宿推荐
    public function acc(){

        $date=$this->getdata($_POST['id']);
        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        // 名宿
        $note_near_hostel=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit(4)
            ->select();
        $Map=A("Api/Map");
        foreach ($note_near_hostel as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $note_near_hostel[$key]['reviewnum']=0;
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $note_near_hostel[$key]['ishit']=1;
            }else{
                $note_near_hostel[$key]['ishit']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $note_near_hostel[$key]['iscollect']=1;
            }else{
                $note_near_hostel[$key]['iscollect']=0;
            }
            $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            $note_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        $this->ajaxReturn($note_near_hostel,'json');
    }

    // 活动推荐
    public function act(){

        
        $date=$this->getdata($_POST['id']);
        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;

        // $recoords=getcoords($data['lat'],$data['lng'],2);
        // $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        // $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
        $note_near_activity=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
            ->limit(4)
            ->select();
        foreach ($note_near_activity as $key => $value) {
            # code...
            $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
            $note_near_activity[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
            $note_near_activity[$key]['joinlist']=!empty($joinlist)?$joinlist:"";
            $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid))->find();
            if(!empty($joinstatus)){
                $note_near_activity[$key]['isjoin']=1;
            }else{
                $note_near_activity[$key]['isjoin']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $note_near_activity[$key]['ishit']=1;
            }else{
                $note_near_activity[$key]['ishit']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $note_near_activity[$key]['iscollect']=1;
            }else{
                $note_near_activity[$key]['iscollect']=0;
            }
            $note_near_activity[$key]['starttime']=date('Y-m-d',$note_near_activity[0]['starttime']);;
            $note_near_activity[$key]['endtime']=date('Y-m-d',$note_near_activity[0]['endtime']);;
        }
        $this->ajaxReturn($note_near_activity,'json');
    }
    public function getdata($id){
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        // die;
        $data=M('note a')
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on c.value=a.id")
            ->join('left join zz_noteman c on a.man=c.id')
            ->join('left join zz_notestyle d on a.style=d.id')
            ->where(array('a.id'=>$id))
            ->order(array('a.inputtime'=>'desc'))
            ->field('a.id nid,a.title,a.imglist,a.inputtime,a.fee,a.thumb athumb,a.begintime,a.days,a.hit,c.catname nmame,d.catname dname,b.nickname,b.head')
            ->find();
            // echo M('note a')->getlastsql();
            // die;
            // print_r(M('note a')->getlastsql());
            // die;
        return $data;
    }


    public function show1() {
        $id=$_GET['id'];
        $uid=session("uid");

        $data=$this->getdata($id);
        // 收藏
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$id))->find();
        !empty($collectstatus)?$data['iscollect']=1:$data['iscollect']=0;
        // 点赞
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$id))->find();
        !empty($hitstatus)?$data['ishit']=1:$data['ishit']=0;
        // print_r($data['iscollect']);
        // print_r($data['ishit']);
        $contentlist=json_decode($data['imglist']);
        $comment=M('review r')
        ->join("left join zz_member b on r.uid=b.id")
        ->where(array('r.value'=>$data['value']))->select();
        // print_r($data);
        // die;
        // foreach ($contentlist as $key => $value) {
        //     print_r($value->content);
        // }
        // foreach ($contentlist as $key => $value) {
        //     $contentlist[$key]=(array)$value;
        // }
        // $contentlist=json_decode($data['imglist'],ture);
        // print_r($contentlist);
        // $this->assign("content",$contentlist);
        $data['imglist']=json_decode($data['imglist'],ture);
        $this->assign("comment",$comment);
        $this->assign("data",$data);
        $this->assign("id",$id);
        $this->display();

    }
}