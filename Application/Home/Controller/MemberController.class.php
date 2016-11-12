<?php

/**
 * MemberController short summary.
 *
 * MemberController description.
 *
 * @version 1.0
 * @author cmc
 */
namespace Home\Controller;

use Home\Common\CommonController;

use Org\Net\Imgshot;

class MemberController extends CommonController {

    public function _initialize(){
      parent::_initialize();
      $uid=session("uid");
      $hostelorder=M('book_room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.uid'=>$uid))->field("b.catid,b.style")->select();
      if($hostelorder){
        foreach ($hostelorder as $value) {
          # code...
          $hostelcate[]=$value['catid'];
          $hostelstyle[]=$value['style'];
        }
        
        $map['style']=array('in',$hostelstyle);
        $map['catid']=array('in',$hostelcate);
        $map['_logic']='or';
        $where['_complex']=$map;
        $interestedhostel=M('Hostel')->where(array('status'=>2,'isdel'=>0,'type'=>'1'))->where($where)->cache(true)->limit(10)->select();
      }else{
        $interestedhostel=M('Hostel')->where(array('status'=>2,'isdel'=>0,'type'=>'1'))->cache(true)->limit(10)->select();
      }

      $this->assign("interestedhostel",$interestedhostel);
    }
    /**
     * 会员中心页
     * @author yiyouguisu<741459065@qq.com> time|20151219
     * @retrun void
     */
    public function index() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $myhostel=M("Hostel a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where(array('a.isdel'=>0,'a.status'=>2,'a.uid'=>$uid))
                ->order(array('a.id'=>'desc'))
                ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
                ->select();
            $this->assign('myhostel',$myhostel);

            $myparty=M("activity a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.isdel'=>0,'a.status'=>2,'a.uid'=>$uid))->order(array('id'=>"desc"))
                ->field('a.id,a.title,a.thumb,a.money,a.address,a.status,a.uid,a.starttime,a.endtime,a.inputtime')->limit(2)->select();
            foreach ($myparty as $key => $value) {
              # code...
                if($value['endtime']>=time()){
                  $myparty[$key]['donestatus']=0;
                }else{
                  $myparty[$key]['donestatus']=1;
                }
            }
            $this->assign('myparty',$myparty);

            $myreview=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                ->order(array('a.id'=>'desc'))
                ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->limit(4)
                ->select();
            foreach ($myreview as $key => $value)
            {
                if($value['varname']=='note'){
                    $myreview[$key]['title']=M('note')->where(array('id'=>$value['value']))->getField("title");
                }else if($value['varname']=='party'){
                    $myreview[$key]['title']=M('activity')->where(array('id'=>$value['value']))->getField("title");
                }else if($value['varname']=='hostel'){
                    $myreview[$key]['title']=M('hostel')->where(array('id'=>$value['value']))->getField("title");
                }else if($value['varname']=='room'){
                    $myreview[$key]['title']=M('room')->where(array('id'=>$value['value']))->getField("title");
                }else if($value['varname']=='trip'){
                    $myreview[$key]['title']=M('trip')->where(array('id'=>$value['value']))->getField("title");
                }
            }
            $this->assign('myreview',$myreview);

            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $mynote=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where(array('a.uid'=>$uid,'a.status'=>2,'a.isdel'=>0))
                ->order(array('a.id'=>'desc'))
                ->field('a.id,a.title,a.thumb,a.description,a.content,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.status,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->limit(2)
                ->select();
            foreach ($mynote as $key => $value)
            { 
                if(empty($value['reviewnum'])) $mynote[$key]['reviewnum']=0;
                $mynote[$key]['description'] = $this->str_cut(trim(strip_tags($value['content'])), 250);
            }
            $this->assign('mynote',$mynote);


            $where=array('a.uid|e.uid'=>$uid,'a.ordertype'=>1);
            $order=array('a.inputtime'=>'desc');
            $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,c.refund_status,a.ordertype,c.donetime,c.review_remark,d.endtime,f.remark as refundreview_remark');
            $hostelorder=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                ->join("left join zz_book_room d on a.orderid=d.orderid")
                ->join("left join zz_hostel e on d.hid=e.id")
                ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                ->where($where)
                ->order($order)
                ->field($field)
                ->limit(4)
                ->select();
            foreach ($hostelorder as $key => $value) {
                # code...
                $productinfo=M('book_room a')
                    ->join("left join zz_room c on a.rid=c.id")
                    ->join("left join zz_hostel b on c.hid=b.id")
                    ->where(array('a.orderid'=>$value['orderid']))
                    ->field("a.rid,b.id as hid,b.thumb,b.title,b.money,a.starttime,a.endtime")
                    ->find();
                $hostelorder[$key]['productinfo']=$productinfo;
            }
            $this->assign('hostelorder',$hostelorder);

            $where=array('a.uid|e.uid'=>$uid,'a.ordertype'=>2);
            $order=array('a.inputtime'=>'desc');
            $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,c.refund_status,a.ordertype,c.donetime,e.endtime,f.remark as refundreview_remark');
            $partyorder=M('order a')
                ->join("left join zz_order_time c on a.orderid=c.orderid")
                ->join("left join zz_activity_apply d on a.orderid=d.orderid")
                ->join("left join zz_activity e on d.aid=e.id")
                ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                ->where($where)
                ->order($order)
                ->field($field)
                ->limit(4)
                ->select();
            foreach ($partyorder as $key => $value) {
                # code...
                $productinfo=M('activity_apply a')
                    ->join("left join zz_activity b on a.aid=b.id")
                    ->where(array('a.orderid'=>$value['orderid']))
                    ->field("a.aid,b.thumb,b.title,b.money,b.isfree,b.starttime,b.endtime")
                    ->find();
                $partyorder[$key]['productinfo']=$productinfo;
            }
            $this->assign('partyorder',$partyorder);
            $this->display();
        }
    }
    /**
     * 会员详情
     * @author yiyouguisu<741459065@qq.com> time|20151219
     * @retrun void
     */
    public function detail() {
      $uid=I('uid');
      $fuid=session("uid");
      if(!empty($uid)&&!empty($fuid)){
          $num=M('view')->where('fuid=' . session("uid") . " and tuid=" . $uid)->count();
          $todaynum=M('view')->where('day(inputtime) = day(NOW()) and month(inputtime) = month(NOW()) and year(inputtime)=year(now()) and fuid=' . session("uid") . " and tuid=" . $uid)->count();
          if($num==0){
              M('Member')->where('id=' . $uid)->setInc("viewnum");
              if($todaynum==0){
                M('Member')->where('id=' . $uid)->setInc("todayviewnum");
              }
              M('view')->add(array(
                  'fuid'=>session("uid"),
                  'tuid'=>$uid,
                  'inputtime'=>time()
              ));
          }
      }
      $data=M('Member')->where('id=' . $uid)->find();
      $data['attentionnum'] = D("attention")->where('fuid=' . $data['id'])->count();
      $data['fansnum'] = D("attention")->where('tuid=' . $data['id'])->count();
      $data['viewlist']=D("view a")->join("left join zz_member b on a.fuid=b.id")->where('a.tuid=' . $data['id'])->group('fuid')->field("a.fuid as uid,b.nickname,b.head")->limit(6)->select();
      $data['characteristic']=M('linkage')->where(array('catid'=>1,'value'=>array('in',$data['characteristic'])))->select();
      $data['hobby']=M('linkage')->where(array('catid'=>2,'value'=>array('in',$data['hobby'])))->select();

      $fuid=session("uid");
      $attention=M('attention')->where(array('fuid'=>$fuid,'tuid'=>$uid))->find();
      $data['isattention'] = !empty($attention)?1:0;
      $this->assign('data',$data);

      $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
      $hostel=M("Hostel a")
          ->join("left join zz_member b on a.uid=b.id")
          ->join("left join {$sqlI} c on a.id=c.value")
          ->where(array('a.isdel'=>0,'a.status'=>2,'a.uid'=>$uid))
          ->order(array('a.id'=>'desc'))
          ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.description,a.support,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
          ->limit(3)
          ->select();
      foreach ($hostel as $key => $value) {
        # code...
        $hostel[$key]['roomnum']=M('room')->where(array('hid'=>$value['id']))->count();
        $hostel[$key]['description'] = $this->str_cut(trim(strip_tags($value['description'])), 100);
      }
      $this->assign('hostel',$hostel);

      $party=M("activity a")
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.isdel'=>0,'a.status'=>2,'a.uid'=>$uid))->order(array('id'=>"desc"))
          ->field('a.id,a.title,a.thumb,a.money,a.address,a.status,a.uid,a.starttime,a.endtime,a.inputtime')->limit(2)->select();
      foreach ($party as $key => $value) {
        # code...
          if($value['starttime']<=time()&&$value['endtime']>=time()){
            $party[$key]['donestatus']=0;
          }else{
            $party[$key]['donestatus']=1;
          }
      }
      $this->assign('party',$party);

      $trip=M("trip a")
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.ispublic'=>1,'a.uid'=>$uid))->order(array('id'=>"desc"))
          ->field('a.id,a.title,a.status,a.uid,a.starttime,a.endtime,a.inputtime')->limit(2)->select();
      foreach ($trip as $key => $value) {
        # code...
          if($value['starttime']<=time()&&$value['endtime']>=time()){
            $trip[$key]['donestatus']=0;
          }else{
            $trip[$key]['donestatus']=1;
          }
      }
      $this->assign('trip',$trip);

      $review=M("review a")
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.uid'=>$uid,'a.isdel'=>0))
          ->order(array('a.id'=>'desc'))
          ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
          ->limit(4)
          ->select();
      foreach ($review as $key => $value)
      {
          if($value['varname']=='note'){
              $review[$key]['title']=M('note')->where(array('id'=>$value['value']))->getField("title");
          }else if($value['varname']=='party'){
              $review[$key]['title']=M('activity')->where(array('id'=>$value['value']))->getField("title");
          }else if($value['varname']=='hostel'){
              $review[$key]['title']=M('hostel')->where(array('id'=>$value['value']))->getField("title");
          }else if($value['varname']=='room'){
              $review[$key]['title']=M('room')->where(array('id'=>$value['value']))->getField("title");
          }
      }
      $this->assign('review',$review);

      $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
      $note=M("Note a")
          ->join("left join zz_member b on a.uid=b.id")
          ->join("left join {$sqlI} c on a.id=c.value")
          ->where(array('a.uid'=>$uid,'a.status'=>2,'a.isdel'=>0))
          ->order(array('a.id'=>'desc'))
          ->field('a.id,a.title,a.thumb,a.description,a.content,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.status,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
          ->limit(2)
          ->select();
      foreach ($note as $key => $value)
      { 
          if(empty($value['reviewnum'])) $note[$key]['reviewnum']=0;
          $note[$key]['description'] = $this->str_cut(trim(strip_tags($value['content'])), 250);
      }
      $this->assign('note',$note);

      $myhostel=M('book_room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.uid'=>$uid,'a.paystatus'=>1))->field("a.starttime,b.*")->limit(4)->select();
      $this->assign('myhostel',$myhostel);
      $myhostelnum=M('book_room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.uid'=>$uid,'a.paystatus'=>1))->count();
      $this->assign('myhostelnum',$myhostelnum);

      $myparty=M('activity_apply a')->join("left join zz_activity b on a.aid=b.id")->where(array('a.uid'=>$uid,'a.paystatus'=>1))->field("b.*")->limit(4)->select();
      $this->assign('myparty',$myparty);
      $mypartynum=M('activity_apply a')->join("left join zz_activity b on a.aid=b.id")->where(array('a.uid'=>$uid,'a.paystatus'=>1))->count();
      $this->assign('mypartynum',$mypartynum);
      $this->display();
    }

    /**
     * 会员注册
     * @author yiyouguisu<741459065@qq.com> time|20151219
     * @retrun void
     */
    public function reg() {
        if(IS_POST){
            $phone=$_POST['phone'];
            // $verify = new \Think\Verify();
            // $code = $_POST['verify'];
            // $verifyok = $verify->check($code, $id = '');
            // if (!$verifyok) {
            //     $this->error('图片验证码错误，请重新输入');
            // }
            $verifyset=M('verify')->where('phone=' . $phone)->find();
            $time=time()-$verifyset['expiretime'];
            if($time>0){
                $verify="";
                M('verify')->where('phone=' . $phone)->save(array(
                'status'=>1
                ));
            }else{
                $verify=$verifyset['verify'];
                M('verify')->where('phone=' . $phone)->save(array(
                'status'=>1
                ));
            }
            $telverify= $_POST['telverify'];
            if(strtolower($telverify)!=strtolower($verify)){
                $this->error('请输入您手机接收到的正确验证码');
            }
            
            $password=$_POST['password'];
            $pwdconfirm=$_POST['pwdconfirm'];
            if(empty($password)||empty($pwdconfirm)||empty($phone)){
                $this->error('请将信息填写完整');
            }
            if(!check_phone($phone)){
                $this->error('手机号已被注册');
            }
            $invite_code = $_POST['invite_code'];
            $tuijianuser=M('member')->where(array('tuijiancode'=>$invite_code))->find();
            if (!$tuijianuser&&!empty($invite_code)) {
                $this->error('推荐用户不存在');
            } 
            $data=$_POST;
            $data['group_id']=1;
            $data['username']=$_POST['phone'];
            $data['phone_status'] = 1;
            $data['head']="/default_head.png";
            if($tuijianuser&&!empty($invite_code)){
                $data['groupid_id'] = $tuijianuser['id'];
            }
            $id = D("member")->addUser($data);
            if ($id) {
                $Rongrun=A("Api/Rongyun");
                $rongyun_token=$Rongrun->savetoken($id);

                M("message")->add(array(
                  'r_id'=>$id,
                  'title'=>"恭喜你注册成功",
                  'content'=>"恭喜你注册成功！",
                  'varname'=>"reg",
                  'value'=>$id,
                  'inputtime'=>time()
                ));
                if($tuijianuser&&!empty($invite_code)){
                    $Vouchers= M("Vouchers")->where(array('id'=>1))->find();
                    $vouchers_order_id=M("Vouchers_order")->add(array(
                        'catid'=>1,
                        'uid'=>$id,
                        'num'=>1,
                        'price'=>$Vouchers['price'],
                        'hid'=>$Vouchers['hid'],
                        'aid'=>$Vouchers['aid'],
                        'status'=>0,   
                        'inputtime'=>time(),
                        'updatetime'=>time()
                        ));
                    if($vouchers_order_id){
                        \Api\Controller\UtilController::addmessage($order['uid'],"会员首次注册获取优惠券","会员首次注册获取优惠券","会员首次注册获取优惠券","getcoupons",$vouchers_order_id);
                    }
                    M('invite')->add(array(
                        'uid'=>$tuijianuser['id'],
                        'tuid'=>$id,
                        'tuijiancode'=>$invite_code,
                        'status'=>2,
                        'inputtime'=>time()
                        ));
                    $Vouchers= M("Vouchers")->where(array('id'=>2))->find();
                    $vouchers_order_id=M("Vouchers_order")->add(array(
                        'catid'=>2,
                        'uid'=>$tuijianuser['id'],
                        'num'=>1,
                        'price'=>$Vouchers['price'],
                        'hid'=>$Vouchers['hid'],
                        'aid'=>$Vouchers['aid'],
                        'status'=>0,   
                        'inputtime'=>time(),
                        'updatetime'=>time()
                        ));
                    if($vouchers_order_id){
                        \Api\Controller\UtilController::addmessage($order['uid'],"分享APP邀请好友注册","分享APP邀请好友注册赠送20元","分享APP邀请好友注册赠送20元","getcoupons",$vouchers_order_id);
                    }
                }else{
                    $Vouchers= M("Vouchers")->where(array('id'=>1))->find();
                    $vouchers_order_id=M("Vouchers_order")->add(array(
                        'catid'=>1,
                        'uid'=>$id,
                        'num'=>1,
                        'price'=>$Vouchers['price'],
                        'hid'=>$Vouchers['hid'],
                        'aid'=>$Vouchers['aid'],
                        'status'=>0,   
                        'inputtime'=>time(),
                        'updatetime'=>time()
                        ));
                    if($vouchers_order_id){
                        \Api\Controller\UtilController::addmessage($order['uid'],"会员首次注册获取优惠券","会员首次注册获取优惠券","会员首次注册获取优惠券","getcoupons",$vouchers_order_id);
                    }

                }
                $this->loginHome($_POST["phone"], $_POST["password"]);
                $this->redirect('Home/Member/addinfo');
            } else {
                $this->error(D("member")->getError());
            }
        }else{
            $this->display();
        }
    }


    /**
     * 会员登录
     * @author yiyouguisu<741459065@qq.com> time|20151219
     * @retrun void
     */
    public function login() {
        if (session('uid')) {
            $this->redirect('Home/Member/index');
        } else {
            if (IS_POST) {
                $username = $_POST['phone'];
                $password = $_POST['password'];
                $autotype = ($_POST['autotype'] ? $_POST['autotype'] : 0);
                $status=$this->loginHome($username, $password, $autotype);
                if ($status==2) {
                    $nickname=session("nickname");
                    if(empty($nickname)){
                      $this->redirect("Home/Member/addinfo");
                    }else{
                      $returnurl=cookie("returnurl");
                      if(!empty($returnurl)){
                          $returnurl=urldecode($returnurl);
                          redirect($returnurl);
                      }else{
                          $this->redirect("Home/Member/index");
                      }
                    }
                    
                    //$this->redirect('Home/Member/index');
                }elseif($status==0) {
                    $this->error('登录失败');
                }elseif($status==1) {
                    $this->error('帐号被禁用,请联系蜗牛客客服');
                }
            } else {
                $this->display();
            }
        }
    }
    /**
     *绑定手机号
     **第三方登录后完善信息
     */
    public function bindphone(){
      $uid=I('uid');
      $this->assign("uid",$uid);
      $this->display();
    }
    public function dobindphone(){
      $ret=$_POST;
      $uid=trim($ret['uid']);
      $password=trim($ret['password']);
      $phone=trim($ret['phone']);
      $telverify = trim($ret['telverify']);
      $sex=intval(trim($ret['sex']));

      $verifyset = M('verify')->where('phone=' . $phone)->find();
      $time = time() - $verifyset['expiretime'];
      if ($time > 0) {
          $verify = "";
          M('verify')->where('phone=' . $phone)->save(array(
            'status' => 1
          ));
      } else {
          $verify = $verifyset['verify'];
          M('verify')->where('phone=' . $phone)->save(array(
            'status' => 1
          ));
      }

      $where['id']=$uid;
      $user=M('Member')->where($where)->find();

      if($phone==''||$password==''||$uid==''||$telverify==''||$sex==''){
        exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
      }elseif (strtolower($telverify) != strtolower($verify)) {
          exit(json_encode(array('code' => -200, 'msg' => "验证码错误")));
      }elseif(!$user){
        exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
      }elseif(!check_phone($phone)){
        exit(json_encode(array('code'=>-200,'msg'=>"手机号已经被使用!")));
      }else{
        $verify = CommonController::genRandomString(6);
        $data['verify'] = $verify;
        $data['password'] = D("Member")->encryption($user['username'], $password, $verify);
        $data['phone']=$phone;
        $data['sex']=$sex;
        $id=M('Member')->where("id=" . $user['id'])->save($data);
        if($id){
            session('username', $user['username']);
            session('uid', $uid);
            if ($autotype == 1) {
                $autoinfo = $uid . "|" . $user['username'] . "|" . get_client_ip();
                $auto = \Home\Common\CommonController::authcode($autoinfo, "ENCODE");
                cookie('auto', $auto, C('AUTO_TIME_LOGIN'));
            }
          exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
        }else{
          exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
        }
      }
    }
    /**
     *补充信息
     *普通注册后完善信息
     */
    public function addinfo(){
      $this->display();
    }
    public function doaddinfo(){
      $ret=$_POST;
      $uid=session("uid");
      $nickname=trim($ret['nickname']);
      $sex=intval(trim($ret['sex']));

      $where['id']=$uid;
      $user=M('Member')->where($where)->find();

      if($nickname==''||$uid==''||$sex==''){
        exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
      }elseif(!$user){
        exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
      }else{
        $data['nickname']=$nickname;
        $data['sex']=$sex;
        $id=M('Member')->where("id=" . $user['id'])->save($data);
        if($id){
          exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
        }else{
          exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
        }
      }
    }
    /**
     * 会员退出登录
     * @author yiyouguisu<741459065@qq.com> time|20151219
     * @retrun void
     */
    public function loginout() {
        if (session('uid')) {
            cookie('auto', null);
            session('uid', null);
            session('username', null);
            $this->redirect('Member/login');
        } else {
            $this->error('已经退出！');
        }
    }
    /**
     * 登陆
     * @param int|string $identifier 用户ID,或者用户名
     * @param string $password 用户密码，不能为空
     * @param int $autotype 是否记住用户自动登录
     * @return int 
     */
    public function loginHome($identifier, $password, $autotype = 0) {
        if (empty($identifier) || empty($password)) {
            return 0;
        }else{
            $user = D("member")->getLocalAdminUser($identifier, $password);
            if (!$user) {
                $this->recordLoginHome($identifier, $password, 0, "帐号密码错误");
                return 0;
            }elseif ($user['status'] == 0) {
                $this->recordLoginHome($identifier, $password, 0, "帐号被禁止");
                return 1;
            }else{
                session('username', $user['username']);
                session('nickname', $user['nickname']);
                session('phone', $user['phone']);
                session('uid', $user['id']);
                if ($autotype == 1) {
                    $autoinfo = $user['id'] . "|" . $user['username'] . "|" . get_client_ip();
                    $auto = \Home\Common\CommonController::authcode($autoinfo, "ENCODE");
                    cookie('auto', $auto, C('AUTO_TIME_LOGIN'));
                }
                M("member")->where(array("id" => $user['id']))->save(array(
                    "lastlogin_time" => time(),
                    "login_num" => $user["login_num"] + 1,
                    "lastlogin_ip" => get_client_ip()
                ));
                return 2;
            }
        }
        
        
    }

    /**
     * 记录前台登陆信息
     * @param string $identifier 用户名
     * @param string $password 用户密码
     * @param int $status 状态 1登录成功 0登录失败
     * @param string $info 备注
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function recordLoginHome($identifier, $password, $status, $info = "") {
        M("userlog")->add(array(
            "username" => $identifier,
            "logintime" => date("Y-m-d H:i:s"),
            "loginip" => get_client_ip(),
            "status" => $status,
            "password" => "***" . substr($password, 3, 4) . "***",
            "info" => $info
        ));
    }
    /**
     *修改密码
     */
    public function dochangepassword(){
      $ret=$_POST;
      $telverify=trim($ret['telverify']);
      $new_password=trim($ret['new_password']);
      $phone=trim($ret['phone']);
      $uid = session("uid");

      $where['id']=$uid;
      $user=M('Member')->where($where)->find();

      $verifyset=M('verify')->where('phone=' . $phone)->find();
      $time=time()-$verifyset['expiretime'];
      if($time>0){
        $verify="";
        M('verify')->where('phone=' . $phone)->save(array(
          'status'=>1
        ));
      }else{
        $verify=$verifyset['verify'];
        M('verify')->where('phone=' . $phone)->save(array(
          'status'=>1
        ));
      }
      if($uid==''||$telverify==''||$new_password==''){
        exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
      }elseif(strtolower($telverify)!=strtolower($verify)){
        exit(json_encode(array('code'=>-200,'msg'=>"验证码错误")));
      }elseif(empty($user)){
        exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
      }else{
        $verify = CommonController::genRandomString(6);
        $data['verify'] = $verify;
        $data['password'] = D("Member")->encryption($user['username'], $new_password, $verify);
        $id=M('Member')->where($where)->save($data);
        if($id){
          exit(json_encode(array('code'=>200,'msg'=>"修改成功")));
        }else{
          exit(json_encode(array('code'=>-202,'msg'=>"修改失败")));
        }
      }
    }
    /**
     * 会员忘记密码
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function forgot() {
        $this->display();
    }
    public function doforgot(){
      $ret=$_POST;
      $telverify=trim($ret['telverify']);
      $new_password=trim($ret['password']);
      $phone=trim($ret['phone']);

      $where['phone']=$phone;
      $user=M('Member')->where($where)->find();

      $verifyset=M('verify')->where('phone=' . $phone)->find();
      $time=time()-$verifyset['expiretime'];
      if($time>0){
        $verify="";
        M('verify')->where('phone=' . $phone)->save(array(
          'status'=>1
        ));
      }else{
        $verify=$verifyset['verify'];
        M('verify')->where('phone=' . $phone)->save(array(
          'status'=>1
        ));
      }
      if($phone==''||$new_password==''||$telverify==''){
        exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
      }elseif(strtolower($telverify)!=strtolower($verify)){
        exit(json_encode(array('code'=>-200,'msg'=>"验证码错误")));
      }elseif(!$user){
        exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
      }else{
        $verify = CommonController::genRandomString(6);
        $data['verify'] = $verify;
        $data['password'] = D("Member")->encryption($user['username'], $new_password, $verify);
        $id=M('Member')->where("id=" . $user['id'])->save($data);
        if($id){
          exit(json_encode(array('code'=>200,'msg'=>"重置密码成功")));
        }else{
          exit(json_encode(array('code'=>-202,'msg'=>"重置密码失败")));
        }
      }
    }
    public function dochangephone(){
      $ret=$_POST;
      $uid=session("uid");
      $phone=trim($ret['phone']);
      $telverify = trim($ret['telverify']);

      $verifyset = M('verify')->where('phone=' . $phone)->find();
      $time = time() - $verifyset['expiretime'];
      if ($time > 0) {
          $verify = "";
          M('verify')->where('phone=' . $phone)->save(array(
          'status' => 1
          ));
      } else {
          $verify = $verifyset['verify'];
          M('verify')->where('phone=' . $phone)->save(array(
          'status' => 1
          ));
      }

      $where['id']=$uid;
      $user=M('Member')->where($where)->find();

      if($phone==''||$uid==''||$telverify==''){
        exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
      }elseif (strtolower($telverify) != strtolower($verify)) {
          exit(json_encode(array('code' => -200, 'msg' => "验证码错误")));
      }elseif(!$user){
        exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
      }elseif(!check_phone($phone)){
        exit(json_encode(array('code'=>-200,'msg'=>"手机号已经被使用!")));
      }else{
        $data['phone']=$phone;
        $id=M('Member')->where("id=" . $user['id'])->save($data);
        if($id){
          exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
        }else{
          exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
        }
      }
    }
    public function ajax_area(){
        $map['parentid']=$_POST["parentid"];
        $list=M("area")->where(array('status'=>1))->where($map)->select();
        echo json_encode($list);
    }
    /**
     * 会员修改个人信息
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function change_info() {
        if(!session('uid')){
            $this->error("请先登录",U('Member/login'));
        }else{
            if(IS_POST){
                $data=$_POST;
                $characteristic=array_diff($data['characteristic'], array(null,'null','',' '));
                $data['characteristic']=implode(",", $characteristic);
                $hobby=array_diff($data['hobby'], array(null,'null','',' '));
                $data['hobby']=implode(",", $hobby);
                $data['area']=$_POST['province'] . ',' . $_POST['city'] . ',' . $_POST['town'];
                $data['hometown']=$_POST['province1'] . ',' . $_POST['city1'] . ',' . $_POST['town1'];
                $data['id']=session("uid");
                $data['username']=session("username");
                if (false !== D("member")->editUser($data)) {
                    $this->success("修改成功",U('Home/Member/index'));
                }else{
                    $this->error("修改失败");
                }
            }else{
                $userinfo=M('member')->where('id=' . session('uid'))->find();
                $area=explode(',', $userinfo['area']);
                $userinfo['province']=$area[0];
                $userinfo['city']=$area[1];
                $userinfo['town']=$area[2];
                $address=explode(',', $userinfo['hometown']);
                $userinfo['province1']=$address[0];
                $userinfo['city1']=$address[1];
                $userinfo['town1']=$address[2];
                $this->assign('userinfo',$userinfo);
                $province = M('area')->where(array('parentid'=>0,'status'=>1))->select();
                $this->assign('province',$province);
                $characteristic = M("linkage")->where("catid=1")->field('value,name')->select();
                $this->assign('characteristic',$characteristic);
                $hobby = M("linkage")->where("catid=2")->field('value,name')->select();
                $this->assign('hobby',$hobby);
                $this->display();
            }
        }
    }
    /**
     * 会员修改图像
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function change_head() {
        if (!session('uid')) {
            $this->error("请先登录",U('Member/login'));
        } else {
            if (IS_POST) {
                if(empty($_POST['head'])){
                    $this->error('图像不能为空！');
                }
                if (!preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$_POST['head'])){
                    $head=$_POST['head'];
                }else{
                    $head=auto_save_image($_POST['head']);
                }
                $imgshot = new Imgshot();
                $imgshot->initialize(substr($head, 1), $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'],200,200);
                $filename=$imgshot->generate_shot();
                $id=M('Member')->where('id=' . session("uid"))->save(array(
                    'head'=>$filename
                ));
                if ($id) {
                    $this->redirect("Home/Member/change_head");
                } else {
                    $this->error('修改失败！');
                }
            } else {
                $this->display();
            }
        }
    }
    /**
     * 会员修改背景
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    
    public function change_background() {
        if (!session('uid')) {
            $this->error('请先登录！');
        } else {
            if (IS_POST) {
                if(empty($_POST['background'])){
                    $this->error('图像不能为空！');
                }
                $imgshot = new Imgshot();

                $image = new \Think\Image(); 
                $image->open('.'.$_POST['background']);
                $width = $image->width(); // 返回图片的宽度
                $height = $image->height(); // 返回图片的高度
                $ratio = 956/$width;
                $w = (int)round( $_POST['w'] / $ratio);
                $h = (int)round( $_POST['h'] / $ratio);
                $x = (int)round( $_POST['x'] / $ratio);
                $y = (int)round( $_POST['y'] / $ratio);
                $imgshot->initialize(substr($_POST['background'], 1), $x, $y, $w, $h,1920,200);
                $filename=$imgshot->generate_shot();

                // $imgshot->initialize(substr($_POST['background'], 1), $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'],1920,200);
                // $filename=$imgshot->generate_shot();
                $id=M('Member')->where('id=' . session("uid"))->save(array(
                    'background'=>$filename
                ));
                if ($id) {
                    $this->redirect("Home/Member/change_background");
                } else {
                    $this->error('修改失败！');
                }
            } else {
                $this->display();
            }
        }
    }
    public function test(){
        $imgshot = new Imgshot();

        $file="/Uploads/images/pc/20161108/144321_5066.jpg";

        $image = new \Think\Image(); 
        $image->open('.'.$file);
        $width = $image->width(); // 返回图片的宽度
        $height = $image->height(); // 返回图片的高度
        $ratio = 956/$width;
        $w = (int)round(956 / $ratio);
        $h = (int)round(100 / $ratio);
        $x = (int)round(0 / $ratio);
        $y = (int)round( 238 / $ratio);
        $imgshot->initialize(substr($file, 1), $x, $y, $w, $h,1920,200);
        $filename=$imgshot->generate_shot();
    }

      public function resizeimage($pic_width,$pic_height,$maxwidth){
              if($maxwidth && $pic_width>$maxwidth)
              {
                  $ratio = $maxwidth/$pic_width;
              }

              $newwidth = $pic_width * $ratio;
              $newheight = $pic_height * $ratio;
              return $newwidth;
          
      }
    /**
     * 我的钱包
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function mywallet() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
          $uid=session('uid');
          $account=M('account')->where(array('uid'=>$uid))->find();
          $this->assign("account", $account);

          $count=M("account_log")->where(array('uid'=>$uid))->count();
          $page = new \Think\Page($count,10);
          $walletlog=M("account_log")->where(array('uid'=>$uid))->order(array('id'=>"desc"))->limit($page->firstRow . ',' . $page->listRows)->field("id,money,total,dcflag,remark,status,addtime")->page($p,$num)->select();
          $page->setConfig('prev','上一页');
          $page->setConfig('next','下一页');
          $show = $page->show();
          $this->assign("walletlog", $walletlog);
          $this->assign("Page", $show);
          if($_GET['isAjax']==1){
              $jsondata['status']=1;
              $jsondata['html']  = $this->fetch("morelist_walletlog");
              $this->ajaxReturn($jsondata,'json');
          }else{
              $this->display();
          }
        }
    }
    /**
     *房东申请体现
     */
    public function withdraw(){
      $ret=$_POST;
      $uid=intval(trim($ret['uid']));
      $alipayaccount=trim($ret['alipayaccount']);
      $realname=trim($ret['realname']);
      $money=floatval(trim($ret['money']));
      $fee=floatval(trim($ret['fee']));
          
      $where['id']=$uid;
      $result=M('Member')->where($where)->find();

      $usemoney=M('account')->where(array('uid'=>$uid))->getField("usemoney");

      if($uid==''||$realname==''||$money==''||$alipayaccount==''){
        exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
      }elseif(empty($result)){
        exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
      }elseif($usemoney<$money||empty($usemoney)){
        exit(json_encode(array('code'=>-200,'msg'=>"可用金额不足")));
      }else{
        $id=M('withdraw')->add(array(
            'uid'=>$uid,
            'alipayaccount'=>$alipayaccount,
            'realname'=>$realname,
            'money'=>$money,
            'fee'=>$fee,
            'ip'=>get_client_ip(),
            'inputtime'=>time()
        ));
        if($id){
          $account=M('account')->where(array('uid'=>$uid))->find();

          $mid=M('account')->where(array('uid'=>$uid))->save(array(
            'nousemoney'=>$account['nousemoney']+floatval($money),
            'usemoney'=>$account['usemoney']-floatval($money),
            ));
          if($mid){
            M('account_log')->add(array(
              'uid'=>$uid,
              'type'=>'applywithdraw',
              'money'=>$money,
              'total'=>$account['total'],
              'usemoney'=>$account['usemoney']-floatval($money),
              'nousemoney'=>$account['nousemoney']+floatval($money),
              'status'=>1,
              'dcflag'=>2,
              'remark'=>'申请提现',
              'addip'=>get_client_ip(),
              'addtime'=>time()
              ));
          }
          exit(json_encode(array('code'=>200,'msg'=>"申请成功")));
        }else{
          exit(json_encode(array('code'=>-202,'msg'=>"申请失败")));
        }
      }
    }
    /**
     * 我的游记
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function mynote() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $where=array();
            $order=array('a.id'=>'desc');
            $where['a.uid']=$uid;
            $where['a.isdel']=0;
            $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $count=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)->count();
            $page = new \Think\Page($count,10);
            $list=M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.thumb,a.description,a.content,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.status,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
            foreach ($list as $key => $value)
            { 
                if(empty($value['reviewnum'])) $list[$key]['reviewnum']=0;
                $list[$key]['description'] = $this->str_cut(trim(strip_tags($value['content'])), 250);
                $collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['nid']))->count();
                $list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
            }
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $jsondata['status']=1;
                $jsondata['html']  = $this->fetch("morelist_mynote");
                $this->ajaxReturn($jsondata,'json');
            }else{
                $this->display();
            }
        }
    }
    /**
     * 我的优惠券
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function mycoupons() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
            $uid=session("uid");
            $type=I('varname');
            if(empty($type)){
              $type="waituse";
            }
            
            switch ($type) {
              case "waituse":
                  $count=M('vouchers_order a')
                      ->join("left join zz_vouchers b on a.catid=b.id")
                      ->where(array('a.uid'=>$uid,'b.id'=>array('in',$catids),'a.status'=>0,'b.validity_endtime'=>array('gt',time())))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('vouchers_order a')
                      ->join("left join zz_vouchers b on a.catid=b.id")
                      ->where(array('a.uid'=>$uid,'b.id'=>array('in',$catids),'a.status'=>0,'b.validity_endtime'=>array('gt',time())))
                      ->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->field("a.id,b.thumb,b.title,b.price,b.type,b.validity_starttime,b.validity_endtime,a.num,a.`status`,b.`range`")
                      ->select();
                  break;
              case "usedone":
                  $count=M('vouchers_order a')
                      ->join("left join zz_vouchers b on a.catid=b.id")
                      ->where(array('a.uid'=>$uid,'b.id'=>array('in',$catids),'a.status'=>1,'b.validity_endtime'=>array('gt',time())))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('vouchers_order a')
                      ->join("left join zz_vouchers b on a.catid=b.id")
                      ->where(array('a.uid'=>$uid,'b.id'=>array('in',$catids),'a.status'=>1,'b.validity_endtime'=>array('gt',time())))
                      ->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->field("a.id,b.thumb,b.title,b.price,b.type,b.validity_starttime,b.validity_endtime,a.num,a.`status`,b.`range`")
                      ->select();
                  break;
              case "enddone":
                  $count=M('vouchers_order a')
                      ->join("left join zz_vouchers b on a.catid=b.id")
                      ->where(array('a.uid'=>$uid,'b.id'=>array('in',$catids),'b.validity_endtime'=>array('lt',time())))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('vouchers_order a')
                      ->join("left join zz_vouchers b on a.catid=b.id")
                      ->where(array('a.uid'=>$uid,'b.id'=>array('in',$catids),'b.validity_endtime'=>array('lt',time())))
                      ->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->field("a.id,b.thumb,b.title,b.price,b.type,b.validity_starttime,b.validity_endtime,a.num,a.`status`,b.`range`")
                      ->select();
                  break;
            }
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $jsondata['status']=1;
                $jsondata['html']  = $this->fetch("morelist_mycoupons");
                $this->ajaxReturn($jsondata,'json');
            }else{
                $this->display();
            }
        }
    }

    public function couponsshow(){
        $id=I('id');
        $data = M('vouchers_order a')
            ->join("left join zz_vouchers b on a.catid=b.id")
            ->where(array('a.id'=>$id))
            ->field("a.id,a.catid,b.thumb,b.title,b.voucherstype,b.voucherscale,a.price,a.hid,a.aid,b.city,b.`range`,b.validity_starttime,b.validity_endtime,a.`status`,b.`range`,b.content")->find();
        if(!empty($data['city'])){
            $data['cityname']=M('area')->where(array('id'=>$data['city']))->getField("name");
        }
        if(!empty($data['hid'])){
           $data['hostel']=M('hostel')->where(array('id'=>array('in',trim($data['hid'],','))))->getField("title",true); 
        }
        if(!empty($data['aid'])){
            $data['party']=M('Activity')->where(array('id'=>array('in',trim($data['aid'],','))))->getField("title",true); 
        }
        $this->assign("data",$data);
        $this->display();
    }
    /**
     * 我的订单
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function myorder_hostel() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $type=I('varname');
            if(empty($type)){
              $type="all";
            }
            
            switch ($type) {
              case "all":
                  $where=array('a.uid|e.uid'=>$uid,'a.ordertype'=>1);
                  $order=array('a.inputtime'=>'desc');
                  $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,c.refund_status,a.ordertype,c.donetime,c.review_remark,d.endtime,f.remark as refundreview_remark');
                  $count=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_book_room d on a.orderid=d.orderid")
                      ->join("left join zz_hostel e on d.hid=e.id")
                      ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_book_room d on a.orderid=d.orderid")
                      ->join("left join zz_hostel e on d.hid=e.id")
                      ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                      ->where($where)
                      ->order($order)
                      ->field($field)
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value) {
                      # code...
                      $productinfo=M('book_room a')
                          ->join("left join zz_room c on a.rid=c.id")
                          ->join("left join zz_hostel b on c.hid=b.id")
                          ->where(array('a.orderid'=>$value['orderid']))
                          ->field("a.rid,b.id as hid,b.thumb,b.title,b.money,a.starttime,a.endtime")
                          ->find();
                      $list[$key]['productinfo']=$productinfo;
                  }
                  break;
              case "waitpay":
                  $where=array('a.uid|e.uid'=>$uid,'c.status'=>2,'c.pay_status'=>0,'a.ordertype'=>1);
                  $order=array('a.inputtime'=>'desc');
                  $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime,d.endtime');
                  $count=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_book_room d on a.orderid=d.orderid")
                      ->join("left join zz_hostel e on d.hid=e.id")
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_book_room d on a.orderid=d.orderid")
                      ->join("left join zz_hostel e on d.hid=e.id")
                      ->where($where)
                      ->order($order)
                      ->field($field)
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value) {
                      # code...
                      $productinfo=M('book_room a')
                          ->join("left join zz_room c on a.rid=c.id")
                          ->join("left join zz_hostel b on c.hid=b.id")
                          ->where(array('a.orderid'=>$value['orderid']))
                          ->field("a.rid,b.id as hid,b.thumb,b.title,b.money,a.starttime,a.endtime")
                          ->find();
                      $list[$key]['productinfo']=$productinfo;
                  }
                  break;
              case "waitreview":
                  $where=array('a.uid|e.uid'=>$uid,'c.status'=>1,'c.pay_status'=>0,'a.ordertype'=>1);
                  $order=array('a.inputtime'=>'desc');
                  $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime,d.endtime');
                  $count=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_book_room d on a.orderid=d.orderid")
                      ->join("left join zz_hostel e on d.hid=e.id")
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_book_room d on a.orderid=d.orderid")
                      ->join("left join zz_hostel e on d.hid=e.id")
                      ->where($where)
                      ->order($order)
                      ->field($field)
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value) {
                      # code...
                      $productinfo=M('book_room a')
                          ->join("left join zz_room c on a.rid=c.id")
                          ->join("left join zz_hostel b on c.hid=b.id")
                          ->where(array('a.orderid'=>$value['orderid']))
                          ->field("a.rid,b.id as hid,b.thumb,b.title,b.money,a.starttime,a.endtime")
                          ->find();
                      $list[$key]['productinfo']=$productinfo;
                  }
                  break;
              case "done":
                  $where=array('a.uid|e.uid'=>$uid,'c.status'=>4,'c.pay_status'=>1,'a.ordertype'=>1);
                  $order=array('a.inputtime'=>'desc');
                  $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,c.refund_status,a.ordertype,c.donetime,d.endtime,f.remark as refundreview_remark');
                  $count=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_book_room d on a.orderid=d.orderid")
                      ->join("left join zz_hostel e on d.hid=e.id")
                      ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('order a')->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_book_room d on a.orderid=d.orderid")
                      ->join("left join zz_hostel e on d.hid=e.id")
                      ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                      ->where($where)
                      ->order($order)
                      ->field($field)
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value) {
                      # code...
                      $productinfo=M('book_room a')
                          ->join("left join zz_room c on a.rid=c.id")
                          ->join("left join zz_hostel b on c.hid=b.id")
                          ->where(array('a.orderid'=>$value['orderid']))
                          ->field("a.rid,b.id as hid,b.thumb,b.title,b.money,a.starttime,a.endtime")
                          ->find();
                      $list[$key]['productinfo']=$productinfo;
                  }
                  break;
            }
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $jsondata['status']=1;
                $jsondata['html']  = $this->fetch("morelist_hostelorder");
                $this->ajaxReturn($jsondata,'json');
            }else{
                $this->display();
            }
        }
    }
    /**
     * 我的订单
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function myorder_party() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
          $uid=session("uid");
            $type=I('varname');
            if(empty($type)){
              $type="done";
            }
            
            switch ($type) {
              case "all":
                  $where=array('a.uid|e.uid'=>$uid,'a.ordertype'=>2);
                  $order=array('a.inputtime'=>'desc');
                  $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,c.refund_status,a.ordertype,c.donetime,e.endtime,f.remark as refundreview_remark');
                  $count=M('order a')
                      ->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_activity_apply d on a.orderid=d.orderid")
                      ->join("left join zz_activity e on d.aid=e.id")
                      ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('order a')
                      ->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_activity_apply d on a.orderid=d.orderid")
                      ->join("left join zz_activity e on d.aid=e.id")
                      ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                      ->where($where)
                      ->order($order)
                      ->field($field)
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value) {
                      # code...
                      $productinfo=M('activity_apply a')
                          ->join("left join zz_activity b on a.aid=b.id")
                          ->where(array('a.orderid'=>$value['orderid']))
                          ->field("a.aid,b.thumb,b.title,b.money,b.isfree,b.starttime,b.endtime,b.area,b.address")
                          ->find();
                      $list[$key]['productinfo']=$productinfo;
                  }
                  break;
              case "done":
                  $where=array('a.uid|e.uid'=>$uid,'c.status'=>4,'c.pay_status'=>1,'a.ordertype'=>2);
                  $order=array('a.inputtime'=>'desc');
                  $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,c.refund_status,a.ordertype,c.donetime,e.endtime,f.remark as refundreview_remark');
                  $count=M('order a')
                      ->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_activity_apply d on a.orderid=d.orderid")
                      ->join("left join zz_activity e on d.aid=e.id")
                      ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('order a')
                      ->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_activity_apply d on a.orderid=d.orderid")
                      ->join("left join zz_activity e on d.aid=e.id")
                      ->join("left join zz_refund_apply f on a.orderid=f.orderid")
                      ->where($where)
                      ->order($order)
                      ->field($field)
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value) {
                      # code...
                      $productinfo=M('activity_apply a')
                          ->join("left join zz_activity b on a.aid=b.id")
                          ->where(array('a.orderid'=>$value['orderid']))
                          ->field("a.aid,b.thumb,b.title,b.money,b.isfree,b.starttime,b.endtime,b.area,b.address")
                          ->find();
                      $list[$key]['productinfo']=$productinfo;
                  }
                  break;
              case "waitpay":
                  $where=array('a.uid|e.uid'=>$uid,'c.status'=>2,'c.pay_status'=>0,'a.ordertype'=>2);
                  $order=array('a.inputtime'=>'desc');
                  $field=array('a.uid,a.orderid,a.discount,a.money,a.total,a.inputtime,a.paytype,c.status,c.pay_status,c.evaluate_status,a.ordertype,c.donetime,e.endtime');
                  $count=M('order a')
                      ->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_activity_apply d on a.orderid=d.orderid")
                      ->join("left join zz_activity e on d.aid=e.id")
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('order a')
                      ->join("left join zz_order_time c on a.orderid=c.orderid")
                      ->join("left join zz_activity_apply d on a.orderid=d.orderid")
                      ->join("left join zz_activity e on d.aid=e.id")
                      ->where($where)
                      ->order($order)
                      ->field($field)
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value) {
                      # code...
                      $productinfo=M('activity_apply a')
                          ->join("left join zz_activity b on a.aid=b.id")
                          ->where(array('a.orderid'=>$value['orderid']))
                          ->field("a.aid,b.thumb,b.title,b.money,b.isfree,b.starttime,b.endtime,b.area,b.address")
                          ->find();
                      $list[$key]['productinfo']=$productinfo;
                  }
                  break;
              
            }
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $jsondata['status']=1;
                $jsondata['html']  = $this->fetch("morelist_partyorder");
                $this->ajaxReturn($jsondata,'json');
            }else{
                $this->display();
            }
        }
    }
    /**
     * 我的评论
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function myreview() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $type=I('varname');
            if(empty($type)){
              $type="all";
            }
            
            switch ($type) {
              case "all":
                  $count=M('review a')
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M("review a")
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                      ->order(array('a.id'=>'desc'))
                      ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      if($value['varname']=='note'){
                          $list[$key]['title']=M('note')->where(array('id'=>$value['value']))->getField("title");
                      }else if($value['varname']=='party'){
                          $list[$key]['title']=M('activity')->where(array('id'=>$value['value']))->getField("title");
                      }else if($value['varname']=='hostel'){
                          $list[$key]['title']=M('hostel')->where(array('id'=>$value['value']))->getField("title");
                      }else if($value['varname']=='room'){
                          $list[$key]['title']=M('room')->where(array('id'=>$value['value']))->getField("title");
                      }else if($value['varname']=='trip'){
                          $list[$key]['title']=M('trip')->where(array('id'=>$value['value']))->getField("title");
                      }
                  }
                  $sql=M("review a")
                      ->join("left join zz_member b on a.uid=b.id")
                      ->_sql();
                  break;
              case "note":
                  $count=M('review a')
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'note'))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M("review a")
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'note'))
                      ->order(array('a.id'=>'desc'))
                      ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      $list[$key]['title']=M('note')->where(array('id'=>$value['value']))->getField("title");
                  }
                  break;
              case "hostel":
                  $count=M('review a')
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'hostel'))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M("review a")
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'hostel'))
                      ->order(array('a.id'=>'desc'))
                      ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      $list[$key]['title']=M('hostel')->where(array('id'=>$value['value']))->getField("title");
                  }
                  break;
              case "party":
                  $count=M('review a')
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'party'))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M("review a")
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'party'))
                      ->order(array('a.id'=>'desc'))
                      ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      $list[$key]['title']=M('activity')->where(array('id'=>$value['value']))->getField("title");
                  }
                  break;
              case "trip":
                  $count=M('review a')
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'trip'))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M("review a")
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'trip'))
                      ->order(array('a.id'=>'desc'))
                      ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      $list[$key]['title']=M('trip')->where(array('id'=>$value['value']))->getField("title");
                  }
                  break;
            }
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $jsondata['status']=1;
                $jsondata['html']  = $this->fetch("morelist_myreview");
                $this->ajaxReturn($jsondata,'json');
            }else{
                $this->display();
            }
        }
    }
    /**
     * 我的收藏
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function mycollect() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $type=I('varname');
            if(empty($type)){
              $type="hostel";
            }
            $uid=session("uid");
            switch ($type) {
              case "note":
                  $count=M('collect a')
                      ->join("left join zz_note b on a.value=b.id")
                      ->join("left join zz_member c on b.uid=c.id")
                      ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'note'))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('collect a')
                      ->join("left join zz_note b on a.value=b.id")
                      ->join("left join zz_member c on b.uid=c.id")
                      ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'note'))
                      ->field('a.id,a.varname,b.id as nid,b.title,b.description,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.hit,b.begintime,b.endtime,b.uid,c.nickname,c.head,c.rongyun_token,a.inputtime')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->order(array('a.inputtime'=>'desc'))
                      ->select();
                  foreach ($list as $key => $value)
                  {   
                      $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'note','value'=>$value['nid']))->count();
                      $list[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

                      $collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['nid']))->count();
                      $list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
                  }
                  break;
              case "hostel":
                  $count=M('collect a')
                      ->join("left join zz_hostel b on a.value=b.id")
                      ->join("left join zz_member c on b.uid=c.id")
                      ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'hostel'))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('collect a')
                      ->join("left join zz_hostel b on a.value=b.id")
                      ->join("left join zz_member c on b.uid=c.id")
                      ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'hostel'))
                      ->field('a.id,a.varname,b.id as hid,b.title,b.thumb,b.money,b.area,b.city,b.address,b.lat,b.lng,b.hit,b.uid,c.nickname,c.head,c.rongyun_token,a.inputtime')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->order(array('a.inputtime'=>'desc'))
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'hostel','value'=>$value['hid']))->count();
                      $list[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

                      $collectnum=M('collect')->where(array('varname'=>'hostel','value'=>$value['hid']))->count();
                      $list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
                  }
                  $sql=M('collect a')->_sql();
                  break;
              case "party":
                  $count=M('collect a')
                      ->join("left join zz_activity b on a.value=b.id")
                      ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'party'))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('collect a')
                      ->join("left join zz_activity b on a.value=b.id")
                      ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'party'))
                      ->field('a.id,a.varname,b.id as aid,b.title,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.starttime,b.endtime')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->order(array('a.inputtime'=>'desc'))
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'party','value'=>$value['aid']))->count();
                      $list[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

                      $collectnum=M('collect')->where(array('varname'=>'party','value'=>$value['aid']))->count();
                      $list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
                      
                      $joinnum=M('activity_apply')->where(array('aid'=>$value['aid'],'paystatus'=>1))->sum("num");
                      $list[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                  }
                  break;
              case "trip":
                  $count=M('collect a')
                      ->join("left join zz_activity b on a.value=b.id")
                      ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'party'))
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M('collect a')
                      ->join("left join zz_activity b on a.value=b.id")
                      ->where(array('a.uid'=>$uid,'b.isdel'=>0,'a.varname'=>'party'))
                      ->field('a.id,a.varname,b.id as aid,b.title,b.thumb,b.area,b.city,b.address,b.lat,b.lng,b.starttime,b.endtime')
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->order(array('a.inputtime'=>'desc'))
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      $reviewnum=M('review')->where(array('isdel'=>0,'varname'=>'party','value'=>$value['aid']))->count();
                      $list[$key]['reviewnum']=!empty($reviewnum)?$reviewnum:0;

                      $collectnum=M('collect')->where(array('varname'=>'party','value'=>$value['aid']))->count();
                      $list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
                      
                      $joinnum=M('activity_apply')->where(array('aid'=>$value['aid'],'paystatus'=>1))->sum("num");
                      $list[$key]['joinnum']=!empty($joinnum)?$joinnum:0;
                  }
                  break;
            }
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $jsondata['status']=1;
                $jsondata['html']  = $this->fetch("morelist_mycollect");
                $this->ajaxReturn($jsondata,'json');
            }else{
                $this->display();
            }
        }
    }
    /**
     * 我的发布
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function myrelease() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $type=I('varname');
            if(empty($type)){
              $type="hostel";
            }
            $status=$_GET['status'];
            if ($status == "" || $status == null) {
                $status=1;
            }
            switch ($type) {
              case "hostel":
                  $where=array();
                  if($status=='1') $where['a.status']=2;
                  elseif($status=='0') $where['a.status']=1;
                  $count=M('Hostel a')
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M("Hostel a")
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                      ->where($where)
                      ->order(array('a.id'=>'desc'))
                      ->field("a.id,a.title,a.acreage,a.bedtype,a.thumb,a.money,a.status,a.uid,a.inputtime,'hostel' as varname")
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                  foreach ($list as $key => $value)
                  {
                      $list[$key]['bedtype']=trim($value['bedtype'],",");
                  }
                  $sql=M("Hostel a")
                      ->join("left join zz_member b on a.uid=b.id")->_sql();
                  break;
              case "party":
                  $where=array();
                  if($status=='1') $where['a.status']=2;
                  elseif($status=='0') $where['a.status']=1;
                  $count=M('activity a')
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                      ->where($where)
                      ->count();
                  $page = new \Think\Page($count,10);
                  $list=M("activity a")
                      ->join("left join zz_member b on a.uid=b.id")
                      ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                      ->where($where)
                      ->order(array('a.id'=>'desc'))
                      ->field("a.id,a.title,a.thumb,a.money,a.address,a.status,a.uid,a.starttime,a.endtime,a.inputtime,'party' as varname")
                      ->limit($page->firstRow . ',' . $page->listRows)
                      ->select();
                      $sql=M("activity a")
                      ->join("left join zz_member b on a.uid=b.id")->_sql();
                  break;
            }
            $page->setConfig('prev','上一页');
            $page->setConfig('next','下一页');
            $show = $page->show();
            $this->assign("data", $list);
            $this->assign("Page", $show);
            if($_GET['isAjax']==1){
                $jsondata['status']=1;
                //$jsondata['sql']=$sql;
                $jsondata['html']  = $this->fetch("morelist_myrelease");
                $this->ajaxReturn($jsondata,'json');
            }else{
                $this->display();
            }
        }
    }
    /**
     * 账号安全
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function save() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $alipayaccount=M("alipayaccount")->where(array('uid'=>$uid))->getField("alipayaccount");
            $this->assign("alipayaccount",$alipayaccount);
            $this->display();
        }
    }  
    
    public function ajax_set_alipayaccount(){
        $ret=$_POST;
        $uid=session("uid");
        $realname=trim($ret['realname']);
        $alipayaccount=trim($ret['alipayaccount']);
        
        $user=M('Member')->where(array('id'=>$uid))->find();
        $alipayaccountset= M('alipayaccount')->where(array('uid'=>$uid))->find();
        if($uid==''||$realname==''||$alipayaccount==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }else{
            if(empty($alipayaccountset)){
                $data['uid']=$uid;
                $data['realname']=$realname;
                $data['alipayaccount']=$alipayaccount;
                $data['inputtime']=time();
                $id=M('alipayaccount')->add($data);
            }else{
                $data['realname']=$realname;
                $data['alipayaccount']=$alipayaccount;
                $id=M('alipayaccount')->where(array('uid'=>$uid))->save($data);
            }
            if($id){
                echo json_encode(array('code'=>200,'msg'=>"提交成功"));
            }else{
                echo json_encode(array('code'=>-202,'msg'=>"提交失败"));
            }
        }
    }
    /**
     * 帮助手册
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function help() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $data=M("question")->order(array('id'=>"desc"))->field('id,title,content,inputtime')->select();
            $this->assign("data",$data);
            $instruction=M("config")->where(array('groupid'=>6,'varname'=>'instruction'))->getField("value");
            $this->assign("instruction",$instruction);
            $this->display();
        }
    }
    /**
     * 帮助信息详情
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function helpshow() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $id=$_GET['id'];
            $data=M("question")->where(array('id'=>$id))->order(array('id'=>"desc"))->field('id,title,content,inputtime')->find();
            $this->assign("data",$data);
            $this->display();
        }
    }
    /**
     * 会员常用联系人
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function linkman() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            $uid=session("uid");
            $data=M("linkman")
                ->where(array('uid'=>$uid))
                ->order(array('id'=>"desc"))
                ->field('id,realname,idcard,phone,inputtime')
                ->select();
            $this->assign("data",$data);
            $this->display();
        }
    }
    public function ajax_add_linkman(){
        $ret=$_POST;
        $uid=session("uid");
        $realname=trim($ret['realname']);
        $idcard=trim($ret['idcard']);
        $phone=trim($ret['phone']);
        $user=M('Member')->where(array('id'=>$uid))->find();
        $linkman= M('linkman')->where(array('realname'=>$realname,'idcard'=>$idcard,'phone'=>$phone))->find();
        $linkman_idcard=M('linkman')->where(array('idcard'=>$idcard))->find();
        $linkman_phone=M('linkman')->where(array('phone'=>$phone))->find();
        if($uid==''||$realname==''||$idcard==''||$phone==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(!empty($linkman)){
            exit(json_encode(array('code'=>-200,'msg'=>"联系人已经存在")));
        }elseif(!empty($linkman_idcard)){
            exit(json_encode(array('code'=>-200,'msg'=>"身份证号已经存在")));
        }elseif(!empty($linkman_phone)){
            exit(json_encode(array('code'=>-200,'msg'=>"手机号码已经存在")));
        }else{
            $data['uid']=$uid;
            $data['realname']=$realname;
            $data['idcard']=$idcard;
            $data['phone']=$phone;
            $data['inputtime']=time();
            $id=M('linkman')->add($data);
            if($id){
                echo json_encode(array('code'=>200,'msg'=>"提交成功",'linkmanid'=>$id));
            }else{
                echo json_encode(array('code'=>-202,'msg'=>"提交失败"));
            }
        }
    }
    public function ajax_edit_linkman(){
        $ret=$_POST;
        $uid=session("uid");
        $lmid=intval(trim($ret['lmid']));
        $realname=trim($ret['realname']);
        $idcard=trim($ret['idcard']);
        $phone=trim($ret['phone']);
        $user=M('Member')->where(array('id'=>$uid))->find();
        $linkman= M('linkman')->where(array('id'=>$lmid))->find();
        $linkman_idcard=M('linkman')->where(array('idcard'=>$idcard,'id'=>array('neq',$lmid)))->find();
        $linkman_phone=M('linkman')->where(array('phone'=>$phone,'id'=>array('neq',$lmid)))->find();
        if($uid==''||$lmid==''||$realname==''||$idcard==''||$phone==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($linkman)){
            exit(json_encode(array('code'=>-200,'msg'=>"联系人不存在")));
        }elseif(!empty($linkman_idcard)){
            exit(json_encode(array('code'=>-200,'msg'=>"身份证号已经存在")));
        }elseif(!empty($linkman_phone)){
            exit(json_encode(array('code'=>-200,'msg'=>"手机号码已经存在")));
        }else{
            $data['uid']=$uid;
            $data['realname']=$realname;
            $data['idcard']=$idcard;
            $data['phone']=$phone;
            $data['updatetime']=time();
            $id=M('linkman')->where(array('id'=>$lmid))->save($data);
            if($id){
                echo json_encode(array('code'=>200,'msg'=>"提交成功"));
            }else{
                echo json_encode(array('code'=>-202,'msg'=>"提交失败"));
            }
        }
    }
    public function ajax_del_linkman(){
        $ret=$_POST;
        $uid=session("uid");
        $lmid=intval(trim($ret['lmid']));
        
        $user=M('Member')->where(array('id'=>$uid))->find();
        $linkman= M('linkman')->where(array('id'=>$lmid))->find();
        if($uid==''||$lmid==''){
            exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
        }elseif(empty($linkman)){
            exit(json_encode(array('code'=>-200,'msg'=>"联系人不存在")));
        }else{
            $id=M('linkman')->where(array('id'=>$lmid))->delete();
            if($id){
                echo json_encode(array('code'=>200,'msg'=>"提交成功"));
            }else{
                echo json_encode(array('code'=>-202,'msg'=>"提交失败"));
            }
        }
    }
    /**
     * 会员实名认证
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function realname() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            if(IS_POST){
                $uid=session("uid");
                $realname=trim($_POST['realname']);
                $idcard=trim($_POST['idcard']);
                $idcard_front=trim($_POST['idcard_front']);
                $idcard_back=trim($_POST['idcard_back']);
                $alipayaccount=trim($_POST['alipayaccount']);


                $where['id']=$uid;
                $result=M('Member')->where($where)->find();

                if($uid==''||$realname==''||$idcard==''||$idcard_front==''||$idcard_back==''){
                    $this->error("请上传身份证正反面图片");
                }elseif(empty($result)){
                    $this->error("用户不存在");
                }elseif(!funccard($idcard)){
                    $this->error("身份证号码格式错误");
                }elseif($result['realname_status']==1){
                    $this->error("用户已经实名认证");
                }elseif(!check_idcard($idcard)){
                    $this->error("身份证号码已被使用");
                }else{
                    $id=M('realname_apply')->add(array(
                        'uid'=>$uid,
                        'realname'=>$realname,
                        'idcard'=>$idcard,
                        'idcard_front'=>$idcard_front,
                        'idcard_back'=>$idcard_back,
                        'alipayaccount'=>$alipayaccount,
                        'inputtime'=>time()
                    ));
                    if($id){
                        M("message")->add(array(
                          'r_id'=>$uid,
                          'title'=>"申请实名认证",
                          'content'=>"申请认证成功，等待审核！",
                          'varname'=>"applyrealname",
                          'value'=>$uid,
                          'inputtime'=>time()
                        ));
                        $this->success("申请认证成功，等待审核！",U('Home/Member/index'));
                    }else{
                        M("message")->add(array(
                          'r_id'=>$uid,
                          'title'=>"申请实名认证",
                          'content'=>"申请认证失败！",
                          'varname'=>"applyrealname",
                          'value'=>$uid,
                          'inputtime'=>time()
                        ));
                        $this->success("申请认证失败！",U('Home/Member/index'));
                    }
                }
            }else{
                $uid=session("uid");
                $data=M('realname_apply')->where(array('uid'=>$uid))->find();
                $this->assign("data",$data);
                $this->display();
            }
        }
    }
    
    /**
     * 会员房东认证
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function houseowner() {
        if (!session('uid')) {
            $url=__SELF__;cookie("returnurl",urlencode($url));$this->redirect('Home/Member/login');
        } else {
            if(IS_POST){
                $uid=session("uid");
                $realname=trim($_POST['realname']);
                $alipayaccount=trim($_POST['alipayaccount']);
                $housename=trim($_POST['housename']);
                $address=trim($_POST['address']);
                $thumb=trim($_POST['thumb']);

                $where['id']=$uid;
                $result=M('Member')->where($where)->find();

                if($uid==''||$realname==''||$alipayaccount==''||$housename==''||$address==''){
                    $this->error("请求参数错误");
                }elseif(empty($result)){
                    $this->error("用户不存在");
                }elseif($result['realname_status']==0){
                    $this->error("请先进行实名认证");
                }elseif($result['houseowner_status']==1){
                    $this->error("用户已经职场认证");
                }else{
                    $id=M('houseowner_apply')->add(array(
                        'uid'=>$uid,
                        'housename'=>$housename,
                        'alipayaccount'=>$alipayaccount,
                        'realname'=>$realname,
                        'address'=>$address,
                        'thumb'=>$thumb,
                        'inputtime'=>time()
                    ));
                    if($id){
                        M("message")->add(array(
                          'r_id'=>$uid,
                          'title'=>"申请房东认证",
                          'content'=>"申请认证成功，等待审核！",
                          'varname'=>"applyhouseowner",
                          'value'=>$uid,
                          'inputtime'=>time()
                        ));
                        $this->success("申请认证成功，等待审核！",U('Home/Member/index'));
                    }else{
                        M("message")->add(array(
                          'r_id'=>$uid,
                          'title'=>"申请房东认证",
                          'content'=>"申请认证失败！",
                          'varname'=>"applyhouseowner",
                          'value'=>$uid,
                          'inputtime'=>time()
                        ));
                        $this->success("申请认证失败！",U('Home/Member/index'));
                    }
                }
            }else{
                $uid=session("uid");
                $realname_status=M('member')->where(array('id'=>$uid))->getField("realname_status");
                $apply=M('realname_apply')->where(array('uid'=>$uid))->find();
                if($apply['status']==1){
                  $realname_status=-1;
                }
                switch ($realname_status) {
                  case '-1':
                    # code...
                    $this->error("请等待实名认证审核");
                    break;
                  case '0':
                    # code...
                    $this->error("请先进行实名认证",U('Home/Member/realname'));
                    break;
                  case '1':
                    # code...
                    $data=M('houseowner_apply')->where(array('uid'=>$uid))->find();
                    $data['realname']=M('member')->where(array('id'=>$uid))->getField("realname");
                    $data['alipayaccount']=M('alipayaccount')->where(array('uid'=>$uid))->getField("alipayaccount");
                    $this->assign("data",$data);
                    $this->display();
                    break;
                }
                
            }
        }
    }
    /**
     * 使用协议
     * @return void
     * @author yiyouguisu<741459065@qq.com> time|20151219
     */
    public function pact(){
        $data=M("config")->where(array('groupid'=>6,'varname'=>'use_service'))->getField("value");
        $this->assign('data',$data);
        $this->display();
    }
    public function ajax_attention(){
      $ret=$_POST;
      $uid = session("uid");
      $tuid=intval(trim($ret['tuid']));

      $fuser=M('Member')->where(array('id'=>$uid))->find();
      $tuser=M('Member')->where(array('id'=>$tuid))->find();
      $attentionstatus=M('attention')->where(array('fuid'=>$uid,'tuid'=>$tuid))->find();
      if($tuid==''||$uid==''){
        exit(json_encode(array('code'=>-200,'msg'=>"请求参数错误")));
      }elseif(empty($fuser)){
        exit(json_encode(array('code'=>-200,'msg'=>"用户不存在")));
      }elseif(empty($tuser)){
        exit(json_encode(array('code'=>-200,'msg'=>"好友不存在")));
      }elseif($uid==$tuid){
        exit(json_encode(array('code'=>-200,'msg'=>"用户与好友为同一人")));
      }else{
        if(!empty($attentionstatus)){
          $id=M('attention')->where(array(
            'fuid'=>$fuser['id'],
            'tuid'=>$tuser['id']
          ))->delete();
          if($id){
            $fansnum=M('attention')->where(array('tuid'=>$tuid))->count();
            exit(json_encode(array('code'=>200,'msg'=>"取消关注成功",'fansnum'=>$fansnum)));
          }else{
            exit(json_encode(array('code'=>-202,'msg'=>"取消关注失败")));
          }
        }else{
          $id=M('attention')->add(array(
            'fuid'=>$fuser['id'],
            'tuid'=>$tuser['id'],
            'inputtime'=>time()
          ));
          if($id){
            $fansnum=M('attention')->where(array('tuid'=>$tuid))->count();
            exit(json_encode(array('code'=>200,'msg'=>"关注成功",'fansnum'=>$fansnum)));
          }else{
            exit(json_encode(array('code'=>-202,'msg'=>"关注失败")));
          }
        }
        
        
      }
    }
    public function note(){
      $uid=I('uid');
      if(empty($uid)){
          $uid=session("uid");
      }
      $data=M('Member')->where('id=' . $uid)->find();
      $data['attentionnum'] = D("attention")->where('fuid=' . $data['id'])->count();
      $data['fansnum'] = D("attention")->where('tuid=' . $data['id'])->count();
      $data['viewlist']=D("view a")->join("left join zz_member b on a.fuid=b.id")->where('a.tuid=' . $data['id'])->group('fuid')->field("a.fuid as uid,b.nickname,b.head")->limit(6)->select();
      $data['characteristic']=M('linkage')->where(array('catid'=>1,'value'=>array('in',$data['characteristic'])))->select();
      $data['hobby']=M('linkage')->where(array('catid'=>2,'value'=>array('in',$data['hobby'])))->select();

      $fuid=session("uid");
      $attention=M('attention')->where(array('fuid'=>$fuid,'tuid'=>$uid))->find();
      $data['isattention'] = !empty($attention)?1:0;
      $this->assign('data',$data);

      $where=array();
      $order=array('a.id'=>'desc');
      $where['a.uid']=$uid;
      $where['a.isdel']=0;
      $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
      $count=M("Note a")
          ->join("left join zz_member b on a.uid=b.id")
          ->join("left join {$sqlI} c on a.id=c.value")
          ->where($where)->count();
      $page = new \Think\Page($count,10);
      $list=M("Note a")
          ->join("left join zz_member b on a.uid=b.id")
          ->join("left join {$sqlI} c on a.id=c.value")
          ->where($where)
          ->order($order)
          ->field('a.id,a.title,a.thumb,a.description,a.content,a.area,a.address,a.lat,a.lng,a.hit,a.begintime,a.status,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
          ->limit($page->firstRow . ',' . $page->listRows)
          ->select();
      foreach ($list as $key => $value)
      { 
          if(empty($value['reviewnum'])) $list[$key]['reviewnum']=0;
          $list[$key]['description'] = $this->str_cut(trim(strip_tags($value['content'])), 250);
          $collectnum=M('collect')->where(array('varname'=>'note','value'=>$value['nid']))->count();
          $list[$key]['collectnum']=!empty($collectnum)?$collectnum:0;
      }
      $page->setConfig('prev','上一页');
      $page->setConfig('next','下一页');
      $show = $page->show();
      $this->assign("note", $list);
      $this->assign("Page", $show);
      if($_GET['isAjax']==1){
          $jsondata['status']=1;
          $jsondata['html']  = $this->fetch("morelist_note");
          $this->ajaxReturn($jsondata,'json');
      }else{
          $this->display();
      }
    }
    public function party(){
      $uid=I('uid');
      if(empty($uid)){
          $uid=session("uid");
      }
      $data=M('Member')->where('id=' . $uid)->find();
      $data['attentionnum'] = D("attention")->where('fuid=' . $data['id'])->count();
      $data['fansnum'] = D("attention")->where('tuid=' . $data['id'])->count();
      $data['viewlist']=D("view a")->join("left join zz_member b on a.fuid=b.id")->where('a.tuid=' . $data['id'])->group('fuid')->field("a.fuid as uid,b.nickname,b.head")->limit(6)->select();
      $data['characteristic']=M('linkage')->where(array('catid'=>1,'value'=>array('in',$data['characteristic'])))->select();
      $data['hobby']=M('linkage')->where(array('catid'=>2,'value'=>array('in',$data['hobby'])))->select();

      $fuid=session("uid");
      $attention=M('attention')->where(array('fuid'=>$fuid,'tuid'=>$uid))->find();
      $data['isattention'] = !empty($attention)?1:0;
      $this->assign('data',$data);

      $count=M('activity a')
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.uid'=>$uid,'a.isdel'=>0))
          ->where($where)
          ->count();
      $page = new \Think\Page($count,10);
      $list=M("activity a")
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.uid'=>$uid,'a.isdel'=>0))
          ->where($where)
          ->order(array('a.id'=>'desc'))
          ->field("a.id,a.title,a.thumb,a.money,a.address,a.status,a.uid,a.starttime,a.endtime,a.inputtime,'party' as varname")
          ->limit($page->firstRow . ',' . $page->listRows)
          ->select();
      $page->setConfig('prev','上一页');
      $page->setConfig('next','下一页');
      $show = $page->show();
      $this->assign("party", $list);
      $this->assign("Page", $show);
      if($_GET['isAjax']==1){
          $jsondata['status']=1;
          $jsondata['html']  = $this->fetch("morelist_party");
          $this->ajaxReturn($jsondata,'json');
      }else{
          $this->display();
      }
    }
    public function hostel(){
      $uid=I('uid');
      if(empty($uid)){
          $uid=session("uid");
      }
      $data=M('Member')->where('id=' . $uid)->find();
      $data['attentionnum'] = D("attention")->where('fuid=' . $data['id'])->count();
      $data['fansnum'] = D("attention")->where('tuid=' . $data['id'])->count();
      $data['viewlist']=D("view a")->join("left join zz_member b on a.fuid=b.id")->where('a.tuid=' . $data['id'])->group('fuid')->field("a.fuid as uid,b.nickname,b.head")->limit(6)->select();
      $data['characteristic']=M('linkage')->where(array('catid'=>1,'value'=>array('in',$data['characteristic'])))->select();
      $data['hobby']=M('linkage')->where(array('catid'=>2,'value'=>array('in',$data['hobby'])))->select();

      $fuid=session("uid");
      $attention=M('attention')->where(array('fuid'=>$fuid,'tuid'=>$uid))->find();
      $data['isattention'] = !empty($attention)?1:0;
      $this->assign('data',$data);

      $count=M('Hostel a')
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.uid'=>$uid,'a.isdel'=>0))
          ->where($where)
          ->count();
      $page = new \Think\Page($count,10);
      $list=M("Hostel a")
          ->join("left join zz_member b on a.uid=b.id")
          ->where(array('a.uid'=>$uid,'a.isdel'=>0))
          ->where($where)
          ->order(array('a.id'=>'desc'))
          ->field("a.id,a.title,a.acreage,a.bedtype,a.thumb,a.money,a.status,a.uid,a.inputtime,'hostel' as varname")
          ->limit($page->firstRow . ',' . $page->listRows)
          ->select();
      foreach ($list as $key => $value)
      {
          $list[$key]['bedtype']=trim($value['bedtype'],",");
      }
      $page->setConfig('prev','上一页');
      $page->setConfig('next','下一页');
      $show = $page->show();
      $this->assign("hostel", $list);
      $this->assign("Page", $show);
      if($_GET['isAjax']==1){
          $jsondata['status']=1;
          $jsondata['html']  = $this->fetch("morelist_hostel");
          $this->ajaxReturn($jsondata,'json');
      }else{
          $this->display();
      }
    }
    public function review(){
      $uid=I('uid');
      if(empty($uid)){
          $uid=session("uid");
      }
      $data=M('Member')->where('id=' . $uid)->find();
      $data['attentionnum'] = D("attention")->where('fuid=' . $data['id'])->count();
      $data['fansnum'] = D("attention")->where('tuid=' . $data['id'])->count();
      $data['viewlist']=D("view a")->join("left join zz_member b on a.fuid=b.id")->where('a.tuid=' . $data['id'])->group('fuid')->field("a.fuid as uid,b.nickname,b.head")->limit(6)->select();
      $data['characteristic']=M('linkage')->where(array('catid'=>1,'value'=>array('in',$data['characteristic'])))->select();
      $data['hobby']=M('linkage')->where(array('catid'=>2,'value'=>array('in',$data['hobby'])))->select();

      $fuid=session("uid");
      $attention=M('attention')->where(array('fuid'=>$fuid,'tuid'=>$uid))->find();
      $data['isattention'] = !empty($attention)?1:0;
      $this->assign('data',$data);
      
      $type=I('varname');
      if(empty($type)){
        $type="all";
      }
      
      switch ($type) {
        case "all":
            $count=M('review a')
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                ->count();
            $page = new \Think\Page($count,10);
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0))
                ->order(array('a.id'=>'desc'))
                ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
            foreach ($list as $key => $value)
            {
                if($value['varname']=='note'){
                    $list[$key]['title']=M('note')->where(array('id'=>$value['value']))->getField("title");
                }else if($value['varname']=='party'){
                    $list[$key]['title']=M('activity')->where(array('id'=>$value['value']))->getField("title");
                }else if($value['varname']=='hostel'){
                    $list[$key]['title']=M('hostel')->where(array('id'=>$value['value']))->getField("title");
                }else if($value['varname']=='room'){
                    $list[$key]['title']=M('room')->where(array('id'=>$value['value']))->getField("title");
                }else if($value['varname']=='trip'){
                    $list[$key]['title']=M('trip')->where(array('id'=>$value['value']))->getField("title");
                }
            }
            $sql=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->_sql();
            break;
        case "note":
            $count=M('review a')
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'note'))
                ->count();
            $page = new \Think\Page($count,10);
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'note'))
                ->order(array('a.id'=>'desc'))
                ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
            foreach ($list as $key => $value)
            {
                $list[$key]['title']=M('note')->where(array('id'=>$value['value']))->getField("title");
            }
            break;
        case "hostel":
            $count=M('review a')
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'hostel'))
                ->count();
            $page = new \Think\Page($count,10);
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'hostel'))
                ->order(array('a.id'=>'desc'))
                ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
            foreach ($list as $key => $value)
            {
                $list[$key]['title']=M('hostel')->where(array('id'=>$value['value']))->getField("title");
            }
            break;
        case "party":
            $count=M('review a')
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'party'))
                ->count();
            $page = new \Think\Page($count,10);
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'party'))
                ->order(array('a.id'=>'desc'))
                ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
            foreach ($list as $key => $value)
            {
                $list[$key]['title']=M('activity')->where(array('id'=>$value['value']))->getField("title");
            }
            break;
        case "trip":
            $count=M('review a')
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'trip'))
                ->count();
            $page = new \Think\Page($count,10);
            $list=M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where(array('a.uid'=>$uid,'a.isdel'=>0,'a.varname'=>'trip'))
                ->order(array('a.id'=>'desc'))
                ->field('a.id as rid,a.value,a.varname,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
            foreach ($list as $key => $value)
            {
                $list[$key]['title']=M('trip')->where(array('id'=>$value['value']))->getField("title");
            }
            break;
      }
      $page->setConfig('prev','上一页');
      $page->setConfig('next','下一页');
      $show = $page->show();
      $this->assign("review", $list);
      $this->assign("Page", $show);
      if($_GET['isAjax']==1){
          $jsondata['status']=1;
          $jsondata['html']  = $this->fetch("morelist_review");
          $this->ajaxReturn($jsondata,'json');
      }else{
          $this->display();
      }
    }
    public function ajax_deletereview(){
        if(IS_POST){
            $where=array();
            $rid=$_POST['rid'];
            $uid=session("uid");
            $review=M('review')->where(array('id'=>$rid))->find();
            if($rid==''||$uid==''){
                $this->ajaxReturn(array('status'=>0,'msg'=>'评论ID不能为空'),'json');
            }elseif(empty($review)){
                $this->ajaxReturn(array('status'=>0,'msg'=>"评论不存在"),'json');
            }else{
                $where=array();
                $where['id']=array('eq',$rid);
                $id=M("review")->where($where)->save(array('isdel'=>1,'deletetime'=>time()));
                if($id){
                    $this->ajaxReturn(array('status'=>1,'msg'=>'删除成功'),'json');
                }else{
                    $this->ajaxReturn(array('status'=>0,'msg'=>'删除失败'),'json');
                }
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>'请求非法'),'json');
        }
    }
}
