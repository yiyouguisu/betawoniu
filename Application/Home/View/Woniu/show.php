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
                <div class="My_message_details_m">
                    <div class="My_message_details_m_top">
                        <span>{$message.title}</span>
                        <i>{$message.inputtime|date="Y年m月d日 H:i:s",###}</i>
                    </div>
                    <div class="My_message_details_m_center">
                        <p>{$message.content} </p>
                    </div>
                    <div class="My_message_details_m_bottom">
                        <span>入住人数 : <em>{$order.num|default="0"}人</em></span>
                        <span>入住间数 : <em>{$order.roomnum|default="0"}间</em></span>
                        <span>入驻日期 : <em>{$order.starttime|date="Y年m月d日",###}  -  {$order.endtime|date="Y年m月d日",###} </em></span>
                    </div>
                </div>
                <div class="My_message_details_m2">
                    <div class="My_message_details_m2_top">
                        <span>预约人 :</span>
                    </div>
                    <div class="My_message_details_m2_bottom">
                        <div class="middle My_message_details_m2_bottom2">
                            <a href="">
                                <div>
                                    <img src="{$member.head|default='default_head.png'}" />
                                </div>
                            </a>
                        </div>
                        <div class="middle My_message_details_m2_bottom3">
                            <a href="{:U('Home/Member/detail',array('uid'=>$member['id']))}">{$order.realname}  <eq name="member['realname_status']" value="1"><img src="__IMG__/Icon/img27.png" /></eq></a>
                            <span>{$order.phone}</span>
                        </div>
                        <!-- <div class="middle My_message_details_m2_bottom4">
                            <span>
                                <img src="__IMG__/Icon/img97.png" />
                            </span>
                        </div> -->
                    </div>
                </div>
                <div class="My_message_details_m3 hidden">
                    <input class="adopt" type="button" value="通过审核" data-orderid="{$order.orderid}" />
                    <input class="Not_through Event_details5_6_list3_03" type="button" value="不通过审核" data-orderid="{$order.orderid}" />
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
                <span>不通过理由 :</span>
                <textarea name="remark"></textarea>
                <input type="hidden" name="orderid" value="">
                <input type="button" id="reportsave" value="确定提交" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".adopt").live("click",function () {
                var uid="{$user.id}";
                if(uid==''){
                    alert("请先登录！");var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                    return false;
                }
                var orderid=$(this).data("orderid");
                $.post("{:U('Home/Order/ajax_revieworder')}",{"orderid":orderid,"uid":uid,"status":2},function(d){
                    d=eval("("+d+")");
                    if(d.code==200){
                        alert(d.msg)
                        window.location.href="{:U('Home/Woniu/message')}";
                    }else{
                        alert(d.msg);
                    }
                });
            })
            $(".Event_details5_6_list3_03").live("click",function () {
                $(".My_message_details_main2").show();
                $("html,body").css({
                    "overflow-y": "hidden",
                })
                $("input[name='orderid']").val($(this).data("orderid"));
            })
            $(".My_message_details_main3,.My_message_details_m4topf").click(function () {
                $(".My_message_details_main2").hide();
                $("html,body").css({
                    "overflow-y": "auto",
                })
                $("textarea[name='remark']").val("");
            })
            $("#reportsave").live("click",function(){
                var uid="{$user.id}";
                if(uid==''){
                    alert("请先登录！");var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                    return false;
                }
                var remark=$("textarea[name='remark']").val();
                if(remark==''){
                    alert("不通过理由不能为空！");
                    return false;
                }
                var orderid=$("input[name='orderid']").val();
                $.post("{:U('Home/Order/ajax_revieworder')}",{"orderid":orderid,"remark":remark,"uid":uid,"status":5},function(d){
                    d=eval("("+d+")");
                    if(d.code==200){
                        $(".My_message_details_main2").hide();
                        $("html,body").css({
                            "overflow-y": "auto",
                        })
                        alert(d.msg)
                        window.location.href="{:U('Home/Woniu/message')}";
                    }else{
                        alert(d.msg);
                    }
                });
            })
        })
    </script>
    <div class="Mask3 hide">
    </div>
<include file="public:foot" />