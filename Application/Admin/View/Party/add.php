<include file="Common:Head" />
<script>
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
    var url = "{:U('Admin/Party/get_hostel')}";
    function get_hostel() {
        var uid=$("input[name='uid']").val();
        $.ajax({
            type: "GET",
            url: url,
            data: { 'uid': uid },
            dataType: "json",
            success: function (data) {
                if(data!=null){
                    $('#hostel').html("<option value=''>请选择适用美宿</option>");
                    $.each(data, function (no, items) {
                        $('#hostel').append('<option value="' + items.id + '">' + items.title + '</option>');
                    });
                }
            }
        });
    }
</script>
<body class="J_scroll_fixed">
    <div class="wrap jj">

        <include file="Common:Nav" />
        <div class="common-form">
            <!---->
            <form method="post" action="{:U('Admin/Party/add')}">
                <div class="h_a">活动信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">发布者</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="hidden" name="uid" id="uid" value="" />
                                    <input type="text" class="input length_4 input_hd" placeholder="请选择发布者" id="username" value="" readonly required>
                                    <input type="button" class="button" value="选择" onclick="omnipotent('selectid','{:U('Admin/Member/select',array('type'=>2))}','请选择发布者',1,700,400)">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">标题</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入标题" id="title" value="{$data.title}">
                                </td>
                            </tr>
                            
                            <tr id="img">
                                <th>活动图片：</th>
                                <td>
                                    <div class="thumb" style="display:inline-block;"></div><input type="hidden" id="thumb" name="thumb" value="{$data.thumb}" style="float: left"  runat="server">&nbsp; <input type="button" class="button" value="选择上传" id="uploadify" ></td>
                                </td>
                            </tr>
                            
                            <tr>
                                <th width="80">活动类型</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label><input type='radio' name='partytype' value='1' checked><span>亲子类</span></label>
                                        </li>
                                        <li>
                                            <label><input type='radio' name='partytype' value='2'><span>情侣类</span></label>
                                        </li>
                                        <li>
                                            <label><input type='radio' name='partytype' value='3'><span>家庭出游</span></label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">适用美宿</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <select class="select_2" name="hid" id="hostel">
                                        <option value="">请选择适用美宿</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">活动特色</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <select class="select_2" name="catid">
                                        <option value="">请选择活动特色</option>
                                        <volist name="partycate" id="vo">
                                            <option value="{$vo.id}">{$vo.catname}</option>
                                         </volist>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <th width="80">报名费用</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="money" class="input length_6 input_hd" placeholder="请输入报名费用" id="money" value="{$data.money}">
                                    <input type="checkbox" name="isfree" value="1" />免费活动
                                </td>
                            </tr>
                            <tr>
                                <th>地区<input type="hidden" class="input" name="area" id="area" value="{$data.area}"></th>
                                <td class="jgbox"></td>
                            </tr>
                            <tr>
                                <th>详细地址</th>
                                <td>
                                    <input type="text" name="address" class="input length_6 input_hd" placeholder="请输入详细地址" id="address" value="{$data.address}">
                                </td>
                            </tr>

                            <tr>
                                <th>活动时间</th>
                                <td>
                                    <input type="text" name="starttime" class="input length_2 J_date starttime" value="{$data.begintime}" style="width:120px;">
                                    -
                                    <input type="text" class="input length_2 J_date endtime" name="endtime" value="{$data.endtime}" style="width:120px;">
                                </td>
                            </tr>
                            <tr>
                                <th>人数限制</th>
                                <td>
                                    <input type="number" name="start_numlimit" class="input length_2" value="{$data.start_numlimit}" style="width:120px;">
                                    -
                                    <input type="number" class="input length_2" name="end_numlimit" value="{$data.end_numlimit}" style="width:120px;">
                                </td>
                            </tr>
                            <tr>
                                <th>促销活动 </th>
                                <td>活动报名满<input type="text" name="vouchersrange" class="input length_2"  placeholder="请输入金额" id="vouchersrange" value="{$data.vouchersrange}">元金额送
                                    <input type="text" name="vouchersdiscount" class="input length_2"  placeholder="请输入金额" id="vouchersdiscount" value="{$data.vouchersdiscount}">元金额的抵用券
                                </td>
                            </tr>
                            <tr>
                                <th>活动摘要</th>
                                <td>
                                    <textarea name="description" id="description" class="valid" style="width:500px;height:80px;">{$data.description}</textarea>
                                </td>
                            </tr>
                            <tr id="contenttr">
                                <th>活动详情</th>
                                <td>
                                    <textarea name="content" id="content" style="width:100%;height:500px;">{$data.content}</textarea>
                                </td>
                            </tr>
                            <tr id="contenttr">
                                <th>取消报名规则</th>
                                <td>
                                    <textarea name="cancelrule" id="cancelrule" style="width: 100%; height: 500px;">{$data.cancelrule}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>属性</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label>
                                                <input type='radio' name='isindex' value='1'>
                                                <span>推荐</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='isindex' value='0' checked>
                                                <span>不推荐</span>
                                            </label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>精品</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label>
                                                <input type='radio' name='type' value='1'>
                                                <span>是</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='type' value='0' checked>
                                                <span>否</span>
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
                'buttonImg': '__PUBLIC__/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    $(".thumb").html("<img src='"+response+"' width='202px' height='152px'  />");
                    $("input[name='thumb']").val(response);
                }
            });
        });
    </script>
</body>
</html>