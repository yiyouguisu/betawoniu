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
    <style>
        .pop_nav {
            padding: 0px;
        }

            .pop_nav ul {
                border-bottom: 1px solid green;
                padding: 0 5px;
                height: 25px;
                clear: both;
            }

                .pop_nav ul li.current a {
                    border: 1px solid green;
                    border-bottom: 0 none;
                    color: #333;
                    font-weight: 700;
                    background: #F3F3F3;
                    position: relative;
                    border-radius: 2px;
                    margin-bottom: -1px;
                }
    </style>
    <div class="wrap J_check_wrap">
        <div class="pop_nav" style="margin-bottom:0px">
            <ul class="J_tabs_nav">
                <li <?php if(empty($type)): ?>class="current"<?php endif; ?> data-type="<?php echo ($type); ?>"><a href="javascript:;;">基本信息</a></li>
                <li <?php if(($type) == "2"): ?>class="current"<?php endif; ?> data-type="<?php echo ($type); ?>"><a href="javascript:;;">优惠券</a></li>
            </ul>
        </div>
        <form name="myform" id="myform" method="post" enctype="multipart/form-data">
            <div class="J_tabs_contents" style="width:760px">
                <div class="tba">
                    <div class="table_full">
                        <table width="100%" class="table_form">
                            <tr>
                                <th width="130">用户名：</th>
                                <td width="200"><?php echo ($data["username"]); ?></td>
                                <th width="130">认证情况：</th>
                                <td width="200"><?php echo getlevelinfo($data['id']);?></td>
                            </tr>
                            <tr>
                                <th>状态：</th>
                                <td><?php if($data["status"] == 0): ?>冻结<?php else: ?>开启<?php endif; ?></td>
                                <th>昵称：</th>
                                <td><?php echo ($data["nickname"]); ?></td>
                            </tr>
                            <tr>
                                <th>真实姓名：</th>
                                <td><?php echo ((isset($data["realname"]) && ($data["realname"] !== ""))?($data["realname"]):"未填写"); ?></td>
                                <th>身份证号：</th>
                                <td><?php echo ((isset($data["idcard"]) && ($data["idcard"] !== ""))?($data["idcard"]):"未填写"); ?></td>
                            </tr>
                            <tr>
                                <th>手机号码：</th>
                                <td><?php echo ((isset($data["phone"]) && ($data["phone"] !== ""))?($data["phone"]):"未填写"); ?></td>
                                <th>邮箱：</th>
                                <td><?php echo ((isset($data["email"]) && ($data["email"] !== ""))?($data["email"]):"未填写"); ?></td>
                            </tr>
                            <tr>
                                <th>家乡：</th>
                                <td><?php echo getarea($data['hometown']);?></td>
                                <th>居住区域：</th>
                                <td><?php echo getarea($data['area']); echo ($data["address"]); ?></td>
                            </tr>
                            <tr>
                                <th>性别：</th>
                                <td><?php if($data["sex"] == 1): ?>男<?php endif; if($data["sex"] == 2): ?>女<?php endif; if($data["sex"] == 0): ?>默认<?php endif; ?></td>
                                <th>生日：</th>
                                <td><?php echo ((isset($data["birthday"]) && ($data["birthday"] !== ""))?($data["birthday"]):"未填写"); ?></td>
                            </tr>
                            <tr>
                                <th>学历：</th>
                                <td><?php echo ((isset($data["education"]) && ($data["education"] !== ""))?($data["education"]):"未填写"); ?></td>
                                <th>学校：</th>
                                <td><?php echo ((isset($data["school"]) && ($data["school"] !== ""))?($data["school"]):"未填写"); ?></td>
                            </tr>
                            <tr>
                                <th>属相：</th>
                                <td><?php echo ((isset($data["zodiac"]) && ($data["zodiac"] !== ""))?($data["zodiac"]):"未填写"); ?></td>
                                <th>星座：</th>
                                <td><?php echo ((isset($data["constellation"]) && ($data["constellation"] !== ""))?($data["constellation"]):"未填写"); ?></td>
                            </tr>
                            
                            <tr>
                                <th>血型：</th>
                                <td><?php echo ((isset($data["bloodtype"]) && ($data["bloodtype"] !== ""))?($data["bloodtype"]):"未填写"); ?></td>
                                <!--<th>可用积分：</th>
                                <td><?php echo ((isset($data["useintegral"]) && ($data["useintegral"] !== ""))?($data["useintegral"]):"0"); ?>分</td>-->
                                <th>钱包余额：</th>
                                <td><?php echo ((isset($data["usemoney"]) && ($data["usemoney"] !== ""))?($data["usemoney"]):"0.00"); ?>元</td>
                            </tr>
                            <tr>
                                <th>个人特性：</th>
                                <td><?php echo ((isset($data["characteristic"]) && ($data["characteristic"] !== ""))?($data["characteristic"]):"未选择"); ?></td>
                                <th>个人爱好：</th>
                                <td><?php echo ((isset($data["hobby"]) && ($data["hobby"] !== ""))?($data["hobby"]):"未选择"); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="tba">
                    <div class="table_full">
                        <table width="100%" class="table_form">
                            <thead>
                                <tr>
                                    <td width="20%" align="center">优惠券名称</td>
                                    <td width="6%" align="center">数量</td>
                                    <td width="6%" align="center">价格</td>
                                    <td width="15%" align="center">适用范围</td>
                                    <td width="6%" align="center">状态</td>
                                    <td width="15%" align="center">有效时间</td>
                                    <td width="15%" align="center">发放时间</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(is_array($vouchers)): foreach($vouchers as $key=>$vo): ?><tr>
                                        <td align="center"><?php echo ($vo["title"]); ?></td>
                                        <td align="center"><?php echo ($vo["num"]); ?></td>
                                        <td align="center"><?php echo ($vo["price"]); ?></td>
                                        <td align="center">消费满元<?php echo ($vo["range"]); ?>可使用</td>
                                        <td align="center">
                                            <?php if(($vo['usestatus']) == "1"): ?>可用<?php endif; ?>
                                            <?php if(($vo['usestatus']) == "0"): ?>不可用<?php endif; ?>
                                        </td>
                                        <td align="center"><?php echo (date("Y-m-d H:i:s",$vo["validity_endtime"])); ?></td>
                                        <td align="center">
                                            <?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?>
                                        </td>
                                    </tr><?php endforeach; endif; ?>
                            </tbody>
                        </table>
                        <div class="p10">
                            <div class="pages ajaxpagebar" data-id="2"> <?php echo ($Page2); ?> </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="/Public/Admin/js/common.js?v"></script>
    <script src="/Public/Admin/js/content_addtop.js"></script>
    <script>
        $('.ajaxpagebar a').live("click", function () {
            var type = $(this).parents("div.ajaxpagebar").data("id");
            var geturl = $(this).attr('href');
            window.location.href = geturl + '&type=' + type;

            return false;
        })

    </script>
</body>
</html>