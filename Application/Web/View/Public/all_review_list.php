<include file="Public:head" />
<div class="header center pr ft18 fix-head">
  评论（<em class="ft18">{$count}</em>）
  <div class="head_go pa">
    <a href="javascript:history.go(-1);">
      <img src="__IMG__/go.jpg">
    </a>
  </div>
</div>
<div class="container" style="margin-top:6rem">
  <div class="land">
    <volist name="data" id="vo">
      <div class="land_btm">
        <div class="land_c f14">
          <div class="fans_list" style="padding:1rem 0">
            <div class="fl">
              <img src="{$vo.head}" style="width:50px;height:50px;border-radius:50%;vertical-align:middle">
            </div>
            <div class="fans_b fl" style="margin-left:3%">
              <div class="fans_b1 f16" style="margin-top:0">{$vo.nickname}</div> 
              <div class="fans_b2 f14">
                {$vo.content}
              </div> 
              <div class="fans_time f13">2015-5-18</div>
            </div>
          </div>
        </div>
      </div>
    </volist>
    <!--
    <div class="snail_d center trip_btn f16" style="margin:2rem 2.5%  2rem">
      <a href="person-3.html" class="snail_cut jk_click">添加评论</a>
    </div>
    -->
  </div>     
</div>
</body>
</html>
