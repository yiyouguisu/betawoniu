<include file="public:head" />
<body>
<div class="header center z-index112 pr f18 fix-head">
    预定美宿
</div>

<div class="container" style="margin-top:6rem;padding-top:1rem">
   <div class="coupon_box center">
     <div class="fg_a"><img src="__IMG__/per_suc.jpg"></div>
     <div class="fg_b blue f24">恭喜，预订成功！</div>
     <div class="ft16 theme_color_blue" style="padding:8px 0">您的订单号为：{$order.orderid}</div>
     <div class="fg_c ft12">我们会尽快通知房主，收到房主确认订单后</div>
     <div class="fg_c ft12">我们会第一时间通知您</div>
     <br>
     <div style="padding:18px 8px;border-radisu:5px;background:#efefef;box-shadow:2px 5px 10px #999">
    <a href="{:U('Order/hotel_order_detail')}?orderid={$order.orderid}" id="pass" style="display:inline-block;padding:8px;width:42%;background:#56c3cf;color:#fff;border:0;border-radius:3px;" class="ft16">去看订单</a>
    <a href="{:U('Hostel/show')}?id={$data.hid}" id="not_pass" style="display:inline-block;padding:8px;width:42%;background:#fff;color:#000;border:0;border-radius:3px;" class="ft16">返回美宿详情</a>
     </div>
     <div class="act_d center">
       <span>我们的其他房间</span>
       <div class="act_d1"></div>
     </div>
    </div>
    <div class="land_c  wc f14">
      <volist name="house_owner_room" id='vo'>
        <a href="{:U('Web/Hostel/room',array('id'=>$vo['id']))}" style="display:block;padding:5px;border-bottom:1px solid #efefef">
          <div class="land_d pr f0">
            <div class="land_e vertical"><img src="{$vo.thumb}" style="width:100px;height:80px;"></div>
            <div class="land_f vertical">
              <div class="land_f1 f16">{$vo.title}</div>
              <div class="land_f2 f13">{$vo.area}M<sup>2</sup> {$vo.catname}</div>
              <div class="land_f3 pa f0">
                <div class="land_money ft18"><em>￥</em>{$vo.money}
                  <span>起</span>
                </div>
              </div>
            </div>
          </div>
        </a>
      </volist> 
     </div>
</div>

</body>

</html>
