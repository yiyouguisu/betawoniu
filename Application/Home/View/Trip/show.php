<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<include file="public:mheader" />
<div style="background:#efefef;" class="hidden">
    <div class="wrap">
        <div class="activity_main">
            <a href="/">首页</a>
            <span>></span>
            <a href="{:U('Home/Trip/index')}">行程</a>
            <span>></span>
            <a href="{:U('Home/Trip/show',array('id'=>$data['id']))}">行程详情</a>
        </div>
        <div class="">
            <div class="Edit_stroke_main">
                <div class="Edit_stroke_main_top">
                    <span>{$data.title}</span>
                    <p>( {$data.description} )</p>
                    <label>{$data.starttime|date="Y年m月d日",###} 至 {$data.endtime|date="Y年m月d日",###}</label>
                    <i>进行中</i>
                    <div style="padding-bottom:28px;"></div>
                </div>
                <div class="Edit_stroke_main_bottom">
                    <ul class="Edit_stroke_main_bottom_ul">
                        <volist name="data['tripinfo']" id="vo">
                            <volist name="vo['eventcity']" id="v">
                                <li>
                                    <div class="hidden Edit_stroke_main_bottom_list" style="font-size: 0;">
                                        <div class="middle Edit_stroke_main_bottom_list_1">
                                            <span>{$vo.date|date="m月d日",###}</span>
                                        </div>
                                        <div class="middle Edit_stroke_main_bottom_list_c">
                                            <span>{$v.cityname}</span>
                                            <i>{$v.place}</i>
                                        </div>
                                        <div class="middle Edit_stroke_main_bottom_list_r">
                                            <volist name="v['event']" id="k">
                                                <div class="Edit_stroke_main_bottom_r1">
                                                    <span class="middle">{:str_cut($k['event'],15)}</span>
                                                </div>
                                            </volist>
                                        </div>
                                    </div>
                                </li>
                            </volist>
                        </volist>
                    </ul>
                    
                    <div class="Stroke_detail_main reviewlist">
                        
                    </div>
                    <div class="Event_details6">
                    <div class="Event_details6_01">
                        <a href="{:U('Home/Member/detail',array('uid'=>$user['id']))}">
                            <img src="{$user.head|default='/default_head.png'}" style="width:58px;height:58px" />
                        </a>
                        <span id="reviewtitle">评论行程</span>
                    </div>
                    <div class="Stroke_detail_main3">
                        <div class="Event_details6_03">
                            <textarea name="content"></textarea>
                        </div>
                    </div>
                    <div class="Event_details6_05">
                        <input type="hidden" name="rid" value="">
                        <input type="hidden" name="type" value="review">
                        <a href="javascript:;" id="addreview">发表评论</a>
                    </div>
                </div>
                <script>
                $(function(){
                    var tid="{$data.id}";
                    var geturl = "{:U('Home/Trip/get_review')}";
                    var p={"isAjax":1,"tid":tid};
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
                                $.post("{:U('Home/Trip/add_reviewreply')}",{"tid":tid,"rid":rid,"content":content,"uid":uid},function(d){
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
                                $.post("{:U('Home/Trip/add_reviewquote')}",{"tid":tid,"rid":rid,"content":content,"uid":uid},function(d){
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
                            $.post("{:U('Home/Trip/add_review')}",{"tid":tid,"content":content,"uid":uid},function(d){
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
                var reportreason=$("textarea[name='reportreason']").val();
                if(reportreason==''){
                    alert("举报理由不能为空！");
                    return false;
                }
                var rid=$("input[name='reportid']").val();
                $.post("{:U('Home/Trip/add_report')}",{"rid":rid,"content":reportreason,"uid":uid},function(d){
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
<include file="public:foot" />