<?php

// +----------------------------------------------------------------------
// * 后台公共文件
// * 主要定义后台公共函数库
// +----------------------------------------------------------------------
/**
 * 下拉菜单选择
 * 根据参数产生下拉选择效果
 * @access public 
 * @param int $catid 菜单类型ID
 * @param string $value 菜单值
 * @return string $data
 */
function linkage($catid, $value = "") {
    $catid = intval($catid);
    $data = M("linkage")->where("catid=" . $catid)->order(array("listorder" => "desc", "id" => "asc"))->select();
    $str = "";
    foreach ($data as $k => $val) {
        if ($val["value"] == $value) {
            $selected = " selected";
        } else {
            $selected = " ";
        }
        $str = $str . "<option value='" . $val["value"] . "' " . $selected . ">" . $val["name"] . "</option>";
    }
    echo $str;
}

/**
 * 获取菜单选择
 * 根据参数产生下拉选择效果
 * @access public 
 * @param int $catid 菜单类型ID
 * @param string $value 菜单值
 * @return string $name
 */
function linkageget($catid, $value) {
    $catid = intval($catid);
    $name = M("linkage")->where("catid=" . $catid . " and value='" . $value . "'")->getField("name");
    echo $name;
}

/*
 **获取签到积分
 */
function getsignintegral($lastintegral=0,$continuesign=1){
    if($continuesign>1){
        if($lastintegral<50){
            $signintegral+=5;
        }elseif($lastintegral==50){
            $signintegral=50;
        }
    }else{
        $signintegral=5;
    }
    return $signintegral;
}

/**
 * 获取用户名
 * 根据用户ID获取用户名
 * @access public 
 * @param int $userid 用户ID
 * @return string $username
 */
function getuser($userid,$type="username") {
    $userid = intval($userid);
    $name = M("member")->where("id=" . $userid)->getField($type);
    return $name;
}

/**
 * 字符截取
 * @param $string 需要截取的字符串
 * @param $length 长度
 * @param $dot
 */
function str_cut($sourcestr, $length, $dot = '...') {
    $returnstr = '';
    $i = 0;
    $n = 0;
    $str_length = strlen($sourcestr); //字符串的字节数 
    while (($n < $length) && ($i <= $str_length)) {
        $temp_str = substr($sourcestr, $i, 1);
        $ascnum = Ord($temp_str); //得到字符串中第$i位字符的ascii码 
        if ($ascnum >= 224) {//如果ASCII位高与224，
            $returnstr = $returnstr . substr($sourcestr, $i, 3); //根据UTF-8编码规范，将3个连续的字符计为单个字符         
            $i = $i + 3; //实际Byte计为3
            $n++; //字串长度计1
        } elseif ($ascnum >= 192) { //如果ASCII位高与192，
            $returnstr = $returnstr . substr($sourcestr, $i, 2); //根据UTF-8编码规范，将2个连续的字符计为单个字符 
            $i = $i + 2; //实际Byte计为2
            $n++; //字串长度计1
        } elseif ($ascnum >= 65 && $ascnum <= 90) { //如果是大写字母，
            $returnstr = $returnstr . substr($sourcestr, $i, 1);
            $i = $i + 1; //实际的Byte数仍计1个
            $n++; //但考虑整体美观，大写字母计成一个高位字符
        } else {//其他情况下，包括小写字母和半角标点符号，
            $returnstr = $returnstr . substr($sourcestr, $i, 1);
            $i = $i + 1;            //实际的Byte数计1个
            $n = $n + 0.5;        //小写字母和半角标点等与半个高位字符宽...
        }
    }
    if ($str_length > strlen($returnstr)) {
        $returnstr = $returnstr . $dot; //超过长度时在尾处加上省略号
    }
    return $returnstr;
}

/**
 * 隐藏隐私信息
 * @access public 
 * @param string $str 用户ID
 * @return string
 */
function substrreplace($str) {
    $len = strlen($str) / 2;
    return substr_replace($str, str_repeat('*', $len), ceil(($len) / 2), $len);
}

/**
 * 数值千位分隔符
 * @access public 
 * @param float $num
 * @return string
 */
function kilobit($num) {
    $num = preg_replace('/(?<=[0-9])(?=(?:[0-9]{3})+(?![0-9]))/', ',', $num);
    return $num;
}
function isMobile($num) {
    return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $num) ? true : false;
}
function getaddress($uid) {
    $uid=  intval($uid);
    $area=M("member_info")->where("uid=".$uid)->getField('area');
    $area1=explode(',', $area);
    foreach ($area1 as $key => $value) {
        # code...
        if($key==0){
            $arealist=M('area')->where('id=' . $value)->getField("name");
        }elseif($key==1){
            $list=M('area')->where('id=' . $value)->getField("name");
            $arealist=$arealist . $list;
        }
    }
    return $arealist;
}
function p($array){
    dump($array,1,'<pre>',0);
}
/**
 * 根据身份证号码获取性别
 * @param string $string    身份证号码
 * @return int $sex 性别 1男 2女 0未知
 */
function getsex($idcard) {
    $sexint = (int) substr($idcard, 16, 1);
    return $sexint % 2 === 0 ? 2 : 1;
}

/**
 * 根据身份证号码获取生日
 * @param string $string    身份证号码
 * @return $birthday
 */
function getbirthday($idcard) {
    $bir = substr($idcard, 6, 8);
    $year = (int) substr($bir, 0, 4);
    $month = (int) substr($bir, 4, 2);
    $day = (int) substr($bir, 6, 2);
    return $year . "-" . $month . "-" . $day;
}

/**
 * 计算给定时间戳与当前时间相差的时间，并以一种比较友好的方式输出
 * @param  [int] $timestamp [给定的时间戳]
 * @param  [int] $current_time [要与之相减的时间戳，默认为当前时间]
 * @return [string]            [相差天数]
 */
function tmspan($timestamp,$current_time=0){
    if(!$current_time) $current_time=time();
    $span=$current_time-$timestamp;
    if($span<60){
        return "刚刚";
    }else if($span<3600){
        return intval($span/60)."分钟前";
    }else if($span<24*3600){
        return intval($span/3600)."小时前";
    }else if($span<(7*24*3600)){
        return intval($span/(24*3600))."天前";
    }else{
        return date('Y-m-d H:i:s',$timestamp);
    }
}

//身份证正则
function funccard($str){
    return (preg_match('/\d{17}[\d|x]|\d{15}/',$str))?true:false;
}
/**
 * 检测用户名
 * @author oydm<389602549@qq.com>  time|20140421
 */
function check_username($username) {
    $result = M("Member")->where("username='".$username."'")->find();
    if($result){
        return true;
    }else{
        return false;
    }
}
function check_tuijiancode($tuijian) {
    $result = M("Member")->where("tuijiancode='".$tuijian."'")->find();
    if($result){
        return true;
    }else{
        return false;
    }
}
/**
 * 检测邮箱
 * @author oydm<389602549@qq.com>  time|20140421
 */
function check_email($email) {
    $result = M("Member")->where("email='" . $email."'")->find();
    if($result){
        return false;
    }else{
        return true;
    }
}
/**
 * 检测身份证号码
 * @author 
 */
function check_idcard($idcard) {
    $result = M("Member")->where("idcard='" . $idcard."'")->find();
    if($result){
        return false;
    }else{
        return true;
    }
}
/**
 * 检测手机号码
 * @author 
 */
function check_phone($phone) {
    $where['phone|username']=$phone;
    $result = M("Member")->where($where)->select();
    if($result){
        return false;
    }else{
        return true;
    }
}

//调取等级信息
function getlevel($uid) {
    $levelConfig = F("levelConfig",'',CACHEDATA_PATH);
    $totalorder_num=M('order a')
        ->join("left join zz_order_time b on a.orderid=b.orderid")
        ->where(array('a.uid'=>$uid,'b.status'=>5))
        ->count();
    $totalorder_money=M('order a')
        ->join("left join zz_order_time b on a.orderid=b.orderid")
        ->where(array('a.uid'=>$uid,'b.status'=>5))
        ->sum("total");
    $totalorder_money=!empty($totalorder_money)?$totalorder_money:0;
    $totalorder_num=!empty($totalorder_num)?$totalorder_num:0;
    $level_total=0;
    $level_money=0;
    foreach ($levelConfig as $key => $value)
    {
    	if($value['total_startlimit']<=$totalorder_money&&$totalorder_money<$value['total_endlimit']){
            $level_money=$key;
        }
        if($value['frequency_startlimit']<=$totalorder_num&&$totalorder_num<$value['frequency_endlimit']){
            $level_total=$key;
        }
    }
    $level=min(array($level_total,$level_money));
    
    return $levelConfig[$level]['title'];
}
function getman($frendnum) {
    if ($frendnum < 6) {
        $num = 6 - $frendnum;
    } elseif ($frendnum < 26) {
        $num = 26 - $frendnum;
    } elseif ($frendnum < 51) {
        $num = 51 - $frendnum;
    } elseif ($frendnum < 101) {
        $num = 101 - $frendnum;
    } elseif ($frendnum < 201) {
        $num = 201 - $frendnum;
    } elseif ($frendnum < 401) {
        $num = 401 - $frendnum;
    } elseif ($frendnum < 1001) {
        $num = 1001 - $frendnum;
    } elseif ($frendnum < 2001) {
        $num = 2001 - $frendnum;
    } elseif ($frendnum < 5001) {
        $num = 5001 - $frendnum;
    } elseif ($frendnum < 10001) {
        $num = 10001 - $frendnum;
    } elseif ($frendnum < 30001) {
        $num = 30001 - $frendnum;
    } elseif ($frendnum < 100001) {
        $num = 100001 - $frendnum;
    } elseif ($frendnum > 100000) {
        $num = 100000 - $frendnum;
    }
    return $num;
}
function phpcode($data,$orderid){
    import("Vendor.phpqrcode.phpqrcode","",".php");
    $filename = "Uploads/ordercode/".$orderid .'.png';
    $errorCorrectionLevel = 'L';
    $matrixPointSize = 4;
    $QRcode=new \QRcode();
    $QRcode->png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    $filename="/".$filename;
    return $filename;
}
function fileext($file){
    return pathinfo($file, PATHINFO_EXTENSION);
}
/**
 * 生成缩略图
 * @author yangzhiguo0903@163.com<script cf-hash="f9e31" type="text/javascript">
 * @param string     源图绝对完整地址{带文件名及后缀名}
 * @param string     目标图绝对完整地址{带文件名及后缀名}
 * @param int        缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
 * @param int        缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
 * @param int        是否裁切{宽,高必须非0}
 * @param int/float  缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
 * @return boolean
 */
function img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0)
{
    if(!is_file($src_img))
    {
        return false;
    }
    $ot = fileext($dst_img);
    $otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
    $srcinfo = getimagesize($src_img);
    $src_w = $srcinfo[0];
    $src_h = $srcinfo[1];
    $type  = strtolower(substr(image_type_to_extension($srcinfo[2]), 1));
    $createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
    
    $dst_h = $height;
    $dst_w = $width;
    $x = $y = 0;
    
    /**
     * 缩略图不超过源图尺寸（前提是宽或高只有一个）
     */
    if(($width> $src_w && $height> $src_h) || ($height> $src_h && $width == 0) || ($width> $src_w && $height == 0))
    {
        $proportion = 1;
    }
    if($width> $src_w)
    {
        $dst_w = $width = $src_w;
    }
    if($height> $src_h)
    {
        $dst_h = $height = $src_h;
    }
    
    if(!$width && !$height && !$proportion)
    {
        return false;
    }
    if(!$proportion)
    {
        if($cut == 0)
        {
            if($dst_w && $dst_h)
            {
                if($dst_w/$src_w> $dst_h/$src_h)
                {
                    $dst_w = $src_w * ($dst_h / $src_h);
                    $x = 0 - ($dst_w - $width) / 2;
                }
                else
                {
                    $dst_h = $src_h * ($dst_w / $src_w);
                    $y = 0 - ($dst_h - $height) / 2;
                }
            }
            else if($dst_w xor $dst_h)
            {
                if($dst_w && !$dst_h)  //有宽无高
                {
                    $propor = $dst_w / $src_w;
                    $height = $dst_h  = $src_h * $propor;
                }
                else if(!$dst_w && $dst_h)  //有高无宽
                {
                    $propor = $dst_h / $src_h;
                    $width  = $dst_w = $src_w * $propor;
                }
            }
        }
        else
        {
            if(!$dst_h)  //裁剪时无高
            {
                $height = $dst_h = $dst_w;
            }
            if(!$dst_w)  //裁剪时无宽
            {
                $width = $dst_w = $dst_h;
            }
            $propor = min(max($dst_w / $src_w, $dst_h / $src_h), 1);
            $dst_w = (int)round($src_w * $propor);
            $dst_h = (int)round($src_h * $propor);
            $x = ($width - $dst_w) / 2;
            $y = ($height - $dst_h) / 2;
        }
    }
    else
    {
        $proportion = min($proportion, 1);
        $height = $dst_h = $src_h * $proportion;
        $width  = $dst_w = $src_w * $proportion;
    }
    
    $src = $createfun($src_img);
    $dst = imagecreatetruecolor($width ? $width : $dst_w, $height ? $height : $dst_h);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);
    
    if(function_exists('imagecopyresampled'))
    {
        imagecopyresampled($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    else
    {
        imagecopyresized($dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
    }
    $otfunc($dst, $dst_img);
    imagedestroy($dst);
    imagedestroy($src);
    return true;
}

function getarea($area) {
    $area1=explode(',', $area);
    foreach ($area1 as $key => $value) {
        # code...
        if($key==0){
            $arealist=M('area')->where('id=' . $value)->getField("name");
        }else{
            $list=M('area')->where('id=' . $value)->getField("name");
            $arealist=$arealist . $list;
        }
    }
    return $arealist;
}
function getposition($area,$addresss){
    $location=array();
    
    $arealist=getarea($area);
    $address=urlencode($arealist.$addresss);

    $url="http://api.map.baidu.com/geocoder/v2/?ak=3ac1342b68fec1069cd54e9af77f7b05&address=";
    $url=$url.$address;
    $url=$url."&output=json";
    $data=file_get_contents($url);
    $data=json_decode($data,true);
    if($data['status']==0){
        $location=$data['result']['location'];
    }
    
    return $location;
}
function getlinkage($catid){
    $data=M("linkage")->where("catid=".$catid)->order(array("listorder" => "desc","id" => "asc"))->select();
    return $data;
}
function getsnav($pid){
    $cate=M('productcate')->select();
    $nav=getParentsnav($cate,$pid);
    foreach ($nav as $key => $value) {
        # code...
        if($key==0){
            $navlist=$value['catname'];
        }else{
            $navlist=$navlist . '-' . $value['catname'];
        }
    }
    return $navlist;
}
function getParentsnav($cate,$pid){
    $arr=array();
    foreach ($cate as $v) {
        # code...
        if($v['id']==$pid){
            $arr[]=$v;
            $arr=array_merge(getParentsnav($cate,$v['parentid']),$arr);
        }
    }
    return $arr;
}
function getstoreinfo($storeid,$type='title'){
    $data=M("store")->where("id=".$storeid)->getField($type);
    return $data;
}
/**
 * 导出数据为excel表格
 *@param $data    一个二维数组,结构如同从数据库查出来的数组
 *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
 *@param $filename 下载的文件名
 *@examlpe 
 */
function exportexcel($data=array(),$title=array(),$filename='report'){
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel");  
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //导出xls 开始
    if (!empty($title)){
        foreach ($title as $k => $v) {
            $title[$k]=iconv("UTF-8", "GB2312",$v);
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)){
        foreach($data as $key=>$val){
            foreach ($val as $ck => $cv) {
                $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
            }
            $data[$key]=implode("\t", $data[$key]);
            
        }
        echo implode("\n",$data);
    }
}
function getChild($cate,$pid){
    $arr=array();
    foreach ($cate as $v) {
        # code...
        if($v['parentid']==$pid){
            $arr[]=$v['id'];
            $arr=array_merge(getChild($cate,$v['id']),$arr);
        }
    }
    return $arr;
}

function getsendtime($orderid){
    $order=M('order')->where(array('orderid'=>$orderid))->find();
    $timestamp=$order['sendtime']-$order['inputtime'];
    return intval($timestamp/60)."分钟";
}
function getExt($fileName){
    $ext = explode(".", $fileName);
    $ext = $ext[count($ext) - 1];
    return strtolower($ext);
}

function get_curl_json($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_HEADER, 0);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURL_SSLVERSION_SSL, 2);  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    $result = curl_exec($ch);
    if(curl_errno($ch)){
        print_r(curl_error($ch));
    }
    curl_close($ch);
    return json_decode($result,TRUE);
}

function getproduct_evaluation($pid,$level=5){
    $pid=  intval($pid);
    $level=  intval($level);
    $total=M('evaluation')->where(array('varname'=>'product','value'=>$pid))->count();
    $five_total=M('evaluation')->where(array('varname'=>'product','value'=>$pid,'total'=>$level))->count();
    $percent=sprintf("%.2f",(($five_total/$total)*100));
    return $percent;
}

function getproduct_evaluationpercent($pid,$level){
    $pid=  intval($pid);
    $total=M('evaluation')->where(array('varname'=>'product','value'=>$pid))->count();
    $five_total=M('evaluation')->where(array('varname'=>'product','value'=>$pid,'total'=>array('in',$level)))->count();

    $percent=sprintf("%.2f",(($five_total/$total)*100));
    return $percent;
}
function PushQueue($mid, $message_type, $receiver, $title,$description, $extras, $type){
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
    $data['type']=$type;
    M( "sendpush_queue" )->add($data);
}

function get_browsers(){
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        $br = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/i',$br)) {    
            $br = 'MSIE';
        }
        elseif (preg_match('/Firefox/i',$br)) {
            $br = 'Firefox';
        }
        elseif (preg_match('/Chrome/i',$br)) {
            $br = 'Chrome';
        }
        elseif (preg_match('/Safari/i',$br)) {
            $br = 'Safari';
        }
        elseif (preg_match('/Opera/i',$br)) {
            $br = 'Opera';
        }
        elseif (preg_match('/Android/i',$br)) {
            $br = 'Android';
        }
        elseif (preg_match('/iPhone/i',$br)) {
            $br = 'iPhone';
        }
        elseif (preg_match('/iPad/i',$br)) {
            $br = 'iPad';
        }else {
            $br = 'Other';
        }
        return $br;
    }
    else{
        return "unknow";
    } 
}

function getunit($unit){
    $unittext="";
    $ProductUnitConfig=F("ProductUnitConfig",'',CACHEDATA_PATH);
    foreach ($ProductUnitConfig as $value) {
        # code...s
        if($value['value']==$unit){
            $unittext=$value['title'];
        }
    }
    return $unittext;
}

function getcoords($lat,$lng,$scale="2"){
    //$scale=2;  //单位km
    $prelat=getdistance("1","100","2","100");
    $prelng=getdistance("100","1","100","2");
    $coords_x1=$lat - $scale/$prelat;
    $coords_x2=$scale/$prelat + $lat;
    
    $coords_y1=$scale/$prelng + $lng;
    $coords_y2=$lng - $scale/$prelng;

    $coords=array(
        'x1'=>$coords_x1,
        'x2'=>$coords_x2,
        'y1'=>$coords_y1,
        'y2'=>$coords_y2
    );
    return $coords;
}
function getdistance($lat1,$lng1,$lat2,$lng2)//根据经纬度计算距离
{
    //将角度转为狐度
    $radLat1=deg2rad($lat1);
    $radLat2=deg2rad($lat2);
    $radLng1=deg2rad($lng1);
    $radLng2=deg2rad($lng2);
    $a=$radLat1-$radLat2;//两纬度之差,纬度<90
    $b=$radLng1-$radLng2;//两经度之差纬度<180
    $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137;
    //$s = round($s * 1000) / 1000;
    return $s;
}
/**
 * 获取某一天的类型
 * 单个日期返回数字:    0:工作日   1:休息日   2:节假日
 * 多个日期返回数组
 * 用法举例
 * 检查一个日期是否为节假日 getDateType('20130101')
 * 检查多个日期是否为节假日 getDateType('20130101,20130103,20130105,20130201')
 * 获取2012年1月份节假日 getDateType('201201')
 * 获取2012年所有节假日 getDateType('2012')
 * 获取2013年1/2月份节假日 getDateType('201301,201302')
 * @param $date
 * @return int | array
 */
function getDateType($date)
{
    $date = str_replace('-', '', $date);

    $ch = curl_init();
    $url = "http://apis.baidu.com/xiaogg/holiday/holiday?d=$date";
    $header = array(
        'apikey: 494969c1cb7d9d1b05960c7257750648',
    );
    // 添加apikey到header
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch , CURLOPT_URL , $url);

    return json_decode(curl_exec($ch), true);
}

function getmonth($monthnum=4){
    $startdate=mktime(0,0,0,(int)date("m"),1,(int)date("Y"));
    $enddate=strtotime("+{$monthnum} month -1 days",$startdate);
    $dataarr=array();
    $i=0;
    do{
        $dataarr[$i]['name']=date("Y-m-d",$startdate);
        $dataarr[$i]['value']=$startdate;
        $startdate=strtotime("+1 days",$startdate);
        $i++;
    }while($startdate<=$enddate);
    return $dataarr;
}
function getAge($birthday) {
    $age = 0;
    $year = $month = $day = 0;

    if (is_array($birthday)) {
        extract($birthday);
    } else {
        if (strpos($birthday, '-') !== false) {
            list($year, $month, $day) = explode('-', $birthday);
            $day = substr($day, 0, 2); //get the first two chars in case of '2000-11-03 12:12:00'
        }
    }

    $age = date('Y') - $year;
    if (date('m') < $month || (date('m') == $month && date('d') < $day)) $age--;
    return $age;
}
function age($birth) {
    $age = array();
    $now = date('Ymd');
    //分解当前日期为年月日
    $nowyear = (int) ($now / 10000);
    $nowmonth = (int) (($now % 10000) / 100);
    $nowday = $now % 100;

    //分解出生日期为年月日
    $birthyear = (int) ($birth / 10000);
    $birthmonth = (int) (($birth % 10000) / 100);
    $birthday = $birth % 100;

    $year  = $nowyear - $birthyear;
    if ($birthmonth>$nowmonth){
        $year--;
    }else if($birthmonth==$nowmonth){
        if($birthday==29&&$birthmonth=2){
            if ($nowyear%400==0||(($nowyear%4==0)&&($nowyear%100!=0))){
                if($birthday>$nowday){
                    $year--;
                }
            }
        }
    }
    return $year;
}
/**
 * 根据生日中的月份和日期来计算所属星座
 *
 * @param string $birthday
 * @return string
 */
function get_constellation($birthday)
{
    $birth_year = explode('-', $birthday);
    $birth_month=$birth_year[1];
    $birth_date=$birth_year[2];
    //判断的时候，为避免出现1和true的疑惑，或是判断语句始终为真的问题，这里统一处理成字符串形式
    $birth_month = strval($birth_month);
    $constellation_name = array(
         '水瓶座','双鱼座','白羊座','金牛座','双子座','巨蟹座',
         '狮子座','处女座','天秤座','天蝎座)','射手座','摩羯座'
         );
    if ($birth_date <= 22)
    {
        if ('1' !== $birth_month)
        {
            $constellation = $constellation_name[$birth_month-2];
        }
        else
        {
            $constellation = $constellation_name[11];
        }
    }
    else
    {
        $constellation = $constellation_name[$birth_month-1];
    }
    return $constellation;
}
/**
 * 根据生日中的年份来计算所属生肖
 *
 * @param string $birthday
 * @return string
 */
function get_animal($birthday)
{
    $birth_year = explode('-', $birthday);
    $birth_year=$birth_year[0];
    //1900年是子鼠年
    $animal = array(
       '子鼠','丑牛','寅虎','卯兔','辰龙','巳蛇',
        '午马','未羊','申猴','酉鸡','戌狗','亥猪'
       );
    $my_animal = ($birth_year-1900)%12;
    return $animal[$my_animal];
}

function get_evaluationset($rid){
    $data=M('evaluation')->where(array('id'=>$rid,'isanonymous'=>0))->select();
    if($data){
        $total=$data['neat']+$data['safe']+$data['match']+$data['position']+$data['cost'];
        $percent=sprintf("%.2f",(($total/5)*100));
        $num=sprintf("%.1f",(($total/5)*100));
        $evaluation=array(
            'percent'=>$percent,
            'evaluation'=>$num,
            );
    }else{
        $evaluation=array(
            'percent'=>100.00,
            'evaluation'=>10.0,
            );
    }
    return $evaluation;
}
function gethouse_evaluation($hid){
    $hid=  intval($hid);
    $evaluation = M('evaluation')->where(array('hid'=>$hid,'isanonymous'=>0))->select();
    $totalnum=M('evaluation')->where(array('hid'=>$hid,'isanonymous'=>0))->count();
    $neat=0;
    $safe=0;
    $match=0;
    $position=0;
    $cost=0;
    foreach ($evaluation as $value)
    {
        $neat+=$value['neat'];
        $safe+=$value['safe'];
        $match+=$value['match'];
        $position+=$value['position'];
        $cost+=$value['cost'];
    }
    $total=$neat+$safe+$match+$position+$cost;
    $percent=sprintf("%.2f",(($total/5/$totalnum/10)*100));
    $num=sprintf("%.1f",(($total/5/$totalnum/10)*10));
    unset($evaluation);

    $neat=sprintf("%.1f",(($neat/$totalnum/10)*10));
    $safe=sprintf("%.1f",(($safe/$totalnum/10)*10));
    $match=sprintf("%.1f",(($match/$totalnum/10)*10));
    $position=sprintf("%.1f",(($position/$totalnum/10)*10));
    $cost=sprintf("%.1f",(($cost/$totalnum/10)*10));
    if(!empty($totalnum)){
        $evaluation=array(
            'percent'=>$percent,
            'evaluation'=>$num,
            'neat'=>$neat,
            'safe'=>$safe,
            'match'=>$match,
            'position'=>$position,
            'cost'=>$cost
        );
    }else{
        $evaluation=array(
            'percent'=>100.00,
            'evaluation'=>10.0,
            'neat'=>10.0,
            'safe'=>10.0,
            'match'=>10.0,
            'position'=>10.0,
            'cost'=>10.0
            );
    }
    return $evaluation;
}
function getroom_evaluation($rid){
    $rid=  intval($rid);
    $evaluation = M('evaluation')->where(array('rid'=>$rid,'isanonymous'=>0))->select();
    $totalnum=M('evaluation')->where(array('rid'=>$rid,'isanonymous'=>0))->count();
    $neat=0;
    $safe=0;
    $match=0;
    $position=0;
    $cost=0;
    foreach ($evaluation as $value)
    {
        $neat+=$value['neat'];
        $safe+=$value['safe'];
        $match+=$value['match'];
        $position+=$value['position'];
        $cost+=$value['cost'];
    }
    $total=$neat+$safe+$match+$position+$cost;
    $percent=sprintf("%.2f",(($total/5/$totalnum/10)*100));
    $num=sprintf("%.1f",(($total/5/$totalnum/10)*10));
    unset($evaluation);

    $neat=sprintf("%.1f",(($neat/$totalnum/10)*10));
    $safe=sprintf("%.1f",(($safe/$totalnum/10)*10));
    $match=sprintf("%.1f",(($match/$totalnum/10)*10));
    $position=sprintf("%.1f",(($position/$totalnum/10)*10));
    $cost=sprintf("%.1f",(($cost/$totalnum/10)*10));
    if(!empty($totalnum)){
        $evaluation=array(
            'percent'=>$percent,
            'evaluation'=>$num,
            'neat'=>$neat,
            'safe'=>$safe,
            'match'=>$match,
            'position'=>$position,
            'cost'=>$cost
        );
    }else{
        $evaluation=array(
            'percent'=>100.00,
            'evaluation'=>10.0,
            'neat'=>10.0,
            'safe'=>10.0,
            'match'=>10.0,
            'position'=>10.0,
            'cost'=>10.0
            );
    }
    return $evaluation;
}
function get_totalmoney($rid,$starttime,$endtime){
    $rid=  intval($rid);
    $starttime=  intval($starttime);
    $endtime=  intval($endtime);

    $data=M('room')->where(array('id'=>$rid))->find();
    $totalmoney=$money=0.00;
    while ( $starttime < $endtime) {
        # code...
        $money=$data['nomal_money'];
        $week=date("w",$value['value']);
        if(in_array($week, array(0,6))) {
            $money=$data['week_money'];
        }
        $holiday=M('holiday')->where(array('status'=>1,'_string'=>$starttime." <= enddate and ".$starttime." >= startdate"))->field("id,name,days")->find();
        if(!empty($holiday)){
            $money=$data['holiday_money'];
        }

        $totalmoney+=$money;
        $starttime=strtotime("+1 days",$starttime);
    }
    $totalmoney=sprintf("%.2f",$totalmoney);
    return $totalmoney;
}

/**
 * 数字转中文
 * @param Int $num 需要解析的数字
 * @param String $string 初始值
 * @return String
 * @author Anyon Zou <zoujingli@qq.com>
 * @date 2013-08-22 01:20
 */
function IntToCn($num, $string = array()) {
    if (!is_numeric($num)) {
        return $num;
    }
    $splits = array('100000000' => '亿', '10000' => '万');
    $chars = array('10000' => '万', '1000' => '千', '100' => '百', '10' => '十', '1' => '', '0' => '零');
    $ints = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十');
    /*
     * 拆分整数与小数
     */
    $nums = explode('.', "{$num}");
    $num = $nums[0];
    // 处理小数
    $dou = array();
    if (!empty($nums[1])) {
        foreach (str_split("{$nums[1]}") as $n) {
            if (is_numeric($n)) {
                $dou[] = $ints[intval($n)];
            }
        }
    }
    unset($nums);
    foreach ($splits as $step => $split) {
        $floor = $step > 0 ? floor($num / intval($step)) : '0';
        if ($floor > 0) {
            $string[] = IntToCn($floor) . $split;
            $num = fmod($num, $step);
        }
    }
    $string2 = array();
    foreach ($chars as $step => $char) {
        $floor = $step > 0 ? floor($num / intval($step)) : '0';
        if ($floor > 0) {
            $string[] = $string2[] = $ints[$floor] . $char;
            $num = fmod($num, $step);
        } else if ((count($string2) > 0 || (count($string) > 0 && $step != '10000')) && $string2[count($string) - 1] != $ints[0] && $num > 0) {
            $string[] = $ints[0];
        }
    }
    if (!empty($dou)) {
        $string = array_merge($string, array('点'), $dou);
    }
    return join('', $string);
}
function getsmstemplate($varname,$parm=array()){
    $content=M('config')->where(array('groupid'=>9,'varname'=>$varname))->getField("value");
    foreach ($parm as $key => $value)
    {
        $content=str_replace("{#".$key."#}",$value,$content);
    }
    return $content;
}
function getevaluation($evaluationpercent){
    if($evaluationpercent<=0){
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
    }elseif($evaluationpercent>0&&$evaluationpercent<=20){
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
    }elseif($evaluationpercent>20&&$evaluationpercent<=40){
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
    }elseif($evaluationpercent>40&&$evaluationpercent<=60){
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
    }elseif($evaluationpercent>60&&$evaluationpercent<=80){
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img43.png\" /></li>";
    }elseif($evaluationpercent>80&&$evaluationpercent<=100){
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
        echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>";
    }
}