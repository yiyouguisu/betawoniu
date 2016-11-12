<div class="footer">
    <ul>
        <empty name="INDEXCTRL">
          <li>
        <else />
          <li class="foot_cut">
        </empty>
            <a href="/index.php/Web/">
                <div class="foot_a">
                  <empty name="INDEXCTRL">
                    <img src="__IMG__/foot_a1.png">
                  <else />
                    <img src="__IMG__/foot_b1.png">
                  </empty>
                </div>
                <div class="foot_b">首页</div>
            </a>
        </li>
        <empty name="WONIUCTRL">
          <li>
        <else />
          <li class="foot_cut">
        </empty>
            <a href="{:U('Web/Woniu/index')}">
                <div class="foot_a">
                  <empty name="WONIUCTRL">
                    <img src="__IMG__/foot_a2.png">
                  <else />
                    <img src="__IMG__/foot_b2.png">
                  </empty>
                </div>
                <div class="foot_b">蜗牛</div>
            </a>
        </li>

        <empty name="TRIPCTRL">
          <li>
        <else />
          <li class="foot_cut">
        </empty>
            <a href="{:U('Web/Trip/myTrips')}">
                <div class="foot_a">
                    <empty name="TRIPCTRL">
                      <img src="__IMG__/foot_a3.png"></div>
                    <else />
                      <img src="__IMG__/foot_b3.png"></div>
                    </empty>
                <div class="foot_b">行程</div>
            </a>
        </li>
        <empty name="MYCTRL">
          <li>
        <else />
          <li class="foot_cut">
        </empty>
            <a href="{:U('Web/Member/index')}">
                <div class="foot_a">
                  <empty name="MYCTRL">
                    <img src="__IMG__/foot_a4.png"></div>
                  <else />
                    <img src="__IMG__/foot_b4.png"></div>
                  </empty>
                <div class="foot_b">我的</div>
            </a>
        </li>
    </ul>
</div>
<div class="mask"></div>
<div class="fish_btm hide">
    <div class="fish_t center">
        <div class="fish_t1">
            <span></span>
            <img src="__IMG__/drop.jpg"></div>
    </div>
    <div class="fish_y">
        <ul>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="__IMG__/hm_a1.jpg"></a></div>
                <div class="fish_y2">微信</div>
            </li>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="__IMG__/hm_a2.jpg"></a></div>
                <div class="fish_y2 fish_y3">微博</div>
            </li>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="__IMG__/hm_a3.jpg"></a></div>
                <div class="fish_y2 fish_y4">QQ</div>
            </li>
        </ul>
    </div>
</div>
<include file="public:chat_uitls" />
</html>
