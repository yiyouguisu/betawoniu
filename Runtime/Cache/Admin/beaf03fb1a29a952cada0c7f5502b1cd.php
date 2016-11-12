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
 <div class="h_a">温馨提示</div>
  <div class="prompt_text">
    <p>1、栏目<font color="blue">ID</font>为<font color="blue">蓝色</font>才可以添加内容。可以使用“属性转换”进行转换！</p>
    <p>2、终极栏目不能添加子栏目</p>
    <p>3、排序按照排序数值倒序排列</p>
    <p>4、外部链接不能进行“属性转换”</p>
  </div>
 <!-- -->
   <form name="myform" action="<?php echo U('Admin/Category/listorder');?>" method="post">
  <div class="table_list">
    <table width="100%">
        <colgroup>
        <col width="80">
        <col width="80">
        <col>
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100" >
        <col width="300">
        </colgroup>
        <thead>
          <tr>
            <td align='center'>排序</td>
            <td align='center'>栏目ID</td>
            <td>栏目名称</td>
            <td align='center'>栏目类型</td>
            <td align='center'>所属模型</td>
            <td align='center'>是否显示</td>
            <td align='center'>是否终极</td>
            <td align='center'>管理操作</td>
          </tr>
        </thead>
        <?php echo ($categorys); ?>
      </table>
    <div class="btn_wrap">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">排序</button>
      </div>
    </div>
  </div>
  </div>
</form>
   </div>
</div>
<script src="/Public/Admin/js/common.js?v"></script>
</body>
</html>