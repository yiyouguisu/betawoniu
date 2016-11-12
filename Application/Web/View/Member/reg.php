<include file="Public:head" />
<body class="back_blue">
    <div class="header center pr f18">注册
      <div class="head_go pa" onclick="history.go(-1)">
          <img src="__IMG__/go.jpg"></div>
    </div>
    <div class="container">
        <div class="login_box">
            <div class="login_top">
                <div class="login_list">
                    <div class="login_a">
                        <input id="phone" name="phone" type="text" class="login_text f14" placeholder="输入手机号码 :">
                    </div>
                </div>
                <div class="login_list">
                    <div class="login_a vertical" style="width: 65%">
                        <input id="telverify" name="telverify" type="text" class="login_text f14" placeholder="输入验证码 :">
                    </div>
                    <div class="infor_right vertical">
                        <input id="btnSendCode" type="button" class="infor_b f14" value="获取验证码" onclick="sendMessage()">
                    </div>
                </div>
                <div class="login_list">
                    <div class="login_a">
                        <input id="password" name="password" type="text" class="login_text f14" placeholder="输入密码 :">
                    </div>
                </div>
                <div class="login_list">
                    <div class="login_a">
                        <input id="pwdconfirm" name="pwdconfirm" type="text" class="login_text f14" placeholder="再次输入密码 :">
                    </div>
                </div>
                <div class="login_list">
                    <div class="login_a">
                        <input id="invite_code" name="invite_code" type="text" class="login_text f14" placeholder="请输入邀请码 :" readonly="true" value="{$invitecode}">
                    </div>
                </div>
            </div>
            <div class="login_b f16">
                <a id="regsubmit">立即注册</a></div>

            <div class="infor_btm f13">
                <a href="javascript:;">点击立即注册表示您已同意蜗牛壳APP使用协议</a></div>
        </div>
    </div>
    <script type="text/javascript">
        var InterValObj; //timer变量，控制时间
        var count = 60; //间隔函数，1秒执行
        var curCount;//当前剩余秒数
        function sendMessage() {
            var phone = $('#phone').val();
            if (phone == '') {
                alert("手机号码不能为空");
                $("#phone").focus();
                return false;
            } else {
                if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone)) {
                    alert("手机号码格式不正确");
                    $("#phone").focus();
                    return false;
                } else {
                    curCount = count;
                    $("#btnSendCode").attr("disabled", "true");
                    $("#btnSendCode").val("重新发送(" + curCount + ")");
                    InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                    $.ajax({
                        type: "GET", //用POST方式传输
                        dataType: "JSON", //数据格式:JSON
                        url: "{:U('Web/Public/sendchecknum')}", //目标地址
                        data: { "phone": phone },
                        success: function (data) {
                            console.log(data);
                        }
                    });

                }

            }

        }
        //timer处理函数
        function SetRemainTime() {
            if (curCount == 0) {
                window.clearInterval(InterValObj);//停止计时器
                $("#btnSendCode").removeAttr("disabled");//启用按钮
                $("#btnSendCode").val("重新发送");
            }
            else {
                curCount--;
                $("#btnSendCode").val("重新发送(" + curCount + ")");
            }
        }
        $(function () {
            var regsubmit = $('#regsubmit');
            regsubmit.click(function () {
                alert('aaaa');
                var phone = $('#phone').val();
                var telverify = $("input[name='telverify']").val();
                var password = $("input[name='password']").val();
                var pwdconfirm = $("input[name='pwdconfirm']").val();
                var invite_code = $("input[name='invite_code']").val();
                if (phone == '') {
                    alert("手机号码不能为空");
                    $("#phone").focus();
                    return false;
                } else if (phone.length != 11) {
                    alert("手机号码格式不正确");
                    $("#phone").focus();
                    return false;
                } else if (telverify == '') {
                    alert("验证码不能为空");
                    $("input[name='telverify']").focus();
                    return false;
                } else if (password == '') {
                    alert("密码不能为空");
                    $("input[name='password']").focus();
                    return false;
                } else if (pwdconfirm == '') {
                    alert("确认密码不能为空");
                    $("input[name='pwdconfirm']").focus();
                    return false;
                } else if (pwdconfirm != password) {
                    alert("两次密码不一样");
                    $("input[name='pwdconfirm']").focus();
                    return false;
                } else {
                    var data = { 'phone': phone, 'telverify': telverify, 'password': password, 'pwdconfirm': pwdconfirm, 'invite_code': invite_code }
                    $.post("{:U('Web/Member/ajax_reg')}", data, function (res) {
                        if (res.code == 200) {
                            alert('注册成功')
                            window.location.href = "{:U('Web/Member/regSuccess')}";
                        }
                        else {
                            alert(res.msg);
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
