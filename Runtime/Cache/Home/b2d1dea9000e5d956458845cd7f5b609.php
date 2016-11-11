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


    <div class="hmain_main2"  style="background: url('<?php echo ((isset($data["background"]) && ($data["background"] !== ""))?($data["background"]):'/Public/Home/images/img51.jpg'); ?>') no-repeat center center;padding: 30px 0 30px 0;    background-size: 1920px 200px;">
        <div class="wrap">
            <div class="middle hmain_main2_1">
                <img src="<?php echo ($data["head"]); ?>" />
            </div>
            <div class="middle hmain_main2_2">
                <div class="hmain_main2_2_top">
                    <span class="middle"><?php echo ((isset($data["nickname"]) && ($data["nickname"] !== ""))?($data["nickname"]):"未设置"); ?></span>
                    <?php if(($data['realname_status']) == "1"): ?><img src="/Public/Home/images/Icon/img14.png" /><?php endif; ?>
                    <?php if(($data['houseowner_status']) == "1"): ?><img src="/Public/Home/images/Icon/img15.png" /><?php endif; ?>
                    <?php if(($data['id']) != $user["id"]): ?><a <?php if(($data['isattention']) == "1"): ?>class="middle hmain_chang"<?php else: ?> class="middle"<?php endif; ?> href="javascript:;" id="attention">关注</a>
                        <a href="<?php echo U('Home/Woniu/chatdetail',array('tuid'=>$data['id'],'type'=>'member'));?>" class="middle">私信</a><?php endif; ?>
                </div>
                <div class="hmain_main2_2_bottom">
                    <span><?php echo ($data["info"]); ?></span>
                    <?php if(is_array($data['characteristic'])): $i = 0; $__LIST__ = $data['characteristic'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><i>
                            <?php echo ($vo["name"]); ?>
                        </i><?php endforeach; endif; else: echo "" ;endif; ?>
                    <?php if(is_array($data['hobby'])): $i = 0; $__LIST__ = $data['hobby'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><i>
                            <?php echo ($vo["name"]); ?>
                        </i><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div <?php if(($user['houseowner_status']) == "1"): ?>class="hmain6"<?php else: ?> class="hmain3"<?php endif; ?>>
        <div class="wrap">
            <ul <?php if(($user['houseowner_status']) == "1"): ?>class="hmain6_ul hidden"<?php else: ?> class="hmain3_ul hidden"<?php endif; ?>>
                <li <?php if(($user['houseowner_status']) == "1"): if(($current_url) == "Home/Member/detail"): ?>class="hmain6_li"<?php endif; else: ?> <?php if(($current_url) == "Home/Member/detail"): ?>class="hmain3_li"<?php endif; endif; ?>>
                    <a href="<?php echo U('Home/Member/detail',array('uid'=>$data['id']));?>">Ta的主页</a>
                </li>
                <li class="">
                    |
                </li>
                <li <?php if(($user['houseowner_status']) == "1"): if(($current_url) == "Home/Member/note"): ?>class="hmain6_li"<?php endif; else: ?> <?php if(($current_url) == "Home/Member/note"): ?>class="hmain3_li"<?php endif; endif; ?>>
                    <a href="<?php echo U('Home/Member/note',array('uid'=>$data['id']));?>">Ta的游记</a>
                </li>
                <?php if(($user['houseowner_status']) == "1"): ?><li class="">
	                    |
	                </li>
                	<li <?php if(($user['houseowner_status']) == "1"): if(($current_url) == "Home/Member/party"): ?>class="hmain6_li"<?php endif; else: ?> <?php if(($current_url) == "Home/Member/party"): ?>class="hmain3_li"<?php endif; endif; ?>>
	                    <a href="<?php echo U('Home/Member/party',array('uid'=>$data['id']));?>">Ta的活动</a>
	                </li>
	                <li class="">
	                    |
	                </li>
	                <li <?php if(($user['houseowner_status']) == "1"): if(($current_url) == "Home/Member/hostel"): ?>class="hmain6_li"<?php endif; else: ?> <?php if(($current_url) == "Home/Member/hostel"): ?>class="hmain3_li"<?php endif; endif; ?>>
	                    <a href="<?php echo U('Home/Member/hostel',array('uid'=>$data['id']));?>">Ta的美宿</a>
	                </li><?php endif; ?>
                <li class="">
                    |
                </li>
                <li <?php if(($user['houseowner_status']) == "1"): if(($current_url) == "Home/Member/review"): ?>class="hmain6_li"<?php endif; else: ?> <?php if(($current_url) == "Home/Member/review"): ?>class="hmain3_li"<?php endif; endif; ?>>
                    <a href="<?php echo U('Home/Member/review',array('uid'=>$data['id']));?>">Ta的评论</a>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".hmain3_ul li:even").css({
                "width":"410px",
                "text-align":"center"
            })
            $(".hmain3_ul li").first().css({
                "margin-left": "0px"
            })
            $(".hmain3_ul li").last().css({
                "margin-right": "0px"
            })
            $(".hmain6_ul li:even").css({
                "padding-right": "109px",
                "padding-left":"109px"
            })
            $(".hmain6_ul li").first().css({
                "padding-left": "0px"
            })
            $(".hmain6_ul li").last().css({
                "padding-right": "0px"
            })
            $("#attention").click(function(){
                var tuid="<?php echo ($data["id"]); ?>";
                $.ajax({
                     type: "POST",
                     url: "<?php echo U('Home/Member/ajax_attention');?>",
                     data: {'tuid':tuid},
                     dataType: "json",
                     success: function(data){
                        alert(data.msg)
                        if(data.code==200){
                            $("#attention").toggleClass("hmain_chang");
                            $("#fansnum").text(data.fansnum);
                        }
                     }
                })  
            })
        })
    </script>
    <div class="hmain4">
        <div class="wrap hmain5 hidden">
            <div class="fl hmain5_l">
                <div class="hmain5_l1">
                    <div class="hmain5_l2 hidden">
                        <div class="fl hmain5_l3">
                            <p id="attentionnum"><?php echo ((isset($data["attentionnum"]) && ($data["attentionnum"] !== ""))?($data["attentionnum"]):"0"); ?></p>
                            <span>关注</span>
                        </div>
                        <div class="fl hmain5_l3">
                            <p id="fansnum"><?php echo ((isset($data["fansnum"]) && ($data["fansnum"] !== ""))?($data["fansnum"]):"0"); ?></p>
                            <span>粉丝</span>
                        </div>
                    </div>
                    <div class="hmain5_l4">
                        <div class="hmain5_l401">
                            <span>注册时间：</span>
                            <i><?php echo (date("Y-m-d",$data["reg_time"])); ?></i>
                        </div>
                        <div class="hmain5_l401">
                            <span>最后登录：</span>
                            <i>
                                <?php if(!empty($data['lastlogin_time'])): echo (date("Y-m-d",$data["lastlogin_time"])); ?>
                                    <?php else: ?>
                                    尚未登录<?php endif; ?>
                            </i>
                        </div>
                    </div>
                    <?php if(($data['houseowner_status']) == "1"): ?><div class="hmain5_l5">
                            <span>Ta的美宿：</span>
                            <i><?php echo str_cut($hostel[0]['title'],10);?></i><label>（<?php echo ((isset($hostel["0"]["roomnum"]) && ($hostel["0"]["roomnum"] !== ""))?($hostel["0"]["roomnum"]):"0"); ?>间房）</label>
                        </div>
                        <a href="<?php echo U('Home/Member/hostel');?>">查看更多房东信息</a><?php endif; ?>
                </div>
                <div class="hmain5_l6 hidden">
                    <span>今日访问</span>
                    <ul class="hmain5_l6_ul hidden">
                        <?php if(is_array($data['viewlist'])): $i = 0; $__LIST__ = $data['viewlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="fl">
                                <a href="<?php echo U('Home/Member/detail',array('uid'=>$vo['uid']));?>">
                                    <img src="<?php echo ($vo["head"]); ?>" style="width:58px;height:58px;    border-radius: 50%;"/>
                                    <i><?php echo ($vo["nickname"]); ?></i>
                                </a>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>

                    <div class="hmain5_l6_2">
                        <p>累计访问：<em><?php echo ((isset($data["viewnum"]) && ($data["viewnum"] !== ""))?($data["viewnum"]):"0"); ?></em></p>
                        <p>今日访问：<em><?php echo ((isset($data["todayviewnum"]) && ($data["todayviewnum"] !== ""))?($data["todayviewnum"]):"0"); ?></em></p>
                    </div>
                </div>
                <div class="hmain5_l7">
                    <span>Ta住过的美宿</span>
                    <i>( <?php echo ((isset($myhostelnum) && ($myhostelnum !== ""))?($myhostelnum):"0"); ?> )</i>
                    <ul class="hmain5_l7_ul">
                        <?php if(is_array($myhostel)): $i = 0; $__LIST__ = $myhostel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <div class="hmain5_l7_ul1 hidden">
                                    <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>">
                                        <div class="fl hmain5_l7_ul2">
                                            <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:83px;height:52px" />
                                        </div>
                                        <div class="fl hmain5_l7_ul3">
                                            <span><?php echo ($vo["title"]); ?></span>
                                            <i>入住时间：<em><?php echo (date("Y-m-d",$vo["starttime"])); ?></em></i>
                                        </div>
                                    </a>
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                   <!--  <a href="">
                        查看更多
                    </a> -->
                </div>
                <div class="hmain5_l7">
                    <span>Ta参加过的活动</span>
                    <i>( <?php echo ((isset($mypartynum) && ($mypartynum !== ""))?($mypartynum):"0"); ?> )</i>
                    <ul class="hmain5_l7_ul">
                        <?php if(is_array($myparty)): $i = 0; $__LIST__ = $myparty;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                <div class="hmain5_l7_ul1 hidden">
                                    <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>">
                                        <div class="fl hmain5_l7_ul2">
                                            <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg"  style="width:83px;height:52px" />
                                        </div>
                                        <div class="fl hmain5_l7_ul3">
                                            <span><?php echo str_cut($vo['title'],15);?></span>
                                            <i>活动时间：<em><?php echo (date("Y-m-d",$vo["starttime"])); ?></em></i>
                                        </div>
                                    </a>
                                </div>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <!-- <a href="">
                        查看更多
                    </a> -->
                </div>
            </div>
            <div class="fl hmain5_r">
            	<?php if(($user['houseowner_status']) == "1"): ?><div class="hmain5_r1">
	                    <ul>
	                        <li>
	                            <div class="hmain5_r1_top">
	                                <span>Ta的美宿</span>
	                            </div>
                                <?php if(is_array($hostel)): $i = 0; $__LIST__ = $hostel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="hmain5_r1_bottom hidden">
    	                                <div class="fl hmain5_r1_bottom01 pr">
    	                                    <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>">
    	                                        <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:245px;height:153px" />
    	                                    </a>
    	                                    <div class="main4_bottom_list2 pa">
    	                                        <img src="/Public/Home/images/Icon/img8.png" />
    	                                    </div>
    	                                </div>
    	                                <div class="fl hmain5_r1_bottom02">
    	                                    <div class="hmain5_r2 hidden">
    	                                        <div class="fl">
    	                                            <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a><i><?php echo ((isset($vo["evaluation"]) && ($vo["evaluation"] !== ""))?($vo["evaluation"]):"0.0"); ?><em>分</em></i>
    	                                        </div>
    	                                        <div class="fr hmain5_r2r">
    	                                            <label><em>￥</em><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.00"); ?><em>起</em></label>
    	                                        </div>
    	                                    </div>
    	                                    <div class="hmain5_r3">
    	                                        <p><?php echo ($vo["description"]); ?></p>
    	                                    </div>
    	                                    <div class="hmain5_r4">
    	                                        <div class="fl">
    	                                            <span>房间 :</span><i><?php echo ((isset($vo["roomnum"]) && ($vo["roomnum"] !== ""))?($vo["roomnum"]):"0"); ?>间</i>
    	                                        </div>
    	                                        <div class="fr hidden">
    	                                            <div class="fl">
    	                                                <img src="/Public/Home/images/Icon/img10.png" />
    	                                                <label><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></label><label>条点评</label>
    	                                            </div>
    	                                            <div class="fl hmain5_r4_01">
    	                                                <img src="/Public/Home/images/Icon/img9.png" />
    	                                                <label><?php echo ((isset($vo["hit"]) && ($vo["hit"] !== ""))?($vo["hit"]):"0"); ?></label>
    	                                            </div>
    	                                        </div>
    	                                    </div>
    	                                </div>
    	                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
	                        </li>
	                    </ul>
                        <a style="display: block;font-size: 16px;color: #999999;text-align: center;border: 1px solid #d1d1d1;line-height: 50px;height: 50px;" href="<?php echo U('Home/Member/hostel',array('uid'=>$data['id']));?>">点击查看更多</a>
	                </div><?php endif; ?>
                <div class="hmain5_r5">
                    <div>
                        <div class="hmain5_r5_top">
                            <span>Ta的游记</span>
                        </div>
                        <ul class="hmain5_r5_ul">
                            <?php if(is_array($note)): $i = 0; $__LIST__ = $note;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
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
                        <a href="<?php echo U('Home/Member/note',array('uid'=>$data['id']));?>">点击查看更多</a>
                    </div>
                </div>
                <div class="hmain5_r6">
                    <div>
                        <div class="hmain5_r6_1">
                            <span>Ta的评论</span>
                        </div>
                        <ul class="hmain5_r6_ul">
                            <?php if(is_array($review)): $i = 0; $__LIST__ = $review;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo['varname']) == "note"): ?><li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],20);?></a><span class="hmain5_r6_ul1_a">游记</span>
                                            </div>
                                            <p><?php echo ($vo["content"]); ?></p>
                                            <span>发表于 <em><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?></em></span>
                                        </div>
                                    </li><?php endif; ?>
                                <?php if(($vo['varname']) == "party"): ?><li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],20);?></a><span class="hmain5_r6_ul1_a2">活动</span>
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
                                                <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>"><?php echo str_cut($vo['title'],20);?></a><span class="hmain5_r6_ul1_a3">行程</span>
                                            </div>
                                            <p><?php echo ($vo["content"]); ?></p>
                                            <span>发表于 <em><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?></em></span>
                                        </div>
                                    </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>  
                        </ul>

                        <a href="<?php echo U('Home/Member/review',array('uid'=>$data['id']));?>">点击查看更多</a>

                    </div>
                </div>

                <div class="hmain5_r7">
                    <div>
                        <div class="hmain5_r5_top">
                            <span>Ta的行程</span>
                        </div>
                        <ul class="hmain5_r7_ul">
                            <?php if(is_array($trip)): $i = 0; $__LIST__ = $trip;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                                    <div class="hmain5_r7_ul1">
                                        <a href="<?php echo U('Home/Trip/show',array('id'=>$vo['id']));?>">
                                            <div>
                                                <span><?php echo ($vo["title"]); ?></span><?php if(($vo['status']) == ""): ?><label class="hmain5_r7_ul1a">已完成</label><?php else: ?><label class="hmain5_r7_ul1a2">进行中</label><?php endif; ?>
                                            </div>
                                            <i>时间 :<em class="f14 c333"><?php echo (date("Y年m月d日",$vo["starttime"])); ?> - <?php echo (date("Y年m月d日",$vo["endtime"])); ?></em></i>
                                        </a>
                                    </div>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".hmain5_l6_2 p").last().css({
                "border-top": "0px"
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