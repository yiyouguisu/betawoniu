<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class HostelController extends CommonController {

    public function _initialize() {
        $Hostelcate=F("Hostelcate");
        if(!$Hostelcate){
            $Hostelcate=M('Hostelcate')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            F("Hostelcate",$Hostelcate);
        }
        $this->Hostelcate=$Hostelcate;       
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }

    public function index() {
        $search = I('get.search');
        $where = array();
        $where['isdel']=0;
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
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('title', 'content', 'username');
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

        $count = D("Hostel")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("Hostel")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortitle"] = $this->str_cut($r["title"], 30);
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    /**
     * 编辑美宿
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
            $imglist=  json_encode($_POST["imglist"]);
            if (D("Hostel")->create()) {
                D("Hostel")->lng = $location['lng'];
                D("Hostel")->lat = $location['lat'];
                D("Hostel")->city = $city;
                D("Hostel")->imglist = $imglist;
                D("Hostel")->username=M('Member')->where(array('id'=>$_POST['uid']))->getField("nickname");
                D("Hostel")->updatetime = time();
                $id = D("Hostel")->save();
                if (!empty($id)) {
                    $hid=$_POST['id'];
                    $title=$_POST["title"];
                    $place=M('place')->where(array('id'=>$_POST['place']))->getField("title");
                    $tags_content=M('tags_content')->where(array('contentid'=>$hid,'varname'=>'hostel','type'=>'hostel'))->find();
                    if(empty($tags_content)){
                        M('tags_content')->add(array('contentid'=>$hid,'title'=>$title,'varname'=>'hostel','type'=>'hostel','hid'=>$hid,'hostel'=>$title,'place'=>$place,'updatetime'=>time()));
                    }
                    $this->success("修改美宿成功！", U("Admin/Hostel/index"));
                } else {
                    $this->error("修改美宿失败！");
                }
            } else {
                $this->error(D("Hostel")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("ID参数错误");
            }
            $data=D("Hostel")->where("id=".$id)->find();
            $this->assign("data", $data);
            $imglist=json_decode($data['imglist'],true);
            $this->assign("imglist", $imglist);
            $hostelcate=M("hostelcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("hostelcate",$hostelcate);
            $hosteltype=M("hosteltype")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("hosteltype",$hosteltype);
            $place=M("place")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("place",$place);
            $this->display();
        }

    }
    /*
     * 添加美宿
     */

    public function add() {
        if ($_POST) {
            $Map=A("Api/Map");
            $location=$Map->get_position_complex($_POST['area'],$_POST['address']);
            $imglist=  json_encode($_POST["imglist"]);
            $areabox=explode(",",$_POST['area']);
            if(in_array($areabox[0],array(2,3,4,5))){
                $city=$areabox[0];
            }else{
                $city=$areabox[1];
            }
            if (D("Hostel")->create()) {
                D("Hostel")->lng = $location['lng'];
                D("Hostel")->lat = $location['lat'];
                D("Hostel")->city = $city;
                D("Hostel")->imglist = $imglist;
                D('Hostel')->bookremark = htmlspecialchars_decode($_POST['bookremark']);//退订信息
                D("Hostel")->inputtime = time();
                D("Hostel")->updatetime = time();
                D("Hostel")->username=M('Member')->where(array('id'=>$_POST['uid']))->getField("nickname");
                D("Hostel")->status = 2;
                D("Hostel")->verify_user=$_SESSION['user'];
                D("Hostel")->verify_time = time();
                $id = D("Hostel")->add();
                if (!empty($id)) {
                    $hid=$id;
                    $title=$_POST["title"];
                    $place=M('place')->where(array('id'=>$_POST['place']))->getField("title");
                    $tags_content=M('tags_content')->where(array('contentid'=>$hid,'varname'=>'hostel','type'=>'hostel'))->find();
                    if(empty($tags_content)){
                        M('tags_content')->add(array('contentid'=>$hid,'title'=>$title,'varname'=>'hostel','type'=>'hostel','hid'=>$hid,'hostel'=>$title,'place'=>$place,'updatetime'=>time()));
                    }
                    $this->success("新增美宿成功！", U("Admin/Hostel/index"));
                } else {
                    $this->error("新增美宿失败！");
                }
            } else {
                $this->error(D("Hostel")->getError());
            }
        } else {
            $hostelcate=M("hostelcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("hostelcate",$hostelcate);
            $hosteltype=M("hosteltype")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("hosteltype",$hosteltype);
            $place=M("place")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("place",$place);
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
        $did=M("Hostel")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));
        if ($did) {
            $this->success("删除美宿成功！");
        } else {
            $this->error("删除美宿失败！");
        }
    }

    /*
     * 删除美宿
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Hostel")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    /**
     *  下架
     */
    public function setoff() {
        $id = $_GET['id'];
        $offtime=time();
        $did=M()->execute("update zz_hostel set isoff={$_GET['isoff']} ,offtime={$offtime} where id={$id}");
        //$did=M("Hostel")->where(array('id'=>$id))->save(array('isoff'=>$_GET['isoff'],'offtime'=>time()));
        if ($did) {
            $this->success("更新状态成功！");
        } else {
            $this->error("更新状态失败！");
        }
    }
    /*
     * 美宿审核
     */

    public function review() {
        if (IS_POST) {
            $status=I('status');
            if(empty($status)){
                $this->error("请选择审核状态");
            }
            $data=M('Hostel')->where('id=' . I('id'))->find();
            if($data['status']!=1){
                $this->error("不能重复审核！");
            }
            $id=M('Hostel')->where('id=' . I('id'))->save(array(
                'status'=>$status,
                'verify_time' => time(),
                'verify_user' => $_SESSION['user'],
                'remark'=>I('remark')
            ));
            if($id>0&&$status==2){
                \Api\Controller\UtilController::addmessage($data['uid'],"美宿审核","您的美宿(".$data['title'].")审核成功！","您的美宿(".$data['title'].")审核成功！","successreviewhostel",$data['id']);
                $this->success("操作成功！");
            }elseif($id>0&&$status==3){
                \Api\Controller\UtilController::addmessage($data['uid'],"美宿审核","您的美宿(".$data['title'].")审核失败！","您的美宿(".$data['title'].")审核失败！","failreviewhostel",$data['id']);
                $this->success("操作成功！");
            }elseif(!$id){
                $this->error("操作失败！");
            }
        } else {
            $id=I('id');
            $data=M('Hostel')->where(array('id'=>$id))->find();
            $this->assign("data",$data);
            $this->display();
        }
    }

    /*
     * 美宿推荐
     */

    public function pushs() {
        $data['isindex'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Hostel")->where(array("id" => $id))->save($data);
            }
            $this->success("推荐成功！");
        } else {
            $this->error("推荐成功！");
        }
    }

    /*
     * 美宿推荐
     */

    public function unpushs() {
        $data['isindex'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Hostel")->where(array("id" => $id))->save($data);
            }
            $this->success("取消推荐成功！");
        } else {
            $this->error("取消推荐失败！");
        }
    }

    /*
     * 美宿排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Hostel")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Hostel")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    public function jinpins() {
        $data['type'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Hostel")->where(array("id" => $id))->save($data);
            }
            $this->success("设置精品成功！");
        } else {
            $this->error("设置精品成功！");
        }
    }

    /*
     * 游记推荐
     */

    public function unjinpins() {
        $data['type'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Hostel")->where(array("id" => $id))->save($data);
            }
            $this->success("取消设置精品成功！");
        } else {
            $this->error("取消设置精品失败！");
        }
    }
}