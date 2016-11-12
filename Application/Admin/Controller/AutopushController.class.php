<?php

namespace Admin\Controller;

use Admin\Common\CommonController;

class AutopushController extends CommonController {
    public function _initialize() {
        $this->userid=!empty($_SESSION['userid'])? $_SESSION['userid'] : 1;
        
        $time=time();
        $this->starttime=mktime(0,0,0,intval(date("m",$time)),intval(date("d",$time)),intval(date("Y",$time)));
        $this->endtime=mktime(23,59,59,intval(date("m",$time)),intval(date("d",$time)),intval(date("Y",$time)));
    }

    public function today_weblog() {
        $endSig = "\n\n";
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $time = date('r');
        $response = array(
            'users'=>$this->users(),
            'hostelorder' => $this->hostelorder(),
            'partyorder' => $this->partyorder(),
            'waitchecknote' => $this->waitchecknote(),
            'waitcheckparty' => $this->waitcheckparty(),
            'waitcheckhostel' => $this->waitcheckhostel(),
            'realname' => $this->realname(),
            'houseowner' => $this->houseowner(),
            'withdraw' => $this->withdraw()
        );
        $res = json_encode($response);
        echo "data:{$res}{$endSig}";
        flush();
    }
    protected function users() {
        $where['reg_time']=array(array('EGT', $this->starttime), array('ELT', $this->endtime));
        $where['group_id']=1;
        $data=M('member')->where($where)->count();
        return intval($data);
    }
    protected function hostelorder() {
        $where['inputtime']=array(array('EGT', $this->starttime), array('ELT', $this->endtime));
        $where['ordertype']=1;
        $count=M('order')->where($where)->count();
        $money=M('order')->where($where)->sum("total");
        $data = array(
          'count' => intval($count),
          'money' => sprintf("%.2f",floatval($money))
        );
        return $data;
    }
    protected function partyorder() {
        $where['inputtime']=array(array('EGT', $this->starttime), array('ELT', $this->endtime));
        $where['ordertype']=2;
        $count=M('order')->where($where)->count();
        $money=M('order')->where($where)->sum("total");
        $data = array(
          'count' => intval($count),
          'money' => sprintf("%.2f",floatval($money))
        );
        return $data;
    }
    protected function waitchecknote() {
        $where['status']=1;
        $where['inputtime']=array(array('EGT', $this->starttime), array('ELT', $this->endtime));
        $data = M("note")->where($where)->count();
        return intval($data);
    }
    protected function waitcheckparty() {
        $where['status']=1;
        $where['inputtime']=array(array('EGT', $this->starttime), array('ELT', $this->endtime));
        $data = M("party")->where($where)->count();
        return intval($data);
    }
    protected function waitcheckhostel() {
        $where['status']=1;
        $where['inputtime']=array(array('EGT', $this->starttime), array('ELT', $this->endtime));
        $data = M("hostel")->where($where)->count();
        return intval($data);
    }
    protected function realname() {
        $where['status']=1;
        $where['inputtime']=array(array('EGT', $this->starttime), array('ELT', $endtime));
        $data = M("realname_apply")->where($where)->count();
        return intval($data);
    }
    protected function houseowner() {
        $where['status']=1;
        $where['inputtime']=array(array('EGT', $this->starttime), array('ELT', $this->endtime));
        $data = M("houseowner_apply")->where($where)->count();
        return intval($data);
    }
    protected function withdraw() {
        $where['status']=1;
        $where['inputtime']=array(array('EGT', $this->starttime), array('ELT', $this->endtime));
        $data = M("withdraw")->where($where)->count();
        return intval($data);
    }
}