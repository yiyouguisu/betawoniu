<include file="Public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      我的
      <div class="per_header pa"><a href="{:U('Web/Member/set')}"><img src="__IMG__/home_v1.jpg"></a><i>&nbsp;</i></div>
      <div class="tra_pr hd_ck home_header home_ck1 pa"><img src="__IMG__/hj_a2.jpg"><span>分享APP</span></div>
</div>
<div class="container">
      <div class="son_top pr f0">
              <div class="son_a vertical"><a href="{:U('Web/Member/myinfo')}"><img src="{$data.head}"></a></div>
              <div class="son_b vertical">
                    <div class="son_b1 f20">{$data.nickname}</div>
                    <div class="son_b2 f14"><em>关注: {$follow|default="0"}</em><span>粉丝: {$fans|default="0"}</span></div>
              </div>
              <div class="set_a pa"><a href="{:U('Web/Member/memberHome',array('id'=>$data['id']))}">个人主页<img src="__IMG__/set_right.jpg"></a></div>
      </div> 
      
      <div class="set_b">
              <a href="{:U('Web/Member/publicnote')}"><div class="help_list">
               <div class="help_a"><img src="__IMG__/set_a1.jpg"> 我要发布游记</div>
              </div></a> 
      </div>
      
      <div class="set_b">
            <a href="my-merchant1.html">
                <div class="help_list">
                    <div class="help_a"><img src="__IMG__/mer_a1.jpg"> 我的钱包</div>
                </div>
            </a> 
              
            <a href="{:U('Web/Member/mymerchant')}"><div class="help_list">
                <div class="help_a"><img src="__IMG__/mer_a2.jpg"> 我发布的民宿</div>
            </div></a>
              
            <a href="{:U('Web/Member/myact')}"><div class="help_list">
                <div class="help_a"><img src="__IMG__/mer_a3.jpg"> 我发布的活动</div>
            </div></a>

            <a href="{:U('Web/Member/couponInfo')}">
                <div class="help_list">
                    <div class="help_a"><img src="__IMG__/set_a2.jpg"> 我的优惠券</div>
                </div>
            </a> 
            <a href="{:U('Web/Member/orderlist')}">
                <div class="help_list">
                    <div class="help_a">
                        <img src="__IMG__/set_a3.jpg"> 我的订单
                        <sup><img src="__IMG__/point.jpg"></sup><span>(6)</span>
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
      
      <div class="set_c">
         <div class="snail_d center trip_btn f16">
                  <a href="{:U('Web/Member/certification')}" class="snail_cut ">我要实名认证</a>
         </div>
      </div>
      
      <div style="height:4rem"></div>

</div>

<include file="Public:foot" />