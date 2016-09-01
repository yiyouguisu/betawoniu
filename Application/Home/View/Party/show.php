<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <script src="__JS__/jquery.jqtransform.js"></script>
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
<div class="wrap">
        <div class="activity_main">
            <a href="/">首页</a>
            <span>></span>
            <a href="{:U('Home/Party/index')}">活动</a>
            <span>></span>
            <a href="{:U('Home/Party/show',array('id'=>$data['id']))}">活动详细</a>
        </div>
        <div class="Event_details hidden">
            <div class="middle Event_details2">
                <span>{:str_cut($data['title'],12)}</span>
                <div class="hidden Event_details2_01">
                    <div class="fl Event_details2_02">
                        <img src="__IMG__/Icon/img10.png" />
                        <span>
                            <em>{$data.reviewnum|default="0"}</em>条评论
                        </span>
                    </div>
                    <div class="fl Event_details2_03">
                        <eq name="data['ishit']" value="1">
                            <img src="__IMG__/dianzan.png" class="zanbg1" data-id="{$data.id}"/>
                            <else />
                            <img src="__IMG__/Icon/img9.png" class="zanbg1" data-id="{$data.id}"/>
                        </eq>
                        <span class="zannum">{$data.hit|default="0"}</span>
                    </div>
                    <div class="fl Event_details2_04">
                        <span>{$data.inputtime|date="Y-m-d H:i",###} </span>
                    </div>
                    <div class="fl Event_details2_05">
                        <span>浏览：<em>{$data.view|default="0"}</em></span>
                    </div>
                </div>
            </div>
            <div class="middle Event_detail3 hidden">
                <div class="Event_detail3_01 fl">
                    <a href=""><img src="__IMG__/Icon/img24.png" /></a>
                </div>
                <div class="Event_detail3_02 fl">
                    <a href="javascript:;">
                        <eq name="data['iscollect']" value="1">
                            <img src="__IMG__/Icon/img25.png" class="shoucang" data-id="{$data.id}"/>
                            <else />
                            <img src="__IMG__/shoucang.png"  class="shoucang" data-id="{$data.id}"/>
                        </eq>
                        收藏
                    </a>
                </div>
                <div class="Event_detail3_03 fl">
                    <a href="javascript:;"  class="travels2_bottom3">
                        <img src="__IMG__/Icon/img26.png" />
                        添加到行程
                    </a>
                </div>
            </div>
            <div class="middle Event_details4">
                <span><eq name="data['isfree']" value="1"><em>免费</em><else /><em>{$data.money|default="0.00"}</em>元</eq></span>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="Event_details5 hidden">
            <div class="fl Event_details5_1">
                <div class="Event_details5_1_01 hidden">
                    <div class="Event_details5_1_02_01">
                        <img src="__IMG__/Icon/img30.png" />
                        <span>活动时间 :</span>
                        <i>{$data.starttime|date="Y-m-d",###} 至{$data.endtime|date="Y-m-d",###}</i>
                    </div>
                    <div class="Event_details5_1_02_01">
                        <span>活动费用 :</span>
                        <i>￥{$data.money|default="0.00"}/ 人</i>
                    </div>
                    <div class="Event_details5_1_02_04">
                        <span>活动特色 : </span>
                        <i>{$data.catname}</i>
                    </div>
                    <div class="fl hidden">
                        <div class="Event_details5_1_02_01">
                            <span>活动类型 : </span>
                            <i>
                                <eq name="data['partytype']" value="1">亲子类</eq>
                                <eq name="data['partytype']" value="2">情侣类</eq>
                                <eq name="data['partytype']" value="3">家庭出游</eq>
                            </i>
                        </div>
                        <div class="Event_details5_1_02_02">
                            <img src="__IMG__/Icon/img29.png" />
                            <span>活动地址 : </span>
                            <i>
                                {:getarea($data['area'])}{$data.address}
                            </i>
                        </div>
                    </div>
                </div>
                <div class="Event_details5_3">
                    <span>活动介绍</span>
                    {$data.content}
                </div>
                <div class="Event_details5_4 reviewlist">
                    
                </div>
                <div class="Event_details6">
                    <div class="Event_details6_01">
                        <a href="{:U('Home/Member/detail',array('uid'=>$user['id']))}">
                            <img src="{$user.head|default='/default_head.png'}" style="width:58px;height:58px" />
                        </a>
                        <span id="reviewtitle">评论活动</span>
                    </div>
                    <div class="Event_details6_02">
                        <div class="Event_details6_03">
                            <!-- <span class="f14 c999">回复 XXX：</span> -->
                            <textarea name="content"></textarea>
                        </div>
                        <!-- <div class="Event_details6_04 ">
                            <img class="middle" src="__IMG__/Icon/img32.png" />
                            <img src="__IMG__/Icon/img31.png" />
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
                    var aid="{$data.id}";
                    var geturl = "{:U('Home/Party/get_review')}";
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
                                $.post("{:U('Home/Party/add_reviewreply')}",{"aid":aid,"rid":rid,"content":content,"uid":uid},function(d){
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
                                $.post("{:U('Home/Party/add_reviewquote')}",{"aid":aid,"rid":rid,"content":content,"uid":uid},function(d){
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
                            $.post("{:U('Home/Party/add_review')}",{"aid":aid,"content":content,"uid":uid},function(d){
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
                                <img src="{$data.head}" width="104px" height="104px"/>
                            </div>
                            <i>{$data.nickname}</i>
                        </a>
                    </div>
                    <div class="Event_details5_2_03 hidden">
                        <div class="fl Event_details5_2_04">
                            <label>
                                <eq name="data['realname_status']" value="1">
                                    <img src="__IMG__/Icon/img27.png" />
                                    <else />
                                    <img src="__IMG__/Icon/img27_1.png" />
                                </eq>
                                实名认证
                            </label>
                        </div>
                        <div class="Event_details5_2_04 fl">
                            <label>
                                <eq name="data['houseowner_status']" value="1">
                                    <img src="__IMG__/Icon/img28.png" />
                                    <else />
                                    <img src="__IMG__/Icon/img28_1.png" />
                                </eq>
                                个人房东
                            </label>
                        </div>
                    </div>
                    <if condition="$data['endtime'] elt time()">
                        <a class="a1" href="javascript:;">已过期</a>
                    <elseif condition="$data['end_numlimit'] elt $data['joinnum']" />
                        <a class="a1" href="javascript:;">报名人数已满</a>
                    <else />
                        <a class="a1" href="{:U('Home/Order/joinparty',array('aid'=>$data['id']))}">我要报名</a>
                    </if>
                    
                    <a class="a2" href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['uid']))}">在线咨询</a>
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
                $.post("{:U('Home/Party/add_report')}",{"rid":rid,"content":reportreason,"uid":uid},function(d){
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
                    <volist name="data['party_near_hostel']" id="vo">
                        <li class="fl">
                            <div class="Event_details8_li">
                                <div class="Event_details8_list">
                                    <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}" class="Event_details8_a">
                                        <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg">
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
                    <volist name="data['party_near_activity']" id="vo">
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
        $(".Mask3").height($(window).height());
        $(".travels2_bottom3").click(function () {
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
            if(uid=="{$data.uid}"){
                alert("不能选择自己发布的活动");
                return false;
            }
            var home_iscachetrip=$.cookie("home_iscachetrip");
            var hid="";
            if(home_iscachetrip){
                var p={};
                p['aid']="{$data.id}";
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
            p['aid']="{$data.id}";
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
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Party/ajax_hit')}",
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
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_hit')}",
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
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_collect')}",
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
<include file="public:foot" />