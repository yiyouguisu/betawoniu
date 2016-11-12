<include file="Public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18" style="position:fixed;left:0;top:0;right:0">
      我的
      <div class="per_header pa"><a href="{:U('Web/Member/set')}"><img src="__IMG__/home_v1.jpg"></a><i>&nbsp;</i></div>
      <div class="tra_pr hd_ck home_header home_ck1 pa"><img src="__IMG__/hj_a2.jpg"><span>分享APP</span></div>
</div>
<div class="container" style="margin-top:6rem;">
      <div class="son_top pr f0">
              <div class="son_a vertical">
                <a href="{:U('Web/Member/myinfo')}">
                  <img  src="{$data.head}" style="width:60px;height:60px;border-radius:35px;border:3px solid #fff;">
                  <eq name="data['houseowner_status']" value="1">
                    <img src="__IMG__/houseowner.png" class="houseowner_img">
                  </eq>
                </a>
              </div>
              <div class="son_b vertical">
                    <div class="son_b1 f20">{$data.nickname}</div>
                    <div class="son_b2 f14"><em>关注: {$follow|default="0"}</em><span>粉丝: {$fans|default="0"}</span></div>
              </div>
              <div class="set_a pa"><a href="{:U('Web/Member/memberHome',array('id'=>$data['id']))}">个人主页<img src="__IMG__/set_right.jpg"></a></div>
      </div> 
      
      <div class="set_b">
              <a href="{:U('Web/Note/add')}"><div class="help_list">
               <div class="help_a"><img src="__IMG__/set_a1.jpg"> 我要发布游记</div>
              </div></a> 
      </div>
      
      <div class="set_b">
            <eq name="data['houseowner_status']" value="1"> 
            <a href="{:U('Wallet/index')}">
                <div class="help_list">
                    <div class="help_a"><img src="__IMG__/mer_a1.jpg"> 我的钱包</div>
                </div>
            </a> 
            </eq>
            <eq name="data['houseowner_status']" value="1"> 
              <a href="{:U('Web/Member/mymerchant')}"><div class="help_list may_disnone">
                  <div class="help_a"><img src="__IMG__/mer_a2.jpg"> 我发布的美宿</div>
              </div></a>
              
              <a href="{:U('Web/Member/myact')}"><div class="help_list may_disnone">
                  <div class="help_a"><img src="__IMG__/mer_a3.jpg"> 我发布的活动</div>
              </div></a>
            </eq>
            <a href="{:U('Web/Member/mycoupons')}">
                <div class="help_list">
                    <div class="help_a"><img src="__IMG__/set_a2.jpg"> 我的优惠券</div>
                </div>
            </a> 
            <a href="{:U('Web/Member/orderlist')}">
                <div class="help_list">
                    <div class="help_a">
                        <img src="__IMG__/set_a3.jpg"> 我的订单
                        <gt name="newordernum" value="0">
                          <sup><img src="__IMG__/point.jpg"></sup><span>({$newordernum|default="0"})</span>
                        </gt>
                    </div>
                </div>
            </a>

            <a href="{:U('Web/Member/mynote')}">
                <div class="help_list">
                    <div class="help_a"><img src="__IMG__/set_a4.jpg"> 我的游记</div>
                </div>
            </a> 

            <a href="{:U('Web/Member/collect')}">
                <div class="help_list">
                    <div class="help_a"><img src="__IMG__/set_a5.jpg"> 我的收藏</div>
                </div>
            </a> 
            <a href="{:U('Web/Member/useinfo')}">
                <div class="help_list">
                    <div class="help_a"><img src="__IMG__/set_a6.jpg"> 帮助手册</div>
                </div>
            </a> 
            <a href="">
                <div class="help_list">
                    <div class="help_a"><img src="__IMG__/set_a7.jpg"> 邀请好友注册</div>
                </div>
            </a> 
      </div>
      <eq name="data['houseowner_status']" value="0"> 
        <div class="set_c">
          <div class="snail_d center trip_btn f16">
            <eq name="data['realname_status']" value="0">
              <a href="{:U('Web/Member/realname')}" class="snail_cut ">
            <else />
              <a href="{:U('Web/Member/apply_hotel_owner')}" class="snail_cut">
            </eq>
              我要成为美宿主人
            </a>
          </div>
        </div>
      </eq>
      
      <div style="height:4rem"></div>

</div>

<include file="Public:foot" />
