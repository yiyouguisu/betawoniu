<include file="public:head" />
<link href="__CSS__/AddStyle.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
    <script src="__JS__/jquery.carousel.js"></script>
    <link href="__CSS__/carousel.css" rel="stylesheet" />
    <!--<link href="__CSS__/default.css" rel="stylesheet" />-->
    <script src="__JS__/islider.js"></script>
    <script src="__JS__/islider_desktop.js"></script>
    <script>
    function aa(nid){
        window.location.href=nid;
    }
    </script>
<style>
	body{
		background:#252c3f;
	}
    .recom_a img{
        width: 100%;
    }
</style>
<div class="wrap">
        <div class="Wait_for_main1_top">
            <div class="Wait_for_main1_top2">
                <ul class="Wait_for_main1_top2_ul">
                    <li class="middle Wait_for_main1_top2_list2">
                        <a href="{:U('Wx/Member/waitreward')}"><span>等待抽奖</span><i>({$waitnum|default="0"})</i></a>
                    </li>
                    <li class="middle">
                        <a href="{:U('Wx/Member/reward')}" class="pr">
                            <span>已经抽奖</span>
                            <div class="Wait_for_main1_top2_list pa">
                                <i>奖</i>
                            </div>
                        </a>
                    </li>
                    <li class="middle">
                        <a href="{:U('Wx/Member/endreward')}"><span>已结束</span><i>({$endnum|default="0"})</i></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="wrap2">
            <div class="Wait_for_main1">
                <ul class="Wait_for_main1_ul">
                    <div class="item_list infinite_scroll">
                        <include file="Member:morelist_waitreward" />
                    </div>
                    <div id="more"><a href="{:U('Wx/Member/waitreward',array('isAjax'=>1,'p'=>2))}"></a></div>
                </ul>
            </div>
        </div>
    </div>


    <div style="margin-bottom:260px;"></div>
    <div class="" style="position:fixed; left:0px;bottom:0px; background: #252c3f;">
        <div class="Submit_successfully_main2">
            <div class="Submit_main2_top">
                <a >更多活动  <em>({$totalnum|default="0"})</em></a>
            </div>
            <div id="dom-effect" class="iSlider-effect"></div>
        </div>
    </div>
    <script>

    var domList = {$jsonStr};
    var hasCoupons = '{$hasCoupons}';
    if(hasCoupons > 0){
        $('.Wait_for_main1_top2_list').css("background","#de6064");
        $('.Wait_for_main1_top2_list').css('border-radius',"50%");
    }
        
    //滚动dom
    var islider4 = new iSlider({
        data: domList,
        dom: document.getElementById("dom-effect"),
        type: 'dom',
        animateType: 'depth',
        isAutoplay: false,
        isLooping: true,
    });

    </script>
    <script type="text/javascript">
        
        $(function () {
            // $("img").delegate(".aa","click",function(){
            //     console.log("11");
            //     alert("11")
            // })
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
                    finishedMsg: '没有更多数据',
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