<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<style type="text/css">
        html, body { margin: 0; padding: 0; }
        .iw_poi_title { color: #CC5522; font-size: 14px; font-weight: bold; overflow: hidden; padding-right: 13px; white-space: nowrap; }
        .iw_poi_content { font: 12px arial,sans-serif; overflow: visible; padding-top: 4px; white-space: -moz-pre-wrap; word-wrap: break-word; }
    </style>
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=GxLrHBjtGLbOk23xtDXL1nh5PVsEq77n&s=1"></script>
<script>
    $(function () {
        var dateInput = $("input.J_date")
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker({});
            });
        }
    });
</script>
<include file="public:mheader" />
<div style="background:#e6edf1;">
        <div class="wrap hidden">
            <div class="Legend_main3">
                <div class="Legend_main3_top">
                    <a href="/">首页</a>
                    <i>></i>
                    <a href="{:U('Home/Hostel/index')}">美宿</a>
                </div>
                <div class="Legend_main3_top2 hidden">
                    <form action="{:U('Home/Hostel/map')}" method="get">
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
                        <!--<img src="__IMG__/Icon/img85.png" />-->
                        <img src="__IMG__/Icon/img108.png" />
                        <input class="f16" type="text" onclick="window.location.href='{:U('Home/Hostel/index')}'" style="cursor:pointer;" value="列表模式" />
                    </div>
                </div>
                
                
            </div>

            <div class="Legend_map_main2">
                <div style="height:346px;border:#ccc solid 1px;" id="allmap"></div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        // 百度地图API功能
        var mp = new BMap.Map("allmap");
        var point = new BMap.Point({$location.x}, {$location.y});
        mp.centerAndZoom(point, 15);
        mp.enableScrollWheelZoom();
        // 复杂的自定义覆盖物
        function ComplexCustomOverlay(point, text, mouseoverText,url) {
            this._point = point;
            this._text = text;
            this._overText = mouseoverText;
            this._url = url;
        }
        ComplexCustomOverlay.prototype = new BMap.Overlay();
        ComplexCustomOverlay.prototype.initialize = function (map) {
            this._map = map;
            var url=this._url;
            var div = this._div = document.createElement("div");
            div.style.position = "absolute";
            div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
            div.style.background = "url('__IMG__/Icon/img124.png') no-repeat center center";
            div.style.backgroundSize = "100% 100%";
            div.style.color = "white";
            div.style.height = "68px";
            div.style.width = "60px";
            div.style.padding = "2px";
            div.style.lineHeight = "18px";
            div.style.whiteSpace = "nowrap";
            div.style.MozUserSelect = "none";
            div.style.fontSize = "12px";

            div.onclick = function(){
                window.location.href=url;
            };
            var span = this._span = document.createElement("span");
            div.appendChild(span);
            //span.appendChild(document.createTextNode(this._text));
            span.innerHTML = "<span class='span_x'>￥<em>"+this._text+"</em></span><span class='span_y'>起</span>"
            var that = this;

            var arrow = this._arrow = document.createElement("div");

            arrow.style.position = "absolute";
            arrow.style.width = "11px";
            arrow.style.height = "10px";
            arrow.style.top = "22px";
            arrow.style.left = "10px";
            arrow.style.overflow = "hidden";
            div.appendChild(arrow);

            mp.getPanes().labelPane.appendChild(div);

            return div;
        }
        ComplexCustomOverlay.prototype.draw = function () {
            var map = this._map;
            var pixel = map.pointToOverlayPixel(this._point);
            this._div.style.left = pixel.x - parseInt(this._arrow.style.left) + "px";
            this._div.style.top = pixel.y - 30 + "px";
        }
        var jsonlist={$jsonlist};
        if(jsonlist!=""){
            $.each(jsonlist,function(index,item){
                var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(item.lng, item.lat), item.money, "","/index.php/Home/Hostel/show/id/"+item.id+".html");
                mp.addOverlay(myCompOverlay);
            })
        }
    </script>
    </script>

    <div style="background:#fff;">
        <div class="wrap">
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