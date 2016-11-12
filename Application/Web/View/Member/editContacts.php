<include file="public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      添加入住人
       <div class="head_go pa"><a href="javascript:history.back()" ><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container">
   <div class="land">
        <div class="act_c">
              <form action="{:U('Web/Member/editContacts')}" method="post" id='form'>
                <div class="lu_b">
                  <input type="text" name='realname' class="lu_text" placeholder="真实姓名 :" value="{$data.realname}">
                </div>
                <div class="lu_b">
                  <input type="text" name="phone" class="lu_text" placeholder="手机号码 :" value="{$data.phone}">
                </div>
                <div class="lu_b">
                  <input type="text" name="idcard" class="lu_text" placeholder="身份证号码 :" value="{$data.idcard}">
                </div>
                <div class="snail_d center trip_btn f16">
                  <input type='hidden' name='url' value='{$data.url}'/>
                  <input type='hidden' name='id' value="{$id}">
                <a class="snail_cut jk_click">编辑</a>
                </div>
              </form>

        </div>
   </div>
</div>
<script type="text/javascript">
  $(function(){
    $('.snail_cut').click(function(){
      var realname=$("input[name='realname']").val();
      var phone=$("input[name='phone']").val();
      var idcard=$("input[name='icard']").val();
      if(realname==''){
          alert("姓名不能为空！");
          $("input[name='realname']").focus();
          return false;
      }
      if(idcard=='' || idcard.length != 18){
          alert("请输入18位有效身份证号！");
          $("input[name='icard']").focus();
          return false;
      }
      if(phone==''){
        alert("手机号码不能为空！");
        $("input[name='phone']").focus();
        return false;
      }
      if (phone.length != 11) {
        alert("请输入11位有效手机号！");
        $("input[name='phone']").focus();
        return false;
      } 
      $('#form').submit();
    })
  })
</script>
</body>

</html>
