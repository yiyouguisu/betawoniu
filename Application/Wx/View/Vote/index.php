<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<style>
    body {
        background: #21283b;
    }
    </style>
    <div class="wrap">
        <img src="{$logo}" style="width:100%;">
    </div>
    <div class="wrap">
        <div class="Selection_top2">
            <ul class="Selection_top2_ul hidden">
                <li class="fl">
                    <span>参与美宿</span>
                    <i>({$joinnum|default="0"}家)</i>
                    <!-- <i>(5630家)</i> -->
                </li>
                <li class="fl">
                    <span>累积投票</span>
                    <i>({$votenum|default="0"}票)</i>
                    <!-- <i>(1200票)</i> -->
                </li>
                <li class="fl">
                    <span>访问次数</span>
                    <!-- <i>({$totalnum|default="0"}次)</i> -->
                    <i>({$hot|default="0"}次)</i>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
    $(function() {
        $(".Selection_top2_ul li").last().css({
            "border-right": "0px"
        })
    })
    </script>
    <div class="index_rule_box">
        <p class="red">点击页面底部"我要报名"</p>
        <p class="red">即可自荐、推荐美宿参加票选</p>
        <div style="color:#FFFFFF;">
            {$rule}
        </div>
        <p class="red">
            <a href="{$link}" style="color:#ff715f
;">点击查看更多活动详情</a><br/>
            <a href="{$link}"><img src="__IMG__/vote/morerule.png"></a>
        </p>

    </div>
    <form action="{:U('Wx/Vote/index')}" method="get">
        <div class="index_search_box">
            <input type="text" name="condition" id="searchbox" value="{$condition|default=''}" placeholder="请输入美宿名称或者编号">
            <!-- <button class="btn_search" onclick="SearchInn()">搜索</button> -->
            <input type="submit" class="middle" value="搜索" style="border:none;cousor:pointer">
        </div>
    </form>
    <div class="wrap">
        <div class="Selection_top3">
            <ul class="hidden Selection_top3_ul">
                <li <empty name="Think.get.type"> class="fl colorli"<else /> class="fl"</empty>>
                <a href="{:U('Wx/Vote/index')}">全部客栈</a>
            </li>
            <li <notempty name="Think.get.type"> class="fl colorli"<else /> class="fl"</notempty>>
                <a href="{:U('Wx/Vote/index',array('type'=>1))}">投票排行</a>
            </li>
            </ul>
        </div>
    </div>
    <div class="wrap">
        <div class="Selection_top3_show">
            <ul class="hidden Selection_top3_show_1">
                <div class="item_list infinite_scroll">
                    <include file="Vote:morelist_index" />
                </div>
                <div id="more">
                    <a href="{:U('Wx/Vote/index',array('isAjax'=>1,'p'=>2,'type'=>$type,'condition'=>$condition))}"></a>
                </div>
            </ul>
        </div>
    </div>
    <div style="height:40px;"></div>
    <div class="index_foot">
        <ul>
            <!-- <li><a href="{:U('Wx/Vote/turntable')}"> <div class="foot_nav"><img src="__IMG__/vote/1.png" />参与抽奖</div></a></li> -->
            <!-- <li><a href="{:U('Wx/Vote/votedinn')}"> <div class="foot_nav"><img src="__IMG__/vote/1.png" />我投票过的客栈</div></a></li>  -->
            <li><a href="{:U('Wx/Vote/myinfo')}">  <div class="foot_nav"><img src="__IMG__/vote/2.png" />我的奖励</div></a></li>
            <li><a href="{:U('Wx/Vote/apply')}">  <div class="foot_nav"><img src="__IMG__/vote/3.png" />美宿报名</div></a></li>
        </ul>
    </div>
    <!-- <eq name="user['subscribestatus']" value="0">
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
    </eq> -->
    <script type="text/javascript">
    $(function() {
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
                finished: function() {
                    sp++;
                    if (sp >= 120) {
                        $("#more").remove();
                        $(window).unbind('.infscr');
                    }
                    $("#infscr-loading").hide();
                }
            },
            errorCallback: function() {

            }

        }, function(newElements) {
            var $newElems = $(newElements);
            $('.infinite_scroll').append($newElems);
            $newElems.fadeIn();
            return;
        });

    });
    // function SearchInn(){
    //     var condition = $("#searchbox").val();
    //     if(condition== "")
    //         $.alert("请输入美宿名称或者编号");
    //     else{
    //         window.location.href="/index.php/Vote/index/condition/"+condition+".html";
    //     }
    // }
    </script>
    <script type="text/javascript">
    $(function() {
        var isvote = false;
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
                            obj.removeClass("voteparty").html("<img src=\"/Public/Wx/img/vote/img3.png\" />已经投票(" + (Number(votenum) + 1) + ")");
                            obj.css("background","#929292");
                            isvote = true;
                        });
                    } else if (data.status == -1) {
                        $.hideLoading();
                        $.alert("您今天已给该客栈投过票了！");
                    } else if (data.status == -2) {
                        $.hideLoading();
                        $.alert("请先关注蜗牛客公众号");
                    } else if (data.status == -3) {
                        $.hideLoading();
                        $.alert("今日投票次数已达上限");
                    } else if(data.status == -5){
                        $.hideLoading();
                        $.alert("该客栈已下架或者删除！");
                    } else {
                        $.hideLoading();
                        $.alert("投票失败");
                    }
                }
            });
        })
        $(".details_main3_04 a").click(function() {
            $(".details_main3_03").hide();
        })
    })
    </script>
<include file="public:foot" />
