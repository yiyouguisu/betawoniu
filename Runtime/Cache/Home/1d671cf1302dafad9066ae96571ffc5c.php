<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
    <meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
    <meta name="format-detection" content="telephone=no" />
    <link href="/favicon.ico" rel="SHORTCUT ICON">
    <title><?php echo ($site["sitetitle"]); ?></title>
    <script type="text/javascript">
    //全局变量
    var GV = {
        DIMAUB: "",
        JS_ROOT: "/Public/Home/js/",
        TOKEN: "d8a7e4212dd72764fc54360bc619692c_0be21a07a2313806c7f61fc129e26832"
    };
    </script>
    <script src="/Public/Home/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Home/js/wind.js"></script>
    <link href="/Public/Home/css/style.css" rel="stylesheet" />
    <link href="/Public/Home/css/base.css" rel="stylesheet" />
    <script src="/Public/Home/js/work.js"></script>
    <script src="/Public/Home/js/jquery.SuperSlide.2.1.1.js"></script>
    <script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script src="/Public/public/js/jquery.cookie.js" type="text/javascript"></script>
    <meta property="qc:admins" content="306144657363611416636375" />
    <meta property="wb:webmaster" content="43e5a3e0be007a03" />
    <script>
        $(function(){
            $('img.pic').lazyload({
               effect: 'fadeIn'
            });
        })
    </script>
</head>
<body>

<div class="hmain_top">
    <script>
    $(function(){
        getchildren(0,true);
        initvals();
        $(".jgbox").delegate("select","change",function(){
            $(this).nextAll().remove();
            if($(this).val()!=null&&$(this).val()!=''){
                getchildren($(this).val(),true);
            }else{
                getval();
            }
            
        });
    })
    function getval()
    {
        var vals="";
        $(".jgbox select").each(function(){
            var val=$(this).val();
            if(val!=null&&val!="")
            {
                vals+=',';
                vals+=val;
            }
        });
        if(vals!="")
        {
            vals=vals.substr(1);        
            $("#arrparentid").val(vals);
        }else{
            $("#arrparentid").val('');
        }
    }
    function getchildren(a,b) {
        $.ajax({
            url: "<?php echo U('Home/Public/getareachildren');?>",
            async: false,
            data: { id: a },
            success: function (data) {
                data=eval("("+data+")");
                if (data != null && data.length > 0) {
                    var ahtml = "<select class=''>";
                    if(b)
                    {
                        ahtml += "<option value=''>--请选择--</option>";
                    }
                    for (var i = 0; i < data.length; i++) {
                        ahtml += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                    }
                    ahtml += "</select>";
                    $(".jgbox").append(ahtml);
                }
            }
        });
                    getval();
    }
    function initvals()
    {
        //var vals=$("#arrparentid").val();
        var vals = $.cookie('home_location');
        if(vals!=null&&vals!="")
        {
            var arr=new Array();
            arr=vals.split(",");
            for(var i=0;i<arr.length;i++)
            {
                if($.trim(arr[i]) !="")
                {
                    $(".jgbox select").last().val(arr[i]);
                    getchildren(arr[i],true);
                }
            }
        }
    }
</script>
    <div class="wrap">
        <div class="middle main_top1">
                <a href="/" ><img src="/Public/Home/images/logo.png" /></a>
                <div class="main_top2 pr">
                    <div class="main3_05 hidden">
                        <input type="hidden" name="arrparentid" id="arrparentid" value="<?php echo ($arrparentid); ?>">
                        <span class="main3_03span position"><?php echo ((isset($cityname) && ($cityname !== ""))?($cityname):"请选择"); ?></span>
                    </div>
                    <div class="pa main3_03span_float hide">
                        <div class="main3_03span_float_top1">
                            <div class="jgbox" style="display: inline-block;"></div>
                            <input class="main3_input location" type="button" value="定位" />
                        </div>
                        
                    </div>
                </div>
            </div>
        <div class="middle main_top3">
            <ul class="hidden main_top3_ul">
                <li <?php if(($controller_url) == "Home/Index"): ?>class="fl main_top3_chang2" <?php else: ?>class="fl"<?php endif; ?>>
                    <a href="/">首页</a>
                </li>
                <li class="fl">|</li>
                <li <?php if(($controller_url) == "Home/Note"): ?>class="fl main_top3_chang2" <?php else: ?>class="fl"<?php endif; ?>>
                    <a href="<?php echo U('Home/Note/index');?>">游记</a>
                </li>
                <li class="fl">|</li>
                <li <?php if(($controller_url) == "Home/Party"): ?>class="fl main_top3_chang2" <?php else: ?>class="fl"<?php endif; ?>>
                    <a href="<?php echo U('Home/Party/index');?>">活动</a>
                </li>
                <li class="fl">|</li>
                <li <?php if($controller_url == 'Home/Hostel' or $controller_url == 'Home/Room'): ?>class="fl main_top3_chang2" <?php else: ?>class="fl"<?php endif; ?>>
                    <a href="<?php echo U('Home/Hostel/index');?>">美宿</a>
                </li>
                <li class="fl">|</li>
                <li <?php if(($controller_url) == "Home/Trip"): ?>class="fl main_top3_chang2" <?php else: ?>class="fl"<?php endif; ?>>
                    <a href="<?php echo U('Home/Trip/index');?>">行程</a>
                </li>
                <li class="fl">|</li>
                <li <?php if(($controller_url) == "Home/Woniu"): ?>class="fl main_top3_chang2" <?php else: ?>class="fl"<?php endif; ?>>
                    <a href="<?php echo U('Home/Woniu/index');?>">蜗牛</a>
                </li>
                <li class="fl">|</li>
                <li <?php if(($current_url) == "Home/About/app"): ?>class="fl main_top3_chang2" <?php else: ?>class="fl"<?php endif; ?>>
                    <a href="<?php echo U('Home/About/app');?>">APP下载</a>
                </li>
            </ul>
        </div>
        <?php if(!empty($user)): ?><div class="middle hmain_top4 clearfix ">
                <div class="hmain_top4_01 fl pr">
                    <span>消息</span>
                    <img class="hide" src="/Public/Home/images/Icon/img45.png" />
                    <div class="hide pa hmain_top4_04">
                        <div class="hmain_top4_04_01">
                            <ul class="hmain_top4_04_01_ul"  style="box-shadow: 0 0 10px #999;">
                                <li>
                                    <a href="<?php echo U('Home/Woniu/chatdetail');?>">
                                        <img src="/Public/Home/images/Icon/img47.png" />
                                        <span class="f14 c666">私信  <em class="f12 waitletternum">(<?php echo ((isset($waitletternum) && ($waitletternum !== ""))?($waitletternum):"0"); ?>)</em></span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo U('Home/Woniu/message');?>">
                                        <img src="/Public/Home/images/Icon/img48.png" />
                                        <span class="f14 c666">我的消息  <em class="f12">(<?php echo ((isset($waitmessagenum) && ($waitmessagenum !== ""))?($waitmessagenum):"0"); ?>)</em></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="hmain_top4_02 fl pr">
                    <div class="hmain_top4_02_img">
                        <a href="<?php echo U('Home/Member/index');?>"><img src="<?php echo ((isset($user["head"]) && ($user["head"] !== ""))?($user["head"]):'/default_head.png'); ?>" width="36px" height="36px"/></a>
                        <div class="hmain_top4_02_img2 pa hide">
                            <ul class="hmain_top4_02_img2_ul">
                                <li>
                                    <a href="<?php echo U('Home/Note/add');?>">
                                        <img src="/Public/Home/images/Icon/img49.png" />
                                        <span>写游记</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo U('Home/Woniu/index');?>">
                                        <img src="/Public/Home/images/Icon/img50.png" />
                                        <span>我的好友</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo U('Home/Member/mycollect');?>">
                                        <img src="/Public/Home/images/Icon/img51.png" />
                                        <span>我的收藏</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo U('Home/Member/myorder_hostel');?>">
                                        <img src="/Public/Home/images/Icon/img52.png" />
                                        <span>我的订单</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo U('Home/Member/mycoupons');?>">
                                        <img src="/Public/Home/images/Icon/img53.png" />
                                        <span>我的优惠券</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo U('Home/Member/help');?>">
                                        <img src="/Public/Home/images/Icon/img54.png" />
                                        <span>帮助中心</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo U('Home/Member/change_info');?>">
                                        <img src="/Public/Home/images/Icon/img55.png" />
                                        <span>设置</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo U('Home/Member/loginout');?>">
                                        <img src="/Public/Home/images/Icon/img56.png" />
                                        <span>退出</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="middle main_top4">
                <div class="main_top4_01 middle">
                    <a id="weibologin" onclick="toSinaLogin();" href="javascript:;">
                        <img src="/Public/Home/images/Icon/share1.png" />
                    </a>
                    <a id="qqlogin" onclick="toQzoneLogin();" href="javascript:;">
                        <img src="/Public/Home/images/Icon/share2.png" />
                    </a>
                    <a id="weixinlogin" onclick="toWeixinLogin();" href="javascript:;">
                        <img src="/Public/Home/images/Icon/share3.png" />
                    </a>
                </div>
                <div class="main_top4_02 middle">
                    <ul class="main_top4_02_ul">
                        <li class="fl">
                            <a href="<?php echo U('Home/Member/login');?>">登录</a>
                        </li>
                        <li class="fl">|</li>
                        <li class="fl">
                            <a href="<?php echo U('Home/Member/reg');?>">注册</a>
                        </li>
                    </ul>
                </div>
            </div><?php endif; ?>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".main3_03span").click(function () {
                $(this).addClass("main3_03span2").parent().css({ "background": "#fff" });
                $(this).parent().siblings().show();
            })
            $(".main3_input").click(function () {
                $(".main3_03span_float").hide();
                $(".main3_03span").removeClass("main3_03span2").parent().css({ "background": "#21a7bb" });
                var location=$("#arrparentid").val();
                $.cookie('home_location', location, {path:'/'});
                var p={};
                p['location']=location;
                $.post("<?php echo U('Home/Public/ajax_getcity');?>",p,function(d){
                    if(d.code=200){
                        window.location.reload();
                       $(".position").text(d.cityname); 
                    }else{
                        alert("定位失败，请重试！");
                    }
                })

            })
            $(".main3_03span").click(function () {
                $(this).next().slideToggle();
            })
            $(".main3_03bul li").click(function () {
                $(this).parents(".main_top2").find("span").text($(this).text());
                $(this).parents(".main3_03bul").hide().attr("data-id", $(this).attr("data-id"));
            })
            $(".main3_03span_float_top2_ul li").click(function () {
                $(this).addClass("main3_chang").siblings().removeClass("main3_chang");
            })
        $(".hmain_top4_01").hover(function () {
            $(this).find(".hmain_top4_04").stop(true, true).fadeIn()
        }, function () {
            $(this).find(".hmain_top4_04").stop(true, true).fadeOut()
        })
        $(".hmain_top4_02_img").hover(function () {
            $(this).find(".hmain_top4_02_img2").stop(true, true).fadeIn();
        }, function () {
            $(this).find(".hmain_top4_02_img2").stop(true, true).fadeOut();
        })
        $(window).height();
        $(".main_top3_ul li").hover(function () {
            $(this).addClass("main_top3_chang");
        }, function () {
            $(this).removeClass("main_top3_chang");
        })
        $(".main_bottom1_t span").click(function () {
            $(this).addClass("main_bottom1_tbg").siblings().removeClass("main_bottom1_tbg");
        })
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
                    url: "<?php echo U('Home/Public/sendchecknum');?>", //目标地址
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
            <div class="fl pd_main2">
    <ul class="pd_main2_ul">
        <?php if($user['houseowner_status'] == 1): ?><li <?php if(($current_url) == "Home/Member/change_info"): ?>class="pd_main2_li pd_b" <?php else: ?>class="pd_b"<?php endif; ?>>
                <a href="<?php echo U('Home/Member/change_info');?>">
                    <span>房东信息</span>
                </a>
            </li>
            <?php else: ?>
            <li <?php if(($current_url) == "Home/Member/change_info"): ?>class="pd_main2_li pd_b" <?php else: ?>class="pd_b"<?php endif; ?>>
                <a href="<?php echo U('Home/Member/change_info');?>">
                    <span>个人信息</span>
                </a>
            </li><?php endif; ?>
        
        <li <?php if(($current_url) == "Home/Member/change_head"): ?>class="pd_main2_li pd_b2" <?php else: ?>class="pd_b2"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/change_head');?>">
                <span>我的头像</span>
            </a>
        </li>
        <li <?php if(($current_url) == "Home/Member/change_background"): ?>class="pd_main2_li7 pd_b7" <?php else: ?>class="pd_b7"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/change_background');?>">
                <span>上传背景图片</span>
            </a>
        </li>
        <?php if($user['houseowner_status'] == 1): ?><li <?php if(($current_url) == "Home/Member/mywallet"): ?>class="pd_main2_li pd_b3" <?php else: ?>class="pd_b3"<?php endif; ?>>
                <a href="<?php echo U('Home/Member/mywallet');?>">
                    <span>我的钱包</span>
                </a>
            </li><?php endif; ?>
        <li <?php if(($current_url) == "Home/Member/save"): ?>class="pd_main2_li pd_b4" <?php else: ?>class="pd_b4"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/save');?>">
                <span>账号安全</span>
            </a>
        </li>
        <li <?php if(($current_url) == "Home/Member/linkman"): ?>class="pd_main2_li pd_b5" <?php else: ?>class="pd_b5"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/linkman');?>">
                <span>常用联系人</span>
            </a>
        </li>
        <!-- <li <?php if(($current_url) == "Home/Member/help"): ?>class="pd_main2_li pd_b6" <?php else: ?>class="pd_b6"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/help');?>">
                <span>帮助手册</span>
            </a>
        </li> -->
    </ul>
</div>
            <div class="fl pd_main3">
                <div class="pd_main10_top">
                    <span>账号安全</span>
                    <?php if(($user['realname_status']) == "0"): ?><a href="<?php echo U('Home/Member/realname');?>">
                            <img src="/Public/Home/images/Icon/img65.png" />实名认证
                        </a><?php endif; ?>
                </div>
                <div class="pd_main13_botttom">
                    <div>
                        <span>密码 :</span>
                        <a href="#modifypassword">修改密码</a>
                    </div>
                    <div>
                        <span>绑定手机 :</span>
                        <i><?php echo ((isset($user["phone"]) && ($user["phone"] !== ""))?($user["phone"]):"未绑定"); ?></i>
                        <?php if(!empty($user['phone'])): ?><label><img src="/Public/Home/images/Icon/img68.png" />已绑定</label><?php endif; ?>
                        <a href="#modifyphone">更改号码</a>
                    </div>
                </div>
                <div class="pd_main14_bottom" id="modifypassword">
                    <label>更改密码</label>
                    <p>我们将向该手机发送验证码，请在下方输入您看到的验证码</p>
                    <div>
                        <span>验证方式 :</span><input class="pd_main14_btn2" type="text" id="password_phone" value="<?php echo ($user['phone']); ?>" />
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
                        <span>验证方式 :</span><input class="pd_main14_btn2" type="text" id="phone_phone" value="<?php echo ($user['phone']); ?>" />
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
                            <input type="hidden" name="realname" value="<?php echo ($user["realname"]); ?>" />
                            <input type="text" name="alipayaccount" class="personal_data3_a3_text"  value="<?php echo ($alipayaccount); ?>" />
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
            var url="<?php echo U('Home/Member/ajax_set_alipayaccount');?>";
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
            var url="<?php echo U('Home/Member/dochangepassword');?>";
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
            var url="<?php echo U('Home/Member/dochangephone');?>";
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
<div class="foot">
    <div class="wrap">
        <div class="foot1 hidden">
            <ul class="hidden foot1_ul">
                <li class="fl foot1_li1">
                    <p>联系我们</p>
                    <i>客服电话： </i>
                    <label><?php echo ($site["sitetel"]); ?></label>
                    <span>Email：<?php echo ($site["siteemail"]); ?></span>
                    <i>合作媒体： </i>
                        <div class="hidden">
                            <a href="https://mp.toutiao.com/">
                                <img src="/Public/Home/images/Icon/img129.png" />
                            </a>
                            <a href="http://mp.yidianzixun.com/#Home">
                                <img src="/Public/Home/images/Icon/img130.png" />
                            </a>
                            <a href="http://mp.sohu.com/main/home/index.action">
                                <img src="/Public/Home/images/Icon/img131.png" />
                            </a>
                            <a href="http://weibo.com/u/5995342055/home?wvr=5">
                                <img src="/Public/Home/images/Icon/img132.png" />
                            </a>
                        </div>
                    <!-- <div class="hidden">
                        <a href="">
                            <img src="/Public/Home/images/Icon/share3.png" />
                        </a> 
                        <a href="<?php echo ($site["siteweibo"]); ?>">
                            <img src="/Public/Home/images/Icon/share1.png" />
                        </a>
                    </div>-->
                </li>
                <li class="fl foot1_li2">
                    <p>公司信息</p>
                    <a href="<?php echo U('Home/About/index');?>">关于我们</a>
                    <a href="<?php echo U('Home/About/feedback');?>">投诉建议</a>
                    <a href="<?php echo U('Home/About/contact');?>">联系我们</a>
                </li>
                <li class="fl foot1_li2">
                    <p>帮助中心</p>
                    <a href="<?php echo U('Home/About/question');?>">常见问题</a>
                    <a href="<?php echo U('Home/About/privacy');?>">隐私政策</a>
                    <a href="<?php echo U('Home/About/service');?>">服务条款</a>
                    <a href="<?php echo U('Home/Member/index');?>">个人中心</a>
                </li>
                <li class="fl foot1_li2">
                    <p>产品线</p>
                    <a href="<?php echo U('Home/Note/index');?>">游记攻略</a>
                    <a href="<?php echo U('Home/Hostel/index');?>">精品美宿</a>
                    <a href="<?php echo U('Home/Party/index');?>">精品活动</a>
                    <a href="<?php echo U('Home/Trip/index');?>">制定行程</a>
                </li>
                <li class="fl foot1_li3">
                    <p>APP下载</p>
                    <img src="/Public/Home/images/qrcode.jpg" style="width:105px;height:105px" />
                    <div class="foot1_li3_01">
                        <img src="/Public/Home/images/logo2.png"  />
                        <i>snailinns</i>
                        <a href="<?php echo U('Home/About/app');?>" class="foot_a">
                            <img src="/Public/Home/images/Icon/img12.png" />
                            IOS
                        </a>
                        <a href="<?php echo U('Home/About/app');?>">
                            <img src="/Public/Home/images/Icon/img13.png" />
                            安卓
                        </a>
                    </div>

                </li>
            </ul>

            <div class="foot2">
                <p>
                  <?php if(is_array($link)): $i = 0; $__LIST__ = $link;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; echo ($vo["title"]); ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
                </p>
                <div>
                  <?php echo ($site["sitecopyright"]); echo ($site["siteicp"]); ?>
                  <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1260209912'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1260209912%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="http://cdn.ronghub.com/RongIMLib-2.1.3.min.js"></script>

    <script>
    RongIMClient.init("cpj2xarljz3ln");
    var token = "<?php echo ($user["rongyun_token"]); ?>";
    RongIMClient.connect(token, {
        onSuccess: function(userId) {
          console.log("Login successfully." + userId);
        },
        onTokenIncorrect: function() {
          console.log('token无效');
        },
        onError:function(errorCode){
              var info = '';
              switch (errorCode) {
                case RongIMLib.ErrorCode.TIMEOUT:
                  info = '超时';
                  break;
                case RongIMLib.ErrorCode.UNKNOWN_ERROR:
                  info = '未知错误';
                  break;
                case RongIMLib.ErrorCode.UNACCEPTABLE_PaROTOCOL_VERSION:
                  info = '不可接受的协议版本';
                  break;
                case RongIMLib.ErrorCode.IDENTIFIER_REJECTED:
                  info = 'appkey不正确';
                  break;
                case RongIMLib.ErrorCode.SERVER_UNAVAILABLE:
                  info = '服务器不可用';
                  break;
              }
              console.log(errorCode);
            }
      });
      // 设置连接监听状态 （ status 标识当前连接状态）
       // 连接状态监听器
       RongIMClient.setConnectionStatusListener({
          onChanged: function (status) {
              switch (status) {
                  //链接成功
                  case RongIMLib.ConnectionStatus.CONNECTED:
                      console.log('链接成功');
                      
                      RongIMClient.getInstance().getConversationList({
                        onSuccess: function(list) {
                            console.log(list);
                            var uids;
                            $.each(list, function(index, val) {
                                if (index==0) {
                                    uids=val['targetId']
                                }else{
                                    uids+=','+val['targetId'];
                                }
                            });
                            console.log(uids);
                            // 获取好友列表的用户数据
                            $.post("<?php echo U('Home/Woniu/get_user_info');?>", {'uids': uids}, function(data) {
                               console.log(data);
                                // 获取未读消息的总数
                                RongIMClient.getInstance().getTotalUnreadCount({
                                    onSuccess: function(count) {
                                        if (count!=0) {
                                            $('.waitletternum').text("("+count+")");
                                        }
                                    },
                                    onError: function(error) {
                                    }
                                });
                            },'json');
                        },
                        onError: function(error) {
                            console.log('获取会话列表失败')
                        }
                      },null);
                        // rongSendMessage("89","asdfadsfasdf");
                        // rongSendMessage("84","asdf ewrqeasfasgad");
                      break;
                  //正在链接
                  case RongIMLib.ConnectionStatus.CONNECTING:
                      console.log('正在链接');
                      break;
                  //重新链接
                  case RongIMLib.ConnectionStatus.DISCONNECTED:
                      console.log('断开连接');
                      break;
                  //其他设备登录
                  case RongIMLib.ConnectionStatus.KICKED_OFFLINE_BY_OTHER_CLIENT:
                      console.log('其他设备登录');
                      break;
                    //网络不可用
                  case RongIMLib.ConnectionStatus.NETWORK_UNAVAILABLE:
                    console.log('网络不可用');
                    break;
                  }
          }});

       // 消息监听器
       RongIMClient.setOnReceiveMessageListener({
          // 接收到的消息
          onReceived: function (message) {
              // 判断消息类型
              switch(message.messageType){
                  case RongIMClient.MessageType.TextMessage:
                         // 发送的消息内容将会被打印
                      console.log(message.content.content);
                      break;
                  case RongIMClient.MessageType.VoiceMessage:
                      // 对声音进行预加载                
                      // message.content.content 格式为 AMR 格式的 base64 码
                      RongIMLib.RongIMVoice.preLoaded(message.content.content);
                      break;
                  case RongIMClient.MessageType.ImageMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.DiscussionNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.LocationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.RichContentMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.DiscussionNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.InformationNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.ContactNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.ProfileNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.CommandNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.CommandMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.UnknownMessage:
                      // do something...
                      break;
                  default:
                      // 自定义消息
                      // do something...
                      break;
                console.log(message.content.content);
              }
          }
      });
    </script>
</body>
</html>