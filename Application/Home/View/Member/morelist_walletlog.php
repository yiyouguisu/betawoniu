<ul>
    <volist name="walletlog" id="vo">
        <li>
            <div class="hidden pd_c">
                <div class="fl pd_main17_aleft">
                    <span>{$vo.remark}</span>
                    <i>余额：<em>{$vo.total|default="0.00"}</em></i>
                </div>
                <div class="fr pd_main17_aright">
                    <i>{$vo.addtime|date="Y-m-d",###}</i>
                    <span><eq name="vo['dcflag']" value="1">+<else />-</eq>{$vo.money|default="0.00"}</span>
                </div>
            </div>
        </li>
    </volist>
</ul>
<div style="height:20px;"></div>
<div class="activity_chang4 ajaxpagebar">
    {$Page}
</div>