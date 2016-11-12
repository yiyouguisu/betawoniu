<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=GxLrHBjtGLbOk23xtDXL1nh5PVsEq77n"></script>
<include file="public:mheader" />
<div class="wrap">
        <div class="activity_main">
            <a href="/">首页</a>
            <span>></span>
            <a href="{:U('Home/Woniu/index')}">蜗牛</a>
            <span>></span>
            <a href="{:U('Home/Woniu/morefriend')}">添加好友</a>
        </div>
    </div>



    <div class="wrap">
        <div class="Add_with_more">
            <div class="Add_with_more_top">
                <span>附近的蜗牛客</span>
            </div>
            <div class="Add_with_more_map">
                <div style="width:1222px;height:518px;border:#ccc solid 1px;" id="allmap"></div>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        
        var mp = new BMap.Map("allmap");
        var point = new BMap.Point({$location.x}, {$location.y});
        mp.centerAndZoom(point, 15);
        mp.enableScrollWheelZoom();
        

        // 复杂的自定义覆盖物
        function ComplexCustomOverlay(point, text, mouseoverText,backgroundImage,url) {
            this._point = point;
            this._text = text;
            this._overText = mouseoverText;
            this._backgroundImage = backgroundImage;
            this._url = url;

        }
        ComplexCustomOverlay.prototype = new BMap.Overlay();
        ComplexCustomOverlay.prototype.initialize = function (map) {
            this._map = map;
            var url=this._url;
            var div = this._div = document.createElement("div");
            div.style.position = "absolute";
            div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
            div.style.backgroundImage = "url('"+this._backgroundImage+"')";
            div.style.backgroundSize = "100%";
            div.style.border = "4px solid #fff";
            div.style.color = "white";
            div.style.height = "60px";
            div.style.width = "60px";
            div.style.padding = "2px";
            div.style.lineHeight = "60px";
            div.style.whiteSpace = "nowrap";
            div.style.MozUserSelect = "none";
            div.style.borderRadius = "50%";
            div.style.fontSize = "12px"
            div.style.overflow = "hidden";
            div.onclick = function(){
	       		window.location.href=url;
	       	};

            var span = this._span = document.createElement("span");
            div.appendChild(span);
            span.appendChild(document.createTextNode(this._text));
            var that = this;

            var arrow = this._arrow = document.createElement("div");
            //arrow.style.background = "url(http://map.baidu.com/fwmap/upload/r/map/fwmap/static/house/images/label.png) no-repeat";
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

        var txt = "", mouseoverTxt = txt + " " + parseInt(Math.random() * 1000, 10) + "";


        var jsonlist={$data};
        if(jsonlist!=""){
        	$.each(jsonlist,function(index,item){
        		var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(item.lng, item.lat), "", mouseoverTxt,item.head,"/index.php/Home/Member/detail/uid/"+item.uid+".html");
			    mp.addOverlay(myCompOverlay);
        	})
        }
       

    </script>
<include file="public:foot" />
