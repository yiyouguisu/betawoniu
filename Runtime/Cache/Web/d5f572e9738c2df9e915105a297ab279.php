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

<body class="back-f1f1f1">
<div class="header center pr f18">
      帮助手册
      <div class="head_go pa" onclick="history.go(-1)"><img src="/Public/Web/images/go.jpg"></div>
</div>

<div class="container">
  <div class="help_box">
      <a href="<?php echo U('Web/About/explainWeb');?>"><div class="help_list">
           <div class="help_a"><img src="/Public/Web/images/help_a1.jpg"> 软件使用说明</div>
      </div></a> 
      <a href="my-help1.html"><div class="help_list">
           <div class="help_a"><img src="/Public/Web/images/help_a2.jpg"> 常见问题</div>
      </div></a> 
  </div>
     

</div>

</body>
</html>