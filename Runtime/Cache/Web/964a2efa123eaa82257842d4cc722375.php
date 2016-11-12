<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <title><?php echo ($error); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/Public/Public/css/weui.css">
	<link rel="stylesheet" href="/Public/Public/css/jquery-weui.css">
  </head>

  <body ontouchstart>
    <script src="/Public/Public/js/jquery-2.1.4.js"></script>
	<script src="/Public/Public/js/jquery-weui.js"></script>
    <script type="text/javascript">
    	$.alert("<?php echo ($error); ?>",function() {
		  location.href = '<?php echo ($jumpUrl); ?>';
		});
		
	</script>
  </body>

  </html>