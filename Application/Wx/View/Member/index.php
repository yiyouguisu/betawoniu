<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="Personal_Center_main wrap">
    <div class="Personal_Center_main1">
        <img src="{$user.head|default='/default_head.png'}" />
    </div>
    <span>{$user.nickname|default="未关注"}</span>
</div>
<div class="Personal_Center_main2 wrap">
    <div class="Personal_Center_main3">
        <ul class="hidden Personal_Center_main3_ul">
            <li class="fl">
                <a href="{:U('Wx/Member/myvote')}">
                    <img src="__IMG__/Personal Center/img1.png" />
                    <span>我点亮过的客栈</span>
                    <i>({$votenum|default="0"}家)</i>
                </a>
            </li>
            <li class="fl">
                <a href="{:U('Wx/Member/share')}">
                    <img src="__IMG__/Personal Center/img2.png" />
                    <span>我点亮过的小伙伴</span>
                    <i>({$sharenum|default="0"}人)</i>
                </a>
            </li>
            <li class="fl">
                <a href="{:U('Wx/Member/reward')}">
                    <img src="__IMG__/Personal Center/img3.png" />
                    <span>我的奖励</span>
                    <!--<i>(￥{$rewardmoney|default="0.00"}元)</i>-->
                    <i></i>
                </a>
            </li>
            <li class="fl">
                <a href="{:U('Wx/Member/couponslog')}">
                    <img src="__IMG__/Personal Center/img4.png" />
                    <span>优惠券使用记录</span>
                    <i></i>
                </a>
            </li>
        </ul>
    </div>

</div>

<div class="Personal_Center_main4 wrap">
    <div class="Personal_Center_main4_01 pr">
        <img src="__IMG__/Personal Center/img2.jpg" />
        <span>
            <img src="__IMG__/Personal Center/img5.png" />
            我的分享码
            <img src="__IMG__/Personal Center/img5.png" />
        </span>
        <p>{$user.tuijiancode}</p>
        <img src="__IMG__/Personal Center/img3.jpg" />
    </div>
</div>
<include file="public:foot" />