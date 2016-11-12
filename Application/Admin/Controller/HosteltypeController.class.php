<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class HosteltypeController extends CommonController {

    public function _initialize() {
        $Hosteltype=F("Hosteltype");
        if(!$Hosteltype){
            $Hosteltype=M('Hosteltype')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            F("Hosteltype",$Hosteltype);
        }
        $this->Hosteltype=$Hosteltype;       
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $Hosteltype = $this->Hosteltype;
        $this->assign("data", $Hosteltype);
        $this->display();
    }

    /**
     *  添加
     */
    public function add() {
        if (IS_POST) {
            if (D("Hosteltype")->create()) {
                D("Hosteltype")->inputtime=time();
                $catid=D("Hosteltype")->add();
                if ($catid) {
                    $this->success("增加成功！", U("Admin/Hosteltype/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error(D("Hosteltype")->getError());
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
        if (D("Hosteltype")->delete($id)) {
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
            $data = D("Hosteltype")->create();
            if ($data) {
                if (D("Hosteltype")->save($data)) {
                    $this->success("修改成功！", U("Admin/Hosteltype/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Hosteltype")->getError());
            }
        } else {
            $data = D("Hosteltype")->where(array("id" => $id))->find();
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
            $Hosteltype = D("Hosteltype");
            foreach ($_POST['listorders'] as $id => $listorder) {
                $Hosteltype->where(array('id' => $id))->save(array('listorder' => $listorder));
            }
            $this->success("排序更新成功！");
        } else {
            $this->error("信息提交有误！");
        }
    }
    
}