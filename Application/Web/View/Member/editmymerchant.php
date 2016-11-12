<include file="public:head" />
<body>
<div class="header center pr f18">
      我发布的民宿
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
      <div class="head_click tra_head pa"><a id="all">全选</a></div>
</div>


<div class="container">
	<div class="land">
		<div class="land_c f14">
			<volist name='data' id='vo'>
				<div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="sec-{$vo.id}" value="{$vo.id}" class="chk_1"><label for="sec-{$vo.id}"></label>
					</div>

					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">
								<div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
								</div>
							</div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 my_tra1 vertical"><span class="my_span1">进行中</span></div>
							</div>
						</div>
					</div>      
				</div>
			</volist>
		</div>
		<div class="fish_btm">
			<div class="fish_t center">
				<div class="fish_t1 fish_wt">
					<span></span><img src="__IMG__/drop.jpg">
				</div>
			</div>
			<div class="fish_s">
				<div class="fish_list">    
					<div class="snail_d center f16">
						<a class="snail_cut del">下架</a>
					</div>
				</div>    
				<div class="fish_list">    
					<div class="snail_d center f16">
						<a href="" class="omg_ccc">取消</a>
					</div>
				</div>
			</div>       
		</div>
	</div>	   	
</div>
<script type="text/javascript">
$(function(){
	var del=$('.del');
	del.click(function(){
		var text='';
		$("input:checkbox").each(function(){
			if($(this).attr("checked")=='checked'){
				text+=$(this).val()+',';
			}
		});
		text=text.substr(0,text.length-1);
		console.log(text);
		var data={'id':text};
		console.log(data);
		$.post("{:U('Web/Member/editmymerchant')}",data,function(res){
			if(res.code==200){
				console.log(data.id);
				var array=data.id.split(',');
				// 去空值
				for(var i = 0; i < array.length; i++) {
					if(array[i].length == 0) array.splice(i,1);
				}
				for (var i = 0; i<array.length; i++) {
					console.log(array[i]);
					var div=$('#sec-'+array[i]).parent().parent();
					div.remove();
				}
			}
		});
	});



	$('#all').click(function(){
		$(":checkbox").attr("checked", true);
	});
})
</script>
</body>

</html>