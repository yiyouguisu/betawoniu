<volist name="data" id="vo">
    <li class="item">
                    <div class="Volunteer1">
                        <div class="Volunteer1_top hidden">
                            <div class="fl Volunteer1_top_01">
                                <img src="{$vo.housethumb}" />
                            </div>
                            <div class="fl Volunteer1_top_02">
                                <i>{$vo.housename}</i>
                                <p>
                                    地址:<span class="c666">{:getarea($vo['area'])}{$vo.address}</span>
                                </p>
                            </div>
                        </div>
                        <div class="Volunteer1_top1">
                            <p>招聘岗位 :</p>
                            <a href="javascript:;">{$vo.title}</a>
                        </div>
                        <div class="Volunteer1_top2">
                            <span>职位要求:</span>
                            {$vo.content}
                        </div>
                        <div class="Volunteer1_top3">
                            <span>联系方式：</span>
                            {$vo.contact}
                        </div>
                    </div>
                </li>
</volist>