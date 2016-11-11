<include file="Public:head" />
<div class="header center pr f18">
      我的收藏
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa"><a href="{:U('Web/Member/editcollect')}">编辑</a></div>
</div>
<div class="container">
   <div class="land">
       <div class="land_b map_title center  f14">
                       <a class="a_title">游记</a>
                       <a class="a_title" >民宿</a>
                       <a class="a_title" >活动</a>
       </div>

   		<!-- 游记 -->
		<div class="land_c f14 collect" style='display:none'>
			<volist name='note' id='vo'>
				<a href="{:U('Web/Note/show',array('id'=>$vo['nid']))}">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">{$vo.inputtime|date='Y-m-d',###}</div>
							<div class="land_f3 pa f0">
								<div class="land_f4 vertical">
									<img src="{$vo.head}">
								</div>
								<div class="land_h tra_wc vertical">
									<div class="land_h1 f11 vertical">
										<img src="__IMG__/land_d3.png">
										<span>{$vo.reviewnum}</span>条评论
									</div>
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
		<!-- 名宿 -->
		<div class="land_c f14 collect" style='display:none'>
			<volist name='houselist' id='vo'>
				<a href="{:U('Web/Hostel/show',array('id'=>$vo['hid']))}">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">
								<div class="land_money f20"><em>￥</em>{$vo.price}<span>起</span>
								</div>
							</div>
							<div class="land_f3 pa f0">
								<div class="land_f4 vertical">
									<img src="{$vo.head}">
								</div>
								<div class="land_h tra_wc vertical">
									<div class="land_h1 f11 vertical">
										<img src="__IMG__/land_d3.png">
										<span>{$vo.reviewnum}</span>条评论
									</div>
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
		<!-- 活动 -->
		<div class="land_c f14 collect" style='display:none'>
			<volist name='party' id='vo'>
				<a href="{:U('Web/Party/show',array('id'=>$vo['aid']))}">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f3 fich_kk f0">
								<div class="land_font">
									<span>时间:</span> {$vo.starttime} 至{$vo.endtime}        
								</div> 
								<div class="land_font">
									<span>地点:</span> {$vo.address}        
								</div>
								<div class="land_font">
									<span>已参与:</span> 20人        
								</div> 
							</div>
						</div>
					</div>
				</a>
			</volist>
		</div>
   </div>	   	
</div>
<script type="text/javascript">
	$(function(){
		var collect=$('.collect');
		var a_title=$('.a_title');
		a_title.eq(0).addClass('land_cut');
		collect.eq(0).show();
		a_title.click(function(){
			a_title.removeClass('land_cut');
			collect.hide();
			var a=$(this).index();
			a_title.eq(a).addClass('land_cut');
			collect.eq(a).show();


		});
	});
</script>

<include file="Public:foot" />
