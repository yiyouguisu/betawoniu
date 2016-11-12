<include file="Public:head" />
<body>
<div class="header center pr f18">
      我的游记
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa"><a id='all'>全选</a></div>
</div>


<div class="container">
	<div class="land">
		<volist name='data' id='vo'>
			<div class="land_c f14">
				<div class="land_d f0">
					<div class="fish-check fl">
						<input type="checkbox" id="sec-{$vo.nid}" value="{$vo.nid}" class="chk_1"><label for="sec-{$vo.nid}"></label>
					</div>
					<div class="fish-b pr fr">
						<div class="land_e vertical"><img src="{$vo.thumb}"></div>
						<div class="land_f vertical">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">{$vo.inputtime|date='Y-m-d',###}</div>
							<div class="land_f3 fish_c pa f0">
								<div class="land_f4 my_tra1 vertical"><span class="my_span">未审核</span></div>
							</div>
						</div>
					</div>      
				</div>    
			</div>
		</volist>
		



		<div class="fish_btm">
			<div class="fish_t center">
				<div onclick="history.go(-1)" class="fish_t1 fish_wt">
					<span></span><img src="__IMG__/drop.jpg">
				</div>
			</div>
			<div class="fish_s">
				<div class="fish_list">
                	<div class="snail_d woc_height center f16 del">
                    	<a class="snail_cut">删除</a>
                	</div>
            	</div>    
            	<div class="fish_list">    
                	<div class="snail_d woc_height center f16 edit">
                    	<a class="snail_cut">编辑</a>
                	</div>
            	</div>    
            	<div class="fish_list">    
                	<div class="snail_d woc_height center f16">
                        <a onclick="history.go(-1)" class="omg_ccc">取消</a>
					</div>
				</div>
            </div>       
		</div>
	</div>	   	
</div>
<script type="text/javascript">
	$(function(){
		// 删除我的游记
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
			$.post("{:U('Web/Member/editmynote')}",data,function(res){
				console.log(res);
				if(res.code==200){
					alert(res.msg);
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
				else{
					alert(res.msg);
				}
			});
		});
		// 编辑我的游记
		var edit=$('.edit');
		edit.click(function(){
			var text='';
			$("input:checkbox").each(function(){
				if($(this).attr("checked")=='checked'){
					text+=$(this).val()+',';
				}
			});
			text=text.substr(0,text.length-1);
			var url="{:U('Web/Member/editnoteinfo')}";
			url=url.substr(0,url.length-5);
			url=url+'/id/'+text+'.html';
			window.location.href=url;
		})
		// 全选
		$('#all').click(function(){
			$(":checkbox").attr("checked", true);
		});
		// 判断加个checkbox被选中
		var chk_1=$('.chk_1');
		chk_1.click(function(){
			var checked=$("input[type='checkbox']:checked").length;
			if(checked>1){
				$('.edit').hide();
			}
			else{
				$('.edit').show();
			}
		})
	});
</script>
</body>

</html>