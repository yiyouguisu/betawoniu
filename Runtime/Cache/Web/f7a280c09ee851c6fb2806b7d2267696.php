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
      活动详细
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="/Public/Web/images/go.jpg"></a><span>&nbsp;</span></div>
      <div class="tra_pr hd_ck pa"><em>&nbsp;</em><em><img src="/Public/Web/images/hj_a2.jpg"></em>
      </div>
</div>

<div class="container padding_0">
   <div class="land">
               <div class="act_g pr">
                    <div class="act_g1"><img src="<?php echo ($data["thumb"]); ?>" style="width: 100%;height: 60vw;"></div>
                    <div class="recom_c pa"><div class="recom_gg collect <?php if($data["iscollect"] == 1): ?>recom_c_cut<?php endif; ?> "></div>
                                            <span><a href-""><img src="/Public/Web/images/recom_a3.png"></a></span>
                    </div>
                    <div class="act_g2 f16 center pa">
                            报名费：<em>￥</em><span><?php echo ((isset($data["money"]) && ($data["money"] !== ""))?($data["money"]):"0.00"); ?></span>
                    </div>
               </div>  
               
               <div class="det_box">
                       <div class="act_k">
                            <div class="act_k1 vertical"><?php echo ($data["title"]); ?></div>
                            <div class="act_k2 vertical">
                              <?php if($data["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png"> 
                              <?php else: ?>
                                <img src="/Public/Web/images/poin.png"><?php endif; ?>
                              <span id='vcount'><?php echo ($data["hit"]); ?></span>
                            </div>
                       </div>
                       <div class="vb_a">
                            <div class="land_font">
                                <span>时间:</span> <?php echo (date("Y-m-d",$data["starttime"])); ?> 至 <?php echo (date("Y-m-d",$data["endtime"])); ?>       
                            </div> 
                            <div class="land_font">
                                <span>地点:</span> <?php echo getarea($data['area']); echo ($data["address"]); ?>      
                            </div> 
                            <div class="land_font pr">
                                <span>人数:</span> 限定<?php echo ((isset($data["start_numlimit"]) && ($data["start_numlimit"] !== ""))?($data["start_numlimit"]):'0'); ?>-<?php echo ((isset($data["end_numlimit"]) && ($data["end_numlimit"] !== ""))?($data["end_numlimit"]):'0'); ?>人
                                <div class="vb_a1 pa">
                                      <img src="/Public/Web/images/add_e.png">距你  5.6km
                                </div>        
                            </div> 
                            
                            <div class="vb_b"><img src="/Public/Web/images/map_2.jpg"></div>
                            <div class="recom_s f14">
                                  已参与：
                                  <span>
                                      <?php if(is_array($data["joinlist"])): $i = 0; $__LIST__ = $data["joinlist"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><img src="<?php echo ($svo["head"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
                                  </span>
                                  <em>(..<?php echo ($data["joinnum"]); ?>人)</em>
                            </div>
                       </div>
                       
 
               </div>
               
               <div class="vb_c ">
                    <div class="vb_c1 center">活动简介</div>
                    <div class="vb_c2"><?php echo ($data["content"]); ?></div>
               </div>
               
               <div class="vb_d center">
                    <div class="vb_c1 ">活动发起人</div>
                    <div class="land_a center">
                            <div class="land_a1"><img src="<?php echo ($data["head"]); ?>"></div>
                            <div class="land_a2 home_d1 margin_05 f16"><?php echo ($data["nickname"]); ?></div>
                            <div class="home_d2 margin_05">
                                  <div class="home_d3 vertical mr_4"><img src="/Public/Web/images/home_a1.png">实名认证</div>
                            </div>                  
                    </div>
                    <div class="vb_d1"><a href=""><img src="/Public/Web/images/vb_a.jpg">在线咨询</a></div> 
               </div>
                  
               <div class="lpl_conments">
                    <div class="trip_f">
                            <div class="trip_f1">评论区
                 <div class="trip_f2">
                        <img src="/Public/Web/images/land_d3.png">
                        <span><?php echo ($data["reviewnum"]); ?></span>条评论
                 </div>
            </div>
                            <div class="trip_fBtm">
                                 <?php if(is_array($data['reviewlist'])): $i = 0; $__LIST__ = $data['reviewlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="fans_list">
                                        <div class="per_tx fl"><img src="<?php echo ($vo["head"]); ?>"></div>
                                        <div class="fans_b per_tr fl">
                                            <div class="fans_b1 f16"><?php echo ($vo["nickname"]); ?></div> 
                                            <div class="fans_b2 f14"><?php echo ($vo["content"]); ?></div> 
                                            <div class="fans_time f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
                                        </div>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>
            
                            <div class="trip_t">
                                  <input type="text" placeholder="发布我的评论 ..." class="trip_text fl">
                                  <input type="button" value="90+ 评论" class="trip_button fr" 
                                       onclick="location.href='<?php echo U('Web/Review/index',array('type'=>1,'id'=>$id));?>'">
                            </div>
                     </div>
               </div>
               
               <div class="mth pr">
                   <div class="mth_top pa">附近民宿推荐</div>
                   <div id="dom-effect" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
               
               <div class="mth pr" style="margin-top:20px;">
                   <div class="mth_top pa">附近活动推荐</div>
                   <div id="mth_dom" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
     
               <div style="height:2rem"></div>  
               <div class="snail_d center trip_btn f16" style="margin:2rem 0 0">
                            <a href="<?php echo U('Web/Order/joinparty',array('id'=>$id));?>" class="snail_cut">我要报名</a>
               </div>   
   </div>   
</div>
<script type="text/javascript">
  $(function(){
    // 收藏
    $('.collect').click(function(){
      var id=<?php echo ($id); ?>;
      var data={'type':1,'id':id};
      console.log(data);
      $.post("<?php echo U('Web/Ajaxapi/collection');?>",data,function(res){
        console.log(res);
        if(res.code==200)
        {
          $('.collect').addClass('recom_c_cut');
        }
        else if(res.code==300){
          $('.collect').removeClass('recom_c_cut');
        }
        else{
          alert(res.msg);
        }
      });
    })
    // 点赞 vertical
    $('.certical').click(function(){
      var id=<?php echo ($id); ?>;
      var data={'type':1,'id':id};
      $.post("<?php echo U('Web/Ajaxapi/hit');?>",data,function(res){
        console.log(res);
        if(res.code==200)
        {
          var hit=$('#vcount').text();
          $('#vcount').text(Number(hit)+1)// $('.collect').addClass('recom_c_cut');
          $('.certical').find('img').attr('src','/Public/Web/images/poin_1.png');
        }
        else if(res.code==300){
          var hit=$('#vcount').text();
          $('#vcount').text(Number(hit)-1)// $('.collect').addClass('recom_c_cut');
          $('.certical').find('img').attr('src','/Public/Web/images/poin.png');
        }
        else{
          alert(res.msg);
        }
      });
    })

  })
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