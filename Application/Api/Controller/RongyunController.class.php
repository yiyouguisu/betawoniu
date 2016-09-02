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
        foreach ($member as $value){
            if(empty($value['rongyun_token'])){
                $tokenStr = $this->Rongyun->getToken($value['id'], $value['username'], C("WEB_URL").$value['head']);
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
	public function messageroute(){
		$nonce = $_GET['nonce'];
		$timestamp = $_GET['timestamp'];
		$signature = $_GET['signature'];
		$local_signature = sha1($this->ConfigData['rongyunPass'].$nonce.$timestamp);
		if(strcmp($signature, $local_signature)===0){
			$data=$_POST;
			$data['inputtime']=time();
			$id=M('thirdmessage_log')->add($data);
			if($id){
				header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
			}
		} else {
		    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
		}
	}
    
}