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
    <link rel="stylesheet" href="/Public/Public/css/weui.css">
    <link rel="stylesheet" href="/Public/Public/css/jquery-weui.css">
    <link rel="stylesheet" href="/Public/Web/css/base.css">
    <link rel="stylesheet" href="/Public/Web/css/style.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery-ui.min.css">
    <script src="/Public/Web/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Public/js/jquery-weui.js"></script>
    <script src="/Public/Web/js/Action.js"></script>
    <script src="/Public/Web/js/TouchSlide.1.1.js"></script>
    <script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script src="/Public/public/js/jquery.cookie.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Public/Web/js/iscroll.js"></script>
    <link rel="stylesheet" href="/Public/Web/css/list.css">
    <script>
        $(function(){
            $('img.pic').lazyload({
               effect: 'fadeIn'
            });
        })
    </script>
</head>
<body>

<div class="header center pr f18">蜗牛客
      <div class="address f14 pa">
          <a href="search-3.html">城市<img src="/Public/Web/images/address.png"></a></div>
</div>
<div class="container">
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>
                <?php if(is_array($ad)): $i = 0; $__LIST__ = $ad;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a class="pic" href="javascript:;"><img src="<?php echo ($vo["image"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="hd">
            <ul></ul>
        </div>
    </div>
    <div class="land_c">
        <div class="search_box">
            <input type="text" class="search_text" placeholder="输入目的地、景点、民宿等关键词...">
            <input type="button" class="search_btn">
        </div>
        <!-- <button class='btn'>test</button> -->
        <div class="nav center">
            <a href="<?php echo U('Web/Note/index');?>">
                <img src="/Public/Web/images/tb_a1.png">
                游记</a>
            <a href="<?php echo U('Web/Party/index');?>">
                <img src="/Public/Web/images/tb_a2.png">
                活动</a>
            <a href="<?php echo U('Web/Hostel/index');?>">
                <img src="/Public/Web/images/tb_a3.png">
                民宿</a>
        </div>
    </div>
    <div class="recom  recom_ppt">
        <div class="recom_title f18 center">推荐游记</div>
        <?php if(is_array($data['note'])): $i = 0; $__LIST__ = $data['note'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
            <div class="recom_a pr">
              <a href="<?php echo U('Web/Note/show',array('id'=>$vo['id']));?>">
                   <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Web/images/default.jpg" style="width: 100%;height: 60vw;">
              </a>
              <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>"><div class="recom_d pa"><img src="<?php echo ($vo["head"]); ?>"></div></a>
            </div>
            <div class="recom_b pa"><?php if(($vo['type']) == "1"): ?><img src="/Public/Web/images/recom_a1.png"><?php endif; ?></div>
            <div class="recom_c pa"><div class="recom_gg notecollect <?php if($vo["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>" data-id="<?php echo ($vo["id"]); ?>"></div></div>
            <div class="recom_e">
              <div class="land_f1 recom_e1 f16"><?php echo ($vo["title"]); ?></div>
              <div class="recom_f">
                <div class="recom_f1 f12 fl"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
                <div class="recom_f2 fr">
                  <div class="land_h recom_f3 vertical">
                    <div class="land_h2 f12 vertical notehit" data-id="<?php echo ($vo["id"]); ?>">
                      <?php if($vo["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png">
                      <?php else: ?>
                        <img src="/Public/Web/images/poin.png"><?php endif; ?>
                      <span class="vcount"><?php echo ((isset($vo["hit"]) && ($vo["hit"] !== ""))?($vo["hit"]):"0"); ?></span>
                    </div>
                    <div class="land_h1 f12 vertical">
                      <img src="/Public/Web/images/land_d3.png">
                      <span><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></span>条评论 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

    <div class="recom">
        <div class="recom_title f18 center" style="color: #56c3cf">推荐活动</div>
        <?php if(is_array($data['party'])): $i = 0; $__LIST__ = $data['party'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
                     <div class="recom_a pr">
                           <a href="<?php echo U('Web/Party/show',array('id'=>$vo['id']));?>"><img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Web/images/default.jpg" style="width: 100%;height: 60vw"></a>
                           <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>"><div class="recom_d pa"><img src="<?php echo ($vo["head"]); ?>"></div></a>
                     </div>
                     <div class="recom_c pa"><div class="recom_gg partycollect <?php if($vo["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>" data-id="<?php echo ($vo["id"]); ?>"></div></div>
             
                    <div class="recom_e">
                           <div class="land_f1 recom_e1 f16"><?php echo ($vo["title"]); ?></div>
                           <div class="recom_k">
                                    <div class="land_font">
                                        <span>时间:</span> <?php echo (date('Y-m-d',$vo["starttime"])); ?> 至<?php echo (date('Y-m-d',$vo["endtime"])); ?>       
                                    </div> 
                                    <div class="land_font">
                                        <span>地点:</span> <?php echo getarea($vo['area']); echo ($vo["address"]); ?>        
                                    </div> 
                          </div>
                          <div class="recom_s f14">
                              已参与：
                              <span>
                                <?php if(is_array($vo["joinlist"])): $i = 0; $__LIST__ = $vo["joinlist"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><img src="<?php echo ($v["head"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
                              </span>
                              <em>(..<?php echo ((isset($vo["joinnum"]) && ($vo["joinnum"] !== ""))?($vo["joinnum"]):'0'); ?>人)</em>
                          </div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>

    <div class="recom">
        <div class="recom_title f18 center" style="color: #ff715f">推荐民宿</div>
        <?php if(is_array($data['hostel'])): $i = 0; $__LIST__ = $data['hostel'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
                         <div class="recom_a pr">
                              <a href="<?php echo U('Web/Hostel/show',array('id'=>$vo['id']));?>"><img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Web/images/default.jpg" style="width: 100%;height: 60vw"></a>
                               <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>"><div class="recom_d pa"><img src="<?php echo ($vo["head"]); ?>"></div></a>
                               <div class="recom_g f18 center pa">
                                   <div class="recom_g1 fl"><em>￥</em><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.00"); ?><span>起</span></div>
                                   <div class="recom_g2 fl"><?php echo ((isset($co["evaluation"]) && ($co["evaluation"] !== ""))?($co["evaluation"]):"10.0"); ?><span>分</span></div>
                               </div>
                         </div>
                         <div class="recom_c pa"><div class="recom_gg hostelcollect <?php if($vo["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>" data-id="<?php echo ($vo["id"]); ?>"></div></div>
                        <div class="recom_e">
                               <div class="land_f1 recom_e1 f16"><?php echo ($vo["title"]); ?></div>
                               <div class="recom_f">
                                <div class="recom_f1 recom_hong f12 fl"><img src="/Public/Web/images/add_e.png">距你  <?php echo ((isset($vo["distance"]) && ($vo["distance"] !== ""))?($vo["distance"]):"0.00"); ?>km</div>
                                    <div class="recom_f2 fr">
                                        <div class="land_h recom_f3 vertical">
                                              <div class="land_h2 f12 vertical hostelhit" data-id="<?php echo ($vo["id"]); ?>">
                                                <?php if($vo["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png">
                                                <?php else: ?>
                                                  <img src="/Public/Web/images/poin.png"><?php endif; ?>
                                                <span class="vcount"><?php echo ((isset($vo["hit"]) && ($vo["hit"] !== ""))?($vo["hit"]):"0"); ?></span>
                                              </div>
                                              <div class="land_h1 f12 vertical">
                                                    <img src="/Public/Web/images/land_d3.png">
                                                    <span><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></span>条评论
                                              </div>
                                          </div>
                                    </div>
                               </div>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div style="height: 8rem"></div>

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
<script type="text/javascript">
    TouchSlide({
        slideCell: "#slideBox",
        titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell: ".bd ul",
        effect: "leftLoop",
        autoPage: true,//自动分页
        autoPlay: true //自动播放
    });
</script>
<script>
    getLocation();
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
        else {
            console.log("该浏览器不支持获取地理位置。");
        }
    }
    function showPosition(position) {
        console.log(position.coords.longitude);
        console.log(position.coords.latitude);
        var data = { 'position': position.coords.longitude + ',' + position.coords.latitude };
        $.post("<?php echo U('Web/Index/cacheposition');?>", data, function (res) {
        });
    }
    $(function () {
        $(".notehit").click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/Web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var nid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Note/ajax_hit');?>",
                data: { 'nid': nid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.notecollect').click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/Web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var nid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Note/ajax_collect');?>",
                data: { 'nid': nid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
        $(".partyhit").click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/Web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var aid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Party/ajax_hit');?>",
                data: { 'aid': aid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.partycollect').click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/Web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var aid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Party/ajax_collect');?>",
                data: { 'aid': aid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
        $(".hostelhit").click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/Web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var hid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Hostel/ajax_hit');?>",
                data: { 'hid': hid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.hostelcollect').click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/Web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var hid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Hostel/ajax_collect');?>",
                data: { 'hid': hid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
    });
</script>