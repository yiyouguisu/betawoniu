<include file="public:head" />
<include file="public:mheader" />
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
                        <a href="{:U('Home/Member/change_password')}">修改密码</a>
                    </div>
                    <div>
                        <span>绑定手机 :</span>
                        <i>{$user.phone|default="未绑定"}</i>
                        <notempty name="user['phone']">
                            <label><img src="__IMG__/Icon/img68.png" />已绑定</label>
                            <a href="">更改号码</a>
                        </notempty>
                    </div>
                </div>
                <div class="pd_main14_bottom">
                    <label>更改号码</label>
                    <p>我们将向该手机发送验证码，请在下方输入您看到的验证码</p>
                    <div>
                        <span>验证方式 :</span><input class="pd_main14_btn2" type="text" placeholder="验证{:substrreplace($user['phone'])}" />
                        <input class="pd_main14_btn" type="button" value="获取验证码" />
                    </div>
                    <div>
                        <span>验证码 :</span><input class="pd_main14_btn2" type="text" placeholder="输入验证码" />
                    </div>
                    <input class="pd_main14_btn3" type="submit" value="提交" />
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
    })
</script>
<include file="public:foot" />