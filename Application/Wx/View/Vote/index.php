<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<style type="text/css">
.hk_a { overflow:hidden;}
.hk_a a { height:5rem;line-height:5rem;display:block;text-align:center; font-size:1.6rem;color:#999999;
          width:50%;float:left;border-bottom:1px solid #cccccc;}
.hk_a a.hk_cut {border-bottom:1px solid #56c3cf;color:#56c3cf }	
</style>
<div class="wrap">
    <div class="hk_a">
             <a href="{:U('Wx/Vote/turntable')}">大转盘抽奖</a>
             <a href="{:U('Wx/Vote/index')}" class="hk_cut">抽奖结果</a>
        </div>
    <div class="activity_main">
        <ul class="activity_ul">
            <li class="item">
                <a href="{:U('Wx/Vote/turntablelog')}">
                    <div class="hidden activity1">
                        <span class="fl">大转盘抽奖结果</span>
                        <i class="fr"></i>
                    </div>
                    <div class="activity2">
                        <p>点击查看大转盘抽奖结果！</p>
                    </div>
                </a>
            </li>
            <div class="item_list infinite_scroll">
                <include file="Vote:morelist_index" />
            </div>
            <div id="more"><a href="{:U('Wx/Vote/index',array('isAjax'=>1,'p'=>2))}"></a></div>

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
