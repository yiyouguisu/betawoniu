<include file="public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      活动付款
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container padding_0">
  <form action="{:U('Web/Order/dopay')}" method="get" id='form'>
     <div class="act_e">
           <div class="act_e1 fl"><img src="{$data.thumb}"></div>
           <div class="act_e2 fr">
                <div class="act_e3">{$data.title}</div>
                <div>
                    <div class="land_font mont_a mont_red">
                        <span>已报名:</span> {$data.end_numlimit}/人      
                    </div> 
                    <div class="land_font mont_a">
                        <span>已参与:</span> {$data.yes_num}人      
                    </div> 
                </div>
           </div>
     </div>
     
     <div class="act_e f14">
          <div class="act_e5"><span>时间 :</span>{$data.starttime|date='Y年m月d日',###}</div>
          <div class="act_e5"><span>地址 :</span>{$data.address}</div>
     </div>
     
      <div class="act_f play_blue" style="margin-bottom:1rem;">
        <span>支付方式 :</span>
        <select name='paytype'>
          <option value='1'>支付宝</option>
          <option value='2'>微信支付</option>
          <option value='3'>银联支付</option>
        </select>
      </div>
     
     <div class="act_e_r">
          <div class="act_f pr"><span>总价格 :</span><em>￥</em><i class="total">{$order.total}</i>
                <div class="act_font pa">（{$order.num}人）</div>
          </div>
          <div class="help_a common_click act_h"><img src="__IMG__/bi.jpg">是否有优惠券？</div>
          <if condition='($order.couponsid eq NULL) OR ($order.couponsid eq 0)'>
            <div class="help_a act_h add" style='display:none'></div>
          <else/>
            <div class="help_a act_h add">{$order.coupon_name}</div>
          </if>
     </div>
     
     <!-- <a href=""><div class="act_h amz_a"><img src="__IMG__/gk.jpg">价格明细</div></a> -->
     <div class="act_href center">
          <input type='hidden' name='orderid' value='{$order.orderid}' />\
          <a class='sub'>立即付款</a>
     </div>
  </form>
</div>

<div class="big_mask"></div>
<div class="common_mask">
    <div class="pyl_top pr">选择优惠券
        <div class="pyl_close pa"><img src="__IMG__/close.jpg"></div>
    </div>
    
    <div class="common_mid">
          <div class="name_box bianj_child">
              <volist name='coupon' id='vo'>
                <div class="prefer_list">
                  <span>{$vo.title}</span>
                  <input type='hidden' class='cprice' value='{$vo.price}'>
                  <input type='hidden' class='coid' value='{$vo.coid}'>
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
   $('.prefer_list').click(function(){
    cdata['title']=$(this).find('span').text();
    cdata['coid']=$(this).find('.coid').val();
    cdata['cprice']=$(this).find('.cprice').val();
    $(this).addClass("prefer_cut").siblings().removeClass("prefer_cut");
    console.log(cdata);
   })
   $('.addCoupon').click(function(){
    $(".big_mask,.pyl,.common_mask").hide();
    // var total=Number($('.total').text())-cdata.cprice;
    // total=(total).toFixed(2);
    // $('.total').text(total);
    $('.add').text(cdata.title);
    $('.add').show();
    var orderid='{$order.orderid}';
    var data={'orderid':orderid,'coid':cdata['coid']};
    console.log(data);
    $.post("{:U('Web/Order/uCoupon')}",data,function(res){
      if(res.code==200){
        var total=(res.money).toFixed(2);
        $('.total').text(total);
      }
    })
   })
   $('.sub').click(function(){
    $('#form').submit();
   });
})

// $(function(){
//    $(".bianj_child .prefer_list").click(function(){
//     console.log(cdata);
//        $(this).addClass("prefer_cut").siblings().removeClass("prefer_cut") 
//    })
// })
</script>


</body>

</html>