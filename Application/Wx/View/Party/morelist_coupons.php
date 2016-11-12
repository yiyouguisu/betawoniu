<volist name="data" id="vo">
    <li data-type="{$vo.type}" data-id="{$vo.id}" data-price="{$vo.price}">
        <div <in name="vo['id']" value="$couponsid"> class="reward2_2_left reward2_2_left2"<else /> class="reward2_2_left "</in>>
            <span></span>
        </div>
        <div class="reward2_2_right">
            <div class="reward2_2_right1">
                <lt name="vo['type']" value="4">
                    <img src="{$vo.thumb}" />
                    <else />
                    <div class="reward2_2_right2">
                        <p>
                            ￥<span>{$vo.price}</span>
                        </p>

                        <eq name="vo['type']" value="4"><i>投票</i></eq>
                        <eq name="vo['type']" value="5"><i>邀请投票</i></eq>
                    </div>
                </lt>
            </div>
            <div class="reward2_2_01">
                <div class="reward2_2_02">
                    <p>
                        <eq name="vo['type']" value="1">全额抵用券</eq>
                        <eq name="vo['type']" value="2">5折抵用券</eq>
                        <eq name="vo['type']" value="3">8折抵用券</eq>
                        <eq name="vo['type']" value="4">普通投票抵用券</eq>
                        <eq name="vo['type']" value="5">邀请投票抵用券</eq>
                        <egt name="vo['type']" value="4">
                            <span>(￥<em>{$vo.price}</em>)</span>
                        </egt>
                    </p>
                    <span>
                        适用于：<strong>{$vo.house}</strong>
                    </span>
                    <span>
                        有效期：<strong>{$vo.validity_starttime|date="Y-m-d",###}至{$vo.validity_endtime|date="Y-m-d",###}</strong>
                    </span>
                </div>
            </div>
        </div>
    </li>
</volist>