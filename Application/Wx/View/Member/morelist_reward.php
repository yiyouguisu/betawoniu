<volist name="data" id="vo">
    <li class="pr item">
        <div class="rew_left pa"><img src="__IMG__/reward/img2.png"  /></div>
        <div class="rew_right pa"><img src="__IMG__/reward/img1.png" /></div>
        <div class="reward_main4_01_list">
            <div class="reward_main4_01_list1 hidden">
                <if condition="$type eq 6">
                    <span>抽奖码 {$vo.code}</span>
                    <a href="{:U('Wx/News/backshow',array('nid'=>$vo['hid']))}">获取更多</a>
                    <else />
                    <span>
                        <eq name="vo['type']" value="1">全额抵用券</eq>
                        <eq name="vo['type']" value="2">5折抵用券</eq>
                        <eq name="vo['type']" value="3">8折抵用券</eq>
                        <eq name="vo['type']" value="4">普通投票抵用券</eq>
                        <eq name="vo['type']" value="5">邀请投票抵用券</eq>
                    </span>
                    <eq name="vo['type']" value="4"><i>￥<em>{$vo.price|default="0"}</em></i></eq>
                    <eq name="vo['type']" value="5"><i>￥<em>{$vo.price|default="0"}</em></i></eq>
                    <a href="{:U('Wx/Member/givencoupons',array('id'=>$vo['id']))}">赠送</a>
                </if>
            </div>
            <div class="reward_main4_01_list2">
                <div class="reward_main4_01_list2_list1">
                    <span>适用于:</span>
                    <i>{$vo.house}</i>
                </div>
                <div class="reward_main4_01_list2_list1">
                    <span>有效期:</span>
                    <i>{$vo.validity_starttime|date="Y-m-d",###}至{$vo.validity_endtime|date="Y-m-d",###}</i>
                </div>
            </div>
        </div>
    </li>
</volist>