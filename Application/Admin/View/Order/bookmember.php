<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="20%" align="center" >真实姓名</td>
                            <td width="20%" align="center" >身份证号码</td>
                            <td width="20%" align="center" >手机号码</td>
                            <td width="20%" align="center" >主报人</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr class="productshow" data-id="{$vo.id}">
                            <td align="center" >{$vo.realname}</td>
                            <td align="center" >{$vo.idcard}</td>
                            <td align="center" >{$vo.phone}</td>
                            <td align="center" >
                                <eq name="vo['linkmanid']" value="0">是<else />否</eq>
                            </td>
                        </tr>
                    </volist>
                    </tbody>
                </table>
    
            <div class="p10">
                <div class="pages"> {$Page} </div>
            </div>
        <div class="btn_wrap">
                <div class="btn_wrap_pd">
                     <button class="btn btn_submit mr10 " type="button" onclick="javascript:history.go(-1)">返回</button>
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