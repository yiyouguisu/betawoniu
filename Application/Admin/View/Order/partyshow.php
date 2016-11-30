<include file="Common:Head" />
<style type="text/css">
    .cu, .cu-li li, .cu-span span {
        cursor: hand;
        !important;
        cursor: pointer;
    }

    tr.cu:hover td {
        background-color: #FF9966;
    }
</style>
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <div class="common-form">
            <div class="h_a">订单详细信息</div>
            <div style="font-size: 12px;padding: 5px 9px;">订单状态： 
                <eq name="data['status']" value="1">用户确认订单成功</eq>
                <eq name="data['status']" value="2">等待支付</eq>
                  <eq name="data['status']" value="3">
                      <eq name="data['refund_status']" value="2">
                          退订成功
                          <else />
                          已取消
                      </eq>
                  </eq>
                <eq name="data['status']" value="4">
                      <if condition="$data['productinfo']['endtime'] lt time()">
                          已完成
                          <else />
                          <eq name="data['refund_status']" value="0">
                              待参加
                          </eq>
                          <eq name="data['refund_status']" value="1">
                              退订中
                          </eq>
                          <eq name="data['refund_status']" value="2">
                              退订成功
                          </eq>
                          <eq name="data['refund_status']" value="3">
                              退订审核失败
                          </eq>
                      </if>
                  </eq>
            </div>
            <div style="font-size: 12px;padding: 5px 9px;">支付状态：
                {:getpaystatus($data['pay_status'])}
            </div>
            <div class="h_a">活动信息</div>
            <div class="table_full">
              <table width="100%" class="table_form contentWrap">
                <tr>
                  <th scope="col" style="width:60%; overflow:hidden;">
                      <div align="left" style="float:left; width:184px;">
                            <img src="{$data.productinfo.thumb}" width="184" height="115" />
                      </div>
                      <div style="float:left; margin-left:20px;">
                        <div align="left"><a href="javascript:;">{$data.productinfo.title}</a></div>
                        <p>活动人数 : {$data.productinfo.start_numlimit|default="0"}-{$data.productinfo.end_numlimit|default="0"}人</p>
                        <div>
                          <p style="display: inline-block; *dispaly:inline; *zoom:1; vertical-align: middle;"> 已参与 : </p>
                          <volist name="data['productinfo']['joinlist']" id="vo">
                          <a href="javascript:;" style="width:30px;height:30px;border-radius:50%; margin-right: 6px; display: inline-block; *dispaly:inline; *zoom:1; vertical-align: middle;" class="midden hidden">
                            <img style="width:30px;height:30px;border-radius:50%; " src="{$vo.head}">
                          </a>
                          </volist>
                          <span sytle="display: inline-block; *dispaly:inline; *zoom:1; vertical-align: middle; font-size: 14px; color: #666666;">( {$data.productinfo.joinnum|default="0"}人 )</span>
                        </div>
                      </div>
                      
                  </th>
                  <th scope="col" style="width:40%">
                      <div align="left">
                        <p>
                            <span style="width:85px; display:inline-block; *display:inline; *zoom:1;">预定人：</span>
                            <a href="javascript:;">
                                <em>{$data.productinfo.nickname}</em>
                            </a>
                        <p>
                        <p>
                            <span style="width:85px; display:inline-block; *display:inline; *zoom:1;">活动时间：</span>
                            <i style="font-style: normal;">开始：{$data.productinfo.starttime|date="Y年m月d日",###}</i>
                            <i style="font-style: normal;">至</i>
                            <i style="font-style: normal;">结束：{$data.productinfo.endtime|date="m月d日",###}</i>
                        </p>
                        <p>
                            <span style="width:85px; display:inline-block; *display:inline; *zoom:1;">活动费用：</span>
                            <i style="font-style: normal;">￥{$data.productinfo.money|default="0.00"}人</i>
                        </p>
                    </div>
                  </th>
                </tr>
                <tr>
                  <td colspan="2">
                    <div align="left" style="overflow:hidden;">
                            <p style="float:left;">￥{$data.productinfo.money|default="0.00"} （活动费用 x {$data.productinfo.num|default="0"}人） — ￥{$data.discount|default="0.00"} （优惠券） = ￥{$data.money|default="0.00"}</span>
                      <p style="float:right;">订单金额 : <i>￥<em>{$data.money|default="0.00"}</em></i></p>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="h_a">参与者信息</div>
            <div class="table_full">
                <table width="100%" class="table_form contentWrap">
                  <tr>
                    <th scope="col" style="width:20%;"><div align="left">姓名</div></th>
                    <th scope="col" style="width:80%;"><div align="left">身份证</div></th>
                  </tr>
                  <volist name="data['productinfo']['book_member']" id="vo">
                        <tr>
                            <td><div align="left">{$vo.realname}</div></td>
                            <td><div align="left">{$vo.idcard}</div></td>
                        </tr>
                    </volist>
                  
                </table>
              </div>
              <div class="h_a">主报人信息</div>
              <div class="table_full">
                <table width="100%" class="table_form contentWrap">
                  <tr>
                    <th scope="col" style="width:20%;"><div align="left">姓名</div></th>
                    <th scope="col" style="width:30%;"><div align="left">身份证号码</div></th>
                    <th scope="col" style="width:50%;"><div align="left">手机号码</div></th>
                  </tr>
                  <tr>
                    <td><div align="left">{$data.productinfo.realname}</div></td>
                    <td><div align="left">{$data.productinfo.idcard}</div></td>
                    <td><div align="left">{$data.productinfo.phone}</div></td>
                  </tr>
                </table>
              </div>
        </div>
    </div>
    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
    <script src="__JS__/layer/extend/layer.ext.js"></script>
    <script>
            //调用示例
            layer.ready(function(){ //为了layer.ext.js加载完毕再执行
              layer.photos({
                  photos: '#layer-photos-demo'
              });
            }); 
        
    </script>
</body>
</html>