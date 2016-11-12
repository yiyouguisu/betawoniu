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

<div class="my_home" style="background: url('<?php echo ((isset($user["background"]) && ($user["background"] !== ""))?($user["background"]):'/Public/Home/images/img51.jpg'); ?>') no-repeat center center;    background-size: 1920px 200px;">
        <div class="wrap">
            <div class="my_home_main">
                <div class="my_home_main2">
                    <img src="<?php echo ((isset($user["head"]) && ($user["head"] !== ""))?($user["head"]):'/default_head.png'); ?>"  width="110px" height="110px"/>
                </div>
                <div class="my_home_main3">
                    <div class="hidden my_home_main4">
                        <span class="fr" onclick="window.location.href='<?php echo U('Home/Member/change_background');?>'">我要换背景</span>
                    </div>
                    <div class="my_home_main5">
                        <div class="my_home_main5_01 middle">
                            <span class="f22 cw"><?php echo ((isset($user["nickname"]) && ($user["nickname"] !== ""))?($user["nickname"]):"未填写"); ?></span>
                            <?php if(($user['houseowner_status']) == "1"): ?><img src="/Public/Home/images/Icon/img37.png" /><a class="cw f14">个人房东</a><?php endif; ?>
                            
                        </div>
                        <div class="my_home_main5_02 middle">
                            <span class="f22 cw"><?php echo ((isset($user["attentionnum"]) && ($user["attentionnum"] !== ""))?($user["attentionnum"]):"0"); ?></span>
                            <a class="cw f14">关注</a>
                        </div>
                        <div class="my_home_main5_02 middle">
                            <span class="f22 cw"><?php echo ((isset($user["fansnum"]) && ($user["fansnum"] !== ""))?($user["fansnum"]):"0"); ?></span>
                            <a class="cw f14">粉丝</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my_home2">
        <div <?php if(($user['houseowner_status']) == "1"): ?>class="wrap hidden legend_main"<?php else: ?> class="wrap hidden my_home2_01"<?php endif; ?>>
    <ul <?php if(($user['houseowner_status']) == "1"): ?>class="legend_main_ul fl"<?php else: ?> class="my_home2_ul fl"<?php endif; ?>>
        <li <?php if(($current_url) == "Home/Member/index"): ?>class="fl legend_main_chang" <?php else: ?>class="fl"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/index');?>"><?php if(($user['houseowner_status']) == "1"): ?>房东主页<?php else: ?>个人主页<?php endif; ?></a>
        </li>
        <li <?php if($current_url == 'Home/Member/mycoupons' or $current_url == 'Home/Member/couponsshow'): ?>class="fl legend_main_chang" <?php else: ?>class="fl"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/mycoupons');?>">我的优惠券</a>
        </li>
        <li <?php if($current_url == 'Home/Member/myorder_hostel' or $current_url == 'Home/Member/myorder_party'): ?>class="fl legend_main_chang" <?php else: ?>class="fl"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/myorder_hostel');?>">我的订单</a>
        </li>
        <li <?php if(($current_url) == "Home/Member/mynote"): ?>class="fl legend_main_chang" <?php else: ?>class="fl"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/mynote');?>">我的游记</a>
        </li>
        <li <?php if(($current_url) == "Home/Member/myreview"): ?>class="fl legend_main_chang" <?php else: ?>class="fl"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/myreview');?>">我的评论</a>
        </li>
        <li <?php if(($current_url) == "Home/Member/mycollect"): ?>class="fl legend_main_chang" <?php else: ?>class="fl"<?php endif; ?>>
            <a href="<?php echo U('Home/Member/mycollect');?>">我的收藏</a>
        </li>
        <?php if(($user['houseowner_status']) == "1"): ?><li <?php if(($current_url) == "Home/Member/mywallet"): ?>class="fl legend_main_chang" <?php else: ?>class="fl"<?php endif; ?>>
                <a href="<?php echo U('Home/Member/mywallet');?>">我的钱包</a>
            </li>
            <li <?php if(($current_url) == "Home/Member/myrelease"): ?>class="fl legend_main_chang" <?php else: ?>class="fl"<?php endif; ?>>
                <a href="<?php echo U('Home/Member/myrelease');?>">我的发布</a>
            </li><?php endif; ?>
    </ul>
    <?php if(($user['houseowner_status']) == "0"): ?><a href="<?php echo U('Home/Member/houseowner');?>">申请成为房东</a><?php endif; ?>
</div>
    </div>
    <div class="hmain4">
        <div class="wrap hmain5 clearfix">
            <div class="fl hmain5_l">
                <div class="hmain5_l6 hidden">
                    <span>今日访问</span>
                    <ul class="hmain5_l6_ul hidden">
                        <?php if(is_array($user['viewlist'])): $i = 0; $__LIST__ = $user['viewlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="fl">
                                <a href="<?php echo U('Home/Member/detail',array('uid'=>$vo['uid']));?>">
                                    <img src="<?php echo ($vo["head"]); ?>" style="width:58px;height:58px;border-radius: 50%;"/>
                                    <i><?php echo ($vo["nickname"]); ?></i>
                                </a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>

                    <div class="hmain5_l6_2">
                        <p>累计访问：<em><?php echo ((isset($user["viewnum"]) && ($user["viewnum"] !== ""))?($user["viewnum"]):"0"); ?></em></p>
                        <p>今日访问：<em><?php echo ((isset($user["todayviewnum"]) && ($user["todayviewnum"] !== ""))?($user["todayviewnum"]):"0"); ?></em></p>
                    </div>
                </div>
                <div class="my_home3 hidden">
                    <span class="f18 c000">我的粉丝</span>
                    <i>( <?php echo ((isset($user["fansnum"]) && ($user["fansnum"] !== ""))?($user["fansnum"]):"0"); ?> )</i>
                    <ul class="hidden my_home3_ul">
                         <?php if(is_array($user['fanslist'])): $i = 0; $__LIST__ = $user['fanslist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="fl">
                                <a href="<?php echo U('Home/Member/detail',array('uid'=>$vo['uid']));?>">
                                    <div class="my_home3_ul_list">
                                        <img src="<?php echo ($vo["head"]); ?>" style="width:58px;height:58px;"/>
                                    </div>
                                    <span class="f12 c000"><?php echo str_cut($vo['nickname'],4);?></span>
                                </a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <?php if($user["fansnum"] > 6): ?><a href="" class="f14 c666">
                            查看更多
                        </a><?php endif; ?>
                </div>



            </div>
            <div class="fl hmain5_r">
                <div class="my_home4">
                    <p><?php echo ($user["nickname"]); ?>，这里是你的家！</p>
                    <p>你可以发布并管理美宿、活动、游记和你的粉丝。现在开启蜗牛客的旅程！</p>
                </div>
                <div class="my_home6">
                    <ul class="my_home6_ul clearfix">
                        <li>
                            <a href="<?php echo U('Home/Member/change_info');?>">
                                <img src="/Public/Home/images/Icon/img38.png" />
                                <span class="f18 c333">完善个人资料</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo U('Home/Note/add');?>">
                                <img src="/Public/Home/images/Icon/img39.png" />
                                <span class="f18 c333">写游记</span>
                            </a>
                        </li>
                        <?php if(($user['houseowner_status']) == "1"): ?><li>
                                <a href="<?php echo U('Home/Party/add');?>">
                                    <img src="/Public/Home/images/Icon/img40.png" />
                                    <span class="f18 c333">发布活动</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo U('Home/Hostel/add');?>">
                                    <img src="/Public/Home/images/Icon/img41.png" />
                                    <span class="f18 c333">发布美宿</span>
                                </a>
                            </li>
                            <?php else: ?>
                            <li>
                                <a href="<?php echo U('Home/Trip/add');?>">
                                    <img src="/Public/Home/images/Icon/img114.png" />
                                    <span class="f18 c333">制定行程</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo U('Home/Member/myorder_hostel');?>">
                                    <img src="/Public/Home/images/Icon/img115.png" />
                                    <span class="f18 c333">我的订单</span>
                                </a>
                            </li><?php endif; ?>
                    </ul>
                </div>
                <?php if(($user['houseowner_status']) == "1"): ?><div class="my_home7">
                        <div class="my_home7_top">
                            <span class="f24 c333">我发布的美宿</span>
                        </div>
                        <ul class="my_home7_ul">
                            <?php if(is_array($myhostel)): $i = 0; $__LIST__ = $myhostel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                    <div class="my_home7_list">
                                        <div class="middle my_home7_list2">
                                            <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>">
                                                <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:185px;height:116px" />
                                            </a>
                                        </div>
                                        <div class="middle my_home7_list3">
                                            <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>" class="f28 c333"><?php echo ($vo["title"]); ?></a>
                                            <div class="my_home7_list3_01 hidden">
                                                <ul class="hidden my_home7_list3_01_ul fl">
                                                    <?php  if($vo['evaluationpercent']>0&&$vo['evaluationpercent']<=20){ echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; }elseif($vo['evaluationpercent']>20&&$vo['evaluationpercent']<=40){ echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; }elseif($vo['evaluationpercent']>40&&$vo['evaluationpercent']<=60){ echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; }elseif($vo['evaluationpercent']>60&&$vo['evaluationpercent']<=80){ echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; }elseif($vo['evaluationpercent']>80&&$vo['evaluationpercent']<=100){ echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; echo "<li class=\"fl\"><img src=\"/Public/Home/images/Icon/img42.png\" /></li>"; } ?>
                                                </ul>
                                                <span class="fl"><em class=""><?php echo ((isset($vo["evaluation"]) && ($vo["evaluation"] !== ""))?($vo["evaluation"]):"0"); ?></em>分</span>
                                                <div class="my_home7_list3_02 fl">
                                                    <img src="/Public/Home/images/Icon/img10.png" />
                                                    <i class="f15 c999"><em class="f16"><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></em>条评论</i>
                                                </div>
                                            </div>
                                            <div class="my_home7_list3_03">
                                                <img src="/Public/Home/images/Icon/img44.png" />
                                                <span class="f14 c333">客栈地址 : <em><?php echo getarea($vo['area']); echo ($vo["address"]); ?>  </em></span>
                                            </div>
                                        </div>
                                        <div class="middle my_home7_list4">
                                            <span class="c333 f18"><em><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.00"); ?></em> 元起</span>
                                        </div>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <div class="my_home8">
                        <div class="my_home8_top">
                            <span class="f24 c333">我发布的活动</span>
                        </div>
                        <div class="my_home8_top2">
                            <ul class="my_home8_top2_ul">
                                <?php if(is_array($myparty)): $i = 0; $__LIST__ = $myparty;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                        <div class="hidden my_home8_top2_list">
                                            <div class="fl my_home8_top2_list2">
                                                <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>">
                                                    <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:143px;height:89px" />
                                                </a>
                                            </div>
                                            <div class="fl my_home8_top2_list3">
                                                <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>" class="f24 c333"><?php echo ($vo["title"]); ?></a>
                                                <div class="hidden my_home8_top2_list3_01">
                                                    <div class="fl my_home8_top2_list3_02">
                                                        <span class="f14 c999">时间 :<em class="f12 c666"><?php echo (date("Y-m-d",$vo["starttime"])); ?> - <?php echo (date("Y-m-d",$vo["endtime"])); ?></em></span>
                                                        <span class="f14 c999">地点 :<em class="c666 f14"><?php echo getarea($vo['area']); echo ($vo["address"]); ?> </em></span>
                                                    </div>
                                                    <div class="fr my_home8_top2_list3_03">
                                                        <?php if(($vo['donestatus']) == "0"): ?><span class="my_home8_span2">进行中</span>
                                                            <?php else: ?>
                                                            <span class="my_home8_span1">已完成</span><?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li><?php endforeach; endif; else: echo "" ;endif; ?>   
                            </ul>
                            <?php if($user["partynum"] > 2): ?><div class="my_home9_bottom2" style="padding-bottom: 30px;">
                                    <a href="<?php echo U('Home/Member/myrelease');?>">点击查看更多</a>
                                </div><?php endif; ?>
                        </div>
                    </div><?php endif; ?>
                <div class="my_home9">
                    <div class="my_home9_top">
                        <span class="f24 c333">我的美宿订单</span>
                    </div>
                    <div class="my_home9_bottom">
                        <ul class="my_home9_bottom_ul">
                            <?php if(is_array($hostelorder)): $i = 0; $__LIST__ = $hostelorder;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                    <div class="hidden my_home9_bottom_list1">
                                        <div class="fl my_home9_bottom_list2">
                                            <a href="<?php echo U('Home/Room/show',array('id'=>$vo['productinfo']['rid']));?>">
                                                <img class="pic" data-original="<?php echo ($vo["productinfo"]["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:142px;height:88px" />
                                            </a>
                                        </div>
                                        <div class="fl my_home9_bottom_list3">
                                            <div class="my_home9_bottom_list3_top">
                                                <a href="<?php echo U('Home/Room/show',array('id'=>$vo['productinfo']['rid']));?>" class="f24 c333"><?php echo str_cut($vo['productinfo']['title'],20);?></a><i class="my_home9_a">美宿</i>
                                            </div>
                                            <div class="my_home9_bottom_list3_bottom">
                                                <div class="middle my_home9_bottom_list3_bottom2">
                                                    <label class="f22">￥</label><span class="f36"><?php echo ((isset($vo["productinfo"]["money"]) && ($vo["productinfo"]["money"] !== ""))?($vo["productinfo"]["money"]):"0.00"); ?></span><i class="f18">起</i>
                                                </div>
                                                <?php if($vo['uid'] != $user['id']): if(($vo['status']) == "1"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">预定</span>
                                                            <a href="<?php echo U('Home/Woniu/orderreview',array('orderid'=>$vo['orderid']));?>" class="my_home9_bottom_list3_a3">去审核</a>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "2"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <a href="javascript:;" class="my_home9_bottom_list3_a1">待付款</a>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "3"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <?php if(($vo['refund_status']) == "2"): ?><span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                <?php else: ?>
                                                                <span class="my_home9_bottom_list3_span2">已取消</span><?php endif; ?>
                                                        </div><?php endif; ?>
                                                    
                                                    <?php if(($vo['status']) == "4"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <?php if($vo['endtime'] < time()): if(($vo['evaluate_status']) == "0"): ?><a href="javascript:;"  class="my_home9_bottom_list3_a2">待评价</a>
                                                                    <?php else: ?>
                                                                    <a href="javascript:;"  class="my_home9_bottom_list3_a2">已完成</a><?php endif; ?>
                                                                <?php else: ?>
                                                                <?php if(($vo['refund_status']) == "0"): ?><a href="javascript:;"  class="my_home9_bottom_list3_a2">待入住</a><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "1"): ?><span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="<?php echo U('Home/Woniu/refundorderreview',array('orderid'=>$vo['orderid']));?>"  class="my_home9_bottom_list3_a2">去审核</a><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "2"): ?><span class="my_home9_bottom_list3_span2">退订成功</span><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "3"): ?><span class="my_home9_bottom_list3_span2">审核失败</span>
                                                                    <a href="javascript:;" class="my_home9_bottom_list3_a2 remark" data-remark="<?php echo ($vo["refundreview_remark"]); ?>"  style="background: #8c8e85;">失败原因</a><?php endif; endif; ?>   
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "5"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">审核失败</span>
                                                            <a class="my_home9_bottom_list3_a2 remark" href="javascript:;" data-remark="<?php echo ($vo["review_remark"]); ?>">失败原因</a>
                                                        </div><?php endif; ?>
                                                    <?php else: ?>
                                                    <?php if(($vo['status']) == "1"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">预定</span>
                                                            <a href="javascript:;"  class="my_home9_bottom_list3_a3">待审核</a>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "2"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <a href="<?php echo U('Home/Order/bookpay',array('orderid'=>$vo['orderid']));?>" class="my_home9_bottom_list3_a1">去支付</a>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "3"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <?php if(($vo['refund_status']) == "2"): ?><span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                <?php else: ?>
                                                                <span class="my_home9_bottom_list3_span2">已取消</span><?php endif; ?>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "4"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <?php if($vo['endtime'] < time()): if(($vo['evaluate_status']) == "0"): ?><a href="<?php echo U('Home/Order/evaluate',array('orderid'=>$vo['orderid']));?>"  class="my_home9_bottom_list3_a2">我要评价</a>
                                                                    <?php else: ?>
                                                                    <a href="javascript:;"  class="my_home9_bottom_list3_a2">已完成</a><?php endif; ?>
                                                                <?php else: ?>
                                                                <?php if(($vo['refund_status']) == "0"): ?><a href="javascript:;"  class="my_home9_bottom_list3_a2">待入住</a><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "1"): ?><span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="javascript:;"  class="my_home9_bottom_list3_a2">待审核</a><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "2"): ?><span class="my_home9_bottom_list3_span2">退订成功</span><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "3"): ?><span class="my_home9_bottom_list3_span2">审核失败</span>
                                                                    <a href="javascript:;"  class="my_home9_bottom_list3_a2 remark" data-remark="<?php echo ($vo["refundreview_remark"]); ?>" style="background: #8c8e85;">失败原因</a><?php endif; endif; ?>
                                                                
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "5"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">审核失败</span>
                                                            <a class="my_home9_bottom_list3_a2 remark" href="javascript:;" data-remark="<?php echo ($vo["review_remark"]); ?>">失败原因</a>
                                                        </div><?php endif; endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <div class="my_home9_bottom2">
                        <a href="<?php echo U('Home/Member/myorder_hostel');?>">点击查看更多</a>
                    </div>
                </div>
                <div class="my_home9">
                    <div class="my_home9_top">
                        <span class="f24 c333">我的活动订单</span>
                    </div>
                    <div class="my_home9_bottom">
                        <ul class="my_home9_bottom_ul">
                            <?php if(is_array($partyorder)): $i = 0; $__LIST__ = $partyorder;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                    <div class="hidden my_home9_bottom_list1">
                                        <div class="fl my_home9_bottom_list2">
                                            <a href="<?php echo U('Home/Party/show',array('id'=>$vo['productinfo']['aid']));?>">
                                                <img class="pic" data-original="<?php echo ($vo["productinfo"]["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:142px;height:88px" />
                                            </a>
                                        </div>
                                        <div class="fl my_home9_bottom_list3">
                                            <div class="my_home9_bottom_list3_top">
                                                <a href="<?php echo U('Home/Party/show',array('id'=>$vo['productinfo']['aid']));?>" class="f24 c333"><?php echo str_cut($vo['productinfo']['title'],20);?></a><i class="my_home9_a2">活动</i>
                                            </div>
                                            <div class="my_home9_bottom_list3_bottom">
                                                <div class="middle my_home9_bottom_list3_bottom2">
                                                   <p class="f14 c999">
                                                       时间 :<em class="f12 c666"><?php echo (date("Y-m-d",$vo["productinfo"]["starttime"])); ?> - <?php echo (date("Y-m-d",$vo["productinfo"]["endtime"])); ?></em>
                                                   </p>
                                                    <p class="f14 c999">
                                                        地点 :<em class="c666 f14"><?php echo getarea($vo['productinfo']['area']); echo ($vo["productinfo"]["address"]); ?></em>
                                                    </p>
                                                </div>
                                                <?php if($vo['uid'] != $user['id']): if(($vo['status']) == "2"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <span class="my_home9_bottom_list3_span2">待付款</span>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "3"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <?php if(($vo['refund_status']) == "2"): ?><span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                <?php else: ?>
                                                                <span class="my_home9_bottom_list3_span2">已取消</span><?php endif; ?>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "4"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <?php if($vo['endtime'] < time()): ?><span class="my_home9_bottom_list3_span2">已完成</span>
                                                                <?php else: ?>
                                                                <?php if(($vo['refund_status']) == "0"): ?><span class="my_home9_bottom_list3_span2">待参加</span><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "1"): ?><span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="<?php echo U('Home/Woniu/refundorderreview',array('orderid'=>$vo['orderid']));?>" class="my_home9_bottom_list3_a1">去审核</a><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "2"): ?><span class="my_home9_bottom_list3_span2">退订成功</span><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "3"): ?><span class="my_home9_bottom_list3_span2">审核失败</span>
                                                                    <a href="javascript:;" class="my_home9_bottom_list3_a1 remark" data-remark="<?php echo ($vo["refundreview_remark"]); ?>"  style="background: #8c8e85;">失败原因</a><?php endif; endif; ?>
                                                        </div><?php endif; ?>
                                                    <?php else: ?>
                                                    <?php if(($vo['status']) == "2"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <a href="<?php echo U('Home/Order/joinpay',array('orderid'=>$vo['orderid']));?>"  class="my_home9_bottom_list3_a1">去支付</a>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "3"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <?php if(($vo['refund_status']) == "2"): ?><span class="my_home9_bottom_list3_span2">退订成功</span>
                                                                <?php else: ?>
                                                                <span class="my_home9_bottom_list3_span2">已取消</span><?php endif; ?>
                                                        </div><?php endif; ?>
                                                    <?php if(($vo['status']) == "4"): ?><div class="my_home9_bottom_list3_bottom3 middle">
                                                            <?php if($vo['endtime'] < time()): ?><span class="my_home9_bottom_list3_span2">已完成</span>
                                                                <?php else: ?>
                                                                <?php if(($vo['refund_status']) == "0"): ?><span class="my_home9_bottom_list3_span2">待参加</span><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "1"): ?><span class="my_home9_bottom_list3_span2">退订</span>
                                                                    <a href="javascript:;" class="my_home9_bottom_list3_a1">去审核</a><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "2"): ?><span class="my_home9_bottom_list3_span2">退订成功</span><?php endif; ?>
                                                                <?php if(($vo['refund_status']) == "3"): ?><span class="my_home9_bottom_list3_span2">审核失败</span>
                                                                    <a href="javascript:;" class="my_home9_bottom_list3_a1 remark" data-remark="<?php echo ($vo["refundreview_remark"]); ?>"  style="background: #8c8e85;">失败原因</a><?php endif; endif; ?>
                                                        </div><?php endif; endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                    </div>
                    <div class="my_home9_bottom2">
                        <a href="<?php echo U('Home/Member/myorder_party');?>">点击查看更多</a>
                    </div>
                </div>
                <div class="hmain5_r6">
                    <div>
                        <div class="hmain5_r6_1">
                            <span>我的评论</span>
                        </div>
                        <ul class="hmain5_r6_ul">
                            <?php if(is_array($myreview)): $i = 0; $__LIST__ = $myreview;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo['varname']) == "note"): ?><li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="<?php echo U('Home/Note/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],20);?></a><span class="hmain5_r6_ul1_a">游记</span>
                                            </div>
                                            <p><?php echo ($vo["content"]); ?></p>
                                            <span>发表于 <em><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?></em></span>
                                        </div>
                                    </li><?php endif; ?>
                                <?php if(($vo['varname']) == "party"): ?><li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],20);?></a><span class="hmain5_r6_ul1_a2">活动</span>
                                            </div>
                                            <p><?php echo ($vo["content"]); ?></p>
                                            <span>发表于 <em><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?></em></span>
                                        </div>
                                    </li><?php endif; ?>
                                <?php if(($vo['varname']) == "hostel"): ?><li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],20);?></a><span class="hmain5_r6_ul1_a1">美宿</span>
                                            </div>
                                            <p><?php echo ($vo["content"]); ?></p>
                                            <span>发表于 <em><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?></em></span>
                                        </div>
                                    </li><?php endif; ?>
                                <?php if(($vo['varname']) == "trip"): ?><li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="<?php echo U('Home/Trip/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],20);?></a><span class="hmain5_r6_ul1_a3">行程</span>
                                            </div>
                                            <p><?php echo ($vo["content"]); ?></p>
                                            <span>发表于 <em><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?></em></span>
                                        </div>
                                    </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>  
                        </ul>
                        <?php if($user["reviewnum"] > 4): ?><a href="<?php echo U('Home/Member/myreview');?>">点击查看更多</a><?php endif; ?>
                    </div>
                </div>
                <div class="hmain5_r5">
                    <div>
                        <div class="hmain5_r5_top hidden">
                            <span class="fl">我的游记</span>
                            <a href="<?php echo U('Home/Note/add');?>">
                                <img src="/Public/Home/images/Icon/img11.png" />发布游记
                            </a>
                        </div>
                        <ul class="hmain5_r5_ul">
                            <?php if(is_array($mynote)): $i = 0; $__LIST__ = $mynote;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                    <div class="hmain5_r5_list hidden">
                                        <div class="fl hmain5_r5_list1">
                                            <a href="<?php echo U('Home/Note/show',array('id'=>$vo['id']));?>">
                                                <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:202px; height:153px" />
                                            </a>
                                        </div>
                                        <div class="fl hmain5_r5_list2">
                                            <a href="<?php echo U('Home/Note/show',array('id'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a>
                                            <i><?php echo (date("Y-m-d",$vo["inputtime"])); ?></i>
                                            <p><?php echo str_cut($vo['description'],30);?></p>
                                            <div class="hmain5_r5_list2_2 hidden">
                                                <div class="fl hidden hmain5_r5_list2_3">
                                                    <div class="fl">
                                                        <img style="margin-right:3px;" src="/Public/Home/images/Icon/img10.png" /><i><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></i><label>条点评</label>
                                                    </div>
                                                    <div class="fl">
                                                        <img style="margin-left:20px;margin-right:3px;" src="/Public/Home/images/Icon/img9.png" /><label><?php echo ((isset($vo["hit"]) && ($vo["hit"] !== ""))?($vo["hit"]):"0"); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                        <?php if($user["notenum"] > 2): ?><a href="<?php echo U('Home/Member/mynote');?>">点击查看更多</a><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="My_message_details_main2 hide">
        <div class="My_message_details_main3">
        </div>
        <div class="My_message_details_main4">
            <div class="My_message_details_m4top">
                <span>请输入不通过的理由</span>
                <div class="My_message_details_m4topf"></div>
            </div>
            <div class="My_message_details_m4bottom">
                <span id="remark"></span>
                
            </div>
        </div>
    </div>
    <div class="Mask3 hide">
    </div>
    <script type="text/javascript">
        $(function () {
            $(".hmain5_l6_2 p").last().css({
                "border-top": "0px"
            })
            $(".remark").live("click",function(){
                var obj=$(this);
                var remark=obj.data("remark");
                $("#remark").text(remark);
                $(".My_message_details_main2").show();
                $("html,body").css({
                    "overflow-y": "hidden",
                })
                
            })
            $(".My_message_details_main3,.My_message_details_m4topf").click(function () {
                $(".My_message_details_main2").hide();
                $("html,body").css({
                    "overflow-y": "auto",
                })
            })
        })
    </script>
    <script type="text/javascript">
        $(function () {
            $(".hmain5_l3").last().css({
                "border-right": "0px",
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