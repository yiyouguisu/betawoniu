<include file="public:head" />

<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      活动报名
      <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container padding_0">
     <div class="act_e">
           <div class="act_e1 fl"><img src="__IMG__/act_c1.jpg"></div>
           <div class="act_e2 fr">
                <div class="act_e3">{$data.title}</div>
                <div>
                    <div class="land_font">
                        <span>时间:</span> {$data.starttime|date='Y-m-d',###} 至{$data.endtime|date='Y-m-d',###}
                    </div> 
                    <div class="land_font">
                        <span>地点:</span> {$data.address}       
                    </div> 
                </div>

           </div>
     </div>
		<form action="{:U('Web/Order/createAct')}" method="post" id='form' onsubmit="return checkform();">
			<div class="we_a">
				<div class="yr-a we_p2 center">报名人数</div>
				<div class="we_b">
					<div class="we_b1">
						<input type="button" class="we_btn reduce" value="-">
					</div>
					<div class="we_b2 center">
						<input type="text" name='num' class="we_text" value="1">人
					</div>
					<div class="we_b1 right">
						<input type="button" class="we_btn add" value="+">
					</div>
				</div>
				<div class="yr-a we_p2 center" style="margin-top:1rem;">主报名人信息</div>
				<div class="we_d">
					<div class="lu_b"><input type="text" name="realname" class="lu_text" placeholder="真实姓名 :"></div>
					<div class="lu_b"><input type="text" name="phone" class="lu_text" placeholder="电话号码 :"></div>
					<div class="lu_b"><input type="text" name="idcard" class="lu_text" placeholder="身份证号码 :"></div>
				</div>
				<div class="yr-a we_p2 center" style="margin-top:-1rem;">其他报名人信息</div>
				<div class="name_box">
					<volist name='people' id='vo'>
						<div class="name_list">
							<div class="name_text">{$vo.realname}</div>
							<input type='hidden' value="{$vo.id}" />
							<!--<input type="text" class="name_text" placeholder="周生生" disabled="disabled">-->
							<div class="name_a">
								<input type="button" class="name_btn" data-id='{$vo.id}' value="编辑">
								<input type="button" class="name_btn del" data-id='{$vo.id}' value="删除">
							</div>
						</div>
					</volist>
				</div>
				<div class="olist">
					<a href="{:U('Web/Member/topContacts',array('id'=>$rid))}"><span>+</span>添加</a>
				</div>
			</div>
     
			<div class="ig" style="margin-top:2rem;">
				<div class="ig_left fl">
					<div class="ig_a">活动总额 :<span><em>￥</em> <span id='tmoney'>{$data.money}</span> </span></div>
					<div class="ig_b"><a href="">价格明细 <img src="__IMG__/arrow.jpg"><span id='details'></span> </a></div>
				</div>
				<div class="ig_right fr">
					<input type='hidden' name='money' value='{$data.money}' >
					<input type='hidden' name='aid' value="{$pid}"> 
					<a class='sub'>提交报名表</a>
				</div>
			</div>
		</form>
</div>

</body>
<script type="text/javascript">
var money={$data.money};
$(function(){
	$('.we_text').val(countActPeople());
	total(countActPeople());
})
// 减少人数
$('.reduce').click(function(){
	var num=countActPeople();
	var thisnum=$('.we_text').val();
	if(thisnum<=countActPeople()){
		return;
	}
	else{
		thisnum--;
		$('.we_text').val(thisnum);
		total(thisnum);
	}
})
// 增加人数
$('.add').click(function(){
	var thisnum=$('.we_text').val();
	console.log(thisnum);
	thisnum++;
	console.log(thisnum);
	$('.we_text').val(thisnum);
	total(thisnum);
})
$('.del').click(function(){
	var self=$(this);
	var data={'id':$(this).data('id')};
	$.post("{:U('Web/Member/delcookie')}",data,function(res){
		self.parent().parent().remove();
	})
})
$('.sub').click(function(){
	$('#form').submit();
})
function countActPeople(){
	var count=$('.name_list').length;
	return count;
}
function total(people){
	var total=Number(people)*money;
	$('#tmoney').text(total);
	$('#details').text(people+'人*￥'+money);
}
function checkform(){
	//  var pattern = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/; 
 // return pattern.test(card); 


	var realname=$("input[name='realname']").val();
	var idcard=$("input[name='idcard']").val();
	var phone=$("input[name='phone']").val();
	var num=$("input[name='num']").val();
	if(realname==''){
		alert("请填写姓名");
		$("input[name='realname']").focus();
		return false;
	}else if(idcard==''){
		alert("请填写身份证号码");
		$("input[name='idcard']").focus();
		return false;
	}else if(phone==''){
		alert("请填写手机号码");
		$("input[name='phone']").focus();
		return false;
	}
	else if(!/^1[3|4|5|7|8][0-9]{9}$/.test(phone)){
		alert("手机号码格式不正确");
		$("input[name='phone']").focus();
		return false;
	}else if(!/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(idcard)){
		alert("身份证号码错误");
		$("input[name='phone']").focus();
		return false;
	}
	else if(num!=$('.name_list').length){
		alert("报名人数与用户信息数量不一致");
		$("input[name='phone']").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
</html>