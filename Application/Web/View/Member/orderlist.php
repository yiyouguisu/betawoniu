<include file="Public:head" />
<body>
<div class="header center pr f18">
		<div class="header_bmn1">
			<a class='column'>民宿</a>
			<a class='column'>活动</a>
		</div>
		<div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <!-- <div class="head_click tra_head pa"><a href="">编辑</a></div> -->
</div>
<div class="container ht" style='display:none'>
	<div class="land">
		<div class="land_b map_title center f14 list_four">
			<a class="ht_a">全部</a>
			<a class="ht_a">待支付</a>
			<a class="ht_a">待审核</a>
			<a class="ht_a">已完成</a>
		</div>

   		<!-- 全部 -->
		<div class="land_c f14 content">
			<volist name='ht' id='vo'>
	           <div class="land_d pr f0">
	                <div class="land_e vertical"><img src="{$vo.thumb}"></div>
	                <div class="land_f vertical">
	                      <div class="land_f1 f16">{$vo.title}</div>
	                      <div class="land_f2 f13">
	                            <div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
	                            </div>
	                      </div>
	                      <div class="land_f3 pa f0">
	                            <div class="land_f4 my_tra1 vertical"><span>已完成</span></div>
	                            <div class="land_h my_tra2 vertical" style="vertical-align:bottom">
	                                  <div class="rev_btn rev_btn1"><a href="my-review.html">我要点评</a></div>
	                            </div>
	                      </div>
	                </div>
	           </div>
	  		</volist>         
		</div>
		<!-- 未付款 -->
		<div class="land_c f14 content">
			<volist name='ht' id='vo'>
	           <div class="land_d pr f0">
	                <div class="land_e vertical"><img src="{$vo.thumb}"></div>
	                <div class="land_f vertical">
	                      <div class="land_f1 f16">{$vo.title}</div>
	                      <div class="land_f2 f13">
	                            <div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
	                            </div>
	                      </div>
	                      <div class="land_f3 pa f0">
	                            <div class="land_f4 my_tra1 vertical"><span>已完成</span></div>
	                          
	                          <!-- <div class="land_f4 my_tra1 vertical"><span class="my_span">未付款</span></div> -->

	                            <div class="land_h my_tra2 vertical" style="vertical-align:bottom">
	                                  <div class="rev_btn rev_btn1"><a href="my-review.html">我要点评</a></div>

	                                 <!-- <div class="rev_btn"><a href="">去支付</a></div> -->
	                            </div>
	                      </div>
	                </div>
	           </div>
	  		</volist>         
		</div>
		<!-- 已完成 -->
		<div class="land_c f14 content">
			<volist name='ht' id='vo'>
	           <div class="land_d pr f0">
	                <div class="land_e vertical"><img src="{$vo.thumb}"></div>
	                <div class="land_f vertical">
	                      <div class="land_f1 f16">{$vo.title}</div>
	                      <div class="land_f2 f13">
	                            <div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
	                            </div>
	                      </div>
	                      <div class="land_f3 pa f0">
	                            <div class="land_f4 my_tra1 vertical"><span>已完成</span></div>
	                            <div class="land_h my_tra2 vertical" style="vertical-align:bottom">
	                                  <div class="rev_btn rev_btn1"><a href="my-review.html">我要点评</a></div>
	                            </div>
	                      </div>
	                </div>
	           </div>
	  		</volist>         
		</div>


	</div>	   	
</div>

<div class="container act" style='display:none'>
	<div class="land">
		<div class="land_b map_title center  f14">
			<a class="act_a ">全部</a>
			<a class="act_a ">未付款</a>
			<a class="act_a ">已完成</a>
		</div>

   		<!-- 全部 -->
		<div class="land_c f14 content" style='display:none'>
			<volist name='act' id='vo'>
	           <div class="land_d pr f0">
	                <div class="land_e vertical"><img src="{$vo.thumb}"></div>
	                <div class="land_f vertical">
						<div class="land_f1 f16">{$vo.title}</div>
						<div class="land_f2 f13">
							<div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
							</div>
						</div>
						<div class="land_f3 pa f0">
						  	<if condition='$vo.paystatus eq 0'>
						  		<div class="land_f4 my_tra1 vertical"><span class="my_span">未付款</span></div>
						  	<else/>
						  		<div class="land_f4 my_tra1 vertical"><span>已完成</span></div>
						  	</if>
						    <div class="land_h my_tra2 vertical" style="vertical-align:bottom">
								<if condition='$vo.paystatus eq 0'>
									<div class="rev_btn"><a href="{:U('Web/Order/partyPay',array('orderid'=>$vo['id']))}">去支付</a></div>
								<else/>
									<div class="rev_btn rev_btn1"><a href="my-review.html">我要点评</a></div>
								</if>
						    </div>
						</div>
	                </div>
	           </div>
	  		</volist>         
		</div>
		<!-- 未付款 --> 
		<div class="land_c f14 content" style='display:none'>
			<volist name='act' id='vo'>
				<if condition='$vo.paystatus eq 0'>
					<div class="land_d pr f0">
		                <div class="land_e vertical"><img src="{$vo.thumb}"></div>
		                <div class="land_f vertical">
								<div class="land_f1 f16">{$vo.title}</div>
								<div class="land_f2 f13">
									<div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
									</div>
								</div>
								<div class="land_f3 pa f0">
		                      		<div class="land_f4 my_tra1 vertical"><span class="my_span">未付款</span></div>
		                            <div class="land_h my_tra2 vertical" style="vertical-align:bottom">
		                                 <div class="rev_btn"><a href="{:U('Web/Order/partyPay',array('orderid'=>$vo['orderid']))}">去支付</a></div>
		                            </div>
								</div>
		                </div>
					</div>
				</if>
	  		</volist>         
		</div>
		<!-- 已完成 -->
		<div class="land_c f14 content" style='display:none'>
			<volist name='act' id='vo'>
				<if condition='$vo.paystatus eq 1'>
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">
								<div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
								</div>
							</div>
							<div class="land_f3 pa f0">
								<div class="land_f4 my_tra1 vertical"><span>已完成</span></div>
								<div class="land_h my_tra2 vertical" style="vertical-align:bottom">
									<div class="rev_btn rev_btn1"><a href="{:U('Web/Review/index',array('type'=>1,'id'=>$vo['id']))}">我要点评</a></div>
								</div>
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
	// 栏目切换
	$('.container').eq(0).show();
	$('.column').eq(0).addClass('head_cut');
	$('.column').click(function(){
		$('.container').hide();
		$('.column').removeClass('head_cut');
		$('.container').eq($(this).index()).show();
		$('.column').eq($(this).index()).addClass('head_cut');
	});
	click('act','act_a');
	click('ht','ht_a');


});	

function click(act,act_a){
	$('.'+act).find('.content').eq(0).show();
	$('.'+act_a).eq(0).addClass('land_cut');
	$('.'+act_a).click(function(){
		$('.'+act).find('.content').hide();
		$('.'+act_a).removeClass('land_cut');
		$('.'+act).find('.content').eq($(this).index()).show();
		$('.'+act_a).eq($(this).index()).addClass('land_cut');
	})
}


</script>


<include file="Public:foot" />