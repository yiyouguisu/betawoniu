<include file="Common:Head" />
<script>
    $(function(){
        getchildren(0, '.jgbox', true);
        getchildren(0, '.jgbox1', true);
        initvals();
        $(".jgbox").delegate("select","change",function(){
            $(this).nextAll().remove();
            getchildren($(this).val(), ".jgbox", true);
        });
        $(".jgbox1").delegate("select", "change", function () {
            $(this).nextAll().remove();
            getchildren($(this).val(),".jgbox1", true);
        });
    })

    function getchildren(a,obj,b) {
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
                    $(obj).append(ahtml);
                }
            }
        });
                    getval(obj);
    }
    function getval(obj)
    {
        var vals = "";
        if (obj == '.jgbox') {
            $(".jgbox select").each(function () {
                var val = $(this).val();
                if (val != null && val != "") {
                    vals += ',';
                    vals += val;
                }
            });
            if (vals != "") {
                vals = vals.substr(1);
                $("#area").val(vals);
            }
        } else if (obj == '.jgbox1') {
            $(".jgbox1 select").each(function () {
                var val = $(this).val();
                if (val != null && val != "") {
                    vals += ',';
                    vals += val;
                }
            });
            if (vals != "") {
                vals = vals.substr(1);
                $("#hometown").val(vals);
            }
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
        var vals = $("#hometown").val();
        if (vals != null && vals != "") {
            var arr = new Array();
            arr = vals.split(",");
            for (var i = 0; i < arr.length; i++) {
                if ($.trim(arr[i]) != "") {
                    $(".jgbox1 select").last().val(arr[i]);
                    getchildren(arr[i], true);
                }
            }
        }
    }

</script>
<body class="J_scroll_fixed">
    <div class="wrap jj">
        <include file="Common:Nav" />
        <div class="common-form">

            <form method="post" action="{:U('Admin/member/add')}">
                <div class="h_a">会员基本信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">用户名</th>
                                <td>
                                    <input type="text" name="username" class="input" id="username" value="{$data.username}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">昵称</th>
                                <td>
                                    <input type="text" name="nickname" class="input" id="nickname" value="{$data.nickname}">
                                </td>
                            </tr>
                            <tr>
                                <th>用户类型</th>
                                <td>
                                    <select name="houseowner_status">
                                        <option value="0" selected>个人</option>
                                        <option value="1">房东</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>图像</th>
                                <td>
                                    <img id="head" src="{$data.head}" width="80" height="80" />
                                    <input type="hidden" name="head" id="image" class="input" value="{$data.head}" style="float: left" runat="server">&nbsp; <input type="button" class="button" value="选择上传" id="uploadify">
                                </td>
                                </td>
                            </tr>
                            <tr>
                                <th>密码</th>
                                <td>
                                    <input type="password" name="password" class="input" id="password" value="">
                                </td>
                            </tr>
                            <tr>
                                <th>确认密码</th>
                                <td>
                                    <input type="password" name="pwdconfirm" class="input" id="pwdconfirm" value="">
                                </td>
                            </tr>
                            <tr>
                                <th>手机号码</th>
                                <td>
                                    <input type="text" name="phone" class="input" id="phone" value="{$data.phone}" size="30">
                                </td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <td>
                                    <input type="text" name="email" class="input" id="email" value="{$data.email}" size="30">
                                </td>
                            </tr>
                            <tr>
                                <th>身份证号码</th>
                                <td>
                                    <input type="text" name="idcard" class="input" id="idcard" value="{$data.idcard}" size="30">
                                </td>
                            </tr>
                            <tr>
                                <th>真实姓名</th>
                                <td><input type="text" name="realname" class="input" id="realname" value="{$data.realname}"></td>
                            </tr>
                            <tr>
                                <th>生日</th>
                                <td><input type="text" name="birthday" class="input length_2 J_date" value="{$data.birthday}" style="width:120px;"></td>
                            </tr>
                            <tr>
                                <th>故乡<input type="hidden" class="input" name="hometown" id="hometown" value="{$data.hometown}"></th>
                                <td class="jgbox1"></td>
                            </tr>
                            <tr>
                                <th>居住地<input type="hidden" class="input" name="area" id="area" value="{$data.area}"></th>
                                <td class="jgbox"></td>
                            </tr>
                            <tr>
                                <th>详细地址</th>
                                <td><input type="text" name="address" class="input" id="address" value="{$data.address}" size="50"></td>
                            </tr>
                            <tr>
                                <th>性别</th>
                                <td>
                                    <select name="sex">
                                        <option value="1" selected>男</option>
                                        <option value="2">女</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>学历</th>
                                <td><input type="text" name="education" class="input" id="education" value="{$data.education}"></td>
                            </tr>
                            <tr>
                                <th>学校</th>
                                <td><input type="text" name="school" class="input" id="school" value="{$data.school}"></td>
                            </tr>
                            <tr>
                                <th>属相</th>
                                <td><input type="text" name="zodiac" class="input" id="zodiac" value="{$data.zodiac}"></td>
                            </tr>
                            <tr>
                                <th>星座</th>
                                <td><input type="text" name="constellation" class="input" id="constellation" value="{$data.constellation}"></td>
                            </tr>
                            <tr>
                                <th>个性签名</th>
                                <td><input type="text" name="info" class="input" id="info" value="{$data.info}"></td>
                            </tr>
                            <tr>
                                <th>血型</th>
                                <td><input type="text" name="bloodtype" class="input" id="bloodtype" value="{$data.bloodtype}"></td>
                            </tr>
                            <tr>
                                <th valign="top">个人特性：</th>
                                <td style="clear: both;">
                                    <volist name=":getlinkage(1)" id="vo">
                                        <label style="float: left; width: 100px;"><input name="characteristic[]" type="checkbox" value="{$vo.name}" <in name="vo['name']" value="$data.characteristic">checked</in> class="characteristic">{$vo.name}</label>
                                    </volist>
                                </td>
                            </tr>
                            <tr>
                                <th valign="top">个人爱好：</th>
                                <td style="clear: both;">
                                    <volist name=":getlinkage(2)" id="vo">
                                        <label style="float: left; width: 100px;"><input name="hobby[]" type="checkbox" value="{$vo.name}" <in name="vo['name']" value="$data.hobby">checked</in> class="hobby">{$vo.name}</label>
                                    </volist>
                                </td>
                            </tr>
                            <tr>
                                <th>状态</td>
                                <td>
                                    <select name="status">
                                        <option value="1" selected>开启</option>
                                        <option value="0">禁止</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="">
                    <div class="btn_wrap_pd">
                        <input type="hidden" name="group_id" value="1" />
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="__JS__/common.js?v"></script>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#uploadify").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'    : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method': 'get',
                'folder': '/Uploads/member',//服务端的上传目录
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
                    //alert(response);
                    getResult(response);//获得上传的文件路径
                }
            });

            var imgg = $("#image");
            function getResult(content) {
                imgg.val(content);
                $("#head").attr("src", content);
            }
        });
    </script>
</body>
</html>