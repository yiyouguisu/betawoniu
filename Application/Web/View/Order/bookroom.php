<include file="public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      预订民宿
       <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container padding_0">
     <div class="act_e" style="margin-bottom:2rem;">
           <div class="act_e1 fl"><img src="{$data.thumb}"></div>
           <div class="act_e2 fr">
                <div class="act_e3">{$data.t}</div>
                <div class="act_e4">{$data.title}</div>
           </div>
     </div>
     <form action="{:U('Web/Order/createbook')}" method="post" id='form'>
       <div class="yr">
                   <div class="yr-a center">入住时间和离店时间</div>
                   <div class="yr-b" style="margin-bottom:0;">
                        <div class="yr-c center fl">
                            <div class="yr-c1"><img src="__IMG__/date.jpg"></div>
                            <div class="yr-c2">入住时间</div>
                            <div class="yr-c3">
                                 <input class="ggo_text begin" name="starttime" type="date" value="">
                            </div>
                        </div>
                        <div class="yr-d fl pr" >
                            共<span id='day'>0</span>天
                            <div class="yr_line pa"></div>
                            <input type='hidden' name="days" calss='day' />
                        </div>
                        <div class="yr-c center fl">
                            <div class="yr-c1"><img src="__IMG__/date.jpg"></div>
                            <div class="yr-c2">入住时间</div>
                            <div class="yr-c3">
                                 <input class="ggo_text end" name="endtime" type="date" value="">
                            </div>
                        </div>
                   </div>
                   <div class="we"><span>最后一天14:00后取消订单，将产生违约金</span></div>
       </div> 
       
       <div class="we_a">
            <div class="yr_list">
                <div class="yr-a padding_2 center">预订人数</div>
                <div class="we_b">
                      <div class="we_b1"><input type="button" class="we_btn add1" value="-"></div>
                      <div class="we_b2 center">
                           <input type="text" name='people' class="we_text reduce" value="1">人
                      </div>
                      <div class="we_b1 right">
                          <input type="button" class="we_btn add1" value="+">
                      </div>
                </div>
            </div>
            
            <div class="yr_list">
                <div class="yr-a padding_2  center">入住信息</div>
                <div class="we_c">
                    <volist name='people' id='vo'>
                      <div class="name_list">
                           <div class="name_text">{$vo.realname}</div>
                           <input type='hidden' value="{$i}" />
                           <!--<input type="text" class="name_text" placeholder="周生生" disabled="disabled">-->
                           <div class="name_a">
                                 <input type="button" class="name_btn" value="编辑">
                                 <input type="button" class="name_btn" value="删除">
                           </div>
                      </div>
                    </volist>
                    
                    <div class="olist">
                        <a href="{:U('Web/Member/topContacts',array('id'=>$rid))}"><span>+</span>添加</a>
                    </div>
                    
                </div>  
            </div>
            
            
            <div class="yr-a padding_2 center">预订人信息</div>
            <div class="we_d">
                 <div class="lu_b"><input type="text" class="lu_text" name="realname" placeholder="真实姓名 :"></div>
               
                 <div class="lu_b"><input type="text" class="lu_text" name="phone" placeholder="电话号码 :"></div>
              
                 <div class="lu_b"><input type="text" class="lu_text" name="idcard" placeholder="身份证号码 :"></div>
              
            </div>
            <div class="yr-a padding_2 center" style="padding-top:0">是否有优惠券</div>
            <div class="help_list" style="border-radius:5px;">
                <div class="help_a">选择优惠券</div>
            </div> 

       </div>
       
       <div class="ig">
           <div class="ig_left fl">
                  <div class="ig_a">订单总额 :<span><em>￥</em><span id='total'>680</span></span></div>
                  <div class="ig_b"><a href="">价格明细 <img src="__IMG__/arrow.jpg"></a><span id="detail"></span></div>
           </div>
           <div class="ig_right fr">
              <input type="hidden" name="money"  value="0.00">
              <input type="hidden" name="couponsid" value="">
              <input type="hidden" name="discount" value="0.00">
              <input type="hidden" name="memberids" value="">
              <input type="hidden" name="rid" value="{$id}">
               <a class='sub'>提交订单</a>
           </div>
       </div>
   </from>
</div>




<script type="text/javascript">
  var s,e,day;
  var people=1;
  var day=1;
  var money={$data.nomal_money};
  var allpeople={$data.mannum};
  $(function(){
    $('.begin').change(function(){
      // alert($(this).val());
      s=$(this).val();
      difference(s,e);
    })
    $('.end').change(function(){
      // alert($(this).val());
      e=$(this).val();
      difference(s,e);
    })
  })
  function difference(s,e){
    if(typeof(s)=='undefined'){
      return;
    }
    if(typeof(e)=='undefined'){
      return;
    }
    console.log(s);
    console.log(e);
    var stime=Date.parse(new Date(s));
    var etime=Date.parse(new Date(e));
    console.log(stime);
    console.log(etime);
    if(stime>etime){
      alert('入住时间必须小于退房时间');
      return;
    }
    else{
      var time=etime-stime;
      console.log(time);
      day=parseInt(Math.abs(etime-stime)/1000/60/60/24);
      console.log(day);
      $('#day').text(day);
      $('.day').val(day);
      total(day,money,people);
    }
  }
  $('.add1').click(function(){
    var people=$('.reduce').val();
    if($(this).val()=="+"){
        people=Number(people)+1;
    }
    else{
      if(people==1){
        alert('不能再小了');
      }
      else{
        people-=1;
      }
    }
    $('.reduce').val(people);
    total(day,money,people)
  })
function total(days,money,people){
  console.log(days);
  console.log(money);
  console.log(people);
  var allmoney=parseFloat(parseFloat(days)*parseFloat(money)*parseFloat(people)).toFixed(2);
  if(isNaN(allmoney)){
    return;
  }
  $("#total").text(allmoney);
  $("#detail").text("房费x"+days+"晚x"+people+"人");
  $('input[name="money"]').val(allmoney);
}
$('.sub').click(function(){
  $('#form').submit();
})
</script>
</body>

</html>