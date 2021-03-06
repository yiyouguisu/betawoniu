<include file="Common:Head" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=wqBXfIN3HkpM1AHKWujjCdsi"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<style type="text/css">
    .iw_poi_title {
        color: #CC5522;
        font-size: 14px;
        font-weight: bold;
        overflow: hidden;
        padding-right: 13px;
        white-space: nowrap;
    }

    .iw_poi_content {
        font: 12px arial,sans-serif;
        overflow: visible;
        padding-top: 4px;
        white-space: -moz-pre-wrap;
        word-wrap: break-word;
    }
    .aa{
        margin-right: 20px;
        margin-bottom:10px;
        margin-top:10px;
    }
</style>
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav" />
        <div style="width: 25%; height: 550px; border: #ccc solid 1px; float: left;    overflow: auto;">
            <form action="{:U('Admin/Order/dodistribute')}" method="post">
                <ul>
                    <volist name="runer" id="vo">
                        <li>
                            <input type="radio" name="ruid" value="{$vo.ruid}">
                            <span class="aa">{$vo.realname}</span>
                            <span class="aa">距离仓库   {$vo.distance|default="0.00"}千米</span>
                            <span class="aa" style="display: block;margin-left: 22px;">有{$vo.ordernum|default="0"}笔订单在派送</span>
                        </li>
                    </volist>
                </ul>
                <input type="hidden" name="orderid" value="{$orderid}">
                <button types="submit" style="margin-top: 20px;    margin-bottom: 10px;width: 80%;height: 30px;    background-color: #FFCC00;border: 1px solid #fff;border-radius: 5px;" >派发</button>
             </form>
        </div>
        <div style="width: 73%; height: 550px; border: #ccc solid 1px; float: right;" id="dituContent"></div>
    </div>
    <script language="javascript">
        var a = "";
        var markerArr = "";
        var myGeo = new BMap.Geocoder();

        a = "{$store['lng']}" + "|" + "{$store['lat']}";
        //alert(a);
        //markerArr = [{ title: "{$store['title']}", content: "门店所在位置", point: a}];
        markerArr={$markerArrStr};
        initMap();



        //创建和初始化地图函数：
        function initMap() {

            createMap();//创建地图
            setMapEvent();//设置地图事件
            addMapControl();//向地图添加控件
            var isOpen=1;
            var pointicon={ w: 21, h: 21, l: 0, t: 0, x: 6, lb: 5 };
            for (var i = 0; i < markerArr.length; i++) {
                var json = markerArr[i];
                var p0 = json.point.split("|")[0];
                var p1 = json.point.split("|")[1];
                var point = new BMap.Point(p0, p1);
                var iconImg = createIcon(pointicon);
                var marker = new BMap.Marker(point, { icon: iconImg });
                var iw = createInfoWindow(i);
                var label = new BMap.Label(json.title, { "offset": new BMap.Size(pointicon.lb - pointicon.x + 10, -20) });
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
                    if (!!isOpen) {
                        label.hide();
                        _marker.openInfoWindow(_iw);
                    }
                })()
            }
        }

        //创建地图函数：
        function createMap() {
            var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
            var point = new BMap.Point("{$store['lng']}", "{$store['lat']}");//定义一个中心点坐标
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

        //initMap();//创建和初始化地图
    </script>

</body>
</html>