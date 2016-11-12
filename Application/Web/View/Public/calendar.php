<div class="vb_date" style="background:#fff;padding:10px;">
  <div class="calendar"></div>
</div>
<script src="__JS__/underscore.js"></script>
<script src="__JS__/moment.min.js"></script>
<script src="__JS__/clndr.min.js"></script>
<script type="text/template" id="calendar-template">
  <div class="clndr-controls">
      <div class="clndr-previous-button"></div>
      <div class="month">
          <%=year %>-<%=month %>
      </div>
      <div class="clndr-next-button"></div>
  </div>
  <div class="clndr-grid">
      <div class="days-of-the-week">
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
  var rid = '{$data.rid}';
  var uid = '{$uid}';
  $.ajax({
    'url': '{:U("Api/Room/show")}',
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
