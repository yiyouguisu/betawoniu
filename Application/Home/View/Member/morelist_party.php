<ul class="order_main3_ul">
    <volist name="party" id="vo">
        <li>
            <div class="hidden">
                <div class="fl order_main3_list">
                    <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">
                        <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:144px; height:90px" />
                    </a>
                </div>
                <div class="fl order_main3_list2">
                    <div class="order_main3_list2_top hidden">
                        <a href="" class="f24 c333 fl">{$vo.title}</a>
                        <!-- <div class="fr legend_main2">
                            <a href="{:U('Home/Party/edit',array('id'=>$vo['id']))}">编辑</a>
                            <input type="button" class="party_delete" data-id="{$vo.id}" value="删除" />
                        </div> -->
                    </div>
                    <div class="order_main3_list2_bottom hidden">
                        <div class="fl order_main3_list2_bottom5">
                            <span class="f14 c999">时间 :<em class="c666 f12">{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em></span>
                            <span class="f14 c999">地点 :<em class="c666 f14">{:getarea($vo['area'])}{$vo.address} </em></span>
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