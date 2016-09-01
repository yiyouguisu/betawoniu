<div class="Event_details5_5">
    <span>评论</span><i>({$reviewnum|default="0"})</i>
</div>
<div class="Event_details5_6">
    <ul class="Event_details5_6_ul">
        <volist name="reviewdata" id="vo">
            <li>
                <div class="hidden Event_details5_6_list">
                    <div class="fl Event_details5_6_list2">
                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                            <div>
                                <img src="{$vo.head}" style="width:77px;height:77px;border-radius: 50%;" />
                            </div>
                            <span class="f14 c000 tc nickname" >{$vo.nickname}</span>
                        </a>
                    </div>
                    <div class="fr Event_details5_6_list3">
                        <p class="f16 c000">{$vo.content}</p>
                        <div class="Event_details5_6_list3_01">
                            <i class="f12 c999">发表于<em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></i>
                        </div>
                        <a href="javascript:;" class="f12 Event_details5_6_list3_02 reply" data-id="{$vo.rid}" data-rname="{$vo.nickname}">回复</a>
                        <!-- <a href="javascript:;" class="f12 Event_details5_6_list3_02 quote" data-id="{$vo.rid}" data-rname="{$vo.nickname}">引用</a> -->
                        <a href="javascript:;" class="f12 Event_details5_6_list3_03 report" data-id="{$vo.rid}">举报</a>
                    </div>
                </div>
            </li>
        </volist>
    </ul>
</div>
<div class="activity_chang4 ajaxpagebar">
    {$Page}
</div>
<div style="margin-bottom:40px;">

</div>