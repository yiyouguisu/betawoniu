<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class RoomcateController extends CommonController {

    public function _initialize() {
        $Roomcate=F("Roomcate");
        if(!$Roomcate){
            $Roomcate=M('Roomcate')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            F("Roomcate",$Roomcate);
        }
        $this->Roomcate=$Roomcate;       
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $Roomcate = $this->Roomcate;
        $this->assign("data", $Roomcate);
        $this->display();
    }

    /**
     *  添加
     */
    public function add() {
        if (IS_POST) {
            if (D("Roomcate")->create()) {
                D("Roomcate")->inputtime=time();
                $catid=D("Roomcate")->add();
                if ($catid) {
                    $this->success("增加成功！", U("Admin/Roomcate/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error(D("Roomcate")->getError());
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
        if (D("Roomcate")->delete($id)) {
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
            $data = D("Roomcate")->create();
            if ($data) {
                if (D("Roomcate")->save($data)) {
                    $this->success("修改成功！", U("Admin/Roomcate/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Roomcate")->getError());
            }
        } else {
            $data = D("Roomcate")->where(array("id" => $id))->find();
            if (!$data) {
                $this->error("该设施不存在！");
            }
            $this->assign("data", $data);
            $this->display();
        }
    }
    
    //排序 
    public function listorder() {
        if (IS_POST) {
            $Roomcate = D("Roomcate");
            foreach ($_POST['listorders'] as $id => $listorder) {
                $Roomcate->where(array('id' => $id))->save(array('listorder' => $listorder));
            }
            $this->success("排序更新成功！");
        } else {
            $this->error("信息提交有误！");
        }
    }
    
}