<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
    <meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
    <meta name="format-detection" content="telephone=no" />
    <link href="favicon.ico" rel="SHORTCUT ICON">
    <title><?php echo ($site["sitetitle"]); ?></title>
    <link rel="stylesheet" href="/Public/Public/css/weui.css">
    <link rel="stylesheet" href="/Public/Public/css/jquery-weui.css">
    <link rel="stylesheet" href="/Public/Web/css/base.css">
    <link rel="stylesheet" href="/Public/Web/css/style.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery-ui.min.css">
    <script src="/Public/Web/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Public/js/jquery-weui.js"></script>
    <script src="/Public/Web/js/Action.js"></script>
    <script src="/Public/Web/js/TouchSlide.1.1.js"></script>
    <script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script src="/Public/public/js/jquery.cookie.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Public/Web/js/iscroll.js"></script>
    <link rel="stylesheet" href="/Public/Web/css/list.css">
    <script>
        $(function(){
            $('img.pic').lazyload({
               effect: 'fadeIn'
            });
        })
    </script>
</head>
<body>

<link rel="stylesheet" type="text/css" href="/Public/Web/css/file.css">
<script type="text/javascript" src='/Public/Web/js/ajaxfileupload.js'></script>
<body class="back-f1f1f1">
<div class="header center pr f18">
      发布游记
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="/Public/Web/images/go.jpg"></a><span>&nbsp;</span></div>
</div>
<form id='form' action="<?php echo U('Web/Member/publicnote');?>" method="post">
	<div class="container">
		<div class="act_c">
			<div class="lu_b">
				<input type="text" name="title" class="lu_text" placeholder="游记标题 :">
			</div>
			<div class="lu_b">
				<input type="text" name="description" class="lu_text" placeholder="游记摘要 :">
			</div>
			<div class="lu_b">
				<input type="text" name="address" class="lu_text" placeholder="详细地址 :">
			</div>

			<div class="lu_b  lu_drop">
				<div class="drop_left fl">
					地区：
				</div>
				<div class="drop_right fl">
					<select class="lu_select" id='area' name='area'>
						<option value='0'>-请选择-</option>
							<?php if(is_array($province)): foreach($province as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
					</select>

					<select class="lu_select" id='city' name='city'>
						<option value='0'>-请选择-</option>
					</select>

					<select class="lu_select" id='county'name='county'>
						<option value='0'>-请选择-</option>
					</select>
				</div>
			</div>

		</div> 

       
		<div class="yr">
			<div class="yr-a center">出发时间</div>
			<div class="yr-b">
				<div class="yr-c center fl">
					<div class="yr-c1"><img src="/Public/Web/images/date.jpg"></div>
					<div class="yr-c2">开始时间</div>
					<div class="yr-c3">
						<input class="ggo_text" type="date" name="begintime" value="2016-05-12" id="in">
					</div>
				</div>
				<div class="yr-d fl pr" >
					共<span id='day'>-</span>天
					<input type="hidden" name="days" id="days"/>
					<div class="yr_line pa"></div>
				</div>
				<div class="yr-c center fl">
					<div class="yr-c1"><img src="/Public/Web/images/date.jpg"></div>
					<div class="yr-c2">结束时间</div>
					<div class="yr-c3">
						<input class="ggo_text" type="date" name="endtime" value="2016-05-12" id="out">
					</div>
				</div>
			</div>
		</div> 
		<div class="yr-a center">人均费用</div>
		<div class="bmm" style="padding:2rem 2.5%;">
			<input type="text" name="fee" class="lu_text" placeholder="人均费用 :">
		</div> 
		<div class="act_c">
			<div class="tra_dropA">
				<select name="noteman">
					<option value="">请选择活动人物</option>
					<?php if(is_array($noteman)): $i = 0; $__LIST__ = $noteman;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>       
			<div class="tra_dropA">
				<select name="notestyle">
					<option value="" >请选择活动形式</option>
					<?php if(is_array($notestyle)): $i = 0; $__LIST__ = $notestyle;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
			<div class="jok_a">发布内容</div>
			<div class="describe_list">
				<!-- 图片list -->
			</div>   
			<input type="button" class="jok_btn jok_red" value="添加图片和描述">
			<!-- 所有内容 -->
			<input type="hidden" name="content" id='content' />       
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
		var rform='<div class="jok_b"><img src="/Public/Web/images/jok_b.jpg" id="upz1"><input type="hidden" id="hid1" class="limgs" /></div><form id= "uploadForm1" enctype="multipart/form-data" method="post">  <a href="javascript:;" class="file jok_btn">上传图片<input type="file" name="Filedata" style="width:100%;height:100%" id=""  onchange="doUpload(1)"></a></form><div class="lu_b"><input type="text" class="lu_text ltest" placeholder="描述 :"></div>'
		$('.describe_list').append(rform);

		var jok_red=$('.jok_red');
		var i=2;
		jok_red.click(function(){
			if(i<=10){
				var html='';
				var html='<div class="jok_b"><img src="/Public/Web/images/jok_b.jpg" id="upz'+i+'"><input type="hidden" id="hid'+i+'" class="limgs" /></div>';
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
			console.log(typeof(data));
			var data=JSON.stringify(data);
			console.log(typeof(data));
			$('#content').val(data);
			$('#form').submit();
		});
		var area,city,county;
		// 城市
        $('#area').change(function(){
            var city=$('#city');
            city.empty();
            var data={'id':$(this).val()};
            console.log(data);
            $.post("<?php echo U('Web/Note/ajaxcity');?>",data,function(res){
                var option='<option>-请选择-</option>';
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
            $.post("<?php echo U('Web/Note/ajaxcity');?>",data,function(res){
                var option='<option>-请选择-</option>';
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
			url: "<?php echo U('Web/Public/uploadone');?>" ,  
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