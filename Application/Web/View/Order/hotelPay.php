<include file="public:head" />
<style>
  .prefer_cut{background:none;}
</style>
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18 fix-head">
  美宿付款   
  <div class="head_go pa">
    <a href="javascript:history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span>
  </div>
</div>
<div class="container padding_0" style="margin-top:6rem">
  <form action="{:U('Web/Order/dopay')}" method="get" id='form'>
     <input type='hidden' name='orderid' value='{$data.orderid}' />
     <div class="act_e">
       <div class="act_e1 fl"><img src="{$data.productinfo.thumb}"></div>
       <div class="act_e2 fr">
         <div class="act_e3 ft16">{$data.productinfo.title}</div>
         <div class="act_e3 ft14" style="color:#56c3cf">{$data.productinfo.room_name}</div>
       </div>
     </div>
     <div class="act_e f14">
       <div class="act_e5">
         <span>入住时间：</span>{$data.productinfo.starttime|date='Y年m月d日',###}
       </div>
       <div class="act_e5">
         <span>离店时间：</span>{$data.productinfo.endtime|date='Y年m月d日', ###}
       </div>
       <div class="act_e5">
         <span>美宿地址：</span>{$data.address}
       </div>
     </div>
     <div class="act_f play_blue" style="margin-bottom:1rem;">
       <span>支付方式 :</span>
       <select class="ft12" name='paytype' style="vertical-align:middle;width:160px;line-height:1.5rem;height:3rem;padding:0 20px;border: 0;">
         <option value="0" selected>选择支付方式</option>
         <option value='1' id="alipay_item">支付宝</option>
         <option value='2' id="wxpay_item">微信支付</option>
         <option value='3'>银联支付</option>
       </select>
     </div>
     <div class="act_e_r">
       <div class="act_f pr">
         <span>总价格 :</span><em>￥</em><i class="total ft18 total">{$data.total}</i>
       </div>
       <div class="act_f pr">
         <span>实付价 :</span><em>￥</em><i class="total ft18 money">{$data.money}</i>
       </div>
       <div class="ft14 help_a common_click act_h" style="padding-top:20px;padding-bottom:20px"><img src="__IMG__/bi.jpg">是否有优惠券？</div>
       <if condition='($data.couponsid eq NULL) OR ($data.couponsid eq 0)'>
         <div class="help_a act_h add" style='display:none;background: none;'></div>
       <else/>
         <div class="help_a act_h add" style="background: none;">{$data.coupon_name}</div>
       </if>
     </div>
     <div class="act_href center" style="margin-left:20px;margin-right:20px;border-radius:3px;">
          <input type="hidden" name="money" value="{$data.money}">
          <input type="hidden" name="totalmoney" value="{$data.money}">
          <input type="hidden" name="couponsid" value="{$data.couponsid}">
          <input type="hidden" name="discount" value="{$data.discount}">
          <input type="hidden" name="orderid" value="{$data.orderid}">
          <a class='sub' style="border-radius:3px;">立即付款</a>
     </div>
  </form>
  <br>
</div>

<div class="big_mask"></div>
<div class="common_mask" style="height: 80%;">
  <div class="pyl_top pr">选择优惠券
      <div class="pyl_close pa"><img src="__IMG__/close.jpg"></div>
  </div>
  <div class="common_mid" style=" height: 90%;">
    <div class="name_box bianj_child" style="height: 80%;overflow-y: scroll;">
        <volist name='coupon' id='vo'>
          <div class="coupon_list" data-title="{$vo.title}" data-id="{$vo.id}" data-price="{$vo.price}">
             <div class="coupon_a center f20 fl"><span>￥</span>{$vo.price}</div>
             <div class="coupon_b fl">
                 <div class="coupon_b1 f16 color_333">{$vo.title}</div>
                 <div class="coupon_b2 f12 color_999">有效期 :{$vo.validity_starttime|date="Y-m-d",###} - {$vo.validity_endtime|date="Y-m-d",###}</div>
             </div>
        </div> 
        </volist>   
    </div>

    <div class="snail_d homen_style center f16">
        <a class='addCoupon'>确定添加</a>
    </div>
  </div>
</div>
<script>
$(function(){
   $(".common_click").click(function(){
       $(".big_mask,.common_mask").show()
   })
   var cdata={};
   $('.coupon_list').click(function(){
    cdata['title']=$(this).find('span').text();
    cdata['coid']=$(this).find('.coid').val();
    cdata['cprice']=$(this).find('.cprice').val();
    $(this).addClass("prefer_cut").siblings().removeClass("prefer_cut");
    console.log(cdata);
   })
   $(".addCoupon").click(function(){
        var couponsid=$("div.name_box div.prefer_cut").data("id");
        var price=$("div.name_box div.prefer_cut").data("price");
        var couponstitle=$("div.name_box div.prefer_cut").data("title");
        $(".big_mask,.pyl,.common_mask").hide();
        $('.add').text(couponstitle+"(￥"+price+"元)");
        $('.add').show();
        
        $("#discount").text(parseFloat(price).toFixed(2));
        $("input[name='couponsid']").val(couponsid);
        $("input[name='discount']").val(parseFloat(price).toFixed(2));
        aa();
    })
   function aa(){
           var money=$("input[name='totalmoney']").val();
            var discount=$("input[name='discount']").val();
            var total=parseFloat(parseFloat(money)-parseFloat(discount)).toFixed(2);
            $(".money").text(total);   
            $("input[name='money']").val(total);
   }
   $('.sub').click(function(){
    $('#form').submit();
   });
})
</script>
<script>
  if(is_weixin()) {
    $('#alipay_item').remove();
  } else {
    $('#wxpay_item').remove();
  }
</script>
</body>
</html>
