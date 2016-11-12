<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class GiftController extends CommonController {

    public function index() {
        $count = D("Gift")->count();
        $page = new \Think\Page($count, 10);
        $data = D("Gift")->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortitle"] = $this->str_cut($r["title"], 30);
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    /**
     * 编辑奖品
     */
    public function edit() {
        if ($_POST) {
            if (D("Gift")->create()) {
                D("Gift")->validity_starttime=strtotime($_POST['validity_starttime']);
                D("Gift")->validity_endtime=strtotime($_POST['validity_endtime']);
                D("Gift")->updatetime = time();
                $id = D("Gift")->where('id=' . $_POST['id'])->save();
                if (!empty($id)) {
                    $this->success("修改奖品成功！", U("Admin/Gift/index"));
                } else {
                    $this->error("修改奖品失败！");
                }
            } else {
                $this->error(D("Gift")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
         if (empty($id)) {
                $this->error("奖品ID参数错误");
          }
        $data=D("Gift")->where("id=".$id)->find();
        $this->assign("data", $data);
        $this->display();
        }
        
    }

    /*
     * 添加奖品
     */

    public function add() {
        if ($_POST) {
            if (D("Gift")->create()) {
                D("Gift")->validity_starttime=strtotime($_POST['validity_starttime']);
                D("Gift")->validity_endtime=strtotime($_POST['validity_endtime']);
                D("Gift")->inputtime = time();
                D("Gift")->username = $_SESSION['user'];
                $id = D("Gift")->add();
                if (!empty($id)) {
                    $this->success("新增奖品成功！", U("Admin/Gift/index"));
                } else {
                    $this->error("新增奖品失败！");
                }
            } else {
                $this->error(D("Gift")->getError());
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
        if (D("Gift")->delete($id)) {
            $this->success("删除奖品成功！");
        } else {
            $this->error("删除奖品失败！");
        }
    }

    /*
     * 删除奖品
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Gift")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /*
     * 奖品审核
     */

    public function review() {
        $data['status'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Gift")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 奖品取消审核
     */

    public function unreview() {
        $data['status'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Gift")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 奖品推荐
     */

    public function pushs() {
        $data['type'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Gift")->where(array("id" => $id))->save($data);
            }
            $this->success("推荐成功！");
        } else {
            $this->error("推荐成功！");
        }
    }

    /*
     * 奖品推荐
     */

    public function unpushs() {
        $data['type'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Gift")->where(array("id" => $id))->save($data);
            }
            $this->success("取消推荐成功！");
        } else {
            $this->error("取消推荐失败！");
        }
    }

    /*
     * 奖品排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Gift")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Gift")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

}