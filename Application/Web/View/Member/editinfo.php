<include file="Public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      修改个性标签
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
</div>

<div class="container">
	<div class="hm">
		<form id='form' action="{:U('Web/Member/editinfo')}" method="post">
	    	<div class="act_c">
				<div class="ws_list">
					<input name='info' type="text" class="ws_text"  placeholder="{$info} ">      
				</div>
				<div class="set_c" style="margin:-1rem 0 0">
					<div class="snail_d center trip_btn f16">
						<a id='sub' class="snail_cut ">修改</a>
					</div>
				</div>
	    	</div>
	    </form>
    </div>   
 
</div>
<script type="text/javascript">
	$(function(){
		$('#sub').click(function(){
			$('#form').submit();
		});
	})
</script>
</body>

</html>
