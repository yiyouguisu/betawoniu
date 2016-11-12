<volist name="data" id="vo">
    <li class="fl item">
        <a href="{:U('Wx/Vote/show',array('id'=>$vo['id']))}" class="pr">
            <img src="{$vo.logo}" data-original="{$vo.thumb}" class="pic" />
        </a>
        <i>{:str_cut($vo['name'],10)}</i>
        <p class="hidden">
            <span class="fl"><img src="__IMG__/Selection/map.png" />{:str_cut($vo['address'],5)}</span>
            <label class="fr"> 编号: {$vo.id}</label>
        </p>
        <eq name="vo['isvote']" value="2">
            <div class="Selection_label voteparty" data-id="{$vo.id}"><img src="__IMG__/Selection/hand.png" />为他投票({$vo.votenum})</div>
            <else />
            <div class="Selection_label" style="background: #929292;" data-id="{$vo.id}"><img src="__IMG__/vote/img3.png" />已经投票({$vo.votenum})</div>
        </eq>


    </li>
</volist>