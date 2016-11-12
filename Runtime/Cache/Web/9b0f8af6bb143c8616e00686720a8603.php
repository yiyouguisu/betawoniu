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

<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      我的
      <div class="per_header pa"><a href="<?php echo U('Web/Member/set');?>"><img src="/Public/Web/images/home_v1.jpg"></a><i>&nbsp;</i></div>
      <div class="tra_pr hd_ck home_header home_ck1 pa"><img src="/Public/Web/images/hj_a2.jpg"><span>分享APP</span></div>
</div>
<div class="container">
      <div class="son_top pr f0">
              <div class="son_a vertical"><a href="<?php echo U('Web/Member/myinfo');?>"><img src="<?php echo ($data["head"]); ?>"></a></div>
              <div class="son_b vertical">
                    <div class="son_b1 f20"><?php echo ($data["nickname"]); ?></div>
                    <div class="son_b2 f14"><em>关注: <?php echo ((isset($follow) && ($follow !== ""))?($follow):"0"); ?></em><span>粉丝: <?php echo ((isset($fans) && ($fans !== ""))?($fans):"0"); ?></span></div>
              </div>
              <div class="set_a pa"><a href="<?php echo U('Web/Member/memberHome',array('id'=>$data['id']));?>">个人主页<img src="/Public/Web/images/set_right.jpg"></a></div>
      </div> 
      
      <div class="set_b">
              <a href="<?php echo U('Web/Member/publicnote');?>"><div class="help_list">
               <div class="help_a"><img src="/Public/Web/images/set_a1.jpg"> 我要发布游记</div>
              </div></a> 
      </div>
      
      <div class="set_b">
            <a href="my-merchant1.html">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/mer_a1.jpg"> 我的钱包</div>
                </div>
            </a> 
              
            <a href="<?php echo U('Web/Member/mymerchant');?>"><div class="help_list">
                <div class="help_a"><img src="/Public/Web/images/mer_a2.jpg"> 我发布的民宿</div>
            </div></a>
              
            <a href="<?php echo U('Web/Member/myact');?>"><div class="help_list">
                <div class="help_a"><img src="/Public/Web/images/mer_a3.jpg"> 我发布的活动</div>
            </div></a>

            <a href="<?php echo U('Web/Member/couponInfo');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a2.jpg"> 我的优惠券</div>
                </div>
            </a> 
            <a href="<?php echo U('Web/Member/orderlist');?>">
                <div class="help_list">
                    <div class="help_a">
                        <img src="/Public/Web/images/set_a3.jpg"> 我的订单
                        <sup><img src="/Public/Web/images/point.jpg"></sup><span>(6)</span>
                    </div>
                </div>
            </a>

            <a href="<?php echo U('Web/Member/mynote');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a4.jpg"> 我的游记</div>
                </div>
            </a> 

            <a href="<?php echo U('Web/Member/collect');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a5.jpg"> 我的收藏</div>
                </div>
            </a> 
            <a href="<?php echo U('Web/Member/useinfo');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a6.jpg"> 帮助手册</div>
                </div>
            </a> 
            <a href="">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a7.jpg"> 邀请好友注册</div>
                </div>
            </a> 
      </div>
      
      <div class="set_c">
         <div class="snail_d center trip_btn f16">
                  <a href="<?php echo U('Web/Member/realname');?>" class="snail_cut ">我要实名认证</a>
         </div>
      </div>
      
      <div style="height:4rem"></div>

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