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
        <div class="activity_main">
            <a href="/">首页</a>
            <span>></span>
            <a href="<?php echo U('Home/Woniu/index');?>">蜗牛</a>
            <span>></span>
            <a href="<?php echo U('Home/Woniu/message');?>">我的消息</a>
        </div>
    </div>


    <div class="wrap">
        <div class="Snail_home_main hidden">
            <div class="fl Snail_home_ml">
                <ul class="Snail_home_ml_ul">
                    <li class=""><!--Snail_home_ml_list-->
                        <a href="<?php echo U('Home/Woniu/index');?>">我的好友</a>
                    </li>
                    <li class="">
                        <!--Snail_home_ml_list2-->
                        <a href="<?php echo U('Home/Woniu/chat');?>">正在聊天</a>
                    </li>
                    <li class="Snail_home_ml_list2"><!--Snail_home_ml_list3-->
                        <a href="<?php echo U('Home/Woniu/message');?>">我的消息</a>
                    </li>
                </ul>
            </div>
            <div class="fl Snail_home_mr">
                <div class="Snail_home_c">
                    <ul class="Snail_home_c_ul">
                        <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['varname'] == 'applyrealnamesuccess'): ?><li class="Snail_home_c_color">
                                    <a href="javascript:;"  <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'successbookhouse'): ?> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?>  data-id="<?php echo ($vo["id"]); ?>" data-href="<?php echo U('Home/Order/show',array('orderid'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'applyhouseownersuccess'): ?> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'refundreviewsuccess'): ?> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Order/show',array('orderid'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'withdrawsuccess'): ?> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>" data-href="<?php echo U('Home/Member/mywallet');?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'applyrealnamefail'): ?>
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>" data-href="<?php echo U('Home/Member/realname');?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'failbookhouse'): ?>
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Order/show',array('orderid'=>$vo['value']));?>">
                                         <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'applyhouseownerfail'): ?>
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Member/houseowner');?>">
                                         <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'withdrawfail'): ?>
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Member/mywallet');?>">
                                         <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'refundreviewfail'): ?>
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Order/show',array('orderid'=>$vo['value']));?>">
                                         <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'payordersuccess'): ?>
                                <li class="Snail_home_c_color3">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Order/show',array('orderid'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'applybookhouse'): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>" data-href="<?php echo U('Home/Woniu/show',array('id'=>$vo['id']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                        <div class="middle Snail_home_c_list2 tr">
                                            <i>查看详细 <img src="/Public/Home/images/Icon/img119.png" /></i>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'brefundhostelapply' or $vo['varname'] == 'brefundpartyapply'): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>" data-href="<?php echo U('Home/Woniu/refundreview',array('id'=>$vo['id']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                        <div class="middle Snail_home_c_list2 tr">
                                            <i>查看详细 <img src="/Public/Home/images/Icon/img119.png" /></i>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'refundhostelapply' or $vo['varname'] == 'refundpartyapply'): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>" data-href="<?php echo U('Home/Order/show',array('orderid'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'successreviewnote'): ?> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Note/show',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'successreviewparty'): ?> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Party/show',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'successreviewhostel'): ?> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Hostel/show',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'failreviewnote' or $vo['varname'] == 'failreviewparty' or $vo['varname'] == 'failreviewhostel'): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>" data-href="<?php echo U('Home/Woniu/reviewshow',array('id'=>$vo['id']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                        <div class="middle Snail_home_c_list2 tr">
                                            <i>查看详细 <img src="/Public/Home/images/Icon/img119.png" /></i>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'waitcheck'): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif($vo['varname'] == 'getcoupons'): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>" data-href="<?php echo U('Home/Memmber/couponsshow',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif(($vo['varname'] == 'notehit') OR ($vo['varname'] == 'notecollect') OR ($vo['varname'] == 'notereview')): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Note/show',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif(($vo['varname'] == 'partyhit') OR ($vo['varname'] == 'partycollect') OR ($vo['varname'] == 'partyreview')): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Party/show',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif(($vo['varname'] == 'hostelhit') OR ($vo['varname'] == 'hostelcollect') OR ($vo['varname'] == 'hostelreview')): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Hostel/show',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif(($vo['varname'] == 'roomhit') OR ($vo['varname'] == 'roomcollect') OR ($vo['varname'] == 'roomreview')): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Room/show',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif(($vo['varname'] == 'triphit') OR ($vo['varname'] == 'tripcollect') OR ($vo['varname'] == 'tripreview')): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Trip/show',array('id'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php elseif(($vo['varname'] == 'fattention') OR ($vo['varname'] == 'tattention')): ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>"  data-href="<?php echo U('Home/Member/detail',array('uid'=>$vo['value']));?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a href="javascript:;" <?php if(($vo['status']) == "0"): ?>class="operation redirect"<?php else: ?>class="redirect"<?php endif; ?> data-id="<?php echo ($vo["id"]); ?>">
                                        <?php if(($vo['status']) == "0"): ?><div class="My_news_main_02_float"></div><?php endif; ?>
                                        <div class="middle Snail_home_c_list">
                                            <span><?php echo ($vo["content"]); ?></span>
                                            <p><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?> </p>
                                        </div>
                                    </a>
                                </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>

                <div class="travels_main3"></div>
                    <div class="activity_chang4">
                        <?php echo ($Page); ?>
                    </div>
                <div class="" style="width: 2px; height: 80px;"></div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".operation").click(function(){
            var obj=$(this);
            var mid=obj.data("id");
            var locationurl=obj.data("href");
            $.post("<?php echo U('Home/Woniu/updatestatus');?>",{"mid":mid},function(d){
                d=eval("("+d+")");
                if(d.code==200){
                    obj.find(".My_news_main_02_float").remove();
                    if(locationurl){
                        window.location.href=locationurl;
                    }
                }else{
                    alert(d.msg);
                }
            });
        })
        $(".redirect").click(function(){
            var obj=$(this);
            var locationurl=obj.data("href");
            if(locationurl){
                window.location.href=locationurl;
            }
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