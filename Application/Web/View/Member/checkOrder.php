<include file="Public:head" />
<div class="header center pr f18">
      消息中心
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
</div>

<div class="container">
    <div class="land_c">
         <div class="snail">
               <div class="snail_title center f18">
                   <h1>{$roomInfo['realname']} 预约的 “{$roomInfo['title']}” 的 房间</h1>
                   <h6>2016-2-15</h6>
               </div>

               <div class="snail_a f14">
                     <div class="snail_a1">{$roomInfo['realname']}预约了您位于 {$roomInfo['title']} 的套房</div>
                     <div class="snail_a2"><span>入住人数 : </span> {$roomerCount}人</div>
                     <div class="snail_a2"><span>入驻日期 : </span> {$roomInfo['starttime']|date='Y-m-d', ###}  -  {$roomInfo['endtime']|date='Y-m-d', ###}</div>
               </div>

               <div class="snail_b">
                     <div class="snail_b1 f16">预约人 :</div>
                     <div class="snail_c">
                          <div class="snail_c1 fl"><img src="{$roomInfo['head']}"></div>
                          <div class="snail_c2 fl">
                               <div class="snail_c3 f15">{$roomInfo['realname']}</div>
                               <div class="snail_c4 f13">{$roomInfo['phone']}</div>
                          </div>
                          <div class="snail_c5 fr">
                            <a href="tel:{$roomInfo['phone']}">
                              <img src="__IMG__/tel.jpg">
                            </a>
                          </div>
                     </div>   
               </div>

               <div class="snail_d center f16">
                    <a href="#" class="snail_cut mr_4" id="pass">通过审核</a>
                    <a href="#" id="not_pass">不通过</a>
               </div>

         </div>
    </div>
</div>
<div class="hide" id="not_pass_box" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:9999;font-size:14px;">
  <div style="opacity:0.9;background:#000;position:absolute;left:0;right:0;top:0;bottom:0;z-index:-1"></div>
  <div style="background:#fff;width:70%;padding:10px;margin:30% auto">
    <textarea style="width:100%;height:100px;border-radius:3px;border:1px solid #eee" placeholder="请填写理由..."></textarea>
    <button id="not_pass_submit" style="color:#fff;width:100%;border-radius:3px;border:0;background:#56c3cf;padding:5px 10px;">提交</button>
    <button id="not_pass_cancel" style="color:#000;width:100%;border-radius:3px;border:0;background:#ccc;padding:5px 10px;margin-top:5px;">取消</button>
  </div>
</div>
<script type="text/javascript">
  $('#pass').click(function(evt) {
    evt.preventDefault();
    console.log(1);
    $.ajax({
      'url': '{:U("Api/Order/revieworder")}',
      'data': JSON.stringify({
        'uid': '{$uid}',
        'orderid': '{$roomInfo["orderid"]}',
        'status': 2,
        'remark': ''
      }),
      'dataType': 'json',
      'type': 'post',
      'processData': false,
      'contentType': 'text/xml',
      'success': function(data) {
        if(data.code == 200) {
          alert('审核成功！');
          window.location.href="{:U('Member/orderlist')}";
        } else {
          alert(data.msg);
        }
      },
      'error': function(err) {
        alert('网络错误，请检查您的网络！');
      }
    });
  });
  $('#not_pass_submit').click(function(evt) {
    evt.preventDefault();
    $.ajax({
      'url': '{:U("Api/Order/revieworder")}',
      'data': JSON.stringify({
        'uid': '{$uid}',
        'orderid': '{$roomInfo["orderid"]}',
        'status': 5,
        'remark': $('textarea').val()
      }),
      'dataType': 'json',
      'type': 'post',
      'processData': false,
      'contentType': 'text/xml',
      'success': function(data) {
        if(data.code == 200) {
          alert('审核完成！');
          window.location.href="{:U('Member/orderlist')}";
        } else {
          alert(data.msg);
        }
      },
      'error': function(err) {
        alert('网络错误，请检查您的网络！');
      }
    });
  
  });
  $('#not_pass').click(function(evt) {
    evt.preventDefault();
    $('#not_pass_box').removeClass('hide');

  });
  $('#not_pass_cancel').click(function(evt) {
    evt.preventDefault();
    $('#not_pass_box').addClass('hide');
  });
</script>
</div>
</body>
