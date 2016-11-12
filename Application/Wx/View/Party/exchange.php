<include file="public:head" />
<script src="__JS__/ajaxForm.js"></script>
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
<div class="details_main wrap">
    <div class="details_top1 wrap2">
        <div class="details_t01 hidden">
            <p>{$data.theme}</p>
            <div class="details_t02">
                <img src="{$data.thumb}" />
            </div>
            <div class="details_t03">
                <span>名称：
                    <i>{$data.title}</i>
                </span>
                <span>地址：
                    <i>{:getarea($data['area'])}{$data.address}</i>
                </span>
            </div>
            <div class="details_t04">
                <a href="javascript:;">
                    <span>兑奖金额</span>
                    {$data.exchangemoney|default="0.00"}
                    <em style="font-size: 1.1rem;">元/晚
                    </em>
                </a>
            </div>
        </div>
        <div class="details_main1">
            <span>房间剩余数量 : {$data.wait_num|default="0"}间
            </span>
        </div>
        <div class="Exchange_Inn_main1">
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
    </div>
</div>
<div class="Exchange_Inn_main2 wrap">
    <div class="Exchange_Inn_main2_01">
        <div class="Exchange_Inn_main2_02">
            <input type="hidden" id="exchangemoney" value="{$data.exchangemoney|default='0.00'}" />
            <a href="javascript:ShowIframe('{:U('Wx/Party/coupons')}')" class="hidden">
                <span class="fl">选择优惠券
                </span>
                <i class="fr">
                    <img src="__IMG__/details/img2.png" />
                </i>
            </a>
        </div>
        <div class="Exchange_Inn_main2_03">
            <div class="Exchange_Inn_main2_04">
                <span>已选优惠券 :</span>
                <label id="coupons_num">{$couponsnum|default="0"}张</label>
            </div>
            <div class="Exchange_Inn_main2_04">
                <span>总金额 :</span>
                <label id="coupons_total">{$couponstotal|default="0.00"}元</label>
            </div>
        </div>
    </div>
</div>
<form class="J_ajaxForm" id="form" action="{:U('Wx/Party/doexchange')}" method="post">
    <div class="wrap">
        <div class="Exchange_Inn_main4">
            <div class="Exchange_Inn_main4_top">
                <span>入住信息</span>
            </div>
            <div class="Exchange_Inn_main4_bottom">
                <div class="Exchange_Inn_main4_bottom1">
                    <span>期望入住时间：</span><input type="date" names="expectdate" class="EI_text" required />
                </div>
                <div class="Exchange_Inn_main4_bottom1">
                    <span>期望入住人数：</span><input type="text" name="expectnum" class="EI_text" required />
                </div>
            </div>
        </div>
    </div>

    <div class="Exchange_Inn_1 wrap">
        <div class="Exchange_Inn_2">
            <div class="Exchange_Inn_1_01">
                <span>入住信息</span>
            </div>
            <div class="man">
                <div class="Exchange_Inn_1_02">
                    <p>
                        <span>真实姓名 :</span>
                        <input type="text" name="realname[0]" value="" required="required" />
                    </p>
                    <p>
                        <span>身份证号 :</span>
                        <input type="text" name="idcard[0]" value="" required="required" />
                        <i class="del">删除</i>
                    </p>
                    <p>
                        <span>联系电话 :</span>
                        <input type="tel" name="tel[0]" value="" required="required" />
                    </p>
                </div>
            </div>
            <input type="hidden" name="num" id="mannum" value="{$num|default='0'}" />
            <a href="javascript:;" id="addman">+添加新入住人信息</a>
        </div>
    </div>
    <div class="Exchange_Inn_3 wrap">
        <div class="Exchange_Inn_3_1 wrap2">
            <span></span>
            <i>同意
                <a href="{:U('Wx/Party/useservice')}" style="color: #999; font-size: 1.4rem;">蜗牛客平台使用协议</a>
            </i>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Exchange_Inn_3_1").click(function () {
                if ($(this).find("span").hasClass("span_cut")) {
                    $("input[name='isagree']").val('0');
                } else {
                    $("input[name='isagree']").val('1');
                }
                $(this).find("span").toggleClass("span_cut");
            })
            $(".del").live("click", function () {
                var num = $("#mannum").val();
                if (num <= 1) {
                    alert("请至少提交一个入住人信息");
                    return false;
                }
                if (confirm("确认删除吗？")) {
                    $(this).parents(".Exchange_Inn_1_02").remove();
                    $("#mannum").val(Number($("#mannum").val()) - 1);
                }
            })
        })
    </script>
    <div class="wrap">
        <div class="Exchange_Inn_4">
            <i class="Exchange_Inn_4_i" id="save">立即兑换</i>
            <div class="details_main3_03 hide">
                <div class="details_main3_04">
                    <img src="__IMG__/details/img4.png" />
                    <span>兑换成功</span>
                    <p>您的优惠券兑换申请成功，请保证电话通畅</p>
                    <p>我们会尽快与您联系</p>
                    <input type="hidden" id="couponsid" name="couponsid" value="{$couponsid}" />
                    <input type="hidden" id="isagree" name="isagree" value="0" />
                    <input type="hidden" id="hid" name="hid" value="{$_GET['id']}" />
                    <input type="hidden" id="exchangemoney" name="exchangemoney" value="{$data.exchangemoney}" />
                    <input type="hidden" id="couponsnum" name="couponsnum" value="{$couponsnum|default='0'}" />
                    <input type="hidden" id="couponstotal" name="couponstotal" value="{$couponstotal|default='0.00'}" />
                    <a href="javascript:void(0);">确认
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    var xss = 1;
    $(function () {
        $(".details_main3_03").css({
            "height": $(window).height(),
        })
        //$(".Exchange_Inn_4_i").click(function () {
        //    $(".details_main3_03").show();
        //})
        $(".details_main3_04 a").click(function () {
            $(".details_main3_03").hide();
            window.location.href = "{:U('Wx/Party/index')}";
        })
        $("#addman").click(function () {
            var str = "<div class=\"Exchange_Inn_1_02\">";
            str += " <p><span>真实姓名 :</span><input type=\"text\" name=\"realname[" + xss + "]\" required/></p>";
            str += "<p><span>身份证号 :</span><input type=\"text\"  name=\"idcard[" + xss + "]\" required/><i class=\"del\">删除</i></p>";
            str += "<p><span>联系电话 :</span><input type=\"tel\" name=\"tel[" + xss + "]\" required/></p>";
            str += "</div>";
            var mannum = '{$data.mannum}';
            if (Number($("#mannum").val()) + 1 > Number(mannum)) {
                alert("入住人数超过民宿入住人数上限");
                return false;
            } else {
                $(".man").append(str);
                $("#mannum").val(Number($("#mannum").val()) + 1);
            }
            xss++;
        })
        $('#save').click(function (e) {
            e.preventDefault();
            var uid = "{$user.id}";
            if (uid == '') {
                $.alert("请先成为会员", function () {
                    window.location.href = "{:U('Wx/Public/wxlogin')}";
                })
                return false;
            }
            var couponsid = $("input[name='couponsid']").val();
            if (couponsid == '') {
                alert("请选择兑换优惠券");
                return false;
            }
            var isagree = $("input[name='isagree']").val();
            if (isagree == '' || isagree == 0) {
                alert("请同意蜗牛客平台使用协议");
                return false;
            }
            var mannum = $("input[name='num']").val();
            var expectnum = $("input[name='expectnum']").val();
            if (mannum != expectnum - 1) {
                alert("请正确填写入住人信息");
                return false;
            }

            var btn = $(this),
                form = btn.parents('form.J_ajaxForm');
            form.ajaxSubmit({
                url: btn.data('action') ? btn.data('action') : form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
                dataType: 'json',
                beforeSubmit: function (arr, $form, options) {
                    btn.prop('disabled', true).addClass('disabled');
                    $.showLoading("正在提交中");
                },
                success: function (data, statusText, xhr, $form) {
                    $.hideLoading();
                    if (data.status == 1) {
                        $(".details_main3_03").show();
                    } else {
                        $.alert(data.info, function () {
                            btn.removeProp('disabled').removeClass('disabled');
                        });
                        
                    }
                }
            });
        });
    })

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
<include file="public:foot" />
