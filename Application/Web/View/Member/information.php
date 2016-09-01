<include file="Public:head" />
<body class="back_blue">
<div class="header center pr f18">
      完善信息
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
</div>

<div class="container">
	<div class="login_box">
		<form  id='form' action="{:U('Web/Member/information')}" method="post">
			<div class="login_top">
				<div class="login_list">
					<div class="login_a">
						<input type="text" class="login_text f14" placeholder="输入昵称 :" name='nickname' >
					</div>
				</div>  
				<div class="sex">
					<div class="sex_a f16">选择性别 :</div>
					<div class="sex_b">
						<a class="fl rsex" data-id='1'>男</a>
						<a class="fr rsex" data-id='2'>女</a>
						<input type="hidden" class="determine" name='sex' value=""/>
					</div>	
				</div> 

			</div>
			<div class="login_b f16"><a class="sub">进入首页</a></div>
		</form>
	</div>	         	
</div>
<script type="text/javascript">
$(function(){
	var rsex=$('.rsex');
	rsex.click(function(){
		rsex.removeClass('active');
		console.log($(this).data('id'));
		$('.determine').val($(this).data('id'));
		$(this).addClass('active');
	})
	$('.sub').click(function(){
		$('#form').submit();
	})
})

</script>
</body>

</html>