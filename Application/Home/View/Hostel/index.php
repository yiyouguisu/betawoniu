<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<style>
    .chosen-container {
        margin-right: 12px;
    }
</style>
<script>
    $(function () {
        var min = 0;
        var max = 5000;
        var minmoney = "{$_GET['minmoney']}";
        var maxmoney = "{$_GET['maxmoney']}";
        if (minmoney != "") {
            min = minmoney;
        }
        if (maxmoney != "") {
            max = maxmoney;
        }
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 5000,
            step: 100,
            values: [min, max],
            slide: function (event, ui) {
                $("#amount").val("￥" + ui.values[0] + " - ￥" + ui.values[1]);
            },
            change: function (event, ui) {
                var minmoney = ui.values[0];
                var maxmoney = ui.values[1];
                var url = "{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}?minmoney=" + minmoney + "&maxmoney=" + maxmoney;
                window.location.href = url;
            }
        });
        $("#amount").val("￥" + $("#slider-range").slider("values", 0) + " - ￥" + $("#slider-range").slider("values", 1));
        var dateInput = $("input.J_date")
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker({});
            });
        }

    });
</script>
<include file="public:mheader" />
<div class="wrap">
        <div class="Legend_main3">
            <div class="Legend_main3_top">
                <a href="/">首页</a>
                <i>></i>
                <a href="{:U('Home/Hostel/index')}">美宿</a>
            </div>
            <div class="Legend_main3_top2 hidden">
                <form action="{:U('Home/Hostel/index')}" method="get">
                    <div class="Legend_main3_top2_map fl">
                        <img src="__IMG__/Icon/img5.png" />
                        <input type="text" placeholder="{$cityname|default='上海'}" />
                    </div>
                    <div class="Legend_main3_top2_datatime fl">
                        <img src="__IMG__/Icon/img6.png" />
                        <input type="text" class="J_date starttime" placeholder="入住时间" value="{$_GET['starttime']}" />
                    </div>
                    <div class="Legend_main3_top2_datatime fl">
                        <img src="__IMG__/Icon/img6.png" />
                        <input type="text" class="J_date endtime" placeholder="离店时间" value="{$_GET['endtime']}" />
                    </div>
                    <div class="Legend_main3_top2_search fl">
                        <img src="__IMG__/Icon/img7.png" />
                        <input type="text" name="keyword" value="{$_GET['keyword']}"  placeholder="请输入美宿名称等关键词搜索..." />
                    </div>
                    <div class="Legend_main3_top2_search2 fl">
                        <input type="submit" value="搜索" />
                    </div>
                </form>
                <div class="Legend_main3_top2_search_map fl">
                    <img src="__IMG__/Icon/img85.png" />
                    <input type="text" onclick="window.location.href='{:U('Home/Hostel/map')}'" style="cursor:pointer;" value="地图模式" />
                </div>
            </div>
            <script type="text/javascript">
                var areaurl = "{:U('Home/Party/getchildren')}";
                $(function(){
                    var province="{$_GET['province']}";
                    var city="{$_GET['city']}";
                    if(province!=''){
                      load(province,'city',1);
                    }
                    if(city!=''){
                      load(city,'town',1);
                    }
                })
                function load(parentid, type ,isinit) {
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
                                        if (items.id == "{$_GET['city']}") {
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
                                        if (items.id == "{$_GET['town']}") {
                                            $('#town').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                                        } else {
                                            $('#town').append('<option value="' + items.id + '">' + items.name + '</option>');
                                        }
                                    });
                                }
                                
                                $('#town').trigger("chosen:updated");
                            }
                            var province=$("#province option:selected").val();
                            var city=$("#city option:selected").val();
                            var town=$("#town option:selected").val();
                            console.log(city)
                            if(isinit==0){
                                var url = "{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage']))}?province=" + province + "&city=" + city + "&town=" + town;
                                window.location.href = url;
                            }
                            
                            
                        }
                    });
                }
            </script>
            <div class="Legend_main3_center">
                <div class="Legend_main3_center_01">
                    <span>按位置 :</span>
                    <div class="activity_top3_02">
                        <select class=" chosen-select-no-single" name="province" id="province"   onchange="load(this.value,'city',0)">
                            <option value="">选择省</option>
                            <volist name="province" id="vo"> 
                                <option value="{$vo.id}" <if condition="$vo['id'] eq $_GET['province']">selected</if>>{$vo.name}</option>
                            </volist>
                        </select>
                    </div>
                    <div class="activity_top3_02">
                        <select class=" chosen-select-no-single" name="city" id="city"  onchange="load(this.value,'town',0)">
                            <option value="">选择市</option>
                        </select>
                    </div>
                    <div class="activity_top3_02">
                        <select class=" chosen-select-no-single" name="town" id="town"  onchange="load(this.value,'distinct',0)">
                            <option value="">选择区</option>
                        </select>
                    </div>
                </div>
                <div class="activity_top3_04">
                    <span>按价格 :</span>
                    <div id="slider-range" class="middle"></div>
                    <input type="text" id="amount" class="middle f12" style="border:0; color:#000; font-weight:bold;">
                </div>
                <div class="Legend_main3_center_list hidden"><!--travels_main4_1-->
                    <span class=" fl f14 c333">按特色 :</span>
                    <div class="fl hidden Legend_main3_2"><!--travels_main4_2-->
                        <ul class="fl" id="menu_city">
                            <li <empty name="_GET['catid']"> class="Legend_chang"</empty> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}'">不限</li>
                            <volist name="hostelcate" id="vo" offset='0' length="14">
                               <li <if condition="$_GET['catid'] eq $vo['id']"> class="Legend_chang"</if> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$vo['id'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage']))}'">{$vo.catname}</li>
                            </volist>
                        </ul>
                        <if condition="count($hostelcate) gt 15">
                            <label class="fr f12 c333 Legend_main3_center_label ishidden">更多</label>
                            <ul class="Legend_main3_ul2 hide"><!--travels_main4_2_ul2-->
                                <volist name="hostelcate" id="vo" offset="14">
                                   <li <if condition="$_GET['catid'] eq $vo['id']"> class="Legend_chang"</if> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$vo['id'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage']))}'">{$vo.catname}</li>
                                </volist>
                            </ul>
                        </if>
                    </div>
                </div>
                <div class="Legend_main3_center_list hidden"><!--travels_main4_1-->
                    <span class=" fl f14 c333">按类型 :</span>
                    <div class="fl hidden Legend_main3_2"><!--travels_main4_2-->
                        <ul class="fl" id="menu_city">
                            <li <empty name="_GET['style']"> class="Legend_chang"</empty> onclick="window.location.href='{:U('Home/Hostel/index',array('catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}'">不限</li>
                            <volist name="hosteltype" id="vo" offset='0' length="14">
                               <li <if condition="$_GET['style'] eq $vo['id']"> class="Legend_chang"</if> onclick="window.location.href='{:U('Home/Hostel/index',array('catid'=>$_GET['catid'],'style'=>$vo['id'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage']))}'">{$vo.catname}</li>
                            </volist>
                        </ul>
                        <if condition="count($hostelcate) gt 15">
                            <label class="fr f12 c333 Legend_main3_center_label ishidden">更多</label>
                            <ul class="Legend_main3_ul2 hide"><!--travels_main4_2_ul2-->
                                <volist name="hosteltype" id="vo" offset="14">
                                   <li <if condition="$_GET['style'] eq $vo['id']"> class="Legend_chang"</if> onclick="window.location.href='{:U('Home/Hostel/index',array('catid'=>$_GET['catid'],'style'=>$vo['id'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage']))}'">{$vo.catname}</li>
                                </volist>
                            </ul>
                        </if>
                    </div>
                </div>
                <div class="Legend_main3_center_list hidden">
                    <span class="f14 c333 middle fl">服务设施 :</span>
                    <ul class="hidden">
                        <li <empty name="_GET['support']"> class="Legend_chang"</empty> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}'">不限</li>
                        <volist name="roomcate" id="vo" offset='0' length="14">
                           <li <if condition="$_GET['support'] eq $vo['id']"> class="Legend_chang"</if> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$vo['id'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage']))}'">{$vo.catname}</li>
                        </volist>
                    </ul>
                </div>
                <div class="Legend_main3_center_list hidden">
                    <span class="f14 c333 middle fl">床型 :</span>
                    <ul class="hidden">
                        <li <empty name="_GET['bedtype']"> class="Legend_chang"</empty> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}'">不限</li>
                        <volist name="bedcate" id="vo" offset='0' length="14">
                           <li <if condition="$_GET['bedtype'] eq $vo['id']"> class="Legend_chang"</if> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'bedtype'=>$vo['id'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$_GET['acreage']))}'">{$vo.catname}</li>
                        </volist>
                    </ul>
                </div>
                <div class="Legend_main3_center_list hidden">
                    <span class="f14 c333 middle fl">面积 :</span>
                    <ul class="hidden">
                        <li <empty name="_GET['acreage']"> class="Legend_chang"</empty> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}'">不限</li>
                        <volist name="acreagecate" id="vo" offset='0' length="14">
                           <li <if condition="$_GET['acreage'] eq $vo['value']"> class="Legend_chang"</if> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$_GET['score'],'acreage'=>$vo['value']))}'">{$vo.name}</li>
                        </volist>
                    </ul>
                </div>
                <div class="Legend_main3_center_list hidden">
                    <span class="f14 c333 middle fl">评分 :</span>
                    <ul class="hidden">
                        <li <empty name="_GET['score']"> class="Legend_chang"</empty> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'acreage'=>$_GET['acreage'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}'">不限</li>
                        <volist name="scorecate" id="vo" offset='0' length="14">
                           <li <if condition="$_GET['score'] eq $vo['value']"> class="Legend_chang"</if> onclick="window.location.href='{:U('Home/Hostel/index',array('style'=>$_GET['style'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'bedtype'=>$_GET['bedtype'],'support'=>$_GET['support'],'score'=>$vo['value'],'acreage'=>$_GET['acreage']))}'">{$vo.name}</li>
                        </volist>
                    </ul>
                </div>
            </div>
            <div class="Legend_main3_center2">
                <span>找到 <em>{$hostelnum|default="0"}</em> 家美宿  共 <em>{$roomnum|default="0"}</em> 间房   </span>
            </div>
            <div class="main4_bottom">
                <ul class="main4_bottom_ul">
                    <volist name="data" id="vo">
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="javascript:;">
                                    <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:399px;height:250px"  onclick="window.location.href='{:U('Home/Hostel/show',array('id'=>$vo['id']))}'"/>
                                    <div class="pa main4_bottom_list1"></div>
                                </a>
                                <eq name="vo['type']" value="1">
                                    <div class="pa main4_bottom_list_x">
                                        <img src="__IMG__/Icon/jing.png" style="width: 53px;height: 53px;"/>
                                    </div>
                                </eq>
                                <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Event_details8_list_01 shoucang_hostel collect"<else /> class="Event_details8_list_01 shoucang_hostel"</eq>></div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>{$vo.money|default="0.00"}</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>{$vo.evaluation|default="0.0"}</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                        <img src="{$vo.head}" style="width:67px;height:67px"  />
                                    </a>
                                </div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>{:str_cut($vo['title'],15)}</span>
                                    <div class="fr main_bottom_textl1">
                                        <eq name="vo['ishit']" value="1">
                                            <img src="__IMG__/dianzan.png" class="zanbg1" data-id="{$vo.id}"/>
                                            <else />
                                            <img src="__IMG__/Icon/img9.png" class="zanbg1" data-id="{$vo.id}"/>
                                        </eq>
                                        <i class="zannum">{$vo.hit|default="0"}</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>{$vo.reviewnum|default="0"}</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                    </volist>
                </ul>
            </div>
            <div style="border-bottom:1px solid #e0e0e0; margin-bottom:14px;"></div>
            <div class="hidden Legend_main3_4">
                <div class="activity_chang4 fl">
                    {$Page}
                </div>
                <i class="fr">共<em>{$pagenum|default="0"}</em>页<em>{$hostelnum|default="0"}</em>条</i>
            </div>
            <div style="margin-bottom:90px;"></div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Legend_main3_center_list li").click(function () {
                $(this).addClass("Legend_chang").siblings().removeClass("Legend_chang");
                $(this).parents("ul").siblings().find("li").removeClass("Legend_chang");
            })
            $(".Legend_main3_center_label").click(function () {
                var $labale = $(this).html();
                if ($labale == "更多") {
                    $(this).html("收起");
                    $(".Legend_main3_ul2").show();
                } else {
                    $(this).html("更多");
                    $(".Legend_main3_ul2").hide();
                }
            })
            $(".chosen-select-no-single").chosen();
            $(".Legend_main3_center_list").last().css({
                "border-bottom":"0px"
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
        })
    </script>
<include file="public:foot" />
