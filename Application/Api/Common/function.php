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
function getuser($userid,$type="username") {
    $userid = intval($userid);
    $name = M("member")->where("id=" . $userid)->getField($type);
    return $name;
}


/**
 * 字符截取
 * @param string $string 需要截取的字符串
 * @param int $length 长度
 * @param string $dot
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
  return strlen($num) == 11 ? true : false;
}
function getaddress($uid) {
    $arealist=array();
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
    dump($array,true,'<pre>',false);
}
/**
 *第二个参数留空则为gb1232编码
 *echo Pinyin('PHP100中文网');
 *第二个参数随意设置则为utf-8编码
 *echo Pinyin('PHP100中文网',1);
 */
function Pinyin($_String, $_Code='gb2312'){
    $_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
    "|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
    "cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
    "|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
    "|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
    "|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
    "|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
    "|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
    "|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
    "|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
    "|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
    "she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
    "tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
    "|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
    "|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
    "zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";
    $_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
    "|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
    "|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
    "|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
    "|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
    "|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
    "|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
    "|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
    "|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
    "|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
    "|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
    "|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
    "|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
    "|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
    "|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
    "|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
    "|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
    "|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
    "|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
    "|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
    "|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
    "|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
    "|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
    "|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
    "|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
    "|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
    "|-10270|-10262|-10260|-10256|-10254";
    $_TDataKey = explode('|', $_DataKey);
    $_TDataValue = explode('|', $_DataValue);
    $_Data = (PHP_VERSION>='5.0') ? array_combine($_TDataKey, $_TDataValue) : _Array_Combine($_TDataKey, $_TDataValue);
    arsort($_Data);
    reset($_Data);
    if($_Code != 'gb2312') $_String = _U2_Utf8_Gb($_String);
    $_Res = '';
    for($i=0; $i<strlen($_String); $i++){
        $_P = ord(substr($_String, $i, 1));
        if($_P>160) {
            $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536;
        }
        $_Res .= _Pinyin($_P, $_Data);
    }
    return preg_replace("/[^a-z0-9]*/", '', $_Res);
}
function _Pinyin($_Num, $_Data){
    if ($_Num>0 && $_Num<160 ) return chr($_Num);
    elseif($_Num<-20319 || $_Num>-10247) return '';
    else {
        foreach($_Data as $k=>$v){
            if($v<=$_Num) break;
        }
        return $k;
    }
}
function _U2_Utf8_Gb($_C){
    $_String = '';
    if($_C < 0x80) $_String .= $_C;
    elseif($_C < 0x800){
        $_String .= chr(0xC0 | $_C>>6);
        $_String .= chr(0x80 | $_C & 0x3F);
    }elseif($_C < 0x10000){
        $_String .= chr(0xE0 | $_C>>12);
        $_String .= chr(0x80 | $_C>>6 & 0x3F);
        $_String .= chr(0x80 | $_C & 0x3F);
    } elseif($_C < 0x200000) {
        $_String .= chr(0xF0 | $_C>>18);
        $_String .= chr(0x80 | $_C>>12 & 0x3F);
        $_String .= chr(0x80 | $_C>>6 & 0x3F);
        $_String .= chr(0x80 | $_C & 0x3F);
    }
    return iconv('UTF-8', 'GB2312', $_String);
}
function _Array_Combine($_Arr1, $_Arr2){
    for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i];
    return $_Res;
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
 * @return string $birthday
 */
function getbirthday($idcard) {
    $bir = substr($idcard, 6, 8);
    $year = (int) substr($bir, 0, 4);
    $month = (int) substr($bir, 4, 2);
    $day = (int) substr($bir, 6, 2);
    return $year . "-" . $month . "-" . $day;
}
function age($uid){
    $uid=  intval($uid);
    $birthday=M('member')->where('id='.$uid)->getField("birthday");
    if(!empty($birthday)){
        $YTD=str_replace('/','-',$birthday);
        $YTD = strtotime($YTD);
        $year = date('Y', $YTD);
        if(($month = (date('m') - date('m', $YTD))) < 0){
            $year++;
        }else if ($month == 0 && date('d') - date('d', $YTD) < 0){
            $year++;
        }
        return date('Y') - $year;
    }else{
        return "未知";
    }

}
/**
 * 计算给定时间戳与当前时间相差的时间，并以一种比较友好的方式输出
 * @param int $timestamp [给定的时间戳]
 * @param int $current_time [要与之相减的时间戳，默认为当前时间]
 * @return string            [相差天数]
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
function getrole($uid) {
    $uid=  intval($uid);
    $group_id=M("member")->where("id=".$uid)->getField('group_id');
    return $group_id;
}
//获取已售量
function get_product_sale($pid) {
    $totalnum=M('takeaway')->where(array('pid'=>$pid))->sum("num");
    $unit=M('product')->where(array('id'=>$pid))->getField("unit");
    return $totalnum.$unit;
}
//获取已售量
function get_store_sale($storeid) {
    $pids=M('product')->where(array('storeid'=>$storeid))->getField("id",ture);
    $totalnum=M('takeaway')->where(array('pid'=>array('in',$pids)))->sum("num");
    return $totalnum;
}

function get_store_stock($storeid){
    $totalstock=M('product')->where(array('storeid'=>$storeid))->sum("stock");
    return $totalstock;
}

function getToken() {
    $url = "https://a1.easemob.com/968968/wjyaochisha/token";
    $body = array(
        "grant_type" => "client_credentials",
        "client_id" => "YXA6lcnnUD_2EeW6Ea_4KlE75A",
        "client_secret" => "YXA6UklicFbessg4gLmhSJHAzxnz2Ws"
    );
    $patoken = json_encode($body);
    $res = postCurl($url, $patoken);
    $tokenResult = array();
    $tokenResult = json_decode($res, true);
    return "Authorization: Bearer " . $tokenResult["access_token"];
}
function postCurl($url, $body, $header = array(), $method = "POST") {
    array_push($header, 'Accept:application/json');
    array_push($header, 'Content-Type:application/json');
    //array_push($header, 'http:multipart/form-data');

    $ch = curl_init();//启动一个curl会话
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //curl_setopt($ch, $method, 1);

    switch ($method){
        case "GET" :
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            break;
        case "POST":
            curl_setopt($ch, CURLOPT_POST,true);
            break;
        case "PUT" :
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            break;
        case "DELETE":
            curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
    }

    curl_setopt($ch, CURLOPT_USERAGENT, 'SSTS Browser/1.0');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);
    if (isset($body{3}) > 0) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }
    if (count($header) > 0) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }

    $ret = curl_exec($ch);
    $err = curl_error($ch);

    curl_close($ch);
    //clear_object($ch);
    //clear_object($body);
    //clear_object($header);

    if ($err) {
        return $err;
    }

    return $ret;
}
function httppost($reurl='',$rearray=array('')){
    if (empty($reurl) || empty($rearray)) {
        return (false);
    }

    $post_data = $rearray;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $reurl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'LightPass/X1 (With CURL)');
    $output = curl_exec($ch);
    if (!$output){
        return (false);
    }else {
        curl_close($ch);
        return $output;

    }
}

function https_request($url, $data_string) {
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
    $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return $return_content;
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
/*
 **获取签到积分
 */
function getsignintegral($lastintegral,$continuesign){
    $signintegral=0;
    if($continuesign>1){
        if($lastintegral<50){
            $signintegral=$lastintegral+5;
        }elseif($lastintegral==50){
            $signintegral=50;
        }
    }else{
        $signintegral=5;
    }
    return $signintegral;
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
            'percent'=>100,
            'evaluation'=>10,
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
            'neat'=>10,
            'safe'=>10,
            'match'=>10,
            'position'=>10,
            'cost'=>10
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
            'neat'=>10,
            'safe'=>10,
            'match'=>10,
            'position'=>10,
            'cost'=>10
            );
    }
    return $evaluation;
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
function getsmstemplate($varname,$parm=array()){
    $content=M('config')->where(array('groupid'=>9,'varname'=>$varname))->getField("value");
    foreach ($parm as $key => $value)
    {
        $content=str_replace("{#".$key."#}",$value,$content);
    }
    return $content;
}
