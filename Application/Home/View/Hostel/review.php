<ul class="Inn_introduction_main10_botttom_ul">
    <volist name="reviewdata" id="vo">
        <li>
            <div class="hidden Inn_introduction_main10_botttom_list">
                <div class="fl Inn_introduction_main10_botttom_list2">
                    <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                        <div><img src="{$vo.head}" width="76px" height="76px" style="border-radius: 50%;" /></div>
                        <span>{$vo.nickname}</span>
                    </a>
                </div>
                <div class="fl Inn_introduction_main10_botttom_list3">
                    <div>
                        <div class="Inn_Star_praise hidden">
                            <ul class="Inn_Star_praise_ul hidden middle">
                                {:getevaluation($vo['evaluationpercent'])}
                            </ul>
                            <span class="middle"><em>{$vo.evaluation|default="0.0"}</em>分</span>
                        </div>
                    </div>
                    <div class="Inn_introduction_main10_botttom_list3_1">
                        <p>{$vo.content}</p>
                        <span>发表于<em> {$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                    </div>
                </div>
            </div>
        </li>      
    </volist>       
</ul>
<div class="hidden Inn_introduction_main10_botttom2">
    <div class="fl">
        <div class="activity_chang4 ajaxpagebar">
            {$Page}
        </div>
    </div>
    <div class="fr Inn_introduction_main10_botttom3">
        <span>共<em>{$totalpages|default="0"}</em>页<em>{$totalrows|default="0"}</em>条</span>
    </div>
</div>           


