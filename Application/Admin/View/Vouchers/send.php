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
    .picList li{ float: left; margin-top: 2px; margin-right: 5px;}
</style>

<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <div class="common-form">
            <form class="J_ajaxForm" method="post" action="{:U('Admin/Vouchers/send')}">
                <div class="h_a">优惠券信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="100">优惠券名称</th>
                                <td>{$data.title}</td>
                            </tr>
                            <tr>
                                <th width="100">优惠券用途分类</th>
                                <td>
                                    <eq name="data['voucherstype']" value="all">全部</eq>
                                    <eq name="data['voucherstype']" value="hostel">美宿</eq>
                                    <eq name="data['voucherstype']" value="party">活动</eq>
                                </td>
                            </tr>
                            <tr>
                                <th width="100">优惠券适用范围</th>
                                <td>
                                    <eq name="data['voucherscale']" value="all">全部</eq>
                                    <eq name="data['voucherscale']" value="area">区域范围:{$data.cityname}</eq>
                                    <eq name="data['voucherscale']" value="assign">
                                        <eq name="data['voucherstype']" value="all">
                                            美宿：</br>
                                            <volist name="data['hostel']" id="vo">
                                                {$vo.title}</br>
                                            </volist>
                                            活动：</br>
                                            <volist name="data['party']" id="vo">
                                                {$vo.title}</br>
                                            </volist>
                                        </eq>
                                        <eq name="data['voucherstype']" value="hostel">
                                            美宿：</br>
                                            <volist name="data['hostel']" id="vo">
                                                {$vo.title}</br>
                                            </volist>
                                        </eq>
                                        <eq name="data['voucherstype']" value="party">
                                            活动：</br>
                                            <volist name="data['party']" id="vo">
                                                {$vo.title}</br>
                                            </volist>
                                        </eq>
                                    </eq>
                                </td>
                            </tr>

                            <tr>
                                <th width="100">优惠券价格</th>
                                <td>{$data.price|default="0.00"}</td>
                            </tr>
                            <tr>
                                <th width="100">优惠券适用范围</th>
                                <td>消费满{$data.range|default="0"}元可使用</td>
                            </tr>
                            <tr>
                                <th width="100">优惠券有效时间</th>
                                <td>
                                    {$data.validity_starttime|date="Y-m-d H:i:s",###}</br>
                                    {$data.validity_endtime|date="Y-m-d H:i:s",###}
                                </td>
                            </tr>
                            <tr>
                                <th width="100">优惠券使用规则</th>
                                <td>{$data.content}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="h_a">发放优惠券信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="100">发放范围</th>
                                <td>
                                  <ul class="switch_list cc ">
                                      <li>
                                        <label>
                                          <input type='radio' name='scale' value='1' >
                                          <span>所有用户</span></label>
                                      </li>
                                      <!--<li>
                                        <label>
                                          <input type='radio' name='scale' value='2' >
                                          <span>偏向用户</span></label>
                                      </li>-->
                                      <li>
                                        <label>
                                          <input type='radio' name='scale' value='3' checked>
                                          <span>特定用户</span></label>
                                      </li>
                                      <!--<li>
                                        <label>
                                          <input type='radio' name='scale' value='4' >
                                          <span>会员等级</span></label>
                                      </li>-->
                                    </ul>
                                </td>
                            </tr>
                            <tr id="scale" style="display:none;">
                                <th></th>
                                <td>
                                    <ul class="switch_list cc ">
                                    <volist name=":getlinkage(1)" id="vo">
                                      <li>
                                        <label>
                                          <input type='checkbox' name='preference[]' value='{$vo.value}' >
                                          <span>{$vo.name}</span>
                                        </label>
                                      </li>
                                    </volist>
                                    </ul>
                                </td>
                            </tr>
                            <tr id="scale1">
                                <th></th>
                                <td>
                                    <textarea name="name" id="name" class="valid" placeholder="请输入用户名或手机号码,多个以（,）分割" style="width: 100%; height: 150px;"></textarea>
                                </td>
                            </tr>
                            <tr id="scale2" style="display:none;">
                                <th></th>
                                <td>
                                    <select class="select_1" name="level"  style="width:100px;">
                                        <option value="">全部</option>
                                        <volist name="levelConfig" id="vo">
                                            <option value="{$key}" >{$vo.title}</option>
                                        </volist>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th width="100">发放数量</th>
                                <td><input type="number" name="num" min="0" class="input input_hd" placeholder="请输入发放数量" id="num" value=""></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <input type="hidden" name="catid" value="{$data.id}" />
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<script src="__JS__/common.js?v"></script>
      <script src="__JS__/content_addtop.js"></script>
      <script type="text/javascript">
        $(function(){
            $("input[name='scale']:radio").click(function() {
                if($(this).val()==2) {
                    $("#scale").show();
                    $("#scale1").hide();
                    $("#scale2").hide();
                }else if($(this).val()==1){
                    $("#scale").hide();
                    $("#scale1").hide();
                    $("#scale2").hide();
                } else if ($(this).val() == 3) {
                    $("#scale").hide();
                    $("#scale2").hide();
                    $("#scale1").show();
                } else if ($(this).val() == 4) {
                    $("#scale").hide();
                    $("#scale1").hide();
                    $("#scale2").show();
                }
            });
        });
    </script>
</body>
</html>