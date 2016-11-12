<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<style>
    html{
        overflow-x: hidden;
    }
</style>
<div class="body_bg">
    <div class="wrap">
        <div class="WeChat_list1_main">
            <span>{$data.title}</span>
            <i>{$data.inputtime|date="Y-m-d",###}</i><a href="http://mp.weixin.qq.com/s?__biz=MzIzNTI4ODEyNg==&mid=100001017&idx=1&sn=bc71b7305eb6010602cd696ff71b5216">{$data.nickname} 蜗牛客慢生活</a>
        </div>
        <div class="binding"></div>
    </div>
    <div class="tele_share3">
        <span>您已提交报名信息</span>
        <p>点击右上角，选择 【分享到朋友圈】 即可报名成功获取抽奖码。</p>
        <div class="tele_share4">
            <img class="close" src="__IMG__/tele_share.jpg" />
        </div>
    </div>

    <div class="details_main3 wrap">
        <div class="details_main3_02">
            {$data.content}
        </div>
    </div>
    <div class="hidden"></div>
    <div class="details_main3 wrap">
        <div class="details_main3_02">
            <img src="{$site.vote_image}" />
            <p>{$site.vote_description}</p>
        </div>
    </div>
    <div class="wrap WeChat_list1_main5"></div>
    <div class="wrap">
        <div class="WeChat_list1_main3">
            <div class="WeChat_list1_main4">
                <span>阅读<em>{$data.view|default="0"}</em></span>
                <label style="font-weight: normal; margin-bottom: 0; ">
                    <img src="__IMG__/WeChat_list/img3.png" class="hit" />赞(<span style="width: auto;    margin-top: -2px;" id="hitnum">{$data.hit|default="0"}</span>)</label>
                <!--<i onclick="window.location.href='{:U('Wx/Member/reward',array('type'=>6))}'">立即报名</i>-->
                <div class="" style="display:inline-block;vertical-align:middle; width:37%;overflow:hidden; margin: 2.5% 0;">
                    <eq name="data['isjoin']" value="0">
                        <a href="javascript:;" class="join">参与抽奖</a>
                        <else />
                        <a href="{:U('Wx/News/backshow',array('nid'=>$data['id']))}" class="join">获取更多抽奖码</a>
                    </eq>
                </div>
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
                $.alert("请先清除微信缓存；方法：手机后台关闭微信应用，再重新打开微信。");
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
                var id="{$data.id}";
                window.location.href = "{:U('Wx/Member/setphone')}?id="+id;
        })
    })
</script>
<script type="text/javascript">
    $(function () {
        $(".main").height($(window).height());
        $(".main").css({
            "background-size": "100% " + $(window).height() + ""
        })
        $("tele_share4 .close").click(function(){
            $(".binding,.tele_share3").hide()
        })
    })

    </script>  
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
$(function(){
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
          'hideAllNonBaseMenuItem',
        ]
    });
    
    wx.ready(function () {
        wx.hideAllNonBaseMenuItem({
          success: function () {
          }
        });
    });

    wx.error(function (res) {
        //alert(res.errMsg);
    });
    })

    function ajax_share(mid,sharetype,sharestatus){
        // $.ajax({
        //     type: "POST",
        //     url: "{:U('Wx/Member/ajax_share')}",
        //     data: {'sharetype':sharetype,'sharestatus':sharestatus,'mid':mid},
        //     dataType: "json",
        //     success: function(data){
        //         if(sharestatus=='success'){
        //             window.location.href="{:U('Wx/Member/waitreward')}";
        //         }
        //     }
        // });
    }
</script>
</body>
</html>

