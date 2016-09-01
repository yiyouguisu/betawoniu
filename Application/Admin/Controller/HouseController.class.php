<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class HouseController extends CommonController {

    public function _initialize(){
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

        $count = D("House")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("House")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortitle"] = $this->str_cut($r["title"], 30);
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    /**
     * 编辑民宿
     */
    public function edit() {
        if ($_POST) {
            // $Map=A("Api/Map");
            // $location=$Map->get_position_complex($_POST['area'],$_POST['address']);
            // $areabox=explode(",",$_POST['area']);
            // if(in_array($areabox[0],array(2,3,4,5))){
            //     $city=$areabox[0];
            // }else{
            //     $city=$areabox[1];
            // }
            //$imglist=  json_encode($_POST["imglist"]);
            if (D("House")->create()) {
                // D("House")->lng = $location['lng'];
                // D("House")->lat = $location['lat'];
                // D("House")->city = $city;
                D("House")->couponsrule=implode(",", $_POST['couponsrule']);
                D("House")->link = $_POST['link'];
                D("House")->theme = $_POST['theme'];
                // D("House")->workstarttime=strtotime($_POST['workstarttime']);
                // D("House")->workendtime=strtotime($_POST['workendtime']);
                //D("House")->imglist = $imglist;
                D("House")->username=M('Member')->where(array('id'=>$_POST['uid']))->getField("nickname");
                D("House")->updatetime = time();
                $id = D("House")->save();
                if (!empty($id)) {
                    $this->success("修改民宿成功！", U("Admin/House/index"));
                } else {
                    $this->error("修改民宿失败！");
                }
            } else {
                $this->error(D("House")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("文章ID参数错误");
            }
            $data=D("House")->where("id=".$id)->find();
            $data['workstarttime']=date("Y-m-d H:i:s",$data['workstarttime']);
            $data['workendtime']=date("Y-m-d H:i:s",$data['workendtime']);
            $this->assign("data", $data);
            //$imglist=json_decode($data['imglist'],true);
            //$this->assign("imglist", $imglist);
            $this->display();
        }

    }

    /*
     * 添加民宿
     */

    public function add() {
        if ($_POST) {
            // $Map=A("Api/Map");
            // $location=$Map->get_position_complex($_POST['area'],$_POST['address']);
            // //$imglist=  json_encode($_POST["imglist"]);
            // $areabox=explode(",",$_POST['area']);
            // if(in_array($areabox[0],array(2,3,4,5))){
            //     $city=$areabox[0];
            // }else{
            //     $city=$areabox[1];
            // }
            if (D("House")->create()) {
                // D("House")->lng = $location['lng'];
                // D("House")->lat = $location['lat'];
                // D("House")->city = $city;
                D("House")->lng = 'xxx';
                D("House")->lat = 'xxx';
                D("House")->city = 'xxx';
                D("House")->couponsrule=implode(",", $_POST['couponsrule']);
                D("House")->link = $_POST['link'];
                D("House")->theme = $_POST['theme'];
                // D("House")->workstarttime=strtotime($_POST['workstarttime']);
                // D("House")->workendtime=strtotime($_POST['workendtime']);
                //D("House")->imglist = $imglist;
                D("House")->inputtime = time();
                D("House")->updatetime = time();
                D("House")->username=M('Member')->where(array('id'=>$_POST['uid']))->getField("nickname");
                D("House")->status = 2;
                D("House")->verify_user=$_SESSION['user'];
                D("House")->verify_time = time();
                $id = D("House")->add();
                if (!empty($id)) {
                    $this->success("新增民宿成功！", U("Admin/House/index"));
                } else {
                    $this->error("新增民宿失败！");
                }
            } else {
                $this->error(D("House")->getError());
            }
        } else {
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
        $did=M("House")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));
        if ($did) {
            $this->success("删除民宿成功！");
        } else {
            $this->error("删除民宿失败！");
        }
    }

    /*
     * 删除民宿
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("House")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /*
     * 民宿审核
     */

    public function review() {
        $data['status'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("House")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 民宿取消审核
     */

    public function unreview() {
        $data['status'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("House")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 民宿推荐
     */

    public function pushs() {
        $data['type'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("House")->where(array("id" => $id))->save($data);
            }
            $this->success("推荐成功！");
        } else {
            $this->error("推荐成功！");
        }
    }

    /*
     * 民宿推荐
     */

    public function unpushs() {
        $data['type'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("House")->where(array("id" => $id))->save($data);
            }
            $this->success("取消推荐成功！");
        } else {
            $this->error("取消推荐失败！");
        }
    }

    /*
     * 民宿排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("House")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("House")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    public function pool() {
        $search = I('get.search');
        $where = array();
        $hid=I('id');
        $this->assign("hid",$hid);
        $where['a.hid']=$hid;

        $pid=I('pid');
        if(!empty($pid)){
            $uids=M('Member')->where(array('groupid_id'=>$pid))->getField("id",true);
            $where['a.uid']=array('in',$uids);
        }
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["a.inputtime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["a.inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['a.inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('b.nickname', 'b.phone');
                if ($searchtype < 4) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 4) {
                    $where["a.id"] = array("EQ", (int) $keyword);
                }
            }
        }

        $count = D("pool a")->join("left join zz_member b on a.uid=b.id")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("pool a")
            ->join("left join zz_member b on a.uid=b.id")
            ->where($where)
            ->limit($page->firstRow . ',' . $page->listRows)
            ->order(array("a.id" => "desc"))
            ->field("a.*,b.nickname,b.phone")
            ->select();
        //echo D("pool a")->_sql();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
}