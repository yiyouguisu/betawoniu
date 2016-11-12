<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class BedcateController extends CommonController {

    public function _initialize() {
        $Bedcate=F("Bedcate");
        if(!$Bedcate){
            $Bedcate=M('Bedcate')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            F("Bedcate",$Bedcate);
        }
        $this->Bedcate=$Bedcate;       
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $Bedcate = $this->Bedcate;
        $this->assign("data", $Bedcate);
        $this->display();
    }

    /**
     *  添加
     */
    public function add() {
        if (IS_POST) {
            if (D("Bedcate")->create()) {
                D("Bedcate")->inputtime=time();
                $catid=D("Bedcate")->add();
                if ($catid) {
                    $this->success("增加成功！", U("Admin/Bedcate/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error(D("Bedcate")->getError());
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
        if (D("Bedcate")->delete($id)) {
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
            $data = D("Bedcate")->create();
            if ($data) {
                if (D("Bedcate")->save($data)) {
                    $this->success("修改成功！", U("Admin/Bedcate/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Bedcate")->getError());
            }
        } else {
            $data = D("Bedcate")->where(array("id" => $id))->find();
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
            $Bedcate = D("Bedcate");
            foreach ($_POST['listorders'] as $id => $listorder) {
                $Bedcate->where(array('id' => $id))->save(array('listorder' => $listorder));
            }
            $this->success("排序更新成功！");
        } else {
            $this->error("信息提交有误！");
        }
    }
    
}