<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/Order/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> 
                    <span class="mr20">
                        下单时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">

                        订单类型：
                        <select class="select_2" name="ordertype" style="width:85px;">
                            <option value=""  <empty name="Think.get.ordertype">selected</empty>>全部</option>
                            <option value="1" <if condition=" $Think.get.ordertype eq '1'"> selected</if>>美宿订单</option>
                            <option value="2" <if condition=" $Think.get.ordertype eq '2'"> selected</if>>活动订单</option>
                        </select>
                        订单号：
                        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="{$Think.get.keyword}" placeholder="请输入订单号...">
                        
                        <button class="btn">搜索</button>
                    </span>
                </div>
            </div>
        </form> 

        <form action="{:U('Admin/Order/del')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="12%" align="center" >订单号</td>
                            <td width="8%" align="center" >下单用户</td>
                            <td width="6%" align="center" >订单类型</td>
                            <td width="8%" align="center" >订单金额</td>
                            <td width="8%" align="center" >优惠金额</td>
                            <td width="8%" align="center" >实付金额</td>
                            <td width="12%"  align="center" >订单时间</td>
                            <td width="6%"  align="center" >支付方式</td>
                            <td width="6%"  align="center" >支付状态</td>
                            <td width="6%"  align="center" >订单状态</td>
                            <td width="12%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                 <?php $money_total1=0;?>
                    <volist name="data" id="vo">
                        <tr class="productshow" data-id="{$vo.id}">
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.id}"></td>
                            <td align="center" >{$vo.orderid}</td>
                            <td align="center" >{:getuserinfo($vo['uid'])}</td>
                            <td align="center" >{:getordertype($vo['orderid'])}</td>
                            <td align="center" >
                                ￥<?php $money_total1+=$vo['total'];?>
                                {$vo.total|default="0.00"}
                            </td>
                            <td align="center" >{$vo.discount|default="0.00"}</td>
                            <td align="center" >{$vo.money|default="0.00"}</td>
                            <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                            <td align="center" >{:getpaystyle($vo['orderid'])}</td>
                            <td align="center" >{:getpaystatus($vo['pay_status'])}</td>
                            <td align="center" >{:getorderstatus($vo['status'])}</td>
                            <td align="center" > 
                                <if condition="$vo['status'] neq 4">
                                    <eq name="vo['status']" value="1">
                                        <a href="javascript:;" onClick="omnipotent('selectid','{:U('Admin/Order/review',array('orderid'=>$vo['orderid']))}','审核',1,700,300)">审核</a></br>
                                    </eq >
                                    <else />
                                    订单已完成<br/>{$vo.donetime|date="Y-m-d H:i:s",###}</br>
                                </if>
                                <a href="{:U('Admin/Order/docancel',array('orderid'=>$vo['orderid']))}">取消订单</a></br>
                                <a href="{:U('Admin/Order/doclose',array('orderid'=>$vo['orderid']))}" class="close">关闭订单</a></br>
                                <a href="javascript:;" onClick="omnipotent('selectid','{:U('Admin/Order/show',array('orderid'=>$vo['orderid']))}','查看详情',1,850,600)">查看详情</a></br>
                            </td>
                        </tr>

                    </volist>
                      <tr style="font-weight:bold">
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td align="center">小计:</th>
                        <td align="center">￥{$money_total1|default="0.00"}</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                      </tr>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages"> {$Page} </div>
                    <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>   

                    <if condition="authcheck('Admin/Order/del')">
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">删除</button>
                    </if>
                    </form>
                </div>
            </div>

            <div class="btn_wrap">
                <div class="btn_wrap_pd">
                        <form method="post" action="{:U('Admin/Orderexcel/excel')}">
                            <input type="hidden" value="1" name="search">
                            <input type="hidden" name="start_time" value="{$Think.get.start_time}" >
                            <input type="hidden"  name="end_time" value="{$Think.get.end_time}" >
                            <input type="hidden"  name="ordertype" value="{$Think.get.ordertype}" >
                            <input type="hidden"  name="keyword" value="{$Think.get.keyword}" >
                            <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">导出当前数据</button>
                        </form> 
                </div>
            </div>


    </div>

    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
    <script>
        $(function () {

        })

    </script>
</body>
</html>