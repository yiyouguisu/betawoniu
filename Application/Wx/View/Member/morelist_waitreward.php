<volist name="data" id="vo">
    <li class="aitem">
        <div class="Wait_for_main1_list">
            <div class="Wait_for_main1_list2">
                <a href="{$vo.link}">{$vo.title}</a>
            </div>
            <div class="Wait_for_main1_list3">
                <div class="middle Wait_for_main1_list3_1">
                    <img src="__IMG__/image/icon/time.png" /><span>开奖时间：<em>{$vo.endtime|date="Y-m-d",###}</em></span>
                </div>
                <div class="middle Wait_for_main1_list3_2">
                    <a href="{:U('Wx/Member/setphone',array('id'=>$vo['id'],'houseid'=>$vo['houseid'],'from'=>'waitreward'))}">
                        <i>邀好友拿抽奖码</i>
                        <img src="__IMG__/image/icon/img5.png" />
                    </a>
                </div>
            </div>
            <div class="Wait_for_main1_list4 hidden">
                <div class="fl Wait_for_main1_list5">
                    <span>抽奖码 :</span>
                </div>
                <div class="fl Wait_for_main1_list6 hidden">
                    <span class="c999 f11">
                        <volist name="vo['pool']" id="v">
                            <neq name="key" value="0">、</neq>{$v}
                        </volist>
                    </span>
                    <a href="{:U('Wx/Member/pool',array('vaid'=>$vo['id']))}" class="c333 f12 fr">更多</a>
                </div>
            </div>
        </div>
    </li>
</volist>