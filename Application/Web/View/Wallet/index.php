<include file="public:head" />
<div class="header center z-index112 pr f18">
    我的钱包
    <div class="head_go pa">
        <a href="javascript:history.back();">
            <img src="__IMG__/go.jpg">
        </a><span>&nbsp;</span>
    </div>
</div>
<div class="container">
    <div class="son_top f0">
        <div class="mer_c vertical">
            <div>
                <span>待提现余额 :</span>&nbsp;
                <em class="ft18">￥</em><span class="ft18" style="opacity:1">{$account.usemoney}</span>
            </div>
            <div>
                <span>即将到账金额 :</span>&nbsp;
                <em class="ft18">￥</em><span class="ft18" style="opacity:1">{$account.waitmoney}</span>
            </div>
        </div>
        <div class="mer_d vertical">
            <img src="__IMG__/money.jpg">
        </div>
    </div>
    <div class="">
        <a href="{:U('Wallet/withdraw_cash')}">
            <div class="help_list">
                <div class="help_a">
                    <img src="__IMG__/gh_a1.jpg">余额提现</div>
            </div>
        </a>
    </div>
    <div class="">
        <a href="{:U('Wallet/use_log')}">
            <div class="help_list">
                <div class="help_a">
                    <img src="__IMG__/mer_a1.jpg">钱包使用记录
                    <span class="mer_span"><img src="__IMG__/point.jpg"></span>
                </div>
            </div>
        </a>
    </div>


    <div style="height:4rem"></div>
</div>
</body>

</html>
