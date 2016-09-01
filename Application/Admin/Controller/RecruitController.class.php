<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class RecruitController extends CommonController {

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
    
        $count = D("Recruit")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $data = D("Recruit")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortitle"] = $this->str_cut($r["title"], 30);
            $data[$k]["house"] = D("house")->where("id=" . $r["hid"])->getField("title");
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);

        $this->display();
    }

    /**
     * 编辑招聘
     */
    public function edit() {
        if ($_POST) {
            if (D("Recruit")->create()) {
                D("Recruit")->updatetime = time();
                $id = D("Recruit")->save();
                if (!empty($id)) {
                    $this->success("修改招聘成功！", U("Admin/Recruit/index"));
                } else {
                    $this->error("修改招聘失败！");
                }
            } else {
                $this->error(D("Recruit")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
         if (empty($id)) {
                $this->error("文章ID参数错误");
          }
        $data=D("Recruit")->where("id=".$id)->find();
        $this->assign("data", $data);
        $shop=M('house')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->select();
            $this->assign("shop",$shop);
        $this->display();
        }
        
    }

    /*
     * 添加招聘
     */

    public function add() {
        if ($_POST) {
            if (D("Recruit")->create()) {
                D("Recruit")->inputtime = time();
                D("Recruit")->username = $_SESSION['user'];
                $id = D("Recruit")->add();
                if (!empty($id)) {
                    $this->success("新增招聘成功！", U("Admin/Recruit/index"));
                } else {
                    $this->error("新增招聘失败！");
                }
            } else {
                $this->error(D("Recruit")->getError());
            }
        } else {
            $shop=M('house')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->select();
            $this->assign("shop",$shop);
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
        if (D("Recruit")->delete($id)) {
            $this->success("删除招聘成功！");
        } else {
            $this->error("删除招聘失败！");
        }
    }

    /*
     * 删除招聘
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Recruit")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /*
     * 招聘审核
     */

    public function review() {
        $data['status'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("article")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 招聘取消审核
     */

    public function unreview() {
        $data['status'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("article")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 招聘推荐
     */

    public function pushs() {
        $data['type'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("article")->where(array("id" => $id))->save($data);
            }
            $this->success("推荐成功！");
        } else {
            $this->error("推荐成功！");
        }
    }

    /*
     * 招聘推荐
     */

    public function unpushs() {
        $data['type'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("article")->where(array("id" => $id))->save($data);
            }
            $this->success("取消推荐成功！");
        } else {
            $this->error("取消推荐失败！");
        }
    }

    /*
     * 招聘排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Recruit")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Recruit")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

}