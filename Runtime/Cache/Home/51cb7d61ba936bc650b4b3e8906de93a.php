<?php if (!defined('THINK_PATH')) exit();?><li id="room_<?php echo ($data["rid"]); ?>">
    <div class="hidden Release_of_legend_m3t_list">
        <div class="fl Release_of_legend_m3t_list2">
            <a href="javascript:;">
                <img src="<?php echo ($data["thumb"]); ?>" style="width:256px;height:156px" />
            </a>
        </div>
        <div class="fl Release_of_legend_m3t_list3">
            <div class="top">
                <a href="javascript:;"><?php echo ($data["title"]); ?></a>
            </div>
            <div class="center hidden">
                <ul class="center_ul hidden middle">
                    <li><img src="/Public/Home/images/Icon/img42.png" /></li>
                    <li><img src="/Public/Home/images/Icon/img42.png" /></li>
                    <li><img src="/Public/Home/images/Icon/img42.png" /></li>
                    <li><img src="/Public/Home/images/Icon/img42.png" /></li>
                    <li><img src="/Public/Home/images/Icon/img42.png" /></li>
                </ul>
                <span class="middle"><em>10.0</em>分</span>
                <div class="center_ul_list middle">
                    <img src="/Public/Home/images/Icon/img10.png" /><i><em>0</em>条评论</i>
                </div>
            </div>
            <div class="center2">
                <span>房间面积：<em><?php echo ((isset($data["area"]) && ($data["area"] !== ""))?($data["area"]):"0.0"); ?>m² </em></span>
                <span>床型信息：<em><?php echo ($data["bedtype"]); ?></em></span>
                <span>最多入住：<em><?php echo ((isset($data["mannum"]) && ($data["mannum"] !== ""))?($data["mannum"]):"0"); ?>人</em></span>
            </div>
            <div class="bottom">
                <?php if(is_array($support)): $i = 0; $__LIST__ = $support;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><i><img src="<?php echo ($vo["red_thumb"]); ?>" /><em><?php echo ($vo["catname"]); ?></em></i><?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
        </div>
        <div class="fr Release_of_legend_m3t_list4" style="text-align: center; width: 224px;">
            <i><em><?php echo ((isset($data["money"]) && ($data["money"] !== ""))?($data["money"]):"0.0"); ?></em>元起</i>
            <input type="button" class="delroom" data-id="<?php echo ($data["rid"]); ?>" value="删除" />
            <input type="button" class="editroom" data-id="<?php echo ($data["rid"]); ?>" value="修改" />
        </div>
    </div>
</li>