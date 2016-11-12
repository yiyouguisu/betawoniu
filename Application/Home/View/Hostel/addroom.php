<li id="room_{$data.rid}">
    <div class="hidden Release_of_legend_m3t_list">
        <div class="fl Release_of_legend_m3t_list2">
            <a href="javascript:;">
                <img src="{$data.thumb}" style="width:256px;height:156px" />
            </a>
        </div>
        <div class="fl Release_of_legend_m3t_list3">
            <div class="top">
                <a href="javascript:;">{$data.title}</a>
            </div>
            <div class="center hidden">
                <ul class="center_ul hidden middle">
                    <li><img src="__IMG__/Icon/img42.png" /></li>
                    <li><img src="__IMG__/Icon/img42.png" /></li>
                    <li><img src="__IMG__/Icon/img42.png" /></li>
                    <li><img src="__IMG__/Icon/img42.png" /></li>
                    <li><img src="__IMG__/Icon/img42.png" /></li>
                </ul>
                <span class="middle"><em>10.0</em>分</span>
                <div class="center_ul_list middle">
                    <img src="__IMG__/Icon/img10.png" /><i><em>0</em>条评论</i>
                </div>
            </div>
            <div class="center2">
                <span>房间面积：<em>{$data.area|default="0.0"}m² </em></span>
                <span>床型信息：<em>{$data.bedtype}</em></span>
                <span>最多入住：<em>{$data.mannum|default="0"}人</em></span>
            </div>
            <div class="bottom">
                <volist name="support" id="vo">
                    <i><img src="{$vo.red_thumb}" /><em>{$vo.catname}</em></i>
                </volist>
            </div>
        </div>
        <div class="fr Release_of_legend_m3t_list4" style="text-align: center; width: 224px;">
            <i><em>{$data.money|default="0.0"}</em>元起</i>
            <input type="button" class="delroom" data-id="{$data.rid}" value="删除" />
            <input type="button" class="editroom" data-id="{$data.rid}" value="修改" />
        </div>
    </div>
</li>