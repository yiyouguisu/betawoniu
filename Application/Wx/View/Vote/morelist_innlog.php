<volist name="data" id="vo">
    <li class="item">
        <span>{$vo.description}</span>
        <label><eq name="vo['type']" value="1">+</eq><eq name="vo['type']" value="2">-</eq>{$vo.num|default="0"}</label>
    </li>
</volist>