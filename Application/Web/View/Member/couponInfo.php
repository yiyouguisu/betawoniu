<include file="Public:head" />
<body>
<div class="header center pr f18">
      我的优惠券
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
</div>
<div class="container">
  <div class="coupon_box">
      
       <div class="coupon_d center">
          <div class="coupon_d1"><span>￥</span>{$data.price|default="0.00"}</div>
          <div class="coupon_d2 f18">{$data.title}</div>
          <div class="coupon_d3">有效期 :{$data.validity_starttime|date="Y-m-d",###} - {$data.validity_endtime|date="Y-m-d",###}</div>
       </div>
       <div class="coupon_e">
           <div class="cou_xinzeng">消费满{$data.range|default="0.00"}元可使用</div>
	
			<notempty name="data['cityname']">
				<div class="coupon_e1 f16 color_333">优惠券适用城市 :</div>
	            <div class="coupon_e2">
	               <p>{$data.cityname}</p>
	            </div>
            </notempty>
            <notempty name="data['hostel']">
                <div class="coupon_e1 f16 color_333">优惠券适用美宿 :</div>
	            <div class="coupon_e2">
	            	<volist name="data['hostel']" id="vo">
	               	<p>{$vo}</p>
	               </volist>
	            </div>
            </notempty>
            <notempty name="data['party']">
                <div class="coupon_e1 f16 color_333">优惠券适优惠券适用活动用美宿 :</div>
	            <div class="coupon_e2">
	            	<volist name="data['party']" id="vo">
	               	<p>{$vo}</p>
	               </volist>
	            </div>
            </notempty>
           
           <div class="coupon_e1 f16 color_333">优惠券使用说明 :</div>
           <div class="coupon_e2">
               {$data.content}
           </div>
       </div> 
  </div>
</div>
<include file="Public:foot" />
