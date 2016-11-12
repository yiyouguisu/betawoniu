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
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <!-- <div class="nav">
          <ul class="cc">
                <li class="current"><a href="<?php echo U('Admin/Menu/index');?>">后台菜单管理</a></li>
                <li ><a href="<?php echo U('Admin/Menu/add');?>">添加菜单</a></li>
              </ul>
        </div>-->
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
        <!-- -->
        <div class="h_a">站点配置</div>
        <div class="table_full">
            <form method='post' class="J_ajaxForm" id="myform" action="<?php echo U('Admin/Config/index');?>">
                <table cellpadding="0" cellspacing="0" width="100%" class="table_form">
                    <tr>
                        <th width="140">站点名称:</th>
                        <td>
                            <input type="text" class="input" name="sitename" value="<?php echo ($Site["sitename"]); ?>" size="40"></td>
                    </tr>
                    <tr>
                        <th width="140">网站域名:</th>
                        <td>
                            <input type="text" class="input" name="siteurl" value="<?php echo ($Site["siteurl"]); ?>" size="40">
                            <span class="gray">请以“/”结尾，当前域名 <?php echo ($URL); ?></span></td>
                    </tr>
                    <tr>
                        <th width="140">网站标题:</th>
                        <td>
                            <input type="text" class="input" name="sitetitle" value="<?php echo ($Site["sitetitle"]); ?>" size="40"></td>
                    </tr>
                    <tr>
                        <th width="140">网站关键字:</th>
                        <td>
                            <input type="text" class="input" name="sitekeywords" value="<?php echo ($Site["sitekeywords"]); ?>" size="40">
                            <span class="gray">请以“,”分割</span></td>
                    </tr>
                    <tr>
                        <th width="140">网站描述:</th>
                        <td>
                            <textarea name="sitedescription" style="width: 350px; height: 100px;"><?php echo ($Site["sitedescription"]); ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th width="140">网站电话:</th>
                        <td>
                            <input type="text" class="input" name="sitetel" value="<?php echo ($Site["sitetel"]); ?>" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">网站Email:</th>
                        <td>
                            <input type="text" class="input" name="siteemail" value="<?php echo ($Site["siteemail"]); ?>" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">网站微博:</th>
                        <td>
                            <input type="text" class="input" name="siteweibo" value="<?php echo ($Site["siteweibo"]); ?>" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">公司地址:</th>
                        <td>
                            <input type="text" class="input" name="siteaddress" value="<?php echo ($Site["siteaddress"]); ?>" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">版权信息:</th>
                        <td>
                            <input type="text" class="input" name="sitecopyright" value="<?php echo ($Site["sitecopyright"]); ?>" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">备案号:</th>
                        <td>
                            <input type="text" class="input" name="siteicp" value="<?php echo ($Site["siteicp"]); ?>" size="40">
                        </td>
                    </tr>
                    
                    <tr>
                        <th>评选活动详情图片：</th>
                        <td>
                            <input type="text" name="vote_image" id="vote_image" class="input length_5" value="<?php echo ($Site["vote_image"]); ?>" style="float: left" ondblclick='image_priview(this.value);'>&nbsp;
                            <input type="button" class="button upload" value="选择上传" id="uploadbtn_vote_image" data-id="vote_image">
                            <span class="gray">双击文本框查看图片</span></td>
                    </tr>
                    <tr>
                        <th>评选活动描述:</th>
                        <td>
                            <textarea name="vote_description" style="width: 350px; height: 100px;"><?php echo ($Site["vote_description"]); ?></textarea>
                        </td>
                    </tr>
   
                </table>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="/Public/Admin/js/common.js?v"></script>
    <script src="/Public/Admin/js/content_addtop.js"></script>
    <link rel="stylesheet" type="text/css"  href="/Public/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="/Public/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="/Public/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
    $(function(){
        $(".upload").each(function(){
            inituploadify($(this));
        })
    })
   function inituploadify(a){
    a.uploadify({
        'uploader'  : '/Public/Public/uploadify/uploadify.swf',//所需要的flash文件
        'cancelImg' : '/Public/Public/uploadify/cancel.gif',//单个取消上传的图片
        //'script' : '/Public/Public/uploadify/uploadify.php',//实现上传的程序
        'script'    : "<?php echo U('Admin/Public/uploadone');?>",//实现上传的程序
        'method'    : 'post',
        'auto'      : true,//自动上传
        'multi'     : false,//是否多文件上传
        'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
        'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
        'sizeLimit': '',//限制上传文件的大小2m(比特b)
        'queueSizeLimit' :10, //可上传的文件个数
        'buttonImg' : '/Public/Public/uploadify/add.gif',//替换上传钮扣
        'width'     : 80,//buttonImg的大小
        'height'    : 26,
        onComplete: function (evt, queueID, fileObj, response, data) {
            var obj="#"+$(evt.currentTarget).attr("data-id");
            $(obj).val(response);
        }
    });
   }
   </script>
</body>
</html>