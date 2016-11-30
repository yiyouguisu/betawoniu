<include file="public:head" />
<body class="back-f1f1f1">
  <div class="header center z-index112 pr ft16 fix-head">
      评价活动: {$activity.title}
      <div class="head_go pa">
          <a href="javascript:history.back();window.location.reload();">
              <img src="__IMG__/go.jpg">
          </a><span>&nbsp;</span>
      </div>
  </div>
  <div class="container" style="margin-top:6rem">
    <div style="padding:16px;">
      <textarea style="height:200px;width:98%;padding:1%;color:#333;border-radius:5px;box-shadow:2px 5px 20px #56c3cf" rows=8 class="ft16" placeholder="评论你想说的... ..."></textarea>
    </div>
    <div style="padding:16px">
      <button style="border:0;width:100%;padding:12px 0;color:#fff;background:#56c3cf;border-radius:5px;box-shadow:0px 3px 10px #999" class="ft16" id="submit_comment">提交评价</button>
    </div>
  </div>
</body>
<script>
$('#submit_comment').click(function(evt) {
  evt.preventDefault();
  var uid = {$uid};
  var aid = {$aid};
  var content = $('textarea').val();
  if(!content) {
    alert('评论内容必须填写！');
    return;
  }
  $(this).attr('disabled', 'disabled');
  rawPost('{:U("Api/Activity/review")}', {
    'uid': '{$uid}',
    'aid': '{$aid}',
    'content': content
  }, function(data) {
    if(data.code == 200) {
      window.location.href = "{:U('Order/party_order_detail')}?orderid={$orderid}";
    } else {
      alert(data.msg); 
      $(this).removeAttr('disabled');
    } 
  }, function(err, data) {
    console.log(err);
    $(this).removeAttr('disabled');
    alert('网络错误！');
  });
});
</script>
</div>
