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

<link href="/Public/Wx/css/Style.css" rel="stylesheet" />
<link href="/Public/Wx/css/base.css" rel="stylesheet" />
<link href="/Public/Wx/css/AddStyle.css" rel="stylesheet" />
<style>
    html{
        overflow-x: hidden;
    }
</style>
<div class="body_bg">
    <div class="wrap">
        <div class="WeChat_list1_main">
            <span><?php echo ($data["title"]); ?></span>
            <i><?php echo (date("Y-m-d",$data["inputtime"])); ?></i><a href="http://mp.weixin.qq.com/s?__biz=MzIzNTI4ODEyNg==&mid=100001017&idx=1&sn=bc71b7305eb6010602cd696ff71b5216"><?php echo ($data["nickname"]); ?> 蜗牛客慢生活</a>
        </div>
        <div class="add_float2 hide">
            <div class="add_float2_bg2"></div>
            <div class="add_botom pa">
                <img class="close" src="/Public/Wx/img/image/icon/img8.png" />
                <div class="add_botom2">
                    <div class="add_botom3">
                        <p>点击右上角，选择【发送给朋友】，好友点击文章底部【参与抽奖】并成功分享朋友圈，您即可额外获得一个抽奖码。抽奖码越多中奖机率越高哦！</p>
                    </div>
                    <div class="add_botom4">
                        <img src="/Public/Wx/img/image/img4.jpg" />
                    </div>
                </div>
                <span>发送给朋友或者发送到 好友群</span>
                <img src="/Public/Wx/img/image/icon/img3.png" />
            </div>
        </div>
    </div>
    <div class="details_main3 wrap">
        <div class="details_main3_02">
            <?php echo ($data["content"]); ?>
        </div>
    </div>
    <div class="hidden"></div>
    <div class="details_main3 wrap">
        <div class="details_main3_02">
            <img src="<?php echo ($site["vote_image"]); ?>" />
            <p><?php echo ($site["vote_description"]); ?></p>
        </div>
    </div>
    <div class="wrap WeChat_list1_main5"></div>
    <div class="wrap">
        <div class="WeChat_list1_main3">
            <div class="WeChat_list1_main4">
                <span>阅读<em><?php echo ((isset($data["view"]) && ($data["view"] !== ""))?($data["view"]):"0"); ?></em></span>
                <label style="font-weight: normal; margin-bottom: 0; ">
                    <img src="/Public/Wx/img/WeChat_list/img3.png" class="hit" />赞(<span style="width: auto;margin-top: -2px;" id="hitnum"><?php echo ((isset($data["hit"]) && ($data["hit"] !== ""))?($data["hit"]):"0"); ?></span>)</label>
                <!--<i onclick="window.location.href='<?php echo U('Wx/Member/reward',array('type'=>6));?>'">立即报名</i>-->
                <div class="" style="display:inline-block;vertical-align:middle; width:37%;overflow:hidden; margin: 2.5% 0;">
                    <a href="javascript:;" class="join">更多民宿</a>
                </div>
            </div>
        </div>
    </div>

    
</div>

<script type="text/javascript">
    $(function () {
        $(".add_float2").height($(window).height());
        $(".add_float2").show();
        $(".hit").click(function () {
            var nid = '<?php echo ($data["id"]); ?>';
            var uid = "<?php echo ($user["id"]); ?>";
            if (uid == '') {
                $.alert("请先清除微信缓存；方法：手机后台关闭微信应用，再重新打开微信。");
                return false;
            }

            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Wx/News/ajax_hit');?>",
                data: { 'nid': nid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        $.hideLoading();
                        var hitnum = $("#hitnum").text();
                        $("#hitnum").text(Number(hitnum) + 1);
                    } else if (data.status == -1) {
                        $.hideLoading();
                        $.alert("该用户已经点赞过");
                    }else {
                        $.hideLoading();
                        $.alert("点赞失败");
                    }
                }
            });
        })
        $(".join").click(function () {
                window.location.href = "<?php echo U('Wx/News/index');?>";
        })
    })
</script>
<script type="text/javascript">
    $(function () {
        $(".main").height($(window).height());
        $(".main").css({
            "background-size": "100% " + $(window).height() + ""
        })
        $(".close").click(function(){
            $(".add_float2").hide();
        })
    })

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
          'hideMenuItems',
          'showAllNonBaseMenuItem',
        ]
    });
    wx.ready(function () {
        wx.showAllNonBaseMenuItem({
          success: function () {
          }
        });

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
            title: '【<?php echo ($share["title"]); ?>】<?php echo ($share["content"]); ?>',
            desc: '【<?php echo ($share["title"]); ?>】<?php echo ($share["content"]); ?>',
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
    function ajax_share(mid,sharetype,sharestatus){
        //$.ajax({
        //    type: "POST",
        //    url: "<?php echo U('Wx/Member/ajax_share');?>",
        //    data: {'sharetype':sharetype,'sharestatus':sharestatus,'mid':mid},
        //    dataType: "json",
        //    success: function(data){
        //        if(sharestatus=='success'){
        //            $(".binding,.tele_share5").hide()
        //            $(".binding,.tele_share3").show();
        //        }
        //    }
        //});
    }
</script>
</body>
</html>