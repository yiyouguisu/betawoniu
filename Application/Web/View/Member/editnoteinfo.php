<include file="Public:head" />
<link rel="stylesheet" type="text/css" href="__CSS__/file.css">
<script type="text/javascript" src='__JS__/ajaxfileupload.js'></script>
<body class="back-f1f1f1">
<div class="header center pr f18">
      编辑游记
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>
<form id='form' action="{:U('Web/Member/editnoteinfo')}" method="post">
	<div class="container">
		<div class="act_c">
			<div class="lu_b">
				<input type="text" name="title" class="lu_text" placeholder="游记标题 :" value="{$data.title}" >
			</div>
			<div class="lu_b">
				<input type="text" name="description" class="lu_text" placeholder="游记摘要 :" value="{$data.description}" >
			</div>
			<div class="lu_b">
				<input type="text" name="address" class="lu_text" placeholder="详细地址 :" value="{$data.address}" >
			</div>

			<div class="lu_b  lu_drop">
				<div class="drop_left fl">
					地区：
				</div>
				<div class="drop_right fl">
					<select class="lu_select" id='area' name='area'>
						<option value='0'>-请选择-</option>
							<foreach name="province" item="vo">
								<option value="{$vo.id}" <if condition="$data['carray'][0] eq $vo['id']">selected="selected"</if>>{$vo.name}</option>
							</foreach>
					</select>

					<select class="lu_select" id='city' name='city'>
						<option value='0'>-请选择-</option>
						<foreach name="allprovince[0]" item="vo">
								<option value="{$vo.id}" <if condition="$data['carray'][1] eq $vo['id']">selected="selected"</if>>{$vo.name}</option>
						</foreach>
					</select>

					<select class="lu_select" id='county'name='county'>
						<option value='0'>-请选择-</option>
						<foreach name="allprovince[1]" item="vo">
								<option value="{$vo.id}" <if condition="$data['carray'][2] eq $vo['id']">selected="selected"</if>>{$vo.name}</option>
						</foreach>
					</select>
				</div>
			</div>

		</div> 

       
		<div class="yr">
			<div class="yr-a center">出发时间</div>
			<div class="yr-b">
				<div class="yr-c center fl">
					<div class="yr-c1"><img src="__IMG__/date.jpg"></div>
					<div class="yr-c2">入住时间</div>
					<div class="yr-c3">
						<input class="ggo_text" type="date" name="begintime" value="{$data.begintime|date='Y-m-d',###}" id="in">
					</div>
				</div>
				<div class="yr-d fl pr" >
					共<span id='day'>{$data.days}</span>天
					<input type="hidden" name="days" id="days" value='{$data.days}' />
					<div class="yr_line pa"></div>
				</div>
				<div class="yr-c center fl">
					<div class="yr-c1"><img src="__IMG__/date.jpg"></div>
					<div class="yr-c2">退房时间</div>
					<div class="yr-c3">
						<input class="ggo_text" type="date" name="endtime" value="{$data.endtime|date='Y-m-d',###}" id="out">
					</div>
				</div>
			</div>
		</div> 
		<div class="yr-a center">人均费用</div>
		<div class="bmm" style="padding:2rem 2.5%;">
			<input type="text" name="fee" class="lu_text" placeholder="人均费用 :" value='{$data.fee}'>
		</div> 
		<div class="act_c">
			<div class="tra_dropA">
				<select name="noteman">
					<volist name="noteman" id="vo">
						<option value="{$vo.id}" <if condition="$data['man'] eq $vo['id']">selected="selected"</if>>{$vo.catname}</option>
					</volist>
				</select>
			</div>       
			<div class="tra_dropA">
				<select name="notestyle">
					<volist name="notestyle" id="vo">
						<option value="{$vo.id}" <if condition="$data['style'] eq $vo['id']">selected="selected"</if>>{$vo.catname}</option>
					</volist>
				</select>
			</div>
			<div class="jok_a">发布内容</div>
			<div class="describe_list">
				<!-- 图片list -->
			</div>   
			<input type="button" class="jok_btn jok_red" value="添加图片和描述">
			<!-- 所有内容 -->
			<input type="hidden" name="content" id='content' /> 
			<!-- 修改游记id  -->
			<input type="hidden" name='id' value='{$data.id}'>
		</div>
		<div class="snail_d center trip_btn f16" style="margin:2rem 2.5% 0">
			<a href="javascript:;" id="sub" class="snail_cut">发布</a>
		</div>
	</div>
</form>

<script type="text/javascript">
	var intime=''
	var outtime='';
	$(function() {
		// 计算时间差
	    var cin=$('#in');
	    var cout=$('#out');
	    var day=''
		cin.change(function(){
			console.log('in');
			intime=$(this).val();
			day=checktime(intime,outtime);
			showdays(day)
		});
		cout.change(function(){
			outtime=$(this).val();
			checktime(intime,outtime);
			day=checktime(intime,outtime);
			showdays(day)
		});
		var content='{$data.imglist}';
		content=JSON.parse(content);
		console.log(typeof(content));
		var rform=''
		var i=0;
		$.each(content,function(id,value){
			console.log(value);
			rform+='<div class="jok_b"><img src="'+value.thumb+'" id="upz'+id+'"><input type="hidden" id="hid'+id+'" class="limgs" value="'+value.thumb+'" /></div><form id= "uploadForm'+id+'" enctype="multipart/form-data" method="post">  <a href="javascript:;" class="file jok_btn">上传图片<input type="file" name="Filedata" style="width:100%;height:100%" id=""  onchange="doUpload('+id+')"></a></form><div class="lu_b"><input type="text" class="lu_text ltest" placeholder="描述 :" value='+value.content+'></div>'
			i++;
		})
		$('.describe_list').append(rform);

		var jok_red=$('.jok_red');
		jok_red.click(function(){
			if(i<=10){
				var html='';
				var html='<div class="jok_b"><img src="__IMG__/jok_b.jpg" id="upz'+i+'"><input type="hidden" id="hid'+i+'" class="limgs" /></div>';
				$('.describe_list').append(html);
				var form = $('<form></form>'); 
				form.attr('method', 'post');
				form.attr('id', 'uploadForm'+i);  
				form.attr('enctype', 'multipart/form-data');  
				var file='<a href="javascript:;" class="file jok_btn">上传图片<input type="file" name="Filedata" id="" style="width:100%;height:100%" onchange="doUpload('+i+')"></a>';
				var form1=form.append(file);
				$('.describe_list').append(form1);
				var sub='<div class="lu_b"><input type="text" class="lu_text ltest" placeholder="描述 :"></div>';
				$('.describe_list').append(sub);
			}
			else{
				alert('最多上传10张图');
			}
			i++;
		})


		$('#sub').click(function(){
			var imgurl=$('.limgs');
			var data=[];
			imgurl.each(function(i){
				var url=$(this).val();
				$('.ltest').each(function(j){
					var text=$(this).val();
					if(i==j){
						var obj={'content':text,'thumb':url}
						data.push(obj);
					}
				});
			});
			var data=JSON.stringify(data);
			$('#content').val(data);
			console.log(data);
			$('#form').submit();
		});
		var area,city,county;
		// 城市
        $('#area').change(function(){
            var city=$('#city');
            city.empty();
            var data={'id':$(this).val()};
            console.log(data);
            $.post("{:U('Web/Note/ajaxcity')}",data,function(res){
                var option='<option>-请选择-</option>';
                res = JSON.parse(res);
                $.each(res,function(i,value){
                    option+='<option value='+value.id+'>'+value.name+'</option>';
                });
                city.append(option);
            });
            area=$(this).val();
        });
        // 区域
        $('#city').change(function(){
            var county=$('#county');
            county.empty();
            var data={'id':$(this).val()};
            $.post("{:U('Web/Note/ajaxcity')}",data,function(res){
                var option='<option>-请选择-</option>';
                res = JSON.parse(res);
                $.each(res,function(i,value){
                    option+='<option value='+value.id+'>'+value.name+'</option>';
                });
                county.append(option);
            });
            city=$(this).val();
        });
        $('#county').change(function(){
        	county=$(this).val();
        	console.log(area);
        	console.log(county);
        	console.log(county);
        })
	});
	function checktime(it,ot){
		console.log('out');
		it=new Date(it+' 00:00:00');
		ot=new Date(ot+' 00:00:00');
		if(it=='' || it=='NAN'){
			return '';
		}
		else if(ot=='' || ot=='NAN'){
			return '';
		}
		else if(ot<it){
			alert('退房时间小于入住时间');
			$('#day').text('-');
		}
		else{
			return parseInt(Math.abs(ot - it) / 1000 / 60 / 60 / 24);
		}	
	}
	// 显示时间
	function showdays(day){
		console.log(day)
		if(!isNaN(day)){
			$('#day').text(day);
			$('#days').val(day);
		}
		
	}
	$('.add').click(function(){

	});
	function doUpload(i) {  
		console.log(i)
		if(i==1){
			var formData = new FormData($( "#uploadForm1" )[0]);
		}
		else{
			console.log('else');
			console.log("#uploadForm"+i);
			var formData = new FormData($("#uploadForm"+i)[0]);
		}
     	console.log(formData);
     	$.ajax({  
			url: "{:U('Web/Public/uploadone')}" ,  
			type: 'POST',  
			data: formData,  
			async: false,  
			cache: false,  
			contentType: false,  
			processData: false,  
			success: function (returndata) {  
				console.log(returndata);
				if(i==1){
					$('#upz1').attr('src',returndata);
					$('#hid1').val(returndata);
				}
				else{
					$('#upz'+i).attr('src',returndata);
					$('#hid'+i).val(returndata);
				}
				// alert("成功");
				// alert(returndata);
				// alert(typeof(returndata));
				// console.log(returndata);
				// $('.upz').attr('src',returndata);
			},  
			error: function (returndata) {  
				alert('失败');  
			}  
     	});
	} 
</script>
</body>
</html>