<?php if (!defined('THINK_PATH')) exit(); if(is_array($party)): $i = 0; $__LIST__ = $party;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
      <div class="recom_a pr">
          <a href="<?php echo U('Web/Party/show',array('id'=>$vo['id']));?>">
            <img src="<?php echo ($vo["thumb"]); ?>" style="width: 100%;height: 60vw;">
          </a>
          <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>">
            <div class="recom_d pa"><img src="<?php echo ($vo["head"]); ?>"></div>
          </a>
      </div>
      <div class="recom_c pa">
        <div class="recom_gg collect <?php if($vo["iscollect"] == 1): ?>recom_c_cut<?php endif; ?>" data-id="<?php echo ($vo["id"]); ?>"></div>
      </div>
      <div class="recom_e">
         <div class="land_f1 recom_e1 f16"><?php echo str_cut($vo['title'],12);?></div>
         <div class="recom_k">
                  <div class="land_font">
                      <span>时间:</span> <?php echo (date('Y-m-d',$vo["starttime"])); ?> 至<?php echo (date('Y-m-d',$vo["endtime"])); ?>      
                  </div> 
                  <div class="land_font">
                      <span>地点:</span><?php echo getarea($vo['area']); echo ($vo["address"]); ?>      
                  </div> 
        </div>
        <div class="recom_s f16">
            已参与：
            <span id="sapn">
                <?php if(is_array($vo['joinlist'])): $i = 0; $__LIST__ = $vo['joinlist'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><img src='<?php echo ($v["head"]); ?>'><?php endforeach; endif; else: echo "" ;endif; ?>
            </span>
            <em>(<?php echo ((isset($vo["joinnum"]) && ($vo["joinnum"] !== ""))?($vo["joinnum"]):"0"); ?>人)</em>
        </div>
      </div>
  </div><?php endforeach; endif; else: echo "" ;endif; ?>