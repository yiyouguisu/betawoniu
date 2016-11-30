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

<body>
<div class="header center z-index112 pr f18 fix-head">
      <div class="stay_top">
           <div class="stay_box">
                   <div class="stay_a fl" id="stay">
                       <div class="stay_a1">住 <?php echo ($stayStart); ?></div>
                       <div class="stay_a2">离 <?php echo ($stayEnd); ?></div>
                   </div>
                   <div class="stay_b f0 fr" id="go_search">
                       <input type="text" class="stay_text vertical" placeholder="输入美宿或关键词搜索...">
                       <input type="button" class="stay_btn vertical">
                   </div>
           </div>
      </div>
      <div class="head_go pa"><a href="<?php echo U('Index');?>"><img src="/Public/Web/images/go.jpg"></a><span>&nbsp;</span></div>
      <div class="tra_pr map_small f14 pa"><a href="<?php echo U('Web/Hostel/all_map');?>"><img src="/Public/Web/images/map_small.jpg">地图</a></div>      
</div>
<div class="container" style="margin-top:6rem;">
   <div class="land land_pad">
          <div class="tra_list pr z-index112 center f14 tra_listFix">
                <div class="tra_li tra_li_on">按特色</div>
                <div class="tra_drop tra_click">
                    <div class="act_pad">
                        <div class="dress_box">
                             <div class="dress_b act_a center moch_click f14">
                                 <ul>
                                    <li class='hostelcate' data-id=''>不限</li>
                                    <?php if(is_array($hostelcate)): $i = 0; $__LIST__ = $hostelcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class='hostelcate' data-id='<?php echo ($vo["id"]); ?>'><?php echo ($vo["catname"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </ul>
                             </div>
                       </div>
                    </div>
                </div>
                
                <div class="tra_li tra_li_on">按位置</div>
                <div class="tra_drop sarea">
                    <div class="tra_dropA_box">
                         <div class="tra_dropA">
                            <select id='area'>
                                <option value='0'>---全部---</option>
                                <?php if(is_array($areaArray)): foreach($areaArray as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                            </select>
                         </div>
                         <div class="tra_dropA">
                            <select id='city'>
                                <option value='0'>---全部-</option>
                            </select>
                         </div>
                         <div class="tra_dropA">
                            <select id='county'>
                                <option value='0'>---全部-</option>
                            </select>
                         </div>

                    <div style="padding-bottom:8px;">
                      <button style="width:100%;color:#fff;background:#56c3cf;border:0;border-radius:3px;" id="submit_area">确定</button>    
                    </div>
                     </div>
                </div>
                <div class="tra_li tra_li_on">按价格</div>
                <div class="tra_drop ">
                  <div class="scr_top">
                    <div class="scr_e1" style="margin-bottom:2rem;">美宿价格</div> 
                    <div class="scr_b" style="margin-bottom:1rem;">
                      <div class="range_scroll" style="padding:0 8px;">
                        <input class="range-slider" type="hidden" value="0,2500"/>
                      </div>
                      <div class="number">
                        <div class="number_a fl">￥0</div>
                        <div class="number_b fr">￥5000</div>
                      </div>
                    </div>
                    <div class="mng_content">
                      <div class="mng_left fl">￥<span id='minmoney'>100</span> — ￥<span id='maxmoney'>5000</span></div>
                      <input type="button" class="mng_btn fr pricesub" id="go_price" value="确定">
                    </div>
                  </div> 
                </div>

                <div class="tra_li tra_li_on">筛选</div>
                  <div class="tra_drop stay_btmScroll pr">
                     <div class="tra_scroll clearfix">
                       <div class="stay_left stay_ml fl">
                         <ul>
                             <li class="stay_leftCut">设施服务</li>
                             <li>特色</li>
                             <li>床型</li>
                             <li>面积</li>
                             <li>评分</li>
                         </ul>
                     </div>
                       <div class="stay_right stay_mr fl">
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
                     <div class="tra_scrollBox"><input type="button" class="btn_fix" value="确定" id="cates"></div>
                </div>
                <!--
                <div class="tra_li tra_li_on">筛选</div>
                <div class="tra_drop">
                  <div class="tra_scroll clearfix">
                     <div class="stay_left fl">
                         <ul>
                             <li>设施服务</li>
                             <li>特色</li>
                             <li>床型</li>
                             <li>面积</li>
                             <li>评分</li>
                         </ul>
                     </div>
                     <div class="stay_right fl" style="overflow-y:scroll">
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
              -->
          </div>
          <div class="land_btm">  
            <div class="f14" id="DataList">
                <div id="scroller">
                    <div id="pullDown" class="idle">
                        <span class="pullDownIcon"></span>
                        <span class="pullDownLabel">下拉加载数据...</span>
                    </div>
                    <div id="thelist"></div>
                    <div id="pullUp" class="idle">
                        <span class="pullUpIcon"></span>
                        <span class="pullUpLabel">上拉加载数据...</span>
                    </div>
                </div>
            </div>
          </div>    
   </div>  
   <div class="mask"></div>     
   <div id="time_box" style="position:fixed;top:6rem;left:0;right:0;background:#fff;padding:10px;z-index:1000;display:none">
      <input type="date" name="live_1" id="live_1" value="<?php echo ($stayStartValue); ?>" style="display:none">
      <input type="date" name="live_2" id="live_2" value="<?php echo ($stayEndValue); ?>" style="display:none">
      <div style="padding:5px">
        <div class="stay_timer" data-type="start" id="start_stay" style="padding:5px;font-size:16px;border:1px solid #eee;display:inline-block;vertical-align:middle;width:60%">
          <span style="margin:0 3px" id="start_date"><?php echo ($stayStart); ?></span>
          <span style="margin:0 3px" id="start_week_day">周三</span>
          <span style="margin:0 3px">入住</span>
        </div>
        <button class="ft12" style="margin-left:2%;width:15%;padding:6px;color:#fff;background:#56c3cf;border:0;border-radius:3px;" id="prev_day">前一天</button>
        <button class="ft12" style="width:15%;padding:6px;color:#fff;background:#56c3cf;border:0;border-radius:3px;" id="next_day">后一天</button>
      </div>
      <div style="padding:5px">
        <div class="stay_timer" data-type="end" id="end_stay" style="padding:5px;font-size:16px;border:1px solid #eee;width:66%;vertical-align:middle;display:inline-block;border-radius:2px;">
          <span style="margin:0 3px;" id="stay_days">住1晚</span> 
          <span style="margin:0 3px;" id="leave_date"><?php echo ($stayEnd); ?></span> 
          <span style="margin:0 3px;" id="leave_week_day">周四</span> 
          <span style="margin:0 3px;">离店</span> 
        </div>
        <button class="ft12" style="margin-left:2%;width:12%;padding:6px;color:#fff;background:#ccc;border-radius:3px;border:0" id="add_day">+</button>
        <button class="ft12" style="width:12%;padding:6px;color:#fff;background:#ccc;border-radius:3px;border:0" id="minu_day">-</button>
      </div>
      <div style="padding:5px">
        <button class="ft16" style="padding:6px;color:#fff;background:#56c3cf;border:0;border-radius:3px;width:100%">确定</button>
      </div>
   </div>
   <div id="time_choose_box" style="position:fixed;left:0;top:0;right:0;z-index:10000;top:6rem;display:none">
      <div class="vb_date" style="background:#fff;padding:10px;">
  <div class="calendar"></div>
</div>
<script src="/Public/Web/js/underscore.js"></script>
<script src="/Public/Web/js/moment.min.js"></script>
<script src="/Public/Web/js/clndr.min.js"></script>
<script type="text/template" id="calendar-template">
  <div class="clndr-controls">
      <div class="clndr-previous-button"></div>
      <div class="month">
          <%=year %>-<%=month %>
      </div>
      <div class="clndr-next-button"></div>
  </div>
  <div class="clndr-grid">
      <div class="days-of-the-week" style="color:#000 !important">
          <% _.each(daysOfTheWeek, function(day) { %>
              <div class="header-day">
                  <%=day %>
              </div>
          <% }); %>
              <div class="days">
                  <% _.each(days, function(day) { %>
                      <div class="<%= day.classes %> ft10" style="line-height:1.5rem" data-value="<%=year %>-<%=month %>-<%=day.day > 9 ? day.day : '0' + day.day %>">
                          <%=day.properties.isToday? "今天": day.day %>
                      </div>
                      <% }); %>
              </div>
      </div>
  </div>
</script>
<script>
    var firstDate = false;
    $(function()
    {
        var calendar = $('.calendar').clndr(
        {
            daysOfTheWeek: ['日', '一', '二', '三', '四', '五', '六'],
            template: $('#calendar-template').html(),
            ready: function()
            {
              getMoney();
              if(typeof(partydate) == 'function') {
                partydate(); 
              }
            },
            clickEvents:
            {
              click: function(target)
              {
                  $(target.element).addClass("selected").siblings().removeClass("selected");
              },
              onMonthChange: function()
              {
                getMoney();
                if(typeof(partydate) == 'function') {
                  partydate(); 
                }
              },
            },
            showAdjacentMonths: true,
            adjacentDaysChangeMonth: true
        });

        $('.calendar').on('touchstart', function(e)
        {
            x = e.originalEvent.targetTouches[0].pageX; // anchor point
        }).on('touchmove', function(e)
        {
            var change = e.originalEvent.targetTouches[0].pageX -
                x;
            change = Math.min(Math.max(-100, change), 100); // restrict to -100px left, 0px right
            $(e.currentTarget).find(".clndr-grid").css("left",
                change + 'px');
            if (change < -10)
            {
                $(document).on('touchmove', function(e)
                {
                    e.preventDefault();
                });
            }
        }).on('touchend', function(e)
        {
            var change = e.originalEvent.changedTouches[0].pageX -
                x;
            if (change > 100)
            {
                $(
                    ".calendar .clndr-controls .clndr-previous-button"
                ).click();
            }
            else if (change < -100)
            {
                $(
                    ".calendar .clndr-controls .clndr-next-button"
                ).click();
            }
            $(e.currentTarget).find(".clndr-grid").css("left",
                '0px');
            $(document).unbind('touchmove');
        });
    });
</script>
<script>
var bookItems = undefined;
function getMoney() {
  var rid = '<?php echo ($data["rid"]); ?>';
  var uid = '<?php echo ($uid); ?>';
  $.ajax({
    'url': '<?php echo U("Api/Room/show");?>',
    'data': JSON.stringify({'id': rid, 'uid': uid}),
    'dataType': 'json',
    'type': 'post',
    'processData': false,
    'contentType': 'text/xml',
    'success': function(data) {
      if(data.code == 200) {
        //console.log(data.data);
        var bookdate = data.data.bookdate;
        var days = $('.day');
        var normal = data.data.nomal_money;
        var week = data.data.week_money;
        var holiday = data.data.holiday_money;
        bookItems = bookdate;
        $.each(bookdate, function(i, d) {
          var me = d;
          var dat = me.name; 
          var dstamp = Date.parse(dat.replace(/-/g,"/"));
          for(var i = 0; i <= days.length; i++) {
            var ob = $(days[i]);
            var value = ob.data('value');
            if(value) {
              var ostamp = Date.parse(value.replace(/-/g,"/")); 
              if(dstamp == ostamp) {
                var htm = ob.html().trim();
                if(me.isbook) {
                  ob.html(htm + '<br>已预订');   
                } else if (me.isgone) {
                  ob.html(htm + '<br><span style="color:#ccc">' + '订完了' + '</span>');   
                } else {
                  if(me.isweek) {
                    ob.html(htm + '<br><span style="color:#ccc">¥' + week + '</span>');   
                    ob.data('price', week);
                    if(me.isholiday) {
                      ob.html(htm + '<br>¥<span style="color:#ccc>"' + holiday + '</span>');   
                      ob.data('price', holiday);
                    }
                  } else if (me.isholiday) {
                    ob.html(htm + '<br>¥<span style="color:#ccc">' + holiday + '</span>');   
                    ob.data('price', holiday);
                  } else {
                    ob.html(htm + '<br><span style="color:#ccc">¥' + normal + '</span>');   
                    ob.data('price', normal);
                  }
                }
              }
            } else {
              continue; 
            }
          } 
        });
        if(typeof(total) == 'function') {
          total(); 
        }
        if(typeof(rebind) == 'function') {
          rebind(); 
        }
      }
    },
    'error': function(err, data) {
      console.log(err);  
    }
  });
}
</script>

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
          $('#minmoney').text(minmoney);
          $('#maxmoney').text(maxmoney);
      }
    });
  });
</script>

<script>
  
   $(function(){
        collect();
        hit();
        $(function(){
          $(".moch_click li").click(function(){
            $(this).addClass("hm_cut").siblings().removeClass("hm_cut")
          })  
        });
        // 加个选择后ajax
        $('.pricesub').click(function(){
          var values = $('input.range-slider').val();
          var arr = values.split(',');
          data.minmoney = arr[0];
          data.maxmoney = arr[1];
          $.post("<?php echo U('Web/Hostel/select');?>",data,function(res){
            addHtml(res);
            collect();
            hit();
            $('.mask, .tra_drop').fadeOut('show');
          })
        })
        // 选择城市
        $('#area').change(function(){
            var city=$('#city');
            var data={'parentid':$(this).val()};
            $.get("<?php echo U('Web/Note/getchildren');?>",data,function(res){
                res = JSON.parse(res); 
                var option='';
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
            $.get("<?php echo U('Web/Note/getchildren');?>",data,function(res){
                if(res == null || res == 'null') {
                  data['area'] = $('#area').val() + ',' + $('#city').val();
                  $('#thelist').html('');
                  //ajax_send(data);
                  loaded({'area': $('#area').val() + ',' + $('#city').val()});
                  $('.mask').hide();
                  $('.tra_drop').hide();
                  return; 
                }
                res = JSON.parse(res);
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
            if($('#city').val()==$(this).val()){
              area=$('#area').val()+','+$('#city').val();
            }
            data['city']=area;
            $('#thelist').html('');
            //ajax_send(data);
            $('.mask').hide();
            $('.tra_drop').hide();
        });
        // 选择特色
        $('.hostelcate').click(function(){
          data['catid']=$(this).data('id');
          if(!data['catid']) {
            ajax_send(); 
          } else {
            ajax_send(data);
          }
          $('.mask').hide();
          $('.tra_drop').hide();
        });
        // 支持
        var a=[];
        /*
        $('.support').click(function(){
            if(a.length==0){
              a.push($(this).data('id'));
            } else {
              if(a.indexOf($(this).data('id'))!=-1){
                console.log('del');
                a.remove(a.indexOf($(this).data('id')));
              }
              else{
                console.log('add');
                a.push($(this).data('id'));
              }
            }
            supportArray = a.join(",");
            data['support']=supportArray;
            ajax_send(data);
        });
        */
        $('#cates').click(function(evt) {
          evt.preventDefault();
          $('.support').each(function(i, t) {
            var _this = $(t);
            if(!_this.hasClass('stay_rightCut')) 
              return;
            if(a.length==0){
              a.push(_this.data('id'));
            } else {
              if(a.indexOf(_this.data('id'))!=-1){
                console.log('del');
                a.remove(a.indexOf(_this.data('id')));
              }
              else{
                console.log('add');
                a.push(_this.data('id'));
              }
            }
            supportArray = a.join(",");
            data['support']=supportArray;
          });
          $('.hosteltype').each(function(i, t) {
            var _this = $(t); 
            if(!_this.hasClass('stay_rightCut')) return;
            data.type = _this.data('id');
          });
          ajax_send(data); 
        });
        // 类型
        /*
        $('.hosteltype').click(function(){
          console.log(data);
          data['type']=$(this).data('id');
          console.log(data)
          ajax_send(data);
        })
         */
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
        $('.tra_drop').hide();
        $('.mask').hide();
        addHtml(res);
        collect();
        hit();
      })
    }
    function collect(){
        // 收藏
        $('.collect').unbind('click');
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
        var thelist =$('#thelist');
        thelist.html('');
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
        thelist.append(content);
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
<script>
    var p = {};
    var city, month, notetype, order = 0;
    var OFFSET = 5;
    var page = 1;
    var PAGESIZE = 5;

    var myScroll,
        pullDownEl,
        pullDownOffset,
        pullUpEl,
        pullUpOffset,
        generatedCount = 0;

    var maxScrollY = 0;
    var hasMoreData = false;

    $(function () {
        loaded();
        $(".mask").click(function () {
            $(".tra_drop").hide()
            $("#time_box").hide();
            $("#time_choose_box").hide();
            loaded()
        })
    })

    function loaded() {
        page = 1;
        p['p'] = page;
        p['month'] = ($(".month li.tra_dropCut").length > 0) ? $(".month li.tra_dropCut").data('id') : 0;
        p['type'] = ($(".order li.tra_dropCut").length > 0) ? $(".order li.tra_dropCut").data('id') : 0;
        p['notetype'] = ($(".notetype li.tra_dropCut").length > 0) ? $(".notetype li.tra_dropCut").data('id') : 0;
        p['province'] = $("#area").val();
        p['city'] = $('#city').val();
        p['town'] = $('#county').val();
        var options = arguments[0] ? arguments[0] : undefined;
        if(options) {
          $.each(options, function(k, v) {
            p[k] = v; 
          });
        }
        pullDownEl = document.getElementById('pullDown');
        pullDownOffset = pullDownEl.offsetHeight;
        pullUpEl = document.getElementById('pullUp');
        pullUpOffset = pullUpEl.offsetHeight;
        hasMoreData = false;
        $("#pullUp").hide();
        pullDownEl.className = 'loading';
        pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
        $.get("<?php echo U('Web/Hostel/ajax_getlist');?>", p, function (data, status) {
            if (status == "success") {
                if (data.status == 0) {
                    $("#pullDown").hide();
                    $("#pullUp").hide();
                }
                if (data.num < PAGESIZE) {
                    hasMoreData = false;
                    $("#pullUp").hide();
                } else {
                    hasMoreData = true;
                    $("#pullUp").show();
                }

                myScroll = new iScroll('DataList', {
                    useTransition: true,
                    topOffset: pullDownOffset,
                    onRefresh: function () {
                        if (pullDownEl.className.match('loading')) {
                            pullDownEl.className = 'idle';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
                            this.minScrollY = -pullDownOffset;
                        }
                        if (pullUpEl.className.match('loading')) {
                            pullUpEl.className = 'idle';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉刷新...';
                        }
                    },
                    onScrollMove: function () {
                        if (this.y > OFFSET && !pullDownEl.className.match('flip')) {
                            pullDownEl.className = 'flip';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '信息更新中...';
                            this.minScrollY = 0;
                        } else if (this.y < OFFSET && pullDownEl.className.match('flip')) {
                            pullDownEl.className = 'idle';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉加载更多...';
                            this.minScrollY = -pullDownOffset;
                        }
                        if (this.y < (maxScrollY - pullUpOffset - OFFSET) && !pullUpEl.className.match('flip')) {
                            if (hasMoreData) {
                                this.maxScrollY = this.maxScrollY - pullUpOffset;
                                pullUpEl.className = 'flip';
                                pullUpEl.querySelector('.pullUpLabel').innerHTML = '信息更新中...';
                            }
                        } else if (this.y > (maxScrollY - pullUpOffset - OFFSET) && pullUpEl.className.match('flip')) {
                            if (hasMoreData) {
                                this.maxScrollY = maxScrollY;
                                pullUpEl.className = 'idle';
                                pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                            }
                        }
                    },
                    onScrollEnd: function () {
                        if (pullDownEl.className.match('flip')) {
                            pullDownEl.className = 'loading';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
                            refresh();
                        }
                        if (hasMoreData && pullUpEl.className.match('flip')) {
                            pullUpEl.className = 'loading';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';
                            nextPage();
                        }
                    }
                });
                $("#thelist").empty();
                $("#thelist").html(data.html);
                myScroll.refresh();
                if (hasMoreData) {
                    myScroll.maxScrollY = myScroll.maxScrollY + pullUpOffset;
                } else {
                    myScroll.maxScrollY = myScroll.maxScrollY;
                }
                maxScrollY = myScroll.maxScrollY;
                collect();
                getLocation();
            };
        }, "json");
        pullDownEl.querySelector('.pullDownLabel').innerHTML = '无数据...';
        
    }

    function refresh() {
        page = 1;
        p['p'] = page;
        p['month'] = ($(".month li.tra_dropCut").length > 0) ? $(".month li.tra_dropCut").data('id') : 0;
        p['type'] = ($(".order li.tra_dropCut").length > 0) ? $(".order li.tra_dropCut").data('id') : 0;
        p['notetype'] = ($(".notetype li.tra_dropCut").length > 0) ? $(".notetype li.tra_dropCut").data('id') : 0;
        p['province'] = ($("#province option:selected").length > 0) ? $("#province option:selected").val() : 0;
        p['city'] = ($("#city option:selected").length > 0) ? $("#city option:selected").val() : 0;
        p['town'] = ($("#town option:selected").length > 0) ? $("#town option:selected").val() : 0;
        $.get("<?php echo U('Web/Hostel/ajax_getlist');?>", p, function (data, status) {
            if (status == "success") {
                if (data.length < PAGESIZE || data.status == 0) {
                    hasMoreData = false;
                    $("#pullUp").hide();
                } else {
                    hasMoreData = true;
                    $("#pullUp").show();
                }
                $("#thelist").empty();
                $("#thelist").html(data.html);
                myScroll.refresh();
                if (hasMoreData) {
                    myScroll.maxScrollY = myScroll.maxScrollY + pullUpOffset;
                } else {
                    myScroll.maxScrollY = myScroll.maxScrollY;
                }
                maxScrollY = myScroll.maxScrollY;
                getLocation();
            };
        }, "json");
    }

    function nextPage() {
        page++;
        p['p'] = page;
        p['month'] = ($(".month li.tra_dropCut").length > 0) ? $(".month li.tra_dropCut").data('id') : 0;
        p['type'] = ($(".order li.tra_dropCut").length > 0) ? $(".order li.tra_dropCut").data('id') : 0;
        p['notetype'] = ($(".notetype li.tra_dropCut").length > 0) ? $(".notetype li.tra_dropCut").data('id') : 0;
        p['province'] = ($("#province option:selected").length > 0) ? $("#province option:selected").val() : 0;
        p['city'] = ($("#city option:selected").length > 0) ? $("#city option:selected").val() : 0;
        p['town'] = ($("#town option:selected").length > 0) ? $("#town option:selected").val() : 0;

        $.get("<?php echo U('Web/Hostel/ajax_getlist');?>", p, function (data, status) {
            if (status == "success") {
                if (data.length < PAGESIZE || data.status == 0) {
                    hasMoreData = false;
                    $("#pullUp").hide();
                } else {
                    hasMoreData = true;
                    $("#pullUp").show();
                }
                $new_item = data.html;
                $("#thelist").append(data.html);
                myScroll.refresh();
                if (hasMoreData) {
                    myScroll.maxScrollY = myScroll.maxScrollY + pullUpOffset;
                } else {
                    myScroll.maxScrollY = myScroll.maxScrollY;
                }
                maxScrollY = myScroll.maxScrollY;
            };
        }, "json");
    }
</script>
<script>
  $('.stay_timer').click(function(evt) {
    evt.preventDefault();
    $('#time_choose_box').fadeIn('fast');
    $('.mask').show();
    var type = $(this).data('type');
    $('.day').unbind('click');
    $('.day').click(function(evt) {
      evt.preventDefault();
      var _this = $(this);
      var dat = _this.html().trim();
      var mon = $('.month').html().trim();
      var dStr = mon.replace('-', ',') + ',' + dat;
      var month = mon.split('-')[1];
      var d = new Date(dStr);
      var weekShow = getWeekDate(d.getDay());
      var year = mon + '-' + (dat < 10 ? 0 + dat.toString() : dat);
      var timestamp = $.myTime.DateToUnix(year);
      if(type == 'start') {
        var endStamp = $.myTime.DateToUnix($('#live_2').val());
        var durations = (endStamp - timestamp)/(3600 * 24);
        if(durations <= 0) {
          alert('离店时间必须大于入住时间！');
          return;
        }
        $('#start_week_day').html(weekShow);
        $('#start_date').html(month + '-' + dat);
        $('#live_1').val(year);
        $('#stay_days').html('住' + durations + '晚');
      }
      if(type == 'end') {
        var startStamp = $.myTime.DateToUnix($('#live_1').val());
        var durations = (timestamp - startStamp)/(3600 * 24);
        console.log(durations);
        if(durations <= 0) {
          alert('离店时间必须大于入住时间！');
          return;
        }
        $('#leave_week_day').html(weekShow);
        $('#leave_date').html(month + '-' + dat);
        $('#stay_days').html('住' + durations + '晚');
        $('#live_2').val(year);
      }
      $('#time_choose_box').hide();
    });
  });
  $('#stay').click(function(evt) {
    evt.preventDefault();
    $('#time_box').show();
    $('.mask').show();
  });
  $('#prev_day').click(function(evt) {
    evt.preventDefault();
    var starttime = $('#live_1').val()
    var endtime = $('#live_2').val();
    var starttimestamp = $.myTime.DateToUnix(starttime) - 3600 * 24;
    var todayTimestamp = $.myTime.DateToUnix($.myTime.UnixToDate(new Date().getTime()/1000));
    if(starttimestamp < todayTimestamp)  {
      alert('入住时间不能小于当日日期！');
      return;
    }
    var endtimestamp = $.myTime.DateToUnix(endtime);
    var preStarttime = $.myTime.UnixToDate(starttimestamp);
    var weekDate = getWeekDate(new Date(preStarttime).getDay());
    $('#start_week_day').html(weekDate);
    $('#start_date').html(preStarttime.substring(5));
    $('#live_1').val(preStarttime);
    var durations = (endtimestamp - starttimestamp)/(3600 * 24);
    $('#stay_days').html('住' + durations + '晚');
  });
  $('#next_day').click(function(evt) {
    evt.preventDefault();
    var starttime = $('#live_1').val()
    var endtime = $('#live_2').val();
    var starttimestamp = $.myTime.DateToUnix(starttime) + 3600 * 24;
    var endtimestamp = $.myTime.DateToUnix(endtime);
    if(endtimestamp <= starttimestamp) {
      alert('入住时间必须小于离店时间！');
      return;
    }
    var nextstarttime = $.myTime.UnixToDate(starttimestamp);
    var weekDate = getWeekDate(new Date(starttimestamp).getDay());
    $('#start_week_day').html(weekDate);
    $('#start_date').html(nextstarttime.substring(5));
    $('#live_1').val(nextstarttime);
    var durations = (endtimestamp - starttimestamp)/(3600 * 24);
    $('#stay_days').html('住' + durations + '晚');
  });
  $('#add_day').click(function(evt) {
    evt.preventDefault();
    var starttime = $('#live_1').val()
    var endtime = $('#live_2').val();
    var starttimestamp = $.myTime.DateToUnix(starttime);
    var endtimestamp = $.myTime.DateToUnix(endtime) + 3600 * 24;
    var endDate = $.myTime.UnixToDate(endtimestamp);
    var durations = (endtimestamp - starttimestamp)/(3600 * 24);
    var weekDate = getWeekDate(new Date(endtimestamp).getDay());
    $('#leave_week_date').html(weekDate);
    $('#leave_date').html(endDate.substring(5));
    $('#live_2').val(endDate);
    $('#stay_days').html('住' + durations + '晚');
  });
  $('#minu_day').click(function(evt) {
    evt.preventDefault()
    var starttime = $('#live_1').val();
    var endtime = $('#live_2').val();
    var starttimestamp = $.myTime.DateToUnix(starttime);
    var endtimestamp = $.myTime.DateToUnix(endtime) - 3600 * 24;
    if(endtimestamp <= starttimestamp) {
      alert('离店日期必须大于入住日期');
      return;
    }
    var endDate = $.myTime.UnixToDate(endtimestamp);
    var durations = (endtimestamp - starttimestamp)/(3600 * 24);
    var weekDate = getWeekDate(new Date(endtimestamp).getDay());
    $('#leave_week_date').html(weekDate);
    $('#leave_date').html(endDate.substring(5));
    $('#live_2').val(endDate);
    $('#stay_days').html('住' + durations + '晚');
  });
  function getWeekDate(d) {
    switch(d) {
      case 0:
       return '周日';
      case 1:
       return '周一';
      case 2:
       return '周二';
      case 3:
       return '周三';
      case 4:
       return '周四';
      case 5:
       return '周五';
      case 6:
       return '周六';
    }
  }
</script>
<script>
$('#go_search').click(function(evt) {
  evt.preventDefault();
  window.location.href="<?php echo U('Web/Public/search_project');?>";
});
$('#submit_area').click(function(evt) {
  evt.preventDefault();
  $('#thelist').html('');
  loaded(); 
  $('.mask').hide();
  $('.sarea').fadeOut('fast');
});
function getHotelDistance(lat, lng) {
  console.log(lat);
  console.log(lng);
  $('.distances').each(function(i, obj) {
    var _this = $(obj);
    var dlat = _this.data('lat');
    var dlng = _this.data('lng');
    $.ajax({
      'url': '<?php echo U("Api/Map/get_distance_for_web");?>?o_lat=' + lat + '&o_lng=' + lng + '&d_lat=' + dlat + '&d_lng=' + dlng,
      'type': 'get',
      'dataType': 'text',
      'success': function(data) {
        _this.html(data);
      },
      'error': function(err) {
        console.log(err); 
      }
    });
  });
}
</script>
<script src="/Public/Web/js/jquery.range.js"></script>
<script>
$(function(){
  $('.range-slider').jRange({
    from: 0,
    to: 5000,
    step: 1,
    format: '%s',
    width: 300,
    showLabels: true,
    isRange : true,
    onstatechange: function (data) {
      var values = data.split(',');
      $('#minmoney').html(values[0]);
      $('#maxmoney').html(values[1]);
      data.minmoney = values[0];
      data.maxmoney = values[1];
    }
  });
});
</script>
</body>
</html>