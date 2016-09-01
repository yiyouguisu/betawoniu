<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <script src="__JS__/WdatePicker.js"></script>
    <script src="__JS__/work.js"></script>
    <script src="__JS__/jquery-browser.js"></script>
    <script src="__JS__/jquery.qqFace.js"></script>
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
<include file="public:mheader" />
<div class="travels2">
        <div class="travels2_top" style="background: url('{$data.background|default='__IMG__/img51.jpg'}') no-repeat center center;background-size: 100% 200px;height: 200px;">
            
        </div>
        <div class="travels2_bottom">
            <div class="wrap pr">
                <div class="pa travels2_bottom1">
                    <a href="{:U('Home/Member/detail',array('uid'=>$data['uid']))}">
                        <img src="{$data.head}" width="104px" height="104px" />
                    </a>
                </div>
                <div class="travels2_bottom2">
                    <div class="travels2_bottom2_01">
                        <div class="travels2_bottom2_02 middle">
                            <span class="f16 c000">{$data.nickname}</span>
                        </div>
                        <div class="middle travels2_bottom2_03 hidden">
                            <div class="travels2_bottom2_04 fl tr">
                                <img src="__IMG__/Icon/img10.png" />
                                <span class="f15 c999"><em class="c999 f16">{$data.reviewnum|default="0"}</em>条评论</span>
                            </div>
                            <div class="travels2_bottom2_05 fl tr">
                                <eq name="data['ishit']" value="1">
                                    <img src="__IMG__/dianzan.png" class="zanbg1" data-id="{$data.id}"/>
                                    <else />
                                    <img src="__IMG__/Icon/img9.png" class="zanbg1" data-id="{$data.id}"/>
                                </eq>
                                <span class="c999 f15 zannum">{$data.hit|default="0"}</span>
                            </div>
                            <div class="travels2_bottom2_04 fl tr">
                                <span class="f12 c999">{$data.inputtime|date="Y-m-d H:i",###} </span>
                            </div>
                            <div class="travels2_bottom2_05 fl tr">
                                <span class="f12 c999"> 浏览：<em class="f12 c999"></em>{$data.view|default="0"}</span>
                            </div>
                        </div>
                        <div class="middle travels2_bottom2_06 tr">
                            <a href="">
                                <img src="__IMG__/Icon/img24.png" />
                            </a>
                            <a href="javascript:;">
                                <eq name="data['iscollect']" value="1">
                                    <img src="__IMG__/Icon/img25.png" class="shoucang" data-id="{$data.id}"/>
                                    <else />
                                    <img src="__IMG__/shoucang.png"  class="shoucang" data-id="{$data.id}"/>
                                </eq>
                                收藏
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="Event_details5 hidden">
            <div class="fl Event_details5_1"> 
                <div class="Event_details5_1_01 hidden">
                    <div class="Event_details5_1_02_01">
                        <img src="__IMG__/Icon/img86.png" />
                        <span>出发时间 :</span>
                        <i>{$data.begintime|date="Y-m-d",###} 至{$data.endtime|date="Y-m-d",###}</i>
                    </div>
                    <div class="Event_details5_1_02_01">
                        <img src="__IMG__/Icon/img87.png" />
                        <span>人均费用 : </span>
                        <i>￥{$data.fee|default="0.00"}</i>
                    </div>
                    <div class="Event_details5_1_02_04">
                        <img src="__IMG__/Icon/img88.png" />
                        <span>形式 : </span>
                        <i>{$data.notestyle}</i>
                    </div>
                    <div class="Event_details5_1_02_01">
                        <img src="__IMG__/Icon/img89.png" />
                        <span>人物 : </span>
                        <i>{$data.noteman} </i>
                    </div>
                    <div class="Event_details5_1_02_01">
                        <img src="__IMG__/Icon/img90.png" />
                        <span>出行天数 :</span>
                        <i>{$data.days|default="0"}天</i>
                    </div>
                </div>

                <div class="Event_details5_3">
                    <div style="height:25px; width:1px;"></div>
                    <label>{$data.description}</label>
                    <volist name="data['content']" id="vo">
                        <p>{$vo.content}</p>
                        <notempty name="vo['thumb']">
                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" />
                        </notempty>
                    </volist>
                    
                </div>
                <div class="Event_details5_4 reviewlist">
                    
                </div>
                <div class="Event_details6">
                    <div class="Event_details6_01">
                        <a href="{:U('Home/Member/detail',array('uid'=>$user['id']))}">
                            <img src="{$user.head|default='/default_head.png'}" style="width:58px;height:58px" />
                        </a>
                        <span id="reviewtitle">评论游记</span>
                    </div>
                    <div class="Event_details6_02">
                        <div class="Event_details6_03">
                            <!-- <span class="f14 c999">回复 XXX：</span> -->
                            <textarea id="saytext" name="content" class="input"></textarea>
                        </div>
                        <!-- <div class="Event_details6_04 pr">
                            <img class="middle" src="__IMG__/Icon/img32.png" />
                            <img class="emotion" src="__IMG__/Icon/img31.png" />
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
                    var nid="{$data.id}";
                    var geturl = "{:U('Home/Note/get_review')}";
                    var p={"isAjax":1,"nid":nid};
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
                        var uid="{$user.id}";
                        if(uid==''){
                            alert("请先登录！");
                            var loginp={};
                            loginp['url']="__SELF__";
                            $.post("{:U('Home/Public/ajax_cacheurl')}",loginp,function(data){
                                if(data.code=200){
                                    window.location.href="{:U('Home/Member/login')}";
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
                                $.post("{:U('Home/Note/add_reviewreply')}",{"nid":nid,"rid":rid,"content":content,"uid":uid},function(d){
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
                            }else if(type=='quote'){
                                $.post("{:U('Home/Note/add_reviewquote')}",{"nid":nid,"rid":rid,"content":content,"uid":uid},function(d){
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
                            $.post("{:U('Home/Note/add_review')}",{"nid":nid,"content":content,"uid":uid},function(d){
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
            <div class="fl travels2_main">
                <div class="travels2_main2">
                    <span class="f22">文中出现过的美宿</span>
                    <volist name="data['note_hostel']" id="vo">
                        <i data-hid="{$vo.hid}" data-uid="{$vo.uid}"><em>+</em>{$vo.title}</i>
                    </volist>
                    <a href="javascript:void(0);" data-varname="hostel" class="travels2_bottom3"><em>+</em>  添加到行程</a>
                </div>
                <div class="travels2_main3 hidden">
                    <span class="f22">文中出现过的景点</span>
                    <ul class="travels2_main3_ul hidden">
                        <volist name="data['note_place']" id="vo">
                            <li>
                                <i data-hid="{$vo.hid}" data-uid="{$vo.uid}">
                                    <em>+</em>{$vo.title}
                                </i>
                            </li>
                        </volist>
                    </ul>
                    <a href="javascript:void(0);" data-varname="place" class="travels2_bottom3"><em>+</em>  添加到行程</a>
                </div>
                <div class="travels2_main4">
                    <label>相关游记推荐</label>
                    <ul class="travels2_main4_ul">
                        <volist name="data['relative_note']" id="vo">
                            <li class="hidden">
                                <if condition="$key elt 2">
                                    <div class="fl travels2_main4_02">
                                        <eq name="key" value="0"><img src="__IMG__/Icon/img34.png" /></eq>
                                        <eq name="key" value="1"><img src="__IMG__/Icon/img35.png" /></eq>
                                        <eq name="key" value="2"><img src="__IMG__/Icon/img36.png" /></eq>
                                    </div>
                                </if>
                                <div class="fl travels2_main4_03">
                                    <span class="c333 f18">{:str_cut($vo['title'],10)}</span>
                                    <i class="f12">{$vo.inputtime|date="Y-m-d",###}</i>
                                </div>
                            </li>
                        </volist>
                    </ul>
                </div>
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
                <img src="__IMG__/Icon/img107.png" />
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
                    <input value="{:date('Y-m-d')}" type="text" class="J_date" id="trip_starttime" />
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
            $(".travels2_main2 i").click(function(){
                var uid="{$user.id}";
                if(uid==''){
                    alert("请先登录！");
                    var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                    return false;
                }
                if(!$(this).hasClass("travels2_chang")){
                    if(uid==$(this).data("uid")){
                        alert("不能选择自己发布的美宿");
                        return false;
                    }else{
                        $(this).addClass("travels2_chang");
                    }
                }else{
                    $(this).removeClass("travels2_chang");
                }
                
            })
            $(".travels2_main3_ul li").click(function () {
                var uid="{$user.id}";
                if(uid==''){
                    alert("请先登录！");var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                    return false;
                }
                if(!$(this).hasClass("travels2_chang2")){
                    if(uid==$(this).data("uid")){
                        alert("不能选择自己发布的美宿");
                        return false;
                    }else{
                        $(this).addClass("travels2_chang2");
                    }
                }else{
                    $(this).removeClass("travels2_chang2");
                }
            })
            $(".Mask3").height($(window).height());
            $(".travels2_bottom3").click(function () {
                var uid="{$user.id}";
                if(uid==''){
                    alert("请先登录！");var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                    return false;
                }
                var home_iscachetrip=$.cookie("home_iscachetrip");
                var varname=$(this).data("varname");

                if(varname=='hostel'){
                    var a=$(".travels2_main2 i.travels2_chang").length;
                    if(a==0){
                        alert("请先选择美宿！");
                        return false;
                    }
                }else if(varname=='place'){
                    var a=$(".travels2_main3_ul li.travels2_chang2").length;
                    if(a==0){
                        alert("请先选择景点！");
                        return false;
                    }
                }
                var hid="";
                if(home_iscachetrip){
                    var p={};
                    if(varname=='hostel'){
                        $(".travels2_main2 i.travels2_chang").each(function(){
                            if(hid==""){
                                hid=$(this).data("hid");
                            }else{
                                hid+=","+$(this).data("hid");
                            }
                        })
                    }else if(varname=='place'){
                        $(".travels2_main3_ul li.travels2_chang2").each(function(){
                            if(hid==""){
                                hid=$(this).data("hid");
                            }else{
                                hid+=","+$(this).data("hid");
                            }
                        })
                    }
                    p['hid']=hid;
                    $.post("{:U('Home/Trip/ajax_cachetripinfo')}",p,function(data){
                        if(data.code=200){
                            var home_cachetripdo= $.cookie("home_cachetripdo");
                            if(home_cachetripdo=='edit'){
                                window.location.href="{:U('Home/Trip/edit')}";
                            }else if(home_cachetripdo=='add'){
                                window.location.href="{:U('Home/Trip/add')}";
                            }
                        }else{
                            alert("提交失败");
                        }
                    })
                }else{
                    $(".addtrip").data("varname",varname);
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
                var varname=$(this).data("varname");
                if(varname=='hostel'){
                    var hid="";
                    $(".travels2_main2 i.travels2_chang").each(function(){
                        if(hid==""){
                            hid=$(this).data("hid");
                        }else{
                            hid+=","+$(this).data("hid");
                        }
                    })
                }else if(varname=='place'){
                    var hid="";
                    $(".travels2_main3_ul li.travels2_chang2").each(function(){
                        if(hid==""){
                            hid=$(this).data("hid");
                        }else{
                            hid+=","+$(this).data("hid");
                        }
                    })
                }
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
                p['hid']=hid;
                p['title']=trip_title;
                p['starttime']=trip_starttime;
                p['days']=trip_days;
                $.post("{:U('Home/Trip/ajax_cachetripinfo')}",p,function(data){
                    if(data.code=200){
                        $(".Mask3").hide();
                        $(".travels2_a").hide();
                        window.location.href="{:U('Home/Trip/add')}";
                    }else{
                        alert("提交失败");
                    }
                })
                
            })
        })
    </script>

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
                var uid="{$user.id}";
                if(uid==''){
                    alert("请先登录！");
                    var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
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
                $.post("{:U('Home/Note/add_report')}",{"rid":rid,"content":reportreason,"uid":uid},function(d){
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
                    <volist name="data['note_near_hostel']" id="vo">
                        <li class="fl">
                            <div class="Event_details8_li">
                                <div class="Event_details8_list">
                                    <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}" class="Event_details8_a">
                                        <img src="{$vo.thumb}">
                                    </a>
                                    <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Event_details8_list_01 shoucang_hostel collect"<else /> class="Event_details8_list_01 shoucang_hostel"</eq>></div>
                                    <div class="Event_details8_list_02 pa">
                                        <i>￥</i>
                                        <span>{$vo.money|default="0.00"}</span>
                                        <label>起</label>
                                    </div>
                                    <div class="Event_details8_list_03 pa">
                                        <span>{$vo.evaluation|default="0"}</span><i>分</i>
                                    </div>
                                    <div class="Event_details8_list_04 pa">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            <img src="{$vo.head}">
                                        </a>
                                    </div>
                                </div>
                                <div class="Event_details8_list2">
                                    <span onclck="window.location.href='{:U('Home/Hostel/show',array('id'=>$vo['id']))}'">{:str_cut($vo['title'],10)}</span>
                                    <div class="hidden Event_details8_list2_01">
                                        <div class="fl Event_details8_list2_02">
                                            <img src="__IMG__/Icon/img10.png" />
                                            <i><em>{$vo.reviewnum|default="0"}</em>条点评</i>
                                        </div>
                                        <div class="fr Event_details8_list2_03 tr">
                                            <eq name="vo['ishit']" value="1">
                                                <img src="__IMG__/dianzan.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="{$vo.id}"/>
                                                <else />
                                                <img src="__IMG__/Icon/img9.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="{$vo.id}"/>
                                            </eq>
                                            <i class="zannum">{$vo.hit|default="0"}</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </volist>
                </ul>
            </div>
        </div>
        <div class="Event_details7">
            <span>周边活动推荐</span>
            <div class="Event_details8 hidden">
                <ul class="Event_details8_ul clearfix">
                    <volist name="data['note_near_activity']" id="vo">
                        <li class="fl">
                            <div class="Event_details8_li">
                                <div class="Event_details8_list">
                                    <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}" class="Event_details8_a">
                                        <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" />
                                    </a>
                                    <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Event_details8_list_01 shoucang_party collect"<else /> class="Event_details8_list_01 shoucang_party"</eq>></div>
                                    <div class="Event_details8_list_04 pa">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            <img src="{$vo.head}">
                                        </a>
                                    </div>
                                </div>
                                <div class="Event_details8_list3">
                                    <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],10)}</a>
                                    <div>
                                        <i class="c999 f14">
                                            时间 :<em class="f12 c666">{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em>
                                        </i>
                                    </div>
                                    <div>
                                        <i class="c999 f14">
                                            地点 :<em class="f12 c666">{$vo.address} </em>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </volist>
                </ul>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function () {
        $(".zanbg1").live("click",function(){
            var obj=$(this);
            var uid='{$user.id}';
            if(!uid){
                alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
                return false;
            }
            var hitnum=$(this).siblings(".zannum");
            var nid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Note/ajax_hit')}",
                 data: {'nid':nid},
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
            var uid='{$user.id}';
            if(!uid){
                alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
                return false;
            }
            var hitnum=$(this).siblings(".zannum");
            var nid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_hit')}",
                 data: {'nid':nid},
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
            var uid='{$user.id}';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
                return false;
            }
            var nid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Note/ajax_collect')}",
                 data: {'nid':nid},
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
            var uid='{$user.id}';
            if(!uid){
                alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
                return false;
            }
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Party/ajax_collect')}",
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
            var uid='{$user.id}';
            if(!uid){
                alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
                return false;
            }
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_collect')}",
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
    });
</script>


<include file="public:foot" />