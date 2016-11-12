<include file="public:head" />
<body>
<div class="header center z-index112 pr f18">
      活动报名
      <div class="head_go pa"><a onclick='window.location.href="{:U('Web/Index/index')}"'><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container">
   <div class="coupon_box center">
          <div class="fg_a"><img src="__IMG__/per_suc.jpg"></div>
          <div class="fg_b blue f24">恭喜，报名提交成功！</div>
          <div class="fg_c">我们会尽快通知发起人，收到确认后</div>
          <div class="fg_c">我们会第一时间通知您</div>
          <div class="act_d center">
                  <span>活动附近的民宿</span>
                  <div class="act_d1"></div>
          </div>
    </div>
    <div class="land_c  wc f14">
		<a href="">
			<div class="land_d pr f0">
				<div class="land_e vertical"><img src="__IMG__/land_d1.jpg"></div>
				<div class="land_f vertical">
					<div class="land_f1 f16">神秘的京都你不懂，请点</div>
					<div class="land_f3 pa f0">
						<div class="land_money f20">8.8<span>分</span></div>
					</div>
				</div>
			</div>
		</a>
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
		<div class="scr_d center">显示全部6个民宿<img src="__IMG__/drop_f.jpg"></div> 
	</div>
</div>

</body>
<script type="text/javascript"> </script>
</html>