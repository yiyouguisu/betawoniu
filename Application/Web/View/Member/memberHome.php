<include file="Public:head" />

<body>
<div class="container">
	<div class="land">
          <div class="land_top center pr">
                  <div class="land_bj pr"><img src="__IMG__/top_bj_f.jpg">
                      <div class="land_go pa" onclick="history.go(-1)"><img src="__IMG__/go.png"></div> 
                  </div>
                  <div class="land_a pa">
                        <div class="land_a1"><img src="{$data.head}"></div>
                        <div class="land_a2 margin_05 write f16">{$data.nickname}</div>
                        <a href="{:U('Web/Member/myfans',array('id'=>$data['id']))}">
                        	<div class="land_a3 margin_05 write f14">关注: {$follow|default="0"} | 粉丝: {$fans|default="0"}</div>
                        </a>
                        <div class="land_a4 margin_05 write f14 pr">
                        	  {$data.info}
                        </div>
                        <div class="land_a5 margin_05 write f14">
							<volist name=":getlinkage(2)" id="vo">
								<in name="vo['name']" value="$data.hobby">{$vo.name}、</in> 
							</volist>
                        </div>
                        <if condition='$ismy eq 1'>
                        	<div class="land_a6 margin_05 f14"><a href="" class="mr_5">+ 关注</a><a href="">私信</a></div>
                        </if>
                  </div>
          </div>

          <div class="land_btm">
				<div class="land_b person_title center f16">
					<a class="my">我的游记（{$cnote}）</a>
					<a class='my'>我的评论（{$creview}）</a>
				</div>            
				<div class="land_c f14 comments_box" style='display:none'>
					<volist name='note' id='vo'>
						<a href="{:U('Web/Note/show',array('id'=>$vo['id']))}">
							<div class="land_d pr f0">
								<div class="land_e vertical"><img src="{$vo.thumb}"></div>
								<div class="land_f vertical">
									<div class="land_f1 f16">{$vo.title}</div>
									<div class="land_f2 f13">{$vo.inputtime|date='Y-m-d',###}</div>
									<div class="land_f3 pa f0">
										<div class="land_f4 vertical">
											<img src="__IMG__/land_d2.png">
										</div>
										<div class="land_h tra_wc vertical">
											<div class="land_h1 f11 vertical">
												<img src="__IMG__/land_d3.png">
												<span>188</span>条评论
											</div>
											<div class="land_h2 f11 vertical">
												<img src="__IMG__/land_d4.png">
												<span>68</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>
					</volist>
				</div>
          </div>	


		<div class="land_btm re">
			<div class="comments_box" style='display:none'>
				<volist name='notedata' id='vo'>
					<a href="{:U('Web/Note/show',array('id'=>$vo['nid']))}">
						<div class="comments">
							<div class="com_top pr">
								<div class="com_a f16">{$vo.title}</div>
								<div class="com_b f13">{$vo.inputtime|date='Y-m-d',###}</div>
								<div class="com_c com_c1 pa">游记</div>
							</div>
							<div class="com_btm f14">
								{$vo.id1}评论内容：{$vo.content}
							</div>
						</div>
					</a>
				</volist>

				<volist name='activityreview' id='vo'>
					<a href="{:U('Web/Party/show',array('id'=>$vo['pid']))}">
						<div class="comments">
							<div class="com_top pr">
								<div class="com_a f16">{$vo.title}</div>
								<div class="com_b f13">{$vo.inputtime|date='Y-m-d',###}</div>
								<div class="com_c com_c2 pa">活动</div>
							</div>
							<div class="com_btm f14">
								{$vo.content}
							</div>
						</div>
					</a>
				</volist>
			</div>
		</div>	
	</div>	   	
</div>
<script type="text/javascript">
	$(function(){
		var my=$('.my');
		var comments_box=$('.comments_box')
		my.eq(0).addClass('land_cut');
		comments_box.eq(0).show();
		my.click(function(){
			my.removeClass('land_cut');
			comments_box.hide();
			my.eq($(this).index()).addClass('land_cut');
			comments_box.eq($(this).index()).show();
		});
	});
	
</script>
</body>

</html>