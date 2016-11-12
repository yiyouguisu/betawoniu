<include file="Public:head" />
<body>
<div class="container">
	<div class="land">
          <div class="land_top center pr">
                  <div class="land_bj pr">
					<eq name="data['houseowner_status']" value="1">
                  		<img src="__IMG__/shop.png">
                  	<else />
                  		<img src="__IMG__/personal.png">
                  	</eq>
                    <div class="land_go pa" onclick="history.go(-1)"><img src="__IMG__/go.png"></div> 
                  </div>
                  <div class="land_a pa" style="margin-top:30px;">
                        <div class="land_a1 home-head"><img src="{$data.head}"></div>
                        <div class="land_a2 margin_05 write f16">{$data.nickname}
                        	<eq name="data['houseowner_status']" value="1">
                        	<img src="__IMG__/houseowner.png" style="width:12px;">
                        	</eq>
                        </div>
                        <a href="{:U('Web/Member/myfans',array('id'=>$data['id']))}">
                        	<div class="land_a3 margin_05 write f14">关注: {$follow|default="0"} | 粉丝: {$fans|default="0"}</div>
                        </a>
                        <div class="land_a4 margin_05 write f14 pr">
                        	  {$data.info}
                        </div>
                        <div class="land_a5 margin_05 write f14">
                        	{$hobbyAndCharac}
							<!-- <volist name=":getlinkage(2)" id="vo">
								<in name="vo['name']" value="$data.hobby">{$vo.name}、</in> 
							</volist>
							<volist name=":getlinkage(1)" id="vo">
								<in name="vo['name']" value="$data.characteristic">{$vo.name}、</in> 
							</volist> -->
                        </div>
                        <if condition='$ismy eq 1'>
                          <div class="land_a6 margin_05 f14">
                          	<if condition='$attention eq 0'>
                            	<a href="" class="mr_5 focus">+关注</a>
                            <else />
                            	<a href="" class="mr_5 focus">已关注</a>
                            </if>
                            <a href="#"  class="chat_friends" data-targetid="{$data.id}" data-targettoken="{$data.rongyun_token}" data-targethead="{$data.head}" data-nickname="{$data.nickname}">私信</a>
                          </div>
                        </if>
                  </div>
          </div>

          <div class="land_btm">
          		<eq name="data['houseowner_status']" value="1">
					<div class="land_b person_title center f16">
						<a class="my">游记（{$cnote}）</a>
						<a class="my">活动（{$cact}）</a>
						<a class='my'>美宿（{$chostel}）</a>
						<a class='my'>评论（{$creview}）</a>
					</div>
				<else />
					<div class="land_b person_title center f16">
						<a class="my" style="width:50%;">游记（{$cnote}）</a>
						<a class="my" style="width:50%;">评论（{$cact}）</a>
					</div>
				</eq>            
				<div class="land_c f14 comments_box" style='display:none'>
					<volist name='note' id='vo'>
						<a href="{:U('Web/Note/show',array('id'=>$vo['id']))}">
						<div class="list-item">
							<div class="list-item-left-img"><img src="{$vo.thumb}"></div>
							<div class="list-item-right-content">
								<div class="title">{$vo.title}</div>
								<div class="time">{$vo.inputtime|date='Y-m-d',###}</div>
								<div class="bottom">
									<div class="land_f4 vertical head-left">
										<img  src="{$vo.thumb}">
									</div>
									
									<div class="land_h my_tra2  tnt_btm vertical" style="float:right;">
										<div class="land_h1 f11 vertical">
											<img src="__IMG__/land_d3.png">
											<span>{$vo.reviewnum}</span>条评论
										</div>
										<div class="land_h2 f11 vertical">
											<img src="__IMG__/land_d4.png">
											<span>{$vo.collectnum}</span>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</a>
					</volist>
				</div>
          </div>
          <eq name="data['houseowner_status']" value="1">	
		<div class="land_btm re land_c">
			<div class="comments_box" style='display:none'>
				<volist name='actdata' id='vo'>
					<a href="{:U('Web/Party/show',array('id'=>$vo['id']))}">
					<div class="land_d pr f0">
						<div class="left-img"><img src="{$vo.thumb}"></div>
						<div class="right-content">
							<div class="land_f1 f16">{$vo.title}</div>

							<div class="land_f3 fich_kk f0">
								<div class="land_font">
									<span>时间:</span> {$vo.starttime|date='Y-m-d',###}至{$vo.endtime|date='Y-m-d',###}   
								</div> 
								<div class="land_font">
									<span>地点:</span> {$vo.address}        
								</div>
							</div>
						</div>
					</div>
				</a>
				</volist>
			</div>
		</div>	
		</eq>     
		<eq name="data['houseowner_status']" value="1">
		<div class="land_btm re land_c">
			<div class="comments_box" style='display:none'>
				<volist name='hosteldata' id='vo'>
					<a href="{:U('Web/Hostel/show',array('id'=>$vo['id']))}">
						<div class="list-item">
							<div class="list-item-left-img"><img src="{$vo.thumb}"></div>
							<div class="list-item-right-content">
								<div class="title">{$vo.title}</div>
								<!-- <div class="time">{$vo.inputtime|date='Y-m-d',###}</div> -->
								<div>
									<div class="money"><em>￥</em>{$vo.money}<span>起</span>
									</div>
								</div>
								<div class="bottom">
									<div class="land_h my_tra2  tnt_btm vertical" style="float:right;">
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
		</eq>     
		<div class="land_btm re land_c">
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
<include file="public:chat_uitls" />
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
		$('.focus').click(function(){
            $.ajax({
                type: "POST",
                url: "{:U('Web/Member/ajax_attention')}",
                data: {
                    tuid:{$data.id}
                },
                dataType: "json",
                success: function(data) {
                    if (data.code == 200) {
                        var htmlStr = $('.focus').html();
                        if(htmlStr == '已关注')
                        	$('.focus').html('+关注');
                        else
                        	$('.focus').html(已关注);
                    } else {          
                        $.alert(data.msg);
                        return false;
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $.hideLoading();
                    $.alert('系统错误！');
                }
            });
		});
	});
	
</script>
</body>
</html>
