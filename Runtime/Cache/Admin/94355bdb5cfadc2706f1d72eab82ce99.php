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
    $(function () {
        var url = "<?php echo U('Admin/Ueditor/index');?>";
        var ue2 = UE.getEditor('description', {
            serverUrl: url,
            UEDITOR_HOME_URL: '/Public/Editor/UEditor/',
        });
        ue2.ready(function () {
            ue2.execCommand('serverparam', {
                'userid': '1',
                'username': 'admin',
            });
        });

    })

</script>
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
            <!---->
            <form method="post" action="<?php echo U('Admin/Hostel/add');?>">
                <div class="h_a">美宿信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">发布者</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="hidden" name="uid" id="uid" value="" />
                                    <input type="text" class="input length_4 input_hd" placeholder="请选择游者" id="username" value="" readonly required>
                                    <input type="button" class="button" value="选择" onclick="omnipotent('selectid','<?php echo U('Admin/Member/select',array('type'=>2));?>','请选择发布者',1,700,400)">
                                </td>
                            </tr>
                             <tr>
                                <th width="80">美宿名称</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入标题" id="title" value="<?php echo ($data["title"]); ?>">
                                </td>
                            </tr>
                            <tr id="img">
                                <th>美宿LOGO：</th>
                                <td>
                                    <div class="thumb" style="display:inline-block;"></div><input type="hidden" id="thumb" name="thumb" value="<?php echo ($data["thumb"]); ?>" style="float: left"  runat="server">&nbsp; <input type="button" class="button" value="选择上传" id="uploadify" ></td>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">适用景点</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <select class="select_2" name="place">
                                        <option value="">请选择适用景点</option>
                                        <?php if(is_array($place)): $i = 0; $__LIST__ = $place;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">美宿类型</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <select class="select_2" name="style">
                                        <option value="">请选择美宿类型</option>
                                        <?php if(is_array($hosteltype)): $i = 0; $__LIST__ = $hosteltype;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">美宿特色</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <select class="select_2" name="catid">
                                        <option value="">请选择美宿特色</option>
                                        <?php if(is_array($hostelcate)): $i = 0; $__LIST__ = $hostelcate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["catname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </td>
                            </tr>
                           
                            <tr>
                                <th>美宿地址<input type="hidden" class="input" name="area" id="area" value="<?php echo ($data["area"]); ?>"></th>
                                <td class="jgbox"></td>
                            </tr>
                            <tr>
                                <th>详细地址</th>
                                <td>
                                    <input type="text" name="address" class="input length_6 input_hd" placeholder="请输入美宿地址" id="address" value="<?php echo ($data["address"]); ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>促销活动 </th>
                                <td>美宿预定满<input type="text" name="vouchersrange" class="input length_2"  placeholder="请输入金额" id="vouchersrange" value="<?php echo ($data["vouchersrange"]); ?>">元金额送
                                    <input type="text" name="vouchersdiscount" class="input length_2"  placeholder="请输入金额" id="vouchersdiscount" value="<?php echo ($data["vouchersdiscount"]); ?>">元金额的抵用券
                                </td>
                            </tr>
                            <tr>
                                <th>美宿简介</th>
                                <td>
                                    <textarea name="description" id="description" style="width: 100%; height: 500px;"><?php echo ($data["description"]); ?></textarea>
                                </td>
                            </tr>
                            <tr id="contenttr">
                                <th>退订规则</th>
                                <td>
                                    <textarea name="content" id="content" style="width: 100%; height: 500px;"><?php echo ($data["content"]); ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>预定提醒</th>
                                <td>
                                    <textarea name="bookremark" id="bookremark" style="width: 100%; height: 200px;"><?php echo ($data["bookremark"]); ?></textarea>
                                </td>
                            </tr>
                            <tr id="imagelist">
                                <th>图片列表：</th>
                                <td>
                                    <fieldset class="blue pad-10">
                                        <legend>图片列表</legend>
                                        <center>
                                            <div class="onShow" id="nameTip">您最多每次可以同时上传 <font color="red">10</font> 张,双击文本框查看图片</div>
                                        </center>
                                        <ul id="albums" class="picList"></ul>
                                    </fieldset>

                                    <div class="bk10"></div>
                                    <input type="button" class="button btn_submit" value="选择上传" id="uploadify1">
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
                        <input type="hidden" name="applyid" value="<?php echo ($data["id"]); ?>" />
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
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
        $(function () {
            $("#uploadify").uploadify({
                'uploader': '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "<?php echo U('Admin/Public/uploadone');?>",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '/Public/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    $(".thumb").html("<img src='"+response+"' width='202px' height='152px'  />");
                    $("input[name='thumb']").val(response);
                }
            });

            var imgg = $("#image");
            function getResult(content) {
                imgg.val(content);
            }

            $("#uploadify1").uploadify({
                'uploader': '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'  : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "<?php echo U('Admin/Public/upload');?>",//实现上传的程序
                'method': 'get',
                'folder': '/Uploads/images',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': "",//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '/Public/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    // alert(response);
                    getResultimglist(response, queueID);//获得上传的文件路径
                }
            });
            var albums = $("#albums");
            var str = "";
            function getResultimglist(content,queueID){
                str= "<li id='"+queueID+"'><input type='text' name='imglist[]' value='"+content+"' style='width:310px;' class='input' ondblclick='image_priview(this.value);'><a href=\"javascript:remove_div('"+queueID+"')\">移除</a></li>";
                albums.append(str);
            }

        });
    </script>
</body>
</html>