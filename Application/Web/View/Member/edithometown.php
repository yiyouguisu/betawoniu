<include file="Public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      修改故乡
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
</div>

<div class="container">
	<div class="hm">
		<form id='form' action="{:U('Web/Member/edithometown')}" method="post">
			<div class="det_list">
				<div class="det_a fl">省 :</div>
				<div class="det_b fr">
					<select name='province' class="xuex_select province">
						<option value="0">--请选择--</option>
						<volist name='province' id='vo'>
							<option value='{$vo.id}'>{$vo.name}</option>
						</volist>
					</select>
				</div>
			</div>
			<div class="det_list">
				<div class="det_a fl">市 :</div>
				<div class="det_b fr">
					<select name='city' class="xuex_select city">
					</select>
				</div>
			</div>
			<div class="det_list countydiv" style='display:none'>
				<div class="det_a fl">县:</div>
				<div class="det_b fr">
					<select name='county' class="xuex_select county">
					</select>
				</div>
			</div>

			<div class="set_c" style="margin:-1rem 0 0">
				<div class="snail_d center trip_btn f16">
					<a id='sub' class="snail_cut ">修改</a>
				</div>
			</div>
	    </form>
    </div>   
 
</div>
<script type="text/javascript">
	$(function(){
		// 市
		var city=$('.city');
		$('.province').change(function(){
			var data={'city':$(this).val()}
			$.post("{:U('Web/Member/getcity')}",data,function(res){
				if(res.code==200){
					city.empty();
					var option='<option value="0">--请选择--</option>';
					$.each(res.data,function(index,value){
						option+="<option value="+value.id+">"+value.name+"</option>"
					});
					city.append(option);
				}
			});
		});
		// 县
		var countydiv=$('.countydiv');
		var county=$('.county');
		$('.city').change(function(){
			var data={'city':$(this).val()}
			$.post("{:U('Web/Member/getcity')}",data,function(res){
				console.log(res);
				if(res.code==200){
					county.empty();
					countydiv.show();
					var option='<option value="0">--请选择--</option>';
					$.each(res.data,function(index,value){
						option+="<option value="+value.id+">"+value.name+"</option>"
					});
					county.append(option);
				}
				else{
					countydiv.hide();
				}
			});
		});

		$('#sub').click(function(){
			$('#form').submit();
		});
	})
</script>
</body>