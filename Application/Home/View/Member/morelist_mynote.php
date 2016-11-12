<ul class="My_travels_main3_ul">
    <volist name="data" id="vo">
        <li>
            <div class="hidden My_travels_main3_list hidden">
                <div class="fl My_travels_main3_list2">
                    <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">
                        <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:200px; height:151px" />
                    </a>
                </div>
                <div class="fl My_travels_main3_list3">
                    <div class="My_travels_main3_list3_1">
                        <span class="f20 c333">{$vo.title}</span>
                        <i class="f12 c999">{$vo.inputtime|date="Y-m-d",###}</i>
                        <p class="f14 c666">{:str_cut($vo['description'],30)}</p>
                    </div>
                    <div class="My_travels_main3_list3_4 hidden">
                        <div class="fl My_travels_main3_list3_2 hidden">
                            <div class="My_travels_main3_list3_2_01 fl">
                                <img src="__IMG__/Icon/img10.png" />
                                <span class="f14 c999"><em>{$vo.reviewnum|default="0"}</em>条点评</span>
                            </div>
                            <div class="My_travels_main3_list3_2_02 fl">
                                <img src="__IMG__/Icon/img9.png" /><i class="f12 c999">{$vo.hit|default="0"}</i>
                            </div>
                        </div>
                        <div class="fr My_travels_main3_list3_3">
                            <a href="{:U('Home/Note/edit',array('id'=>$vo['id']))}">编辑</a>
                            <input type="button" class="note_delete" data-id="{$vo.id}" value="删除" />
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </volist>                      
</ul>
<div style="height:20px;"></div>
<div class="activity_chang4 ajaxpagebar">
    {$Page}
</div>