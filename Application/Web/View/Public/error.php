<!DOCTYPE html>
<html>
  <head>
    <title>{$error}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="__PUBLIC__/Public/css/weui.css">
	<link rel="stylesheet" href="__PUBLIC__/Public/css/jquery-weui.css">
  </head>

  <body ontouchstart>
    <script src="__PUBLIC__/Public/js/jquery-2.1.4.js"></script>
	<script src="__PUBLIC__/Public/js/jquery-weui.js"></script>
    <script type="text/javascript">
    	$.alert("{$error}",function() {
		  location.href = '{$jumpUrl}';
		});
		
	</script>
  </body>

  </html>
