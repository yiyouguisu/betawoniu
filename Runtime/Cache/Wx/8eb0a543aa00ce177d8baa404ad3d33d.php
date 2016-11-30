<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="aitem">
        <div class="Wait_for_main1_list">
            <div class="Wait_for_main1_list2">
                <a href="<?php echo ($vo["link"]); ?>"><?php echo ($vo["title"]); ?></a>
            </div>
            <div class="Wait_for_main1_list3">
                <div class="middle Wait_for_main1_list3_1">
                    <img src="/Public/Wx/img/image/icon/time.png" /><span>开奖时间：<em><?php echo (date("Y-m-d",$vo["endtime"])); ?></em></span>
                </div>
                <div class="middle Wait_for_main1_list3_2">
                    <a href="<?php echo U('Wx/Member/setphone',array('id'=>$vo['id'],'houseid'=>$vo['houseid'],'from'=>'waitreward'));?>">
                        <i>邀好友拿抽奖码</i>
                        <img src="/Public/Wx/img/image/icon/img5.png" />
                    </a>
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