<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script src="__JS__/WdatePicker.js"></script>
<script src="__JS__/work.js"></script>
<include file="public:mheader" />
<div style="background:#f4f4f4;">
        <div class="wrap">
            <div class="Fill_in_order_main">
                <div class="hidden">
                    <span class="f24 c333 fl">订单详情：</span>
                    <if condition="$ownid eq $data['uid']">
                        <neq name="data['status']" value="4">
                            <a href="javascript:;" class="a4 fr cancel"  data-orderid="{$data['orderid']}">取消订单</a>
                            <a href="{:U('Home/Order/edithostelorder',array('orderid'=>$data['orderid']))}" class="a3 fr">修改订单</a>
                            <eq name="data['status']" value="2">
                                <a href="{:U('Home/Order/bookpay',array('orderid'=>$data['orderid']))}" class="a3 fr" data-orderid="{$data['orderid']}">立即付款</a>
                            </eq>
                        <else />
                            <eq name="data['refund_status']" value="0">
                                <if condition="$data['productinfo']['endtime'] gt time()">
                                    <a href="javascript:;" class="a3 fr refund"  data-orderid="{$data['orderid']}">申请退订</a>
                                </if>
                            </eq>
                            <eq name="data['refund_status']" value="1">
                                <a href="javascript:;" class="a3 fr"  data-orderid="{$data['orderid']}">退订申请中</a>
                            </eq>
                            <eq name="data['refund_status']" value="2">
                                <a href="javascript:;" class="a3 fr"  data-orderid="{$data['orderid']}">退订申请通过</a>
                            </eq>
                            <eq name="data['refund_status']" value="3">
                                <a href="javascript:;" class="a3 fr"  data-orderid="{$data['orderid']}">退订申请不通过</a>
                            </eq>
                        </neq>
                    </if>
                    
                </div>
                <i>订单号：{$data['orderid']}</i>
                <i>订单状态：<em>
                    <eq name="data['status']" value="1">等待房东确认</eq>
                    <eq name="data['status']" value="2">等待支付</eq>
                    <eq name="data['status']" value="3">
                        <eq name="data['refund_status']" value="2">
                            退订成功
                            <else />
                            已取消
                        </eq>
                    </eq>
                    <eq name="data['status']" value="4">
                        <if condition="$data['productinfo']['endtime'] lt time()">
                            <eq name="data['evaluate_status']" value="0">
                                待评价
                                <else />
                                
                                <eq name="data['refund_status']" value="0">
                                    已完成
                                </eq>
                                <eq name="data['refund_status']" value="1">
                                    退订申请中
                                </eq>
                                <eq name="data['refund_status']" value="2">
                                    退订成功
                                </eq>
                                <eq name="data['refund_status']" value="3">
                                    退订审核失败
                                    <span style="color:#666;margin-left: 20px;">失败原因：</span>{$data.refundreview_remark}
                                </eq>
                            </eq>
                            <else />
                            <eq name="data['refund_status']" value="0">
                                待入住
                            </eq>
                            <eq name="data['refund_status']" value="1">
                                退订申请中
                            </eq>
                            <eq name="data['refund_status']" value="2">
                                退订成功
                            </eq>
                            <eq name="data['refund_status']" value="3">
                                退订审核失败
                                <span style="color:#666;margin-left: 20px;">失败原因：</span>{$data.refundreview_remark}
                            </eq>
                        </if>   
                    </eq>
                    <eq name="data['status']" value="5">预定审核失败
                                <span style="color:#666;margin-left: 20px;">失败原因：</span>{$data.review_remark}</eq>
                </em></i>
            </div>
            <div class="payment hidden">
                <div class="fl payment_main_11">
                    <span>填写订单</span>
                </div>
                <eq name="data['status']" value="1">
                    <div class="fl payment_main_15">
                        <!--灰色样式类名 payment_main_02    蓝色样式类名payment_main_05-->
                        <span>房东确认</span>
                    </div>
                    <div class="fl payment_main_13">
                        <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
                        <span>支付钱款</span>
                    </div>
                    <div class="fl payment_main_14">
                        <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
                        <span>预订完成</span>
                    </div>
                </eq> 
                <eq name="data['status']" value="4">
                    <div class="fl payment_main_15">
                        <!--灰色样式类名 payment_main_02    蓝色样式类名payment_main_05-->
                        <span>房东确认</span>
                    </div>
                    <div class="fl payment_main_16">
                        <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
                        <span>支付钱款</span>
                    </div>
                    <div class="fl payment_main_17">
                        <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
                        <span>预订完成</span>
                    </div>
                </eq>
                <eq name="data['status']" value="2">
                    <div class="fl payment_main_15">
                        <!--灰色样式类名 payment_main_02    蓝色样式类名payment_main_05-->
                        <span>房东确认</span>
                    </div>
                    <div class="fl payment_main_16">
                        <!--灰色样式类名 payment_main_13    蓝色样式类名payment_main_06-->
                        <span>支付钱款</span>
                    </div>
                    <div class="fl payment_main_14">
                        <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
                        <span>预订完成</span>
                    </div>
                </eq> 
                <eq name="data['status']" value="5">
                    <div class="fl payment_main_15">
                        <!--灰色样式类名 payment_main_02    蓝色样式类名payment_main_05-->
                        <span>房东确认</span>
                    </div>
                    <div class="fl payment_main_13">
                        <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
                        <span>支付钱款</span>
                    </div>
                    <div class="fl payment_main_14">
                        <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
                        <span>预订完成</span>
                    </div>
                </eq> 
            </div>
        </div>
        <div class="wrap">
            <div class="payment_main2 clearfix">
                <span class="payment_main2_span">入住信息 :</span>
                <div class="payment_main3">
                    <div class="hidden payment_main3_01">
                        <div class="fl payment_main3_02">
                            <a href="{:U('Home/Room/show',array('id'=>$data['productinfo']['rid']))}">
                                <img src="{$data.productinfo.thumb}" style="width:184px;height:115px" />
                            </a>
                        </div>
                        <div class="fl payment_main3_03">
                            <a href="{:U('Home/Room/show',array('id'=>$data['productinfo']['rid']))}" class="f28 c333">{$data.productinfo.title}</a>
                            <div class="my_home7_list3_01 hidden">
                                <ul class="hidden my_home7_list3_01_ul fl">
                                    {:getevaluation($data['productinfo']['evaluationpercent'])}
                                </ul>
                                <span class="fl"><em class="">{$data.productinfo.evuation|default="10.0"}</em>分</span>
                                <div class="my_home7_list3_02 fl">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i class="f15 c999"><em class="f16">{$data.productinfo.reviewnum|default="0"}</em>条评论</i>
                                </div>
                            </div>
                            <div class="my_home7_list3_03">
                                <img src="__IMG__/Icon/img44.png" />
                                <span class="f14 c333">客栈地址 : <em>{:getarea($data['productinfo']['area'])}{$data.productinfo.address}  </em></span>
                            </div>
                        </div>
                        <div class="fl payment_main3_04">
                            <div class="payment_main3_04_01">
                                <if condition="$ownid eq $data['uid']">
                                    <span>房东：</span>
                                    <a href="{:U('Home/Member/detail',array('uid'=>$houseowner['id']))}" class="payment_main3_04_01_1">
                                        <div>
                                            <img src="{$houseowner.head}" width="48px" height="48px" />
                                        </div>
                                        <i>{$houseowner.nickname}</i>
                                    </a>
                                    <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$houseowner['id']))}" class="payment_main3_04_01_2">在线聊天</a>
                                </if>
                                <if condition="$ownid eq $data['productinfo']['houseownerid']">
                                    <span>预定人：</span>
                                    <a href="{:U('Home/Member/detail',array('uid'=>$data['uid']))}" class="payment_main3_04_01_1">
                                        <div>
                                            <img src="{$data.productinfo.head}" width="48px" height="48px" />
                                        </div>
                                        <i>{$data.productinfo.nickname}</i>
                                    </a>
                                    <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['productinfo']['uid']))}" class="payment_main3_04_01_2">在线聊天</a>
                                </if>
                                
                            </div>
                            <div class="payment_main3_04_02">
                                <span>入住时段：</span>
                                <i class="f14 c333">入住：<em class="c333 f14">{$data.productinfo.starttime|date="Y年m月d日",###}</em></i>
                                <label>{$data.productinfo.days|default="0"}天</label>
                                <i class="f14 c333">离店：<em class="c333 f14">{$data.productinfo.endtime|date="m月d日",###}</em></i>
                            </div>
                            <div class="payment_main3_04_02">
                                <span>入住人数：</span>
                                <i class="c333 f14">{$data.productinfo.num|default="0"}人</i>
                            </div>
                            <div class="payment_main3_04_02">
                                <span>入住间数：</span>
                                <i class="c333 f14">{$data.productinfo.roomnum|default="0"}间</i>
                            </div>
                        </div>

                    </div>
                    <div style="height:38px;border-bottom: 1px solid #e5e5e5;"></div>
                    <div class="payment_main4 hidden">
                        <div class="fl payment_main4_1">
                            <span>总价房价￥<em>{$data.totalmoney|default="0.00"}</em></span>
                            <i>（
                            <gt name="nomalnum" value="0">
                            平日房费{$data.productinfo.nomal_money|default="0.00"}元*{$data.productinfo.roomnum|default="0"}间*{$nomalnum|default="0"}晚
                            </gt>
                            <gt name="weeknum" value="0">
                            +周末房费{$data.productinfo.week_money|default="0.00"}元*{$data.productinfo.roomnum|default="0"}间*{$weeknum|default="0"}晚
                            </gt>
                            <gt name="holidaynum" value="0">
                            +法假房费{$data.productinfo.holiday_money|default="0.00"}元*{$data.productinfo.roomnum|default="0"}间*{$holidaynum|default="0"}晚
                            </gt>
                            ）</i>
                            <label>—</label>
                            <span>￥<em>{$data.discount|default="0.00"}</em></span>
                            <i>（优惠券）</i>
                            <div>=</div>
                            <span>￥<em>{$data.money|default="0.00"}</em></span>

                        </div>
                        <div class="payment_main4_3 fr">
                            <eq name="data['refund_status']" value="2">
                                <span class="f16 c666">退款金额 : </span>
                                <i class="f14">￥<em class="f25">{$data.refundmoney|default="0.00"}</em></i>
                            </eq>
                            <span class="f16 c666" style="margin-left: 30px;">订单金额 : </span>
                            <i class="f14">￥<em class="f25">{$data.money|default="0.00"}</em></i>
                        </div>
                    </div>
                </div>
                <span class="payment_main2_span2">入住人信息 :</span>
                <div class="Fill_in_order_main2">
                    <table class="Fill_in_order_main2_tab">
                        <thead>
                            <tr>
                                <td>姓名</td>
                                <td>身份证号码</td>
                            </tr>
                        </thead>
                        <tbody>
                            <volist name="data['productinfo']['book_member']" id="vo">
                                <tr>
                                    <td class="f16 c333">
                                        {$vo.realname}
                                    </td>
                                    <td class="f16 c333">{$vo.idcard}</td>
                                </tr>
                            </volist>
                        </tbody>
                    </table>
                </div>
                <span class="payment_main2_span2">预订人信息 :</span>
                <div class="Fill_in_order_main3">
                    <table class="Fill_in_order_main3_tab">
                        <thead>
                            <tr>
                                <td>姓名</td>
                                <td>身份证号码</td>
                                <td>手机号码</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$data.productinfo.realname}</td>
                                <td>{$data.productinfo.idcard}</td>
                                <td>{$data.productinfo.phone}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--弹窗一-->
    <div class="Popup">
        <div class="Mask_x hide"></div>
        <div class="Popup_show hide">
            <div class="Popup_top pr">
                <span>退订规则</span>
                <img class="img_hide3" src="__IMG__/Icon/img107.png" />
            </div>
            <div class="Popup_body">
                <div class="Popup_title">
                    <span>退订规则 :</span>
                </div>
                <div class="Popup_tab">
                    {$data.productinfo.content}
                </div>
                <div class="Popup_sub">
                    <input class="sub_x" type="button" value="继续退订" />
                </div>
            </div>
        </div>

        <div class="Popup2_Reason hide">
            <div class="Popup_top pr">
                <span>请输入退订原因</span>
                <img class="img_hide" src="__IMG__/Icon/img107.png" />
            </div>
            <div class="Popup2_Reason2">
                <span>退定原因</span>
                <textarea name="content"></textarea>
                <div class="Popup_sub">
                    <input type="hidden" name="orderid" value="{$data['orderid']}" />
                    <input class="sub_y" type="button" value="确认退订" />
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".refund").click(function () {
                $(".Mask_x,.Popup_show").show();
                $("html,body").css({
                    "overflow-y": "hidden"
                })
            })
            $(".Mask_x,.img_hide3").click(function () {
                $(".Mask_x,.Popup_show,.Popup2_Reason").hide();
                $("html,body").css({
                    "overflow-y": "scroll"
                })
            })
            $(".Reason2").click(function () {
                $(".Mask_x,.Popup2_Reason").show();
                $("html,body").css({
                    "overflow-y": "hidden"
                })
            })
            $(".sub_x").click(function () {
                $(".Popup_show").hide();
                $(".Popup2_Reason").show();
            })
            $(".Mask_x,.img_hide").click(function () {
                $(".Mask_x,.Popup_show,.Popup2_Reason").hide();
                $("html,body").css({
                    "overflow-y": "scroll"
                })
            })
            $(".sub_y").click(function(){
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

                var orderid=$("input[name='orderid']").val();
                var content=$("textarea[name='content']").val();
                if(content==''){
                    alert("请填写退定原因！");
                    return false;
                }
                $.post("{:U('Home/Order/ajax_refundapply')}",{"orderid":orderid,"uid":uid,"content":content},function(d){
                    d=eval("("+d+")");
                    if(d.code==200){
                        alert(d.msg)
                        window.location.href="{:U('Home/Member/myorder_hostel')}";
                    }else{
                        alert(d.msg);
                    }
                });
            })
        })
    </script>

<include file="public:foot" />
<script>
    $(function(){
        $('a.cancel').click(function () {
            if (confirm("您确定要取消此订单？")) {
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
                $.post("{:U('Home/Order/ajax_cancelorder')}",{"orderid":orderid,"uid":uid},function(d){
                    d=eval("("+d+")");
                    if(d.code==200){
                        alert(d.msg)
                        window.location.href="{:U('Home/Member/myorder_hostel')}";
                    }else{
                        alert(d.msg);
                    }
                });
            } else {
                return false;
            }
        });
    })
</script>