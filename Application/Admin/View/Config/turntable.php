<include file="Common:Head" />
<body class="J_scroll_fixed">
    <style>
        .pop_nav {
            padding: 0px;
        }

            .pop_nav ul {
                border-bottom: 1px solid green;
                padding: 0 5px;
                height: 25px;
                clear: both;
            }

                .pop_nav ul li.current a {
                    border: 1px solid green;
                    border-bottom: 0 none;
                    color: #333;
                    font-weight: 700;
                    background: #F3F3F3;
                    position: relative;
                    border-radius: 2px;
                    margin-bottom: -1px;
                }
    </style>
    <div class="wrap J_check_wrap">
        <include file="Common:Nav" />
        <div class="pop_nav" style="margin-bottom: 0px">
            <ul class="J_tabs_nav">
                <li class="current">
                    <a href="javascript:;;">大转盘活动配置</a></li>
                <li class="">
                    <a href="javascript:;;">大转盘活动规则</a></li>
            </ul>
        </div>
        <form id="myform" method="post" enctype="multipart/form-data" action="{:U('Admin/Config/service')}">
            <div class="h_a"></div>
            <div class="J_tabs_contents">
                <div class="tba">
                    <div class="table_full">
                        <table cellpadding="0" cellspacing="0" width="100%" class="table_form">
                            <tr>
                                <th width="140">大转盘活动时间</th>
                                <td>
                                    <input type="text" name="party_starttime" class="input length_2 J_date" value="{$Site.party_starttime}" style="width: 120px;">
                                    <input type="text" class="input length_2 J_date" name="party_endtime" value="{$Site.party_endtime}" style="width: 120px;">
                                </td>
                            </tr>
                            <tr>
                                <th>大转盘活动一周抽取限制:</th>
                                <td>
                                    <input type="number" class="input" name="party_week_num" value="{$Site.party_week_num}" size="40">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="tba">
                    <div class="table_full">
                        <textarea name="turntablerule" id="turntablerule">{$Site.turntablerule}</textarea>
                    </div>
                </div>
            </div>
            <div class="btn_wrap">
                <div class="btn_wrap_pd">
                    <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
                </div>
            </div>
        </form>
    </div>
    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('turntablerule', { toolbar: 'Full' });
    </script>
</body>
</html>