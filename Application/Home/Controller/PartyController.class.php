<?php
namespace Home\Controller;
use Home\Common\CommonController;

class PartyController extends CommonController {

    public function index() {
    	$uid=session("uid");
        $where=array();
        $order=array();
    	$type=I('type',0,'intval');
    	if(!empty($type)){
    		if($type==1) $order=array('a.hit'=>'desc');
    		if($type==2) $order=array('a.id'=>'desc');
    	}else{
    		$order=array("a.listorder" => "desc","a.id" => "desc");
    	}
    	$keyword=I('keyword');
    	if(!empty($keyword)){
    		$where['a.title|a.description']=array('like',"%".$keyword."%");
    	}
        $starttime = I('get.starttime');
        if (!empty($starttime)) {
            $starttime = strtotime($starttime);
            $where["a.starttime"] = array("EGT", $starttime);
        }
        //添加结束时间
        $endtime = I('get.endtime');
        if (!empty($endtime)) {
            $endtime = strtotime($endtime);
            $where["a.endtime"] = array("ELT", $endtime);
        }
    	$catid=I('catid');
    	if(!empty($catid)){
            $where['a.catid']=$catid;
        }
        $partytype=I('partytype');
        if(!empty($partytype)){
            $where['a.partytype']=$partytype;
        }
        $area="";
        if(!empty($_GET['province'])){
            if(!empty($_GET['city'])){
                if(!empty($_GET['town'])){
                    $area=$_GET['province'] . ',' . $_GET['city'] . ',' . $_GET['town'];
                }else{
                    $area=$_GET['province'] . ',' . $_GET['city'];
                } 
            }else{
                $where['a.area']=array('like',$_GET['province'] . ','."%");
            }
        }
        if(!empty($area)){
            $where['a.area']=$area;
        }
        $city=I('city');
        if(isset($_GET['province'])&&in_array($_GET['province'],array(2,3,4,5))){
            $city=$_GET['province'];
        }
        if(!empty($city)){
            $where['a.city'] =$city;
        }
        $minmoney=I('minmoney');
        $maxmoney=I('maxmoney');
        if($minmoney!=null&&$maxmoney!=null){
            $where['a.money'] = array(array('EGT', $minmoney), array('ELT', $maxmoney));
            
        }
        $where['a.status']=2;
        $where['a.isdel']=0;
        $where['a.isoff']=0;

        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'party'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $count = M("Activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->count();
        $page = new \Think\Page($count,6);
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $party = M("Activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
		        ->limit($page->firstRow . ',' . $page->listRows)
		        ->order($order)
		        ->field('a.id,a.title,a.thumb,a.description,a.area,a.city,a.address,a.lat,a.lng,a.hit,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,a.type,c.reviewnum')
		        ->select();
		foreach ($party as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $party[$key]['reviewnum']=0;
            //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$value['id'],'a.isdel'=>0,'a.varname'=>'party'))->field("a.id as vid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->select();
            //$party[$key]['reviewlist']=!empty($reviewlist)?$reviewlist:"";
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
        }
        $show = $page->show();
        $this->assign("party", $party);
        $this->assign("Page", $show);

        $partycate=M("partycate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("partycate",$partycate);

        $ad=M('ad')->where(array('catid'=>13))->order(array("listorder" => "desc","id" => "desc"))->select();
        $this->assign("ad", $ad);

        $where=array();
        $where['a.status']=2;
        $where['a.isdel']=0;
        $where['a.isoff']=0;
        $hotnote=M("note a")
        		->join("left join zz_member b on a.uid=b.id")
        		->where($where)
        		->order(array("a.hit" => "desc","a.listorder" => "desc","a.id" => "desc"))
        		->limit(4)
        		->field('a.id,a.title,a.thumb,a.description,a.area,a.address,a.lat,a.lng,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
        		->select();
		$this->assign("hotnote", $hotnote);
        $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
        $this->assign('province',$province);
        $this->display();
    }
    public function getchildren() {
        $parentid = $_GET['parentid'];
        $result = M("area")->where(array("parentid" => $parentid,'status'=>1))->select();
        $result = json_encode($result);
        echo $result;
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
            if (D("Activity")->create()) {
                D("Activity")->uid = $uid;
                D("Activity")->lng = $location['lng'];
                D("Activity")->lat = $location['lat'];
                D("Activity")->city = $city;
                D("Activity")->area = $area;
                D("Activity")->starttime=strtotime($_POST['starttime']);
                D("Activity")->endtime=strtotime($_POST['endtime']);
                D("Activity")->inputtime = time();
                D("Activity")->username = !empty($member['nickname'])?$member['nickname']:$member['username'];
                $id = D("Activity")->add();
                if($id){
                    $aid=$id;
                    $title=$_POST["title"];
                    $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->where(array('a.id'=>$_POST["hid"]))->field("a.id,a.title,b.title as place")->find();
                    $tags_content=M('tags_content')->where(array('contentid'=>$aid,'varname'=>'party','type'=>'party'))->find();
                    if(empty($tags_content)){
                        M('tags_content')->add(array('contentid'=>$aid,'title'=>$title,'varname'=>'party','type'=>'party','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                    }
                    $this->redirect("Home/Party/addsuccess",array('id'=>$id));
                    //$this->success("发布活动成功，等待管理员审核！", U("Home/Party/index"));
                } else {
                    $this->error("新增活动失败！");
                }
            } else {
                $this->error(D("Activity")->getError());
            }
        } else {
            $uid=session('uid');
            $user = M('member')->where('id=' . session('uid'))->find();
            if (!session('uid')) {
                $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
            }elseif($user['houseowner_status']!=1){
                $this->error("请先进行商家认证");
            } else {
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $partycate=M("partycate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("partycate",$partycate);
                $hostel=M('hostel')->where(array('uid'=>$uid,'status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("hostel",$hostel);
                $this->display();
            }
        }
    }
    public function edit() {
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
            if (D("Activity")->create()) {
                D("Activity")->uid = $uid;
                D("Activity")->lng = $location['lng'];
                D("Activity")->lat = $location['lat'];
                D("Activity")->city = $city;
                D("Activity")->area = $area;
                D("Activity")->starttime=strtotime($_POST['starttime']);
                D("Activity")->endtime=strtotime($_POST['endtime']);
                D("Activity")->updatetime = time();
                D("Activity")->username = !empty($member['nickname'])?$member['nickname']:$member['username'];
                D("Activity")->status = 1;
                D("Activity")->remark="";
                $id = D("Activity")->save();
                if($id){
                    $aid=$_POST['id'];
                    $title=$_POST["title"];
                    $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->where(array('a.id'=>$_POST["hid"]))->field("a.id,a.title,b.title as place")->find();
                    $tags_content=M('tags_content')->where(array('contentid'=>$aid,'varname'=>'party','type'=>'party'))->find();
                    if(empty($tags_content)){
                        M('tags_content')->add(array('contentid'=>$aid,'title'=>$title,'varname'=>'party','type'=>'party','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                    }
                    //$this->redirect("Home/Party/addsuccess");
                    $this->success("修改活动成功", U("Home/Party/index"));
                } else {
                    $this->error("新增活动失败！");
                }
            } else {
                $this->error(D("Activity")->getError());
            }
        } else {
            $uid=session('uid');
            if (!session('uid')) {
                $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
            } else {
                $id= I('get.id', null, 'intval');
                if (empty($id)) {
                    $this->error("ID参数错误");
                }
                $data=D("Activity")->where("id=".$id)->find();
                $data['starttime']=date("Y-m-d",$data['starttime']);
                $data['endtime']=date("Y-m-d",$data['endtime']);
                $area=explode(',', $data['area']);
                $data['province']=$area[0];
                $data['city']=$area[1];
                $data['town']=$area[2];
                $this->assign("data", $data);
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $partycate=M("partycate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("partycate",$partycate);
                $hostel=M('hostel')->where(array('uid'=>$uid,'status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("hostel",$hostel);
                $this->display();
            }
        }
    }
    public function show() {
        $id=I('id');
        $uid=session("uid");
        M('activity')->where(array('id'=>$id))->setInc("view");
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'party'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where(array('a.id'=>$id))
            ->field('a.id,a.catid,a.title,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.isfree,a.partytype,a.starttime,a.endtime,a.content,a.start_numlimit,a.end_numlimit,a.yes_num,a.view,a.uid,b.nickname,b.head,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime,c.reviewnum')
            ->find();
        $data['catname']=M('partycate')->where(array('id'=>$data['catid']))->getField("catname");  
        if(empty($data['reviewnum'])) $data['reviewnum']=0;
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
        $note_party=M('tags_content a')->join("left join zz_activity b on a.contentid=b.id")->where(array('a.varname'=>'party','a.contentid'=>$data['id'],'a.type'=>'party'))->field("a.title,a.hid,a.place,b.city,'party' as type")->find();
        $data['note_party']=!empty($note_party)?$note_party:null;
        // $Map=A("Api/Map");
        // $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$data['lat'].",".$data['lng']);
        // $data['distance']=!empty($distance)?$distance:0.00;
        $reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'party'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->select();
        $data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
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
            ->limit(4)
            ->select();
        foreach ($party_near_activity as $key => $value) {
            # code...
            $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
            $party_near_activity[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
            $party_near_activity[$key]['joinlist']=!empty($joinlist)?$joinlist:"";
            $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid))->find();
            if(!empty($joinstatus)){
                $party_near_activity[$key]['isjoin']=1;
            }else{
                $party_near_activity[$key]['isjoin']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $party_near_activity[$key]['ishit']=1;
            }else{
                $party_near_activity[$key]['ishit']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"party",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $party_near_activity[$key]['iscollect']=1;
            }else{
                $party_near_activity[$key]['iscollect']=0;
            }
        }
        $data['party_near_activity']=!empty($party_near_activity)?$party_near_activity:null;

        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;
        $where['a.isoff']=0;

        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $recoords=getcoords($data['lat'],$data['lng'],2);
        $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
        $party_near_hostel=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit(4)
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
            $distance=$Map->get_distance_baidu("driving",$data['lat'].",".$data['lng'],$value['lat'].",".$value['lng']);
            $party_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        $data['party_near_hostel']=!empty($party_near_hostel)?$party_near_hostel:null;
        $this->assign("data",$data);
        $this->display();
    }
    public function addsuccess(){
        $data=M('activity')->where(array('id'=>$_GET['id']))->find();
        $where=array();
        $where['a.status']=2;
        $where['a.isdel']=0;
        $where['a.isoff']=0;

        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $recoords=getcoords($data['lat'],$data['lng'],2);
        $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
        $party_near_hostel=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit(4)
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
            $distance=$Map->get_distance_baidu("driving",$data['lat'].",".$data['lng'],$value['lat'].",".$value['lng']);
            $party_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        $data['party_near_hostel']=!empty($party_near_hostel)?$party_near_hostel:null;
        $this->assign("data",$data);
        $this->display();
    }
    
    public function ajax_hit(){
        if(IS_POST){
            $aid=$_POST['aid'];
            $where['uid']=session("uid");
            $where['varname']='party';
            $where['value']=$aid;
            $num=M('hit')->where($where)->count();
            $party=M('activity')->where('id=' . $aid)->find();
            if($num==0){
                $where['inputtime']=time();
                M('activity')->where('id=' . $aid)->setInc('hit');
                $id=M('hit')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($party['uid'],"活动点赞","您的活动(".$party['title'].")获得1个赞","您的活动(".$party['title'].")获得1个赞","partyhit",$party['id']);
                    $data['status']=1;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }else{
                    $data['status']=0;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }
            }else{
                M('activity')->where('id=' . $aid)->setDec('hit');
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
            $aid=$_POST['aid'];
            $where['uid']=session("uid");
            $where['varname']='party';
            $where['value']=$aid;
            $num=M('collect')->where($where)->count();
            $party=M('activity')->where('id=' . $aid)->find();
            if($num==0){
                $where['inputtime']=time();
                $id=M('collect')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($party['uid'],"活动收藏","您的活动(".$party['title'].")被其他用户收藏了","您的活动(".$party['title'].")被其他用户收藏了","partycollect",$party['id']);
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
    public function ajax_delete(){
        if(IS_POST){
            $where=array();
            $aid=$_POST['aid'];
            $uid=session("uid");
            $party=M('activity')->where(array('id'=>$aid))->find();
            if($aid==''||$uid==''){
                $this->ajaxReturn(array('status'=>0,'msg'=>'活动ID不能为空'),'json');
            }elseif(empty($party)){
                $this->ajaxReturn(array('status'=>0,'msg'=>"活动不存在"),'json');
            }else{
                $where=array();
                $where['id']=array('eq',$aid);
                $id=M("activity")->where($where)->save(array('isdel'=>1,'deletetime'=>time()));
                if($id){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'删除成功'),'json');
                }else{
                    $this->ajaxReturn(array('status'=>0,'msg'=>'删除失败'),'json');
                }
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'请求非法'),'json');
        }
    }
    public function get_review(){
        $ret=$_GET;
        $aid=intval(trim($ret['aid']));

        if($aid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$aid;
            $where['a.isdel']=0;
            $where['a.varname']='party';
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
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $party=M('activity')->where(array('id'=>$aid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($aid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($party)){
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
                \Api\Controller\UtilController::addmessage($party['uid'],"活动评论","您的活动(".$party['title'].")被其他用户评论了","您的活动(".$party['title'].")被其他用户评论了","partyreview",$party['id']);
                exit(json_encode(array('code'=>200,'msg'=>"评论成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"评论失败")));
            }
        }
    }
    public function add_reviewreply(){
        $ret=$_POST;
        $rid=intval(trim($ret['rid']));
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $review=M('review')->where(array('id'=>$rid))->find();
        $party=M('activity')->where(array('id'=>$aid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($rid==''||$aid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($review)){
            exit(json_encode(array('code'=>-200,'msg'=>"评论不存在")));
        }elseif(empty($party)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['rid']=$rid;
            $data['value']=$aid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='party';
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
        $aid=intval(trim($ret['aid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $review=M('review')->where(array('id'=>$rid))->find();
        $party=M('activity')->where(array('id'=>$aid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($rid==''||$aid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($review)){
            exit(json_encode(array('code'=>-200,'msg'=>"评论不存在")));
        }elseif(empty($party)){
            exit(json_encode(array('code'=>-200,'msg'=>"活动不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['rid']=$rid;
            $data['value']=$aid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='party';
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
}