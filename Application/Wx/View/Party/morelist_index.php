<volist name="data" id="vo">
    <li class="fl item">
        <a href="{:U('Wx/Party/show',array('id'=>$vo['id']))}" class="pr">
            <img src="__IMG__/default.png" data-original="{$vo.thumb}" class="pic" />
            <div class="pa vote1_add">
                <span>票数:</span>
                <i class="votenum">{$vo.votenum|default="0"}</i>
            </div>
        </a>
        <i>{:str_cut($vo['title'],10)}</i>
        <p class="hidden">
            <span class="fl"><img src="__IMG__/Selection/map.png" />{:getarea($vo['area'])}</span>
            <label class="fr"> 编号: {$vo.id}</label>
        </p>
        <eq name="vo['isvote']" value="0">
            <div class="Selection_label voteparty" data-id="{$vo.id}"><img src="__IMG__/Selection/hand.png" />为他投票</div>
            <else />
            <div class="Selection_label" data-id="{$vo.id}"><img src="__IMG__/vote/img3.png" />已经投票</div>
        </eq>


    </li>
</volist>