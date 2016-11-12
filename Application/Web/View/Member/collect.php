<include file="Public:head" />
<div class="header center pr f18">
      我的收藏
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="head_click tra_head pa">编辑</div>
</div>
<div class="container">
   <div class="land">
       <div class="land_b map_title center  f14">
                       <a class="a_title" id="n">游记</a>
                       <a class="a_title" id="h">美宿</a>
                       <a class="a_title" id="p">活动</a>
       </div>

   		<!-- 游记 -->
		<div class="land_c f14 collect" style='display:none'>
			<volist name='note' id='vo'>
			<div>
				<div class="fish-check fl disnone">
						<input type="checkbox" id="n-{$vo.id}" value="{$vo.id}" class="chk_1 chk_n"><label for="n-{$vo.id}"></label>
					</div>
				<a href="{:U('Web/Note/show',array('id'=>$vo['nid']))}">
					<div class="land_d pr f0">
						<div class="left-img"><img src="{$vo.thumb}"></div>
						<div class="right-content">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">{$vo.inputtime|date='Y-m-d',###}</div>
							<div class="land_f1 land_f2 f13">{$vo.description}</div>
							<div class="land_f3 f0">
								<div class="land_f4 vertical head-left">
									<img  src="{$vo.head}">
								</div>
								<div class="land_h tra_wc vertical content-right">
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
				</a>
				</div>
			</volist>
		</div>
		<!-- 名宿 -->
		<div class="land_c f14 collect" style='display:none'>
			<volist name='houselist' id='vo'>
			<div>
			<div class="fish-check fl disnone">
						<input type="checkbox" id="h-{$vo.id}" value="{$vo.id}" class="chk_1 chk_h"><label for="h-{$vo.id}"></label>
					</div>
				<a href="{:U('Web/Hostel/show',array('id'=>$vo['hid']))}">
					<div class="land_d pr f0">
						<div class="left-img"><img src="{$vo.thumb}"></div>
						<div class="right-content">
							<div class="land_f1 f16">{$vo.title}</div>
							<div class="land_f2 f13">
								<div class="land_money f20"><em>￥</em>{$vo.money}<span>起</span>
								</div>
							</div>
							<div class="land_f3 f0">
								<div class="land_f4 vertical head-left">
									<img  src="{$vo.head}">
								</div>
								<div class="land_h tra_wc vertical content-right">
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
				</a>
				</div>
			</volist>
		</div>
		<!-- 活动 -->
		<div class="land_c f14 collect" style='display:none'>
			<volist name='party' id='vo'>
			<div>
			<div class="fish-check fl disnone">
						<input type="checkbox" id="p-{$vo.id}" value="{$vo.id}" class="chk_1 chk_p"><label for="p-{$vo.id}"></label>
					</div>
				<a href="{:U('Web/Party/show',array('id'=>$vo['aid']))}">
					<div class="land_d pr f0">
						<div class="left-img"><img src="{$vo.thumb}"></div>
						<div class="right-content">
							<div class="land_f1 f16">{$vo.title}</div>

							<div class="land_f3 fich_kk f0">
								<div class="land_font">
									<span>时间:</span> {$vo.starttime|date='Y-m-d',###}至{$vo.endtime|date='Y-m-d',###}   
								</div> 
								<div class="land_font">
									<span>地点:</span> {$vo.address}        
								</div>
								<div class="land_font">
									<span>已参与:</span> {$vo.joinnum}人        
								</div> 
							</div>
						</div>
					</div>
				</a>
				</div>
			</volist>
			
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

</div>
<script type="text/javascript">
	var isEdit = 1;  //1代表当前是编辑按钮   2代表不是编辑按钮
	var isAllCheck = 1; //1代表全选  2代表取消全选
	var nowTab = 'n'; //当前tab页面   n游记  h美宿  p活动
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
			nowTab = this.id;
			ChangeToEditStatus();
		});

		//点击编辑或者全选/不全选按钮
		$('.head_click').click(function(){
			if(isEdit == 1){
				ChangeToSureStatus();
			}else{
				SwitchAllCheck();
			}
		});

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

		var selector = '.chk_' + nowTab;
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
		var selector = '.chk_' + nowTab;
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
		var selector = '.chk_' + nowTab;
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
		var data={'id':text,'type':nowTab};
		$.showLoading("正在修改...");
		$.post("{:U('Web/Member/editcollect')}",data,function(res){
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
			    	var selector='#'+nowTab+'-'+array[i];
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

<include file="Public:foot" />
