<?php if (!defined('THINK_PATH')) exit();?><div class="Event_details5_5">
    <span>评论</span><i>(<?php echo ((isset($reviewnum) && ($reviewnum !== ""))?($reviewnum):"0"); ?>)</i>
</div>
<div class="Event_details5_6">
    <ul class="Event_details5_6_ul">
        <?php if(is_array($reviewdata)): $i = 0; $__LIST__ = $reviewdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
                <div class="hidden Event_details5_6_list">
                    <div class="fl Event_details5_6_list2">
                        <a href="<?php echo U('Home/Member/detail',array('uid'=>$vo['uid']));?>">
                            <div>
                                <img src="<?php echo ($vo["head"]); ?>" style="width:77px;height:77px;border-radius: 50%;" />
                            </div>
                            <span class="f14 c000 tc nickname" ><?php echo ($vo["nickname"]); ?></span>
                        </a>
                    </div>
                    <div class="fr Event_details5_6_list3">
                        <p class="f16 c000"><?php echo ($vo["content"]); ?></p>
                        <div class="Event_details5_6_list3_01">
                            <i class="f12 c999">发表于<em><?php echo (date("Y-m-d H:i:s",$vo["inputtime"])); ?></em></i>
                        </div>
                        <a href="javascript:;" class="f12 Event_details5_6_list3_02 reply" data-id="<?php echo ($vo["rid"]); ?>" data-rname="<?php echo ($vo["nickname"]); ?>">回复</a>
                        <!-- <a href="javascript:;" class="f12 Event_details5_6_list3_02 quote" data-id="<?php echo ($vo["rid"]); ?>" data-rname="<?php echo ($vo["nickname"]); ?>">引用</a> -->
                        <a href="javascript:;" class="f12 Event_details5_6_list3_03 report" data-id="<?php echo ($vo["rid"]); ?>">举报</a>
                    </div>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
<div class="activity_chang4 ajaxpagebar">
    <?php echo ($Page); ?>
</div>
<div style="margin-bottom:40px;">

</div>