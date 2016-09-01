<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <style>
        .ui-state-hover{
            background:#fefefe;
        }
    </style>
<include file="public:mheader" />
<div style="background:#efefef;" class="hidden">
        <div class="wrap">
            <div class="activity_main">
                <a href="/">首页</a>
                <span>></span>
                <a href="{:U('Home/Trip/index')}">行程</a>
                <span>></span>
                <a href="{:U('Home/Trip/add')}">定制行程</a>
            </div>
        </div>
    </div>

    <div class="wrap">
        <div class="">
            <div class="Custom_travel_m hidden">
                <div class="fl Custom_travel_m2">
                    <ul class="Custom_travel_m2_ul">
                        <li class="Custom_travel_m2_list">
                            <span>全部</span>
                            <i>ALL</i>
                        </li>
                        <volist name="data['dayarr']" id="vo">
                            <li data-day="{$vo['day']}">
                                <span>第{$vo['daytext']}天</span>
                                <i>DAY{$vo['day']}</i>
                            </li>
                        </volist>
                        <li class="addday">
                            <img src="__IMG__/Icon/img101.png" />
                            <p>新增</p>
                        </li>
                    </ul>
                </div>
                <div class="fl Custom_travel_m3">
                    <div class="Custom_travel_m4_top hidden">
                        <span>{$data.title}</span>
                        <p>{$data.starttime|date="Y年m月d日",###} 至 {$data.endtime|date="m月d日",###}</p>
                        <i>准备中</i>
                    </div>
                    <div class="Custom_travel_content" data-day="0">
                        <div class="Custom_travel_m4">
                            
                            <div class="Custom_travel_m4_bottom">
                                <notempty name="data['alltripinfo']">
                                    <volist name="data['alltripinfo']" id="vo">
                                        <div class="Custom_travel_m4_bottom1">
                                            <div class="Custom_travel_m4_bottom1_span">
                                                <span>{$vo.cityname}</span>
                                            </div>
                                            <ul class="Custom_travel_m4_bottom1_ul">
                                                <volist name="vo['event']" id="v">
                                                    <li data-city="{$vo.city}" data-place="{$v.place}" data-eventid="{$v.eventid}" data-event="{$v.event}" data-varname="{$v.varname}" data-listorder="0">
                                                        <div class="Custom_travel_m4_bottom1_list middle">
                                                            <i class="f24 c999">{$v.place}</i>
                                                        </div>
                                                        <div class="Custom_travel_m4_bottom1_list2 middle">
                                                            <span>{$v.event}</span>
                                                        </div>
                                                        <div class="Custom_travel_m4_bottom1_list3 middle">
                                                            <span>删除</span>
                                                            <img src="__IMG__/Icon/img100.png" />
                                                        </div>
                                                    </li>
                                                </volist>
                                            </ul>
                                        </div>
                                    </volist>
                                </notempty>
                                <div class="Custom_travel_m4_bottom2">
                                    <span class="deltripinfo">-  删   除</span>
                                    <span class="Custom_travel_m4_bottom2_span">+ 添加更多</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <volist name="data['dayarr']" id="vo">
                        <div class="Custom_travel_content hide" data-day="{$vo.day}" data-date="{$vo.date}">
                            <div class="Custom_travel_m4">
                                <div class="Custom_travel_m4_bottom">
                                    <notempty name="vo['eventcity']">
                                        <volist name="vo['eventcity']" id="v">
                                            <div class="Custom_travel_m4_bottom1">
                                                <div class="Custom_travel_m4_bottom1_span">
                                                    <span>{$v.cityname}</span>
                                                </div>
                                                <ul class="Custom_travel_m4_bottom1_ul">
                                                    <volist name="v['event']" id="k">
                                                        <li data-city="{$v.city}" data-place="{$k.place}" data-eventid="{$k.eventid}" data-event="{$k.event}" data-varname="{$k.varname}" data-listorder="{$key+1}">
                                                            <div class="Custom_travel_m4_bottom1_list middle">
                                                                <i class="f24 c999">{$k.place}</i>
                                                            </div>
                                                            <div class="Custom_travel_m4_bottom1_list2 middle">
                                                                <span>{$k.event}</span>
                                                            </div>
                                                            <div class="Custom_travel_m4_bottom1_list3 middle">
                                                                <span>删除</span>
                                                                <img src="__IMG__/Icon/img100.png" />
                                                            </div>
                                                        </li>
                                                    </volist>
                                                </ul>
                                            </div>
                                        </volist>
                                    </notempty>
                                    <div class="Custom_travel_m4_bottom2">
                                        <span class="deltripinfo">-  删   除</span>
                                        <span class="Custom_travel_m4_bottom2_span">+ 添加更多</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </volist>
                </div>
            </div>
            <div class="Custom_travel_m5">
                <span class='save'>完成规划并生成行程</span>
            </div>
        </div>
    </div>
    <div class="Mask4 hide">
        <div class="Mask4_b"></div>
        <div class="Mask4_content">
            <div class="Mask4_content_top hidden">
                <img src="__IMG__/Icon/img107.png" />
            </div>
            <div class="Mask4_content_center">
                <img src="__IMG__/Icon/img120.png" />
                <span>您确定要删除该行程么？</span>
            </div>
            <div class="Mask4_content_foot">
                <input type="hidden" id="deltrip_eventid" value="" />
                <input type="hidden" id="deltrip_varname" value="" />
                <input type="hidden" id="deltrip_day" value="" />
                <input type="button" value="确定" class="Mask4_sub" />
                <input type="button" value="取消" class="Mask4_btn" />
            </div>
        </div>
    </div>
    <div class="Mask5 hide">
        <div class="Mask5_b"></div>
        <div class="Mask5_content">
            <div class="Mask5_content_top">
                <span>请选择添加栏目</span>
                <img src="__IMG__/Icon/img107.png" />
            </div>
            <div class="Mask5_content_center">
                <ul class="Mask5_content_center_ul">
                    <li data-varname="note" data-day="0">
                        <span>游记</span>
                    </li>
                    <li data-varname="party" data-day="0">
                        <span>活动</span>
                    </li>
                    <li data-varname="hostel" data-day="0">
                        <span>美宿</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".save").click(function(){
                var p={};
                $.post("{:U('Home/Trip/doadd')}",p,function(data){
                    data=eval("("+data+")");
                    if(data.code==200){
                        alert(data.msg);
                        window.location.href="{:U('Home/Trip/mytrip')}";
                    }else{
                        alert(data.msg);
                    }
                })
            })

            var day=$.cookie("home_iscachetripday");
            $(".Custom_travel_content").eq(day).show().siblings(".Custom_travel_content").hide();
            $(".Custom_travel_m2_ul > li").eq(day).addClass("Custom_travel_m2_list").siblings().removeClass("Custom_travel_m2_list");

            var $ml = $(".Custom_travel_m2_ul > li");
            $ml.live("click",function () {
                if(!$(this).hasClass("addday")){
                    $(this).addClass("Custom_travel_m2_list").siblings().removeClass("Custom_travel_m2_list");
                    $(".Custom_travel_content").eq($(this).index()).show().siblings(".Custom_travel_content").hide();
                }
            });


            var $cl = $(".Custom_travel_m4_bottom1_ul > li");
            $cl.draggable({ revert: "invalid" });

            $cl.droppable({
                tolerance: "pointer",
                accept: $cl,
                drop: function (event, ui) {
                    var e = e || window.event;
                    var mouse_y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;//鼠标当前的Y轴位置

                    if ($(this).parent()[0] == ui.draggable.parent()[0]) {
                    //如果所在同一个父类
                        var $this = $(this);
                        var $ui_drag = ui.draggable;

                        var offsettop = this.offsetTop;
                        var half = this.clientHeight / 2;//元素一半的位置
                        var TopAero = offsettop + half;//上半区域

                        var moveTop = parseInt($ui_drag.css("top"));//拖拽的Top距离
                        var UIoldOffsetTop = $ui_drag[0].offsetTop - moveTop;//拖拽对象原本的Top位置
 

                        var position_y = moveTop - (this.offsetTop - UIoldOffsetTop);//Dom结构变化后位置保持不变
                        var offsetHeight = this.offsetHeight + parseInt($this.css("margin-bottom"));//在这里每个单元实际使用的高度
                        if (mouse_y > TopAero) {
                        //如果拖入元素的下半区域
                            if (offsettop < UIoldOffsetTop)
                            {
                                position_y -= offsetHeight;
                            }
                            $this.after($ui_drag.css("top", position_y)).css("top", offsetHeight);//添加到元素的后面
                        } else {
                            if (offsettop >= UIoldOffsetTop)
                            {
                                position_y += offsetHeight;
                            }
                            $this.before($ui_drag.css("top", position_y)).css("top", -offsetHeight);//添加到元素的前面
                        }
                        var tlistorder=$(this).data("listorder");
                        var teventid=$(this).data("eventid");
                        var flistorder=$ui_drag.data("listorder");
                        var feventid=$ui_drag.data("eventid");


                        $(this).data("listorder",$ui_drag.data("listorder"));
                        $ui_drag.data("listorder",tlistorder);

                        var p={};
                        p['feventid']=feventid;
                        p['flistorder']=flistorder;
                        p['teventid']=teventid;
                        p['tlistorder']=tlistorder;
                        $.post("{:U('Home/Trip/ajax_listordertripinfo')}",p,function(data){
                            if(data.code==200){
                                console.log("listorder success");
                            }
                        })

                        $ui_drag.animate({
                        //开始拖拽对象的动画
                            "left": 0,
                            "top": 0
                        });
                        $this.animate({
                        //开始放置对象的动画
                            "left": 0,
                            "top": 0
                        });
                    } else {
                        ui.draggable.animate({
                        //还原位置
                            "left": 0,
                            "top": 0
                        });
                    }
                }
            });


            $ml.not(":first,:last").droppable({
                tolerance: "pointer",
                accept: ".Custom_travel_m4_bottom1_ul > li",
                hoverClass: "ui-state-hover",
                drop: function (event, ui) {
                    var dragobject = ui.draggable[0];
                    var $ul = $(dragobject).parent();
                    var title = $ul.prevAll(".Custom_travel_m4_bottom1_span").children("span").text();

                    var cs = $(".Custom_travel_content").eq($(this).index());
                    var $ct = $(cs).find(".Custom_travel_m4_bottom1_span");
                    var $span = $ct.children("span");
                    for (var i = 0; i < $span.length; i++) {
                        if (title == $span[i].innerText) {
                        //如果找到了匹配的title
                            $($ct[i]).next().append(dragobject);
                            var listorder=$($ct[i]).next().find("li").length;
                            console.log("listorder1",listorder);
                            $(dragobject).attr("data-listorder",listorder);
                            $(dragobject).css({
                                "left": 0,
                                "top": 0
                            });
                            if ($ul.children().length == 0) {
                                $ul.parent().remove();
                            }
                            break;
                        } else {
                            if (i == $span.length - 1) {
                            //如果未找到匹配的title
                                var $clone = $(dragobject).parent().parent().clone(true);
                                $clone.children("ul").empty().append(dragobject);
                                $(dragobject).attr("data-listorder",1);
                                console.log("listorder2",1);
                                $(dragobject).css({
                                    "left": 0,
                                    "top": 0
                                });
                                //alert($clone[0]);
                                $($ct[i]).parent().after($clone);

                                if ($ul.children().length == 0) {
                                    $ul.parent().remove();
                                }
                            }
                        }
                    }
                    if ($span.length == 0) {
                    //如果不存在任何title
                        var $clone = $(dragobject).parent().parent().clone(true);
                        $clone.children("ul").empty().append(dragobject);
                        $(dragobject).attr("data-listorder",1);
                        console.log("listorder3",1);
                        $(dragobject).css({
                            "left": 0,
                            "top": 0
                        });
                        //alert($clone[0]);
                        $(cs).find(".Custom_travel_m4_bottom").prepend($clone);

                        if ($ul.children().length == 0) {
                            $ul.parent().remove();
                        }
                    }
                    var eventid=$(dragobject).data("eventid");
                    var day=$(this).data("day");
                    var p={};
                    p['eventid']=eventid;
                    p['day']=day;
                    $.post("{:U('Home/Trip/ajax_updatetripinfo')}",p,function(data){
                        if(data.code==200){
                            console.log("drag success");
                        }
                    })
                }
            });
        });
        $(function () {
            $(".deltripinfo").live("click",function () {
                if($(this).hasClass("Custom_travel_m4_bottom_a")){
                    $(this).removeClass("Custom_travel_m4_bottom_a");
                    $(this).parent(".Custom_travel_m4_bottom2").siblings(".Custom_travel_m4_bottom1").find(".Custom_travel_m4_bottom1_list3 span").removeClass("current").hide();
                    $(this).html("-  删   除");
                }else{
                    $(this).addClass("Custom_travel_m4_bottom_a");
                    $(this).parent(".Custom_travel_m4_bottom2").siblings(".Custom_travel_m4_bottom1").find(".Custom_travel_m4_bottom1_list3 span").show().addClass("current");
                    $(this).html("-  完   成");
                }
                
            })
            $(".Custom_travel_m4_bottom1_list3 span").click(function () {
                $("#deltrip_varname").val($(this).parents("li").data("varname"));
                $("#deltrip_eventid").val($(this).parents("li").data("eventid"));
                $("#deltrip_day").val($(this).parents(".Custom_travel_content").data("day"));
                $(".Mask4").show();
                $("html").css({
                    "overflow-y": "hidden"
                })
            })
            $(".Mask4_btn,.Mask4_b,.Mask4_content_top img").click(function () {
                $(".Mask4").hide();
                $("html").css({
                    "overflow-y": "scroll"
                })
            })
            $(".Mask4_sub").click(function(){
                var eventid=$("#deltrip_eventid").val();
                var day=$("#deltrip_day").val();
                var p={};
                p['eventid']=eventid;
                p['day']=day;
                $.post("{:U('Home/Trip/ajax_deltripinfo')}",p,function(data){
                    if(data.code==200){
                        console.log("deltripinfo success");
                        var $dl=$('.Custom_travel_content').eq(day).find("ul.Custom_travel_m4_bottom1_ul li[data-eventid='"+eventid+"']");
                        if($dl.parent("ul.Custom_travel_m4_bottom1_ul").find("li").length==1){
                            $dl.parents(".Custom_travel_m4_bottom1").remove();
                        }else{
                            $dl.remove();
                        }
                        $(".Mask4").hide();
                        $("html").css({
                            "overflow-y": "scroll"
                        })
                    }
                })
            })
            $(".Mask5_content_center_ul li").click(function () {
                var day=$(this).data("day");
                var varname=$(this).data("varname");
                var p={};
                p['day']=day;
                $.post("{:U('Home/Trip/ajax_cookieday')}",p,function(data){
                    if(data.code==200){
                        if(varname=='note'){
                            window.location.href="{:U('Home/Note/index')}";
                        }else if(varname=='party'){
                            window.location.href="{:U('Home/Party/index')}";
                        }else if(varname=='hostel'){
                            window.location.href="{:U('Home/Hostel/index')}";
                        }
                    }
                })
                
            })
            $(".Custom_travel_m4_bottom2_span").live("click",function () {
                var day=$(this).parents(".Custom_travel_content").data("day");
                $("ul.Mask5_content_center_ul li").attr("data-day",day);
                $(".Mask5").show();
                $("html").css({
                    "overflow-y": "hidden"
                })
            })
            $(".Mask5_content_top img,.Mask5_b").click(function () {
                $(".Mask5").hide();
                $("html").css({
                    "overflow-y": "scroll"
                })
            })
            $(".addday").click(function(){
                var obj=$(this);
                var p={};
                $.post("{:U('Home/Trip/ajax_addday')}",p,function(data){
                    var str="<li><span>第"+data.data.daytext+"天</span><i>DAY"+data.data.day+"</i></li>";
                    $(str).droppable({
                        tolerance: "pointer",
                        accept: ".Custom_travel_m4_bottom1_ul > li",
                        hoverClass: "ui-state-hover",
                        drop: function (event, ui) {
                            var dragobject = ui.draggable[0];
                            var $ul = $(dragobject).parent();
                            var title = $ul.prevAll(".Custom_travel_m4_bottom1_span").children("span").text();

                            //var cs = $(".Custom_travel_content")[getObjectIndex(this, $ml)];
                            var cs = $(".Custom_travel_content").eq($(this).index());
                            var $ct = $(cs).find(".Custom_travel_m4_bottom1_span");
                            var $span = $ct.children("span");
                            for (var i = 0; i < $span.length; i++) {
                                if (title == $span[i].innerText) {
                                //如果找到了匹配的title
                                    $($ct[i]).next().append(dragobject);
                                    var listorder=$($ct[i]).next().find("li").length;
                                    $(dragobject).data("listorder",listorder);
                                    $(dragobject).css({
                                        "left": 0,
                                        "top": 0
                                    });
                                    if ($ul.children().length == 0) {
                                        $ul.parent().remove();
                                    }
                                    break;
                                } else {
                                    if (i == $span.length - 1) {
                                    //如果未找到匹配的title
                                        var $clone = $(dragobject).parent().parent().clone(true);
                                        $clone.children("ul").empty().append(dragobject);
                                        $(dragobject).data("listorder",1);
                                        $(dragobject).css({
                                            "left": 0,
                                            "top": 0
                                        });
                                        //alert($clone[0]);
                                        $($ct[i]).parent().after($clone);

                                        if ($ul.children().length == 0) {
                                            $ul.parent().remove();
                                        }
                                    }
                                }
                            }
                            if ($span.length == 0) {
                            //如果不存在任何title
                                var $clone = $(dragobject).parent().parent().clone(true);
                                $clone.children("ul").empty().append(dragobject);
                                $(dragobject).data("listorder",1);
                                $(dragobject).css({
                                    "left": 0,
                                    "top": 0
                                });
                                //alert($clone[0]);
                                $(cs).find(".Custom_travel_m4_bottom").prepend($clone);

                                if ($ul.children().length == 0) {
                                    $ul.parent().remove();
                                }
                            }
                        }
                    }).insertBefore(obj);

                    var str="<div class=\"Custom_travel_content hide\" data-day=\""+data.data.day+"\" data-date=\""+data.data.date+"\">";
                            str+="<div class=\"Custom_travel_m4\">";
                                str+="<div class=\"Custom_travel_m4_bottom\">";
                                    str+="<div class=\"Custom_travel_m4_bottom1\"></div>";
                                    str+="<div class=\"Custom_travel_m4_bottom2\">";
                                        str+="<span class=\"deltripinfo\">-  删   除</span>";
                                        str+="<span class=\"Custom_travel_m4_bottom2_span\">+ 添加更多</span>";
                                    str+="</div>";
                                str+="</div>";
                            str+="</div>";
                        str+="</div>";
                    $(str).appendTo(".Custom_travel_m3");
                })
            })
        })
    </script>
<include file="public:foot" />