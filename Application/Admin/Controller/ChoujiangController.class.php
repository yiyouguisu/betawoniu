<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class ChoujiangController extends CommonController {

    public function index() {
        $search = I('get.search');
        $where = array();
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["inputtime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            //搜索字段
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                if ($searchtype < 3) {
                    $where["rid"] = array("EQ", (int) $keyword);
                } elseif ($searchtype == 3) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
        }
        $where['voteresult'] = array('neq', 6);
        $count = D("innvotelog")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $data = D("innvotelog")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["prize"] = M('gift')->where(array('rank'=>$r['voteresult']))->getField("prize");
            $data[$k]['innname'] = M('inn')->where(array('id'=>$r['innid']))->getField('name');
            // $data[$k]['username'] = M('member')->where(array('id'=>$value['uid']))->getField('nickname');
        }
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->assign("searchtype", $searchtype);

        $this->display();
    }   

    /**
     * 数据导出
     * 
     */
    public function excel() {
        $data = M('Choujianglog')->select();
        foreach ($data as $key => $value) {
            # code...
            if($value['rid']==1){
                $data[$key]['rid']="一等奖";
            }elseif($value['rid']==2){
                $data[$key]['rid']="二等奖";
            }elseif($value['rid']==3){
                $data[$key]['rid']="三等奖";
            }elseif($value['rid']==4){
                $data[$key]['rid']="幸运奖";
            }elseif($value['rid']==5){
                $data[$key]['rid']="谢谢参与";
            }
            $data[$key]['inputtime']=date("Y-m-d H:i:s",$value['inputtime']);
            
        }
        exportexcel($data ,array('id','中奖等级','手机号码','中奖时间'),'中奖结果表');
    }

    /**
     * 编辑内容
     */
    public function add() {
        if ($_POST) {
            if (D("Choujianglog")->create()) {
                D("Choujianglog")->inputtime = time();
                $id = D("Choujianglog")->add();
                if (!empty($id)) {
                    $this->success("添加内容成功！", U("Admin/Choujiang/index"));
                } else {
                    $this->error("添加内容失败！");
                }
            } else {
                $this->error(D("Choujianglog")->getError());
            }
        } else {
          $this->display();
        }
        
    }
    /**
     * 编辑内容
     */
    public function edit() {
        if ($_POST) {
            if (D("Choujianglog")->create()) {
                $id = D("Choujianglog")->save();
                if (!empty($id)) {
                    $this->success("修改内容成功！", U("Admin/Choujiang/index"));
                } else {
                    $this->error("修改内容失败！");
                }
            } else {
                $this->error(D("Choujianglog")->getError());
            }
        } else {
             $id= I('get.id', null, 'intval');
         if (empty($id)) {
                $this->error("ID参数错误");
          }
        $data=D("Choujianglog")->where("id=".$id)->find();     
        $this->assign("data", $data);
          $this->display();
        }
        
    }
    /**
     *  删除
     */
    public function delete() {
        $id = $_GET['id'];
        if (D("Choujianglog")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    
}