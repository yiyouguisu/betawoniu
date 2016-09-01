<include file="Public:head" />
<body>
<div class="header center pr f18">
      我发布的活动
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa"><a id='all'>全选</a></div>
</div>


<div class="container">
	<div class="land">
		<volist name='data' id='vo'>
			<div class="land_c f14">
	        	<div class="land_d f0">
	            	<div class="fish-a fl">
	            		<input type="checkbox" id="sec-{$vo.id}" value="{$vo.id}" class="chk_1"><label for="sec-{$vo.id}"></label>
	            	</div>
	            	<div class="fish-b pr fr">
	                	<div class="land_e vertical"><img src="{$vo.thumb}"></div>
	                	<div class="land_f vertical">
	                      	<div class="land_f1 f16">{$vo.title}</div>
	                      	<div class="land_f2 f13">
	                          	<div class="land_money f20"><i>报名费：</i><em>￥</em>{$vo.money}
	                          	</div>
	                      	</div>
	                      	<div class="land_f3 fish_c pa f0">
								<if condition='$vo.status eq 1'>
									<div class="land_f4 my_tra1 vertical"><span class="my_span">审核中</span></div>
								<elseif condition="$vo['endtime'] gt NOW_TIME"/>
									<div class="land_f4 my_tra1 vertical"><span class="my_span1">进行中</span></div>
								<else />
									<div class="land_f4 my_tra1 vertical"><span>已结束</span></div>
								</if>
	                      	</div>
	                	</div>
	            	</div>      
	        	</div>  
			</div>
		</volist>
      
      <div class="fish_btm">
           <div class="fish_t center"><div class="fish_t1 fish_wt"><span></span><img src="__IMG__/drop.jpg"></div></div>
           <div class="fish_s">
                   <div class="fish_list">
                       <div class="snail_d center f16">
                            <a class="snail_cut">删除</a>
                       </div>
                   </div>    
 <!--                   <div class="fish_list">    
                       <div class="snail_d center f16">
                            <a href="" class="snail_cut">编辑</a>
                       </div>
                   </div>  -->   
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
	$('#all').click(function(){
		$(":checkbox").attr("checked", true);
	});
	var snail_cut=$('.snail_cut');
	snail_cut.click(function(){
		var text='';
		$("input:checkbox").each(function(){
			if($(this).attr("checked")=='checked'){
				text+=$(this).val()+',';
			}
		});
		text=text.substr(0,text.length-1);
		console.log(text);
		var data={'id':text};
		$.post("{:U('Web/Member/editmyact')}",data,function(res){
			console.log(res);
			if(res.code==200){
				alert(res.msg);
				window.location.href="{:U('Web/Member/index')}"
			}
			else{
				alert(res.msg);
			}
		});
	});
});

</script>
</body>

</html>