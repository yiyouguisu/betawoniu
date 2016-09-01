<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class TagController extends CommonController {

    public function index() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["lastusertime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["lastusertime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['lastusertime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('hostel', 'place', 'username');
                if ($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 3) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
            //状态
            $ishot = $_GET["ishot"];
            if ($ishot != "" && $ishot != null) {
                $where["ishot"] = array("EQ", $ishot);
            }
        }
    
        $count = D("Tags")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $data = D("Tags")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    /**
     * 编辑内容
     */
    public function edit() {
        if ($_POST) {
            $oldTagsName = I('post.oldtagsname', '', 'trim');
            $tag = I('post.tag', '', 'trim');
            if (D("Tags")->create()) {
                $id = D("Tags")->save();
                if (!empty($id)) {
                    if ($oldTagsName != $tag) {
                        M('TagsContent')->where(array('tag' => $oldTagsName))->save(array('tag' => $tag));
                    }
                    $this->success("修改成功！", U("Admin/Tag/index"));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error(D("Tags")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("ID参数错误");
            }
            $data=D("Tags")->where("id=".$id)->find();
            $this->assign("data", $data);
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
        } elseif ($submit == "hot") {
            $this->hot();
        } elseif ($submit == "unhot") {
            $this->unhot();
        }
    }

    /**
     *  删除
     */
    public function delete() {
        $id = I('get.id', 0, 'intval');
        $info =D("Tags")->where(array('id' => $id))->find();
        if (D("Tags")->delete($id)) {
            M('TagsContent')->where(array('tag' => $info['tag']))->delete();
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    

    /*
     * 删除内容
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                $info =D("Tags")->where(array('id' => $id))->find();
                M('TagsContent')->where(array('tag' => $info['tag']))->delete();
                M("Tags")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    

    /*
     * 内容审核
     */

    public function hot() {
        $data['ishot'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Tags")->where(array("id" => $id))->save($data);
            }
            $this->success("设置成功！");
        } else {
            $this->error("设置失败！");
        }
    }
    
    /*
     * 内容取消审核
     */

    public function unhot() {
        $data['ishot'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Tags")->where(array("id" => $id))->save($data);
            }
            $this->success("设置成功！");
        } else {
            $this->error("设置失败！");
        }
    }

    /*
     * 内容排序
     */

    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Tags")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Tags")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    public function downloadtpl() {
        $file=$_SERVER['DOCUMENT_ROOT']. "/Uploads/template/tag.xlsx";
        if(is_file($file)) {
            header("Content-Type: application/force-download");
            header("Content-Disposition: attachment; filename=".basename($file));
            readfile($file);
            exit;
        }else{
            $this->error('文件不存在！');
        }
    }
    public function tagimport(){
        if ($_POST) {
            $file=I('file');
            $filetmpname = $_SERVER['DOCUMENT_ROOT'] . $file;
            if(!is_file($filetmpname)){
                $this->error('文档解析错误');
            }
            import("Org.Util.PHPExcel");
            $PHPExcel = new \PHPExcel(); 
            $PHPReader = new \PHPExcel_Reader_Excel2007(); 
            if(!$PHPReader->canRead($filetmpname)){ 
                $PHPReader = new \PHPExcel_Reader_Excel5(); 
                if(!$PHPReader->canRead($filetmpname)){ 
                    $PHPReader = new \PHPExcel_Reader_CSV();
                    if(!$PHPReader->canRead($filetmpname)){
                        $this->error('文档解析错误');
                    }
                } 
            } 
            $PHPExcel = $PHPReader->load($filetmpname); 
            $member=array();
            $sheet = $PHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $strOut="";
            for ($row = 2; $row <= $highestRow; $row++){
                $hostel=$sheet->getCell('A'.$row)->getValue();
                if(empty($hostel)){
                    $strOut.="第:{$row}行信息导入失败：错误信息是美宿不能为空\r\n";
                    continue;
                }
                $place=$sheet->getCell('B'.$row)->getValue();
                if(empty($place)){
                    $strOut.="第:{$row}行信息导入失败：错误信息是景点不能为空\r\n";
                    continue;
                }
                $tag=M('tags')->where(array('hostel'=>$hostel,'place'=>$place))->find();
                if(!$tag){
                    $aid=M('tags')->add(array(
                        'tag'=>$hostel."--".$place,
                        'hostel'=>$hostel,
                        'place'=>$place,
                        'inputtime'=>time(),
                        'updatetime'=>time()
                        ));
                }
                if (!$aid) {
                    $strOut.="第:{$row}行信息导入失败\r\n";
                }
            }
            
            if($strOut!=""){
                $this->error($strOut);
            }else{
                $this->success('导入成功',U('Admin/Tag/index'));
            }
        } else {
            $this->display();
        }

    }
    public function upload() {
        if (!empty($_FILES)) {
            $upload = new \Think\Upload();
            $upload->maxSize = "202400000000";
            $upload->exts= explode("|","xls|xlsx");// 设置附件上传类型
            $upload->savePath = "/Uploads/files/";
            $upload->autoSub= true;
            $upload->saveName = date('His')."_".rand(1000,9999);
            $upload->subName  = array('date','Ymd');
            $info=$upload->uploadOne($_FILES['Filedata']);
            if (!$info) {
                echo ($upload->getError());
            } else {
                $fname=$info['savepath'].$info['savename'];
                echo $fname;
            }
        }
    }

}