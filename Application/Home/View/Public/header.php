<div class="wrap main_top">
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
            url: "{:U('Home/Public/getareachildren')}",
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
    <div class="middle main_top1">
        <a href="/" ><img src="__IMG__/logo.png" /></a>
        <div class="main_top2 pr">
            <div class="main3_05 hidden">
                <input type="hidden" name="arrparentid" id="arrparentid" value="{$arrparentid}">
                <span class="main3_03span position">{$cityname|default="请选择"}</span>
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
            <li <eq name="controller_url" value="Home/Index">class="fl main_top3_chang2" <else />class="fl" </eq>>
                <a href="/">首页</a>
            </li>
            <li class="fl">|</li>
            <li <eq name="controller_url" value="Home/Note">class="fl main_top3_chang2" <else />class="fl" </eq>>
                <a href="{:U('Home/Note/index')}">游记</a>
            </li>
            <li class="fl">|</li>
            <li <eq name="controller_url" value="Home/Party">class="fl main_top3_chang2" <else />class="fl" </eq>>
                <a href="{:U('Home/Party/index')}">活动</a>
            </li>
            <li class="fl">|</li>
            <li <if condition="$controller_url eq 'Home/Hostel' or $controller_url eq 'Home/Room'">class="fl main_top3_chang2" <else />class="fl" </if>>
            <a href="{:U('Home/Hostel/index')}">美宿</a>
        </li>
            <li class="fl">|</li>
            <li <eq name="controller_url" value="Home/Trip">class="fl main_top3_chang2" <else />class="fl" </eq>>
                <a href="{:U('Home/Trip/index')}">行程</a>
            </li>
            <li class="fl">|</li>
            <li <eq name="controller_url" value="Home/Woniu">class="fl main_top3_chang2" <else />class="fl" </eq>>
                <a href="{:U('Home/Woniu/index')}">蜗牛</a>
            </li>
            <li class="fl">|</li>
            <li <eq name="current_url" value="Home/About/app">class="fl main_top3_chang2" <else />class="fl" </eq>>
                <a href="{:U('Home/About/app')}">APP下载</a>
            </li>
        </ul>
    </div>
    <notempty name="user">
    <div class="middle hmain_top4 clearfix">
        <div class="hmain_top4_01 fl pr">
            <span>消息</span>
            <img class="hide" src="__IMG__/Icon/img45.png" />
            <div class="hide pa hmain_top4_04">
                <div class="hmain_top4_04_01">
                    <ul class="hmain_top4_04_01_ul" style="box-shadow: 0 0 10px #999;">
                        <li>
                            <a href="{:U('Home/Woniu/chatdetail')}">
                                <img src="__IMG__/Icon/img47.png" />
                                <span class="f14 c666">私信  <em class="f12 waitletternum">({$waitletternum|default="0"})</em></span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Woniu/message')}">
                                <img src="__IMG__/Icon/img48.png" />
                                <span class="f14 c666">我的消息  <em class="f12">({$waitmessagenum|default="0"})</em></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="hmain_top4_02 fl pr">
            <div class="hmain_top4_02_img">
                <a href="{:U('Home/Member/index')}"><img src="{$user.head|default='/default_head.png'}"  width="36px" height="36px"/></a>
                <div class="hmain_top4_02_img2 pa hide">
                    <ul class="hmain_top4_02_img2_ul">
                        <li>
                            <a href="{:U('Home/Note/add')}">
                                <img src="__IMG__/Icon/img49.png" />
                                <span>写游记</span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Woniu/index')}">
                                <img src="__IMG__/Icon/img50.png" />
                                <span>我的好友</span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Member/mycollect')}">
                                <img src="__IMG__/Icon/img51.png" />
                                <span>我的收藏</span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Member/myorder_hostel')}">
                                <img src="__IMG__/Icon/img52.png" />
                                <span>我的订单</span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Member/mycoupons')}">
                                <img src="__IMG__/Icon/img53.png" />
                                <span>我的优惠券</span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Member/help')}">
                                <img src="__IMG__/Icon/img54.png" />
                                <span>帮助中心</span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Member/change_info')}">
                                <img src="__IMG__/Icon/img55.png" />
                                <span>设置</span>
                            </a>
                        </li>
                        <li>
                            <a href="{:U('Home/Member/loginout')}">
                                <img src="__IMG__/Icon/img56.png" />
                                <span>退出</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <else />
    <div class="middle main_top4">
        <div class="main_top4_01 middle">
            <a id="weibologin" onclick="toSinaLogin();" href="javascript:;">
                <img src="__IMG__/Icon/share1.png" />
            </a>
            <a id="qqlogin" onclick="toQzoneLogin();" href="javascript:;">
                <img src="__IMG__/Icon/share2.png" />
            </a>
            <a id="weixinlogin" onclick="toWeixinLogin();" href="javascript:;">
                <img src="__IMG__/Icon/share3.png" />
            </a>
        </div>
        <div class="main_top4_02 middle">
            <ul class="main_top4_02_ul">
                <li class="fl">
                    <a href="{:U('Home/Member/login')}">登录</a>
                </li>
                <li class="fl">|</li>
                <li class="fl">
                    <a href="{:U('Home/Member/reg')}">注册</a>
                </li>
            </ul>
        </div>
    </div>
</notempty>
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
        $.post("{:U('Home/Public/ajax_getcity')}",p,function(d){
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
});
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