<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />

<include file="public:mheader" />
<div class="wrap">
        <div class="activity_main">
            <a href="/">首页</a>
            <span>></span>
            <a href="{:U('Home/Woniu/index')}">蜗牛</a>
            <span>></span>
            <a href="{:U('Home/Woniu/index')}">我的好友</a>
        </div>
    </div>
    <div class="wrap">
        <div class="Snail_home_main hidden">
            <div class="fl Snail_home_ml">
                <ul class="Snail_home_ml_ul">
                   <li class="Snail_home_ml_list2"><!--Snail_home_ml_list-->
                        <a href="{:U('Home/Woniu/index')}">我的好友</a>
                    </li>
                    <li class="">
                        <!--Snail_home_ml_list2-->
                        <a href="{:U('Home/Woniu/chat')}">正在聊天</a>
                    </li>
                    <li class=""><!--Snail_home_ml_list3-->
                        <a href="{:U('Home/Woniu/message')}">我的消息</a>
                    </li>
                </ul>
            </div>
            <div class="fl Snail_home_mr">
                <div class="Snail_home_mr_01 hidden">
                    <ul class="Snail_home_mr_01_ul hidden">
                        <volist name="data" id="vo">
                            <li>
                                <div class="pr Snail_home_mr_01_list">
                                    <div class="Snail_home_mr_01_list_head pa">
                                        <img src="{$vo.head}" />
                                    </div>
                                    <div class="Snail_home_mr_01_list2">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            {$vo.nickname}  
                                            <img src="__IMG__/Icon/img27.png" /> 
                                        </a>
                                    </div>
                                    <div class="Snail_home_mr_01_list3 hidden">
                                        <div class="fl Snail_home_mr_01_list3_01">
                                            <span>{$vo.attentionnum|default="0"}</span>
                                            <i>关注</i>
                                        </div>
                                        <div class="fl Snail_home_mr_01_list3_01">
                                            <span>{$vo.fansnnum|default="0"}</span>
                                            <i>粉丝</i>
                                        </div>
                                    </div>
                                    <div class="Snail_home_mr_01_list4 hidden">
                                        <span>已关注</span>
                                        <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$vo['uid']))}">发私信</a>
                                    </div>
                                </div>
                            </li>
                        </volist>
                    </ul>
                    <div class="Snail_home_a">
                        <div class="Snail_home_a1">
                            <span>共{$totalnum|default="0"}位好友</span>
                        </div>
                    </div>
                    <div class="Snail_home_b">
                        <span onclick="window.location.href='{:U('Home/Woniu/morefriend')}'">添加更多好友</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<include file="public:foot" />