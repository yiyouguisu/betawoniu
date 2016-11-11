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
<div class="container">
	<div class="land">
          <div class="land_top center pr">
                  <div class="land_bj pr"><img src="/Public/Web/images/top_bj_f.jpg">
                      <div class="land_go pa" onclick="history.go(-1)"><img src="/Public/Web/images/go.png"></div> 
                  </div>
                  <div class="land_a pa">
                        <div class="land_a1"><img src="<?php echo ($data["head"]); ?>"></div>
                        <div class="land_a2 margin_05 write f16"><?php echo ($data["nickname"]); ?></div>
                        <a href="<?php echo U('Web/Member/myfans',array('id'=>$data['id']));?>">
                        	<div class="land_a3 margin_05 write f14">关注: <?php echo ((isset($follow) && ($follow !== ""))?($follow):"0"); ?> | 粉丝: <?php echo ((isset($fans) && ($fans !== ""))?($fans):"0"); ?></div>
                        </a>
                        <div class="land_a4 margin_05 write f14 pr">
                        	  <?php echo ($data["info"]); ?>
                        </div>
                        <div class="land_a5 margin_05 write f14">
							<?php $_result=getlinkage(2);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(in_array(($vo['name']), is_array($data["hobby"])?$data["hobby"]:explode(',',$data["hobby"]))): echo ($vo["name"]); ?>、<?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                        <?php if($ismy == 1): ?><div class="land_a6 margin_05 f14"><a href="" class="mr_5">+ 关注</a><a href="">私信</a></div><?php endif; ?>
                  </div>
          </div>

          <div class="land_btm">
				<div class="land_b person_title center f16">
					<a class="my">我的游记（<?php echo ($cnote); ?>）</a>
					<a class='my'>我的评论（<?php echo ($creview); ?>）</a>
				</div>            
				<div class="land_c f14 comments_box" style='display:none'>
					<?php if(is_array($note)): $i = 0; $__LIST__ = $note;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Web/Note/show',array('id'=>$vo['id']));?>">
							<div class="land_d pr f0">
								<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
								<div class="land_f vertical">
									<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
									<div class="land_f2 f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
									<div class="land_f3 pa f0">
										<div class="land_f4 vertical">
											<img src="/Public/Web/images/land_d2.png">
										</div>
										<div class="land_h tra_wc vertical">
											<div class="land_h1 f11 vertical">
												<img src="/Public/Web/images/land_d3.png">
												<span>188</span>条评论
											</div>
											<div class="land_h2 f11 vertical">
												<img src="/Public/Web/images/land_d4.png">
												<span>68</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a><?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
          </div>	


		<div class="land_btm re">
			<div class="comments_box" style='display:none'>
				<?php if(is_array($notedata)): $i = 0; $__LIST__ = $notedata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Web/Note/show',array('id'=>$vo['nid']));?>">
						<div class="comments">
							<div class="com_top pr">
								<div class="com_a f16"><?php echo ($vo["title"]); ?></div>
								<div class="com_b f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
								<div class="com_c com_c1 pa">游记</div>
							</div>
							<div class="com_btm f14">
								<?php echo ($vo["id1"]); ?>评论内容：<?php echo ($vo["content"]); ?>
							</div>
						</div>
					</a><?php endforeach; endif; else: echo "" ;endif; ?>

				<?php if(is_array($activityreview)): $i = 0; $__LIST__ = $activityreview;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Web/Party/show',array('id'=>$vo['pid']));?>">
						<div class="comments">
							<div class="com_top pr">
								<div class="com_a f16"><?php echo ($vo["title"]); ?></div>
								<div class="com_b f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
								<div class="com_c com_c2 pa">活动</div>
							</div>
							<div class="com_btm f14">
								<?php echo ($vo["content"]); ?>
							</div>
						</div>
					</a><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>	
	</div>	   	
</div>
<script type="text/javascript">
	$(function(){
		var my=$('.my');
		var comments_box=$('.comments_box')
		my.eq(0).addClass('land_cut');
		comments_box.eq(0).show();
		my.click(function(){
			my.removeClass('land_cut');
			comments_box.hide();
			my.eq($(this).index()).addClass('land_cut');
			comments_box.eq($(this).index()).show();
		});
	});
	
</script>
</body>

</html>