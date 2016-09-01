<include file="Public:head" />
<body>
<div class="header center pr f18">
      我的粉丝
      <div class="head_go pa"><a href="javascript:history.go(-1);"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container">
   <div class="land">

          <div class="land_btm">
                  <div class="land_b person_title center f16">
                  	   <a class="fhead ">我的粉丝（{$fans}）</a>
                  	   <a class="fhead">我的关注（{$follow}）</a>
                  </div>
                  <div class="land_c f14" style="display:none">
                        <volist name='list["fansArray"]' id='vo'>
                          <a href="{:U('Web/Member/memberHome',array('id'=>$vo['id']))}">
                            <div class="fans_list">
                              <div class="fans_a vertical"><img src="{$vo.head}"></div>
                              <div class="fans_b vertical">
                                <div class="ggo_pr f16">{$vo.nickname}
                                  <div class="ggo_pa f14">{$vo.area}</div>
                                </div> 
                                <div class="fans_b2 f14">{$vo.info|default='对方好懒，什么都木有留下。。。'}</div> 
                              </div>
                            </div>
                          </a>
                        </volist>
                  </div>
                  <div class="land_c f14" style="display:none">
                        <volist name='list["followArray"]' id='vo'>
                          <a href="{:U('Web/Member/memberHome',array('id'=>$vo['id']))}">
                            <div class="fans_list">
                              <div class="fans_a vertical"><img src="{$vo.head}"></div>
                              <div class="fans_b vertical">
                                <div class="ggo_pr f16">{$vo.nickname}
                                  <div class="ggo_pa f14">{$vo.area}</div>
                                </div> 
                                <div class="fans_b2 f14">{$vo.info|default='对方好懒，什么都木有留下。。。'}</div> 
                              </div>
                            </div>
                          </a>
                        </volist>
                  </div>
          </div>	
   </div>	   	
</div>
<script type="text/javascript">
$(function(){
  $('.fhead').eq(0).addClass('land_cut');
  $('.land_c').eq(0).show();
  $('.fhead').click(function(){
    $('.fhead').removeClass('land_cut');
    $('.land_c').hide();
    $('.fhead').eq($(this).index()).addClass('land_cut');
    $('.land_c').eq($(this).index()).show();
  })
})

</script>
</body>
</html>