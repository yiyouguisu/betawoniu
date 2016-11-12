<include file="public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18" style="position:fixed;left:0;top:0;right:0">
   审核订单
  <div class="head_go pa">
  <a style="display:block" href="{:U('member/orderlist')}"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>
<div class="container padding_0" style="margin-top:6rem;padding:8px;">
  <div style="padding:8px;border-bottom:1px solid #dfdfdf">
    <h3 class="ft18" style="text-align:center">{$data.realname}预约的“{$data.room_name}”房间</h3>
    <div class="ft14" style="text-align:center;color:#aaa">{$data.inputtime|date='Y-m-d', ###}</div>
  </div>
  <div class="ft16" style="color:#666;padding:8px;border-bottom:1px solid #dfdfdf">
    <h4>{$data.realname}预约了您位于“{$data.room_name}”的套房</h4>
    <br>
    <p>入住人数：{$data.num}人</p>
    <p>入住日期：{$data.starttime|date='m月d日', ###}-{$data.endtime|date='m月d日', ###}</p>
  </div>
  <div style="padding:8px;border-bottom:1px solid #dfdfdf">
    <h4 class="ft16">预约人</h4>
    <div style="padding:10px;background:#fff;vertical-align:middle;border-radius:3px;margin:5px 0">
      <div style="float:left;width:25%;">
        <img style="width:50px;height:50px;border-radius:50%" src="{$data.head}">
      </div>
      <div style="float:left;width:30%;padding:10px 0" class="ft14">
        {$data.phone}  
      </div>
      <div style="float:left;width:45%;text-align:right;padding:10px 0" class="ft14">
        <a href="tel:{$data.phone}">
          <img src="__IMG__/wx_a21.jpg" style="height:28px;width:32px;">
        </a>
      </div>
      <div style="clear:both"></div>
    </div>
  </div>
  <div style="padding:8px;border-bottom:1px solid #dfdfdf;text-align:center">
    <button id="pass" style="padding:8px;width:48%;background:#56c3cf;color:#fff;border:0;border-radius:3px;" class="ft16">通过审核</button>
    <button id="not_pass" style="padding:8px;width:48%;background:#aaa;color:#000;border:0;border-radius:3px;" class="ft16">不通过</button>
  </div>
  <div id="refuse" style="position:fixed;top:0;left:0;bottom:0;right:0;z-index:1000;display:none">
    <div style="position:absolute;left:0;right:0;top:0;bottom:0;background:#000;opacity:0.6"></div>
    <div style="position:absolute;top:20%;width:80%;left:10%;height:230px;background:#fff;border:0;border-radius:3px;text-align:right">
      <textarea id="reason" style="width:90%;height:150px;border:0;margin:5%;" class="ft16" placeholder="请填写理由"></textarea> 
      <button class="ft14" style="padding:5px;border:0;width:100px;background:#efefef;color:#000;border-radius:3px;margin:0 1%" id="close_refuse">关闭</button>
      <button class="ft14" style="padding:5px;border:0;width:100px;background:#56c3cf;color:#fff;border-radius:3px;margin:0 5%" id="submit_refuse" data-orderid="{$order.orderid}">提交</button>
    </div>
  </div>
</div>
</body>
<script>
$('#not_pass').click(function(evt) {
  evt.preventDefault();
  $('#refuse').show();
});
$('#close_refuse').click(function(evt) {
  evt.preventDefault();
  $('#refuse').hide();
  $('#reason').val('');
});
$('#pass').click(function(evt) {
  evt.preventDefault();
  $.ajax({
    'url': '{:U("Api/Order/revieworder")}',
    'data': JSON.stringify({
      'uid': '{$data.uid}',
      'orderid': '{$data.orderid}',
      'status': '2'
    }),
    'dataType': 'json',
    'type': 'post',
    'contentType': 'text/xml',
    'processData': false,
    'success': function(data) {
      if(data.code == 200) {
        alert('审核成功！');
        window.location.href="{:U('Member/orderlist')}";
      } else {
        alert(data.msg); 
      }
    },
    'error': function(err, data) {
      console.log(err); 
    }
  });
});
$('#submit_refuse').click(function(evt) {
  evt.preventDefault();
  var content = $('#reason').val();
  $.ajax({
    'url': '{:U("Api/Order/revieworder")}',
    'type': 'post',
    'data': JSON.stringify({
      'uid': '{$data.uid}',
      'orderid': '{$data.orderid}',
      'status': '5',
      'remark': content
    }),
    'dataType': 'json',
    'contentType': 'text/xml',
    'processData': false,
    'success': function(data) {
      if(data.code) {
        window.location.href="{:U('Member/orderlist')}";
      } else {
        alert(data.msg); 
      }
    },
    'error': function(err, data) {
      console.log(err);
    }
  });
});
</script>
</html>
