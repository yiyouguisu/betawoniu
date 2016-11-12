<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class NoteController extends CommonController {

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

        $count = D("Note")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("Note")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortitle"] = $this->str_cut($r["title"], 30);
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    /**
     * 编辑游记
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
            if (D("Note")->create()) {
                D("Note")->lng = $location['lng'];
                D("Note")->lat = $location['lat'];
                D("Note")->city = $city;
                D("Note")->begintime=strtotime($_POST['begintime']);
                D("Note")->endtime=strtotime($_POST['endtime']);
                D("Note")->hid = implode(",", $_POST['hid']);
                D("Note")->imglist = $imglist;
                D("Note")->username=M('Member')->where(array('id'=>$_POST['uid']))->getField("nickname");
                D("Note")->updatetime = time();
                $id = D("Note")->save();
                if (!empty($id)) {
                    $nid=$_POST['id'];
                    $hid=$_POST['hid'];
                    $title=$_POST["title"];
                    foreach ($hid as $value) {
                        # code...
                        $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->where(array('a.id'=>$value))->field("a.id,a.title,b.title as place")->find();
                        $tags_content=M('tags_content')->where(array('contentid'=>$nid,'hid'=>$hostel['id'],'varname'=>'note','type'=>'hostel'))->find();
                        if(empty($tags_content)){
                            M('tags_content')->add(array('contentid'=>$nid,'title'=>$hostel['title'],'varname'=>'note','type'=>'hostel','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                        }

                        $tags_content=M('tags_content')->where(array('contentid'=>$nid,'hid'=>$hostel['id'],'varname'=>'note','type'=>'place'))->find();
                        if(empty($tags_content)){
                            M('tags_content')->add(array('contentid'=>$nid,'title'=>$hostel['place'],'varname'=>'note','type'=>'place','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                        }
                    }
                    $this->success("修改游记成功！", U("Admin/Note/index"));
                } else {
                    $this->error("修改游记失败！");
                }
            } else {
                $this->error(D("Note")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("文章ID参数错误");
            }
            $data=D("Note")->where("id=".$id)->find();
            $data['begintime']=date("Y-m-d",$data['begintime']);
            $data['endtime']=date("Y-m-d",$data['endtime']);
            $this->assign("data", $data);
            $imglist=json_decode($data['imglist'],true);
            $this->assign("imglist", $imglist);
            $notestyle=M("notestyle")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("notestyle",$notestyle);
            $noteman=M("noteman")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("noteman",$noteman);
            $this->display();
        }

    }
    /*
     * 添加游记
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
            if (D("Note")->create()) {
                D("Note")->lng = $location['lng'];
                D("Note")->lat = $location['lat'];
                D("Note")->city = $city;
                D("Note")->begintime=strtotime($_POST['begintime']);
                D("Note")->endtime=strtotime($_POST['endtime']);
                D("Note")->imglist = $imglist;
                D("Note")->hid = implode(",", $_POST['hid']);
                D("Note")->inputtime = time();
                D("Note")->updatetime = time();
                D("Note")->username=M('Member')->where(array('id'=>$_POST['uid']))->getField("nickname");
                D("Store")->status = 2;
                D("Store")->verify_user=$_SESSION['user'];
                D("Store")->verify_time = time();
                $id = D("Note")->add();
                if (!empty($id)) {
                    $nid=$id;
                    $hid=$_POST['hid'];
                    $title=$_POST["title"];
                    foreach ($hid as $value) {
                        # code...
                        $hostel=M('hostel a')->join("left join zz_place b on a.place=b.id")->where(array('a.id'=>$value))->field("a.id,a.title,b.title as place")->find();
                        $tags_content=M('tags_content')->where(array('contentid'=>$nid,'hid'=>$hostel['id'],'varname'=>'note','type'=>'hostel'))->find();
                        if(empty($tags_content)){
                            M('tags_content')->add(array('contentid'=>$nid,'title'=>$title,'varname'=>'note','type'=>'hostel','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                        }

                        $tags_content=M('tags_content')->where(array('contentid'=>$nid,'hid'=>$hostel['id'],'varname'=>'note','type'=>'place'))->find();
                        if(empty($tags_content)){
                            M('tags_content')->add(array('contentid'=>$nid,'title'=>$title,'varname'=>'note','type'=>'place','hid'=>$hostel['id'],'hostel'=>$hostel['title'],'place'=>$hostel['place'],'updatetime'=>time()));
                        }
                    }
                    $this->success("新增游记成功！", U("Admin/Note/index"));
                } else {
                    $this->error("新增游记失败！");
                }
            } else {
                $this->error(D("Note")->getError());
            }
        } else {
            $notestyle=M("notestyle")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("notestyle",$notestyle);
            $noteman=M("noteman")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("noteman",$noteman);
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
        $did=M("Note")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));
        if ($did) {
            $this->success("删除游记成功！");
        } else {
            $this->error("删除游记失败！");
        }
    }

    /*
     * 删除游记
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Note")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));
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
        $did=M()->execute("update zz_note set isoff={$_GET['isoff']}, offtime={$offtime} where id={$id}");
        //$did=M("Note")->where(array('id'=>$id))->save(array('isoff'=>$_GET['isoff'],'offtime'=>time()));
        if ($did) {
            $this->success("更新状态成功！");
        } else {
            $this->error("更新状态失败！");
        }
    }
    /*
     * 游记审核
     */

    public function review() {
        if (IS_POST) {
            $status=I('status');
            if(empty($status)){
                $this->error("请选择审核状态");
            }
            $data=M('note')->where('id=' . I('id'))->find();
            if($data['status']!=1){
                $this->error("不能重复审核！");
            }
            $id=M('note')->where('id=' . I('id'))->save(array(
                'status'=>$status,
                'verify_time' => time(),
                'verify_user' => $_SESSION['user'],
                'remark'=>I('remark')
            ));
            if($id>0&&$status==2){
                \Api\Controller\UtilController::addmessage($data['uid'],"游记审核","您的游记(".$data['title'].")审核成功！","您的游记(".$data['title'].")审核成功！","successreviewnote",$data['id']);
                $this->success("操作成功！");
            }elseif($id>0&&$status==3){
                \Api\Controller\UtilController::addmessage($data['uid'],"游记审核","您的游记(".$data['title'].")审核失败！","您的游记(".$data['title'].")审核失败！","failreviewnote",$data['id']);
                $this->success("操作成功！");
            }elseif(!$id){
                $this->error("操作失败！");
            }
        } else {
            $id=I('id');
            $data=M('note')->where(array('id'=>$id))->find();
            $this->assign("data",$data);
            $this->display();
        }
    }

    

    public function pushs() {
        $data['isindex'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Note")->where(array("id" => $id))->save($data);
            }
            $this->success("推荐成功！");
        } else {
            $this->error("推荐成功！");
        }
    }

    /*
     * 游记推荐
     */

    public function unpushs() {
        $data['isindex'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Note")->where(array("id" => $id))->save($data);
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
                M("Note")->where(array("id" => $id))->save($data);
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
                M("Note")->where(array("id" => $id))->save($data);
            }
            $this->success("取消设置精品成功！");
        } else {
            $this->error("取消设置精品失败！");
        }
    }

    /*
     * 游记排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Note")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Note")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    public function get_hostel(){
        $hid=I('hid');
        $hidbox=explode(",",$hid);
        $data=M('book_room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.uid'=>$_POST['uid'],'b.status'=>2,'b.isdel'=>0,'a.paystatus'=>1))->order(array('b.listorder'=>'desc','b.id'=>'desc'))->select();
        if(empty($data)){
            $data=M('Hostel')->where(array('status'=>2,'isdel'=>0,'type'=>'0'))->order(array('listorder'=>'desc','id'=>'desc'))->field("id,title")->select();
        }
        foreach ($data as $key => $value) {
            # code...
            if(!empty($hidbox)&&in_array($value['id'],$hidbox)){
                $data[$key]['ischeck']=1;
            }else{
                $data[$key]['ischeck']=0;
            }
        }
        echo json_encode($data);
    }
}