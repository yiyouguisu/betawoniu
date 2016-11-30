<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="pr item">
        <div class="rew_left pa"><img src="/Public/Wx/img/image/icon/Draw_result_left.png"  /></div>
        <div class="rew_right pa"><img src="/Public/Wx/img/image/icon/Draw_result_right.png" /></div>
        <div class="reward_main4_01_list">
            <div style="background:#fff; padding-bottom:2%;">
                <div class="reward_main4_01_list1 hidden">
                    <?php if($type == 6): ?><span>抽奖码 <?php echo ($vo["code"]); ?></span>
                        <a href="<?php echo U('Wx/News/backshow',array('nid'=>$vo['hid']));?>">获取更多</a>
                        <?php else: ?>
                        <?php if(($vo['vaid']) == "0"): ?><span>
                                <?php if(($vo['catid']) == "1"): ?>一等奖<?php endif; ?>
                                <?php if(($vo['catid']) == "2"): ?>二等奖<?php endif; ?>
                                <?php if(($vo['catid']) == "3"): ?>三等奖<?php endif; ?>
                                <?php if(($vo['catid']) == "4"): ?>四等奖<?php endif; ?>
                                <?php if(($vo['catid']) == "5"): ?>五等奖<?php endif; ?>
                            </span>
                            <?php else: ?>
                            <span>
                                <?php if(($vo['type']) == "1"): ?>全额抵用券<?php endif; ?>
                                <?php if(($vo['type']) == "2"): ?>5折抵用券<?php endif; ?>
                                <?php if(($vo['type']) == "3"): ?>8折抵用券<?php endif; ?>
                                <?php if(($vo['type']) == "4"): ?>普通投票抵用券<?php endif; ?>
                                <?php if(($vo['type']) == "5"): ?>邀请投票抵用券<?php endif; ?>
                            </span><?php endif; ?>
                        
                        <!--  <?php if(($vo['givenstatus']) == "2"): ?><span style="color:#666">
                                <?php if(($vo['type']) == "1"): ?>一等奖<?php endif; ?>
                                <?php if(($vo['type']) == "2"): ?>二等奖<?php endif; ?>
                                <?php if(($vo['type']) == "3"): ?>三等奖<?php endif; ?>
                                <?php if(($vo['type']) == "4"): ?>四等奖<?php endif; ?>
                                <?php if(($vo['type']) == "5"): ?>五等奖<?php endif; ?>
                            </span>
                            <?php else: ?>
                            <span>
                                <?php if(($vo['type']) == "1"): ?>一等奖<?php endif; ?>
                                <?php if(($vo['type']) == "2"): ?>二等奖<?php endif; ?>
                                <?php if(($vo['type']) == "3"): ?>三等奖<?php endif; ?>
                                <?php if(($vo['type']) == "4"): ?>四等奖<?php endif; ?>
                                <?php if(($vo['type']) == "5"): ?>五等奖<?php endif; ?>
                            </span><?php endif; ?> -->
                      
                        <?php if(($vo['type']) == "4"): ?><i>￥<em><?php echo ((isset($vo["price"]) && ($vo["price"] !== ""))?($vo["price"]):"0"); ?></em></i><?php endif; ?>
                        <?php if(($vo['type']) == "5"): ?><i>￥<em><?php echo ((isset($vo["price"]) && ($vo["price"] !== ""))?($vo["price"]):"0"); ?></em></i><?php endif; ?>
                        <?php if(($vo['givenstatus']) != "0"): ?><a class="reward_main4_01_list1a1" style="background-color:#666" href="javascript:;">赠送</a>
                            <?php else: ?>
                            <a class="reward_main4_01_list1a1" href="<?php echo U('Wx/Member/givencoupons',array('id'=>$vo['id']));?>">赠送</a><?php endif; endif; ?>
                </div>
                <?php if($vo['vaid'] != 0): ?><a href="<?php echo ($vo["link"]); ?>">
                <?php else: ?>
                    <a href="<?php echo U('Wx/Vote/show',array('id'=>$vo['hid']));?>"><?php endif; ?>
                <div class="reward_main4_01_list2">
                    <div class="reward_main4_01_list2_list1">
                        <span>适用于:</span>
                        <i><?php echo ($vo["house"]); ?></i>
                    </div>
                    <div class="reward_main4_01_list2_list1">
                        <span>有效期:</span>
                        <i><?php echo (date("Y-m-d",$vo["in_starttime"])); ?>至<?php echo (date("Y-m-d",$vo["in_endtime"])); ?></i>
                    </div>
                    <?php if($vo['vaid'] != 0): ?><div class="reward_main4_01_list2_list1">
                            <span>中奖码:</span>
                            <i><?php echo ($vo["code"]); ?></i>
                        </div>
                    <?php else: ?>
                        <div class="reward_main4_01_list2_list1">
                            <span>来源:</span>
                            <i>评选大转盘</i>
                        </div><?php endif; ?>
                </div>
                </a>
                <?php if($type != 6): ?><div class="reward_main4_01_list2_list2">
                        <?php if(($vo['givenstatus']) == "1"): ?><a href="javascript:;" style="color:#666" >等待入住中</a><?php endif; ?>
                        <?php if(($vo['givenstatus']) == "0"): ?><a href="<?php echo U('Wx/Member/usecoupons',array('id'=>$vo['id']));?>">立即使用</a><?php endif; ?>
                        <?php if(($vo['givenstatus']) == "2"): ?><a href="javascript:;" style="color:#666" >已完成</a><?php endif; ?>
                    </div><?php endif; ?>
            </div>
        </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>