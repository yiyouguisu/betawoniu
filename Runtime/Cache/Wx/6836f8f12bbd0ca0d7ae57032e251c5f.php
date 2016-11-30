<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
<meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
<meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
<meta name="format-detection" content="telephone=no" />
<link href="favicon.ico" rel="SHORTCUT ICON">
<title><?php echo ($site["sitetitle"]); ?></title>

<link rel="stylesheet" href="/Public/Public/css/weui.css">
<link rel="stylesheet" href="/Public/Public/css/jquery-weui.css">
<link rel="stylesheet" href="/Public/Wx/css/layer.css">
<script src="/Public/Wx/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Public/js/jquery-weui.js"></script>
<script type="text/javascript" src="/Public/public/js/jquery.infinitescroll.js"></script>
<script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script> 
<script src="/Public/Wx/js/layer.js" type="text/javascript"></script> 
</head>
<body>

<link href="/Public/Wx/css/Style.css" rel="stylesheet" />
<link href="/Public/Wx/css/base.css" rel="stylesheet" />
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<style>
    body {
        background: #21283b;
    }
    </style>
    <div class="wrap">
        <img src="<?php echo ($logo); ?>" style="width:100%;">
    </div>
    <div class="wrap">
        <div class="Selection_top2">
            <ul class="Selection_top2_ul hidden">
                <li class="fl">
                    <span>参与美宿</span>
                    <i>(<?php echo ((isset($joinnum) && ($joinnum !== ""))?($joinnum):"0"); ?>家)</i>
                    <!-- <i>(5630家)</i> -->
                </li>
                <li class="fl">
                    <span>累积投票</span>
                    <i>(<?php echo ((isset($votenum) && ($votenum !== ""))?($votenum):"0"); ?>票)</i>
                    <!-- <i>(1200票)</i> -->
                </li>
                <li class="fl">
                    <span>访问次数</span>
                    <!-- <i>(<?php echo ((isset($totalnum) && ($totalnum !== ""))?($totalnum):"0"); ?>次)</i> -->
                    <i>(<?php echo ((isset($hot) && ($hot !== ""))?($hot):"0"); ?>次)</i>
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
            <?php echo ($rule); ?>
        </div>
        <p class="red">
            <a href="<?php echo ($link); ?>" style="color:#ff715f
;">点击查看更多活动详情</a><br/>
            <a href="<?php echo ($link); ?>"><img src="/Public/Wx/img/vote/morerule.png"></a>
        </p>

    </div>
    <form action="<?php echo U('Wx/Vote/index');?>" method="get">
        <div class="index_search_box">
            <input type="text" name="condition" id="searchbox" value="<?php echo ((isset($condition) && ($condition !== ""))?($condition):''); ?>" placeholder="请输入美宿名称或者编号">
            <!-- <button class="btn_search" onclick="SearchInn()">搜索</button> -->
            <input type="submit" class="middle" value="搜索" style="border:none;cousor:pointer">
        </div>
    </form>
    <div class="wrap">
        <div class="Selection_top3">
            <ul class="hidden Selection_top3_ul">
                <li <?php if(empty($_GET['type'])): ?>class="fl colorli"<?php else: ?> class="fl"<?php endif; ?>>
                <a href="<?php echo U('Wx/Vote/index');?>">全部客栈</a>
            </li>
            <li <?php if(!empty($_GET['type'])): ?>class="fl colorli"<?php else: ?> class="fl"<?php endif; ?>>
                <a href="<?php echo U('Wx/Vote/index',array('type'=>1));?>">投票排行</a>
            </li>
            </ul>
        </div>
    </div>
    <div class="wrap">
        <div class="Selection_top3_show">
            <ul class="hidden Selection_top3_show_1">
                <div class="item_list infinite_scroll">
                    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="fl item">
        <a href="<?php echo U('Wx/Vote/show',array('id'=>$vo['id']));?>" class="pr">
            <img src="<?php echo ($vo["logo"]); ?>" data-original="<?php echo ($vo["thumb"]); ?>" class="pic" />
        </a>
        <i><?php echo str_cut($vo['name'],10);?></i>
        <p class="hidden">
            <span class="fl"><img src="/Public/Wx/img/Selection/map.png" /><?php echo str_cut($vo['address'],5);?></span>
            <label class="fr"> 编号: <?php echo ($vo["id"]); ?></label>
        </p>
        <?php if(($vo['isvote']) == "2"): ?><div class="Selection_label voteparty" data-id="<?php echo ($vo["id"]); ?>"><img src="/Public/Wx/img/Selection/hand.png" />为他投票(<?php echo ($vo["votenum"]); ?>)</div>
            <?php else: ?>
            <div class="Selection_label" style="background: #929292;" data-id="<?php echo ($vo["id"]); ?>"><img src="/Public/Wx/img/vote/img3.png" />已经投票(<?php echo ($vo["votenum"]); ?>)</div><?php endif; ?>


    </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div id="more">
                    <a href="<?php echo U('Wx/Vote/index',array('isAjax'=>1,'p'=>2,'type'=>$type,'condition'=>$condition));?>"></a>
                </div>
            </ul>
        </div>
    </div>
    <div style="height:40px;"></div>
    <div class="index_foot">
        <ul>
            <!-- <li><a href="<?php echo U('Wx/Vote/turntable');?>"> <div class="foot_nav"><img src="/Public/Wx/img/vote/1.png" />参与抽奖</div></a></li> -->
            <!-- <li><a href="<?php echo U('Wx/Vote/votedinn');?>"> <div class="foot_nav"><img src="/Public/Wx/img/vote/1.png" />我投票过的客栈</div></a></li>  -->
            <li><a href="<?php echo U('Wx/Vote/myinfo');?>">  <div class="foot_nav"><img src="/Public/Wx/img/vote/2.png" />我的奖励</div></a></li>
            <li><a href="<?php echo U('Wx/Vote/apply');?>">  <div class="foot_nav"><img src="/Public/Wx/img/vote/3.png" />美宿报名</div></a></li>
        </ul>
    </div>
    <!-- <?php if(($user['subscribestatus']) == "0"): ?><div class="details_main4">
            <div class="details_main4_01 hidden">
                <div class="details_main4_02">
                    <span>点击关注我们的微信服务号</span>
                </div>
                <div class="details_main4_03">
                    <a href="http://mp.weixin.qq.com/s?__biz=MzIwNzM5NTE5OA==&mid=100000003&idx=1&sn=b3b21c2c9ef869c7b589d684d65b83b8#rd">关注微信</a>
                </div>
            </div>
        </div><?php endif; ?> -->
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
            var uid = "<?php echo ($user["id"]); ?>";
            if (uid == '') {
                $.alert("请先清除微信缓存；方法：手机后台关闭微信应用，再重新打开微信。");
                return false;
            }

            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "<?php echo U('Wx/Vote/ajax_vote');?>",
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
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  wx.config({
      debug: false,
      appId: '<?php echo $signPackage["appId"];?>',
      timestamp: <?php echo $signPackage["timestamp"];?>,
      nonceStr: '<?php echo $signPackage["nonceStr"];?>',
      signature: '<?php echo $signPackage["signature"];?>',
      jsApiList: [
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'hideMenuItems'
      ]
  });
  wx.ready(function () {


  // 2.1 监听“分享给朋友”，按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareAppMessage({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {

      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareAppMessage','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareAppMessage','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareAppMessage','error');
      }
    });


  // 2.2 监听“分享到朋友圈”按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareTimeline({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {
        // 不要尝试在trigger中使用ajax异步请求修改本次分享的内容，因为客户端分享操作是一个同步操作，这时候使用ajax的回包会还没有返回
      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareTimeline','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareTimeline','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareTimeline','error');
      }
    });


  // 2.3 监听“分享到QQ”按钮点击、自定义分享内容及分享结果接口

    wx.onMenuShareQQ({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {
      },
      complete: function (res) {
      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareQQ','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareQQ','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareQQ','error');
      }
    });


  // 2.4 监听“分享到微博”按钮点击、自定义分享内容及分享结果接口
    wx.onMenuShareWeibo({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {
      },
      complete: function (res) {
      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareWeibo','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareWeibo','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareWeibo','error');
      }
    });


  // 2.5 监听“分享到QZone”按钮点击、自定义分享内容及分享接口

    wx.onMenuShareQZone({
      title: '<?php echo ($share["title"]); ?>',
      desc: '<?php echo ($share["content"]); ?>',
      link: '<?php echo ($share["link"]); ?>',
      imgUrl: '<?php echo ($share["image"]); ?>',
      trigger: function (res) {
      },
      complete: function (res) {
      },
      success: function (res) {
        alert('已分享');
        ajax_share('<?php echo ($share["id"]); ?>','ShareQZone','success');
      },
      cancel: function (res) {
        alert('已取消');
        ajax_share('<?php echo ($share["id"]); ?>','ShareQZone','cancel');
      },
      fail: function (res) {
        alert(JSON.stringify(res));
        ajax_share('<?php echo ($share["id"]); ?>','ShareQZone','error');
      }
    });
});

wx.error(function (res) {
  //alert(res.errMsg);
});
// function ajax_share(mid,sharetype,sharestatus){
    //$.ajax({
    //    type: "POST",
    //    url: "<?php echo U('Home/Index/ajax_share');?>",
    //    data: {'sharetype':sharetype,'sharestatus':sharestatus,'mid':mid},
    //    dataType: "json",
    //    success: function(data){
    //        if(sharestatus=='success'){
    //            window.location.href='/index.php/Index/order/mid/'+mid+'.html';
    //        }

    //    }
    //});
// }
</script>
</body>
</html>