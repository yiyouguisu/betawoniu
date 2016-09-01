<include file="public:head" />
    <div class="Sign_inm pr">
        <div class="Sign_inm2">
            <img src="__IMG__/img33.jpg" />
        </div>
        <div class="wrap">
            <div class="Sign_inm1">
                <div class="Sign_in_img">
                    <img src="__IMG__/Icon/img17.png" />
                </div>
                <form action="{:U('Home/Member/login')}" method="post" onsubmit="return checkform();">
                <script type="text/javascript">
                    function checkform() {
                        var phone = $("input[name='phone']").val();
                        var password = $("input[name='password']").val();
                        if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone)) {
                            alert("手机号码格式不正确");
                            $("input[name='phone']").focus();
                            return false;
                        } else if (phone == '') {
                            alert("手机号不能为空");
                            $("input[name='phone']").focus();
                            return false;
                        } else if (password == '') {
                            alert("密码不能为空");
                            $("input[name='password']").focus();
                            return false;
                        } else {
                            return true;
                        }
                    }
                </script>
                <div class="Sign_in_bottom">
                    <input type="text" class="Sign_text" name="phone" placeholder="您的手机号码 :" />
                    <input type="password" class="Sign_text" name="password" placeholder="您的密码 :" />
                    <a href="{:U('Home/Member/forgot')}">忘记密码？</a>
                    <input class="Sign_btn" type="submit" value="登录" />
                    <div class="Sign_in_bottom_01">
                        <a href="">用合作网站账户直接登录</a>
                        <ul class=" Sign_in_bottom_ul">
                            <li class="">
                                <a id="qqlogin" onclick="toQzoneLogin();" href="javascript:;">
                                    <img src="__IMG__/Icon/share4.png" />
                                    <i>QQ</i>
                                </a>
                            </li>
                            <li class="">
                                <a id="weibologin" onclick="toSinaLogin();" href="javascript:;">
                                    <img src="__IMG__/Icon/share5.png" />
                                    <i>新浪微博</i>
                                </a>
                            </li>
                            <li class="">
                                <a id="weixinlogin" onclick="toWeixinLogin();" href="javascript:;">
                                    <img src="__IMG__/Icon/share6.png" />
                                    <i>微信</i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                </form>
                <a href="{:U('Home/Member/reg')}">还没有账户？立即注册</a>
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
    <script type="text/javascript">
            var childWindow;
            function toQzoneLogin()
            {   
                //window.location.href="/index.php/home/oauth/qq.html";
                childWindow = window.open("/index.php/home/oauth/qq.html","TencentLogin","left=450,top=200,width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
            } 
            function toSinaLogin()
            { 
                //window.location.href="/index.php/home/oauth/sina.html";
                childWindow = window.open("/index.php/home/oauth/sina.html","SinaLogin","left=400,top=150,width=600,height=400,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
            }
            function toWeixinLogin()
            { 
                childWindow = window.open("/index.php/home/oauth/weixin.html","WeixinLogin","left=450,top=150,width=600,height=500,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
                //window.location.href="/index.php/home/oauth/weixin.html";
            }  
            function closeChildWindow()
            {   
                childWindow.close();
            }
        </script>
</body>
</html>
