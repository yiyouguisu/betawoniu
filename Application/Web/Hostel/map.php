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
    <script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<script>
    $(function () {

    });
</script>
<include file="public:mheader" />
<div style="background:#e6edf1;">
        <div class="wrap hidden">
            <div class="Legend_main3">
                <div class="Legend_main3_top">
                    <a href="">首页</a>
                    <i>></i>
                    <a href="">名宿</a>
                </div>
                <div class="Legend_main3_top2 hidden">
                    <div class="Legend_main3_top2_map fl">
                        <img src="__IMG__/Icon/img5.png" />
                        <input type="text" value="杭州市" />
                    </div>
                    <div class="Legend_main3_top2_datatime fl">
                        <img src="__IMG__/Icon/img6.png" />
                        <input type="text" value="2016-5-20" />
                    </div>
                    <div class="Legend_main3_top2_datatime fl">
                        <img src="__IMG__/Icon/img6.png" />
                        <input type="text" value="2016-5-20" />
                    </div>
                    <div class="Legend_main3_top2_search fl">
                        <img src="__IMG__/Icon/img7.png" />
                        <input type="text" value="请输入民宿名称等关键词搜索..." />
                    </div>
                    <div class="Legend_main3_top2_search2 fl">
                        <input type="submit" value="搜索" />
                    </div>
                    <div class="Legend_main3_top2_search_map fl">
                        <!--<img src="__IMG__/Icon/img85.png" />-->
                        <img src="__IMG__/Icon/img108.png" />
                        <input class="f16" type="text" value="列表模式" />
                    </div>
                </div>
                
                
            </div>

            <div class="Legend_map_main2">
                <div style="height:346px;border:#ccc solid 1px;" id="dituContent"></div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        //创建和初始化地图函数：
        function initMap() {
            createMap();//创建地图
            setMapEvent();//设置地图事件
            addMapControl();//向地图添加控件
            addMarker();//向地图中添加marker
        }

        //创建地图函数：
        function createMap() {
            var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
            var point = new BMap.Point(121.402419, 31.270483);//定义一个中心点坐标
            map.centerAndZoom(point, 12);//设定地图的中心点和坐标并将地图显示在地图容器中
            window.map = map;//将map变量存储在全局
        }

        //地图事件设置函数：
        function setMapEvent() {
            map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
            map.enableScrollWheelZoom();//启用地图滚轮放大缩小
            map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
            map.enableKeyboard();//启用键盘上下左右键移动地图
        }

        //地图控件添加函数：
        function addMapControl() {
            //向地图中添加缩放控件
            var ctrl_nav = new BMap.NavigationControl({ anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE });
            map.addControl(ctrl_nav);
            //向地图中添加缩略图控件
            var ctrl_ove = new BMap.OverviewMapControl({ anchor: BMAP_ANCHOR_BOTTOM_RIGHT, isOpen: 1 });
            map.addControl(ctrl_ove);
            //向地图中添加比例尺控件
            var ctrl_sca = new BMap.ScaleControl({ anchor: BMAP_ANCHOR_BOTTOM_LEFT });
            map.addControl(ctrl_sca);
        }

        //标注点数组
        var markerArr = [{ title: "￥200起", content: "君越酒店", point: "121.352689|31.2611", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }
             , { title: "￥400", content: "七天连锁", point: "121.394658|31.254679", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }
             , { title: "￥500", content: "哇哦就", point: "121.389484|31.245294", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }
             , { title: "我的标记", content: "我的备注", point: "121.355564|31.243812", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }
             , { title: "我的标记", content: "我的备注", point: "121.388334|31.298628", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }
             , { title: "我的标记", content: "我的备注", point: "121.41708|31.283322", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }
             , { title: "我的标记", content: "我的备注", point: "121.444675|31.273446", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }
             , { title: "我的标记", content: "我的备注", point: "121.372811|31.305046", isOpen: 0, icon: { w: 23, h: 25, l: 46, t: 21, x: 9, lb: 12 } }
        ];
        //创建marker
        function addMarker() {
            for (var i = 0; i < markerArr.length; i++) {
                var json = markerArr[i];
                var p0 = json.point.split("|")[0];
                var p1 = json.point.split("|")[1];
                var point = new BMap.Point(p0, p1);
                var iconImg = createIcon(json.icon);
                var marker = new BMap.Marker(point, { icon: iconImg });
                var iw = createInfoWindow(i);
                var label = new BMap.Label(json.title, { "offset": new BMap.Size(json.icon.lb - json.icon.x + 10, -20) });
                marker.setLabel(label);
                map.addOverlay(marker);
                label.setStyle({
                    borderColor: "#808080",
                    color: "#333",
                    cursor: "pointer"
                });

                (function () {
                    var index = i;
                    var _iw = createInfoWindow(i);
                    var _marker = marker;
                    _marker.addEventListener("click", function () {
                        this.openInfoWindow(_iw);
                    });
                    _iw.addEventListener("open", function () {
                        _marker.getLabel().hide();
                    })
                    _iw.addEventListener("close", function () {
                        _marker.getLabel().show();
                    })
                    label.addEventListener("click", function () {
                        _marker.openInfoWindow(_iw);
                    })
                    if (!!json.isOpen) {
                        label.hide();
                        _marker.openInfoWindow(_iw);
                    }
                })()
            }
        }
        //创建InfoWindow
        function createInfoWindow(i) {
            var json = markerArr[i];
            var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>" + json.content + "</div>");
            return iw;
        }
        //创建一个Icon
        function createIcon(json) {
            var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w, json.h), { imageOffset: new BMap.Size(-json.l, -json.t), infoWindowOffset: new BMap.Size(json.lb + 5, 1), offset: new BMap.Size(json.x, json.h) })
            return icon;
        }

        initMap();//创建和初始化地图
    </script>

    <div style="background:#fff;">
        <div class="wrap">
            <div class="Legend_map_main1">
                <div class="Legend_main3_center2">
                    <span>找到 <em>512</em> 家民宿  共 <em>2,270</em> 间房   </span>
                </div>
                <div class="main4_bottom">
                    <ul class="main4_bottom_ul">
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>
                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>杭州·近银泰浙大自然格调三居</span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>上海·徐家汇金寓浪漫两居 </span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>上海·徐家汇金寓浪漫两居 </span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>杭州·近银泰浙大自然格调三居</span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>上海·徐家汇金寓浪漫两居 </span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href=""><img src="__IMG__/img12.jpg" /></a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>上海·徐家汇金寓浪漫两居 </span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>
                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>杭州·近银泰浙大自然格调三居</span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>上海·徐家汇金寓浪漫两居 </span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>上海·徐家汇金寓浪漫两居 </span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>杭州·近银泰浙大自然格调三居</span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href="">
                                        <img src="__IMG__/img12.jpg" />
                                    </a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>上海·徐家汇金寓浪漫两居 </span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="main4_bottom_list pr">
                                <a href="">
                                    <img src="__IMG__/img6.jpg" />
                                </a>

                                <div class="main4_bottom_list2 pa">
                                    <img src="__IMG__/Icon/img8.png" />
                                </div>
                                <div class="main4_bottom_list3 pa">
                                    <i>￥</i><span>600</span><label>起</label>
                                </div>
                                <div class="main4_bottom_list4 pa">
                                    <span>8.8</span><i>分</i>
                                </div>
                                <div class="main4_bottom_list5 pa">
                                    <a href=""><img src="__IMG__/img12.jpg" /></a>
                                </div>
                                <div class="pa main4_bottom_list1"></div>
                            </div>
                            <div class="main_bottom_text">
                                <div class="main_bottom_textl">
                                    <span>上海·徐家汇金寓浪漫两居 </span>
                                    <div class="fr main_bottom_textl1">
                                        <img src="__IMG__/Icon/img9.png" /><i>28</i>
                                    </div>
                                </div>
                                <div class="main_bottom_text2">
                                    <img src="__IMG__/Icon/img10.png" />
                                    <i>188</i>
                                    <span>条点评</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div style="border-bottom:1px solid #e0e0e0; margin-bottom:14px;"></div>
                <div class="hidden Legend_main3_4">
                    <div class="activity_chang4 fl">
                        <a href="" class="prev disnone">上一页</a>
                        <span class="current">1</span>
                        <a href="">2</a>
                        <a href="">3</a>
                        <a href="">4</a>
                        <a href="">5</a>
                        <a href="">6</a>
                        <a href="">7</a>
                        <a href="" class="next">下一页</a>
                    </div>
                    <i class="fr">共<em>514</em>页<em>10807</em>条</i>
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
        })
    </script>
<include file="public:foot" />