<?php if (!defined('THINK_PATH')) exit(); if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="recom_list pr">
      <div class="recom_a pr">
        <a href="<?php echo U('Hostel/show');?>?id=<?php echo ($vo["id"]); ?>">
          <img src="<?php echo ($vo["thumb"]); ?>" style="height:240px">
        </a>
        <div class="recom_d pa">
          <a href="<?php echo U('member/memberHome');?>?id=<?php echo ($vo["uid"]); ?>" style="display:block;">
            <img src="<?php echo ($vo["head"]); ?>" style="width:60px;height:60px;">
          </a>
        </div>
        <div class="recom_g f18 center pa">
            <div class="recom_g1 fl"><em>￥</em><?php echo ($vo["money"]); ?><span>起</span>
            </div>
            <div class="recom_g2 fl"><?php echo ($vo["evaluation"]); ?><span>分</span>
            </div>
        </div>
      </div>
      <div class="recom_c pa">
          <?php if($vo["iscollect"] == 1): ?><div class="recom_gg collect recom_c_cut" data-id="<?php echo ($vo["id"]); ?>"></div>
          <?php else: ?>
            <div class="recom_gg collect" data-id="<?php echo ($vo["id"]); ?>"></div><?php endif; ?>
      </div>
      <div class="recom_e">
          <div class="land_f1 recom_e1 f16"><?php echo ($vo["title"]); ?></div>
          <div class="recom_f">
              <div class="recom_f1 recom_hong f12 fl">
                  <img src="/Public/Web/images/add_e.png">距你 <span class="distances" data-lat="<?php echo ($vo["lat"]); ?>" data-lng="<?php echo ($vo["lng"]); ?>"></span>km
              </div>
              <div class="recom_f2 fr">
                  <div class="land_h recom_f3 vertical">
                      <div class="land_h2 f12 vertical">
                          <?php if($vo["ishit"] == 1): ?><img src="/Public/Web/images/poin_1.png">
                          <?php else: ?>
                            <img src="/Public/Web/images/poin.png"><?php endif; ?>
                          <span><?php echo ($vo["hit"]); ?></span>
                      </div>
                      <div class="land_h1 f12 vertical" style="width:30%">
                          <img src="/Public/Web/images/land_d3.png">
                          <span><?php echo ($vo["reviewnum"]); ?></span>条评论
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div><?php endforeach; endif; else: echo "" ;endif; ?>