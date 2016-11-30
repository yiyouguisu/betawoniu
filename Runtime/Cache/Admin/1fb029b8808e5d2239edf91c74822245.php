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
        <div class="h_a">短信模版配置</div>
        <div class="table_full">
             <form method='post'   id="myform" action="<?php echo U('Admin/Config/smstemplate');?>">
                <table cellpadding=0 cellspacing=0 width="100%" class="table_form" >
                    <tr>
                        <th width="140">系统验证码:</th>
                        <td>
                            <textarea name="sms_phonecode" style="width:350px; height:100px;"><?php echo ($Site["sms_phonecode"]); ?></textarea>  
                            <span class="gray"><font color="red">{#code#}</font>代表验证码</span>
                        </td>
                    </tr>
                    <tr>
                        <th width="140">中奖短信:</th>
                        <td>
                            <textarea name="sms_votecontent" style="width:350px; height:100px;"><?php echo ($Site["sms_votecontent"]); ?></textarea>  
                            <span class="gray"><font color="red">{#house#}</font>代表活动,</span>
                            <span class="gray"><font color="red">{#level#}</font>代表优惠券的类型</span>
                        </td>
                    </tr>
                    <tr>
                        <th width="140">实名认证成功:</th>
                        <td>
                            <textarea name="sms_applyrealnamesuccess" style="width:350px; height:100px;"><?php echo ($Site["sms_applyrealnamesuccess"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">实名认证失败:</th>
                        <td>
                            <textarea name="sms_applyrealnamefail" style="width:350px; height:100px;"><?php echo ($Site["sms_applyrealnamefail"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">民宿订单审核成功:</th>
                        <td>
                            <textarea name="sms_successbookhouse" style="width:350px; height:100px;"><?php echo ($Site["sms_successbookhouse"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">民宿订单审核失败:</th>
                        <td>
                            <textarea name="sms_failbookhouse" style="width:350px; height:100px;"><?php echo ($Site["sms_failbookhouse"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">入住时间倒计时提醒:</th>
                        <td>
                            <textarea name="sms_waitcheck" style="width:350px; height:100px;"><?php echo ($Site["sms_waitcheck"]); ?></textarea>  
                            <span class="gray"><font color="red">{#hostel#}</font>代表美宿名称</span>
                        </td>
                    </tr>
                    <tr>
                        <th width="140">生日提醒:</th>
                        <td>
                            <textarea name="sms_birthday" style="width:350px; height:100px;"><?php echo ($Site["sms_birthday"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">房东认证成功:</th>
                        <td>
                            <textarea name="sms_applyhouseownersuccess" style="width:350px; height:100px;"><?php echo ($Site["sms_applyhouseownersuccess"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">房东认证失败:</th>
                        <td>
                            <textarea name="sms_applyhouseownerfail" style="width:350px; height:100px;"><?php echo ($Site["sms_applyhouseownerfail"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">新订单待审核通知:</th>
                        <td>
                            <textarea name="sms_applybookhouse" style="width:350px; height:100px;"><?php echo ($Site["sms_applybookhouse"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">订单支付成功通知:</th>
                        <td>
                            <textarea name="sms_payordersuccess" style="width:350px; height:100px;"><?php echo ($Site["sms_payordersuccess"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">美宿订单支付倒计时提醒:</th>
                        <td>
                            <textarea name="sms_waitpay_hostel" style="width:350px; height:100px;"><?php echo ($Site["sms_waitpay_hostel"]); ?></textarea>  
                            <span class="gray"><font color="red">{#hostel#}</font>代表美宿名称</span>
                        </td>
                    </tr>
                    <tr>
                        <th width="140">活动订单支付倒计时提醒:</th>
                        <td>
                            <textarea name="sms_waitpay_party" style="width:350px; height:100px;"><?php echo ($Site["sms_waitpay_party"]); ?></textarea>  
                            <span class="gray"><font color="red">{#party#}</font>代表活动名称</span>
                        </td>
                    </tr>
                    <tr>
                        <th width="140">房东提现成功:</th>
                        <td>
                            <textarea name="sms_withdrawsuccess" style="width:350px; height:100px;"><?php echo ($Site["sms_withdrawsuccess"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">房东提现失败:</th>
                        <td>
                            <textarea name="sms_withdrawfail" style="width:350px; height:100px;"><?php echo ($Site["sms_withdrawfail"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">申请退订:</th>
                        <td>
                            <textarea name="sms_refundhostelapply" style="width:350px; height:100px;"><?php echo ($Site["sms_refundhostelapply"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">新申请退订(房东):</th>
                        <td>
                            <textarea name="sms_brefundhostelapply" style="width:350px; height:100px;"><?php echo ($Site["sms_brefundhostelapply"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">申请取消报名:</th>
                        <td>
                            <textarea name="sms_refundpartyapply" style="width:350px; height:100px;"><?php echo ($Site["sms_refundpartyapply"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">新申请取消报名(房东):</th>
                        <td>
                            <textarea name="sms_brefundpartyapply" style="width:350px; height:100px;"><?php echo ($Site["sms_brefundpartyapply"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">退订申请审核通过:</th>
                        <td>
                            <textarea name="sms_refundreviewsuccess" style="width:350px; height:100px;"><?php echo ($Site["sms_refundreviewsuccess"]); ?></textarea>  
                        </td>
                    </tr>
                    <tr>
                        <th width="140">退订申请审核不通过:</th>
                        <td>
                            <textarea name="sms_refundreviewfail" style="width:350px; height:100px;"><?php echo ($Site["sms_refundreviewfail"]); ?></textarea>  
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
</body>
</html>