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

<div class="header center z-index112 pr f18">
      <div class="stay_top">
           <div class="stay_box">
                   <div class="stay_a fl">
                       <div class="stay_a1">住 4-30</div>
                       <div class="stay_a2">离 5-10</div>
                   </div>
                   <div class="stay_b f0 fr">
                       <input type="text" class="stay_text vertical" placeholder="输入民宿或关键词搜索...">
                       <input type="button" class="stay_btn vertical">
                   </div>
           </div>
      </div>
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="/Public/Web/images/go.jpg"></a><span>&nbsp;</span></div>
      <div class="tra_pr map_small f14 pa"><a href="<?php echo U('Web/Hostel/map');?>"><img src="/Public/Web/images/map_small.jpg">地图</a></div>      
</div>

<div class="container">
   <div class="land">
          <div class="tra_list pr z-index112 center f14">
                <div class="tra_li tra_li_on">按特色</div>
                <div class="tra_drop tra_click">
                    <div class="act_pad">
                        <div class="dress_box">
                             <div class="dress_b act_a center moch_click f14">
                                 <ul>
                                    <?php if(is_array($hostelcate)): $i = 0; $__LIST__ = $hostelcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class='hostelcate' data-id='<?php echo ($vo["id"]); ?>'><?php echo ($vo["catname"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </ul>
                             </div>
                       </div>
                    </div>
                </div>
                
                <div class="tra_li tra_li_on">按位置</div>
                <div class="tra_drop">
                    <div class="tra_dropA_box">
                         <div class="tra_dropA">
                            <select id='area'>
                                <option value='0'>---请选择-</option>
                                <?php if(is_array($areaArray)): foreach($areaArray as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                            </select>
                         </div>
                         <div class="tra_dropA">
                            <select id='city'>
                                <option value='0'>---请选择-</option>
                            </select>
                         </div>
                         <div class="tra_dropA">
                            <select id='county'>
                                <option value='0'>---请选择-</option>
                            </select>
                         </div>
                     </div>
                </div>
                <div class="tra_li tra_li_on">按价格</div>
                <div class="tra_drop">
                        <div class="scr_top">
                              <div class="scr_e1" style="margin-bottom:2rem;">活动费用</div> 
                              <div class="scr_b" style="margin-bottom:2rem;">
                                   <div id="slider-range"></div>
                                   <div class="number">
                                       <div class="number_a fl">￥0</div>
                                       <div class="number_b fr">￥5000</div>
                                   </div>
                              </div>
                              <div class="mng_content">
                                   <div class="mng_left fl">￥<span id='minmoney'>100</span> — ￥<span id='maxmoney'>1000</span></div>
                                   <input type="button" class="mng_btn fr pricesub" value="确定">
                              </div>
                        </div> 
                </div>
                
                <div class="tra_li tra_li_on">筛选</div>
                <div class="tra_drop">
                     <div class="stay_left fl">
                         <ul>
                             <li>设施服务</li>
                             <li>特色</li>
                             <li>床型</li>
                             <li>面积</li>
                             <li>评分</li>
                         </ul>
                     </div>
                     <div class="stay_right fl">
                           <ul>
                              <li class='support' data-id='0'><img src="/Public/Web/images/stay_b1.png"> 不限</li>
                              <?php if(is_array($roomcate)): $i = 0; $__LIST__ = $roomcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class='support' data-id='<?php echo ($vo["id"]); ?>'><img src="<?php echo ($vo["gray_thumb"]); ?>"><?php echo ($vo["catname"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                           </ul>
                           
                           <ul>
                              <?php if(is_array($hosteltype)): $i = 0; $__LIST__ = $hosteltype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class='hosteltype' data-id='<?php echo ($vo["id"]); ?>'><?php echo ($vo["catname"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                           </ul>
                              
                           <ul>
                              <?php if(is_array($bedcate)): $i = 0; $__LIST__ = $bedcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class='bedcate' data-id='<?php echo ($vo["id"]); ?>'><?php echo ($vo["catname"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                           </ul>
                           
                           <ul>
                              <?php if(is_array($acreagecate)): $i = 0; $__LIST__ = $acreagecate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class='acreage' data-id='<?php echo ($vo["value"]); ?>'><?php echo ($vo["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                           </ul>
                           
                           <ul>
                              <?php if(is_array($scorecate)): $i = 0; $__LIST__ = $scorecate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class='score' data-id='<?php echo ($vo["value"]); ?>'><?php echo ($vo["name"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                           </ul>
                         
                     </div>
                </div>
          </div>

          <div class="land_btm">  
                <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
                        <a href="<?php echo U('Web/Hostel/show',array('id'=>$vo['id']));?>"><div class="recom_a pr"><img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Web/images/default.jpg" style="width: 100%;height: 60vw;">
                            <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>"><div class="recom_d pa"><img src="<?php echo ($vo["head"]); ?>"></div></a>
                            <div class="recom_g f18 center pa">
                                <div class="recom_g1 fl"><em>￥</em><?php echo ($vo["money"]); ?><span>起</span></div>
                                <div class="recom_g2 fl"><?php echo ((isset($vo["evaluation"]) && ($vo["evaluation"] !== ""))?($vo["evaluation"]):'0'); ?><span>分</span></div>
                            </div>
                        </div></a>
                        <div class="recom_c pa"><div class="recom_gg collect <?php if($vo["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>" data-id="<?php echo ($vo["id"]); ?>"></div></div>
                        <div class="recom_e">
                            <div class="land_f1 recom_e1 f16"><?php echo ($vo["title"]); ?></div>
                            <div class="recom_f">
                            <div class="recom_f1 recom_hong f12 fl"><img src="/Public/Web/images/add_e.png">距你  <?php echo ((isset($vo["distance"]) && ($vo["distance"] !== ""))?($vo["distance"]):'0'); ?>km</div>
                                <div class="recom_f2 fr">
                                    <div class="land_h recom_f3 vertical">
                                            <div class="land_h2 f12 vertical hit" data-id="<?php echo ($vo["id"]); ?>">
                                                <?php if($vo["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png">
                                                <?php else: ?>
                                                  <img src="/Public/Web/images/poin.png"><?php endif; ?>
                                                <span class="vcount"><?php echo ($vo["hit"]); ?></span>
                                            </div>
                                            <div class="land_h1 f12 vertical">
                                                <img src="/Public/Web/images/land_d3.png">
                                                <span><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):'0'); ?></span>条评论
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>

          </div>    

   </div>  
   <div class="mask"></div>     
   
   <div class="">
   
   </div>
</div>




<script src="/Public/Web/js/jquery-ui.min.js.js"></script>
<script>
var data={};
  $(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 5000,
      values: [ 75, 3000 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      },
      change:function(event, ui){
          var minmoney = ui.values[0];
          var maxmoney = ui.values[1];
          console.log(minmoney);
          console.log(maxmoney);
          data['minmoney']=minmoney;
          data['maxmoney']=maxmoney;
          console.log(data);
          $('#minmoney').text(minmoney);
          $('#maxmoney').text(maxmoney);
      }
    });
    // $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    //   " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  });
</script>

<script>
  
   $(function(){
        collect();
        hit();
        $(".moch_click li").click(function(){
           $(this).addClass("hm_cut").siblings().removeClass("hm_cut")
        })
        // 加个选择后ajax
        $('.pricesub').click(function(){
          $.post("<?php echo U('Web/Hostel/select');?>",data,function(res){
            addHtml(res);
            collect();
            hit();
          })
        })
        // 选择城市
        $('#area').change(function(){
            var city=$('#city');
            city.empty();
            var data={'id':$(this).val()};
            console.log(data);
            $.post("<?php echo U('Web/Note/ajaxcity');?>",data,function(res){
                var option='<option>--请选择--</option>';
                $.each(res,function(i,value){
                    option+='<option value='+value.id+'>'+value.name+'</option>';
                });
                city.append(option);
            });
        });
        // 区域
        $('#city').change(function(){
            var county=$('#county');
            county.empty();
            var data={'id':$(this).val()};
            $.post("<?php echo U('Web/Note/ajaxcity');?>",data,function(res){
                var option='<option>--请选择--</option>';
                $.each(res,function(i,value){
                    option+='<option value='+value.id+'>'+value.name+'</option>';
                });
                county.append(option);
            });
        });
        // 选择城市
        $('#county').change(function(){
            var area=$('#area').val()+','+$('#city').val()+','+$(this).val();
            console.log(area);
            if($('#city').val()==$(this).val()){
              area=$('#area').val()+','+$('#city').val();
            }
            data['city']=area;
            ajax_send(data);
        });
        // 选择特色
        $('.hostelcate').click(function(){
          console.log($(this).data('id'));
          data['catid']=$(this).data('id');
          console.log(data);
          ajax_send(data);
        });
        // 支持
        var a=[];
        $('.support').click(function(){
            if(a.length==0){
              a.push($(this).data('id'));
            }
            else{
              if(a.indexOf($(this).data('id'))!=-1){
                console.log('del');
                a.remove(a.indexOf($(this).data('id')));
              }
              else{
                console.log('add');
                a.push($(this).data('id'));
              }
            }
            console.log(a);
            supportArray = a.join(",");
            data['support']=supportArray;
            ajax_send(data);
        });
        // 类型
        $('.hosteltype').click(function(){
          console.log(data);
          data['type']=$(this).data('id');
          console.log(data)
          ajax_send(data);
        })
        // 床型
        $('.bedcate').click(function(){
          data['bedtype']=$(this).data('id');
          console.log(data)
          ajax_send(data);
        });
        // 面积
        $('.acreage').click(function(){
          data['acreage']=$(this).data('id');
          console.log(data)
          ajax_send(data);
        })
        $('.score').click(function(){
          data['score']=$(this).data('id');
          console.log(data)
          ajax_send(data);
        })

   })
    function ajax_send(data) {
      $.post("<?php echo U('Web/Hostel/select');?>",data,function(res){
        console.log(res);
        addHtml(res);
        collect();
        hit();
      })
      // body...
    }
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

    function addHtml(data){
        var land_btm=$('.land_btm');
        land_btm.empty();
        var content=''
        $.each(data,function(i,value){
            var url="<?php echo U('Web/Hostel/show');?>";
            url=url.substr(0,url.length-5);
            url=url+'/id/'+value.id;
            console.log(url);
            var uurl="<?php echo U('Web/Member/memberHome');?>";
            uurl=uurl.substr(0,uurl.length-5);
            uurl=uurl+'/id/'+value.uid;
            console.log(uurl);
            content+='<div class="recom_list pr"><a href="'+url+'"><div class="recom_a pr"><img src="'+value.thumb+'">';
            content+='<a href='+uurl+'><div class="recom_d pa"><img src="'+value.head+'"></div></a><div class="recom_g f18 center pa">';
            content+='<div class="recom_g1 fl"><em>￥</em>'+value.money+'<span>起</span></div><div class="recom_g2 fl">'+value.evaluation+'<span>分</span></div>';
            content+='</div></div></a><div class="recom_c pa">';
            if(value.iscollect==1){
                content+='<div class="recom_gg collect recom_c_cut" data-id="'+value.id+'"></div></div>';
            }
            else{
                content+='<div class="recom_gg collect" data-id="'+value.id+'"></div></div>';
            }
            content+='<div class="recom_e"><div class="land_f1 recom_e1 f16">'+value.title+'</div>';
            if(value.distance=='undefined'){
              var distance=0;
            }
            else{
              var distance=value.distance;
            }
            content+='<div class="recom_f"><div class="recom_f1 recom_hong f12 fl"><img src="/Public/Web/images/add_e.png">距你  '+distance+'km</div>';
            content+='<div class="recom_f2 fr"><div class="land_h recom_f3 vertical"><div class="land_h2 f12 vertical hit" data-id="'+value.id+'">';
            if(value.ishit==1){
                content+='<img src="/Public/Web/images/poin_1.png">'
            }
            else{
                content+='<img src="/Public/Web/images/poin.png">'
            }
            content+='<span class="vcount">'+value.hit+'</span></div><div class="land_h1 f12 vertical"><img src="/Public/Web/images/land_d3.png">';
            content+='<span>'+value.reviewnum+'</span>条评论</div></div></div></div></div></div>'
        });
        land_btm.append(content);
    }

    Array.prototype.remove=function(obj){ 
      for(var i =0;i <this.length;i++){ 
        var temp = this[i]; 
        if(!isNaN(obj)){ 
          temp=i; 
        } 
        if(temp == obj){ 
          for(var j = i;j <this.length;j++){ 
            this[j]=this[j+1]; 
          } 
          this.length = this.length-1; 
        } 
      } 
    } 





















</script>

</body>

</html>