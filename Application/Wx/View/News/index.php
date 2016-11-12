<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="wrap">
    <div class="WeChat_list_main">
        <ul class="hidden">
            <div class="item_list infinite_scroll">
                <include file="News:morelist_index" />
            </div>
            <div id="more"><a href="{:U('Wx/News/index',array('isAjax'=>1,'p'=>2))}"></a></div>
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
                <a href="http://mp.weixin.qq.com/s?__biz=MzIzNTI4ODEyNg==&mid=100001017&idx=1&sn=bc71b7305eb6010602cd696ff71b5216">关注微信</a>
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
<include file="public:foot" />
