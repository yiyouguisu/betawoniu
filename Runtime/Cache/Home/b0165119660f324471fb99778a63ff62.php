<?php if (!defined('THINK_PATH')) exit(); if(is_array($data['room'])): $i = 0; $__LIST__ = $data['room'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
        <div class="hidden Release_of_legend_m3t_list">
            <div class="fl Release_of_legend_m3t_list2">
                <a href="<?php echo U('Home/Room/show',array('id'=>$vo['rid']));?>">
                    <img src="<?php echo ($vo["thumb"]); ?>" style="width:256px;height:160px"/>
                </a>
            </div>
            <div class="fl Release_of_legend_m3t_list3">
                <div class="top">
                    <a href="<?php echo U('Home/Room/show',array('id'=>$vo['rid']));?>"><?php echo ($vo["title"]); ?></a>
                </div>
                <div class="center hidden">
                    <ul class="center_ul hidden middle">
                        <?php echo getevaluation($vo['evaluationpercent']);?>
                    </ul>
                    <span class="middle"><em><?php echo ((isset($vo["evaluation"]) && ($vo["evaluation"] !== ""))?($vo["evaluation"]):"10.0"); ?></em>分</span>
                    <div class="center_ul_list middle">
                        <img src="/Public/Home/images/Icon/img10.png" /><i><em><?php echo ((isset($vo["reviewnum"]) && ($vo["reviewnum"] !== ""))?($vo["reviewnum"]):"0"); ?></em>条评论</i>
                    </div>
                </div>
                <div class="center2">
                    <span>房间面积：<em><?php echo ((isset($vo["area"]) && ($vo["area"] !== ""))?($vo["area"]):"0.0"); ?>平米 </em></span>
                    <span>床型信息：<em><?php echo ($vo["bedtype"]); ?></em></span>
                    <span>房间数量：<em><?php echo ((isset($vo["mannum"]) && ($vo["mannum"] !== ""))?($vo["mannum"]):"0"); ?>间</em></span>
                </div>
                <div class="bottom">
                    <?php if(is_array($vo['support'])): $i = 0; $__LIST__ = $vo['support'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><i>
                            <img src="<?php echo ($v["red_thumb"]); ?>" /><em><?php echo ($v["catname"]); ?></em>
                        </i><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="fr Release_of_legend_m3t_list4" style="text-align: center;">
                <i><em><?php echo ((isset($vo["money"]) && ($vo["money"] !== ""))?($vo["money"]):"0.0"); ?></em>元起</i>
                <input type="button" onclick="window.location.href='<?php echo U('Home/Room/show',array('id'=>$vo['rid']));?>'" value="立即预定" />
            </div>
        </div>
    </li><?php endforeach; endif; else: echo "" ;endif; ?>