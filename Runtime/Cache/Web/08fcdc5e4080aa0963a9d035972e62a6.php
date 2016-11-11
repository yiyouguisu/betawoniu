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

<body class="back-f1f1f1">
    <div class="header center z-index112 pr f18">
        <div class="head_go pa" onclick="history.go(-1)">
            <img src="/Public/Web/images/go.jpg"></div>
        <div class="tra_pr hd_ck pa">
            <em>
                <?php if($data["iscollect"] == 1): ?><img src="/Public/Web/images/hj_a1_1.jpg" class='collect' data-id="<?php echo ($data["id"]); ?>">
                <?php else: ?>
                   <img src="/Public/Web/images/hj_a1.jpg" class='collect' data-id="<?php echo ($data["id"]); ?>"><?php endif; ?>
            </em>
            <em>
                <img src="/Public/Web/images/hj_a2.jpg"></em>
            <em>
                <img src="/Public/Web/images/hj_a3.jpg"></em>
        </div>
    </div>
    <div class="container padding_0">
        <div class="land">
            <div class="lpl_top">
                <div class="lpl_title">
                    <div class="lpl_a"><?php echo ($data["title"]); ?></div>
                    <div class="lpl_b f0">
                        <div class="lpl_b1 vertical">
                            <img src="<?php echo ($data["head"]); ?>"><?php echo ($data["nickname"]); ?></div>
                        <div class="lpl_b2 vertical"><em>发表于：</em><?php echo (date('Y-m-d',$data["inputtime"])); ?>
                           <span class='certical notehit' data-id="<?php echo ($data["id"]); ?>">
                               <?php if($data['ishit'] == 1): ?><img src="/Public/Web/images/poin_1.png"> 
                                <?php else: ?>
                                  <img src="/Public/Web/images/poin.png"><?php endif; ?>
                               <span id='vcount' style="margin-left: 0;"><?php echo ((isset($data["hit"]) && ($data["hit"] !== ""))?($data["hit"]):"0"); ?></span>
                           </span>
                        </div>
                    </div>
                </div>

                <div class="lpl_c">
                    <div class="lpl_c1">
                        <span>
                            <img src="/Public/Web/images/gh_a2.jpg">出发时间： </span>
                        <em><?php echo (date('Y-m-d',$data["begintime"])); ?></em></div>
                    <div class="lpl_c1">
                        <span>
                            <img src="/Public/Web/images/gh_a1.jpg">人均费用： </span>
                        <em>￥<?php echo ($data["fee"]); ?></em></div>
                    <div class="lpl_c1">
                        <span>
                            <img src="/Public/Web/images/gh_a3.jpg">人物： </span>
                        <em><?php echo ($data["noteman"]); ?></em></div>
                    <div class="lpl_c1">
                        <span>
                            <img src="/Public/Web/images/gh_a4.jpg">出行天数： </span>
                        <em><?php echo ((isset($data["days"]) && ($data["days"] !== ""))?($data["days"]):"0"); ?>天</em></div>
                    <div class="lpl_c1">
                        <span>
                            <img src="/Public/Web/images/gh_a5.jpg">形式： </span>
                        <em><?php echo ($data["notestyle"]); ?></em></div>
                    <div class="clearfix"></div>
                </div>

                <div class="lpl_d">
                    <?php if(is_array($data['content'])): $i = 0; $__LIST__ = $data['content'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="lpl_d2"><?php echo ($vo["content"]); ?></div>
                        <?php if(!empty($vo['thumb'])): ?><div class="lpl_d2"><img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Web/images/default.jpg" /></div><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>

                <div class="lpl_e">
                    <div class="lpl_f">
                        <div class="lpl_e1">文中出现过的民宿 :</div>
                        <div class="lpl_e2">
                            <?php if(is_array($data['note_hostel'])): $i = 0; $__LIST__ = $data['note_hostel'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span data-hid="<?php echo ($vo["hid"]); ?>" data-uid="<?php echo ($vo["uid"]); ?>"><?php echo ($vo["title"]); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                    <div class="lpl_f">
                        <div class="lpl_e1">文中出现过的景点 :</div>
                        <div class="lpl_e2">
                            <span>西湖</span>
                            <span>太湖</span>
                            <span>杭州灵隐寺</span>
                            <?php if(is_array($data['note_place'])): $i = 0; $__LIST__ = $data['note_place'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><span data-hid="<?php echo ($vo["hid"]); ?>" data-uid="<?php echo ($vo["uid"]); ?>">
                                <?php echo ($vo["title"]); ?>
                              </span><?php endforeach; endif; else: echo "" ;endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lpl_conments">
                <div class="trip_f">
                    <div class="trip_f1">评论区
                      <div class="trip_f2">
                          <img src="/Public/Web/images/land_d3.png">
                          <span><?php echo ((isset($data["reviewnum"]) && ($data["reviewnum"] !== ""))?($data["reviewnum"]):"0"); ?></span>条评论
                      </div>
                    </div>
                    <div class="trip_fBtm">
                        <?php if(is_array($comment)): $i = 0; $__LIST__ = $comment;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vp): $mod = ($i % 2 );++$i;?><div class="fans_list">
                              <div class="per_tx fl"><img src="<?php echo ($vp["head"]); ?>"></div>
                              <div class="fans_b per_tr fl">
                                  <div class="fans_b1 f16"><?php echo ($vp["nickname"]); ?></div> 
                                  <div class="fans_b2 f14"><?php echo ($vp["content"]); ?></div> 
                                  <div class="fans_time f13"><?php echo (date('Y-m-d',$vp["inputtime"])); ?></div>
                              </div>
                          </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="trip_t">
                        <input type="text" placeholder="发布我的评论 ..." class="trip_text fl">
                        <input type="button" value="90+ 评论" class="trip_button fr"
                            onclick="location.href='<?php echo U('Web/Review/index',array('type'=>0,'id'=>$id));?>'">
                    </div>
                </div>
            </div>

            <div class="mth pr">
                <div class="mth_top pa">附近民宿推荐</div>
                <div id="dom-effect" class="iSlider-effect"></div>
                <div class="mth_a center">
                    <span>
                        <a href="<?php echo U('Web/Hostel/index');?>">查看更多</a></span>
                    <div class="mth_a2"></div>
                </div>
            </div>

            <div class="mth pr" style="margin-top: 20px;">
                <div class="mth_top pa">附近活动推荐</div>
                <div id="mth_dom" class="iSlider-effect"></div>
                <div class="mth_a center">
                    <span>
                        <a href="<?php echo U('Web/Party/index');?>">查看更多</a></span>
                    <div class="mth_a2"></div>
                </div>
            </div>

            <div class="mth_c">
                <div class="lpl_f">
                    <div class="lpl_e1">已选 :</div>
                    <div class="lpl_e2">
                        <!-- <span>君悦</span>
                        <span>儒家</span>
                        <span>西湖森林客栈</span> -->
                    </div>
                </div>
            </div>
            <div class="snail_d center trip_btn f16" style="margin: 0rem">
                <a href="person-3.html" class="snail_cut">添加到行程</a>
            </div>
        </div>
    </div>
    <script src="/Public/Web/js/islider.js"></script>
    <script src="/Public/Web/js/islider_desktop.js"></script>

    <script>
        
        var note_near_hostel=<?php echo ($data["note_near_hostel"]); ?>;
        var domList = [];
        $.each(note_near_hostel,function(i,value){
          domList[i]={
            'height' : '100%',
            'width' : '100%',
            'content' :'<div class="recom_list pr"><div class="recom_a recomhostel pr"><img src="'+value.thumb+'"><div class="recom_g f18 center pa"><div class="recom_g1 fl"><em>￥</em>'+value.money+'<span>起</span></div><div class="recom_g2 fl">'+value.evaluation+'<span>分</span></div></div></div><div class="recom_e"><div class="land_f1 recom_e1 f16">'+value.address+'</div><div class="recom_f"><div class="recom_f1 recom_hong f12 fl"><img src="/Public/Web/images/add_e.png">距你  '+value.distance+'km</div><div class="recom_f2 fr"><div class="land_h recom_f3 vertical"><div class="land_h2 vertical"><img src="/Public/Web/images/poin.png"> <span>'+value.hit+'</span></div><div class="land_h1 vertical"><img src="/Public/Web/images/land_d3.png"><span>'+value.reviewnum+'</span>条评论</div></div></div></div></div></div>'
          };
        });
        var islider4 = new iSlider({
            data: domList,
            dom: document.getElementById("dom-effect"),
            type: 'dom',
            animateType: 'depth',
            isAutoplay: false,
            isLooping: true,
        });
        islider4.bindMouse();
    
        var note_near_activity=<?php echo ($data["note_near_activity"]); ?>;
        var mthList = [];
        $.each(note_near_activity,function(i,value){
            var html='';
            html+='<div class="recom_list"><div class="recom_a recomparty pr"><img src="'+value.thumb+'"></div><div class="recom_e">';
            html+='<div class="land_f1 recom_e1 f16">'+value.title+'</div>';
            html+='<div class="recom_k">';
            html+='<div class="land_font"><span>时间:</span> '+value.starttime+' 至'+value.endtime+'</div>';
            html+=' <div class="land_font"><span>地点:</span> '+value.address+' </div>';
            html+='</div></div></div>';
            mthList[i]={
              'height' : '100%',
              'width' : '100%',
              'content' :html
            };
        });
        var islider4 = new iSlider({
              data: mthList,
              dom: document.getElementById("mth_dom"),
              type: 'dom',
              animateType: 'depth',
              isAutoplay: false,
              isLooping: true,
        });
        islider4.bindMouse();
  
    </script>
    <script type="text/javascript">
        $(function () {
            $(".notehit").live("click",function(){
                var obj=$(this);
                var uid='<?php echo ($user["id"]); ?>';
                if(!uid){
                    alert("请先登录！");
                    var p={};
                    p['url']="/index.php/Web/Note/show/id/118.html";
                    $.post("<?php echo U('Home/Public/ajax_cacheurl');?>",p,function(data){
                        if(data.code=200){
                            window.location.href="<?php echo U('Home/Member/login');?>";
                        }
                    })
                    return false;
                }
                var hitnum=$(this).find("#vcount");
                var nid=$(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "<?php echo U('Home/Note/ajax_hit');?>",
                    data: {'nid':nid},
                    dataType: "json",
                    success: function(data){
                        if(data.status==1){
                            if(data.type==1){
                                var num=Number(hitnum.text()) + 1;
                                hitnum.text(num);
                                obj.find("img").attr("src","/Public/Web/images/poin_1.png");
                            }else if(data.type==2){
                                var num=Number(hitnum.text()) - 1;
                                hitnum.text(num);
                                obj.find("img").attr("src","/Public/Web/images/poin.png");
                            }
                        }else if(data.status==0){
                            alert("点赞失败！");
                        }
                    }
                });
            });
            $(".collect").live("click",function(){
                var obj=$(this);
                var uid='<?php echo ($user["id"]); ?>';
                if(!uid){
                    alert("请先登录！");
                    var p={};
                    p['url']="/index.php/Web/Note/show/id/118.html";
                    $.post("<?php echo U('Web/Public/ajax_cacheurl');?>",p,function(data){
                        if(data.code=200){
                            window.location.href="<?php echo U('Web/Member/login');?>";
                        }
                    })
                    return false;
                }
                var nid=$(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "<?php echo U('Web/Note/ajax_collect');?>",
                    data: {'nid':nid},
                    dataType: "json",
                    success: function(data){
                        if(data.status==1){
                            if(data.type==1){
                                obj.attr("src","/Public/Web/images/hj_a1_1.jpg");
                            }else if(data.type==2){
                                obj.attr("src","/Public/Web/images/hj_a1.jpg");
                            }
                        }else if(data.status==0){
                            alert("收藏失败！");
                        }
                    }
                });
            });
       
        });
    </script>
</body>
</html>