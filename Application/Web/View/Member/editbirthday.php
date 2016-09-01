<include file="Public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      修改出生日期
      <div class="head_go pa"><a href=""><img src="__IMG__/go.jpg"></a></div>
</div>

<div class="container">
	<div class="hm">
		<div class="dress_title f18">出生日期</div>
		<form id='form' action="{:U('Web/Member/editbirthday')}" method="post">
			<div class="dress_b hm_input center f16">
				<ul>
					<li>
						<span id='year'>{$birthday[0]}</span>
						<select class="hm_text year" name='year'>
						</select>
					</li>
					<li>
						<span id='month'>{$birthday[1]}</span>
						<select class="hm_text month" name='month'>
						</select>
					</li>
					<li>
						<span id='day'>{$birthday[2]}</span>
						<select class="hm_text day" name='day'>
						</select>
					</li>
				</ul>
			</div>
		</form>  
		<div class="set_c" style="margin:-1rem 2.5% 0">
			<div class="snail_d center trip_btn f16">
				<a id='sub' class="snail_cut ">修改</a>
			</div>
		</div>
    </div>   
 
</div>
<script type="text/javascript">
	var year;
	var month;
	var day;
	$(function(){
		ysers();
		var year=$('.year');
		var month=$('.month');
		var day=$('.day');
		var year='';
		$('.year').change(function(){
			$('#year').text($(this).val());
			year=$(this).val();
			month.empty();
			day.empty();
			months();
			$('#month').text('--请选择--');
			$('#day').text('--请选择--');
			// alert(IsPinYear(year));
		});
		$('.month').change(function(){
			//30天 
			var smonth=['4','6','9','11'];
			// 31天
			var dmonth=['1','3','5','7','8','10','12'];
			day.empty();
			$('#day').text('--请选择--');
			$('#month').text($(this).val());
			if(dmonth.indexOf($(this).val())>0){
				days(31);
			}
			else if(smonth.indexOf($(this).val())>0){
				days(30);
			}else if(IsPinYear(year)){
				days(29);
			}else{
				days(28)
			}
				
		});
		$('.day').change(function(){
			$('#day').text($(this).val());
		});

		// sub提交
		$('#sub').click(function(){
			$('#form').submit();
		});

	})
	function ysers(){
		var mydate = new Date();
		year=mydate.getFullYear();
		month=mydate.getMonth();
		day=mydate.getDate();
		var syear=year-1971;
		var option='<option value="0">--请选择--</option>';
		for(var i=0;i<=syear;i++){
			var y=1970+i;
			option+='<option value='+y+'>'+y+'</option>';
		}
		$('.year').append(option);
	}
	function months(){
		var option='<option value="0">--请选择--</option>';
		for (var i=1;i<=12;i++) {
			option+='<option value='+i+'>'+i+'</option>';
		};
		$('.month').append(option);
	}
	function days(day){
		console.log(day);
		var option='<option value="0">--请选择--</option>';
		for (var i=1;i<=day;i++) {
			option+='<option value='+i+'>'+i+'</option>';
		};
		$('.day').append(option);
	}
	function IsPinYear(year)//判断是否闰平年
	{
	    return(0 == year%4 && (year%100 !=0 || year%400 == 0));
	}


</script>
</body>

</html>