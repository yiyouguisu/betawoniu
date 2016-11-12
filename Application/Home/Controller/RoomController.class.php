<?php
namespace Home\Controller;
use Home\Common\CommonController;

class RoomController extends CommonController {

    public function show(){
        $id=I('id');
        $uid=session("uid");

        if($id==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("Room a")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->join("left join zz_hostel b on a.hid=b.id")
            ->join("left join zz_bedcate d on a.roomtype=d.id")
            ->where(array('a.id'=>$id))
            ->field('a.id as rid,a.hid,a.title,a.thumb,a.hit,a.area,a.nomal_money,a.week_money,a.holiday_money,a.money,a.imglist,a.mannum,a.support,a.conveniences,a.bathroom,a.media,a.food,a.mannum,a.content,a.score as evaluation,a.scorepercent as evaluationpercent,a.inputtime,c.reviewnum,b.title as hostel,b.area as hostelarea,b.address as hosteladdress,b.lat,b.lng,d.catname as bedtype')
            ->find();
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            $imglist=explode("|", $data['imglist']);
        	$this->assign("imglist", $imglist);
            $support=M("roomcate")->where(array('id'=>array('in',$data['support'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        	$this->assign("support", $support);
            $data['support']=M("roomcate")->where(array('ishot'=>1,'id'=>array('in',$data['support'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
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
            $note_hostel=M('tags_content a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.varname'=>'hostel','a.contentid'=>$data['hid'],'a.type'=>'hostel'))->field("a.title,a.hid,a.place,b.city,'hostel' as type")->find();
            $data['note_hostel']=!empty($note_hostel)?$note_hostel:null;
            //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'room'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->select();
            //$data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
            $bookdate=getmonth();
            foreach ($bookdate as $key => $value) {
                # code...
                $bookdate[$key]['price']=$data['nomal_money'];
                $week=date("w",$value['value']);
                if(in_array($week, array(0,6))) {
                    $bookdate[$key]['isweek']=1;
                    $bookdate[$key]['price']=$data['week_money'];
                }else{
                    $bookdate[$key]['isweek']=0;
                }
                $holiday=M('holiday')->where(array('status'=>1,'_string'=>$value['value']." <= enddate and ".$value['value']." >= startdate"))->field("id,name,days")->find();
                if(!empty($holiday)){
                    $bookdate[$key]['isholiday']=1;
                    $bookdate[$key]['holiday']=$holiday;
                    $bookdate[$key]['price']=$data['holiday_money'];
                }else{
                    $bookdate[$key]['isholiday']=0;
                }

                $booknum=M('book_room')->where(array('_string'=>$value['value']." <= endtime and ".$value['value']." >= starttime","id"=>$id))->sum('num');
                if($booknum>=$data['mannum']){
                    $bookdate[$key]['isgone']=1;
                }elseif($booknum<$data['mannum']){
                    $bookdate[$key]['isgone']=0;
                    $bookdate[$key]['wait_num']=$data['mannum']-$booknum;
                }
                $book_status=M('book_room a')->join("left join zz_order_time b on a.orderid=b.orderid")->where(array('_string'=>$value['value']." <= a.endtime and ".$value['value']." >= a.starttime",'a.uid'=>$uid,'a.rid'=>$id,'b.status'=>4))->find();
                if(!empty($book_status)){
                    $bookdate[$key]['isbook']=1;
                }else{
                    $bookdate[$key]['isbook']=0;
                }
            }

            $jsonlist="[";
            foreach ($bookdate as $key => $value) {
                # code...
                $str="";
                if($key==0){
                    if($value['isbook']==1){
                        $str="{title: '已定',start: \"".$value['name']."\",constraint: 'businessHours',}";
                    }else{
                        if($value['isgone']==1){
                            $str="{title: '定完',start: \"".$value['name']."\",constraint: 'businessHours',}";
                        }else{
                            $str="{title: '剩".$value['wait_num']."间 ￥".$value['price']."',start: \"".$value['name']."\",constraint: 'businessHours',}";
                        }
                    }
                }else{
                    if($value['isbook']==1){
                        $str=",{title: '已定',start: \"".$value['name']."\",constraint: 'businessHours',}";
                    }else{
                        if($value['isgone']==1){
                            $str=",{title: '定完',start: \"".$value['name']."\",constraint: 'businessHours',}";
                        }else{
                            $str=",{title: '剩".$value['wait_num']."间 ￥".$value['price']."',start: \"".$value['name']."\",constraint: 'businessHours',}";
                        }
                    }
                }

                $jsonlist.=$str;
            }
            $jsonlist.="]";
            
            $data['jsonlist']=!empty($jsonlist)?$jsonlist:null;

            $where=array();
	        $where['a.status']=2;
	        $where['a.type']=1;
	        $where['a.isdel']=0;
            $where['a.isoff']=0;

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
            $where['a.isoff']=0;

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
	            $distance=$Map->get_distance_baidu("driving",$data['lat'].",".$data['lng'],$value['lat'].",".$value['lng']);
	            $house_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
	        }
	        $data['house_near_hostel']=!empty($house_near_hostel)?$house_near_hostel:null;
            $this->assign("data",$data);
            $this->display();
        }
    }
    public function get_review(){
        $ret=$_GET;
        $rid=intval(trim($ret['rid']));

        if($rid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$rid;
            $where['a.isdel']=0;
            $where['a.varname']='room';
            $count=M('review a')
                  ->join("left join zz_member b on a.uid=b.id")
                  ->where($where)
                  ->count();
            $page = new \Think\Page($count,10);
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order($order)
                ->field('a.id as rid,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token,a.evaluation,a.evaluationpercent')
                ->limit($page->firstRow . ',' . $page->listRows)->select();
            $this->assign("reviewdata",$list);
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            $this->assign("totalpages", ceil($count/10));
            $this->assign("totalrows", $count);
            $jsondata['html']  = $this->fetch("review");
            $this->ajaxReturn($jsondata,'json');
            
        }
    }
    public function ajax_hit(){
        if(IS_POST){
            $rid=$_POST['rid'];
            $where['uid']=session("uid");
            $where['varname']='room';
            $where['value']=$rid;
            $num=M('hit')->where($where)->count();
            $Room=M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.uid")->find();
            if($num==0){
                $where['inputtime']=time();
                M('room')->where('id=' . $rid)->setInc('hit');
                $id=M('hit')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($Room['uid'],"房间点赞","您的房间(".$Room['title'].")获得1个赞","您的房间(".$Room['title'].")获得1个赞","roomhit",$Room['id']);
                    $data['status']=1;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }else{
                    $data['status']=0;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }
            }else{
                M('room')->where('id=' . $rid)->setDec('hit');
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
            $rid=$_POST['rid'];
            $where['uid']=session("uid");
            $where['varname']='room';
            $where['value']=$rid;
            $num=M('collect')->where($where)->count();
            $Room=M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id'=>$rid))->field("a.*,b.uid")->find();
            if($num==0){
                $where['inputtime']=time();
                $id=M('collect')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($Room['uid'],"房间收藏","您的房间(".$Room['title'].")被其他用户收藏了","您的房间(".$Room['title'].")被其他用户收藏了","roomcollect",$Room['id']);
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
    public function ajax_checkdate(){
        $rid=$_POST['rid'];
        $starttime=strtotime($_POST['starttime']);
        $endtime=strtotime($_POST['endtime']);
        $roomnum=intval($_POST['roomnum']);
        
        $data=M('room')->where(array('id'=>$rid))->find();

        
        $totalmoney=$money=0.00;
        $isgone=0;
        $weeknum=$holidaynum=$nomalnum=$flag=0;
        while ( $starttime < $endtime) {
            # code...
            $money=$data['nomal_money'];
            $week=date("w",$starttime);
            if(in_array($week, array(0,6))) {
                $money=$data['week_money'];
                $flag=1;
            }
            $holiday=M('holiday')->where(array('status'=>1,'_string'=>$starttime." <= enddate and ".$starttime." >= startdate"))->field("id,name,days")->find();
            if(!empty($holiday)){
                $money=$data['holiday_money'];
                $flag=2;
            }

            $booknum=M('book_room')->where(array('_string'=>$starttime." <= endtime and ".$starttime." >= starttime","id"=>rid))->sum('num');
            if($booknum>=$data['mannum']){
                $isgone=1;
                break;
            }
            if($flag==0){
                $nomalnum++;
            }elseif($flag==1){
                $weeknum++;
            }elseif($flag==2){
                $holidaynum++;
            }
            $totalmoney+=$money;
            $starttime=strtotime("+1 days",$starttime);
        }
        if($isgone==1){
            $this->ajaxReturn(array('code'=>-200),'json');  
        }else{
            $totalmoney=$totalmoney*$roomnum;
            $totalmoney=sprintf("%.2f",$totalmoney);
            $this->ajaxReturn(array('code'=>200,'totalmoney'=>$totalmoney,'nomalnum'=>$nomalnum,'weeknum'=>$weeknum,'holidaynum'=>$holidaynum),'json');  
        }
              
    }
    public function ajax_getdate(){
        $id=I('rid');
        $data=M("Room")->where(array('id'=>$id))->find();
        $bookdate=getmonth();
        foreach ($bookdate as $key => $value) {
            # code...
            $bookdate[$key]['price']=$data['nomal_money'];
            $week=date("w",$value['value']);
            if(in_array($week, array(0,6))) {
                $bookdate[$key]['isweek']=1;
                $bookdate[$key]['price']=$data['week_money'];
            }else{
                $bookdate[$key]['isweek']=0;
            }
            $holiday=M('holiday')->where(array('status'=>1,'_string'=>$value['value']." <= enddate and ".$value['value']." >= startdate"))->field("id,name,days")->find();
            if(!empty($holiday)){
                $bookdate[$key]['isholiday']=1;
                $bookdate[$key]['holiday']=$holiday;
                $bookdate[$key]['price']=$data['holiday_money'];
            }else{
                $bookdate[$key]['isholiday']=0;
            }

            $booknum=M('book_room')->where(array('_string'=>$value['value']." <= endtime and ".$value['value']." >= starttime"))->sum('num');
            if($booknum>=$data['mannum']){
                $bookdate[$key]['isgone']=1;
            }elseif($booknum<$data['mannum']){
                $bookdate[$key]['isgone']=0;
                $bookdate[$key]['wait_num']=$data['mannum']-$booknum;
            }
            $book_status=M('book_room')->where(array('_string'=>$value['value']." <= endtime and ".$value['value']." >= starttime",'uid'=>$uid,'rid'=>$id))->find();
            if(!empty($book_status)){
                $bookdate[$key]['isbook']=1;
            }else{
                $bookdate[$key]['isbook']=0;
            }
        }


        $output=array();
        foreach ($bookdate as $value) {
            # code...
            if($value['isbook']==1){
                $output[]=array('title'=>'已定','start'=>$value['name'],'constraint'=>'businessHours');
            }else{
                if($value['isgone']==1){
                    $output[]=array('title'=>'定完','start'=>$value['name'],'constraint'=>'businessHours');
                }else{
                    $output[]=array('title'=>"剩".$value['wait_num']."间 ￥".$value['price'],'start'=>$value['name'],'constraint'=>'businessHours');
                }
            }
            
        }
        
        
        echo json_encode($output);
    }
}