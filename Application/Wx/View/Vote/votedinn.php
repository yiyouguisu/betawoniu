<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="wrap">
    <div class="vote Selection_top3">
        <ul class="hidden vote-1_ul Selection_top3_show_1">
            <div class="item_list infinite_scroll">
                <include file="Vote:morelist_index" />
            </div>
            <div id="more"><a href="{:U('Wx/Vote/votedinn',array('isAjax'=>1,'p'=>2))}"></a></div>
        </ul>
    </div>
</div>
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
        $(".voteparty").click(function() {
            if (isvote) return false;
            var obj = $(this);
            var innid = obj.data("id");
            var uid = "{$user.id}";
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
                            var votenum = obj.parent("li").find(".votenum").text();
                            obj.parent("li").find(".votenum").text(Number(votenum) + 1);
                            obj.removeClass("voteparty").html("<img src=\"/Public/Wx/img/vote/img3.png\" />已经投票");
                            isvote = true;
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
                    } else {
                        $.hideLoading();
                        $.alert("投票失败");
                    }
                }
            });
        })

});
</script>
<include file="public:foot" />
