<volist name="data" id="vo">
    <li class="item">
        <span>{$vo.remark}</span>
        <label><eq name="vo['dcflag']" value="1">+</eq><eq name="vo['dcflag']" value="2">-</eq>{$vo.money|default="0.00"}</label>
    </li>
</volist>