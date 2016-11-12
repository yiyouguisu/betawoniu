<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class VouchersController extends CommonController {

    public function index() {
        $search = I('get.search');
        $where = array();
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

        $count = D("Vouchers")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("Vouchers")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
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
            if (D("Vouchers")->create()) {
                D("Vouchers")->validity_starttime=strtotime($_POST['validity_starttime']);
                D("Vouchers")->validity_endtime=strtotime($_POST['validity_endtime']);
                D("Vouchers")->hid = implode(",",$_POST['hid']);
                D("Vouchers")->aid = implode(",",$_POST['aid']);
                D("Vouchers")->city = $_POST['city'];
                D("Vouchers")->username = $_SESSION['user'];
                D("Vouchers")->updatetime = time();
                $id = D("Vouchers")->save();
                if (!empty($id)) {
                    $this->success("修改优惠券成功！", U("Admin/Vouchers/index"));
                } else {
                    $this->error("修改优惠券失败！");
                }
            } else {
                $this->error(D("Vouchers")->getError());
            }
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("ID参数错误");
            }
            $data=D("Vouchers")->where("id=".$id)->find();
            $data['validity_starttime']=date("Y-m-d",$data['validity_starttime']);
            $data['validity_endtime']=date("Y-m-d",$data['validity_endtime']);
            $this->assign("data", $data);

            $ids=M('area')->where(array('parentid'=>0,'id'=>array('not in','2,3,4,5')))->getField("id",true);
            $map['parentid']  = array("in",$ids);
            $map['id']  = array('in','2,3,4,5');
            $map['_logic'] = 'or';
            $where['_complex'] = $map;
            $city = M("area")->where($where)->select();
            $this->assign("city",$city);
            $hostel=M('Hostel')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->limit(16)->select();
            foreach ($hostel as $k=> $r)
            {
                if(in_array($r['id'],explode(",",$data['hid']))){
                    $hostel[$k]['ischeck']=1;
                }else{
                    $hostel[$k]['ischeck']=0;
                }
            }
            $this->assign("hostel",$hostel);
            $party=M('Activity')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->limit(16)->select();
            foreach ($party as $k=> $r)
            {
                if(in_array($r['id'],explode(",",$data['aid']))){
                    $party[$k]['ischeck']=1;
                }else{
                    $party[$k]['ischeck']=0;
                }
            }
            $this->assign("party",$party);
            $this->display();
        }

    }

    /*
     * 添加内容
     */

    public function add() {
        if ($_POST) {
            if (D("Vouchers")->create()) {
                D("Vouchers")->validity_starttime=strtotime($_POST['validity_starttime']);
                D("Vouchers")->validity_endtime=strtotime($_POST['validity_endtime']);
                D("Vouchers")->inputtime = time();
                D("Vouchers")->hid = implode(",",$_POST['hid']);
                D("Vouchers")->aid = implode(",",$_POST['aid']);
                D("Vouchers")->city = $_POST['city'];
                D("Vouchers")->username = $_SESSION['user'];
                $id = D("Vouchers")->add();
                if (!empty($id)) {
                    $this->success("新增优惠券成功！", U("Admin/Vouchers/index"));
                } else {
                    $this->error("新增优惠券失败！");
                }
            } else {
                $this->error(D("Vouchers")->getError());
            }
        } else {
            $ids=M('area')->where(array('parentid'=>0,'id'=>array('not in','2,3,4,5')))->getField("id",true);
            $map['parentid']  = array("in",$ids);
            $map['id']  = array('in','2,3,4,5');
            $map['_logic'] = 'or';
            $where['_complex'] = $map;
            $city = M("area")->where($where)->select();
            $this->assign("city",$city);
            $hostel=M('Hostel')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->limit(16)->select();
            $this->assign("hostel",$hostel);
            $party=M('Activity')->where(array('status'=>2,'isdel'=>0))->order(array('listorder'=>'desc','id'=>'desc'))->limit(16)->select();
            $this->assign("party",$party);
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
        if (D("Vouchers")->delete($id)) {
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
                M("Vouchers")->delete($id);
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
                M("Vouchers")->where(array("id" => $id))->save($data);
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
                M("Vouchers")->where(array("id" => $id))->save($data);
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
        $pk = D("Vouchers")->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $status = D("Vouchers")->where(array($pk => $key))->save($data);
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
                $uids=M('member')->where(array('status'=>1))->getField("id",true);
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

                $uids=M('member')->where(array('username|phone|nickname'=>array('in',$_POST['name'])))->getField("id",true);
            }elseif($_POST['scale']==4){
                if(empty($_POST['level'])){
                    $this->error("请先选择用户级别！");
                }
                $uids=getuid_level($_POST['level']);
            }
            $Vouchers= M("Vouchers")->where(array('id'=>$catid))->find();
            foreach ($uids as $value)
            {
                for ($i = 0; $i < $_POST['num']; $i++)
                {
                    $cids=M("Vouchers_order")->add(array(
                        'catid'=>$_POST['catid'],
                        'uid'=>$value,
                        'num'=>1,
                        'price'=>$Vouchers['price'],
                        'hid'=>$Vouchers['hid'],
                        'aid'=>$Vouchers['aid'],
                        'status'=>0,
                        'inputtime'=>time(),
                        'updatetime'=>time()
                        ));
                    $cid[]=$cids;
                    \Api\Controller\UtilController::addmessage($value,"获取优惠券","恭喜您，获得我们的优惠券！","恭喜您，获得我们的优惠券！","getcoupons",$cids);
                }

            }
            if(!empty($cid)){
                $this->success("发放成功！", U("Admin/Vouchers/index"));
            }else{
                $this->error("发放失败！");
            }
        } else {
            $data= M("Vouchers")->where(array('id'=>$catid))->find();
            $data['cityname']=M('area')->where(array('id'=>$data['city']))->getField("name");
            $data['hostel']=M('hostel')->where(array('id'=>array('in',trim($data['hid']))))->select();
            $data['party']=M('Activity')->where(array('id'=>array('in',trim($data['aid']))))->select();
            $this->assign("data",$data);
            // $levelConfig = F("levelConfig",'',CACHEDATA_PATH);
            // $this->assign("levelConfig", $levelConfig);
            $this->display();
        }
    }
    public function ajax_getmorehostel(){
        $hid=I('hid');
        $hidbox=explode(",",$hid);
        $where = array();
        $where['isdel']=0;
        $where['status']=2;
        $count = D("Hostel")->where($where)->count();
        $page = new \Think\Page($count, 16);
        $data = D("Hostel")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
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
    public function ajax_getmoreparty(){
        $aid=I('aid');
        $hidbox=explode(",",$aid);
        $where = array();
        $where['isdel']=0;
        $where['status']=2;
        $count = D("Activity")->where($where)->count();
        $page = new \Think\Page($count, 16);
        $data = D("Activity")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("listorder" => "desc","id" => "desc"))->select();
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
    public function sendlog() {
        $catid=I('id');
        $search = I('get.search');
        $where = array();
        $where['catid']=$catid;
        if (!empty($search)) {
            //添加开始时间
            $start_time = I('get.start_time');
            if (!empty($start_time)) {
                $start_time = strtotime($start_time);
                $where["a.inputtime"] = array("EGT", $start_time);
            }
            //添加结束时间
            $end_time = I('get.end_time');
            if (!empty($end_time)) {
                $end_time = strtotime($end_time);
                $where["a.inputtime"] = array("ELT", $end_time);
            }
            if ($end_time > 0 && $start_time > 0) {
                $where['a.inputtime'] = array(array('EGT', $start_time), array('ELT', $end_time));
            }
        }
    
        $count = D("vouchers_order a")->join("left join zz_vouchers b on a.catid=b.id")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("vouchers_order a")
        ->join("left join zz_vouchers b on a.catid=b.id")
        ->join("left join zz_member c on a.uid=c.id")
        ->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("a.id" => "desc"))->field("a.*,b.title,b.validity_starttime,b.validity_endtime,c.nickname,c.phone")->select();
        $show = $page->show();
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }
    public function deletelog() {
        $id = $_GET['id'];
        if (D("vouchers_order")->delete($id)) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
    public function dellog(){
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("vouchers_order")->delete($id);
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
}
