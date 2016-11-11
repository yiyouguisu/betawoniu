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
            <div style="padding-top:28px;"></div>
            <div class="payment hidden">
                <div class="fl payment_main_11">
                    <span>填写订单</span>
                </div>
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
            </div>
        </div>
        <div class="wrap">
            <div class="payment_main2 clearfix">
                <span class="payment_main2_span">房东确认信息 :</span>
                <div class="payment_main3">
                    <div class="hidden payment_main3_01">
                        <div class="fl payment_main3_02">
                            <a href="{:U('Home/Room/show',array('id'=>$data['id']))}">
                                <img src="{$data.thumb}" style="width:184px;height:115px" />
                            </a>
                        </div>
                        <div class="fl payment_main3_03">
                            <a href="{:U('Home/Room/show',array('id'=>$data['id']))}" class="f28 c333">{$data.title}</a>
                            <div class="my_home7_list3_01 hidden">
                                <ul class="hidden my_home7_list3_01_ul fl">
                                    {:getevaluation($data['productinfo']['evaluationpercent'])}
                                </ul>
                                <span class="fl"><em class="">{$data.productinfo.evuation|default="10.0"}</em>分</span>
                                <div class="my_home7_list3_02 fl">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i class="f15 c999"><em class="f16">{$data.reviewnum|default="0"}</em>条评论</i>
                                </div>
                            </div>
                            <div class="my_home7_list3_03">
                                <img src="__IMG__/Icon/img44.png" />
                                <span class="f14 c333">客栈地址 : <em>{:getarea($data['hostelarea'])}{$data.hosteladdress}  </em></span>
                            </div>
                        </div>
                        <div class="fl payment_main3_04">
                            <div class="payment_main3_04_01">
                                <span>房东：</span>
                                <a href="{:U('Home/Member/detail',array('uid'=>$data['uid']))}" class="payment_main3_04_01_1">
                                    <div>
                                        <img src="{$data.head}" width="48px" height="48px" />
                                    </div>
                                    <i>{$data.nickname}</i>
                                </a>
                                <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['uid'],'type'=>'hostel'))}" class="payment_main3_04_01_2">在线聊天</a>
                            </div>
                            <div class="payment_main3_04_02">
                                <span>入住时段：</span>
                                <i class="f14 c333">入住：<em class="c333 f14">{$order.starttime|date="Y年m月d日",###}</em></i>
                                <label>{$order.days|default="0"}天</label>
                                <i class="f14 c333">离店：<em class="c333 f14">{$order.endtime|date="Y年m月d日",###}</em></i>
                            </div>
                            <div class="payment_main3_04_02">
                                <span>入住人数：</span>
                                <i class="c333 f14">{$order.num|default="0"}人</i>
                            </div>
                            <div class="payment_main3_04_02">
                                <span>入住间数：</span>
                                <i class="c333 f14">{$order.roomnum|default="0"}人</i>
                            </div>
                        </div>
                    </div>
                    <div style="height:38px;border-bottom: 1px solid #e5e5e5;"></div>
                    <div class="payment_main4 hidden">
                        <div class="fl payment_main4_1">
                                <span>￥<em id="money">{$order.money|default="0.00"}</em></span>
                                <i>（房费 x <i id="roomnum">{$order.roomnum|default="0"}</i>间）</i>
                                <label>—</label>
                                <span>￥<em id="discount">{$order.discount|default="0.00"}</em></span>
                                <i>（优惠券）</i>
                                <div>=</div>
                                <span>￥<em id="total">{$order.money|default="0.00"}</em></span>
                            </div>
                        <div class="payment_main4_3 fr">
                            <span class="f16 c666">应付金额 : </span>
                            <i class="f14">￥<em class="f25 total">{$order.money|default="0.00"}</em></i>
                        </div>
                    </div>
                </div>
                <form action="{:U('Home/Order/dopay')}" method="post">
                    <span class="payment_main2_span2">线上支付 :</span>
                    <div class="payment_main5">
                        <span>支付平台</span>
                        <div class="hidden" style="margin-top:50px;margin-bottom:30px;">
                            <div class="fl">
                                <input type="radio" name="paytype" value="1" />
                                <img src="__IMG__/img64.jpg" />
                            </div>
                            <div class="fl">
                                <input type="radio" name="paytype" value="2" />
                                <img src="__IMG__/img65.jpg" />
                            </div>
                            <div class="fl">
                                <input type="radio" name="paytype" value="3" />
                                <img src="__IMG__/img66.jpg" />
                            </div>
                        </div>
                    </div>
                    <div class="payment_main6 hidden">
                        <input type="hidden" name="orderid" value="{$order['orderid']}">
                        <input type="submit" value="去付款" />
                    </div>
                </form>
            </div>
        </div>
    </div>
<include file="public:foot" />