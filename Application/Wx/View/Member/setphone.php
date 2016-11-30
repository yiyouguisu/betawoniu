<include file="public:head" />
<link rel="stylesheet" href="__CSS__/base.css">
<link rel="stylesheet" href="__CSS__/AddStyle.css">

  <div class="main wrap pr" style=" ">
        <div class="pr main_3">
            <img src="__IMG__/image/img.jpg" />
        </div>
        <div class="pa hidden" style="width:95%; left:0px; z-index:4; padding:2.5% 2.5%; top:0;">
            <div class="main_1">
                <div class="main_top">
                    <span class="middle main_top_span1">蜗牛客</span>
                    <i class="middle" style="display: block;line-height: 0.8rem;">X</i>
                    <span class="middle main_top_span2" style="font-size: 2.3rem;">{$data.theme}</span>
                </div>
                <div class="main_2">
                    <img src="__IMG__/image/icon/img1.png" />
                </div>
                <div class="main_tab">
                    <input type="tel" class="text2" id="phone" value="{$user.phone}" placeholder="请输入手机号码报名" />
                    <input type="text" class="text2" id="nickname" value="{$user.nickname}" placeholder="请输入用户名" />
                    <input class="sub save" type="button" value="下一步"/>
                </div>
                <div class="main_foot">
                    <p>如果您中奖，我们将会通过您的手机号</p>
                    <p>联系您，请认真填写</p>
                </div>
            </div>
        </div>

        <div>
          <div class="add_float3 hide">
                <div class="add_float1_bg1"></div>
                <div class="add_top pa">
                  <img src="__IMG__/image/icon/share001.png" style="width:100%;"/>
                  <img src="__IMG__/image/icon/woniushare002.png" style="width:100%;"/>
                  <img src="__IMG__/image/icon/share004.png" style="width:100%;"/>
                    <!-- <img src="__IMG__/image/icon/img10.png" /> -->
    
                        <!-- <div class="add_botom4">
                            <a href="Submission_failed.html"><img src="__IMG__/image/img4.jpg" /></a>
                        </div> -->
                    
                    <!-- <span>444</span>
                    <img src="__IMG__/image/icon/img3.png" /> -->
                </div>
            </div>
            <div class="add_float1 hide">
                <div class="add_float1_bg1"></div>
                <div class="add_top pa">
                    <img src="__IMG__/image/icon/img7.png" />

                    <p>点击右上角，选择 【分享到朋友圈】 即可报名成功获取抽奖码。</p>
                    <div class="add_botom4">
                            <a href="Submission_failed.html"><img src="__IMG__/image/img3.jpg" /></a>
                        </div>
                    <span>朋友通过该分享路径也可报名</span>
                    <span>参加本活动</span>
                    <img src="__IMG__/image/icon/img3.png" />
                </div>
            </div>

            <div class="add_float2 hide">
                <div class="add_float1_bg1"></div>
                <div class="add_top pa">
                    <img src="__IMG__/image/icon/img10.png" />

                        <p>点击右上角，选择【发送给朋友】邀请好友，好友长按文章顶部的【二维码】报名成功并获取抽奖码，您即可额外获【一个抽奖码】数量没有上限！</p>
    
                        <div class="add_botom4">
                            <a href="Submission_failed.html"><img src="__IMG__/image/img4.jpg" /></a>
                        </div>
                    
                    <span>发送给朋友或者发送到 好友群</span>
                    <img src="__IMG__/image/icon/img3.png" />
                </div>
            </div>

            

        </div>
    </div>
    <div class="sign_pop hide">
        <div class="sign_mask"></div>
        <div class="sign_content">
            <p>登录</p>
            <span>请输入用户名和密码</span>
            <input type="text" class="sign_text phone" placeholder="输入用户名" name="usernmae" value="" readonly/>
            <input type="password" class="sign_text" placeholder="输入密码"  name="password" value="" />
            <div class="sign_input">
                <input type="button" class="cancellogin" value="取消" />
                <input type="button" class="sign_btn" value="登录" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".main_3 img").height(($(document).height()) + 40);
            $(".add_float1").height($(window).height());
        })
    </script>

<script type="text/javascript">
    $(function () {
     
        var from = '{$data['from']}';
        if(from == 'waitreward'){
          $(".add_float2").show();
          $(".add_float2").css("height","100%");
            $("body").css({
              "position": "fixed",
              "top": "0",
              "left": "0"
            });
        }

        $(".save").click(function(){
            var phone = $("#phone").val();
            var nickname = $("#nickname").val();
            var uid = "{$user.id}";
            if (uid == '') {
                $.alert("请先清除微信缓存；方法：手机后台关闭微信应用，再重新打开微信。");
                return false;
            }
            if (phone == '') {
                $.alert("请填写手机号码");
                return false;
            }
            if (nickname == '') {
                $.alert("请填写联系人");
                return false;
            }
            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/Member/ajax_setphone')}",
                data: {'phone':phone,'nickname':nickname,'uid':uid},
                dataType: "json",
                success: function(data){
                    if(data.code==1){
                        $.hideLoading();
                        $(".add_float1").show();
                        $("body").css({
                            "position": "fixed",
                            "top": "0",
                            "left": "0"
                        });
                    }else if(data.code==-1){
                      $.hideLoading();
                      $.alert(data.msg,function(){
                        $(".phone").val(phone);
                        $(".sign_pop").show();
                      })
                      
                    }else{
                        $.hideLoading();
                        $.alert(data.msg);
                        return false;
                    }

                }
            });

        })

        $(".sign_btn").click(function(){
            var phone = $(".phone").val();
            var password = $("input[name='password']").val();
            
            if (password == '') {
                $.alert("请输入登录密码");
                return false;
            }
            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/Member/ajax_login')}",
                data: {'phone':phone,'password':password},
                dataType: "json",
                success: function(data){
                    if(data.code==1){
                        $.hideLoading();
                        $(".sign_pop").hide();
                        window.location.reload();
                    }else{
                        $.hideLoading();
                        $.alert(data.msg);
                        return false;
                    }

                }
            });

        })


            $(".sign_mask,.cancellogin").click(function () {
                $(".sign_pop").hide();
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
      title: '{$share.title}',
      desc: '{$share.content}',
      link: '{$share.link}',
      imgUrl: '{$share.image}',
      trigger: function (res) {

      },
      success: function (res) {
          alert('已分享');
          //$.showLoading("正在生成抽奖码...");
        //ajax_share('{$share.id}','ShareAppMessage','success');
      },
      cancel: function (res) {
        alert('已取消');
        //ajax_share('{$share.id}','ShareAppMessage','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        //ajax_share('{$share.id}','ShareAppMessage','error');
      }
    });


  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareTimeline({
      title: '{$share.title}',
      desc: '{$share.content}',
      link: '{$share.link}',
      imgUrl: '{$share.image}',
      trigger: function (res) {
        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
      },
      success: function (res) {
         // alert('已分享');
          $.showLoading("正在生成抽奖码...");
        ajax_share('{$share.id}','ShareTimeline','success');
      },
      cancel: function (res) {
        alert('已取消');
        // ajax_share('{$share.id}','ShareTimeline','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        // ajax_share('{$share.id}','ShareTimeline','error');
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
          //$.showLoading("正在生成抽奖码...");
        //ajax_share('{$share.id}','ShareQQ','success');
      },
      cancel: function (res) {
        alert('已取消');
        //ajax_share('{$share.id}','ShareQQ','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
       // ajax_share('{$share.id}','ShareQQ','error');
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
          //$.showLoading("正在生成抽奖码...");
       // ajax_share('{$share.id}','ShareWeibo','success');
      },
      cancel: function (res) {
        alert('已取消');
        //ajax_share('{$share.id}','ShareWeibo','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        //ajax_share('{$share.id}','ShareWeibo','error');
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
         // $.showLoading("正在生成抽奖码...");
       // ajax_share('{$share.id}','ShareQZone','success');
      },
      cancel: function (res) {
        alert('已取消');
        //ajax_share('{$share.id}','ShareQZone','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        //ajax_share('{$share.id}','ShareQZone','error');
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
            // alert(JSON.stringify(data));
            if(sharestatus=='success'){
              $.hideLoading();

              if(data.subscribe == 1){
                if(data.ischoujiang == 1){
                  window.location.href="{:U('Wx/Member/endreward')}";
                }else{
                  window.location.href="{:U('Wx/Member/waitreward')}";
                }
              }else{
                $(".add_float1").hide();
                $(".add_float2").hide();
                $(".add_float3").css('display','block');
                $(".add_float3").height($(window).height());
                $("body").css({
                  "position": "fixed",
                  "top": "0",
                  "left": "0"
                });
                if(data.ischoujiang == 1){
                  alert("该活动已结束，此次分享不会获得抽奖码！");
                }
              }

              if(data.subscribe == 1 && data.ischoujiang != 1)
                window.location.href="{:U('Wx/Member/waitreward')}";
              else{
                $(".add_float1").hide();
                $(".add_float2").hide();
                $(".add_float3").css('display','block');
                $(".add_float3").height($(window).height());
                $("body").css({
                  "position": "fixed",
                  "top": "0",
                  "left": "0"
                });

              }

            }
        }
    });
}
</script>
</body>
</html>
