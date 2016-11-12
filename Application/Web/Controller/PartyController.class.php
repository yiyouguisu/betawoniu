<?php
namespace Web\Controller;
use Web\Common\CommonController;

class PartyController extends CommonController {
    public function index() {
        $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
        $this->assign('province',$province);
        $partycate=M("partycate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("partycate",$partycate);
        $this->assign("uid", session("uid"));
        $this->display();
    }
    public function ajax_getlist() {
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
        if (empty($party)) {
            $jsondata['status']  = 0;
        }else{
            $jsondata['status']  = 1;
            $jsondata['num']  = count($party);
            $jsondata['html']  = $this->fetch("morelist_index");
        }
        $this->ajaxReturn($jsondata,'json');
    }
    public function select(){
        $uid=session("uid");
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'party'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        // 特色
        if($_POST['partycate']!=''){
            $where['a.catid']=$_POST['partycate'];
        }
        // 城市
        if($_POST['city']!=''){
            // $area=;
            $where['a.area']=$_POST['city'];
        }
        // 类型
        if($_POST['partytype']!='' && $_POST['partytype']!=0){
            $where['a.partytype']=$_POST['partytype'];
        }
        // 价格
        if($_POST['minmoney']>0 || $_POST['maxmoney']>0){
            $where['a.money'] = array(array('EGT', $_POST['minmoney']), array('ELT', $_POST['maxmoney']));
        }
        // print_r($_POST);
        // print_r($where);
        // die;

        $party = M("Activity a")
        ->join("left join zz_member b on a.uid=b.id")
        ->join("left join {$sqlI} c on a.id=c.value")
        ->where($where)
        ->order(array("a.listorder" => "desc","a.id" => "desc"))
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
            // 
            $joinhead=M('activity_apply a')
            ->join('left join zz_member b on a.uid=b.id')
            ->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))
            ->field('b.head,b.id')->select();
            $party[$key]['joinhead']=count($joinhead)>0?$joinhead:array();
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
            $party[$key]['joinlist']=!empty($joinlist)?$joinlist:"";
            $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid))->find();
            if(!empty($joinstatus)){
                $party[$key]['isjoin']=1;
            }else{
                $party[$key]['isjoin']=0;
            }
        }
        if(count($party)>0){
            $data['code']=200;
            $data['data']=$party;
            $this->ajaxReturn($data,'json');
        }
        else{
            $this->ajaxReturn(array('code'=>500),'json');
        }
        
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
                    $this->redirect("Home/Party/addsuccess");
                    //$this->success("发布活动成功，等待管理员审核！", U("Home/Party/index"));
                } else {
                    $this->error("新增活动失败！");
                }
            } else {
                $this->error(D("Activity")->getError());
            }
        } else {
            if (!session('uid')) {
                $this->redirect('Home/Member/login');
            } else {
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $partycate=M("partycate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("partycate",$partycate);
                $this->display();
            }
        }
    }
    public function show() {
        $id=I('id');
        $uid=session("uid");
        M('activity')->where(array('id'=>$id))->setInc("view");
        $sqlI=M('review')
          ->where(array('isdel'=>0,'varname'=>'party'))
          ->group("value")
          ->field("value,count(value) as reviewnum")
          ->order('id desc')
          ->limit(0, 5)
          ->buildSql();
        $data=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where(array('a.id'=>$id))
            ->field('a.id,a.catid,a.title,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.partytype,a.starttime,a.endtime,a.content,a.start_numlimit,a.end_numlimit,a.yes_num,a.view,a.uid,b.nickname,b.head,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime,c.reviewnum')
            ->find();
        $data['catname']=M('partycate')->where(array('id'=>$data['catid']))->getField("catname");  
        if(empty($data['reviewnum'])) $data['reviewnum']=0;
        $joinnum=M('activity_apply')
          ->where(array('aid'=>$data['id'],'paystatus'=>1))
          ->sum("num");
        $joinnum = $joinnum == NULL ? 0 : $joinnum;
        if($joinnum >= $data['end_numlimit']) {
          $this->assign('full', 1);
        }
        if($data['endtime'] <= time()) {
          $this->assign('expire', 1); 
        }
        $data['joinnum']=!empty($joinnum)?$joinnum:0;
        $joinlist=M('activity_apply a')
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.aid'=>$data['id'],'a.paystatus'=>1))
          ->field("b.id,b.nickname,b.head,b.rongyun_token")
          ->select();
        $data['joinlist']=!empty($joinlist)?$joinlist:null;
        $joinstatus=M('activity_apply')->where(array('aid'=>$data['id'],'uid'=>$uid))->find();
        if(!empty($joinstatus)){
            $data['isjoin']=1;
            $this->assign('joined', 1);
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
        $lat=cookie('lat');
        $lng=cookie('lng');
        $Map=A("Api/Map");
        $distance=$Map->get_distance_baidu("driving",$lat.",".$lng,$data['lat'].",".$data['lng']);
        $data['distance']=!empty($distance)?$distance:0.00;
        $reviewlist=M('review a')
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'party'))
          ->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")
          ->order('a.id desc')
          ->limit(5)
          ->select();
        $data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;

        $recoords=getcoords($data['lat'],$data['lng'],2);
        $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
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
        }
        $member = M('member')->where(array('id' => session('uid')))->find();
        $this->assign('member', $member);
        $data['note_near_activity']=!empty($note_near_activity)?$note_near_activity:null;

        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;

        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $recoords=getcoords($data['lat'],$data['lng'],2);
        $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
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
        $data['note_near_hostel']=!empty($note_near_hostel)?$note_near_hostel:null;
        $this->assign('id',$id);
        $this->assign("data",$data);
        $this->display();
    }
    // 参加活动
    public function enroll(){
        $id=I('get.id');
        print_r($id);
        $this->display();
    }
    public function addsuccess(){
        $this->display();
    }
    public function join(){
        $this->display();
    }
    public function joinconfirm(){
        $this->display();
    }
    public function joinpay(){
        $this->display();
    }
    public function joinsuccess(){
        $this->display();
    }
    public function ajax_hit(){
        if(IS_POST){
            $aid=$_POST['aid'];
            $where['uid']=session("uid");
            $where['varname']='party';
            $where['value']=$aid;
            $num=M('hit')->where($where)->count();
            if($num==0){
                $where['inputtime']=time();
                M('activity')->where('id=' . $aid)->setInc('hit');
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
    public function app_show() {
        $id=I('id');
        $data=M("activity")
            ->where(array('id'=>$id))
            ->find();
        $this->assign("data",$data);
        $this->display();
    }
    public function allComment() {
      $id = $_GET['id'];
      $data =M('review a')
        ->join("left join zz_member b on a.uid=b.id")
        ->where(array('a.value'=> $id,'a.isdel'=>0,'a.varname'=>'party'))
        ->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")
        ->order('a.id desc')
        ->select();
      $count = count($data);
      $this->assign('count', $count);
      $this->assign('data', $data); 
      $this->display('Public/all_review_list');
    }
}
