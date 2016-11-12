<include file="Public:head" />
<script src="__JS__/Action.js"></script>
<body>
<div class="header center pr f18">
      我的游记
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa">编辑</div>
</div>

<!-- http://192.168.2.107/index.php/Web/Note/show/id/95.html -->
<div class="container">
	<div class="land">
		<div class="land_c f14">
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
								<div class="time">{$vo.inputtime|date='Y-m-d',###}</div>
								<div class="bottom">
									<div class="land_f4 my_tra1 vertical">
										<if condition="$vo.status eq 1">
											<span class="my_span">未审核</span>
										<else/>
											<span>已审核</span>
										</if>
									</div>
									<div class="land_h my_tra2  tnt_btm vertical">
										<div class="land_h2 f11 vertical">
											<img src="__IMG__/land_d4.png">
											<span>{$vo.hit}</span>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</a>
				</div>
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
                     <a class="snail_edit">编辑</a>
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

		//编辑
		$('.snail_edit').click(function(){
			DoEdit();
		})
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
		$.post("{:U('Web/Member/deletemynote')}",data,function(res){
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

	//编辑
	var DoEdit = function(){
		var selector = '.chk_1';
		var checkedItem = "";
		var count = 0;
		$(selector).each(function(){
			if($(this).attr("checked")=='checked'){
				checkedItem= $(this).val();
				count ++;
			}
		});
		if(count == 0){
			layer.open({content: '请至少选中一条游记！',skin: 'msg',time: 2 });
  			return ;
		}
		if(count > 1){
			layer.open({content: '最多只能选中一条游记进行编辑！',skin: 'msg',time: 2 });
  			return ;
		}
		var url="{:U('Web/Note/edit')}";
		url=url.substr(0,url.length-5);
		url=url+'/id/'+checkedItem+'.html';
		window.location.href=url;
	}
</script>
<include file="Public:foot" />