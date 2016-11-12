<include file="public:head" />
<link href="__CSS__/AddStyle.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<script src="__JS__/jquery.carousel.js"></script>
<link href="__CSS__/carousel.css" rel="stylesheet" />
<style>
body{
	background:#21283b; 
}
</style>
    <div class="wrap">
        <div class="Wait_for_main1_top">
            <div class="Wait_for_main1_top2">
                <ul class="Wait_for_main1_top2_ul">
                    <li class="middle">
                        <a href="{:U('Wx/Member/waitreward')}"><span>等待抽奖</span><i>({$waitnum|default="0"})</i></a>
                    </li>
                    <li class="middle Wait_for_main1_top2_list2">
                        <a href="{:U('Wx/Member/reward')}" class="pr">
                            <span>已经抽奖</span>
                            <div class="Wait_for_main1_top2_list pa">
                                <i>奖</i>
                            </div>
                        </a>
                    </li>
                    <li class="middle">
                        <a href="{:U('Wx/Member/endreward')}"><span>已结束</span><i>({$endnum|default="0"})</i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="wrap Draw_result_main2">
            <div class="reward_main2 hidden">
                <div class="fl reward_main3">
                    <ul class="reward_main3_ul">
                    	<li <empty name="type"> class="reward_main3_li"</empty> onclick="window.location.href='{:U('Wx/Member/reward')}'">
		                    全部
		                </li>
		                <li <eq name="type" value="1"> class="reward_main3_li"</eq> onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>1))}'">
		                    全额抵用券
		                </li>
		                <li <eq name="type" value="2"> class="reward_main3_li"</eq> onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>2))}'">
		                    5折抵用券
		                </li>
		                <li <eq name="type" value="3"> class="reward_main3_li"</eq> onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>3))}'">
		                    8折抵用券
		                </li>
		                <li <eq name="type" value="4"> class="reward_main3_li"</eq> onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>4))}'">
		                    普通投票抵用券
		                </li>
		                <li <eq name="type" value="5"> class="reward_main3_li"</eq> onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>5))}'">
		                    邀请投票抵用券
		                </li>
		                <!-- <li <eq name="type" value="6"> class="reward_main3_li"</eq> onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>6))}'">
		                    抽奖码
		                </li> -->
                    </ul>
                    <div class="pa Draw_result_main3">
                        <if condition="$type neq 6">
			                <a href="{:U('Wx/Member/useservice',array('type'=>1))}">使用规则</a>
			                <else />
			                <a href="{:U('Wx/Member/useservice',array('type'=>2))}">使用规则</a>
			             </if>
                    </div>
                </div>
                <div class="fl reward_main4">
                    <div class="reward_main4_01">
                        <ul class="reward_main4_01_ul" style="height: 80%;">
                            <div class="item_list infinite_scroll">
		                        <include file="Member:morelist_reward" />
		                    </div>
		                    <div id="more"><a href="{:U('Wx/Member/reward',array('isAjax'=>1,'p'=>2,'type'=>$type))}"></a></div>
                        </ul>
                        <div style="margin-top:10rem;"></div>
                        <div class="wrap">
                            <div class="reward_5">
                                <span>共<em>{$count|default="0"}</em>张</span>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(".reward_main3").height($(window).height());
        Caroursel.init($('.caroursel'))
    </script>
	<script type="text/javascript">

		$(function () {
			var hasCoupons = '{$hasCoupons}';
    if(hasCoupons > 0){
        $('.Wait_for_main1_top2_list').css("background","#de6064");
        $('.Wait_for_main1_top2_list').css('border-radius',"50%");
    }
			$('img.pic').lazyload({
				effect: 'fadeIn'
			});
			$('.item').fadeIn();
			var sp = 1
			$(".infinite_scroll").infinitescroll({
				navSelector: "#more",
				nextSelector: "#more a",
				itemSelector: ".item",
				loading: {
					msgText: ' ',
					finishedMsg: '没有更多数据',
					finished: function () {
						sp++;
						if (sp >= 120) {
							$("#more").remove();
							$(window).unbind('.infscr');
						}
						$("#infscr-loading").hide();
					}
				}, errorCallback: function () {

				}

			}, function (newElements) {
				var $newElems = $(newElements);
				$('.infinite_scroll').append($newElems);
				$newElems.fadeIn();
				return;
			});

		});
	</script>
<include file="public:foot" />
