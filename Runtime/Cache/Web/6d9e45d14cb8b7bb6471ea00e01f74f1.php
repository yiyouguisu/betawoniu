<?php if (!defined('THINK_PATH')) exit(); if(is_array($note)): $i = 0; $__LIST__ = $note;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="land_d pr f0">
        <div class="land_e vertical">
            <a href="<?php echo U('Web/Note/show',array('id'=>$vo['id']));?>">
                <img src="<?php echo ((isset($vo["thumb"]) && ($vo["thumb"] !== ""))?($vo["thumb"]):'/Public/Web/images/default.jpg'); ?>" style="width: 100%;height: 30vw;">
            </a>
        </div>
        <div class="land_f vertical">
            <div class="land_f1 f15">
                <a href="<?php echo U('Web/Note/show',array('id'=>$vo['id']));?>" style="color:#000">
                    <?php echo str_cut($vo['title'],8);?>
                </a>
            </div>
            <div class="land_f2 f11"><?php echo (date('Y-m-d',$vo["begintime"])); ?></div>
            <div class="land_f2 f11"><?php echo str_cut($vo['description'],25);?></div>
            <div class="land_f3 pa f0">
                  <div class="land_f4 vertical">
                    <a href="<?php echo U('Web/Member/memberHome',array('id'=>$vo['uid']));?>">
                        <img src="<?php echo ($vo["head"]); ?>">
                    </a>
                  </div>
                  <div class="land_h tra_wc vertical">
                      <div class="land_h1 f11 vertical">
                            <img src="/Public/Web/images/land_d3.png">
                            <span><?php echo ($vo["reviewnum"]); ?></span>条评论
                      </div>
                      <div class="land_h2 f11 vertical">
                            <img src="/Public/Web/images/land_d4.png">
                            <span><?php echo ($vo["hit"]); ?></span>
                      </div>
                  </div>
            </div>
        </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>