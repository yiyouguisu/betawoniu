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
    <div class="header center z-index112 pr f18 fix-head">
        活动报名
        <div class="head_go pa">
            <a href="<?php echo U('Party/show');?>?id=<?php echo ($data["id"]); ?>">
                <img src="/Public/Web/images/go.jpg">
            </a><span>&nbsp;</span>
        </div>
    </div>
    <div class="container padding_0" style="margin-top:6rem">
        <div class="act_e">
            <div class="act_e1 fl">
                <img src="/Public/Web/images/act_c1.jpg">
            </div>
            <div class="act_e2 fr">
                <div class="act_e3"><?php echo ($data["title"]); ?></div>
                <div>
                    <div class="land_font">
                        <span>时间:</span> <?php echo (date('Y-m-d',$data["starttime"])); ?> 至<?php echo (date('Y-m-d',$data["endtime"])); ?>
                    </div>
                    <div class="land_font">
                        <span>地点:</span> <?php echo ($data["address"]); ?>
                    </div>
                </div>

            </div>
        </div>
        <form action="<?php echo U('Web/Order/createAct');?>" method="post" id='form' onsubmit="return checkform();">
            <input type="hidden" name="_token" value="<?php echo ($_token); ?>">
            <input type="hidden" name="aid" value="{pid}">
            <div class="we_a" style="margin-bottom:6rem">
                <div class="yr-a we_p2 center">报名人数</div>
                <div class="we_b">
                    <div class="we_b1">
                    </div>
                    <div class="we_b2 center">
                        <input type="number" name='num' class="we_text" value="1" readonly>人
                    </div>
                    <div class="we_b1 right">
                    </div>
                </div>
                <div class="yr-a we_p2 center" style="margin-top:1rem;">主报名人信息</div>
                <div class="we_d">
                    <div class="lu_b">
                        <input type="text" name="realname" class="lu_text main-partner" value="<?php echo ($member["realname"]); ?>" placeholder="真实姓名 :">
                    </div>
                    <div class="lu_b">
                        <input type="text" name="phone" class="lu_text main-partner" value="<?php echo ($member["phone"]); ?>" placeholder="电话号码 :">
                    </div>
                    <div class="lu_b">
                        <input type="text" name="idcard" class="lu_text main-partner" value="<?php echo ($member["idcard"]); ?>" placeholder="身份证号码 :">
                    </div>
                </div>
                <div class="yr-a we_p2 center" style="margin-top:-1rem;">其他报名人信息</div>
                <div class="we_c">
                </div>
                <div class="olist home_inforClick">
                    <a href="javascript:;" class="ft14"><span>+</span>添加</a>
                </div>
                <!--
                <div class="ft12 yr-a padding_2 center" style="padding-top:0">是否有优惠券</div>
                <div class="help_list" style="border-radius:5px;">
                    <div class="help_a ft12 common_click couponstitle">选择优惠券</div>
                </div>
                -->
            </div>
            <div class="ig" style="position:fixed;bottom:0;left:0;right:0">
                <div class="ig_left fl">
                    <div class="ig_a ft14">活动总额 :
                        <span class="ft16">￥<span class="ft16" id='tmoney'><?php echo ($data["money"]); ?></span> </span>
                    </div>
                    <div class="ig_b ft10">
                        <a href="#" id="price_detail">价格明细 <!-- <img src="/Public/Web/images/arrow.jpg"><span id='details'></span> -->&nbsp;&gt;</a>
                    </div>
                </div>
                <div class="ig_right fr">
                    <input type='hidden' name='money' value='<?php echo ($data["money"]); ?>'>
                    <input type='hidden' name='aid' value="<?php echo ($pid); ?>">
                    <input type="hidden" name="couponsid" value="">
                    <input type="hidden" name="discount" value="0.00">
                    <input type="submit" class='sub' value="提交报名表" style="background:transparent;color:#fff">
                </div>
            </div>
        </form>
    </div>

    <!--弹窗操作 -->
    <div class="fix_box_full_wt" style="display:none" id="edit_partner">
      <div class="fix_box_header theme_back_blue">
          <a class="ft18 cwt" href="javascript:;">修改参与人</a>
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

            <div class="snail_d homen_href center f16">
                <a href="">添加常用人信息</a>
            </div>

            <div class="snail_d homen_style center f16">
                <a href="javascript:;" id="add_linkman_to_partner">确定添加</a>
            </div>
        </div>
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
                <a class='addCoupon'>确定添加</a>
            </div>
        </div>
    </div>
    <div id="p_detail" style="position:fixed;left:0;right:0;top:0;bottom:0;z-index:1000;display:none;">
        <div style="position:absolute;left:0;top:6rem;right:0;bottom:0;background:#000;opacity:0.8;"
        id="mask"></div>
        <div style="position:absolute;left:10px;right:10px;height:5rem;top:6rem;border-bottom:1px solid #fff;"></div>
        <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:11.5rem;"></div>
        <div style="position:absolute;height:2rem;left:0;width:100%;top:13.5rem;">
            <span style="width:30%;margin-left:10px;color:#fff;display:inline-block;text-align:left"
            id="d_start"><?php echo (date('Y-m-d',$data["starttime"])); ?></span>
            <span style="width:34%;color:#56c3cf;display:inline-block;text-align:center" class="ft14">共<span id="d_people">2</span>人</span>
            <span style="width:30%;color:#fff;display:inline-block;text-align:right" id="d_end"><?php echo (date('Y-m-d',$data["endtime"])); ?></span>
        </div>
        <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:15.5rem;"></div>
        <div style="position:absolute;left:10px;right:10px;height:4rem;top:18rem;padding-top:1rem;border-top:1px solid #fff;">
            <span style="width:48%;display:inline-block;color:#fff" class="ft16">活动总额</span>
            <span style="width:48%;display:inline-block;color:#ff5f4c;text-align:right;" class="ft16"
            id="dtotal"></span>
        </div>
    </div>
</body>
<script>
    $(function()
    {   
        aa();
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
        $(".addCoupon").click(function()
        {
            var couponsid = $("div.name_box div.prefer_cut").data(
                "id");
            var price = $("div.name_box div.prefer_cut").data(
                "price");
            var couponstitle = $(
                "div.name_box div.prefer_cut").data(
                "title");
            $(".big_mask,.pyl,.common_mask").hide();
            $('.couponstitle').text(couponstitle);

            $("#discount").text(parseFloat(price).toFixed(2));
            $("input[name='couponsid']").val(couponsid);
            $("input[name='discount']").val(parseFloat(price)
                .toFixed(2));
            aa();
        })
    })
    var money = <?php echo ($data["money"]); ?>;
    (function() {
        $('.we_text').val(countActPeople());
        total(countActPeople());
    })();

    function aa()
        {
            var thisnum = $('.we_text').val();
            var discount = $("input[name='discount']").val();
            var total = thisnum * money - discount;
            $("#tmoney").text(total);
            $('input[name="money"]').val(total);
            console.log(total);
        }
        // 减少人数
        /*
        $('.reduce').click(function(){
        	var num=countActPeople();
        	var thisnum=$('.we_text').val();
        	if(thisnum<=countActPeople()){
        		return;
        	}
        	else{
        		thisnum--;
        		$('.we_text').val(thisnum);
        		total(thisnum);
        	}
        })
         */
        // 增加人数
        /*
        $('.add').click(function(){
        	var thisnum=$('.we_text').val();
        	console.log(thisnum);
        	thisnum++;
        	console.log(thisnum);
        	$('.we_text').val(thisnum);
        	total(thisnum);
        })
         */
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
        var thisnum = $('.we_text').val();
        $('.we_text').val(--thisnum);
        total(thisnum);
    })

    function countActPeople() {
        var count = $('we_c.name_list').length + 1;
        return count;
    }

    function total(people)
    {
        var total = Number(people) * money;
        $('#tmoney').text(total);
        $('#details').text(people + '人*￥' + money);
        aa();
    }

    function checkform()
    {
        var realname = $("input[name='realname']").val();
        var idcard = $("input[name='idcard']").val();
        var phone = $("input[name='phone']").val();
        var num = $("input[name='num']").val();
        if (realname == '')
        {
            alert("请填写姓名");
            $("input[name='realname']").focus();
            return false;
        }
        else if (idcard == '')
        {
            alert("请填写身份证号码");
            $("input[name='idcard']").focus();
            return false;
        }
        else if (phone == '')
        {
            alert("请填写手机号码");
            $("input[name='phone']").focus();
            return false;
        }
        else if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone))
        {
            alert("手机号码格式不正确");
            $("input[name='phone']").focus();
            return false;
        }
        else if (!/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(idcard))
        {
            alert("身份证号码错误");
            $("input[name='phone']").focus();
            return false;
        }
        else
        {
            return true;
        }
    }
    $('#p_detail').click(function(evt)
    {
        evt.preventDefault();
        $(this).hide();
    });
    $('#price_detail').click(function(evt)
    {
        evt.preventDefault();
        $('#d_people').html(countActPeople());
        var total = Number(countActPeople()) * money;
        $('#dtotal').html(total);
        $('#p_detail').fadeIn('fast');
    });
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
     * 新增常用联系人页面信息
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
      $('input[name=num]').val(num + 1);
      total();
    }

  })();
</script>
</html>