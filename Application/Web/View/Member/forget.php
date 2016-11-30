<include file="public:head" />
<body class="back_blue">
<div class="header center pr f18">
    忘记密码
    <div class="head_go pa">
      <a href="javascript:history.back()">
        <img src="__IMG__/go.jpg">
      </a>
    </div>
</div>
<div class="container">
    <div class="login_box">
        <div class="login_top">
            <div class="login_list">
                <div class="login_a">
                    <input type="text" class="login_text f14" placeholder="输入手机号码 :" id="phone">
                </div>
            </div>

            <div class="login_list">
                <div class="login_a vertical" style="width:65%">
                    <input type="text" class="login_text f14" placeholder="输入验证码 :" id="telverify">
                </div>
                <div class="infor_right vertical">
                    <input type="button" class="infor_b f14" value="获取验证码" id="verify">
                </div>
            </div>

            <div class="login_list">
                <div class="login_a">
                    <input type="password" id="password" class="login_text f14" placeholder="输入新密码 :">
                </div>
            </div>
        </div>
        <div class="login_b f14"><a href="javascript:;" id="get_back">找回</a>
        </div>
        <div class="login_c f14">
            <a href="login.html" class="fr">快速登录</a>
        </div>
    </div>
</div>
</body>
<script>
var count = 15;
var tHandler = undefined;
$('#verify').click(function(evt) {
  evt.preventDefault();
  var phone = $('#phone').val();
  if(!phone || phone.length != 11) {
    alert('请正确输入11位手机号！');
    return;
  }
  var _this = $(this);
  _this.attr('disabled', 'disabled');
  _this.html('请稍等...');
  rawPost("{:U('Api/Public/sendchecknum_phone')}", {
    'phone': phone
  }, function(data) {
    if(data.code == 200) {
      alert('发送成功！');
      tHandler = setInterval(timeCount, 1000);
    } else {
      alert(data.msg);
      _this.removeAttr('disabled');
      _this.html('获取验证码');
    }
  }, function(err, data) {
    _this.removeAttr('disabled');
    _this.html('获取验证码');
    console.log(err); 
  });
});

function timeCount() {
  if(count > 0) {
    count--; 
    $('#verify').val('重新获取（' + count + '）');
  } else {
    clearInterval(tHandler); 
    count = 15;
    $('#verify').html('获取验证码');
    $('#verify').removeAttr('disabled');
  }
}
$('#get_back').click(function(evt) {
  evt.preventDefault();
  var phone = $('#phone').val();
  var verify = $('#telverify').val();
  var password = $('#password').val();
  if(!phone || phone.length != 11) {
    alert('请正确填写11位手机号码！');
    return;
  } else if (!verify) {
    alert('请填写验证码！');
    return;
  } else if (!password) {
    alert('请填写密码！');
    return;
  }
  var _this = $(this);
  _this.attr('disabled', 'disabled');
  _this.html('请稍等...');
  rawPost('{:U("Api/Member/setpassword")}', {
    phone: phone,
    telverify: verify,
    new_password: password
  }, function(data) {
    if(data.code == 200) {
      alert('修改成功，请重新登录！');
      window.location.href = "{:U('Member/login')}";
    } else {
      alert(data.msg); 
      _this.removeAttr('disabled');
      _this.html('找回');
    }
  }, function(err, data) {
    console.log(err); 
    alert('网络错误，请检查您的网络！');
    _this.removeAttr('disabled');
    _this.html('找回');
  });
});
</script>
</html>
