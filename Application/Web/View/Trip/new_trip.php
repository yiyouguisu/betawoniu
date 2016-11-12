<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <title>蜗牛客</title>
    <link rel="stylesheet" href="__CSS__/base.css" />
    <link rel="stylesheet" href="__CSS__/style.css" />
    
    <script src="__JS__/jquery-1.11.1.min.js"></script>
    <script src="__JS__/hammer.min.js"></script>
    <script src="__JS__/Action.js"></script>
    <script src="__JS__/Sortable.min.js"></script>
    <script src="__JS__/dropsort.js"></script>
</head>

<body class="back-f1f1f1">
    <script src="js/add-innerText.js"></script>
    <div class="header center z-index112 pr f18">
        规划行程<span id="show"></span>
        <div class="head_go pa" onclick="history.go(-1)"><img src="images/go.jpg" /></div>
    </div>
    <div class="container">
        <div class="trip_box pr">
            <div class="trip_left pa">
                <div class="trip_list trip_listdrag">
                    <div class="trip_a"><span style="background:#fff;">全部</span></div>
                    <div class="trip_b"></div>
                </div>
                <div class="trip_list trip_listdrag">
                    <div class="trip_a"><span>D1</span></div>
                    <div class="trip_b"></div>
                </div>
                <div class="trip_list trip_listdrag">
                    <div class="trip_a"><span>D2</span></div>
                    <div class="trip_b"></div>
                </div>
                <div class="trip_list trip_listdrag">
                    <div class="trip_a"><span>D3</span></div>
                    <div class="trip_b"></div>
                </div>
                <div class="trip_list">
                    <div class="trip_a"><span>+</span></div>
                    <div class="trip_b"></div>
                </div>
            </div>
            <div class="trip_right">
                <div class="trip_cBox">
                    <div class="trip_c center">
                        <div class="trip_c1">杭州 、上海、苏州 5日游</div>
                        <div class="trip_c2"><img src="images/time.png" />2016年5月20日 - 5月25日</div>
                        <div class="trip_c3">进行中</div>
                    </div>
                    <div class="trip_dragBtm">
                        <div class="trip_d ">
                            <div class="trip_e center">
                                <span>杭州</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox">
                                <div class="trip_h trip_drag f0 trip_point">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">0</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">1</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">2</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">3</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="trip_d ">
                            <div class="trip_e center">
                                <span>上海</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox">
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">西湖新龙门客栈</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">森林湖泊钓鱼活动</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                            </div>
                            <div class="snail_d center trip_btn f16">
                                <a href="">添加更多</a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="trip_cBox hide">
                    <div class="trip_c center">
                        <div class="trip_c1">杭州 、上海、苏州 5日游</div>
                        <div class="trip_c2"><img src="images/time.png" />2016年5月20日 - 5月25日</div>
                        <div class="trip_c3">进行中22</div>
                    </div>

                    <div class="trip_dragBtm">
                        <div class="trip_d ">
                            <div class="trip_e center">
                                <span>杭州</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox">
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">西湖新龙门客栈</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">森林湖泊钓鱼活动</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="trip_d ">
                            <div class="trip_e center">
                                <span>上海</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox">
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">西湖新龙门客栈</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">森林湖泊钓鱼活动</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                            </div>
                            <div class="snail_d center trip_btn f16">
                                <a href="">添加更多</a>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="trip_cBox hide">
                    <div class="trip_c center">
                        <div class="trip_c1">杭州 、上海、苏州 5日游</div>
                        <div class="trip_c2"><img src="images/time.png" />2016年5月20日 - 5月25日</div>
                        <div class="trip_c3">进行中33</div>
                    </div>

                    <div class="trip_dragBtm">
                        <div class="trip_d ">
                            <div class="trip_e center">
                                <span>杭州</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox">
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">西湖新龙门客栈</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">森林湖泊钓鱼活动</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="trip_d ">
                            <div class="trip_e center">
                                <span>上海</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox">
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">西湖新龙门客栈</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">森林湖泊钓鱼活动</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                            </div>
                            <div class="snail_d center trip_btn f16">
                                <a href="">添加更多</a>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="trip_cBox hide">
                    <div class="trip_c center">
                        <div class="trip_c1">杭州 、上海、苏州 5日游</div>
                        <div class="trip_c2"><img src="images/time.png" />2016年5月20日 - 5月25日</div>
                        <div class="trip_c3">进行中44</div>
                    </div>

                    <div class="trip_dragBtm">
                        <div class="trip_d ">
                            <div class="trip_e center">
                                <span>杭州</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox">
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">西湖新龙门客栈</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">森林湖泊钓鱼活动</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="trip_d ">
                            <div class="trip_e center">
                                <span>上海</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox">
                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">西湖新龙门客栈</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                                <div class="trip_h trip_drag f0">
                                    <div class="trip_h1 vertical">西湖</div>
                                    <div class="trip_h2 vertical">森林湖泊钓鱼活动</div>
                                    <div class="trip_h3 vertical"><img src="images/lin.png" /></div>
                                </div>

                            </div>
                            <div class="snail_d center trip_btn f16">
                                <a href="">添加更多</a>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="snail_d center trip_btn hh_btm f16">
        <a href="trip-details.html" class="snail_cut">完成规划并生成</a>
    </div>


    <script src="js/jquery-ui.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            //tab切换
            var $ml = $(".trip_left > .trip_listdrag");
            $ml.click(function () {
                $(this).addClass("trip_big").siblings().removeClass("trip_big");
                $(".trip_cBox").hide();
                var cs = $(".trip_cBox")[getObjectIndex(this, $ml)];
                $(cs).show();
            });

            //拖放排序
            $(".trip_hBox > .trip_drag").dropsort();

            mobilesort();

            //拖入tab
            $ml.not(":first").droppable({
                tolerance: "pointer",
                accept: ".trip_hBox > .trip_drag",//$(".trip_hBox").not(".trip_hBox:eq(0)").find(" > .trip_drag"),//PC端“全部”的不允许拖出去
                hoverClass: "ui-state-hover",
                drop: function (event, ui) {
                    tabdrop(ui.draggable, this);
                }
            });

            function tabdrop($dragele, dropele) {
                var dragobject = $dragele[0];
                var $ul = $(dragobject).parent();
                var title = $ul.prevAll(".trip_e ").children("span").text();

                var $tabItem = $(dragobject).parents(".trip_cBox");
                var nowPageIndex = getObjectIndex($tabItem[0], $(".trip_cBox"))

                var dropIndex = getObjectIndex(dropele, $ml);

                if (dropIndex == nowPageIndex) {//拖入至当前页面
                    $dragele.resetanimate();
                    return;
                }

                var cs = $(".trip_cBox")[dropIndex];

                var $ct = $(cs).find(".trip_e");
                var $span = $ct.children("span");


                for (var i = 0; i < $span.length; i++) {
                    if (title == $span[i].innerText) {//如果找到了匹配的title
                        $($ct[i]).next().append(dragobject);
                        $(dragobject).css({
                            "left": 0,
                            "top": 0
                        });
                        if ($ul.children().length == 0) {
                            $ul.parent().remove();
                        }
                        break;
                    } else {
                        if (i == $span.length - 1) {//如果未找到匹配的title
                            var $clone = $(dragobject).parent().parent().clone(true);
                            $clone.children("ul").empty().append(dragobject);
                            $(dragobject).css({
                                "left": 0,
                                "top": 0
                            });
                            //alert($clone[0]);
                            $($ct[i]).parent().after($clone);

                            if ($ul.children().length == 0) {
                                $ul.parent().remove();
                            }
                        }
                    }
                }
                if ($span.length == 0) {//如果不存在任何title
                    var $clone = $(dragobject).parent().parent().clone(true);
                    $clone.children("ul").empty().append(dragobject);
                    $(dragobject).css({
                        "left": 0,
                        "top": 0
                    });
                    //alert($clone[0]);
                    $(cs).find(".trip_dragBtm").prepend($clone);

                    if ($ul.children().length == 0) {
                        $ul.parent().remove();
                    }
                }

            }

            function getObjectIndex(a, b) {
                for (var i in b) {
                    if (b[i] == a) {
                        return i;
                    }
                }
                return -1;
            }

            function IsPC() {
                var userAgentInfo = navigator.userAgent;
                var Agents = new Array("Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod");
                var flag = true;
                for (var v = 0; v < Agents.length; v++) {
                    if (userAgentInfo.indexOf(Agents[v]) > 0) { flag = false; break; }
                }
                return flag;
            }


            function mobilesort() {
                //移动端启用Sortable排序
                if (!IsPC()) {
                    //$(".trip_drag").hammerdrag();
                    var $tripBoxs = $(".trip_hBox");
                    $tripBoxs.each(function (index) {
                        Sortable.create($tripBoxs[index], {
                            group: { 'pull': false },
                            animation: 150,
                            onStart: function (event) {
                                //alert(evt);
                            },
                            onEnd: function (event) {
                                //var $parentcbox = $(event.item).parents(".trip_cBox");//移动端“全部”的不允许拖出去，注释掉允许
                                //var $cboxAll = $(".trip_cBox:eq(0)");
                                //if ($parentcbox[0] == $cboxAll[0]) {
                                    //return;
                                //}
                                var e = window.event;
                                var mouseX = e.changedTouches[0].clientX;
                                var mouseY = e.changedTouches[0].clientY;//e.clientY + document.body.scrollTop + document.documentElement.scrollTop;//鼠标当前的Y轴位置

                                $ml.each(function (index) {
                                    if (index == 0) {
                                        return;
                                    }
                                    var top = $($ml[index]).offset().top;
                                    var left = $($ml[index]).offset().left;
                                    var height = $ml[index].clientHeight;
                                    var width = $ml[index].clientWidth;

                                    var isDrop = checkpoint(
                                        {
                                            x: mouseX,
                                            y: mouseY
                                        },
                                        {
                                            point: { x: left, y: top },
                                            rect: { w: width, h: height }
                                        }
                                    );

                                    if (isDrop) {
                                        tabdrop($(event.item), $ml[index]);
                                        mobilesort();//重新注册事件
                                    }
                                });
                            }
                        });
                    });
                }
            }
        });
    </script>
    <style>
        /*可拖动元素鼠标指针默认样式*/
        .trip_drag {
            cursor: default;
        }
    </style>
</body>
</html>
