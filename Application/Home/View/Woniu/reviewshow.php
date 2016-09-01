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
            <a href="{:U('Home/Woniu/message')}">我的消息</a>
        </div>
    </div>
    <div class="wrap">
        <div class="Snail_home_main hidden">
            <div class="fl Snail_home_ml">
                <ul class="Snail_home_ml_ul">
                   <li class=""><!--Snail_home_ml_list-->
                        <a href="{:U('Home/Woniu/index')}">我的好友</a>
                    </li>
                    <li class="">
                        <!--Snail_home_ml_list2-->
                        <a href="{:U('Home/Woniu/chat')}">正在聊天</a>
                    </li>
                    <li class="Snail_home_ml_list2"><!--Snail_home_ml_list3-->
                        <a href="{:U('Home/Woniu/message')}">我的消息</a>
                    </li>
                </ul>
            </div>
            
            <div class="fl Snail_home_mr">
                <div class="wdxxxxsbhd_x">
                    <div class="wdxxxxsbhd_main">
                        <div class="wdxxxxsbhd_head">
                            <span>{$message.content}</span>
                        	<i>{$message.inputtime|date="Y年m月d日 H:i:s",###}</i>
                        </div>
                        <div class="wdxxxxsbhd_body">
                            <span>失败理由 :</span>
                            <p>{$data.remark}</p>
                        </div>
                        <eq name="message['varname']" value="failreviewparty">
	                        <div class="wdxxxxsbhd_foot">
	                            <div class="middle wdxxxxsbhd_foot2">
	                                <a href="{:U('Home/Party/show',array('id'=>$data['id']))}">
	                                    <img src="{$data.thumb}" style="width:96px;height:72px" />
	                                </a>
	                            </div>
	                            <div class="middle wdxxxxsbhd_foot3">
	                                <div class="wdxxxxsbhd_foot3_top">
	                                    <a href="{:U('Home/Party/show',array('id'=>$data['id']))}">{$data.title}</a>
	                                </div>
	                                <div class="wdxxxxsbhd_foot3_bottom">
	                                    <span class="f14 c999">时间 :<em class="f12 c666">{$data.starttime|date="Y-m-d",###} - {$data.endtime|date="Y-m-d",###}</em></span>
	                                    <span class="f14 c999">地点 :<em class="c666">{:getarea($data['area'])}{$data.address}</em></span>
	                                </div>
	                            </div>
	                            <div class="middle wdxxxxsbhd_foot4">
	                                <input type="button" value="去完善" onclick="window.location.href='{:U('Home/Party/edit',array('id'=>$data['id']))}'" />
	                            </div>
	                        </div>
	                    </eq>
	                    <eq name="message['varname']" value="failreviewnote">
	                        <div class="wdxxxxsbhd_foot">
	                            <div class="middle wdxxxxsbhd_foot2">
	                                <a href="{:U('Home/Note/show',array('id'=>$data['id']))}">
	                                    <img src="{$data.thumb}" style="width:96px;height:72px" />
	                                </a>
	                            </div>
	                            <div class="middle wdxxxxsbhd_foot3">
	                                <div class="wdxxxxsbhd_foot3_top">
	                                    <a href="{:U('Home/Note/show',array('id'=>$data['id']))}">{$data.title}</a>
	                                </div>
	                                
	                                <div class="wdxxxxsbys_main">
	                                    <i class="f12 c999">{$data.inputtime|date="Y-m-d H:i:s",###}</i>
	                                </div>
	                            </div>
	                            <div class="middle wdxxxxsbhd_foot4">
	                                <input type="button" value="去完善" onclick="window.location.href='{:U('Home/Note/edit',array('id'=>$data['id']))}'" />
	                            </div>
	                        </div>
	                    </eq>
	                    <eq name="message['varname']" value="failreviewhostel">
	                        <div class="wdxxxxsbhd_foot">
	                            <div class="middle wdxxxxsbhd_foot2">
	                                <a href="{:U('Home/Hostel/show',array('id'=>$data['id']))}">
	                                    <img src="{$data.thumb}" style="width:96px;height:72px" />
	                                </a>
	                            </div>
	                            <div class="middle wdxxxxsbhd_foot3">
	                                <div class="wdxxxxsbhd_foot3_top">
	                                    <a href="{:U('Home/Hostel/show',array('id'=>$data['id']))}">{$data.title}</a>
	                                </div>
	                                
	                                <div class="wdxxxxsbms_body">
	                                    <i>￥<em>{$data.money|default="0.00"}</em></i>
	                                    <span>起</span>
	                                </div>
	                            </div>
	                            <div class="middle wdxxxxsbhd_foot4">
	                                <input type="button" value="去完善" onclick="window.location.href='{:U('Home/Hostel/edit',array('id'=>$data['id']))}'" />
	                            </div>
	                        </div>
	                    </eq>
                    </div>
                </div>
            </div>
        </div>
    </div>
<include file="public:foot" />