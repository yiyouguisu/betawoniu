<include file="public:head" />
<body class="back-f1f1f1">
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=EdOBKRNGYWwo9ZKhqMSRjgbdGHIHH2Gh&s=1"></script>
<div class="container padding_0">
   <div class="land">
                <div class="act_g pr">
                    <div id="slideBox" class="slideBox">
                       <div class="bd">
                          <ul>
                            <volist name="imglist" id="img">
                              <li>
                                <a class="pic" href="javascript:;">
                                  <img src="{$img}" style="width:100%;height:280px;" />
                                </a>
                              </li>
                            </volist>
                          </ul>
                       </div>
                    </div>   
                    <div class="history pa">
                      <a style="display:block" href="javascript:history.back();">
                        <img src="__IMG__/go.png">
                      </a><span>&nbsp;</span>
                    </div>
                    <div class="recom_c pa"><div class="recom_gg collect <if condition='$data.iscollect eq 1'>recom_c_cut</if> "  data-id="{$data.id}"></div>
                                            <span><a href=""><img src="__IMG__/share.png"></a></span>
                                            <span><a class="add_to_trip" href="{:U('Web/Note/add')}"><img src="__IMG__/recom_a3.png"></a></span>
                    </div>
                    <div class="act_g2 f16 center pa">
                      <em>￥</em><span>{$data.money|default="0.00"}</span><em>起</em>
                    </div>
               </div>  
               <div class="det_box">
                 <div class="act_k">
                      <div class="act_k1 vertical">{$data.title}</div>
                      <div class="act_k2 vertical hit" data-id="{$data.id}" >
                          <if condition='$data.ishit eq 1'>
                            <img src="__IMG__/poin_1.png">
                          <else/>
                            <img src="__IMG__/poin.png">
                          </if>
                          <span id="hitnum">{$data.hit|default="0"}</span>
                      </div>
                 </div>
                 <div class="edg">
                     <div class="edg_a fl">
                                <div class="edg_b">{$data.evaluation|default="10.0"}<span>分</span></div>
                                <div class="edg_c">
                                    <span><img src="__IMG__/star.png"></span>
                                    <span><img src="__IMG__/star.png"></span>
                                    <span><img src="__IMG__/star.png"></span>
                                    <span><img src="__IMG__/star.png"></span>
                                    <span><img src="__IMG__/star.png"></span>
                                </div>
                     </div>
                     <a href="{:U('Hostel/review')}?hid={$data.id}"><div class="edg_d fr">
                         <img src="__IMG__/edg_a1.jpg"> {$data.reviewnum|default="0"}条评论 <span><img src="__IMG__/arrow.jpg"></span>
                     </div></a>
                 </div>
                 <div class="vb_a">
                   <div class="land_font pr">
                     <span class="ft12 over_ellipsis show_address" style="color:#333;display:inline-block;max-width:62%">
                       地址：{:getarea($data['area'])}{$data.address}  
                     </span>
                     <div class="vb_a1 pa ft12">
                        <img src="__IMG__/add_e.png">距你
                        <span id="hotel_distance" class="vb_a1" style="color:#ff715f">{$data.distance}</span>
                        公里
                     </div>        
                   </div> 
                   <div class="vb_b" style="position:relative">
                     <div id="map_container" style="height:150px;margin:0px;"></div>
                     <div id="map_cover" style="width:100%;height:100%;position:absolute;z-index:9999;left:0;top:0"></div>
                   </div>
                 </div>
               </div>
               
               <div class="snake">
                    <div class="vb_c1 snake_a center">我们的房间</div>
                        <volist name='data["room"]' id='vo'>
                          <if condition="$i gt 3">
                            <a href="{:U('Web/Room/show',array('id'=>$vo['rid']))}" class="hide_items" style="display:none;">
                          <else />
                            <a href="{:U('Web/Room/show',array('id'=>$vo['rid']))}">
                          </if>
                                <div class="snake_list f14">
                                       <div class="land_d pr f0">
                                            <div class="land_e vertical" style="padding: 0 10px;">
                                                <img src="{$vo.thumb}" style="width:100px;height:80px;">
                                            </div>
                                            <div class="land_f vertical">
                                                  <div class="land_f1 f16">{$vo.title}</div>
                                                  <div class="land_f2 f13">{$vo.area}M<sup>2</sup> {$vo.bedtype}</div>
                                                  <br>
                                                  <div class="land_f3 f0" style="padding:15px 0 0 0">
                                                     <div class="land_money ft18">¥ {$vo.money}
                                                                                     <span>起</span>
                                                      </div>
                                                  </div>
                                            </div>
                                            <div style="width:20%;vertical-align:middle" class="fr">
                                              <div style="padding:12px;background:#ff715f;color:#fff;width:40px;height:40px;font-size:14px;text-align:center">立即预订</div>
                                            </div>
                                       </div>
                                </div>
                            </a>
                        </volist>
                      <div class="scr_d snake_b center" data-content="收起">显示全部{$roomcount}个房间<img src="__IMG__/drop_f.jpg"></div> 
                    </div>
               </div>
               
               <div class="vb_d center">
                 <div class="land_a center">
                   <div class="land_a1 snake_c">
                     <a href="{:U('Hostel/landlord_info')}?hid={$data.id}">
                       <img src="{$data.head}" style="width:80px;height:80px;border-radius:50%">
                     </a>
                   </div>
                   <div class="land_a2 home_d1 margin_05 f16">{$data.nickname}</div>
                   <div class="home_d2 margin_05">
                         <div class="home_d3 vertical mr_4"><img src="__IMG__/home_a1.png">实名认证</div>
                         </div>                  
                    </div>
                      <empty name="data.is_owner">
                    <div class="vb_d1">
                        <a class="chat_friends" href="#" data-targetid="{$data.id}" data-targettoken="{$data.rongyun_token}" data-targethead="{$data.head}" data-nickname="{$data.nickname}">
                        <img src="__IMG__/vb_a.jpg">在线咨询
                      </a>
                    </div> 
                      </empty>
                  <div style="height:1rem"></div>
               </div>
               
               <div class="vb_c ">
                    <div class="vb_c1 center">美宿描述</div>
                    <div class="vb_c2">
                      {$data.description}
                    </div>
                    <div class="vb_c3 snake_click"><a href="javascript:;">查看完整美宿描述</a></div>
               </div>
               
               <div class="vb_c" style="padding-bottom:0;">
                    <div class="vb_c1 center">配套设施</div>
                    <div class="snake_btm">
                        <foreach name="roomcate" item="vo" key="k" >
                            <div class="snake_e">
                                <volist name='vo' id='svo'>
                                    <div class="snake_e1">
                                      <img src="{$svo.thumb}"><span <if condition="$svo.iscolor gt 0"> <else/>style="color:#DDDDDD;"</if> >{$svo.catname}</span>
                                    </div>
                                </volist>
                            </div>
                        </foreach>
                    </div>
               </div>
               
               <div class="snake_m ">
                    <div class="vb_c1 center snake_kl" style="margin:0 2.5%;">退订规则</div>
                  
                 <div style="padding:10px;color:#aaa" class="ft12">{$data.content}</div>
                 <div class="snake_small">该规则由房东制定</div>
               </div>
                 <neq name="house_owner_activity_num" value="0">
               <div class="mth pr">
                   <div class="mth_top pa">我们发布的活动</div>
                   <div id="mth_dom" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
               </neq>
               <neq name="house_near_hostel_num" value="0">
               <div class="mth pr" style="margin-top:20px;">
                   <div class="mth_top pa">附近民宿推荐</div>
                   <div id="dom-effect" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
     </neq>
     <div class="add_to_trip back_blue ft16" style="padding:10px;color:#fff;text-align:center;margin-top:15px">
      添加到行程
     </div> 
   </div>   
</div>
<div class="big_mask"></div>
<div class="pyl">
    <div class="pyl_top pr">房间简介
        <div class="pyl_close pa"><img src="__IMG__/close.jpg"></div>
    </div>
    <div class="pyl_font" style="height:85%;-webkit-overflow-scrolling:touch;overflow:auto">
        <iframe style="overflow:scroll;width:100%;height:auto;border:0;" src="{:U('Web/Hostel/app_show')}?id={$data.id}" scrolling="no">
        </iframe>
        <div class="snail_d homen_style center f16" >
          <a href="javescript:void(0);" id="i_know" class="common_click" style="width:100%">我知道了</a>
        </div>
    </div>
</div>
<div id="new_trip" class="hide">
  <div class="trip_cover"></div>
  <div class="trip_pre_content">
    <div style="padding:10px;font-size:14px;">
      <div style="width:30%" class="fl">
        <a href="#" id="dismiss_edit" style="color:#aaa">取消</a>
      </div> 
      <div style="width:40%;color:#56c3cf" class="fl tc">编辑行程信息</div> 
      <div style="width:30%" class="fl tr">
        <a href="#" style="color:#56c3cf" id="save_trip">保存</a>
      </div> 
      <div style="clear:both"></div>
    </div>
    <div style="padding:10px;">
      <form action="{:U('Trip/add')}" method="post" id="post_add">
        <div class="form-group">
          <input type="hidden" value="" name="hotels">
          <input class="required form-control form-inline" type="text" name="trip_title" placeholder="行程标题：" data-content="行程标题">
        </div>
        <div class="form-group">
          <input class="required form-control form-inline" type="date" name="start_date" placeholder="出发时间：" value="" data-content="出发时间">
        </div>
        <div class="form-group">
          <input class="required form-control form-inline" type="number" name="trip_days" placeholder="出行天数：" data-content="出行天数">
        </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function(){
    collect();
    hit();
  })

  var selectedHotel = [];
  var hotelId = {$data.id};
  $('.add_to_trip').click(function(evt) {
    evt.preventDefault();
    selectedHotel.push(hotelId);
    if(selectedHotel.length == 0) {
      alert('请至少选择一个美宿或景点！');
      return;
    }
    $('#new_trip').removeClass('hide');
    $('.mask').hide();
  });
  $('#dismiss_edit').click(function(evt) {
    evt.preventDefault();
    $('#new_trip').addClass('hide');
    $('.required').val('');
  });
  $('#save_trip').click(function(e) {
    e.preventDefault();
    var filled = true;
    var notice = '';
    $('input[name=hotels]').val(selectedHotel.join(','));
    $('.required').each(function(i, t) {
      var val = $(t).val();
      if(!val) {
        filled = false;  
        notice += $(t).data('content') + '必须填写！\n';
      }
    });
    if(filled) {
      $('#post_add')[0].submit();
    } else {
      alert(notice); 
    }
  });

  function collect(){
      // 收藏
      $('.collect').click(function(){
        var self=$(this);
        var id=self.data('id');
        var data={'type':2,'id':id};
        console.log(data);
        $.post("{:U('Web/Ajaxapi/collection')}",data,function(res){
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
        $.post("{:U('Web/Ajaxapi/hit')}",data,function(res){
          console.log(res);
          if(res.code==200)
          {
              self.find('span').text(Number(hit)+1)
              self.find('img').attr('src','__IMG__/poin_1.png');
              var num = $('#hitnum').val();
              $('#hitnum').val(num + 1);
          }
          else if(res.code==300){
              self.find('span').text(Number(hit)-1)
              self.find('img').attr('src','__IMG__/poin.png');
              var num = $('#hitnum').val();
              $('#hitnum').val(num - 1);
          }
          else{
            alert(res.msg);
          }
        });
      })
  }
</script>
<include file="public:chat_uitls" />
</body>
<script>
  var map = new BMap.Map("map_container"); // 创建地图实例  
  var point = new BMap.Point({$data.lng}, {$data.lat}); // 创建点坐标  
  map.centerAndZoom(point, 15);
  var marker = new BMap.Marker(point); // 创建标注    
  map.addOverlay(marker);
  function getHotelDistance(lat, lng) {
    console.log(lat);
    console.log(lng);
    var dlat = '{$data.lat}';
    var dlng = '{$data.lng}';
    $.ajax({
      'url': '{:U("Api/Map/get_distance_for_web")}?o_lat=' + lat + '&o_lng=' + lng + '&d_lat=' + dlat + '&d_lng=' + dlng,
      'type': 'get',
      'dataType': 'text',
      'success': function(data) {
        console.log(data);
        $('#hotel_distance').html(data);
      },
      'error': function(err) {
        console.log(err); 
      }
    });
  }
  getLocation();
</script>
<script>
 $('.show_address').click(function (evt) {
    evt.preventDefault();
    var _this = $(this); 
    var html = '<div style="position:fixed;top:0;left:0;right:0;bottom:0;background:#fff;z-index:1000;padding:35% 5%;font-size:16px;color:#000">' + _this.html() + '</div>'
    var addressBox = $(html);
    addressBox.click(function(e) {
      e.preventDefault();
      $(this).remove(); 
    });
    $('body').append(addressBox);
  });
  $('#i_know').click(function(evt) {
    evt.preventDefault();
    $('.big_mask').hide();     
    $('.pyl').hide();
  });


  $('#map_cover').click(function(evt) {
    evt.preventDefault();
    window.location.href="{:U('Public/big_map')}?lng={$data.lng}&lat={$data.lat}";
  });

</script>
<input type='hidden' id='getid' value='{$data.id}'> 
<script src="__JS__/islider.js"></script>
<script src="__JS__/islider_desktop.js"></script>

<script>
        var data={$data.house_near_hostel};
        //data=eval("("+data+")");
          var domList = [];
          $.each(data,function(i,value){
            domList[i]={
              'height' : '100%',
              'width' : '100%',
              'content' :'<div class="recom_list pr"><div class="recom_a recomhostel pr"><img src="'+value.thumb+'"><div class="recom_g f18 center pa"><div class="recom_g1 fl"><em>￥</em>'+value.money+'<span>起</span></div><div class="recom_g2 fl">'+value.evaluation+'<span>分</span></div></div></div><div class="recom_e"><div class="land_f1 recom_e1 f16">'+value.address+'</div><div class="recom_f"><div class="recom_f1 recom_hong f12 fl"><img src="__IMG__/add_e.png">距你  '+value.distance+'km</div><div class="recom_f2 fr"><div class="land_h recom_f3 vertical"><div class="land_h2 vertical"><img src="__IMG__/poin.png"> <span>'+value.hit+'</span></div><div class="land_h1 vertical"><img src="__IMG__/land_d3.png"><span>'+value.reviewnum+'</span>条评论</div></div></div></div></div></div>'
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
</script>


<script>
        var data={$data.house_owner_activity};
        //data=eval("("+data+")");
          var mthList = [];
          $.each(data,function(i,value){
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


</script>
<script src="__JS__/TouchSlide.1.1.js"></script>
<script type="text/javascript">
  TouchSlide({ 
     slideCell:"#slideBox",
     mainCell:".bd ul", 
     effect:"leftLoop", 
     autoPlay:true //自动播放
  });
</script>
<script>
var initHide = true;
$('.snake_b').click(function(evt) {
  evt.preventDefault();
  if(initHide) {
    $('.hide_item').show();
  } else {
    $('.hide_item').hide();
  }
  var htmContent = $(this).html();
  var tmp_content = $(this).data('content');
  $(this).html(tmp_content);
  $(this).data('content', htmContent);
});
</script>
</html>
