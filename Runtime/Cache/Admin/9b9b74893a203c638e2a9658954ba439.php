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
.cu,.cu-li li,.cu-span span {cursor: hand;!important;cursor: pointer}
 tr.cu:hover td{
    background-color:#FF9966;
}
 
</style>
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
       <div class="common-form">
                <div class="table_full">
                    <form class="J_ajaxForm" method="post" action="<?php echo U('Admin/Party/review');?>">
                         <div class="bk10"></div>
                         <div class="h_a">审核信息</div>       
                        <table width="100%" class="table_form contentWrap">
                            <tbody>
                            <tr>
                                <th  width="80">审核</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label>
                                                
                                                <input type='radio' name='status' value='2' <?php if($data['status'] == '2' ): ?>checked<?php endif; ?>>
                                                <span>审核成功</span></label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='status' value='3' <?php if($data['status'] == '3' ): ?>checked<?php endif; ?>>
                                                <span>审核失败</span></label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>审核备注</th>
                                <td>
                                    <textarea  name="remark" class="valid" style="width:500px;height:80px;"><?php echo ($data["remark"]); ?></textarea>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="btn_wrap">
                            <div class="btn_wrap_pd">
                                <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>">
                                <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">审核</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
<script src="/Public/Admin/js/common.js?v"></script>
</body>
</html>