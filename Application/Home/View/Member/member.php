<div class="my_home" style="background: url('{$user.background|default='__IMG__/img51.jpg'}') no-repeat center center;background-size: 1920px 200px;">
        <div class="wrap">
            <div class="order_main hidden">
                <div class="order_main1_1">
                    <a href="{:U('Home/Member/index')}">
                        <div class="order_main1">
                            <img src="{$user.head|default='/default_head.png'}" width="108px"  height="108px" />
                        </div>
                        <span>{$user.nickname}</span>
                    </a>
                </div>
                <i class="fr" onclick="window.location.href='{:U('Home/Member/change_background')}'">我要换背景</i>
            </div>
        </div>
    </div>
    <div class="my_home2">
        <include file="Member:menu" />
    </div>

    