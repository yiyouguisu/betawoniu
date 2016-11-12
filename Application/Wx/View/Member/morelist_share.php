<volist name="data" id="vo">
    <li class="hidden item" <notempty name="type">  onclick="closeframe(this,{$vo.id},'{$vo.nickname}','{$vo.head}','{$vo.phone}')" </notempty>>
        <div class="fl">
            <img src="/default_head.png" data-original="{$vo.head}" class="pic"/>
        </div>
        <div class="fl">
            {$vo.nickname|default="未填写"}
        </div>
        <div class="fr">
            {$vo.reg_time|date="Y-m-d",###}
        </div>
    </li>
</volist>