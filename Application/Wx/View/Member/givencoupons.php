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
    body{
        background:#252c3f;
    }
</style>

<link href="__CSS__/base.css" rel="stylesheet" />
<link href="__CSS__/AddStyle.css" rel="stylesheet" />
    <div class="wrap">
        <div class="Gift_friends">
            <div class="Gift_friends_top">
                <img src="__IMG__/image/icon/Gift_friends.png"     width="100%;"/>
            </div>
            <div class="Gift_friends_top2">
                <a href="javascript:ShowIframe('{:U('Wx/Member/share',array('type'=>1))}')" class="hidden">
                    <span class="fl middle username">请选择点亮过的好友</span>
                    <img src="__IMG__/image/icon/img6.png" />
                </a>
            </div>
            <div class="Gift_friends_bottom">
                <p>如果好友没有被点亮，那被赠送的好友必须参与活动才能查看所得抵用券。</p>
                <input class="text3 nickname" type="text" name="nickname" placeholder="好友姓名"/>
                <input class="text3 phone" type="text" name="phone" placeholder="好友联系方式" />
                <input type="hidden" name="id" value="{$id}" />
                <input type="hidden" id="uid" name="uid" value="" />
                <input class="sub2 save" type="button" value="确定赠送" />
            </div>
           
        </div>
    </div>
<include file="public:foot" />
<script>
    $(function () {
        $(".save").click(function () {
            var coupons_orderid = $("input[name='id']").val();
            var uid = $("input[name='uid']").val();
            var nickname = $("input[name='nickname']").val();
            var phone = $("input[name='phone']").val();
            if (nickname=='' || phone=='') {
                alert("请选择赠送好友");
                return false;
            }
            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/Member/ajax_given')}",
                data: { 'uid': uid,'nickname':nickname,'phone':phone, 'coupons_orderid': coupons_orderid },
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
                    } else if(data.status == -3){
                        $.hideLoading();
                        $.alert("友情提示:您赠送的好友还不是蜗牛客的小伙伴，请先邀请其参与任意抽奖活动！");
                    } else if(data.status == -4){
                        $.hideLoading();
                        $.alert("用户名不能为空！");
                    } else if(data.status == -5){
                        $.hideLoading();
                        $.alert("手机不能为空！");
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