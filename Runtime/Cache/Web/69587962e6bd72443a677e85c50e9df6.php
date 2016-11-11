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

<script type="text/javascript" src="/Public/Web/js/ajaxfileupload.js"></script>
<script type="text/javascript">
    var areaurl = "<?php echo U('Web/Note/getchildren');?>";
    function load(parentid, type) {
        $.ajax({
            type: "GET",
            url: areaurl,
            data: { 'parentid': parentid },
            dataType: "json",
            success: function (data) {
                if (type == 'city') {
                    $('#city').html('<option value="">--请选择--</option>');
                    $('#town').html('<option value="">--请选择--</option>');
                    if(data!=null){
                        $.each(data, function (no, items) {
                            if (items.id == "<?php echo ($_GET['city']); ?>") {
                                $('#city').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                            } else {
                                $('#city').append('<option value="' + items.id + '">' + items.name + '</option>');
                            }
                        });
                    }
                } else if (type == 'town') {
                    $('#town').html('<option value="">--请选择--</option>');
                    if(data!=null){
                        $.each(data, function (no, items) {
                            if (items.id == "<?php echo ($_GET['town']); ?>") {
                                $('#town').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                            } else {
                                $('#town').append('<option value="' + items.id + '">' + items.name + '</option>');
                            }
                        });
                    }
                }
            }
        });
    }
</script>
<link rel="stylesheet" type="text/css" href="/Public/Web/css/file.css">
<script type="text/javascript" src='/Public/Web/js/ajaxfileupload.js'></script>
<body class="back-f1f1f1">
<div class="header center pr f18">
      发布游记
      <div class="head_go pa"><a href="<?php echo U('Web/Note/index');?>"><img src="/Public/Web/images/go.jpg"></a><span>&nbsp;</span></div>
</div>
<form id='form' action="<?php echo U('Web/Note/add');?>" method="post">
	<div class="container">
		<div class="act_c">
			<div class="lu_b">
				<input type="text" name="title" class="lu_text" placeholder="游记标题 :" required>
			</div>
			<div class="lu_b">
				<textarea  class="lu_text" placeholder="游记摘要 ：" name="description" required></textarea>
			</div>
			<div class="lu_b">
				<input type="text" name="fee" class="lu_text" placeholder="人均费用 :" required>
			</div>
			<div class="lu_b  lu_drop">
				<div class="drop_left fl">
					地区：
				</div>
				<div class="drop_right fl">
					<select  class="lu_select" name="province" id="province"   onchange="load(this.value,'city',0)" required>
                        <option value="">--请选择--</option>
                        <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $_GET['province']): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <select  class="lu_select" name="city" id="city"  onchange="load(this.value,'town',0)" required>
                       <option value="">--请选择--</option>
                    </select>

                    <select  class="lu_select" name="town" id="town"  onchange="load(this.value,'distinct',0)">
                       <option value="">--请选择--</option>
                    </select>
				</div>
			</div>
			<div class="lu_b">
				<input type="text" name="address" class="lu_text" placeholder="详细地址 :">
			</div>
		</div> 

       
		<div class="yr">
			<div class="yr-a center">出发时间</div>
			<div class="yr-b">
				<div class="yr-c center fl">
					<div class="yr-c1"><img src="/Public/Web/images/date.jpg"></div>
					<div class="yr-c2">开始时间</div>
					<div class="yr-c3">
						<input class="ggo_text date starttime" type="date" name="begintime" value="<?php echo date('Y-m-d');?>" required>
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
						<input class="ggo_text date endtime" type="date" name="endtime" value="<?php echo date('Y-m-d');?>" required>
					</div>
				</div>
			</div>
		</div> 
		 
		<div class="act_c">
			<div class="tra_dropA">
				<select name="man">
					<option value="">请选择活动人物</option>
					<?php if(is_array($noteman)): $i = 0; $__LIST__ = $noteman;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>       
			<div class="tra_dropA">
				<select name="style">
					<option value="" >请选择活动形式</option>
					<?php if(is_array($notestyle)): $i = 0; $__LIST__ = $notestyle;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
			<div class="jok_a">发布内容</div>
			<div class="describe_list">
				<div class="imglist">
					<div class="jok_b">
						<img src="/Public/Web/images/default.jpg" id="img_0">
						<input type="hidden" class="thumb" id="imglist_0" name="imglist[0][thumb]" value="">
					</div>
					<a href="javascript:;" class="file jok_btn">上传图片
						<input type="file" name="Filedata" id="fileupload_0" style="width:100%;height:100%" onchange="ajaxFileUpload(0)">
					</a>
					<div class="lu_b">
	                    <textarea  class="lu_text ltest" id="content_0" placeholder="描述 ：" name="imglist[0][content]"></textarea>
					</div>
				</div>
			</div>   
			<input type="button" class="jok_btn jok_red qadd" value="添加图片和描述">
		</div>
		<div class="snail_d center trip_btn f16" style="margin:2rem 2.5% 0">
			<input type="hidden" name="hid" value="" />
			<a href="javascript:;" id="save" class="snail_cut">发布</a>
		</div>
	</div>
</form>

<script type="text/javascript">
	var xss=0;
	$(function() {
		$(".date").change(function(){
			var starttime=$(".starttime").val();
			var endtime=$(".endtime").val();
			if(starttime!=''&&endtime!=''){
                if(Date.parse(endtime) - Date.parse(starttime)<0){
                    alert("请填写正确日期");
                    $(".endtime").val();
                    return false;
                }else{
                    var days=DateDiff(starttime,endtime);
                    $("#days").val(Number(days));
                    $('#day').text(Number(days));
                }
                
            }
		});
		$("#save").click(function(){
			var title=$("input[name='title']").val();
			var description=$("textarea[name='description']").val();
			var fee=$("input[name='fee']").val();
			var province=$("select[name='province'] option:selected").val();
			var city=$("select[name='city'] option:selected").val();
			var starttime=$("input[name='starttime']").val();
			var endtime=$("input[name='endtime']").val();
			var man=$("select[name='man'] option:selected").val();
			var style=$("select[name='style'] option:selected").val();
			if(title==''){
				alert("请填写游记标题");
				return false;
			}
			if(description==''){
				alert("请填写游记描述");
				return false;
			}
			if(fee==''){
				alert("请填写人均费用");
				return false;
			}
			if(province==''||city==''){
				alert("请选择地区");
				return false;
			}
			if(starttime==''||endtime==''){
				alert("请选择时间");
				return false;
			}
			if(man==''){
				alert("请选择游记人物");
				return false;
			}
			if(style==''){
				alert("请选择游记形式");
				return false;
			}
			$("#form").submit();
		})
		$(".qadd").click(function() {
			var thumb=$("#imglist_"+xss).val();
			var content=$("#content_"+xss).val();
			if(thumb==''&&content==''){
				return false;
			}
            xss++;
            var htmladd="<div class=\"imglist\"><div class=\"jok_b\">";
				htmladd +="<img src=\"/Public/Web/images/default.jpg\" id=\"img_"+xss+"\">";
				htmladd +="<input type=\"hidden\" class=\"thumb\" id=\"imglist_"+xss+"\" name=\"imglist["+xss+"][thumb]\">";
				htmladd +="</div>";
				htmladd +="<a href=\"javascript:;\" class=\"file jok_btn\">上传图片";
				htmladd +="<input type=\"file\" name=\"Filedata\" id=\"fileupload_"+xss+"\" style=\"width:100%;height:100%\"  onchange=\"ajaxFileUpload("+xss+")\">";
				htmladd +="</a>";
				htmladd +="<div class=\"lu_b\">";
                htmladd +="<textarea  class=\"lu_text ltest\" placeholder=\"描述 ：\" id=\"content_"+xss+"\" name=\"imglist["+xss+"][content]\"></textarea>";
				htmladd +="</div></div>";
            var htmltr=  $(htmladd);
            $('.describe_list').append(htmltr);
        })
	});
	//计算天数差的函数，通用  
    function  DateDiff(sDate1,  sDate2){    //sDate1和sDate2是2006-12-18格式  
       var  aDate,  oDate1,  oDate2,  iDays  
       aDate  =  sDate1.split("-")  
       oDate1  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])    //转换为12-18-2006格式  
       aDate  =  sDate2.split("-")  
       oDate2  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])  
       iDays  =  parseInt(Math.abs(oDate1  -  oDate2)  /  1000  /  60  /  60  /24)    //把相差的毫秒数转换为天数  
       return  iDays  
    }   
	function ajaxFileUpload(i) {
        $.ajaxFileUpload({
            url: "<?php echo U('Web/Public/uploadone');?>",
            secureuri: false, //一般设置为false
            fileElementId: "fileupload_"+i,
            secureuri: false,
            dataType: 'text',
            success: function (data, status) {
                $('#img_'+i).attr('src',data);
				$('#imglist_'+i).val(data);
            },
            error: function (data, status, e) { }
        })
        return false;
    }
</script>
</body>
</html>