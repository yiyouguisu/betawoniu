<volist name="data" id="vo">
    <li class="fl item">
        <div class="pr vote-01">
            <img src="__IMG__/default.png" data-original="{$vo.thumb}" class="pic" />
            <div class="pa vote_add">
                <span>票数:</span>
                <i>{$vo.votenum|default="0"}</i>
            </div>
        </div>
        <span>
            {:str_cut($vo['title'],10)}
        </span>
        <p class="hidden">
            <i><img src="__IMG__/vote/map.png" />{:getarea($vo['area'])}</i>
            <label> 编号: {$vo.hid}</label>
        </p>
        <label class="vote_chang_color"><img src="__IMG__/vote/img3.png" />已经投票</label>
    </li>
</volist>