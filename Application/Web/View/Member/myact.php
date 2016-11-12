<include file="Public:head" />
<body>
<div class="header center pr f18">
      我发布的活动
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa">编辑</div>
</div>


<div class="container">
	<div class="land">
		<div class="land_b map_title center  f14">
			<a class="all ">全部</a>
			<a class="all " >进行中</a>
			<a class="all ">已结束</a>
		</div>
		<!-- 全部 -->
		<div class="land_c f14 show_div" style='display:none'>
			<volist name='data' id='vo'>
				<div>
					<div class="fish-check fl disnone">
						<input type="checkbox" id="{$vo.id}" value="{$vo.id}" class="chk_1 chk_p"><label for="{$vo.id}"></label>
					</div>
					<a href="{:U('Web/Note/show',array('id'=>$vo['id']))}">
						<div class="list-item">
							<div class="list-item-left-img"><img src="{$vo.thumb}"></div>
							<div class="list-item-right-content">
								<div class="title">{$vo.title}</div>
								<div>
									<div class="money"><i>报名费：</i><em>￥</em>{$vo.money}<span>起</span>
									</div>
								</div>
								<div class="bottom">
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
					</a>
				</div>       					
			</volist>
		</div>
		<!-- 进行中 -->
		<div class="land_c f14 show_div" style='display:none'>
			<volist name='data' id='vo'>
				<if condition="($vo['endtime'] gt NOW_TIME) AND ($vo.status eq 1)">
					<div>
					<div class="fish-check fl disnone">
						<input type="checkbox" id="{$vo.id}" value="{$vo.id}" class="chk_1 chk_p"><label for="{$vo.id}"></label>
					</div>
					<a href="{:U('Web/Note/show',array('id'=>$vo['id']))}">
						<div class="list-item">
							<div class="list-item-left-img"><img src="{$vo.thumb}"></div>
							<div class="list-item-right-content">
								<div class="title">{$vo.title}</div>
								<div>
									<div class="money"><i>报名费：</i><em>￥</em>{$vo.money}<span>起</span>
									</div>
								</div>
								<div class="bottom">
									<div class="land_f4 my_tra1 vertical"><span class="my_span1">进行中</span></div>	
								</div>
							</div>
						</div>	
					</a>
				</div> 
				</if>     					
			</volist>
		</div>
		<!-- 结束 -->
		<div class="land_c f14 show_div" style='display:none'>
			<volist name='data' id='vo'>
				<if condition="$vo['endtime'] lt NOW_TIME">
					<div>
					<div class="fish-check fl disnone">
						<input type="checkbox" id="{$vo.id}" value="{$vo.id}" class="chk_1 chk_p"><label for="{$vo.id}"></label>
					</div>
					<a href="{:U('Web/Note/show',array('id'=>$vo['id']))}">
						<div class="list-item">
							<div class="list-item-left-img"><img src="{$vo.thumb}"></div>
							<div class="list-item-right-content">
								<div class="title">{$vo.title}</div>
								<div>
									<div class="money"><i>报名费：</i><em>￥</em>{$vo.money}<span>起</span>
									</div>
								</div>
								<div class="bottom">
									<div class="land_f4 my_tra1 vertical"><span>已结束</span></div>	
								</div>
							</div>
						</div>	
					</a>
				</div>
				</if>			
			</volist>
		</div>
	</div>
	<div class="fish_btm disnone">
     	<div class="fish_t center"><div class="fish_t1 fish_wt"><span></span><img src="__IMG__/drop.jpg"></div></div>
     	<div class="fish_s">
            <div class="fish_list">
                <div class="snail_d woc_height center f16">
                     <a class="snail_cut">删除</a>
                </div>
            </div>  
            <div class="fish_list">    
                <div class="snail_d woc_height center f16">
                     <a class="omg_ccc">取消</a>
                </div>
            </div>
     	</div>       
 	</div>	   	
</div>
<script type="text/javascript">
	var isEdit = 1;  //1代表当前是编辑按钮   2代表不是编辑按钮
	var isAllCheck = 1; //1代表全选  2代表取消全选
$(function(){
	var all=$('.all');
	var show=$('.show_div');
	all.eq(0).addClass('land_cut');
	show.eq(0).show();
	all.click(function(){
		all.removeClass('land_cut');
		show.hide();
		all.eq($(this).index()).addClass('land_cut');
		show.eq($(this).index()).show();
	});

	//点击编辑或者全选/不全选按钮
	$('.head_click').click(function(){
		if(isEdit == 1){
			ChangeToSureStatus();
		}else{
			SwitchAllCheck();
		}
	});

	//删除
	$('.snail_cut').click(function(){
		DoDelete();
	});

	//点击取消，还原成编辑状态
	$('.omg_ccc').click(function(){
		ChangeToEditStatus();
	});	
});
	//还原成编辑状态
	var ChangeToEditStatus = function(){
		isEdit = 1;
		$('.head_click').html("编辑");
		$('.fish-check').addClass('disnone');
		$('.fish_btm').addClass('disnone');

		var selector = '.chk_1';
		$(selector).attr("checked", false);
		isAllCheck = 1;
	}

	//变为全选/非全选状态
	var ChangeToSureStatus = function(){
		isEdit = 2;
		isAllCheck = 1;
		$('.head_click').html("全选");
		$('.fish-check').removeClass('disnone');
		$('.fish_btm').removeClass('disnone');
	}

	//全选非全选切换
	var SwitchAllCheck = function(){
		var selector = '.chk_1';
		if(isAllCheck == 1){
			$('.head_click').html("不全选");
			isAllCheck = 2;
			$(selector).attr("checked", true);
		}else{
			$('.head_click').html("全选");
			isAllCheck = 1;
			$(selector).attr("checked", false);
		}
	}

	//删除
	var DoDelete = function(){
		var selector = '.chk_1';
		var text = "";
		$(selector).each(function(){
			if($(this).attr("checked")=='checked'){
				text+=$(this).val()+'|';
			}
		});
		if(text == ""){
			layer.open({
    			content: '请至少选中一条数据！'
    			,skin: 'msg'
    			,time: 2 //2秒后自动关闭
  			});
  			return ;
		}
		var data={'id':text};
		$.showLoading("正在修改...");
		$.post("{:U('Web/Member/deletemyact')}",data,function(res){
			console.log(res);
			$.hideLoading();
			if(res.code==200){
				console.log();
				var array=data.id.split('|');
			    for(var i = 0; i < array.length; i++) {
			        if(array[i].length == 0) array.splice(i,1);
			    }
			    for (var i = 0; i<array.length; i++) {
			    	console.log(array[i]);
			    	var selector='#'+array[i];
			    	$(selector).parent().parent().remove();
			    }
			    ChangeToEditStatus();
			}
			else{
				alert(res.msg);
			}
		});
	}

</script>
</body>

</html>