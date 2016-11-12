<include file="public:head" />
<include file="public:mheader" />

	<include file="Member:member" />
    <div class="order_main2">
        <div class="wrap clearfix">
            <include file="Member:member_left2" />
            <div class="fl Coupon_details_main">
                <div class="Coupon_details_main2">
                    <div class="Coupon_details_main2_top">
                        <div>
                            <span class="f36 cw">￥<em>{$data.price|default="0.00"}</em></span>
                            <p>{$data.title}</p>
                            <i class="f14 cw">有效期 :<em class="f14 cw">{$data.validity_starttime|date="Y-m-d",###} - {$data.validity_endtime|date="Y-m-d",###}</em></i>
                        </div>
                    </div>
                    <div class="Coupon_details_main2_center">
                        <span>消费满{$data.range|default="0.00"}元可使用</span>
                    </div>
                    <div class="Coupon_details_main2_bottom">
                        <notempty name="data['cityname']">
                            <span class="c333 f18">优惠券适用城市 :{$data.cityname}</span>
                        </notempty>
                        <notempty name="data['hostel']">
                            <span class="c333 f18">优惠券适用美宿 :</span>
                            <volist name="data['hostel']" id="vo">
                                <i>{$vo}</i>
                            </volist>
                        </notempty>
                        <notempty name="data['party']">
                            <span class="c333 f18">优惠券适用活动 :</span>
                            <volist name="data['party']" id="vo">
                                <i>{$vo}</i>
                            </volist>
                        </notempty>
                        <span class="c333 f18">优惠券使用说明 :</span>
                        {$data.content}
                    </div>
                </div>
            </div>

        </div>
    </div>

<include file="public:foot" />