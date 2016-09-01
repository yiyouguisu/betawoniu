<include file="Public:head" />
<script src="__JS__/Action.js"></script>
<body>
<div class="header center pr f18">
      我的游记
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa"><a href="{:U('Web/Member/editmynote')}">编辑</a></div>
</div>

<!-- http://192.168.2.107/index.php/Web/Travel/show/id/95.html -->
<div class="container">
	<div class="land">
		<div class="land_c f14">
			<volist name='data' id='vo'>
				<a href="{:U('Web/Travel/show',array('id'=>$vo['id']))}">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">{$vo.inputtime|date='Y-m-d',###}</div>
							<div class="land_f3 pa f0">
								<div class="land_f4 my_tra1 vertical">
									<if condition="$vo.status eq 1">
										<span class="my_span">未审核</span>
									<else/>
										<span>已审核</span>
									</if>
								</div>
								<div class="land_h my_tra2  tnt_btm vertical">
									<div class="land_h2 f11 vertical">
										<img src="__IMG__/land_d4.png">
										<span>{$vo.hit}</span>
									</div>
								</div>
							</div>
						</div>
		      	   </div>
				</a>
			</volist>
		</div>
	</div>	   	
</div>
















<include file="Public:foot" />