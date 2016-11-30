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
    .cu, .cu-li li, .cu-span span {
        cursor: hand;
        !important;
        cursor: pointer;
    }

    tr.cu:hover td {
        background-color: #FF9966;
    }
</style>
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <div class="h_a">搜索</div>
        <form method="post" action="<?php echo U('Admin/Member/select',array('type'=>1));?>">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10">
                    <span class="mr20">
                        性别：
                        <select class="select_1" name="sex">
                            <option value="" <?php if(empty($_POST['sex'])): ?>selected<?php endif; ?>>全部</option>
                            <option value="1" <?php if( $_POST['sex']== '1'): ?>selected<?php endif; ?>>男</option>
                            <option value="2" <?php if( $_POST['sex']== '2'): ?>selected<?php endif; ?>>女</option>
                        </select>
                        关键字：
                        <select class="select_2" name="searchtype">
                            <option value='0' <?php if( $searchtype == '0' ): ?>selected<?php endif; ?>>用户名</option>
                            <option value='1' <?php if( $searchtype == '1' ): ?>selected<?php endif; ?>>真实姓名</option>
                            <option value='2' <?php if( $searchtype == '2' ): ?>selected<?php endif; ?>>邮箱</option>
                            <option value='3' <?php if( $searchtype == '3' ): ?>selected<?php endif; ?>>手机</option>
                            <!--
                                                     <option value='4' <?php if( $searchtype == '4' ): ?>selected<?php endif; ?>>ID</option>-->
                        </select>
                        <input type="text" class="input length_2" name="keyword" value="" placeholder="请输入关键字...">
                        搜索类别：
                        <select class="select_3" name="type" style="display:none;">                          
                            <option value="1" selected>1</option>
                        </select>
                        <button class="btn">搜索</button>
                    </span>
                </div>
            </div>
        </form>
        <div class="table_list">
            <table width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <td width="12%" align="center">用户名</td>
                        <td width="8%" align="center">昵称</td>
                        <td width="8%" align="center">性别</td>
                        <td width="8%" align="center">真实姓名</td>
                        <td width="15%" align="center">邮箱</td>
                        <td width="15%" align="center">手机</td>
                       
                    </tr>
                </thead>
                <tbody>


                    <?php if(is_array($data)): foreach($data as $key=>$vo): ?><tr onclick="select_list(this, '<?php echo ($vo["nickname"]); ?>', '<?php echo ($vo["id"]); ?>')" class="cu" title="点击选择">
                            <td width="10%" align="center"><?php echo ($vo["username"]); ?></td>
                            <td width="10%" align="center"><?php echo ($vo["nickname"]); ?></td>
                            <td width="8%" align="center">
                                <?php if( $vo["sex"] == '1' ): ?>男<?php endif; ?>
                                <?php if( $vo["sex"] == '2' ): ?>女<?php endif; ?>
                                <?php if( $vo["sex"] == '0' ): ?>未知<?php endif; ?>
                            </td>
                            <td width="10%" align="center"><?php echo ($vo["realname"]); ?></td>
                            <td width="20%" align="center"><?php echo ($vo["email"]); ?></td>
                            <td width="15%" align="center">
                                <?php echo ($vo["phone"]); ?>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </tbody>
            </table>
            <div class="p10">
                <div class="pages"> <?php echo ($Page); ?> </div>
            </div>
        </div>
    </div>
    <script src="/Public/Admin/js/common.js?v"></script>
    <script>
        function select_list(obj, title, id) {
            $(window.parent.document).find("#uid").val(id);
            $(window.parent.document).find('#username').val(title);
            window.parent.get_hostel(); 
            
        }
    </script>
</body>
</html>