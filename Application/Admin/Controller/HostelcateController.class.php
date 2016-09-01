<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class HostelcateController extends CommonController {

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
        $Hostelcate = $this->Hostelcate;
        $this->assign("data", $Hostelcate);
        $this->display();
    }

    /**
     *  添加
     */
    public function add() {
        if (IS_POST) {
            if (D("Hostelcate")->create()) {
                D("Hostelcate")->inputtime=time();
                $catid=D("Hostelcate")->add();
                if ($catid) {
                    $this->success("增加成功！", U("Admin/Hostelcate/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error(D("Hostelcate")->getError());
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
        if (D("Hostelcate")->delete($id)) {
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
            $data = D("Hostelcate")->create();
            if ($data) {
                if (D("Hostelcate")->save($data)) {
                    $this->success("修改成功！", U("Admin/Hostelcate/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Hostelcate")->getError());
            }
        } else {
            $data = D("Hostelcate")->where(array("id" => $id))->find();
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
            $Hostelcate = D("Hostelcate");
            foreach ($_POST['listorders'] as $id => $listorder) {
                $Hostelcate->where(array('id' => $id))->save(array('listorder' => $listorder));
            }
            $this->success("排序更新成功！");
        } else {
            $this->error("信息提交有误！");
        }
    }
    
}