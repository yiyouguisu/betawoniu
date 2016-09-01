<ul class="My_collection_main_ul">
    <volist name="data" id="vo">
        <eq  name="vo['varname']" value="note">
            <li>
                <div class="My_collection_main_list hidden">
                    <div class="fl My_collection_main_list2">
                        <a href="{:U('Home/Note/show',array('id'=>$vo['nid']))}">
                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:144px; height:90px" />
                        </a>
                    </div>
                    <div class="fl My_collection_main_list3">
                        <a href="{:U('Home/Note/show',array('id'=>$vo['nid']))}" class="f24 c333">{$vo.title}</a>
                        <div class="My_collection_main_list4"></div>
                        <div class="My_collection_main_list5">
                            <p>{$vo.description}</p>
                        </div>
                    </div>
                </div>
            </li>
        </eq>
        <eq  name="vo['varname']" value="party">
            <li>
                <div class="My_collection_main_list hidden">
                    <div class="fl My_collection_main_list2">
                        <a href="{:U('Home/Party/show',array('id'=>$vo['aid']))}">
                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:144px; height:90px" />
                        </a>
                    </div>
                    <div class="fl My_collection_main_list3">
                        <a href="{:U('Home/Party/show',array('id'=>$vo['aid']))}" class="f24 c333">{$vo.title}</a>
                        <div class="Merchant_Colletion_Activities_main">
                            <span>时间 :<em>{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em></span>
                            <span>地点 :<em>{:getarea($vo['area'])}{$vo.address} </em></span>
                        </div>
                    </div>
                </div>
            </li>
        </eq>
        <eq  name="vo['varname']" value="hostel">
            <li>
                <div class="My_collection_main_list hidden">
                    <div class="fl My_collection_main_list2">
                        <a href="{:U('Home/Hostel/show',array('id'=>$vo['hid']))}">
                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:144px; height:90px" />
                        </a>
                    </div>
                    <div class="fl My_collection_main_list3">
                        <a href="{:U('Home/Hostel/show',array('id'=>$vo['hid']))}" class="f24 c333">{$vo.title}</a>
                        <div class="My_collection_main_list4">
                            <img src="__IMG__/Icon/img44.png" /><i class="f14 c333">客栈地址 : <em>{:getarea($vo['area'])}{$vo.address} </em></i>
                        </div>
                        <div class="My_collection_main_list5">
                            <span class="f22">￥</span><i class="f36">{$vo.money|default="0.00"}</i><label class="f18">起</label>
                        </div>
                    </div>
                </div>
            </li>
        </eq>
        <eq  name="vo['varname']" value="trip">
            <li>
                <div class="Merchant_Colletion_Activities_main2">
                    <a href="{:U('Home/Trip/show',array('id'=>$vo['tid']))}">
                        <span>{$vo.title}</span>
                        <i>时间 :<em>{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em></i>
                    </a>
                </div>
            </li>
        </eq>
    </volist>                      
</ul>
<div style="height:20px;"></div>
<div class="activity_chang4 ajaxpagebar">
    {$Page}
</div>