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
<body class="J_scroll_fixed">
    <div class="wrap jj">
        <include file="Common:Nav" />
        <div class="common-form">
            <form method="post" action="{:U('Admin/Inn/theme')}">
                <div class="h_a">评选美宿主题</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">主题名称</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入主题" id="title" value="{$data.title}">
                                </td>
                            </tr>
                            <tr id="img">
                                <th>主题logo：</th>
                                <td>
                                    <div class="thumb" style="display:inline-block;"><img src="{$data.logo}"  width='200px' height='132px'></div><input type="hidden" id="logo" name="logo" value="{$data.logo}" style="float: left"  runat="server">&nbsp; <input type="button" class="button" value="选择上传" id="uploadify" ></td>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">活动摘要</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="abstract" class="input length_6 input_hd" placeholder="请输入摘要" id="abstract" value="{$data.abstract}">
                                    <span class="gray">*用于微信分享</span>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">活动规则链接</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="link" class="input length_6 input_hd" placeholder="请输入规则链接" id="link" value="{$data.link}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">评选规则</th>
                                <td>
                                    <textarea name="description" id="description">{$data.description}</textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
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
        var xss=parseInt({$key})||0;
        CKEDITOR.replace('description', { toolbar: 'Full' });
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
                'buttonImg': '__PUBLIC__/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    $(".thumb").html("<img src='"+response+"' width='200px' height='132px'  />");
                    $("input[name='logo']").val(response);
                }
            });

        });
    </script>
</body>
</html>