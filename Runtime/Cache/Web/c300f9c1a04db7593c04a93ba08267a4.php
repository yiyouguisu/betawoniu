<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
    <meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width,user-scalable=0,minimum-scale=1,maximum-scale=1"/>
    <meta name="x5-fullscreen" content="true" />
    <link href="favicon.ico" rel="SHORTCUT ICON">
    <title><?php echo ($site["sitetitle"]); ?></title>
    <link rel="stylesheet" href="/Public/Public/css/weui.css">
    <link rel="stylesheet" href="/Public/Public/css/jquery-weui.css">
    <link rel="stylesheet" href="/Public/Web/css/base.css">
    <link rel="stylesheet" href="/Public/Web/css/style.css?v=0.1">
    <link rel="stylesheet" href="/Public/Web/css/clndr.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery.range.css">
    <script src="/Public/Web/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Public/js/jquery-weui.js"></script>
    <script src="/Public/Web/js/Action.js"></script>
    <script src="/Public/Web/js/TouchSlide.1.1.js"></script>
    <script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script src="/Public/public/js/jquery.cookie.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Public/Web/js/iscroll.js"></script>
    <script src="/Public/Public/js/layer.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/Public/Public/css/layer.css">
    <link rel="stylesheet" href="/Public/Web/css/list.css">
    <script type="text/javascript">
     function is_weixin(){  
       var ua = navigator.userAgent.toLowerCase();  
       if(ua.match(/MicroMessenger/i)=="micromessenger") {  
         return true;  
       } else {  
         return false;  
       }  
     }  
     if(is_weixin()) {
       /*
       $.ajax({
        'async': true,
        'url': '<?php echo U("Member/checkLogin");?>',
        'dataType': '',
        '' 
       })
        */
     }
      (function($)
      {
          $.extend(
          {
              myTime:
              {
                  /**
                   *              * 当前时间戳
                   *                           * @return <int>        unix时间戳(秒)
                   *                                        */
                  CurTime: function()
                  {
                      return Date.parse(new Date()) / 1000;
                  },
                  /**              
                   *              * 日期 转换为 Unix时间戳
                   *                           * @param <string> 2014-01-01 20:20:20  日期格式
                   *                                        * @return <int>        unix时间戳(秒)
                   *                                                     */
                  DateToUnix: function(string)
                  {
                      var f = string.split(' ', 2);
                      var d = (f[0] ? f[0] : '').split('-',
                          3);
                      var t = (f[1] ? f[1] : '').split(':',
                          3);
                      return (new Date(
                          parseInt(d[0], 10) ||
                          null, (parseInt(d[1], 10) ||
                              1) - 1,
                          parseInt(d[2], 10) ||
                          null,
                          parseInt(t[0], 10) ||
                          null,
                          parseInt(t[1], 10) ||
                          null,
                          parseInt(t[2], 10) ||
                          null
                      )).getTime() / 1000;
                  },
                  /**              
                   *              * 时间戳转换日期
                   *                           * @param <int> unixTime    待时间戳(秒)
                   *                                        * @param <bool> isFull    返回完整时间(Y-m-d 或者 Y-m-d H:i:s)
                   *                                                     * @param <int>  timeZone   时区
                   *                                                                  */
                  UnixToDate: function(unixTime, isFull,
                      timeZone)
                  {
                      if (typeof(timeZone) == 'number')
                      {
                          unixTime = parseInt(unixTime) +
                              parseInt(timeZone) * 60 * 60;
                      }
                      var time = new Date(unixTime * 1000);
                      var ymdhis = "";
                      ymdhis += time.getUTCFullYear() + "-";
                      ymdhis += (time.getMonth() + 1) + "-";
                      ymdhis += time.getDate() < 10 ? 0 + time.getDate().toString() : time.getDate();
                      if (isFull === true)
                      {
                          ymdhis += " " + time.getUTCHours() +
                              ":";
                          ymdhis += time.getUTCMinutes() +
                              ":";
                          ymdhis += time.getUTCSeconds();
                      }
                      return ymdhis;
                  }
              }
          });
      })(jQuery);
    </script>
    <script>
        $(function(){
            $('img.pic').lazyload({
               effect: 'fadeIn'
            });
        })
    </script>
    <script>
      getLocation();
      function getLocation() {
        if (navigator.geolocation) {
          console.log('location start.');
          navigator.geolocation.getCurrentPosition(showPosition, errorPosition);
        } else {
          console.log('浏览器不支持定位！');
        }
      }
      function showPosition(position) {
        var data = { 'position': position.coords.longitude + ',' + position.coords.latitude };
        $.post("<?php echo U('Web/Index/cacheposition');?>", data, function (res) {
          if(typeof(getHotelDistance) == 'function') {
            var pos = JSON.parse(res);
            getHotelDistance(pos.lat, pos.lng);
          }
          if(typeof(baiduCallback) == 'function') {
            var pos = JSON.parse(res);
            baiduCallback(pos.lat, pos.lng); 
          }
        });
      }
      function errorPosition(err) {
        console.log(err);
        console.warn('ERROR(' + err.code + '): ' + err.message);
      }
    </script>
    <script type="text/javascript">
      function rawPost(url, data, success, err) {
        $.ajax({
          'url': url,
          'data': JSON.stringify(data),
          'dataType': 'json',
          'type': 'post',
          'success': success,
          'error': err
        });
      }
    </script>
    <script>
  if(is_weixin()) {
    //调用微信jssdk
    $.getScript('https://res.wx.qq.com/open/js/jweixin-1.1.0.js', function() {
      var signPackage = <?php echo ($signPackage); ?>;
      //配置参数
      wx.config({
        debug: false,
        appId: '<?php echo ($appid); ?>',
        timestamp: signPackage.timestamp,
        nonceStr: signPackage.nonceStr,
        signature: signPackage.signature,
        jsApiList: [
          'onMenuShareTimeline',
          'onMenuShareAppMessage'
        ] 
      });
      //配置成功回调
      wx.ready(function() {
        console.log('wx_jssdk_success'); 
        var sharePublic = {
          'title': '蜗牛壳',
          'link': signPackage.url,
          'desc': 'adasdasdasdasdasddwqe',
          'imgUrl': '',
          'success': function() {

          },
          'cancel': function() {
          
          }
        }, shareFriends = {
          'title': '蜗牛壳',
          'link': signPackage.url,
          'imgUrl': '',
          'desc': 'asascasqwdqwqweqrqwr',
          'type': 'link',
          'dataUrl': '',
          'success': function() {
             
          },
          'error': function() {
          
          }
        };

        //分享微信朋友圈
        wx.onMenuShareTimeline(sharePublic);

        //分享微信好友
        wx.onMenuShareAppMessage(shareFriends);

        //分享QQ好友
        wx.onMenuShareQQ(shareFriends);

        //分享腾讯微博
        wx.onMenuShareWeibo(sharePublic);

        //分享qq空间
        wx.onMenuShareQZone(sharePublic);
      });
      //配置失败回调
      wx.error(function() {
        console.log('auth failed');
      });
    });
  }
</script>

    <script>
      var inviteCode = '<?php echo ($inviteCode); ?>';
      window.onload = function() {
        if(inviteCode) {
          setTimeout("alert('请先注册，更多精彩！');window.location.href='<?php echo U('Member/reg');?>?invitecode=<?php echo ($inviteCode); ?>'", 5000);
        } 
      };
    </script>
</head>
<body style="min-height:100%">

<body class="back_blue">
    <div class="header center pr f18">登录
      <div class="head_go pa" onclick="history.go(-1)">
          <img src="/Public/Web/images/go.jpg"></div>
    </div>
    <div class="container">
        <div class="login_box">
            <div class="login_top">
                <div class="login_list">
                    <div class="login_a">
                        <input id='phone' type="text" class="login_text" placeholder="输入手机号码 :" value="<?php echo ($phone); ?>">
                    </div>
                </div>
                <div class="login_list">
                    <div class="login_a vertical">
                        <input id='pwd' type="password" class="login_text" placeholder="输入密码 :">
                        <input id='tpwd' type="text" class="login_text" placeholder="输入密码 :" style='display: none'>
                    </div>
                    <div class="login_pa vertical showpwd">
                        <img src="/Public/Web/images/ig.png"></div>
                </div>
            </div>
            <div class="login_mid">
                <div class="login_b f16">
                    <a id='login'>立即登录</a></div>
                <div class="login_c f16">
                    <a href="<?php echo U('Web/Member/reg');?>">快速注册</a>
                    <a href="<?php echo U('Web/Member/forget');?>" class="fr">忘记密码?</a>
                </div>
            </div>

            <div class="login_btm">
                <div class="login_d center pr">
                    <div class="login_d1 pr f14">第三方账号登录</div>
                    <div class="login_d2 pa"></div>
                </div>
                <div class="login_e" style="text-align:center">
                    <div class="login_e1" id="wx_login">
                        <a href="javascript:;">
                            <img src="/Public/Web/images/tb_1.jpg"></a></div>
                    <div class="login_e1 not_wx">
                        <a href="">
                            <img src="/Public/Web/images/tb_2.jpg"></a></div>
                    <div class="login_e1 not_wx">
                        <a href="">
                            <img src="/Public/Web/images/tb_3.jpg"></a></div>
                </div>
                <div style="text-align:center;color:#fff" class="ft12">非微信注册用户请使用手机号码登录</div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            var login = $('#login');
            login.click(function () {
                var name = $('#phone').val();
                var pwd = $('#pwd').val();
                if (name == '') {
                    alert("手机号码不能为空");
                    $("#phone").focus();
                    return false;
                } else if (!/^1[3|4|5|7|8][0-9]{9}$/.test(name)) {
                    alert("手机号码格式不正确");
                    $("#phone").focus();
                    return false;
                } else if (pwd == '') {
                    alert("密码不能为空");
                    $("input[name='password']").focus();
                    return false;
                } else {
                    var data = { 'username': name, 'password': pwd, 'openid': '<?php echo ($openid); ?>', 'unionid': '<?php echo ($unionid); ?>' }
                    $.post("<?php echo U('Web/Member/ajax_login');?>", data, function (res) {
                        if (res.code == 200) {
                            var referer = "<?php echo ($referer); ?>";
                            if(referer) {
                              window.location.href = referer;
                            } else {
                              window.location.href = "<?php echo U('Web/Index/index');?>";
                            }
                        }
                        else {
                            alert(res.msg);
                        }
                    });
                }
            });
            var flag = true;
            $('.showpwd').click(function () {
                var pwd = $('#pwd');
                var pwdtext = $('#pwd').val();
                var tpwd = $('#tpwd');
                var twdtext = $('#tpwd').val();
                if (pwd.css('display') == 'none') {
                    pwd.show();
                    tpwd.hide();
                    pwd.val(twdtext)
                }
                else {
                    pwd.hide();
                    tpwd.show();
                    tpwd.val(pwdtext);
                }
            })
        })
    </script>
    <script>
      if(is_weixin()) {
        $('.not_wx').hide();
        $('#wx_login').removeClass('login_e1').css({'width': '15%', 'margin': 'auto'});
        $('#wx_login').click(function(evt) {
          evt.preventDefault();
          window.location.href = "<?php echo U('Member/wxlogin');?>"; 
        });
      }
    </script>
</body>
</html>