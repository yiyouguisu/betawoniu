<include file="public:head" />
<include file="public:mheader" />

	<include file="Member:member" />
    <div class="order_main2">
        <div class="wrap clearfix">
            <include file="Member:member_left2" />
            <div class="fl order_main2_2">
                <div class="order_main2_201">
                    <p>我的订单</p>
                    <div class="order_main2_201_list">
                        <a href="order2.html" class="order_list_a1">美宿</a>
                        <a href="order.html" class="">活动</a>
                    </div>
                    <div class="order_main2_201_list2">
                        <span class="order_list_a2">已完成</span>
                        <span>未付款</span>
                    </div>
                    <div>
                        <div class="order_main3">
                            <ul class="order_main3_ul">
                                <li>
                                    <div class="hidden">
                                        <div class="fl order_main3_list">
                                            <a href="">
                                                <img src="__IMG__/img70.jpg" />
                                            </a>
                                        </div>
                                        <div class="fl order_main3_list2">
                                            <div class="order_main3_list2_top hidden">
                                                <a href="" class="f24 c333 fl">一起去南极看企鹅</a>
                                                <a href="" class="fr order_main3_list2_top_a2">查看订单详情 ></a>
                                            </div>
                                            <div class="order_main3_list2_bottom hidden">
                                                <div class="fl hidden order_main3_list2_bottom4">
                                                    <i class="f22">￥</i><span class="f36">600</span><label class="f18">起</label>
                                                </div>
                                                <div class="fr order_main3_list2_bottom2 ">
                                                    <i>已完成</i>
                                                    <a href="">去评价</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="order_main3 hide">
                            <ul class="order_main3_ul">
                                <li>
                                    <div class="hidden">
                                        <div class="fl order_main3_list">
                                            <a href="">
                                                <img src="__IMG__/img70.jpg" />
                                            </a>
                                        </div>
                                        <div class="fl order_main3_list2">
                                            <div class="order_main3_list2_top hidden">
                                                <a href="" class="f24 c333 fl">一起去南极看企鹅</a>
                                                <a href="" class="fr order_main3_list2_top_a2">查看订单详情 ></a>
                                            </div>
                                            <div class="order_main3_list2_bottom hidden">
                                                <div class="fl hidden order_main3_list2_bottom4">
                                                    <i class="f22">￥</i><span class="f36">600</span><label class="f18">起</label>
                                                </div>
                                                <div class="fr order_main3_list2_bottom3 ">
                                                    <i>未付款</i>
                                                    <a href="">去支付</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".order_main2_1_ul li").last().css({
                "border-bottom": "0"
            });
            var $ml = $(".order_main2_201_list2 span");
            $ml.click(function () {
                $(".order_main3").hide();
                $(this).addClass('order_list_a2').siblings().removeClass('order_list_a2');
                var cs = $(".order_main3")[getObjectIndex(this, $ml)];
                $(cs).show();
            });
            $(".hmain5_l6_2 p").last().css({
                "border-top": "0px"
            })
        })
        function getObjectIndex(a, b) {
            for (var i in b) {
                if (b[i] == a) {
                    return i;
                }
            }
            return -1;
        }
    </script>

<include file="public:foot" />