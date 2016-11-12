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

<body>
<div class="header center pr f18">
      我的收藏
      <div class="head_go pa" onclick="history.go(-1)"><img src="/Public/Web/images/go.jpg"></div>
      <div class="head_click tra_head pa"><a id='all'>全选</a></div>
</div>


<div class="container">
	<div class="land">
		<div class="land_b map_title center  f14">
			<a class="a_title">游记</a>
			<a class="a_title" >民宿</a>
			<a class="a_title" >活动</a>
		</div>
   
		<div class="land_c f14 collect" style='display:none'>
			<?php if(is_array($note)): $i = 0; $__LIST__ = $note;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="n-<?php echo ($vo["id"]); ?>" value="n-<?php echo ($vo["id"]); ?>" class="chk_1"><label for="n-<?php echo ($vo["id"]); ?>"></label>
					</div>
					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
							<div class="land_f2 f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 vertical">
									<img src="<?php echo ($vo["head"]); ?>">
								</div>
								<div class="land_h tra_wc vertical">
									<div class="land_h1 f11 vertical">
										<img src="/Public/Web/images/land_d3.png">
									<span><?php echo ($vo["reviewnum"]); ?></span>条评论
									</div>
									<div class="land_h2 f11 vertical">
										<img src="/Public/Web/images/land_d4.png">
										<span><?php echo ($vo["hit"]); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>      
				</div><?php endforeach; endif; else: echo "" ;endif; ?>       
		</div>

		<div class="land_c f14 collect" style='display:none'>
			<?php if(is_array($houselist)): $i = 0; $__LIST__ = $houselist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="h-<?php echo ($vo["id"]); ?>" value="h-<?php echo ($vo["id"]); ?>" class="chk_1"><label for="h-<?php echo ($vo["id"]); ?>"></label>
					</div>
					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
							<div class="land_f2 f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 vertical">
									<img src="<?php echo ($vo["head"]); ?>">
								</div>
								<div class="land_h tra_wc vertical">
									<div class="land_h1 f11 vertical">
										<img src="/Public/Web/images/land_d3.png">
									<span><?php echo ($vo["reviewnum"]); ?></span>条评论
									</div>
									<div class="land_h2 f11 vertical">
										<img src="/Public/Web/images/land_d4.png">
										<span><?php echo ($vo["hit"]); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>      
				</div><?php endforeach; endif; else: echo "" ;endif; ?>       
		</div>

		<div class="land_c f14 collect" style='display:none'>
			<?php if(is_array($party)): $i = 0; $__LIST__ = $party;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="p-<?php echo ($vo["id"]); ?>" value="p-<?php echo ($vo["id"]); ?>" class="chk_1"><label for="p-<?php echo ($vo["id"]); ?>"></label>
					</div>
					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
							<div class="land_f2 f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 vertical">
									<img src="<?php echo ($vo["head"]); ?>">
								</div>
								<div class="land_h tra_wc vertical">
									<div class="land_h1 f11 vertical">
										<img src="/Public/Web/images/land_d3.png">
									<span><?php echo ($vo["reviewnum"]); ?></span>条评论
									</div>
									<div class="land_h2 f11 vertical">
										<img src="/Public/Web/images/land_d4.png">
										<span><?php echo ($vo["hit"]); ?></span>
									</div>
								</div>
							</div>
						</div>
					</div>      
				</div><?php endforeach; endif; else: echo "" ;endif; ?>       
		</div>
      
      <div class="fish_btm">
           <div class="fish_t center"><div class="fish_t1 fish_wt"><span></span><img src="/Public/Web/images/drop.jpg"></div></div>
           <div class="fish_s">
                   <div class="fish_list">
                       <div class="snail_d woc_height center f16">
                            <a class="snail_cut">删除</a>
                       </div>
                   </div>    
                    
                   <div class="fish_list">    
                       <div class="snail_d woc_height center f16">
                            <a href="<?php echo U('Web/Member/collect');?>" class="omg_ccc">取消</a>
                       </div>
                   </div>
            </div>       
      </div>
   </div>	   	
</div>
<script type="text/javascript">
	$(function(){
		var collect=$('.collect');
		var a_title=$('.a_title');
		a_title.eq(0).addClass('land_cut');
		collect.eq(0).show();
		a_title.click(function(){
			a_title.removeClass('land_cut');
			collect.hide();
			var a=$(this).index();
			a_title.eq(a).addClass('land_cut');
			collect.eq(a).show();
		});
		var snail_cut=$('.snail_cut');
		var date=
		snail_cut.click(function(){
			var text='';
			$("input:checkbox").each(function(){
				if($(this).attr("checked")=='checked'){
					text+=$(this).val()+'|';
				}
			});
			console.log(text);
			var data={'id':text};
			$.post("<?php echo U('Web/Member/editcollect');?>",data,function(res){
				console.log(res);
				if(res.code==200){
					alert(res.msg);
					console.log();
					var array=data.id.split('|');
				    for(var i = 0; i < array.length; i++) {
				        if(array[i].length == 0) array.splice(i,1);
				    }
				    for (var i = 0; i<array.length; i++) {
				    	console.log(array[i]);
				    	var div=$('#'+array[i]).parent().parent();
				    	div.remove();
				    }
				}
				else{
					alert(res.msg);
				}
			});
		});
		$('#all').click(function(){
			$(":checkbox").attr("checked", true);
		});
	});
</script>
</body>

</html>