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

<style>
    .iframe {
        border: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        left: 100%;
        background: #fff;
        z-index: 99999;
        display: none;
    }
    body{
        background:#252c3f;
    }
</style>

<link href="/Public/Wx/css/base.css" rel="stylesheet" />
<link href="/Public/Wx/css/AddStyle.css" rel="stylesheet" />
    <div class="wrap">
        <div class="Gift_friends">
            <div class="Gift_friends_top">
                <img src="/Public/Wx/img/image/icon/Gift_friends.png"     width="100%;"/>
            </div>
            <div class="Gift_friends_top2">
                <a href="javascript:ShowIframe('<?php echo U('Wx/Member/share',array('type'=>1));?>')" class="hidden">
                    <span class="fl middle username">请选择点亮过的好友</span>
                    <img src="/Public/Wx/img/image/icon/img6.png" />
                </a>
            </div>
            <div class="Gift_friends_bottom">
                <p>如果好友没有被点亮，那被赠送的好友必须参与活动才能查看所得抵用券。</p>
                <input class="text3 nickname" type="text" name="nickname" placeholder="好友姓名"/>
                <input class="text3 phone" type="text" name="phone" placeholder="好友联系方式" />
                <input type="hidden" name="id" value="<?php echo ($id); ?>" />
                <input type="hidden" id="uid" name="uid" value="" />
                <input class="sub2 save" type="button" value="确定赠送" />
            </div>
           
        </div>
    </div>
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
<script>
    $(function () {
        $(".save").click(function () {
            var coupons_orderid = $("input[name='id']").val();
            var uid = $("input[name='uid']").val();
            var nickname = $("input[name='nickname']").val();
            var phone = $("input[name='phone']").val();
            if (nickname=='' || phone=='') {
                alert("请选择赠送好友");
                return false;
            }
            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Wx/Member/ajax_given');?>",
                data: { 'uid': uid,'nickname':nickname,'phone':phone, 'coupons_orderid': coupons_orderid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        $.hideLoading();
                        $.alert("赠送成功", function () {
                            window.location.href = "<?php echo U('Wx/Member/reward');?>";
                        })
                    } else if (data.status == -1) {
                        $.hideLoading();
                        $.alert("该优惠券已经使用");
                    } else if (data.status == -2) {
                        $.hideLoading();
                        $.alert("该优惠券过期了");
                    } else if(data.status == -3){
                        $.hideLoading();
                        $.alert("友情提示:您赠送的好友还不是蜗牛客的小伙伴，请先邀请其参与任意抽奖活动！");
                    } else if(data.status == -4){
                        $.hideLoading();
                        $.alert("用户名不能为空！");
                    } else if(data.status == -5){
                        $.hideLoading();
                        $.alert("手机不能为空！");
                    } else {
                        $.hideLoading();
                        $.alert("赠送失败");
                    }
                }
            });
        })
    })
</script>
<script>
    function ShowIframe(url) {
        $iframe = $(".iframe");
        if ($iframe.size() == 0) {
            $iframe = $("<iframe></iframe>");
            $iframe.addClass("iframe");
            $iframe.appendTo("body");
        }
        $iframe.attr("src", url);
        //$("html,body").css("overflow", "hidden");
        $("body").children("div,form").fadeOut();
        $.showLoading();
        $iframe.load(function () {
            $iframe.show().animate({ left: 0 });
            $.hideLoading();
        });
    }
    function CloseIframe() {
        if ($(".iframe").size() > 0) {
            $("body").children("div,form").fadeIn();
            $(".iframe").animate({ left: "100%" }, function () {
                $(".iframe").remove();
                $.hideLoading();
                $(".mask").hide()
                //$("html,body").css("overflow", "auto");
            });
            return false;
        }
    }

</script>