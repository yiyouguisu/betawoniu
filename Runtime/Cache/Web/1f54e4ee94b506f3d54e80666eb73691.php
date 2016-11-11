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
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="/Public/Web/images/go.jpg"></a><span>&nbsp;</span></div>
      <div class="head_click tra_head pa"><a id="all">全选</a></div>
</div>


<div class="container">
	<div class="land">
		<div class="land_c f14">
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="sec-<?php echo ($vo["id"]); ?>" value="<?php echo ($vo["id"]); ?>" class="chk_1"><label for="sec-<?php echo ($vo["id"]); ?>"></label>
					</div>

					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
							<div class="land_f2 f13">
								<div class="land_money f20"><em>￥</em><?php echo ($vo["money"]); ?><span>起</span>
								</div>
							</div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 my_tra1 vertical"><span class="my_span1">进行中</span></div>
							</div>
						</div>
					</div>      
				</div><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<div class="fish_btm">
			<div class="fish_t center">
				<div class="fish_t1 fish_wt">
					<span></span><img src="/Public/Web/images/drop.jpg">
				</div>
			</div>
			<div class="fish_s">
				<div class="fish_list">    
					<div class="snail_d center f16">
						<a class="snail_cut del">下架</a>
					</div>
				</div>    
				<div class="fish_list">    
					<div class="snail_d center f16">
						<a href="" class="omg_ccc">取消</a>
					</div>
				</div>
			</div>       
		</div>
	</div>	   	
</div>
<script type="text/javascript">
$(function(){
	var del=$('.del');
	del.click(function(){
		var text='';
		$("input:checkbox").each(function(){
			if($(this).attr("checked")=='checked'){
				text+=$(this).val()+',';
			}
		});
		text=text.substr(0,text.length-1);
		console.log(text);
		var data={'id':text};
		console.log(data);
		$.post("<?php echo U('Web/Member/editmymerchant');?>",data,function(res){
			if(res.code==200){
				console.log(data.id);
				var array=data.id.split(',');
				// 去空值
				for(var i = 0; i < array.length; i++) {
					if(array[i].length == 0) array.splice(i,1);
				}
				for (var i = 0; i<array.length; i++) {
					console.log(array[i]);
					var div=$('#sec-'+array[i]).parent().parent();
					div.remove();
				}
			}
		});
	});



	$('#all').click(function(){
		$(":checkbox").attr("checked", true);
	});
})
</script>
</body>

</html>