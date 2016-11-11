<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <script src="__JS__/jquery.jqtransform.js"></script>
<include file="public:mheader" />
<div style="background:#f4f4f4;">
        <div class="wrap">
            <div style="padding-top:28px;"></div>
            <div class="payment hidden">
                <div class="middle payment_main_01">
                    <span>填写预订信息</span>
                </div>
                <div class="middle payment_main_06">
                    <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
                    <span>支付钱款</span>
                </div>
                <div class="middle payment_main_04">
                    <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
                    <span>报名成功</span>
                </div>
            </div>
        </div>
        <div class="wrap">
            <div class="payment_main2 clearfix">
                <span class="payment_main2_span">活动确认信息 :</span>
                <div class="payment_main3">
                    <div class="hidden payment_main3_01">
                        <div class="fl payment_main3_02">
                            <a href="{:U('Home/Party/show',array('id'=>$data['id']))}">
                                <img src="{$data.thumb}" style="width:184px;height:115px" />
                            </a>
                        </div>
                        <div class="fl payment_main3_03">
                            <a href="{:U('Home/Party/show',array('id'=>$data['id']))}" class="f28 c333">{$data.title}</a>

                            <div class="Activity_Registration_a">
                                <div class="middle Activity_Registration_b">
                                    <span>活动人数 : <em>{$data.start_numlimit|default="0"}-{$data.end_numlimit|default="0"}人</em></span>
                                </div>
                                <div class="Activity_Registration_c middle">
                                    <span>已参与 :</span>
                                    <volist name="data['joinlist']" id="v">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$v['id']))}" class="middle">
                                            <img src="{$v.head}" width="30px" height="30px" />
                                        </a>
                                    </volist>
                                    <i>( {$data.joinnum|default="0"}人 )</i>
                                </div>
                            </div>
                            <div class="my_home7_list3_03">
                                <img src="__IMG__/Icon/img44.png" />
                                <span class="f14 c333">地址 : <em>{:getarea($data['area'])}{$data.address}  </em></span>
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
                                <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['uid'],'type'=>'party'))}" class="payment_main3_04_01_2">在线聊天</a>
                            </div>
                            <div class="payment_main3_04_02">
                                <span>活动时间：</span>
                                <i class="f14 c333"><em class="c333 f14">{$data.starttime|date="Y年m月d日",###}</em></i>
                                <label>至<label>
                                <i class="f14 c333"><em class="c333 f14">{$data.endtime|date="Y年m月d日",###}</em></i>
                            </div>
                            <div class="payment_main3_04_02">
                                <span>活动费用：</span>
                                <i class="c333 f14">￥{$data.money|default="0.00"}人</i>
                            </div>
                        </div>
                    </div>
                    <div style="height:38px;border-bottom: 1px solid #e5e5e5;"></div>
                    <div class="payment_main4 hidden">
                        <div class="fl payment_main4_1">
                            <span>￥<em id="money">{$data.money|default="0.00"}</em></span>
                            <i>（活动费用 x <i id="mannum">{$order.num|default="0"}</i>人）</i>
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