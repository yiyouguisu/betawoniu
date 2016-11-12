<include file="public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      添加入住人
       <div class="head_go pa"><a href="javascript:history.back();"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>
<div class="container">
   <div class="land">
     <div class="act_c">
       <div class="lu_b">
          <input type="text" name="name" class="lu_text" placeholder="真实姓名 :">
       </div>
       <div class="lu_b">
          <input type="text" name="phone" class="lu_text" placeholder="手机号码 :">
       </div>
       <div class="lu_b">
          <input type="text" name='icard' class="lu_text" placeholder="身份证号码 :">
       </div>
       <div class="snail_d homen_style center f16">
          <a href="javescript:;" class="common_click">选择常用人信息</a>
       </div>
       <div class="snail_d center trip_btn f16">
          <a class="snail_cut jk_click">添加</a>
       </div>
     </div>
   </div>
</div>
<div class="big_mask"></div>
<div class="common_mask">
    <div class="pyl_top pr">常用人信息
        <div class="pyl_close pa"><img src="__IMG__/close.jpg"></div>
    </div>
    
    <div class="common_mid">
           <div class="name_box bianj_child">
                  <volist name='data["people"]' id='vo'>
                      <div class="name_list">
                         <div class="name_text">{$vo.realname}</div>
                         <input type="hidden" id="phone" value="{$vo.phone}"/>
                         <input type="hidden" id="idcard" value="{$vo.idcard}"/>
                         <input type="hidden" id="realname" value="{$vo.realname}"/>
                         <input type="hidden" id="cid" value="{$vo.id}"/>
                         <div class="name_a">
                               <input type="button" class="name_btn" onclick= "window.location.href='{:U("Web/Member/editContacts",array("id"=>$vo["id"],"url"=>$data["url"]))}'" value="编辑">
                               <input type="button" class="name_btn delc" data-id="{$vo.id}" value="删除">
                         </div>
                      </div>
                  </volist>
          </div>
          
          <div class="snail_d homen_href center f16">
            <a href="{:U('Web/Member/editContacts',array('url'=>$data['url']))}">添加常用人信息</a>
          </div>
          
          <div class="snail_d homen_style center f16">
                   <a class='subadd' >确定添加</a>
          </div>
    </div>
</div>
<script src="__JS__/jquery-1.11.1.min.js"></script>
<script src="__JS__/Action.js"></script>
<script>
$(function(){
   $(".common_click").click(function(){
       $(".big_mask,.common_mask").show()
   })

})

$(function(){
   $(".bianj_child .name_list").click(function(){
       $(this).addClass("name_cut").siblings().removeClass("name_cut") 
   })
})

$(function(){
  $('pa').click(function(){
    $(".big_mask,.common_mask").hide()
  })
  $('.delc').click(function(){
    var self=$(this);
    var dataId={'id':$(this).data('id')}
    console.log(dataId);
    $.post("{:U('Web/Member/delContacts')}",dataId,function(res){
      if(res.code==200){
        self.parent().parent().remove();
      }
    });
  })


})
// $("input[name$='letter']") 
var data={};
$('.name_list').click(function(){
  data['phone']=$(this).find("#phone").val();
  data['idcard']=$(this).find("#idcard").val();
  data['realname']=$(this).find("#realname").val();
  data['id']=$(this).find("#cid").val();
})
$('.subadd').click(function(){
  console.log(data);
  data['url']="{$data.url}";
  data['id']
  $.post("{:U('Web/Member/addContacts')}",data,function(res){
    window.location.href=res;
  })
})
$('.jk_click').click(function(evt){
  evt.preventDefault();
  data['phone']=$("input[name='phone']").val();
  data['realname']=$("input[name='name']").val();
  data['idcard']=$("input[name='icard']").val();
  if(data['realname']==''){
      alert("姓名不能为空！");
      $("input[name='realname']").focus();
      return false;
  }
  if(data['idcard']=='' || data['idcard'].length != 18){
      alert("请正确填写18位身份证号！");
      $("input[name='icard']").focus();
      return false;
  }
  if(data['phone']==''){
    alert("手机号码不能为空！");
    $("input[name='phone']").focus();
    return false;
  }
  if (data['phone'].length != 11) {
    alert("请正确填写11位手机号码！");
    $("input[name='phone']").focus();
    return false;
  } 

  data['url']="{$data.url}";
  $.post("{:U('Web/Member/addPeople')}",data,function(res){
    if(res.code==500){
      alert('联系人已存在，请从常用联系人中添加');
    } else {
      self.location = document.referrer;
    }
  });
});
</script>
</body>
</html>
