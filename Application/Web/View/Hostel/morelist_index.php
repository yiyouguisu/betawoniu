<volist name="data" id="vo">
  <div class="recom_list pr">
      <div class="recom_a pr">
        <a href="{:U('Hostel/show')}?id={$vo.id}">
          <img src="{$vo.thumb}" style="height:240px">
        </a>
        <div class="recom_d pa">
          <a href="{:U('member/memberHome')}?id={$vo.uid}" style="display:block;">
            <img src="{$vo.head}" style="width:60px;height:60px;">
          </a>
        </div>
        <div class="recom_g f18 center pa">
            <div class="recom_g1 fl"><em>￥</em>{$vo.money}<span>起</span>
            </div>
            <div class="recom_g2 fl">{$vo.evaluation}<span>分</span>
            </div>
        </div>
      </div>
      <div class="recom_c pa">
          <if condition="$vo.iscollect eq 1">
            <div class="recom_gg collect recom_c_cut" data-id="{$vo.id}"></div>
          <else />
            <div class="recom_gg collect" data-id="{$vo.id}"></div>
          </if>
      </div>
      <div class="recom_e">
          <div class="land_f1 recom_e1 f16">{$vo.title}</div>
          <div class="recom_f">
              <div class="recom_f1 recom_hong f12 fl">
                  <img src="__IMG__/add_e.png">距你 <span class="distances" data-lat="{$vo.lat}" data-lng="{$vo.lng}"></span>km
              </div>
              <div class="recom_f2 fr">
                  <div class="land_h recom_f3 vertical">
                      <div class="land_h2 f12 vertical">
                          <if condition="$vo.ishit eq 1">
                            <img src="__IMG__/poin_1.png">
                          <else />
                            <img src="__IMG__/poin.png">
                          </if>
                          <span>{$vo.hit}</span>
                      </div>
                      <div class="land_h1 f12 vertical" style="width:30%">
                          <img src="__IMG__/land_d3.png">
                          <span>{$vo.reviewnum}</span>条评论
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</volist>
