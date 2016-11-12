<?php
namespace Wx\Controller;
use Wx\Common\CommonController;
class NewsController extends CommonController {
    //public function index() {
    //    if (!session('uid')) {
    //        $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    //        cookie("returnurl",$returnurl);
    //        $this->redirect("Wx/Public/wxlogin");
    //    } else{
    //        $uid=session("uid");
    //        $where['status']=1;
    //        $where['isdel']=0;
    //        $where['parentid']=0;
    //        $count = M('article')->where($where)->count();
    //        $page = new \Think\Page($count,6);
    //        $data = M('article')->where($where)->order(array('id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
    //        foreach ($data as $key => $value)
    //        {
    //            $hitstatus=M("hit")->where(array('uid'=>$uid,'value'=>$value['id'],'varname'=>'news'))->find();
    //            if($hitstatus){
    //                $data[$key]['ishit']=1;
    //            }else{
    //                $data[$key]['ishit']=0;
    //            }
    //            $where['parentid']=$value['id'];
    //            $news=M('article')->where($where)->order(array('id'=>'desc'))->select();
    //            foreach ($news as $k => $val)
    //            {
    //                $hitstatus=M("hit")->where(array('uid'=>$uid,'value'=>$val['id'],'varname'=>'news'))->find();
    //                if($hitstatus){
    //                    $news[$k]['ishit']=1;
    //                }else{
    //                    $news[$k]['ishit']=0;
    //                }
    //            }
    //            $data[$key]['news']=$news;
    //        }
    //        $show = $page->show();
    //        $this->assign("data", $data);
    //        $this->assign("Page", $show);

    //        if($_GET['isAjax']==1){
    //            $this->display("morelist_index");
    //        }else{
    //            $this->display();
    //        }
    //    }
        
    //}

    //用户点开分享的页面时访问
    public function bridge(){
        // session(null);
        // echo 123;
        $nid=I('nid');
        $invitecode = session('invitecode');
        // \Think\Log::write("invitecode111:".$invitecode,'WARN');
        if(empty($nid)){
            $innid = I('innid');
            if(!empty($innid)){
                $this->redirect("Wx/Vote/show",array('id'=>$innid));
            }else{
                $this->redirect("Wx/Vote/index");
            }
        } else {
            // $data=M('house')->where(array('id'=>$id))->find();
            $house = M('house')->where(array('id' => $nid))->find();
            header("Location: {$house['link']}");
            exit;
        }

    }

    public function index() {
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $uid=session("uid");
            $where['b.status']=2;
            $where['b.isdel']=0;
            $where['a.ischoujiang']=0;
            $count = M('voteparty a')->join("left join zz_house b on a.hid=b.id")->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('voteparty a')->join("left join zz_house b on a.hid=b.id")->where($where)->order(array('b.id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
            foreach ($data as $key => $value)
            {
                $data[$key]['nickname']=M('Member')->where(array('id'=>$value['uid']))->getField("nickname");
                //$data[$key]['description']=$this->str_cut(trim(strip_tags($value['content'])), 50);
                $hitstatus=M("hit")->where(array('uid'=>$uid,'value'=>$value['id'],'varname'=>'voteparty'))->find();
                if($hitstatus){
                    $data[$key]['ishit']=1;
                }else{
                    $data[$key]['ishit']=0;
                }
            }
            $show = $page->show();
            $this->assign("data", $data);
            $this->assign("Page", $show);

            if($_GET['isAjax']==1){
                $this->display("morelist_index");
            }else{
                $this->display();
            }
        }
        
    }
    public function show() {
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $id=I('nid');
            session("nid",$id);
            $uid=session("uid");
            $data=M('house')->where(array('id'=>$id))->find();
            $data['nickname']=M('Member')->where(array('id'=>$data['uid']))->getField("nickname");
            M('house')->where(array('id'=>$id))->setInc("view");
            $hitstatus=M("hit")->where(array('uid'=>$uid,'value'=>$id,'varname'=>'voteparty'))->find();
            if($hitstatus){
                $data['ishit']=1;
            }else{
                $data['ishit']=0;
            }
            $joinstatus=M("pool")->where(array('uid'=>$uid,'hid'=>$id,'isowner'=>1))->find();
            if($joinstatus){
                $data['isjoin']=1;
            }else{
                $data['isjoin']=0;
            }

            $this->assign("data",$data);
            $share['id']=$data['id'];
            $share['title']=$data['title'];
           // $share['content']=$this->str_cut(trim(strip_tags($data['content'])), 100);
            $share['content']=$data['description'];
            $uid = session('uid');
            if($uid){
                $tuijiancode = M('member')->where(array('id'=>$uid))->getField("tuijiancode");
                $share['link']=C("WEB_URL").U('Wx/News/show',array('nid'=>$id,'invitecode'=>$tuijiancode));
            }else{
                $share['link']=C("WEB_URL").U('Wx/News/show',array('nid'=>$id));
            }

            $share['image']=C("WEB_URL").$data['thumb'];
            $this->assign("share",$share);
            $this->display();
        }
    }
    public function backshow() {
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $id=I('nid');
            session("nid",$id);
            $uid=session("uid");


            $data=M('house')->where(array('id'=>$id))->find();
            $data['nickname']=M('Member')->where(array('id'=>$data['uid']))->getField("nickname");
            M('house')->where(array('id'=>$id))->setInc("view");
            $hitstatus=M("hit")->where(array('uid'=>$uid,'value'=>$id,'varname'=>'voteparty'))->find();
            if($hitstatus){
                $data['ishit']=1;
            }else{
                $data['ishit']=0;
            }
            $this->assign("data",$data);
            $share['id']=$data['id'];
            $share['title']=$data['title'];
            //$share['content']=$this->str_cut(trim(strip_tags($data['content'])), 100);
            $share['content']=$data['description'];
            $uid = session('uid');
            if($uid){
                $tuijiancode = M('member')->where(array('id'=>$uid))->getField("tuijiancode");
                $share['link']=C("WEB_URL").U('Wx/News/show',array('nid'=>$id,'invitecode'=>$tuijiancode));
            }else{
                $share['link']=C("WEB_URL").U('Wx/News/show',array('nid'=>$id));
            }

            $share['image']=C("WEB_URL").$data['thumb'];
            $this->assign("share",$share);
            $this->display();
        }
    }
    public function ajax_hit(){
        if(IS_POST){
            $nid=$_POST['nid'];
            $uid=session("uid");
            //$user=M('member')->where(array('id'=>$uid))->find();
            //if($user['subscribestatus']==0){
            //    $this->ajaxReturn(array('status'=>-2),'json');
            //}
            $hitstatus=M("hit")->where(array('uid'=>$uid,'value'=>$nid,'varname'=>'voteparty'))->find();
            if($hitstatus){
                $this->ajaxReturn(array('status'=>-1),'json');
            }
            $id=M('hit')->add(array(
                'uid'=>$uid,
                'varname'=>'voteparty',
                'value'=>$nid,
                'inputtime'=>time()
                ));
            if($id){
                M('house')->where(array('id'=>$nid))->setInc("hit");
                $this->ajaxReturn(array('status'=>1,'msg'=>"碌茫脭脼鲁脡鹿娄"),'json');
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>"碌茫脭脼脢搂掳脺"),'json');
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>"脟毛脟贸路脟路篓"),'json');
        }
    }
}