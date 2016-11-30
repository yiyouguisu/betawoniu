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

<link rel="stylesheet" type="text/css"  href="/Public/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="/Public/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="/Public/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
    $(function(){
        $(".upload").each(function(){
            inituploadify($(this));
        })
    })
   function inituploadify(a){
    a.uploadify({
        'uploader'  : '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
        'cancelImg' : '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
        //'script' : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
        'script'    : "<?php echo U('Admin/Public/uploadone');?>",//实现上传的程序
        'method'    : 'post',
        'auto'      : true,//自动上传
        'multi'     : false,//是否多文件上传
        'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
        'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
        'sizeLimit': '',//限制上传文件的大小2m(比特b)
        'queueSizeLimit' :10, //可上传的文件个数
        'buttonImg' : '/Public/Public/uploadify/add.gif',//替换上传钮扣
        'width'     : 80,//buttonImg的大小
        'height'    : 26,
        onComplete: function (evt, queueID, fileObj, response, data) {
            var obj="#"+$(evt.currentTarget).attr("data-id");
            $(obj).val(response);
        }
    });
   }
   </script>
<script src="/Public/Home/js/chosen.jquery.js"></script>
<link href="/Public/Home/css/chosen.css" rel="stylesheet" />
<script src="/Public/Home/js/jquery-ui.min.js"></script>
<link href="/Public/Home/css/jquery-ui.min.css" rel="stylesheet" />
<script src="/Public/Home/js/WdatePicker.js"></script>
<script src="/Public/Home/js/work.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Editor/UEditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Editor/UEditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Editor/UEditor/lang/zh-cn/zh-cn.js"></script>

<style>
  .chosen-container{
    width: 150px;
      margin-right: 23px;
  }
  .delimglist{
    cursor: pointer;
    position: absolute;right: 0px;top: 0px;width: 40px;height: 23px;line-height: 23px; color: #000;font-size: 15px;text-align: center;opacity: 0.5;
  }
</style>
<script type="text/javascript">
                var areaurl = "<?php echo U('Home/Party/getchildren');?>";
                function load(parentid, type) {
                    $.ajax({
                        type: "GET",
                        url: areaurl,
                        data: { 'parentid': parentid },
                        dataType: "json",
                        success: function (data) {
                            if (type == 'city') {
                                $('#city').html('<option value="">选择市</option>');
                                $('#town').html('<option value="">选择区</option>');
                                if(data!=null){
                                    $.each(data, function (no, items) {
                                        if (items.id == "<?php echo ($_GET['city']); ?>") {
                                            $('#city').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                                        } else {
                                            $('#city').append('<option value="' + items.id + '">' + items.name + '</option>');
                                        }
                                    });
                                }
                                $('#city').trigger("chosen:updated");
                                $('#town').trigger("chosen:updated");
                            } else if (type == 'town') {
                                $('#town').html('<option value="">选择区</option>');
                                if(data!=null){
                                    $.each(data, function (no, items) {
                                        if (items.id == "<?php echo ($_GET['town']); ?>") {
                                            $('#town').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                                        } else {
                                            $('#town').append('<option value="' + items.id + '">' + items.name + '</option>');
                                        }
                                    });
                                }
                                
                                $('#town').trigger("chosen:updated");
                            }
                            
                            
                        }
                    });
                }
            </script>
    <script>
        $(function () {
            var url="<?php echo U('Home/Ueditor/index');?>";
            UE.getEditor('content',{
                serverUrl :url,
                UEDITOR_HOME_URL:'/Public/Editor/UEditor/',
            });
            UE.getEditor('roomcontent',{
                serverUrl :url,
                UEDITOR_HOME_URL:'/Public/Editor/UEditor/',
            });
            UE.getEditor('description',{
                serverUrl :url,
                UEDITOR_HOME_URL:'/Public/Editor/UEditor/',
            });
            // UE.getEditor('bookremark',{
            //     serverUrl :url,
            //     UEDITOR_HOME_URL:'/Public/Editor/UEditor/',
            // });
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 500,
                values: [75, 300],
                slide: function (event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });
            $("#amount").val("$" + $("#slider-range").slider("values", 0) +
              " - $" + $("#slider-range").slider("values", 1));
        });
    </script>
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

<form action="<?php echo U('Home/Hostel/add');?>" method="post">
    <div class="wrap">
        <div class="Legend_main3">
            <div class="Legend_main3_top">
                <a href="/">首页</a>
                <i>></i>
                <a href="<?php echo U('Home/Hostel/index');?>">美宿</a>
                <i>></i>
                <a href="<?php echo U('Home/Hostel/add');?>">发布美宿</a>
            </div>
            <div class="Release_of_legend_temporary">
                <div class="activity2_main">
                    <span>上传美宿缩略图</span>
                    <i>图片建议选择尺寸400像素 X 250像素 的图片</i>
                    <ul class="hidden activity2_main_ul">
                        <li class="fl">
                           <a href="javascript:;">
                               <input type="button" value="选择上传" id="uploadify">
                           </a>
                       </li>
                       <li class="fl thumb">
                           
                       </li>
                    </ul>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">美宿名称 :</span>
                    <input class="middle text4" style="width:670px;" type="text" name="title" value="" required/>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">适用景点 : </span>
                    <div class="activity2_main2_select middle">
                        <select name="place">
                            <option value="">请选择适用景点</option>
                            <?php if(is_array($place)): $i = 0; $__LIST__ = $place;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        <select>
                    </div>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">美宿地址 : </span>
                    <div class="middle activity2_main2_text3" style="width: 45%;">
                        <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" required name="province" id="province" onchange="load(this.value,'city')">
                            <option value="">选择省</option>
                            <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" required name="city" id="city" onchange="load(this.value,'town')">
                            <option value="">选择市</option>
                        </select>
                        <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" name="town" id="town">
                            <option value="">选择区</option>
                        </select>
                    </div>
                    <input type="text" name="address" class="activity2_main2_text5 middle" style="width:430px"/>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">美宿特色 : </span>
                    <div class="middle activity2_main2_text3">
                        <select class="sc-wd chosen-select-no-single" name="catid" required>
                            <option value="">请选择特色</option>
                            <?php if(is_array($hostelcate)): $i = 0; $__LIST__ = $hostelcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <span class="middle" style="margin-left: 140px;">美宿类型 : </span>
                    <div class="middle activity2_main2_text3">
                        <select class="sc-wd chosen-select-no-single" name="style" required>
                            <option value="">请选择类型</option>
                            <?php if(is_array($hosteltype)): $i = 0; $__LIST__ = $hosteltype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:20px;"></div>
                <div class="activity2_main">
                    <span>上传美宿展示图</span>
                    <i>图片建议选择尺寸730像素 X 415像素 的图片 (建议上传7张以上)</i>
                    <ul class="hidden activity2_main_ul imglist">
                        <li class="fl">
                           <a href="javascript:;">
                               <input type="button" value="选择上传" id="uploadify1">
                           </a>
                       </li>
                       
                    </ul>
                </div>
                <div style="border-bottom:1px solid #e3e3e3;"></div>
                <div class="Release_of_legend_main2">
                    <span>美宿描述 : </span>
                    <textarea name="description" id="description" style="width: 100%; height: 200px;"></textarea>
                </div>
                <!--8-9添加 begin-->
                <div class="Release_of_legend_x">
                    <span class="middle">促销活动 : </span>
                    <div class="middle Release_of_legend_y">
                        <span>美宿预定满</span>
                        <div>
                            <input type="text" name="vouchersrange" required />
                            <i>元</i>
                        </div>
                        <span>金额送</span>
                        <div>
                            <input type="text" name="vouchersdiscount" required/>
                            <i>元</i>
                        </div>
                        <span>金额的抵用券</span>
                    </div>
                </div>

                <!--end-->

                <div style="border-bottom:1px solid #e3e3e3;"></div>
                <div class="Release_of_legend_main2">
                    <span>退订提醒 : </span>
                    <textarea name="bookremark"  id="bookremark" style="width: 100%; height: 200px;"></textarea>
                </div>
                <div class="Release_of_legend_main3">
                    <div class="Release_of_legend_main3_top">
                        <span>添加房间 : </span>
                    </div>
                    <div class="Release_of_legend_main3_bottom">
                        <ul class="Release_of_legend_m3t_ul roomlist">
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Release_of_legend_m3t_ul li").last().css({
                "border-bottom":"0"
            });
            $(".Legend_main3_center_list li").click(function () {
                $(this).addClass("Legend_chang").siblings().removeClass("Legend_chang");
                $(this).parents("ul").siblings().find("li").removeClass("Legend_chang");
            })
            
            $(".chosen-select-no-single").chosen();
            $(".Legend_main3_center_list").last().css({
                "border-bottom":"0px"
            })
        })
    </script>
    <div class="wrap">
        <div class="Release_of_legend_m4">
            <div class="Release_of_legend_m4_top">
                <span>添加房间：</span>
            </div>
            <div class="activity2_main">
                <span>上传房间缩略图</span>
                <i>图片建议选择尺寸400像素 X 250像素 的图片</i>
                <ul class="hidden activity2_main_ul">
                    <li class="fl">
                       <a href="javascript:;">
                           <input type="button" value="选择上传" id="uploadify2">
                       </a>
                    </li>
                    <li class="fl rthumb">
                       
                    </li>
                </ul>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">房间名称 : </span>
                <input class="middle text4 room" style="width:503px; margin-right:140px;" type="text" name="roomtitle" id="roomtitle"  />

                <span class="middle">房间数量 : </span>
                <div class="middle activity2_main2_text2" style="margin-right:0px;">
                    <input type="text" class="room" value="" name="roommannum" id="roommannum" />
                    <i>间</i>
                </div>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">房间费用 : </span>
                <i class="f16 c666 middle">平时价格：</i>
                <div class="middle activity2_main2_text2">
                    <input type="text" class="room" value="" name="nomal_money" id="nomal_money" />
                    <i>元/间</i>
                </div>
                <i class="f16 c666 middle">周末价格：</i>
                <div class="middle activity2_main2_text2">
                    <input type="text"  class="room"value="" name="week_money" id="week_money" />
                    <i>元/间</i>
                </div>
                <i class="f16 c666 middle">节假日价格：</i>
                <div class="middle activity2_main2_text2" style="margin-right:0px;">
                    <input type="text" class="room" value="" name="holiday_money" id="holiday_money" />
                    <i>元/间</i>
                </div>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">房间面积 : </span>
                <div class="middle activity2_main2_text2">
                    <input type="text" class="room" value="" name="roomarea" id="roomarea" />
                    <i>m²</i>
                </div>
                <span class="middle">床型 : </span>
                <div class="middle activity2_main2_text3">
                    <select class="sc-wd chosen-select-no-single room" name="roomtype">
                        <option value="">请选择床型</option>
                        <?php if(is_array($bedcate)): $i = 0; $__LIST__ = $bedcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>

            <div style="margin-bottom:25px;"></div>
            <div class="activity2_main">
                <span>上传房间展示图</span>
                <i>图片建议选择尺寸730像素 X 415像素 的图片 (建议上传7张以上)</i>
                <ul class="hidden activity2_main_ul roomimglist">
                    <li class="fl uploadli">
                       <a href="javascript:;">
                           <input type="button" value="选择上传" id="uploadify3">
                       </a>
                    </li>
                </ul>
            </div>
            <div class="Release_of_legend_m4_list">
                <span>房间简介 : </span>
                <textarea class="room" name="roomcontent"  id="roomcontent"  style="width: 100%; height: 200px;"></textarea>
            </div>

            <div class="Release_of_legend_m4_list2">
                <div class="Release_of_legend_m4_list3">
                    <span>配套设施 : </span>
                    <i>( 可多选 )</i>
                    <label>其中 “ 特”为 重点推荐的配套设施，勾选后可重点在房间列表展示，最多可以选择三个</label>
                </div>
                <div class="Release_of_legend_m4_list4 hidden">
                    <ul class="Release_of_legend_m4_ul hidden">
                        <?php if(is_array($support)): $i = 0; $__LIST__ = $support;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="room support">
                                <div data-id="<?php echo ($vo["id"]); ?>" data-hot="<?php echo ($vo["ishot"]); ?>" class="Release_of_legend_a1 fl" style="background: url('<?php echo ($vo["gray_thumb"]); ?>') no-repeat 9px center;    background-size: 24px 24px;">
                                    <span><?php echo ($vo["catname"]); ?></span>
                                </div>
                                <i data-id="<?php echo ($vo["id"]); ?>" class="hotsupport Release_of_legend_a1_i fl">特</i>
                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>便利设施 : </span>
                    <input type="text" class="room" name="conveniences" id="conveniences" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>浴室 : </span>
                    <input type="text" class="room" name="bathroom" id="bathroom" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>媒体科技 : </span>
                    <input type="text" class="room" name="media" id="media" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>食品饮食 : </span>
                    <input type="text" class="room" name="food" id="food" />
                </div>
                <div class="Release_of_legend_m4_bottom2">
                    <input type="hidden" name="roomthumb" id="roomthumb" value=""/>
                    <input type="hidden" name="roomsupport" id="roomsupport" value=""/>
                    <input type="hidden" name="roomhotsupport" id="roomhotsupport" value=""/>
                    <input class="Release_of_legend_m4_sub addroom" type="button" value="发布房间" />
                    <input class="Release_of_legend_m4_reset" type="reset" value="重置" />
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var rid=0;
        $(function () {
            $(".Release_of_legend_a1_i").click(function(){
                if($(this).siblings(".Release_of_legend_m4_ul div").hasClass("Release_of_legend_m4_span")){
                    var hitnum=$(".Release_of_legend_a1_i2").length;
                    if(hitnum>=3&&!$(this).hasClass("Release_of_legend_a1_i2")){
                        alert("最多可以选择三个");
                        return false;
                    }else{
                        $(this).toggleClass("Release_of_legend_a1_i2");
                        aa();
                    }
                }
                
            })
            $(".Release_of_legend_m4_ul div").click(function () {
                $(this).toggleClass("Release_of_legend_m4_span")
                aa();
            })
            $(".delimglist").live("click",function(){
                if(confirm("确认删除吗？")){
                    $(this).parent("li").remove();
                }
            })
            $(".delroom").live("click",function(){
                var obj=$(this);
                if(confirm("确认删除吗？")){
                    var p={};
                    p['rid']=$(this).data("id");
                    $.post("<?php echo U('Home/Hostel/ajax_deleteroom');?>",p,function(d){
                        if(d.code==200){
                            obj.parents("li").remove();
                        }else{
                            alert(d.msg);
                            return false;
                        }
                    });
                    
                }
            })
            $(".editroom").live("click",function(){
                var obj=$(this);
                var p={};
                p['rid']=obj.data("id");
                $.post("<?php echo U('Home/Hostel/ajax_editroom');?>",p,function(d){
                    if(d.code==200){
                        $("input[name='roomtitle']").val(d.data.title);
                        $("input[name='roomthumb']").val(d.data.thumb);
                        $(".rthumb").html("<img src='"+d.data.thumb+"'/>");
                        $("input[name='roommannum']").val(d.data.mannum);
                        $("input[name='nomal_money']").val(d.data.nomal_money);
                        $("input[name='week_money']").val(d.data.week_money);
                        $("input[name='holiday_money']").val(d.data.holiday_money);
                        $("input[name='roomarea']").val(d.data.area);
                        $("select[name='roomtype']").val(d.data.roomtype);
                        $("textarea[name='roomcontent']").val(d.data.content);
                        UE.getEditor('roomcontent').setContent(d.data.content,false);
                        $("input[name='roomsupport']").val(d.data.support);
                        $("input[name='roomhotsupport']").val(d.data.hotsupport);
                        $("input[name='conveniences']").val(d.data.conveniences);
                        $("input[name='bathroom']").val(d.data.bathroom);
                        $("input[name='media']").val(d.data.media);
                        $("input[name='food']").val(d.data.food);
                        $.each(d.data.imglist,function(index,item){
                            $(".roomimglist").append("<li class=\"fl pr\"><img src='"+item+"'/><input type='hidden' name='roomimglist[]' value='"+item+"' /><input type=\"button\" class=\"delimglist\" value=\"删除\" ></li>");
                        })
                        $.each(d.data.support,function(index,item){
                            $(".support").each(function(){
                                if($(this).find("div").data("id")==item){
                                    $(this).find("div").addClass("Release_of_legend_m4_span");
                                }
                            })
                        })
                        $.each(d.data.hotsupport,function(index,item){
                            $(".support").each(function(){
                                if($(this).find(".hotsupport").data("id")==item){
                                    $(this).find(".hotsupport").addClass("Release_of_legend_a1_i2");
                                }
                            })
                        })
                        obj.parents("li").remove();
                        $("input[name='rid']").val(obj.data("id"));
                        $(".addroom").val("修改房间");
                    }else{
                        alert(d.msg);
                        return false;
                    }
                });
            })
            $(".addroom").click(function(){
                var title=$("input[name='roomtitle']").val();
                if(title==""){
                    alert("请填写房间标题");
                    return false;
                }
                var thumb=$("input[name='roomthumb']").val();
                if(title==""){
                    alert("请上传房间缩略图");
                    return false;
                }
                var mannum=$("input[name='roommannum']").val();
                if(title==""){
                    alert("请填写入住人数");
                    return false;
                }
                var nomal_money=$("input[name='nomal_money']").val();
                if(title==""){
                    alert("请填写房间平时价格");
                    return false;
                }
                var week_money=$("input[name='week_money']").val();
                if(title==""){
                    alert("请填写房间周末价格");
                    return false;
                }
                var holiday_money=$("input[name='holiday_money']").val();
                if(title==""){
                    alert("请填写房间节假日价格");
                    return false;
                }
                var area=$("input[name='roomarea']").val();
                if(title==""){
                    alert("请填写房间面积");
                    return false;
                }
                var roomtype=$("select[name='roomtype']").val();
                if(title==""){
                    alert("请选择房间床型");
                    return false;
                }
                var content=$("textarea[name='roomcontent']").val();
                var support=$("input[name='roomsupport']").val();
                var hotsupport=$("input[name='roomhotsupport']").val();
                var conveniences=$("input[name='conveniences']").val();
                var bathroom=$("input[name='bathroom']").val();
                var media=$("input[name='media']").val();
                var food=$("input[name='food']").val();
                var imglist="";
                $("input[name='roomimglist[]']").each(function(){
                    var img=$(this).val();
                    if(imglist==""){
                        imglist=img;
                    }else{
                        imglist+="|"+img;
                    }
                })
                var p={};
                p['rid']=rid;
                p['title']=title;
                p['thumb']=thumb;
                p['mannum']=mannum;
                p['nomal_money']=nomal_money;
                p['week_money']=week_money;
                p['holiday_money']=holiday_money;
                p['area']=area;
                p['roomtype']=roomtype;
                p['content']=content;
                p['support']=support;
                p['hotsupport']=hotsupport;
                p['conveniences']=conveniences;
                p['bathroom']=bathroom;
                p['media']=media;
                p['food']=food;
                p['imglist']=imglist;
                $.post("<?php echo U('Home/Hostel/ajax_cacheroom');?>",p,function(d){
                    if(d.code==200){
                        $(".roomlist").append(d.html);
                        $("input[name='roomtitle']").val("");
                        $("input[name='roomthumb']").val("");
                        $("input[name='roommannum']").val("");
                        $("input[name='nomal_money']").val("");
                        $("input[name='week_money']").val("");
                        $("input[name='holiday_money']").val("");
                        $("input[name='roomarea']").val("");
                        $("select[name='roomtype']").val("");
                        $("textarea[name='roomcontent']").val("");
                        UE.getEditor('roomcontent').setContent('',false);
                        $("input[name='roomsupport']").val();
                        $("input[name='roomhotsupport']").val();
                        $("input[name='conveniences']").val("");
                        $("input[name='bathroom']").val("");
                        $("input[name='media']").val("");
                        $("input[name='food']").val("");
                        $(".Release_of_legend_m4_ul div").removeClass("Release_of_legend_m4_span");
                        $(".Release_of_legend_a1_i").removeClass("Release_of_legend_a1_i2");
                        $(".rthumb").html("");
                        $(".uploadli").siblings().remove();
                        rid++;
                    }else{
                        alert(d.msg);
                        return false;
                    }
                });
            })
        })
        function aa(){
            var str="";
            $(".room .Release_of_legend_m4_span").each(function(index,item){
                var id=$(this).data("id");
                if(str==""){
                    str=id;
                }else{
                    str+=","+id;
                }
            })
            $("input[name='roomsupport']").val(str);
            var str="";
            $(".room .Release_of_legend_a1_i2").each(function(index,item){
                var id=$(this).data("id");
                if(str==""){
                    str=id;
                }else{
                    str+=","+id;
                }
            })
            $("input[name='roomhotsupport']").val(str);
        }
    </script>
    <div class="wrap">
        <div class="Release_of_legend_m5">
            <span>退订规则 : </span>
            <textarea name="content"  id="content" style="width: 100%; height: 200px;"></textarea>
            <input type="hidden" name="thumb" value="" />
            <input type="submit" value="发布美宿" />
        </div>
    </div>
</form>
<link rel="stylesheet" type="text/css" href="/Public/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="/Public/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="/Public/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#uploadify").uploadify({
                'uploader': '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "<?php echo U('Home/Public/uploadone');?>",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '/Public/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    data=eval("("+response+")");
                    if(data.status==1){
                        $(".thumb").html("<img src='"+data.msg+"'/>");
                        $("input[name='thumb']").val(data.msg);
                    }else{
                        alert(data.msg);
                    }
                    
                }
            });
            $("#uploadify1").uploadify({
                'uploader': '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "<?php echo U('Home/Public/uploadone');?>",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '/Public/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    data=eval("("+response+")");
                    if(data.status==1){
                        $(".imglist").append("<li class=\"fl pr\"><img src='"+data.msg+"'/><input type='hidden' name='imglist[]' value='"+data.msg+"' /><input type=\"button\" class=\"delimglist\" value=\"删除\" ></li>");
                    }else{
                        alert(data.msg);
                    }
                }
            });
            $("#uploadify2").uploadify({
                'uploader': '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "<?php echo U('Home/Public/uploadone');?>",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '/Public/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    data=eval("("+response+")");
                    if(data.status==1){
                        $(".rthumb").html("<img src='"+data.msg+"'/>");
                        $("input[name='roomthumb']").val(data.msg);
                    }else{
                        alert(data.msg);
                    }
                    
                }
            });
            $("#uploadify3").uploadify({
                'uploader': '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "<?php echo U('Home/Public/uploadone');?>",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '/Public/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    data=eval("("+response+")");
                    if(data.status==1){
                        $(".roomimglist").append("<li class=\"fl pr\"><img src='"+data.msg+"'/><input type='hidden' name='roomimglist[]' value='"+data.msg+"' /><input type=\"button\" class=\"delimglist\" value=\"删除\" ></li>");
                    }else{
                        alert(data.msg);
                    }
                }
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
<script src="https://cdn.ronghub.com/RongIMLib-2.2.4.min.js"></script>
<!-- <script src="http://cdn.ronghub.com/RongIMLib-2.1.3.min.js"></script>
 -->
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