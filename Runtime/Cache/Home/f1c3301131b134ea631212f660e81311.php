<?php if (!defined('THINK_PATH')) exit();?><ul class="Inn_introduction_main10_botttom_ul">
    <?php if(is_array($reviewdata)): $i = 0; $__LIST__ = $reviewdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
            <div class="hidden Inn_introduction_main10_botttom_list">
                <div class="fl Inn_introduction_main10_botttom_list2">
                    <a href="<?php echo U('Home/Member/detail',array('uid'=>$vo['uid']));?>">
                        <div><img src="<?php echo ($vo["head"]); ?>" width="76px" height="76px" style="border-radius: 50%;" /></div>
                        <span><?php echo ($vo["nickname"]); ?></span>
                    </a>
                </div>
                <div class="fl Inn_introduction_main10_botttom_list3">
                    <div>
                        <div class="Inn_Star_praise hidden">
                            <ul class="Inn_Star_praise_ul hidden middle">
                                <?php echo getevaluation($vo['evaluationpercent']);?>
                            </ul>
                            <span class="middle"><em><?php echo ((isset($vo["evaluation"]) && ($vo["evaluation"] !== ""))?($vo["evaluation"]):"0.0"); ?></em>分</span>
                        </div>
                    </div>
                    <div class="Inn_introduction_main10_botttom_list3_1">
                        <p><?php echo ($vo["content"]); ?></p>
                        <span>发表于<em> <?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?></em></span>
                    </div>
                </div>
            </div>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>       
</ul>
<div class="hidden Inn_introduction_main10_botttom2">
    <div class="fl">
        <div class="activity_chang4 ajaxpagebar">
            <?php echo ($Page); ?>
        </div>
    </div>
    <div class="fr Inn_introduction_main10_botttom3">
        <span>共<em><?php echo ((isset($totalpages) && ($totalpages !== ""))?($totalpages):"0"); ?></em>页<em><?php echo ((isset($totalrows) && ($totalrows !== ""))?($totalrows):"0"); ?></em>条</span>
    </div>
</div>