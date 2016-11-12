<?php
namespace Home\Controller;
use Home\Common\CommonController;

class NoteController extends CommonController {

    public function index() {
    	$uid=session("uid");
        $order=array();
        $where=array();
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
        $begintime = I('get.begintime');
        if (!empty($begintime)) {
            $begintime = strtotime($begintime);
            $where["a.begintime"] = array("EGT", $begintime);
        }
        //添加结束时间
        $endtime = I('get.endtime');
        if (!empty($endtime)) {
            $endtime = strtotime($endtime);
            $where["a.endtime"] = array("ELT", $endtime);
        }
        $city=I('city');
        if(!empty($city)){
            $where['a.city'] =$city;
        }

        $month=I('month');
        if(!empty($month)){
            $where['_string'] = "month(FROM_UNIXTIME( a.inputtime )) = ".$month;
        }
        $where['a.status']=2;
        $where['a.isdel']=0;
        $where['a.isoff']=0;

        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $count = M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->count();
        $page = new \Think\Page($count,6);
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $note = M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
		        ->limit($page->firstRow . ',' . $page->listRows)
		        ->order($order)
		        ->field('a.id,a.title,a.thumb,a.description,a.area,a.city,a.address,a.lat,a.lng,a.hit,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,a.type,c.reviewnum')
		        ->select();
		foreach ($note as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $note[$key]['reviewnum']=0;
            //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$value['id'],'a.isdel'=>0,'a.varname'=>'note'))->field("a.id as vid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->select();
            //$note[$key]['reviewlist']=!empty($reviewlist)?$reviewlist:"";
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
        $show = $page->show();
        $this->assign("note", $note);
        $this->assign("Page", $show);

        $ad=M('ad')->where(array('catid'=>12))->order(array("listorder" => "desc","id" => "desc"))->select();
        $this->assign("ad", $ad);


        $where=array();
        $where['a.status']=2;
        $where['a.isdel']=0;
        $where['a.isoff']=0;
        $hotparty=M("activity a")
        		->join("left join zz_member b on a.uid=b.id")
        		->where($where)
        		->order(array("a.hit" => "desc","a.listorder" => "desc","a.id" => "desc"))
        		->limit(4)
        		->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
        		->select();
		$this->assign("hotparty", $hotparty);

        $where=array();
        $ids=M('area')->where(array('parentid'=>0,'id'=>array('not in','2,3,4,5')))->getField("id",true);
        $map['parentid']  = array("in",$ids);
        $map['id']  = array('in','2,3,4,5');
        $map['_logic'] = 'or';
        $where['_complex'] = $map;
        $where['ishot']=1;
        $hotcity = M("area")->where($where)->field('id,name,fletter,ishot')->select();
        $this->assign("hotcity", $hotcity);
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
            if (D("Note")->create()) {
                D("Note")->uid = $uid;
                D("Note")->lng = $location['lng'];
                D("Note")->lat = $location['lat'];
                D("Note")->city = $city;
                D("Note")->area = $area;
                D("Note")->imglist = $imglist;
                D("Note")->begintime=strtotime($_POST['begintime']);
                D("Note")->endtime=strtotime($_POST['endtime']);
                D("Note")->inputtime = time();
                D("Note")->username = !empty($member['nickname'])?$member['nickname']:$member['username'];
                $id = D("Note")->add();
                if($id){
                    $nid=$id;
                    $hid=explode(",", $_POST['hid']);
                    $title=$_POST["title"];
                    foreach ($hid as $value) {
                        # code...
                        $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->where(array('a.id'=>$value))->field("a.id,a.title,b.title as place")->find();
                        $tags_content=M('tags_content')->where(array('contentid'=>$nid,'hid'=>$hostel['id'],'varname'=>'note','type'=>'hostel'))->find();
                        if(empty($tags_content)){
                            M('tags_content')->add(array('contentid'=>$nid,'title'=>$title,'varname'=>'note','type'=>'hostel','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                        }

                        $tags_content=M('tags_content')->where(array('contentid'=>$nid,'hid'=>$hostel['id'],'varname'=>'note','type'=>'place'))->find();
                        if(empty($tags_content)){
                            M('tags_content')->add(array('contentid'=>$nid,'title'=>$title,'varname'=>'note','type'=>'place','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                        }
                    }
                    
                    $this->success("发布游记成功，等待管理员审核！", U("Home/Note/index"));
                } else {
                    $this->error("新增游记失败！");
                }
            } else {
                $this->error(D("Note")->getError());
            }
        } else {
            $uid=session("uid");
            if (!session('uid')) {
                $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
            } else {
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $notestyle=M("notestyle")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("notestyle",$notestyle);
                $noteman=M("noteman")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("noteman",$noteman);
                // $hostel=M('book_room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.uid'=>$uid,'b.status'=>2,'b.isdel'=>0,'a.paystatus'=>1))->order(array('b.listorder'=>'desc','b.id'=>'desc'))->select();
                // if(empty($hostel)){
                    $hostel=M('Hostel')->where(array('status'=>2,'isdel'=>0,'isoff'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->field("id,title")->select();
                //}
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
            $imglist=json_encode($_POST['imglist']);
            if (D("Note")->create()) {
                D("Note")->uid = $uid;
                D("Note")->lng = $location['lng'];
                D("Note")->lat = $location['lat'];
                D("Note")->city = $city;
                D("Note")->area = $area;
                D("Note")->imglist = $imglist;
                D("Note")->begintime=strtotime($_POST['begintime']);
                D("Note")->endtime=strtotime($_POST['endtime']);
                D("Note")->updatetime = time();
                D("Note")->username = !empty($member['nickname'])?$member['nickname']:$member['username'];
                D("Store")->status = 1;
                D("Store")->remark="";
                $id = D("Note")->save();
                if($id){
                    $nid=$_POST['id'];
                    $hid=explode(",", $_POST['hid']);
                    $title=$_POST["title"];
                    foreach ($hid as $value) {
                        # code...
                        $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->where(array('a.id'=>$value))->field("a.id,a.title,b.title as place")->find();
                        $tags_content=M('tags_content')->where(array('contentid'=>$nid,'hid'=>$hostel['id'],'varname'=>'note','type'=>'hostel'))->find();
                        if(empty($tags_content)){
                            M('tags_content')->add(array('contentid'=>$nid,'title'=>$title,'varname'=>'note','type'=>'hostel','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                        }

                        $tags_content=M('tags_content')->where(array('contentid'=>$nid,'hid'=>$hostel['id'],'varname'=>'note','type'=>'place'))->find();
                        if(empty($tags_content)){
                            M('tags_content')->add(array('contentid'=>$nid,'title'=>$title,'varname'=>'note','type'=>'place','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                        }
                    }
                    $this->success("修改游记成功！", U("Home/Note/index"));
                } else {
                    $this->error("修改游记失败！");
                }
            } else {
                $this->error(D("Note")->getError());
            }
        } else {
            if (!session('uid')) {
                $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
            } else {
                $id= I('get.id', null, 'intval');
                if (empty($id)) {
                    $this->error("文章ID参数错误");
                }
                $data=D("Note")->where("id=".$id)->find();
                $data['begintime']=date("Y-m-d",$data['begintime']);
                $data['endtime']=date("Y-m-d",$data['endtime']);
                $area=explode(',', $data['area']);
                $data['province']=$area[0];
                $data['city']=$area[1];
                $data['town']=$area[2];
                $this->assign("data", $data);
                $imglist=json_decode($data['imglist'],true);
                $this->assign("imglist", $imglist);
                $notestyle=M("notestyle")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("notestyle",$notestyle);
                $noteman=M("noteman")->order(array('listorder'=>'desc','id'=>'asc'))->select();
                $this->assign("noteman",$noteman);
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $hidbox=explode(",",$data['hid']);
                // $hostel=M('book_room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.uid'=>$_POST['uid'],'b.status'=>2,'b.isdel'=>0,'a.paystatus'=>1))->order(array('b.listorder'=>'desc','b.id'=>'desc'))->select();
                // if(empty($hostel)){
                    $hostel=M('Hostel')->where(array('status'=>2,'isdel'=>0,'isoff'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->field("id,title")->select();
                //}
                foreach ($hostel as $key => $value) {
                    # code...
                    if(!empty($hidbox)&&in_array($value['id'],$hidbox)){
                        $hostel[$key]['ischeck']=1;
                    }else{
                        $hostel[$key]['ischeck']=0;
                    }
                }
                $this->assign('hostel',$hostel);
                $this->assign('notehostelnum',count($hidbox));
                if(count($hidbox)==1){
                    $notehosteltitle=M('Hostel')->where(array('id'=>$data['hid']))->getField("title");
                    $this->assign('notehosteltitle',$notehosteltitle);
                }
                $this->display();
            }
        }
    }
    public function show() {
        $id=I('id');
        $uid=session("uid");
        M('Note')->where(array('id'=>$id))->setInc("view");
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Note a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->join("left join zz_noteman d on a.man=d.id")
            ->join("left join zz_notestyle e on a.style=e.id")
            ->where(array('a.id'=>$id))
            ->field('a.id,a.title,a.thumb,a.area,a.city,a.address,a.lat,a.lng,a.hit,a.imglist as content,a.begintime,a.endtime,a.fee,a.man,a.style,a.days,a.view,a.uid,b.nickname,b.head,b.background,b.rongyun_token,a.inputtime,c.reviewnum,d.catname as noteman,e.catname as notestyle')
            ->find();
        if(empty($data['reviewnum'])) $data['reviewnum']=0;
        $data['content']=json_decode($data['content'],true);
        $reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'note'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->select();
        $data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$data['id']))->find();
        !empty($collectstatus)?$data['iscollect']=1:$data['iscollect']=0;

        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$data['id']))->find();
        !empty($hitstatus)?$data['ishit']=1:$data['ishit']=0;

        $note_place=M('tags_content a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.varname'=>'note','a.contentid'=>$data['id'],'a.type'=>'place'))->field("a.place as title,a.hid,b.title as hostel,b.city,'place' as type,b.uid")->select();
        $data['note_place']=!empty($note_place)?$note_place:null;

        $note_hostel=M('tags_content a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.varname'=>'note','a.contentid'=>$data['id'],'a.type'=>'hostel'))->field("a.hostel as title,a.hid,a.place,b.city,'hostel' as type,b.uid")->select();
        $data['note_hostel']=!empty($note_hostel)?$note_hostel:null;

        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;
        $where['a.isoff']=0;

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
        $data['note_near_activity']=!empty($note_near_activity)?$note_near_activity:null;

        $where=array();
        $where['a.status']=2;
        $where['a.type']=1;
        $where['a.isdel']=0;
        $where['a.isoff']=0;

        $recoords=getcoords($data['lat'],$data['lng'],2);
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
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
            $distance=$Map->get_distance_baidu("driving",$data['lat'].",".$data['lng'],$value['lat'].",".$value['lng']);
            $note_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        $data['note_near_hostel']=!empty($note_near_hostel)?$note_near_hostel:null;

        $where=array();
        $where['a.status']=2;
        $where['a.isdel']=0;
        $where['a.isoff']=0;
        $where['a.noteman']=$data['noteman'];
        $where['a.notestyle']=$data['notestyle'];
        $where['a.id']=array('neq',$id);
        $relative_note=M("note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order(array("a.listorder" => "desc","a.id" => "desc"))
                ->limit(6)
                ->field('a.id,a.title,a.thumb,a.description,a.area,a.address,a.lat,a.lng,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                ->select();
        $data['relative_note']=!empty($relative_note)?$relative_note:null;
        $this->assign("data",$data);
        $this->display();
    }
    public function ajax_hit(){
        if(IS_POST){
            $nid=$_POST['nid'];
            $where['uid']=session("uid");
            $where['varname']='note';
            $where['value']=$nid;
            $num=M('hit')->where($where)->count();
            $note=M('note')->where('id=' . $nid)->find();
            if($num==0){
                $where['inputtime']=time();
                M('note')->where('id=' . $nid)->setInc('hit');
                $id=M('hit')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($note['uid'],"游记点赞","您的游记(".$note['title'].")获得1个赞","您的游记(".$note['title'].")获得1个赞","notehit",$note['id']);
                    $data['status']=1;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }else{
                    $data['status']=0;
                    $data['type']=1;
                    $this->ajaxReturn($data,'json');
                }
            }else{
                M('note')->where('id=' . $nid)->setDec('hit');
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
            $nid=$_POST['nid'];
            $where['uid']=session("uid");
            $where['varname']='note';
            $where['value']=$nid;
            $num=M('collect')->where($where)->count();
            $note=M('note')->where(array('id'=>$nid))->find();
            if($num==0){
                $where['inputtime']=time();
                $id=M('collect')->add($where);
                if($id){
                    \Api\Controller\UtilController::addmessage($note['uid'],"游记收藏","您的游记(".$note['title'].")被其他用户收藏了","您的游记(".$note['title'].")被其他用户收藏了","notecollect",$note['id']);
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
            $nid=$_POST['nid'];
            $uid=session("uid");
            $note=M('note')->where(array('id'=>$nid))->find();
            if($nid==''||$uid==''){
                $this->ajaxReturn(array('status'=>0,'msg'=>'游记ID不能为空'),'json');
            }elseif(empty($note)){
                $this->ajaxReturn(array('status'=>0,'msg'=>"游记不存在"),'json');
            }else{
                $where=array();
                $where['id']=array('eq',$nid);
                $id=M("note")->where($where)->save(array('isdel'=>1,'deletetime'=>time()));
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
        $nid=intval(trim($ret['nid']));

        if($nid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$nid;
            $where['a.isdel']=0;
            $where['a.varname']='note';
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
        $nid=intval(trim($ret['nid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $note=M('note')->where(array('id'=>$nid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($nid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['value']=$nid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='note';
            $data['inputtime']=time();
            $id=M("review")->add($data);
            if($id){
                \Api\Controller\UtilController::addmessage($note['uid'],"游记评论","您的游记(".$note['title'].")被其他用户评论了","您的游记(".$note['title'].")被其他用户评论了","notereview",$note['id']);
                exit(json_encode(array('code'=>200,'msg'=>"评论成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"评论失败")));
            }
        }
    }
    public function add_reviewreply(){
        $ret=$_POST;
        $rid=intval(trim($ret['rid']));
        $nid=intval(trim($ret['nid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $review=M('review')->where(array('id'=>$rid))->find();
        $note=M('note')->where(array('id'=>$nid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($rid==''||$nid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($review)){
            exit(json_encode(array('code'=>-200,'msg'=>"评论不存在")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['rid']=$rid;
            $data['value']=$nid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='note';
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
        $nid=intval(trim($ret['nid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $review=M('review')->where(array('id'=>$rid))->find();
        $note=M('note')->where(array('id'=>$nid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($rid==''||$nid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($review)){
            exit(json_encode(array('code'=>-200,'msg'=>"评论不存在")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['rid']=$rid;
            $data['value']=$nid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='note';
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