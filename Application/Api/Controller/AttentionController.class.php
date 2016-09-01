<?php

namespace Api\Controller;

use Api\Common\CommonController;

class AttentionController extends CommonController {

	public function get_myfrend(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        $uid=intval(trim($ret['uid']));

        $where['id']=$uid;
        $user=M('Member')->where($where)->find();

        if($uid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }else{
        	$uids=M('attention')->where(array('fuid'=>$uid))->getField("tuid",true);

            $count=M('attention a')->join("left join zz_member b on a.fuid=b.id")->where(array('a.tuid'=>$uid))->count();
			$attention=M('attention a')
                ->join("left join zz_member b on a.fuid=b.id")
                ->where(array('a.tuid'=>$uid,'a.fuid'=>array('in',$uids)))
                ->field('b.id as uid,b.nickname,b.head,b.info,b.area,b.rongyun_token')
                ->page($p,$num)
                ->select();
            $attention=!empty($attention)?$attention:null;
            $data=array(
                'num'=>$count,
                'data'=>$attention
                );
			if($data){
                exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
            }
		}
	}
	/*
     **我的关注
     */
	public function get_myattention(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        $uid=intval(trim($ret['uid']));

        $where['id']=$uid;
        $user=M('Member')->where($where)->find();

        if($uid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }else{
            $count=M('attention a')->join("left join zz_member b on a.tuid=b.id")->where(array('a.fuid'=>$uid))->count();
			$attention=M('attention a')
                ->join("left join zz_member b on a.tuid=b.id")
                ->where(array('a.fuid'=>$uid))
                ->field('b.id as uid,b.nickname,b.head,b.info,b.area,b.rongyun_token')
                ->page($p,$num)->select();
            $attention=!empty($attention)?$attention:null;
            $data=array(
                'num'=>$count,
                'data'=>$attention
                );
			if($data){
                exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
            }
		}
	}

    /*
     **我的粉丝
     */
	public function get_myfans(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$p=intval(trim($ret['p']));
        $num=intval(trim($ret['num']));
        $uid=intval(trim($ret['uid']));

        $where['id']=$uid;
        $user=M('Member')->where($where)->find();

        if($uid==''||$p==''||$num==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }else{
            $count=M('attention a')->join("left join zz_member b on a.fuid=b.id")->where(array('a.tuid'=>$uid))->count();
			$attention=M('attention a')
                ->join("left join zz_member b on a.fuid=b.id")
                ->where(array('a.tuid'=>$uid))
                ->field('b.id as uid,b.nickname,b.head,b.info,b.area,b.rongyun_token')
                ->page($p,$num)
                ->select();
            $attention=!empty($attention)?$attention:null;
            $data=array(
                'num'=>$count,
                'data'=>$attention
                );
			if($data){
                exit(json_encode(array('code'=>200,'msg'=>"获取数据成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
            }
		}
	}
	/*
     **添加关注
     */
	public function attention(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$tuid=intval(trim($ret['tuid']));
		$uid=intval(trim($ret['uid']));

		$fuser=M('Member')->where(array('id'=>$uid))->find();
		$tuser=M('Member')->where(array('id'=>$tuid))->find();
		$attentionstatus=M('attention')->where(array('fuid'=>$uid,'tuid'=>$tuid))->find();
		if($tuid==''||$uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($fuser)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}elseif(empty($tuser)){
			exit(json_encode(array('code'=>-200,'msg'=>"好友不存在")));
		}elseif(!empty($attentionstatus)){
			exit(json_encode(array('code'=>-200,'msg'=>"已关注此用户")));
		}elseif($uid==$tuid){
			exit(json_encode(array('code'=>-200,'msg'=>"用户与好友为同一人")));
		}else{
			$id=M('attention')->add(array(
				'fuid'=>$fuser['id'],
				'tuid'=>$tuser['id'],
				'inputtime'=>time()
			));
			if($id){
                UtilController::addmessage($tuser['id'],"好友关注","有蜗牛客关注你了，相互关注就可以成为好友！","有蜗牛客关注你了，相互关注就可以成为好友！","fattention",$fuser['id']);
				exit(json_encode(array('code'=>200,'msg'=>"关注成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"关注失败")));
			}
		}
	}
	/*
     **取消关注
     */
    public function unattention(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$tuid=intval(trim($ret['tuid']));
		$uid=intval(trim($ret['uid']));

		$fuser=M('Member')->where(array('id'=>$uid))->find();
		$tuser=M('Member')->where(array('id'=>$tuid))->find();
		$attentionstatus=M('attention')->where(array('fuid'=>$uid,'tuid'=>$tuid))->find();
		if($tuid==''||$uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($fuser)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}elseif(empty($tuser)){
			exit(json_encode(array('code'=>-200,'msg'=>"好友不存在")));
		}elseif(empty($attentionstatus)){
			exit(json_encode(array('code'=>-200,'msg'=>"尚未关注此用户")));
		}else{
			$id=M('attention')->delete($attentionstatus['id']);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"取消关注成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"取消关注失败")));
			}
		}
	}
}
