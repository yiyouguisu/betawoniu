<include file="Public:head" />
<body>
<div class="header center pr ft18 fix-head">
	<div class="header_bmn1 ft12">
    <if condition="$showAct eq 1">
		  <a class='column'>美宿</a>
		  <a class='column head_cut'>活动</a>
    <else />
		  <a class='column head_cut'>美宿</a>
		  <a class='column'>活动</a>
    </if>
	</div>
  <div class="head_go pa">
    <a href="{:U('Member/index')}">
      <img src="__IMG__/go.jpg">
    </a>
  </div>
</div>
<if condition="$showAct eq 1">
  <div class="container ht" style='display:none;margin-top:6rem;'>
<else />
  <div class="container ht" style='margin-top:6rem;'>
</if>
	<div class="land">
		<div class="land_b map_title center f14 list_three">
			<a class="ht_a">全部</a>
			<a class="ht_a">待支付</a>
			<a class="ht_a">已完成</a>
		</div>

    <!-- 全部 -->
		<div class="land_c f14 content">
			<volist name='ht' id='vo'>
      <a href="{:U('Order/hotel_order_detail')}?orderid={$vo.orderid}">
	      <div class="land_d pr f0">
          <div class="land_e vertical">
            <img src="{$vo.thumb}" style="width:100px;height:80px;">
          </div>
	        <div class="vertical" style="margin:0 5px">
	          <div class="land_f1 f16">{$vo.title}</div>
	          <div class="land_f2 f13">
              <if condition="$vo.status eq 5">
                <p style="padding: 8px 0 12px 0;width:160px;color:#000" class="over_ellipsis ft10">
                  拒绝理由：{$vo.review_remark}
                </p>
              <elseif condition="$vo.status eq 1" />
                <if condition="$vo.owner_order eq 1">
                  <p style="padding: 8px 0 12px 0;width:160px;color:#000" class="over_ellipsis ft10">
                    入住：{$vo.starttime|date='m月d日', ###} - {$vo.endtime|date='m月d日', ###}
                  </p>
                <else />
                  <div class="land_money ft18" style="padding:5px 0">
                    <em>￥</em>{$vo.money}
	                </div>
                </if>
              <elseif condition="$vo.status eq 3" />
                  <div class="land_money ft18" style="padding:5px 0">
                    <em>￥</em>{$vo.money}
	                </div>
              <else />
                  <p style="padding: 8px 0 12px 0;width:160px;color:#000" class="over_ellipsis ft10">
                    入住：{$vo.starttime|date='m月d日', ###} - {$vo.endtime|date='m月d日', ###}
                  </p>
              </if>
	          </div>
	          <div class="land_f3 pa f0">
              <if condition="$vo.status eq 1">
                <div class="land_f4 my_tra1 vertical" style="width:100%">
                  <span class="my_span">待审核</span>
                </div>
              <elseif condition="$vo.status eq 2" />
                <div class="land_f4 my_tra1 vertical" style="width:100%">
                  <span class="my_span">待支付</span>
                </div>
              <elseif condition="$vo.status eq 3" />
                <div class="land_f4 my_tra1 vertical" style="width:100%">
                  <span class="">已取消</span>
                </div>
              <elseif condition="$vo.status eq 4" />
                <notempty name="vo.checkin">
                  <eq name="vo.refund_status" value="1">
                    <div class="land_f4 my_tra1 vertical" style="width:100%">
                      <span class="my_span">申请退订</span>
                    </div>
                  <else />
                    <div class="land_f4 my_tra1 vertical" style="width:100%">
                      <span class="my_span">待入住</span>
                    </div>
                  </eq>
                </notempty>
                <notempty name="vo.finished">
                  <div class="land_f4 my_tra1 vertical" style="width:100%">
                    <span class="my_span">已完成</span>
                  </div>
                </notempty>
              <elseif condition="$vo.status eq 5" />
                <div class="land_f4 my_tra1 vertical" style="width:100%">
                  <span class="my_span">审核失败</span>
                </div>
              <elseif condition="$vo.status eq 6" />
                <div class="land_f4 my_tra1 vertical" style="width:100%">
                  <span class="">已关闭</span>
                </div>
              </if>
	          </div>
	        </div>
				  <if condition="$vo.status eq 1">
            <if condition="$vo.owner_order eq 1">
              <div class="rev_btn" style="float:right">
                <a class="ft14" href="{:U('Web/Order/go_audio',array('orderid'=>$vo['orderid']))}">去审核</a>
              </div>
            </if>
          <elseif condition="$vo.status eq 2" />
            <if condition="$vo.owner_order eq 0">
              <div class="rev_btn" style="float:right">
                <a class="ft14" href="{:U('Web/Order/hotelPay',array('orderid'=>$vo['orderid']))}">去支付</a>
              </div>
            </if>
				  </if>
				  <if condition="$vo.status eq 4">
            <if condition="$vo.finished eq 1">
              <if condition="$vo.evaluate_status eq 0">
                <div class="rev_btn rev_btn1" style="float:right">
                  <a href="{:U('Member/comment_hotel')}?rid={$vo.rid}&orderid={$vo.orderid}" class="ft14">我要点评</a>
                </div>
              </if>
            </if>
          </if>
	      </div>
      </a>
	  	</volist>         
		</div>
		<!-- 未付款 -->
		<div class="land_c f14 content hide">
			<volist name='ht' id='vo'>
        <if condition="$vo.status eq 2">
          <a href="{:U('Order/hotel_order_detail')}?orderid={$vo.orderid}">
	           <div class="land_d pr f0">
                  <div class="land_e vertical">
                      <img src="{$vo.thumb}" style="width:100px;height:80px;">
                  </div>
	                <div class="vertical" style="margin:0 5px;">
                        <div class="land_f1 f16">
                          <p class="over_ellipsis" style="width:160px;">{$vo.title}</p>
                        </div>
	                      <div class="land_f2 f13">
	                            <div class="land_money ft18" style="padding:5px 0"><em>￥</em>{$vo.money}<span></span>
	                            </div>
	                      </div>
	                      <div class="land_f3 pa f0">
                          <div class="land_f4 my_tra1 vertical">
                            <span class="my_span">未付款</span>
                          </div>
	                      </div>
	                </div>
                  <div class="rev_btn" style="float:right;">
                    <a class="ft14" href="">去支付</a>
                  </div>
	           </div>
          </a>
          </if>
	  		</volist>         
		</div>
		<!-- 已完成 -->
		<div class="land_c f14 content hide">
			<volist name='ht' id='vo'>
        <if condition="$vo.finished eq 1">
          <a href="{:U('Order/hotel_order_detail')}?orderid={$vo.orderid}">
	           <div class="land_d pr f0">
                  <div class="land_e vertical">
                    <img src="{$vo.thumb}" style="width:100px;height:80px;">
                  </div>
	                <div class="vertical" style="margin:0 5px;">
                     <div class="land_f1 ft14">
                       <p style="width:160px" class="over_ellipsis">{$vo.title}</p>
                     </div>
	                   <div class="land_f2 ft14">
	                         <div class="land_money ft18" style="padding:5px 0"><em>￥</em>{$vo.money}<span></span>
	                         </div>
	                   </div>
	                   <div class="land_f3 pa f0">
                       <div class="land_f4 my_tra1 vertical" style="width:100%">
                         <span>已完成</span>
                       </div>
	                   </div>
	                </div>
                  <div class="rev_btn rev_btn1 ft14" style="float:right">
                    <a  href="{:U('Member/comment_hotel')}?rid={$vo.rid}&orderid={$vo.orderid}" class="ft12" href="#">我要点评</a>

                  </div>
                  <div style="clear:both"></div>
	           </div>
          </a>
        </if>
	  	</volist>         
		</div>
	</div>	   	
</div>

<if condition="$showAct eq 1">
  <div class="container act" style='margin-top:6rem'>
<else />
  <div class="container act" style='display:none;margin-top:6rem'>
</if>
	<div class="land">
		<div class="land_b map_title center  f14">
			<a class="act_a ">全部</a>
			<a class="act_a ">未付款</a>
			<a class="act_a ">已完成</a>
		</div>

   		<!-- 全部 -->
		<div class="land_c f14 content" style='display:none'>
			<volist name='act' id='vo'>
          <a href="{:U('Order/party_order_detail')}?orderid={$vo.orderid}">
	          <div class="land_d pr f0">
            <div class="land_e vertical">
              <img src="{$vo.thumb}" style="width:100px;height:80px;">
            </div>
	          <div class="vertical" style="margin:0 5px">
						<div class="land_f1 f16">{$vo.title}</div>
						<div class="land_f2 f13">
              <div class="land_money ft18" style="padding:5px 0">
                <em>￥</em>{$vo.money}<span></span>
							</div>
						</div>
						<div class="land_f3 pa f0">
						  	<if condition='$vo.status eq 1'>
						  		<div class="land_f4 my_tra1 vertical" style="width:100%"><span class="my_span">待审核</span></div>
                <elseif condition="$vo.status eq 2"/>
						  		<div class="land_f4 my_tra1 vertical" style="width:100%"><span class="my_span">待支付</span></div>
                <elseif condition="$vo.status eq 3"/>
						  		<div class="land_f4 my_tra1 vertical" style="width:100%"><span class="">已取消</span></div>
						  	<elseif condition="$vo.status eq 4"/>
                  <eq name="vo.checkin" value="1">
                    <if condition="$vo.refund_status eq 1">
                      <div class="land_f4 my_tra1 vertical" style="width:100%">
                        <span>申请退款</span>
                      </div>
                    <else />
                        <div class="land_f4 my_tra1 vertical" style="width:100%">
                          <span>待参加</span>
                        </div>
                    </if>
                  </eq>
                  <eq name="vo.finished" value="1">
                    <div class="land_f4 my_tra1 vertical" style="width:100%">
                      <span>已完成</span>
                    </div>
                  </eq>
						  	</if>
						  </div>
	          </div>
						<if condition='$vo.status eq 2'>
              <if condition="$vo.owner_order eq 0">
                <div class="rev_btn" style="float:right">
                  <a class="ft14" href="{:U('Web/Order/partyPay',array('orderid'=>$vo['orderid']))}">去支付</a>
                </div>
              </if>
						<elseif condition="$vo.status eq 4"/>
              <if condition="$vo.finished eq 1">
                <if condition="$vo.owner_order eq 0">
                  <div class="rev_btn rev_btn1" style="float:right">
                    <a href="{:U('Party/review')}?orderid={$vo.orderid}" class="ft14">我要点评</a>
                  </div>
                </if>
              <else />
                <if condition="$vo.refund_status eq 1">
                  <if condition="$vo.owner_order eq 1">
                    <div class="rev_btn" style="float:right">
                      <a href="{:U('Order/audit_party')}?orderid={$vo.orderid}" class="ft14">去审核</a>
                    </div>
                  </if>
                </if>
              </if>
						</if>
	        </div>
          </a>
	  		</volist>         
		</div>
		<!-- 未付款 --> 
		<div class="land_c f14 content" style='display:none'>
			<volist name='act' id='vo'>
				<if condition='$vo.paystatus eq 0'>
          <a href="{:U('Order/party_order_detail')}?orderid={$vo.orderid}">
	          <div class="land_d pr f0">
              <div class="land_e vertical">
                <img src="{$vo.thumb}" style="width:100px;height:80px;">
              </div>
	            <div class="vertical" style="margin:0 5px">
						    <div class="land_f1 f16">{$vo.title}</div>
						    <div class="land_f2 f13">
                  <div class="land_money ft18" style="padding:5px 0">
                    <em>￥</em>{$vo.money}<span></span>
						    	</div>
						    </div>
						    <div class="land_f3 pa f0">
						    	<div class="land_f4 my_tra1 vertical" style="width:100%"><span class="my_span">待支付</span></div>
						    </div>
	            </div>
              <div class="rev_btn" style="float:right">
                <if condition="$vo.owner_order eq 0">
                  <a class="ft14" href="{:U('Web/Order/partyPay',array('orderid'=>$vo['orderid']))}">去支付</a>
                </if>
	            </div>
            </div>
          </a>
				</if>
	  	</volist>         
		</div>
		<!-- 已完成 -->
		<div class="land_c f14 content" style='display:none'>
			<volist name='act' id='vo'>
				<if condition='$vo.finished eq 1'>
					<div class="land_d pr f0">
            <div class="land_e vertical">
              <img src="{$vo.thumb}" style="width:100px;height:80px;">
            </div>
						<div class="vertical" style="margin:0 5px;">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">
								<div class="land_money ft18" style="padding:5px 0"><em>￥</em>{$vo.money}<span></span>
								</div>
							</div>
							<div class="land_f3 pa f0">
								<div class="land_f4 my_tra1 vertical" style="width:100%"><span>已完成</span></div>
					    </div>
					</div>
          <div class="rev_btn rev_btn1" style="float:right">
            <a class="ft14" href="{:U('Web/Review/index',array('type'=>1,'id'=>$vo['id']))}">我要点评</a>
          </div>
        </div>
				</if>
	  		</volist>         
		</div>
	</div>	   	
</div>
<script type="text/javascript">
$(function(){
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
<script>
$('.rev_btn').each(function(i, ob) {
  $(ob).find('a').first().remove();
});
</script>
</body>
</html>

