<include file="Common:Head" />
<include file="Common:ueditor" />
<style type="text/css">
    .col-auto {
        overflow: hidden;
        _zoom: 1;
        _float: left;
        border: 1px solid #c2d1d8;
    }

    .col-right {
        float: right;
        width: 210px;
        overflow: hidden;
        margin-left: 6px;
        border: 1px solid #c2d1d8;
    }

    body fieldset {
        border: 1px solid #D8D8D8;
        padding: 10px;
        background-color: #FFF;
    }

        body fieldset legend {
            background-color: #F9F9F9;
            border: 1px solid #D8D8D8;
            font-weight: 700;
            padding: 3px 8px;
        }

    .picList li {
        float: left;
        margin-top: 2px;
        margin-right: 5px;
    }
</style>
<script type="text/javascript">
    $(function () {
        var url = "{:U('Admin/Ueditor/index')}";
        var ue2 = UE.getEditor('description', {
            serverUrl: url,
            UEDITOR_HOME_URL: '__Editor__/UEditor/',
        });
        ue2.ready(function () {
            ue2.execCommand('serverparam', {
                'userid': '1',
                'username': 'admin',
            });
        });

    })

</script>
<body class="J_scroll_fixed">
    <div class="wrap jj">

        <include file="Common:Nav" />
        <div class="common-form">
            <!---->
            <form method="post" action="{:U('Admin/Vote/add')}">
                <div class="h_a">活动信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">标题</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入标题" id="title" value="{$data.title}">
                                </td>
                            </tr>
                            <tr id="shop">
                                <th width="80">活动适用民宿</th>
                                <td><span class="must_red">*</span>
                                    <select name="hid">
                                        <option value="">请选择民宿</option>
                                        <volist name="shop" id="vo">
                                            <option value="{$vo.id}">{$vo.title}</option>
                                        </volist>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>抽奖时间</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="starttime" class="input length_2 J_date" value="{$data.starttime}" style="width: 120px;">
                                    -
                                    <input type="text" class="input length_2 J_date" name="endtime" value="{$data.endtime}" style="width: 120px;">
                                </td>
                            </tr>
                            <tr>
                                <th>入住时间</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="in_starttime" class="input length_2 J_date" value="{$data.in_starttime}" style="width: 120px;">
                                    -
                                    <input type="text" class="input length_2 J_date" name="in_endtime" value="{$data.in_endtime}" style="width: 120px;">
                                </td>
                            </tr>
                            <tr>
                                <th width="140">活动中奖人数限制:</th>
                                <td><span class="must_red">*</span>
                                    <input type="number" min="1" class="input" name="voterewardnum" value="{$data.voterewardnum}" size="40">
                                </td>
                            </tr>
                            <!--<tr>
                                <th width="140">活动投票限制:</th>
                                <td>
                                    <input type="number" min="1" class="input" name="minvotenum" value="{$data.minvotenum}" size="40">
                                </td>
                            </tr>-->
                            <tr>
                                <th width="140">活动中奖人数限制设置:</th>
                                <td><span class="must_red">*</span>
                                    <table width="100%" class="table_form contentWrap">
                                        <tbody>
                                            <volist name="gift" id="vo">
                                                <tr>
                                                    <th width="80">{$vo.prize}</th>
                                                    <td>
                                                        <input type="hidden" class="input" name="gift[{$key}][rank]" value="{$vo.rank}" size="40">
                                                        <input type="number" min="0" class="input" name="gift[{$key}][v]" value="" size="40">
                                                    </td>
                                                </tr>
                                            </volist>
                                            <tr>
                                                    <td colspan="2">
                                                        上述奖项中奖人数加起来为活动中奖人数限制数
                                                    </td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <th>活动规则</th>
                                <td>
                                    <textarea name="description" id="description" style="width: 100%; height: 500px;">{$data.description}</textarea>
                                </td>
                            </tr>
                            <tr id="contenttr">
                                <th>活动详情</th>
                                <td>
                                    <textarea name="content" id="content" style="width: 100%; height: 500px;">{$data.content}</textarea>
                                </td>
                            </tr>

                            <tr>
                                <th>审核</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label>
                                                <input type='radio' name='status' value='2' checked>
                                                <span>审核</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='status' value='1'>
                                                <span>未审核</span>
                                            </label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#uploadify").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    $("#image").val(response);
                }
            });
        });
    </script>
</body>
</html>