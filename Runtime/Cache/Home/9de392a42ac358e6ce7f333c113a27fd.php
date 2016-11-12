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

<link href="/Public/Home/css/jqtransform.css" rel="stylesheet" />
<script src="/Public/Home/js/jquery.jqtransform.js"></script>
<script language="javascript">
    $(function () {
        $('.jqtransform').jqTransform();
        var dateInput = $("input.J_date");
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker({
                    onHide:function(){
                        var birthday=$(".J_date").val();
                        if(birthday!=''){
                            
                        }
                        
                        
                    }
                });
                
            });
        }
        var province='<?php echo ($userinfo["province"]); ?>';
        var city='<?php echo ($userinfo["city"]); ?>';
        var province1='<?php echo ($userinfo["province1"]); ?>';
        var city1='<?php echo ($userinfo["city1"]); ?>';
        if(province!=''){
          load(province,'city');
        }
        if(city!=''){
          load(city,'town');
        }
        if(province1!=''){
          getaddress(province1,'city');
        }
        if(city1!=''){
          getaddress(city1,'town');
        }
    });
    function load(parentid,type){
      $.ajax({
         type: "POST",
         url: "<?php echo U('Home/Member/ajax_area');?>",
         data: {'parentid':parentid},
         dataType: "json",
         success: function(data){
                    if(type=='city'){
                      $('#city').html('<option value="">市/县</option>');
                      $('#town').html('<option value="">镇/区</option>');
                      $.each(data,function(no,items){
                        if(items.id=='<?php echo ($userinfo["city"]); ?>'){
                            $('#city').append('<option value="'+items.id+'"selected>'+items.name+'</option>');
                        }else{
                            $('#city').append('<option value="'+items.id+'">'+items.name+'</option>');
                        }
                      });
                      fix_select('select#city');
                    }else if(type=='town'){
                      $('#town').html('<option value="">镇/区</option>');
                      $.each(data,function(no,items){
                        if(items.id=='<?php echo ($userinfo["town"]); ?>'){
                            $('#town').append('<option value="'+items.id+'"selected>'+items.name+'</option>');
                        }else{
                            $('#town').append('<option value="'+items.id+'">'+items.name+'</option>');
                        }
                      });
                      fix_select('select#town');
                    }
                  }
      });
    }
    function getaddress(parentid,type){
      $.ajax({
         type: "POST",
         url: "<?php echo U('Home/Member/ajax_area');?>",
         data: {'parentid':parentid},
         dataType: "json",
         success: function(data){
                    if(type=='city'){
                      $('#city1').html('<option value="">市/县</option>');
                      $('#town1').html('<option value="">镇/区</option>');
                      $.each(data,function(no,items){
                        if(items.id=='<?php echo ($userinfo["city1"]); ?>'){
                            $('#city1').append('<option value="'+items.id+'"selected>'+items.name+'</option>');
                        }else{
                            $('#city1').append('<option value="'+items.id+'">'+items.name+'</option>');
                        }
                      });
                      fix_select('select#city1');
                    }else if(type=='town'){
                      $('#town1').html('<option value="">镇/区</option>');
                      $.each(data,function(no,items){
                        if(items.id=='<?php echo ($userinfo["town1"]); ?>'){
                            $('#town1').append('<option value="'+items.id+'"selected>'+items.name+'</option>');
                        }else{
                            $('#town1').append('<option value="'+items.id+'">'+items.name+'</option>');
                        }
                      });
                      fix_select('select#town1');
                    }
                  }
      });
    }
    function fix_select(selector) { 
        var i=$(selector).parent().find('div,ul').remove().css('zIndex'); 
        $(selector).unwrap().removeClass('jqTransformHidden').jqTransSelect(); 
        $(selector).parent().css('zIndex', i); 
    } 
    
</script>
<div class="hmain_top">
    <script>
    $(function(){
        getchildren(0,true);
        initvals();
        $(".jgbox").delegate("select","change",function(){
            $(this).nextAll().remove();
            getchildren($(this).val(),true);
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
                        <span class="main3_03span position"><?php echo ((isset($cityname) && ($cityname !== ""))?($cityname):"上海"); ?></span>
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
        <li <?php if(($current_url) == "Home/Member/help"): ?>class="pd_main2_li pd_b6" <?php else: ?>class="pd_b6"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/help');?>">
                <span>帮助手册</span>
            </a>
        </li>
    </ul>
</div>
        <div class="fl pd_main3">
            <div class="pd_main3_top hidden">
                <div class="middle">
                    <label class="f24 c333">个人信息</label>
                </div>
                <div class="middle pd_main3_top2">
                    <i class="c999 f12 middle">资料完善度</i>
                    <div class="pr pd_main3_top2_01 middle">
                        <div class="pa pd_main3_top2_02" style="width:<?php echo ($parsent); ?>%;"></div>
                        <label><?php echo ($parsent); ?>%</label>
                    </div>
                </div>
                <div class="tr middle pd_main3_top3 hidden">
                    <?php if(($user['realname_status']) == "0"): ?><a href="<?php echo U('Home/Member/realname');?>">
                            <img src="/Public/Home/images/Icon/img65.png" />实名认证
                        </a><?php endif; ?>
                </div>
            </div>
            <form class="jqtransform" id="form" action="<?php echo U('Home/Member/change_info');?>" method="post">
                <div class="pd_main3_bottom">
                    <label>名称 :</label>
                    <input type="text" name="nickname" value="<?php echo ($user["nickname"]); ?>" />
                </div>
                <div class="pd_main3_bottom">
                    <label>性别 :</label>
                    <div class="">
                        <input type="radio" name="sex" value="1" <?php if(($user['sex']) == "1"): ?>checked<?php endif; ?> /><i>男性</i>
                    </div>
                    <div>
                        <input type="radio" name="sex" value="2" <?php if(($user['sex']) == "2"): ?>checked<?php endif; ?>/><i>女性</i>
                    </div>
                    <div>
                        <input type="radio" name="sex" value="0" <?php if(($user['sex']) == "0"): ?>checked<?php endif; ?>/><i>保密</i>
                    </div>
                </div>
                <div class="pd_main3_bottom">
                    <label>出生日期 :</label>
                    <input type="text" name="birthday" class="J_date" value="<?php echo ($user["birthday"]); ?>" />
                </div>
                <div class="pd_main7_bottom">
                    <label>居住地：</label>
                    <select name="province" id="province" style="width:120px;" onchange="load(this.value,'city')">
                      <option value="">省/直辖市</option>
                      <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $userinfo['province']): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>          
                    <select name="city" id="city" style="width:80px;"  onchange="load(this.value,'town')">
                      <option value="">市/县</option>
                    </select>
                    <select name="town" style="width:80px;" id="town">
                      <option value="">镇/区</option>
                    </select>
                </div>
                <div class="pd_main7_bottom">
                    <label>故乡：</label>
                    <select name="province1" id="province1" style="width:120px;" onchange="getaddress(this.value,'city')">
                      <option value="">省/直辖市</option>
                      <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $userinfo['province1']): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>          
                    <select name="city1" id="city1" style="width:80px;"  onchange="getaddress(this.value,'town')">
                      <option value="">市/县</option>
                    </select>
                    <select name="town1" style="width:80px;" id="town1">
                      <option value="">镇/区</option>
                    </select>
                </div>
                <div class="pd_main7_bottom">
                    <label>学历：</label>
                    <select name="education">
                        <option value="">请选择学历</option>
                        <option <?php if('博士' == $userinfo['education']): ?>selected<?php endif; ?>>博士</option>
                        <option <?php if('硕士' == $userinfo['education']): ?>selected<?php endif; ?>>硕士</option>
                        <option <?php if('本科' == $userinfo['education']): ?>selected<?php endif; ?>>本科</option>
                        <option <?php if('专科' == $userinfo['education']): ?>selected<?php endif; ?>>专科</option>
                    </select>
                </div>
                <div class="pd_main3_bottom">
                    <label>学校：</label>
                    <input type="text" name="school" value="<?php echo ($user["school"]); ?>" />
                </div>
                <div class="pd_main7_bottom">
                    <label>属相：</label>
                    <select name="zodiac">
                        <option value="">请选择属相</option>
                        <option <?php if('子鼠' == $userinfo['zodiac']): ?>selected<?php endif; ?>>子鼠</option>
                        <option <?php if('丑牛' == $userinfo['zodiac']): ?>selected<?php endif; ?>>丑牛</option>
                        <option <?php if('寅虎' == $userinfo['zodiac']): ?>selected<?php endif; ?>>寅虎</option>
                        <option <?php if('卯兔' == $userinfo['zodiac']): ?>selected<?php endif; ?>>卯兔</option>
                        <option <?php if('辰龙' == $userinfo['zodiac']): ?>selected<?php endif; ?>>辰龙</option>
                        <option <?php if('巳蛇' == $userinfo['zodiac']): ?>selected<?php endif; ?>>巳蛇</option>
                        <option <?php if('午马' == $userinfo['zodiac']): ?>selected<?php endif; ?>>午马</option>
                        <option <?php if('未羊' == $userinfo['zodiac']): ?>selected<?php endif; ?>>未羊</option>
                        <option <?php if('申猴' == $userinfo['zodiac']): ?>selected<?php endif; ?>>申猴</option>
                        <option <?php if('酉鸡' == $userinfo['zodiac']): ?>selected<?php endif; ?>>酉鸡</option>
                        <option <?php if('戌狗' == $userinfo['zodiac']): ?>selected<?php endif; ?>>戌狗</option>
                        <option <?php if('亥猪' == $userinfo['zodiac']): ?>selected<?php endif; ?>>亥猪</option>
                    </select>
                </div>
                <div class="pd_main7_bottom">
                    <label>星座：</label>
                    <select name="constellation">
                        <option value="">请选择星座</option>
                        <option <?php if('水瓶座' == $userinfo['constellation']): ?>selected<?php endif; ?>>水瓶座</option>
                        <option <?php if('双鱼座' == $userinfo['constellation']): ?>selected<?php endif; ?>>双鱼座</option>
                        <option <?php if('白羊座' == $userinfo['constellation']): ?>selected<?php endif; ?>>白羊座</option>
                        <option <?php if('金牛座' == $userinfo['constellation']): ?>selected<?php endif; ?>>金牛座</option>
                        <option <?php if('双子座' == $userinfo['constellation']): ?>selected<?php endif; ?>>双子座</option>
                        <option <?php if('巨蟹座' == $userinfo['constellation']): ?>selected<?php endif; ?>>巨蟹座</option>
                        <option <?php if('狮子座' == $userinfo['constellation']): ?>selected<?php endif; ?>>狮子座</option>
                        <option <?php if('处女座' == $userinfo['constellation']): ?>selected<?php endif; ?>>处女座</option>
                        <option <?php if('天秤座' == $userinfo['constellation']): ?>selected<?php endif; ?>>天秤座</option>
                        <option <?php if('天蝎座' == $userinfo['constellation']): ?>selected<?php endif; ?>>天蝎座</option>
                        <option <?php if('射手座' == $userinfo['constellation']): ?>selected<?php endif; ?>>射手座</option>
                        <option <?php if('摩羯座' == $userinfo['constellation']): ?>selected<?php endif; ?>>摩羯座</option>
                    </select>
                </div>
                <div class="pd_main7_bottom">
                    <label>血型：</label>
                    <select name="bloodtype">
                        <option value="">请选择血型</option>
                        <option <?php if('A型' == $userinfo['bloodtype']): ?>selected<?php endif; ?>>A型</option>
                        <option <?php if('B型' == $userinfo['bloodtype']): ?>selected<?php endif; ?>>B型</option>
                        <option <?php if('AB型' == $userinfo['bloodtype']): ?>selected<?php endif; ?>>AB型</option>
                        <option <?php if('O型' == $userinfo['bloodtype']): ?>selected<?php endif; ?>>O型</option>
                    </select>
                </div>
                <div class="pd_main3_bottom">
                    <label>个性签名：</label>
                    <input type="text" name="info" value="<?php echo ($user["info"]); ?>" />
                </div>
            
                <div class="pd_main4_bottom">
                    <div class="pd_main4_bottom2" style="overflow: hidden;">
                        <span>个人标签：</span>
                        <i class="c333 f16">特性</i>
                        
                    </div>
                    <div class="pd_main4_bottom3 hidden">

                        <ul class="pd_main4_bottom3_ul">
                            <?php if(is_array($characteristic)): $i = 0; $__LIST__ = $characteristic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-value="<?php echo ($vo["value"]); ?>" <?php if(in_array(($vo['value']), is_array($user["characteristic"])?$user["characteristic"]:explode(',',$user["characteristic"]))): ?>class="pd_main4_bottom3_chang"<?php endif; ?>>
                                    <span><?php echo ($vo["name"]); ?></span>
                                    <input name="characteristic[]" type="hidden" <?php if(in_array(($vo['value']), is_array($user["characteristic"])?$user["characteristic"]:explode(',',$user["characteristic"]))): ?>value="<?php echo ($vo["value"]); ?>"<?php else: ?>value=""<?php endif; ?> class="characteristic">
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <div class="pd_main4_bottom5">
                            <i></i>
                        </div>
                        <?php if(count($characteristic) > 16): ?><div class="pd_main4_bottom4 pd_main4_bottom6">
                                <span>更多</span>
                                <img src="/Public/Home/images/Icon/img33.png" />
                            </div><?php endif; ?>
                    </div>
                    
                    <div class="pd_main4_bottom5">
                        <div class="hidden">
                            <label>爱好</label>
                        </div>
                        <ul class="pd_main4_bottom5_ul">
                            <?php if(is_array($hobby)): $i = 0; $__LIST__ = $hobby;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-value="<?php echo ($vo["value"]); ?>" <?php if(in_array(($vo['value']), is_array($user["hobby"])?$user["hobby"]:explode(',',$user["hobby"]))): ?>class="pd_main4_bottom5_chang"<?php endif; ?>>
                                    <span><?php echo ($vo["name"]); ?></span>
                                    <input name="hobby[]" type="hidden" <?php if(in_array(($vo['value']), is_array($user["hobby"])?$user["hobby"]:explode(',',$user["hobby"]))): ?>value="<?php echo ($vo["value"]); ?>"<?php else: ?>value=""<?php endif; ?> class="hobby">
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
            </div>
            <div class="pd_main5">

            </div>
            <div class="pd_main6">
                <a href="javascript:;" id="save">保存</a>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".pd_main3_bottom input").click(function () {
                $(this).parents().addClass("pd_main3_bottom2").siblings().removeClass("pd_main3_bottom2");
            })
            $(".pd_main4_bottom3_ul li").click(function () {
                var obj=$(this);
                if(!obj.hasClass("pd_main4_bottom3_chang")){
                    var size=$(".pd_main4_bottom3_ul li.pd_main4_bottom3_chang").size();
                    if(size>=3){
                      alert("至多选3个");
                      return false;
                    }
                    obj.find(".characteristic").val(obj.data("value"));
                }else{
                    obj.find(".characteristic").val("");
                }
                $(this).toggleClass("pd_main4_bottom3_chang");
            })
            $(".pd_main4_bottom5_ul li").click(function () {
                var obj=$(this);
                if(!obj.hasClass("pd_main4_bottom5_chang")){
                    var size=$(".pd_main4_bottom5_ul li.pd_main4_bottom5_chang").size();
                    if(size>=3){
                      alert("至多选3个");
                      return false;
                    }
                    obj.find(".hobby").val(obj.data("value"));
                }else{
                    obj.find(".hobby").val("");
                }
                $(this).toggleClass("pd_main4_bottom5_chang");
            })
           
            //更多

            var li_length = $(".pd_main4_bottom3_ul li").length;
            if (li_length > 16) {

                $(".pd_main4_bottom4 span").text("更多");
                $(".pd_main4_bottom3_ul").find("li:gt(16)").hide();
            }
            else {
                $(".pd_main4_bottom4 span").text("");
            }

            //更多
            $(".pd_main4_bottom4").click(function () {
                if ($(this).hasClass("pd_main4_bottom6")) {
                    $(".pd_main4_bottom4 span").text("收起");
                    $(".pd_main4_bottom3_ul").find("li:gt(16)").show();
                    $(this).removeClass("pd_main4_bottom6");
                }
                else {
                    $(".pd_main4_bottom4 span").text("更多");
                    $(".pd_main4_bottom3_ul").find("li:gt(16)").hide();
                    $(this).addClass("pd_main4_bottom6")
                }
            });
        $("#save").click(function(){
            $("#form").submit();
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