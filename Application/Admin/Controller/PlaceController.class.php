<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class PlaceController extends CommonController {

    public function _initialize() {
        $Place=F("Place");
        if(!$Place){
            $Place=M('Place')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            F("Place",$Place);
        }
        $this->Place=$Place;       
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $Place = $this->Place;
        $this->assign("data", $Place);
        $this->display();
    }

    /**
     *  添加
     */
    public function add() {
        if (IS_POST) {
            if (D("Place")->create()) {
                D("Place")->inputtime=time();
                $catid=D("Place")->add();
                if ($catid) {
                    $this->success("增加成功！", U("Admin/Place/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error(D("Place")->getError());
            }
        } else {
            $this->display();
        }
    }


    
    /**
     *  删除
     */
    public function delete() {
        $id = $_GET['id'];
        if (D("Place")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     *  编辑
     */
    public function edit() {
        $id = $_GET['id'];
        if (IS_POST) {
            $data = D("Place")->create();
            if ($data) {
                if (D("Place")->save($data)) {
                    $this->success("修改成功！", U("Admin/Place/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Place")->getError());
            }
        } else {
            $data = D("Place")->where(array("id" => $id))->find();
            if (!$data) {
                $this->error("该特色不存在！");
            }
            $this->assign("data", $data);
            $this->display();
        }
    }
    
    //排序 
    public function listorder() {
        if (IS_POST) {
            $Place = D("Place");
            foreach ($_POST['listorders'] as $id => $listorder) {
                $Place->where(array('id' => $id))->save(array('listorder' => $listorder));
            }
            $this->success("排序更新成功！");
        } else {
            $this->error("信息提交有误！");
        }
    }
    
}