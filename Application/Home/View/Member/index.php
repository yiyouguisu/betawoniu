<include file="public:head" />
<include file="public:mheader" />
<div class="my_home" style="background: url('{$user.background|default='__IMG__/img51.jpg'}') no-repeat center center;    background-size: 1920px 200px;">
        <div class="wrap">
            <div class="my_home_main">
                <div class="my_home_main2">
                    <img src="{$user.head|default='/default_head.png'}"  width="110px" height="110px"/>
                </div>
                <div class="my_home_main3">
                    <div class="hidden my_home_main4">
                        <span class="fr" onclick="window.location.href='{:U('Home/Member/change_background')}'">我要换背景</span>
                    </div>
                    <div class="my_home_main5">
                        <div class="my_home_main5_01 middle">
                            <span class="f22 cw">{$user.nickname|default="未填写"}</span>
                            <eq name="user['houseowner_status']" value="1">
                                <img src="__IMG__/Icon/img37.png" /><a class="cw f14">个人房东</a>
                            </eq>
                            
                        </div>
                        <div class="my_home_main5_02 middle">
                            <span class="f22 cw">{$user.attentionnum|default="0"}</span>
                            <a class="cw f14">关注</a>
                        </div>
                        <div class="my_home_main5_02 middle">
                            <span class="f22 cw">{$user.fansnum|default="0"}</span>
                            <a class="cw f14">粉丝</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my_home2">
        <include file="Member:menu" />
    </div>
    <div class="hmain4">
        <div class="wrap hmain5 clearfix">
            <div class="fl hmain5_l">
                <div class="hmain5_l6 hidden">
                    <span>今日访问</span>
                    <ul class="hmain5_l6_ul hidden">
                        <volist name="user['viewlist']" id="vo">
                            <li class="fl">
                                <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                    <img src="{$vo.head}" style="width:58px;height:58px;border-radius: 50%;"/>
                                    <i>{$vo.nickname}</i>
                                </a>
                            </li>
                        </volist>
                    </ul>

                    <div class="hmain5_l6_2">
                        <p>累计访问：<em>{$user.viewnum|default="0"}</em></p>
                        <p>今日访问：<em>{$user.todayviewnum|default="0"}</em></p>
                    </div>
                </div>
                <div class="my_home3 hidden">
                    <span class="f18 c000">我的粉丝</span>
                    <i>( {$user.fansnum|default="0"} )</i>
                    <ul class="hidden my_home3_ul">
                         <volist name="user['fanslist']" id="vo">
                            <li class="fl">
                                <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                    <div class="my_home3_ul_list">
                                        <img src="{$vo.head}" style="width:58px;height:58px;"/>
                                    </div>
                                    <span class="f12 c000">{:str_cut($vo['nickname'],4)}</span>
                                </a>
                            </li>
                        </volist>
                    </ul>
                    <if condition="$user.fansnum gt 6">
                        <a href="" class="f14 c666">
                            查看更多
                        </a>
                    </if>
                </div>



            </div>
            <div class="fl hmain5_r">
                <div class="my_home4">
                    <p>{$user.nickname}，这里是你的家！</p>
                    <p>你可以发布并管理美宿、活动、游记和你的粉丝。现在开启蜗牛客的旅程！</p>
                </div>
                <div class="my_home6">
                    <ul class="my_home6_ul clearfix">
                        <li>
                            <a href="{:U('Home/Member/change_info')}">
                                <img src="__IMG__/Icon/img38.png" />
                                <span class="f18 c333">完善个人资料</span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Note/add')}">
                                <img src="__IMG__/Icon/img39.png" />
                                <span class="f18 c333">写游记</span>
                            </a>
                        </li>
                        <eq name="user['houseowner_status']" value="1">
                            <li>
                                <a href="{:U('Home/Party/add')}">
                                    <img src="__IMG__/Icon/img40.png" />
                                    <span class="f18 c333">发布活动</span>
                                </a>
                            </li>
                            <li>
                                <a href="{:U('Home/Hostel/add')}">
                                    <img src="__IMG__/Icon/img41.png" />
                                    <span class="f18 c333">发布美宿</span>
                                </a>
                            </li>
                            <else />
                            <li>
                                <a href="{:U('Home/Trip/add')}">
                                    <img src="__IMG__/Icon/img114.png" />
                                    <span class="f18 c333">制定行程</span>
                                </a>
                            </li>
                            <li>
                                <a href="{:U('Home/Member/myorder_hostel')}">
                                    <img src="__IMG__/Icon/img115.png" />
                                    <span class="f18 c333">我的订单</span>
                                </a>
                            </li>
                        </eq>
                    </ul>
                </div>
                <eq name="user['houseowner_status']" value="1">
                    <div class="my_home7">
                        <div class="my_home7_top">
                            <span class="f24 c333">我发布的美宿</span>
                        </div>
                        <ul class="my_home7_ul">
                            <volist name="myhostel" id="vo">
                                <li>
                                    <div class="my_home7_list">
                                        <div class="middle my_home7_list2">
                                            <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">
                                                <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:185px;height:116px" />
                                            </a>
                                        </div>
                                        <div class="middle my_home7_list3">
                                            <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}" class="f28 c333">{$vo.title}</a>
                                            <div class="my_home7_list3_01 hidden">
                                                <ul class="hidden my_home7_list3_01_ul fl">
                                                    <?php 
                                                    if($vo['evaluationpercent']>0&&$vo['evaluationpercent']<=20){
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                    }elseif($vo['evaluationpercent']>20&&$vo['evaluationpercent']<=40){
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                    }elseif($vo['evaluationpercent']>40&&$vo['evaluationpercent']<=60){
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                    }elseif($vo['evaluationpercent']>60&&$vo['evaluationpercent']<=80){
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                    }elseif($vo['evaluationpercent']>80&&$vo['evaluationpercent']<=100){
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                        echo "<li class=\"fl\"><img src=\"__IMG__/Icon/img42.png\" /></li>";
                                                    }
                                                    
                                                    ?>
                                                </ul>
                                                <span class="fl"><em class="">{$vo.evaluation|default="0"}</em>分</span>
                                                <div class="my_home7_list3_02 fl">
                                                    <img src="__IMG__/Icon/img10.png" />
                                                    <i class="f15 c999"><em class="f16">{$vo.reviewnum|default="0"}</em>条评论</i>
                                                </div>
                                            </div>
                                            <div class="my_home7_list3_03">
                                                <img src="__IMG__/Icon/img44.png" />
                                                <span class="f14 c333">客栈地址 : <em>{:getarea($vo['area'])}{$vo.address}  </em></span>
                                            </div>
                                        </div>
                                        <div class="middle my_home7_list4">
                                            <span class="c333 f18"><em>{$vo.money|default="0.00"}</em> 元起</span>
                                        </div>
                                    </div>
                                </li>
                            </volist>
                        </ul>
                    </div>
                    <div class="my_home8">
                        <div class="my_home8_top">
                            <span class="f24 c333">我发布的活动</span>
                        </div>
                        <div class="my_home8_top2">
                            <ul class="my_home8_top2_ul">
                                <volist name="myparty" id="vo">
                                    <li>
                                        <div class="hidden my_home8_top2_list">
                                            <div class="fl my_home8_top2_list2">
                                                <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">
                                                    <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:143px;height:89px" />
                                                </a>
                                            </div>
                                            <div class="fl my_home8_top2_list3">
                                                <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}" class="f24 c333">{$vo.title}</a>
                                                <div class="hidden my_home8_top2_list3_01">
                                                    <div class="fl my_home8_top2_list3_02">
                                                        <span class="f14 c999">时间 :<em class="f12 c666">{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em></span>
                                                        <span class="f14 c999">地点 :<em class="c666 f14">{:getarea($vo['area'])}{$vo.address} </em></span>
                                                    </div>
                                                    <div class="fr my_home8_top2_list3_03">
                                                        <eq name="vo['donestatus']" value="0">
                                                            <span class="my_home8_span2">进行中</span>
                                                            <else/>
                                                            <span class="my_home8_span1">已完成</span>
                                                        </eq>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </volist>   
                            </ul>
                            <if condition="$user.partynum gt 2">
                                <div class="my_home9_bottom2" style="padding-bottom: 30px;">
                                    <a href="{:U('Home/Member/myrelease')}">点击查看更多</a>
                                </div>
                            </if>
                        </div>
                    </div>
                </eq>
                <div class="my_home9">
                    <div class="my_home9_top">
                        <span class="f24 c333">我的美宿订单</span>
                    </div>
                    <div class="my_home9_bottom">
                        <ul class="my_home9_bottom_ul">
                            <volist name="hostelorder" id="vo">
                                <li>
                                    <div class="hidden my_home9_bottom_list1">
                                        <div class="fl my_home9_bottom_list2">
                                            <a href="{:U('Home/Room/show',array('id'=>$vo['productinfo']['rid']))}">
                                                <img class="pic" data-original="{$vo.productinfo.thumb}" src="__IMG__/default.jpg" style="width:142px;height:88px" />
                                            </a>
                                        </div>
                                        <div class="fl my_home9_bottom_list3">
                                            <div class="my_home9_bottom_list3_top">
                                                <a href="{:U('Home/Room/show',array('id'=>$vo['productinfo']['rid']))}" class="f24 c333">{:str_cut($vo['productinfo']['title'],20)}</a><i class="my_home9_a">美宿</i>
                                            </div>
                                            <div class="my_home9_bottom_list3_bottom">
                                                <div class="middle my_home9_bottom_list3_bottom2">
                                                    <label class="f22">￥</label><span class="f36">{$vo.productinfo.money|default="0.00"}</span><i class="f18">起</i>
                                                </div>
                                                <if condition="$vo['uid'] neq $user['id']">
                                                    <eq name="vo['status']" value="1">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">预定</span>
                                                            <a href="{:U('Home/Woniu/orderreview',array('orderid'=>$vo['orderid']))}" class="my_home9_bottom_list3_a3">去审核</a>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="2">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <a href="javascript:;" class="my_home9_bottom_list3_a1">待付款</a>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="3">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <eq name="vo['refund_status']" value="2">
                                                                <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                <else />
                                                                <span class="my_home9_bottom_list3_span2">已取消</span>
                                                            </eq>
                                                        </div>
                                                    </eq>
                                                    
                                                    <eq name="vo['status']" value="4">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <if condition="$vo['endtime'] lt time()">
                                                                <eq name="vo['evaluate_status']" value="0">
                                                                    <a href="javascript:;"  class="my_home9_bottom_list3_a2">待评价</a>
                                                                    <else />
                                                                    <eq name="vo['refund_status']" value="0">
                                                                        <a href="javascript:;"  class="my_home9_bottom_list3_a2">已完成</a>
                                                                    </eq>
                                                                    <eq name="vo['refund_status']" value="1">
                                                                        <span class="my_home9_bottom_list3_span2">退订</span>
                                                                        <a href="{:U('Home/Woniu/refundorderreview',array('orderid'=>$vo['orderid']))}"  class="my_home9_bottom_list3_a2">去审核</a>
                                                                    </eq>
                                                                    <eq name="vo['refund_status']" value="2">
                                                                        <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                    </eq>
                                                                    <eq name="vo['refund_status']" value="3">
                                                                        <span class="my_home9_bottom_list3_span2">待入住</span>
                                                                        <!-- <a href="javascript:;" class="my_home9_bottom_list3_a2 remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a> -->
                                                                    </eq>
                                                                </eq>
                                                                <else />
                                                                <eq name="vo['refund_status']" value="0">
                                                                    <a href="javascript:;"  class="my_home9_bottom_list3_a2">待入住</a>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="1">
                                                                    <span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="{:U('Home/Woniu/refundorderreview',array('orderid'=>$vo['orderid']))}"  class="my_home9_bottom_list3_a2">去审核</a>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="2">
                                                                    <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="3">
                                                                    <span class="my_home9_bottom_list3_span2">待入住</span>
                                                                    <!-- <a href="javascript:;" class="my_home9_bottom_list3_a2 remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a> -->
                                                                </eq>
                                                            </if>   
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="5">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">待入住</span>
                                                            <!-- <a class="my_home9_bottom_list3_a2 remark" href="javascript:;" data-remark="{$vo.review_remark}">失败原因</a> -->
                                                        </div>
                                                    </eq>
                                                    <else />
                                                    <eq name="vo['status']" value="1">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">预定</span>
                                                            <a href="javascript:;"  class="my_home9_bottom_list3_a3">待审核</a>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="2">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <a href="{:U('Home/Order/bookpay',array('orderid'=>$vo['orderid']))}" class="my_home9_bottom_list3_a1">去支付</a>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="3">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <eq name="vo['refund_status']" value="2">
                                                                <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                <else />
                                                                <span class="my_home9_bottom_list3_span2">已取消</span>
                                                            </eq>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="4">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <if condition="$vo['endtime'] lt time()">
                                                                <eq name="vo['evaluate_status']" value="0">
                                                                    <a href="{:U('Home/Order/evaluate',array('orderid'=>$vo['orderid']))}"  class="my_home9_bottom_list3_a2">我要评价</a>
                                                                    <else />
                                                                    <eq name="vo['refund_status']" value="0">
                                                                        <a href="javascript:;"  class="my_home9_bottom_list3_a2">已完成</a>
                                                                    </eq>
                                                                    <eq name="vo['refund_status']" value="1">
                                                                        <span class="my_home9_bottom_list3_span2">退订</span>
                                                                        <a href="javascript:;"  class="my_home9_bottom_list3_a2">待审核</a>
                                                                    </eq>
                                                                    <eq name="vo['refund_status']" value="2">
                                                                        <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                    </eq>
                                                                    <eq name="vo['refund_status']" value="3">
                                                                        <span class="my_home9_bottom_list3_span2">待入住</span>
                                                                        <!-- <a href="javascript:;"  class="my_home9_bottom_list3_a2 remark" data-remark="{$vo.refundreview_remark}" style="background: #8c8e85;">失败原因</a> -->
                                                                    </eq>
                                                                </eq>
                                                                <else />
                                                                <eq name="vo['refund_status']" value="0">
                                                                    <a href="javascript:;"  class="my_home9_bottom_list3_a2">待入住</a>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="1">
                                                                    <span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="javascript:;"  class="my_home9_bottom_list3_a2">待审核</a>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="2">
                                                                    <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="3">
                                                                    <span class="my_home9_bottom_list3_span2">待入住</span>
                                                                    <!-- <a href="javascript:;"  class="my_home9_bottom_list3_a2 remark" data-remark="{$vo.refundreview_remark}" style="background: #8c8e85;">失败原因</a> -->
                                                                </eq>
                                                            </if>
                                                                
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="5">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">待入住</span>
                                                            <!-- <a class="my_home9_bottom_list3_a2 remark" href="javascript:;" data-remark="{$vo.review_remark}">失败原因</a> -->
                                                        </div>
                                                    </eq>
                                                </if>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </volist>
                        </ul>
                    </div>
                    <div class="my_home9_bottom2">
                        <a href="{:U('Home/Member/myorder_hostel')}">点击查看更多</a>
                    </div>
                </div>
                <div class="my_home9">
                    <div class="my_home9_top">
                        <span class="f24 c333">我的活动订单</span>
                    </div>
                    <div class="my_home9_bottom">
                        <ul class="my_home9_bottom_ul">
                            <volist name="partyorder" id="vo">
                                <li>
                                    <div class="hidden my_home9_bottom_list1">
                                        <div class="fl my_home9_bottom_list2">
                                            <a href="{:U('Home/Party/show',array('id'=>$vo['productinfo']['aid']))}">
                                                <img class="pic" data-original="{$vo.productinfo.thumb}" src="__IMG__/default.jpg" style="width:142px;height:88px" />
                                            </a>
                                        </div>
                                        <div class="fl my_home9_bottom_list3">
                                            <div class="my_home9_bottom_list3_top">
                                                <a href="{:U('Home/Party/show',array('id'=>$vo['productinfo']['aid']))}" class="f24 c333">{:str_cut($vo['productinfo']['title'],20)}</a><i class="my_home9_a2">活动</i>
                                            </div>
                                            <div class="my_home9_bottom_list3_bottom">
                                                <div class="middle my_home9_bottom_list3_bottom2">
                                                   <p class="f14 c999">
                                                       时间 :<em class="f12 c666">{$vo.productinfo.starttime|date="Y-m-d",###} - {$vo.productinfo.endtime|date="Y-m-d",###}</em>
                                                   </p>
                                                    <p class="f14 c999">
                                                        地点 :<em class="c666 f14">{:getarea($vo['productinfo']['area'])}{$vo.productinfo.address}</em>
                                                    </p>
                                                </div>
                                                <if condition="$vo['uid'] neq $user['id']">
                                                    <eq name="vo['status']" value="2">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">待付款</span>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="3">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <eq name="vo['refund_status']" value="2">
                                                                <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                <else />
                                                                <span class="my_home9_bottom_list3_span2">已取消</span>
                                                            </eq>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="4">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <if condition="$vo['endtime'] lt time()">
                                                                <eq name="vo['refund_status']" value="0">
                                                                    <span class="my_home9_bottom_list3_span2">已完成</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="1">
                                                                    <span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="{:U('Home/Woniu/refundorderreview',array('orderid'=>$vo['orderid']))}" class="my_home9_bottom_list3_a1">去审核</a>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="2">
                                                                    <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="3">
                                                                    <span class="my_home9_bottom_list3_span2">待参加</span>
                                                                    <!-- <a href="javascript:;" class="my_home9_bottom_list3_a1 remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a> -->
                                                                </eq>
                                                                <else />
                                                                <eq name="vo['refund_status']" value="0">
                                                                    <span class="my_home9_bottom_list3_span2">待参加</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="1">
                                                                    <span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="{:U('Home/Woniu/refundorderreview',array('orderid'=>$vo['orderid']))}" class="my_home9_bottom_list3_a1">去审核</a>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="2">
                                                                    <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="3">
                                                                    <span class="my_home9_bottom_list3_span2">待参加</span>
                                                                    <!-- <a href="javascript:;" class="my_home9_bottom_list3_a1 remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a> -->
                                                                </eq>
                                                            </if>
                                                        </div>
                                                    </eq>
                                                    <else />
                                                    <eq name="vo['status']" value="2">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <a href="{:U('Home/Order/joinpay',array('orderid'=>$vo['orderid']))}"  class="my_home9_bottom_list3_a1">去支付</a>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="3">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <eq name="vo['refund_status']" value="2">
                                                                <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                <else />
                                                                <span class="my_home9_bottom_list3_span2">已取消</span>
                                                            </eq>
                                                        </div>
                                                    </eq>
                                                    <eq name="vo['status']" value="4">
                                                        <div class="my_home9_bottom_list3_bottom3 middle">
                                                            <if condition="$vo['endtime'] lt time()">
                                                                <eq name="vo['refund_status']" value="0">
                                                                    <span class="my_home9_bottom_list3_span2">已完成</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="1">
                                                                    <span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="javascript:;" class="my_home9_bottom_list3_a1">去审核</a>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="2">
                                                                    <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="3">
                                                                    <span class="my_home9_bottom_list3_span2">待参加</span>
                                                                    <!-- <a href="javascript:;" class="my_home9_bottom_list3_a1 remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a> -->
                                                                </eq>
                                                                <else />
                                                                <eq name="vo['refund_status']" value="0">
                                                                    <span class="my_home9_bottom_list3_span2">待参加</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="1">
                                                                    <span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="javascript:;" class="my_home9_bottom_list3_a1">去审核</a>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="2">
                                                                    <span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                </eq>
                                                                <eq name="vo['refund_status']" value="3">
                                                                    <span class="my_home9_bottom_list3_span2">待参加</span>
                                                                    <!-- <a href="javascript:;" class="my_home9_bottom_list3_a1 remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a> -->
                                                                </eq>
                                                            </if>
                                                        </div>
                                                    </eq>
                                                </if>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </volist>
                        </ul>
                    </div>
                    <div class="my_home9_bottom2">
                        <a href="{:U('Home/Member/myorder_party')}">点击查看更多</a>
                    </div>
                </div>
                <div class="hmain5_r6">
                    <div>
                        <div class="hmain5_r6_1">
                            <span>我的评论</span>
                        </div>
                        <ul class="hmain5_r6_ul">
                            <volist name="myreview" id="vo">
                                <eq  name="vo['varname']" value="note">
                                    <li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],20)}</a><span class="hmain5_r6_ul1_a">游记</span>
                                            </div>
                                            <p>{$vo.content}</p>
                                            <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                                        </div>
                                    </li>
                                </eq>
                                <eq  name="vo['varname']" value="party">
                                    <li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],20)}</a><span class="hmain5_r6_ul1_a2">活动</span>
                                            </div>
                                            <p>{$vo.content}</p>
                                            <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                                        </div>
                                    </li>
                                </eq>
                                <eq  name="vo['varname']" value="hostel">
                                    <li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],20)}</a><span class="hmain5_r6_ul1_a1">美宿</span>
                                            </div>
                                            <p>{$vo.content}</p>
                                            <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                                        </div>
                                    </li>
                                </eq>
                                <eq  name="vo['varname']" value="trip">
                                    <li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="{:U('Home/Trip/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],20)}</a><span class="hmain5_r6_ul1_a3">行程</span>
                                            </div>
                                            <p>{$vo.content}</p>
                                            <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                                        </div>
                                    </li>
                                </eq>
                            </volist>  
                        </ul>
                        <if condition="$user.reviewnum gt 4">
                            <a href="{:U('Home/Member/myreview')}">点击查看更多</a>
                        </if>
                    </div>
                </div>
                <div class="hmain5_r5">
                    <div>
                        <div class="hmain5_r5_top hidden">
                            <span class="fl">我的游记</span>
                            <a href="{:U('Home/Note/add')}">
                                <img src="__IMG__/Icon/img11.png" />发布游记
                            </a>
                        </div>
                        <ul class="hmain5_r5_ul">
                            <volist name="mynote" id="vo">
                                <li>
                                    <div class="hmain5_r5_list hidden">
                                        <div class="fl hmain5_r5_list1">
                                            <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">
                                                <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:202px; height:153px" />
                                            </a>
                                        </div>
                                        <div class="fl hmain5_r5_list2">
                                            <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">{$vo.title}</a>
                                            <i>{$vo.inputtime|date="Y-m-d",###}</i>
                                            <p>{:str_cut($vo['description'],30)}</p>
                                            <div class="hmain5_r5_list2_2 hidden">
                                                <div class="fl hidden hmain5_r5_list2_3">
                                                    <div class="fl">
                                                        <img style="margin-right:3px;" src="__IMG__/Icon/img10.png" /><i>{$vo.reviewnum|default="0"}</i><label>条点评</label>
                                                    </div>
                                                    <div class="fl">
                                                        <img style="margin-left:20px;margin-right:3px;" src="__IMG__/Icon/img9.png" /><label>{$vo.hit|default="0"}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </volist>
                        </ul>
                        <if condition="$user.notenum gt 2">
                            <a href="{:U('Home/Member/mynote')}">点击查看更多</a>
                        </if>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="My_message_details_main2 hide">
        <div class="My_message_details_main3">
        </div>
        <div class="My_message_details_main4">
            <div class="My_message_details_m4top">
                <span>请输入不通过的理由</span>
                <div class="My_message_details_m4topf"></div>
            </div>
            <div class="My_message_details_m4bottom">
                <span id="remark"></span>
                
            </div>
        </div>
    </div>
    <div class="Mask3 hide">
    </div>
    <script type="text/javascript">
        $(function () {
            $(".hmain5_l6_2 p").last().css({
                "border-top": "0px"
            })
            $(".remark").live("click",function(){
                var obj=$(this);
                var remark=obj.data("remark");
                $("#remark").text(remark);
                $(".My_message_details_main2").show();
                $("html,body").css({
                    "overflow-y": "hidden",
                })
                
            })
            $(".My_message_details_main3,.My_message_details_m4topf").click(function () {
                $(".My_message_details_main2").hide();
                $("html,body").css({
                    "overflow-y": "auto",
                })
            })
        })
    </script>
    <script type="text/javascript">
        $(function () {
            $(".hmain5_l3").last().css({
                "border-right": "0px",
            })
        })
    </script>
<include file="public:foot" />
