<include file="Public:head" />
<body>
<div class="header center pr f18">
      我的收藏
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa"><a id='all'>全选</a></div>
</div>


<div class="container">
	<div class="land">
		<div class="land_b map_title center  f14">
			<a class="a_title">游记</a>
			<a class="a_title" >美宿</a>
			<a class="a_title" >活动</a>
		</div>
   
		<div class="land_c f14 collect" style='display:none'>
			<volist name='note' id='vo'>
				<div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="n-{$vo.id}" value="n-{$vo.id}" class="chk_1"><label for="n-{$vo.id}"></label>
					</div>
					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">{$vo.inputtime|date='Y-m-d',###}</div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 vertical">
									<img src="{$vo.head}">
								</div>
								<div class="land_h tra_wc vertical">
									<div class="land_h1 f11 vertical">
										<img src="__IMG__/land_d3.png">
									<span>{$vo.reviewnum}</span>条评论
									</div>
									<div class="land_h2 f11 vertical">
										<img src="__IMG__/land_d4.png">
										<span>{$vo.hit}</span>
									</div>
								</div>
							</div>
						</div>
					</div>      
				</div>
			</volist>       
		</div>

		<div class="land_c f14 collect" style='display:none'>
			<volist name='houselist' id='vo'>
				<div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="h-{$vo.id}" value="h-{$vo.id}" class="chk_1"><label for="h-{$vo.id}"></label>
					</div>
					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">{$vo.inputtime|date='Y-m-d',###}</div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 vertical">
									<img src="{$vo.head}">
								</div>
								<div class="land_h tra_wc vertical">
									<div class="land_h1 f11 vertical">
										<img src="__IMG__/land_d3.png">
									<span>{$vo.reviewnum}</span>条评论
									</div>
									<div class="land_h2 f11 vertical">
										<img src="__IMG__/land_d4.png">
										<span>{$vo.hit}</span>
									</div>
								</div>
							</div>
						</div>
					</div>      
				</div>
			</volist>       
		</div>

		<div class="land_c f14 collect" style='display:none'>
			<volist name='party' id='vo'>
				<div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="p-{$vo.id}" value="p-{$vo.id}" class="chk_1"><label for="p-{$vo.id}"></label>
					</div>
					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">{$vo.inputtime|date='Y-m-d',###}</div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 vertical">
									<img src="{$vo.head}">
								</div>
								<div class="land_h tra_wc vertical">
									<div class="land_h1 f11 vertical">
										<img src="__IMG__/land_d3.png">
									<span>{$vo.reviewnum}</span>条评论
									</div>
									<div class="land_h2 f11 vertical">
										<img src="__IMG__/land_d4.png">
										<span>{$vo.hit}</span>
									</div>
								</div>
							</div>
						</div>
					</div>      
				</div>
			</volist>       
		</div>
      
      <div class="fish_btm">
           <div class="fish_t center"><div class="fish_t1 fish_wt"><span></span><img src="__IMG__/drop.jpg"></div></div>
           <div class="fish_s">
                   <div class="fish_list">
                       <div class="snail_d woc_height center f16">
                            <a class="snail_cut">删除</a>
                       </div>
                   </div>    
                    
                   <div class="fish_list">    
                       <div class="snail_d woc_height center f16">
                            <a href="{:U('Web/Member/collect')}" class="omg_ccc">取消</a>
                       </div>
                   </div>
            </div>       
      </div>
   </div>	   	
</div>
<script type="text/javascript">
	$(function(){
		var collect=$('.collect');
		var a_title=$('.a_title');
		a_title.eq(0).addClass('land_cut');
		collect.eq(0).show();
		a_title.click(function(){
			a_title.removeClass('land_cut');
			collect.hide();
			var a=$(this).index();
			a_title.eq(a).addClass('land_cut');
			collect.eq(a).show();
		});
		var snail_cut=$('.snail_cut');
		var date=
		snail_cut.click(function(){
			var text='';
			$("input:checkbox").each(function(){
				if($(this).attr("checked")=='checked'){
					text+=$(this).val()+'|';
				}
			});
			console.log(text);
			var data={'id':text};
			$.post("{:U('Web/Member/editcollect')}",data,function(res){
				console.log(res);
				if(res.code==200){
					alert(res.msg);
					console.log();
					var array=data.id.split('|');
				    for(var i = 0; i < array.length; i++) {
				        if(array[i].length == 0) array.splice(i,1);
				    }
				    for (var i = 0; i<array.length; i++) {
				    	console.log(array[i]);
				    	var div=$('#'+array[i]).parent().parent();
				    	div.remove();
				    }
				}
				else{
					alert(res.msg);
				}
			});
		});
		$('#all').click(function(){
			$(":checkbox").attr("checked", true);
		});
	});
</script>
</body>

</html>