<include file="Common:Head" />

<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav" />

        <form name="myform" id="myform" action="{:U('Admin/Roomcate/add')}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="type" value="1">
            <div class="J_tabs_contents">

                <div class="h_a">基本属性</div>
                <div class="table_full">
                    <table width="100%" class="table_form ">
                        <tr id="normal_add">
                            <th width="200">名称：</th>
                            <td>
                                <input type="text" name="catname" id="catname" class="input" value="">
                            </td>
                        </tr>
                        <tr id="logo">
                            <th>灰色展示图：</th>
                            <td>
                                <input type="text" name="gray_thumb" id="gray_thumb" class="input length_5" value="{$data.gray_thumb}" style="float: left" runat="server" ondblclick='image_priview(this.value);'>&nbsp;
                                <input type="button" class="button" value="选择上传" id="uploadify">
                                <span class="gray">双击文本框查看图片</span>
                            </td>
                        </tr>
                        <tr id="logo">
                            <th>蓝色展示图：</th>
                            <td>
                                <input type="text" name="blue_thumb" id="blue_thumb" class="input length_5" value="{$data.blue_thumb}" style="float: left" runat="server" ondblclick='image_priview(this.value);'>&nbsp;
                                <input type="button" class="button" value="选择上传" id="uploadify1">
                                <span class="gray">双击文本框查看图片</span>
                            </td>
                        </tr>
                        <tr id="logo">
                            <th>红色展示图：</th>
                            <td>
                                <input type="text" name="red_thumb" id="red_thumb" class="input length_5" value="{$data.red_thumb}" style="float: left" runat="server" ondblclick='image_priview(this.value);'>&nbsp;
                                <input type="button" class="button" value="选择上传" id="uploadify2">
                                <span class="gray">双击文本框查看图片</span>
                            </td>
                        </tr>
                        <tr id="logo">
                            <th>黑色展示图：</th>
                            <td>
                                <input type="text" name="black_thumb" id="black_thumb" class="input length_5" value="{$data.black_thumb}" style="float: left" runat="server" ondblclick='image_priview(this.value);'>&nbsp;
                                <input type="button" class="button" value="选择上传" id="uploadify3">
                                <span class="gray">双击文本框查看图片</span>
                            </td>
                        </tr>
                        <!-- <tr>
                            <th>特色</th>
                            <td>
                                <ul class="switch_list cc ">
                                    <li>
                                        <label>
                                            <input type='radio' name='ishot' value='1'>
                                            <span>是</span>
                                        </label>
                                    </li>
                                    <li>
                                        <label>
                                            <input type='radio' name='ishot' value='0' checked>
                                            <span>否</span>
                                        </label>
                                    </li>
                                </ul>
                            </td>
                        </tr> -->
                        <tr>
                            <th>显示排序：</th>
                            <td>
                                <input type="text" name="listorder" id="listorder" class="input" value="0">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="btn_wrap">
                <div class="btn_wrap_pd">
                    <button class="btn btn_submit mr10 " type="submit">提交</button>
                </div>
            </div>
        </form>
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
                //'script'  : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': 2100000,//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    $("#gray_thumb").val(response);
                }
            });
            $("#uploadify1").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'  : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': 2100000,//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    $("#blue_thumb").val(response);
                }
            });
            $("#uploadify2").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'  : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': 2100000,//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    $("#red_thumb").val(response);
                }
            });
            $("#uploadify3").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'  : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': 2100000,//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    $("#black_thumb").val(response);
                }
            });
        });
    </script>
</body>
</html>