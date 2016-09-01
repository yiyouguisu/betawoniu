<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="wrap">
    <div class="reward2_2">
        <ul class="reward2_2_ul">
            <div class="item_list infinite_scroll">
                <include file="Party:morelist_coupons" />
            </div>
            <div id="more">
                <a href="{:U('Wx/Party/coupons',array('isAjax'=>1,'p'=>2))}"></a>
            </div>
        </ul>

        <div class="reward2_3 hidden ">
            <a href="javascript:;" id="back">返回</a>
            <a href="javascript:;" id="save">确定</a>
        </div>
        <div class="reward2_4"></div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".reward2_2_left").click(function () {
            $(this).toggleClass("reward2_2_left2");
        })
    })
</script>

<script>
    $(function () {
        var couponsids = $(window.parent.document).find("#couponsid").val();
        console.log(couponsids);
        $(".reward2_2_left").each(function () {
            var obj = $(this).parents("li");
            couponsid = obj.data("id");
            console.log(couponsid);
            if (couponsids.split(",").indexOf(couponsid+'') != -1) {
                $(this).addClass("reward2_2_left2");
            } else {
                $(this).removeClass("reward2_2_left2");
            }

        })

        $("#save").click(function () {
            var exchangemoney = $(window.parent.document).find("#exchangemoney").val();
            var coupons_num = 0;
            var coupons_total = 0.00;
            var couponsid = "";
            $(".reward2_2_left.reward2_2_left2").each(function () {
                var obj = $(this).parents("li");
                couponsid += obj.data("id") + ",";
                coupons_num++;
                if (obj.data("type") == 1) {
                    coupons_total += parseFloat(exchangemoney);
                } else if (obj.data("type") == 2) {
                    coupons_total += parseFloat(exchangemoney * 0.5);
                } else if (obj.data("type") == 3) {
                    coupons_total += parseFloat(exchangemoney * 0.8);
                } else if (obj.data("type") == 4) {
                    coupons_total += parseFloat(obj.data("price"));
                } else if (obj.data("type") == 5) {
                    coupons_total += parseFloat(obj.data("price"));
                }

            })
            if (coupons_total < exchangemoney) {
                alert("抵扣券累计金额不足以兑换,请继续选择抵扣券");
                return false;
            }
            $(window.parent.document).find("#coupons_num").text(coupons_num + "张");
            $(window.parent.document).find("#coupons_total").text(coupons_total + "元");
            $(window.parent.document).find("#couponsnum").val(coupons_num);
            $(window.parent.document).find("#couponstotal").val(coupons_total);
            $(window.parent.document).find("#couponsid").val(couponsid);
            window.parent.CloseIframe();
        })
        $("#back").click(function () {
            window.parent.CloseIframe();
        })
    })

</script>
<script type="text/javascript">
    $(function () {
        $('img.pic').lazyload({
            effect: 'fadeIn'
        });
        $('.item').fadeIn();
        var sp = 1
        $(".infinite_scroll").infinitescroll({
            navSelector: "#more",
            nextSelector: "#more a",
            itemSelector: ".item",
            loading: {
                msgText: ' ',
                finishedMsg: ' ',
                finished: function () {
                    sp++;
                    if (sp >= 120) {
                        $("#more").remove();
                        $(window).unbind('.infscr');
                    }
                    $("#infscr-loading").hide();
                }
            }, errorCallback: function () {

            }

        }, function (newElements) {
            var $newElems = $(newElements);
            $('.infinite_scroll').append($newElems);
            $newElems.fadeIn();
            return;
        });

    });
</script>
<include file="public:foot" />
