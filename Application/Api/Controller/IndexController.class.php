<?php

namespace Api\Controller;

use Api\Common\CommonController;

class IndexController extends CommonController {
    
    public function index() {

        $Refund=A("Api/Refund");
        $paycharge=$Refund->refund("201608200901564913838","0.01","0.01","20160902153942167","unionpay");
        dump($paycharge);die;
        
        $data['phone'] = '15225071509';
        $data['password']='123456';

        $keyStr = '2b8L3j5b0H';
        echo "md5密钥：";
        dump(md5($keyStr));

        $postUrl = 'http://' . $_SERVER['HTTP_HOST'].U('Api/Member/test');

        echo "传输json数据：";
        dump(json_encode($data));

        echo "传输加密json数据：";
        dump(json_encode(array('data'=>CommonController::encrypt_des($data))));

        $res = https_request($postUrl,json_encode(array('data'=>CommonController::encrypt_des($data))));
        echo "返回解密前json数据：";
        dump($res);

        $res = json_decode($res,true);
        echo "格式化数据：";
        dump($res);

        echo "解密后数据：";
        dump(CommonController::decrypt_des($res['data']));
    }
    public function test(){
        $ids=M('area')->where(array('parentid'=>0,'id'=>array('not in','2,3,4,5')))->getField("id",true);
        $map['parentid']  = array("in",$ids);
        $map['id']  = array('in','2,3,4,5');
        $map['_logic'] = 'or';
        $where['_complex'] = $map;
        $data = M("area")->where($where)->field('id,name')->select();
        foreach ($data as $value)
        {
             $fletter=substr(Pinyin($value['name'],1), 0, 1);
             $fletter=strtoupper($fletter);
             M('area')->where(array('id'=>$value['id']))->setField("fletter",$fletter);
        }
    }
    /**
     *首页推荐列表
     */
    public function pushindex(){
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
        $where['a.isindex']=1;
        $where['a.isdel']=0;
        $where['a.isoff']=0;
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $note=M("Note a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>'desc'))
            ->field('a.id,a.title,a.description,a.thumb,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,a.type,c.reviewnum')
            ->select();
        foreach ($note as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $note[$key]['reviewnum']=0;
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
        $sqlII=M('review')->where(array('isdel'=>0,'varname'=>'party'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $party=M("activity a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlII} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->select();
        foreach ($party as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $party[$key]['reviewnum']=0;
            $joinnum=M('activity_apply')->where(array('aid'=>$value['id'],'paystatus'=>1))->sum("num");
            $party[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
            $joinlist=M('activity_apply a')->join("left join zz_member b on a.uid=b.id")->where(array('a.aid'=>$value['id'],'a.paystatus'=>1))->field("b.id,b.nickname,b.head,b.rongyun_token")->select();
            $party[$key]['joinlist']=!empty($joinlist)?$joinlist:null;
            $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
            if(!empty($joinstatus)){
                $party[$key]['isjoin']=1;
            }else{
                $party[$key]['isjoin']=0;
            }
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
        }
        $sqlIII=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
        $house=M("hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlIII} c on a.id=c.value")
            ->where($where)
            ->order(array('id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->select();
        $Map=A("Api/Map");
        foreach ($house as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $house[$key]['reviewnum']=0;
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $house[$key]['iscollect']=1;
            }else{
                $house[$key]['iscollect']=0;
            }
            $distance=$Map->get_distance_baidu_simple("driving",$lat.",".$lng,$value['lat'].",".$value['lng']);
            $house[$key]['distance']=!empty($distance)?$distance:0.00;
            $evaluation=gethouse_evaluation($value['id']);
            $house[$key]['evaluation']=!empty($evaluation['evaluation'])?$evaluation['evaluation']:0.0;
            $house[$key]['evaluationpercent']=!empty($evaluation['percent'])?$evaluation['percent']:0.00;
        }
        $data=array("note"=>$note,'party'=>$party,'house'=>$house);
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
        }else{
            exit(json_encode(array('code'=>-200,'msg'=>"无符合要求数据")));
        }
    }
}