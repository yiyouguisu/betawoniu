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

<div class="header center pr f18 fix-head">蜗牛客
  <div class="address f14 pa">
    <a href="<?php echo U('Public/search');?>"><?php echo ((isset($city['name']) && ($city['name'] !== ""))?($city['name']):'城市'); ?><img src="/Public/Web/images/address.png"></a>
  </div>
</div>
<div class="container" style="margin-top:6rem">
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>
                <?php if(is_array($ad)): $i = 0; $__LIST__ = $ad;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                      <?php if($vo["hid"] > 0): ?><a class="pic" href="<?php echo U('Hostel/show');?>?id=<?php echo ($vo["hid"]); ?>">
                      <?php elseif($vo["nid"] > 0): ?>
                        <a class="pic" href="<?php echo U('Note/show');?>?id=<?php echo ($vo["nid"]); ?>">
                      <?php elseif($vo["aid"] > 0): ?>
                        <a class="pic" href="<?php echo U('Party/show');?>?id=<?php echo ($vo["aid"]); ?>">
                      <?php else: ?>
                        <a class="pic" href="<?php echo ($vo["url"]); ?>"><?php endif; ?>
                        <img src="<?php echo ($vo["image"]); ?>" style="height:200px;width:100%">
                      </a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div class="hd">
            <ul></ul>
        </div>
    </div>
    <div class="land_c">
        <div class="search_box" id="search_box" data-url="<?php echo U('Public/search_project');?>">
            <input type="text" class="search_text" placeholder="输入目的地、景点、美宿等关键词...">
            <input type="button" class="search_btn">
        </div>
        <!-- <button class='btn'>test</button> -->
        <div class="nav center">
            <a href="<?php echo U('Web/Note/index');?>">
                <img src="/Public/Web/images/tb_a1.png">
                游记</a>
            <a href="<?php echo U('Web/Hostel/index');?>">
                <img src="/Public/Web/images/tb_a3.png">
                美宿</a>
            <a href="<?php echo U('Web/Party/index');?>">
                <img src="/Public/Web/images/tb_a2.png">
                活动</a>
        </div>
    </div>
    <div class="recom  recom_ppt">
        <div class="recom_title f18 center">推荐游记</div>
        <?php if(is_array($data['note'])): $i = 0; $__LIST__ = $data['note'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
            <div class="recom_a pr">
              <a href="<?php echo U('Web/Note/show',array('id'=>$vo['id']));?>">
                   <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Web/images/default.jpg" style="width: 100%;height: 60vw;">
              </a>
              <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>"><div class="recom_d pa"><img src="<?php echo ($vo["head"]); ?>"></div></a>
            </div>
            <div class="recom_b pa"><?php if(($vo['type']) == "1"): ?><img src="/Public/Web/images/recom_a1.png"><?php endif; ?></div>
            <div class="recom_c pa"><div class="recom_gg notecollect <?php if($vo["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>" data-id="<?php echo ($vo["id"]); ?>"></div></div>
            <div class="recom_e">
              <div class="land_f1 recom_e1 f16"><?php echo ($vo["title"]); ?></div>
              <div class="recom_f">
                <div class="recom_f1 f12 fl"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
                <div class="recom_f2 fr">
                  <div class="land_h recom_f3 vertical">
                    <div class="land_h2 f12 vertical notehit" data-id="<?php echo ($vo["id"]); ?>">
                      <?php if($vo["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png">
                      <?php else: ?>
                        <img src="/Public/Web/images/poin.png"><?php endif; ?>
                      <span class="vcount"><?php echo ((isset($vo["hit"]) && ($vo["hit"] !== ""))?($vo["hit"]):"0"); ?></span>
                    </div>
                    <div class="land_h1 f12 vertical">
                      <img src="/Public/Web/images/land_d3.png">
                      <span><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></span>条评论 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>


    <div class="recom">
        <div class="recom_title f18 center" style="color: #ff715f">推荐美宿</div>
        <?php if(is_array($data['house'])): $i = 0; $__LIST__ = $data['house'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
                         <div class="recom_a pr">
                              <a href="<?php echo U('Web/Hostel/show',array('id'=>$vo['id']));?>"><img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Web/images/default.jpg" style="width: 100%;height: 60vw"></a>
                               <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>">
                                  <div class="recom_d pa"><img src="<?php echo ($vo["head"]); ?>"></div>
                               </a>
                               <div class="recom_g f18 center pa">
                                   <div class="recom_g1 fl"><em>￥</em><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.00"); ?><span>起</span></div>
                                   <div class="recom_g2 fl"><?php echo ((isset($co["evaluation"]) && ($co["evaluation"] !== ""))?($co["evaluation"]):"10.0"); ?><span>分</span></div>
                               </div>
                         </div>
                         <div class="recom_c pa"><div class="recom_gg hostelcollect <?php if($vo["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>" data-id="<?php echo ($vo["id"]); ?>"></div></div>
                        <div class="recom_e">
                               <div class="land_f1 recom_e1 f16"><?php echo ($vo["title"]); ?></div>
                               <div class="recom_f">
                                <div class="recom_f1 recom_hong f12 fl">
                                  <img src="/Public/Web/images/add_e.png">距你<span class="distance" data-lat="<?php echo ($vo["lng"]); ?>" data-lng="<?php echo ($vo["lat"]); ?>">0.00</span>公里
                                </div>
                                    <div class="recom_f2 fr">
                                        <div class="land_h recom_f3 vertical">
                                              <div class="land_h2 f12 vertical hostelhit" data-id="<?php echo ($vo["id"]); ?>">
                                                <?php if($vo["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png">
                                                <?php else: ?>
                                                  <img src="/Public/Web/images/poin.png"><?php endif; ?>
                                                <span class="vcount"><?php echo ((isset($vo["hit"]) && ($vo["hit"] !== ""))?($vo["hit"]):"0"); ?></span>
                                              </div>
                                              <div class="land_h1 f12 vertical">
                                                    <img src="/Public/Web/images/land_d3.png">
                                                    <span><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></span>条评论
                                              </div>
                                          </div>
                                    </div>
                               </div>
                        </div>
                    </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="recom">
        <div class="recom_title f18 center" style="color: #56c3cf">推荐活动</div>
        <?php if(is_array($data['party'])): $i = 0; $__LIST__ = $data['party'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
                     <div class="recom_a pr">
                           <a href="<?php echo U('Web/Party/show',array('id'=>$vo['id']));?>"><img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Web/images/default.jpg" style="width: 100%;height: 60vw"></a>
                           <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>"><div class="recom_d pa"><img src="<?php echo ($vo["head"]); ?>"></div></a>
                     </div>
                     <div class="recom_c pa"><div class="recom_gg partycollect <?php if($vo["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>" data-id="<?php echo ($vo["id"]); ?>"></div></div>
             
                    <div class="recom_e">
                           <div class="land_f1 recom_e1 f16"><?php echo ($vo["title"]); ?></div>
                           <div class="recom_k">
                                    <div class="land_font">
                                        <span>时间:</span> <?php echo (date('Y-m-d',$vo["starttime"])); ?> 至<?php echo (date('Y-m-d',$vo["endtime"])); ?>       
                                    </div> 
                                    <div class="land_font">
                                        <span>地点:</span> <?php echo getarea($vo['area']); echo ($vo["address"]); ?>        
                                    </div> 
                          </div>
                          <div class="recom_s f14">
                              已参与：
                              <span>
                                <?php if(is_array($vo["joinlist"])): $i = 0; $__LIST__ = $vo["joinlist"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><img src="<?php echo ($v["head"]); ?>"><?php endforeach; endif; else: echo "" ;endif; ?>
                              </span>
                              <em>(..<?php echo ((isset($vo["joinnum"]) && ($vo["joinnum"] !== ""))?($vo["joinnum"]):'0'); ?>人)</em>
                          </div>
                    </div>
                </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div style="height: 8rem"></div>

</div>
<script type="text/javascript">
    TouchSlide({
        slideCell: "#slideBox",
        titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell: ".bd ul",
        effect: "leftLoop",
        autoPage: true,//自动分页
        autoPlay: true //自动播放
    });
</script>
<script>
    $(function () {
        $(".notehit").click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var nid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Note/ajax_hit');?>",
                data: { 'nid': nid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.notecollect').click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var nid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Note/ajax_collect');?>",
                data: { 'nid': nid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
        $(".partyhit").click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var aid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Party/ajax_hit');?>",
                data: { 'aid': aid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.partycollect').click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var aid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Party/ajax_collect');?>",
                data: { 'aid': aid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
        $(".hostelhit").click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var hid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Hostel/ajax_hit');?>",
                data: { 'hid': hid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.hostelcollect').click(function () {
            var obj = $(this);
            var uid = '<?php echo ($user["id"]); ?>';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "/index.php/web";
                $.post("<?php echo U('Web/Public/ajax_cacheurl');?>", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "<?php echo U('Web/Member/login');?>";
                    }
                })
                return false;
            }
            var hid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Web/Hostel/ajax_collect');?>",
                data: { 'hid': hid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
    });
</script>
<script>
  $('#search_box').click(function(evt) {
    evt.preventDefault();
    var url = $(this).data('url');
    window.location.href = url;
  
  });
</script>
<script>
  function getHotelDistance(lat, lng) {
    $('.distance').each(function(i, t) {
      var _this = $(t);
      var dest_lat = _this.data('lng');
      var dest_lng = _this.data('lat');
      $.ajax({
        'url': '<?php echo U("Api/Map/get_distance_for_web");?>?o_lat=' + lat + '&o_lng=' + lng + '&d_lat=' + dest_lat + '&d_lng=' + dest_lng,
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
  };
</script>
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