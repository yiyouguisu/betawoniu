<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class NotestyleController extends CommonController {

    public function _initialize() {
        $Notestyle=F("Notestyle");
        if(!$Notestyle){
            $Notestyle=M('Notestyle')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            F("Notestyle",$Notestyle);
        }
        $this->Notestyle=$Notestyle;       
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $Notestyle = $this->Notestyle;
        $this->assign("data", $Notestyle);
        $this->display();
    }

    /**
     *  添加
     */
    public function add() {
        if (IS_POST) {
            if (D("Notestyle")->create()) {
                D("Notestyle")->inputtime=time();
                $catid=D("Notestyle")->add();
                if ($catid) {
                    $this->success("增加成功！", U("Admin/Notestyle/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error(D("Notestyle")->getError());
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
        if (D("Notestyle")->delete($id)) {
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
            $data = D("Notestyle")->create();
            if ($data) {
                if (D("Notestyle")->save($data)) {
                    $this->success("修改成功！", U("Admin/Notestyle/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Notestyle")->getError());
            }
        } else {
            $data = D("Notestyle")->where(array("id" => $id))->find();
            if (!$data) {
                $this->error("该形式不存在！");
            }
            $this->assign("data", $data);
            $this->display();
        }
    }
    
    //排序 
    public function listorder() {
        if (IS_POST) {
            $Notestyle = D("Notestyle");
            foreach ($_POST['listorders'] as $id => $listorder) {
                $Notestyle->where(array('id' => $id))->save(array('listorder' => $listorder));
            }
            $this->success("排序更新成功！");
        } else {
            $this->error("信息提交有误！");
        }
    }
    
}