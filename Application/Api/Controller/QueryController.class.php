<?php

namespace Api\Controller;

use Api\Common\CommonController;

class QueryController extends CommonController {

	/**
	 * 首页搜索
	 */
	public function search(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
        $keyword=trim($ret['keyword']);
        $city=intval(trim($ret['city']));


        if($keyword==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $where=array();
            // if(!empty($city)){
            //     $where['a.city']=$city;
            // }
            if(!empty($keyword)){
                $where['a.title']=array("like","%".$keyword."%");
            }

            $order=array('a.id'=>'desc');
            $where['a.isdel']=0;

            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $note=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.thumb,a.area,a.city,a.address,a.lat,a.lng,a.hit,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->select();
            foreach ($note as $key => $value) {
                # code...
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
            $note=!empty($note)?$note:array();


            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'house'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $house=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.acreage,a.address,a.lat,a.lng,a.hit,a.bookremark,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
                ->select();
            foreach ($house as $key => $value) {
                # code...
                $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"house",'value'=>$value['id']))->find();
                if(!empty($collectstatus)){
                    $house[$key]['iscollect']=1;
                }else{
                    $house[$key]['iscollect']=0;
                }
                $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"house",'value'=>$value['id']))->find();
                if(!empty($hitstatus)){
                    $house[$key]['ishit']=1;
                }else{
                    $house[$key]['ishit']=0;
                }
            }
            $house=!empty($house)?$house:array();


            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'party'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $party=M("Activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
                ->select();
            foreach ($party as $key => $value) {
                # code...
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
                $joinstatus=M('activity_apply')->where(array('aid'=>$value['id'],'uid'=>$uid,'paystatus'=>1))->find();
                if(!empty($joinstatus)){
                    $data[$key]['isjoin']=1;
                }else{
                    $data[$key]['isjoin']=0;
                }
            }
            $party=!empty($party)?$party:array();
            $data=array('note'=>$note,'party'=>$party,'house'=>$house);
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"无符合要求数据")));
            }
        }
    }
}
