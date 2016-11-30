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
<div class="container">
   <div class="land">
     <div class="land_btm">  
       <div class="f14" id="DataList" style="top:0">
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
          console.log(data);
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
     $(".moch_click li").click(function(){
        $(this).addClass("hm_cut").siblings().removeClass("hm_cut")
     })
     // 加个选择后ajax
     $('.pricesub').click(function(){
       $.post("<?php echo U('Web/Hostel/select');?>",data,function(res){
         addHtml(res);
         collect();
         hit();
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
     $('.support').click(function(){
         if(a.length==0){
           a.push($(this).data('id'));
         }
         else{
           if(a.indexOf($(this).data('id'))!=-1){
             console.log('del');
             a.remove(a.indexOf($(this).data('id')));
           }
           else{
             console.log('add');
             a.push($(this).data('id'));
           }
         }
         console.log(a);
         supportArray = a.join(",");
         data['support']=supportArray;
         ajax_send(data);
     });
     // 类型
     $('.hosteltype').click(function(){
       console.log(data);
       data['type']=$(this).data('id');
       console.log(data)
       ajax_send(data);
     })
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
     /*
      $.post("<?php echo U('Web/Hostel/select');?>",data,function(res){
        addHtml(res);
        collect();
        hit();
      })
     */
     loaded();
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

    document.addEventListener('touchmove', function (e) {
        e.preventDefault();
    }, false);
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
        /*
        p['month'] = ($(".month li.tra_dropCut").length > 0) ? $(".month li.tra_dropCut").data('id') : 0;
        p['type'] = ($(".order li.tra_dropCut").length > 0) ? $(".order li.tra_dropCut").data('id') : 0;
        p['notetype'] = ($(".notetype li.tra_dropCut").length > 0) ? $(".notetype li.tra_dropCut").data('id') : 0;
        p['province'] = $("#area").val();
        */
        p['city'] = "<?php echo ((isset($city) && ($city !== ""))?($city):'213'); ?>";
        p['pointed'] = 1;
        /*
        p['town'] = $('#county').val();
        var options = arguments[0] ? arguments[0] : undefined;
        if(options) {
          $.each(options, function(k, v) {
            p[k] = v; 
          });
        }
        */
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
                            loaded();
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
  window.location.href='<?php echo U('Web/Public/search_project');?>';
});
$('#submit_area').click(function(evt) {
  evt.preventDefault();
  $('#thelist').html('');
  loaded(); 
  $('.mask').hide();
  $('.sarea').fadeOut('fast');
});
function getHotelDistance(lat, lng) {
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
</body>
</html>