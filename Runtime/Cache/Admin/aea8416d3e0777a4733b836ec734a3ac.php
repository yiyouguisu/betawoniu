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
        <form method="get" action="<?php echo U('Admin/Order/party');?>">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> 
                    <span class="mr20">
                        下单时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="<?php echo ($_GET['start_time']); ?>" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="<?php echo ($_GET['end_time']); ?>" style="width:80px;">

                        订单类型：
                        <select class="select_2" name="ordertype" style="width:85px;">
                            <option value=""  <?php if(empty($_GET['ordertype'])): ?>selected<?php endif; ?>>全部</option>
                            <option value="1" <?php if( $_GET['ordertype']== '1'): ?>selected<?php endif; ?>>美宿订单</option>
                            <option value="2" <?php if( $_GET['ordertype']== '2'): ?>selected<?php endif; ?>>活动订单</option>
                        </select>
                        订单号：
                        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="<?php echo ($_GET['keyword']); ?>" placeholder="请输入订单号...">
                        <input type="hidden" class="input length_2" name="aid" style="width:200px;" value="<?php echo ($_GET['aid']); ?>">
                        <button class="btn">搜索</button>
                    </span>
                </div>
            </div>
        </form> 

        <form action="<?php echo U('Admin/Order/del');?>" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="15%" align="center" >订单号</td>
                            <td width="8%" align="center" >下单用户</td>
                            <td width="6%" align="center" >订单类型</td>
                            <td width="8%" align="center" >订单金额</td>
                            <td width="8%" align="center" >优惠金额</td>
                            <td width="8%" align="center" >实付金额</td>
                            <td width="10%"  align="center" >订单时间</td>
                            <td width="6%"  align="center" >支付方式</td>
                            <td width="6%"  align="center" >支付状态</td>
                            <td width="6%"  align="center" >订单状态</td>
                            <td width="12%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                 <?php $money_total1=0;?>
                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr class="productshow" data-id="<?php echo ($vo["id"]); ?>">
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>"></td>
                            <td align="center" ><?php echo ($vo["orderid"]); ?><a href="<?php echo U('Admin/Order/bookmember',array('type'=>'party','orderid'=>$vo['orderid']));?>" class="info"><img src="/Public/Admin/images/info.png" style="width: 20px;display: inline-block;margin-bottom: -5px;"></a></td>
                            <td align="center" ><?php echo getuserinfo($vo['uid']);?></td>
                            <td align="center" ><?php echo getordertype($vo['orderid']);?></td>
                            <td align="center" >
                                ￥<?php $money_total1+=$vo['total'];?>
                                <?php echo ((isset($vo["total"]) && ($vo["total"] !== ""))?($vo["total"]):"0.00"); ?>
                            </td>
                            <td align="center" ><?php echo ((isset($vo["discount"]) && ($vo["discount"] !== ""))?($vo["discount"]):"0.00"); ?></td>
                            <td align="center" ><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.00"); ?></td>
                            <td align="center" ><?php echo (date("Y-m-d",$vo["inputtime"])); ?></br><?php echo (date("H:i:s",$vo["inputtime"])); ?></td>
                            <td align="center" ><?php echo getpaystyle($vo['orderid']);?></td>
                            <td align="center" ><?php echo getpaystatus($vo['pay_status']);?></td>
                            <td align="center" ><?php echo getorderstatus($vo['status']);?></td>
                            <td align="center" > 
                                <?php if($vo['status'] != 4): if(($vo['status']) == "1"): ?><a href="javascript:;" onClick="omnipotent('selectid','<?php echo U('Admin/Order/review',array('orderid'=>$vo['orderid']));?>','审核',1,700,300)">审核</a></br><?php endif; ?>
                                    <?php else: ?>
                                    订单已完成<br/><?php echo (date("Y-m-d H:i:s",$vo["donetime"])); ?></br><?php endif; ?>
                                <a href="<?php echo U('Admin/Order/docancel',array('orderid'=>$vo['orderid']));?>">取消订单</a></br>
                                <a href="<?php echo U('Admin/Order/doclose',array('orderid'=>$vo['orderid']));?>" class="close">关闭订单</a></br>
                                <a href="javascript:;" onClick="omnipotent('selectid','<?php echo U('Admin/Order/show',array('orderid'=>$vo['orderid']));?>','查看详情',1,850,600)">查看详情</a></br>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                      <tr style="font-weight:bold">
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td align="center">小计:</th>
                        <td align="center">￥<?php echo ((isset($money_total1) && ($money_total1 !== ""))?($money_total1):"0.00"); ?></th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                        <td>&nbsp;</th>
                      </tr>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages"> <?php echo ($Page); ?> </div>
                    <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>   

                    <?php if(authcheck('Admin/Order/del')): ?><button class="btn btn_submit mr10 " type="submit" name="submit" value="del">删除</button><?php endif; ?>
                    </form>
                </div>
            </div>

            <div class="btn_wrap">
                <div class="btn_wrap_pd">
                        <form method="post" action="<?php echo U('Admin/Orderexcel/excel');?>">
                            <input type="hidden" value="1" name="search">
                            <input type="hidden" name="start_time" value="<?php echo ($_GET['start_time']); ?>" >
                            <input type="hidden"  name="end_time" value="<?php echo ($_GET['end_time']); ?>" >
                            <input type="hidden"  name="ordertype" value="<?php echo ($_GET['ordertype']); ?>" >
                            <input type="hidden"  name="keyword" value="<?php echo ($_GET['keyword']); ?>" >
                            <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">导出当前数据</button>
                        </form> 
                </div>
            </div>


    </div>

    <script src="/Public/Admin/js/common.js?v"></script>
    <script src="/Public/Admin/js/content_addtop.js"></script>
    <script>
        $(function () {

        })

    </script>
</body>
</html>