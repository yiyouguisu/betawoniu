<include file="Public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      修改性别
      <div class="head_go pa"><a href=""><img src="__IMG__/go.jpg"></a></div>
</div>

<div class="container">
	<form id='form' action="{:U('Web/Member/editsex')}" method="post">
		<div class="hm">
			<div class="dress_title f18">性别</div>
			<div class="dress_b  hm_ff hm_click2 center f16">
				<ul>
					<li class='sex <if condition="$sex eq 1">hm_cut</if>' data-id='1'>男</li>
					<li class='sex <if condition="$sex eq 2">hm_cut</if>' data-id='2'>女</li>  
				</ul>
			</div>
			<input type='hidden' name='sex' id='sex' >
			<div class="set_c" style="margin:-1rem 2.5% 0">
				<div class="snail_d center trip_btn f16">
					<a id='sub' class="snail_cut ">修改</a>
				</div>
			</div>
		</div>
    </form>   
 
</div>
<script type="text/javascript">
	$(function(){
		var sub=$('#sub');
		sub.click(function(){
			$('#form').submit();
		});
		$('.sex').click(function(){
			$('#sex').val($(this).data('id'));
		});
	})
</script>
</body>

</html>
