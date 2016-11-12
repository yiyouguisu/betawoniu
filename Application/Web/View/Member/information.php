<include file="Public:head" />
<body class="back_blue">
<div class="header center pr f18">
      补充信息
</div>
<div class="container">
  <form action="{:U('Member/information')}" method="post" id="info" onsubmit="return checkForm();">
   <input type="hidden" name="openid" value="{$userinfo['openid']}">
   <input type="hidden" name="unionid" value="{$userinfo['unionid']}">
   <input type="hidden" name="head" value="{$userinfo['headimgurl']}">
   <div class="login_box">
     <div class="infor_top">
       <div class="infor_img vertical">
         <img src="{$userinfo['headimgurl']}" style="border:3px solid #fff;width:80px;height:80px;border-radius:50px;">
       </div>
       <div class="infor_a vertical">
          <div class="infor_a1 f20">{$userinfo['nickname']}</div>
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
                  <input type="text" class="login_text f14 required" placeholder="输入昵称 :" value="{$userinfo['nickname']}" name="nickname" data-tips="昵称">
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
            <input type="button" value="确定">
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
      'url': '{:U("Api/Public/sendchecknum_phone")}',
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
      'url': '{:U("Api/Public/check_verify")}',
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
    if(!phone.val() || phone.val().length != 11) {
      alert('请输入有效11位手机号码');
      return;
    }
    $(this).attr('disabled', 'disabled');
    $('#message').html('请稍等...');
    $.ajax({
      'url': '{:U("Api/Public/checkPhoneExist")}',
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
          window.url = '"http://' + window.location.hostname + '{:U("member/login")}?phone=' + $('#phone').val() + '&openid={$userinfo["openid"]}&unionid={$userinfo["unionid"]}}' + '"';
          setTimeout('window.location.href=' + window.url, 2500);
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

