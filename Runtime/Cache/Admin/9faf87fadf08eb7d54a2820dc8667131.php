<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<title>网站系统管理后台</title>
<link href="/Public/Admin/css/admin_style.css" rel="stylesheet" />
<link href="/Public/Admin/js/artDialog/skins/default.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/Editor/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "",
    JS_ROOT: "/Public/Admin/js/",
    TOKEN: "d8a7e4212dd72764fc54360bc619692c_0be21a07a2313806c7f61fc129e26832"
};
</script>
<script src="/Public/Admin/js/wind.js"></script>
<script src="/Public/Admin/js/jquery.js"></script>
<script src="/Public/Admin/js/layer/layer.js"></script>
<script src="/Public/Admin/js/jquery.cookie.js"></script>
<script>
    $(document).ready(function(){
        $('a.del').click(function(){
             if(confirm("您确定要删除此信息？")){
                 return true;
            }else{
                return false;
            }
        });
        $('a.cancel').click(function () {
            if (confirm("您确定要取消此订单？")) {
                return true;
            } else {
                return false;
            }
        });
        $('a.close').click(function () {
            if (confirm("您确定要关闭此订单？")) {
                return true;
            } else {
                return false;
            }
        });

        $("button.J_ajax_submit_btn").click(function(){
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement(); 
                return true;
            }
        })
    });
</script>
</head>
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
            url: "<?php echo U('admin/Expand/getchildren');?>",
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
<script type="text/javascript" charset="utf-8" src="/Public/Editor/UEditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Editor/UEditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Editor/UEditor/lang/zh-cn/zh-cn.js"></script>

<script>
    $(function(){
        var url="<?php echo U('Admin/Ueditor/index');?>";
        var ue = UE.getEditor('content',{
            serverUrl :url,
            UEDITOR_HOME_URL:'/Public/Editor/UEditor/',
        });
        var ue1 = UE.getEditor('contact',{
            serverUrl :url,
            UEDITOR_HOME_URL:'/Public/Editor/UEditor/',
        });
        UE.getEditor('cancelrule',{
            serverUrl :url,
            UEDITOR_HOME_URL:'/Public/Editor/UEditor/',
        });
        ue1.ready(function(){
            ue1.execCommand('serverparam', {
                'userid': '1',
                'username': 'admin',
            });
        });
        
    })
</script>
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
    var url = "<?php echo U('Admin/Party/get_hostel');?>";
    $(function(){
        get_hostel();
    })
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
                        if (items.id == "<?php echo ($data['hid']); ?>") {
                            $('#hostel').append('<option value="' + items.id + '"selected>' + items.title + '</option>');
                        } else {
                            $('#hostel').append('<option value="' + items.id + '">' + items.title + '</option>');
                        }
                    });
                }
            }
        });
    }
</script>
<body class="J_scroll_fixed">
    <div class="wrap jj">
        <?php  $getMenu = \Admin\Controller\PublicController::getMenu(); if($getMenu) { ?>
<div class="nav">
  <ul class="cc">
    <?php
 foreach($getMenu as $r){ $name = $r['name']; $app=explode("/",$r['name']); $action=$app[1].$app[2]; ?>
    <li <?php echo $action==CONTROLLER_NAME.ACTION_NAME?'class="current"':""; ?>><a href="<?php echo U("".$name."");?>"><?php echo $r['title'];?></a></li>
    <?php
 } ?>
  </ul>
</div>
<?php } ?>
        <div class="common-form">
            <form method="post" action="<?php echo U('Admin/Party/edit');?>">
                <div class="h_a">活动信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">发布者</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="hidden" name="uid" id="uid" value="<?php echo ($data["uid"]); ?>" />
                                    <input type="text" class="input length_4 input_hd" placeholder="请选择发布者" id="username" value="<?php echo ($data["username"]); ?>" readonly required>
                                    <input type="button" class="button" value="选择" onclick="omnipotent('selectid','<?php echo U('Admin/Member/select',array('type'=>2));?>','请选择发布者',1,700,400)">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">标题</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入标题" id="title" value="<?php echo ($data["title"]); ?>">
                                </td>
                            </tr>

                            <tr id="img">
                                <th>活动图片：</th>
                                <td>
                                    <div class="thumb" style="display:inline-block;"><img src="<?php echo ($data["thumb"]); ?>"  width='202px' height='152px'></div><input type="hidden" id="thumb" name="thumb" value="<?php echo ($data["thumb"]); ?>" style="float: left"  runat="server">&nbsp; <input type="button" class="button" value="选择上传" id="uploadify" ></td>
                                </td>
                            </tr>
                            
                            <tr>
                                <th width="80">活动类型</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label><input type='radio' name='partytype' value='1' <?php if(($data['partytype']) == "1"): ?>checked<?php endif; ?>><span>亲子类</span></label>
                                        </li>
                                        <li>
                                            <label><input type='radio' name='partytype' value='2' <?php if(($data['partytype']) == "2"): ?>checked<?php endif; ?>><span>情侣类</span></label>
                                        </li>
                                        <li>
                                            <label><input type='radio' name='partytype' value='3' <?php if(($data['partytype']) == "3"): ?>checked<?php endif; ?>><span>家庭出游</span></label>
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
                                        <?php if(is_array($partycate)): $i = 0; $__LIST__ = $partycate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $data['catid']): ?>selected<?php endif; ?>><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <th width="80">报名费用</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="money" class="input length_6 input_hd" placeholder="请输入报名费用" id="money" value="<?php echo ($data["money"]); ?>">
                                    <input type="checkbox" name="isfree" value="1" <?php if($data['isfree'] == 1): ?>checked<?php endif; ?>/>免费活动
                                </td>
                            </tr>
                            <tr>
                                <th>地区<input type="hidden" class="input" name="area" id="area" value="<?php echo ($data["area"]); ?>"></th>
                                <td class="jgbox"></td>
                            </tr>
                            <tr>
                                <th>详细地址</th>
                                <td>
                                    <input type="text" name="address" class="input length_6 input_hd" placeholder="请输入详细地址" id="address" value="<?php echo ($data["address"]); ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>活动时间</th>
                                <td>
                                    <input type="text" name="starttime" class="input length_2 J_date" value="<?php echo ($data["starttime"]); ?>" style="width:120px;">
                                    -
                                    <input type="text" class="input length_2 J_date" name="endtime" value="<?php echo ($data["endtime"]); ?>" style="width:120px;">
                                </td>
                            </tr>
                            <tr>
                                <th>人数限制</th>
                                <td>
                                    <input type="number" name="start_numlimit" class="input length_2" value="<?php echo ($data["start_numlimit"]); ?>" style="width:120px;">
                                    -
                                    <input type="number" class="input length_2" name="end_numlimit" value="<?php echo ($data["end_numlimit"]); ?>" style="width:120px;">
                                </td>
                            </tr>
                            <tr>
                                <th>促销活动 </th>
                                <td>活动报名满<input type="text" name="vouchersrange" class="input length_2"  placeholder="请输入金额" id="vouchersrange" value="<?php echo ($data["vouchersrange"]); ?>">元金额送
                                    <input type="text" name="vouchersdiscount" class="input length_2"  placeholder="请输入金额" id="vouchersdiscount" value="<?php echo ($data["vouchersdiscount"]); ?>">元金额的抵用券
                                </td>
                            </tr>
                            <tr>
                                <th>活动摘要</th>
                                <td>
                                    <textarea name="description" id="description" class="valid" style="width:500px;height:80px;"><?php echo ($data["description"]); ?></textarea>
                                    <span class="gray">不填写会自动截取内容正文的前250个字符</span>
                                </td>
                            </tr>
                            <tr id="contenttr">
                                <th>活动详情</th>
                                <td>
                                    <textarea name="content" id="content" style="width:100%;height:500px;"><?php echo ($data["content"]); ?></textarea>
                                </td>
                            </tr>
                            <tr id="contenttr">
                                <th>取消报名规则</th>
                                <td>
                                    <textarea name="cancelrule" id="cancelrule" style="width: 100%; height: 500px;"><?php echo ($data["cancelrule"]); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>属性</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label>
                                                <input type='radio' name='isindex' value='1'  <?php if($data['isindex'] == '1' ): ?>checked<?php endif; ?>>
                                                <span>推荐</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='isindex' value='0'   <?php if($data['isindex'] == '0' ): ?>checked<?php endif; ?>>
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
                                                <input type='radio' name='type' value='1' <?php if($data['type'] == '1' ): ?>checked<?php endif; ?>>
                                                <span>是</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='type' value='0' <?php if($data['type'] == '0' ): ?>checked<?php endif; ?>>
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
                        <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/Public/Admin/js/common.js?v"></script>
    <script src="/Public/Admin/js/content_addtop.js"></script>
    <link rel="stylesheet" type="text/css" href="/Public/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="/Public/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="/Public/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#uploadify").uploadify({
                'uploader'  : '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg' : '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
                'script'    : "<?php echo U('Admin/Public/uploadone');?>",//实现上传的程序
                'method'    : 'post',
                'folder'    : '/Uploads/images/',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg': '/Public/Public/uploadify/upload.gif',//替换上传钮扣
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