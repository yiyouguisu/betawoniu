<div class="fl hmain5_l">
    <div class="hmain5_l6 hidden">
        <span>最近访客</span>
        <ul class="hmain5_l6_ul hidden">
            <volist name="user['viewlist']" id="vo">
                <li class="fl">
                    <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                        <img src="{$vo.head}" style="width:58px;height:58px;border-radius: 50%;"/>
                        <i>{$vo.nickname}</i>
                    </a>
                </li>
            </volist>
        </ul>

        <div class="hmain5_l6_2">
            <p>累计访问：<em>{$user.viewnum|default="0"}</em></p>
            <p>今日访问：<em>{$user.todayviewnum|default="0"}</em></p>
        </div>
    </div>
</div>

                