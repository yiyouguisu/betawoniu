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
    <!--<link href="/Public/Wx/css/default.css" rel="stylesheet" />-->
    <script src="/Public/Wx/js/islider.js"></script>
    <script src="/Public/Wx/js/islider_desktop.js"></script>
    <script>
    function aa(nid){
        window.location.href=nid;
    }
    </script>
<style>
	body{
		background:#252c3f;
	}
    .recom_a img{
        width: 100%;
    }
</style>
<div class="wrap">
        <div class="Wait_for_main1_top">
            <div class="Wait_for_main1_top2">
                <ul class="Wait_for_main1_top2_ul">
                    <li class="middle Wait_for_main1_top2_list2">
                        <a href="<?php echo U('Wx/Member/waitreward');?>"><span>等待抽奖</span><i>(<?php echo ((isset($waitnum) && ($waitnum !== ""))?($waitnum):"0"); ?>)</i></a>
                    </li>
                    <li class="middle">
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
        <div class="wrap2">
            <div class="Wait_for_main1">
                <ul class="Wait_for_main1_ul">
                    <div class="item_list infinite_scroll">
                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="aitem">
        <div class="Wait_for_main1_list">
            <div class="Wait_for_main1_list2">
                <a href="<?php echo ($vo["link"]); ?>"><?php echo ($vo["title"]); ?></a>
            </div>
            <div class="Wait_for_main1_list3">
                <div class="middle Wait_for_main1_list3_1">
                    <img src="/Public/Wx/img/image/icon/time.png" /><span>开奖时间：<em><?php echo (date("Y-m-d",$vo["endtime"])); ?></em></span>
                </div>
                <div class="middle Wait_for_main1_list3_2">
                    <a href="<?php echo U('Wx/Member/setphone',array('id'=>$vo['id'],'houseid'=>$vo['houseid'],'from'=>'waitreward'));?>">
                        <i>邀好友拿抽奖码</i>
                        <img src="/Public/Wx/img/image/icon/img5.png" />
                    </a>
                </div>
            </div>
            <div class="Wait_for_main1_list4 hidden">
                <div class="fl Wait_for_main1_list5">
                    <span>抽奖码 :</span>
                </div>
                <div class="fl Wait_for_main1_list6 hidden">
                    <span class="c999 f11">
                        <?php if(is_array($vo['pool'])): $i = 0; $__LIST__ = $vo['pool'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if(($key) != "0"): ?>、<?php endif; echo ($v); endforeach; endif; else: echo "" ;endif; ?>
                    </span>
                    <a href="<?php echo U('Wx/Member/pool',array('vaid'=>$vo['id']));?>" class="c333 f12 fr">更多</a>
                </div>
            </div>
        </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div id="more"><a href="<?php echo U('Wx/Member/waitreward',array('isAjax'=>1,'p'=>2));?>"></a></div>
                </ul>
            </div>
        </div>
    </div>


    <div style="margin-bottom:260px;"></div>
    <div class="" style="position:fixed; left:0px;bottom:0px; background: #252c3f;">
        <div class="Submit_successfully_main2">
            <div class="Submit_main2_top">
                <a >更多活动  <em>(<?php echo ((isset($totalnum) && ($totalnum !== ""))?($totalnum):"0"); ?>)</em></a>
            </div>
            <div id="dom-effect" class="iSlider-effect"></div>
        </div>
    </div>
    <script>

    var domList = <?php echo ($jsonStr); ?>;
    var hasCoupons = '<?php echo ($hasCoupons); ?>';
    if(hasCoupons > 0){
        $('.Wait_for_main1_top2_list').css("background","#de6064");
        $('.Wait_for_main1_top2_list').css('border-radius',"50%");
    }
        
    //滚动dom
    var islider4 = new iSlider({
        data: domList,
        dom: document.getElementById("dom-effect"),
        type: 'dom',
        animateType: 'depth',
        isAutoplay: false,
        isLooping: true,
    });

    </script>
    <script type="text/javascript">
        
        $(function () {
            // $("img").delegate(".aa","click",function(){
            //     console.log("11");
            //     alert("11")
            // })
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