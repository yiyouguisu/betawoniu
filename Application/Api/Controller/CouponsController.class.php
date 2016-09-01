<?php

namespace Api\Controller;

use Api\Common\CommonController;

class CouponsController extends CommonController {

	/*
     **我的优惠券列表
     */
    public function get_mycoupons() {
		$ret = $GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));
        $hid = intval(trim($ret['hid']));
        $aid = intval(trim($ret['aid']));
        $city = intval(trim($ret['city']));
		$num=intval(trim($ret['num']));
        $p=intval(trim($ret['p']));

		$user=M('Member')->where(array('id'=>$uid))->find();
		if ($uid == ''||$p == '' ||$num == '') {
		    exit(json_encode(array('code' => -200, 'msg' => "Request parameter is null!")));
		} elseif(!$user){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		} else{
            $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
            if(!empty($hid)){
                $city=M('hostel')->where(array('id'=>$hid))->getField("city");
                $where=array();
                $where['a.uid']=$uid;
                $where['_string']="(b.voucherstype='hostel' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.hid LIKE '%,".$hid.",%')))";
                $where['b.id']=array('in',$catids);
                $data = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,a.price,a.hid,a.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->page($p,$num)->select();
            }elseif(!empty($aid)){
                $city=M('activity')->where(array('id'=>$hid))->getField("city");
                $where=array();
                $where['a.uid']=$uid;
                $where['_string']="(b.voucherstype='party' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%'))) or (b.voucherstype='all' and (b.voucherscale='all' or (b.voucherscale='area' and city='".$city."') or (b.voucherscale='assign' and a.aid LIKE '%,".$aid.",%')))";
                $where['b.id']=array('in',$catids);
                $data = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,a.price,a.hid,a.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->page($p,$num)->select();
            }elseif(!empty($city)){
                $data = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.uid'=>$uid,'b.city'=>array('eq',$city),'b.id'=>array('in',$catids)))->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,a.price,a.hid,a.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->page($p,$num)->select();
            }else{
                $data = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where(array('a.uid'=>$uid,'b.id'=>array('in',$catids)))->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,a.price,a.hid,a.aid,b.city,b.`range`,b.validity_endtime,a.`status`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))->page($p,$num)->select();
            }
            //$data['sql']=M('vouchers_order a')->_sql();
		    if ($data) {
				exit(json_encode(array('code' => 200, 'msg' => "success", 'data' => $data)));
		    } else {
				exit(json_encode(array('code' => -201, 'msg' => "暂无优惠券")));
		    }
		}
    }
    /*
     **优惠券详情
     */
    public function show(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $id=intval(trim($ret['id']));
        if($id==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }else{
            $data = M('vouchers_order a')
                ->join("left join zz_vouchers b on a.catid=b.id")
                ->where(array('a.id'=>$id))
                ->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,a.price,a.hid,a.aid,b.city,b.`range`,b.validity_endtime,a.`status`,b.`range`,b.content")->find();
            if(!empty($data['city'])){
                $data['cityname']=M('area')->where(array('id'=>$data['city']))->getField("name");
            }
            if(!empty($data['hid'])){
               $data['hostel']=M('hostel')->where(array('id'=>array('in',trim($data['hid'],','))))->getField("title",true); 
            }
            if(!empty($data['aid'])){
                $data['party']=M('Activity')->where(array('id'=>array('in',trim($data['aid'],','))))->getField("title",true); 
            }
            
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-200,'msg'=>"获取详情失败")));
            }
        }
    }
}
