<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class RoomController extends CommonController {

    public function _initialize(){
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }

    public function index() {
        $search = I('get.search');
        $where = array();
        $hid=I('hid');
        $where['hid']=$hid;
        $this->assign("hid",$hid);
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

        $count = D("Room")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("Room")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortitle"] = $this->str_cut($r["title"], 30);
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    /**
     * 编辑房间
     */
    public function edit() {
        if ($_POST) {
            $imglist=  implode("|",$_POST["imglist"]);
            $support=  implode(",",$_POST["support"]);
            if (D("Room")->create()) {
                D("Room")->money=min($_POST['nomal_money'],$_POST['week_money'],$_POST['holiday_money']);
                D("Room")->wait_num = $_POST['mannum'];
                D("Room")->imglist = $imglist;
                D("Room")->support = $support;
                D("Room")->updatetime = time();
                $id = D("Room")->save();
                if (!empty($id)) {
                    $money=M('room')->where(array('hid'=>$_POST['hid']))->min("money");
                    $area=M('room')->where(array('hid'=>$_POST['hid']))->max("area");
                    $support=M('room')->where(array('hid'=>$_POST['hid']))->group("hid")->field("hid,group_concat(support) as newsupport")->select();
                    $supportbox=explode(",", $support[0]['newsupport']);
                    $supportbox=array_unique($supportbox);

                    $bedtype=M('room')->where(array('hid'=>$_POST['hid']))->group("hid")->field("hid,group_concat(roomtype) as newbedtype")->select();
                    $bedtypebox=explode(",", $bedtype[0]['newbedtype']);
                    $bedtypebox=array_unique($bedtypebox);


                    M('hostel')->where(array('id'=>$_POST['hid']))->save(array(
                        'money'=>$money,
                        'acreage'=>$area,
                        'support'=>",".implode(",", $supportbox).",",
                        'bedtype'=>",".implode(",", $bedtypebox).","
                        ));
                    $this->success("修改房间成功！", U("Admin/Room/index",array('hid'=>$_POST['hid'])));
                } else {
                    $this->error("修改房间失败！");
                }
            } else {
                $this->error(D("Room")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("ID参数错误");
            }
            $data=D("Room")->where("id=".$id)->find();
            $this->assign("data", $data);
            $imglist=explode("|",$data['imglist']);
            $this->assign("imglist", $imglist);
            $roomcate=M("roomcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("roomcate",$roomcate);
            $bedcate=M("bedcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("bedcate",$bedcate);
            $this->display();
        }

    }

    /*
     * 添加房间
     */

    public function add() {
        if ($_POST) {
            $imglist=  implode("|",$_POST["imglist"]);
            $support=  implode(",",$_POST["support"]);
            if (D("Room")->create()) {
                D("Room")->imglist = $imglist;
                D("Room")->support = $support;
                D("Room")->money=min($_POST['nomal_money'],$_POST['week_money'],$_POST['holiday_money']);
                D("Room")->wait_num = $_POST['mannum'];
                D("Room")->inputtime = time();
                D("Room")->updatetime = time();
                D("Room")->status = 2;
                D("Room")->verify_user=$_SESSION['user'];
                D("Room")->verify_time = time();
                $id = D("Room")->add();
                if (!empty($id)) {
                    $money=M('room')->where(array('hid'=>$_POST['hid']))->min("money");
                    $area=M('room')->where(array('hid'=>$_POST['hid']))->max("area");
                    $support=M('room')->where(array('hid'=>$_POST['hid']))->group("hid")->field("hid,group_concat(support) as newsupport")->select();
                    $supportbox=explode(",", $support[0]['newsupport']);
                    $supportbox=array_unique($supportbox);

                    $bedtype=M('room')->where(array('hid'=>$_POST['hid']))->group("hid")->field("hid,group_concat(roomtype) as newbedtype")->select();
                    $bedtypebox=explode(",", $bedtype[0]['newbedtype']);
                    $bedtypebox=array_unique($bedtypebox);


                    M('hostel')->where(array('id'=>$_POST['hid']))->save(array(
                        'money'=>$money,
                        'acreage'=>$area,
                        'support'=>",".implode(",", $supportbox).",",
                        'bedtype'=>",".implode(",", $bedtypebox).","
                        ));
                    $this->success("新增房间成功！", U("Admin/Room/index",array('hid'=>$_POST['hid'])));
                } else {
                    $this->error("新增房间失败！");
                }
            } else {
                $this->error(D("Room")->getError());
            }
        } else {
            $hid=I('hid');
            $this->assign("hid",$hid);
            $roomcate=M("roomcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("roomcate",$roomcate);
            $bedcate=M("bedcate")->order(array('listorder'=>'desc','id'=>'asc'))->select();
            $this->assign("bedcate",$bedcate);
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
        $room=M('Room')->where(array('id'=>$id))->find();
        $hid=$room['hid'];
        $did=M("Room")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));

        if ($did) {
            $money=M('room')->where(array('hid'=>$hid,'isdel'=>0))->min("money");
            $area=M('room')->where(array('hid'=>$hid,'isdel'=>0))->max("area");
            $support=M('room')->where(array('hid'=>$hid,'isdel'=>0))->group("hid")->field("hid,group_concat(support) as newsupport")->select();
            $supportbox=explode(",", $support[0]['newsupport']);
            $supportbox=array_unique($supportbox);

            $bedtype=M('room')->where(array('hid'=>$hid,'isdel'=>0))->group("hid")->field("hid,group_concat(roomtype) as newbedtype")->select();
            $bedtypebox=explode(",", $bedtype[0]['newbedtype']);
            $bedtypebox=array_unique($bedtypebox);


            M('hostel')->where(array('id'=>$hid))->save(array(
                'money'=>$money,
                'acreage'=>$area,
                'support'=>",".implode(",", $supportbox).",",
                'bedtype'=>",".implode(",", $bedtypebox).","
                ));
            $this->success("删除房间成功！");
        } else {
            $this->error("删除房间失败！");
        }
    }

    /*
     * 删除房间
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Room")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));
                $room=M('Room')->where(array('id'=>$id))->find();
                $hid=$room['hid'];
                $money=M('room')->where(array('hid'=>$hid,'isdel'=>0))->min("money");
                $area=M('room')->where(array('hid'=>$hid,'isdel'=>0))->max("area");
                $support=M('room')->where(array('hid'=>$hid,'isdel'=>0))->group("hid")->field("hid,group_concat(support) as newsupport")->select();
                $supportbox=explode(",", $support[0]['newsupport']);
                $supportbox=array_unique($supportbox);

                $bedtype=M('room')->where(array('hid'=>$hid,'isdel'=>0))->group("hid")->field("hid,group_concat(roomtype) as newbedtype")->select();
                $bedtypebox=explode(",", $bedtype[0]['newbedtype']);
                $bedtypebox=array_unique($bedtypebox);


                M('hostel')->where(array('id'=>$hid))->save(array(
                    'money'=>$money,
                    'acreage'=>$area,
                    'support'=>",".implode(",", $supportbox).",",
                    'bedtype'=>",".implode(",", $bedtypebox).","
                    ));
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /*
     * 房间审核
     */

    public function review() {
        $data['status'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Room")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 房间取消审核
     */

    public function unreview() {
        $data['status'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Room")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 房间推荐
     */

    public function pushs() {
        $data['type'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Room")->where(array("id" => $id))->save($data);
            }
            $this->success("推荐成功！");
        } else {
            $this->error("推荐成功！");
        }
    }

    /*
     * 房间推荐
     */

    public function unpushs() {
        $data['type'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Room")->where(array("id" => $id))->save($data);
            }
            $this->success("取消推荐成功！");
        } else {
            $this->error("取消推荐失败！");
        }
    }

    /*
     * 房间排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Room")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Room")->where(array($pk => $key))->save($data);
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