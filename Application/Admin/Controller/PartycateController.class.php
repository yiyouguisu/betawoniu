<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class PartycateController extends CommonController {

    public function _initialize() {
        $Partycate=F("Partycate");
        if(!$Partycate){
            $Partycate=M('Partycate')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            F("Partycate",$Partycate);
        }
        $this->Partycate=$Partycate;       
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $Partycate = $this->Partycate;
        $this->assign("data", $Partycate);
        $this->display();
    }

    /**
     *  添加
     */
    public function add() {
        if (IS_POST) {
            if (D("Partycate")->create()) {
                D("Partycate")->inputtime=time();
                $catid=D("Partycate")->add();
                if ($catid) {
                    $this->success("增加成功！", U("Admin/Partycate/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error(D("Partycate")->getError());
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
        if (D("Partycate")->delete($id)) {
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
            $data = D("Partycate")->create();
            if ($data) {
                if (D("Partycate")->save($data)) {
                    $this->success("修改成功！", U("Admin/Partycate/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Partycate")->getError());
            }
        } else {
            $data = D("Partycate")->where(array("id" => $id))->find();
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
            $Partycate = D("Partycate");
            foreach ($_POST['listorders'] as $id => $listorder) {
                $Partycate->where(array('id' => $id))->save(array('listorder' => $listorder));
            }
            $this->success("排序更新成功！");
        } else {
            $this->error("信息提交有误！");
        }
    }
    
}