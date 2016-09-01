<volist name="data" id="vo">
    <li class="item">
        <a href="{:U('Wx/Vote/show',array('id'=>$vo['id']))}">
            <div class="hidden activity1">
                <span class="fl">{$vo.title}</span>
                <i class="fr"></i>
            </div>
            <div class="activity2">
                <p>{$vo.content}</p>
            </div>
        </a>
    </li>
</volist>