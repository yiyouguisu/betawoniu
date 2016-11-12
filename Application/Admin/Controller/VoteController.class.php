<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class VoteController extends CommonController {

    public function index() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["inputtime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            //栏目
            $catid = I('get.catid', null, 'intval');
            if (!empty($catid)) {
                $where["catid"] = array("EQ", $catid);
            }
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('title', 'description', 'username');
                if ($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 3) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
            //状态
            $status = $_GET["status"];
            if ($status != "" && $status != null) {
                $where["status"] = array("EQ", $status);
            }
        }

        $count = D("Voteparty")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("Voteparty")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortitle"] = $this->str_cut($r["title"], 30);
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    /**
     * 编辑活动
     */
    public function edit() {
        if ($_POST) {
            if (D("Voteparty")->create()) {
                D("Voteparty")->starttime=strtotime($_POST['starttime']);
                D("Voteparty")->endtime=strtotime($_POST['endtime']);
                D("Voteparty")->in_starttime=strtotime($_POST['in_starttime']);
                D("Voteparty")->in_endtime=strtotime($_POST['in_endtime']);
                D("Voteparty")->updatetime = time();
                $id = D("Voteparty")->save();
                if (!empty($id)) {
                    M('gift_voteparty')->where(array('vaid'=>$_POST['id']))->delete();
                    foreach ($_POST['gift'] as $value)
                    {
                    	M('gift_voteparty')->add(array(
                            'vaid'=>$_POST['id'],
                            'rank'=>$value['rank'],
                            'v'=>$value['v'],
                            'inputtime'=>time()
                            ));
                    }
                    $this->success("修改活动成功！", U("Admin/Vote/index"));
                } else {
                    $this->error("修改活动失败！");
                }
            } else {
                $this->error(D("Voteparty")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("活动ID参数错误");
            }
            $data=D("Voteparty")->where("id=".$id)->find();
            $data['starttime']=date("Y-m-d",$data['starttime']);
            $data['endtime']=date("Y-m-d",$data['endtime']);
            $data['in_starttime']=date("Y-m-d",$data['in_starttime']);
            $data['in_endtime']=date("Y-m-d",$data['in_endtime']);
            $this->assign("data", $data);
            $gift_voteparty=M('gift_voteparty')->where(array('vaid'=>$id))->select();
            foreach ($gift_voteparty as $value)
            {
            	$v[$value['rank']]=$value['v'];
            }
            $this->assign("v", $v);

            $shop=M('house')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->select();
            $this->assign("shop",$shop);
            $gift=M('gift')->order(array('id'=>'desc'))->where(array('id'=>array('in','1,2,3')))->select();
            $this->assign("gift",$gift);
            $this->display();
        }

    }

    /*
     * 添加活动
     */

    public function add() {
        if ($_POST) {

            if (D("Voteparty")->create()) {
                D("Voteparty")->starttime=strtotime($_POST['starttime']);
                D("Voteparty")->endtime=strtotime($_POST['endtime']);
                D("Voteparty")->in_starttime=strtotime($_POST['in_starttime']);
                D("Voteparty")->in_endtime=strtotime($_POST['in_endtime']);
                D("Voteparty")->inputtime = time();
                D("Voteparty")->username = $_SESSION['user'];
                $id = D("Voteparty")->add();
                if($id){
                    M('gift_voteparty')->where(array('vaid'=>$id))->delete();
                    foreach ($_POST['gift'] as $value)
                    {
                    	M('gift_voteparty')->add(array(
                            'vaid'=>$id,
                            'rank'=>$value['rank'],
                            'v'=>$value['v'],
                            'inputtime'=>time()
                            ));
                    }
                    $this->success("新增活动成功！", U("Admin/Vote/index"));
                } else {
                    $this->error("新增活动失败！");
                }
            } else {
                $this->error(D("Voteparty")->getError());
            }
        } else {
            $shop=M('house')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->select();
            $this->assign("shop",$shop);
            $gift=M('gift')->order(array('id'=>'desc'))->where(array('id'=>array('in','1,2,3')))->select();
            $this->assign("gift",$gift);
            $this->display();
        }
    }

    /*
     * 操作判断
     */

    public function action() {
        $submit = trim($_POST["submit"]);
        if ($submit == "listorder") {
            $this->listorder();
        } elseif ($submit == "del") {
            $this->del();
        } elseif ($submit == "review") {
            $this->review();
        } elseif ($submit == "unreview") {
            $this->unreview();
        } elseif ($submit == "pushs") {
            $this->pushs();
        } elseif ($submit == "unpushs") {
            $this->unpushs();
        }
    }

    /**
     *  删除
     */
    public function delete() {
        $id = $_GET['id'];
        if (D("Voteparty")->delete($id)) {
            $this->success("删除活动成功！");
        } else {
            $this->error("删除活动失败！");
        }
    }

    /*
     * 删除活动
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                D("Voteparty")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /*
     * 活动审核
     */

    public function review() {
        $data['status'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                D("Voteparty")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 活动取消审核
     */

    public function unreview() {
        $data['status'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                D("Voteparty")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 活动推荐
     */

    public function pushs() {
        $data['type'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                D("Voteparty")->where(array("id" => $id))->save($data);
            }
            $this->success("推荐成功！");
        } else {
            $this->error("推荐成功！");
        }
    }

    /*
     * 活动推荐
     */

    public function unpushs() {
        $data['type'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                D("Voteparty")->where(array("id" => $id))->save($data);
            }
            $this->success("取消推荐成功！");
        } else {
            $this->error("取消推荐失败！");
        }
    }

    /*
     * 活动排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Voteparty")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Voteparty")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    public function ajax_getproduct(){
        $data=M('product')->where(array('storeid'=>$_POST['storeid']))->order(array('listorder'=>'desc','id'=>'desc'))->select();
        echo json_encode($data);
    }
    // public function revote(){
    //     $vaid=I('id');
    //     $voteparty=M('voteparty')->where(array('id'=>$vaid))->find();
    //     if(!$voteparty['ischoujiang']==1){
    //         $this->error("该期活动还未抽奖");
    //     }
    
    //         M('voteparty')->where(array('id'=>$vaid))->setField("ischoujiang",0);
    //         M('voteparty')->where(array('id'=>$vaid))->setField("hassms",0);
    //         M('coupons_order')->where(array('vaid'=>$vaid))->delete();
    //         $data['status'] = 0;
    //         M('pool')->where(array('vaid'=>$vaid))->save($data);
    //         $this->success("设置成功！");
        
    // }
    public function postsms(){
        $vaid=I('vaid');
        $coid=I('coid');
        if($coid == 'statics' || $vaid == 'statics')
            exit();
        if($vaid != ''){
            $voteparty=M('voteparty')->where(array('id'=>$vaid))->find();
            if($voteparty['ischoujiang']==0){
                $this->error("该期活动还未抽奖");
            }else{
                $contentTL = M("config")->where(array("varname"=>"sms_votecontent"))->getField("value");
                
                $contenList = M('coupons_order A')
                    ->join("left join member B on A.uid = B.id")
                    ->join("left join coupons C on A.catid = C.id")
                    ->join("left join house D on D.id = A.hid")
                    ->field("D.theme as theme,B.phone as phone,C.title as title")
                    ->where(array('A.vaid'=>$vaid,'A.hassms'=>0))
                    ->select();
                $successSum = 0;
                $failSum = 0;
                $sms = A('Api/Ymsms');
                foreach ($contenList as $key => $value) {
                    # code...      
                    $data['hassms'] = 1;
                    $content = str_replace("{#house#}", $value["theme"] , $contentTL); 
                    $content = str_replace("{#house#}", $value["title"] , $content);         
                    $ret = '{"phone":"18221265103","content":$content}';
                    if($sms->sendbsmsapi($ret) == 0){ 
                        M('coupons_order')->where(array('id'=>$coid))->save($data);
                        $successSum ++;
                    }else{
                        $failSum ++;
                    }
                }
                $total = $successSum + $failSum;
                $this->success("总共{$total}条，成功发送{$successSum}条，失败{$failSum}条！");
            }
            // $this->success("群发成功！");
        }else if($coid != ''){
            $contentTL = M("config")->where(array("varname"=>"sms_votecontent"))->getField("value");
            $coupons_order = M('coupons_order')->where(array('id'=>$coid))->find();
            $house = M('house')->where(array('id'=>$coupons_order['hid']))->find();
            // $member = M('member')->where(array('id'=>$coupons_order['uid']))->find();
            $coupons = M('coupons')->where(array('id'=>$coupons_order['catid']))->find();

            $content = str_replace("{#house#}", $house["theme"], $contentTL);
            $content = str_replace("{#level#}", $coupons["title"], $content);       
            $sms = A('Api/Ymsms');
            $ret = json_encode(array('phone' => '13816450228', 'content' => $content));
            $res = $sms->sendbsmsapi($ret);
            \Think\Log::write("res:{$res}",'WARN');
            if($res == "0"){
                // $data['hassms'] = 1;
                // M('coupons_order')->where(array('id'=>$coid))->save($data);
                $this->success("短信发送成功！");
            }else
                $this->error("短信发送失败！");
        }else{
            $this->error("请求错误！");
        }
    }

    public function choujiang(){
        $vaid=I('id');
        $voteparty=M('voteparty')->where(array('id'=>$vaid))->find();
        if($voteparty['ischoujiang']==1){
            $this->error("该期活动已经抽奖");
        }
        if(IS_POST){
            $basecode=I('basecode');
            if(empty($basecode)){
                $this->error("请填写福彩3D中奖码");
            }
            $basenum=I('basenum');
            if(empty($basenum)){
                $this->error("请填写基数");
            }
            M('voteparty')->where(array('id'=>$vaid))->save(array(
                "basecode"=>$basecode,
                "basenum"=>$basenum
                ));
            //$minvotenum=$voteparty['minvotenum'];
            //$minvotenum=!empty($minvotenum)?$minvotenum:0;

            $voterewardnum=$voteparty['voterewardnum'];
            $voterewardnum=!empty($voterewardnum)?$voterewardnum:1;

            $basenum=!empty($basenum)?$basenum:1;

            $totalnum=M('pool')->where(array('vaid'=>$vaid,'status'=>0))->count();
            if(!$totalnum){
                $this->error("该活动没有任何人参与抽奖！");
            }
            $poolMember = M('pool')->field('uid')->where(array('vaid'=>$vaid,'status'=>0))->group("uid")->select();
            // exit();
             // \Think\Log::write("ischoujiang:{$data['link']}",'WARN');
            if(count($poolMember) < $voterewardnum)
                $this->error("抽奖码总数应该不大于抽奖人数！");
            $poolCode = M('pool')->field('uid,code')->where(array('vaid'=>$vaid,'status'=>0))->select();
            $strPool = "";
            foreach ($poolCode as $key => $value) {
                # code...
                $value['code'] = (int)$value['code'];
                if($strPool != "")
                    $strPool = "{$strPool},{$value['uid']}";
                else
                    $strPool = "{$value['uid']}";
            }
            
            $i = 1;
            $code=array();
            for ( $i = 1,$j=1; $i <= $voterewardnum;$j++) {
                $luckyCode = (int)$basecode+(round($totalnum/$basenum)*$j);
                if($luckyCode > $totalnum)
                    $this->error("当前规则抽不齐指定的中奖码个数");
                $luckyUser = "";
                foreach ($poolCode as $key => $value) {
                    # code...
                    if($value['code'] == $luckyCode)
                        $luckyUser = $value['uid'];
                }
                \Think\Log::write("{$i},luckyCode:{$luckyCode},strPool:{$strPool}",'WARN');
                if($luckyUser!=''){
                if(strstr($strPool, "{$luckyUser},")){
                    $code[]=$luckyCode;
                    (int)$i = (int)$i + 1;
                    $strPool = str_replace("{$luckyUser},", "", $strPool);
                }
                }
            }
            $sqlI=M('pool')->where(array('vaid'=>$vaid,'status'=>0))->group("uid")->field("uid,count(code) as codetotalnum")->buildSql();
            $voteresult=M('pool a')
                ->join("left join {$sqlI} as b on a.uid=b.uid")
                ->where(array('a.vaid'=>$vaid,'a.status'=>0,'a.code'=>array('in',$code)))
                ->order(array('b.codetotalnum'=>'desc','a.id'=>'asc'))
                ->group("a.uid")
                ->select();
            if(empty($voteresult)){
               $this->error("没有符合条件的数据"); 
            }
            $arr=array();
            $gift_voteparty=M('gift_voteparty')->where(array('vaid'=>$vaid,'v'=>array('gt',0)))->field('rank,v')->order(array('rank'=>"asc"))->select();
            foreach ($gift_voteparty as $key => $val) {
                $arr[$val['rank']] = $val['v'];
            }
            $j=0;
            $data=array();
            foreach ($arr as $key => $value)
            {   
                $value=$value+$j;
            	for ($i = $j; $i < $value; $i++) {
                    $data[$i]['uid'] = $voteresult[$i]['uid'];
                    $data[$i]['hid']=$voteresult[$i]['hid'];
                    $data[$i]['code']=$voteresult[$i]['code'];
                    $data[$i]['catid']=$key; 
                }
                $j=$i;
            }
            foreach ($data as $key => $value) {
                if(empty($value['uid'])){
                    unset($data[$key]);
                    continue;
                }else{
                    $data[$key]['vaid']=$vaid;
                    $data[$key]['num']=1;
                    $data[$key]['inputtime']=time();
                    $data[$key]['updatetime']=time();
                }
                
            }
            $id=M('coupons_order')->addAll($data);
            
            if($id){
                foreach ($voteresult as $value)
                {
                   M('pool')->where(array('id'=>$value['id']))->setField("status",1);
                }
                M('voteparty')->where(array('id'=>$vaid))->setField("ischoujiang",1);
                $this->success("抽奖结果已经生成",U('Admin/Vote/voteresult',array('id'=>$vaid)));
            }else{
                $this->error("抽奖失败");
            }
        }else{
            $this->assign("data",$voteparty);
            $this->display();
        }
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
    public function voteresult(){
        $vaid=I('id');
        $voteparty=M('voteparty')->where(array('id'=>$vaid))->find();
        if($voteparty['ischoujiang']==0){
            $this->error("该期活动尚未抽奖");
        }
        $sqlI=M('pool')->where(array('vaid'=>$vaid))->group("uid")->field("uid,count(*) as num")->buildSql();
        $data=M('coupons_order a')
            ->join("left join zz_coupons b on a.catid=b.id")
            ->join("left join {$sqlI} c on c.uid=a.uid")
            ->where(array('a.vaid'=>$vaid))
            ->field("a.*,c.num,b.title,a.code,b.validity_starttime,b.validity_endtime")
            ->order(array('c.num'=>'desc','a.catid'=>'asc','a.id'=>'desc'))
            ->select();
        foreach ($data as $key => $value) {
            # code...
            $data[$key]['username']=M('member')->where(array('id'=>$value['uid']))->getField("nickname");
            $data[$key]['phone']=M('member')->where(array('id'=>$value['uid']))->getField("phone");
            //$data[$key]['num']=M('pool')->where(array('uid'=>$value['uid'],'vaid'=>$vaid))->count();
        }
        $this->assign("data",$data);
        $this->display();
    }
}