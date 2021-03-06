<include file="Public:head" />
<div class="header center z-index112 pr f18 fix-head">
    美宿预订
    <div class="head_go pa">
        <a href="{:U('member/orderlist')}">
            <img src="__IMG__/go.jpg">
        </a><span>&nbsp;</span>
    </div>
</div>
<div class="container" style="margin-top:6rem;padding-bottom:0">
    <div class="stayin-head qiandao-clear">
      <if condition="$order.status eq 1">待审核
      <elseif condition="$order.status eq 2" />待支付
      <elseif condition="$order.status eq 3" />已取消
      <elseif condition="$order.status eq 4" />
        <if condition="$order.finished eq 1">
          已完成
        <else />
          <eq name="order.refund_status" value="1">
            申请退订
          <else />
            待入住
          </eq>
        </if>
      <elseif condition="$order.status eq 5" />审核失败
      <elseif condition="$order.status eq 6" />已关闭
      </if>
      <if condition="$order.status eq 1">
        <if condition="$is_owner eq 1">
          <a href="{:U('Order/go_audio')}?orderid={$order.orderid}">
            <span class="fr audit-fr">去审核</span>
          </a>
        </if>
      <elseif condition="$order.status eq 2" />
        <if condition="$is_owner eq 0">
          <a href="{:U('Order/hotelPay')}?orderid={$order.orderid}">
              <span class="fr audit-fr">去支付</span>
          </a>
        </if>
      <elseif condition="$order.status eq 4" />
        <eq name="order.finished" value="1">
          <if condition="$order.evaluate_status eq 0">
            <a href="{:U('Order/hotelPay')}?orderid={$order.orderid}">
                <span class="fr">去评价</span>
            </a>
          </if>
        <else />
          <eq name="order.refund_status" value="1" >
            <if condition="$is_owner eq 1">
              <a href="{:U('Order/cancel_audit')}?orderid={$order.orderid}">
                <span class="fr audit-fr">去审核</span>
              </a>
            </if>
          <else />
            <if condition="$is_owner eq 0" >
              <a class="cancel_order" href="javascript:;">
                  <span class="fr cancel_order">取消订单</span>
              </a>
            </if>
          </eq>
        </eq>
        <notempty name="order.refundreview_remark">
          <a class="" href="javascript:;">
              <span class="fr cancel_order">拒绝退订</span>
          </a>
        </notempty>
      </if>
      <div class="ft10">订单号：{$order.orderid}</div>
    </div>
    <notempty name="order.refundreview_remark"> 
      <div style="margin: 8px 0;padding:5px">
        <p>失败原因：{$order.refundreview_remark}</p>
      </div>
    </notempty>
    <notempty name="order.review_remark"> 
      <div style="margin: 8px 0;padding:5px">
        <p>失败原因：{$order.review_remark}</p>
      </div>
    </notempty>
    <!-- 支付模块 -->
    <if condition="$order.status eq 2">
      <empty name="is_owner">
        <div style="padding:8px 0;background:#efefef">
            <else />
        <div style="padding:8px 0;background:#efefef;display:none">
      </empty>
    </if>
    <empty name="is_owner">
      <if condition="($order.status eq 2) OR ($order.status eq 1)">
        <a href="" style="display:block">
          <div class="submit-head qiandao-clear">
            <div class="fl" style="color:#999">在线支付 :<span>￥<span>{$order.money}</span></span>
            </div>
            <div class="fr" style="color:#999" id="price_detail">价格明细
              <img src="__IMG__/arrow.jpg">
            </div>
          </div>
        </a>
        <div class="submit-head submit-heads qiandao-clear">
          <a class="fl on" href="{:U('Order/editbook')}?orderid={$order.orderid}">修改订单</a>
          <a class="fr cancel_order">取消订单</a>
        </div>
      <elseif condition="$order.status eq 5" />
        <div style="padding:8px 5px;background:#f8f8f8">
          拒绝理由：{$order.review_remark}
        </div>
      </if>
      
    </empty>
    </div>
    <!--  -->

    <div class="stayin-middle qiandao-clear">
        <div class="fl f-fl">
            <img src="{$order.productinfo.thumb}" style="width:80;height:60px;">
        </div>
        <div class="fl">
            <p class="f-p">{$order.productinfo.title}</p>
            <p class="s-p">{$order.productinfo.room_name}</p>
        </div>
        <div class="fr t-fr" style="width:auto;padding-left:8px;padding-right:8px">￥<span>{$order.money}</span>
        </div>
    </div>
    <div class="stayin-middle">
        <p class="t-p"><span class="theme_color_blue f-span">入住时间：</span>
          <span>{$order.productinfo.starttime|date='m月d日',###}-{$order.productinfo.endtime|date='m月d日',###}</span>
          <span>共{$order.productinfo.days}天</span>
          <span class="t-span">{$order.productinfo.roomnum}间</span>
        </p>
        <p class="t-p">
          <span class="theme_color_blue f-span">使用优惠：</span>
          <span id="use_discount">{$discount|default='未使用'}</span>
        </p>
    </div>
    <div class="theme_color_blue stayin-order">预订人信息</div>
    <div class="stayin-main">
        <p class="fou-p">
          <span class="f-span">{$order.productinfo.realname}</span>
        </p>
        <p class="fou-p qiandao-clear">
          手机号码 :<span class="fr">{$order.productinfo.phone}</span>
        </p>
        <p class="fou-p qiandao-clear">
          身份证号 :<span class="fr">{$order.productinfo.idcard}</span>
        </p>
    </div>
    <div class="stayin-order theme_color_blue">入住人信息（共{$ccount}人）</div>
    <volist name="clients" id="client">
      <div class="stayin-main">
          <p class="fou-p"><span class="f-span">{$client.realname}</span>
          </p>
          <p class="fou-p qiandao-clear">手机号码 :<span class="fr">{$client.phone}</span>
          </p>
          <p class="fou-p qiandao-clear">身份证号 :<span class="fr">{$client.idcard}</span>
          </p>
      </div>
    </volist>
    <if condition="$ccount gt 1">
      <div class="stayin-more">显示全部入住人
          <img src="__IMG__/drop_f.jpg">
      </div>
    </if>
    <a class="theme_color_blue stayin-details" href="{:U('Hostel/show')}?id={$order.productinfo.hid}">美宿详情</a>
    </div>
    <div id="cancel" style="position:fixed;top:0;left:0;bottom:0;right:0;z-index:1000;display:none">
      <div style="position:absolute;left:0;right:0;top:0;bottom:0;background:#000;opacity:0.6"></div>
      <div style="position:absolute;top:20%;width:80%;left:10%;height:230px;background:#fff;border:0;border-radius:3px;text-align:right">
        <textarea id="reason" style="width:90%;height:150px;border:0;margin:5%;" class="ft16" placeholder="请填写理由"></textarea> 
        <button class="ft14" style="padding:5px;border:0;width:100px;background:#efefef;color:#000;border-radius:3px;margin:0 1%" id="close_cancel">关闭</button>
        <button class="ft14" style="padding:5px;border:0;width:100px;background:#56c3cf;color:#fff;border-radius:3px;margin:0 5%" id="submit_cancel" data-orderid="{$order.orderid}" data-uid="{$order.uid}">提交</button>
      </div>
    </div>
  <div id="p_detail" style="position:fixed;left:0;right:0;top:0;bottom:0;z-index:1000;display:none">
      <div style="position:absolute;left:0;top:6rem;right:0;bottom:0;background:#000;opacity:0.8;"
      id="mask"></div>
      <div style="position:absolute;left:10px;right:10px;height:5rem;top:6rem;border-bottom:1px solid #fff;"></div>
      <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:11.5rem;"></div>
      <div style="position:absolute;height:2rem;left:0;width:100%;top:13.5rem;">
          <span style="width:30%;margin-left:10px;color:#fff;display:inline-block;text-align:left" class="ft12" id="d_start">{$order.productinfo.starttime|date='m月d日',###}入住</span>
          <span style="width:34%;color:#56c3cf;display:inline-block;text-align:center" class="ft14">共<span id="d_day">{$order.productinfo.days}</span>天</span>
          <span style="width:30%;color:#fff;display:inline-block;text-align:right" id="d_end" class="ft12">{$order.productinfo.endtime|date='m月d日',###}离店</span>
      </div>
      <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:15.5rem;"></div>
      <div style="position:absolute;left:10px;right:10px;height:4rem;top:18rem;padding-top:1rem;border-top:1px solid #fff;">
          <span style="width:48%;display:inline-block;color:#fff" class="ft16">预定总额</span>
          <span style="width:48%;display:inline-block;color:#ff5f4c;text-align:right;" class="ft16" id="dtotal">¥{$order.money}</span>
      </div>
  </div>
    </body>
    <script>
        $(function()
        {
            var homeLength = 3
            var homeList = $(".stayin-main").length;
            if (homeList > homeLength)
            {
                $(".stayin-main").each(function(i)
                {
                    if (i >= homeLength)
                    {
                        $(".stayin-main").eq(i).hide();
                    }
                });
            }
            $(".stayin-more").click(function()
            {
                $(".stayin-main").fadeIn();
                $(".stayin-more").remove();
            })
        })
        $('.cancel_order').click(function(evt) {
          evt.preventDefault();
          var cancel_status = {$order.status};
          if(cancel_status == 2 || cancel_status == 1) {
            var con = confirm('确认取消订单？');
            var uid = {$order.uid};
            var orderid = '{$order.orderid}';
            if(con) {
              $.ajax({
                'url': '{:U("Api/Order/closeorder")}',
                'dataType': 'json',
                'data': JSON.stringify({'uid': uid, 'orderid': orderid }),
                'type': 'post',
                'contentType': 'text/xml',
                'processData': false,
                'success': function(data) {
                  if(data.code == 200) {
                    alert('订单已取消！');
                    window.location.reload();
                  } else {
                    alert(data.msg);
                  }
                },
                'error': function(err) {
                  console.log(err); 
                }
              });   
            }
          } else if(cancel_status == 4) {
            $('#cancel').fadeIn('fast');
          }
        });
        $('#close_cancel').click(function(evt) {
          evt.preventDefault();
          $('#cancel').fadeOut('fast');
          $('#reason').val('');
        });
        $('#submit_cancel').click(function(e) {
          e.preventDefault();
          if(!$('#reason').val()) {
            alert('请填写理由！');
            return;
          }
          var _this = $(this);
          _this.attr('disabled', 'disabled');
          var uid = _this.data('uid');
          var orderid = _this.data('orderid');
          $.ajax({
            'url': "{:U('Api/Order/refundapply')}",
            'data': JSON.stringify({
              'uid': uid,
              'orderid': orderid,
              'content': $('#reason').val()
            }),
            'dataType': 'json',
            'type': 'post',
            'processData': false,
            'contentType': 'text/xml',
            'success': function(data) {
              if(data.code == 200) {
                window.location.reload();
              } else {
                alert(data.msg);  
                _this.removeAttr('disabled');
              }
            },
            'error': function(err, data) {
              console.log(err);
              console.log(data); 
              _this.removeAttr('disabled');
              alert('网络错误，请检查您的网络！');
            }
          });
        });
      $('#price_detail').click(function(evt)
      {
          evt.preventDefault();
          var target = $('#p_detail');
          target.fadeIn('fast');
          $('#')
      });
      $('#p_detail').click(function(evt)
      {
          evt.preventDefault();
          $(this).fadeOut('fast');
      });

    </script>
    </html>
