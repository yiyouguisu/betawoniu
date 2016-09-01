<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class MemberController extends CommonController {
    /**
     * 用户选择
     * @author oydm<389602549@qq.com>  time|20140507
     */
    public function select() {
        $search = I('post.search');
        $where = array();
        $type=I('type');
        if(!empty($type)){
            // if($type==1) $where['houseowner_status']=1;
            if($type==2) $where['houseowner_status']=1;
        }else{
            $where['subscribestatus']=1;
        }
        
        if (!empty($search)) {
            //性别
            $sex= I('post.sex', null, 'intval');
            if (!empty($sex)) {
                $where["sex"] = array("EQ", $sex);
            }
            //搜索字段
            $searchtype = I('post.searchtype', null, 'intval');
            //搜索关键字
            $keyword = I('post.keyword');
            if (!empty($keyword)) {
                $type_array = array('nickname','realname','email','phone');
                if ($searchtype < 4) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 4) {
                    $where["id"] = array("EQ", (int)$keyword);
                }
            }

        }
        $count = M("member")->where($where)->count();
        $page = new \Think\Page($count,8);
        $data = M("member")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    /**
     * 会员列表
     * @author oydm<389602549@qq.com>  time|20140507
     */
    public function index() {
        $search = I('post.search');
        $where = array();
        $where['group_id']=1;
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('post.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["reg_time"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('post.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["reg_time"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['reg_time'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            //性别
            $sex= I('post.sex', null, 'intval');
            if (!empty($sex)) {
                $where["sex"] = array("EQ", $sex);
            }

            $level= I('post.level', null, 'intval');
            if (!empty($level)) {

                $uids=getuid_level($level);

                $where["id"] = array("in", $uids);

            }

            //搜索字段
            $searchtype = I('post.searchtype', null, 'intval');
            //搜索关键字
            $keyword = I('post.keyword');
            if (!empty($keyword)) {
                $type_array = array('nickname','realname','email','phone');
                if ($searchtype < 4) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 4) {
                    $where["id"] = array("EQ", (int)$keyword);
                }
            }
        }
        $count = M("member")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = M("member")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $key => $value) {
            # code...
            $data[$key]['reviewnum']=M('review')->where(array('uid'=>$value['id']))->count();
            $data[$key]['orderwnum']=M('order')->where(array('uid'=>$value['id']))->count();
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->assign("sex", $sex);
        $this->assign("searchtype", $searchtype);

        $levelConfig = F("levelConfig",'',CACHEDATA_PATH);
        $this->assign("levelConfig", $levelConfig);

        $this->display();
    }
    
    /**
     *  添加
     * @author oydm<389602549@qq.com>  time|20140507
     */
    public function add() {
        if (IS_POST) {
            $data=$_POST;
            $data['characteristic']=implode(",", $_POST['characteristic']);
            $data['hobby']=implode(",", $_POST['hobby']);
            if (D("member")->addUser($data)) {
                $this->success("添加会员成功！", U("Admin/Member/index"));
            } else {
                $this->error(D("member")->getError());
            }
        } else {
            $this->display();
        }
    }

    /**
     *  删除
     * @author oydm<389602549@qq.com>  time|20140507
     */
    public function del() {
        $id = I('get.id');
        if (empty($id)) {
            $this->error("没有指定删除对象！");
        }
        //执行删除
        if (D("member")->delUser($id)) {
            $this->success("删除成功！");
        } else {
            $this->error(D("member")->getError());
        }
    }

    /**
     *  编辑
     * @author oydm<389602549@qq.com>  time|20140507
     */
    public function edit() {
        if (IS_POST) {
            $data=$_POST;
            $data['characteristic']=implode(",", $_POST['characteristic']);
            $data['hobby']=implode(",", $_POST['hobby']);
            if (false !== D("member")->editUser($data)) {
                $this->success("更新成功！", U("Admin/Member/index"));
            } else {
                $this->error(D("member")->getError());
            }
        } else {
            $data = D("member")->where(array("id" => $_GET["id"]))->find();
            $info = D("member_info")->where(array("uid" => $data["id"]))->find();
            $this->assign("data", $data);
            $this->assign("info", $info);
            $this->display();
        }
    }
    public function details(){
        $uid=I('id');
        $data=M('member a')
            ->join("left join zz_integral b on a.id=b.uid")
            ->join("left join zz_account c on a.id=c.uid")
            ->where('a.id=' . $uid)
            ->field("a.*,b.useintegral,c.usemoney")
            ->find();
        // $data['companynumber']=M('company')->where(array('id'=>$data['companyid']))->getField("companynumber");
        // $preference=explode(",",$data['preference']);
        // foreach ($preference as $key => $value)
        // {
        // 	$preference[$key]=M('linkage')->where(array('catid'=>1,'value'=>$value))->find();
        // }

        // $data['preference']=$preference;
        $this->assign("data",$data);

        $type=I('type');
        $this->assign("type",$type);
        if(!empty($type)){
            unset($_GET['type']);
            if($type==1){
                $where=array('a.uid'=>$uid,'c.cancel_status'=>0,'c.close_status'=>0);
                $count1 = M("order a")->join("left join zz_store b on a.storeid=b.id")->join("left join zz_order_time c on a.orderid=c.orderid")->where($where)->count();
                $page1 = new \Think\Page($count1, 6);
                $order = M("order a")
                    ->join("left join zz_store b on a.storeid=b.id")
                    ->join("left join zz_order_time c on a.orderid=c.orderid")
                    ->where($where)
                    ->limit($page1->firstRow . ',' . $page1->listRows)
                    ->order(array("a.id" => "desc"))
                    ->field("a.*,b.title as storename,c.inputtime,c.donetime,c.status")
                    ->cache(true)
                    ->select();
                $show1 = $page1->show();
                $this->assign("order", $order);
                $this->assign("Page1", $show1);

                unset($_GET['p']);

                $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
                $where=array('a.uid'=>$uid,'b.id'=>array('in',$catids));
                $count2 = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->count();
                $page2 = new \Think\Page($count2, 6);
                $vouchers =M('vouchers_order a')
                    ->join("left join zz_vouchers b on a.catid=b.id")
                    ->where($where)
                    ->field("a.id,a.inputtime,b.title,b.price,b.validity_endtime,a.num,a.`status`,b.`range`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))
                    ->limit($page2->firstRow . ',' . $page2->listRows)
                    ->order(array("a.status" => "asc","b.validity_endtime" => "desc","a.id" => "desc"))
                    ->select();
                foreach ($vouchers as $key => $value)
                {
                    if($value['status']==1){
                        $vouchers[$key]['usestatus']=0;
                    }else{
                        if($value['validity_endtime']<=time()){
                            $vouchers[$key]['usestatus']=0;
                        }else{
                            $vouchers[$key]['usestatus']=1;
                        }
                    }
                }
                $show2 = $page2->show();
                $this->assign("vouchers", $vouchers);
                $this->assign("Page2", $show2);
            }elseif($type==2){
                $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
                $where=array('a.uid'=>$uid,'b.id'=>array('in',$catids));
                $count2 = M('vouchers_order a')->join("left join zz_vouchers b on a.catid=b.id")->where($where)->count();
                $page2 = new \Think\Page($count2, 6);
                $vouchers =M('vouchers_order a')
                    ->join("left join zz_vouchers b on a.catid=b.id")
                    ->where($where)
                    ->field("a.id,a.inputtime,b.title,b.price,b.validity_endtime,a.num,a.`status`,b.`range`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))
                    ->limit($page2->firstRow . ',' . $page2->listRows)
                    ->order(array("a.status" => "asc","b.validity_endtime" => "desc","a.id" => "desc"))
                    ->select();
                foreach ($vouchers as $key => $value)
                {
                    if($value['status']==1){
                        $vouchers[$key]['usestatus']=0;
                    }else{
                        if($value['validity_endtime']<=time()){
                            $vouchers[$key]['usestatus']=0;
                        }else{
                            $vouchers[$key]['usestatus']=1;
                        }
                    }
                }
                $show2 = $page2->show();
                $this->assign("vouchers", $vouchers);
                $this->assign("Page2", $show2);
                unset($_GET['p']);
                $where=array('a.uid'=>$uid,'c.cancel_status'=>0,'c.close_status'=>0);
                $count1 = M("order a")->join("left join zz_store b on a.storeid=b.id")->join("left join zz_order_time c on a.orderid=c.orderid")->where($where)->count();
                $page1 = new \Think\Page($count1, 6);
                $order = M("order a")
                    ->join("left join zz_store b on a.storeid=b.id")
                    ->join("left join zz_order_time c on a.orderid=c.orderid")
                    ->where($where)
                    ->limit($page1->firstRow . ',' . $page1->listRows)
                    ->order(array("a.id" => "desc"))
                    ->field("a.*,b.title as storename,c.inputtime,c.donetime,c.status")
                    ->select();
                $show1 = $page1->show();
                $this->assign("order", $order);
                $this->assign("Page1", $show1);
            }

        }else{
            $where=array('a.uid'=>$uid,'c.cancel_status'=>0,'c.close_status'=>0);
            $count1 = M("order a")
                    ->join("left join zz_store b on a.storeid=b.id")
                    ->join("left join zz_order_time c on a.orderid=c.orderid")
                    ->where($where)
                    ->count();
            $page1 = new \Think\Page($count1, 6);
            $order = M("order a")
                ->join("left join zz_store b on a.storeid=b.id")
                ->join("left join zz_order_time c on a.orderid=c.orderid")
                ->where($where)
                ->limit($page1->firstRow . ',' . $page1->listRows)
                ->order(array("a.id" => "desc"))
                ->field("a.*,b.title as storename,c.inputtime,c.donetime,c.status")
                ->select();
            $show1 = $page1->show();
            $this->assign("order", $order);
            $this->assign("Page1", $show1);


            $catids=M('vouchers')->where(array('status'=>1))->getField("id",true);
            $where=array('a.uid'=>$uid,'b.id'=>array('in',$catids));
            $count2 = M('vouchers_order a')
                    ->join("left join zz_vouchers b on a.catid=b.id")
                    ->where($where)
                    ->count();
            $page2 = new \Think\Page($count2, 6);
            $vouchers =M('vouchers_order a')
                ->join("left join zz_vouchers b on a.catid=b.id")
                ->where($where)
                ->field("a.id,a.inputtime,b.title,b.price,b.validity_endtime,a.num,a.`status`,b.`range`")->order(array('b.validity_endtime'=>'asc','a.`status`'=>'asc','a.inputtime'=>'desc'))
                ->limit($page2->firstRow . ',' . $page2->listRows)
                ->order(array("a.status" => "asc","b.validity_endtime" => "desc","a.id" => "desc"))
                ->select();
            foreach ($vouchers as $key => $value)
            {
            	if($value['status']==1){
                    $vouchers[$key]['usestatus']=0;
                }else{
                    if($value['validity_endtime']<=time()){
                        $vouchers[$key]['usestatus']=0;
                    }else{
                        $vouchers[$key]['usestatus']=1;
                    }
                }
            }
            $show2 = $page2->show();
            $this->assign("vouchers", $vouchers);
            $this->assign("Page2", $show2);
        }

        $this->display();
    }

    public function ajax_getinfo(){
        $birthday=$_POST['birthday'];
        if(!empty($birthday)){
            $constellation=get_constellation($birthday);
            $zodiac=get_animal($birthday);
            $this->ajaxReturn(array('constellation'=>$constellation,'zodiac'=>$zodiac),'json');
        }

    }

    public function setstatus(){
        $data['id']=I('id');
        $data['status']=I('status');
        if (false !== D("member")->editUser($data)) {
            $this->success("更新成功！", U("Admin/Member/index"));
        } else {
            $this->error(D("member")->getError());
        }
    }
}