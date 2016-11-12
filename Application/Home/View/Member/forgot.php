<include file="public:head" />
<script type="text/javascript">
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数
    function sendMessage() {
        var phone = $("#phone").val();
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
                $("#btnSendCode").text("重新发送(" + curCount + ")");
                InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
                $.ajax({
                    type: "GET", //用POST方式传输
                    dataType: "JSON", //数据格式:JSON
                    url: "{:U('Home/Public/sendchecknum')}", //目标地址
                    data: { "phone": phone },
                    success: function (status) {
                        // alert(status.phone);
                        console.log(status);
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
            $("#btnSendCode").text("重新发送");
        }
        else {
            curCount--;
            $("#btnSendCode").text("重新发送(" + curCount + ")");
        }
    }
    
</script>
<div class="Forget pr">
        <div class="Sign_inm2">
            <img src="__IMG__/img34.jpg" />
        </div>
        <div class="wrap">
            <div class="Forget_main1">
                <div class="Sign_in_img">
                    <img src="__IMG__/Icon/img17.png" />
                </div>
                <div class="Forget_main12">
                    <input class="Ftext" type="text" id="phone" name="phone" placeholder="您的手机号码 :" />
                    <input class="Ftext2" type="text" name="telverify" placeholder="短信验证码 :">
                    <a href="javascript:;" id="btnSendCode" onclick="sendMessage()">获取验证码 </a>
                    <input class="Ftext" type="text" id="password" name="password" placeholder="请输入新密码 :" />
                    <input class="Ftext" type="text" id="pwdconfirm" name="pwdconfirm" placeholder="请再次输入密码 :" />
                    <input class="Fsub save" type="button" value="找回密码" />
                </div>
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
            $(".save").click(function(){
                var phone = $("input[name='phone']").val();
                var telverify = $("input[name='telverify']").val();
                var password = $("input[name='password']").val();
                var pwdconfirm = $("input[name='pwdconfirm']").val();
                if (phone == '') {
                    alert("手机号码不能为空");
                    $("input[name='phone']").focus();
                    return false;
                } else if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone)) {
                    alert("手机号码格式不正确");
                    $("input[name='phone']").focus();
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
                    var p={};
                    p['phone']=phone;
                    p['telverify']=telverify;
                    p['password']=password;
                    $.post("{:U('Home/Member/doforgot')}",p,function(data){
                        data=eval("("+data+")");
                        if(data.code==200){
                            alert("重置密码成功，请重新登陆！")
                            window.location.href="{:U('Home/Member/login')}";
                        }else{
                            alert(data.msg)
                        }
                    })
                }


            })
        })
    </script>

</body>
</html>
