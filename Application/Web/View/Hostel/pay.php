<include file="Public:head" />
<div class="header center z-index112 pr f18">
      美宿付款
<div class="head_go pa">
  <a href="" onclick="history.go(-1)">
    <img src="__IMG__/go.jpg">
  </a>
  <span>&nbsp;</span>
</div>
</div>
<div class="container padding_0" style="background:#efefef">
  <div class="act_e">
    <div class="act_e1 fl"><img src="__IMG__/act_c1.jpg"></div>
    <div class="act_e2 fr">
      <div class="act_e3">{$order['hotel_name']}</div>
      <div class="act_e4">{$order['room_name']}</div>
    </div>
  </div>
  <div class="act_e f14">
    <div class="act_e5"><span>入住时间 :</span>{$order['starttime']|date='Y-m-d', ###}</div>
    <div class="act_e5"><span>离店时间 :</span>{$order['endtime']|date='Y-m-d', ###}</div>
    <div class="act_e5"><span>美宿地址 :</span>{$order['address']}</div>
  </div>
  <div class="act_e_r" style="font-size:12px;">
    <div class="act_f"><span>总价格 :</span><em>￥</em>{$order['money']}</div>
    <div class="act_h"><img src="__IMG__/bi.jpg">是否有优惠券？</div>
  </div>
  <a href="my-help3.html" style="font-size:12px;">
    <div class="help_list" style="margin-top:1.5rem;">
      <div class="help_a"><img src="__IMG__/gk.jpg">价格说明</div>
    </div>
  </a> 
  <a href="#" style="font-size:12px;display:block" id="choose_pay_type">
    <div class="help_list" style="margin-top:1.5rem;">
      <div class="help_a">
        <img src="__IMG__/gk.jpg">支付方式：
        <span id="paytype" style="color:#ff5f4c">微信支付</span>
      </div>
    </div>
  </a> 
  <div class="act_href center" style="padding:10px;">
    <a href="#" id="go_pay">立即付款</a>
  </div>
</div>
<div id="pay_cover" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:9999" class="hide">
  <div style="position:absolute;left:0;top:0;right:0;bottom:0;background:#000;opacity:0.8;z-index:-1"></div>
  <div style="width:70%;margin:30% auto;background:#fff;border-radius:3px;padding:10px;text-align:center">
    <div style="border-bottom:1px solid #eee;padding:8px;color:#ff5f4c" class="paytype" data-type="wxpay">
      微信支付 
    </div>
    <div style="border-bottom:1px solid #eee;padding:8px;color:#ff5f4c" class="paytype" data-type="alipay">
      支付宝钱包
    </div>
    <div style="padding:8px;color:#ff5f4c" class="paytype" data-type="yl">
      银联支付
    </div>
  </div>
</div>
</body>
<script>
  $('html').css({'background': '#efefef'});
  $('.paytype').click(function(evt) {
    evt.preventDefault();
    var type = $(this).data('type');
    var content = $(this).html();
    $('#paytype').html(content);
    $('#pay_cover').addClass('hide');
  });
  $('#choose_pay_type').click(function(evt) {
    evt.preventDefault();
    $('#pay_cover').removeClass('hide');
  });
  $('#go_pay').click(function(evt) {
    evt.preventDefault();
    $.ajax({
      'url': '{:U("Api/")}',
    
    });
  });
</script>
</html>
