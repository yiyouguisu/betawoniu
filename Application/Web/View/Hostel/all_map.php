<!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="{$site.sitekeywords}" />
  <meta name="description" content="{$site.sitedescription}" />
  <meta name="format-detection" content="telephone=no" />
  <meta name="viewport" content="width=device-width,user-scalable=0,minimum-scale=1,maximum-scale=1"/>
  <meta name="x5-fullscreen" content="true" />
  <script src="__JS__/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=GxLrHBjtGLbOk23xtDXL1nh5PVsEq77n&s=1"></script>
<script type="text/javascript" src="https://api.map.baidu.com/getscript?v=2.0&ak=GxLrHBjtGLbOk23xtDXL1nh5PVsEq77n&services=&t=20161124185815"></script>
  <style>
    html, body {
      width: 100%;
      height: 100%;
      padding: 0;
      margin: 0;
    }
  </style>
</head>
<body>
  <div style="position:fixed;left:0;right:0;top:0;height:50px;background:#56c3cf;z-index:1000">
    <a href="javascript:history.go(-1);" id="close_map" style="display:inline-block;padding:12px;">
      <img src="__IMG__/go.png" style="height:25px;">
    </a>
  </div>
  <div style="position:fixed;top:60px;right:20px;z-index:10000">
    找到 <span id="num_hotel"></span> 间美宿，共<span id="num_room"></span>间房
  </div>
  <div class="Legend_map_main2" style="width:100%;height:100%;margin-top:50px;">
      <div style="height:100%;border:#ccc solid 1px;" id="allmap"></div>
  </div>
</body>
<script type="text/javascript">
    function getLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(showPosition, errorPosition);
      }
      else {
         console.log('浏览器不支持定位！');
      }
    }
    function showPosition(position) {
      var data = { 'position': position.coords.longitude + ',' + position.coords.latitude };
      $.post("{:U('Web/Index/cacheposition')}", data, function (res) {
        if(typeof(baiduCallback) == 'function') {
          var pos = JSON.parse(res);
          baiduCallback(pos.lat, pos.lng); 
        }
      });
    }
    function errorPosition(err) {
      console.warn('ERROR(' + err.code + '): ' + err.message);
    }
    function baiduCallback(lat, lng) {
      var mp = new BMap.Map("allmap");
      var point = new BMap.Point(lng, lat);
      mp.centerAndZoom(point, 14);
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
          console.log(url);
          var div = this._div = document.createElement("div");
          div.style.position = "absolute";
          div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
          div.style.background = "url('__IMG__/Icon/img124.png') no-repeat center center";
          div.style.backgroundSize = "100% 100%";
          div.style.color = "white";
          div.style.height = "50px";
          div.style.width = "50px";
          div.style.padding = "5px";
          div.style.lineHeight = "3";
          div.style.whiteSpace = "nowrap";
          div.style.MozUserSelect = "none";
          div.style.fontSize = "12px";
          div.onclick = function(evt){
            evt.preventDefault();
            window.location.href=url;
          };
          div.addEventListener('touchstart', function(evt) {
            evt.preventDefault();
            window.location.href=url;
          });
          var span = this._span = document.createElement("span");
          div.appendChild(span);
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
      rawPost('{:U("Api/Hostel/get_hostel_map")}', {
        'lat': lat, 'lng': lng, 'radis': 20  
      }, function(data) {
        var jsonlist=data.data;
        $('#num_hotel').html(data.hostelnum);
        $('#num_room').html(data.roomnum);
        $.each(jsonlist,function(index,item){
            var myCompOverlay = new ComplexCustomOverlay(new BMap.Point(item.lng, item.lat), item.money, "","/index.php/Web/Hostel/show/id/"+item.id+".html");
            mp.addOverlay(myCompOverlay);
        })
      
      }, function(err, data) {
        console.log(err); 
      });
    } 
    getLocation();

    function rawPost(url, data, success, err) {
      $.ajax({
        'url': url,
        'data': JSON.stringify(data),
        'dataType': 'json',
        'type': 'post',
        'success': success,
        'error': err
      });
    }
</script>
</html>
