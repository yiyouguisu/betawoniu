<?php if (!defined('THINK_PATH')) exit();?><ul class="order_main3_ul">
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($vo['varname']) == "party"): ?><li>
                <div class="hidden">
                    <div class="fl order_main3_list">
                        <a href="<?php echo U('Home/Party/show',array('id'=>$vo['id']));?>">
                            <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:144px; height:90px" />
                        </a>
                    </div>
                    <div class="fl order_main3_list2">
                        <div class="order_main3_list2_top hidden">
                            <a href="" class="f24 c333 fl"><?php echo ($vo["title"]); ?></a>
                            <div class="fr legend_main2">
                                <a href="<?php echo U('Home/Party/edit',array('id'=>$vo['id']));?>">编辑</a>
                                <input type="button" class="party_delete" data-id="<?php echo ($vo["id"]); ?>" value="删除" />
                                <?php if($vo['status'] == '2' ): if($vo['isoff'] == '0' ): ?><input type="button" class="party_switchoff" data-isoff="<?php echo ($vo["isoff"]); ?>" data-id="<?php echo ($vo["id"]); ?>" value="下架" /> 
                                    <?php else: ?>
                                        <input type="button" class="party_switchoff" data-isoff="<?php echo ($vo["isoff"]); ?>" data-id="<?php echo ($vo["id"]); ?>" value="启用" /><?php endif; endif; ?>
                            </div>
                        </div>
                        <div class="order_main3_list2_bottom hidden">
                            <div class="fl order_main3_list2_bottom5">
                                <span class="f14 c999">时间 :<em class="c666 f12"><?php echo (date("Y-m-d",$vo["starttime"])); ?> - <?php echo (date("Y-m-d",$vo["endtime"])); ?></em></span>
                                <span class="f14 c999">地点 :<em class="c666 f14"><?php echo getarea($vo['area']); echo ($vo["address"]); ?> </em></span>
                            </div>
                        </div>
                    </div>
                </div>
            </li><?php endif; ?>
        <?php if(($vo['varname']) == "hostel"): ?><li>
                <div class="hidden">
                    <div class="fl order_main3_list">
                        <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>">
                            <img class="pic" data-original="<?php echo ($vo["thumb"]); ?>" src="/Public/Home/images/default.jpg" style="width:144px; height:90px" />
                        </a>
                    </div>
                    <div class="fl order_main3_list2">
                        <div class="order_main3_list2_top hidden">
                            <a href="<?php echo U('Home/Hostel/show',array('id'=>$vo['id']));?>" class="f24 c333 fl"><?php echo ($vo["title"]); ?></a>
                            <div class="fr legend_main2">
                                <a href="<?php echo U('Home/Hostel/edit',array('id'=>$vo['id']));?>">编辑</a>
                                <input type="button" class="hostel_delete" data-id="<?php echo ($vo["id"]); ?>" value="删除" />
                                <?php if($vo['status'] == '2' ): if($vo['isoff'] == '0' ): ?><input type="button" class="hostel_switchoff" data-isoff="<?php echo ($vo["isoff"]); ?>" data-id="<?php echo ($vo["id"]); ?>" value="下架" /> 
                                    <?php else: ?>
                                        <input type="button" class="hostel_switchoff" data-isoff="<?php echo ($vo["isoff"]); ?>" data-id="<?php echo ($vo["id"]); ?>" value="启用" /><?php endif; endif; ?>
                            </div>
                        </div>
                        <div class="order_main3_list2_bottom hidden">
                            <div class="fl hidden order_main3_list2_bottom4">
                                <i class="f22">￥</i><span class="f36"><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.00"); ?></span><label class="f18">起</label>
                            </div>
                        </div>
                    </div>
                </div>
            </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>  
</ul>
<div style="height:20px;"></div>
<div class="activity_chang4 ajaxpagebar">
    <?php echo ($Page); ?>
</div>