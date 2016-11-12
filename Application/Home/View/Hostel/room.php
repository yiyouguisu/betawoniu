<volist name="data['room']" id="vo">
    <li>
        <div class="hidden Release_of_legend_m3t_list">
            <div class="fl Release_of_legend_m3t_list2">
                <a href="{:U('Home/Room/show',array('id'=>$vo['rid']))}">
                    <img src="{$vo.thumb}" style="width:256px;height:160px"/>
                </a>
            </div>
            <div class="fl Release_of_legend_m3t_list3">
                <div class="top">
                    <a href="{:U('Home/Room/show',array('id'=>$vo['rid']))}">{$vo.title}</a>
                </div>
                <div class="center hidden">
                    <ul class="center_ul hidden middle">
                        {:getevaluation($vo['evaluationpercent'])}
                    </ul>
                    <span class="middle"><em>{$vo.evaluation|default="10.0"}</em>分</span>
                    <div class="center_ul_list middle">
                        <img src="__IMG__/Icon/img10.png" /><i><em>{$vo.reviewnum|default="0"}</em>条评论</i>
                    </div>
                </div>
                <div class="center2">
                    <span>房间面积：<em>{$vo.area|default="0.0"}m2 </em></span>
                    <span>床型信息：<em>{$vo.bedtype}</em></span>
                    <span>最多入住：<em>{$vo.mannum|default="0"}人</em></span>
                </div>
                <div class="bottom">
                    <volist name="vo['support']" id="v">
                        <i>
                            <img src="{$v.red_thumb}" /><em>{$v.catname}</em>
                        </i>
                    </volist>
                </div>
            </div>
            <div class="fr Release_of_legend_m3t_list4" style="text-align: center;">
                <i><em>{$vo.money|default="0.0"}</em>元起</i>
                <input type="button" onclick="window.location.href='{:U('Home/Room/show',array('id'=>$vo['rid']))}'" value="立即预定" />
            </div>
        </div>
    </li>
</volist>