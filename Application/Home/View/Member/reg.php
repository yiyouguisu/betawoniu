<include file="public:head" />
<div class="register pr">
        <div class="Sign_inm2">
            <img src="__IMG__/img35.jpg" />
        </div>
        <div class="wrap">
            <div class="register1">
                <div class="Sign_in_img">
                    <img src="__IMG__/Icon/img17.png" />
                </div>
                <form action="{:U('Home/Member/reg')}" method="post" onsubmit="return checkform();">
                <script type="text/javascript">
                    function checkform() {
                        var phone = $("input[name='phone']").val();
                        var verify = $("input[name='verify']").val();
                        var password = $("input[name='password']").val();
                        var pwdconfirm = $("input[name='pwdconfirm']").val();
                        if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone)) {
                            alert("手机号码格式不正确");
                            $("input[name='phone']").focus();
                            return false;
                        } else if (verify == '') {
                            alert("验证码不能为空");
                            $("input[name='verify']").focus();
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
                            return true;
                        }
                    }
                </script>
                <script>
                    $(function () {
                        var verifyimg = $(".verifyimg").attr("src");
                        $(".reloadverify").click(function () {
                            if (verifyimg.indexOf('?') > 0) {
                                $(".verifyimg").attr("src", verifyimg + '&random=' + Math.random());
                            } else {
                                $(".verifyimg").attr("src", verifyimg.replace(/\?.*$/, '') + '?' + Math.random());
                            }
                        });
                    });

                </script>
                <div class="register2">
                    <input type="text" class="register2_text" name="phone" placeholder="您的手机号码 :" />
                    <input type="text" class="register2_text2" name="verify" placeholder="输入验证码 :">
                    <span>
                        <img src="{:U('Home/Public/verify')}" width="100px" height="35px" style="    margin-top: 20px;" class="verifyimg reloadverify">
                    </span>
                    <input type="password" class="register2_text" name="password" placeholder="请输入密码 :" />
                    <input type="password" class="register2_text"  name="pwdconfirm" placeholder="请再次输入密码 :" />
                    <input class="register_btn" type="submit" value="注册" />
                    <p>
                        注册视为同意<a href="javascript:;" onclick="javascript:window.showModalDialog('{:U('Home/Member/pact')}','','dialogWidth=1024px;dialogHeight=768px,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top=10,left=20,resizable=no')">《蜗牛客用户使用协议》</a>
                    </p>
                </div>
                </form>
                <a href="{:U('Home/Member/login')}">我已有账户？立即登录</a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    $(function () {
        $(".Sign_in_bottom_ul li").last().css({
            "margin-right": "0"
        })
        $(".Sign_inm2").height($(window).height());
        $(".Sign_inm2").width($(window).width());
    })
    </script>

</body>
</html>
