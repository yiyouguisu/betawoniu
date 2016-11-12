<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
    <meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
    <meta name="format-detection" content="telephone=no" />
    <link href="favicon.ico" rel="SHORTCUT ICON">
    <title><?php echo ($site["sitetitle"]); ?></title>
    <link rel="stylesheet" href="/Public/Web/css/base.css">
    <link rel="stylesheet" href="/Public/Web/css/style.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery-ui.min.css">
    <script src="/Public/Web/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Web/js/Action.js"></script>
    <script src="/Public/Web/js/TouchSlide.1.1.js"></script>
</head>
<body>

<div class="header center pr f18"><?php echo ($data["title"]); ?>
      <div class="head_go pa" onclick="history.go(-1)">
          <img src="/Public/Web/images/go.jpg"></div>
</div>
<div class="container">
    <div class="help_box">
        <div class="help_f f16 color_333 center "></div>
        <div class="help_h"><?php echo ($data["content"]); ?>
        </div>
    </div>
</div>
<div class="footer">
    <ul>
        <li class="foot_cut">
            <a href="/index.php/Web/">
                <div class="foot_a">
                    <img src="/Public/Web/images/foot_b1.png"></div>
                <div class="foot_b">首页</div>
            </a>
        </li>
        <li>
            <a href="<?php echo U('Web/Woniu/index');?>">
                <div class="foot_a">
                    <img src="/Public/Web/images/foot_a2.png"></div>
                <div class="foot_b">蜗牛</div>
            </a>
        </li>

        <li>
            <a href="<?php echo U('Web/Trip/index');?>">
                <div class="foot_a">
                    <img src="/Public/Web/images/foot_a3.png"></div>
                <div class="foot_b">行程</div>
            </a>
        </li>

        <li>
            <a href="<?php echo U('Web/Member/index');?>">
                <div class="foot_a">
                    <img src="/Public/Web/images/foot_a4.png"></div>
                <div class="foot_b">我的</div>
            </a>
        </li>
    </ul>
</div>
<div class="mask"></div>
<div class="fish_btm hide">
    <div class="fish_t center">
        <div class="fish_t1">
            <span></span>
            <img src="/Public/Web/images/drop.jpg"></div>
    </div>
    <div class="fish_y">
        <ul>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="/Public/Web/images/hm_a1.jpg"></a></div>
                <div class="fish_y2">微信</div>
            </li>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="/Public/Web/images/hm_a2.jpg"></a></div>
                <div class="fish_y2 fish_y3">微博</div>
            </li>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="/Public/Web/images/hm_a3.jpg"></a></div>
                <div class="fish_y2 fish_y4">QQ</div>
            </li>
        </ul>
    </div>
</div>
</body>
</html>