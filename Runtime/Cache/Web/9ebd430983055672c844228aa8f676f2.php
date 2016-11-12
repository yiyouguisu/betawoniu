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

<div class="header center pr f18">
      我的收藏
      <div class="head_go pa" onclick="history.go(-1)"><img src="/Public/Web/images/go.jpg"></div>
      <div class="head_click tra_head pa"><a href="<?php echo U('Web/Member/editcollect');?>">编辑</a></div>
</div>
<div class="container">
   <div class="land">
       <div class="land_b map_title center  f14">
                       <a class="a_title">游记</a>
                       <a class="a_title" >民宿</a>
                       <a class="a_title" >活动</a>
       </div>

   		<!-- 游记 -->
		<div class="land_c f14 collect" style='display:none'>
			<?php if(is_array($note)): $i = 0; $__LIST__ = $note;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Web/Note/show',array('id'=>$vo['nid']));?>">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
							<div class="land_f2 f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
							<div class="land_f3 pa f0">
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
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<!-- 名宿 -->
		<div class="land_c f14 collect" style='display:none'>
			<?php if(is_array($houselist)): $i = 0; $__LIST__ = $houselist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Web/Hostel/show',array('id'=>$vo['hid']));?>">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
							<div class="land_f2 f13">
								<div class="land_money f20"><em>￥</em><?php echo ($vo["price"]); ?><span>起</span>
								</div>
							</div>
							<div class="land_f3 pa f0">
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
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
		</div>
		<!-- 活动 -->
		<div class="land_c f14 collect" style='display:none'>
			<?php if(is_array($party)): $i = 0; $__LIST__ = $party;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Web/Party/show',array('id'=>$vo['aid']));?>">
					<div class="land_d pr f0">
						<div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
							<div class="land_f3 fich_kk f0">
								<div class="land_font">
									<span>时间:</span> <?php echo ($vo["starttime"]); ?> 至<?php echo ($vo["endtime"]); ?>        
								</div> 
								<div class="land_font">
									<span>地点:</span> <?php echo ($vo["address"]); ?>        
								</div>
								<div class="land_font">
									<span>已参与:</span> 20人        
								</div> 
							</div>
						</div>
					</div>
				</a><?php endforeach; endif; else: echo "" ;endif; ?>
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
	});
</script>

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