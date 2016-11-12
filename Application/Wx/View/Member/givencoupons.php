<include file="public:head" />
<style>
    .iframe {
        border: 0;
        width: 100%;
        height: 100%;
        position: absolute;
        left: 100%;
        background: #fff;
        z-index: 99999;
        display: none;
    }
</style>
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<!--<div class="wrap">
    <div class="Coupon_gift hidden">
        <div class="Coupon_gift_l fl">
            赠送优惠券金额 :
        </div>
        <div class="Coupon_gift_r fr">
            <span class="add">
                +
            </span>
            <label>280</label><em class="fich_em">元</em>
            <span class="reduce">—</span>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(function () {
            $(".add").click(function () {
                var label1 = parseInt($(".Coupon_gift_r label").text());
                label1+=1 ;
                $(".Coupon_gift_r label").text(label1);
            })
            $(".reduce").click(function () {
                var label1 = parseInt($(".Coupon_gift_r label").text());
                label1 -= 1;
                $(".Coupon_gift_r label").text(label1);
            })
        })
</script>-->
<div class="wrap">
    <div class="Coupon_gift2 hidden">
        <div class="Coupon_gift2_l fl">
            被赠送好友 :
        </div>
        <div class="Coupon_gift2_r fr">
            <a href="javascript:ShowIframe('{:U('Wx/Member/share',array('type'=>1))}')" class="hidden">
                <div class="fl Coupon_gift2_r_1">
                    <img class="head" src="/default_head.png" />
                </div>
                <span class="fl username">
                    请选择好友
                </span>
                <div class="fl Coupon_gift2_r_2">
                    <img src="__IMG__/Coupon gift/img2.png"/>
                </div>
            </a>
        </div>
    </div>
</div>
<div class="wrap">
    <div class="Coupon_gift3">
        <input type="hidden" name="id" value="{$id}" />
        <input type="hidden" id="uid" name="uid" value="" />
        <a href="javascript:void(0);" class="save">立即赠送</a>
    </div>
</div>
<include file="public:foot" />
<script>
    $(function () {
        $(".save").click(function () {
            var coupons_orderid = $("input[name='id']").val();
            var uid = $("input[name='uid']").val();
            if (uid == '') {
                alert("请选择赠送好友");
                return false;
            }
            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/Member/ajax_given')}",
                data: { 'uid': uid, 'coupons_orderid': coupons_orderid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        $.hideLoading();
                        $.alert("赠送成功", function () {
                            window.location.href = "{:U('Wx/Member/reward')}";
                        })
                    } else if (data.status == -1) {
                        $.hideLoading();
                        $.alert("该优惠券已经使用");
                    } else if (data.status == -2) {
                        $.hideLoading();
                        $.alert("该优惠券过期了");
                    } else {
                        $.hideLoading();
                        $.alert("赠送失败");
                    }
                }
            });
        })
    })
</script>
<script>
    function ShowIframe(url) {
        $iframe = $(".iframe");
        if ($iframe.size() == 0) {
            $iframe = $("<iframe></iframe>");
            $iframe.addClass("iframe");
            $iframe.appendTo("body");
        }
        $iframe.attr("src", url);
        //$("html,body").css("overflow", "hidden");
        $("body").children("div,form").fadeOut();
        $.showLoading();
        $iframe.load(function () {
            $iframe.show().animate({ left: 0 });
            $.hideLoading();
        });
    }
    function CloseIframe() {
        if ($(".iframe").size() > 0) {
            $("body").children("div,form").fadeIn();
            $(".iframe").animate({ left: "100%" }, function () {
                $(".iframe").remove();
                $.hideLoading();
                $(".mask").hide()
                //$("html,body").css("overflow", "auto");
            });
            return false;
        }
    }

</script>