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
<div class="header center pr f18">
      补充信息
</div>
<div class="container">
  <form action="<?php echo U('Member/information');?>" method="post" id="info" onsubmit="return checkForm();">
   <input type="hidden" name="openid" value="<?php echo ($userinfo['openid']); ?>">
   <input type="hidden" name="unionid" value="<?php echo ($userinfo['unionid']); ?>">
   <input type="hidden" name="head" value="<?php echo ($userinfo['headimgurl']); ?>">
   <div class="login_box">
     <div class="infor_top">
       <div class="infor_img vertical">
         <img src="<?php echo ($userinfo['headimgurl']); ?>" style="border:3px solid #fff;width:80px;height:80px;border-radius:50px;">
       </div>
       <div class="infor_a vertical">
          <div class="infor_a1 f20"><?php echo ($userinfo['nickname']); ?></div>
          <div class="infor_a2 f14" id="message">你好，首次登录请补全手机号码</div>
       </div>
     </div> 
     <div class="login_top">
           <div class="login_list">
             <div class="login_a">
                 <input type="text" class="login_text f14 required" placeholder="输入手机号码 :" name="phone" id="phone" data-tips="手机号">
             </div>
          </div>  
       <div id="supply" style="display:none">
        <div class="login_list">
              <div class="login_a vertical" style="width:65%">
                  <input type="text" class="login_text f14 required" placeholder="输入验证码 :" name="check_num" id="check_num" data-tips="验证码">
              </div>
              <div class="infor_right vertical">
                   <input type="button" class="infor_b f14" value="获取验证码" id="send_code">
              </div>
        </div>
        <div class="login_list">
              <div class="login_a">
                  <input type="text" class="login_text f14 required" placeholder="输入昵称 :" value="<?php echo ($userinfo['nickname']); ?>" name="nickname" data-tips="昵称">
              </div>
        </div> 
        <div class="login_list">
              <div class="login_a">
                  <input type="password" class="login_text f14 required" placeholder="设置密码 :" value="" name="password" data-tip="密码">
              </div>
        </div> 
        <div class="sex">
          <div class="sex_a f14">选择性别 :</div>
          <div class="sex_b">
            <a href="javascript:;" class="fl sex-btn" data-sex="1">男</a>
            <input type="hidden" class="required" name="sex" value="" data-tips="性别">
            <a href="javascript:;" class="fr sex-btn" data-sex="2">女</a>
          </div>  
        </div> 
        <br>
        <div class="login_b f16">
            <input type="button" value="确定" style="width:100%">
        </div>
        </div>
      </div>
      <br>
      <button class="f16" style="padding:10px;width:100%;border-radius:5px;background:#fff;color:#56c3cf;border:0" id="confirm_phone">确定</button>
    </div>            
  </form>
</div>
<script type="text/javascript">
  var sendBtn = $('#send_code');
  var count = 20;
  var countHandler;
  sendBtn.click(function(evt) {
    evt.preventDefault();
    var phone = $('#phone').val();
    if(!phone || phone.length != 11) {
      alert('请正确填写11位手机号！');
      return; 
    }
    sendBtn.attr('disabled', 'disabled');
    sendBtn.val('发送中...');
    $.ajax({
      'url': '<?php echo U("Api/Public/sendchecknum_phone");?>',
      'dataType': 'json',
      'data': JSON.stringify({ 'phone': phone }),
      'type': 'post',
      'contentType': 'text/xml',
      'processData': false,
      'success': function(data){
        if(data.code == 200) {
          countHandler = setInterval(counting, 1000); 
        } else {
          alert(data.msg);
          sendBtn.removeAttr('disabled');
          sendBtn.val('获取验证码'); 
        }
      },
      'error': function(err, data) {
        alert('网络出错，请检查您的网络！');
        sendBtn.removeAttr('disabled');
        sendBtn.val('获取验证码'); 
        console.log(err);  
      }
    });
  });
  function counting() {
    if(count > 0) {
      count --;
      sendBtn.val('重发（' + count + '）');
    } else {
      count = 20;
      clearInterval(countHandler);  
      sendBtn.removeAttr('disabled');
      sendBtn.val('获取验证码');
    }
  }
  $('#check_num').change(function() {
    var _this = $(this);
    $.ajax({
      'url': '<?php echo U("Api/Public/check_verify");?>',
      'data': JSON.stringify({
        phone: $('#phone').val(),
        num: _this.val() 
      }),
      'dataType': 'json',
      'contentType': 'text/xml',
      'processData': false,
      'type': 'post',
      'success': function(data) {
        if(data.code != 200)  {
          alert(data.msg);
          _this.val('');
          _this.focus();
        }
      },
      'error': function(err,data) {
        console.log(data); 
      }
    });
  });
  $('.sex-btn').click(function(evt) {
    evt.preventDefault();
    var _this = $(this);
    $('input[name=sex]').val(_this.data('sex'));
  });
  function checkForm() {
    var tips = '';
    $('.required').each(function(i, t) {
      var _me = $(t);
      if(!_me.val()) {
        var tip = _me.data('tips');
        tips += '请正确输入/选择' + tip + '\n';
      } 
    });
    if(tips) {
      alert(tips); 
      return false;
    } else {
      return true; 
    }
  }
  $('#confirm_phone').click(function(evt) {
    evt.preventDefault()
    var _this = $(this);
    var phone = $('#phone');
    var openid = $('input[name=openid]');
    if(!phone.val() || phone.val().length != 11) {
      alert('请输入有效11位手机号码');
      return;
    }
    $(this).attr('disabled', 'disabled');
    $('#message').html('请稍等...');
    $.ajax({
      'url': '<?php echo U("Api/Public/checkPhoneExist");?>',
      'data': JSON.stringify({
        'phone': phone.val()
      }),
      'dataType': 'json',
      'contentType': 'text/xml',
      'processData': false,
      'type': 'post',
      'success': function(data) {
        if(data.code == 200) {
          $('#message').html('您已注册蜗牛客，将跳转到登录页！');
          //window.url = '"https://' + window.location.hostname + '<?php echo U("member/login");?>?phone=' + $('#phone').val() + '&openid=<?php echo ($userinfo["openid"]); ?>&unionid=<?php echo ($userinfo["unionid"]); ?>}' + '"';
          window.url = "<?php echo U('Member/login');?>?phone" + phone.val() + '&openid=' + openid.val();
          setTimeout('window.location.href="' + window.url + '"', 2500);
        } else {
          $('#message').html('请继续补全信息');
          _this.hide();
          $('#supply').fadeIn('fast');
        }
      },
      'error': function(err, data) {
        console.log(err); 
      }
    });
  });
</script>
</body>
</html>