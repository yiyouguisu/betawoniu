<?php

namespace Wx\Controller;

use Wx\Common\CommonController;

class ChoujiangController extends CommonController {

    
    public function make() {
        $nowtime=time();
        $party_starttime=M('config')->where(array('varname'=>'party_starttime'))->getField("value");
        $party_endtime=M('config')->where(array('varname'=>'party_endtime'))->getField("value");
        $party_starttime=strtotime($party_starttime);
        $party_endtime=strtotime($party_endtime);
        $uid=session("uid");
        $user=M('Member')->where(array('id'=>$uid))->find();
        if(!$uid){
            $data['status']=0;
            $data['content']="请先登录！";
            $this->ajaxReturn($data);
        }
        if($nowtime<$party_starttime){
            $data['status']=0;
            $data['content']="还没有到抽奖时间！";
            $this->ajaxReturn($data);
        }
        if($nowtime>$party_endtime){
            $data['status']=0;
            $data['content']="抽奖已结束！";
            $this->ajaxReturn($data);
        }
        //$where=array();
        //$where['a.uid']=$uid;
        //$where['a.status']=0;
        //$where['b.validity_endtime']=array('gt',time());
        //$where['b.id']=array('in','4,5');
        //$couponsmoney = M('coupons_order a')->join("left join zz_coupons b on a.catid=b.id")->where($where)->sum("b.price");
        //if($couponsmoney<=100){
        //    $data['status']=0;
        //    $data['content']="没有抽奖资格！";
        //    $this->ajaxReturn($data);
        //}
        //$where=array();
        //$starttime=mktime(0,0,0,(int)date("m"),(int)date("d"),(int)date("Y"));
        //$endtime=mktime(23,59,59,(int)date("m"),(int)date("d"),(int)date("Y"));
        //$where['uid']=$uid;
        //$where['inputtime']=array(array('egt',$starttime),array('elt',$endtime));
        //$status=M('choujianglog')->where($where)->count();
        //if($status>0){
        //    $data['status']=0;
        //    $data['content']="您今天已经抽过奖！";
        //    $this->ajaxReturn($data);
        //}
        //$starttime=strtotime("-7 days");
        //$endtime=$nowtime;
        //$where['inputtime']=array(array('egt',$starttime),array('elt',$endtime));
        //$status=M('choujianglog')->where($where)->count();
        //$party_week_num=M('config')->where(array('varname'=>'party_week_num'))->getField("value");
        //if($status>=$party_week_num){
        //    $data['status']=0;
        //    $data['content']="您最近七天抽奖次数已用完！";
        //    $this->ajaxReturn($data);
        //}
        $prize_arr= M('gift')->field('id,rank,prize,v,min,max,validity_starttime,validity_endtime,remark')->order(array('v'=>asc))->select();
        foreach ($prize_arr as $val) {
            $arr[$val['rank']] = $val['v'];
        }
        $rid = $this->get_rand($arr); 
        
        $str =$prize_arr[$rid-1]['remark'];
        $data=array(
            'rid'=>$rid,
            'uid'=>$user['id'],
            'inputtime'=>time()
        );  
        M('choujianglog')->add($data);
        
        if($rid!=6){
            $coupons['vaid']=0;
            $coupons['uid']=$user['id'];
            $coupons['catid']=$rid;
            $coupons['num']=1;
            $coupons['inputtime']=time();
            $coupons['updatetime']=time();
            M('coupons_order')->add($coupons);
        }
        

        $data['status']=1;
        $data['content']=$str;
        $data['rid']=$rid;

        $min = $prize_arr[$rid-1]['min']; 
        $max = $prize_arr[$rid-1]['max']; 
        $data['angle'] = mt_rand($min, $max); //随机生成一个角度  

        $this->ajaxReturn($data);
        
    }
    private function get_rand($proArr) {
        $result = '';
        $proSum = array_sum($proArr);
        foreach ($proArr as $key => $proCur) {
            $randNum = mt_rand(1, $proSum);
            if ($randNum <= $proCur) {
                $result = $key;
                break;
            } else {
                $proSum -= $proCur;
            }
        }
        unset($proArr);
        return $result;
    }
}