<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="hidden item" <?php if(!empty($type)): ?>onclick="closeframe(this,<?php echo ($vo["id"]); ?>,'<?php echo ($vo["nickname"]); ?>','<?php echo ($vo["head"]); ?>','<?php echo ($vo["phone"]); ?>')"<?php endif; ?>>
        <div class="fl">
            <img src="/default_head.png" data-original="<?php echo ($vo["head"]); ?>" class="pic"/>
        </div>
        <div class="fl">
            <?php echo ((isset($vo["nickname"]) && ($vo["nickname"] !== ""))?($vo["nickname"]):"未填写"); ?>
        </div>
        <div class="fr">
            <?php echo (date("Y-m-d",$vo["reg_time"])); ?>
        </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>