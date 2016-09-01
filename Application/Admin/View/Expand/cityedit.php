<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap jj">
        <include file="Common:Nav"/>
        <div class="common-form">
            <form method="post" action="{:U('Admin/Expand/cityedit')}">
                <div class="h_a">基本信息</div>
                <div class="table_list">
                    <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
                        <tbody>
                            
                            <tr>
                                <td width="140">名称:</td>
                                <td><input type="text" class="input" name="name" id="name" value="{$data.name}" ></td>
                            </tr>
                             <tr id="img">
                                <td>图片：</td>
                                <td><input type="text" name="thumb" id="image" class="input length_5" value="{$data.thumb}" style="float: left"  runat="server" ondblclick='image_priview(this.value);'>&nbsp; <input type="button" class="button" value="选择上传" id="uploadify" > <span class="gray"> 双击文本框查看图片</span></td>
                            </tr>
                            <!-- <tr>
                                <td>附加数据:</td>
                                <td><input type="text" class="input" name="extravalue" id="extravalue" value="{$data.extravalue}" ></td>
                            </tr> -->
                            <tr>
                                <td>状态:</td>
                                <td><select name="status">
                                        <option value="1" <eq name="data.status" value="1">selected</eq>>启用</option>
                                        <option value="0" <eq name="data.status" value="0">selected</eq>>禁用</option>
                                    </select></td>
                            </tr>
                            <tr>
                                <td>热门:</td>
                                <td>
                                    <select name="ishot">
                                        <option value="1" <eq name="data.ishot" value="1">selected</eq>>是</option>
                                        <option value="0" <eq name="data.ishot" value="0">selected</eq>>否</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>排序:</td>
                                <td><input type="text" class="input" name="listorder" id="listorder" value="{$data.listorder}" ></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="">
                    <div class="btn_wrap_pd">
                          <input type="hidden" class="input" name="id" value="{$data.id}" >
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
    <link rel="stylesheet" type="text/css"  href="__PUBLIC__/Public/uploadify/uploadify.css" />
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
                    getResult(response);//获得上传的文件路径
                }
            });

            var imgg = $("#image");
            function getResult(content) {
                imgg.val(content);
            }
        });
    </script>
</body>
</html>