<include file="Public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18" style="position:fixed;top:0;left:0;width:100%;">
      行程详细
  <div class="head_go pa">
    <a href="javascript:history.go(-1)">
      <img src="__IMG__/go.jpg">
    </a>
  </div>
  <div class="tra_pr hd_ck pa"><i></i><em><img src="__IMG__/hj_a2.jpg"></em></div>
</div>
<notempty name="edit">
  <div class="container padding_0" style="margin-top:6rem;margin-bottom:6rem">
<else />
  <div class="container padding_0" style="margin-top:6rem;">
</notempty>
       <div class="trip_c center">
              <div class="bich_a">
                  <div class="trip_c1 bich_a1">{$trip.description}</div>
                  <div class="bich_a2">
                    {$placeStr}
                  </div>
                  <div class="bich_a3"></div>
              </div>
              <div class="trip_c2">
                <img src="__IMG__/time.png">2016年5月20日 - 5月25日
                
              </div>
              <div class="trip_c3">
                <if condition="$trip.status eq 1">
                     未开始
                <elseif condition="$trip.status eq 2" />
                     进行中
                <elseif condition="$trip.status eq 3" />
                     已完成
                </if>
              </div>
       </div>
       <div class="bich_b">
          <volist name="tripinfos" id="tripinfo">
            <div class="bich_list">
              <div class="bich_c fl">
                  <div class="bich_c1">28</div>
                  <div class="bich_c2">四月</div>
              </div>
              <div class="bich_d fl">
                  <div class="bich_d1">{$tripinfo.cityname}</div>
                  <div class="bich_d2">{$tripinfo.place}</div>
              </div>
              <div class="bich_e fl">
                  <div class="bich_e1">
                    <p class="over_ellipsis">{$tripinfo.event}<p>
                  </div>
                  <!-- <div class="bich_e2">西湖森林湖泊钓鱼活动</div> -->
              </div>
            </div>
          </volist>
       </div> 
       <div class="trip_f">
         <div class="trip_f1">评论区
              <div class="trip_f2">
                     <img src="__IMG__/land_d3.png">
                     <span>{$ccount}</span>条评论
              </div>
         </div>
         <div class="trip_fBtm">
          <volist name="comments" id="comment">
            <div class="fans_list">
              <div class="per_tx fl">
                <img src="{$comment['head']}">
              </div>
              <div class="fans_b per_tr fl">
                <div class="fans_b1 f16">{$comment['nickname']}</div> 
                <div class="fans_b2 f14">{$comment['content']}</div> 
                <div class="fans_time f13">{$comment['inputtime']|date='Y-m-d', ###}</div>
              </div>
            </div>
          </volist>
         </div>
         <div class="trip_t">
            <form action="{:U('Trip/comment')}" method="post">
              <input type="text" placeholder="发布我的评论 ..." class="trip_text fl" name="content">
              <input type="hidden" name="tid" value="{$trip.id}">
              <input type="submit" value="评论" class="trip_button fr">
            </form>
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
      <form action="{:U('Trip/edit')}" method="post" id="post_edit">
        <input type="hidden" name="tid" value="{$trip.id}">
        <div class="form-group">
          <input class="required form-control form-inline" type="text" name="trip_title" placeholder="行程标题：" data-content="行程标题" value="{$trip.title}">
        </div>
        <div class="form-group">
          <input class="required form-control form-inline" type="date" name="start_date" placeholder="出发时间：" data-content="出发时间" value="{$startDate}">
        </div>
        <div class="form-group">
          <input class="required form-control form-inline" type="number" name="trip_days" placeholder="出行天数：" data-content="出行天数" value="{$trip.days}">
        </div>
      </form>
    </div>
  </div>
</div>
<notempty name="edit">
  <div style="position:fixed;bottom:0;left:0;right:0;padding:10px;text-align:center;background:#f8f8f8;height:auto">
    <a style="display:block;padding:5px;color:#fff;background:#56c3cf;font-size:16px;" href="{:U('Trip/')}" id="edit_trip">
      编辑我的行程
    </a>
  </div>
</notempty>
<script type="text/javascript">
  $('#edit_trip').click(function(evt) {
    evt.preventDefault();
    $('#new_trip').removeClass('hide');
  });
  $('#dismiss_edit').click(function(evt) {
    evt.preventDefault();
    $('#new_trip').addClass('hide');
  });
  $('#save_trip').click(function(evt) {
    $('#post_edit')[0].submit();
    evt.preventDefault();
  });
</script>
</body>
</html>
