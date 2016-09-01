<volist name="data" id="vo">
    <li class="item">
        <a href="{:U('Wx/Vote/show',array('id'=>$vo['id']))}">
            <div class="hidden activity1">
                <span class="fl">{$vo.title}</span>
                <i class="fr"></i>
            </div>
            <div class="activity2">
                <p>根据比赛规则{$vo.title}于{$vo.starttime|date="Y-m-d",###}至{$vo.endtime|date="Y-m-d",###}抽奖结果已知晓，具体点击查看详细</p>
            </div>
        </a>
    </li>
</volist>