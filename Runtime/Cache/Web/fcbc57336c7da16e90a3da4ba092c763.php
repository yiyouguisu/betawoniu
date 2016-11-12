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
    <script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script src="/Public/public/js/jquery.cookie.js" type="text/javascript"></script>
    <script>
        $(function(){
            $('img.pic').lazyload({
               effect: 'fadeIn'
            });
        })
    </script>
</head>
<body>


<body>
<div class="header center pr f18">
      我发布的民宿
      <div class="head_go pa" onclick="history.go(-1)"><img src="/Public/Web/images/go.jpg"></div>
      <div class="head_click tra_head pa"><a href="<?php echo U('Web/Member/editmymerchant');?>">编辑</a></div>
</div>


<div class="container">
   <div class="land">
       <div class="omg_a">我目前有<?php echo ($count); ?>个民宿</div>
       <div class="land_c f14">
       		<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="land_d pr f0">
					<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
					<div class="land_f vertical">
						<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
						<div class="land_f2 f13">
							<div class="land_money f20"><em>￥</em><?php echo ($vo["money"]); ?><span>起</span>
							</div>
						</div>
						<div class="land_f3 pa f0">
							<div class="land_f4 my_tra1 vertical">
								<span class="my_span1"><?php if($vo["status"] == '1'): ?>审核中<?php else: ?>进行中<?php endif; ?></span>
							</div>
						</div>
					</div>
            	</div><?php endforeach; endif; else: echo "" ;endif; ?>
      
      </div>
   </div>	   	
</div>

</body>

</html>