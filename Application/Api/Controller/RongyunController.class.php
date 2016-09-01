<?php

namespace Api\Controller;

use Api\Common\CommonController;

use Org\Util\Rongyun;

class RongyunController extends CommonController {

	protected $Rongyun, $Config, $ConfigData;

    public function _initialize(){
        parent::_initialize();
        $this->Config = D("Config");
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=$this->Config->order(array('id'=>'desc'))->select();
            F("web_config",$ConfigData);
        }
        $Rongyun_config=array();
        foreach ($ConfigData as $r) {
            if($r['groupid'] == 5){
                $Rongyun_config[$r['varname']] = $r['value'];
            }
        }
        $this->ConfigData=$Rongyun_config;
        $this->Rongyun = new Rongyun($this->ConfigData['rongyunUser'], $this->ConfigData['rongyunPass']);
    }
    public function gettoken() {
        $member=M('member')->where(array('_string'=>"rongyun_token = ''"))->limit(1000)->select();
        $sql=M('member')->_sql();
        dump($sql);
        foreach ($member as $value){
            if(empty($value['rongyun_token'])){
                $tokenStr = $this->Rongyun->getToken($value['id'], $value['username'], C("WEB_URL").$value['head']);
                dump($tokenStr);
                $token = json_decode($tokenStr, true);
                M('Member')->where(array('id'=>$value['id']))->setField("rongyun_token",$token['token']);
            }
        }
    }

    public function savetoken($uid) {
		$member=M('member')->where(array('id'=>$uid))->find();
		$tokenStr = $this->Rongyun->getToken($uid, $member['username'], C("WEB_URL").$member['head']);
		$token = json_decode($tokenStr, true);
		M('Member')->where(array('id'=>$uid))->setField("rongyun_token",$token['token']);
        return $token;
    }
    public function token(){
    	# code...
    	$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		$member=M('Member')->where(array('id'=>$uid))->find();
		if($uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($member)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$tokenStr = $this->Rongyun->getToken($uid, $member['username'], C("WEB_URL").$member['head']);
			$token = json_decode($tokenStr, true);
			
			if(!empty($token['token'])){
				$id=M('Member')->where(array('id'=>$uid))->setField("rongyun_token",$token['token']);
				exit(json_encode(array('code'=>200,'msg'=>"success",'data' => array('token'=>$token['token']))));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"error")));
			}
		}

    }
	/**
     * 通讯录列表
     */
	public function friendlist(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		//$p=intval(trim($ret['p']));
		//$num=intval(trim($ret['num']));

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();
		if($uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$data=M("attention a")->join("left join zz_member b on a.uid=b.id")->where(array('a.fuid'=>$uid,'a.isagree'=>1,'a.isblack'=>0,'a.isdelete'=>0))->field("a.tuid as uid,a.remark,a.inputtime,b.nickname,b.head,b.rongyun_token")->select();
            if($data){
				exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data' => $data)));
			}else{
				exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
			}
		}
	}
	/**
     * 新的朋友列表
     */
	public function newfriendlist(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		//$p=intval(trim($ret['p']));
		//$num=intval(trim($ret['num']));

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();
		if($uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$data=M("attention a")->join("left join zz_member b on a.uid=b.id")->where(array('a.tuid'=>$uid,'a.isblack'=>0,'a.isdelete'=>0))->field("a.fuid as uid,a.applyinfo,a.isagree,a.remark,a.inputtime,b.nickname,b.head,b.rongyun_token")->select();
            if($data){
				exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data' => $data)));
			}else{
				exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
			}
		}
	}
	/**
     * 添加好友请求
     */
	public function attention_apply(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$tuid=intval(trim($ret['tuid']));
		$uid=intval(trim($ret['uid']));

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		$where1['id']=$tuid;
		$ustatus=M('Member')->where($where1)->count();
		$status=M('attention')->where('fuid=' . $uid . ' and tuid=' . $tuid . ' and isdelete=0')->find();
		if($tuid==''||$uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif($ustatus<1){
			exit(json_encode(array('code'=>-200,'msg'=>"好友不存在")));
		}elseif($status){
			exit(json_encode(array('code'=>-200,'msg'=>"已经关注")));
		}else{
			$frend=M('attention')->where('fuid=' . $uid . ' and tuid=' . $tuid . ' and isdelete=1')->find();
			if($frend&&$frend['isblack']==0){
				if($frend['isblack']){
					$id=M('attention')->where('fuid=' . $uid . ' and tuid=' . $tuid . ' and isdelete=1')->save(array(
						'isdelete'=>0,
						'isagree'=>0,
						));
				}else{
					exit(json_encode(array('code'=>200,'msg'=>"已被拉入黑名单")));
				}
			}else{
				$id=M('attention')->add(array(
                    'fuid'=>$uid,
                    'tuid'=>$tuid,
                    'inputtime'=>time()
                ));
			}

			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"发送申请成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"发送申请失败")));
			}
		}
	}
	/**
     * 同意添加好友请求
     */
	public function attention_agree(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));
		$attentionid=intval(trim($ret['attentionid']));


		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		$attention=M('attention')->where('id=' . $attentionid)->find();
		if($attentionid==''||$uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif($attention){
			exit(json_encode(array('code'=>-200,'msg'=>"好友请求不存在")));
		}elseif($attention['isagree']==1){
			exit(json_encode(array('code'=>-200,'msg'=>"已经处理该好友请求")));
		}else{
			$id=M('attention')->where('id=' . $attentionid)->save(array(
                'isagree'=>1,
                'agreetime'=>time()
                ));
			if($id){
                M('attention')->add(array(
                    'fuid'=>$attention['tuid'],
                    'tuid'=>$attention['fuid'],
                    'inputtime'=>time(),
                    'isagree'=>1,
                    'agreetime'=>time()
                ));
				exit(json_encode(array('code'=>200,'msg'=>"处理成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"处理失败")));
			}
		}
	}
	/**
     * 搜索好友
     */
	public function search(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$keyword=trim($ret['keyword']);

		if($keyword==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}else{
			$where['liexinid|phone']=$keyword;
			$user=M('Member')->where($where)->find();
			if($user){
                $data=array(
                    'frendnickname'=>$user['nickname'],
                    'frendid'=>$user['id'],
                    'frendrongyun_token'=>$user['rongyun_token'],
                    'frendhead'=>$user['head']
                    );
				exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data'=>$data)));
			}else{
				exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
			}
		}
	}
	/**
     * 设置备注
     */
	public function set_remark(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$tuid=intval(trim($ret['tuid']));
		$uid=intval(trim($ret['uid']));
		$remark=trim($ret['remark']);


		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		$where1['id']=$tuid;
		$user=M('Member')->where($where1)->find();

		$where2['fuid']=$uid;
		$where2['tuid']=$tuid;
		$num=M('attention')->where($where2)->count();
		if($tuid==''||$uid==''||$remark==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"好友不存在")));
		}elseif(!$num){
			exit(json_encode(array('code'=>-200,'msg'=>"未关注此用户")));
		}elseif($uid==$tuid){
			exit(json_encode(array('code'=>-200,'msg'=>"用户与好友为同一人")));
		}else{
			$id=M('attention')->save(array(
				'fuid'=>$result['id'],
				'tuid'=>$tuid,
				'remark'=>$remark
			));
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"设置备注成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"设置备注失败")));
			}
		}
	}
	/**
     * 设置标签
     */
	public function set_tag(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$tuid=intval(trim($ret['tuid']));
		$uid=intval(trim($ret['uid']));
		$tagid=intval(trim($ret['tagid']));


		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		$where1['id']=$tuid;
		$user=M('Member')->where($where1)->find();

		$where2['fuid']=$uid;
		$where2['tuid']=$tuid;
		$num=M('attention')->where($where2)->count();
		if($tuid==''||$uid==''||$tagid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"好友不存在")));
		}elseif(!$num){
			exit(json_encode(array('code'=>-200,'msg'=>"未关注此用户")));
		}elseif($uid==$tuid){
			exit(json_encode(array('code'=>-200,'msg'=>"用户与好友为同一人")));
		}else{
			$id=M('attention')->save(array(
				'fuid'=>$result['id'],
				'tuid'=>$tuid,
				'tagid'=>$tagid
			));
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"设置标签成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"设置标签失败")));
			}
		}
	}
	/**
     * 删除好友
     */
	public function unattention(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$tuid=intval(trim($ret['tuid']));
		$uid=intval(trim($ret['uid']));

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		$where1['id']=$tuid;
		$ustatus=M('Member')->where($where1)->count();
		$status=M('attention')->where('fuid=' . $uid . ' and tuid=' . $tuid)->find();
		if($tuid==''||$uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif($ustatus<1){
			exit(json_encode(array('code'=>-200,'msg'=>"好友不存在")));
		}elseif(!$status){
			exit(json_encode(array('code'=>-200,'msg'=>"尚未关注他")));
		}else{
			$id=M('attention')->where('fuid=' . $uid . ' and tuid=' . $tuid)->save(array(
				'isdelete'=>1,
				'deletetime'=>time()
				));
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"删除好友成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"删除好友失败")));
			}
		}
	}
	/**
     * 拉黑
     */
	public function black(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$tuid=intval(trim($ret['tuid']));
		$uid=intval(trim($ret['uid']));

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		$where1['id']=$tuid;
		$user=M('Member')->where($where1)->find();
		$status=M('blacklist')->where('fuid=' . $uid . ' and tuid=' . $tuid)->find();
		$status1=M('attention')->where('fuid=' . $result['id'] . ' and tuid=' . $tuid)->find();
		if($tuid==''||$uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"被拉黑用户不存在")));
		}elseif($status){
			exit(json_encode(array('code'=>-200,'msg'=>"不能重复拉黑")));
		}elseif(!$status1){
			exit(json_encode(array('code'=>-200,'msg'=>"尚未成为好友")));
		}else{
			$id=M('blacklist')->add(array(
				'fuid'=>$result['id'],
				'tuid'=>$tuid,
				'inputtime'=>time()
			));
			if($id){
				M('attention')->where('fuid=' . $result['id'] . ' and tuid=' . $tuid)->setField("isblack",1);
				exit(json_encode(array('code'=>200,'msg'=>"拉黑好友成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"拉黑好友失败")));
			}
		}
	}
	/**
     * 移除黑名单
     */
	public function blackdelete(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$tuid=intval(trim($ret['tuid']));
		$uid=intval(trim($ret['uid']));

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();

		$where1['id']=$tuid;
		$user=M('Member')->where($where1)->find();
		$status=M('blacklist')->where('fuid=' . $uid . ' and tuid=' . $tuid)->find();
		if($tuid==''||$uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(!$status){
			exit(json_encode(array('code'=>-200,'msg'=>"尚未拉黑")));
		}else{
			$id=M('blacklist')->delete(array(
				'fuid'=>$result['id'],
				'tuid'=>$tuid,
			));
			if($id){
				M('attention')->where('fuid=' . $result['id'] . ' and tuid=' . $tuid)->setField("isblack",0);
				exit(json_encode(array('code'=>200,'msg'=>"移除黑名单成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"移除黑名单失败")));
			}
		}
	}
	/**
     * 黑名单列表
     */
	public function blacklist(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
		// $p=intval(trim($ret['p']));
		// $num=intval(trim($ret['num']));

		$where['id']=$uid;
		$result=M('Member')->where($where)->find();
		if($uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($result)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$data=M('blacklist')->where('fuid=' . $result['id'])->field('id,tuid,inputtime')->select();
			foreach ($data as $key => $value) {
                # code...
                $member=M('member')->where('id=' . $value['tuid'])->find();
                $data[$key]['nickname']=$member['nickname'];
                $data[$key]['info']=$member['info'];
                $data[$key]['rongyun_token']=$member['rongyun_token'];
                $data[$key]['head']=C("WEB_URL") .$member['head'];
            }
			if($data){
				exit(json_encode(array('code'=>200,'msg'=>"Load success!",'data' => $data)));
			}else{
				exit(json_encode(array('code'=>-201,'msg'=>"The data is empty!")));
			}
		}
	}
    /**
     * 群聊列表
     */
    public function chatlist() {
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $uid=intval(trim($ret['uid']));

        $member=M('member')->where(array('id'=>$uid))->find();
        if($uid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($member)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            $where['a.uid']=$uid;
            $data=M('member_chat a')->join("left join zz_chat b on a.chatid=b.id")->where($where)->field("b.id,b,name,a.isbusy,a.istop,a.ismanager,a.issave")->select();
            foreach ($data as $key => $value) {
                # code...
                $data[$key]['num']=M('member_chat')->where(array('chatid'=>$value['id']))->count();
            }
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
            }
        }
    }
	/**
     * 创建群聊
     */
	public function creat_chat(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$name=intval(trim($ret['name']));
		$uid=intval(trim($ret['uid']));
        $memberids=trim($ret['memberids']);

		$user=M('Member')->where(array('id'=>$uid))->find();
		if($name==''||$uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
            $id=M('chat')->add(array(
                'name'=>$name,
                'uid'=>$uid,
                'inputtime'=>time(),
                'updatetime'=>time()
                ));
			if($id){
                $code=phpcode(json_encode(array('id'=>$id,'name'=>$name)),md5($name));
                M('chat')->where(array('id'=>$id))->setField("qrcode",$code);
                M('member_chat')->add(array(
                            'chatid'=>$id,
                            'uid'=>$uid,
                            'nickname'=>$user['nickname'],
                            'ismanager'=>1,
                            'inputtime'=>time(),
                            'updatetime'=>time()
                        ));
                foreach (explode(",",$memberids) as $value)
                {
                    $chat_member=M('member')->where(array('id'=>$value))->find();
                    if($chat_member){
                        M('member_chat')->add(array(
                            'chatid'=>$id,
                            'uid'=>$value,
                            'nickname'=>$chat_member['nickname'],
                            'ismanager'=>0,
                            'inputtime'=>time(),
                            'updatetime'=>time()
                        ));
                    }

                }

				exit(json_encode(array('code'=>200,'msg'=>"创建成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"创建失败")));
			}
		}
	}
    /**
     * 群聊成员
     */
    public function chatmember() {
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
        $ret=json_decode($ret,true);
        $lid=intval(trim($ret['lid']));

        $where['id']=$lid;
        $chat=M('chat')->where($where)->find();
        if($lid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($chat)){
            exit(json_encode(array('code'=>-200,'msg'=>"群聊不存在")));
        }else{
            $where['a.chatid']=$lid;
            $data=M('member_chat a')->join("left join zz_member b on a.uid=b.id")->where($where)->field("a.uid,b.nickname,b.head,b.rongyun_token")->select();
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
            }
        }
    }
	/**
     * 修改群聊名称
     */
	public function changename(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$lid=intval(trim($ret['lid']));
		$name=trim($ret['uid']);

		$chat=M('chat')->where(array('id'=>$lid))->find();
		if($lid==''||$name==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($chat)){
			exit(json_encode(array('code'=>-200,'msg'=>"群聊不存在")));
		}else{
			$id=M('chat')->save(array(
				'id'=>$chat['id'],
				'name'=>$name,
				'updatetime'=>time()
			));
			if($id>0){
				exit(json_encode(array('code'=>200,'msg'=>"修改成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"修改失败")));
			}
		}
	}
	/**
     * 添加成员
     */
	public function addmember(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$lid=intval(trim($ret['lid']));
		$memberids=trim($ret['memberids']);

		$chat=M('chat')->where(array('id'=>$lid))->find();
		if($lid==''||$memberids==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($chat)){
			exit(json_encode(array('code'=>-200,'msg'=>"群聊不存在")));
		}else{
            $ids=array();
			foreach (explode(',', $memberids) as $value) {
				# code...
                $chat_member=M('member')->where(array('id'=>$value))->find();
                if($chat_member){
                    $status=M('member_chat')->where(array('uid'=>$value,'chatid'=>$lid))->find();
                    if(!$status){
                        M('member_chat')->add(array(
                            'chatid'=>$lid,
                            'uid'=>$value,
                            'nickname'=>$chat_member['nickname'],
                            'ismanager'=>0,
                            'inputtime'=>time(),
                            'updatetime'=>time()
                        ));
                    }
				}
			}
			if($ids){
				exit(json_encode(array('code'=>200,'msg'=>"添加成员成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"添加成员失败")));
			}
		}
	}
	/**
     * 删除成员
     */
	public function delmember(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$lid=intval(trim($ret['lid']));
		$memberids=trim($ret['memberids']);

		$chat=M('chat')->where(array('id'=>$lid))->find();
		if($lid==''||$memberids==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($chat)){
			exit(json_encode(array('code'=>-200,'msg'=>"群聊不存在")));
		}else{
            $ids=M('member_chat')->where(array('uid'=>array("in",$memberids),'chatid'=>$lid))->delete();
			if($ids){
				exit(json_encode(array('code'=>200,'msg'=>"删除成员成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"删除成员失败")));
			}
		}
	}
    /**
     * 通讯录标签
     */
    public function tag(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));

		$member=M('Member')->where(array('id'=>$uid))->find();
		if($uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($member)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}else{
            $data=M('tag')->where(array('uid'=>$uid))->field("id,name")->select();
            foreach ($data as $key => $value){
            	$data[$key]['num']=M('attention')->where(array('fuid'=>$uid,'tag'=>$value['id']))->count();
            }
			if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
            }
		}
    }
    /**
     * 通讯录标签  添加
     */
    public function tag_add(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
        $name=trim($ret['name']);

		$member=M('Member')->where(array('id'=>$uid))->find();
		if($uid==''||$name==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($member)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}else{
            $ids=M('tag')->add(array(
                'uid'=>$uid,
                'name'=>$name,
                'inputtime'=>time(),
                'updatetime'=>time()
                ));

			if($ids){
				exit(json_encode(array('code'=>200,'msg'=>"添加成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"添加失败")));
			}
		}
    }
    /**
     * 通讯录标签  修改
     */
    public function tag_modify(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
        $tagid=intval(trim($ret['tagid']));
        $name=trim($ret['name']);

		$member=M('Member')->where(array('id'=>$uid))->find();
        $tag=M('tag')->where(array('id'=>$tagid))->find();
		if($uid==''||$name==''||$tagid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($member)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}elseif(empty($tag)){
			exit(json_encode(array('code'=>-200,'msg'=>"标签不存在")));
		}else{
            $ids=M('tag')->save(array(
                'id'=>$tagid,
                'name'=>$name,
                'updatetime'=>time()
                ));

			if($ids){
				exit(json_encode(array('code'=>200,'msg'=>"修改成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"修改失败")));
			}
		}
    }
    /**
     * 通讯录标签  删除
     */
    public function tag_delete(){
        $ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$ret = CommonController::decrypt($ret['data']);
        $ret=json_decode($ret,true);
		$uid=intval(trim($ret['uid']));
        $tagid=intval(trim($ret['tagid']));

		$member=M('Member')->where(array('id'=>$uid))->find();
        $tag=M('tag')->where(array('id'=>$tagid))->find();
		if($uid==''||$tagid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
		}elseif(empty($member)){
			exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
		}elseif(empty($tag)){
			exit(json_encode(array('code'=>-200,'msg'=>"标签不存在")));
		}else{
            $ids=M('tag')->delete($tagid);
			if($ids){
				exit(json_encode(array('code'=>200,'msg'=>"删除成功")));
			}else{
				exit(json_encode(array('code'=>-200,'msg'=>"删除失败")));
			}
		}
    }
	/**
     * 获取猎信会员的基本信息
     */
	public function ucenter(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
		$uid = intval(trim($ret['uid']));

		$user=M('Member')->where(array('id'=>$uid))->find();

		if($uid==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$dataset['uid'] = $user['id'];
            $dataset['nickname'] = $user['nickname'];
            $dataset['head'] = $user['head'];
            $dataset['liexinid'] = $user['liexinid'];
            $dataset['info'] = $user['info'];
            $dataset['area'] = getarea($user['area']);
            $dataset['backgroud']=$user['backgroud'];
            exit(json_encode(array('code' => 200, 'msg' => "获取数据成功", 'data' =>$dataset)));
		}
	}
	/**
     * 会员完善资料
     */
	public function change_info(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
        $ret = CommonController::decrypt($ret['data']);
		$uid = intval(trim($ret['uid']));
		$filed=trim($ret['filed']);
		$value=trim($ret['value']);

		$where['id']=$uid;
		$user=M('Member')->where($where)->field('id')->find();
		if($uid==''||$filed==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}else{
			$id=M('member')->where(array('id'=>$uid))->setField($filed,$value);
			if($id){
				exit(json_encode(array('code'=>200,'msg'=>"修改成功")));
			}else{
				exit(json_encode(array('code'=>-202,'msg'=>"修改失败")));
			}
		}
	}
    public function updatefrendlist(){
		$ret=$GLOBALS['HTTP_RAW_POST_DATA'];
		$ret=json_decode($ret,true);
        $retdata = CommonController::decrypt($ret['data']);
		$uid = intval(trim($retdata['uid']));
		$phonelist=$retdata['phonelist'];

        $where['id']=$uid;
		$user=M('Member')->where($where)->field('id')->find();
		if($uid==''||$phonelist==''){
			exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
		}elseif(empty($user)){
			exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
		}elseif(empty($phonelist)){
			exit(json_encode(array('code'=>-200,'msg'=>"The Phonelist is null!")));
		}else{
            $data=array();
            foreach ($phonelist as $key => $value)
            {
                $status=M('member')->where(array('phone'=>$value['phone']))->find();
                if($status){
                    $frend=M("member")->where(array('phone'=>$value['phone']))
                        ->field("id as uid,nickname,head,phone,rongyun_token")
                        ->find();
                    if($frend){
                        $frend['isattention']=0;
                    }else{
                        $frend['isattention']=0;
                    }
                    $frend['realname']=$value['realname'];
                    $data[$key]=$frend;
                }
            }
            if($data){
                exit(json_encode(array('code'=>200,'msg'=>"加载成功",'data'=>$data)));
            }else{
                exit(json_encode(array('code'=>-201,'msg'=>"数据为空")));
            }
        }
    }
}