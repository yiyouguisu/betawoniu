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
            <div class="table_full">
                <form class="J_ajaxForm" method="post" action="{:U('Admin/Vote/choujiang')}">
                    <div class="bk10"></div>
                    <div class="h_a">抽奖信息</div>
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">福彩3D中奖码</th>
                                <td>
                                    <input type="text" class="input" name="basecode" value="{$data.basecode}" /></td>
                            </tr>
                            <tr>
                                <th width="80">基数:</th>
                                <td>
                                    <input type="number" min="1" class="input" name="basenum" value="{$data.basenum}" size="40">
                                    <span class="gray">基数应该小于本期活动抽奖码总数</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="btn_wrap" style="position: fixed;bottom: 0;left: 0;width: 100%;z-index: 999;">
                        <div class="btn_wrap_pd">
                            <input type="hidden" name="id" value="{$data.id}">
                            <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="__JS__/common.js?v"></script>
</body>
</html>