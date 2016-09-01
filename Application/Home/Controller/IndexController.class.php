<?php
namespace Home\Controller;
use Home\Common\CommonController;

class IndexController extends CommonController {

    public function index() {
        $uid=session("uid");
        $city=session("city");
    	$where=array();
    	$ids=M('area')->where(array('parentid'=>0,'id'=>array('not in','2,3,4,5')))->getField("id",true);
        $map['parentid']  = array("in",$ids);
        $map['id']  = array('in','2,3,4,5');
        $map['_logic'] = 'or';
        $where['_complex'] = $map;
        $where['ishot']=1;
        $hotcity = M("area")->where($where)->field('id,name,fletter,ishot,thumb')->select();
        $this->assign("hotcity",$hotcity);

        $where=array();
        $sqlI=M('review')->where(array('isdel'=>0,'varname'=>'hostel'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
		
        $where['a.status']=2;
        $where['a.isdel']=0;
        if(!empty($city)){
            $where['a.city']=$city;
        }
        $hothostel=M("Hostel a")
            ->join("left join zz_member b on a.uid=b.id")
            ->join("left join {$sqlI} c on a.id=c.value")
            ->where($where)
            ->order(array('a.hit'=>"desc",'a.id'=>"desc"))
            ->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.hit,a.score as evaluation,a.scorepercent as evaluationpercent,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime,c.reviewnum')
            ->limit(6)
            ->select();
        foreach ($hothostel as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $hothostel[$key]['reviewnum']=0;
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $hothostel[$key]['ishit']=1;
            }else{
                $hothostel[$key]['ishit']=0;
            }
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"hostel",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $hothostel[$key]['iscollect']=1;
            }else{
                $hothostel[$key]['iscollect']=0;
            }
        }
        $this->assign("hothostel",$hothostel);

        $where=array();
        $where['a.status']=2;
        $where['a.isdel']=0;
        if(!empty($city)){
            $where['a.city']=$city;
        }
        $hotparty=M("activity a")
        		->join("left join zz_member b on a.uid=b.id")
        		->where($where)
        		->order(array("a.hit" => "desc","a.listorder" => "desc","a.id" => "desc"))
        		->limit(4)
        		->field('a.id,a.title,a.thumb,a.money,a.area,a.address,a.lat,a.lng,a.starttime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.type,a.inputtime')
        		->select();
		$this->assign("hotparty", $hotparty);

		$where=array();
        if(!empty($city)){
            $where['a.city']=$city;
        }
		$sqlI=M('review')->where(array('isdel'=>0,'varname'=>'note'))->group("value")->field("value,count(value) as reviewnum")->buildSql();
		$hotnote = M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
		        ->limit(10)
		        ->order(array('a.hit'=>'desc'))
		        ->field('a.id,a.title,a.thumb,a.description,a.area,a.city,a.address,a.lat,a.lng,a.hit,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,a.type,c.reviewnum')
		        ->select();
		foreach ($hotnote as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $hotnote[$key]['reviewnum']=0;
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $hotnote[$key]['iscollect']=1;
            }else{
                $hotnote[$key]['iscollect']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $hotnote[$key]['ishit']=1;
            }else{
                $hotnote[$key]['ishit']=0;
            }
        }
        $this->assign("hotnote", $hotnote);
        $newnote = M("Note a")
                ->join("left join zz_member b on a.uid=b.id")
                ->join("left join {$sqlI} c on a.id=c.value")
                ->where($where)
		        ->limit(10)
		        ->order(array('a.id'=>'desc'))
		        ->field('a.id,a.title,a.thumb,a.description,a.area,a.city,a.address,a.lat,a.lng,a.hit,a.begintime,a.endtime,a.uid,b.nickname,b.head,b.rongyun_token,a.inputtime,a.type,c.reviewnum')
		        ->select();
		foreach ($newnote as $key => $value) {
            # code...
            if(empty($value['reviewnum'])) $newnote[$key]['reviewnum']=0;
            $collectstatus=M('collect')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
            if(!empty($collectstatus)){
                $newnote[$key]['iscollect']=1;
            }else{
                $newnote[$key]['iscollect']=0;
            }
            $hitstatus=M('hit')->where(array('uid'=>$uid,'varname'=>"note",'value'=>$value['id']))->find();
            if(!empty($hitstatus)){
                $newnote[$key]['ishit']=1;
            }else{
                $newnote[$key]['ishit']=0;
            }
        }
        $this->assign("newnote", $newnote);

        $hotdestination=M('Tripinfo')->field("city,cityname,count(city) as citynum")->group("city")->select();
        $this->assign("hotdestination", $hotdestination);

        $this->display();
    }
    
}