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
    public function index() {
        if (!session('uid')) {
            $returnurl=urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            cookie("returnurl",$returnurl);
            $this->redirect("Wx/Public/wxlogin");
        } else{
            $uid=session("uid");
            $where['status']=2;
            $where['isdel']=0;
            $count = M('house')->where($where)->count();
            $page = new \Think\Page($count,6);
            $data = M('house')->where($where)->order(array('id'=>'desc'))->limit($page->firstRow . ',' . $page->listRows)->select();
            foreach ($data as $key => $value)
            {
                $data[$key]['description']=$this->str_cut(trim(strip_tags($value['content'])), 50);
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
            $share['content']=$this->str_cut(trim(strip_tags($data['content'])), 100);
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
            $share['content']=$this->str_cut(trim(strip_tags($data['content'])), 100);
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
                $this->ajaxReturn(array('status'=>1,'msg'=>"点赞成功"),'json');
            }else{
                $this->ajaxReturn(array('status'=>0,'msg'=>"点赞失败"),'json');
            }
        }else{
            $this->ajaxReturn(array('status'=>0,'msg'=>"请求非法"),'json');
        }
    }
}