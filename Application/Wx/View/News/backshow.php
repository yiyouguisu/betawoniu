<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="body_bg">
    <div class="wrap">
        <div class="WeChat_list1_main">
            <span>{$data.title}</span>
            <i>{$data.inputtime|date="Y-m-d",###}</i><a href="javascript:;">蜗牛慢生活</a>
        </div>
        <div class="binding"></div>
        <div class="tele_share5">
            <img class="close" src="__IMG__/img1.png" />
            <div class="tele_share2">
                <p>
                    点击右上角，选择【发送给朋友】邀请好友，好友点击文章底部的【立即报名】并成功分享到朋友圈，您即可额外获【一个抽奖码】数量没有上限！
                </p>
                <img src="__IMG__/tele_share2.jpg" />
            </div>
        </div>
    </div>
    <div class="details_main3 wrap">
        <div class="details_main3_02">
            <p>{$data.content}</p>
            <img src="{$site.vote_image}" />
            <p>{$site.vote_description}</p>
        </div>
    </div>
    <div class="wrap WeChat_list1_main5"></div>
    <div class="wrap">
        <div class="WeChat_list1_main3">
            <div class="WeChat_list1_main4">
                <span>阅读<em>{$data.view|default="0"}</em></span>
                <label>
                    <img src="__IMG__/WeChat_list/img1.jpg" class="hit" />赞(<span style="width: 10px;" id="hitnum">{$data.hit|default="0"}</span>)</label>
                <!--<i onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>6))}'">立即报名</i>-->
                <i class="join">更多民宿</i>
            </div>
        </div>

    </div>

</div>

<script type="text/javascript">
    $(function () {
        $(".hit").click(function () {
            var nid = '{$data.id}';
            var uid = "{$user.id}";
            if (uid == '') {
                $.alert("请先成为会员", function () {
                    window.location.href = "{:U('Wx/Public/wxlogin')}";
                })
                return false;
            }

            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/News/ajax_hit')}",
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
                window.location.href = "{:U('Wx/News/index')}";
        })
    })
</script>
<script type="text/javascript">
    $(function () {
        $(".main").height($(window).height());
        $(".main").css({
            "background-size": "100% " + $(window).height() + ""
        })
        $(".binding,.tele_share5").show();
        $(".tele_share5 .close").click(function(){
            $(".binding,.tele_share5").hide()
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
          'hideMenuItems'
        ]
    });
    wx.ready(function () {


        // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
        wx.onMenuShareAppMessage({
            title: '{$share.title}',
            desc: '{$share.content}',
            link: '{$share.link}',
            imgUrl: '{$share.image}',
            trigger: function (res) {

            },
            success: function (res) {
                alert('已分享');
                ajax_share('{$share.id}','ShareAppMessage','success');
            },
            cancel: function (res) {
                alert('已取消');
                ajax_share('{$share.id}','ShareAppMessage','cancel');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
                ajax_share('{$share.id}','ShareAppMessage','error');
            }
        });


        // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
        wx.onMenuShareTimeline({
            title: '{$share.content}',
            desc: '{$share.content}',
            link: '{$share.link}',
            imgUrl: '{$share.image}',
            trigger: function (res) {
                // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
            },
            success: function (res) {
                alert('已分享');
                ajax_share('{$share.id}','ShareTimeline','success');
            },
            cancel: function (res) {
                alert('已取消');
                ajax_share('{$share.id}','ShareTimeline','cancel');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
                ajax_share('{$share.id}','ShareTimeline','error');
            }
        });


        // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口

        wx.onMenuShareQQ({
            title: '{$share.title}',
            desc: '{$share.content}',
            link: '{$share.link}',
            imgUrl: '{$share.image}',
            trigger: function (res) {
            },
            complete: function (res) {
            },
            success: function (res) {
                alert('已分享');
                ajax_share('{$share.id}','ShareQQ','success');
            },
            cancel: function (res) {
                alert('已取消');
                ajax_share('{$share.id}','ShareQQ','cancel');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
                ajax_share('{$share.id}','ShareQQ','error');
            }
        });


        // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
        wx.onMenuShareWeibo({
            title: '{$share.title}',
            desc: '{$share.content}',
            link: '{$share.link}',
            imgUrl: '{$share.image}',
            trigger: function (res) {
            },
            complete: function (res) {
            },
            success: function (res) {
                alert('已分享');
                ajax_share('{$share.id}','ShareWeibo','success');
            },
            cancel: function (res) {
                alert('已取消');
                ajax_share('{$share.id}','ShareWeibo','cancel');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
                ajax_share('{$share.id}','ShareWeibo','error');
            }
        });


        // 2.5 监听“分享到QZone”按钮点击、自定义分享内容及分享接口

        wx.onMenuShareQZone({
            title: '{$share.title}',
            desc: '{$share.content}',
            link: '{$share.link}',
            imgUrl: '{$share.image}',
            trigger: function (res) {
            },
            complete: function (res) {
            },
            success: function (res) {
                alert('已分享');
                ajax_share('{$share.id}','ShareQZone','success');
            },
            cancel: function (res) {
                alert('已取消');
                ajax_share('{$share.id}','ShareQZone','cancel');
            },
            fail: function (res) {
                alert(JSON.stringify(res));
                ajax_share('{$share.id}','ShareQZone','error');
            }
        });
    });

    wx.error(function (res) {
        //alert(res.errMsg);
    });
    function ajax_share(mid,sharetype,sharestatus){
        //$.ajax({
        //    type: "POST",
        //    url: "{:U('Wx/Member/ajax_share')}",
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

