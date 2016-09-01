<include file="Common:Head" />
<script type="text/javascript">
    window.setInterval(function () {
        reloadPage(window);
    }, 10000);
</script>
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <div class="table_list">
            <table width="100%" cellspacing="0">
                <thead>
                    <tr style="height: 60px; font-size: 18px; font-weight: bold;">
                        <td width="20%" align="center">订单编号</td>
                        <td width="80%" align="center">商品信息</td>
                    </tr>
                </thead>
                <tbody>
                    <volist name="data" id="vo">
                        <tr>
                            <td align="center">{$vo.orderid}</td>
                            <td align="center">
                                <table width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td width="100%" align="center" colspan="4">订单留言：{$vo.buyerremark|default="无"}</td>
                                        </tr>
                                        <tr>
                                            <td width="40%" align="left">商品名称</td>
                                            <td width="20%" align="center">商品数量</td>
                                            <td width="20%" align="center">商品规格</td>
                                            <td width="20%" align="center">需要称重</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <volist name="vo['productinfo']" id="v">
                                            <tr>
                                                <td align="left">{$v.productname}</td>
                                                <td align="center">{$v.nums|default="0"}</td>
                                                <td align="center">{$v.standard}{:getunit($v['unit'])}</td>
                                                <td align="center">
                                                    <eq name="v['product_type']" value="4">
                                                        是
                                                        <else />
                                                        否
                                                    </eq>
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
                <div class="pages" style="text-align: center;">{$Page} </div>
            </div>
        </div>

    </div>

    <script src="__JS__/common.js?v"></script>
</body>
</html>