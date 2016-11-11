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
<div class="container padding_0">
   <div class="land">
                <div class="act_g pr">
                    <div class="act_g1"><img src="<?php echo ($data["thumb"]); ?>"  style="width: 100%;height: 60vw;"></div>
                    <div class="history pa"><a href="" onclick="history.go(-1)"><img src="/Public/Web/images/go.png"></a><span>&nbsp;</span></div>
                    <div class="recom_c pa"><div class="recom_gg collect <?php if($data["iscollect"] == 1): ?>recom_c_cut<?php endif; ?> "  data-id="<?php echo ($data["id"]); ?>"></div>
                                            <span><a href=""><img src="/Public/Web/images/share.png"></a></span>
                                            <span><a href=""><img src="/Public/Web/images/recom_a3.png"></a></span>
                    </div>
                    <div class="act_g2 f16 center pa">
                            <em>￥</em><span><?php echo ((isset($data["money"]) && ($data["money"] !== ""))?($data["money"]):"0.00"); ?></span><em>起</em>
                    </div>
               </div>  

               
               <div class="det_box">
                       <div class="act_k">
                            <div class="act_k1 vertical"><?php echo ($data["title"]); ?></div>
                            <div class="act_k2 vertical hit" data-id="<?php echo ($data["id"]); ?>" >
                                <?php if($data["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png">
                                <?php else: ?>
                                  <img src="/Public/Web/images/poin.png"><?php endif; ?>
                                <?php echo ((isset($data["hit"]) && ($data["hit"] !== ""))?($data["hit"]):"0"); ?>
                            </div>
                       </div>
                       
                       <div class="edg">
                           <div class="edg_a fl">
                                      <div class="edg_b"><?php echo ((isset($data["evaluation"]) && ($data["evaluation"] !== ""))?($data["evaluation"]):"10.0"); ?><span>分</span></div>
                                      <div class="edg_c">
                                          <span><img src="/Public/Web/images/star.png"></span>
                                          <span><img src="/Public/Web/images/star.png"></span>
                                          <span><img src="/Public/Web/images/star.png"></span>
                                          <span><img src="/Public/Web/images/star.png"></span>
                                          <span><img src="/Public/Web/images/star.png"></span>
                                      </div>
                           </div>
                           <a href="homestay-2.html"><div class="edg_d fr">
                               <img src="/Public/Web/images/edg_a1.jpg"> <?php echo ((isset($data["reviewnum"]) && ($data["reviewnum"] !== ""))?($data["reviewnum"]):"0"); ?>条评论 <span><img src="/Public/Web/images/arrow.jpg"></span>
                           </div></a>
                       </div>
                       
                       <div class="vb_a">
                            <div class="land_font pr">
                                <span>地址:</span> <?php echo getarea($data['area']); echo ($data["address"]); ?>
                                <div class="vb_a1 pa">
                                      <img src="/Public/Web/images/add_e.png">距你  5.6km
                                </div>        
                            </div> 
                            
                            <div class="vb_b"><img src="/Public/Web/images/map_2.jpg"></div>
                       </div>
                       
 
               </div>
               
               <div class="snake">
                    <div class="vb_c1 snake_a center">我们的房间</div>
                        <?php if(is_array($data["room"])): $i = 0; $__LIST__ = $data["room"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Web/Hostel/room',array('id'=>$vo['rid']));?>">
                                <div class="snake_list f14">
                                       <div class="land_d pr f0">
                                            <div class="land_e vertical"><img src="<?php echo ($vo["thumb"]); ?>"></div>
                                            <div class="land_f vertical">
                                                  <div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
                                                  <div class="land_f2 f13"><?php echo ($data["area"]); ?>M<sup>2</sup> <?php echo ($vo["bedtype"]); ?></div>
                                                  <div class="land_f3 pa f0">
                                                        <div class="land_money f20"><em>￥</em> <?php echo ($vo["money"]); ?>
                                                                                     <span>起</span>
                                                        </div>
                                                  </div>
                                            </div>
                                       </div>
                                </div>
                            </a><?php endforeach; endif; else: echo "" ;endif; ?>
                        
                        <div class="scr_d snake_b center">显示全部<?php echo ($roomcount); ?>个房间<img src="/Public/Web/images/drop_f.jpg"></div> 
               </div>
               
               <div class="vb_d center">
                    <div class="land_a center">
                            <div class="land_a1 snake_c"><a href="homestay-1.html"><img src="/Public/Web/images/land_a.png"></a></div>
                            <div class="land_a2 home_d1 margin_05 f16">蔡小亮</div>
                            <div class="home_d2 margin_05">
                                  <div class="home_d3 vertical mr_4"><img src="/Public/Web/images/home_a1.png">实名认证</div>
                            </div>                  
                    </div>
                    <div class="vb_d1"><a href=""><img src="/Public/Web/images/vb_a.jpg">在线咨询</a></div> 
                    <div style="height:1rem"></div>
               </div>
               
               <div class="vb_c ">
                    <div class="vb_c1 center">民宿描述</div>
                    <div class="vb_c2">
                            <?php echo ($data["description"]); ?>
                    </div>
                    <div class="vb_c3 snake_click"><a href="javascript:;">查看完整民宿描述</a></div>
               </div>
               
               <div class="vb_c" style="padding-bottom:0;">
                    <div class="vb_c1 center">配套设施</div>
                    <div class="snake_btm">
                        <?php if(is_array($roomcate)): foreach($roomcate as $k=>$vo): ?><div class="snake_e">
                                <?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><div class="snake_e1"><img src="<?php echo ($svo["thumb"]); ?>"><?php echo ($svo["catname"]); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
                                
                            </div><?php endforeach; endif; ?>
                    </div>
               </div>
               
               <div class="snake_m ">
                    <div class="vb_c1 center snake_kl" style="margin:0 2.5%;">退订规则</div>
                    <?php echo ($data["content"]); ?>
                    <div class="snake_small">该规则由房东制定</div>
               </div>
               
               <div class="mth pr">
                   <div class="mth_top pa">附近活动推荐</div>
                   <div id="mth_dom" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
               
               <div class="mth pr" style="margin-top:20px;">
                   <div class="mth_top pa">附近民宿推荐</div>
                   <div id="dom-effect" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
     
              
   </div>   
</div>


<div class="big_mask"></div>
<div class="pyl">
    <div class="pyl_top pr">房间简介
        <div class="pyl_close pa"><img src="/Public/Web/images/close.jpg"></div>
    </div>
    <div class="pyl_font">
        <?php if(is_array($data['imglist'])): foreach($data['imglist'] as $k=>$vo): ?><img src="<?php echo ($vo); ?>"><?php endforeach; endif; ?>
         <div class="snail_d homen_style center f16" >
                <a href="javescript:;" class="common_click" style="width:100%">我知道了</a>
         </div>
    </div>
    
    

</div>

<script type="text/javascript">
  $(function(){
    collect();
    hit();
  })
    function collect(){
        // 收藏
        $('.collect').click(function(){
          var self=$(this);
          var id=self.data('id');
          var data={'type':2,'id':id};
          console.log(data);
          $.post("<?php echo U('Web/Ajaxapi/collection');?>",data,function(res){
            console.log(res);
            if(res.code==200)
            {
              self.addClass('recom_c_cut');
            }
            else if(res.code==300){
              self.removeClass('recom_c_cut');
            }
            else{
              alert(res.msg);
            }
          });
        })
    }

    function hit(){
        // 收藏
        $('.hit').click(function(){
          var self=$(this);
          var id=self.data('id');
          var data={'type':2,'id':id};
          var hit=self.text();
          console.log(data);
          $.post("<?php echo U('Web/Ajaxapi/hit');?>",data,function(res){
            console.log(res);
            if(res.code==200)
            {
                self.find('span').text(Number(hit)+1)
                self.find('img').attr('src','/Public/Web/images/poin_1.png');
            }
            else if(res.code==300){
                self.find('span').text(Number(hit)-1)
                self.find('img').attr('src','/Public/Web/images/poin.png');
            }
            else{
              alert(res.msg);
            }
          });
        })
    }
</script>
<input type='hidden' id='getid' value='<?php echo ($id); ?>'> 
<script src="/Public/Web/js/islider.js"></script>
<script src="/Public/Web/js/islider_desktop.js"></script>

<script>
        var id=document.getElementById('getid').value;
        var data={'id':id};
        $.post("<?php echo U('Web/Note/acc');?>",data,function(res){
          // console.log(res);
          var domList = [];
          $.each(res,function(i,value){
            domList[i]={
              'height' : '100%',
              'width' : '100%',
              'content' :'<div class="recom_list pr"><div class="recom_a recomhostel pr"><img src="'+value.thumb+'"><div class="recom_g f18 center pa"><div class="recom_g1 fl"><em>￥</em>'+value.money+'<span>起</span></div><div class="recom_g2 fl">'+value.evaluation+'<span>分</span></div></div></div><div class="recom_e"><div class="land_f1 recom_e1 f16">'+value.address+'</div><div class="recom_f"><div class="recom_f1 recom_hong f12 fl"><img src="/Public/Web/images/add_e.png">距你  '+value.distancekm+'km</div><div class="recom_f2 fr"><div class="land_h recom_f3 vertical"><div class="land_h2 vertical"><img src="/Public/Web/images/poin.png"> <span>'+value.hit+'</span></div><div class="land_h1 vertical"><img src="/Public/Web/images/land_d3.png"><span>'+value.reviewnum+'</span>条评论</div></div></div></div></div></div>'
            };
          });
          // console.log(domList);
          var islider4 = new iSlider({
              data: domList,
              dom: document.getElementById("dom-effect"),
              type: 'dom',
              animateType: 'depth',
              isAutoplay: false,
              isLooping: true,
          });
          islider4.bindMouse();

        });
</script>


<script>

      
        console.log(data);
        $.post("<?php echo U('Web/Note/act');?>",data,function(res){
          console.log(res);
          var mthList = [];
          $.each(res,function(i,value){
            console.log(value);
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
          //滚动dom
          var islider4 = new iSlider({
              data: mthList,
              dom: document.getElementById("mth_dom"),
              type: 'dom',
              animateType: 'depth',
              isAutoplay: false,
              isLooping: true,
          });
          islider4.bindMouse();

        });

</script>


</body>

</html>