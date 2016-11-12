<?php

namespace Api\Controller;

use Api\Common\CommonController;

class TripController extends CommonController
{
    /**
     *获取公开行程列表
     */
    public function get_trip()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $uid = intval(trim($ret['uid']));
        $p = intval(trim($ret['p']));
        $num = intval(trim($ret['num']));

        if ($p == '' || $num == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } else {
            $where = array();
            $order = array('a.id' => 'desc');
            $where['a.ispublic'] = 1;
            $where['a.isdel'] = 0;
            $sqlI = M('review')
              ->where(array('isdel' => 0, 'varname' => 'trip'))
              ->group("value")
              ->field("value,count(value) as reviewnum")
              ->buildSql();
            $data = M("Trip a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.description,a.starttime,a.endtime,a.days,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->page($p, $num)
                ->select();
            foreach ($data as $key => $value) {
                if (empty($value['reviewnum'])) $data[$key]['reviewnum'] = 0;
                $reviewlist = M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value' => $value['id'], 'a.isdel' => 0, 'a.varname' => 'trip'))->field("a.id as vid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->select();
                $data[$key]['reviewlist'] = !empty($reviewlist) ? $reviewlist : "";
                // $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$value['id']))->find();
                // if(!empty($collectstatus)){
                //     $data[$key]['iscollect']=1;
                // }else{
                //     $data[$key]['iscollect']=0;
                // }
                $hitstatus = M('hit')->where(array('uid' => $uid, 'varname' => "trip", 'value' => $value['id']))->find();
                if (!empty($hitstatus)) {
                    $data[$key]['ishit'] = 1;
                } else {
                    $data[$key]['ishit'] = 0;
                }
                //支付状态
                $tripinfo = M('tripinfo')->find($tid);
                $ordertime = M('order_time')->where(['orderid' => $tripinfo['orderid']])->find();
               // $data['paystatus'] = $ordertime['pay_status'];
            }
            if ($data) {
                exit(json_encode(array('code' => 200, 'msg' => "加载成功", 'data' => $data)));
            } else {
                exit(json_encode(array('code' => -201, 'msg' => "无符合要求数据")));
            }
        }
    }

    /**
     *获取我的行程列表
     */
    public function get_mytrip()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $uid = intval(trim($ret['uid']));
        $p = intval(trim($ret['p']));
        $num = intval(trim($ret['num']));

        if ($uid == '' || $p == '' || $num == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } else {
            $where = array();
            $order = array('a.id' => 'desc');
            $where['a.uid'] = $uid;
            $where['a.isdel'] = 0;
            $sqlI = M('review')->where(array('isdel' => 0, 'varname' => 'trip'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $count = M("Trip a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)->count();
            $list = M("Trip a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
                ->order($order)
                ->field('a.id,a.title,a.description,a.starttime,a.endtime,a.days,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->page($p, $num)->select();
            foreach ($list as $key => $value) {
                if (empty($value['reviewnum'])) $list[$key]['reviewnum'] = 0;
                //支付状态
                $tripinfo = M('tripinfo')->find($value['id']);
                $ordertime = M('order_time')->where(['orderid' => $tripinfo['orderid']])->find();
                $list[$key]['paystatus'] = empty($ordertime)?0:$ordertime['pay_status'];
            }
            $data = array('num' => $count, 'data' => $list);
            if ($data) {
                exit(json_encode(array('code' => 200, 'msg' => "加载成功", 'data' => $data)));
            } else {
                exit(json_encode(array('code' => -201, 'msg' => "无符合要求数据")));
            }
        }
    }

    /**
     *行程详情
     */
    public function show()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $id = intval(trim($ret['id']));
        $uid = intval(trim($ret['uid']));
        if ($id == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } else {
            $sqlI = M('review')->where(array('isdel' => 0, 'varname' => 'trip'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
            $data = M("Trip a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where(array('a.id' => $id))
                ->field('a.id,a.title,a.description,a.starttime,a.endtime,a.days,a.ispublic,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,c.reviewnum')
                ->find();
            $event = M('tripinfo')->where(array('tid' => $id))->order(array('day' => 'asc', 'city' => 'asc', 'listorder' => 'asc'))->find();
            if ($event['varname'] == 'hostel') {
                $data['thumb'] = M('hostel')->where(array('id' => $event['eventid']))->getField("thumb");
            } elseif ($event['varname'] == 'party') {
                $data['thumb'] = M('activity')->where(array('id' => $event['eventid']))->getField("thumb");
            }

            $tripinfo = M('tripinfo')->where(array('tid' => $id))->group("day")->order(array('day' => 'asc'))->field("day,date,money")->select();
            foreach ($tripinfo as $key => $value) {
                # code..
                $eventcity = M('tripinfo')->where(array('tid' => $id, 'day' => $value['day']))->group("city")->order(array('city' => 'asc'))->field("city,cityname,place")->select();
                foreach ($eventcity as $ke => $valu) {
                    # code...
                    $event = M('tripinfo')->where(array('tid' => $id, 'day' => $value['day'], 'city' => $valu['city']))->order(array('listorder' => 'asc'))->field("orderid,place,event,varname,eventid,listorder")->select();
                    foreach ($event as $k => $val) {
                        # code...
                        $paystatus = M('order_time')->where(array('orderid' => $val['orderid']))->getField("pay_status");
                        $event[$k]['paystatus'] = !empty($paystatus) ? $paystatus : 0;
                        if ($val['varname'] == 'hostel') {
                            $event[$k]['uid'] = M('hostel')->where(array('id' => $val['eventid']))->getField("uid");
                        } elseif ($val['varname'] == 'party') {
                            $event[$k]['uid'] = M('activity')->where(array('id' => $val['eventid']))->getField("uid");
                        }
                    }
                    $eventcity[$ke]['event'] = $event;
                }
                $tripinfo[$key]['eventcity'] = $eventcity;

            }
            $data['tripinfo'] = !empty($tripinfo) ? $tripinfo : null;

            if (empty($data['reviewnum'])) $data['reviewnum'] = 0;
            $reviewlist = M('review a')->join("left join zz_member b on a.uid=b.id")->where(array('a.value' => $data['id'], 'a.isdel' => 0, 'a.varname' => 'trip'))->field("a.id as rid,a.content,a.inputtime,b.id as uid,b.nickname,b.head,b.rongyun_token")->order(array('a.id' => 'desc'))->limit(10)->select();
            $data['reviewlist'] = !empty($reviewlist) ? $reviewlist : null;
            // $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"trip",'value'=>$data['id']))->find();
            // !empty($collectstatus)?$data['iscollect']=1:$data['iscollect']=0;

            $hitstatus = M('hit')->where(array('uid' => $uid, 'varname' => "trip", 'value' => $data['id']))->find();
            !empty($hitstatus) ? $data['ishit'] = 1 : $data['ishit'] = 0;

            if ($data) {
                exit(json_encode(array('code' => 200, 'msg' => "加载成功", 'data' => $data)));
            } else {
                exit(json_encode(array('code' => -200, 'msg' => "获取游记详情失败")));
            }
        }
    }

    /**
     *规划行程
     */
    public function add()
    {
        $ret = file_get_contents("php://input");
        $ret = json_decode($ret, true);
        $uid = intval(trim($ret['uid']));
        $title = trim($ret['title']);
        $starttime = intval(trim($ret['starttime']));
        $endtime = intval(trim($ret['endtime']));
        $days = intval(trim($ret['days']));
        $money = floatval(trim($ret['money']));
        $ispublic = intval(trim($ret['ispublic']));
        $tripinfo = $ret['tripinfo'];

        $user = M('Member')->where(array('id' => $uid))->find();
        if ($uid == '' || $title == '' || $starttime == '' || $endtime == '' || $days == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } else {
            $data['uid'] = $uid;
            $data['username'] = $user['nickname'];
            $data['title'] = $title;
            $data['description'] = $description;
            $data['starttime'] = $starttime;
            $data['endtime'] = $endtime;
            $data['days'] = $days;
            $data['money'] = $money;
            $data['ispublic'] = $ispublic;
            $data['inputtime'] = time();
            $data['updatetime'] = time();
            $id = M("trip")->add($data);
            if ($id) {
                $citynamearray = array();
                foreach ($tripinfo as $value) {
                    # code...
                    $orderid = "";
                    if (trim($value['varname']) == 'party') {
                        $orderid = "ac" . date("YmdHis", time()) . rand(100, 999);
                    } elseif (trim($value['varname']) == 'hostel') {
                        $orderid = "hc" . date("YmdHis", time()) . rand(100, 999);
                    }
                    $cityname = M('area')->where(array('id' => $value['city']))->getField("name");
                    $citynamearray[] = $cityname;
                    M('tripinfo')->add(array(
                        'tid' => $id,
                        'orderid' => $orderid,
                        'day' => intval(trim($value['day'])),
                        'city' => intval(trim($value['city'])),
                        'cityname' => $cityname,
                        'place' => trim($value['place']),
                        'event' => trim($value['event']),
                        'varname' => trim($value['varname']),
                        'eventid' => intval(trim($value['eventid'])),
                        'listorder' => intval(trim($value['listorder'])),
                        'date' => intval(trim($value['date'])),
                        'money' => floatval(trim($value['money']))
                    ));
                }
                if ($citynamearray) {
                    $citynamearray = array_unique($citynamearray);
                    $description = implode(",", $citynamearray) . $days . "日游";
                    M("trip")->where(array('id' => $id))->setField("description", $description);
                }
                exit(json_encode(array('code' => 200, 'msg' => "提交成功")));
            } else {
                exit(json_encode(array('code' => -202, 'msg' => "提交失败")));
            }
        }
    }

    /**
     *规划行程
     */
    public function edit()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $tid = intval(trim($ret['tid']));
        $uid = intval(trim($ret['uid']));
        $title = trim($ret['title']);
        $starttime = intval(trim($ret['starttime']));
        $endtime = intval(trim($ret['endtime']));
        $days = intval(trim($ret['days']));
        $money = floatval(trim($ret['money']));
        $ispublic = intval(trim($ret['ispublic']));
        $tripinfo = $ret['tripinfo'];

        $user = M('Member')->where(array('id' => $uid))->find();
        $trip = M('trip')->where(array('id' => $tid))->find();
        if ($tid == '' || $uid == '' || $title == '' || $starttime == '' || $endtime == '' || $days == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } elseif (empty($trip)) {
            exit(json_encode(array('code' => -200, 'msg' => "行程不存在")));
        } else {
            $data['uid'] = $uid;
            $data['username'] = $user['nickname'];
            $data['title'] = $title;
            $data['description'] = $description;
            $data['starttime'] = $starttime;
            $data['endtime'] = $endtime;
            $data['days'] = $days;
            $data['money'] = $money;
            $data['ispublic'] = $ispublic;
            $data['inputtime'] = time();
            $data['updatetime'] = time();
            $id = M("trip")->where(array('id' => $tid))->save($data);
            if ($id) {
                M('tripinfo')->where(array('tid' => $tid))->delete();
                $citynamearray = array();
                foreach ($tripinfo as $value) {
                    # code...
                    $orderid = "";
                    if (trim($value['varname']) == 'party') {
                        $orderid = "ac" . date("YmdHis", time()) . rand(100, 999);
                    } elseif (trim($value['varname']) == 'hostel') {
                        $orderid = "hc" . date("YmdHis", time()) . rand(100, 999);
                    }
                    $cityname = M('area')->where(array('id' => $value['city']))->getField("name");
                    $citynamearray[] = $cityname;
                    M('tripinfo')->add(array(
                        'tid' => $tid,
                        'orderid' => $orderid,
                        'day' => intval(trim($value['day'])),
                        'city' => intval(trim($value['city'])),
                        'cityname' => $cityname,
                        'place' => trim($value['place']),
                        'event' => trim($value['event']),
                        'varname' => trim($value['varname']),
                        'eventid' => intval(trim($value['eventid'])),
                        'listorder' => intval(trim($value['listorder'])),
                        'date' => intval(trim($value['date'])),
                        'money' => floatval(trim($value['money']))
                    ));

                }
                if ($citynamearray) {
                    $citynamearray = array_unique($citynamearray);
                    $description = implode(",", $citynamearray) . $days . "日游";
                    M("trip")->where(array('id' => $tid))->setField("description", $description);
                }
                exit(json_encode(array('code' => 200, 'msg' => "提交成功")));
            } else {
                exit(json_encode(array('code' => -202, 'msg' => "提交失败")));
            }
        }
    }

    /**
     *评论
     */
    public function review()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $tid = intval(trim($ret['tid']));
        $uid = intval(trim($ret['uid']));
        $content = trim($ret['content']);

        $trip = M('trip')->where(array('id' => $tid))->find();
        $user = M('Member')->where(array('id' => $uid))->find();
        if ($tid == '' || $uid == '' || $content == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($trip)) {
            exit(json_encode(array('code' => -200, 'msg' => "行程不存在")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } elseif ($trip['ispublic'] == 0) {
            exit(json_encode(array('code' => -200, 'msg' => "该行程不是公开行程")));
        } else {
            $data['value'] = $tid;
            $data['uid'] = $uid;
            $data['content'] = $content;
            $data['varname'] = 'trip';
            $data['inputtime'] = time();
            $id = M("review")->add($data);
            if ($id) {
                exit(json_encode(array('code' => 200, 'msg' => "评论成功")));
            } else {
                exit(json_encode(array('code' => -202, 'msg' => "评论失败")));
            }
        }
    }

    /**
     *活动订单修改
     */
    public function order_party()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $orderid = trim($ret['orderid']);
        $aid = intval(trim($ret['aid']));
        $uid = intval(trim($ret['uid']));
        $realname = trim($ret['realname']);
        $idcard = trim($ret['idcard']);
        $phone = trim($ret['phone']);
        $num = intval(trim($ret['num']));
        $couponsid = intval(trim($ret['couponsid']));
        $discount = intval(trim($ret['discount']));
        $money = floatval(trim($ret['money']));
        $memberids = trim($ret['memberids']);

        $user = M('Member')->where(array('id' => $uid))->find();
        $order = M('order')->where(array('orderid' => $orderid))->find();
        $activity = M('activity')->where(array('id' => $aid))->find();
        $apply = M('activity_apply')->where(array('aid' => $aid, 'uid' => $uid))->find();
        if ($orderid == '' || $uid == '' || $aid == '' || $realname == '' || $idcard == '' || $num == '' || $phone == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } elseif (empty($activity) || $activity['isdel'] == 1) {
            exit(json_encode(array('code' => -200, 'msg' => "活动不存在")));
        } elseif ($activity['uid'] == $uid) {
            exit(json_encode(array('code' => -200, 'msg' => "不能参加自己的活动")));
        } elseif ($activity['end_numlimit'] - $activity['yes_num'] < $num) {
            exit(json_encode(array('code' => -200, 'msg' => "活动人数超过限制")));
        } elseif (!empty($apply) && $apply['paystatus'] == 1) {
            exit(json_encode(array('code' => -200, 'msg' => "已经报名")));
        } else {
            $premoney = $activity['money'];
            if (empty($premoney) || $premoney == '0.00' || $activity['isfree'] == 1 || $money == '0.00') {
                $data['paystatus'] = 1;
            }
            $data['aid'] = $aid;
            $data['uid'] = $uid;
            $data['orderid'] = $orderid;
            $data['realname'] = $realname;
            $data['idcard'] = $idcard;
            $data['phone'] = $phone;
            $data['num'] = $num;
            $data['couponsid'] = $couponsid;
            $data['discount'] = $discount;
            $data['money'] = $money;
            $data['total'] = $premoney * $num;
            $data['inputtime'] = time();
            $data['memberids'] = $memberids;
            if ($order) {
                $id = M("activity_apply")->where(array('orderid' => $orderid))->save($data);
            } else {
                $id = M("activity_apply")->add($data);
            }

            if ($id) {
                M('activity_member')->where(array('orderid' => $orderid))->delete();
                if (!empty($memberids)) {
                    $infobox = M('linkman')->where(array('id' => array('in', $memberids)))->select();
                    foreach ($infobox as $value) {
                        M('activity_member')->add(array(
                            'uid' => $uid,
                            'aid' => $aid,
                            'linkmanid' => $value['id'],
                            'orderid' => $orderid,
                            'realname' => $value['realname'],
                            'idcard' => $value['idcard'],
                            'phone' => $value['phone'],
                            'inputtime' => time()
                        ));
                    }
                }
                M('activity_member')->add(array(
                    'uid' => $uid,
                    'aid' => $aid,
                    'orderid' => $orderid,
                    'realname' => $realname,
                    'idcard' => $idcard,
                    'phone' => $phone,
                    'inputtime' => time()
                ));
                if ($order) {
                    $orderset = M('order')->where(array('orderid' => $orderid))->save(array(
                        'title' => "蜗牛客慢生活-订单编号" . $orderid,
                        'uid' => $uid,
                        'orderid' => $orderid,
                        'nums' => 1,
                        'money' => $money,
                        'total' => $premoney * $num,
                        'discount' => $discount,
                        'couponsid' => $couponsid,
                        'inputtime' => time(),
                        'ordertype' => 2
                    ));
                    if ($orderset) {
                        if (empty($premoney) || $premoney == '0.00') {
                            M('order_time')->where(array('orderid' => $orderid))->save(array(
                                'orderid' => $orderid,
                                'status' => 4,
                                'pay_status' => 1,
                                'pay_time' => time(),
                                'donetime' => time()
                            ));
                        }
                    }
                } else {
                    $orderset = M('order')->add(array(
                        'title' => "蜗牛客慢生活-订单编号" . $orderid,
                        'uid' => $uid,
                        'orderid' => $orderid,
                        'nums' => 1,
                        'money' => $money,
                        'total' => $premoney * $num,
                        'discount' => $discount,
                        'couponsid' => $couponsid,
                        'inputtime' => time(),
                        'ordertype' => 2
                    ));
                    if ($orderset) {
                        if (empty($premoney) || $premoney == '0.00') {
                            M('order_time')->add(array(
                                'orderid' => $orderid,
                                'status' => 4,
                                'pay_status' => 1,
                                'pay_time' => time(),
                                'donetime' => time(),
                                'inputtime' => time()
                            ));
                        } else {
                            M('order_time')->add(array(
                                'orderid' => $orderid,
                                'status' => 2,
                                'inputtime' => time()
                            ));
                        }
                    }
                }

                $data['orderid'] = $orderid;
                exit(json_encode(array('code' => 200, 'msg' => "提交成功", 'data' => $data)));
            } else {
                exit(json_encode(array('code' => -200, 'msg' => "提交失败")));
            }
        }
    }

    /**
     *预定房间
     */
    public function order_hostel()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $orderid = trim($ret['orderid']);
        $rid = intval(trim($ret['rid']));
        $uid = intval(trim($ret['uid']));
        $realname = trim($ret['realname']);
        $idcard = trim($ret['idcard']);
        $phone = trim($ret['phone']);
        $num = intval(trim($ret['num']));
        $roomnum = intval(trim($ret['roomnum']));
        $starttime = intval(trim($ret['starttime']));
        $endtime = intval(trim($ret['endtime']));
        $days = intval(trim($ret['days']));
        $memberids = trim($ret['memberids']);
        $couponsid = intval(trim($ret['couponsid']));
        $discount = floatval(trim($ret['discount']));
        $money = floatval(trim($ret['money']));

        $user = M('Member')->where(array('id' => $uid))->find();
        $order = M('order')->where(array('orderid' => $orderid))->find();
        $room = M('Room a')->join("left join zz_hostel b on a.hid=b.id")->where(array('a.id' => $rid))->field("a.*,b.title as hostel,b.uid as houseownerid")->find();
        $apply = M('book_room')->where(array('rid' => $rid, 'uid' => $uid, '_string' => $endtime . " <= endtime and " . $starttime . " >= starttime"))->find();

        $booknum = M('book_room')->where(array('_string' => $endtime . " <= endtime and " . $starttime . " >= starttime"))->sum('num');
        if ($uid == '' || $rid == '' || $num == '' || $roomnum == '' || $days == '' || $starttime == '' || $endtime == '' || $realname == '' || $idcard == '' || $phone == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } elseif (empty($room) || $room['isdel'] == 1) {
            exit(json_encode(array('code' => -200, 'msg' => "房间不存在")));
        } elseif ($room['houseownerid'] == $uid) {
            exit(json_encode(array('code' => -200, 'msg' => "不能预定自己的房间")));
        } elseif ($roomnum >= $room['mannum']) {
            exit(json_encode(array('code' => -200, 'msg' => "房间数超过限制")));
        } elseif ($room['mannum'] - $booknum < $num) {
            exit(json_encode(array('code' => -200, 'msg' => "入住人数超过限制")));
        } elseif (!empty($apply) && $apply['paystatus'] == 1) {
            exit(json_encode(array('code' => -200, 'msg' => "已经预定")));
        } else {
            $premoney = $room['money'];
            if (empty($premoney) || $premoney == '0.00' || $money == '0.00') {
                $data['paystatus'] = 1;
            }
            $data['rid'] = $rid;
            $data['hid'] = $room['hid'];
            $data['uid'] = $uid;
            $data['orderid'] = $orderid;
            $data['num'] = $num;
            $data['days'] = $days;
            $data['realname'] = $realname;
            $data['idcard'] = $idcard;
            $data['phone'] = $phone;
            $data['starttime'] = $starttime;
            $data['endtime'] = $endtime;
            $data['couponsid'] = $couponsid;
            $data['discount'] = $discount;
            $data['money'] = $money;
            $data['total'] = $premoney * $num;
            $data['memberids'] = $memberids;
            $data['inputtime'] = time();
            if ($order) {
                $id = M("book_room")->where(array('orderid' => $orderid))->save($data);
            } else {
                $id = M("book_room")->add($data);
            }
            if ($id) {
                M('book_member')->where(array('orderid' => $orderid))->delete();
                if (!empty($memberids)) {
                    $infobox = M('linkman')->where(array('id' => array('in', $memberids)))->select();
                    foreach ($infobox as $value) {
                        M('book_member')->add(array(
                            'uid' => $uid,
                            'rid' => $rid,
                            'linkmanid' => $value['id'],
                            'orderid' => $orderid,
                            'realname' => $value['realname'],
                            'idcard' => $value['idcard'],
                            'phone' => $value['phone'],
                            'inputtime' => time()
                        ));
                    }
                }
                M('book_member')->add(array(
                    'uid' => $uid,
                    'rid' => $rid,
                    'orderid' => $orderid,
                    'realname' => $realname,
                    'idcard' => $idcard,
                    'phone' => $phone,
                    'inputtime' => time()
                ));
                if ($order) {
                    $orderset = M('order')->where(array('orderid' => $orderid))->save(array(
                        'title' => "蜗牛客慢生活-订单编号" . $orderid,
                        'uid' => $uid,
                        'orderid' => $orderid,
                        'nums' => 1,
                        'money' => $money,
                        'total' => $premoney * $roomnum,
                        'discount' => $discount,
                        'couponsid' => $couponsid,
                        'inputtime' => time(),
                        'ordertype' => 1
                    ));
                    if ($orderset) {
                        if (empty($premoney) || $premoney == '0.00') {
                            M('order_time')->where(array('orderid' => $orderid))->save(array(
                                'orderid' => $orderid,
                                'status' => 4,
                                'pay_status' => 1,
                                'pay_time' => time(),
                                'donetime' => time()
                            ));
                        }
                    }
                } else {
                    $order = M('order')->add(array(
                        'title' => "蜗牛客慢生活-订单编号" . $orderid,
                        'uid' => $uid,
                        'orderid' => $orderid,
                        'nums' => 1,
                        'money' => $money,
                        'total' => $premoney * $roomnum,
                        'discount' => $discount,
                        'couponsid' => $couponsid,
                        'inputtime' => time(),
                        'ordertype' => 1
                    ));
                    if ($order) {
                        if (empty($premoney) || $premoney == '0.00') {
                            M('order_time')->add(array(
                                'orderid' => $orderid,
                                'status' => 4,
                                'pay_status' => 1,
                                'pay_time' => time(),
                                'donetime' => time(),
                                'inputtime' => time()
                            ));
                        } else {
                            M('order_time')->add(array(
                                'orderid' => $orderid,
                                'status' => 1,
                                'inputtime' => time()
                            ));
                        }
                    }
                    UtilController::addmessage($room['houseownerid'], "申请入住", "您有新的房间预定订单需要审核，请尽快处理。", "您有新的房间预定订单需要审核，请尽快处理。", "applybookhouse", $orderid);
                }

                $data['orderid'] = $orderid;

                exit(json_encode(array('code' => 200, 'msg' => "提交成功", 'data' => $data)));
            } else {
                exit(json_encode(array('code' => -200, 'msg' => "提交失败")));
            }
        }
    }

    /**
     *评论列表
     */
    public function get_review()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $tid = intval(trim($ret['tid']));
        $p = intval(trim($ret['p']));
        $num = intval(trim($ret['num']));

        if ($tid == '' || $p == '' || $num == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } else {
            $where = array();
            $order = array('a.id' => 'desc');
            $where['a.value'] = $tid;
            $where['a.isdel'] = 0;
            $where['a.varname'] = 'trip';
            $count = M("review a")->where($where)->count();
            $list = M("review a")
                ->join("left join zz_member b on a.uid=b.id")
                ->where($where)
                ->order($order)
                ->field('a.id as rid,a.content,a.inputtime,a.uid,b.nickname,b.head,b.rongyun_token')
                ->page($p, $num)->select();
            $data = array('num' => $count, 'data' => $list);
            if ($data) {
                exit(json_encode(array('code' => 200, 'msg' => "加载成功", 'data' => $data)));
            } else {
                exit(json_encode(array('code' => -201, 'msg' => "无符合要求数据")));
            }
        }
    }

    /**
     *收藏
     */
    public function collect()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $tid = intval(trim($ret['tid']));
        $uid = intval(trim($ret['uid']));

        $trip = M('trip')->where(array('id' => $tid))->find();
        $user = M('Member')->where(array('id' => $uid))->find();
        $collectstatus = M('collect')->where(array('uid' => $uid, 'varname' => 'trip', 'value' => $tid))->find();
        if ($tid == '' || $uid == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($trip)) {
            exit(json_encode(array('code' => -200, 'msg' => "行程不存在")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } elseif ($trip['ispublic'] == 0) {
            exit(json_encode(array('code' => -200, 'msg' => "该行程不是公开行程")));
        } elseif (!empty($collectstatus)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户已经收藏")));
        } else {
            $id = M("collect")->add(array(
                'uid' => $uid,
                'value' => $tid,
                'varname' => "trip",
                'inputtime' => time()
            ));
            if ($id) {
                UtilController::addmessage($trip['uid'], "行程收藏", "您的行程(" . $trip['title'] . ")被其他用户收藏了", "您的行程(" . $trip['title'] . ")被其他用户收藏了", "tripcollect", $trip['id']);
                exit(json_encode(array('code' => 200, 'msg' => "收藏成功")));
            } else {
                exit(json_encode(array('code' => -202, 'msg' => "收藏失败")));
            }
        }
    }

    /**
     *取消收藏
     */
    public function uncollect()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $tid = trim($ret['tid']);
        $uid = intval(trim($ret['uid']));

        $tidbox = explode(",", $tid);
        if (is_array($tidbox)) {
            $where['id'] = array('in', $tidbox);
        } else {
            $where['id'] = array('eq', $tid);
        }
        $trip = M('trip')->where($where)->count();
        $user = M('Member')->where(array('id' => $uid))->find();
        if (is_array($tidbox)) {
            $collectstatus = M('collect')->where(array('uid' => $uid, 'varname' => 'trip', 'value' => $tid))->find();
        } else {
            $collectstatus = M('collect')->where(array('uid' => $uid, 'varname' => 'trip', 'value' => array('in', $tidbox)))->find();
        }

        if ($tid == '' || $uid == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($trip)) {
            exit(json_encode(array('code' => -200, 'msg' => "行程不存在")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } elseif (empty($collectstatus)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户尚未收藏")));
        } else {
            $where = array();
            $tidbox = explode(",", $tid);
            if (is_array($tidbox)) {
                $where['value'] = array('in', $tidbox);
            } else {
                $where['value'] = array('eq', $tid);
            }
            $where['uid'] = $uid;
            $where['varname'] = "trip";
            $id = M('collect')->where($where)->delete();
            if ($id) {
                exit(json_encode(array('code' => 200, 'msg' => "取消收藏成功")));
            } else {
                exit(json_encode(array('code' => -202, 'msg' => "取消收藏失败")));
            }
        }
    }

    /**
     *点赞
     */
    public function hit()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $tid = intval(trim($ret['tid']));
        $uid = intval(trim($ret['uid']));

        $trip = M('trip')->where(array('id' => $tid))->find();
        $user = M('Member')->where(array('id' => $uid))->find();
        $hitstatus = M('hit')->where(array('uid' => $uid, 'varname' => 'trip', 'value' => $tid))->find();
        if ($tid == '' || $uid == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($trip)) {
            exit(json_encode(array('code' => -200, 'msg' => "行程不存在")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } elseif ($trip['ispublic'] == 0) {
            exit(json_encode(array('code' => -200, 'msg' => "该行程不是公开行程")));
        } elseif (!empty($hitstatus)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户已经点赞")));
        } else {
            M('trip')->where('id=' . $tid)->setInc("hit");
            $id = M("hit")->add(array(
                'uid' => $uid,
                'value' => $tid,
                'varname' => "trip",
                'inputtime' => time()
            ));
            if ($id) {
                UtilController::addmessage($trip['uid'], "行程点赞", "您的行程(" . $trip['title'] . ")获得1个赞", "您的行程(" . $trip['title'] . ")获得1个赞", "triphit", $trip['id']);
                exit(json_encode(array('code' => 200, 'msg' => "点赞成功")));
            } else {
                exit(json_encode(array('code' => -202, 'msg' => "点赞失败")));
            }
        }
    }

    /**
     *取消点赞
     */
    public function unhit()
    {
        $ret = $GLOBALS['HTTP_RAW_POST_DATA'];
        $ret = json_decode($ret, true);
        $tid = intval(trim($ret['tid']));
        $uid = intval(trim($ret['uid']));

        $trip = M('trip')->where(array('id' => $tid))->find();
        $user = M('Member')->where(array('id' => $uid))->find();
        $hitstatus = M('hit')->where(array('uid' => $uid, 'varname' => 'trip', 'value' => $tid))->find();
        if ($tid == '' || $uid == '') {
            exit(json_encode(array('code' => -200, 'msg' => "请求参数错误")));
        } elseif (empty($trip)) {
            exit(json_encode(array('code' => -200, 'msg' => "行程不存在")));
        } elseif (empty($user)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户不存在")));
        } elseif (empty($hitstatus)) {
            exit(json_encode(array('code' => -200, 'msg' => "用户尚未点赞")));
        } else {
            M('trip')->where('id=' . $tid)->setDec("hit");
            $id = M("hit")->delete($hitstatus['id']);
            if ($id) {
                exit(json_encode(array('code' => 200, 'msg' => "取消点赞成功")));
            } else {
                exit(json_encode(array('code' => -202, 'msg' => "取消点赞失败")));
            }
        }
    }
}
