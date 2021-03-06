<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class CouponsController extends CommonController {

    public function index() {
        $search = I('get.search');
        $where = array();
        $where['type']=array('neq',6);
        if (!empty($search)) {
            //状态
            $status = $_GET["status"];
            if ($status != "" && $status != null) {
                $where["status"] = array("EQ", $status);
            }
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            $where['title'] = array("LIKE", "%{$keyword}%");
        }

        $count = D("Coupons")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("Coupons")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
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
            if (D("Coupons")->create()) {
                D("Coupons")->validity_starttime=strtotime($_POST['validity_starttime']);
                D("Coupons")->validity_endtime=strtotime($_POST['validity_endtime']);
                D("Coupons")->hid = implode(",",$_POST['hid']);
                D("Coupons")->updatetime = time();
                $id = D("Coupons")->save();
                if (!empty($id)) {
                    $this->success("修改优惠券成功！", U("Admin/Coupons/index"));
                } else {
                    $this->error("修改优惠券失败！");
                }
            } else {
                $this->error(D("Coupons")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("ID参数错误");
            }
            $data=D("Coupons")->where("id=".$id)->find();
            $data['validity_starttime']=date("Y-m-d H:i:s",$data['validity_starttime']);
            $data['validity_endtime']=date("Y-m-d H:i:s",$data['validity_endtime']);
            $this->assign("data", $data);

            $tree = new \Think\Tree();
            $catid = $data['catid'];
            $result = $this->productcate;
            foreach ($result as $r) {
                $r['selected'] = $r['id'] == $catid ? 'selected' : '';
                if ($r['parentid'] == '0') {
                    $array[] = $r;
                }
            }
            $str = "<option value='\$id' \$selected \$disabled>\$spacer \$catname</option>";
            $tree->init($array);
            $select_Productcates = $tree->get_tree(0, $str);
            $this->assign("category", $select_Productcates);
            $shop=M('house')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->limit(16)->select();
            foreach ($shop as $k=> $r)
            {
            	if(in_array($r['id'],explode(",",$data['hid']))){
                    $shop[$k]['ischeck']=1;
                }else{
                    $shop[$k]['ischeck']=0;
                }
            }
            $this->assign("shop",$shop);
            $this->display();
        }

    }

    /*
     * 添加内容
     */

    public function add() {
        if ($_POST) {
            if (D("Coupons")->create()) {
                D("Coupons")->validity_starttime=strtotime($_POST['validity_starttime']);
                D("Coupons")->validity_endtime=strtotime($_POST['validity_endtime']);
                D("Coupons")->inputtime = time();
                D("Coupons")->hid = implode(",",$_POST['hid']);
                D("Coupons")->username = $_SESSION['user'];
                $id = D("Coupons")->add();
                if (!empty($id)) {
                    $this->success("新增优惠券成功！", U("Admin/Coupons/index"));
                } else {
                    $this->error("新增优惠券失败！");
                }
            } else {
                $this->error(D("Coupons")->getError());
            }
        } else {
            $tree = new \Think\Tree();
            $catid = $data['catid'];
            $result =$this->productcate;
            foreach ($result as $r) {
                $r['selected'] = $r['id'] == $catid ? 'selected' : '';
                if ($r['parentid'] == '0') {
                    $array[] = $r;
                }
            }
            $str = "<option value='\$id' \$selected \$disabled>\$spacer \$catname</option>";
            $tree->init($array);
            $select_Productcates = $tree->get_tree(0, $str);
            $this->assign("category", $select_Productcates);
            $shop=M('house')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->limit(16)->select();
            $this->assign("shop",$shop);
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
        } elseif ($submit == "review") {
            $this->review();
        } elseif ($submit == "unreview") {
            $this->unreview();
        }
    }

    /**
     *  删除
     */
    public function delete() {
        $id = $_GET['id'];
        if (D("Coupons")->delete($id)) {
            $this->success("删除优惠券成功！");
        } else {
            $this->error("删除优惠券失败！");
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
                M("Coupons")->delete($id);
            }
            $this->success("删除优惠券成功！");
        } else {
            $this->error("删除优惠券失败！");
        }
    }

    /*
     * 内容审核
     */

    public function review() {
        $data['status'] = 1;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Coupons")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }

    /*
     * 内容取消审核
     */

    public function unreview() {
        $data['status'] = 0;
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("Coupons")->where(array("id" => $id))->save($data);
            }
            $this->success("审核成功！");
        } else {
            $this->error("审核失败！");
        }
    }


    /*
     * 内容排序
     */
    public function listorder() {
        $listorders = $_POST['listorders'];
        $pk = D("Coupons")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Coupons")->where(array($pk => $key))->save($data);
        }
        if ($status !== false) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
    public  function send(){
        $catid=I("catid",0,intval);
        if (IS_POST) {
            if(empty($_POST['num'])){
                $this->error("发放数量不能为空！");
            }
            $uids=array();
            if($_POST['scale']==1){
                $uids=M('member')->where(array('status'=>1,'group_id'=>1))->getField("id",true);
            }elseif($_POST['scale']==2){
                if(empty($_POST['preference'])){
                    $this->error("请先选择偏向属性！");
                }
                $preference=$_POST['preference'];
                foreach ($preference as $value) {
                    # code...
                    $uidss=M('member')->where(array('status'=>1,'group_id'=>1,'preference'=>array('like',"%".$value."%")))->getField("id",true);
                    $uids=array_merge($uidss,$uids);
                }
                $uids=array_unique($uids);
            }elseif($_POST['scale']==3){
                if(empty($_POST['name'])){
                    $this->error("用户名或手机号码不能为空！");
                }
                $uids=M('member')->where(array('username|phone'=>$_POST['name']))->getField("id",true);
            }elseif($_POST['scale']==4){
                if(empty($_POST['level'])){
                    $this->error("请先选择用户级别！");
                }
                $uids=getuid_level($_POST['level']);
            }
            $coupons= M("Coupons")->where(array('id'=>$catid))->find();
            foreach ($uids as $value)
            {
                for ($i = 0; $i < $_POST['num']; $i++)
                {
                    $cids=M("coupons_order")->add(array(
                        'catid'=>$_POST['catid'],
                        'uid'=>$value,
                        'num'=>1,
                        'status'=>0,
                        'inputtime'=>time(),
                        'updatetime'=>time()
                        ));
                    M('coupons_log')->add(array(
                        'uid'=>$value,
                        'money'=>$coupons['price'],
                        'addtime'=>time(),
                        'addip'=>get_client_ip(),
                        'status'=>1,
                        'dcflag'=>1,
                        'remark'=>"管理员奖励"
                        ));
                    $cid[]=$cids;
                }

            }
            if(!empty($cid)){
                $this->success("发放成功！", U("Admin/Coupons/index"));
            }else{
                $this->error("发放失败！");
            }
        } else {
            $data= M("Coupons")->where(array('id'=>$catid))->find();
            $this->assign("data",$data);
            $levelConfig = F("levelConfig",'',CACHEDATA_PATH);
            $this->assign("levelConfig", $levelConfig);
            $this->display();
        }
    }
    public function ajax_getmore(){
        $hid=I('pid');
        $hidbox=explode(",",$hid);
        $where = array();
        $where['isdel']=0;
        $count = D("House")->where($where)->count();
        $page = new \Think\Page($count, 16);
        $data = D("House")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortitle"] = $this->str_cut($r["title"], 30);
            if(!empty($hidbox)&&in_array($r['id'],$hidbox)){
                $data[$k]['ischeck']=1;
            }else{
                $data[$k]['ischeck']=0;
            }
        }
        $this->ajaxReturn($data,'json');
    }

}