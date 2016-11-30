<include file="public:head" />
<body>
<div class="header center z-index112 pr f18">
      报名成功
</div>

<div class="container">
   <div class="coupon_box center">
          <div class="fg_a"><img src="__IMG__/per_suc.jpg"></div>
          <div class="fg_b blue f24">恭喜，报名提交成功！</div>
          <div class="ft16 theme_color_blue" style="padding:8px 0">您的订单号为：{$order.orderid}</div>
          <div class="fg_c ft12">我们会尽快通知发起人，收到确认后</div>
          <div class="fg_c ft12">我们会第一时间通知您</div>
          <br>
          <div style="padding:18px 8px;border-radisu:5px;background:#efefef;box-shadow:2px 5px 10px #999">
          <a href="{:U('Order/party_order_detail')}?orderid={$order.orderid}" id="pass" style="display:inline-block;padding:8px;width:42%;background:#56c3cf;color:#fff;border:0;border-radius:3px;" class="ft16">去看订单</a>
          <a href="{:U('Party/show')}?id={$data.id}" id="not_pass" style="display:inline-block;padding:8px;width:42%;background:#fff;color:#000;border:0;border-radius:3px;" class="ft16">返回活动详情</a>
          </div>
          <div class="act_d center">
            <span class="ft14">活动附近的美宿</span>
            <div class="act_d1"></div>
          </div>
    </div>
    <div class="land_c  wc f14">
		<volist name='data["party_near_hostel"]' id='vo'>
			<a href="{:U('Web/Party/show',array('id'=>$vo.id))}">
				<div class="land_d pr f0">
					<div class="land_e vertical"><img src="{$vo.thumb}"></div>
					<div class="land_f vertical">
						<div class="land_f1 f16">{$vo.title}</div>
						<div class="land_f3 pa f0">
							<div class="land_money f20">8.8<span>分</span></div>
						</div>
					</div>
				</div>
			</a>			
		</volist>
		<!-- <div class="scr_d center">显示全部6个美宿<img src="__IMG__/drop_f.jpg"></div>  -->
	</div>
</div>

</body>
<script type="text/javascript"> </script>
</html>
