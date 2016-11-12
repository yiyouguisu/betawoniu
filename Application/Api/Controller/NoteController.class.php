<?php
namespace Api\Controller;

use Api\Common\CommonController;

class NoteController extends CommonController {

    /**
     *游记形式
     */
    public function get_notestyle(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("notestyle")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *游记人物
     */
    public function get_noteman(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("noteman")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *游记列表
     */
    public function get_note(){
        //$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = file_get_contents("php://input");
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        $area=trim($ret['area']);
        $notetype=intval(trim($ret['notetype']));
        $notemonth=intval(trim($ret['notemonth']));
        $ordertype=intval(trim($ret['ordertype']));


        if($p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            if(!empty($area)){
                $where['a.area']=$area;
            }
            if(!empty($notetype)){
                $where['a.notetype']=$notetype;
            }
            if(!empty($notemonth)){
                $where['_string'] = "month(FROM_UNIXTIME( a.inputtime )) = ".$notemonth;
            }
            $order=array();
            if(!empty($ordertype)){
                switch ($ordertype) {
                    case "1":
                        $order=array('a.id'=>'desc');
                        break;
                    case "2":
                        $order=array('c.reviewnum'=>'desc');
                        break;
                }
            }else{
                $order=array('a.id'=>'desc');
            }
            $where['a.isdel']=0;
            $where['a.isoff']=0;
            $where['a.status']=2;
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.description,a.thumb,a.area,a.city,a.address,a.lat,a.lng,a.hit,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,a.type,c.reviewnum')
                ->page($p,$num)->select();
            foreach ($data as $key => $value) {
                # code...
                if(empty($value['reviewnum'])) $data[$key]['reviewnum']=0;
                //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$value['id'],'a.isdel'=>0,'a.varname'=>'note'))->field("a.id as vid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->select();
                //$data[$key]['reviewlist']=!empty($reviewlist)?$reviewlist:"";
                $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
                if(!empty($collectstatus)){
                    $data[$key]['iscollect']=1;
                }else{
                    $data[$key]['iscollect']=0;
                }
                $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
                if(!empty($hitstatus)){
                    $data[$key]['ishit']=1;
                }else{
                    $data[$key]['ishit']=0;
                }
                $collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['nid']))->count();
                $data[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
            }
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *首页推荐游记列表
     */
    public function get_pushnote(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $city=intval(trim($ret['city']));
        $where=array();
        if(!empty($city)){
            $where['a.city']=$city;
        }
        $where['a.status']=2;
        $where['a.index']=1;
        $where['a.isdel']=0;
        $where['a.isoff']=0;
        $sqlI=M('review')->where(array('isdel'=>0))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $data=M("Note a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>'desc'))
            ->field('a.id,a.title,a.description,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,a.type,c.reviewnum')
            ->limit(3)->select();
        foreach ($data as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $data[$key]['reviewnum']=0;
            $reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$value['id'],'a.isdel'=>0,'a.varname'=>'note'))->field("a.id as vid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->order(array('a.id'=>'desc'))->select();
            $data[$key]['reviewlist']=!empty($reviewlist)?$reviewlist:"";
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $data[$key]['iscollect']=1;
            }else{
                $data[$key]['iscollect']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $data[$key]['ishit']=1;
            }else{
                $data[$key]['ishit']=0;
            }
        }
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
        }else{
            exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
        }
    }
    /**
     *我的游记列表
     */
    public function get_mynote(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($uid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.uid']=$uid;
            $where['a.status']=2;
            $where['a.isdel']=0;
            $where['a.isoff']=0;
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $count=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)->count();
            $list=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.description,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.status,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->page($p,$num)->select();
            foreach ($list as $key => $value)
            {
            	if(empty($value['reviewnum'])) $list[$key]['reviewnum']=0;
                $collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['id']))->count();
                $list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
            }
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *我的游记列表
     */
    public function get_releasenote(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($uid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.uid']=$uid;
            $where['a.isdel']=0;
            $where['a.isoff']=0;
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $count=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)->count();
            $list=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.description,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.status,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->page($p,$num)->select();
            foreach ($list as $key => $value)
            {
                if(empty($value['reviewnum'])) $list[$key]['reviewnum']=0;
                $collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['id']))->count();
                $list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
            }
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *查看游记
     */
    public function show(){
        $ret= file_get_contents('php://input');
        $ret=json_decode($ret,true);
        $id=intval(trim($ret['id']));
        $uid=intval(trim($ret['uid']));
        if($id==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            M('Note')->where(array('id'=>$id))->setInc("view");
            
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where(array('a.id'=>$id))
                ->field('a.id,a.title,a.description,a.thumb,a.area,a.city,a.address,a.lat,a.lng,a.hit,a.imglist as content,a.begintime,a.endtime,a.fee,a.man,a.style,a.days,a.status,a.remark,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->find();
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            $data['content']=json_decode($data['content'],true);
            $reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'note'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->order(array('a.id'=>'desc'))->select();
            $data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$data['id']))->find();
            !empty($collectstatus)?$data['iscollect']=1:$data['iscollect']=0;

            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$data['id']))->find();
            !empty($hitstatus)?$data['ishit']=1:$data['ishit']=0;

            $note_place=M('tags_content a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.varname'=>'note','a.contentid'=>$data['id'],'a.type'=>'place'))->field("a.place as title,a.hid,b.title as hostel,b.city,'place' as type,b.uid")->select();
            $data['note_place']=!empty($note_place)?$note_place:null;

            $note_hostel=M('tags_content a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.varname'=>'note','a.contentid'=>$data['id'],'a.type'=>'hostel'))->field("a.hostel as title,a.hid,a.place,b.city,'hostel' as type,b.uid")->select();
            $data['note_hostel']=!empty($note_hostel)?$note_hostel:null;
            $data['cityname'] = M('area')->where(array('id' => $data['city']))->getField('name');

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
                ->limit(5)
                ->select();
            foreach ($note_near_activity as $key => $value) {
                # code...
                $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
                $note_near_activity[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
                $note_near_activity[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
                $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
                if(!empty($joinstatus)){
                    $note_near_activity[$key]['isjoin']=1;
                }else{
                    $note_near_activity[$key]['isjoin']=0;
                }
            }
            $data['note_near_activity']=!empty($note_near_activity)?$note_near_activity:null;

            $where=array();
            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;
            $where['a.isoff']=0;

            $recoords=getcoords($data['lat'],$data['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $note_near_hostel=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
                ->limit(5)
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
                $distance=$Map->get_distance_baidu_simple("driving",$data['lat'].",".$data['lng'],$value['lat'].",".$value['lng']);
                $note_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
            }
            $data['note_near_hostel']=!empty($note_near_hostel)?$note_near_hostel:null;

            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"获取游记详情失败")));
            }
        }
    }
    /**
     *发游记
     */
    public function add(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $title=trim($ret['title']);
        $thumb=trim($ret['thumb']);
        $begintime=intval(trim($ret['begintime']));
        $endtime=intval(trim($ret['endtime']));
        $days=intval(trim($ret['days']));
        $fee=floatval(trim($ret['fee']));
        $man=intval(trim($ret['man']));
        $style=intval(trim($ret['style']));
        $area=trim($ret['area']);
        $address=trim($ret['address']);
        $city=intval(trim($ret['city']));
        $lat=floatval(trim($ret['lat']));
        $lng=floatval(trim($ret['lng']));
        $hid=trim($ret['hid']);
        $description=trim($ret['description']);
        $content=json_encode($ret['content']);
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($uid==''||$title==''||$thumb==''||$begintime==''||$endtime==''||$days==''||$fee==''||$man==''||$style==''||$area==''||$city==''||$lat==''||$lng==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['uid']=$uid;
            $data['username']=$user['nickname'];
            $data['title']=$title;
            $data['thumb']=$thumb;
            $data['begintime']=$begintime;
            $data['endtime']=$endtime;
            $data['days']=$days;
            $data['fee']=$fee;
            $data['man']=$man;
            $data['style']=$style;
            $data['imglist']=$content;
            $data['area']=$area;
            $data['address']=$address;
            $data['city']=$city;
            $data['lat']=$lat;
            $data['lng']=$lng;
            $data['notetype']=1;
            $data['hid']=$hid;
            $data['description']=$description;
            $data['inputtime']=time();
            $data['updatetime']=time();
            $id=M("note")->add($data);
            if($id){
                $nid=$id;
                $hid=explode(",", $hid);
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
                exit(json_encode(array('code'=>200,'msg'=>"发布成功等待审核")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"发布失败")));
            }
        }
    }
    /**
     *修改
     */
    public function edit(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $nid=intval(trim($ret['id']));
        $uid=intval(trim($ret['uid']));
        $title=trim($ret['title']);
        $thumb=trim($ret['thumb']);
        $begintime=intval(trim($ret['begintime']));
        $endtime=intval(trim($ret['endtime']));
        $days=intval(trim($ret['days']));
        $fee=floatval(trim($ret['fee']));
        $man=intval(trim($ret['man']));
        $style=intval(trim($ret['style']));
        $area=trim($ret['area']);
        $address=trim($ret['address']);
        $city=intval(trim($ret['city']));
        $lat=floatval(trim($ret['lat']));
        $lng=floatval(trim($ret['lng']));
        $hid=trim($ret['hid']);
        $content=json_encode($ret['content']);

        $note=M('note')->where(array('id'=>$nid))->find();
        if($nid==''||$uid==''||$title==''||$thumb==''||$begintime==''||$endtime==''||$days==''||$fee==''||$man==''||$style==''||$area==''||$city==''||$lat==''||$lng==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }else{
            $data['title']=$title;
            $data['thumb']=$thumb;
            $data['begintime']=$begintime;
            $data['endtime']=$endtime;
            $data['days']=$days;
            $data['fee']=$fee;
            $data['man']=$man;
            $data['style']=$style;
            $data['imglist']=$content;
            $data['area']=$area;
            $data['address']=$address;
            $data['city']=$city;
            $data['lat']=$lat;
            $data['lng']=$lng;
            $data['hid']=$hid;
            $data['updatetime']=time();
            $data['status'] = 1;
            $data['remark']="";
            $id=M("note")->where(array('id'=>$nid))->save($data);
            if($id){
                $hid=explode(",", $hid);
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
                exit(json_encode(array('code'=>200,'msg'=>"修改成功")));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"修改失败")));
            }
        }
    }
    /**
     *评论
     */
    public function review(){
        //$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=file_get_contents("php://input");
        $ret=json_decode($ret,true);
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
                UtilController::addmessage($note['uid'],"游记评论","您的游记(".$note['title'].")被其他用户评论了","您的游记(".$note['title'].")被其他用户评论了","notereview",$note['id']);
                exit(json_encode(array('code'=>200,'msg'=>"评论成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"评论失败")));
            }
        }
    }
    /**
     *评论列表
     */
    public function get_review(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $nid=intval(trim($ret['nid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($nid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$nid;
            $where['a.isdel']=0;
            $where['a.varname']='note';
            $count=M("review a")->where($where)->count();
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order($order)
                ->field('a.id as rid,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->page($p,$num)->select();
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *删游记
     */
    public function delete(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $nid=trim($ret['nid']);
        $uid=intval(trim($ret['uid']));

        $where=array();
        $nidbox=explode(",",$nid);
        if(is_array($nidbox)){
            $where['id']=array('in',$nidbox);
        }else{
            $where['id']=array('eq',$nid);
        }
        $note=M('note')->where($where)->count();
        $where=array();
        $where['id']=$uid;
        $user=M('Member')->where($where)->find();
        if($nid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $where=array();
            $nidbox=explode(",",$nid);
            if(is_array($nidbox)){
                $where['id']=array('in',$nidbox);
            }else{
                $where['id']=array('eq',$nid);
            }
            $id=M("note")->where($where)->save(array('isdel'=>1,'deletetime'=>time()));
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"删除成功")));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"删除失败")));
            }
        }
    }
    /**
     *收藏
     */
    public function collect(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $nid=intval(trim($ret['nid']));
        $uid=intval(trim($ret['uid']));

        $note=M('note')->where(array('id'=>$nid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'note','value'=>$nid))->find();
        if($nid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($collectstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户已经收藏")));
        }else{
            $id=M("collect")->add(array(
            	'uid'=>$uid,
            	'value'=>$nid,
            	'varname'=>"note",
            	'inputtime'=>time()
            ));
            if($id){
                UtilController::addmessage($note['uid'],"游记收藏","您的游记(".$note['title'].")被其他用户收藏了","您的游记(".$note['title'].")被其他用户收藏了","notecollect",$note['id']);
                exit(json_encode(array('code'=>200,'msg'=>"收藏成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"收藏失败")));
            }
        }
    }
    /**
     *取消收藏
     */
    public function uncollect(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $nid=intval(trim($ret['nid']));
        $uid=intval(trim($ret['uid']));

        $note=M('note')->where(array('id'=>$nid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'note','value'=>$nid))->find();
        if($nid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($collectstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户尚未收藏")));
        }else{
            $id=M("collect")->delete($collectstatus['id']);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"取消收藏成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"取消收藏失败")));
            }
        }
    }
    /**
     *点赞
     */
    public function hit(){
        //$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=file_get_contents("php://input");
        $ret=json_decode($ret,true);
        $nid=intval(trim($ret['nid']));
        $uid=intval(trim($ret['uid']));

        $note=M('note')->where(array('id'=>$nid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>'note','value'=>$nid))->find();
        if($nid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($hitstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户已经点赞")));
        }else{
        	M('note')->where('id=' .$nid)->setInc("hit");
            $id=M("hit")->add(array(
            	'uid'=>$uid,
            	'value'=>$nid,
            	'varname'=>"note",
            	'inputtime'=>time()
            ));
            if($id){
                UtilController::addmessage($note['uid'],"游记点赞","您的游记(".$note['title'].")获得1个赞","您的游记(".$note['title'].")获得1个赞","notehit",$note['id']);
                exit(json_encode(array('code'=>200,'msg'=>"点赞成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"点赞失败")));
            }
        }
    }
    /**
     *取消点赞
     */
    public function unhit(){
        //$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=file_get_contents("php://input");
        $ret=json_decode($ret,true);
        $nid=intval(trim($ret['nid']));
        $uid=intval(trim($ret['uid']));

        $note=M('note')->where(array('id'=>$nid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>'note','value'=>$nid))->find();
        if($nid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($hitstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户尚未点赞")));
        }else{
        	M('note')->where('id=' .$nid)->setDec("hit");
            $id=M("hit")->delete($hitstatus['id']);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"取消点赞成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"取消点赞失败")));
            }
        }
    }
    /**
     *游记附近推荐活动列表
     */
    public function get_note_nearactivity(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $nid=intval(trim($ret['nid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        $Note=M('note')->where(array('id'=>$nid))->find();
        if($nid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }else{
            $where=array();
            
            $noteset=M("note")->where(array('id'=>$nid))->getField("id,lat,lng");

            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;
            $where['a.isoff']=0;

            $recoords=getcoords($noteset[$nid]['lat'],$noteset[$nid]['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $data=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                ->page($p,$num)
                ->select();
            foreach ($data as $key => $value) {
                # code...
                $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
                $data[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
                $data[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
                $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
                if(!empty($joinstatus)){
                    $data[$key]['isjoin']=1;
                }else{
                    $data[$key]['isjoin']=0;
                }
            }
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *游记附近推荐美宿列表
     */
    public function get_note_nearhostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $nid=intval(trim($ret['nid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        
        $Note=M('note')->where(array('id'=>$nid))->find();
        if($nid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Note)){
            exit(json_encode(array('code'=>-200,'msg'=>"游记不存在")));
        }else{
            $where=array();
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $noteset=M("note")->where(array('id'=>$nid))->getField("id,lat,lng");

            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;
            $where['a.isoff']=0;

            $recoords=getcoords($noteset[$nid]['lat'],$noteset[$nid]['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $data=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.acreage,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
                ->page($p,$num)
                ->select();
            $Map=A("Api/Map");
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
                $distance=$Map->get_distance_baidu_simple("driving",$Note['lat'].",".$Note['lng'],$value['lat'].",".$value['lng']);
                $data[$key]['distance']=!empty($distance)?$distance:0.00;
            }
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    public function get_myhostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));

        if($uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
          /*
            $data=M('book_room a')
            ->join("left join zz_hostel b on a.hid=b.id")
            ->order(array('b.listorder'=>'desc','b.id'=>'desc'))
            ->group("a.hid")
            ->field("b.id,b.title")->select();
            if(empty($data)){
            */
            $data=M('Hostel')->where(array('status'=>2,'isdel'=>0,'isoff'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->field("id,title")->select();
            //}
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
}
