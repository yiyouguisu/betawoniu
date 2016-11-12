<div class="fl order_main2_1">
    <div class="order_main2_101">
        <label>你可能感兴趣的美宿</label>
        <ul class="order_main2_1_ul">
            <volist name="interestedhostel" id="vo">
                <li>
                    <div class="hidden order_main2_102">
                        <div class="fl order_main2_1_list">
                            <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">
                                <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:82px;height:50px" />
                            </a>
                        </div>
                        <div class="fl order_main2_1_list2">
                            <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">
                                <span>{:str_cut($vo['title'],15)}</span>
                                <i>￥{$vo.money|default="0.00"}起</i>
                            </a>
                        </div>
                    </div>
                </li>
            </volist>
        </ul>
    </div>
</div>