<include file="public:head" />
<body>
<div class="header center z-index112 pr f18 fix-head">
    预定美宿
    <div class="head_go pa" onclick="window.location.href='{:U('Web/Member/orderlist')}'">
    <img src="__IMG__/go.jpg"></div>
</div>

<div class="container" style="margin-top:6rem;padding-top:1rem">
   <div class="coupon_box center">
     <div class="fg_a"><img src="__IMG__/per_suc.jpg"></div>
     <div class="fg_b blue f24">恭喜，预订成功！</div>
     <div class="fg_c">我们会尽快通知房主，收到房主确认订单后</div>
     <div class="fg_c">我们会第一时间通知您</div>
     <div class="act_d center">
       <span>我们的其他房间</span>
       <div class="act_d1"></div>
     </div>
    </div>
    <div class="land_c  wc f14">
      <volist name="house_owner_room" id='vo'>
        <a href="{:U('Web/Hostel/room',array('id'=>$vo['id']))}">
          <div class="land_d pr f0">
            <div class="land_e vertical"><img src="{$vo.thumb}" style="width:100px;height:80px;"></div>
            <div class="land_f vertical">
              <div class="land_f1 f16">{$vo.title}</div>
              <div class="land_f2 f13">{$vo.area}M<sup>2</sup> {$vo.catname}</div>
              <div class="land_f3 pa f0">
                <div class="land_money f20"><em>￥</em>{$vo.money}
                  <span>起</span>
                </div>
              </div>
            </div>
          </div>
        </a>
      </volist> 
      <!-- <div class="scr_d center">显示全部{$count}个房间<img src="__IMG__/drop_f.jpg"></div>  -->
     </div>
</div>

</body>

</html>
