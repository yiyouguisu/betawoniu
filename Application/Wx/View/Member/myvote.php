<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="wrap">
    <div class="vote">
        <ul class="hidden vote-1_ul">
            <div class="item_list infinite_scroll">
                <include file="Member:morelist_myvote" />
            </div>
            <div id="more"><a href="{:U('Wx/Member/myvote',array('isAjax'=>1,'p'=>2))}"></a></div>
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

});
</script>
<include file="public:foot" />
