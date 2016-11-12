<volist name='note' id='vo'>
    <div class="land_d pr f0">
        <div class="land_e vertical">
            <a href="{:U('Web/Note/show',array('id'=>$vo['id']))}">
                <img src="{$vo.thumb|default='__IMG__/default.jpg'}" style="width: 100%;height: 30vw;">
            </a>
        </div>
        <div class="land_f vertical">
            <div class="land_f1 f15">
                <a href="{:U('Web/Note/show',array('id'=>$vo['id']))}" style="color:#000">
                    {:str_cut($vo['title'],8)}
                </a>
            </div>
            <div class="land_f2 f11">{$vo.begintime|date='Y-m-d',###}</div>
            <div class="land_f2 f11">{:str_cut($vo['description'],25)}</div>
            <div class="land_f3 pa f0">
                  <div class="land_f4 vertical">
                    <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}">
                        <img src="{$vo.head}">
                    </a>
                  </div>
                  <div class="land_h tra_wc vertical">
                      <div class="land_h1 f11 vertical">
                            <img src="__IMG__/land_d3.png">
                            <span>{$vo.reviewnum}</span>条评论
                      </div>
                      <div class="land_h2 f11 vertical">
                            <img src="__IMG__/land_d4.png">
                            <span>{$vo.hit}</span>
                      </div>
                  </div>
            </div>
        </div>
    </div>
</volist>