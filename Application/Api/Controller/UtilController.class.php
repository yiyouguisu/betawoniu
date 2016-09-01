<?php

namespace Api\Controller;

use Api\Common\CommonController;

class UtilController extends CommonController {

    /**
     * Summary of MessageCenter
     * @param string $type 
     * @param string $projectid 
     * @param mixed $receiver 
     * @param mixed $extras 
     * @return mixed
     */
    static public function MessageCenter($type,$projectid,$receiver,$extras){
        $Submail=A("Api/Submail");
        $sendresult=array();
        switch ($type)
        {
            case "phone":
                if(count($receiver)>1){
                    $mbox=array();
                    foreach ($receiver as $key => $value)
                    {
                    	$mbox[$key]['to']=$value;
                        $mbox[$key]['vars']=$extras[$key];
                    }
                    $sendresult=$Submail->sendMultiSMS($mbox,$projectid);
                }else{
                    $sendresult=$Submail->sendSMS($receiver[0],$projectid,$extras);
                }
                break;
            case "email":
                if(count($receiver)>1){
                    $sendresult=$Submail->sendMultiMAIl($receiver,$projectid,$extras);
                }else{
                    $sendresult=$Submail->sendMAIl($receiver[0],$projectid,$extras);
                }
                break;
        }
        return $sendresult;
    }
    /**
     * Summary of TaskLog
     * @param string $msg 
     * @param int $difftime 
     * @return void
     */
    static public function TaskLog($msg,$difftime){
        $data = array(
	        "task_info" => $msg,
	        "add_time" => date("Y-m-d H:i:s"),
	        "run_time" => $difftime
	    );
	    M("task_log")->add($data);
    }

    /**
     * Summary of sms
     * @param mixed $receiver 
     * @param string $projectid 
     * @param mixed $extras 
     * @return void
     */
    static public function sms($receiver,$projectid,$extras){
        $mid=M('sms')->add(array(
            "projectid"=>$projectid,
            "phone"=>implode(",",$receiver),
            "content"=>serialize($extras),
            "inputtime"=>time()
            ));
        if($mid){
            $num=count($receiver);
            $i=0;
            do
            {
                $newreceiver=array_slice($receiver,$i,500);
                self::pushmsgqueue($mid,"phone",$projectid,implode(",",$newreceiver),serialize($newreceiver));
                $i+=500;
                unset($newreceiver);
            }while ($i<=$num);
        }  
    }
    /**
     * Summary of email
     * @param mixed $receiver 
     * @param string $projectid 
     * @param mixed $extras 
     * @return void
     */
    static public function email($receiver,$projectid,$extras){
        $mid=M('emaillog')->add(array(
            "projectid"=>$projectid,
            "phone"=>implode(",",$receiver),
            "content"=>serialize($extras),
            "inputtime"=>time()
            ));
        if($mid){
            $num=count($receiver);
            $i=0;
            do
            {
                $newreceiver=array_slice($receiver,$i,500);
                self::pushmsgqueue($mid,"email",$projectid,implode(",",$newreceiver),serialize($newreceiver));
                $i+=500;
                unset($newreceiver);
            }while ($i<=$num);
        }  
    }
    /**
     * Summary of pushmsgqueue
     * @param int $mid 
     * @param string $message_type 
     * @param string $projectid 
     * @param mixed $receiver 
     * @param mixed $extras 
     * @return void
     */
    static public function pushmsgqueue($mid,$message_type,$projectid,$receiver,$extras){
        $data = array();
        $data['mid'] = $mid;
        $data['status'] = 0;
        $data['varname'] = $message_type;
        $data['receiver'] = $receiver;
        $data['projectid']=$projectid;
        $data['extras'] = $extras;
        $data['inputtime'] = time();
        $data['send_time_start'] = 0;
        $data['send_time_end'] = 0;
        M( "sendmsg_queue" )->add($data);
    }
    static public function addmessage($uid,$title,$description,$content,$message_type = 'system',$value=''){
        M("message")->add(array(
            'r_id'=>$uid,
            'title'=>$title,
            'description'=>$description,
            'content'=>$content,
            'varname'=>$message_type,
            'value'=>$value,
            'inputtime'=>time()
        ));
        $push['title']=$title;
        $push['description']=$description;
        $push['content']=$content;
        $push['type']=$message_type;
        $push['isadmin']=1;
        $push['inputtime']=time();
        $push['username']=M('user')->where(array('role'=>1,'group_id'=>2))->getField("username");
        $mid = M("Push")->add($push);
        $registration_id=M('member')->where(array('id'=>array('eq',$uid)))->getField("deviceToken");
        $extras = array("pushtype"=>"message","value"=>$value,'varname'=>$message_type);
        if(!empty($registration_id)){
            UtilController::PushQueue($mid, $message_type,$registration_id, $title,$description, serialize($extras));
        }
    }
    static public function PushQueue($mid, $message_type, $receiver, $title,$description, $extras){
        $data = array();
        $data['mid'] = $mid;
        $data['status'] = 0;
        $data['varname'] = $message_type;
        $data['receiver'] = $receiver;
        $data['title'] = $title;
        $data['description']=$description;
        $data['extras'] = $extras;
        $data['inputtime'] = time();
        $data['send_time_start'] = 0;
        $data['send_time_end'] = 0;
        M( "sendpush_queue" )->add($data);
    }
}