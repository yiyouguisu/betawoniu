<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class PartyController extends CommonController {

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

        $count = D("Activity")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("Activity")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
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
            $Map=A("Api/Map");
            $location=$Map->get_position_complex($_POST['area'],$_POST['address']);
            $areabox=explode(",",$_POST['area']);
            if(in_array($areabox[0],array(2,3,4,5))){
                $city=$areabox[0];
            }else{
                $city=$areabox[1];
            }
            if (D("Activity")->create()) {
                D("Activity")->lng = $location['lng'];
                D("Activity")->lat = $location['lat'];
                D("Activity")->city = $city;

                D("Activity")->starttime=strtotime($_POST['starttime']);
                D("Activity")->endtime=strtotime($_POST['endtime']);
                D("Activity")->updatetime = time();
                D("Activity")->username=M('Member')->where(array('id'=>$_POST['uid']))->getField("nickname");

                $id = D("Activity")->save();
                if (!empty($id)) {
                    $aid=$_POST['id'];
                    $title=$_POST["title"];
                    $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->where(array('a.id'=>$_POST["hid"]))->field("a.id,a.title,b.title as place")->find();
                    $tags_content=M('tags_content')->where(array('contentid'=>$aid,'varname'=>'party','type'=>'party'))->find();
                    if(empty($tags_content)){
                        M('tags_content')->add(array('contentid'=>$aid,'title'=>$title,'varname'=>'party','type'=>'party','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                    }
                    $this->success("修改活动成功！", U("Admin/Party/index"));
                } else {
                    $this->error("修改活动失败！");
                }
            } else {
                $this->error(D("Activity")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("活动ID参数错误");
            }
            $data=D("Activity")->where("id=".$id)->find();
            $data['starttime']=date("Y-m-d",$data['starttime']);
            $data['endtime']=date("Y-m-d",$data['endtime']);
            $this->assign("data", $data);
            $partycate=M("partycate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("partycate",$partycate);
            $this->display();
        }

    }

    /*
     * 添加活动
     */

    public function add() {
        if ($_POST) {
            $Map=A("Api/Map");
            $location=$Map->get_position_complex($_POST['area'],$_POST['address']);
            $areabox=explode(",",$_POST['area']);
            if(in_array($areabox[0],array(2,3,4,5))){
                $city=$areabox[0];
            }else{
                $city=$areabox[1];
            }
            if (D("Activity")->create()) {
                D("Activity")->lng = $location['lng'];
                D("Activity")->lat = $location['lat'];
                D("Activity")->city = $city;
                D("Activity")->starttime=strtotime($_POST['starttime']);
                D("Activity")->endtime=strtotime($_POST['endtime']);
                D("Activity")->inputtime = time();
                D("Activity")->username=M('Member')->where(array('id'=>$_POST['uid']))->getField("nickname");
                $id = D("Activity")->add();
                if($id){
                    $aid=$id;
                    $title=$_POST["title"];
                    $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->where(array('a.id'=>$_POST["hid"]))->field("a.id,a.title,b.title as place")->find();
                    $tags_content=M('tags_content')->where(array('contentid'=>$aid,'varname'=>'party','type'=>'party'))->find();
                    if(empty($tags_content)){
                        M('tags_content')->add(array('contentid'=>$aid,'title'=>$title,'varname'=>'party','type'=>'party','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                    }
                    $this->success("新增活动成功！", U("Admin/Party/index"));
                } else {
                    $this->error("新增活动失败！");
                }
            } else {
                $this->error(D("Activity")->getError());
            }
        } else {
            $partycate=M("partycate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("partycate",$partycate);
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
        } elseif ($submit == "pushs") {
            $this->pushs();
        } elseif ($submit == "unpushs") {
            $this->unpushs();
        } elseif ($submit == "jinpins") {
            $this->jinpins();
        } elseif ($submit == "unjinpins") {
            $this->unjinpins();
        }
    }

    /**
     *  删除
     */
    public function delete() {
        $id = $_GET['id'];
        if (D("Activity")->delete($id)) {
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
                M("Activity")->delete($id);
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
        if (IS_POST) {
            $status=I('status');
            if(empty($status)){
                $this->error("请选择审核状态");
            }
            $data=M('Activity')->where('id=' . I('id'))->find();
            if($data['status']!=1){
                $this->error("不能重复审核！");
            }
            $id=M('Activity')->where('id=' . I('id'))->save(array(
                'status'=>$status,
                'verify_time' => time(),
                'verify_user' => $_SESSION['user'],
                'remark'=>I('remark')
            ));
            if($id>0&&$status==2){
                \Api\Controller\UtilController::addmessage($data['uid'],"活动审核","您的活动(".$data['title'].")审核成功！","您的活动(".$data['title'].")审核成功！","successreviewparty",$data['id']);
                $this->success("操作成功！");
            }elseif($id>0&&$status==3){
                \Api\Controller\UtilController::addmessage($data['uid'],"活动审核","您的活动(".$data['title'].")审核失败！","您的活动(".$data['title'].")审核失败！","failreviewparty",$data['id']);
                $this->success("操作成功！");
            }elseif(!$id){
                $this->error("操作失败！");
            }
        } else {
            $id=I('id');
            $data=M('Activity')->where(array('id'=>$id))->find();
            $this->assign("data",$data);
            $this->display();
        }
    }

    
    /*
     * 活动推荐
     */

    public function pushs() {
        $data['isindex'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Activity")->where(array("id" => $id))->save($data);
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
        $data['isindex'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Activity")->where(array("id" => $id))->save($data);
            }
            $this->success("取消推荐成功！");
        } else {
            $this->error("取消推荐失败！");
        }
    }
    public function jinpins() {
        $data['type'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Activity")->where(array("id" => $id))->save($data);
            }
            $this->success("设置精品成功！");
        } else {
            $this->error("设置精品成功！");
        }
    }

    /*
     * 活动精品
     */

    public function unjinpins() {
        $data['type'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Activity")->where(array("id" => $id))->save($data);
            }
            $this->success("取消设置精品成功！");
        } else {
            $this->error("取消设置精品失败！");
        }
    }
    /*
     * 活动排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Activity")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Activity")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    public function get_hostel(){
        $data=M('Hostel')->where(array('uid'=>$_GET['uid'],'status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->select();
        echo json_encode($data);
    }
}