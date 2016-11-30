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

<script type="text/javascript">
    var areaurl = "<?php echo U('Web/Note/getchildren');?>";
    $(function () {
        var province = "<?php echo ($_GET['province']); ?>";
        var city = "<?php echo ($_GET['city']); ?>";
        if (province != '') {
            load(province, 'city');
        }
        if (city != '') {
            load(city, 'town');
        }
    })
    function load(parentid, type) {
        $.ajax({
            type: "GET",
            url: areaurl,
            data: { 'parentid': parentid },
            dataType: "json",
            success: function (data) {
                if (type == 'city') {
                    $('#city').html('<option value="">--请选择--</option>');
                    $('#town').html('<option value="">--请选择--</option>');
                    if (data != null) {
                        $.each(data, function (no, items) {
                            if (items.id == "<?php echo ($_GET['city']); ?>") {
                                $('#city').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                            } else {
                                $('#city').append('<option value="' + items.id + '">' + items.name + '</option>');
                            }
                        });
                    }
                } else if (type == 'town') {
                    $('#town').html('<option value="">--请选择--</option>');
                    if (data != null) {
                        $.each(data, function (no, items) {
                            if (items.id == "<?php echo ($_GET['town']); ?>") {
                                $('#town').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                            } else {
                                $('#town').append('<option value="' + items.id + '">' + items.name + '</option>');
                            }
                        });
                    }
                }
            }
        });
    }
</script>
<div class="header center z-index112 pr f18 fix-head">
  活动
  <div class="head_go pa">
    <a href="<?php echo U('Web/Index/index');?>"><img src="/Public/Web/images/go.jpg"></a><span>&nbsp;</span></div>
  <div class="tra_pr pa"><i></i><a href="<?php echo U('Public/search_project');?>"><img src="/Public/Web/images/search.jpg"></a></div>
</div>

<div class="container" style="margin-top:6rem">
   <div class="land">
          <div class="tra_list pr z-index112 center f14">
                <div class="tra_li tra_li_on">按特色</div>
                <div class="tra_drop">
                    <div class="act_pad">
                        <div class="dress_box">
                             <div class="dress_b act_a moch_click center f14 partycate">
                                 <ul>
                                    <li data-id='0'>不限</li>
                                    <?php if(is_array($partycate)): $i = 0; $__LIST__ = $partycate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-id='<?php echo ($vo["id"]); ?>'><?php echo ($vo["catname"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </ul>
                             </div>
                       </div>
                    </div>
                </div>
                <div class="tra_li tra_li_on" id="for_time">按时间</div>
                <div class="tra_drop">
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
                <div class="tra_li tra_li_on">按位置</div>
                <div class="tra_drop">
                    <div class="tra_dropA_box">
                      <div class="tra_dropA">
                          <select name="province" id="province" onchange="load(this.value,'city',0)">
                              <option value="">--请选择--</option>
                              <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $_GET['province']): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                          </select>
                          <select name="city" id="city" onchange="load(this.value,'town',0)">
                              <option value="">--请选择--</option>
                          </select>

                          <select name="town" id="town" onchange="load(this.value,'distinct',0)">
                              <option value="">--请选择--</option>
                          </select>
                      </div>
                  </div>
                </div>
              <div class="tra_li tra_li_on">筛选</div>
                <div class="tra_drop" style=""block;>
                    <div class="act_scring">
                        <div class="scr_top">
                          <div class="scr_e1" style="margin-bottom:2rem;">活动费用</div> 
                          <div class="scr_b" style="margin-bottom:1rem;">
                            <div class="range_scroll" style="padding:0 8px;">
                             <input class="range-slider" type="hidden" value="0,5000"/>
                            </div>
                            <div class="number" style="padding:5px 0 12px 0">
                              <div class="number_a fl">￥0</div>
                              <div class="number_b fr">￥5000</div>
                            </div>
                            <div class="ft16 mng_content" style="padding:0px">
                              <div class="mng_left fl">
                                ￥<span id='minmoney'>0</span> — 
                                ￥<span id='maxmoney'>1000</span>
                              </div>
                            </div>
                          </div>
                          <div class="scr_c"></div> 
                          <div class="scr_d center">免费活动</div> 
                        </div> 
                        <div class="scr_btm">
                             <div class="dress_box">
                                     <div class="scr_e1">按类型 :</div>
                                     <div class="dress_b act_a moch_click center f14">
                                         <ul id="party_type">
                                             <li data-id="0">不限</li>
                                             <li data-id="1">亲子类</li>
                                             <li data-id="2">情侣类</li>
                                             <li data-id="3">家庭出游</li>
                                         </ul>
                                     </div>
                                     <div class="snail_d scr_e2 center f16">
                                            <a href="javascript:;" id="clear_selected" class="mr_4">清除筛选</a>
                                            <a href="javascript:;" id="confirm_selected">确定</a>
                                      </div>
                              </div> 
                        </div>        
                    </div>
                </div>
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
   <input type="hidden" name="uid" value="<?php echo ($uid); ?>" id="uid" >
</div>
<script src="/Public/Web/js/jquery-ui.min.js"></script>
<script>
  $(function() {
      $("#slider-range").slider({
            range: true,
            min: 0,
            max: 5000,
            step: 100,
            values: [0, 5000],
            slide: function (event, ui) {
                $("#minmoney").text(ui.values[0]);
                $("#maxmoney").text(ui.values[1]);
            }
      });
      $(".scr_d").click(function(){
        $(this).toggleClass("hm_cut"); 
      });
      $(".partytype li").click(function(){ 
        $(this).addClass("hm_cut").siblings().removeClass("hm_cut")   
      }); 
      $(".partycate li").click(function(){
        $(this).addClass("hm_cut").siblings().removeClass("hm_cut");
        $(".tra_drop").hide();
        $('.mask').hide();
        loaded();
      });
  });
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

    document.addEventListener('touchmove', function (e) {
        e.preventDefault();
    }, false);
    $(function () {
        loaded();
        $(".mask,.snail_cut").click(function () {
            $(".tra_drop").hide()
            loaded()
        })
    })

    function loaded() {
        console.log('loadding');
        page = 1;
        p['p'] = page;
        p['catid'] = ($(".partycate li.hm_cut").length > 0) ? $(".partycate li.hm_cut").data('id') : 0;
        p['partytype'] = ($(".partytype li.hm_cut").length > 0) ? $(".partytype li.hm_cut").data('id') : 0;
        p['isfree'] = ($(".scr_d.hm_cut").length > 0) ? 1 : 0;
        p['province'] = ($("#province option:selected").length > 0) ? $("#province option:selected").val() : 0;
        p['city'] = ($("#city option:selected").length > 0) ? $("#city option:selected").val() : 0;
        p['town'] = ($("#town option:selected").length > 0) ? $("#town option:selected").val() : 0;
        if(arguments[0]) {
          $.each(arguments[0], function(key, val) {
            p[key]  = val;
          });
        }
        console.log(arguments);

        pullDownEl = document.getElementById('pullDown');
        pullDownOffset = pullDownEl.offsetHeight;
        pullUpEl = document.getElementById('pullUp');
        pullUpOffset = pullUpEl.offsetHeight;
        hasMoreData = false;
        $("#pullUp").hide();
        pullDownEl.className = 'loading';
        pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
        $.get("<?php echo U('Web/Party/ajax_getlist');?>", p, function (data, status) {
            if (status == "success") {
              if (data.status == 0) {
                  $("#pullDown").hide();
                  $("#pullUp").hide();
                  $('#thelist').html('');
                  $('.mask, .tra_drop').fadeOut('slow');
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
                      console.log(hasMoreData);
                      if (pullUpEl.className.match('flip')) {
                          pullUpEl.className = 'loading';
                          pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';
                          nextPage();
                      }
                  }
              });

              $("#thelist").html(data.html);
              $('.mask, .tra_drop').fadeOut('slow');

              $('.collect').unbind('click');
              $('.collect').bind('click', function(evt) {
                evt.preventDefault();
                var _me = $(this);
                var isCollect = _me.data('collect');
                var aid = _me.data('id');
                var uid = $('#uid').val();
                if(!uid) {
                  alert('请先登录！');
                  window.location.href="<?php echo U('member/login');?>";
                }
                var url = '';
                if(!isCollect) {
                   url = '<?php echo U("/Api/Activity/collect");?>';
                } else {
                   url = '<?php echo U("/Api/Activity/uncollect");?>';
                }
                $.ajax({
                  'url': url,
                  'data': JSON.stringify({
                    'uid': uid,
                    'aid': aid
                  }),
                  'dataType': 'json',
                  'contentType': 'text/xml',
                  'processData': false,
                  'type': 'post',
                  'success': function(data) {
                    if(data.code == 200) {
                      console.log(isCollect);
                      if(isCollect) {
                        _me.removeClass('recom_c_cut');
                        _me.data('collect', 0)
                      } else {
                        _me.addClass('recom_c_cut');
                        _me.data('collect', 1)
                      }
                    }
                  },
                  'error': function(err, data) {
                    console.log(err); 
                  }
                });
              });

                myScroll.refresh();
                if (hasMoreData) {
                    myScroll.maxScrollY = myScroll.maxScrollY + pullUpOffset;
                } else {
                    myScroll.maxScrollY = myScroll.maxScrollY;
                }
                maxScrollY = myScroll.maxScrollY;
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
        $.get("<?php echo U('Web/Party/ajax_getlist');?>", p, function (data, status) {
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
        $.get("<?php echo U('Web/Party/ajax_getlist');?>", p, function (data, status) {
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
$('#town').change(function(evt) {
  evt.preventDefault();
  $(".tra_drop").hide()
  $('.mask').hide();
  loaded()
});
function partydate() {
  $('.day').click(function(evt) {
    evt.preventDefault();
    var d = $(this).data('value');
    $('#for_time').html(d.substring(5, 10));
    loaded({'time': d});
  });
}
</script>
<script src="/Public/Web/js/jquery.range.js"></script>
<script>
var dataSet = {};
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
      dataSet.minmoney = values[0];
      dataSet.maxmoney = values[1];
    }
  });
});
$('#clear_confirm').click(function(evt) {
  evt.preventDefault();
    
});
$('#confirm_selected').click(function(evt) {
  evt.preventDefault();
  console.log(dataSet);
  loaded(dataSet);
});
$('#party_type > li').click(function(evt) {
  evt.preventDefault();
  var _this = $(this);
  if(_this.hasClass('choose_blue')) {
    _this.removeClass('choose_blue'); 
    dataSet.partytype = 0;
  } else {
    _this.siblings().removeClass('choose_blue');
    _this.addClass('choose_blue');
    dataSet.partytype = _this.data('id');
  }
});
</script>
</body>
</html>