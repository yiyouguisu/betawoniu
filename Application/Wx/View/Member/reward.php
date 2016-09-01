<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="wrap">
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
                <li <eq name="type" value="6"> class="reward_main3_li"</eq> onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>6))}'">
                    抽奖码
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="fl reward_main4">
            <div class="reward_main4_01">
                <ul class="reward_main4_01_ul">
                    <div class="item_list infinite_scroll">
                        <include file="Member:morelist_reward" />
                    </div>
                    <div id="more"><a href="{:U('Wx/Member/reward',array('isAjax'=>1,'p'=>2,'type'=>$type))}"></a></div>

            </ul>
			<div class="wrap">
				<div class="reward_5">

				</div>
			</div>
        </div>
        </div>
    </div>
</div>
<!-- <div class="wrap">
        <div class="reward7">
            <span>共<em>{$count|default="0"}</em>张</span>
        </div>
    </div> -->
<!--一下注释<div class="wrap">
		<div class="reward_main1">
			<a href="{:U('Wx/Member/useservice')}">使用规则</a>
		</div>
	</div>-->
	<script type="text/javascript">
		$(window).scroll(function () {
			var top = $(document).scrollTop();
			if (top > 0) {
				$(".reward_main3_ul").css({
					"position": "fixed",
					"top": "0",
					"left": "0",
					"width": "25%"
				})
			}
		});
	</script>
	<script type="text/javascript">
        $(".reward_main3").height($(window).height());
    </script>
	<!--一下添加-->
	<div class="wrap">
        <div class="reward7">
            <span>共<em style="font-size:1.8rem">{$count|default="0"}</em>张</span>
            <if condition="$type neq 6">
                <a href="{:U('Wx/Member/useservice',array('type'=>1))}">使用规则</a>
                <else />
                <a href="{:U('Wx/Member/useservice',array('type'=>2))}">使用规则</a>
             </if>
        </div>
    </div>
	<script type="text/javascript">
		$(function () {
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
