<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
  <meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
  <meta name="format-detection" content="telephone=no" />
  <meta name="viewport" content="width=device-width,user-scalable=0,minimum-scale=1,maximum-scale=1"/>
  <meta name="x5-fullscreen" content="true" />
  <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=7XTgXXqefgTIH3cwTLsbnR7P&s=1"></script>
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
    <img src="/Public/Web/images/go.png" style="height:25px;">
  </a>
</div>
</div>
<div style="height:100%;width:100%" id="big_map_container"></div>
</div>
</body>
<script>
  function bigmap() {
    var bmap = new BMap.Map("big_map_container"); // 创建地图实例 
    var bpoint = new BMap.Point(<?php echo ($lng); ?>, <?php echo ($lat); ?>); // 创建点坐标  
    bmap.centerAndZoom(bpoint, 15);
    var bmarker = new BMap.Marker(bpoint); // 创建标注    
    bmap.addOverlay(bmarker);
    window.setTimeout(function(){  
      bmap.panTo(new BMap.Point(<?php echo ($lng); ?>, <?php echo ($lat); ?>));    
    }, 2000);
  }
  bigmap();
</script>
</html>