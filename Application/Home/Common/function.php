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

/**
 * 获取用户名
 * 根据用户ID获取用户名
 * @access public 
 * @param int $userid 用户ID
 * @return string $username
 */
function getuser($userid) {
    $userid = intval($userid);
    $name = M("member")->where("id=" . $userid)->getField("username");
    echo $name;
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
/**
 * 检测手机号码是否已被使用
 * @param string $phone 需要检测手机号码
 * @return bool
 * @author yiyouguisu<741459065@qq.com> time|20151219
 */
function check_phone($phone) {
    $where['phone']=$phone;
    $result = M("Member")->where($where)->select();
    if($result){
        return false;
    }else{
        return true;
    }
}
/**
 * 检测手机号码格式是否正确
 * @param string $phone 需要检测手机号码
 * @return bool
 * @author yiyouguisu<741459065@qq.com> 20151219
 */
function isMobile($num) {
    return preg_match('#^13[\d]{9}$|14^[0-9]\d{8}|^15[0-9]\d{8}$|^18[0-9]\d{8}$#', $num) ? true : false;
}

/**
 * 检测用户名是否已被使用
 * @param string $username 需要检测的用户名
 * @return bool
 * @author yiyouguisu<741459065@qq.com> time|20151219
 */
function check_username($username) {
    $result = M("Member")->where("username='".$username."'")->find();
    if($result){
        return true;
    }else{
        return false;
    }
}
/**
 * 检测身份证号码是否已被使用
 * @param string $idcard 需要检测的身份证号码
 * @return bool
 * @author yiyouguisu<741459065@qq.com> time|20151219
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
 * 检测身份证号码格式是否正确
 * @param string $idcard 需要检测的身份证号码
 * @return bool
 * @author yiyouguisu<741459065@qq.com> time|20151219
 */
function funccard($str){
    return (preg_match('/\d{17}[\d|x]|\d{15}/',$str))?true:false;
}

function getlinkage($catid){
    $data=M('linkage')->where(array('catid'=>$catid))->order(array('listorder'=>'desc','id'=>'desc'))->select();
    return $data;
}
function getarea($area) {
    $area1=explode(',', $area);
    foreach ($area1 as $key => $value) {
        # code...
        if($key==0){
            $arealist=M('area')->where('id=' . $value)->getField("name");
        }else{
            $list=M('area')->where('id=' . $value)->getField("name");
            $arealist=$arealist ." ". $list;
        }
    }
    return $arealist;
}
function auto_save_image($url){
    set_time_limit(0);
    $basePath='/Uploads/images/pc/'.date('Ymd');
    $imgPath=$basePath."/".date('His')."_".rand(1000,9999).".jpg";
    if(!is_dir($_SERVER['DOCUMENT_ROOT'].$basePath)) @mkdir($_SERVER['DOCUMENT_ROOT'].$basePath,0777);
    $value = trim($url);
    $get_file = @file_get_contents($value);
    if($get_file)
    {
            $fp = @fopen($_SERVER['DOCUMENT_ROOT'].$imgPath,"w");
            @fwrite($fp,$get_file);
            @fclose($fp);
    }
    return $imgPath;
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