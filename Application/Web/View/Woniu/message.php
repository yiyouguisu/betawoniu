<include file="Public:head" />
<body>
<div class="header center pr f18 fix-head">
      蜗牛
      <div class="map_small f14 pa"><a href="{:U('Woniu/moreFriends')}"><img src="__IMG__/map_small.jpg">地图</a></div>      
</div>
<div class="container" style="margin-top:6rem;background:#f1f1f1">
  <div class="land_b map_title center  f14">
    <a href="{:U('Woniu/index')}">好友</a>
    <a href="{:U('Woniu/chat')}">正在聊天</a>
    <a href="javascript:void(0);" class="land_cut">通知消息</a>
  </div>
  <div class="" style="width:100%">
    <div class="Snail_home_c">
      <ul class="snail_message_list ft14">
      <volist name="data" id="vo">
          <if condition="$vo['varname'] eq 'applyrealnamesuccess'" > 
              <li class="Snail_home_c_color">
                  <a href="javascript:;"  <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'successbookhouse'" /> 
              <li class="Snail_home_c_color">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq>  data-id="{$vo.id}" data-href="{:U('Web/Order/hotel_order_detail',array('orderid'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'applyhouseownersuccess'" /> 
              <li class="Snail_home_c_color">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'refundreviewsuccess'" /> 
              <li class="Snail_home_c_color">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Order/show',array('orderid'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'withdrawsuccess'" /> 
              <li class="Snail_home_c_color">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Web/Member/mywallet')}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'applyrealnamefail'" />
              <li class="Snail_home_c_color2">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Web/Member/realname')}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'failbookhouse'" />
              <li class="Snail_home_c_color2">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Order/show',array('orderid'=>$vo['value']))}">
                       <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'applyhouseownerfail'" />
              <li class="Snail_home_c_color2">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Member/houseowner')}">
                       <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'withdrawfail'" />
              <li class="Snail_home_c_color2">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Wallet/index')}">
                       <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'refundreviewfail'" />
              <li class="Snail_home_c_color2">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Order/show',array('orderid'=>$vo['value']))}">
                       <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'payordersuccess'" />
              <li class="Snail_home_c_color3">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Order/show',array('orderid'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'applybookhouse'"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Web/Woniu/show',array('id'=>$vo['id']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                      <div class="middle Snail_home_c_list2 tr">
                          <i>查看详细 <img src="__IMG__/Icon/img119.png" /></i>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'brefundhostelapply' or $vo['varname'] eq 'brefundpartyapply'"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Web/Woniu/refundreview',array('id'=>$vo['id']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                      <div class="middle Snail_home_c_list2 tr">
                          <i>查看详细 <img src="__IMG__/Icon/img119.png" /></i>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'refundhostelapply' or $vo['varname'] eq 'refundpartyapply'"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Web/Order/show',array('orderid'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'successreviewnote'" /> 
              <li class="Snail_home_c_color">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Note/show',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'successreviewparty'" /> 
              <li class="Snail_home_c_color">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Party/show',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'successreviewhostel'" /> 
              <li class="Snail_home_c_color">
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Hostel/show',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'failreviewnote' or $vo['varname'] eq 'failreviewparty' or $vo['varname'] eq 'failreviewhostel'" />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Web/Woniu/reviewshow',array('id'=>$vo['id']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                      <div class="middle Snail_home_c_list2 tr">
                          <i>查看详细 <img src="__IMG__/Icon/img119.png" /></i>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'waitcheck'"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="$vo['varname'] eq 'getcoupons'"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Web/Member/mycoupons',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="($vo['varname'] eq 'notehit') OR ($vo['varname'] eq 'notecollect') OR ($vo['varname'] eq 'notereview')"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Note/show',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="($vo['varname'] eq 'partyhit') OR ($vo['varname'] eq 'partycollect') OR ($vo['varname'] eq 'partyreview')"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Party/show',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="($vo['varname'] eq 'hostelhit') OR ($vo['varname'] eq 'hostelcollect') OR ($vo['varname'] eq 'hostelreview')"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Hostel/show',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="($vo['varname'] eq 'roomhit') OR ($vo['varname'] eq 'roomcollect') OR ($vo['varname'] eq 'roomreview')"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Room/show',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="($vo['varname'] eq 'triphit') OR ($vo['varname'] eq 'tripcollect') OR ($vo['varname'] eq 'tripreview')"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Trip/show',array('id'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <elseif condition="($vo['varname'] eq 'fattention') OR ($vo['varname'] eq 'tattention')"  />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Web/Member/detail',array('uid'=>$vo['value']))}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          <else />
              <li>
                  <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}">
                      <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                      <div class="middle Snail_home_c_list">
                          <span>{$vo.content}</span>
                          <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                      </div>
                  </a>
              </li>
          </if>
      </volist>
      </ul>
    </div>
  </div>
  <div style="height:2rem"></div>   
</div>
<script>
$('a.redirect').each(function(i, t) {
  var _this = $(t);
  var href = _this.data('href');
  if(href) {
    _this.attr('href', href); 
  }
});
</script>
<include file="Public:foot" />
