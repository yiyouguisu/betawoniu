<include file="Public:head" />
<div data-role="content">
  <div style="background:#fff;width:100%;text-align:center;padding:20px 0;border-radius:5px;">
    <img src="/imgs/weixinpay.png" style="margin-top:20px;">
    <div style="color:#138ed1;font-size:18px;font-weight:bold;margin-top:8px;" id="pay_title">
        正在跳转支付...
    </div>
    <div style="color:#ff8800;font-size:22px;padding:10px;font-weight:bold" id="pay_price">
        ¥&nbsp;{$total} 
    </div>
    <hr style="background:#ddd">
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
