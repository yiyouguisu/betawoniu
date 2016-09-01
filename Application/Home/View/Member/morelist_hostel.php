<ul class="order_main3_ul">
    <volist name="hostel" id="vo">
        <li>
            <div class="hidden">
                <div class="fl order_main3_list">
                    <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">
                        <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:144px; height:90px" />
                    </a>
                </div>
                <div class="fl order_main3_list2">
                    <div class="order_main3_list2_top hidden">
                        <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}" class="f24 c333 fl">{$vo.title}</a>
                        <!-- <div class="fr legend_main2">
                            <a href="{:U('Home/Hostel/edit',array('id'=>$vo['id']))}">编辑</a>
                            <input type="button" class="hostel_delete" data-id="{$vo.id}" value="删除" />
                        </div> -->
                    </div>
                    <div class="order_main3_list2_bottom hidden">
                        <div class="fl hidden order_main3_list2_bottom4">
                            <i class="f22">￥</i><span class="f36">{$vo.money|default="0.00"}</span><label class="f18">起</label>
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