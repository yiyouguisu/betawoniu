<?php
namespace Admin\Controller;
use Admin\Common\CommonController;
class IndexController extends CommonController {
    /**
     * 后台框架
     * @author oydm<389602549@qq.com>  time|20140421
     */
    public function index() {
        $this->assign("SUBMENU_CONFIG", json_encode(D("Menu")->menu_json()));
        $this->display();
    }
    /**
     * 后台首页
     * @author oydm<389602549@qq.com>  time|20140421
     */
    public function main() {
        
        //服务器信息
        $info = array(
            '操作系统' => PHP_OS,
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            'MYSQL版本' => mysql_get_server_info(),
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        );

        
        $this->assign('server_info', $info);

        $uid = $_SESSION["userid"];
        $username = M("user")->where(array("id" => $uid))->getField("username");
        $lastLogin = M("loginlog")->field('loginip,logintime')->where(array("username"=>$username))->order(array('loginid'=>"desc"))->find();
        if(empty($lastLogin)){
            $lastLogin['add_time'] = "首次登陆";    
            $lastLogin['area'] = "首次登陆";    
        }else{
            $lastLogin['add_time'] = $lastLogin['logintime'];   
            //$lastLogin['area'] = ip2area($lastLogin['loginip']);    
        }
        $this->assign("lastLogin",$lastLogin);
        
        $uid = $_SESSION["userid"];
        $User = M("user")->where(array("id" => $uid))->find();

        $starttime=date("Y-m-d");
        $this->assign("starttime",$starttime);
        $endtime=date("Y-m-d",strtotime("+1 days"));
        $this->assign("endtime",$endtime);
        if($User['role']==1){
            $this->charts();
            $this->display();
        }else{
            $this->display("maindefault");
        }
        
    }
    public function charts(){
        $user=array();
        $hostelorder=array();
        $partyorder=array();
        $companyorder=array();
        $speedorder=array();
        $weighorder=array();
        $date=array();
        for($i=14;$i>=0;$i--){
            $time=strtotime("-". $i ." days");
            $_time=date("m-d",$time);
            $starttime=mktime(0,0,0,intval(date("m",$time)),intval(date("d",$time)),intval(date("Y",$time)));
            $endtime=mktime(23,59,59,intval(date("m",$time)),intval(date("d",$time)),intval(date("Y",$time)));
            $date[]=$_time;

            $where = array();
            $where['reg_time']=array(array('EGT', $starttime), array('ELT', $endtime));
            $where['group_id']=1;
            $usernums=M('member')->where($where)->count();
            $user[]=!empty($usernums)?$usernums:0;

            $where = array();
            $where['inputtime']=array(array('EGT', $starttime), array('ELT', $endtime));
            $where['ordertype']=1;
            $hostelordernums=M('order')->where($where)->count();
            $hostelorder[]=!empty($hostelordernums)?$hostelordernums:0;

            $where['ordertype']=2;
            $partyordernums=M('order')->where($where)->count();
            $partyorder[]=!empty($partyordernums)?$partyordernums:0;

            $where = array();
            $where['inputtime']=array(array('EGT', $starttime), array('ELT', $endtime));
            $realnamenums=M('realname_apply')->where($where)->count();
            $realname[]=!empty($realnamenums)?$realnamenums:0;

            $where = array();
            $where['inputtime']=array(array('EGT', $starttime), array('ELT', $endtime));
            $houseownernums=M('houseowner_apply')->where($where)->count();
            $houseowner[]=!empty($houseownernums)?$houseownernums:0;

            $where = array();
            $where['inputtime']=array(array('EGT', $starttime), array('ELT', $endtime));
            $withdrawnums=M('withdraw')->where($where)->count();
            $withdraw[]=!empty($withdrawnums)?$withdrawnums:0;


        }
        $_user=trim(implode(",",$user),",");
        $_hostelorder=trim(implode(",",$hostelorder),",");
        $_partyorder=trim(implode(",",$partyorder),",");
        $_realname=trim(implode(",",$realname),",");
        $_houseowner=trim(implode(",",$houseowner),",");
        $_withdraw=trim(implode(",",$withdraw),",");

        
        $this->assign("date", json_encode($date));
        $this->assign("user", $_user);
        $this->assign("hostelorder", $_hostelorder);
        $this->assign("partyorder", $_partyorder);
        $this->assign("realname", $_realname);
        $this->assign("houseowner", $_houseowner);
        $this->assign("withdraw", $_withdraw);
    }
    /**
     * 菜单搜索
     * @author oydm<389602549@qq.com>  time|20140421
     */
    public function public_find() {
        $keyword = I('get.keyword');
        if (!$keyword) {
            $this->error("请输入需要搜索的关键词！");
        }
        
        $where = array();
        $where['name'] = array("LIKE", "%$keyword%");
        $where['status'] = array("EQ", 1);
        $where['type'] = array("EQ", 1);
        $data = M("Menu")->where($where)->select();
        $menuData = $menuName = array();
        $Module = F("Module");
        foreach ($data as $k => $v) {
            $menuData[ucwords($v['app'])][] = $v;
            $menuName[ucwords($v['app'])] = $Module[ucwords($v['app'])]['name'];
        }
        $this->assign("menuData", $menuData);
        $this->assign("menuName", $menuName);
        $this->assign("keyword", $keyword);
        $this->display();
    }
    
    /**
     * 缓存更新
     * @author oydm<389602549@qq.com>  time|20140421
     */
    public function public_cache() {
        if (isset($_GET['type'])) {
            $Dir = new \Think\Dir();
            $type = I('get.type');
            switch ($type) {
                case "site":
                    //删除缓存目录下的文件
                    $Dir->del(DATA_PATH);
                    $this->success("站点数据缓存清理成功！");
                    break;
                case "Atemplate":
                    //删除缓存目录下的文件
                    $Dir->del(RUNTIME_PATH);
                    $Dir->delDir(RUNTIME_PATH . "Cache/Admin/");
                    $Dir->delDir(RUNTIME_PATH . "Temp/");
                    $this->success("后台模板缓存清理成功！");
                    break;
                case "Htemplate":
                    //删除缓存目录下的文件
                    $Dir->del(RUNTIME_PATH);
                    $Dir->delDir(RUNTIME_PATH . "Cache/Home/");
                    $Dir->delDir(RUNTIME_PATH . "Temp/");
                    $this->success("前台模板缓存清理成功！");
                    break;
                case "Wtemplate":
                    //删除缓存目录下的文件
                    $Dir->del(RUNTIME_PATH);
                    $Dir->delDir(RUNTIME_PATH . "Cache/Web/");
                    $Dir->delDir(RUNTIME_PATH . "Temp/");
                    $this->success("WEB模板缓存清理成功！");
                    break;
                case "logs":
                    $Dir->delDir(RUNTIME_PATH . "Logs/");
                    $this->success("站点日志清理成功！");
                    break;
                default:
                    $this->error("请选择清楚缓存类型！");
                    break;
            }
        } else {
            $this->display("Index:cache");
        }
    }
    public function ajax_getneworder(){
        $endSig = "\n\n";
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        $time = date('r');
        $order=$this->orders();
        if(!empty($order)){
            $response = array(
                'order'=>$order,
                'status' => 1
            );
        }else{
            $response = array(
                'status' => 0
            );
        }
        
        $res = json_encode($response);
        echo "data:{$res}{$endSig}";
        flush();

    }
    protected function orders(){
        $where=array();
        // if(!empty($_SESSION['storeid'])){
        //     $where['a.storeid']=$_SESSION['storeid'];
        // }
        // $where['b.status']=2;
        // $where['b.package_status']=0;
        // $where['b.delivery_status']=0;
        // $where['b.close_status']=0;
        // $where['b.cancel_status']=0;
        // $where['a.puid']=0;
        // $where['_string']="(a.paystyle=2 and b.pay_status=0) or (a.paystyle!=2 and b.pay_status=1) or (a.iscontainsweigh=0 and b.pay_status=1) or a.iscontainsweigh=1";
        // $order=M('Order a')
        //     ->join("left join zz_order_time b on a.orderid=b.orderid")
        //     ->order(array('a.inputtime'=>'desc'))
        //     ->where($where)
        //     ->field("a.orderid")
        //     ->find();

        if(!empty($_SESSION['storeid'])){
            $sql="SELECT a.orderid FROM zz_order a left join zz_order_time b on a.orderid=b.orderid WHERE ( a.storeid = ".$_SESSION['storeid']." ) AND ( b.status = 2 ) AND ( b.package_status = 0 ) AND ( b.delivery_status = 0 ) AND ( b.close_status = 0 ) AND ( b.cancel_status = 0 ) AND ( a.puid = 0 ) AND ( (a.paystyle=2 and b.pay_status=0) or (a.paystyle!=2 and b.pay_status=1) or (a.iscontainsweigh=0 and b.pay_status=1) or a.iscontainsweigh=1 ) ORDER BY a.inputtime desc LIMIT 1";
        }else{
            $sql="SELECT a.orderid FROM zz_order a left join zz_order_time b on a.orderid=b.orderid WHERE ( b.status = 2 ) AND ( b.package_status = 0 ) AND ( b.delivery_status = 0 ) AND ( b.close_status = 0 ) AND ( b.cancel_status = 0 ) AND ( a.puid = 0 ) AND ( (a.paystyle=2 and b.pay_status=0) or (a.paystyle!=2 and b.pay_status=1) or (a.iscontainsweigh=0 and b.pay_status=1) or a.iscontainsweigh=1 ) ORDER BY a.inputtime desc LIMIT 1";
        }
        
        $order=M()->query($sql);
        return $order;
    }
}