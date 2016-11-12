<include file="Public:head" />
<div class="header center pr f18">
      发表评论
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click pa"><a id='sub'>发送</a></div>
</div>


<div class="container">
   <div class="land">

          <div class="land_btm">
                  <div class="land_c f14">
                        <div class="per_f1 f16">说你想评的</div>
                        <div class="per_f2">
                              <textarea class="per_area"></textarea>
                              <input type='hidden' value='{$type}' id='type'>
                              <input type='hidden' value='{$id}' id='id'>
                        </div>
                  </div>
          </div>    

   </div>       
</div>
<script type="text/javascript">
$(function(){
  $('#sub').click(function(){
    var data={'content':$('.per_area').val(),'type':$('#type').val(),'id':$('#id').val()}
    console.log(data);
    $.post('{:U("Web/Review/send")}',data,function(res){
      if(res.code==200){
        alert(res.msg);
        var type={$type};
        if(type=0){
          window.location.href="{:U('Web/Note/show',array('id'=>$id))}"
        }
        else if(type=1){
          window.location.href="{:U('Web/Party/show',array('id'=>$id))}"
        }else{
          window.location.href="{:U('Web/Party/show',array('id'=>$id))}"
        }
      }
      else{
        alert(res.msg);
      }
    })
  })
})
</script>
</body>

</html>