<include file="Public:head" />
<body>
<div class="header center pr f18" style="position:fixed;top:0;left:0;width:100%;z-index:1000">
  行程<div class="map_small f14 pa"><a href=""><img src="__IMG__/trip_b1.jpg">使用说明</a></div>      
</div>
<div style="height:6rem">
</div>
<div class="container">
   <div class="land">
          <div class="land_btm">
                  <div class="land_b trip_title center f16">
                  	   <a class="tabs land_cut" data-signal="my_trip" data-target="#my_trips" data-plan="yes" href="#">我的行程</a>
                  	   <a class="tabs" data-signal="public_trip" data-target="#public_trips" href="#">公开行程</a>
                  </div>
                  <div>
                    <div class="comments_box" id="my_trips">
                      <volist name="trips" id="trip">
                        <a href="{:U('Trip/detail')}?id={$trip.id}">
                          <div class="comments">
                            <div class="com_top pr">
                              <div class="com_a f16">{$trip.description}</div>
                              <div class="com_b trip_time f13">
                                <img src="__IMG__/time_f.jpg">{$trip.starttime|date='Y-m-d',###} - {$trip.endtime|date='Y-m-d',###}
                              </div>
                              <if condition="$trip.status eq 1">
                                <div class="com_c com_c2 pa">
                                   未开始
                                </div>
                              <elseif condition="$trip.status eq 2" />
                                <div class="com_c com_c2 pa">
                                   进行中
                                </div>
                              <elseif condition="$trip.status eq 3" />
                                <div class="com_c com_c1 pa">
                                   已完成
                                </div>
                              </if>
                            </div>
                          </div>
                        </a>
                      </volist>
                    </div>
                    <div class="comments_box" id="public_trips" style="display:none">
                      <volist name="publics" id="pub">
                        <a href="{:U('Trip/detail')}?id={$pub.id}">
                          <div class="comments">
                            <div class="com_top pr">
                              <div class="com_a f16">{$pub.description}</div>
                              <div class="com_b trip_time f13">
                                <img src="__IMG__/time_f.jpg">{$pub.starttime|date='Y-m-d',###} - {$pub.endtime|date='Y-m-d',###}
                              </div>
                              <if condition="$pub.status eq 1">
                                <div class="com_c com_c2 pa">
                                   未开始
                                </div>
                              <elseif condition="$pub.status eq 2" />
                                <div class="com_c com_c2 pa">
                                   进行中
                                </div>
                              <elseif condition="$pub.status eq 3" />
                                <div class="com_c com_c1 pa">
                                   已完成
                                </div>
                              </if>
                            </div>
                          </div>
                        </a>
                      </volist>
                    </div>
                  </div>
          </div>
          <div class="bv" id="make_plan">
                  <div class="snail_d center trip_btn f16">
                            <a href="#" id="add_trip" class="snail_cut">制定新的行程</a>
                  </div>
          </div>	
   </div>	   	
  <div id="new_trip" class="hide">
    <div class="trip_cover"></div>
    <div class="trip_pre_content">
      <div style="padding:10px;font-size:14px;">
        <div style="width:30%" class="fl">
          <a href="#" id="dismiss_edit" style="color:#aaa">取消</a>
        </div> 
        <div style="width:40%;color:#56c3cf" class="fl tc">编辑行程信息</div> 
        <div style="width:30%" class="fl tr">
          <a href="#" style="color:#56c3cf" id="save_trip">保存</a>
        </div> 
        <div style="clear:both"></div>
      </div>
      <div style="padding:10px;">
        <form action="{:U('Trip/add')}" method="post" id="post_add">
          <div class="form-group">
            <input class="required form-control form-inline" type="text" name="trip_title" placeholder="行程标题：" data-content="行程标题">
          </div>
          <div class="form-group">
            <input class="required form-control form-inline" type="date" name="start_date" placeholder="出发时间：" value="" data-content="出发时间">
          </div>
          <div class="form-group">
            <input class="required form-control form-inline" type="number" name="trip_days" placeholder="出行天数：" data-content="出行天数">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  function switchTabs(evt) {
    evt.preventDefault();
    var that = $(this);
    console.log(that);
    that.siblings().removeClass('land_cut');
    that.addClass('land_cut');
    var target = that.data('target');
    $(target).siblings().hide();
    $(target).show();
    if(that.data('plan') == 'yes') {
      $('#make_plan').show();
    } else {
      $('#make_plan').hide();
    }
  }  
  $('.tabs').click(switchTabs);
  $('#dismiss_edit').click(function(evt) {
    evt.preventDefault();
    $('#new_trip').addClass('hide');
    $('.required').val('');
  });
  $('#add_trip').click(function(evt) {
    evt.preventDefault();
    $('#new_trip').removeClass('hide');
    $('.mask').hide();
  });
  $('#save_trip').click(function(e) {
    e.preventDefault();
    var filled = true;
    var notice = '';
    $('.required').each(function(i, t) {
      var val = $(t).val();
      if(!val) {
        filled = false;  
        notice += $(t).data('content') + '必须填写！\n';
      }
    });
    if(filled) {
      $('#post_add')[0].submit();
    } else {
      alert(notice); 
    }
  });
</script>
<include file="Public:foot" />
