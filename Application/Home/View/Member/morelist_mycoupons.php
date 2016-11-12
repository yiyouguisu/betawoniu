<ul class="My_coupons_main_ul">
    <volist name="data" id="vo">
        <li>
            <a href="{:U('Home/Member/couponsshow',array('id'=>$vo['id']))}">
                <div class="fl My_coupons_main_list2">
                    <span>￥<em>{$vo.price|default="0.00"}</em></span>
                </div>
                <div class="fl My_coupons_main_list3">
                    <i>{$vo.title}</i>
                    <span class="f14 c999">有效期 :  <em class="c333">{$vo.validity_starttime|date="Y-m-d",###} - {$vo.validity_endtime|date="Y-m-d",###}</em></span>
                </div>
            </a>
        </li>
    </volist>                      
</ul>
<div style="height:20px;"></div>
<div class="activity_chang4 ajaxpagebar">
    {$Page}
</div>