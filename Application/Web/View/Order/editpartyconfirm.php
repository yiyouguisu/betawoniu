<include file="public:head" />
<body>
<div class="header center z-index112 pr f18">
  修改订单
</div>

<div class="container">
  <div class="coupon_box center">
    <div class="fg_a"><img src="__IMG__/per_suc.jpg"></div>
    <div class="fg_b blue f24">修改成功！</div>
    <div class="ft16 theme_color_blue" style="padding:8px 0">您的订单号为：{$data.orderid}</div>
    <div class="fg_c ft12">请尽快支付！</div>
    <br>
    <div style="padding:18px 8px;border-radisu:5px;background:#efefef;box-shadow:2px 5px 10px #999">
      <a href="{:U('Order/party_order_detail')}?orderid={$data.orderid}" id="pass" style="display:inline-block;padding:8px;width:42%;background:#56c3cf;color:#fff;border:0;border-radius:3px;" class="ft16">去看订单</a>
      <a href="{:U('party/show')}?id={$data.aid}" id="not_pass" style="display:inline-block;padding:8px;width:42%;background:#fff;color:#000;border:0;border-radius:3px;" class="ft16">返回活动详情</a>
    </div>
  </div>
</div>
</body>
</html>
