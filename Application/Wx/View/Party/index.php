<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="wrap">
    <div class="Selection_top">
        <div class="Selection_top_text">
            {$rule.content}
        </div>
    </div>
</div>
<div class="wrap">
    <div class="Selection_top2">
        <ul class="Selection_top2_ul hidden">
            <li class="fl">
                <span>参赛选手</span>
                <i>({$joinnum|default="0"}人)</i>
            </li>
            <li class="fl">
                <span>获奖选手</span>
                <i>({$rewardnum|default="0"}人)</i>
            </li>
            <li class="fl">
                <span>人气总值</span>
                <i>({$totalnum|default="0"}人)</i>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".Selection_top2_ul li").last().css({
            "border-right": "0px"
        })
    })
</script>
<div class="wrap">
    <div class="Selection_top3">
        <ul class="hidden Selection_top3_ul">
            <li <empty name="Think.get.type"> class="fl colorli"<else /> class="fl"</empty>>
                <a href="{:U('Wx/Party/index')}">全部客栈</a>
            </li>
            <li <notempty name="Think.get.type"> class="fl colorli"<else /> class="fl"</notempty>>
                <a href="{:U('Wx/Party/index',array('type'=>1))}">投票排行</a>
            </li>
        </ul>
    </div>
</div>
<div class="wrap">
    <div class="Selection_top3_show">
        <ul class="hidden Selection_top3_show_1">
            <div class="item_list infinite_scroll">
                <include file="Party:morelist_index" />
            </div>
            <div id="more"><a href="{:U('Wx/Party/index',array('isAjax'=>1,'p'=>2,'type'=>$type))}"></a></div>

        </ul>
    </div>
</div>
<eq name="user['subscribestatus']" value="0">
    <div class="details_main4">
        <div class="details_main4_01 hidden">
            <div class="details_main4_02">
                <span>点击关注我们的微信服务号</span>
            </div>
            <div class="details_main4_03">
                <a href="http://mp.weixin.qq.com/s?__biz=MzIwNzM5NTE5OA==&mid=100000003&idx=1&sn=b3b21c2c9ef869c7b589d684d65b83b8#rd">关注微信</a>
            </div>
        </div>
    </div>
</eq>
<script type="text/javascript">
    $(function(){
        $('img.pic').lazyload({
           effect: 'fadeIn'
        });
        $('.item').fadeIn();
        var sp = 1
        $(".infinite_scroll").infinitescroll({
            navSelector   : "#more",
            nextSelector  : "#more a",
            itemSelector  : ".item",
            loading:{
                msgText: ' ',
                finishedMsg: '没有更多数据',
                finished: function(){
                    sp++;
                    if(sp>=120){
                      $("#more").remove();
                      $(window).unbind('.infscr');
                    }
                    $("#infscr-loading").hide();
                  }
            },errorCallback:function(){
                
            }

        },function(newElements){
            var $newElems = $(newElements);
            $('.infinite_scroll').append($newElems);
            $newElems.fadeIn();
            return;
        });

});
</script>
<script type="text/javascript">
    $(function () {
        var isvote = false;
        $(".voteparty").click(function () {
            if (isvote) return false;
            var obj = $(this);
            var hid = obj.data("id");
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
                url: "{:U('Wx/Party/ajax_vote')}",
                data: { 'hid': hid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        $.hideLoading();
                        $.alert("投票成功", function () {
                            var votenum = obj.parent("li").find(".votenum").text();
                            obj.parent("li").find(".votenum").text(Number(votenum) + 1);
                            obj.removeClass("voteparty").html("<img src=\"/Public/Wx/img/vote/img3.png\" />已经投票");
                            isvote = true;
                        });
                    } else if(data.status==-1) {
                        $.hideLoading();
                        $.alert("该用户已经投票");
                    } else if (data.status == -2) {
                        $.hideLoading();
                        $.alert("请先关注蜗牛客公众号");
                    } else if (data.status == -3) {
                        $.hideLoading();
                        $.alert("今日投票次数已达上限");
                    } else {
                        $.hideLoading();
                        $.alert("投票失败");
                    }
                }
            });
        })
        $(".details_main3_04 a").click(function () {
            $(".details_main3_03").hide();
        })
    })
</script>
<include file="public:foot" />
