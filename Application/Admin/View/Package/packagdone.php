<include file="Common:Head" /><body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/Package/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> 
                    <span class="mr20">
                        下单时间：
                        <input type="text" name="start_time" class="input length_2 J_datetime" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_datetime" name="end_time" value="{$Think.get.end_time}" style="width:80px;">
                        订单来源：
                        <select class="select_2" name="ordersource" style="width:85px;">
                            <option value=""  <empty name="Think.get.ordersource">selected</empty>>全部</option>
                            <option value="1" <if condition=" $Think.get.ordersource eq '1'"> selected</if>>手机web</option>
                            <option value="2" <if condition=" $Think.get.ordersource eq '2'"> selected</if>>App</option>
                            <option value="3" <if condition=" $Think.get.ordersource eq '3'"> selected</if>>饿了么</option>
                            <option value="4" <if condition=" $Think.get.ordersource eq '4'"> selected</if>>口碑外卖</option>
                            <option value="5" <if condition=" $Think.get.ordersource eq '5'"> selected</if>>售后订单</option>
                        </select>
                        订单类型：
                        <select class="select_2" name="ordertype" style="width:85px;">
                            <option value=""  <empty name="Think.get.ordertype">selected</empty>>全部</option>
                            <option value="1" <if condition=" $Think.get.ordertype eq '1'"> selected</if>>一般订单</option>
                            <option value="2" <if condition=" $Think.get.ordertype eq '2'"> selected</if>>预购订单</option>
                            <option value="3" <if condition=" $Think.get.ordertype eq '3'"> selected</if>>企业订单</option>
                            <option value="4" <if condition=" $Think.get.ordertype eq '4'"> selected</if>>称重订单 </option>
                        </select>
                        支付方式：
                        <select class="select_2" name="paytype" style="width:85px;">
                            <option value=""  <empty name="Think.get.paytype">selected</empty>>全部</option>
                            <option value="1" <if condition=" $Think.get.paytype eq '1'"> selected</if>>支付宝</option>
                            <option value="2" <if condition=" $Think.get.paytype eq '2'"> selected</if>>微信</option>
                            <option value="3" <if condition=" $Think.get.paytype eq '3'"> selected</if>>货到付款</option>
                        </select>
                        订单类型：
                        <select class="select_2" name="ordertype" style="width:85px;">
                            <option value=""  <empty name="Think.get.ordertype">selected</empty>>全部</option>
                            <option value="1" <if condition=" $Think.get.ordertype eq '1'"> selected</if>>普通订单</option>
                            <option value="2" <if condition=" $Think.get.ordertype eq '2'"> selected</if>>预购订单</option>
                            <option value="3" <if condition=" $Think.get.ordertype eq '3'"> selected</if>>企业订单</option>
                        </select>
                        <!-- 包装状态：
                        <select class="select_2" name="package_status" style="width:85px;">
                            <option value=""  <empty name="Think.get.package_status">selected</empty>>全部</option>
                            <option value="0" <if condition=" $Think.get.package_status eq '0'"> selected</if>>待包装</option>
                            <option value="1" <if condition=" $Think.get.package_status eq '1'"> selected</if>>包装中</option>
                            <option value="2" <if condition=" $Think.get.package_status eq '2'"> selected</if>>包装完成</option>
                        </select> -->
                        订单号：
                        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="{$Think.get.keyword}" placeholder="请输入订单号...">
                        <button class="btn">搜索</button>
                    </span>
                    </div>
            </div>
        </form> 

        <form action="{:U('Admin/Package/action')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="12%" align="center" >订单号</td>
                            <td width="10%" align="center" >订单来源</td>
                            <td width="12%" align="center" >订单金额</td>
                            <td width="12%"  align="center" >订单时间</td>
                            <td width="6%"  align="center" >支付方式</td>
                            <td width="15%"  align="center" >收货人信息</td>
                            <td width="15%"  align="center" >收货地址</td>
                            <td width="15%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr class="productshow" data-id="{$vo.id}">
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="orderids[]" value="{$vo.orderid}"></td>
                            <td align="center" >[<a href="javascript:;" data-href="{:U('Admin/Order/download',array('orderid'=>$vo['orderid']))}" onclick="image_priview('{$vo.ordercode}');">查看二维码</a>]{$vo.orderid}</td>
                            <td align="center" >{:getordersource($vo['ordersource'])}</td>
                            <td align="center" >{$vo.total}</br>配送费￥{$vo.delivery|default="0.00"}</td>
                            <td align="center" >{$vo.inputtime|date="Y-m-d",###}<br/>{$vo.inputtime|date="H:i:s",###}</td>
                            <td align="center" >{:getpaystyle($vo['orderid'])}</td>
                            <td align="center" >{$vo.name}<br/>{$vo.tel}</td>
                            <td align="center" >{:getarea($vo['area'])}<br/>{$vo.address}</td>
                            <td align="center" >
                                <if condition="$vo.package_status eq 0">待包装[<a href="{:U('Admin/Package/package',array('orderid'=>$vo['orderid']))}">包装</a>]</if>
                                <if condition="$vo.package_status eq 1">包装中[<a href="{:U('Admin/Package/packagedone',array('orderid'=>$vo['orderid']))}">包装完成</a>]</br>{:getAuser($vo['puid'])}</br>{$vo.package_time|date="Y-m-d H:i:s",###}</br></if>
                                <if condition="$vo.package_status eq 2">包装完成</br>{:getAuser($vo['puid'])}</br>{$vo.package_donetime|date="Y-m-d H:i:s",###}</br></if>
                                <a href="javascript:;" onClick="omnipotent('selectid','{:U('Admin/Order/orderprint',array('orderid'=>$vo['orderid']))}','打印订单',1,390,250)">打印</a>
                            </td>
                        </tr>
                        <tr id="product_{$vo.id}" style="color: rgb(24, 116, 237);background-color: rgb(230, 230, 230);display:none;" >
                            <td colspan="9">
                                <table width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td width="20%" align="left" >产品名称</td>
                                            <td width="10%" align="center" >产品价格</td>
                                            <td width="20%" align="center" >购买数量</td>
                                            <td width="10%" align="center" >商品单位</td>
                                            <td width="20%" align="center" >商品仓库</td>
                                            <td width="20%" align="center" >商品类型</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <volist name="vo['productinfo']" id="v">
                                            <tr>
                                                <td width="20%" align="left" >{$v.title}</td>
                                                <td width="10%" align="center" >{$v.price}</td>
                                                <td width="20%" align="center" >{$v.nums}</td>
                                                <td width="10%" align="center" >{$v.standard}{:getunit($v['unit'])}</td>
                                                <td width="20%" align="center" >{$v.storehouse}</td>
                                                <td width="20%" align="center" >
                                                    <if condition=" $v.product_type eq '0'"> [企业商品]</if>
                                                    <if condition=" $v.product_type eq '1'"> [一般商品]</if>
                                                    <if condition=" $v.product_type eq '2'"> [团购商品]</if>
                                                    <if condition=" $v.product_type eq '3'"> [预购商品]</if>
                                                    <if condition=" $v.product_type eq '4'"> 
                                                        [称重商品]
                                                        <if condition=" $v.isweigh eq 1"> 
                                                            已称重[{$v.weightime|date="Y-m-d H:i:s",###}]
                                                            <else /> 
                                                            未称重[<a href="javascript:;" onClick="omnipotent('selectid','{:U('Admin/Package/weigh',array('id'=>$v['id']))}','填写称重信息',1,700,400)">填写称重信息</a>]
                                                        </if>
                                                    </if>
                                                </td>
                                            </tr>
                                        </volist>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </volist>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages"> {$Page} </div>
                    
                </div>
            </div>
        </form>
            <div class="btn_wrap">
                <div class="btn_wrap_pd">
                    <if condition="authcheck('Admin/Package/excel')">
                        <form method="post" action="{:U('Admin/Package/excel')}">
                            <input type="hidden" value="1" name="search">
                            <input type="hidden" name="start_time" value="{$Think.get.start_time}" >
                            <input type="hidden"  name="end_time" value="{$Think.get.end_time}" >
                            <input type="hidden"  name="ordersource" value="{$Think.get.ordersource}" >
                            <input type="hidden"  name="paytype" value="{$Think.get.paytype}" >
                            <input type="hidden"  name="ordertype" value="{$Think.get.ordertype}" >
                            <input type="hidden"  name="package_status" value="{$Think.get.package_status}" >
                            <input type="hidden"  name="keyword" value="{$Think.get.keyword}" >
                            <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">导出当前数据</button>
                        </form> 
                    </if>
                </div>
            </div>


    </div>

    <script src="__JS__/common.js?v"></script>
        <script src="__JS__/content_addtop.js"></script>
    <script>
        $(function () {
            $(".productshow a").click(function () {
                var href = $(this).attr("href");
                window.location.href = href;
                return false;
            })
             $(".productshow").click(function () {
                 var obj = "#product_" + $(this).data("id");
                 $(obj).toggle();
             })
            
        })
    </script>
</body>
</html>