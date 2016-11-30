<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
<meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
<meta name="format-detection" content="telephone=no" />
<link href="favicon.ico" rel="SHORTCUT ICON">
<title><?php echo ($site["sitetitle"]); ?></title>

<link rel="stylesheet" href="/Public/Public/css/weui.css">
<link rel="stylesheet" href="/Public/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/Public/Wx/css/layer.css">
<script src="/Public/Wx/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Public/js/jquery-weui.js"></script>
<script type="text/javascript" src="/Public/public/js/jquery.infinitescroll.js"></script>
<script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script> 
<script src="/Public/Wx/js/layer.js" type="text/javascript"></script> 
</head>
<body>

<link href="/Public/Wx/css/AddStyle.css" rel="stylesheet" />
<link href="/Public/Wx/css/base.css" rel="stylesheet" />
<script src="/Public/Wx/js/jquery.carousel.js"></script>
<link href="/Public/Wx/css/carousel.css" rel="stylesheet" />
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
                        <a href="<?php echo U('Wx/Member/waitreward');?>"><span>等待抽奖</span><i>(<?php echo ((isset($waitnum) && ($waitnum !== ""))?($waitnum):"0"); ?>)</i></a>
                    </li>
                    <li class="middle Wait_for_main1_top2_list2">
                        <a href="<?php echo U('Wx/Member/reward');?>" class="pr">
                            <span>已经抽奖</span>
                            <div class="Wait_for_main1_top2_list pa">
                                <i>奖</i>
                            </div>
                        </a>
                    </li>
                    <li class="middle">
                        <a href="<?php echo U('Wx/Member/endreward');?>"><span>已结束</span><i>(<?php echo ((isset($endnum) && ($endnum !== ""))?($endnum):"0"); ?>)</i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="wrap Draw_result_main2">
            <div class="reward_main2 hidden">
                <div class="fl reward_main3">
                    <ul class="reward_main3_ul">
                    	<li <?php if(empty($type)): ?>class="reward_main3_li"<?php endif; ?> onclick="window.location.href='<?php echo U('Wx/Member/reward');?>'">
		                    全部
		                </li>
		                <li <?php if(($type) == "1"): ?>class="reward_main3_li"<?php endif; ?> onclick="window.location.href='<?php echo U('Wx/Member/reward',array('type'=>1));?>'">
		                    全额抵用券
		                </li>
		                <li <?php if(($type) == "2"): ?>class="reward_main3_li"<?php endif; ?> onclick="window.location.href='<?php echo U('Wx/Member/reward',array('type'=>2));?>'">
		                    5折抵用券
		                </li>
		                <li <?php if(($type) == "3"): ?>class="reward_main3_li"<?php endif; ?> onclick="window.location.href='<?php echo U('Wx/Member/reward',array('type'=>3));?>'">
		                    8折抵用券
		                </li>
		                <li <?php if(($type) == "4"): ?>class="reward_main3_li"<?php endif; ?> onclick="window.location.href='<?php echo U('Wx/Member/reward',array('type'=>4));?>'">
		                    普通投票抵用券
		                </li>
		                <li <?php if(($type) == "5"): ?>class="reward_main3_li"<?php endif; ?> onclick="window.location.href='<?php echo U('Wx/Member/reward',array('type'=>5));?>'">
		                    邀请投票抵用券
		                </li>
		                <!-- <li <?php if(($type) == "6"): ?>class="reward_main3_li"<?php endif; ?> onclick="window.location.href='<?php echo U('Wx/Member/reward',array('type'=>6));?>'">
		                    抽奖码
		                </li> -->
                    </ul>
                    <div class="pa Draw_result_main3">
                        <?php if($type != 6): ?><a href="<?php echo U('Wx/Member/useservice',array('type'=>1));?>">使用规则</a>
			                <?php else: ?>
			                <a href="<?php echo U('Wx/Member/useservice',array('type'=>2));?>">使用规则</a><?php endif; ?>
                    </div>
                </div>
                <div class="fl reward_main4">
                    <div class="reward_main4_01">
                        <ul class="reward_main4_01_ul" style="height: 80%;">
                            <div class="item_list infinite_scroll">
		                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="pr item">
        <div class="rew_left pa"><img src="/Public/Wx/img/image/icon/Draw_result_left.png"  /></div>
        <div class="rew_right pa"><img src="/Public/Wx/img/image/icon/Draw_result_right.png" /></div>
        <div class="reward_main4_01_list">
            <div style="background:#fff; padding-bottom:2%;">
                <div class="reward_main4_01_list1 hidden">
                    <?php if($type == 6): ?><span>抽奖码 <?php echo ($vo["code"]); ?></span>
                        <a href="<?php echo U('Wx/News/backshow',array('nid'=>$vo['hid']));?>">获取更多</a>
                        <?php else: ?>
                        <?php if(($vo['vaid']) == "0"): ?><span>
                                <?php if(($vo['catid']) == "1"): ?>一等奖<?php endif; ?>
                                <?php if(($vo['catid']) == "2"): ?>二等奖<?php endif; ?>
                                <?php if(($vo['catid']) == "3"): ?>三等奖<?php endif; ?>
                                <?php if(($vo['catid']) == "4"): ?>四等奖<?php endif; ?>
                                <?php if(($vo['catid']) == "5"): ?>五等奖<?php endif; ?>
                            </span>
                            <?php else: ?>
                            <span>
                                <?php if(($vo['type']) == "1"): ?>全额抵用券<?php endif; ?>
                                <?php if(($vo['type']) == "2"): ?>5折抵用券<?php endif; ?>
                                <?php if(($vo['type']) == "3"): ?>8折抵用券<?php endif; ?>
                                <?php if(($vo['type']) == "4"): ?>普通投票抵用券<?php endif; ?>
                                <?php if(($vo['type']) == "5"): ?>邀请投票抵用券<?php endif; ?>
                            </span><?php endif; ?>
                        
                        <!--  <?php if(($vo['givenstatus']) == "2"): ?><span style="color:#666">
                                <?php if(($vo['type']) == "1"): ?>一等奖<?php endif; ?>
                                <?php if(($vo['type']) == "2"): ?>二等奖<?php endif; ?>
                                <?php if(($vo['type']) == "3"): ?>三等奖<?php endif; ?>
                                <?php if(($vo['type']) == "4"): ?>四等奖<?php endif; ?>
                                <?php if(($vo['type']) == "5"): ?>五等奖<?php endif; ?>
                            </span>
                            <?php else: ?>
                            <span>
                                <?php if(($vo['type']) == "1"): ?>一等奖<?php endif; ?>
                                <?php if(($vo['type']) == "2"): ?>二等奖<?php endif; ?>
                                <?php if(($vo['type']) == "3"): ?>三等奖<?php endif; ?>
                                <?php if(($vo['type']) == "4"): ?>四等奖<?php endif; ?>
                                <?php if(($vo['type']) == "5"): ?>五等奖<?php endif; ?>
                            </span><?php endif; ?> -->
                      
                        <?php if(($vo['type']) == "4"): ?><i>￥<em><?php echo ((isset($vo["price"]) && ($vo["price"] !== ""))?($vo["price"]):"0"); ?></em></i><?php endif; ?>
                        <?php if(($vo['type']) == "5"): ?><i>￥<em><?php echo ((isset($vo["price"]) && ($vo["price"] !== ""))?($vo["price"]):"0"); ?></em></i><?php endif; ?>
                        <?php if(($vo['givenstatus']) != "0"): ?><a class="reward_main4_01_list1a1" style="background-color:#666" href="javascript:;">赠送</a>
                            <?php else: ?>
                            <a class="reward_main4_01_list1a1" href="<?php echo U('Wx/Member/givencoupons',array('id'=>$vo['id']));?>">赠送</a><?php endif; endif; ?>
                </div>
                <?php if($vo['vaid'] != 0): ?><a href="<?php echo ($vo["link"]); ?>">
                <?php else: ?>
                    <a href="<?php echo U('Wx/Vote/show',array('id'=>$vo['hid']));?>"><?php endif; ?>
                <div class="reward_main4_01_list2">
                    <div class="reward_main4_01_list2_list1">
                        <span>适用于:</span>
                        <i><?php echo ($vo["house"]); ?></i>
                    </div>
                    <div class="reward_main4_01_list2_list1">
                        <span>有效期:</span>
                        <i><?php echo (date("Y-m-d",$vo["in_starttime"])); ?>至<?php echo (date("Y-m-d",$vo["in_endtime"])); ?></i>
                    </div>
                    <?php if($vo['vaid'] != 0): ?><div class="reward_main4_01_list2_list1">
                            <span>中奖码:</span>
                            <i><?php echo ($vo["code"]); ?></i>
                        </div>
                    <?php else: ?>
                        <div class="reward_main4_01_list2_list1">
                            <span>来源:</span>
                            <i>评选大转盘</i>
                        </div><?php endif; ?>
                </div>
                </a>
                <?php if($type != 6): ?><div class="reward_main4_01_list2_list2">
                        <?php if(($vo['givenstatus']) == "1"): ?><a href="javascript:;" style="color:#666" >等待入住中</a><?php endif; ?>
                        <?php if(($vo['givenstatus']) == "0"): ?><a href="<?php echo U('Wx/Member/usecoupons',array('id'=>$vo['id']));?>">立即使用</a><?php endif; ?>
                        <?php if(($vo['givenstatus']) == "2"): ?><a href="javascript:;" style="color:#666" >已完成</a><?php endif; ?>
                    </div><?php endif; ?>
            </div>
        </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
		                    </div>
		                    <div id="more"><a href="<?php echo U('Wx/Member/reward',array('isAjax'=>1,'p'=>2,'type'=>$type));?>"></a></div>
                        </ul>
                        <div style="margin-top:10rem;"></div>
                        <div class="wrap">
                            <div class="reward_5">
                                <span>共<em><?php echo ((isset($count) && ($count !== ""))?($count):"0"); ?></em>张</span>
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
			var hasCoupons = '<?php echo ($hasCoupons); ?>';
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
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
      debug: false,
      appId: '<?php echo $signPackage["appId"];?>',
      timestamp: <?php echo $signPackage["timestamp"];?>,
      nonceStr: '<?php echo $signPackage["nonceStr"];?>',
      signature: '<?php echo $signPackage["signature"];?>',
      jsApiList: [
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'hideMenuItems'
      ]
  });
  wx.ready(function () {


  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareAppMessage({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {

      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareAppMessage','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareAppMessage','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareAppMessage','error');
      }
    });


  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareTimeline({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {
        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareTimeline','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareTimeline','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareTimeline','error');
      }
    });


  // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口

    wx.onMenuShareQQ({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {
      },
      complete: function (res) {
      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareQQ','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareQQ','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareQQ','error');
      }
    });


  // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareWeibo({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {
      },
      complete: function (res) {
      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareWeibo','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareWeibo','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareWeibo','error');
      }
    });


  // 2.5 监听“分享到QZone”按钮点击、自定义分享内容及分享接口

    wx.onMenuShareQZone({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {
      },
      complete: function (res) {
      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareQZone','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareQZone','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareQZone','error');
      }
    });
});

wx.error(function (res) {
  //alert(res.errMsg);
});
// function ajax_share(mid,sharetype,sharestatus){
    //$.ajax({
    //    type: "POST",
    //    url: "<?php echo U('Home/Index/ajax_share');?>",
    //    data: {'sharetype':sharetype,'sharestatus':sharestatus,'mid':mid},
    //    dataType: "json",
    //    success: function(data){
    //        if(sharestatus=='success'){
    //            window.location.href='/index.php/Index/order/mid/'+mid+'.html';
    //        }

    //    }
    //});
// }
</script>
</body>
</html>