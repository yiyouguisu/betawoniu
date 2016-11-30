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
    <div class="header center z-index112 pr f18" style="position:fixed;left:0;top:0;right:0">
        预订美宿
        <div class="head_go pa">
            <a href="<?php echo U('Room/show');?>?id=<?php echo ($data["rid"]); ?>">
                <img src="/Public/Web/images/go.jpg">
            </a><span>&nbsp;</span>
        </div>
    </div>
    <div class="container padding_0" style="margin-top:6rem">
        <div class="act_e" style="margin-bottom:2rem;">
            <div class="act_e1 fl">
                <img src="<?php echo ($data["thumb"]); ?>">
            </div>
            <div class="act_e2 fr">
                <div class="act_e3"><?php echo ($data["t"]); ?></div>
                <div class="act_e4"><?php echo ($data["title"]); ?></div>
            </div>
        </div>
        <form action="<?php echo U('Web/Order/createbook');?>" method="post" id='form' onsubmit="return checkForm();">
            <input type="hidden" name="_token" value='<?php echo ($_token); ?>'>
            <div class="yr">
                <div class="yr-a center">入住时间和离店时间</div>
                <div class="yr-b" style="margin-bottom:0;">
                    <div class="yr-c center fl time-box" data-target="#start_time" data-type="start">
                        <div class="yr-c1">
                            <img src="/Public/Web/images/date.jpg">
                            </label>
                        </div>
                        <div class="yr-c2">入住时间</div>
                        <div class="yr-c3">
                            <input class="ggo_text begin" name="starttime" type="date" value="<?php echo ($tomorrow); ?>"
                            id="start_time" style="display:none;">
                            <span><?php echo ($tomorrow); ?></span>
                        </div>
                    </div>
                    <div class="yr-d fl pr">
                        共<span id='day'>1</span>天
                        <div class="yr_line pa"></div>
                        <input type='hidden' value="1" name="days" class='day' />
                    </div>
                    <div class="yr-c center fl time-box" data-target="#leave_time" data-type="end">
                        <div class="yr-c1">
                            <label for="leave_time">
                                <img src="/Public/Web/images/date.jpg">
                            </label>
                        </div>
                        <div class="yr-c2">离店时间</div>
                        <div class="yr-c3">
                            <input class="ggo_text end" name="endtime" type="date" value="<?php echo ($afterTomorrow); ?>"
                            id="leave_time" style="display:none;">
                            <span><?php echo ($afterTomorrow); ?></span>
                        </div>
                    </div>
                </div>
                <div class="we snake_click">
                    <p class="over_ellipsis"><?php echo ($data["bookremark"]); ?></p>
                </div>
            </div>

            <div class="we_a" style="margin-bottom:8rem;">
                <div class="yr_list">
                    <div class="yr-a center ft12" style="padding:10px 5px 5px 5px">预订房间数</div>
                    <div class="we_b">
                        <div class="we_b1">
                            <input type="button" class="we_btn add2" value="-">
                        </div>
                        <div class="we_b2 center ft12">
                            <input type="number" name='rooms' id="rooms" class="we_text reduce_room" value="<?php echo ((isset($roomNum) && ($roomNum !== ""))?($roomNum):1); ?>">间
                        </div>
                        <div class="we_b1 right">
                            <input type="button" class="we_btn add2" value="+">
                        </div>
                    </div>
                </div>
                <div class="yr_list">
                    <div class="yr-a center ft12" style="padding:10px 5px 5px 5px">预订人数</div>
                    <div class="we_b" style="width:100%;text-align:center">
                        <div class="we_b2 center ft12" style="width:100%;padding:8px;">
                            <input style="text-align:center" type="text" name='people' class="we_people reduce"
                            value="<?php echo ((isset($pcount) && ($pcount !== ""))?($pcount):1); ?>" readonly>人
                        </div>
                    </div>
                </div>
                <div class="yr_list">
                    <div class="yr-a center ft12" style="padding:8px 5px 5px 5px">入住人信息</div>
                    <div class="we_c">

                    </div>
                    <div class="olist home_inforClick">
                        <a id="" style="vertical-align:middle;margin:0" class="ft14" href="javascript:void(0);">+添加入住人</a>
                    </div>
                </div>


                <div class="yr-a center ft12" style="padding:15px 5px 5px 5px">预订人信息</div>
                <div class="we_d">
                    <div class="lu_b">
                        <input type="text" class="ft12 lu_text" name="realname" placeholder="真实姓名 :" value="<?php echo ($member["realname"]); ?>">
                    </div>

                    <div class="lu_b">
                        <input type="text" class="ft12 lu_text" name="phone" placeholder="电话号码 :" value="<?php echo ($member["phone"]); ?>">
                    </div>

                    <div class="lu_b">
                        <input type="text" class="ft12 lu_text" name="idcard" placeholder="身份证号码 :" value="<?php echo ($member["idcard"]); ?>">
                    </div>

                </div>
            </div>

            <div class="ig" style="position:fixed;left:0;right:0;bottom:0">
                <div class="ig_left fl">
                    <div class="ig_a ft12" style="line-height:20px">订单总额 :
                        <span>
               <em class="ft14">￥</em><span class="ft16" id='total'><?php echo ($data["nomal_money"]); ?></span>
                        </span>
                    </div>
                    <div style="padding:0px">
                        <a class="ft10" href="#" id="price_detail" style="color:#ff5f4c">价格明细</a>
                    </div>
                </div>
                <div class="ig_right fr">
                    <input type="hidden" name="money" value="<?php echo ($data["nomal_money"]); ?>">
                    <input type="hidden" name="couponsid" value="">
                    <input type="hidden" name="discount" value="0.00">
                    <input type="hidden" name="memberids" value="">
                    <input type="hidden" name="rid" value="<?php echo ($id); ?>">
                    <a class='sub'>提交订单</a>
                </div>
            </div>
          </form>
    </div>
    <div class="big_mask"></div>
    <div class="common_mask" style="height: 80%;">
        <div class="pyl_top pr ">选择优惠券
            <div class="pyl_close pa">
                <img src="/Public/Web/images/close.jpg">
            </div>
        </div>
        <div class="common_mid" style=" height: 90%;">
            <div class="name_box bianj_child" style="height: 80%;overflow-y: scroll;">
                <?php if(is_array($coupon)): $i = 0; $__LIST__ = $coupon;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="prefer_list" data-title="<?php echo ($vo["title"]); ?>" data-id="<?php echo ($vo["id"]); ?>" data-price="<?php echo ($vo["price"]); ?>">
                        <span><?php echo ($vo["title"]); ?></span>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="snail_d homen_style center f16">
                <a href="javascript:;" class='addCoupon'>确定添加</a>
            </div>
        </div>
    </div>
    <div id="time_choose_box" style="position:fixed;left:0;bottom:0;right:0;z-index:10000;display:none">
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
    <div id="p_detail" style="position:fixed;left:0;right:0;top:0;bottom:0;z-index:1000;display:none">
        <div style="position:absolute;left:0;top:6rem;right:0;bottom:0;background:#000;opacity:0.8;"
        id="mask"></div>
        <div style="position:absolute;left:10px;right:10px;height:5rem;top:6rem;border-bottom:1px solid #fff;"></div>
        <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:11.5rem;"></div>
        <div style="position:absolute;height:2rem;left:0;width:100%;top:13.5rem;">
            <span style="width:30%;margin-left:10px;color:#fff;display:inline-block;text-align:left"
            id="d_start"></span>
            <span style="width:34%;color:#56c3cf;display:inline-block;text-align:center" class="ft14">共<span id="d_day"><?php echo ((isset($days) && ($days !== ""))?($days):'1'); ?></span>天</span>
            <span style="width:30%;color:#fff;display:inline-block;text-align:right" id="d_end"></span>
        </div>
        <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:15.5rem;"></div>
        <div style="position:absolute;left:10px;right:10px;height:4rem;top:18rem;padding-top:1rem;border-top:1px solid #fff;">
            <span style="width:48%;display:inline-block;color:#fff" class="ft16">预定总额</span>
            <span style="width:48%;display:inline-block;color:#ff5f4c;text-align:right;" class="ft16"
            id="dtotal"></span>
        </div>
    </div>
    <div class="big_mask"></div>
    <div class="pyl">
        <div class="pyl_top pr">退订提醒
            <div class="pyl_close pa">
                <img src="/Public/Web/images/close.jpg">
            </div>
        </div>
        <div class="pyl_font" style="height:85%;-webkit-overflow-scrolling:touch;overflow:auto">
            <p style="padding:8px;min-height:78%"><?php echo ($data["bookremark"]); ?></p>
            <div class="snail_d homen_style center f16">
                <a href="javescript:void(0);" id="i_know" class="pyl_close" style="width:100%">我知道了</a>
            </div>
        </div>
    </div>

    <!--弹窗操作 -->
    <div class="fix_box_full_wt" style="display:none" id="edit_partner">
      <div class="fix_box_header theme_back_blue">
          <a class="ft18 cwt" href="javascript:;">修改入住人</a>
      </div>
      <div class="back_light_dark fix_box_body">
        <br>
        <input type="hidden" class="link_man" value="">
        <div class="form-group">
          <input type="text" class="lu_text edit_people_text" placeholder="真实姓名：" id="edit_name">
        </div>
        <div class="form-group">
          <input type="text" class="lu_text edit_people_text" placeholder="手机号码：" id="edit_phone">
        </div>
        <div class="form-group">
          <input type="text" class="lu_text edit_people_text" placeholder="身份证号：" id="edit_idcard">
        </div>
        <div class="form-group">
          <div class="snail_d homen_style center f16 btn-6 btn-inline">
            <a class="btn-gray" href="javascript:;" id="edit_cancel">放弃修改</a>
          </div>
          <div class="snail_d homen_style center f16 btn-6 btn-inline">
            <a href="javascript:;" id="edit_confirm">确定修改</a>
          </div>
        </div>
      </div>
    </div>

    <div class="infor_window">
        <div class="act_c">
            <div class="lu_b">
                <input type="text" class="lu_text add_people_text" placeholder="真实姓名 :" id="add_name">
            </div>

            <div class="lu_b">
                <input type="text" class="lu_text add_people_text" placeholder="手机号码 :" id="add_phone">
            </div>

            <div class="lu_b">
                <input type="text" class="lu_text add_people_text" placeholder="身份证号码 :" id="add_idcard">
            </div>

            <div class="snail_d homen_style center f16">
                <a href="javescript:;" class="com_inforClick">选择常用人信息</a>
            </div>

            <div class="snail_d center trip_btn f16">
                <a href="javascript:;" class="snail_cut jk_click" id="add_people_click">添加</a>
            </div>

        </div>
    </div>


    <div class="common_inforBox">
        <div class="pyl_top pr">常用人信息
            <div class="pyl_close pa">
                <img src="/Public/Web/images/close.jpg">
            </div>
        </div>

        <div class="common_mid">
            <div class="name_box bianj_child" style="height:20rem;overflow-y:scroll;-webkit-overflow-scrolling: touch;">
                <?php if(is_array($linkmen)): $i = 0; $__LIST__ = $linkmen;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$linkman): $mod = ($i % 2 );++$i;?><div class="name_list" id="linkman_<?php echo ($linkman["phone"]); ?>">
                  <div class="name_text"><?php echo ($linkman["realname"]); ?></div>
                  <input type="hidden" class="partners" name="partners" value="<?php echo ($linkman["realname"]); ?>,<?php echo ($linkman["phone"]); ?>,<?php echo ($linkman["idcard"]); ?>">
                  <input type="hidden" name="link_id" value="<?php echo ($linkman["id"]); ?>">
                  <div class="name_a">
                    <input type="button" data-name="<?php echo ($linkman["realname"]); ?>" data-phone="<?php echo ($linkman["phone"]); ?>" data-idcard="<?php echo ($linkman["idcard"]); ?>" class="edit_partner name_btn" value="编辑" data-origin="#linkman_<?php echo ($linkman["phone"]); ?>" data-linkid=<?php echo ($linkman["id"]); ?>>
                    <input type="button" class="remove_partner name_btn" data-origin="#linkman_<?php echo ($linkman["phone"]); ?>" value="删除">
                  </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <!--
            <div class="snail_d homen_href center f16">
                <a href="">添加常用人信息</a>
            </div>
            -->

            <div class="snail_d homen_style center f16">
                <a href="javascript:;" id="add_linkman_to_partner">确定添加</a>
            </div>
        </div>
    </div>

    <script>
        $(function()
        {
            $(".home_inforClick").click(function()
            {
                $(".infor_window,.big_mask").fadeIn()
            })

            $(".com_inforClick").click(function()
            {
              $(".common_inforBox,.big_mask").fadeIn()
              $(".infor_window").hide()
            })

            $(".big_mask").click(function()
            {
                $(".infor_window,.common_inforBox").hide()
            })

            $(".pyl_close").click(function()
            {
                $(".infor_window,.common_inforBox").hide()
            })


            $(".bianj_child .name_list").click(function()
            {
                $(this).addClass("name_cut").siblings().removeClass(
                    "name_cut")
            })
        })
    </script>

    <!-- -->
    <script>
        $(function()
        {
            $(".common_click").click(function()
            {
                $(".big_mask,.common_mask").show()
            })
            $('.prefer_list').click(function()
            {
                $(this).addClass("prefer_cut").siblings().removeClass(
                    "prefer_cut");
                console.log(cdata);
            })
        })
    </script>
    <script type="text/javascript">
        var s, e, day;
        var people = 1;
        var day = 1;
        var money = <?php echo ($data["nomal_money"]); ?>;
        var holidayMoney = <?php echo ($data["holiday_money"]); ?>;
        var weekMoney = <?php echo ($data["week_money"]); ?>;
        var allpeople = <?php echo ($data["mannum"]); ?>;
        $(function()
        {
            $('.begin').change(function()
            {
                // alert($(this).val());
                s = $(this).val();
                difference(s, e);
            })
            $('.end').change(function()
            {
                // alert($(this).val());
                e = $(this).val();
                difference(s, e);
            })

        })
        var totalRooms = 1;
        var totalDurations = 1;

        function difference(s, e)
        {
            if (typeof(s) == 'undefined')
            {
                return;
            }
            if (typeof(e) == 'undefined')
            {
                return;
            }
            console.log(s);
            console.log(e);
            var stime = Date.parse(new Date(s));
            var etime = Date.parse(new Date(e));
            console.log(stime);
            console.log(etime);
            if (stime > etime)
            {
                alert('入住时间必须小于退房时间');
                return;
            }
            else
            {
                var time = etime - stime;
                console.log(time);
                day = parseInt(Math.abs(etime - stime) / 1000 / 60 / 60 /
                    24);
                console.log(day);
                $('#day').text(day);
                $('.day').val(day);
                total();
            }
        }
        $('.add1').click(function()
        {
            var people = $('.reduce').val();
            if ($(this).val() == "+")
            {
                people = Number(people) + 1;
            }
            else
            {
                if (people == 1)
                {
                    alert('不能再小了');
                }
                else
                {
                    people -= 1;
                }
            }
            $('.reduce').val(people);
            total();
        });
        $('.add2').click(function()
        {
            var rooms = $('.reduce_room').val();
            if ($(this).val() == "+")
            {
                rooms = Number(rooms) + 1;
            }
            else
            {
                if (rooms == 1)
                {
                    alert('不能再小了');
                }
                else
                {
                    rooms -= 1;
                }
            }
            $('.reduce_room').val(rooms);
            totalRooms = rooms;
            total();
        });
        $(".addCoupon").click(function()
        {
            var couponsid = $("div.name_box div.prefer_cut").data(
                "id");
            var price = $("div.name_box div.prefer_cut").data("price");
            var couponstitle = $("div.name_box div.prefer_cut").data(
                "title");
            $(".big_mask,.pyl,.common_mask").hide();
            $('.couponstitle').text(couponstitle);

            $("#discount").text(parseFloat(price).toFixed(2));
            $("input[name='couponsid']").val(couponsid);
            $("input[name='discount']").val(parseFloat(price).toFixed(
                2));
            total();
        })

        function total()
        {
            var allmoney = 0;
            var startDate = $('#start_time').val();
            var endDate = $('#leave_time').val();
            var timeArr = dataScope(startDate, endDate);
            var discount = $("input[name='discount']").val();


            $.each(bookItems, function(i, value)
            {
                if (value.name == startDate)
                {
                    allmoney += parseInt(value.price);
                    console.log(value);
                }
                else
                {
                    $.each(timeArr, function(j, dat)
                    {
                        if (value.name == dat)
                        {
                            allmoney += parseInt(value.price);
                        }
                    })
                }
            });
            var days = timeArr.length + 1;
            var rooms = $('#rooms').val();
            allmoney = (allmoney * rooms - discount).toFixed(2);
            $("#total").text(allmoney);
            $('input[name="money"]').val(allmoney);
            return allmoney;
        }
        $('.sub').click(function()
        {
            $('#form').submit();
        })
        var liveDuration = 0;
        var bindType = undefined;
        var bindTarget = undefined;
        $('.time-box').click(chooseTime);

        function rebind()
        {
            if (bindType)
            {
                $('.day').unbind('click');
                $('.day').click(dayClick);
            }
        }

        function chooseTime(evt)
        {
            console.log('choose time bind.');
            $('#time_choose_box').show();
            var _this = $(this);
            bindTarget = _this.data('target');
            bindType = _this.data('type');
            $('.day').unbind('click');
            $('.day').click(dayClick);
        };

        function dayClick()
        {
            var type = bindType;
            var target = bindTarget;
            var _me = $(this);
            var time = _me.data('value');
            var dat = new Date();
            var year = dat.getFullYear();
            var month = dat.getMonth() + 1;
            var da = dat.getDate();
            var todayTime = year + '-' + month + '-' + da;
            var today = Date.parse(year + '-' + month +
                '-' + da) / 1000;

            var newstr = time.replace(/-/g, '/');
            var date = new Date(newstr);
            var time_str = date.getTime().toString();
            var ctimestamp = parseInt(time_str.substr(0,
                10));

            if (ctimestamp < today)
            {
                alert('选择日期不能小于当前日期！');
                return;
            }
            if (type == 'start')
            {
                var leaveTime = $('#leave_time').val();
                var leaveDate = new Date(leaveTime.replace(
                    /-/g, '/'));
                var leave_str = leaveDate.getTime().toString();
                console.log(leave_str);
                var ltimestamp = parseInt(leave_str.substr(
                    0, 10));
                if (ctimestamp >= ltimestamp)
                {
                    alert('入住日期必须小于离店日期！');
                    return;
                }
            }
            else
            {
                var startTime = $('#start_time').val();
                var startDate = new Date(startTime.replace(
                    /-/g, '/'));
                var start_str = startDate.getTime().toString();
                var stimestamp = parseInt(start_str.substr(
                    0, 10));
                if (stimestamp >= ctimestamp)
                {
                    alert('离店日期必须大于入住日期！');
                    return;
                }
            }
            $(target).val(time);
            $(target).siblings().html(time);
            $('#time_choose_box').fadeOut('fast');
            var starttime = $('#start_time').val();
            var endtime = $('#leave_time').val();
            var starttimestamp = $.myTime.DateToUnix(starttime);
            var endtimestamp = $.myTime.DateToUnix(endtime);
            if (endtimestamp > 0 && starttimestamp > 0)
            {
                var durations = (endtimestamp -
                    starttimestamp) / (3600 * 24);
                $('#day').html(durations);
                $('input[name=days]').val(durations);
                totalDurations = durations;
                total();
            }
            bindType = undefined;
            bindTarget = undefined;
        }
        $('#price_detail').click(function(evt)
        {
            evt.preventDefault();
            var target = $('#p_detail');
            target.fadeIn('fast');
            var starttime = $('#start_time').val();
            var endtime = $('#leave_time').val();
            $('#d_start').html(starttime ? starttime + ' 入住' : '未选择');
            $('#d_end').html(endtime ? endtime + ' 离店' : '未选择');
            $('#d_day').html(totalDurations);
            var my = parseInt(total());
            if (!my) my = 0;
            $('#dtotal').html('¥' + my.toFixed(2));
        });
        $('#p_detail').click(function(evt)
        {
            evt.preventDefault();
            $(this).fadeOut('fast');
        });

        function dataScope(value1, value2)
        {
            var getDate = function(str)
            {
                var tempDate = new Date();
                var list = str.split("-");
                tempDate.setFullYear(list[0]);
                tempDate.setMonth(list[1] - 1);
                tempDate.setDate(list[2]);
                return tempDate;
            }
            var date1 = getDate(value1);
            var date2 = getDate(value2);
            if (date1 > date2)
            {
                var tempDate = date1;
                date1 = date2;
                date2 = tempDate;
            }
            date1.setDate(date1.getDate() + 1);
            var dateArr = [];
            var i = 0;
            while (!(date1.getFullYear() == date2.getFullYear() && date1.getMonth() ==
                date2.getMonth() && date1.getDate() == date2
                .getDate()))
            {
                var dayStr = date1.getDate().toString();
                if (dayStr.length == 1)
                {
                    dayStr = "0" + dayStr;
                }
                dateArr[i] = date1.getFullYear() + "-" + (date1.getMonth() +
                    1) + "-" + dayStr;
                i++;

                date1.setDate(date1.getDate() + 1);
            }
            return dateArr;
        }

        function checkForm()
        {
            if (!$('input[name=realname]').val())
            {
                alert('请正确填写真实姓名！');
                return false;
            }
            if (!$('input[name=idcard]').val() || $('input[name=idcard]')
                .val().length != 18)
            {
                alert('请填写18位有效身份证号！');
                return false;
            }
            if (!$('input[name=phone]').val() || $('input[name=phone]').val()
                .length != 11)
            {
                alert('请填写11位有效手机号码！');
                return false;
            }
            window.onbeforeunload = undefined;
            return true;
        }
        $('.del').click(function()
        {
            var self = $(this);
            var data = {
                'id': $(this).data('id')
            };
            $.post("<?php echo U('Web/Member/delcookie');?>", data, function(res)
            {
                self.parent().parent().remove();
            })
            var thisnum = $('.we_people').val();
            $('.we_people').val(--thisnum);
        })
    </script>
    <script>
      /*
       * 添加/删除 入住人/常用人
       */
      (function() {
        /*
         * 弹窗
         */
        var nameArr = [], phoneArr = [], idArr = [];
        var editPartner = $('#edit_partner');

        /*
         * 清空修改表单
         */
        editPartner.clear = function () {
          editPartner.find('input').val('');
        };

        /*
         * 填充修改表单
         */
        editPartner.fill = function(target) {
          editPartner.find('input#edit_name').val(target.data('name'));
          editPartner.find('input#edit_phone').val(target.data('phone'));
          editPartner.find('input#edit_idcard').val(target.data('idcard'));
          editPartner.find('input.link_man').val(target.data('linkid'));
          editPartner.data('origin-name', target.data('name'));
          editPartner.data('origin-phone', target.data('phone'));
          editPartner.data('origin-idcard', target.data('idcard'));
        };

        /*
         * 确认修改入住人
         */
        editPartner.find('#edit_confirm').click(function(evt) {
          evt.preventDefault();
          var linkId = editPartner.find('input.link_man').val();
          var realname = editPartner.find('input#edit_name').val();
          var phone = editPartner.find('input#edit_phone').val();
          var idcard = editPartner.find('input#edit_idcard').val();
          var _this = $(this);
          if(parseInt(editPartner.data('origin-phone')).toString() != parseInt(phone).toString()) {
            //通过比较判定是否修改了手机号，如果修改了，则检验是否会和其他入住人重复
            if($.inArray(phone, phoneArr) >= 0) {
              alert('您已添加相同手机号的联系人，请使用其他手机号！');
              return;
            }
          } else if((editPartner.data('origin-idcard')).toString() != idcard.toString()) {
          //注意：js无法直接比较18位整型数字（可能是由于存储位数的问题），应该换长整型或字符串
          //身份证同手机号
            if($.inArray(idcard, idArr) >= 0) {
              alert('您已经添加相同身份证号的联系人，请使用其他身份证号！');
              return;
            }
          } else if(editPartner.data('origin-name') == realname) {
              editPartner.fadeOut('fast'); 
              editPartner.clear();
              return;
          }
          if(linkId) { //如果该联系人已在数据库保存，更新页面数据的同时要回写.
            _this.attr('disabled', 'disabled');
            _this.html('请稍等...');
            rawPost('<?php echo U("Api/Room/edit_linkman");?>', {
              'uid': <?php echo ($uid); ?>,
              'lmid': linkId,
              'realname': realname,
              'phone': phone,
              'idcard': idcard
            }, function(data) {
              if(data.code != 200) {
                alert(data.msg);
              } else {
                //更新页面常用人的信息
                var originPhone = editPartner.data('origin-phone');
                var originLinkman = $('#linkman_' + originPhone);
                delLinkman(originLinkman, true);
                addLinkman(realname, phone, idcard, linkId);

                /*
                 * 编辑入住人的逻辑就是先删掉原来的，再添加一个新的。
                 */

                //删除已选入住人
                var origin = $(editPartner.data('origin'));
                delPartner(origin, true);

                //添加新的入住人
                addPartner(realname, phone, idcard, linkId);
                editPartner.fadeOut('fast'); 
                editPartner.clear();
              }
              _this.html('确定修改');
              _this.removeAttr('disabled');
            }, function(err, data) {
              alert('网络错误！');
              _this.html('确定修改');
              _this.removeAttr('disabled');
            });
          } else { //新增的联系人仅修改页面信息.
            //删除已选入住人
            var origin = $(editPartner.data('origin'));
            delPartner(origin, true);

            //添加新的入住人
            addPartner(realname, phone, idcard);

            editPartner.fadeOut('fast'); 
            editPartner.clear();
          }
        });
        editPartner.find('#edit_cancel').click(function(evt) {
          evt.preventDefault();
          var con = confirm('您确认放弃编辑？'); 
          if(con) {
            editPartner.fadeOut('fast'); 
            editPartner.clear();
          }
        });
        $('#add_people_click').click(function(evt) {
          evt.preventDefault();
          var realname = $('#add_name').val();
          var phone = $('#add_phone').val();
          var idcard = $('#add_idcard').val();
          if(!realname) {
            alert('请正确输入姓名！'); 
            return;
          }
          if(!phone || phone.length != 11) {
            alert('请正确输入11位手机号！');
            return;
          } else if($.inArray(phone, phoneArr) >= 0) {
            alert('您已添加了使用相同手机号的房客，请勿重复添加！') 
            return;
          }
          if(!idcard || idcard.length != 18) {
            alert('请正确输入18位身份证！');
            return;
          } else if($.inArray(idcard, idArr) >= 0) {
            alert('您已添加了使用相同身份证的房客，请勿重复添加！');
            return;
          }
          addPartner(realname, phone, idcard);
        });

        /*
         * 添加入住人
         */
        function addPartner(realname, phone, idcard) {
          nameArr.push(realname);
          phoneArr.push(phone);
          idArr.push(idcard);
          var linkid = arguments[3] ? arguments[3] : '';
          var newPartner = realname + ',' + phone + ',' + idcard;
          var htm =   '<div class="name_list" id="partner_' + phone + '">' + 
            '<div class="name_text"></div>' + 
            '<div class="name_a">' +
            '<input type="hidden" class="link_id" value="' + linkid + '">' +
            '<input class="partners" type="hidden" name="partners[]">' +
            '<input type="button" data-name="' +realname + '" data-linkId="'+ linkid +'" data-phone="'+ phone +'" data-idcard="' + idcard + '" class="name_btn edit_partner" data-origin="#partner_' + phone + '" value="编辑">' +
            '<input type="button" class="name_btn del_partner" data-origin="#partner_' + phone + '" value="删除">' + 
            '</div>' + 
            '</div>';
          var node = $(htm);
          node.find('.edit_partner').data('idcard', idcard);
          node.find('input.del_partner').click(function(evt) {
            evt.preventDefault();
            delPartner(node);
          });
          node.find('input.edit_partner').click(function(evt) {
            evt.preventDefault();
            editPartner.fill($(this));
            editPartner.fadeIn('fast');
            editPartner.data('origin', $(this).data('origin'));
          });
          node.find('div.name_text').html(realname);
          node.find('input.partners').val(newPartner);
          $('div.we_c').prepend(node);
          $(".infor_window,.common_inforBox,.big_mask").hide()
          $(".add_people_text").val('');
          countPartner();
        }
        /*
         * 删除入住人
         */
        function delPartner(partner) {
          var values = partner.find('input.partners').val().split(',');
          var con = true;
          if(!arguments[1]) {
            var con = confirm('确认删除入住人' + values[0] + '？');
          }
          if(con) {
            nameArr.splice($.inArray(values[0]), 1); 
            phoneArr.splice($.inArray(values[1]), 1);
            idArr.splice($.inArray(values[2]), 1);
            partner.remove();
          }
          countPartner();
        }
        /*
         * 初始化绑定元素
         */
        (function() {
          $('input.edit_partner').click(function(evt) {
            evt.preventDefault(); 
            editPartner.fill($(this));
            editPartner.fadeIn('fast');
            editPartner.data('origin', $(this).data('origin'));
          });
          $('input.remove_partner').click(function(evt) {
            evt.preventDefault();
            delLinkman($($(this).data('origin')));
          });
        })();

        /*
         *将常用联系人添加至入住人
         */
        $('#add_linkman_to_partner').click(function(evt) {
          evt.preventDefault();
          var selected = $('.name_box > .name_cut');
          if(!selected) {
            alert('请选择一个常用人信息！');
            return;
          } else {
            var values = selected.find('input.partners').val().split(',');
            if($.inArray(values[1], phoneArr) >= 0) {
              alert('您已经添加了使用相同手机号的房客，请勿重复添加！') 
              return;
            }
            if($.inArray(values[2], idArr) >= 0) {
              alert('您已经添加了使用相同身份证的房客，请勿重复添加！');
              return;
            }
            var linkid = selected.find('input[name=link_id]').val();
            addPartner(values[0], values[1], values[2], linkid);
          }
        });

        /*
         * 新增常用人页面信息
         * 基本逻辑也是先删后加
         */
        function addLinkman(realname, phone, idcard, linkid) {
          var newPartner = realname + ',' + phone + ',' + idcard;
          var htm =   '<div class="name_list" id="linkman_' + phone + '">' + 
            '<div class="name_text"></div>' + 
            '<input type="hidden" name="link_id" value="' + linkid + '">' +
            '<div class="name_a">' +
            '<input class="partners" type="hidden" name="partners[]">' +
            '<input type="button" data-name="' +realname + '" data-linkId="'+ linkid +'" data-phone="'+ phone +'" data-idcard="' + idcard + '" class="name_btn edit_partner" data-origin="#linkman_' + phone + '" value="编辑">' +
            '<input type="button" class="name_btn del_partner" data-origin="#linkman_' + phone + '" value="删除">' + 
            '</div>' + 
            '</div>';
          var node = $(htm);
          node.find('.edit_partner').data('idcard', idcard);
          node.find('input.remove_partner').click(function(evt) {
            evt.preventDefault();
            delLinkman(node);
          });
          node.find('input.edit_partner').click(function(evt) {
            evt.preventDefault();
            editPartner.fill($(this));
            editPartner.fadeIn('fast');
            editPartner.data('origin', $(this).data('origin'));
          });
          node.find('div.name_text').html(realname);
          node.find('input.partners').val(newPartner);
          $('div.name_box').prepend(node);
          $(".infor_window,.common_inforBox,.big_mask").hide()
          $(".add_people_text").val('');
          countPartner();
        }

        /*
         * 删除常用联系人页面信息
         */
        function delLinkman(origin) {
          origin.remove(); 
          var values = origin.find('input.partners').val().split(',');
          if(!arguments[1]) {
            //实际删除
            var con = confirm('确认删除联系人' + values[0] + '？');
            rawPost("<?php echo U('Api/Room/del_linkman');?>", {
              'lmid': origin.find('input[name=link_id]').val()
            }, function(data) {
              if(data.code == 200) {
                alert('删除成功！');
                origin.remove();
                $('#partner_' + values['phone']).remove();
                countPartner();
              } else {
                alert(data.msg);
              }
            }, function(err, data) {
              console.log(data); 
              alert('网络错误，请检查网络！');
            });
          } else {
            origin.remove();
            $('#partner_' + values['phone']).remove();
            countPartner();
          }
        }

        function countPartner() {
          var num = $('div.we_c').find('.name_list').length;
          $('input[name=people]').val(num + 1);
        }

      })();
    </script>
</body>
</html>