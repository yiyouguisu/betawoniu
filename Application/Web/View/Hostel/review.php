<include file="public:head" />
<div class="header center z-index112 pr f18 fix-head">
        点评
        <div class="head_go pa">
            <a href="javascript:history.go(-1)">
                <img src="__IMG__/go.jpg">
            </a><span>&nbsp;</span>
        </div>
    </div>
    <div class="container" style="margin-top:6rem">
        <div class="home_box">
            <div class="home_top center">
                <div class="home_a1">{$evaluation.evaluation}<span>分</span>
                </div>
                <div class="home_a2">
                    <div class="home_a3">
                        <img src="__IMG__/star.png">
                    </div>
                    <div class="home_a3">
                        <img src="__IMG__/star.png">
                    </div>
                    <div class="home_a3">
                        <img src="__IMG__/star.png">
                    </div>
                    <div class="home_a3">
                        <img src="__IMG__/star.png">
                    </div>
                </div>
            </div>
            <div class="home_b">
                <div class="home_b_box">
                    <div class="home_b1">整洁卫生 : <span>{$evaluation.neat}分</span>
                    </div>
                    <div class="home_b1">安全程度 : <span>{$evaluation.safe}分</span>
                    </div>
                </div>
                <div class="home_b_box">
                    <div class="home_b1">描述相符 : <span>{$evaluation.match}分</span>
                    </div>
                    <div class="home_b1">交通位置 : <span>{$evaluation.position}分</span>
                    </div>
                </div>
                <div class="home_b_box" style="border:0">
                    <div class="home_b1">性价比 : <span>{$evaluation.cost}分</span>
                    </div>
                </div>
            </div>
            <div class="land_c f14">
                <empty name="reviewlist">
                  <div style="text-align:center;color:#999;padding:5px" class="ft14">暂无评价</div>
                </empty>
                <volist name="reviewlist" id="review">
                  <div class="fans_list">
                      <div class="per_tx fl">
                          <img src="{$review.head}" style="width:42px;height:42px;border-radius:50%">
                      </div>
                      <div class="fans_b per_tr fl">
                          <div class="fans_b1 home_c f16">{$review.nickname}
                              <div class="home_c1">{$review.inputtime|date='Y-m-d', ###}</div>
                          </div>
                          <div class="fans_b2 f14">{$review.content}</div>
                      </div>
                  </div>
                </volist>
            </div>
        </div>
    </div>
</body>
</html>
