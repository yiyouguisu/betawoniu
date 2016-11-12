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
        <div class="pop_nav" style="margin-bottom:0px">
            <ul class="J_tabs_nav">
                <li class="current"><a href="javascript:;;">优惠券使用规则</a></li>
                <li><a href="javascript:;;">中奖码使用规则</a></li>
            </ul>
        </div>
        <form id="myform" method="post" enctype="multipart/form-data" action="{:U('Admin/Config/service')}">
            <div class="h_a"></div>
            <div class="J_tabs_contents">
                
                <div class="tba">
                    <div class="table_full">
                        <textarea name="coupons_rule" id="coupons_rule">{$Site.coupons_rule}</textarea>
                    </div>
                </div>
                <div class="tba">
                    <div class="table_full">
                        <textarea name="chongjiangcode_rule" id="chongjiangcode_rule">{$Site.chongjiangcode_rule}</textarea>
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
        CKEDITOR.replace('coupons_rule', { toolbar: 'Full' });
        CKEDITOR.replace('chongjiangcode_rule', { toolbar: 'Full' });
    </script>
</body>
</html>