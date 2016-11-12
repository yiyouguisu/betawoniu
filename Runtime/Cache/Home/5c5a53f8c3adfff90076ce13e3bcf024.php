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

<script src="/Public/Home/js/chosen.jquery.js"></script>
<link href="/Public/Home/css/chosen.css" rel="stylesheet" />
<script src="/Public/Home/js/jquery-ui.min.js"></script>
<link href="/Public/Home/css/jquery-ui.min.css" rel="stylesheet" />
<script src="/Public/Home/js/jssor.js"></script>
<script src="/Public/Home/js/jssor.slider.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<script>
        $(function(){
            var dateInput = $("input.J_date")
            if (dateInput.length) {
                Wind.use('datePicker', function () {
                    dateInput.datePicker();
                });
            }
        })
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

<div class="wrap">
        <div class="Legend_main3">
            <div class="Legend_main3_top">
                <a href="/">首页</a>
                <i>></i>
                <a href="<?php echo U('Home/Hostel/index');?>">美宿</a>
                <i>></i>
                <a href="<?php echo U('Home/Hostel/show',array('id'=>$data['id']));?>"><?php echo ($data["title"]); ?></a>
            </div>
            <div class="Inn_introduction_main">
                <div class="Inn_introduction_main_top hidden">
                    <span><?php echo ($data["title"]); ?></span>
                    <i><em><?php echo ((isset($data["money"]) && ($data["money"] !== ""))?($data["money"]):"0.00"); ?></em>元起</i>
                </div>
                <div class="hidden Inn_introduction_main_bottom">
                    <div class="middle Inn_introduction_main_bottom2">
                        <div class="Inn_introduction_main_bottom2_1 hidden">
                            <img src="/Public/Home/images/Icon/img44.png" />
                            <span>客栈地址 : <em><?php echo getarea($data['area']); echo ($data["address"]); ?></em></span>
                            <a href="#Inn_Four">查看地图</a>
                        </div>
                        <div class="center hidden">
                            <ul class="center_ul hidden middle">
                                <?php echo getevaluation($data['evaluationpercent']);?>
                            </ul>
                            <span class="middle"><em><?php echo ((isset($data["evaluation"]) && ($data["evaluation"] !== ""))?($data["evaluation"]):"0.0"); ?></em>分</span>
                            <div class="center_ul_list middle">
                                <img src="/Public/Home/images/Icon/img10.png" /><i><em><?php echo ((isset($data["reviewnum"]) && ($data["reviewnum"] !== ""))?($data["reviewnum"]):"0"); ?></em>条评论</i>
                            </div>
                        </div>

                    </div>
                    <div class="middle Inn_introduction_main_bottom3">
                        <a href="" class="a1"><img src="/Public/Home/images/Icon/img24.png" /></a>
                        <a href="javascript:;" class="a2">
                            <?php if(($data['iscollect']) == "1"): ?><img src="/Public/Home/images/Icon/img25.png" class="shoucang" data-id="<?php echo ($data["id"]); ?>"/>
                                <?php else: ?>
                                <img src="/Public/Home/images/shoucang.png"  class="shoucang" data-id="<?php echo ($data["id"]); ?>"/><?php endif; ?>
                            收藏
                        </a>
                        <a href="javascript:;" class="a3 travels2_bottom3"><img src="/Public/Home/images/Icon/img26.png" />添加到行程</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {

            var _SlideshowTransitions = [
            //Fade in L
                { $Duration: 1200, x: 0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade out R
                , { $Duration: 1200, x: -0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade in R
                , { $Duration: 1200, x: -0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade out L
                , { $Duration: 1200, x: 0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

            //Fade in T
                , { $Duration: 1200, y: 0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out B
                , { $Duration: 1200, y: -0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade in B
                , { $Duration: 1200, y: -0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade out T
                , { $Duration: 1200, y: 0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

            //Fade in LR
                , { $Duration: 1200, x: 0.3, $Cols: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out LR
                , { $Duration: 1200, x: 0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade in TB
                , { $Duration: 1200, y: 0.3, $Rows: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade out TB
                , { $Duration: 1200, y: 0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

            //Fade in LR Chess
                , { $Duration: 1200, y: 0.3, $Cols: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out LR Chess
                , { $Duration: 1200, y: -0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade in TB Chess
                , { $Duration: 1200, x: 0.3, $Rows: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out TB Chess
                , { $Duration: 1200, x: -0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

            //Fade in Corners
                , { $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out Corners
                , { $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $SlideOut: true, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }

            //Fade Clip in H
                , { $Duration: 1200, $Delay: 20, $Clip: 3, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade Clip out H
                , { $Duration: 1200, $Delay: 20, $Clip: 3, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade Clip in V
                , { $Duration: 1200, $Delay: 20, $Clip: 12, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade Clip out V
                , { $Duration: 1200, $Delay: 20, $Clip: 12, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            ];

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 1500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 800,                                //Specifies default duration (swipe) for slide in milliseconds

                $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                },

                $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                },

                $ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 10,                             //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 360                          //[Optional] The offset position to park thumbnail
                }
            };

            var imglist="<?php echo ($imglist); ?>";
            if(imglist!=""){
                var jssor_slider1 = new $JssorSlider$("slider1_container", options);
                //responsive code begin
                //you can remove responsive code if you don't want the slider scales while window resizes
                function ScaleSlider() {
                    var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                    if (parentWidth)
                        jssor_slider1.$ScaleWidth(Math.max(Math.min(parentWidth, 760), 300));
                    else
                        window.setTimeout(ScaleSlider, 30);
                }
            
                ScaleSlider();

                $(window).bind("load", ScaleSlider);
                $(window).bind("resize", ScaleSlider);
                $(window).bind("orientationchange", ScaleSlider);
            }
            //responsive code end
        });
    </script>
    <div class="wrap">
        <div class="Inn_introduction_main2">
            <div id="slider1_container" style="vertical-align:top; display:inline-block; *display:inline; *zoom:1; position: relative; top: 0px; left: 0px; width: 800px;
        height: 556px; background: #fff; overflow: hidden;">

                <!-- Loading Screen -->
                <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                    <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #fff; top: 0px; left: 0px;width: 100%;height:100%;">
                    </div>
                    <div style="position: absolute; display: block; background: url(img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
                    </div>
                </div>

                <!-- Slides Container -->
                <div u="slides" style="cursor: pointer; position: absolute; left: 0px; top: 0px; width: 800px; height: 456px; overflow: hidden;">
                    <?php if(is_array($imglist)): $i = 0; $__LIST__ = $imglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div>
                            <img u="image" src="<?php echo ($vo); ?>" /><!--显示的大图-->
                            <img u="thumb" src="<?php echo ($vo); ?>" /><!--小图片-->
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <!-- Arrow Left -->
                <span u="arrowleft" class="jssora05l hide" style="width: 40px; height: 40px; top: 158px; left: 8px;"></span><!--左箭头-->
                <span u="arrowright" class="jssora05r hide" style="width: 40px; height: 40px; top: 158px; right: 8px"></span><!--右箭头-->
                <div u="thumbnavigator" class="jssort01" style="position: absolute; width: 800px; height: 100px; left:0px; bottom: 0px;">
                    <div u="slides" style="cursor: pointer;">
                        <div u="prototype" class="p" style="position: absolute; width: 107px; height: 72px; top: 0; left: 0;">
                            <div class=w><div u="thumbnailtemplate" style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></div></div>
                            <div class=c>
                            </div>
                        </div>
                    </div>
                    <!-- Thumbnail Item Skin End -->
                </div>
                <!-- Thumbnail Navigator Skin End -->
            </div>

            <div class="Inn_introduction_main3">
                <div class="Inn_introduction_main3_top">
                    <a href="">
                        <div>
                            <img src="<?php echo ($data["head"]); ?>" />
                        </div>
                        <?php echo ($data["nickname"]); ?>
                    </a>
                </div>
                <div class="Inn_introduction_main3_center">
                    <span>
                        <?php if(($data['realname_status']) == "1"): ?><img src="/Public/Home/images/Icon/img27.png" />
                            <?php else: ?>
                            <img src="/Public/Home/images/Icon/img27_1.png" /><?php endif; ?>
                        实名认证
                    </span>
                    <span>
                        <?php if(($data['houseowner_status']) == "1"): ?><img src="/Public/Home/images/Icon/img28.png" />
                            <?php else: ?>
                            <img src="/Public/Home/images/Icon/img28_1.png" /><?php endif; ?>
                        个人房东
                    </span>
                </div>
                <div class="Inn_introduction_main3_center2">
                    <ul class="Inn_introduction_main3_center2_ul hidden">
                        <li>
                            <span><?php echo ($data['onlinereply']); ?>%</span>
                            <i>在线回复率</i>
                        </li>
                        <li>
                            <span><?php echo ($data['evaluationconfirm']); ?>分钟</span>
                            <i>审核确认时间</i>
                        </li>
                        <li>
                            <span><?php echo ($data['orderconfirm']); ?>%</span>
                            <i>订单接受率</i>
                        </li>
                    </ul>
                </div>

                <div class="Inn_introduction_main3_bottom">
                    <!-- <a href="" class="a1">预订房间</a> -->
                    <a href="<?php echo U('Home/Woniu/chatdetail',array('tuid'=>$data['uid']));?>" class="a2">在线咨询房东</a>
                </div>


            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            $(".Legend_main3_center_list li").click(function () {
                $(this).addClass("Legend_chang").siblings().removeClass("Legend_chang");
                $(this).parents("ul").siblings().find("li").removeClass("Legend_chang");
            })
            $(".Inn_introduction_main3_center2_ul li").last().css({
                "border-right": "0"
            })
        })
    </script>

    <div class="Inn_introduction_main4">
        <div class="Inn_introduction_main4_01">
            <span>我们发布的活动</span>
        </div>
        <div class="main2_bottom">
            <div class="picScroll-left2">
                <div class="bd">
                    <ul class="picList">
                        <?php if(is_array($data['house_owner_activity'])): $i = 0; $__LIST__ = $data['house_owner_activity'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li style="max-width:290px">
                                <div class="pic">
                                    <div class="pr">
                                        <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>" class="show_img"><img src="<?php echo ($vo["thumb"]); ?>" style="width:298px;height:191px" /></a>
                                        <div data-id="<?php echo ($vo["id"]); ?>" <?php if(($vo['iscollect']) == "1"): ?>class="Event_details8_list_01 shoucang_party collect"<?php else: ?> class="Event_details8_list_01 shoucang_party"<?php endif; ?>></div>
                                        <div class="Inn_introduction_main4_02 pa">
                                            <a href="<?php echo U('Home/Member/detail',array('id'=>$v['id']));?>" class="middle">
                                                <img src="<?php echo ($vo["head"]); ?>" width="30px" height="30px" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="Inn_introduction_main4_03">
                                        <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],10);?></a>
                                        <i class="f14 c999">时间 :<em class="f12 c666"><?php echo (date("Y-m-d",$vo["starttime"])); ?> - <?php echo (date("Y-m-d",$vo["endtime"])); ?></em></i>
                                        <i class="f14 c999">地点 :<em class="f14 c666"><?php echo ($vo["address"]); ?></em></i>
                                    </div>
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="hd">
                    <ul></ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(".picScroll-left2").slide({
            titCell: ".hd ul",
            mainCell: ".bd ul",
            autoPage: true,
            effect: "leftLoop",
            vis: 4,
            trigger: "click"
        });
    </script>


    <div class="wrap">
        <div class="Inn_introduction_main5">
            <div class="Inn_introduction_main5_tab">
                <ul class="Inn_introduction_main5_tab_ul clearfix">
                    <li><a href="#Inn_one">房间选择</a></li>
                    <li><a href="#Inn_two">美宿描述</a></li>
                    <li><a href="#Inn_Six">评论</a></li>
                    <li><a href="#Inn_Four">交通地图</a></li>
                    <li><a href="#Inn_Three">配套设施</a></li>
                    <li><a href="#Inn_Five">退订规则</a></li>
                    <li><a href="#Inn_Seven">周边美宿</a></li>
                </ul>
            </div>
            <div  name="Inn_one" id="Inn_one">
                 <div class="Inn_introduction_main5_01">
                    <ul class="Release_of_legend_m3t_ul" id="roominfo">
                        <?php if(is_array($data['room'])): $i = 0; $__LIST__ = $data['room'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
        <div class="hidden Release_of_legend_m3t_list">
            <div class="fl Release_of_legend_m3t_list2">
                <a href="<?php echo U('Home/Room/show',array('id'=>$vo['rid']));?>">
                    <img src="<?php echo ($vo["thumb"]); ?>" style="width:256px;height:160px"/>
                </a>
            </div>
            <div class="fl Release_of_legend_m3t_list3">
                <div class="top">
                    <a href="<?php echo U('Home/Room/show',array('id'=>$vo['rid']));?>"><?php echo ($vo["title"]); ?></a>
                </div>
                <div class="center hidden">
                    <ul class="center_ul hidden middle">
                        <?php echo getevaluation($vo['evaluationpercent']);?>
                    </ul>
                    <span class="middle"><em><?php echo ((isset($vo["evaluation"]) && ($vo["evaluation"] !== ""))?($vo["evaluation"]):"10.0"); ?></em>分</span>
                    <div class="center_ul_list middle">
                        <img src="/Public/Home/images/Icon/img10.png" /><i><em><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></em>条评论</i>
                    </div>
                </div>
                <div class="center2">
                    <span>房间面积：<em><?php echo ((isset($vo["area"]) && ($vo["area"] !== ""))?($vo["area"]):"0.0"); ?>m2 </em></span>
                    <span>床型信息：<em><?php echo ($vo["bedtype"]); ?></em></span>
                    <span>最多入住：<em><?php echo ((isset($vo["mannum"]) && ($vo["mannum"] !== ""))?($vo["mannum"]):"0"); ?>人</em></span>
                </div>
                <div class="bottom">
                    <?php if(is_array($vo['support'])): $i = 0; $__LIST__ = $vo['support'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><i>
                            <img src="<?php echo ($v["red_thumb"]); ?>" /><em><?php echo ($v["catname"]); ?></em>
                        </i><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="fr Release_of_legend_m3t_list4" style="text-align: center;">
                <i><em><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.0"); ?></em>元起</i>
                <input type="button" onclick="window.location.href='<?php echo U('Home/Room/show',array('id'=>$vo['rid']));?>'" value="立即预定" />
            </div>
        </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <div class="Inn_introduction_main5_02 getroom">
                         <a href="javascript:;" id="getroom">
                             点击查看全部房间  <em>(<?php echo ((isset($data["roomnum"]) && ($data["roomnum"] !== ""))?($data["roomnum"]):"0"); ?>)</em>  <img src="/Public/Home/images/Icon/img91.png" />
                         </a>
                    </div>
                 </div>
                 
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var page=2;
        $(function () {
            $("#getroom").click(function(){
                var hid="<?php echo ($data["id"]); ?>";
                var posturl = "<?php echo U('Home/Hostel/ajax_getroom');?>";
                var p={ "p":page,"num":2,"hid":hid};
                $.post(posturl,p,function(d){
                    if(d.status==1){
                        $("#roominfo").append(d.html);
                        page++;
                    }else{
                        $(".getroom").hide();
                    }
                    
                });
            })
            
            $(".Release_of_legend_m3t_ul>li:last-child").css({
                "border-bottom": "0"
            })
            var $ml = $(".Inn_introduction_main5_tab_ul>li");
            $ml.click(function () {
                $(this).addClass('Inn_introduction_main5_tab_list').siblings().removeClass('Inn_introduction_main5_tab_list');
            });
        })
        
    </script>


    <div class="wrap">
        <div class="Inn_introduction_main6 hidden" name="Inn_two" id="Inn_two">
            <div class="fl Inn_introduction_main6_1">
                <img src="/Public/Home/images/img92.jpg" />
            </div>
            <div class="fl Inn_introduction_main6_2">
                <div>
                    <div class="Inn_introduction_main6_3 Inn_introduction_main6_heigh" style="height:200px">
                        <?php echo ($data["description"]); ?>
                    </div>
                </div>
                <div class="Inn_introduction_main7_2_span">
                    <span>查看全部</span>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="Inn_introduction_main7 hidden" name="Inn_Three" id="Inn_Three">
            <div class="fl Inn_introduction_main7_1">
                <img src="/Public/Home/images/img93.jpg" />
            </div>
            <div class="fl Inn_introduction_main7_2">
                <div>
                    <ul class="Inn_introduction_main7_2_ul Inn_introduction_main6_heigh Inn_introduction_main6_3"  style="height:200px">
                        <?php if(is_array($support)): $i = 0; $__LIST__ = $support;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <img src="<?php echo ($vo["gray_thumb"]); ?>" /><span><?php echo ($vo["catname"]); ?></span>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="Inn_introduction_main7_2_span">
                    <span>查看全部</span>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Inn_introduction_main7_2_span span").click(function () {
                var $main7_span = $(this).html();
                if ($main7_span == "查看全部") {
                    $(this).html("收起");
                    $(this).parents(".Inn_introduction_main7_2_span").siblings().find(".Inn_introduction_main6_3").css({"height":"auto","min-height":"200px"});
                }
                else if ($main7_span == "收起")
                {
                    $(this).html("查看全部");
                    $(this).parents(".Inn_introduction_main7_2_span").siblings().find(".Inn_introduction_main6_3").css("height",200);
                }
            })
        })
    </script>
    <div class="wrap">
        <div class="Inn_introduction_main8" name="Inn_Four" id="Inn_Four">
            <div style="height:411px;border:#ccc solid 1px;" id="dituContent"></div>
        </div>
    </div>
    <script type="text/javascript">
        //创建和初始化地图函数：
        function initMap() {
            createMap();//创建地图
            setMapEvent();//设置地图事件
            addMapControl();//向地图添加控件
            addMarker();//向地图中添加marker
        }

        //创建地图函数：
        function createMap() {
            var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
            var point = new BMap.Point(121.419727, 31.264583);//定义一个中心点坐标
            map.centerAndZoom(point, 13);//设定地图的中心点和坐标并将地图显示在地图容器中
            window.map = map;//将map变量存储在全局
        }

        //地图事件设置函数：
        function setMapEvent() {
            map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
            map.enableScrollWheelZoom();//启用地图滚轮放大缩小
            map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
            map.enableKeyboard();//启用键盘上下左右键移动地图
        }

        //地图控件添加函数：
        function addMapControl() {
            //向地图中添加缩放控件
            var ctrl_nav = new BMap.NavigationControl({ anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE });
            map.addControl(ctrl_nav);
            //向地图中添加缩略图控件
            var ctrl_ove = new BMap.OverviewMapControl({ anchor: BMAP_ANCHOR_BOTTOM_RIGHT, isOpen: 1 });
            map.addControl(ctrl_ove);
            //向地图中添加比例尺控件
            var ctrl_sca = new BMap.ScaleControl({ anchor: BMAP_ANCHOR_BOTTOM_LEFT });
            map.addControl(ctrl_sca);
        }

        //标注点数组
        var markerArr = [{ title: "<?php echo ($data["title"]); ?>", content: "欢迎光临(●'◡'●)", point: "<?php echo ($data["lng"]); ?>|<?php echo ($data["lat"]); ?>", isOpen: 1, icon: { w: 23, h: 25, l: 92, t: 21, x: 9, lb: 12 } }
        ];
        //创建marker
        function addMarker() {
            for (var i = 0; i < markerArr.length; i++) {
                var json = markerArr[i];
                var p0 = json.point.split("|")[0];
                var p1 = json.point.split("|")[1];
                var point = new BMap.Point(p0, p1);
                var iconImg = createIcon(json.icon);
                var marker = new BMap.Marker(point, { icon: iconImg });
                var iw = createInfoWindow(i);
                var label = new BMap.Label(json.title, { "offset": new BMap.Size(json.icon.lb - json.icon.x + 10, -20) });
                marker.setLabel(label);
                map.addOverlay(marker);
                label.setStyle({
                    borderColor: "#808080",
                    color: "#333",
                    cursor: "pointer"
                });

                (function () {
                    var index = i;
                    var _iw = createInfoWindow(i);
                    var _marker = marker;
                    _marker.addEventListener("click", function () {
                        this.openInfoWindow(_iw);
                    });
                    _iw.addEventListener("open", function () {
                        _marker.getLabel().hide();
                    })
                    _iw.addEventListener("close", function () {
                        _marker.getLabel().show();
                    })
                    label.addEventListener("click", function () {
                        _marker.openInfoWindow(_iw);
                    })
                    if (!!json.isOpen) {
                        label.hide();
                        _marker.openInfoWindow(_iw);
                    }
                })()
            }
        }
        //创建InfoWindow
        function createInfoWindow(i) {
            var json = markerArr[i];
            var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>" + json.content + "</div>");
            return iw;
        }
        //创建一个Icon
        function createIcon(json) {
            var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w, json.h), { imageOffset: new BMap.Size(-json.l, -json.t), infoWindowOffset: new BMap.Size(json.lb + 5, 1), offset: new BMap.Size(json.x, json.h) })
            return icon;
        }

        initMap();//创建和初始化地图
    </script>
    <div class="wrap">
        <div class="Inn_introduction_main6 hidden" name="Inn_Five" id="Inn_Five">
            <div class="fl Inn_introduction_main6_1">
                <img src="/Public/Home/images/img94.jpg" />
            </div>
            <div class="fl Inn_introduction_main6_2">
                <div>
                    <div class="Inn_introduction_main9 Inn_introduction_main6_heigh Inn_introduction_main6_3"   style="height:200px">
                    <?php echo ($data["content"]); ?>
                    </div>
                </div>
                <div class="Inn_introduction_main7_2_span">
                    <span>查看全部</span>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap">
        <div class="Inn_introduction_main10" name="Inn_Six" id="Inn_Six">
            <div class="Inn_introduction_main10_top hidden">
                <div class="fl Inn_introduction_main10_top_left">
                    <span>评论  <em>(<?php echo ((isset($data["reviewnum"]) && ($data["reviewnum"] !== ""))?($data["reviewnum"]):"0"); ?>)</em></span>
                </div>
                <div class="fr Inn_introduction_main10_top_right">
                    <div class="Inn_Star_praise hidden">
                        <ul class="Inn_Star_praise_ul hidden middle">
                            <?php echo getevaluation($data['evaluationpercent']);?>
                        </ul>
                        <span class="middle"><em><?php echo ((isset($data["evaluation"]) && ($data["evaluation"] !== ""))?($data["evaluation"]):"0.0"); ?></em>分</span>
                    </div>
                </div>
            </div>
            <div class="Inn_introduction_main10_botttom reviewlist" >
                
            </div>
            <script>
                $(function(){
                    var hid="<?php echo ($data["id"]); ?>";
                    var geturl = "<?php echo U('Home/Hostel/get_review');?>";
                    var p={"isAjax":1,"hid":hid};
                    $.get(geturl,p,function(d){
                        $(".reviewlist").html(d.html);
                    });
                    $('.ajaxpagebar a').live("click",function(){
                        try{    
                            var geturl = $(this).attr('href');
                            var p={"isAjax":1,"hid":hid};
                            $.get(geturl,p,function(d){
                                $(".reviewlist").html(d.html);
                            });
                        }catch(e){};
                        return false;
                    })
                })
            </script>
        </div>
    </div>


    <div class="wrap">
        <div class="Event_details7" name="Inn_Seven" id="Inn_Seven">
            <span>周边美宿推荐</span>
            <div class="Event_details8 hidden">
                <ul class="Event_details8_ul clearfix">
                    <?php if(is_array($data['house_near_hostel'])): $i = 0; $__LIST__ = $data['house_near_hostel'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="fl">
                            <div class="Event_details8_li">
                                <div class="Event_details8_list">
                                    <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>" class="Event_details8_a">
                                        <img src="<?php echo ($vo["thumb"]); ?>">
                                    </a>
                                    <div data-id="<?php echo ($vo["id"]); ?>" <?php if(($vo['iscollect']) == "1"): ?>class="Event_details8_list_01 shoucang_hostel collect"<?php else: ?> class="Event_details8_list_01 shoucang_hostel"<?php endif; ?>></div>
                                    <div class="Event_details8_list_02 pa">
                                        <i>￥</i>
                                        <span><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.00"); ?></span>
                                        <label>起</label>
                                    </div>
                                    <div class="Event_details8_list_03 pa">
                                        <span><?php echo ((isset($vo["evaluation"]) && ($vo["evaluation"] !== ""))?($vo["evaluation"]):"0"); ?></span><i>分</i>
                                    </div>
                                    <div class="Event_details8_list_04 pa">
                                        <a href="<?php echo U('Home/Member/detail',array('uid'=>$vo['uid']));?>">
                                            <img src="<?php echo ($vo["head"]); ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="Event_details8_list2">
                                    <span onclck="window.location.href='<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>'"><?php echo str_cut($vo['title'],10);?></span>
                                    <div class="hidden Event_details8_list2_01">
                                        <div class="fl Event_details8_list2_02">
                                            <img src="/Public/Home/images/Icon/img10.png" />
                                            <i><em><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></em>条点评</i>
                                        </div>
                                        <div class="fr Event_details8_list2_03 tr">
                                            <?php if(($vo['ishit']) == "1"): ?><img src="/Public/Home/images/dianzan.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="<?php echo ($vo["id"]); ?>"/>
                                                <?php else: ?>
                                                <img src="/Public/Home/images/Icon/img9.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="<?php echo ($vo["id"]); ?>"/><?php endif; ?>
                                            <i class="zannum"><?php echo ((isset($vo["hit"]) && ($vo["hit"] !== ""))?($vo["hit"]):"0"); ?></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
        <div class="Event_details7">
            <span>周边活动推荐</span>
            <div class="Event_details8 hidden">
                <ul class="Event_details8_ul clearfix">
                    <?php if(is_array($data['house_near_activity'])): $i = 0; $__LIST__ = $data['house_near_activity'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="fl">
                            <div class="Event_details8_li">
                                <div class="Event_details8_list">
                                    <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>" class="Event_details8_a">
                                        <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg" />
                                    </a>
                                    <div data-id="<?php echo ($vo["id"]); ?>" <?php if(($vo['iscollect']) == "1"): ?>class="Event_details8_list_01 shoucang_party collect"<?php else: ?> class="Event_details8_list_01 shoucang_party"<?php endif; ?>></div>
                                    <div class="Event_details8_list_04 pa">
                                        <a href="<?php echo U('Home/Member/detail',array('uid'=>$vo['uid']));?>">
                                            <img src="<?php echo ($vo["head"]); ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="Event_details8_list3">
                                    <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],10);?></a>
                                    <div>
                                        <i class="c999 f14">
                                            时间 :<em class="f12 c666"><?php echo (date("Y-m-d",$vo["starttime"])); ?> - <?php echo (date("Y-m-d",$vo["endtime"])); ?></em>
                                        </i>
                                    </div>
                                    <div>
                                        <i class="c999 f14">
                                            地点 :<em class="f12 c666"><?php echo ($vo["address"]); ?> </em>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="Mask3 hide">
        
    </div>
    <div class="travels2_a hide">
        <div class="travels2_a_top pr">
            <span class="f22 c666">
                编辑行程时间
            </span>
            <i class="travels2_a_top2">
                <img src="/Public/Home/images/Icon/img107.png" />
            </i>
        </div>
        <div class="travels2_a_bottom">
            <div class="travels2_a_bottom2">
                <span>行程标题 :</span>
                <input type="text" id="trip_title" />
            </div>
            <div class="travels2_a_bottom3 hidden">
                <div class="travels2_a_bottom4 fl">
                    <span>出发时间 :</span>
                    <input value="<?php echo date('Y-m-d');?>" type="text" class="J_date" id="trip_starttime" />
                </div>
                <div class="fr travels2_a_bottom5">
                    <span class="middle">出发天数 :</span>
                    <div class="travels2_a_bottom6 middle hidden">
                        <input type="text" value="1" id="trip_days"/>
                        <i>天</i>
                    </div>
                </div>
            </div>
            <div class="travels2_a2">
                <input type="button" class="addtrip" data-varname="" value="提交" />
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function () {
        $(".Mask3").height($(window).height());
        $(".travels2_bottom3").click(function () {
            var uid="<?php echo ($user["id"]); ?>";
            if(uid==''){
                alert("请先登录！");var p={};
                    p['url']="/index.php/Home/Hostel/show/id/7.html";
                    $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                        if(data.code=200){
                            window.location.href="<?php echo U('Home/Member/login');?>";
                        }
                    })
                return false;
            }
            if(uid=="<?php echo ($data["uid"]); ?>"){
                alert("不能选择自己发布的美宿");
                return false;
            }
            var home_iscachetrip=$.cookie("home_iscachetrip");
            var hid="";
            if(home_iscachetrip){
                var p={};
                p['hid']="<?php echo ($data["id"]); ?>";
                $.post("<?php echo U('Home/Trip/ajax_cachetripinfo');?>",p,function(data){
                    if(data.code=200){
                        var home_cachetripdo= $.cookie("home_cachetripdo");
                        if(home_cachetripdo=='edit'){
                            window.location.href="<?php echo U('Home/Trip/edit');?>";
                        }else if(home_cachetripdo=='add'){
                            window.location.href="<?php echo U('Home/Trip/add');?>";
                        }
                    }else{
                        alert("提交失败");
                    }
                })
            }else{
                $(".Mask3").show();
                $(".travels2_a").show();
            }
            
        })
        $(".Mask3,.travels2_a_top2").click(function () {
            $(".Mask3").hide();
            $(".travels2_a").hide();
        })
        $(".addtrip").click(function(){
            var p={};
            var trip_title=$("#trip_title").val();
            if(trip_title==''){
                alert("请填写行程标题！");
                return false;
            }
            var trip_starttime=$("#trip_starttime").val();
            if(trip_starttime==''){
                alert("请选择行程开始时间！");
                return false;
            }
            var trip_days=$("#trip_days").val();
            if(trip_days==''||Number(trip_days)<=0){
                alert("请填写正确行程天数！");
                return false;
            }
            p['hid']="<?php echo ($data["id"]); ?>";
            p['title']=trip_title;
            p['starttime']=trip_starttime;
            p['days']=trip_days;
            $.post("<?php echo U('Home/Trip/ajax_cachetripinfo');?>",p,function(data){
                if(data.code=200){
                    $(".Mask3").hide();
                    $(".travels2_a").hide();
                    window.location.href="<?php echo U('Home/Trip/add');?>";
                }else{
                    alert("提交失败");
                }
            })
            
        })
        $(".zanbg1").live("click",function(){
            var obj=$(this);
            var uid='<?php echo ($user["id"]); ?>';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="/index.php/Home/Hostel/show/id/7.html";
                $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                    if(data.code=200){
                        window.location.href="<?php echo U('Home/Member/login');?>";
                    }
                })
              return false;
            }
            var hitnum=$(this).siblings(".zannum");
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "<?php echo U('Home/Party/ajax_hit');?>",
                 data: {'aid':aid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                var num=Number(hitnum.text()) + 1;
                                hitnum.text(num);
                                obj.attr("src","/Public/Home/images/dianzan.png");
                              }else if(data.type==2){
                                var num=Number(hitnum.text()) - 1;
                                hitnum.text(num);
                                obj.attr("src","/Public/Home/images/Icon/img9.png");
                              }
                            }else if(data.status==0){
                              alert("点赞失败！");
                            }
                          }
              });
          });
        $(".zanbg1_hostel").live("click",function(){
            var obj=$(this);
            var uid='<?php echo ($user["id"]); ?>';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="/index.php/Home/Hostel/show/id/7.html";
                $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                    if(data.code=200){
                        window.location.href="<?php echo U('Home/Member/login');?>";
                    }
                })
              return false;
            }
            var hitnum=$(this).siblings(".zannum");
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "<?php echo U('Home/Hostel/ajax_hit');?>",
                 data: {'hid':hid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                var num=Number(hitnum.text()) + 1;
                                hitnum.text(num);
                                obj.attr("src","/Public/Home/images/dianzan.png");
                              }else if(data.type==2){
                                var num=Number(hitnum.text()) - 1;
                                hitnum.text(num);
                                obj.attr("src","/Public/Home/images/Icon/img9.png");
                              }
                            }else if(data.status==0){
                              alert("点赞失败！");
                            }
                          }
              });
          });
        $(".shoucang").live("click",function(){
            var obj=$(this);
            var uid='<?php echo ($user["id"]); ?>';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="/index.php/Home/Hostel/show/id/7.html";
                $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                    if(data.code=200){
                        window.location.href="<?php echo U('Home/Member/login');?>";
                    }
                })
              return false;
            }
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "<?php echo U('Home/Hostel/ajax_collect');?>",
                 data: {'hid':hid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                obj.attr("src","/Public/Home/images/Icon/img25.png");
                              }else if(data.type==2){
                                obj.attr("src","/Public/Home/images/shoucang.png");
                              }
                            }else if(data.status==0){
                              alert("收藏失败！");
                            }
                          }
              });
          });
        $(".shoucang_party").live("click",function(){
            var obj=$(this);
            var uid='<?php echo ($user["id"]); ?>';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="/index.php/Home/Hostel/show/id/7.html";
                $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                    if(data.code=200){
                        window.location.href="<?php echo U('Home/Member/login');?>";
                    }
                })
              return false;
            }
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "<?php echo U('Home/Party/ajax_collect');?>",
                 data: {'aid':aid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                obj.addClass("collect");
                              }else if(data.type==2){
                                obj.removeClass("collect");
                              }
                            }else if(data.status==0){
                              alert("收藏失败！");
                            }
                          }
              });
          });
        $(".shoucang_hostel").live("click",function(){
            var obj=$(this);
            var uid='<?php echo ($user["id"]); ?>';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="/index.php/Home/Hostel/show/id/7.html";
                $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                    if(data.code=200){
                        window.location.href="<?php echo U('Home/Member/login');?>";
                    }
                })
              return false;
            }
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "<?php echo U('Home/Hostel/ajax_collect');?>",
                 data: {'hid':hid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                obj.addClass("collect");
                              }else if(data.type==2){
                                obj.removeClass("collect");
                              }
                            }else if(data.status==0){
                              alert("收藏失败！");
                            }
                          }
              });
          });
    });
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