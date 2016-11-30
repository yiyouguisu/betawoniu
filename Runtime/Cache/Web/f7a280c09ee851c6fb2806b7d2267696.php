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
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=7XTgXXqefgTIH3cwTLsbnR7P&s=1"></script>
    <div class="header center z-index112 pr f18 fix-head">
        活动详细
        <div class="head_go pa">
            <a href="<?php echo U('party/index');?>">
                <img src="/Public/Web/images/go.jpg">
            </a><span>&nbsp;</span>
        </div>
        <div class="tra_pr hd_ck pa"><em>&nbsp;</em><em><img src="/Public/Web/images/hj_a2.jpg"></em>
        </div>
    </div>
    <div class="container padding_0" style="margin-top:6rem">
        <div class="land">
            <div class="act_g pr">
                <div class="act_g1">
                    <img src="<?php echo ($data["thumb"]); ?>" style="width: 100%;height: 60vw;">
                </div>
                <div class="recom_c pa">
                    <div class="recom_gg collect <?php if($data["iscollect"] == 1): ?>recom_c_cut<?php endif; ?> "></div>
                    <span><a href-""><img src="/Public/Web/images/recom_a3.png"></a></span>
                </div>
                <div class="act_g2 f16 center pa">
                    报名费：<em>￥</em><span><?php echo ((isset($data["money"]) && ($data["money"] !== ""))?($data["money"]):"0.00"); ?></span>
                </div>
            </div>

            <div class="det_box">
                <div class="act_k">
                    <div class="act_k1 vertical"><?php echo ($data["title"]); ?></div>
                    <div class="act_k2 vertical" id="go_zan">
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
                            <img src="/Public/Web/images/add_e.png">距你 <?php echo ($data["distance"]["distance"]["text"]); ?>
                        </div>
                    </div>

                    <div id="map_container" style="height:150px;margin:10px;"></div>
                    <div class="recom_s f14">
                        已参与：
                        <span>
                                      <?php if(is_array($data["joinlist"])): $i = 0; $__LIST__ = $data["joinlist"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$svo): $mod = ($i % 2 );++$i;?><img src="<?php echo ($svo["head"]); ?>" style="width:40px;height:40px;"><?php endforeach; endif; else: echo "" ;endif; ?>
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
                    <div class="land_a1" style="width:auto">
                        <a href="<?php echo U('member/memberHome');?>?id=<?php echo ($data["uid"]); ?>" style="display:block">
                            <img src="<?php echo ($data["head"]); ?>" style="width:80px;height:80px;">
                        </a>
                    </div>
                    <div class="land_a2 home_d1 margin_05 f16"><?php echo ($data["nickname"]); ?></div>
                    <div class="home_d2 margin_05">
                        <div class="home_d3 vertical mr_4">
                            <img src="/Public/Web/images/home_a1.png">实名认证</div>
                    </div>
                </div>
                <div class="vb_d1">
                    <a href="">
                        <img src="/Public/Web/images/vb_a.jpg">在线咨询</a>
                </div>
            </div>

            <div class="lpl_conments">
                <div class="trip_f">
                    <div class="trip_f1">评论区
                        <div class="trip_f2">
                            <a href="<?php echo U('Party/allComment');?>?id=<?php echo ($data["id"]); ?>" class="ft12" style="color:#56c3cf">
                                <img src="/Public/Web/images/land_d3.png">
                                <span><?php echo ($data["reviewnum"]); ?></span>条评论
                            </a>
                        </div>
                    </div>
                    <div class="trip_fBtm" id="comment_list">
                        <?php if(is_array($data['reviewlist'])): $i = 0; $__LIST__ = $data['reviewlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="fans_list" style="padding:8px 0">
                                <div class="per_tx fl">
                                    <img src="<?php echo ($vo["head"]); ?>" style="width:40px;height:40px;border-radius:50%">
                                </div>
                                <div class="fans_b per_tr fl">
                                    <div class="fans_b1 f16" style="margin-top:0"><?php echo ($vo["nickname"]); ?></div>
                                    <div class="fans_b2 f14"><?php echo ($vo["content"]); ?></div>
                                    <div class="fans_time f13"><?php echo (date('Y-m-d',$vo["inputtime"])); ?></div>
                                </div>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="trip_t">
                        <input type="text" id="mycomment" placeholder="发布我的评论 ..." class="trip_text fl">
                        <input type="button" value="10+评论" class="trip_button fr" id="deliver_comment">
                    </div>
                </div>
            </div>

            <div class="mth pr" id="slide-hotel">
                <div class="mth_top pa">附近美宿推荐</div>
                <div id="dom-effect" class="iSlider-effect"></div>
                <div class="mth_a center">
                    <span><a href="">查看更多</a></span>
                    <div class="mth_a2"></div>
                </div>
            </div>

            <div class="mth pr"  id="slide-activity">
                <div class="mth_top pa">附近活动推荐</div>
                <div id="mth-dom" class="iSlider-effect"></div>
                <div class="mth_a center">
                    <span><a href="">查看更多</a></span>
                    <div class="mth_a2"></div>
                </div>
            </div>
            <div style="height:2rem"></div>
            <div class="snail_d center trip_btn f16" style="margin:2rem 0 0;border-radius:0;">
                <?php if(!empty($expire)): ?><a href="javascript:void(0);" class="" style="border-radius:0">活动已结束</a>
                    <?php else: ?>
                    <?php if(!empty($joined)): ?><a href="javascript:void(0);" class="" style="border-radius:0">您已报名</a>
                        <?php else: ?>
                        <?php if(!empty($full)): ?><a href="javascript:void(0);" class="" style="border-radius:0">报名人数已满</a>
                            <?php else: ?>
                            <a href="<?php echo U('Web/Order/joinparty',array('id'=>$id));?>" style="border-radius:0" id="go_join" class="snail_cut">我要报名</a><?php endif; endif; endif; ?>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function()
        {
            // 收藏
            $('.collect').click(function()
            {
                var id = {
                    $id
                };
                var data = {
                    'type': 1,
                    'id': id
                };
                console.log(data);
                $.post("<?php echo U('Web/Ajaxapi/collection');?>", data,
                    function(res)
                    {
                        if (res.code == 200)
                        {
                            $('.collect').addClass(
                                'recom_c_cut');
                        }
                        else if (res.code == 300)
                        {
                            $('.collect').removeClass(
                                'recom_c_cut');
                        }
                        else
                        {
                            alert(res.msg);
                        }
                    });
            });
            // 点赞 vertical
            $('#go_zan').click(function()
            {
                var id = {
                    $id
                };
                var data = {
                    'type': 1,
                    'id': id
                };
                $.post("<?php echo U('Web/Ajaxapi/hit');?>", data,
                    function(res)
                    {
                        console.log(res);
                        if (res.code == 200)
                        {
                            var hit = $('#vcount').text();
                            $('#vcount').text(Number(hit) +
                                    1) // $('.collect').addClass('recom_c_cut');
                            $('.vertical').find('img').attr(
                                'src',
                                '/Public/Web/images/poin_1.png');
                        }
                        else if (res.code == 300)
                        {
                            var hit = $('#vcount').text();
                            $('#vcount').text(Number(hit) -
                                    1) // $('.collect').addClass('recom_c_cut');
                            $('.vertical').find('img').attr(
                                'src',
                                '/Public/Web/images/poin.png');
                        }
                        else
                        {
                            alert(res.msg);
                        }
                    });
            })
        })
         $('#deliver_comment').click(function(evt)
        {
            evt.preventDefault();
            var comment = $('#mycomment').val();
            if (!comment || comment.length < 10)
            {
                alert('评论字数不能少于10个。');
                return;
            }
            $.ajax(
            {
                'url': '<?php echo U("Api/Activity/review");?>',
                'data': JSON.stringify(
                {
                    'uid': '<?php echo ($member["id"]); ?>',
                    'aid': '<?php echo ($data["id"]); ?>',
                    'content': comment
                }),
                'dataType': 'json',
                'type': 'post',
                'processData': false,
                'contentType': 'text/xml',
                'success': function(data)
                {
                    if (data.code == 200)
                    {
                        var timestamp = Date.parse(new Date());
                        var html =
                            '<div class="fans_list">' +
                            '<div class="per_tx fl"><img src="<?php echo ($member["head"]); ?>"></div>' +
                            '<div class="fans_b per_tr fl">' +
                            '<div class="fans_b1 f16"><?php echo ($member["nickname"]); ?></div>' +
                            '<div class="fans_b2 f14">' +
                            comment + '</div>' +
                            '<div class="fans_time f13"></div>' +
                            '</div>' +
                            '</div>';
                        $('#comment_list').prepend(html);
                        var comments = $('#comment_list')
                            .children();
                        $('#mycomment').val('');
                        if (comments.length > 5)
                        {
                            $(comments[comments.length -
                                1]).remove();
                        }
                    }
                    else
                    {
                        alert('评论失败！');
                    }
                },
                'error': function(err, data)
                {
                    alert('网络错误！');
                }
            });

        });
    </script>
    <script>
        var map = new BMap.Map("map_container"); // 创建地图实例  
        var point = new BMap.Point(<?php echo ($data["lng"]); ?>, <?php echo ($data["lat"]); ?>); // 创建点坐标  
        map.centerAndZoom(point, 15);
        var marker = new BMap.Marker(point); // 创建标注    
        map.addOverlay(marker);
    </script> 
    <script src="/Public/Web/js/islider.js"></script>
    <script src="/Public/Web/js/islider_desktop.js"></script>
    <script>
        $.ajax({
          'url': '<?php echo U("Api/Activity/get_activity_nearhostel");?>',
          'data': JSON.stringify({
            'p': 1,
            'num': 10,
            'aid': '<?php echo ($data["id"]); ?>'
          }),
          'dataType': 'json',
          'type': 'post',
          'processData': false,
          'contentType': 'text/xml',
          'success': function(data) {
            if(data.code == 200) {
              if(data.data.num == 0) {
                $('#slide-hotel').hide();
              } else {
                var domList = makeList(data.data); 
                var islider4 = new iSlider({
                    data: domList,
                    dom: document.getElementById("dom-effect"),
                    type: 'dom',
                    animateType: 'depth',
                    isAutoplay: false,
                    isLooping: true,
                });
                islider4.bindMouse();
              }
            } else {
            }
          },
          'error': function(err, data) {
            console.log(err); 
          }
        });
        $.ajax({
          'url': '<?php echo U("Api/Activity/get_activity_nearactivity");?>',
          'data': JSON.stringify({
            'p': 1,
            'num': 10,
            'aid': '<?php echo ($data["id"]); ?>'
          }),
          'dataType': 'json',
          'type': 'post',
          'processData': false,
          'contentType': 'text/xml',
          'success': function(data) {
            if(data.code == 200) {
              var domList = makeList(data.data); 
              var islider4 = new iSlider({
                  data: domList,
                  dom: document.getElementById("mth-dom"),
                  type: 'dom',
                  animateType: 'depth',
                  isAutoplay: false,
                  isLooping: true,
              });
              islider4.bindMouse();
            } else {
              $('#slide-activity').hide();
            }
          },
          'error': function(err, data) {
            console.log(err); 
          }
        });

        function makeList(data) {
          var domList = [];
          for(var i = 0; i < data.length; i++) {
            var item = data[i];
            var html='';
            html+='<div class="recom_list"><div class="recom_a pr"><img src="' + item.thumb + '" style=""></div><div class="recom_e">';
            html+='<div class="land_f1 recom_e1 f16" style="line-height:normal">' + item.title + '</div>';
            html+='<div class="recom_k">';
            html+='<div class="land_font"><span>时间:</span>' + $.myTime.UnixToDate(item.starttime) + '至' + $.myTime.UnixToDate(item.endtime) + '</div>';
            html+=' <div class="land_font"><span>地点:</span>' + item.address + '</div>';
            html+='</div></div></div>';
            var obj = {
              'height': '100%',
              'width': '100%',
              'content': html
            };
            domList.push(obj);
          }
          return domList;
        }
        $('#go_join').click(function(evt) {
          evt.preventDefault();
          var is_owner = '<?php echo ($is_owner); ?>';
          if(is_owner) {
            alert('不能报名参加自己的活动！');  
          } else {
            var href = $(this).attr('href');
            window.location.href = href;
          }
        });
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