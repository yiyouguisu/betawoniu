<?php if (!defined('THINK_PATH')) exit();?>
<!doctype html>
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
        <div class="h_a">搜索</div>
        <form method="get" action="<?php echo U('Admin/Exchangeorder/index');?>">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> 
                    <span class="mr20">
                        下单时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="<?php echo ($_GET['start_time']); ?>" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="<?php echo ($_GET['end_time']); ?>" style="width:80px;">

                        <button class="btn">搜索</button>
                    </span>
                </div>
            </div>
        </form> 

        <form action="<?php echo U('Admin/Exchangeorder/del');?>" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="15%" align="center" >订单号</td>
                            <td width="10%" align="center" >下单用户</td>
                            <td width="15%" align="center" >美宿名称</td>
                            <td width="10%" align="center" >兑换金额</td>
                            <td width="10%"  align="center" >订单时间</td>
                            <td width="10%"  align="center" >期望入住人数</td>
                            <td width="10%"  align="center" >期望入住时间</td>
                            <td width="12%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="productshow" data-id="<?php echo ($vo["id"]); ?>">
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>"></td>
                            <td align="center" ><?php echo ($vo["orderid"]); ?></td>
                            <td align="center" ><?php echo getuserinfo($vo['uid']);?></td>
                            <td align="center" ><?php echo ($vo["house"]); ?></td>
                            <td align="center" >
                                <?php echo ($vo["money"]); ?>
                            </td>
                            <td align="center" ><?php echo (date("Y-m-d",$vo["inputtime"])); ?><br/><?php echo (date("H:i:s",$vo["inputtime"])); ?></td>
                            <td align="center" >
                                <?php echo ($vo["expectnum"]); ?>
                            </td>
                            <td align="center" >
                                <?php echo ($vo["expectdate"]); ?>
                            </td>
                            <td align="center" > 
                                 <?php if(authcheck('Admin/Exchangeorder/delete')): ?><a href="<?php echo U('Admin/Exchangeorder/delete',array('id'=>$vo['id']));?>"  class="del">删除</a> 
                <?php else: ?>
                 <font color="#cccccc">删除</font><?php endif; ?> 
                            </td>
                        </tr>
                        <tr id="product_<?php echo ($vo["id"]); ?>" style="color: rgb(24, 116, 237);background-color: rgb(230, 230, 230);display:none;" >
                            <td colspan="11">
                                <table width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td width="33.33%" align="center" >真实姓名</td>
                                            <td width="33.33%" align="center" >身份证号</td>
                                            <td width="33.33%" align="center" >联系方式</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(is_array($vo['productinfo'])): $i = 0; $__LIST__ = $vo['productinfo'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                                <td align="center" ><?php echo ($v["realname"]); ?></td>
                                                <td align="center" ><?php echo ($v["idcard"]); ?></td>
                                                <td align="center" ><?php echo ($v["tel"]); ?></td>
                                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages"> <?php echo ($Page); ?> </div>
                    <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>   

                    <?php if(authcheck('Admin/Exchangeorder/del')): ?><button class="btn btn_submit mr10 " type="submit" name="submit" value="del">删除</button><?php endif; ?>
                    </form>
                </div>
            </div>

            <!-- <div class="btn_wrap">
                <div class="btn_wrap_pd">
                        <form method="post" action="<?php echo U('Admin/Exchangeorderexcel/excel');?>">
                            <input type="hidden" value="1" name="search">
                            <input type="hidden" name="start_time" value="<?php echo ($_GET['start_time']); ?>" >
                            <input type="hidden"  name="end_time" value="<?php echo ($_GET['end_time']); ?>" >
                            <input type="hidden"  name="Exchangeordersource" value="<?php echo ($_GET['Exchangeordersource']); ?>" >
                            <input type="hidden"  name="Exchangeordertype" value="<?php echo ($_GET['Exchangeordertype']); ?>" >
                            <input type="hidden"  name="isthirdparty" value="<?php echo ($_GET['isthirdparty']); ?>" >
                            <input type="hidden"  name="issend" value="<?php echo ($_GET['issend']); ?>" >
                            <input type="hidden"  name="storeid" value="<?php echo ($_GET['storeid']); ?>" >
                            <input type="hidden"  name="keyword" value="<?php echo ($_GET['keyword']); ?>" >
                            <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">导出当前数据</button>
                        </form> 
                </div>
            </div> -->


    </div>

    <script src="/Public/Admin/js/common.js?v"></script>
        <script src="/Public/Admin/js/content_addtop.js"></script>
    <script>
        $(function () {
            $(".productshow a").click(function () {
                var href = $(this).attr("href");
                window.location.href = href;
                return false;
            })
            $(".productshow").click(function () {
                var obj = "#product_" + $(this).data("id");
                $(obj).toggle();
            })

        })
        
    </script>
</body>
</html>