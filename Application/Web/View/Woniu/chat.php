<include file="Public:head" />
<body>
<div class="header center pr f18">
  蜗牛
  <div class="map_small f14 pa">
    <a href="{:U('Woniu/moreFriends')}"><img src="__IMG__/map_small.jpg">地图</a>
  </div>      
</div>

<div class="container">
    <div class="land_b map_title center  f14">
       <a href="{:U('Woniu/index')}">好友</a>
       <a href="javascript:void(0);" class="land_cut">正在聊天</a>
       <a href="{:U('Woniu/message')}">通知消息</a>
    </div>
    <div class="land_c">
      <div class="snail_f">
        <volist name="members" id="vo">
          <a href="#" class="chat_friends" data-targetid="{$vo.id}" data-targettoken="{$vo.rongyun_token}" style="display:block" data-targethead="{$vo.head}" data-nickname="{$vo.nickname}">
              <div class="fans_list f0 pr" style="padding-left:8px;padding-right:8px;">
                 <div class="fans_a vertical"><img src="{$vo.head}"></div>
                 <div class="fans_b vertical">
                       <div class="fans_b1 snail_w100 pr f18">{$vo.nickname}
                           <div class="fans_c f14 pa">5分钟之内</div>
                       </div> 
                       <div class="fans_b2 f14">{$vo.info}</div> 
                 </div>
              </div>
          </a>
        </volist>
      </div>
    </div>
    <div style="height:2rem"></div>   
</div>

<include file="Public:foot" />
