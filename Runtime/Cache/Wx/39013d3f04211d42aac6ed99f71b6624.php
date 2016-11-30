<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="item">
        <div class="Wait_for_main1_list">
            <div class="Wait_for_main1_list2">
                <a href="<?php echo ($vo["link"]); ?>"><?php echo ($vo["title"]); ?></a>
            </div>
            <div class="Wait_for_main1_list3 hidden">
                <div class="fl">
                    <img src="/Public/Wx/img/image/icon/time.png" /><span>开奖时间：<em><?php echo (date("Y-m-d",$vo["endtime"])); ?></em></span>
                </div>
                <div class="fr">
                    
                        <?php if(($vo['iszhongjiang']) == "1"): ?><label class="Has_ended_label2">
                            已中奖
                            </label>
                            <?php else: ?>
                            <label class="Has_ended_label1">
                            未中奖
                            </label><?php endif; ?>
                    
                </div>
            </div>
            <div class="Wait_for_main1_list4 hidden">
                <div class="fl Wait_for_main1_list5">
                    <span>抽奖码 :</span>
                </div>
                <div class="fl Wait_for_main1_list6 hidden">
                    <span class="c999 f11">
                        <?php if(is_array($vo['pool'])): $i = 0; $__LIST__ = $vo['pool'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i; if(($key) != "0"): ?>、<?php endif; echo ($v); endforeach; endif; else: echo "" ;endif; ?>
                    </span>
                    <a href="<?php echo U('Wx/Member/pool',array('vaid'=>$vo['id']));?>" class="c333 f12 fr">更多</a>
                </div>
            </div>
        </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>