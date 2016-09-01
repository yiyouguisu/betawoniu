<ul class="my_comments_main2_body_ul">
    <volist name="review" id="vo">
        <eq  name="vo['varname']" value="note">
            <li>
                <div class="my_comments_main2_body_list hidden">
                    <a href="{:U('Home/Note/show',array('id'=>$vo['value']))}">{:str_cut($vo['title'],20)}</a><i class="my_comments_i1">游记</i>
                    <!-- <input type="button" data-id="{$vo.id}" value="删除" /> -->
                    <p>{$vo.content}</p>
                    <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                </div>
            </li>
        </eq>
        <eq  name="vo['varname']" value="party">
            <li>
                <div class="my_comments_main2_body_list hidden">
                    <a href="{:U('Home/Party/show',array('id'=>$vo['value']))}">{:str_cut($vo['title'],20)}</a><i class="my_comments_i3">活动</i>
                    <!-- <input type="button" data-id="{$vo.id}" value="删除" /> -->
                    <p>{$vo.content}</p>
                    <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                </div>
            </li>
        </eq>
        <eq  name="vo['varname']" value="hostel">
            <li>
                <div class="my_comments_main2_body_list hidden">
                    <a href="{:U('Home/Hostel/show',array('id'=>$vo['value']))}">{:str_cut($vo['title'],20)}</a><i class="my_comments_i2">美宿</i>
                    <!-- <input type="button" data-id="{$vo.id}" value="删除" /> -->
                    <p>{$vo.content}</p>
                    <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                </div>
            </li>
        </eq>
        <eq  name="vo['varname']" value="trip">
            <li>
                <div class="my_comments_main2_body_list hidden">
                    <a href="{:U('Home/Trip/show',array('id'=>$vo['value']))}">{:str_cut($vo['title'],20)}</a><i class="my_comments_i4">行程</i>
                    <!-- <input type="button" data-id="{$vo.id}" value="删除" /> -->
                    <p>{$vo.content}</p>
                    <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                </div>
            </li>
        </eq>
    </volist>                      
</ul>
<div style="height:20px;"></div>
<div class="activity_chang4 ajaxpagebar">
    {$Page}
</div>