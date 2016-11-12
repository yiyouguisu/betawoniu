<include file="public:head" />
<body class="back-f1f1f1">
  <div class="header center z-index112 pr f18" style="position:fixed;left:0;top:0;right:0">
      预订美宿
      <div class="head_go pa">
          <a href="{:U('Room/show')}?id={$data.rid}">
              <img src="__IMG__/go.jpg">
          </a><span>&nbsp;</span>
      </div>
  </div>
  <div class="container padding_0" style="margin-top:6rem">
      <div class="act_e" style="margin-bottom:2rem;">
          <div class="act_e1 fl">
              <img src="{$data.thumb}">
          </div>
          <div class="act_e2 fr">
              <div class="act_e3">{$data.t}</div>
              <div class="act_e4">{$data.title}</div>
          </div>
      </div>
      <form action="{:U('Web/Order/createbook')}" method="post" id='form' onsubmit="return checkForm();">
          <div class="yr">
              <div class="yr-a center">入住时间和离店时间</div>
              <div class="yr-b" style="margin-bottom:0;">
                  <div class="yr-c center fl time-box" data-target="#start_time" data-type="start">
                      <div class="yr-c1">
                          <img src="__IMG__/date.jpg">
                          </label>
                      </div>
                      <div class="yr-c2">入住时间</div>
                      <div class="yr-c3">
                          <input class="ggo_text begin" name="starttime" type="date" value="{$startTime|default=$tomorrow}"
                          id="start_time" style="display:none;">
                          <span>{$startTime|default=$tomorrow}</span>
                      </div>
                  </div>
                  <div class="yr-d fl pr">
                      共<span id='day'>{$days|default=1}</span>天
                      <div class="yr_line pa"></div>
                      <input type='hidden' value="{$days|default=1}" name="days" class='day' />
                  </div>
                  <div class="yr-c center fl time-box" data-target="#leave_time" data-type="end">
                      <div class="yr-c1">
                          <label for="leave_time">
                              <img src="__IMG__/date.jpg">
                          </label>
                      </div>
                      <div class="yr-c2">离店时间</div>
                      <div class="yr-c3">
                          <input class="ggo_text end" name="endtime" type="date" value="{$endTime|default=$afterTomorrow}"
                          id="leave_time" style="display:none;">
                          <span>{$endTime|default=$afterTomorrow}</span>
                      </div>
                  </div>
              </div>
              <div class="we snake_click">
                <p class="over_ellipsis">{$data.bookremark}</p>
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
                          <input type="number" name='rooms' id="rooms" class="we_text reduce_room" value="{$roomNum|default=1}">间
                      </div>
                      <div class="we_b1 right">
                          <input type="button" class="we_btn add2" value="+">
                      </div>
                  </div>
              </div>
              <div class="yr_list">
                  <div class="yr-a center ft12" style="padding:10px 5px 5px 5px">预订人数</div>
                  <div class="we_b" style="width:100%;text-align:center">
                      <!--
                      <div class="we_b1">
                          <input type="button" class="we_btn add1" value="-">
                      </div>
                      -->
                      <div class="we_b2 center ft12" style="width:100%;padding:8px;">
                          <input style="text-align:center" type="text" name='people' class="we_people reduce" value="{$pcount|default=1}" readonly>人
                      </div>
                      <!--
                      <div class="we_b1 right">
                          <input type="button" class="we_btn add1" value="+">
                      </div>
                      -->
                  </div>
              </div>

              <div class="yr_list">
                  <div class="yr-a center ft12" style="padding:8px 5px 5px 5px">入住信息</div>
                  <div class="we_c">
                      <volist name='people' id='vo'>
                          <div class="name_list">
                              <div class="name_text">{$vo.realname}</div>
                              <input type='hidden' value="{$i}" />
                              <!--<input type="text" class="name_text" placeholder="周生生" disabled="disabled">-->
                              <div class="name_a">
                                  <input type="button" class="name_btn del"  data-id='{$vo.id}' value="删除">
                              </div>
                          </div>
                      </volist>

                      <div class="olist">
                          <a id="add_people" style="vertical-align:middle;margin:0" class="ft14" href="{:U('Web/Member/topContacts')}?id={$rid}">+添加</a>
                      </div>

                  </div>
              </div>


              <div class="yr-a center ft12" style="padding:15px 5px 5px 5px">预订人信息</div>
              <div class="we_d">
                  <div class="lu_b">
                      <input type="text" class="ft12 lu_text" name="realname" placeholder="真实姓名 :"
                      value="{$member.realname}">
                  </div>

                  <div class="lu_b">
                      <input type="text" class="ft12 lu_text" name="phone" placeholder="电话号码 :"
                      value="{$member.phone}">
                  </div>

                  <div class="lu_b">
                      <input type="text" class="ft12 lu_text" name="idcard" placeholder="身份证号码 :"
                      value="{$member.idcard}">
                  </div>

              </div>
              <!--
              <div class="ft12 yr-a padding_2 center" style="padding-top:0">是否有优惠券</div>
              <div class="help_list" style="border-radius:5px;">
                  <div class="help_a ft12 common_click couponstitle">选择优惠券</div>
              </div>
-->
          </div>

          <div class="ig" style="position:fixed;left:0;right:0;bottom:0">
              <div class="ig_left fl">
                  <div class="ig_a ft12" style="line-height:20px">订单总额 :
                      <span>
               <em class="ft14">￥</em><span class="ft16" id='total'>{$data.nomal_money}</span>
                      </span>
                  </div>
                  <div style="padding:0px">
                      <a class="ft10" href="#" id="price_detail" style="color:#ff5f4c">价格明细</a>
                  </div>
              </div>
              <div class="ig_right fr">
                  <input type="hidden" name="money" value="{$data.nomal_money}">
                  <input type="hidden" name="couponsid" value="">
                  <input type="hidden" name="discount" value="0.00">
                  <input type="hidden" name="memberids" value="">
                  <input type="hidden" name="rid" value="{$id}">
                  <a class='sub'>提交订单</a>
              </div>
          </div>
          </from>
  </div>
  <div class="big_mask"></div>
  <div class="common_mask" style="height: 80%;">
    <div class="pyl_top pr ">选择优惠券
        <div class="pyl_close pa"><img src="__IMG__/close.jpg"></div>
    </div>
    <div class="common_mid" style=" height: 90%;">
      <div class="name_box bianj_child" style="height: 80%;overflow-y: scroll;">
          <volist name='coupon' id='vo'>
            <div class="prefer_list" data-title="{$vo.title}" data-id="{$vo.id}" data-price="{$vo.price}">
              <span>{$vo.title}</span>
            </div>
          </volist>   
      </div>
      <div class="snail_d homen_style center f16">
          <a class='addCoupon'>确定添加</a>
      </div>
    </div>
  </div>
  <div id="time_choose_box" style="position:fixed;left:0;bottom:0;right:0;z-index:10000;display:none">
      <include file="Public:calendar" />
  </div>
  <div id="p_detail" style="position:fixed;left:0;right:0;top:0;bottom:0;z-index:1000;display:none">
      <div style="position:absolute;left:0;top:6rem;right:0;bottom:0;background:#000;opacity:0.8;"
      id="mask"></div>
      <div style="position:absolute;left:10px;right:10px;height:5rem;top:6rem;border-bottom:1px solid #fff;"></div>
      <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:11.5rem;"></div>
      <div style="position:absolute;height:2rem;left:0;width:100%;top:13.5rem;">
          <span style="width:30%;margin-left:10px;color:#fff;display:inline-block;text-align:left"
          id="d_start"></span>
          <span style="width:34%;color:#56c3cf;display:inline-block;text-align:center" class="ft14">共<span id="d_day">{$days|default='1'}</span>天</span>
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
        <div class="pyl_close pa"><img src="__IMG__/close.jpg"></div>
    </div>
    <div class="pyl_font" style="height:85%;-webkit-overflow-scrolling:touch;overflow:auto">
        <p style="padding:8px;min-height:78%">{$data.bookremark}</p>
        <div class="snail_d homen_style center f16" >
          <a href="javescript:void(0);" id="i_know" class="pyl_close" style="width:100%">我知道了</a>
        </div>
    </div>
</div>
  <script>
  $(function(){
     $(".common_click").click(function(){
         $(".big_mask,.common_mask").show()
     })
     $('.prefer_list').click(function(){
      $(this).addClass("prefer_cut").siblings().removeClass("prefer_cut");
      console.log(cdata);
     })
  })
  </script>
  <script type="text/javascript">
      var s, e, day;
      var people = 1;
      var day = 1;
      var money = {$data.nomal_money};
      var holidayMoney = {$data.holiday_money};
      var weekMoney = {$data.week_money};
      var allpeople = {$data.mannum};
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
      $(".addCoupon").click(function(){
          var couponsid=$("div.name_box div.prefer_cut").data("id");
          var price=$("div.name_box div.prefer_cut").data("price");
          var couponstitle=$("div.name_box div.prefer_cut").data("title");
          $(".big_mask,.pyl,.common_mask").hide();
          $('.couponstitle').text(couponstitle);
          
          $("#discount").text(parseFloat(price).toFixed(2));
          $("input[name='couponsid']").val(couponsid);
          $("input[name='discount']").val(parseFloat(price).toFixed(2));
          total();
      })

      function total()
      {
        var allmoney = 0;
        var startDate = $('#start_time').val();
        var endDate = $('#leave_time').val();
        var timeArr = dataScope(startDate, endDate);
        var discount=$("input[name='discount']").val();


        $.each(bookItems, function(i, value) {
          if(value.name == startDate) {
            allmoney += parseInt(value.price); 
            console.log(value);
          } else {
            $.each(timeArr, function(j, dat) {
              if(value.name == dat) {
                allmoney += parseInt(value.price); 
              } 
            }) 
          }
        });
        var days = timeArr.length + 1;
        var rooms = $('#rooms').val();
        allmoney = (allmoney * rooms-discount).toFixed(2);
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
      function rebind() {
        if(bindType) {
          $('.day').unbind('click');
          $('.day').click(dayClick);
        }
      }
      function chooseTime(evt) {
        console.log('choose time bind.');
        $('#time_choose_box').show();
        var _this = $(this);
        bindTarget = _this.data('target');
        bindType = _this.data('type');
        $('.day').unbind('click');
        $('.day').click(dayClick);
      };
      function dayClick() {
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
          $('#d_start').html(starttime ? starttime : '未选择');
          $('#d_end').html(endtime ? endtime : '未选择');
          $('#d_day').html(totalDurations);
          var my = total();
          if (!my) my = 0;
          $('#dtotal').html(my);
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
      function checkForm() {
        if(!$('input[name=realname]').val()) {
          alert('请正确填写真实姓名！');
          return false;
        }
        if(!$('input[name=idcard]').val() || $('input[name=idcard]').val().length != 18) {
          alert('请填写18位有效身份证号！');
          return false; 
        }
        if(!$('input[name=phone]').val() || $('input[name=phone]').val().length != 11) {
          alert('请填写11位有效手机号码！');
          return false;
        }
        return true; 
      }
      $('.del').click(function(){
      	var self=$(this);
      	var data={'id':$(this).data('id')};
      	$.post("{:U('Web/Member/delcookie')}",data,function(res){
      		self.parent().parent().remove();
      	})
      	var thisnum=$('.we_people').val();
        $('.we_people').val(--thisnum);
      })
  </script>
  <script>
    $('#add_people').click(function(evt) {
      evt.preventDefault();
      var me = $(this);
      var roomnum = $('#rooms').val() ? $('#rooms').val() : 1;
      var starttime = $('#start_time').val() ? $('#start_time').val() : '';
      var endtime = $('#leave_time').val() ? $('#leave_time').val() : '';
      var days = $('input[name=days]').val() ? $('input[name=days]').val() : 0;
      var url = me.attr('href') + '&starttime=' + starttime + '&endtime=' + endtime + '&roomnum=' + roomnum + '&days=' + days;
      window.location.href=url; 
    });
  </script>
</body>
</html>
