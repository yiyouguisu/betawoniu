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
    .picList li{ float: left; margin-top: 2px; margin-right: 5px;}
</style>
<script type="text/javascript">
    $(function(){
        getchildren(0,true);
        initvals();
        $(".jgbox").delegate("select","change",function(){
            $(this).nextAll().remove();
            getchildren($(this).val(),true);
        });
    })

    function getchildren(a,b) {
        $.ajax({
            url: "{:U('admin/Expand/getchildren')}",
            async: false,
            data: { id: a },
            success: function (data) {
                data=eval("("+data+")");
                if (data != null && data.length > 0) {
                    var ahtml = "<select class=''>";
                    if(b)
                    {
                        ahtml += "<option value=''>--请选择--</option>";
                    }
                    for (var i = 0; i < data.length; i++) {
                        ahtml += "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
                    }
                    ahtml += "</select>";
                    $(".jgbox").append(ahtml);


                }
            }
        });
                    getval();
    }
    function getval()
    {
        var vals="";
        $(".jgbox select").each(function(){
            var val=$(this).val();
            if(val!=null&&val!="")
            {
                vals+=',';
                vals+=val;
            }
        });
        if(vals!="")
        {
            vals=vals.substr(1);
            $("#area").val(vals);
        }
    }
    function initvals()
    {
        var vals=$("#area").val();
        if(vals!=null&&vals!="")
        {
            var arr=new Array();
            arr=vals.split(",");
            for(var i=0;i<arr.length;i++)
            {
                if($.trim(arr[i]) !="")
                {
                    $(".jgbox select").last().val(arr[i]);
                    getchildren(arr[i],true);
                }
            }
        }
    }

</script>
<body class="J_scroll_fixed">
    <div class="wrap jj">

        <include file="Common:Nav" />
        <div class="common-form">
            <!---->
            <form method="post" action="{:U('Admin/House/add')}">
                <div class="h_a">民宿信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">发布者</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="hidden" name="uid" id="uid" required="required" value="" />
                                    <input type="text" class="input length_4 input_hd" placeholder="请选择游者" id="username" value="" readonly required>
                                    <input type="button" class="button" value="选择" onclick="omnipotent('selectid','{:U('Admin/Member/select')}','请选择发布者',1,700,400)">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">主题</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" required="required" name="title" class="input length_6 input_hd" placeholder="请输入主题" id="title" value="{$data.title}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">民宿名称</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" required="required" name="theme" class="input length_6 input_hd" placeholder="请输入民宿名称" id="theme" value="{$data.theme}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">文章地址</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" required="required" name="link" class="input length_6 input_hd" placeholder="请输入文章地址" id="link" value="{$data.link}">
                                </td>
                            </tr>
                            <tr>
                                <th>民宿LOGO：</br>(480*285px)</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="thumb" required="required" id="image" class="input length_5" value="" style="float: left" runat="server" ondblclick='image_priview(this.value);'>&nbsp; <input type="button" class="button" value="选择上传" id="uploadify"> <span class="gray"> 双击文本框查看图片</span>
                                </td>
                            </tr>
                            <!-- <tr>
                                <th>民宿地址<input type="hidden" class="input" name="area" id="area" value="{$data.area}"></th>
                                <td><span class="must_red">*</span><div  class="jgbox"></div></td>
                            </tr> -->
                            <!-- <tr>
                                <th>详细地址</th>
                                <td>
                                    <input type="text" name="address" class="input length_6 input_hd" placeholder="请输入民宿地址" id="address" value="{$data.address}">
                                </td>
                            </tr>

                            <tr>
                                <th>兑奖金额</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="exchangemoney" class="input length_6 input_hd" placeholder="请输入兑奖金额" id="exchangemoney" value="{$data.exchangemoney}">
                                </td>
                            </tr> -->

                            <!-- <tr>
                                <th>入住时间段</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="workstarttime" class="input length_2 J_datetime" value="{$data.workstarttime}" style="width:120px;">
                                    -
                                    <input type="text" class="input length_2 J_datetime" name="workendtime" value="{$data.workendtime}" style="width:120px;">
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <th>入住人数</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="mannum" class="input length_6 input_hd" placeholder="请输入民宿入住人数" id="mannum" value="{$data.mannum}">
                                </td>
                            </tr>
                            <tr>
                                <th>剩余房间数</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="wait_num" class="input length_6 input_hd" placeholder="请输入民宿房间剩余数量" id="wait_num" value="{$data.wait_num}">
                                </td>
                            </tr> -->
                            <tr>
                                <th>可使用抵用</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='checkbox' name='couponsrule[]' value='1' checked><span>全额抵用券</span></label>
                                        </li>
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='checkbox' name='couponsrule[]' value='2'><span>5折抵用券</span></label>
                                        </li>
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='checkbox' name='couponsrule[]' value='3'><span>8折抵用券</span>
                                            </label>
                                        </li>
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='checkbox' name='couponsrule[]' value='4'><span>投票兑换券</span>
                                            </label>
                                        </li>
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='checkbox' name='couponsrule[]' value='5'><span>邀请投票兑换券</span>
                                            </label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>民宿摘要</th>
                                <td>
                                    <textarea name="description" required="required" id="description" class="valid" style="width:500px;height:80px;">{$data.description}</textarea>
                                </td>
                            </tr>
                            <!-- <tr id="contenttr">
                                <th>民宿详情</th>
                                <td>
                                    <textarea name="content" id="content" style="width:100%;height:500px;">{$data.content}</textarea>
                                </td>
                            </tr> -->
                            <!-- <tr>
                                <th>属性</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label>
                                                <input type='radio' name='type' value='1'>
                                                <span>推荐</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='type' value='0' checked>
                                                <span>不推荐</span>
                                            </label>
                                        </li>
                                    </ul>
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
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <input type="hidden" name="applyid" value="{$data.id}" />
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
        var xss=parseInt({$key})||0;
        $(function () {
            $("#uploadify").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script'	: '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
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

            $("#uploadify1").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'	: '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/upload')}",//实现上传的程序
                'method': 'get',
                'folder': '/Uploads/images',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': "",//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    // alert(response);
                    getResultimglist(response, queueID);//获得上传的文件路径
                }
            });
            var albums = $("#albums");
            var str = "";
            function getResultimglist(content, queueID) {
                str = "<li id='imglist" + xss + "'>";
                str = str+"<textarea name=\"imglist["+xss+"][content]\" style='width:400px;height:200px;float:left' class='input'></textarea>";
                str=str+"<img src='" + content + "' style='width:210px;height:210px' title='移除' ondblclick=\"javascript:remove_div('" + queueID + "')\">";
                str = str+"<input type='hidden' name=\"imglist["+xss+"][thumb]\" value='" + content + "' style='width:310px;' class='input'>";
                str = str+"</li>";
                albums.append(str);
                xss++;
            }

        });
    </script>
</body>
</html>