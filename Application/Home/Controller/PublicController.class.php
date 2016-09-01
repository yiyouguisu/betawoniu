<?php
namespace Home\Controller;
use Think\Controller;
@ini_set('upload_max_filesize', '50M');
class PublicController extends Controller {

    private $thumb;//�Ƿ�������ͼ
    private $water; //�Ƿ��ˮӡ(0:��ˮӡ,1:ˮӡ����,2ˮӡͼƬ)
    private $waterText;//ˮӡ����
    private $waterTextColor;//ˮӡ������ɫ
    private $waterTextFontsize;//ˮӡ���ִ�С
    private $thumbType;//����ͼ����
    private $waterPosition;//ˮӡλ��
    private $savePath; //����λ��
    private $userid; //�����û���
    private $upload_file_type=1;
    var $config;
    public function _initialize(){
        set_time_limit(0);
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=M('config')->order(array('id'=>'desc'))->select();
            F("web_config",$web_config);
        }
        foreach ($ConfigData as $key => $r) {
            if($r['groupid'] == 4){
                $this->config[$r['varname']] = $r['value'];
            }
        }
        $this->userid=empty($_SESSION['Home_uid'])? $_GET['uid'] : $_SESSION['Home_uid'];
        if(empty($this->userid)){
            $this->userid= '1';
        }

        $this->imagessavePath= '/Uploads/images/pc/';
        $this->filesavePath= '/Uploads/files/pc/';
        $this->videosavePath= '/Uploads/video/pc/';
        $this->remotesavePath= '/Uploads/remote/pc/';
        $this->scrawlsavePath= '/Uploads/scrawl/pc/';
        $this->thumb=$this->config['thumbShow'];
        $this->water=$this->config['waterShow'];
        $this->thumbType=$this->config['thumbType'];
        $this->waterText=$this->config['waterText'];
        $this->waterTextColor=$this->config['waterColor'];
        $this->waterTextFontsize=$this->config['waterFontsize'];
        $this->waterPosition= $this->config['waterPos'];
        $this->filelistpath='/Uploads/files/pc/';
        $this->imageslistpath='/Uploads/images/pc/';
        $this->saveRule = date('His')."_".rand(1000,9999);
        $this->uploadDir = "/Uploads/images/pc/";
        $this->autoSub= true;
        $this->subNameRule = array('date','Ymd');
        //$this->autologin();
    }
    public function _empty(){      
        $this->error("���ʳ���","/index.php");
    }
    /**
     * ��֤��
     * @author oydm<389602549@qq.com>  time|20140421
     */
    public function verify() {
        $verify = new \Think\Verify();
        ob_end_clean();
        $verify->expire = 300;
        $verify->fontSize = 15;
        $verify->length = 4;
        $verify->imageW = 100;
        $verify->imageH = 40;
        $verify->useNoise = false;
        $verify->useCurve = false;
        $verify->bg = array(255, 255, 255);
        $verify->entry();
    }
    /**
     * �����֤��
     * @author oydm<389602549@qq.com>  time|20140421
     */
    public function check_verify() {
        $verify = new \Think\Verify();
        $code = $_POST['verify'];
        $verifyok = $verify->check($code, $id = '');
        if (!$verifyok) {
            echo "��֤�����";
        } else {
            echo "";
        }
    }
    /**
     * ����û���
     * @author oydm<389602549@qq.com>  time|20140421
     */
    public function check_username() {
        $username = $_POST['username'];
        $result = M("Member")->where("username='".$username."'")->find();
        if($result){
            echo "�û����Ѵ��ڣ���������д";
        }else{
            echo "";
        }
    }
    public function check_username2() {
        $username = $_POST['username'];
        $result = M("Member")->where("username='".$username."'")->find();
        if($result){
            echo "";
        }else{
            echo "�û��������ڣ���������д";
        }
    }
    /**
     * �������
     * @author oydm<389602549@qq.com>  time|20140421
     */
    public function check_email() {
        $email = $_POST['email'];
        $result = M("Member")->where("email='" . $email."'")->find();
        if($result){
            echo "�����Ѵ��ڣ���������д";
        }else{
            echo "";
        }
    }

    public function https_request($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return $return_content;
    }
    public function checknum($len = 6) {
        $chars = array(
            "0", "1", "2","3", "4", "5", "6",
            "7", "8", "9"
        );
        $charsLen = count($chars) - 1;
        shuffle($chars);    // ��������� 
        $output = "";
        for ($i = 0; $i < $len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }
    public function postSMS($url,$data=''){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Jimmy's CURL Example beta");
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    public function sendchecknum(){
        $phone=$_GET['phone'];
        if($phone==''){
            exit(json_encode(array('code'=>-200,'msg'=>"Request parameter is null!")));
        }elseif(!isMobile($phone)){
            exit(json_encode(array('code'=>-200,'msg'=>"�ֻ������ʽ����")));
        }else{
            $code=\Api\Common\CommonController::checknum(6);
            $verify=M('verify')->where(array('phone'=>$phone))->find();
            if($verify){
                M('verify')->where(array('phone'=>$phone))->save(array(
                    'verify'=>$code,
                    'inputtime'=>time(),
                    'expiretime'=>strtotime("+5 minute"),
                    'status'=>0
                ));
            }else{
                M('verify')->add(array(
                    'phone'=>$phone,
                    'verify'=>$code,
                    'inputtime'=>time(),
                    'expiretime'=>strtotime("+5 minute"),
                    'status'=>0
                ));
            }
            $Ymsms = A("Api/Ymsms");
            $content=$Ymsms->getsmstemplate("sms_phonecode",array('code'=>$code));
            $data=json_encode(array('phone'=>$phone,'content'=>$content,'type'=>"sms_phonecode"));
            $statuscode=$Ymsms->sendsmsapi($data);
            if($statuscode!=0){
                $data=array('statuscode'=>$statuscode);
                exit(json_encode(array('code'=>-200,'msg'=>"����ʧ��",'data' => $data)));
            }else{
                $data=array('code'=>$code);
                exit(json_encode(array('code'=>200,'msg'=>"���ͳɹ�",'data' => $data)));
            }
        }
    }
    public function upload() {
        if (!empty($_FILES)) {
            //������ļ��ϴ� �ϴ�����
            $this->Fupload();
        }
    }
    public function uploadone() {
        if (!empty($_FILES)) {
            //������ļ��ϴ� �ϴ�����
            $this->Fuploadone();
        }
    }
    
    /**
     * ��ͼƬ�ϴ�
     */
    protected function Fupload() {
        $upload = new \Think\Upload();
        $upload->maxSize = $this->maxSize;
        $upload->exts= $this->allowExtstype;
        $upload->savePath = $this->uploadDir;
        $upload->autoSub= $this->autoSub;
        $upload->saveName = $this->saveRule;
        $upload->subName  = $this->subNameRule;
        $info=$upload->upload();
        if (!$info) {
            echo ($upload->getError());
        } else {
            foreach($info as $file){
                \Admin\Common\CommonController::save_uploadinfo($this->adminid,$this->upload_file_type,$file,$info['name']);
                echo $file['savepath'].$file['savename'];    
            }
        }
    }
    /**
     * ��ͼƬ�ϴ�
     */
    public function FuploadOne() {
        $upload = new \Think\Upload();
        $upload->maxSize = $this->config['uploadHSize'];
        $upload->exts= explode("|",$this->config['uploadHType']);// ���ø����ϴ�����
        $upload->savePath = $this->imagessavePath;
        $upload->autoSub= $this->autoSub;
        $upload->saveName = $this->saveRule;
        $upload->subName  = $this->subNameRule;
        $info=$upload->uploadOne($_FILES['Filedata']);
        if (!$info) {
            $error=$upload->getError();
            echo json_encode(array('status'=>0,'msg'=>$error));
        } else {
            $fname=$info['savepath'].$info['savename'];
            $imagearr = explode(',', 'jpg,gif,png,jpeg,bmp,ttf,tif'); 
            $info['ext']= strtolower($info['ext']);
            \Admin\Common\CommonController::save_uploadinfo($this->userid,$this->upload_file_type,$info,$info['name'], $isthumb = 0, $isadmin = 1,  $time = time());
            $isimage = in_array($info['ext'],$imagearr) ? 1 : 0;
            if ($isimage) {
                $image=new \Think\Image();
                $image->Open(".".$fname);

                $thumbsrc=$info['savepath'] . $upload->saveName . "_thumb." . $info['ext'];
                if($this->thumb==1){
                    $fname=$thumbsrc;
                }
                
                if($this->thumb==1){
                    $image->thumb($this->config['thumbW'],$this->config['thumbH'],$this->config['thumbType'])->save(".".$thumbsrc);
                }
                if ($this->water==1) {
                    if($this->thumb==1){
                        $image->text($this->waterText,'./Public/Public/font/STXINGKA.TTF',$this->config['waterFontsize'],$this->config['waterColor'],$this->waterPosition,array(-2,0))->save(".".$thumbsrc); 
                    }else{
                        $image->text($this->waterText,'./Public/Public/font/STXINGKA.TTF',$this->config['waterFontsize'],$this->config['waterColor'],$this->waterPosition,array(-2,0))->save(".".$fname); 
                    }
                }
                if ($this->water==2) {
                    if($this->thumb==1){
                        $image->water(".".$this->config['waterImg'],$this->waterPosition,$this->config['waterTran'])->save(".".$thumbsrc);
                    }else{
                        $image->water(".".$this->config['waterImg'],$this->waterPosition,$this->config['waterTran'])->save(".".$fname);
                    }
                }   
            }
            echo json_encode(array('status'=>1,'msg'=>$fname));
        }
    }
     /*
     * ajax��ȡ�ӵ����б�
     */

    public function getareachildren() {
        $parentid = $_GET['id'];
        $result = M("area")->where(array("parentid" => $parentid))->cache(true)->select();
        $result = json_encode($result);
        echo $result;
    }
    public function ajax_getcity(){
        if(IS_POST){
            $where=array();
            $location=$_POST['location'];
            if($location==''){
                $this->ajaxReturn(array('code'=>-200),'json');
            }else{
                $locationset=explode(",", $location);
                if(in_array($locationset[0],array(2,3,4,5))){
                    $city=$locationset[0];
                }else{
                    $city=$locationset[1];
                }
                $cityname=M('area')->where(array('id'=>$city))->getField("name");
                if($cityname){
                    $this->ajaxReturn(array('code'=>200,'cityname'=>$cityname),'json');
                }else{
                    $this->ajaxReturn(array('code'=>-200),'json');
                }
            }
        }else{
            $this->ajaxReturn(array('code'=>-200),'json');
        }
    }
    public function ajax_cacheurl(){
        if(IS_POST){
            $url=$_POST['url'];
            if($url==''){
                $this->ajaxReturn(array('code'=>-200),'json');
            }else{
                cookie("returnurl",urlencode($url));
                $this->ajaxReturn(array('code'=>200),'json');
            }
        }else{
            $this->ajaxReturn(array('code'=>-200),'json');
        }
    }
}