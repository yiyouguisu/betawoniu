<?php
namespace Home\Controller;
use Home\Common\CommonController;

class WoniuController extends CommonController {

    public function index() {
    	if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
	    	$uids=M('attention')->where(array('fuid'=>$uid))->getField("tuid",true);

	        $count=M('attention a')->join("left join zz_member b on a.fuid=b.id")->where(array('a.tuid'=>$uid,'a.fuid'=>array('in',$uids)))->count();
			$data=M('attention a')
	            ->join("left join zz_member b on a.fuid=b.id")
	            ->where(array('a.tuid'=>$uid,'a.fuid'=>array('in',$uids)))
	            ->field('b.id as uid,b.nickname,b.head,b.info,b.area,b.rongyun_token')
	            ->select();
	        foreach ($data as $key => $value) {
	        	# code...
	        	$data[$key]['fansnum']=M('attention')->where('tuid=' . $value['uid'])->count();
                $data[$key]['attentionnum']=M('attention')->where('fuid=' . $value['uid'])->count();
	        }
	        $data=!empty($data)?$data:null;
	        $this->assign("data",$data);
	        $this->assign("totalnum",$count);
	        $this->display();
	    }
    }
    public function chat(){
    	if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
	        $this->display();
	    }
    }
    public function chatdetail(){
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
        	$tuid=I('tuid');
            $uid=session("uid");
            $type=I('type');
            if($tuid==$uid){
                if($type=='party'){
                    $this->error("不能咨询自己的活动");
                }else if($type=='hostel'){
                    $this->error("不能咨询自己的美宿");
                }
                
            }
        	$user_data=M('Member')->field('id,nickname,head,rongyun_token')->find($tuid);
            $data=array(
                'id'=>$user_data['id'], // 用户id
                'head'=>$user_data['head'],// 头像
                'nickname'=>$user_data['nickname'],// 用户名
                'rong_key'=>"cpj2xarljz3ln",// 融云key
                'rong_token'=>$user_data['rongyun_token']//获取融云token
                );
            $this->assign('data',$data);
        	$this->display();
        }
    }
    public function message(){
    	if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
        	$uid=session("uid");
        	$count = M("message")->where(array('r_id'=>$uid,'isdel'=>'0'))->count();
	        $page = new \Think\Page($count,6);
	        $page->setConfig("prev","上一页");
	        $page->setConfig("next","下一页");
	        $page->setConfig("first","第一页");
	        $page->setConfig("last","最后一页");
        	$data=M("message")->where(array('r_id'=>$uid,'isdel'=>'0'))->order(array('id'=>"desc"))->field("id,title,content,status,varname,value,inputtime")->limit($page->firstRow . ',' . $page->listRows)->select();
            $show = $page->show();
        	$this->assign("Page", $show);
            $this->assign('data',$data);
	    	$this->display();
	    }
    }
    /**
     * 传递一个、或者多个用户id
     * 获取用户头像用户名；用来组合成好友列表
     */
    public function get_user_info(){
        $uids=I('post.uids');
        // 组合where数组条件
        $map=array(
            'id'=>array('in',$uids)
            );
        $data=M('member')
            ->field('id,nickname,head,rongyun_token')
            ->where($map)
            ->select();
        foreach ($data as $key => $value) {
        	# code...
        	$data[$key]['showurl']=U('Home/Member/detail',array('uid'=>$value['id']));
        }
        $this->ajaxReturn($data,'json');
    }
    public function morefriend(){
        $where=array();
        $where['a.status']=1;
        $Map=A("Api/Map");
        $location=$Map->getlocation();
        if(empty($location)){
            $location=array("x"=>"121.428075","y"=>"31.238356");
        }
        $this->assign("location",$location);
        $recoords=getcoords($location['y'],$location['x'],5);
        $where['a.lng']=array(array('ELT',$recoords['y1']),array('EGT',$recoords['y2']));
        $where['a.lat']=array(array('EGT',$recoords['x1']),array('ELT',$recoords['x2']));
        $data=M("member a")
            ->where($where)
            ->order(array('a.id'=>"desc"))
            ->field('a.id as uid,a.nickname,a.head,a.lat,a.lng')
            ->select();
        foreach ($data as $key => $value) {
            # code...
            $data[$key]['url']=U('Home/Member/detail',array('uid',$value['uid']));
        }
        $josnlist=json_encode($data);
        $this->assign("data",$josnlist);
        $this->display();
    }
    public function show(){
        $mid=$_GET['id'];
        if(!$mid){
            $this->error("ID参数错误");
        }
        M("message")->where(array('id'=>array('eq',$mid)))->setField("status",1);
        $message=M('message')->where(array('id'=>$mid))->find();
        $this->assign("message",$message);
        $orderid=$message['value'];
        $order=M('book_room')->where(array('orderid'=>$orderid))->find();
        $this->assign("order",$order);

        $member=M('member')->where(array('phone'=>$order['phone']))->find();
        $this->assign("member",$member);
        $this->display();
    }
    public function refundreview(){
        $mid=$_GET['id'];
        if(!$mid){
            $this->error("ID参数错误");
        }
        M("message")->where(array('id'=>array('eq',$mid)))->setField("status",1);
        $message=M('message')->where(array('id'=>$mid))->find();
        $this->assign("message",$message);
        $orderid=$message['value'];
        $type=substr($orderid,0,2);
        switch ($type)
        {
            case "ac":
                $order=M('activity_apply a')->join("left join zz_refund_apply b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->field("a.*,b.content,b.inputtime as messagetime")->find();
                break;
            case "hc":
                $order=M('book_room a')->join("left join zz_refund_apply b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->field("a.*,b.content,b.inputtime as messagetime")->find();
                break;
        }

        $this->assign("order",$order);

        $member=M('member')->where(array('phone'=>$order['phone']))->find();
        $this->assign("member",$member);
        $this->display();
    }
    public function refundorderreview(){
        $orderid=$_GET['orderid'];
        if(!$orderid){
            $this->error("ID参数错误");
        }
        $type=substr($orderid,0,2);
        switch ($type)
        {
            case "ac":
                $order=M('activity_apply a')->join("left join zz_refund_apply b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->field("a.*,b.content,b.inputtime as messagetime")->find();
                $title="取消报名";
                $content="您有新的取消报名申请，请尽快审核。";
                break;
            case "hc":
                $order=M('book_room a')->join("left join zz_refund_apply b on a.orderid=b.orderid")->where(array('a.orderid'=>$orderid))->field("a.*,b.content,b.inputtime as messagetime")->find();
                $title="取消入住";
                $content="您有新的取消入住申请，请尽快审核。";
                break;
        }

        $this->assign("order",$order);

        $message=array(
            'title'=>$title,
            'content'=>$content,
            'inputtime'=>$order['messagetime']
            );
        $this->assign("message",$message);

        $member=M('member')->where(array('phone'=>$order['phone']))->find();
        $this->assign("member",$member);
        $this->display();
    }
    public function reviewshow(){
        $mid=$_GET['id'];
        if(!$mid){
            $this->error("ID参数错误");
        }
        M("message")->where(array('id'=>array('eq',$mid)))->setField("status",1);
        $message=M('message')->where(array('id'=>$mid))->find();
        $this->assign("message",$message);
        $data=array();
        switch ($message['varname']) {
            case 'failreviewnote':
                # code...
                $data=M('Note')->where(array('id'=>$message['value']))->find();
                break;
            case 'failreviewparty':
                # code...
                $data=M('Activity')->where(array('id'=>$message['value']))->find();
                break;
            case 'failreviewhostel':
                # code...
                $data=M('Hostel')->where(array('id'=>$message['value']))->find();
                break;
        }
        $this->assign("data",$data);
        $this->display();
    }
    public function orderreview(){
        $orderid=$_GET['orderid'];
        if(!$orderid){
            $this->error("ID参数错误");
        }
        $order=M('book_room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.orderid'=>$orderid))->field("a.*,b.title as hostel")->find();
        $this->assign("order",$order);

        $member=M('member')->where(array('phone'=>$order['phone']))->find();
        $this->assign("member",$member);
        $this->display();
    }
    public function updatestatus(){
        $mid=$_POST['mid'];
        
        if($mid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }else{
            $id=M("message")->where(array('id'=>array('eq',$mid)))->setField("status",1);
            if($id!==false){
                exit(json_encode(array('code'=>200,'msg'=>"更新成功")));
            }else{
                $sql=M("message")->_sql();
                exit(json_encode(array('code'=>-202,'msg'=>"更新失败",'sql'=>$sql)));
            }  
        }
    }
}