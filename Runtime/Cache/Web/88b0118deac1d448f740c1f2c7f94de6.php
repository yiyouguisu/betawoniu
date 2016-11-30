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
    <div class="container padding_0">
        <div class="land">
          <div class="act_g pr">
              <div class="act_g1">
                  <img src="<?php echo ($data["thumb"]); ?>">
              </div>
              <div class="history pa">
                  <a href="<?php echo U('Hostel/show');?>?id=<?php echo ($data["hid"]); ?>" style="display:block;">
                      <img src="/Public/Web/images/go.png">
                  </a><span>&nbsp;</span>
              </div>
              <div class="recom_c pa">
                  <div class="recom_gg collect <?php if($data["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>"
                  data-id="<?php echo ($data["rid"]); ?>"></div>
                  <span><a href=""><img src="/Public/Web/images/share.png"></a></span>
                  <span><a href=""><img src="/Public/Web/images/recom_a3.png"></a></span>
              </div>
              <div class="act_g2 f16 center pa">
                <em>￥</em><span><?php echo ($data["money"]); ?></span><em>起</em>
              </div>
          </div>

          <div class="det_box">
              <div class="act_k">
                  <div class="act_k1 vertical"><?php echo ($data["title"]); ?></div>
                  <div class="act_k2 vertical hit" data-id="<?php echo ($data["rid"]); ?>">
                      <?php if($data["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png">
                          <?php else: ?>
                          <img src="/Public/Web/images/poin.png"><?php endif; ?>
                      <span class="vcount"><?php echo ($data["hit"]); ?></span>
                  </div>
              </div>

              <div class="edg">
                  <div class="edg_a fl">
                      <div class="edg_b">8.8<span>分</span>
                      </div>
                      <div class="edg_c">
                          <span><img src="/Public/Web/images/star.png"></span>
                          <span><img src="/Public/Web/images/star.png"></span>
                          <span><img src="/Public/Web/images/star.png"></span>
                          <span><img src="/Public/Web/images/star.png"></span>
                          <span><img src="/Public/Web/images/star.png"></span>
                      </div>
                  </div>
                  <a href="homestay-2.html">
                      <div class="edg_d fr">
                          <img src="/Public/Web/images/edg_a1.jpg"><?php echo ($data["reviewnum"]); ?>条评论 <span><img src="/Public/Web/images/arrow.jpg"></span>
                      </div>
                  </a>
              </div>

              <div class="wx_box">
                  <div class="wx_top">
                      <div class="wx_list">
                          <div class="wx_a">
                              <div class="wx_b vertical">
                                  <img src="/Public/Web/images/wx_a9.jpg">建筑面积 :</div>
                              <div class="wx_c vertical"><?php echo ($data["area"]); ?>m²</div>
                          </div>

                          <div class="wx_a">
                              <div class="wx_b vertical">
                                  <img src="/Public/Web/images/wx_a10.jpg">房间数：</div>
                              <div class="wx_c vertical"><?php echo ($data["mannum"]); ?>间</div>
                          </div>
                      </div>
                      
                      <?php if(is_array($data["support"])): $i = 0; $__LIST__ = $data["support"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="wx_list">
                              <?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><div class="wx_a">
                                      <div class="wx_b vertical">
                                          <img src="<?php echo ($svo["gray_thumb"]); ?>">
                                      </div>
                                      <div class="wx_c vertical"><?php echo ($svo["catname"]); ?></div>
                                  </div><?php endforeach; endif; else: echo "" ;endif; ?>
                          </div><?php endforeach; endif; else: echo "" ;endif; ?>
                  </div>
                  <div class="wx_btm">
                      <div class="wx_list">
                          <div class="wx_d">便利设施 :</div>
                          <div class="wx_e"><?php echo ($data["conveniences"]); ?></div>
                      </div>

                      <div class="wx_list">
                          <div class="wx_d">浴室 :</div>
                          <div class="wx_e"><?php echo ($data["bathroom"]); ?></div>
                      </div>

                      <div class="wx_list">
                          <div class="wx_d">媒体科技 :</div>
                          <div class="wx_e"><?php echo ($data["media"]); ?></div>
                      </div>

                      <div class="wx_list" style="border-bottom:0;">
                          <div class="wx_d">食品饮品 :</div>
                          <div class="wx_e"><?php echo ($data["food"]); ?></div>
                      </div>
                  </div>

              </div>
          </div>



          <div class="vb_c ">
              <div class="vb_c1 center">房间简介</div>
              <div class="vb_c2">
                  <p><?php echo ($data["content"]); ?></p>
              </div>
              <div class="vb_c3 snake_click"><a href="javascript:;">查看完整美宿房间简介</a>
              </div>
          </div>
          <div class="vb_c ">
            <div class="vb_c1 center">可约日期</div>
            <div id="time_choose_box">
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
            <br>
            <div class="act_href center" style="margin:0;">
                <a href="javascript:;" data-href="<?php echo U('Web/Order/bookroom',array('id'=>$data['rid'],'hid'=>$hid));?>" id="go_book">我要预订</a>
            </div>
          </div>
        </div>
        <div class="big_mask"></div>
        <div class="pyl">
            <div class="pyl_top pr">房间简介
                <div class="pyl_close pa">
                    <img src="/Public/Web/images/close.jpg">
                </div>
            </div>
            <div class="pyl_font" style="height:85%;-webkit-overflow-scrolling:touch;overflow:auto">
                <iframe style="overflow:scroll;width:100%;height:auto;border:0;" src="<?php echo U('Web/Room/app_show');?>?id=<?php echo ($data["rid"]); ?>" scrolling="no">
                </iframe>
                <div class="snail_d homen_style center f16">
                    <a href="javescript:;" class="common_click" style="width:100%">我知道了</a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function()
            {
                collect();
                hit();
            })

            function collect()
            {
                // 收藏
                $('.collect').click(function()
                {
                    var self = $(this);
                    var id = self.data('id');
                    var data = {
                        'type': 3,
                        'id': id
                    };
                    console.log(data);
                    $.post("<?php echo U('Web/Ajaxapi/collection');?>", data,
                        function(res)
                        {
                            console.log(res);
                            if (res.code == 200)
                            {
                                self.addClass('recom_c_cut');
                            }
                            else if (res.code == 300)
                            {
                                self.removeClass(
                                    'recom_c_cut');
                            }
                            else
                            {
                                alert(res.msg);
                            }
                        });
                })
            }

            function hit()
            {
                // 收藏
                $('.hit').click(function()
                {
                    var self = $(this);
                    var id = self.data('id');
                    var data = {
                        'type': 4,
                        'id': id
                    };
                    var hit = self.text();
                    console.log(data);
                    $.post("<?php echo U('Web/Ajaxapi/hit');?>", data,
                        function(res)
                        {
                            console.log(res);
                            if (res.code == 200)
                            {
                                self.find('span').text(Number(
                                    hit) + 1)
                                self.find('img').attr('src',
                                    '/Public/Web/images/poin_1.png');
                            }
                            else if (res.code == 300)
                            {
                                self.find('span').text(Number(
                                    hit) - 1)
                                self.find('img').attr('src',
                                    '/Public/Web/images/poin.png');
                            }
                            else
                            {
                                alert(res.msg);
                            }
                        });
                })
            }
        </script>
        <script>
          $('#go_book').click(function(evt) {
            evt.preventDefault();
            var is_owner = '<?php echo ($data["is_owner"]); ?>';
            if(is_owner) {
              alert('房东不能预定自己的房间！');
            } else {
              var href = $(this).data('href');
              if(is_weixin()) {
                href += '?weixin=1';
              }
              window.location.href = href;
            }
          });
        </script>
</body>
<script>
  
</script>
</html>