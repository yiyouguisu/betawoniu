<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <script src="__JS__/jquery.jqtransform.js"></script>
<include file="public:mheader" />
<div style="background:#f4f4f4;">
        <div class="wrap">
            <div class="payment_main2 clearfix">
                <div style="height:40px;"></div>
                <div class="payment_main3">
                    <div class="payment_main3_01">
                        <div class="middle payment_main3_02">
                            <eq name="data['ordertype']" value='1'>
                                <a href="{:U('Home/Room/show',array('id'=>$data['productinfo']['rid']))}">
                                    <img src="{$data.productinfo.thumb}" style="width:184px;height:115px" />
                                </a>
                                <else />
                                <a href="{:U('Home/Party/show',array('id'=>$data['productinfo']['aid']))}">
                                    <img src="{$data.productinfo.thumb}" style="width:184px;height:115px" />
                                </a>
                            </eq>
                        </div>
                        <eq name="data['ordertype']" value='1'>
                            <div class="middle payment_main3_03">
                                <a href="{:U('Home/Room/show',array('id'=>$data['id']))}" class="f28 c333">{:str_cut($data['productinfo']['title'],10)}</a>
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
                        <else />
                            <div class="middle payment_main3_03">
                                <a href="{:U('Home/Party/show',array('id'=>$data['productinfo']['aid']))}" class="f28 c333">{:str_cut($data['productinfo']['title'],10)}</a>

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
                        </eq>
                        <div class="middle WeChat_payment_main3 tr">
                            <span>应付金额 : </span>
                            <i class="f14">￥<em class="f25">{$data.money|default="0.00"}</em></i>
                        </div>
                    </div>
                </div>
                <div class="WeChat_payment_main">
                    <span>微信扫码支付 :</span>
                    <div class="WeChat_payment_main2">
                        <img src="{$data.wxcode}" style="width:254px;height:254px" />
                        <span>扫一扫上图二维码，立刻进行微信支付</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    window.setInterval(function(){
        var orderid="{$data.orderid}";
        var ordertype="{$data.ordertype}";
        if(orderid!=""){
            $.post("{:U('Home/Order/ajax_getpaystatus')}",{"orderid":orderid},function(d){
                if(d.code==200){
                    if(ordertype=="1"){
                        window.location.href="/index.php/Home/Order/bookfinish/orderid/"+orderid;
                    }else if(ordertype=="2"){
                        window.location.href="/index.php/Home/Order/joinsuccess/orderid/"+orderid;
                    }
                }
            });
        }       
    },1000);
        
</script>
<include file="public:foot" />