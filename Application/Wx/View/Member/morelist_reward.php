<volist name="data" id="vo">
    <li class="pr item">
        <div class="rew_left pa"><img src="__IMG__/image/icon/Draw_result_left.png"  /></div>
        <div class="rew_right pa"><img src="__IMG__/image/icon/Draw_result_right.png" /></div>
        <div class="reward_main4_01_list">
            <div style="background:#fff; padding-bottom:2%;">
                <div class="reward_main4_01_list1 hidden">
                    <if condition="$type eq 6">
                        <span>抽奖码 {$vo.code}</span>
                        <a href="{:U('Wx/News/backshow',array('nid'=>$vo['hid']))}">获取更多</a>
                        <else />
                        <eq name="vo['vaid']" value="0">
                            <span>
                                <eq name="vo['catid']" value="1">一等奖</eq>
                                <eq name="vo['catid']" value="2">二等奖</eq>
                                <eq name="vo['catid']" value="3">三等奖</eq>
                                <eq name="vo['catid']" value="4">四等奖</eq>
                                <eq name="vo['catid']" value="5">五等奖</eq>
                            </span>
                            <else />
                            <span>
                                <eq name="vo['type']" value="1">全额抵用券</eq>
                                <eq name="vo['type']" value="2">5折抵用券</eq>
                                <eq name="vo['type']" value="3">8折抵用券</eq>
                                <eq name="vo['type']" value="4">普通投票抵用券</eq>
                                <eq name="vo['type']" value="5">邀请投票抵用券</eq>
                            </span>
                        </eq>
                        
                        <!--  <eq name="vo['givenstatus']" value="2">
                            <span style="color:#666">
                                <eq name="vo['type']" value="1">一等奖</eq>
                                <eq name="vo['type']" value="2">二等奖</eq>
                                <eq name="vo['type']" value="3">三等奖</eq>
                                <eq name="vo['type']" value="4">四等奖</eq>
                                <eq name="vo['type']" value="5">五等奖</eq>
                            </span>
                            <else />
                            <span>
                                <eq name="vo['type']" value="1">一等奖</eq>
                                <eq name="vo['type']" value="2">二等奖</eq>
                                <eq name="vo['type']" value="3">三等奖</eq>
                                <eq name="vo['type']" value="4">四等奖</eq>
                                <eq name="vo['type']" value="5">五等奖</eq>
                            </span>
                        </eq> -->
                      
                        <eq name="vo['type']" value="4"><i>￥<em>{$vo.price|default="0"}</em></i></eq>
                        <eq name="vo['type']" value="5"><i>￥<em>{$vo.price|default="0"}</em></i></eq>
                        <neq name="vo['givenstatus']" value="0">
                            <a class="reward_main4_01_list1a1" style="background-color:#666" href="javascript:;">赠送</a>
                            <else />
                            <a class="reward_main4_01_list1a1" href="{:U('Wx/Member/givencoupons',array('id'=>$vo['id']))}">赠送</a>
                        </neq>
                    </if>
                </div>
                <if condition="$vo['vaid'] neq 0">
                    <a href="{$vo.link}">
                <else />
                    <a href="{:U('Wx/Vote/show',array('id'=>$vo['hid']))}">
                </if>
                <div class="reward_main4_01_list2">
                    <div class="reward_main4_01_list2_list1">
                        <span>适用于:</span>
                        <i>{$vo.house}</i>
                    </div>
                    <div class="reward_main4_01_list2_list1">
                        <span>有效期:</span>
                        <i>{$vo.in_starttime|date="Y-m-d",###}至{$vo.in_endtime|date="Y-m-d",###}</i>
                    </div>
                    <if condition="$vo['vaid'] neq 0">
                        <div class="reward_main4_01_list2_list1">
                            <span>中奖码:</span>
                            <i>{$vo.code}</i>
                        </div>
                    <else />
                        <div class="reward_main4_01_list2_list1">
                            <span>来源:</span>
                            <i>评选大转盘</i>
                        </div>
                    </if>
                </div>
                </a>
                <if condition="$type neq 6">
                    <div class="reward_main4_01_list2_list2">
                        <eq name="vo['givenstatus']" value="1">
                            <a href="javascript:;" style="color:#666" >等待入住中</a>
                        </eq>
                        <eq name="vo['givenstatus']" value="0">
                            <a href="{:U('Wx/Member/usecoupons',array('id'=>$vo['id']))}">立即使用</a>
                        </eq>
                        <eq name="vo['givenstatus']" value="2">
                            <a href="javascript:;" style="color:#666" >已完成</a>
                        </eq>
                    </div>
                </if>
            </div>
        </div>
    </li>
</volist>