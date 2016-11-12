<include file="public:head"/>
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />

<style>
    html{
        overflow-x: hidden;
    }
</style>
<div class="details_main wrap">
    
    <div class="details_top1 wrap2">
        <div class="details_t01 hidden">
            <!-- <p>{$data.logo}</p> -->
            <div class="details_t02">
                <!-- <img src="{$data.logo}" /> -->
                <img src="{$data.logo}" />
            </div>
            <div class="details_t03">
                <span>
                    名称：
                    <i>{$data.name}</i>
                </span>
                <span>
                    地址：
                    <i>{$data.address}</i>
                </span>
            </div>
            <!-- <div class="details_t04">
                <a href="javascript:;">
                    <span>兑奖金额</span>
                    {$data.exchangemoney|default="0.00"}
                    <em style="font-size:1.1rem;">
                        元/晚
                    </em>
                </a>
            </div> -->
        </div>
        <!-- <div class="details_main1">
            <span>
                房间剩余数量 : {$data.wait_num|default="0"}间
            </span>
        </div> -->
        <div class="Exchange_Inn_main1 hidden">
            <div class="fl Exchange_Inn_main1_01_add">
                <div class="Exchange_Inn_main1_01">
                    <span>入住时间段：</span>
                    <label>{$data.starttime|date="Y-m-d",###}至{$data.endtime|date="Y-m-d",###}</label>
                </div>
                <div class="Exchange_Inn_main1_01">
                    <span>试睡房间数：</span>
                    <label>{$data.roomnum|default="0"}人</label>
                </div>
                <div class="Exchange_Inn_main1_01">
                    <span>可使用抵用：</span>
                    <label>
                            {$usedcoupons}

                    </label>
                </div>
            </div>
            <div class="fr Exchange_Inn_main1_01_add2">
                <div class="middle_div">
                    <p>投票数量</p>
                    <span id="votenum">{$data.votenum|default="0"}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="details_main3 wrap">
    <div class="details_main3_02">
        {$data.content}
    </div>
</div> -->
<div class="hidden"></div>
<div class="details_main3 wrap">
    <div class="details_main3_02">
        <!-- <?php
            // $array = explode(',', $data['imglist']);
            foreach ($data.imglist as $key => $value) {
                echo '<img src="'.$value[thumb].'" />';
            }         
        ?> -->
        <notempty name="imglist">
            <volist name="imglist" id="vo">
                
                <img src='{$vo.thumb}' />
            </volist>
        </notempty>
        <p>{$data.description}</p>
    </div>
</div>


<!-- <div class="details_main3_03 hide">
    <div class="details_main3_04">
        <img src="__IMG__/details/img4.png" />
        <p>您的优惠券兑换申请成功，请保证电话通畅</p>
        <p>我们会尽快与您联系</p>
        <a href="javascript:void(0);">
            确认
        </a>
    </div>
</div> -->
<div class="wrap">
    <div class="details_main5"></div>
</div>
<div class="wrap">
    <div class="details_main3_01">
            <eq name="data['hasvote']" value="2">
                <span class="details_main3_01_span canvote">
                <img src="__IMG__/Selection/hand.png" />为他投票(
                <span id="hitnum">{$data.votenum|default="0"}</span>)
                </span>
            <else />
                <span class="details_main3_01_span " style="background:#929292
;">
                <img src="__IMG__/vote/img3.png" />已经投票(
                <span id="hitnum">{$data.votenum|default="0"}</span>)
                </span>
            </eq>
            <!-- <img src="__IMG__/details/img1.png" />为他投票(
            <span id="hitnum">{$data.votenum|default="0"}</span>) -->
        <eq name="data['isvote']" value="1">
            <a href="{:U('Wx/Vote/turntable',array('innid'=>$data['id']))}" class="details_click">立即抽奖</a>
        <else />
            <a href="javascript:return false;" style="background:#929292;" class="details_click">立即抽奖</a>
        </eq>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".canvote").click(function () {
            var innid ="{$data.id}";
            var uid = "{$user.id}";
            var obj = $(this);
            if (uid == '') {
                $.alert("请先清除微信缓存；方法：手机后台关闭微信应用，再重新打开微信。");
                return false;
            }

            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/Vote/ajax_vote')}",
                data: {
                    'innid': innid
                },
                dataType: "json",
                success: function(data) {
                    if (data.status == 1) {
                        $.hideLoading();
                        $.alert("投票成功", function() {
                            var strhtml = " <img src='__IMG__/vote/img3.png' />已经投票( "
                                          + " <span id='hitnum'>"+data.msg+"</span>)";
                            obj.css("background","#929292");
                            obj.removeClass('canvote');
                            obj.html(strhtml);
                            // $('.details_main3_01').html(strhtml);
                            $('#votenum').html(data.msg);
                        });
                    } else if (data.status == -1) {
                        $.hideLoading();
                        $.alert("该用户已经投票");
                    } else if (data.status == -2) {
                        $.hideLoading();
                        $.alert("请先关注蜗牛客公众号");
                    } else if (data.status == -3) {
                        $.hideLoading();
                        $.alert("今日投票次数已达上限");
                    } else if(data.status == -5){
                        $.hideLoading();
                        $.alert("该客栈已下架或者删除！");
                    } else {
                        $.hideLoading();
                        $.alert("投票失败");
                    }
                }
            });
        });
    });
</script>
<include file="public:foot"/>
