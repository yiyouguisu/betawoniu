<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class NotemanController extends CommonController {

    public function _initialize() {
        $Noteman=F("Noteman");
        if(!$Noteman){
            $Noteman=M('Noteman')->order(array('listorder'=>'desc','id'=>'asc'))->select();
            F("Noteman",$Noteman);
        }
        $this->Noteman=$Noteman;       
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }
    public function index() {
        $Noteman = $this->Noteman;
        $this->assign("data", $Noteman);
        $this->display();
    }

    /**
     *  添加
     */
    public function add() {
        if (IS_POST) {
            if (D("Noteman")->create()) {
                D("Noteman")->inputtime=time();
                $catid=D("Noteman")->add();
                if ($catid) {
                    $this->success("增加成功！", U("Admin/Noteman/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error(D("Noteman")->getError());
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
        if (D("Noteman")->delete($id)) {
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
            $data = D("Noteman")->create();
            if ($data) {
                if (D("Noteman")->save($data)) {
                    $this->success("修改成功！", U("Admin/Noteman/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Noteman")->getError());
            }
        } else {
            $data = D("Noteman")->where(array("id" => $id))->find();
            if (!$data) {
                $this->error("该人物不存在！");
            }
            $this->assign("data", $data);
            $this->display();
        }
    }
    
    //排序 
    public function listorder() {
        if (IS_POST) {
            $Noteman = D("Noteman");
            foreach ($_POST['listorders'] as $id => $listorder) {
                $Noteman->where(array('id' => $id))->save(array('listorder' => $listorder));
            }
            $this->success("排序更新成功！");
        } else {
            $this->error("信息提交有误！");
        }
    }
    
}