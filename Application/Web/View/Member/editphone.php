<include file="Public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      修改手机号码
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container">
         <div class="hm">
             <div class="act_c">
               <div class="lu_b">
                         <input type="text" id='phone' class="lu_text" style="width:100%;" placeholder="输入新手机号码 :" >
               </div>
               
               <div class="hm_acc">
                    <div class="lu_b fl" style="width:62%;">
                         <input type="text" class="lu_text" style="width:100%;" id='code' placeholder="输入验证码 :">
                    </div>
                    <div class="hm_acc_a1 fr">
				      	   <input type="button" class="hm_btn f14" value="获取验证码" id='btnSendCode' onclick="sendMessage()">
				    </div>
               </div>
               
               <div class="set_c" style="margin:-1rem 0 0">
                     <div class="snail_d center trip_btn f16">
                              <a href="javascript:sub();" class="snail_cut ">修改</a>
                     </div>
                </div>
          </div>
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
                        alert(data.msg);
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

    function sub(){
    	var phone=$('#phone').val();
    	var code=$('#code').val();
    	var data={'phone':phone,'code':code};
    	console.log(data);
		$.ajax({
			type: "POST", //用POST方式传输
			dataType: "JSON", //数据格式:JSON
			url: "{:U('Web/Member/phone')}", //目标地址
			data: data,
			success: function (data) {
				if(data.code==200){
					alert(data.msg);
					window.location.href="{:U('Web/Member/myinfo')}";
				}
				else{
					alert(data.msg);
				}
			}
		});
    } 


</script>
</body>

</html>
