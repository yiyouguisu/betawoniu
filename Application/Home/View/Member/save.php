<include file="public:head" />
<include file="public:mheader" />
<script type="text/javascript">
    var InterValObj; //timer变量，控制时间
    var count = 60; //间隔函数，1秒执行
    var curCount;//当前剩余秒数
    function sendMessage(obj,btnobj) {
        var phone = $(obj).val();
        if (phone == '') {
            alert("手机号码不能为空");
            $(obj).focus();
            return false;
        } else {
            if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone)) {
                alert("手机号码格式不正确");
                $(obj).focus();
                return false;
            } else {
                curCount = count;
                
                if(btnobj=="#password_btnSendCode"){
                    $("#password_btnSendCode").prop("disabled", true);
                    $("#password_btnSendCode").val("重新发送(" + curCount + ")");
                    InterValObj = window.setInterval(SetRemainTime_password, 1000); //启动计时器，1秒执行一次
                }else if(btnobj=="#phone_btnSendCode"){
                    $("#phone_btnSendCode").prop("disabled", true);
                    $("#phone_btnSendCode").val("重新发送(" + curCount + ")");
                    InterValObj = window.setInterval(SetRemainTime_phone, 1000); //启动计时器，1秒执行一次
                }
                
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
    function SetRemainTime_password() {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#password_btnSendCode").removeProp("disabled");//启用按钮
            $("#password_btnSendCode").val("重新发送");
        }
        else {
            curCount--;
            $("#password_btnSendCode").val("重新发送(" + curCount + ")");
        }
    }
    //timer处理函数
    function SetRemainTime_phone() {
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#phone_btnSendCode").removeProp("disabled");//启用按钮
            $("#phone_btnSendCode").val("重新发送");
        }
        else {
            curCount--;
            $("#phone_btnSendCode").val("重新发送(" + curCount + ")");
        }
    }
    
</script>
<div class="wrap hidden">
        <div class="pd_main1">
            <include file="Member:change_menu" />
            <div class="fl pd_main3">
                <div class="pd_main10_top">
                    <span>账号安全</span>
                    <eq name="user['realname_status']" value="0">
                        <a href="{:U('Home/Member/realname')}">
                            <img src="__IMG__/Icon/img65.png" />实名认证
                        </a>
                    </eq>
                </div>
                <div class="pd_main13_botttom">
                    <div>
                        <span>密码 :</span>
                        <a href="#modifypassword">修改密码</a>
                    </div>
                    <div>
                        <span>绑定手机 :</span>
                        <i>{$user.phone|default="未绑定"}</i>
                        <notempty name="user['phone']">
                            <label><img src="__IMG__/Icon/img68.png" />已绑定</label>
                        </notempty>
                        <a href="#modifyphone">更改号码</a>
                    </div>
                </div>
                <div class="pd_main14_bottom" id="modifypassword">
                    <label>更改密码</label>
                    <p>我们将向该手机发送验证码，请在下方输入您看到的验证码</p>
                    <div>
                        <span>验证方式 :</span><input class="pd_main14_btn2" type="text" id="password_phone" value="{$user['phone']}" />
                        <input class="pd_main14_btn" type="button" id="password_btnSendCode" onclick="sendMessage('#password_phone','#password_btnSendCode')" value="获取验证码" />
                    </div>
                    <div>
                        <span>验证码 :</span><input class="pd_main14_btn2"  id="password_telverify" type="text" placeholder="输入验证码" />
                    </div>
                    <div>
                        <span>新密码 :</span><input class="pd_main14_btn2" type="password" id="newpassword" placeholder="输入新密码" />
                    </div>
                    <div>
                        <span>确认密码 :</span><input class="pd_main14_btn2" type="password" id="cofirmpassword" placeholder="输入确认密码" />
                    </div>
                    <input class="pd_main14_btn3" type="button" id="password_save" value="提交" />
                </div>
                <div class="pd_main14_bottom" id="modifyphone">
                    <label>更改号码</label>
                    <p>我们将向该手机发送验证码，请在下方输入您看到的验证码</p>
                    <div>
                        <span>验证方式 :</span><input class="pd_main14_btn2" type="text" id="phone_phone" value="{$user['phone']}" />
                        <input class="pd_main14_btn" type="button" id="phone_btnSendCode" onclick="sendMessage('#phone_phone','#phone_btnSendCode')" value="获取验证码" />
                    </div>
                    <div>
                        <span>验证码 :</span><input class="pd_main14_btn2"  id="phone_telverify" type="text" placeholder="输入验证码" />
                    </div>
                    <input class="pd_main14_btn3" type="button" id="phone_save" value="提交" />
                </div>
                <eq name="user['houseowner_status']" value="1">
                    <div class="personal_data3_a">
                        <div class="personal_data3_a2">
                            <span>支付宝账户修改</span>
                        </div>
                        <div class="personal_data3_a3">
                            <span>支付宝 : </span>
                            <input type="hidden" name="realname" value="{$user.realname}" />
                            <input type="text" name="alipayaccount" class="personal_data3_a3_text"  value="{$alipayaccount}" />
                            <input class="personal_data3_a3_sub alipaybtn" type="button" value="修改" />
                        </div>
                    </div>
                </volist>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".alipaybtn").click(function(){
            var alipayaccount=$("input[name='alipayaccount']").val();
            var realname=$("input[name='realname']").val();
            if(realname==''){
                alert("请先实名认证");
                return false;
            }
            if(alipayaccount==''){
                alert("支付宝账号不能为空！");
                $("input[name='alipayaccount']").focus();
                return false;
            }
            var url="{:U('Home/Member/ajax_set_alipayaccount')}";
            $.ajax({
                     type: "POST",
                     url: url,
                     data: {'alipayaccount':alipayaccount,'realname':realname},
                     dataType: "json",
                     success: function(data){
                        alert(data.msg)
                        if(data.code==200){
                           window.location.reload();
                        }
                     }
                })  

        })
        $("#password_save").click(function(){
            var phone=$("#password_phone").val();
            var telverify=$("#password_telverify").val();
            var newpassword=$("#newpassword").val();
            var cofirmpassword=$("#cofirmpassword").val();
            if(phone==''){
                alert("手机号码不能为空！");
                $("#password_phone").focus();
                return false;
            }
            if(telverify==''){
                alert("验证码不能为空！");
                $("#password_telverify").focus();
                return false;
            }
            if(newpassword==''){
                alert("新密码不能为空！");
                $("#newpassword").focus();
                return false;
            }
            if(cofirmpassword==''){
                alert("确认密码不能为空！");
                $("#cofirmpassword").focus();
                return false;
            }
            if(cofirmpassword!=newpassword){
                alert("两次密码不一样！");
                $("#cofirmpassword").focus();
                return false;
            }
            var url="{:U('Home/Member/dochangepassword')}";
            $.ajax({
                     type: "POST",
                     url: url,
                     data: {'phone':phone,'telverify':telverify,'new_password':newpassword},
                     dataType: "json",
                     success: function(data){
                        data=eval("("+data+")");
                        alert(data.msg)
                        if(data.code==200){
                           window.location.reload();
                        }
                     }
                })  

        })
        $("#phone_save").click(function(){
            var phone=$("#phone_phone").val();
            var telverify=$("#phone_telverify").val();
            if(phone==''){
                alert("手机号码不能为空！");
                $("#password_phone").focus();
                return false;
            }
            if(telverify==''){
                alert("验证码不能为空！");
                $("#password_telverify").focus();
                return false;
            }
            var url="{:U('Home/Member/dochangephone')}";
            $.ajax({
                     type: "POST",
                     url: url,
                     data: {'phone':phone,'telverify':telverify},
                     dataType: "json",
                     success: function(data){
                        data=eval("("+data+")");
                        alert(data.msg)
                        if(data.code==200){
                           window.location.reload();
                        }
                     }
                })  

        })
    })
</script>
<include file="public:foot" />