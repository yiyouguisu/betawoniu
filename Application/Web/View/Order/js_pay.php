<include file="Public:head" />
<div class="header center z-index112 pr f18 fix-head">
    预定美宿
</div>

<div class="container" style="margin-top:6rem;padding-top:1rem">
   <div class="coupon_box center">
     <div class="fg_a"><img src="__IMG__/per_suc.jpg"></div>
     <div class="fg_b blue f24" id="pay_title">正在支付...</div>
     <div class="ft16 theme_color_blue" style="padding:8px 0">
      您的订单号为：{$orderid}
     </div>
     <br>
     <div style="padding:18px 8px;border-radisu:5px;background:#efefef;box-shadow:2px 5px 10px #999;display:none" id="view_order">
      <a href="{:U('Order/hotel_order_detail')}?orderid={$orderid}" id="pass" style="display:inline-block;padding:8px;width:42%;background:#56c3cf;color:#fff;border:0;border-radius:3px;" class="ft16">去看订单</a>
    <a href="{:U('Hostel/show')}?id={$data.hid}" id="not_pass" style="display:inline-block;padding:8px;width:42%;background:#fff;color:#000;border:0;border-radius:3px;" class="ft16">返回美宿详情</a>
     </div>
    </div>
    <div class="land_c  wc f14" id="other_rooms">
      <div class="act_d center">
        <span>我们的其他房间</span>
        <div class="act_d1"></div>
      </div>
      <volist name="house_owner_room" id='vo'>
        <a href="{:U('Web/Hostel/room',array('id'=>$vo['id']))}" style="display:block;padding:5px;border-bottom:1px solid #efefef">
          <div class="land_d pr f0">
            <div class="land_e vertical"><img src="{$vo.thumb}" style="width:100px;height:80px;"></div>
            <div class="land_f vertical">
              <div class="land_f1 f16">{$vo.title}</div>
              <div class="land_f2 f13">{$vo.area}M<sup>2</sup> {$vo.catname}</div>
              <div class="land_f3 pa f0">
                <div class="land_money ft18"><em>￥</em>{$vo.money}
                  <span>起</span>
                </div>
              </div>
            </div>
          </div>
        </a>
      </volist> 
     </div>
</div>
<script type="text/javascript">
    var jsParameters = {$parameters};

    function jsApiCall()
    {
        WeixinJSBridge.invoke(

            'getBrandWCPayRequest',

            jsParameters,

            function(res)
            {

                WeixinJSBridge.log(res.err_msg);

                switch (res.err_msg)
                {

                    case 'get_brand_wcpay_request:fail':

                        $('#pay_title').html('支付失败，请重新尝试或联系管理员.');

                        $('#pay_title').css(
                        {
                            color: '#d9534f'
                        });

                        break;

                    case 'get_brand_wcpay_request:ok':

                        $('#pay_title').html('支付成功！');

                        $('#view_order').fadeIn('fast');
                        break;
                }

            }

        );
    }

    function callpay()
    {

        if (typeof WeixinJSBridge == "undefined")
        {
            if (document.addEventListener)
            {
                document.addEventListener('WeixinJSBridgeReady',
                    jsApiCall, false);
            }
            else if (document.attachEvent)
            {
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }
        else
        {
            jsApiCall();
        }
    }

    window.onload = function()
    {
        callpay();
    };
</script>
</body>
</html>
