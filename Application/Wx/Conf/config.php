<?php
return array(
	/* 主题设置 */
    'TMPL_TEMPLATE_SUFFIX'  =>  '.php',   // 默认模板文件后缀
     /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__PUBLIC__' => __ROOT__ . '/Public',
        '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/img',
        '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
        '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
        '__Editor__' => __ROOT__ . '/Public/Editor',
    ),
    /* 数据加密设置 */
    'AUTH_KEY' => '2b8L3j5b0H', //默认数据加密KEY
    'AUTO_TIME_LOGIN' =>"604800", //自动登录限制时间7*24*60*60
      /* SESSION 和 COOKIE 配置 */
    'SESSION_PREFIX' => 'Wx', //session前缀
    'COOKIE_PREFIX'  => 'Wx_', // Cookie前缀 避免冲突

    'TMPL_ACTION_ERROR'     =>  'Public:error',// 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   =>  'Public:success', // 默认成功跳转对应的模板文件

    'WEB_URL' => 'http://' . $_SERVER['HTTP_HOST'], // 网站域名

    'WEI_XIN_INFO' => array(
	// 'APP_ID'         => 'wxc3fdd30f0bf9d5a6',
	// 'APP_SECRET'   	 => '49694f321bc4e5bb09d9001ec417c837',
    'APP_ID'         => 'wxa20cb3ee5f9b058e',
    'APP_SECRET'      => 'b1bc90fa401f965118761ce60076a058',
	),
);