<?php
namespace Home\Controller;
use Home\Common\CommonController;

class AboutController extends CommonController {

    public function index() {
    	$data=M('page')->where(array('catid'=>8))->find();
    	$this->assign('data',$data);
        $this->display();
    }
    public function privacy() {
    	$data=M('page')->where(array('catid'=>11))->find();
    	$this->assign('data',$data);
        $this->display();
    }
    public function contact() {
    	$data=M('page')->where(array('catid'=>10))->find();
    	$this->assign('data',$data);
        $this->display();
    }
    public function service() {
    	$data=M('page')->where(array('catid'=>12))->find();
    	$this->assign('data',$data);
        $this->display();
    }
    public function question() {
    	$data=M("question")->where(array('status'=>1))->order(array('id'=>"asc"))->field('id,title,content,inputtime')->select();
    	$this->assign('data',$data);
        $this->display();
    }
    public function feedback(){

    	$this->display();
    }
    public function app(){
        $data=M('page')->where(array('catid'=>13))->find();
        $this->assign('data',$data);
        $this->display();
    }
     /**
     *改进建议
     */
    public function dofeedback(){
        $ret=$_POST;
        $uid = intval(trim($ret['uid']));
        $title=trim($ret['title']);
        $content=trim($ret['content']);

        $where['id']=$uid;
        $user=M('Member')->where($where)->field('id')->find();
        if($uid==''||$title==''||$content==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(empty($user)){
            exit(json_encode(array('code'=>-200,'msg'=>"The User is not exist!")));
        }else{
            $id=M('feedback')->add(array(
                'uid'=>$uid,
                'title'=>$title,
                'content'=>$content,
                'inputtime'=>time()
                ));
            if($id){
                exit(json_encode(array('code'=>200,'msg'=>"提交成功")));
            }else{
                exit(json_encode(array('code'=>-202,'msg'=>"提交失败")));
            }
        }
    }
}