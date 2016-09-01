<include file="Public:head" />

<body>
<div class="header center pr f18">
      我发布的民宿
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa"><a href="{:U('Web/Member/editmymerchant')}">编辑</a></div>
</div>


<div class="container">
   <div class="land">
       <div class="omg_a">我目前有{$count}个民宿</div>
       <div class="land_c f14">
       		<volist name='data' id='vo'>               
       			<div class="land_d pr f0">
					<div class="land_e vertical"><img src="{$vo.thumb}"></div>
					<div class="land_f vertical">
						<div class="land_f1 f16">{$vo.title}</div>
						<div class="land_f2 f13">
							<div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
							</div>
						</div>
						<div class="land_f3 pa f0">
							<div class="land_f4 my_tra1 vertical">
								<span class="my_span1"><if condition="$vo.status eq '1'">审核中<else/>进行中</if></span>
							</div>
						</div>
					</div>
            	</div>
       		</volist>
      
      </div>
   </div>	   	
</div>

</body>

</html>