<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
    <meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="viewport" content="width=device-width,user-scalable=0,minimum-scale=1,maximum-scale=1"/>
    <meta name="x5-fullscreen" content="true" />
    <link href="favicon.ico" rel="SHORTCUT ICON">
    <title><?php echo ($site["sitetitle"]); ?></title>
    <link rel="stylesheet" href="/Public/Public/css/weui.css">
    <link rel="stylesheet" href="/Public/Public/css/jquery-weui.css">
    <link rel="stylesheet" href="/Public/Web/css/base.css">
    <link rel="stylesheet" href="/Public/Web/css/style.css?v=0.1">
    <link rel="stylesheet" href="/Public/Web/css/clndr.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery.range.css">
    <script src="/Public/Web/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Public/js/jquery-weui.js"></script>
    <script src="/Public/Web/js/Action.js"></script>
    <script src="/Public/Web/js/TouchSlide.1.1.js"></script>
    <script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script src="/Public/public/js/jquery.cookie.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Public/Web/js/iscroll.js"></script>
    <script src="/Public/Public/js/layer.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/Public/Public/css/layer.css">
    <link rel="stylesheet" href="/Public/Web/css/list.css">
    <script type="text/javascript">
     function is_weixin(){  
       var ua = navigator.userAgent.toLowerCase();  
       if(ua.match(/MicroMessenger/i)=="micromessenger") {  
         return true;  
       } else {  
         return false;  
       }  
     }  
     if(is_weixin()) {
       /*
       $.ajax({
        'async': true,
        'url': '<?php echo U("Member/checkLogin");?>',
        'dataType': '',
        '' 
       })
        */
     }
      (function($)
      {
          $.extend(
          {
              myTime:
              {
                  /**
                   *              * 当前时间戳
                   *                           * @return <int>        unix时间戳(秒)
                   *                                        */
                  CurTime: function()
                  {
                      return Date.parse(new Date()) / 1000;
                  },
                  /**              
                   *              * 日期 转换为 Unix时间戳
                   *                           * @param <string> 2014-01-01 20:20:20  日期格式
                   *                                        * @return <int>        unix时间戳(秒)
                   *                                                     */
                  DateToUnix: function(string)
                  {
                      var f = string.split(' ', 2);
                      var d = (f[0] ? f[0] : '').split('-',
                          3);
                      var t = (f[1] ? f[1] : '').split(':',
                          3);
                      return (new Date(
                          parseInt(d[0], 10) ||
                          null, (parseInt(d[1], 10) ||
                              1) - 1,
                          parseInt(d[2], 10) ||
                          null,
                          parseInt(t[0], 10) ||
                          null,
                          parseInt(t[1], 10) ||
                          null,
                          parseInt(t[2], 10) ||
                          null
                      )).getTime() / 1000;
                  },
                  /**              
                   *              * 时间戳转换日期
                   *                           * @param <int> unixTime    待时间戳(秒)
                   *                                        * @param <bool> isFull    返回完整时间(Y-m-d 或者 Y-m-d H:i:s)
                   *                                                     * @param <int>  timeZone   时区
                   *                                                                  */
                  UnixToDate: function(unixTime, isFull,
                      timeZone)
                  {
                      if (typeof(timeZone) == 'number')
                      {
                          unixTime = parseInt(unixTime) +
                              parseInt(timeZone) * 60 * 60;
                      }
                      var time = new Date(unixTime * 1000);
                      var ymdhis = "";
                      ymdhis += time.getUTCFullYear() + "-";
                      ymdhis += (time.getMonth() + 1) + "-";
                      ymdhis += time.getDate() < 10 ? 0 + time.getDate().toString() : time.getDate();
                      if (isFull === true)
                      {
                          ymdhis += " " + time.getUTCHours() +
                              ":";
                          ymdhis += time.getUTCMinutes() +
                              ":";
                          ymdhis += time.getUTCSeconds();
                      }
                      return ymdhis;
                  }
              }
          });
      })(jQuery);
    </script>
    <script>
        $(function(){
            $('img.pic').lazyload({
               effect: 'fadeIn'
            });
        })
    </script>
    <script>
      getLocation();
      function getLocation() {
        if (navigator.geolocation) {
          console.log('location start.');
          navigator.geolocation.getCurrentPosition(showPosition, errorPosition);
        } else {
          console.log('浏览器不支持定位！');
        }
      }
      function showPosition(position) {
        var data = { 'position': position.coords.longitude + ',' + position.coords.latitude };
        $.post("<?php echo U('Web/Index/cacheposition');?>", data, function (res) {
          if(typeof(getHotelDistance) == 'function') {
            var pos = JSON.parse(res);
            getHotelDistance(pos.lat, pos.lng);
          }
          if(typeof(baiduCallback) == 'function') {
            var pos = JSON.parse(res);
            baiduCallback(pos.lat, pos.lng); 
          }
        });
      }
      function errorPosition(err) {
        console.log(err);
        console.warn('ERROR(' + err.code + '): ' + err.message);
      }
    </script>
    <script type="text/javascript">
      function rawPost(url, data, success, err) {
        $.ajax({
          'url': url,
          'data': JSON.stringify(data),
          'dataType': 'json',
          'type': 'post',
          'success': success,
          'error': err
        });
      }
    </script>
    <script>
  if(is_weixin()) {
    //调用微信jssdk
    $.getScript('https://res.wx.qq.com/open/js/jweixin-1.1.0.js', function() {
      var signPackage = <?php echo ($signPackage); ?>;
      //配置参数
      wx.config({
        debug: false,
        appId: '<?php echo ($appid); ?>',
        timestamp: signPackage.timestamp,
        nonceStr: signPackage.nonceStr,
        signature: signPackage.signature,
        jsApiList: [
          'onMenuShareTimeline',
          'onMenuShareAppMessage'
        ] 
      });
      //配置成功回调
      wx.ready(function() {
        console.log('wx_jssdk_success'); 
        var sharePublic = {
          'title': '蜗牛壳',
          'link': signPackage.url,
          'desc': 'adasdasdasdasdasddwqe',
          'imgUrl': '',
          'success': function() {

          },
          'cancel': function() {
          
          }
        }, shareFriends = {
          'title': '蜗牛壳',
          'link': signPackage.url,
          'imgUrl': '',
          'desc': 'asascasqwdqwqweqrqwr',
          'type': 'link',
          'dataUrl': '',
          'success': function() {
             
          },
          'error': function() {
          
          }
        };

        //分享微信朋友圈
        wx.onMenuShareTimeline(sharePublic);

        //分享微信好友
        wx.onMenuShareAppMessage(shareFriends);

        //分享QQ好友
        wx.onMenuShareQQ(shareFriends);

        //分享腾讯微博
        wx.onMenuShareWeibo(sharePublic);

        //分享qq空间
        wx.onMenuShareQZone(sharePublic);
      });
      //配置失败回调
      wx.error(function() {
        console.log('auth failed');
      });
    });
  }
</script>

    <script>
      var inviteCode = '<?php echo ($inviteCode); ?>';
      window.onload = function() {
        if(inviteCode) {
          setTimeout("alert('请先注册，更多精彩！');window.location.href='<?php echo U('Member/reg');?>?invitecode=<?php echo ($inviteCode); ?>'", 5000);
        } 
      };
    </script>
</head>
<body style="min-height:100%">

<body class="back-f1f1f1">
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=EdOBKRNGYWwo9ZKhqMSRjgbdGHIHH2Gh&s=1"></script>
<div class="container padding_0">
   <div class="land">
                <div class="act_g pr">
                    <div id="slideBox" class="slideBox">
                       <div class="bd">
                          <ul>
                            <?php if(is_array($imglist)): $i = 0; $__LIST__ = $imglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?><li>
                                <a class="pic" href="javascript:;">
                                  <img src="<?php echo ($img); ?>" style="width:100%;height:280px;" />
                                </a>
                              </li><?php endforeach; endif; else: echo "" ;endif; ?>
                          </ul>
                       </div>
                    </div>   
                    <div class="history pa">
                      <a style="display:block" href="javascript:history.back();">
                        <img src="/Public/Web/images/go.png">
                      </a><span>&nbsp;</span>
                    </div>
                    <div class="recom_c pa"><div class="recom_gg collect <?php if($data["iscollect"] == 1): ?>recom_c_cut<?php endif; ?> "  data-id="<?php echo ($data["id"]); ?>"></div>
                                            <span><a href=""><img src="/Public/Web/images/share.png"></a></span>
                                            <span><a class="add_to_trip" href="<?php echo U('Web/Note/add');?>"><img src="/Public/Web/images/recom_a3.png"></a></span>
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
                          <span id="hitnum"><?php echo ((isset($data["hit"]) && ($data["hit"] !== ""))?($data["hit"]):"0"); ?></span>
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
                     <a href="<?php echo U('Hostel/review');?>?hid=<?php echo ($data["id"]); ?>"><div class="edg_d fr">
                         <img src="/Public/Web/images/edg_a1.jpg"> <?php echo ((isset($data["reviewnum"]) && ($data["reviewnum"] !== ""))?($data["reviewnum"]):"0"); ?>条评论 <span><img src="/Public/Web/images/arrow.jpg"></span>
                     </div></a>
                 </div>
                 <div class="vb_a">
                   <div class="land_font pr">
                     <span class="ft12 over_ellipsis show_address" style="color:#333;display:inline-block;max-width:62%">
                       地址：<?php echo getarea($data['area']); echo ($data["address"]); ?>  
                     </span>
                     <div class="vb_a1 pa ft12">
                        <img src="/Public/Web/images/add_e.png">距你
                        <span id="hotel_distance" class="vb_a1" style="color:#ff715f"><?php echo ($data["distance"]); ?></span>
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
                        <?php if(is_array($data["room"])): $i = 0; $__LIST__ = $data["room"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Web/Room/show',array('id'=>$vo['rid']));?>">
                                <div class="snake_list f14">
                                       <div class="land_d pr f0">
                                            <div class="land_e vertical" style="padding: 0 10px;">
                                                <img src="<?php echo ($vo["thumb"]); ?>" style="width:100px;height:80px;">
                                            </div>
                                            <div class="land_f vertical">
                                                  <div class="land_f1 f16"><?php echo ($vo["title"]); ?></div>
                                                  <div class="land_f2 f13"><?php echo ($data["area"]); ?>M<sup>2</sup> <?php echo ($vo["bedtype"]); ?></div>
                                                  <br>
                                                  <div class="land_f3 f0" style="padding:15px 0 0 0">
                                                     <div class="land_money ft18">¥ <?php echo ($vo["money"]); ?>
                                                                                     <span>起</span>
                                                      </div>
                                                  </div>
                                            </div>
                                            <div style="width:20%;vertical-align:middle" class="fr">
                                              <div style="padding:12px;background:#ff715f;color:#fff;width:40px;height:40px;font-size:14px;text-align:center">立即预订</div>
                                            </div>
                                       </div>
                                </div>
                            </a><?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="scr_d snake_b center">显示全部<?php echo ($roomcount); ?>个房间<img src="/Public/Web/images/drop_f.jpg"></div> 
               </div>
               
               <div class="vb_d center">
                 <div class="land_a center">
                   <div class="land_a1 snake_c">
                     <a href="<?php echo U('Hostel/landlord_info');?>?hid=<?php echo ($data["id"]); ?>">
                       <img src="<?php echo ($data["head"]); ?>" style="width:80px;height:80px;border-radius:50%">
                     </a>
                   </div>
                   <div class="land_a2 home_d1 margin_05 f16"><?php echo ($data["nickname"]); ?></div>
                   <div class="home_d2 margin_05">
                         <div class="home_d3 vertical mr_4"><img src="/Public/Web/images/home_a1.png">实名认证</div>
                         </div>                  
                    </div>
                      <?php if(empty($data["is_owner"])): ?><div class="vb_d1">
                        <a class="chat_friends" href="#" data-targetid="<?php echo ($data["id"]); ?>" data-targettoken="<?php echo ($data["rongyun_token"]); ?>" data-targethead="<?php echo ($data["head"]); ?>" data-nickname="<?php echo ($data["nickname"]); ?>">
                        <img src="/Public/Web/images/vb_a.jpg">在线咨询
                      </a>
                    </div><?php endif; ?>
                  <div style="height:1rem"></div>
               </div>
               
               <div class="vb_c ">
                    <div class="vb_c1 center">美宿描述</div>
                    <div class="vb_c2">
                      <?php echo ($data["description"]); ?>
                    </div>
                    <div class="vb_c3 snake_click"><a href="javascript:;">查看完整美宿描述</a></div>
               </div>
               
               <div class="vb_c" style="padding-bottom:0;">
                    <div class="vb_c1 center">配套设施</div>
                    <div class="snake_btm">
                        <?php if(is_array($roomcate)): foreach($roomcate as $k=>$vo): ?><div class="snake_e">
                                <?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><div class="snake_e1">
                                      <img src="<?php echo ($svo["thumb"]); ?>"><span <?php if($svo["iscolor"] > 0): else: ?>style="color:#DDDDDD;"<?php endif; ?> ><?php echo ($svo["catname"]); ?></span>
                                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div><?php endforeach; endif; ?>
                    </div>
               </div>
               
               <div class="snake_m ">
                    <div class="vb_c1 center snake_kl" style="margin:0 2.5%;">退订规则</div>
                  
                 <div style="padding:10px;color:#aaa" class="ft12"><?php echo ($data["content"]); ?></div>
                 <div class="snake_small">该规则由房东制定</div>
               </div>
                 <?php if(($house_owner_activity_num) != "0"): ?><div class="mth pr">
                   <div class="mth_top pa">我们发布的活动</div>
                   <div id="mth_dom" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div><?php endif; ?>
               <?php if(($house_near_hostel_num) != "0"): ?><div class="mth pr" style="margin-top:20px;">
                   <div class="mth_top pa">附近民宿推荐</div>
                   <div id="dom-effect" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div><?php endif; ?>
     <div class="add_to_trip back_blue ft16" style="padding:10px;color:#fff;text-align:center;margin-top:15px">
      添加到行程
     </div> 
   </div>   
</div>
<div class="big_mask"></div>
<div class="pyl">
    <div class="pyl_top pr">房间简介
        <div class="pyl_close pa"><img src="/Public/Web/images/close.jpg"></div>
    </div>
    <div class="pyl_font" style="height:85%;-webkit-overflow-scrolling:touch;overflow:auto">
        <iframe style="overflow:scroll;width:100%;height:auto;border:0;" src="<?php echo U('Web/Hostel/app_show');?>?id=<?php echo ($data["id"]); ?>" scrolling="no">
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
      <form action="<?php echo U('Trip/add');?>" method="post" id="post_add">
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
  var hotelId = <?php echo ($data["id"]); ?>;
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
              var num = $('#hitnum').val();
              $('#hitnum').val(num + 1);
          }
          else if(res.code==300){
              self.find('span').text(Number(hit)-1)
              self.find('img').attr('src','/Public/Web/images/poin.png');
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
<div id="chat_window" class="hide">
  <div class="chat_mask">
  </div>
  <div class="chat_frame">
    <div class="chat_head">
      <div class="head_go pa" id="close_chat">
        <img src="/Public/Web/images/go.jpg">
      </div>
      <h3 id="chat_title" style="font-size:20px;color:#fff;text-align:center;"></h3>
    </div>
    <div class="chat_content"  style="height:auto;bottom:0">
      <div id="c_content">
      </div>
    </div>
    <div class="chat_foot" style="background:#efefef">
      <div class="chat_input_box">
        <table width="100%">
          <tbody>
            <tr>
              <td align="center">
                <textarea type="text" class="chat_input" id="chat_words"></textarea>
              </td>
              <td width="48" align="center">
                <img src="/Public/Web/images/Icon/img31.png" class="c_w_a_item" id="emoji_ctrl">
              </td>
              <td width="48" align="center" id="img_container"> 
                <img src="/Public/Web/images/Icon/img32.png" class="c_w_a_item" id="img_picker">
              </td>
              <td width="48" align="center">
                <button id="chat_send_btn" style="padding:7px 5px;border:1px solid #000;border-radius:3px;font-size:12px;">发送</button>
              </td>
            </tr>
            <tr id="emoji_box" class="hide" data-status="0">
              <td colspan="4">
                <div id="rongyun_emoji" style="padding:5px;height:120px;overflow-y:scroll">
                </div>
              </td>
            <tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:10002;background:#000;display:none" id="picture_box">
    <img src="" id="zoom_picture" style="width:100%;position:relative;">   
  </div>
</div>
<script src="https://cdn.ronghub.com/RongIMLib-2.2.4.min.js"></script>
<script src="https://cdn.ronghub.com/RongEmoji-2.2.4.min.js"></script> 
<script src="https://cdn.ronghub.com/RongUploadLib-2.2.4.min.js"></script> 
<script src="/Public/Web/js/chat.js"></script>

</body>
<script>
  var map = new BMap.Map("map_container"); // 创建地图实例  
  var point = new BMap.Point(<?php echo ($data["lng"]); ?>, <?php echo ($data["lat"]); ?>); // 创建点坐标  
  map.centerAndZoom(point, 15);
  var marker = new BMap.Marker(point); // 创建标注    
  map.addOverlay(marker);
  function getHotelDistance(lat, lng) {
    console.log(lat);
    console.log(lng);
    var dlat = '<?php echo ($data["lat"]); ?>';
    var dlng = '<?php echo ($data["lng"]); ?>';
    $.ajax({
      'url': '<?php echo U("Api/Map/get_distance_for_web");?>?o_lat=' + lat + '&o_lng=' + lng + '&d_lat=' + dlat + '&d_lng=' + dlng,
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
    window.location.href="<?php echo U('Public/big_map');?>?lng=<?php echo ($data["lng"]); ?>&lat=<?php echo ($data["lat"]); ?>";
  });

</script>
<input type='hidden' id='getid' value='<?php echo ($data["id"]); ?>'> 
<script src="/Public/Web/js/islider.js"></script>
<script src="/Public/Web/js/islider_desktop.js"></script>

<script>
        var data=<?php echo ($data["house_near_hostel"]); ?>;
        //data=eval("("+data+")");
          var domList = [];
          $.each(data,function(i,value){
            domList[i]={
              'height' : '100%',
              'width' : '100%',
              'content' :'<div class="recom_list pr"><div class="recom_a recomhostel pr"><img src="'+value.thumb+'"><div class="recom_g f18 center pa"><div class="recom_g1 fl"><em>￥</em>'+value.money+'<span>起</span></div><div class="recom_g2 fl">'+value.evaluation+'<span>分</span></div></div></div><div class="recom_e"><div class="land_f1 recom_e1 f16">'+value.address+'</div><div class="recom_f"><div class="recom_f1 recom_hong f12 fl"><img src="/Public/Web/images/add_e.png">距你  '+value.distance+'km</div><div class="recom_f2 fr"><div class="land_h recom_f3 vertical"><div class="land_h2 vertical"><img src="/Public/Web/images/poin.png"> <span>'+value.hit+'</span></div><div class="land_h1 vertical"><img src="/Public/Web/images/land_d3.png"><span>'+value.reviewnum+'</span>条评论</div></div></div></div></div></div>'
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
        var data=<?php echo ($data["house_owner_activity"]); ?>;
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
<script src="/Public/Web/js/TouchSlide.1.1.js"></script>
<script type="text/javascript">
  TouchSlide({ 
     slideCell:"#slideBox",
     mainCell:".bd ul", 
     effect:"leftLoop", 
     autoPlay:true //自动播放
  });
</script>
</html>