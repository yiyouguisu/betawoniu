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
            <form method="post"  action="<?php echo U('Admin/Question/edit');?>">
                <div class="h_a">基本信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">题目</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入题目" id="title" value="<?php echo ($data["title"]); ?>">
                                </td>
                            </tr>
                            <tr>
                                <th>答案</th>
                                <td>
                                    <textarea name="content" id="content" class="valid" style="width: 500px; height: 80px;"><?php echo ($data["content"]); ?></textarea>
                                </td>
                            </tr>
                            
                              <tr id="review">
                                <th>审核</th>
                                <td>
                                  <ul class="switch_list cc ">
                  <li>
                    <label>
                      <input type='radio' name='status' value='1' <?php if($data['status'] == '1' ): ?>checked<?php endif; ?>>
                      <span>审核</span></label>
                  </li>
                  <li>
                    <label>
                      <input type='radio' name='status' value='0' <?php if($data['status'] == '0' ): ?>checked<?php endif; ?>>
                      <span>未审核</span></label>
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
</body>
</html>