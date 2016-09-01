<?php
@mysql_connect("localhost","ziyuli","R6G4f6z7")or die("server error");
@mysql_select_db("ziyuli") or die("数据库不存在或不可用！");
//设置数据的字符集utf-8
mysql_query("SET NAMES 'utf8'");
mysql_query("SET CHARACTER_SET_CLIENT=utf8");
mysql_query("SET CHARACTER_SET_RESULTS=utf8");

date_default_timezone_set("Asia/Shanghai");
//设定用于一个脚本中所有日期时间函数的本地默认时区
//$timezone_identifier = "PRC";		//本地时区标识符
//date_default_timezone_set($timezone_identifier);

?>
