<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<style>
    body {
        background: #252c3f;
    }
    </style>
<div class="Buddy_share wrap">
    <div class="Buddy_share_main">
        <ul class="Buddy_share_ul">
            <div class="item_list infinite_scroll">
                <include file="Member:morelist_share" />
            </div>
            <div id="more"><a href="{:U('Wx/Member/share',array('isAjax'=>1,'p'=>2,'type'=>$type))}"></a></div>
            
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
<script>
    function closeframe(obj, uid,nickname,head,phone) {
        var text = $(obj).find(".infor_a").html();
        $(window.parent.document).find(".username").val(nickname);
        $(window.parent.document).find(".nickname").val(nickname);
        $(window.parent.document).find(".phone").val(phone);
        $(window.parent.document).find(".head").attr("src", head);
        $(window.parent.document).find("#uid").val(uid);
        window.parent.CloseIframe();
    }

</script>
