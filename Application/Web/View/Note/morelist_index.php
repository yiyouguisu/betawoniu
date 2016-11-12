<volist name='note' id='vo'>
  
    <div class="land_d pr f0" style="padding:10px;">
      <div class="land_e vertical">
        <a href="{:U('Note/show')}?id={$vo.id}">
          <img src="{$vo.thumb|default='__IMG__/default.jpg'}" style="width:100px;height:90px;">
        </a>
      </div>
      <div class="land_f vertical" style="width:66%">
        <div class="land_f1 ft14">
          <a href="{:U('Note/show')}?id={$vo.id}" style="color: #000;">{:str_cut($vo['title'],8)}</a>
          </div>
        <div class="land_f2 ft10">{$vo.begintime|date='Y-m-d',###}</div>
        <div class="interv_font">
          <p class="over_ellipsis"><a href="{:U('Note/show')}?id={$vo.id}" style="color: #aaa;">{:str_cut($vo['description'],25)}</a></p>
        </div>
        <div class="land_f3 f0">
          <div class="land_f4 vertical">
            <img src="{$vo.head}" style="width:30px;height:30px;border-radius:30px;">
          </div>
          <div class="land_h tra_wc vertical">
            <div class="land_h1 f11 vertical">
              <img src="__IMG__/land_d3.png">
              <span>{$vo.reviewnum}</span>条评论
            </div>
            <div class="land_h2 f11 vertical ajax_addhid" style="width:16%;" data-id="{$vo.id}">
              <if condition="$vo.ishit eq 1">
                <img src="__IMG__/poin_1.png" style="width:12px">
              <else />
                <img src="__IMG__/poin.png">
              </if>
              <span class='hit'>{$vo.hit}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
</volist>
<script type="text/javascript">
$('.ajax_addhid').click(function(){
  var nid=$(this).attr('data-id');
  var abj=$(this).find('img');
  var hit=$(this).find('.hit');
    $.ajax({
            url:'{:U("Web/Note/ajax_hit")}',
            data:{nid:nid},
            type:'post',
            dataType:'json',
            success:function(data){
              if(parseInt(data.type)==1){
                abj.attr('src',"__IMG__/poin_1.png");
                var num=Number(hit.text()) + 1;
                hit.text(num);
              }else{
                abj.attr('src',"__IMG__/poin.png");
                var num=Number(hit.text()) - 1;
                hit.text(num);              
              }
            },
            error:function(){
                
            },
        })
})
</script>
