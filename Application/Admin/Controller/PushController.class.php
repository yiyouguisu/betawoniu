<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class PushController extends CommonController {
    public function _initialize() {     
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
        $this->storeid=!empty($_SESSION['storeid'])? $_SESSION['storeid'] : 0;
    }
    public function index() {
        $search = I('post.search');
        $where = array();
        $where['isadmin']=1;
        $where['username']=array('eq',$_SESSION['user']);
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('post.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["inputtime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('post.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
            //状态
            $status = $_POST["status"];
            if ($status != "" && $status != null) {
                $where["status"] = array("EQ", $status);
            }
            //搜索关键字
            $keyword = I('post.keyword');
            if(!empty($keyword)){
                $where["title"] = array("like", "%{$keyword}%");
            }
        }
        $count = M("push")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = M("push")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);

        $this->display();
    }


    /**
     *  删除
     */
    public function delete() {
        $id = $_GET['id'];
        if (D("Push")->delete($id)) {
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
                M("Push")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    
    public function add() {
        if(IS_POST){
            if (D("Push")->create()) {
                D("Push")->isadmin = 1;
                D("Push")->inputtime = time();
                D("Push")->username = $_SESSION['user'];
                $mid = D("Push")->add();
                if ($mid) {
                    $uids=array();
                    if($_POST['scale']==1){
                        $uids=M('member')->where(array('status'=>1))->getField("id",true);
                    }elseif($_POST['scale']==3){
                        $uids=M('member')->where(array('username|phone'=>array('in',$_POST['name'])))->getField("id",true);
                    }
                    $message_type="imagetext";
                    $value=C("WEB_URL")."/index.php/Web/Index/pushview/id/".$mid.".html";
                    $num=count($uids);
                    $i=0;
                    $j=1;
                    do
                    {
                        $registration_id=M('member')->where(array('id'=>array('in',$uids)))->page($j,1000)->getField("deviceToken",true);
                        $receiver = implode(",", array_filter($registration_id));//接收者
                        $extras = array("value"=>$value,'varname'=>$message_type);
                        if(!empty($receiver)){
                            \Api\Controller\UtilController::PushQueue($mid,$message_type,$receiver, $_POST['title'], $_POST['description'], serialize($extras));
                        }
                        $j++;
                        $i=$i+1000;
                    }while ($i<=$num);
                    $this->success("新增推送消息成功！", U("Admin/Push/index"));
                } else {
                    $this->error("新增推送消息失败！");
                }
            } else {
                $this->error(D("Push")->getError());
            }
        }else{
            $this->display();
        }
    }
    public function pushagain() {
        $id=I('get.id',0,intval);
        if(empty($id)||$id==0){
            $this->error("参数错误");
        }
        $data=M('push')->where(array('id'=>$id))->find();
        $data['status']=1;
        unset($data['id']);
        unset($data['inputtime']);
        $data['inputtime']=time();
        $mid = M("Push")->add($data);
        if ($mid) {
            $uids=array();
            $pushinfo=M('sendpush_queue')->where(array('mid'=>$id))->find();
            if(!empty($data['scale'])){
                if($data['scale']==1){
                    $uids=M('member')->where(array('status'=>1))->getField("id",true);
                }elseif($data['scale']==3){
                    $uids=M('member')->where(array('username|phone'=>array('in',$data['name'])))->getField("id",true);
                }
                $num=count($uids);
                $i=0;
                $j=1;
                do
                {
                    $registration_id=M('member')->where(array('id'=>array('in',$uids)))->page($j,1000)->getField("deviceToken",true);
                    $receiver = implode(",", array_filter($registration_id));//接收者
                    if(!empty($receiver)){
                        \Api\Controller\UtilController::PushQueue($mid,$pushinfo['varname'],$receiver, $pushinfo['title'],$pushinfo['description'], $pushinfo['extras']);
                    }
                    $j++;
                    $i=$i+1000;
                }while ($i<=$num);
            }else{
                PushQueue($mid,$pushinfo['varname'],$pushinfo['receiver'], $pushinfo['title'], $pushinfo['description'], $pushinfo['extras']);
            }
            $this->success("再次推送消息成功！", U("Admin/Push/index"));
        } else {
            $this->error("再次推送消息失败！");
        }
    }
   
}