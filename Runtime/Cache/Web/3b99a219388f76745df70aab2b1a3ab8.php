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
    <link rel="stylesheet" href="/Public/Web/css/base.css">
    <link rel="stylesheet" href="/Public/Web/css/style.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery-ui.min.css">
    <script src="/Public/Web/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Public/js/jquery-weui.js"></script>
    <script src="/Public/Web/js/Action.js"></script>
    <script src="/Public/Web/js/TouchSlide.1.1.js"></script>
    <script src="/Public/public/js/jquery.lazyload.min.js" type="text/javascript"></script>
    <script src="/Public/public/js/jquery.cookie.js" type="text/javascript"></script>
    <script type="text/javascript" src="/Public/Web/js/iscroll.js"></script>
    <link rel="stylesheet" href="/Public/Web/css/list.css">
    <script>
        $(function(){
            $('img.pic').lazyload({
               effect: 'fadeIn'
            });
        })
    </script>
</head>
<body>

<script type="text/javascript">
    var areaurl = "<?php echo U('Web/Note/getchildren');?>";
    $(function () {
        var province = "<?php echo ($_GET['province']); ?>";
        var city = "<?php echo ($_GET['city']); ?>";
        if (province != '') {
            load(province, 'city');
        }
        if (city != '') {
            load(city, 'town');
        }
    })
    function load(parentid, type) {
        $.ajax({
            type: "GET",
            url: areaurl,
            data: { 'parentid': parentid },
            dataType: "json",
            success: function (data) {
                if (type == 'city') {
                    $('#city').html('<option value="">--请选择--</option>');
                    $('#town').html('<option value="">--请选择--</option>');
                    if (data != null) {
                        $.each(data, function (no, items) {
                            if (items.id == "<?php echo ($_GET['city']); ?>") {
                                $('#city').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                            } else {
                                $('#city').append('<option value="' + items.id + '">' + items.name + '</option>');
                            }
                        });
                    }
                } else if (type == 'town') {
                    $('#town').html('<option value="">--请选择--</option>');
                    if (data != null) {
                        $.each(data, function (no, items) {
                            if (items.id == "<?php echo ($_GET['town']); ?>") {
                                $('#town').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                            } else {
                                $('#town').append('<option value="' + items.id + '">' + items.name + '</option>');
                            }
                        });
                    }
                }
            }
        });
    }
</script>
<div class="header center z-index112 pr f18">
      活动
      <div class="head_go pa"><a href="<?php echo U('Web/Index/index');?>"><img src="/Public/Web/images/go.jpg"></a><span>&nbsp;</span></div>
      <div class="tra_pr pa"><i></i><a href="search-2.html"><img src="/Public/Web/images/search.jpg"></a></div>
</div>

<div class="container">
   <div class="land">
          <div class="tra_list pr z-index112 center f14">
                <div class="tra_li tra_li_on">按特色</div>
                <div class="tra_drop">
                    <div class="act_pad">
                        <div class="dress_box">
                             <div class="dress_b act_a moch_click center f14 partycate">
                                 <ul>
                                    <?php if(is_array($partycate)): $i = 0; $__LIST__ = $partycate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li data-id='<?php echo ($vo["id"]); ?>'><?php echo ($vo["catname"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
                                 </ul>
                             </div>
                       </div>
                    </div>
                </div>
                
                <div class="tra_li tra_li_on">按时间</div>
                <div class="tra_drop">
                    <img src="/Public/Web/images/dt_a.jpg">
                </div>
                <div class="tra_li tra_li_on">按位置</div>
                <div class="tra_drop">
                    <div class="tra_dropA_box">
                      <div class="tra_dropA">
                          <select name="province" id="province" onchange="load(this.value,'city',0)">
                              <option value="">--请选择--</option>
                              <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if($vo['id'] == $_GET['province']): ?>selected<?php endif; ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                          </select>
                          <select name="city" id="city" onchange="load(this.value,'town',0)">
                              <option value="">--请选择--</option>
                          </select>

                          <select name="town" id="town" onchange="load(this.value,'distinct',0)">
                              <option value="">--请选择--</option>
                          </select>
                      </div>
                  </div>
                </div>
                <div class="tra_li tra_li_on">筛选</div>
                <div class="tra_drop">
                    <div class="act_scring">
                        <div class="scr_top">
                              <div class="scr_e1" style="margin-bottom:4rem;padding:0">活动费用</div> 
                              <div class="scr_b" style="margin-bottom:2rem; padding: 0 2.5%;">
                                   <div id="slider-range"></div>
                                   <div class="number">
                                       <div class="number_a fl">￥0</div>
                                       <div class="number_b fr">￥5000</div>
                                   </div>
                              </div>
                              <div class="mng_content">
                                   <div class="mng_left fl">￥<span id="minmoney">0</span> — ￥<span id="maxmoney">不限</span></div>
                              </div>
                              <div class="scr_c"></div> 
                              <div class="scr_d center gratis">免费活动</div> 
                        </div> 
                        <div class="scr_btm">
                             <div class="dress_box">
                                     <div class="scr_e1">按类型 :</div>
                                     <div class="dress_b act_a moch_click center f14">
                                         <ul class="partytype">
                                             <li data-id="0">不限</li>
                                             <li data-id="1">亲子类</li>
                                             <li data-id="2">情侣类</li>
                                             <li data-id="3">家庭出游</li>
                                         </ul>
                                     </div>
                                     <div class="snail_d scr_e2 center f16">
                                            <a class='clear mr_4'>清除筛选</a>
                                            <a class="sub snail_cut">确定</a>
                                      </div>
                              </div> 
                        </div>        
                    </div>
                </div>
          </div>

          <div class="land_btm">
              <div class="land_c f14" id="DataList">
                  <div id="scroller">
                      <div id="pullDown" class="idle">
                          <span class="pullDownIcon"></span>
                          <span class="pullDownLabel">下拉加载数据...</span>
                      </div>
                      <div id="thelist"></div>
                      <div id="pullUp" class="idle">
                          <span class="pullUpIcon"></span>
                          <span class="pullUpLabel">上拉加载数据...</span>
                      </div>
                  </div>
              </div>
          </div>    

   </div>  
   <div class="mask"></div>     
</div>
<script src="/Public/Web/js/jquery-ui.min.js"></script>
<script>
  $(function() {
      $("#slider-range").slider({
            range: true,
            min: 0,
            max: 5000,
            step: 100,
            values: [0, 5000],
            slide: function (event, ui) {
                $("#minmoney").text(ui.values[0]);
                $("#maxmoney").text(ui.values[1]);
            }
      });
      $(".scr_d").click(function(){
          $(this).toggleClass("hm_cut");
      })
      $(".partytype li").click(function(){
          $(this).addClass("hm_cut").siblings().removeClass("hm_cut")   
      })
      $(".partycate li").click(function(){
          $(this).addClass("hm_cut").siblings().removeClass("hm_cut")   
      })
  });
</script>

<script>
    var p = {};
    var city, month, notetype, order = 0;
    var OFFSET = 5;
    var page = 1;
    var PAGESIZE = 10;

    var myScroll,
        pullDownEl,
        pullDownOffset,
        pullUpEl,
        pullUpOffset,
        generatedCount = 0;

    var maxScrollY = 0;
    var hasMoreData = false;

    document.addEventListener('touchmove', function (e) {
        e.preventDefault();
    }, false);
    $(function () {
        loaded();
        $(".mask,.snail_cut").click(function () {
            $(".tra_drop").hide()
            loaded()
        })
    })


    // document.addEventListener('DOMContentLoaded', function() {
    //     $(document).ready(function() {
    //         loaded();
    //     });
    // }, false);

    function loaded() {
        page = 1;
        p['p'] = page;
        p['catid'] = ($(".partycate li.hm_cut").length > 0) ? $(".partycate li.hm_cut").data('id') : 0;
        p['partytype'] = ($(".partytype li.hm_cut").length > 0) ? $(".partytype li.hm_cut").data('id') : 0;
        p['isfree'] = ($(".scr_d.hm_cut").length > 0) ? 1 : 0;
        p['province'] = ($("#province option:selected").length > 0) ? $("#province option:selected").val() : 0;
        p['city'] = ($("#city option:selected").length > 0) ? $("#city option:selected").val() : 0;
        p['town'] = ($("#town option:selected").length > 0) ? $("#town option:selected").val() : 0;

        pullDownEl = document.getElementById('pullDown');
        pullDownOffset = pullDownEl.offsetHeight;
        pullUpEl = document.getElementById('pullUp');
        pullUpOffset = pullUpEl.offsetHeight;
        hasMoreData = false;
        $("#pullUp").hide();
        pullDownEl.className = 'loading';
        pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
        $.get("<?php echo U('Web/Party/ajax_getlist');?>", p, function (data, status) {
            if (status == "success") {
                if (data.status == 0) {
                    $("#pullDown").hide();
                    $("#pullUp").hide();
                }
                if (data.num < PAGESIZE) {
                    hasMoreData = false;
                    $("#pullUp").hide();
                } else {
                    hasMoreData = true;
                    $("#pullUp").show();
                }

                myScroll = new iScroll('DataList', {
                    useTransition: true,
                    topOffset: pullDownOffset,
                    onRefresh: function () {
                        if (pullDownEl.className.match('loading')) {
                            pullDownEl.className = 'idle';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉刷新...';
                            this.minScrollY = -pullDownOffset;
                        }
                        if (pullUpEl.className.match('loading')) {
                            pullUpEl.className = 'idle';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉刷新...';
                        }
                    },
                    onScrollMove: function () {
                        if (this.y > OFFSET && !pullDownEl.className.match('flip')) {
                            pullDownEl.className = 'flip';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '信息更新中...';
                            this.minScrollY = 0;
                        } else if (this.y < OFFSET && pullDownEl.className.match('flip')) {
                            pullDownEl.className = 'idle';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '下拉加载更多...';
                            this.minScrollY = -pullDownOffset;
                        }
                        if (this.y < (maxScrollY - pullUpOffset - OFFSET) && !pullUpEl.className.match('flip')) {
                            if (hasMoreData) {
                                this.maxScrollY = this.maxScrollY - pullUpOffset;
                                pullUpEl.className = 'flip';
                                pullUpEl.querySelector('.pullUpLabel').innerHTML = '信息更新中...';
                            }
                        } else if (this.y > (maxScrollY - pullUpOffset - OFFSET) && pullUpEl.className.match('flip')) {
                            if (hasMoreData) {
                                this.maxScrollY = maxScrollY;
                                pullUpEl.className = 'idle';
                                pullUpEl.querySelector('.pullUpLabel').innerHTML = '上拉加载更多...';
                            }
                        }
                    },
                    onScrollEnd: function () {
                        if (pullDownEl.className.match('flip')) {
                            pullDownEl.className = 'loading';
                            pullDownEl.querySelector('.pullDownLabel').innerHTML = '加载中...';
                            refresh();
                        }
                        if (hasMoreData && pullUpEl.className.match('flip')) {
                            pullUpEl.className = 'loading';
                            pullUpEl.querySelector('.pullUpLabel').innerHTML = '加载中...';
                            nextPage();
                        }
                    }
                });

                $("#thelist").empty();
                $("#thelist").html(data.html);

                myScroll.refresh();
                if (hasMoreData) {
                    myScroll.maxScrollY = myScroll.maxScrollY + pullUpOffset;
                } else {
                    myScroll.maxScrollY = myScroll.maxScrollY;
                }
                maxScrollY = myScroll.maxScrollY;
            };
        }, "json");
        pullDownEl.querySelector('.pullDownLabel').innerHTML = '无数据...';
    }

    function refresh() {
        page = 1;
        p['p'] = page;
        p['month'] = ($(".month li.tra_dropCut").length > 0) ? $(".month li.tra_dropCut").data('id') : 0;
        p['type'] = ($(".order li.tra_dropCut").length > 0) ? $(".order li.tra_dropCut").data('id') : 0;
        p['notetype'] = ($(".notetype li.tra_dropCut").length > 0) ? $(".notetype li.tra_dropCut").data('id') : 0;
        p['province'] = ($("#province option:selected").length > 0) ? $("#province option:selected").val() : 0;
        p['city'] = ($("#city option:selected").length > 0) ? $("#city option:selected").val() : 0;
        p['town'] = ($("#town option:selected").length > 0) ? $("#town option:selected").val() : 0;
        $.get("<?php echo U('Web/Party/ajax_getlist');?>", p, function (data, status) {
            if (status == "success") {
                if (data.length < PAGESIZE || data.status == 0) {
                    hasMoreData = false;
                    $("#pullUp").hide();
                } else {
                    hasMoreData = true;
                    $("#pullUp").show();
                }
                $("#thelist").empty();
                $("#thelist").html(data.html);
                myScroll.refresh();
                if (hasMoreData) {
                    myScroll.maxScrollY = myScroll.maxScrollY + pullUpOffset;
                } else {
                    myScroll.maxScrollY = myScroll.maxScrollY;
                }
                maxScrollY = myScroll.maxScrollY;
            };
        }, "json");
    }

    function nextPage() {
        page++;
        p['p'] = page;
        p['month'] = ($(".month li.tra_dropCut").length > 0) ? $(".month li.tra_dropCut").data('id') : 0;
        p['type'] = ($(".order li.tra_dropCut").length > 0) ? $(".order li.tra_dropCut").data('id') : 0;
        p['notetype'] = ($(".notetype li.tra_dropCut").length > 0) ? $(".notetype li.tra_dropCut").data('id') : 0;
        p['province'] = ($("#province option:selected").length > 0) ? $("#province option:selected").val() : 0;
        p['city'] = ($("#city option:selected").length > 0) ? $("#city option:selected").val() : 0;
        p['town'] = ($("#town option:selected").length > 0) ? $("#town option:selected").val() : 0;

        $.get("<?php echo U('Web/Party/ajax_getlist');?>", p, function (data, status) {
            if (status == "success") {
                if (data.length < PAGESIZE || data.status == 0) {
                    hasMoreData = false;
                    $("#pullUp").hide();
                } else {
                    hasMoreData = true;
                    $("#pullUp").show();
                }
                $new_item = data.html;
                $("#thelist").append(data.html);

                myScroll.refresh();
                if (hasMoreData) {
                    myScroll.maxScrollY = myScroll.maxScrollY + pullUpOffset;
                } else {
                    myScroll.maxScrollY = myScroll.maxScrollY;
                }
                maxScrollY = myScroll.maxScrollY;
            };
        }, "json");
    }
</script>
</body>

</html>