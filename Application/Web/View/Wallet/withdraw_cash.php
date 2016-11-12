<include file="public:head" />
<div class="header center z-index112 pr f18 fix-head">
    余额提现
    <div class="head_go pa">
        <a href="javascript:history.back();">
            <img src="__IMG__/go.jpg">
        </a><span>&nbsp;</span>
    </div>
</div>

<div class="container" style="margin-top:6rem">
    <div class="son_top f0">
        <div class="mer_c vertical"><span>待提现余额 :</span><em>￥</em>{$waitmoney}</div>
        <div class="mer_d vertical">
            <img src="__IMG__/money.jpg">
        </div>
    </div>
    <div class="mp_pad" style="padding-top:2rem;">
      <div class="lu_b">
          <input type="number"  data-tip="提现金额" class="required lu_text" id="cash" placeholder="输入提现金额：">
      </div>
      <div class="lu_b">
          <input type="text" value="{$alipayaccount.alipayaccount}" class="lu_text required" id="alipayaccount" placeholder="输入支付宝账号：" data-tip="支付宝账号">
      </div>
      <div class="lu_b">
          <input type="text" class="lu_text required" value="{$alipayaccount.realname}" id="realname" placeholder="输入支付宝账户姓名："  data-tip="支付宝账户姓名">
      </div>
      <div class="snail_d center trip_btn f16">
          <a href="javascript:void(0);" id="withdraw" class="snail_cut ">确认提现</a>
      </div>
    </div>
    <div style="height:4rem;padding:8px;">
    </div>
</div>
<script>
$('#withdraw').click(function(evt){
  evt.preventDefault();
  var tips = '';
  var pass = true;
  $('.required').each(function(i, t) {
    var value = $(t).val(); 
    if(!value) {
      pass = false;
      tips += '请正确填写' + $(t).data('tip') + '\n';
    }
  });
  if(!pass) {
    alert(tips); 
    return;
  }
  var realname = $('#realname').val();
  var money = $('#cash').val();
  var alipayaccount = $('#alipayaccount').val();
  rawPost('{:U("Api/Member/withdraw")}', {
    'uid': {$alipayaccount.uid},
    'realname': realname,
    'alipayaccount': alipayaccount,
    'money': money
  }, function(data) {
    if(data.code == 200) {
      alert('提现成功！');
      window.location.reload();
    } else {
      alert(data.msg); 
    }
  }, function(err, data) {
    alert('网络出错！');
    return;
  });
});
</script>
</body>
</html>
