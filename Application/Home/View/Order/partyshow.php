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
    	                    <a href="javascript:;" class="a4 fr cancel" data-orderid="{$data['orderid']}">取消订单</a>
    	                    <a href="{:U('Home/Order/editpartyorder',array('orderid'=>$data['orderid']))}" class="a3 fr">修改订单</a>
                            <a href="{:U('Home/Order/joinpay',array('orderid'=>$data['orderid']))}" class="a3 fr" data-orderid="{$data['orderid']}">立即付款</a>
                        <else />
                            <eq name="data['refund_status']" value="0">
                                <if condition="$data['productinfo']['endtime'] gt time()">
                                    <a href="javascript:;" class="a3 fr refund"  data-orderid="{$data['orderid']}">取消报名</a>
                                </if>
                            </eq>
                            <eq name="data['refund_status']" value="1">
                                <a href="javascript:;" class="a3 fr" style="width:105px;"  data-orderid="{$data['orderid']}">取消报名申请中</a>
                            </eq>
                            <eq name="data['refund_status']" value="2">
                                <a href="javascript:;" class="a3 fr"  data-orderid="{$data['orderid']}">取消报名成功</a>
                            </eq>
                            <eq name="data['refund_status']" value="3">
                                <a href="javascript:;" class="a3 fr"  data-orderid="{$data['orderid']}">取消报名失败</a>
                            </eq>
                        </neq>
                    </if>
                </div>
                <i>订单状态：<em>
                	<eq name="data['status']" value="1">用户确认订单成功</eq>
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
                            已完成
                            <else />
                            <eq name="data['refund_status']" value="0">
                                待参加
                            </eq>
                            <eq name="data['refund_status']" value="1">
                                退订中
                            </eq>
                            <eq name="data['refund_status']" value="2">
                                退订成功
                            </eq>
                            <eq name="data['refund_status']" value="3">
                                退订审核失败
                            </eq>
                        </if>
                    </eq>
                </em></i>
            </div>
            <div class="payment hidden">
                <div class="middle payment_main_01">
                    <span>填写预订信息</span>
                </div>
                <eq name="data['status']" value="4">
                	<div  class="middle payment_main_06">
	                    <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
	                    <span>支付钱款</span>
	                </div>
	                <div  class="middle payment_main_07">
	                    <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
	                    <span>报名成功</span>
	                </div>
	            </eq>
	        	<eq name="data['status']" value="2">
	                <div  class="middle payment_main_06">
	                    <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
	                    <span>支付钱款</span>
	                </div>
	                <div  class="middle payment_main_04">
	                    <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
	                    <span>报名成功</span>
	                </div>
                </eq>
	                
		        
                
            </div>
        </div>
        <div class="wrap">
            <div class="payment_main2 clearfix">
                <span class="payment_main2_span">活动信息 :</span>
                <div class="payment_main3">
                    <div class="hidden payment_main3_01">
                        <div class="fl payment_main3_02">
                            <a href="{:U('Home/Party/show',array('id'=>$data['productinfo']['aid']))}">
                                <img src="{$data.productinfo.thumb}" style="width:184px;height:115px" />
                            </a>
                        </div>
                        <div class="fl payment_main3_03">
                            <a href="{:U('Home/Party/show',array('id'=>$data['productinfo']['aid']))}" class="f28 c333">{$data.productinfo.title}</a>

                            <div class="Activity_Registration_a">
                                <div class="middle Activity_Registration_b">
                                    <span>活动人数 : <em>{$data.productinfo.start_numlimit|default="0"}-{$data.productinfo.end_numlimit|default="0"}人</em></span>
                                </div>
                                <div class="Activity_Registration_c middle">
                                    <span>已参与 :</span>
                                    <volist name="data['productinfo']['joinlist']" id="v">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$v['id']))}" class="middle">
                                            <img src="{$v.head}" width="30px" height="30px" />
                                        </a>
                                    </volist>
                                    <i>( {$data.productinfo.joinnum|default="0"}人 )</i>
                                </div>
                            </div>
                            <div class="my_home7_list3_03">
                                <img src="__IMG__/Icon/img44.png" />
                                <span class="f14 c333">地址 : <em>{:getarea($data['productinfo']['area'])}{$data.productinfo.address}  </em></span>
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
                                <span>活动时间：</span>
                                <i class="f14 c333"><em class="c333 f14">{$data.productinfo.starttime|date="Y年m月d日",###}</em></i>
                                <label>至<label>
                                <i class="f14 c333"><em class="c333 f14">{$data.productinfo.endtime|date="Y年m月d日",###}</em></i>
                            </div>
                            <div class="payment_main3_04_02">
                                <span>活动费用：</span>
                                <i class="c333 f14">￥{$data.productinfo.money|default="0.00"}人</i>
                            </div>
                        </div>
                    </div>
                    <div style="height:38px;border-bottom: 1px solid #e5e5e5;"></div>
                    <div class="payment_main4 hidden">
                        <div class="fl payment_main4_1">
                            <span>￥<em>{$data.productinfo.money|default="0.00"}</em></span>
                            <i>（活动费用 x {$data.productinfo.num|default="0"}人）</i>
                            <label>—</label>
                            <span>￥<em>{$data.discount|default="0.00"}</em></span>
                            <i>（优惠券）</i>
                            <div>=</div>
                            <span>￥<em>{$data.money|default="0.00"}</em></span>
                        </div>
                        <div class="payment_main4_3 fr">
                            <eq name="data['refund_status']" value="2">
                                <span class="f16 c666">退款金额 : </span>
                                <i class="f14">￥<em class="f25">{$data.money|default="0.00"}</em></i>
                            </eq>
                            <span class="f16 c666" style="margin-left: 30px;">订单金额 : </span>
                            <i class="f14">￥<em class="f25">{$data.money|default="0.00"}</em></i>
                        </div>
                    </div>
                </div>

                <span class="payment_main2_span2">参与者信息 :</span>
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
                <span class="payment_main2_span2">主报人信息 :</span>
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
                <span>取消报名规则</span>
                <img class="img_hide3" src="__IMG__/Icon/img107.png" />
            </div>
            <div class="Popup_body">
                <div class="Popup_title">
                    <span>取消报名规则 :</span>
                </div>
                <div class="Popup_tab">
                    {$data.productinfo.cancelrule}
                </div>
                <div class="Popup_sub">
                    <input class="sub_x" type="button" value="继续取消" />
                </div>
            </div>
        </div>

        <div class="Popup2_Reason hide">
            <div class="Popup_top pr">
                <span>请输入取消原因</span>
                <img class="img_hide" src="__IMG__/Icon/img107.png" />
            </div>
            <div class="Popup2_Reason2">
                <span>取消原因</span>
                <textarea name="content"></textarea>
                <div class="Popup_sub">
                    <input type="hidden" name="orderid" value="{$data['orderid']}" />
                    <input class="sub_y" type="button" value="确认取消" />
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
                        window.location.href="{:U('Home/Member/myorder_party')}";
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
                        window.location.href="{:U('Home/Member/myorder_party')}";
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