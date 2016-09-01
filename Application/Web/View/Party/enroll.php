<include file="public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      参加活动
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container">
   <div class="land">
      <form action="{:U('Web/Order/joinparty')}" method="post" id='form'>
        <div class="act_c">
               <div class="lu_b">
                         <input type="text" class="lu_text" placeholder="真实姓名 :">
               </div>
               <div class="lu_b">
                         <input type="text" class="lu_text" placeholder="电话号码 :">
               </div>
               <div class="lu_b">
                         <input type="text" class="lu_text" placeholder="身份证号码 :">
               </div>
               <div class="lu_b">
                         <input type="text" class="lu_text" placeholder="参与人数 :">
               </div>
               <div class="snail_d center trip_btn f16">
                            <a class="snail_cut jk_click sub">立即参加</a>
               </div>

        </div>
      </form>
   </div>
</div>
<script type="text/javascript">
$('.sub').click(function(){
  $('#form').submit();
})
</script>
</body>

</html>