<include file="Public:head" />
<body>
<div class="header center pr f18">
      我发布的活动
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa"><a href="{:U('Web/Member/editmyact')}">编辑</a></div>
</div>


<div class="container">
	<div class="land">
		<div class="land_b map_title center  f14">
			<a class="all ">全部</a>
			<a class="all " >进行中</a>
			<a class="all ">已结束</a>
		</div>
		<!-- 全部 -->
		<div class="land_c f14 show_div" style='display:none'>
			<volist name='data' id='vo'>
				<div class="land_d pr f0">
					<div class="land_e vertical"><img src="{$vo.thumb}"></div>
					<div class="land_f vertical">
						<div class="land_f1 f16">{$vo.title}</div>
						<div class="land_f2 f13">
							<div class="land_money f20"><i>报名费：</i><em>￥</em>{$vo.money}
							</div>
						</div>
						<div class="land_f3 pa f0">
							<if condition='$vo.status eq 1'>
								<div class="land_f4 my_tra1 vertical"><span class="my_span">审核中</span></div>
							<elseif condition="$vo['endtime'] gt NOW_TIME"/>
								<div class="land_f4 my_tra1 vertical"><span class="my_span1">进行中</span></div>
							<else />
								<div class="land_f4 my_tra1 vertical"><span>已结束</span></div>
							</if>
						</div>
					</div>
				</div>      					
			</volist>
		</div>
		<!-- 进行中 -->
		<div class="land_c f14 show_div" style='display:none'>
			<volist name='data' id='vo'>
				<if condition="($vo['endtime'] gt NOW_TIME) AND ($vo.status eq 1)">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">
								<div class="land_money f20"><i>报名费：</i><em>￥</em>{$vo.money}
								</div>
							</div>
							<div class="land_f3 pa f0">
								<div class="land_f4 my_tra1 vertical"><span class="my_span1">进行中</span></div>
							</div>
						</div>
					</div> 
				</if>     					
			</volist>
		</div>
		<!-- 结束 -->
		<div class="land_c f14 show_div" style='display:none'>
			<volist name='data' id='vo'>
				<if condition="$vo['endtime'] lt NOW_TIME">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">
								<div class="land_money f20"><i>报名费：</i><em>￥</em>{$vo.money}
								</div>
							</div>
							<div class="land_f3 pa f0">
								<div class="land_f4 my_tra1 vertical"><span>已结束</span></div>
							</div>
						</div>
					</div>
				</if>			
			</volist>
		</div>
	</div>	   	
</div>
<script type="text/javascript">
$(function(){
	var all=$('.all');
	var show=$('.show_div');
	all.eq(0).addClass('land_cut');
	show.eq(0).show();
	all.click(function(){
		all.removeClass('land_cut');
		show.hide();
		all.eq($(this).index()).addClass('land_cut');
		show.eq($(this).index()).show();
	});
});
</script>
</body>

</html>