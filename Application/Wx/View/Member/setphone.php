<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="warp pr">
        <div class="main">
            <div class="mian_img">
                <img src="__IMG__/logo.png" />
            </div>
            <div class="main1">
                <input class="text1" type="tel" id="phone" value="{$user.phone}" placeholder="请输入手机号码报名" />
                <p>如果您中奖，我们将会通过您的手机号</p>
                <p>联系您，请认真填写</p>
                <a href="javascript:;" class="sub save">下一步</a>
            </div>
        </div>


        <div class="binding"></div>
        <div class="tele_share5">
            <img class="close" src="__IMG__/img1.png" />
            <div class="tele_share2">
                <p>
                    点击右上角，选择【发送给朋友】邀请好
                    友，好友点击文章底部的【阅读原文】报
                    名成功，您即可额外获【一个抽奖码】数
                    量没有上限！
                </p>
                <img src="__IMG__/tele_share.jpg" />
            </div>
        </div>
    </div>

    <div class="tele_share3">
        <span>您已提交报名信息</span>
        <p>点击右上角，选择 【分享到朋友圈】 即可报名成功获取抽奖吗。</p>
        <div class="tele_share4">
            <img src="__IMG__/tele_share.jpg" />
        </div>
    </div>
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
<script type="text/javascript">
    $(function () {
        $(".save").click(function(){
            var phone = $("#phone").val();
            var uid = "{$user.id}";
            if (uid == '') {
                $.alert("请先成为会员", function () {
                    window.location.href = "{:U('Wx/Public/wxlogin')}";
                })
                return false;
            }
            if (phone == '') {
                $.alert("请填写手机号码");
                return false;
            }

            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/Member/ajax_setphone')}",
                data: {'phone':phone,'uid':uid},
                dataType: "json",
                success: function(data){
                    if(data.code==1){
                        $.hideLoading();
                        $(".binding,.tele_share3").show();
                    }else{
                        $.hideLoading();
                        $.alert(data.msg);
                        return false;
                    }

                }
            });

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
    $.ajax({
        type: "POST",
        url: "{:U('Wx/Member/ajax_share')}",
        data: {'sharetype':sharetype,'sharestatus':sharestatus,'mid':mid},
        dataType: "json",
        success: function(data){
            if(sharestatus=='success'){
                window.location.href="{:U('Wx/Member/reward',array('type'=>6))}";
            }
        }
    });
}
</script>
</body>
</html>
