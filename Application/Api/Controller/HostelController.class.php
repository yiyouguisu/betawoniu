<?php
namespace Api\Controller;

use Api\Common\CommonController;

class HostelController extends CommonController {
    /**
     *美宿特色
     */
    public function get_hostelcate(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("hostelcate")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *美宿类型
     */
    public function get_hosteltype(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("hosteltype")->field('id,catname')->order(array('listorder'=>'desc','id'=>'asc'))->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *面积配置
     */
    public function get_area(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("linkage")->where("catid=7")->field('value,name')->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *评分配置
     */
    public function get_evaluation(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $data = M("linkage")->where("catid=8")->field('value,name')->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /**
     *美宿列表
     */
    public function get_hostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        $area=trim($ret['area']);
        $money=trim($ret['money']);
        $catid=intval(trim($ret['catid']));
        $style=intval(trim($ret['style']));
        $bedtype=intval(trim($ret['bedtype']));
        $support=intval(trim($ret['support']));
        $acreage=trim($ret['acreage']);
        $score=trim($ret['score']);
        $lat=floatval(trim($ret['lat']));
        $lng=floatval(trim($ret['lng']));

        if($p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $where['a.status']=2;
            $where['a.isdel']=0;
            if(!empty($area)){
                $where['a.area']=$area;
            }
            if(!empty($catid)){
                $where['a.catid']=$catid;
            }
            if(!empty($style)){
                $where['a.style']=$style;
            }
            if(!empty($money)){
                $moneybox=explode("|", $money);
                if(is_array($moneybox)&&count($moneybox)>1){
                    if($moneybox[0]==0){
                        $where['a.money'] = array('ELT', $moneybox[1]);
                    }elseif($moneybox[1]==0){
                        $where['a.money'] = array('EGT', $moneybox[0]);
                    }else{
                        $where['a.money'] = array(array('EGT', $moneybox[0]), array('ELT', $moneybox[1]));
                    }
                    
                }else{
                    $where['a.money'] =$money;
                }
            }
            if(!empty($acreage)){
                $acreagebox=explode("|", $acreage);
                if(is_array($acreagebox)&&count($acreagebox)>1){
                    $where['a.acreage'] = array(array('EGT', $acreagebox[0]), array('ELT', $acreagebox[1]));
                }else{
                    $where['a.acreage'] =$acreage;
                }
            }
            if(!empty($score)){
                $where['a.score'] =array('EGT', $score);
            }
            if(!empty($support)){
                $where['a.support']=array('like',"%,".$support.",%");
                // $select=array();
                // $select["_string"]="concat(',',b.support,',') LIKE '%,".$support.",%'";
                // $hidbox=M('room b')->join("left join zz_hostel a on b.hid=a.id")->distinct(true)->where($where)->where($select)->getField("b.hid",true);
            }
            if(!empty($bedtype)){
                $where['a.bedtype']=array('like',"%,".$bedtype.",%");
            }
            
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.acreage,a.address,a.lat,a.lng,a.hit,a.bookremark,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
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
                $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
                $data[$key]['distance']=!empty($distance)?$distance:0.00;
            }
            $hostelnum=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)->count();

            $hidbox=M("Hostel a")->where($where)->getField("id",true);
            $where=array();
            $where['a.hid']=array('in',$hidbox);
            $where['a.isdel']=0;
            if(!empty($support)){
                $where['a.support']=array('like',"%,".$support.",%");
            }
            if(!empty($bedtype)){
                $where['a.bedtype']=array('like',"%,".$bedtype.",%");
            }
            if(!empty($money)){
                $moneybox=explode("|", $money);
                if(is_array($moneybox)&&count($moneybox)>1){
                    $where['a.money'] = array(array('EGT', $moneybox[0]), array('ELT', $moneybox[1]));
                }else{
                    $where['a.money'] =$money;
                }
            }
            $roomnum=M("room a")->where($where)->count();
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data,'hostelnum'=>$hostelnum,'roomnum'=>$roomnum)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *美宿列表
     */
    public function get_hostel_map(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $area=trim($ret['area']);
        $money=trim($ret['money']);
        $catid=intval(trim($ret['catid']));
        $style=intval(trim($ret['style']));
        $bedtype=intval(trim($ret['bedtype']));
        $support=intval(trim($ret['support']));
        $acreage=trim($ret['acreage']);
        $score=trim($ret['score']);
        $lat=floatval(trim($ret['lat']));
        $lng=floatval(trim($ret['lng']));
        $radis=floatval(trim($ret['radis']));

        if($lat==''||$lng==''||$radis==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $where['a.status']=2;
            $where['a.isdel']=0;
            if(!empty($area)){
                $where['a.area']=$area;
            }
            if(!empty($catid)){
                $where['a.catid']=$catid;
            }
            if(!empty($style)){
                $where['a.style']=$style;
            }
            if(!empty($money)){
                $moneybox=explode("|", $money);
                if(is_array($moneybox)&&count($moneybox)>1){
                    $where['a.money'] = array(array('EGT', $moneybox[0]), array('ELT', $moneybox[1]));
                }else{
                    $where['a.money'] =$money;
                }
            }
            if(!empty($acreage)){
                $acreagebox=explode("|", $acreage);
                if(is_array($acreagebox)&&count($acreagebox)>1){
                    $where['a.acreage'] = array(array('EGT', $acreagebox[0]), array('ELT', $acreagebox[1]));
                }else{
                    $where['a.acreage'] =$acreage;
                }
            }
            if(!empty($score)){
                $where['a.score'] =array('EGT', $score);
            }
            if(!empty($support)){
                $where['a.support']=array('like',"%,".$support.",%");
                // $select=array();
                // $select["_string"]="concat(',',b.support,',') LIKE '%,".$support.",%'";
                // $hidbox=M('room b')->join("left join zz_hostel a on b.hid=a.id")->distinct(true)->where($where)->where($select)->getField("b.hid",true);
            }
            if(!empty($bedtype)){
                $where['a.bedtype']=array('like',"%,".$bedtype.",%");
            }
            
            $recoords=getcoords($lat,$lng,$radis);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.bookremark,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
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
                $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
                $data[$key]['distance']=!empty($distance)?$distance:0.00;
            }
            $hostelnum=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)->count();

            $hidbox=M("Hostel a")->where($where)->getField("id",true);
            $where=array();
            $where['a.hid']=array('in',$hidbox);
            $where['a.isdel']=0;
            if(!empty($support)){
                $where['a.support']=array('like',"%,".$support.",%");
            }
            if(!empty($bedtype)){
                $where['a.bedtype']=array('like',"%,".$bedtype.",%");
            }
            if(!empty($money)){
                $moneybox=explode("|", $money);
                if(is_array($moneybox)&&count($moneybox)>1){
                    $where['a.money'] = array(array('EGT', $moneybox[0]), array('ELT', $moneybox[1]));
                }else{
                    $where['a.money'] =$money;
                }
            }
            $roomnum=M("room a")->where($where)->count();
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data,'hostelnum'=>$hostelnum,'roomnum'=>$roomnum)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *首页推荐美宿列表
     */
    public function get_pushhostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $city=intval(trim($ret['city']));
        $lat=floatval(trim($ret['lat']));
        $lng=floatval(trim($ret['lng']));

        $where=array();
        if(!empty($city)){
            $where['a.city']=$city;
        }
        $where['a.status']=2;
        $where['a.index']=1;
        $where['a.isdel']=0;
        $data=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
            ->limit(3)
            ->select();
        $Map=A("Api/Map");
        foreach ($data as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $note[$key]['reviewnum']=0;
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
            $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            $data[$key]['distance']=!empty($distance)?$distance:0.00;
        }
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
        }else{
            exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
        }
    }
    /**
     *我的美宿列表
     */
    public function get_myhostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($uid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $where['a.uid']=$uid;
            $where['a.status']=2;
            $where['a.isdel']=0;
            $count=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->count();
            $list=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.acreage,a.bedtype,a.thumb,a.money,a.status,a.uid,a.inputtime')->page($p,$num)->select();
            foreach ($list as $key => $value) {
                # code...
                $list[$key]['bedtype']=trim($value['bedtype'],",");
            }
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *我的美宿列表
     */
    public function get_releasehostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($uid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $where['a.uid']=$uid;
            $where['a.isdel']=0;
            $count=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->count();
            $list=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.acreage,a.bedtype,a.thumb,a.money,a.status,a.uid,a.inputtime')->page($p,$num)->select();
            foreach ($list as $key => $value) {
                # code...
                $list[$key]['bedtype']=trim($value['bedtype'],",");
            }
            $data=array('num'=>$count,'data'=>$list);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     *美宿下架
     */
    public function off(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $hid=trim($ret['hid']);
        $uid=intval(trim($ret['uid']));

        $where=array();
        $hidbox=explode(",",$hid);
        if(is_array($hidbox)){
            $where['id']=array('in',$hidbox);
        }else{
            $where['id']=array('eq',$hid);
        }
        $Hostel=M("Hostel")->where($where)->count();
        $where=array();
        $where['id']=$uid;
        $user=M('Member')->where($where)->find();
        if($hid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $where=array();
            $hidbox=explode(",",$hid);
            if(is_array($hidbox)){
                $where['id']=array('in',$hidbox);
            }else{
                $where['id']=array('eq',$hid);
            }
            $id=M("Hostel")->where($where)->save(array('isdel'=>1,'deletetime'=>time()));
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"下架成功")));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"下架失败")));
            }
        }
    }
    /**
     *查看美宿
     */
    public function show(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $id=intval(trim($ret['id']));
        $uid=intval(trim($ret['uid']));
        $lat=floatval(trim($ret['lat']));
        $lng=floatval(trim($ret['lng']));

        if($id==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            M('Hostel')->where(array('id'=>$id))->setInc("view");
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where(array('a.id'=>$id))
            ->field('a.id,a.title,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.money,a.description,a.content,a.bookremark,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.bookremark,a.vouchersrange,a.vouchersdiscount,a.status,a.remark,a.uid,b.nickname,b.head,b.realname_status,b.realname_status,b.houseowner_status,b.rongyun_token,a.inputtime,c.reviewnum')
            ->find();
            if(empty($data['reviewnum'])) $data['reviewnum']=0;
            $evaluation=gethouse_evaluation($data['id']);
            // $house['evaluation']=!empty($evaluation['evaluation'])?$evaluation['evaluation']:0.0;
            // $house['evaluationpercent']=!empty($evaluation['percent'])?$evaluation['percent']:0.00;
            $data['evaluationset']=$evaluation;
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

            $note_hostel=M('tags_content a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.varname'=>'hostel','a.contentid'=>$data['id'],'a.type'=>'hostel'))->field("a.title,a.hid,a.place,b.city,'hostel' as type")->find();
            $data['note_hostel']=!empty($note_hostel)?$note_hostel:null;
            $Map=A("Api/Map");
            $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$data['lat'].",".$data['lng']);
            $data['distance']=!empty($distance)?$distance:0.00;
            //$reviewlist=M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value'=>$data['id'],'a.isdel'=>0,'a.varname'=>'hostel'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->limit(10)->select();
            //$data['reviewlist']=!empty($reviewlist)?$reviewlist:null;
            $room=M('room')->where(array('hid'=>$data['id']))->order(array('id'=>'desc'))->field("id as rid,title,thumb,area,money,roomtype,support")->select();
            $data['room']=!empty($room)?$room:null;

            $support=array();
            foreach ($room as $key => $value) {
                # code...
                $supportex=explode(",", $value['support']);
                $support=array_merge($support,$supportex);
            }
            $support=array_unique($support);

            $data['support']=!empty($support)?implode(",", $support):null;
            $roomnum=M('room')->where(array('hid'=>$data['id']))->count();
            $data['roomnum']=!empty($roomnum)?$roomnum:0;

            $where=array();
            $where['a.status']=2;
            $where['a.uid']=$data['uid'];
            $where['a.isdel']=0;
            $house_owner_activity=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                ->limit(5)
                ->select();
            foreach ($house_owner_activity as $key => $value) {
                # code...
                $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
                $house_owner_activity[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
                $house_owner_activity[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
                $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
                if(!empty($joinstatus)){
                    $house_owner_activity[$key]['isjoin']=1;
                }else{
                    $house_owner_activity[$key]['isjoin']=0;
                }
            }
            $data['house_owner_activity']=!empty($house_owner_activity)?$house_owner_activity:null;

            $where=array();
            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;

            $recoords=getcoords($data['lat'],$data['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $house_near_activity=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                ->limit(5)
                ->select();
            foreach ($house_near_activity as $key => $value) {
                # code...
                $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
                $house_near_activity[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id.b.nickname,b.head,b.rongyun_token")->select();
                $house_near_activity[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
                $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
                if(!empty($joinstatus)){
                    $house_near_activity[$key]['isjoin']=1;
                }else{
                    $house_near_activity[$key]['isjoin']=0;
                }
            }
            $data['house_near_activity']=!empty($house_near_activity)?$house_near_activity:null;

            $where=array();
            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;

            $recoords=getcoords($data['lat'],$data['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $house_near_hostel=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
                ->limit(5)
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
                $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
                $house_near_hostel[$key]['distance']=!empty($distance)?$distance:0.00;
            }
            $data['house_near_hostel']=!empty($house_near_hostel)?$house_near_hostel:null;

            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"获取美宿详情失败")));
            }
        }
    }
    
    /**
     *评论
     */
    public function review(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $hid=intval(trim($ret['hid']));
        $uid=intval(trim($ret['uid']));
        $content=trim($ret['content']);

        $Hostel=M('Hostel')->where(array('id'=>$hid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        if($hid==''||$uid==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $data['value']=$hid;
            $data['uid']=$uid;
            $data['content']=$content;
            $data['varname']='hostel';
            $data['inputtime']=time();
            $id=M("review")->add($data);
            if($id){
                UtilController::addmessage($Hostel['uid'],"美宿评论","您的美宿(".$Hostel['title'].")被其他用户评论了","您的美宿(".$Hostel['title'].")被其他用户评论了","hostelreview",$Hostel['id']);
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
        $hid=intval(trim($ret['hid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        if($hid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.value']=$hid;
            $where['a.isdel']=0;
            $where['a.varname']='hostel';
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
     *收藏
     */
    public function collect(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $hid=intval(trim($ret['hid']));
        $uid=intval(trim($ret['uid']));

        $hostel=M('Hostel')->where(array('id'=>$hid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'hostel','value'=>$hid))->find();
        if($hid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($collectstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户已经收藏")));
        }else{
            $id=M("collect")->add(array(
            	'uid'=>$uid,
            	'value'=>$hid,
            	'varname'=>"hostel",
            	'inputtime'=>time()
            ));
            if($id){
                UtilController::addmessage($hostel['uid'],"美宿收藏","您的美宿(".$hostel['title'].")被其他用户收藏了","您的美宿(".$hostel['title'].")被其他用户收藏了","hostelcollect",$hostel['id']);
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
        $hid=intval(trim($ret['hid']));
        $uid=intval(trim($ret['uid']));

        $hostel=M('Hostel')->where(array('id'=>$hid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>'hostel','value'=>$hid))->find();
        if($hid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
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
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $hid=intval(trim($ret['hid']));
        $uid=intval(trim($ret['uid']));

        $hostel=M('Hostel')->where(array('id'=>$hid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>'hostel','value'=>$hid))->find();
        if($hid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($hitstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户已经点赞")));
        }else{
            M('Hostel')->where('id=' .$hid)->setInc("hit");
            $id=M("hit")->add(array(
                'uid'=>$uid,
                'value'=>$hid,
                'varname'=>"hostel",
                'inputtime'=>time()
            ));
            if($id){
                UtilController::addmessage($hostel['uid'],"美宿点赞","您的美宿(".$hostel['title'].")获得1个赞","您的美宿(".$hostel['title'].")获得1个赞","hostelhit",$hostel['id']);
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
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $hid=intval(trim($ret['hid']));
        $uid=intval(trim($ret['uid']));

        $hostel=M('Hostel')->where(array('id'=>$hid))->find();
        $user=M('Member')->where(array('id'=>$uid))->find();
        $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>'hostel','value'=>$hid))->find();
        if($hid==''||$uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($hitstatus)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户尚未点赞")));
        }else{
            M('Hostel')->where('id=' .$hid)->setDec("hit");
            $id=M("hit")->delete($hitstatus['id']);
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"取消点赞成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"取消点赞失败")));
            }
        }
    }
    /**
     *房东发布活动列表
     */
    public function get_hostel_activity(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $hid=intval(trim($ret['hid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        $Hostel=M('Hostel')->where(array('id'=>$hid))->find();
        if($hid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }else{
            $where=array();
            $hosteluid=M("Hostel")->where(array('id'=>$hid))->getField("uid");
            $where['a.status']=2;
            $where['a.uid']=$hosteluid;
            $where['a.isdel']=0;
            $data=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)->order(array('id'=>"desc"))
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
     *美宿附近推荐活动列表
     */
    public function get_hostel_nearactivity(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $hid=intval(trim($ret['hid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));

        $Hostel=M('Hostel')->where(array('id'=>$hid))->find();
        if($hid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }else{
            $where=array();
            
            $hostelset=M("Hostel")->where(array('id'=>$hid))->getField("id,lat,lng");
            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;

            $recoords=getcoords($hostelset[$hid]['lat'],$hostelset[$hid]['lng'],2);
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
     *美宿附近推荐美宿列表
     */
    public function get_hostel_nearhostel(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $hid=intval(trim($ret['hid']));
        $p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        
        $Hostel=M('Hostel')->where(array('id'=>$hid))->find();
        if($hid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($Hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }else{
            $where=array();
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $hostelset=M("Hostel")->where(array('id'=>$hid))->getField("id,lat,lng");

            $where['a.status']=2;
            $where['a.type']=1;
            $where['a.isdel']=0;

            $recoords=getcoords($hostelset[$hid]['lat'],$hostelset[$hid]['lng'],2);
            $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
            $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
            $data=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
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
                $distance=$Map->get_distance_baidu_simple("driving",$Hostel['lat'].",".$Hostel['lng'],$value['lat'].",".$value['lng']);
                $data[$key]['distance']=!empty($distance)?$distance:0.00;
            }
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
        }
    }
    /**
     * 获取房东的基本信息
     */
    public function get_houseowner_info(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $hid = intval(trim($ret['hid']));

        $Hostel=M('Hostel')->where(array('id'=>$hid))->find();
        if($hid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($Hostel)){
            exit(json_encode(array('code'=>-200,'msg'=>"美宿不存在")));
        }else{
            $hosteluid=M("Hostel")->where(array('id'=>$hid))->getField("uid");
            $user=M('Member')->where(array('id'=>$hosteluid))->find();

            $data=array();
            $data['uid'] = $user['id'];
            $data['username'] = $user['username'];
            $data['head'] = $user['head'];
            $data['nickname'] = $user['nickname'];
            $data['phone'] = $user['phone'];
            $data['sex'] = $user['sex'];
            $data['birthday'] = $user['birthday'];
            $data['hometown'] = $user['hometown'];
            $data['area'] = $user['area'];
            $data['education'] = $user['education'];
            $data['school'] = $user['school'];
            $data['zodiac'] = $user['zodiac'];
            $data['constellation'] = $user['constellation'];
            $data['bloodtype'] = $user['bloodtype'];
            $data['realname_status'] = $user['realname_status'];
            $data['houseowner_status'] = $user['houseowner_status'];
            $data['rongyun_token']=$user['rongyun_token'];

            $hostel=M('hostel')
                ->where(array('uid'=>$hosteluid,'status'=>2,'isdel'=>0))
                ->order(array('id'=>'desc'))
                ->field("id,title,thumb,money,area,address,lat,lng,hit,support,score as evaluation,scorepercent as evaluationpercent")
                ->select();
            $data['hostel']=!empty($hostel)?$hostel:null;
            
            $replyasknum=M('bookask')->where(array('tuid'=>$hosteluid,'status'=>1))->count();
            $totalasknum=M('bookask')->where(array('tuid'=>$hosteluid))->count();
            $onlinereply=($replyasknum/$totalasknum)*100;
            $data['onlinereply']=!empty($onlinereply)?sprintf("%.2f",$onlinereply):"100.00";

            $evaluationconfirm=M()->query("SELECT AVG(b.sufftime) FROM(SELECT(b.review_time - b.inputtime) / 60 AS sufftime FROM zz_book_room a LEFT JOIN zz_order_time b ON a.orderid = b.orderid LEFT JOIN zz_hostel c ON a.hid = c.id WHERE(b.status = 4)AND (b.review_status > 0)AND (c.uid = ".$hosteluid.")) b");
            $data['evaluationconfirm']=!empty($evaluationconfirm)?sprintf("%.2f",$evaluationconfirm):"0.0";

            $successordernum=M('book_room a')->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_hostel c on a.hid=c.id")->where(array('c.uid'=>$hosteluid,'b.review_status'=>1,'b.status'=>array('not in','1,5')))->count();
            $totalordernum=M('book_room a')->join("left join zz_order_time b on a.orderid=b.orderid")->join("left join zz_hostel c on a.hid=c.id")->where(array('c.uid'=>$hosteluid))->count();
            $orderconfirm=($successordernum/$totalordernum)*100;
            $data['orderconfirm']=!empty($orderconfirm)?sprintf("%.2f",$orderconfirm):"100.00";
            if($data){
                exit(json_encode(array('code' => 200, 'msg' => "获取数据成功", 'data' =>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
            }
            
        }
    }
}