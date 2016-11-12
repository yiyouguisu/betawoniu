<include file="public:head" />
<script type="text/javascript">
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数
    function sendMessage() {
        var phone = $(".phone").val();
        if (phone == '') {
            alert("手机号码不能为空");
            $(".phone").focus();
            return false;
        } else {
            if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone)) {
                alert("手机号码格式不正确");
                $(".phone").focus();
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
<div class="register pr">
        <div class="Sign_inm2">
            <img src="__IMG__/img33.jpg" />
        </div>
        <div class="wrap">
            <div class="register1" style="height:392px !important;">
                <div class="Sign_in_img">
                    <img src="__IMG__/Icon/img17.png" />
                </div>
                <div class="Information_perfect_a">
                    <div class="Information_perfect_a_top">
                        <span>
                            个人信息完善
                        </span>
                    </div>
                    <div class="Information_perfect_a_bottom">
                        <input type="text" class="Information_perfect_a_text2 phone" placeholder="您的手机号码 :" />
                        <i id="btnSendCode" onclick="sendMessage()">发送验证码</i>
                        <input type="text" class="Information_perfect_a_text telverify" placeholder="输入验证码 :" />
                        <input type="password" class="Information_perfect_a_text password" placeholder="您的登录密码 :" />
                        <div class="Information_perfect_a_bottom2">
                            <span>选择性别 :</span>
                            <div class="hidden Information_perfect_a_bottom3">
                                <label class="fl label1" data-id="1">男</label>
                                <label class="fr" data-id="2">女</label>
                            </div>
                        </div>
                        <input type="button" value="登录" class="Information_perfect_a_sub save" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Information_perfect_a_bottom3 label").click(function () {
                $(this).addClass("label1").siblings().removeClass("label1");
            })
            $(".Sign_inm2").height($(window).height());
            $(".Sign_inm2").width($(window).width());

            $(".save").click(function(){
            	var sex=$(".Information_perfect_a_bottom3 label.label1").data('id');
            	var password=$(".password").val();
            	if(password==''){
            		alert("请输入您的登录密码");
            		return false;
            	}
                var phone=$(".phone").val();
                if(phone==''){
                    alert("请输入您的手机号码");
                    return false;
                }
                var telverify=$(".telverify").val();
                if(telverify==''){
                    alert("请输入验证码");
                    return false;
                }
            	var p={ "sex":sex,"password":password,"phone":phone,"telverify":telverify,'uid':"{$uid}"};
            	$.post("{:U('Home/Member/dobindphone')}",p,function(d){
                    d=eval("("+d+")");
                    if(d.code==200){
                        window.location.href="{:U('Home/Member/index')}";
                    }else{
                        alert(d.msg);
                    }
                });
            })
            
        })
    </script>
</body>
</html>