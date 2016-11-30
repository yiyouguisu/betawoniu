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
</head>
<body style="min-height:100%">

<div>
    </div>
    <div class="header center pr f18">
      搜索
      <div class="head_go pa">
          <a href="javascript:history.go(-1);">
              <img src="/Public/Web/images/go.jpg">
          </a>
      </div>
    </div>
    <div class="container">
        <div class="land_c">
            <div class="search_box fich_box" style="margin:0 0 1.5rem" id="search_box">
                <input type="text" class="search_text" placeholder="搜索游记／活动／美宿" id="keyword">
                <input type="button" class="search_btn" id="go_search">
            </div>
            <div id="search_result" style="display:none">
              <div class="search_a center search_b f16">
                  搜索结果
              </div>
              <div class="search_c f18" id="note_box">
                <div class="search_c_title">游记 :</div>
                <div id="note_list">
                </div>
              </div>
              <div class="search_c f18" id="house_box">
                <div class="search_c_title">美宿 :</div>
                <div id="hotel_list">
                </div>
              </div>
              <div class="search_c f18" id="party_box">
                <div class="search_c_title">活动 :</div>
                <div id="party_list">
                </div>
              </div>
            </div>
            <div id="search_history">
              <div class="search_a center search_b f12" style="padding:5px 0">
                  搜索历史
              </div>
              <ul id="search_history_list">
                <li>
                  <a class="fr" href="javascript:cleanStorage();" style="color:#666;display:block;background:#efefef;padding:5px;border-radius:5px;margin:5px;">清除历史数据</a>
                  <div style="clear:both"></div>
                </li>
              <ul>                   
            </div>
        </div>
    </div>
</body>
<script>
  var lStorage = window.localStorage;
  var uid = '<?php echo ($uid); ?>';
  $('#keyword').focus(function() {
    $('#search_result').hide();
    $('#search_history').fadeIn('fast');
    searchList();
  })
  $('#go_search').click(function(evt) {
    evt.preventDefault(); 
    var keyword = $('#keyword').val();
    saveStorage(keyword);
    $('#search_history').hide();
    $('#search_result').fadeIn('fast');
    $.ajax({
      'url': '<?php echo U("Api/Query/search");?>',
      'data': JSON.stringify({
        'keyword': keyword
      }),
      'dataType': 'json',
      'type': 'post',
      'contentType': 'text/xml',
      'processData': false,
      'success': function(data) {
        if(data.code == 200) {
          console.log(data.data);
          makeSearchList(data.data); 
        }
      },
      'error': function(err, data) {
        console.log(err); 
      }
    });
  });
  function makeSearchList(data) {
    var hotels = '';
    var notes = '';
    var parties = '';
    $.each(data.house, function(i, value) {
      hotels += '<a href="<?php echo U("Hostel/show");?>?id=' + value.id + '" style="padding:3px;display:block">' +
        '<div class="land_d pr f0">' +
        '<div class="land_e vertical">' +
        '<img src="' + value.thumb + '" style="width:100px;height:80px;">' +
        '</div>' +
        '<div class="land_f vertical" style="width:64%">' +
        '<div class="land_f1 f16">' + value.title +'</div>' +
        '<div class="land_f2 f13">' +
        '<div class="land_money"><span>￥</span>' + value.money + '<span>起</span>' +
        '</div>' +
        '</div>' +
        '<div class="land_f3 pa f0">' +
        '<div class="land_f4 vertical">' +
        '<img src="' + value.head + '" style="width:30px;height:30px;">' +
        '</div>' +
        '<div class="land_h tra_wc vertical">' +
        '<div class="land_h1 f11 vertical">' +
        '<img src="/Public/Web/images/land_d3.png">' +
        '<span>' + value.reviewnum + '</span>条评论' +
        '</div>' +
        '<div class="land_h2 f11 vertical">' +
        '<img src="/Public/Web/images/land_d4.png">&nbsp;' +
        '<span>' + value.hit + '</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</a>';
    });
    $('#hotel_list').html('');
    $('#hotel_list').append(hotels);
    $.each(data.note, function(i, value) {
      notes += '<a href="<?php echo U("Note/show");?>?id=' + value.id + '" style="display:block">' +
      '<div class="land_d pr f0">' +
      '<div class="land_e vertical">' +
      '<img src="' + value.thumb + '" style="width:100px;height:80px;">' +
      '</div>' +
      '<div class="land_f vertical" style="width:64%">' +
      '<div class="land_f1 f16">' + value.title + '</div>' +
      '<div class="interv_font" style="height:1.5rem"><p class="over_ellipsis">' + value.description + '</p></div>' +
      '<div class="land_f2 f13">2015-5-6</div>' + 
      '<div class="land_f3 pa f0">' +
      '<div class="land_f4 vertical">' +
      '<img src="' + value.head + '" style="width:30px;height:30px;">' + 
      '</div>' + 
      '<div class="land_h tra_wc vertical">' +
      '<div class="land_h1 f11 vertical">' +
      '<img src="/Public/Web/images/land_d3.png">' +
      '<span>' + value.reviewnum + '</span>条评论' +
      '</div>' +
      '<div class="land_h2 f11 vertical">' +
      '<img src="/Public/Web/images/land_d4.png">&nbsp;' +
      '<span>' + value.hit + '</span>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</a>';
    });
    $('#note_list').html('');
    $('#note_list').append(notes);
    $.each(data.party, function(i, value) {
      parties += '<a href="<?php echo U("party/show");?>?id=' + value.id + '">' +
      '<div class="land_d pr f0">' +
      '<div class="land_e vertical">' +
      '<img src="' + value.thumb + '" style="width:100px;height:80px">' +
      '</div>' +
      '<div class="land_f vertical">' +
      '<div class="land_f1 f16" style="margin-bottom:2rem">' + value.title + '</div>' +
      '<br>' +
      '<div style="color:#666;font-size:12px;">时间：' + $.myTime.UnixToDate(value.starttime) + '至' + $.myTime.UnixToDate(value.endtime)+ '</div>' +
      '<div style="color:#666;font-size:12px;">地点：' + value.address + '</div>' +
      '</div>' +
      '</div>' +
      '</a>';
    });
    $('#party_list').html('');
    $('#party_list').append(parties);
  }
  function saveStorage(keyword) {
    var arr;
    if(!lStorage.keywords) {
      arr = []; 
    } else {
      arr = JSON.parse(lStorage.keywords);
    }
    var index;
    if((index = $.inArray(keyword, arr)) >= 0) {
      arr.splice(index, 1); 
    }
    arr.push(keyword);
    lStorage.keywords = JSON.stringify(arr);
  }
  function readStorage() {
    if(!lStorage.keywords) return [];
    return JSON.parse(lStorage.keywords);
  }
  function cleanStorage() {
    if(lStorage.keywords)
      lStorage.clean('keywords');
  }
  window.onload = searchList();
  function searchList() {
    var keywords = undefined;
    var list = '';
    keywords = readStorage();
    $('#search_history_list').html('');
    $.each(keywords, function(i, keyword) {
      list = '<li style="padding:5px;font-size:14px;color:#666">' + keyword + '</li>';
      $('#search_history_list').prepend(list);
    });
    $('#search_history_list > li').click(function(evt) {
      evt.preventDefault();
      var keyword = $(this).html();
      $('#keyword').val(keyword);
      $('#go_search').click();
    })
  };
</script>
</html>