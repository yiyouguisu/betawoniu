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
      我的
      <div class="per_header pa"><a href="<?php echo U('Web/Member/set');?>"><img src="/Public/Web/images/home_v1.jpg"></a><i>&nbsp;</i></div>
      <div class="tra_pr hd_ck home_header home_ck1 pa"><img src="/Public/Web/images/hj_a2.jpg"><span>分享APP</span></div>
</div>
<div class="container" style="margin-top:6rem;">
      <div class="son_top pr f0">
              <div class="son_a vertical">
                <a href="<?php echo U('Web/Member/myinfo');?>">
                  <img  src="<?php echo ($data["head"]); ?>" style="width:60px;height:60px;border-radius:35px;border:3px solid #fff;">
                  <?php if(($data['houseowner_status']) == "1"): ?><img src="/Public/Web/images/houseowner.png" class="houseowner_img"><?php endif; ?>
                </a>
              </div>
              <div class="son_b vertical">
                    <div class="son_b1 f20"><?php echo ($data["nickname"]); ?></div>
                    <div class="son_b2 f14"><em>关注: <?php echo ((isset($follow) && ($follow !== ""))?($follow):"0"); ?></em><span>粉丝: <?php echo ((isset($fans) && ($fans !== ""))?($fans):"0"); ?></span></div>
              </div>
              <div class="set_a pa"><a href="<?php echo U('Web/Member/memberHome',array('id'=>$data['id']));?>">个人主页<img src="/Public/Web/images/set_right.jpg"></a></div>
      </div> 
      
      <div class="set_b">
              <a href="<?php echo U('Web/Note/add');?>"><div class="help_list">
               <div class="help_a"><img src="/Public/Web/images/set_a1.jpg"> 我要发布游记</div>
              </div></a> 
      </div>
      
      <div class="set_b">
            <?php if(($data['houseowner_status']) == "1"): ?><a href="<?php echo U('Wallet/index');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/mer_a1.jpg"> 我的钱包</div>
                </div>
            </a><?php endif; ?>
            <?php if(($data['houseowner_status']) == "1"): ?><a href="<?php echo U('Web/Member/mymerchant');?>"><div class="help_list may_disnone">
                  <div class="help_a"><img src="/Public/Web/images/mer_a2.jpg"> 我发布的美宿</div>
              </div></a>
              
              <a href="<?php echo U('Web/Member/myact');?>"><div class="help_list may_disnone">
                  <div class="help_a"><img src="/Public/Web/images/mer_a3.jpg"> 我发布的活动</div>
              </div></a><?php endif; ?>
            <a href="<?php echo U('Web/Member/mycoupons');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a2.jpg"> 我的优惠券</div>
                </div>
            </a> 
            <a href="<?php echo U('Web/Member/orderlist');?>">
                <div class="help_list">
                    <div class="help_a">
                        <img src="/Public/Web/images/set_a3.jpg"> 我的订单
                        <?php if(($newordernum) > "0"): ?><sup><img src="/Public/Web/images/point.jpg"></sup><span>(<?php echo ((isset($newordernum) && ($newordernum !== ""))?($newordernum):"0"); ?>)</span><?php endif; ?>
                    </div>
                </div>
            </a>

            <a href="<?php echo U('Web/Member/mynote');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a4.jpg"> 我的游记</div>
                </div>
            </a> 

            <a href="<?php echo U('Web/Member/collect');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a5.jpg"> 我的收藏</div>
                </div>
            </a> 
            <a href="<?php echo U('Web/Member/useinfo');?>">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a6.jpg"> 帮助手册</div>
                </div>
            </a> 
            <a href="">
                <div class="help_list">
                    <div class="help_a"><img src="/Public/Web/images/set_a7.jpg"> 邀请好友注册</div>
                </div>
            </a> 
      </div>
      <?php if(($data['houseowner_status']) == "0"): ?><div class="set_c">
          <div class="snail_d center trip_btn f16">
            <?php if(($data['realname_status']) == "0"): ?><a href="<?php echo U('Web/Member/realname');?>" class="snail_cut ">
            <?php else: ?>
              <a href="<?php echo U('Web/Member/apply_hotel_owner');?>" class="snail_cut"><?php endif; ?>
              我要成为美宿主人
            </a>
          </div>
        </div><?php endif; ?>
      
      <div style="height:4rem"></div>

</div>

<div class="footer">
    <ul>
        <?php if(empty($INDEXCTRL)): ?><li>
        <?php else: ?>
          <li class="foot_cut"><?php endif; ?>
            <a href="/index.php/Web/">
                <div class="foot_a">
                  <?php if(empty($INDEXCTRL)): ?><img src="/Public/Web/images/foot_a1.png">
                  <?php else: ?>
                    <img src="/Public/Web/images/foot_b1.png"><?php endif; ?>
                </div>
                <div class="foot_b">首页</div>
            </a>
        </li>
        <?php if(empty($WONIUCTRL)): ?><li>
        <?php else: ?>
          <li class="foot_cut"><?php endif; ?>
            <a href="<?php echo U('Web/Woniu/index');?>">
                <div class="foot_a">
                  <?php if(empty($WONIUCTRL)): ?><img src="/Public/Web/images/foot_a2.png">
                  <?php else: ?>
                    <img src="/Public/Web/images/foot_b2.png"><?php endif; ?>
                </div>
                <div class="foot_b">蜗牛</div>
            </a>
        </li>

        <?php if(empty($TRIPCTRL)): ?><li>
        <?php else: ?>
          <li class="foot_cut"><?php endif; ?>
            <a href="<?php echo U('Web/Trip/myTrips');?>">
                <div class="foot_a">
                    <?php if(empty($TRIPCTRL)): ?><img src="/Public/Web/images/foot_a3.png"></div>
                    <?php else: ?>
                      <img src="/Public/Web/images/foot_b3.png"></div><?php endif; ?>
                <div class="foot_b">行程</div>
            </a>
        </li>
        <?php if(empty($MYCTRL)): ?><li>
        <?php else: ?>
          <li class="foot_cut"><?php endif; ?>
            <a href="<?php echo U('Web/Member/index');?>">
                <div class="foot_a">
                  <?php if(empty($MYCTRL)): ?><img src="/Public/Web/images/foot_a4.png"></div>
                  <?php else: ?>
                    <img src="/Public/Web/images/foot_b4.png"></div><?php endif; ?>
                <div class="foot_b">我的</div>
            </a>
        </li>
    </ul>
</div>
<div class="mask"></div>
<div class="fish_btm hide">
    <div class="fish_t center">
        <div class="fish_t1">
            <span></span>
            <img src="/Public/Web/images/drop.jpg"></div>
    </div>
    <div class="fish_y">
        <ul>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="/Public/Web/images/hm_a1.jpg"></a></div>
                <div class="fish_y2">微信</div>
            </li>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="/Public/Web/images/hm_a2.jpg"></a></div>
                <div class="fish_y2 fish_y3">微博</div>
            </li>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="/Public/Web/images/hm_a3.jpg"></a></div>
                <div class="fish_y2 fish_y4">QQ</div>
            </li>
        </ul>
    </div>
</div>
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

</html>