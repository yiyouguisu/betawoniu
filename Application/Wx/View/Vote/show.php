<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="draw_main wrap">
    <ul class=" wrap2 draw_main1">
        <volist name="data" id="vo">
            <li class="">
                <div class="top">
                    <span>
                        幸运00{$key+1}
                    </span>
                </div>
                <div class="top2">
                    <div class="top2_01 hidden">
                        <div class="fl top2_01_1">
                            <img src="{$vo.head}" />
                        </div>
                        <div class="fl top2_01_2">
                            <p class="c333">{$vo.nickname}</p>
                            <span class="bmn">{$vo.inputtime|date="Y-m-d",###}</span>
                        </div>
                    </div>
                </div>
                <div class="top_3">
                    <div class="top3 hidden">
                        <div class="top3_01 fl">
                            <img src="__IMG__/index/img1.jpg" />
                        </div>
                        <div class="top3_02 fl hidden">
                            <p>{$vo.house.title}</p>
                            <span>
                                地址:<i>{:getarea($vo['house']['area'])}{$vo.house.address}</i>
                            </span>

                        </div>
                        <div class="top3_03 fr">
                            <a href="javascript:;">
                                <?php

                            if(in_array(1, explode(',',$vo["catid"]))) $couponsrule="全额抵扣";
                            elseif(in_array(2, explode(',',$vo["catid"]))) $couponsrule="5折抵扣";
                            elseif(in_array(3, explode(',',$vo["catid"]))) $couponsrule="8折抵扣";
                                            echo $couponsrule;
                            ?>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="top4">
                    <p>入住时间 :<span class="c333">{$vo.house.workstarttime|date="Y-m-d",###}至{$vo.house.workendtime|date="Y-m-d",###}</span></p>
                    <p>入住人数 :<span class="c333">{$vo.house.mannum|default="0"}人</span></p>
                </div>
            </li>
        </volist>
    </ul>
</div>
<include file="public:foot" />
