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
    <script src="/Public/Home/js/jquery.jqtransform.js"></script>
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
                <li <?php if(($controller_url) == "Home/About"): ?>class="fl main_top3_chang2" <?php else: ?>class="fl"<?php endif; ?>>
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
            <a href="<?php echo U('Home/Party/index');?>">活动</a>
            <span>></span>
            <a href="<?php echo U('Home/Party/show',array('id'=>$data['id']));?>">活动详细</a>
        </div>
        <div class="Event_details hidden">
            <div class="middle Event_details2">
                <span><?php echo str_cut($data['title'],12);?></span>
                <div class="hidden Event_details2_01">
                    <div class="fl Event_details2_02">
                        <img src="/Public/Home/images/Icon/img10.png" />
                        <span>
                            <em><?php echo ((isset($data["reviewnum"]) && ($data["reviewnum"] !== ""))?($data["reviewnum"]):"0"); ?></em>条评论
                        </span>
                    </div>
                    <div class="fl Event_details2_03">
                        <?php if(($data['ishit']) == "1"): ?><img src="/Public/Home/images/dianzan.png" class="zanbg1" data-id="<?php echo ($data["id"]); ?>"/>
                            <?php else: ?>
                            <img src="/Public/Home/images/Icon/img9.png" class="zanbg1" data-id="<?php echo ($data["id"]); ?>"/><?php endif; ?>
                        <span class="zannum"><?php echo ((isset($data["hit"]) && ($data["hit"] !== ""))?($data["hit"]):"0"); ?></span>
                    </div>
                    <div class="fl Event_details2_04">
                        <span><?php echo (date("Y-m-d H:i",$data["inputtime"])); ?> </span>
                    </div>
                    <div class="fl Event_details2_05">
                        <span>浏览：<em><?php echo ((isset($data["view"]) && ($data["view"] !== ""))?($data["view"]):"0"); ?></em></span>
                    </div>
                </div>
            </div>
            <div class="middle Event_detail3 hidden">
                <div class="Event_detail3_01 fl">
                    <a href=""><img src="/Public/Home/images/Icon/img24.png" /></a>
                </div>
                <div class="Event_detail3_02 fl">
                    <a href="javascript:;">
                        <?php if(($data['iscollect']) == "1"): ?><img src="/Public/Home/images/Icon/img25.png" class="shoucang" data-id="<?php echo ($data["id"]); ?>"/>
                            <?php else: ?>
                            <img src="/Public/Home/images/shoucang.png"  class="shoucang" data-id="<?php echo ($data["id"]); ?>"/><?php endif; ?>
                        收藏
                    </a>
                </div>
                <div class="Event_detail3_03 fl">
                    <a href="javascript:;"  class="travels2_bottom3">
                        <img src="/Public/Home/images/Icon/img26.png" />
                        添加到行程
                    </a>
                </div>
            </div>
            <div class="middle Event_details4">
                <span><?php if(($data['isfree']) == "1"): ?><em>免费</em><?php else: ?><em><?php echo ((isset($data["money"]) && ($data["money"] !== ""))?($data["money"]):"0.00"); ?></em>元<?php endif; ?></span>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="Event_details5 hidden">
            <div class="fl Event_details5_1">
                <div class="Event_details5_1_01 hidden">
                    <div class="Event_details5_1_02_01">
                        <img src="/Public/Home/images/Icon/img30.png" />
                        <span>活动时间 :</span>
                        <i><?php echo (date("Y-m-d",$data["starttime"])); ?> 至<?php echo (date("Y-m-d",$data["endtime"])); ?></i>
                    </div>
                    <div class="Event_details5_1_02_01">
                        <span>活动费用 :</span>
                        <i>￥<?php echo ((isset($data["money"]) && ($data["money"] !== ""))?($data["money"]):"0.00"); ?>/ 人</i>
                    </div>
                    <div class="Event_details5_1_02_04">
                        <span>活动特色 : </span>
                        <i><?php echo ($data["catname"]); ?></i>
                    </div>
                    <div class="fl hidden">
                        <div class="Event_details5_1_02_01">
                            <span>活动类型 : </span>
                            <i>
                                <?php if(($data['partytype']) == "1"): ?>亲子类<?php endif; ?>
                                <?php if(($data['partytype']) == "2"): ?>情侣类<?php endif; ?>
                                <?php if(($data['partytype']) == "3"): ?>家庭出游<?php endif; ?>
                            </i>
                        </div>
                        <div class="Event_details5_1_02_02">
                            <img src="/Public/Home/images/Icon/img29.png" />
                            <span>活动地址 : </span>
                            <i>
                                <?php echo getarea($data['area']); echo ($data["address"]); ?>
                            </i>
                        </div>
                    </div>
                </div>
                <div class="Event_details5_3">
                    <span>活动介绍</span>
                    <?php echo ($data["content"]); ?>
                </div>
                <div class="Event_details5_4 reviewlist">
                    
                </div>
                <div class="Event_details6">
                    <div class="Event_details6_01">
                        <a href="<?php echo U('Home/Member/detail',array('uid'=>$user['id']));?>">
                            <img src="<?php echo ((isset($user["head"]) && ($user["head"] !== ""))?($user["head"]):'/default_head.png'); ?>" style="width:58px;height:58px" />
                        </a>
                        <span id="reviewtitle">评论活动</span>
                    </div>
                    <div class="Event_details6_02">
                        <div class="Event_details6_03">
                            <!-- <span class="f14 c999">回复 XXX：</span> -->
                            <textarea name="content"></textarea>
                        </div>
                        <!-- <div class="Event_details6_04 ">
                            <img class="middle" src="/Public/Home/images/Icon/img32.png" />
                            <img src="/Public/Home/images/Icon/img31.png" />
                        </div> -->
                    </div>
                    <div class="Event_details6_05">
                        <input type="hidden" name="rid" value="">
                        <input type="hidden" name="type" value="review">
                        <a href="javascript:;" id="addreview">发表评论</a>
                    </div>
                </div>
                <script>
                $(function(){
                    var aid="<?php echo ($data["id"]); ?>";
                    var geturl = "<?php echo U('Home/Party/get_review');?>";
                    var p={"isAjax":1,"aid":aid};
                    $.get(geturl,p,function(d){
                        $(".reviewlist").html(d.html);
                    });
                    $('.ajaxpagebar a').live("click",function(){
                        try{    
                            var geturl = $(this).attr('href');
                            $.get(geturl,p,function(d){
                                $(".reviewlist").html(d.html);
                            });
                        }catch(e){};
                        return false;
                    })
                    $("#addreview").click(function(){
                        var uid="<?php echo ($user["id"]); ?>";
                        if(uid==''){
                            alert("请先登录！");
                            var loginp={};
                            loginp['url']="/index.php/Home/Party/show/id/43.html";
                            $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",loginp,function(data){
                                if(data.code=200){
                                    window.location.href="<?php echo U('Home/Member/login');?>";
                                }
                            })
                            return false;
                        }
                        var content=$("textarea[name='content']").val();
                        if(content==''){
                            alert("评论内容不能为空！");
                            return false;
                        }
                        var type=$("input[name='type']").val();
                        var rid=$("input[name='rid']").val();
                        if(rid!=''){
                            if(type=='reply'){
                                $.post("<?php echo U('Home/Party/add_reviewreply');?>",{"aid":aid,"rid":rid,"content":content,"uid":uid},function(d){
                                    d=eval("("+d+")");
                                    if(d.code==200){
                                        $.get(geturl,p,function(d){
                                            $(".reviewlist").html(d.html);
                                        });
                                        alert(d.msg)
                                        $("input[name='type']").val("review");
                                        $("input[name='rid']").val("");
                                        $("#addreview").text("发表评论");
                                        $("#reviewtitle").text("评论活动");
                                        $("textarea[name='content']").val("");
                                    }else{
                                        alert(d.msg);
                                    }
                                });
                            }else if(type=='quote'){
                                $.post("<?php echo U('Home/Party/add_reviewquote');?>",{"aid":aid,"rid":rid,"content":content,"uid":uid},function(d){
                                    d=eval("("+d+")");
                                    if(d.code==200){
                                        $.get(geturl,p,function(d){
                                            $(".reviewlist").html(d.html);
                                        });
                                        alert(d.msg)
                                        $("input[name='type']").val("review");
                                        $("input[name='rid']").val("");
                                        $("#addreview").text("发表评论");
                                        $("#reviewtitle").text("评论游记");
                                        $("textarea[name='content']").val("");
                                    }else{
                                        alert(d.msg);
                                    }
                                });
                            }
                            
                        }else{
                            $.post("<?php echo U('Home/Party/add_review');?>",{"aid":aid,"content":content,"uid":uid},function(d){
                                d=eval("("+d+")");
                                if(d.code==200){
                                    $.get(geturl,p,function(d){
                                        $(".reviewlist").html(d.html);
                                    });
                                    alert(d.msg)
                                    $("textarea[name='content']").val("");
                                }else{
                                    alert(d.msg);
                                }
                            });
                        }
                        
                    })
                    $(".reply").live("click",function(){
                        var obj=$(this);
                        var rid=obj.data("id");
                        $("input[name='rid']").val(rid);
                        $("input[name='type']").val("reply");
                        var nickname=obj.data("rname");
                        $("#addreview").text("发表回复");
                        $("#reviewtitle").text("回复评论");
                        $("textarea[name='content']").val("回复 "+nickname+"：");
                    })
                    $(".quote").live("click",function(){
                        var obj=$(this);
                        var rid=obj.data("id");
                        $("input[name='rid']").val(rid);
                        $("input[name='type']").val("quote");
                        var nickname=obj.data("rname");
                        $("textarea[name='content']").val("引用 "+nickname+"：");
                    })
                    $(".report").live("click",function(){
                        var obj=$(this);
                        var rid=obj.data("id");
                        $("input[name='reportid']").val(rid);
                    })
                })
                </script>
            </div>
            <div class="fl Event_details5_2">
                <div class="Event_details5_2_01">
                    <span>活动发起人</span>
                    <div class="Event_details5_2_05">
                        <a href="">
                            <div class="Event_details5_2_02">
                                <img src="<?php echo ($data["head"]); ?>" width="104px" height="104px"/>
                            </div>
                            <i><?php echo ($data["nickname"]); ?></i>
                        </a>
                    </div>
                    <div class="Event_details5_2_03 hidden">
                        <div class="fl Event_details5_2_04">
                            <label>
                                <?php if(($data['realname_status']) == "1"): ?><img src="/Public/Home/images/Icon/img27.png" />
                                    <?php else: ?>
                                    <img src="/Public/Home/images/Icon/img27_1.png" /><?php endif; ?>
                                实名认证
                            </label>
                        </div>
                        <div class="Event_details5_2_04 fl">
                            <label>
                                <?php if(($data['houseowner_status']) == "1"): ?><img src="/Public/Home/images/Icon/img28.png" />
                                    <?php else: ?>
                                    <img src="/Public/Home/images/Icon/img28_1.png" /><?php endif; ?>
                                个人房东
                            </label>
                        </div>
                    </div>
                    <?php if($data['endtime'] <= time()): ?><a class="a1" href="javascript:;">已过期</a>
                    <?php elseif($data['end_numlimit'] <= $data['joinnum']): ?>
                        <a class="a1" href="javascript:;">报名人数已满</a>
                    <?php else: ?>
                        <a class="a1" href="<?php echo U('Home/Order/joinparty',array('aid'=>$data['id']));?>">我要报名</a><?php endif; ?>
                    
                    <a class="a2" href="<?php echo U('Home/Woniu/chatdetail',array('tuid'=>$data['uid']));?>">在线咨询</a>
                </div>
            </div>
        </div>
    </div>
    <div class="My_message_details_main2 hide">
        <div class="My_message_details_main3">
        </div>
        <div class="My_message_details_main4">
            <div class="My_message_details_m4top">
                <span>请输入举报的理由</span>
                <div class="My_message_details_m4topf"></div>
            </div>
            <div class="My_message_details_m4bottom">
                <span>举报理由 :</span>
                <textarea name="reportreason"></textarea>
                <input type="hidden" name="reportid" value="">
                <input type="button" id="reportsave" value="确定提交" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Event_details5_6_list3_03").live("click",function () {
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
                $("textarea[name='reportreason']").val("");
            })
            $("#reportsave").live("click",function(){
                var uid="<?php echo ($user["id"]); ?>";
                if(uid==''){
                    alert("请先登录！");var p={};
                    p['url']="/index.php/Home/Party/show/id/43.html";
                    $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                        if(data.code=200){
                            window.location.href="<?php echo U('Home/Member/login');?>";
                        }
                    })
                    return false;
                }
                var reportreason=$("textarea[name='reportreason']").val();
                if(reportreason==''){
                    alert("举报理由不能为空！");
                    return false;
                }
                var rid=$("input[name='reportid']").val();
                $.post("<?php echo U('Home/Party/add_report');?>",{"rid":rid,"content":reportreason,"uid":uid},function(d){
                    d=eval("("+d+")");
                    if(d.code==200){
                        alert(d.msg)
                        $(".My_message_details_main2").hide();
                        $("html,body").css({
                            "overflow-y": "auto",
                        })
                        $("textarea[name='reportreason']").val("");
                    }else{
                        alert(d.msg);
                    }
                });
            })
        })
    </script>
    <div class="Mask3 hide">
    </div>
    <div class="wrap">
        <div class="Event_details7">
            <span>周边美宿推荐</span>
            <div class="Event_details8 hidden">
                <ul class="Event_details8_ul clearfix">
                    <?php if(is_array($data['party_near_hostel'])): $i = 0; $__LIST__ = $data['party_near_hostel'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="fl">
                            <div class="Event_details8_li">
                                <div class="Event_details8_list">
                                    <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>" class="Event_details8_a">
                                        <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg">
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
                    <?php if(is_array($data['party_near_activity'])): $i = 0; $__LIST__ = $data['party_near_activity'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="fl">
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
                alert("请先登录！");
                var p={};
                p['url']="/index.php/Home/Party/show/id/43.html";
                $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                    if(data.code=200){
                        window.location.href="<?php echo U('Home/Member/login');?>";
                    }
                })
                return false;
            }
            if(uid=="<?php echo ($data["uid"]); ?>"){
                alert("不能选择自己发布的活动");
                return false;
            }
            var home_iscachetrip=$.cookie("home_iscachetrip");
            var hid="";
            if(home_iscachetrip){
                var p={};
                p['aid']="<?php echo ($data["id"]); ?>";
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
            p['aid']="<?php echo ($data["id"]); ?>";
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
                p['url']="/index.php/Home/Party/show/id/43.html";
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
                p['url']="/index.php/Home/Party/show/id/43.html";
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
                p['url']="/index.php/Home/Party/show/id/43.html";
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
                p['url']="/index.php/Home/Party/show/id/43.html";
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
                p['url']="/index.php/Home/Party/show/id/43.html";
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
                        <a href="" class="foot_a">
                            <img src="/Public/Home/images/Icon/img12.png" />
                            IOS
                        </a>
                        <a href="">
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