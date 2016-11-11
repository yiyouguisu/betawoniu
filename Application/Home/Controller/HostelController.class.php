<?php
namespace Home\Controller;
use Home\Common\CommonController;

class HostelController extends CommonController {

    public function index() {
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
        $style=I('style');
        if(!empty($style)){
            $where['a.style']=$style;
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
            
        }else if(!empty($_GET['area'])){
            $where['a.area']=array('like',$_GET['area'] . ','."%");
            $locationset=explode(",", $_GET['area']);
            if(in_array($locationset[0],array(2,3,4,5))){
                $city=$locationset[0];
            }else{
                $city=$locationset[1]; 
            }
            $cityname=M('area')->where(array('id'=>$city))->getField("name");
            $this->assign("cityname",$cityname);
        }
        if(!empty($area)){
            $where['a.area']=$area;
        }
        $minmoney=I('minmoney');
        $maxmoney=I('maxmoney');
        if($minmoney!=null&&$maxmoney!=null){
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
        $city=I('city');
        if(isset($_GET['province'])&&in_array($_GET['province'],array(2,3,4,5))){
            $city=$_GET['province'];
        }
        if(!empty($city)){
            $where['a.city'] =$city;
        }

        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $sqlII=M('book_room')->where(array('_string'=>$endtime." <= endtime and ".$starttime." >= starttime"))->group("hid")->field("hid,sum(num) as booknum")->buildSql();
        $sqlIII=M('room')->group("hid")->field("hid,sum(mannum) as totalbooknum")->buildSql();
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
            ->where($where)->order(array('a.id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();

        //$Map=A("Api/Map");
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
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->assign("hostelnum",$count);
        $pagenum=round($count/16);
        $this->assign("pagenum",$pagenum);

        
        $hidbox=M("Hostel a")->where($where)->getField("id",true);
        $where=array();
        $where['a.hid']=array('in',$hidbox);
        $where['a.isdel']=0;
        if(!empty($support)){
            $select["_string"]="concat(',',a.support,',') LIKE '%,".$support.",%'";
        }
        if(!empty($bedtype)){
            $where['a.roomtype']=array('eq',$bedtype);
        }
        if($minmoney!=null&&$maxmoney!=null){
            $where['a.money'] = array(array('EGT', $minmoney), array('ELT', $maxmoney));
        }
        $roomnum=M("room a")->where($where)->count();
        $this->assign("roomnum",$roomnum);

        $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
        $this->assign('province',$province);
        $hostelcate = M("hostelcate")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("hostelcate", $hostelcate);
        $hosteltype = M("hosteltype")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("hosteltype", $hosteltype);
        $acreagecate = M("linkage")->where("catid=7")->field('value,name')->select();
        $this->assign("acreagecate", $acreagecate);
        $scorecate = M("linkage")->where("catid=8")->field('value,name')->select();
        $this->assign("scorecate", $scorecate);
        $bedcate = M("bedcate")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("bedcate", $bedcate);
        $roomcate = M("roomcate")->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("roomcate", $roomcate);
        $this->display();
    }
    public function map() {
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
        $catid=I('catid');
        if(!empty($catid)){
            $where['a.catid']=$catid;
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
        //$Map=A("Api/Map");
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
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->assign("hostelnum",$count);
        $pagenum=round($count/16);
        $this->assign("pagenum",$pagenum);
        $this->assign("jsonlist", json_encode($data));
        
        $hidbox=M("Hostel a")->where($where)->getField("id",true);
        $where=array();
        $where['a.hid']=array('in',$hidbox);
        $where['a.isdel']=0;
        if(!empty($support)){
            $select["_string"]="concat(',',a.support,',') LIKE '%,".$support.",%'";
        }
        if(!empty($bedtype)){
            $where['a.roomtype']=array('eq',$bedtype);
        }
        if($minmoney!=null&&$maxmoney!=null){
            $where['a.money'] = array(array('EGT', $minmoney), array('ELT', $maxmoney));
        }
        $roomnum=M("room a")->where($where)->count();
        $this->assign("roomnum",$roomnum);

        $this->display();
    }
    public function add() {
        if ($_POST) {
            $uid=session("uid");
            $member=M('Member')->where(array('id'=>$uid))->find();
            $cachefile="roomtemplate_".$uid;
            $room=S($cachefile);
            if(empty($room)){
                $this->error("请先添加房间！");
            }
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
                D("Hostel")->inputtime = time();
                D("Hostel")->username = !empty($member['nickname'])?$member['nickname']:$member['username'];
                $hid = D("Hostel")->add();
                if($hid){
                    foreach ($room as $value) {
                        # code...
                        $roomdata=array();
                        $roomdata['hid']=$hid;
                        $roomdata['title']=$value['title'];
                        $roomdata['thumb']=$value['thumb'];
                        $roomdata['mannum']=$value['mannum'];
                        $roomdata['nomal_money']=$value['nomal_money'];
                        $roomdata['week_money']=$value['week_money'];
                        $roomdata['holiday_money']=$value['holiday_money'];
                        $roomdata['area']=$value['area'];
                        $roomdata['roomtype']=$value['roomtype'];
                        $roomdata['content']=$value['content'];
                        $roomdata['imglist'] = $value['imglist'];
                        $roomdata['support'] = $value['support'];
                        $roomdata['hotsupport'] = $value['hotsupport'];
                        $roomdata['money']=$value['money'];
                        $roomdata['wait_num'] = $value['mannum'];
                        $roomdata['conveniences']=$value['conveniences'];
                        $roomdata['bathroom']=$value['bathroom'];
                        $roomdata['media']=$value['media'];
                        $roomdata['food']=$value['food'];
                        $roomdata['inputtime'] = time();
                        $roomdata['updatetime'] = time();
                        $roomdata['status'] = 2;
                        $roomdata['verify_user']=$_SESSION['user'];
                        $roomdata['verify_time'] = time();
                        M("Room")->add($roomdata);
                    }

                    $money=M('room')->where(array('hid'=>$hid,'isdel'=>0))->min("money");
                    $area=M('room')->where(array('hid'=>$hid,'isdel'=>0))->max("area");
                    $support=M('room')->where(array('hid'=>$hid,'isdel'=>0))->group("hid")->field("hid,group_concat(support) as newsupport")->select();
                    $supportbox=explode(",", $support[0]['newsupport']);
                    $supportbox=array_unique($supportbox);

                    $bedtype=M('room')->where(array('hid'=>$hid,'isdel'=>0))->group("hid")->field("hid,group_concat(roomtype) as newbedtype")->select();
                    $bedtypebox=explode(",", $bedtype[0]['newbedtype']);
                    $bedtypebox=array_unique($bedtypebox);


                    M('hostel')->where(array('id'=>$hid))->save(array(
                        'money'=>$money,
                        'acreage'=>$area,
                        'support'=>",".implode(",", $supportbox).",",
                        'bedtype'=>",".implode(",", $bedtypebox).","
                        ));
                    $title=$_POST["title"];
                    $place=M('place')->where(array('id'=>$_POST['place']))->getField("title");
                    $tags_content=M('tags_content')->where(array('contentid'=>$hid,'varname'=>'hostel','type'=>'hostel'))->find();
                    if(empty($tags_content)){
                        M('tags_content')->add(array('contentid'=>$hid,'title'=>$title,'varname'=>'hostel','type'=>'hostel','hid'=>$hid,'hostel'=>$title,'place'=>$place,'updatetime'=>time()));
                    }
                    $this->success("发布美宿成功，等待管理员审核！", U("Home/Member/myrelease"));
                } else {
                    $this->error("发布游美宿失败！");
                }
            } else {
                $this->error(D("Hostel")->getError());
            }
        } else {
            $user = M('member')->where('id=' . session('uid'))->find();
            if (!session('uid')) {
                $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
            }elseif($user['houseowner_status']!=1){
                $this->error("请先进行商家认证");
            } else {
                $uid=session("uid");
                $cachefile="roomtemplate_".$uid;
                S($cachefile,null);
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $hostelcate=M("hostelcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("hostelcate",$hostelcate);
                $hosteltype=M("hosteltype")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("hosteltype",$hosteltype);
                $bedcate=M("bedcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("bedcate",$bedcate);
                $support=M("roomcate")->field('id,ishot,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("support",$support);
                $place=M("place")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("place",$place);
                $this->display();
            }
        }
    }
    public function edit() {
        if ($_POST) {
            $uid=session("uid");
            $member=M('Member')->where(array('id'=>$uid))->find();
            $cachefile="roomtemplate_".$uid;
            $room=S($cachefile);
            if(empty($room)){
                $this->error("请先添加房间！");
            }
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
                D("Hostel")->status = 1;
                D("Hostel")->updatetime = time();
                D("Hostel")->username = !empty($member['nickname'])?$member['nickname']:$member['username'];
                D("Hostel")->status = 1;
                D("Hostel")->remark="";
                $hid = D("Hostel")->save();
                if($hid){
                    M("Room")->where(array('hid'=>$_POST['id']))->delete();
                    foreach ($room as $value) {
                        # code...
                        $roomdata=array();
                        $roomdata['hid']=$_POST['id'];
                        $roomdata['title']=$value['title'];
                        $roomdata['thumb']=$value['thumb'];
                        $roomdata['mannum']=$value['mannum'];
                        $roomdata['nomal_money']=$value['nomal_money'];
                        $roomdata['week_money']=$value['week_money'];
                        $roomdata['holiday_money']=$value['holiday_money'];
                        $roomdata['area']=$value['area'];
                        $roomdata['roomtype']=$value['roomtype'];
                        $roomdata['content']=$value['content'];
                        $roomdata['imglist'] = $value['imglist'];
                        $roomdata['support'] = $value['support'];
                        $roomdata['hotsupport'] = $value['hotsupport'];
                        $roomdata['money']=$value['money'];
                        $roomdata['wait_num'] = $value['mannum'];
                        $roomdata['conveniences']=$value['conveniences'];
                        $roomdata['bathroom']=$value['bathroom'];
                        $roomdata['media']=$value['media'];
                        $roomdata['food']=$value['food'];
                        $roomdata['inputtime'] = time();
                        $roomdata['updatetime'] = time();
                        $roomdata['status'] = 2;
                        $roomdata['verify_user']=$_SESSION['user'];
                        $roomdata['verify_time'] = time();
                        M("Room")->add($roomdata);
                    }

                    $money=M('room')->where(array('hid'=>$_POST['id'],'isdel'=>0))->min("money");
                    $area=M('room')->where(array('hid'=>$_POST['id'],'isdel'=>0))->max("area");
                    $support=M('room')->where(array('hid'=>$_POST['id'],'isdel'=>0))->group("hid")->field("hid,group_concat(support) as newsupport")->select();
                    $supportbox=explode(",", $support[0]['newsupport']);
                    $supportbox=array_unique($supportbox);

                    $bedtype=M('room')->where(array('hid'=>$_POST['id'],'isdel'=>0))->group("hid")->field("hid,group_concat(roomtype) as newbedtype")->select();
                    $bedtypebox=explode(",", $bedtype[0]['newbedtype']);
                    $bedtypebox=array_unique($bedtypebox);


                    M('hostel')->where(array('id'=>$_POST['id']))->save(array(
                        'money'=>$money,
                        'acreage'=>$area,
                        'support'=>",".implode(",", $supportbox).",",
                        'bedtype'=>",".implode(",", $bedtypebox).","
                        ));
                    $hid=$_POST['id'];
                    $title=$_POST["title"];
                    $place=M('place')->where(array('id'=>$_POST['place']))->getField("title");
                    $tags_content=M('tags_content')->where(array('contentid'=>$hid,'varname'=>'hostel','type'=>'hostel'))->find();
                    if(empty($tags_content)){
                        M('tags_content')->add(array('contentid'=>$hid,'title'=>$title,'varname'=>'hostel','type'=>'hostel','hid'=>$hid,'hostel'=>$title,'place'=>$place,'updatetime'=>time()));
                    }
                    $this->success("修改美宿成功，等待管理员审核！", U("Home/Member/myrelease"));
                } else {
                    $this->error("修改游美宿失败！");
                }
            } else {
                $this->error(D("Hostel")->getError());
            }
        } else {
            $user = M('member')->where('id=' . session('uid'))->find();
            if (!session('uid')) {
                $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
            }elseif($user['houseowner_status']!=1){
                $this->error("请先进行商家认证");
            } else {
                $uid=session("uid");

                $id= I('get.id', null, 'intval');
                if (empty($id)) {
                    $this->error("ID参数错误");
                }
                $data=D("Hostel")->where("id=".$id)->find();
                $area=explode(',', $data['area']);
                $data['province']=$area[0];
                $data['city']=$area[1];
                $data['town']=$area[2];
                $room=M('room')->where(array('hid'=>$data['id'],'isdel'=>0))->order(array('id'=>'desc'))->select();
                foreach ($room as $key => $value) {
                    # code...
                    $room[$key]['rid']=$key;
                    $room[$key]['bedtype']=M('bedcate')->where(array('id'=>$value['roomtype']))->getField("catname");
                }
                $cachefile="roomtemplate_".$uid;
                S($cachefile,$room);
                foreach ($room as $key => $value) {
                    # code...
                    $room[$key]['support']=M("roomcate")->where(array('id'=>array('in',$value['hotsupport'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
                    $imglist=explode("|", $value['imglist']);
                    $room[$key]['imglist']=$imglist;
                }
                $data['room']=!empty($room)?$room:null;
                $this->assign("data", $data);

                $roomnum=count($room);
                $this->assign("roomnum", $roomnum);

                $imglist=json_decode($data['imglist'],true);
                $this->assign("imglist", $imglist);
                
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $hostelcate=M("hostelcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("hostelcate",$hostelcate);
                $hosteltype=M("hosteltype")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("hosteltype",$hosteltype);
                $bedcate=M("bedcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("bedcate",$bedcate);
                $support=M("roomcate")->field('id,ishot,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("support",$support);
                $place=M("place")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("place",$place);
                $this->display();
            }
        }
    }
    public function ajax_cacheroom(){
        $uid=session("uid");
        $cachefile="roomtemplate_".$uid;
        $room=S($cachefile);
        
        $data=$_POST;
        $data['rid']=$_POST['rid'];
        $data['money']=min($_POST['nomal_money'],$_POST['week_money'],$_POST['holiday_money']);
        $data['wait_num'] = $_POST['mannum'];
        $data['bedtype']=M('bedcate')->where(array('id'=>$data['roomtype']))->getField("catname");
        $this->assign("data",$data);
        $support=M("roomcate")->where(array('id'=>array('in',$data['hotsupport'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        $this->assign("support", $support);
        if(!empty($data)){
            $room[]=$data;
            S($cachefile,$room);
            $html=$this->fetch("addroom");
            $this->ajaxReturn(array('code'=>200,'html'=>$html));
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"发布失败"));
        }
        
    }
    public function ajax_editroom(){
        $uid=session("uid");
        $cachefile="roomtemplate_".$uid;
        $room=S($cachefile);
        if($room[$_POST['rid']]){
            $room[$_POST['rid']]['imglist']=explode("|", $room[$_POST['rid']]['imglist']);
            $room[$_POST['rid']]['support']=explode(",", $room[$_POST['rid']]['support']);
            $room[$_POST['rid']]['hotsupport']=explode(",", $room[$_POST['rid']]['hotsupport']);
            $data=$room[$_POST['rid']];
            unset($room[$_POST['rid']]);
            S($cachefile,$room);
            $this->ajaxReturn(array('code'=>200,'data'=>$data));
        }else{
            $this->ajaxReturn(array('code'=>-200,'msg'=>"数据错误"));
        }
        
    }
    public function ajax_deleteroom(){
        $uid=session("uid");
        $cachefile="roomtemplate_".$uid;
        $room=S($cachefile);
        unset($room[$_POST['rid']]);
        S($cachefile,$room);
        $this->ajaxReturn(array('code'=>200));
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
        $distance=$Map->get_distance_baidu("driving",$data['lat'].",".$data['lng'],$data['lat'].",".$data['lng']);
        $data['distance']=!empty($distance)?$distance:0.00;
        //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'hostel'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->select();
        //$data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $room=M('room a')->join("left join {$sqlI} c on a.id=c.value")->join("left join zz_bedcate b on a.roomtype=b.id")->where(array('a.hid'=>$data['id'],'a.isdel'=>0,))->order(array('a.id'=>'desc'))->field("a.id as rid,a.title,a.thumb,a.area,a.money,a.roomtype,a.support,a.mannum,c.reviewnum,b.catname as bedtype,a.score as evaluation,a.scorepercent as evaluationpercent")->limit(2)->select();
        foreach ($room as $key => $value) {
            # code...
            $room[$key]['support']=M("roomcate")->where(array('id'=>array('in',$value['hotsupport'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        }
        $data['room']=!empty($room)?$room:null;
        $roomnum=M('room')->where(array('hid'=>$data['id'],'isdel'=>0))->count();
        $data['roomnum']=!empty($roomnum)?$roomnum:0;

        $replyasknum=M('bookask')->where(array('tuid'=>$data['uid'],'status'=>1))->count();
        $totalasknum=M('bookask')->where(array('tuid'=>$data['uid']))->count();
        $onlinereply=($replyasknum/$totalasknum)*100;
        $data['onlinereply']=!empty($onlinereply)?sprintf("%.2f",$onlinereply):"100.00";

        $evaluationconfirm=M()->query("SELECT AVG(b.sufftime) FROM(SELECT(b.review_time - b.inputtime) / 60 AS sufftime FROM zz_book_room a LEFT JOIN zz_order_time b ON a.orderid = b.orderid LEFT JOIN zz_hostel c ON a.hid = c.id WHERE(b.status = 4)AND (b.review_status > 0)AND (c.uid = ".$data['uid'].")) b");
        $data['evaluationconfirm']=!empty($evaluationconfirm)?sprintf("%.2f",$evaluationconfirm):0.0;

        $successordernum=M('book_room a')->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_hostel c on a.hid=c.id")->where(array('c.uid'=>$data['uid'],'b.review_status'=>1,'b.status'=>array('not in','1,5')))->count();
        $totalordernum=M('book_room a')->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_hostel c on a.hid=c.id")->where(array('c.uid'=>$data['uid']))->count();
        $orderconfirm=($successordernum/$totalordernum)*100;
        $data['orderconfirm']=!empty($orderconfirm)?sprintf("%.2f",$orderconfirm):"100.00";

        $where=array();
        $where['a.status']=2;
        $where['a.uid']=$data['uid'];
        $where['a.isdel']=0;
        $where['a.isoff']=0;
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
    public function ajax_getroom(){
        $hid=intval(trim($_POST['hid']));
        $p=intval(trim($_POST['p']));
        $num=intval(trim($_POST['num']));
        if($hid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'room'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $list=M('room a')->join("left join {$sqlI} c on a.id=c.value")->join("left join zz_bedcate b on a.roomtype=b.id")->where(array('a.hid'=>$hid,'a.isdel'=>0))->order(array('a.id'=>'desc'))->field("a.id as rid,a.title,a.thumb,a.area,a.money,a.roomtype,a.support,a.mannum,c.reviewnum,b.catname as bedtype")->page($p,$num)->select();
            foreach ($list as $key => $value) {
                # code...
                $list[$key]['support']=M("roomcate")->where(array('id'=>array('in',$value['hotsupport'])))->field('id,gray_thumb,blue_thumb,red_thumb,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            }
            $data['room']=$list;
            $this->assign("data", $data);
            if (!empty($list)) {
                # code...
                $jsondata['status']=1;
                $jsondata['html']  = $this->fetch("room");
            }else{
                $jsondata['status']=0;
            }
            $this->ajaxReturn($jsondata,'json');
        }
    }
    public function get_review(){
        $ret=$_GET;
        $hid=intval(trim($ret['hid']));

        if($hid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$hid;
            $where['a.isdel']=0;
            $where['a.varname']='hostel';
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
            $hid=$_POST['hid'];
            $where['uid']=session("uid");
            $where['varname']='hostel';
            $where['value']=$hid;
            $num=M('hit')->where($where)->count();
            $hostel=M('hostel')->where('id=' . $hid)->find();
            if($num==0){
                $where['inputtime']=time();
                M('hostel')->where('id=' . $hid)->setInc('hit');
                $id=M('hit')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($hostel['uid'],"美宿点赞","您的美宿(".$hostel['title'].")获得1个赞","您的美宿(".$hostel['title'].")获得1个赞","hostelhit",$hostel['id']);
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
            $hostel=M('hostel')->where('id=' . $hid)->find();
            if($num==0){
                $where['inputtime']=time();
                $id=M('collect')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($hostel['uid'],"美宿收藏","您的美宿(".$hostel['title'].")被其他用户收藏了","您的美宿(".$hostel['title'].")被其他用户收藏了","hostelcollect",$hostel['id']);
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
            $hid=$_POST['hid'];
            $uid=session("uid");
            $hostel=M('hostel')->where(array('id'=>$hid))->find();
            if($hid==''||$uid==''){
                $this->ajaxReturn(array('status'=>0,'msg'=>'美宿ID不能为空'),'json');
            }elseif(empty($hostel)){
                $this->ajaxReturn(array('status'=>0,'msg'=>"美宿不存在"),'json');
            }else{
                $where=array();
                $where['id']=array('eq',$hid);
                $id=M("hostel")->where($where)->save(array('isdel'=>1,'deletetime'=>time()));
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
}