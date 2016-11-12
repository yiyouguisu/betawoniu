<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class InnController extends CommonController {

    public function _initialize(){
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
    }

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
            $searchtype = I('get.searchtype', null, 'intval');
            //搜索关键字
            $keyword = urldecode(I('get.keyword'));
            if (!empty($keyword)) {
                $type_array = array('name', 'description', 'owner');
                if ($searchtype < 3) {
                    $searchtype = $type_array[$searchtype];
                    $where[$searchtype] = array("LIKE", "%{$keyword}%");
                } elseif ($searchtype == 3) {
                    $where["id"] = array("EQ", (int) $keyword);
                }
            }
            //状态
            $status = $_GET["status"];
            if ($status != "" && $status != null) {
                $where["status"] = array("EQ", $status);
            }
        }
        $where['status'] = array("neq",5);
        $count = D("Inn")->where($where)->count();
        $page = new \Think\Page($count, 10);
        $page->setConfig("theme","<span class=\"rows\">当前%NOW_PAGE%/%TOTAL_PAGE%页</span>%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%<span class=\"rows\">共 %TOTAL_ROW% 条记录</span>");
        $page->setConfig("prev","上一页");
        $page->setConfig("next","下一页");
        $page->setConfig("first","第一页");
        $page->setConfig("last","最后一页");
        $data = D("Inn")->where($where)->limit($page->firstRow . ',' . $page->listRows)->order(array("id" => "desc"))->select();
        foreach ($data as $k => $r) {
            $data[$k]["sortname"] = $this->str_cut($r["name"], 30);
        }
        $show = $page->show();
        // var_dump($data);
        $this->assign("data", $data);
        $this->assign("Page", $show);
        $this->display();
    }

    public function setoff(){
        $id = I('id');
        $res = M('inn')->where(array('id'=>$id))->save(array(
                    'status'=>4
                ));
        if($res)
            $this->success('下架成功！');
        else
            $this->error('下架失败！');
    }

    public function seton(){
        $id = I('id');
        $res = M('inn')->where(array('id'=>$id))->save(array(
                    'status'=>2
                ));
        if($res)
            $this->success('启用成功！');
        else
            $this->error('启用失败！');
    }

    public function theme(){
        if($_POST){
            $logo = I('logo');
            $title = I('title');
            $link = I('link');
            $abstract = I('abstract');
            $description = I('description');
            if($logo == '')
                $this->error('logo不能为空!');
            if($description == '')
                $this->error('描述不能为空！');
            if($title == '')
                $this->error('主题不能为空！');
            if($abstract == '')
                $this->error('摘要不能为空！');
            if($link == '')
                $this->error('规则连接不能为空！');
            $res = M('wxactivity')->where(array('status'=>2))->save(array(
                        'logo'=>$logo,
                        'title'=>$title,
                        'description'=>$description,
                        'link'=>$link,
                        'abstract'=>$abstract
                    ));
            if($res)
                $this->success('修改成功！');
            else
                $this->error('修改失败！');
        }else{
            $data = M('wxactivity')->where(array('status'=>2))->find();
            $this->assign('data',$data);
            $this->display();
        }
    }

    /**
     * 编辑民宿
     */
    public function edit() {
        if ($_POST) {
            $id = I('id');
            if(empty($id))
                $this->error("id参数错误！");
           $imglist=  json_encode($_POST["imglist"]);
            $name = I('name');
            $address = I('address');
            $logo = I('logo');
            $description = I('description');
            $ownner = I('ownner');
            $contact = I('contact');
            $isvote = I('isvote');
            $roomnum = I('roomnum');
            $starttime = intval(strtotime(date('Y-m-d 00:00:00',strtotime(I('starttime')))));
            $endtime = intval(strtotime(date('Y-m-d 23:59:59',strtotime(I('endtime')))));
            $prizeArr = array();
            $prizeArrDesc = array();
            $prize1 = I('prize1');
            $prizeArr[0] = $prize1; 
            $prize2 = I('prize2');
            $prizeArr[1] = $prize2; 
            $prize3 = I('prize3');
            $prizeArr[2] = $prize3;
            $prize4 = I('prize4');
            $prizeArr[3] = $prize4; 
            $prize5 = I('prize5');
            $prizeArr[4] = $prize5;  

            $prize1desc = I('prize1desc');
            $prizeArrDesc[0] = $prize1desc;
            $prize2desc = I('prize2desc');
            $prizeArrDesc[1] = $prize2desc;
            $prize3desc = I('prize3desc');
            $prizeArrDesc[2] = $prize3desc;
            $prize4desc = I('prize4desc');
            $prizeArrDesc[3] = $prize4desc;
            $prize5desc = I('prize5desc');
            $prizeArrDesc[4] = $prize5desc;
            
            if(empty($name))
                $this->error("美宿名称不能为空！");
            if(empty($address))
                $this->error("美宿地址不能为空！");
            if(empty($ownner))
                $this->error("美宿主人不能为空！");
            if(empty($contact))
                $this->error("主人联系方式不能为空");
            if(empty($logo))
                $this->error("美宿logo不能为空！");
            if(empty($description))
                $this->error("美宿描述不能为空！");
            if($isvote == 1){
                if(empty($roomnum))
                   $this->error("奖品数量不能为空！");
                if(empty($starttime))
                    $this->error("开始时间不能为空！");
                if(empty($endtime))
                    $this->error("结束时间不能为空！");
                if(empty($prize1desc))
                    $this->error("一等奖不能为空！");
                if(empty($prize2desc))
                    $this->error("二等奖不能为空！");
                if(empty($prize3desc))
                    $this->error("三等奖不能为空！");
                if(empty($prize4desc))
                    $this->error("四等奖不能为空！");
                if(empty($prize5desc))
                    $this->error("五等奖不能为空！");
                if(empty($prize1))
                    $this->error("一等奖数量不能为空！");
                if(empty($prize2))
                    $this->error("二等奖数量不能为空！");
                if(empty($prize3))
                    $this->error("三等奖数量不能为空！");
                if(empty($prize4))
                    $this->error("四等奖数量不能为空！");
                if(empty($prize5))
                    $this->error("五等奖数量不能为空！");
            }
            $data['imglist'] = $imglist;
            // $data['uid'] = $uid;
            $data['name'] = $name;
            $data['address'] = $address;
            $data['logo'] = $logo;
            $data['imglist'] = $imglist;
            $data['description'] = $description;
            $data['ownner'] = $ownner;
            $data['contact'] = $contact;
            $data['isvote'] = $isvote;
            $data['starttime'] = $starttime;
            $data['endtime'] = $endtime;
            $data['roomnum'] = $roomnum;
            $data['status'] = 1;
            $data['inputtime'] = time();
            $data['votenum'] = 0;
            M()->startTrans();
            $flag = true;
            if(M('inn')->where(array('id'=>$id))->find()){
                $result = M('inn')->where(array('id'=>$id))->save($data);
                if($result){
                    if($data['isvote'] == 1){
                        for($i = 1; $i < 6; $i ++){
                            $key = 'prize'.$i;
                            $prize = M('innprize')->data(array('quantity'=>$prizeArr[$i-1],'leftquantity'=>$prizeArr[$i-1],'desc'=>$prizeArrDesc[$i-1]))->where(array('innid'=>$id,'level'=>$i))->save();
                            if(!$prize && $prize != 0)
                                $flag = false;
                        }
                    }
                    if($flag == true){
                        M()->commit();
                        $this->error("修改成功！");
                    }else{
                        M()->rollback();
                        $this->error("修改失败！");
                    }
                }
                else
                    $this->error("修改失败！");
            }
            else
                $this->error("找不到该美宿!");
        } else {
            $id= I('get.id', null, 'intval');
            if (empty($id)) {
                $this->error("ID参数错误");
            }
            $data = M('inn')->where(array('id'=>$id))->find();
            $data['starttime'] = date("Y-m-d",$data['starttime']);
            $data['endtime'] = date("Y-m-d",$data['endtime']);
            $prize = M('innprize')->where(array('innid'=>$id))->select();
            foreach ($prize as $key => $value) {
                # code...
                $res = $key + 1;
                $item = 'prize'.$res;
                $item1 = 'leftprize'.$res;
                $item2 = 'prize'.$res.'desc';
                $data[$item] = $value['quantity'];
                $data[$item1] = $value['leftquantity'];
                $data[$item2] = $value['desc'];
            }
            $this->assign("data", $data);
            $this->assign("imglist",json_decode($data['imglist'],true));
            $this->display();
        }

    }

    /*
     * 添加评选美宿
     */

    public function add() {
        if ($_POST) {
            $imglist=  json_encode($_POST["imglist"]);
            $name = I('name');
            $address = I('address');
            $logo = I('logo');
            $description = I('description');
            $ownner = I('ownner');
            $contact = I('contact');
            $isvote = I('isvote');
            $roomnum = I('roomnum');
            $starttime = intval(strtotime(date('Y-m-d 00:00:00',strtotime(I('starttime')))));
            $endtime = intval(strtotime(date('Y-m-d 23:59:59',strtotime(I('endtime')))));
            $prizeArr = array();
            $prizeArrDesc = array();
            $prize1 = I('prize1');
            $prizeArr[0] = $prize1; 
            $prize2 = I('prize2');
            $prizeArr[1] = $prize2; 
            $prize3 = I('prize3');
            $prizeArr[2] = $prize3;
            $prize4 = I('prize4');
            $prizeArr[3] = $prize4; 
            $prize5 = I('prize5');
            $prizeArr[4] = $prize5; 

            $prize1desc = I('prize1desc');
            $prizeArrDesc[0] = $prize1desc;
            $prize2desc = I('prize2desc');
            $prizeArrDesc[1] = $prize2desc;
            $prize3desc = I('prize3desc');
            $prizeArrDesc[2] = $prize3desc;
            $prize4desc = I('prize4desc');
            $prizeArrDesc[3] = $prize4desc;
            $prize5desc = I('prize5desc');
            $prizeArrDesc[4] = $prize5desc; 
            
            if(empty($name))
                $this->error("美宿名称不能为空！");
            if(empty($address))
                $this->error("美宿地址不能为空！");
            if(empty($ownner))
                $this->error("美宿主人不能为空！");
            if(empty($contact))
                $this->error("主人联系方式不能为空");
            if(empty($logo))
                $this->error("美宿logo不能为空！");
            if(empty($description))
                $this->error("美宿描述不能为空！");
            if($isvote == 1){
                if(empty($roomnum))
                   $this->error("房间数量不能为空！");
                if(empty($starttime))
                    $this->error("开始时间不能为空！");
                if(empty($endtime))
                    $this->error("结束时间不能为空！");
                if(empty($prize1))
                    $this->error("一等奖数量不能为空！");
                if(empty($prize2))
                    $this->error("二等奖数量不能为空！");
                if(empty($prize3))
                    $this->error("三等奖数量不能为空！");
                if(empty($prize4))
                    $this->error("四等奖数量不能为空！");
                if(empty($prize5))
                    $this->error("五等奖数量不能为空！");
                if(empty($prize1)){
                    $this->ajaxReturn(array('code'=>0,'msg'=>'一等奖数量不能为空'),'json');
                }
                if(empty($prize2)){
                    $this->ajaxReturn(array('code'=>0,'msg'=>'二等奖数量不能为空'),'json');
                }
                if(empty($prize3)){
                    $this->ajaxReturn(array('code'=>0,'msg'=>'三等奖数量不能为空'),'json');
                }
                if(empty($prize4)){
                    $this->ajaxReturn(array('code'=>0,'msg'=>'四等奖数量不能为空'),'json');
                }
                if(empty($prize5)){
                    $this->ajaxReturn(array('code'=>0,'msg'=>'五等奖数量不能为空'),'json');
                }
            }
            $data['imglist'] = $imglist;
            // $data['uid'] = $uid;
            $data['name'] = $name;
            $data['address'] = $address;
            $data['logo'] = $logo;
            $data['imglist'] = $imglist;
            $data['description'] = $description;
            $data['ownner'] = $ownner;
            $data['contact'] = $contact;
            $data['isvote'] = $isvote;
            $data['starttime'] = $starttime;
            $data['endtime'] = $endtime;
            $data['roomnum'] = $roomnum;
            $data['status'] = 1;
            $data['inputtime'] = time();
            M()->startTrans();
            $flag = true;
            $id = M('inn')->data($data)->add();
            if($id!==false){
                if($data['isvote'] == 1){
                    for($i = 1; $i < 6; $i ++){
                        $key = 'prize'.$i;
                        $prize = M('innprize')->data(array('innid'=>$id,'quantity'=>$prizeArr[$i-1],'leftquantity'=>$prizeArr[$i-1],'level'=>$i,'desc'=>$prizeArrDesc[$i-1]))->add();
                        if(!$prize)
                            $flag = false;
                    }
                }
                if($flag == true){
                    M()->commit();
                    $this->error("添加成功！");
                }else{
                    M()->rollback();
                   $this->error("添加失败！");
                }
            }else{
                $this->error("添加失败！");
            }
        } else {
            $this->display();
        }
    }

    /*
     * 操作判断
     */

    public function action() {
        $submit = trim($_POST["submit"]);
        if ($submit == "review") {
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
        $did=M("Inn")->where(array('id'=>$id))->save(array('status'=>5));
        if ($did) {
            $this->success("删除美宿成功！");
        } else {
            $this->error("删除美宿失败！");
        }
    }

    /*
     * 删除民宿
     */

    public function del() {
        if (IS_POST) {
            if (empty($_POST['ids'])) {
                $this->error("没有信息被选中！");
            }
            foreach ($_POST['ids'] as $id) {
                M("House")->where(array('id'=>$id))->save(array('isdel'=>1,'deletetime'=>time()));
            }
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /*
     * 
     */

    public function review() {
        if (IS_POST) {
            $status = I('status');
            $innid = I('innid');
            $remark = I('remark');
            if(empty($innid))
                $this->error("系统错误！");
            if(empty($status))
                $this->error("请选择审核结果!");
            if($status != 2 && $status != 3)
                $this->error("请正确选择审核结果");
            $inn = M('inn')->where(array('id'=>$innid))->find();
            if($inn['status'] != 1)
                $this->error("不能重复审核！");
            if($inn){
                $res = M('inn')->where(array('id'=>$innid))->save(array(
                            'status'=>$status
                        ));
                if($res){
                    $this->success("审核成功！", U("Admin/Inn/index"));
                }
                else
                    $this->error("审核发生错误！");
            }else{
                $this->error("查找美宿发生错误！");
            }
        } else {
            $id=I('id');
            $data=M('inn')->where(array('id'=>$id))->find();
            // var_dump($data);
            $this->assign("data",$data);
            $this->display();
        }
    }

}