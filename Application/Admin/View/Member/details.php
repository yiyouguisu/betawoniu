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
        <div class="pop_nav" style="margin-bottom:0px">
            <ul class="J_tabs_nav">
                <li <empty name="type"> class="current"</empty> data-type="{$type}"><a href="javascript:;;">基本信息</a></li>
                <li <eq name="type" value="2"> class="current"</eq> data-type="{$type}"><a href="javascript:;;">优惠券</a></li>
            </ul>
        </div>
        <form name="myform" id="myform" method="post" enctype="multipart/form-data">
            <div class="J_tabs_contents" style="width:760px">
                <div class="tba">
                    <div class="table_full">
                        <table width="100%" class="table_form">
                            <tr>
                                <th width="130">用户名：</th>
                                <td width="200">{$data.username}</td>
                                <th width="130">认证情况：</th>
                                <td width="200">{:getlevelinfo($data['id'])}</td>
                            </tr>
                            <tr>
                                <th>状态：</th>
                                <td><if condition="$data.status eq 0">冻结<else />开启</if></td>
                                <th>昵称：</th>
                                <td>{$data.nickname}</td>
                            </tr>
                            <tr>
                                <th>真实姓名：</th>
                                <td>{$data.realname|default="未填写"}</td>
                                <th>身份证号：</th>
                                <td>{$data.idcard|default="未填写"}</td>
                            </tr>
                            <tr>
                                <th>手机号码：</th>
                                <td>{$data.phone|default="未填写"}</td>
                                <th>邮箱：</th>
                                <td>{$data.email|default="未填写"}</td>
                            </tr>
                            <tr>
                                <th>家乡：</th>
                                <td>{:getarea($data['hometown'])}</td>
                                <th>居住区域：</th>
                                <td>{:getarea($data['area'])}{$data.address}</td>
                            </tr>
                            <tr>
                                <th>性别：</th>
                                <td><if condition="$data.sex eq 1">男</if><if condition="$data.sex eq 2">女</if><if condition="$data.sex eq 0">默认</if></td>
                                <th>生日：</th>
                                <td>{$data.birthday|default="未填写"}</td>
                            </tr>
                            <tr>
                                <th>学历：</th>
                                <td>{$data.education|default="未填写"}</td>
                                <th>学校：</th>
                                <td>{$data.school|default="未填写"}</td>
                            </tr>
                            <tr>
                                <th>属相：</th>
                                <td>{$data.zodiac|default="未填写"}</td>
                                <th>星座：</th>
                                <td>{$data.constellation|default="未填写"}</td>
                            </tr>
                            
                            <tr>
                                <th>血型：</th>
                                <td>{$data.bloodtype|default="未填写"}</td>
                                <!--<th>可用积分：</th>
                                <td>{$data.useintegral|default="0"}分</td>-->
                                <th>钱包余额：</th>
                                <td>{$data.usemoney|default="0.00"}元</td>
                            </tr>
                            <tr>
                                <th>个人特性：</th>
                                <td>{$data.characteristic|default="未选择"}</td>
                                <th>个人爱好：</th>
                                <td>{$data.hobby|default="未选择"}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tba">
                    <div class="table_full">
                        <table width="100%" class="table_form">
                            <thead>
                                <tr>
                                    <td width="20%" align="center">优惠券名称</td>
                                    <td width="6%" align="center">数量</td>
                                    <td width="6%" align="center">价格</td>
                                    <td width="15%" align="center">适用范围</td>
                                    <td width="6%" align="center">状态</td>
                                    <td width="15%" align="center">有效时间</td>
                                    <td width="15%" align="center">发放时间</td>
                                </tr>
                            </thead>
                            <tbody>
                                <foreach name="vouchers" item="vo">
                                    <tr>
                                        <td align="center">{$vo.title}</td>
                                        <td align="center">{$vo.num}</td>
                                        <td align="center">{$vo.price}</td>
                                        <td align="center">消费满元{$vo.range}可使用</td>
                                        <td align="center">
                                            <eq name="vo['usestatus']" value="1">可用</eq>
                                            <eq name="vo['usestatus']" value="0">不可用</eq>
                                        </td>
                                        <td align="center">{$vo.validity_endtime|date="Y-m-d H:i:s",###}</td>
                                        <td align="center">
                                            {$vo.inputtime|date="Y-m-d H:i:s",###}
                                        </td>
                                    </tr>
                                </foreach>
                            </tbody>
                        </table>
                        <div class="p10">
                            <div class="pages ajaxpagebar" data-id="2"> {$Page2} </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
    <script>
        $('.ajaxpagebar a').live("click", function () {
            var type = $(this).parents("div.ajaxpagebar").data("id");
            var geturl = $(this).attr('href');
            window.location.href = geturl + '&type=' + type;

            return false;
        })

    </script>
</body>
</html>