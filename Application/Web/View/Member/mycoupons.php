<include file="Public:head" />
<body>
<div class="header center pr f18">
      我的优惠券
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
</div>
<div class="container">
	<div class="coupon_box">
		<volist name="data" id="vo">
			<a href="{:U('Web/Member/couponInfo',array('id'=>$vo['id']))}">
				<div class="coupon_list">
					<div class="coupon_a center f20 fl <if condition="$vo['status'] eq 1">cp_a</if>" ><span>￥</span>{$vo.price}</div>
					<div class="coupon_b fl">
						<div class="coupon_b1 f16 color_333">{$vo.title}</div>
						<div class="coupon_b2 f12 color_999">有效期 :{$vo.validity_starttime|date='Y-m-d',###} 至 {$vo.validity_endtime|date='Y-m-d',###}</div>
					</div>
					<if condition="$vo['status'] eq 1">
						<div class="coupon_c"><img src="__IMG__/rec_b.png"></div>
					</if>
				</div>
			</a>
		</volist>
	</div>
</div>


<include file="Public:foot" />
