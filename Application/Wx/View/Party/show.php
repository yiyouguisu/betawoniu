<include file="public:head"/>
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />


<div class="details_main wrap">
    
    <div class="details_top1 wrap2">
        <div class="details_t01 hidden">
            <p>{$data.theme}</p>
            <div class="details_t02">
                <img src="{$data.thumb}" />
            </div>
            <div class="details_t03">
                <span>
                    名称：
                    <i>{$data.title}</i>
                </span>
                <span>
                    地址：
                    <i>{:getarea($data['area'])}{$data.address}</i>
                </span>
            </div>
            <div class="details_t04">
                <a href="javascript:;">
                    <span>兑奖金额</span>
                    {$data.exchangemoney|default="0.00"}
                    <em style="font-size:1.1rem;">
                        元/晚
                    </em>
                </a>
            </div>
        </div>
        <div class="details_main1">
            <span>
                房间剩余数量 : {$data.wait_num|default="0"}间
            </span>
        </div>
        <div class="Exchange_Inn_main1 hidden">
            <div class="fl Exchange_Inn_main1_01_add">
                <div class="Exchange_Inn_main1_01">
                    <span>入住时间段：</span>
                    <label>{$data.workstarttime|date="Y-m-d",###}至{$data.workendtime|date="Y-m-d",###}</label>
                </div>
                <div class="Exchange_Inn_main1_01">
                    <span>入住人数：</span>
                    <label>{$data.mannum|default="0"}人</label>
                </div>
                <div class="Exchange_Inn_main1_01">
                    <span>可使用抵用：</span>
                    <label>
                            <?php

                            if(in_array(1, explode(',',$data["couponsrule"]))) $couponsrule="全额";
                            if(in_array(2, explode(',',$data["couponsrule"]))) $couponsrule.="/5折";
                            if(in_array(3, explode(',',$data["couponsrule"]))) $couponsrule.="/8折";
                            if(in_array(4, explode(',',$data["couponsrule"]))) $couponsrule.="/普通";
                            elseif(in_array(5, explode(',',$data["couponsrule"]))) $couponsrule.="/普通";
                                            echo $couponsrule;
                            ?>

                    </label>
                </div>
            </div>
            <div class="fr Exchange_Inn_main1_01_add2">
                <p>投票数量</p>
                <span>{$data.votenum|default="0"}</span>
            </div>
        </div>
    </div>
</div>

<div class="details_main3 wrap">
    <div class="details_main3_02">
        <p>{$data.content}</p>
        <img src="{$site.vote_image}" />
        <p>{$site.vote_description}</p>
    </div>
</div>

<div class="details_main3_03 hide">
    <div class="details_main3_04">
        <img src="__IMG__/details/img4.png" />
        <p>您的优惠券兑换申请成功，请保证电话通畅</p>
        <p>我们会尽快与您联系</p>
        <a href="javascript:void(0);">
            确认
        </a>
    </div>
</div>
<div class="wrap">
    <div class="details_main5"></div>
</div>
<div class="wrap">
    <div class="details_main3_01">
        <span class="details_main3_01_span">
            <img src="__IMG__/details/img1.png" />为他点赞(
            <span id="hitnum">{$data.hit|default="0"}</span>)
        </span>
        <a href="{:U('Wx/Party/exchange',array('id'=>$data['id']))}" class="details_click">立即兑换</a>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".details_main3_01_span").click(function () {
            var hid = '{$data.id}';
            var uid = "{$user.id}";
            if (uid == '') {
                $.alert("请先成为会员", function () {
                    window.location.href = "{:U('Wx/Public/wxlogin')}";
                })
                return false;
            }

            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/Party/ajax_hit')}",
                data: { 'hid': hid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        $.hideLoading();
                        var hitnum = $("#hitnum").text();
                        $("#hitnum").text(Number(hitnum)+1);
                    } else if(data.status==-1) {
                        $.hideLoading();
                        $.alert("该用户已经点赞过");
                    } else if (data.status == -2) {
                        $.hideLoading();
                        $.alert("请先关注蜗牛客公众号");
                    } else {
                        $.hideLoading();
                        $.alert("点赞失败");
                    }
                }
            });
        })
    })
</script>
<include file="public:foot"/>
