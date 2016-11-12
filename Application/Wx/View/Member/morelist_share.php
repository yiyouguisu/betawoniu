<volist name="data" id="vo">
    <li class="hidden item" <notempty name="type">  onclick="closeframe(this,{$vo.tuid},'{$vo.nickname}','{$vo.head}')" </notempty>>
        <div class="fl">
            <img src="/default_head.png" data-original="{$vo.head}" class="pic"/>
        </div>
        <div class="fl">
            {$vo.nickname|default="未填写"}
        </div>
        <div class="fr">
            {$vo.inputtime|date="Y-m-d",###}
        </div>
    </li>
</volist>