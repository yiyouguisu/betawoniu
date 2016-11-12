<include file="Public:head" />
<body class="back_blue">
    <div class="header center pr f18">登录
      <div class="head_go pa" onclick="history.go(-1)">
          <img src="__IMG__/go.jpg"></div>
    </div>
    <div class="container">
        <div class="login_box">
            <div class="login_top">
                <div class="login_list">
                    <div class="login_a">
                        <input id='phone' type="text" class="login_text" placeholder="输入手机号码 :" value="{$phone}">
                    </div>
                </div>
                <div class="login_list">
                    <div class="login_a vertical">
                        <input id='pwd' type="password" class="login_text" placeholder="输入密码 :">
                        <input id='tpwd' type="text" class="login_text" placeholder="输入密码 :" style='display: none'>
                    </div>
                    <div class="login_pa vertical showpwd">
                        <img src="__IMG__/ig.png"></div>
                </div>
            </div>
            <div class="login_mid">
                <div class="login_b f16">
                    <a id='login'>立即登录</a></div>
                <div class="login_c f16">
                    <a href="{:U('Web/Member/reg')}">快速注册</a>
                    <a href="{:U('Web/Member/forgot')}" class="fr">忘记密码?</a>
                </div>
            </div>

            <div class="login_btm">
                <div class="login_d center pr">
                    <div class="login_d1 pr f14">第三方账号登录</div>
                    <div class="login_d2 pa"></div>
                </div>
                <div class="login_e">
                    <div class="login_e1">
                        <a href="">
                            <img src="__IMG__/tb_1.jpg"></a></div>
                    <div class="login_e1">
                        <a href="">
                            <img src="__IMG__/tb_2.jpg"></a></div>
                    <div class="login_e1">
                        <a href="">
                            <img src="__IMG__/tb_3.jpg"></a></div>
                </div>
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
                    var data = { 'username': name, 'password': pwd, 'openid': '{$openid}', 'unionid': '{$unionid}' }
                    $.post("{:U('Web/Member/ajax_login')}", data, function (res) {
                        if (res.code == 200) {
                            window.location.href = "{:U('Web/Index/index')}";
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
</body>

</html>
