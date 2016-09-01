<?php

namespace Api\Controller;

use Api\Common\CommonController;

class AdController extends CommonController {

	/* 首页广告 */

    public function get_index_banner() {
    	$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);

        $data=M("ad")->where(array('status'=>1,'catid'=>4))->order(array('listorder'=>"desc",'id'=>"desc"))->field('id,title,image,hid,aid,nid,url,type,content,description,inputtime')->select();
        if($data){
            exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }

    /*
        安卓引导图
    */

    public function get_android_banner() {
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);

        $list=M("ad")->where(array('status'=>1,'catid'=>14))->order(array('listorder'=>"desc",'id'=>"asc"))->field('id,title,image')->select();
        if($list){
            $data=array('data'=>$list,'num'=>count($list));
            exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }
    /*
        安卓引导图
    */

    public function get_ios_banner() {
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);

        $list=M("ad")->where(array('status'=>1,'catid'=>15))->order(array('listorder'=>"desc",'id'=>"asc"))->field('id,title,image')->select();
        if($list){
            $data=array('data'=>$list,'num'=>count($list));
            exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data' => $data)));
        }else{
            exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
        }
    }

}
