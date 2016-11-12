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
    <script src="__JS__/add-innerText.js"></script>
    <!-- add box start. -->
    <div id="add_activity_box" style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:10000;display:none">
      <!-- background cover start. -->
      <div id="a_a_b_cover" style="background:#000;position:absolute;top:0;left:0;width:100%;height:100%;opacity:0.8"></div>
      <!-- background cover end. -->
      <!-- choose type start -->  
      <div id="type_box" style="position:absolute;left:0;bottom:0;right:0;height:240px;text-align:center;">
        <div class="type_item" data-target="trip">
          游记
        </div>
        <div class="type_item" data-target="hotel" >
          美宿 
        </div>
        <div class="type_item"  data-target="activity">
          活动 
        </div>
        <div class="type_item type_cancel"  data-target="cancel">
          取消
        </div>
      </div>
      <!-- choose type end. -->  
      <!-- add box end. -->
      <!-- activities list start. -->
        <include file="Trip:activity_list" /> 
      <!-- activities list end.  -->
      <!-- activities detail start. -->
        <include file="Trip:activity_details" />
      <!-- activities detail end. -->
      <!-- notes list start. -->
        <include file="Trip:note_list" /> 
      <!-- notes list end. -->
      <!-- notes list start. -->
        <include file="Trip:note_detail" /> 
      <!-- notes list end. -->
      <!-- hotels list start. -->
        <include file="Trip:hotel_list" />
      <!-- hotels list end. -->
      <!-- hotels detail start. -->
        <include file="Trip:hotel_details" />
      <!-- hotels detail end. -->
    </div>
    <div class="header center z-index112 pr f18" style="position:fixed;top:0;left:0;right:0">
        规划行程<span id="show"></span>
        <div class="head_go pa">
            <a href="javascript:history.go(-1)" style="font-size:12px;">
                <img src="__IMG__/go.jpg">
            </a><span>&nbsp;</span>
        </div>
    </div>
    <div class="container" style="margin-top:6rem;">
        <div class="trip_box pr" style="overflow-y:scroll;background:#fff;">
            <div class="trip_left pa">
                <div class="trip_list trip_listdrag trip_big">
                    <div class="trip_a trip_cut"><span style="background:#fff;">全部</span></div>
                    <div class="trip_b"></div>
                </div>
                <for start="1" end="$circleDays" step="1">
                  <div class="trip_list trip_listdrag" data-day="{$i}">
                      <div class="trip_a"><span>D{$i}</span></div>
                      <div class="trip_b"></div>
                  </div>
                </for>
                <div class="trip_list">
                    <div class="trip_a"><span>+</span></div>
                    <div class="trip_b"></div>
                </div>
            </div>
            <div class="trip_right">
                <div class="trip_cBox">
                    <div class="trip_c center">
                        <div class="trip_c1">{$title}</div>
                        <div class="trip_c2">
                          <img src="__IMG__/time.png" />
                          {$start_date} - {$end_date}
                          </div>
                        <div class="trip_c3">未开始</div>
                    </div>
                    <div class="trip_dragBtm">
                        <div class="trip_d ">
                            <div class="trip_e center" style="display:none">
                                <span>--</span>
                                <div class="trip_e2"></div>
                            </div>
                            <div class="trip_hBox" id="add_trip_box_all" data-seq="0">
                            </div>
                        </div>
                        <div class="snail_d center trip_btn f16">
                            <a href="#" class="add_more" data-target="#add_trip_box_all">添加更多</a>
                        </div>
                    </div>
                </div>
                <for start="1" end="$circleDays" step="1">
                  <div class="trip_cBox trip_days" style="display:none" data-day="{$i}">
                      <div class="trip_c center">
                          <div class="trip_c1">{$title}</div>
                          <div class="trip_c2">
                            <img src="__IMG__/time.png" />
                            {$start_date} - {$end_date}
                            </div>
                          <div class="trip_c3">未开始</div>
                      </div>
                      <div class="trip_dragBtm">
                          <div class="trip_d ">
                              <div class="trip_e center" style="display:none">
                                  <span>--</span>
                                  <div class="trip_e2"></div>
                              </div>
                              <div class="trip_hBox trip_point_list" id="add_trip_box_{$i}" data-seq="{$i}">
                                <?php foreach($tripinfos as $key => $tripinfo) { ?>
                                  <?php if ($tripinfo['day'] == $i) { ?>
                                    <div class="trip_h trip_drag f0 trip_point">
                                      <input type="hidden" class="activity_value trip_value" data-type="activity" data-varname="{$tripinfo['varname']}" data-city="{$tripinfo['city']}" data-cityname="{$tripinfo['cityname']}" data-id="{$tripinfo['eventid']}" data-event="{$tripinfo['event']}">
                                      <div class="trip_h1 vertical">{$tripinfo['place']}</div>
                                      <div class="trip_h2 vertical">{$tripinfo['event']}</div>
                                      <div class="trip_h3 vertical"><img src="__IMG__/lin.png" /></div>
                                    </div>
                                  <?php } ?>
                                <?php } ?>
                              </div>
                          </div>
                          <div class="snail_d center trip_btn f16">
                              <a href="#" class="add_more" data-target="#add_trip_box_{$i}">添加更多</a>
                          </div>
                      </div>
                  </div>
                </for>
            </div>
        </div>
    </div>
    <div class="snail_d center trip_btn hh_btm f16">
        <a href="#" id="plan_submit" class="snail_cut" style="border-radius:0 !important;">完成规划并生成</a>
    </div>
    <script src="__JS__/jquery-ui.min.js"></script>
    <script type="text/javascript">
      var addBox = $('#add_activity_box');
      if(!window.external) window.external = {};
      var addTripObject =  window.external.addTripObject = {};
      $('.add_more').click(function(evt) {
        evt.preventDefault();
        var _this = $(this);
        console.log(this);
        addTripObject.target = _this.data('target');
        addTripObject.seq = $(addTripObject.target).data('seq');
        addBox.slideToggle('fast');
      });
      $('.type_item').click(function(evt) {
        evt.preventDefault();
        var _this = $(this);
        var type = _this.data('target');
        switch (type) {
          case 'trip':
            $('#note_list_frame').removeClass('hide');
            break; 
          case 'activity':
            $('#activity_list').removeClass('hide');
            break; 
          case 'hotel':
            $('#hotel_list_frame').removeClass('hide');
            break; 
          case 'cancel':
            addBox.slideToggle('fast');
            break; 
        }
      });
    </script>
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

                if (dropIndex == nowPageIndex) {
                    //拖入至当前页面
                    $dragele.resetanimate();
                    return;
                }

                var cs = $(".trip_cBox")[dropIndex];

                var $ct = $(cs).find(".trip_e");
                var $span = $ct.children("span");


                for (var i = 0; i < $span.length; i++) {
                  if (title == $span[i].innerText) {
                        //如果找到了匹配的title
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
                      if (i == $span.length - 1) {
                            //如果未找到匹配的title
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
                if ($span.length == 0) {
                    //如果不存在任何title
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
    <script>
      $('.trip_box').height(window.screen.availHeight);
    </script>
    <script>
      $('a#plan_submit').click(function(evt) {
        evt.preventDefault();
        var trips = [];
        var days = $('.trip_point_list');
        var tripData = [];
        for(var i = 0; i < days.length; i++) {
          var day = $(days[i]); 
          var points = day.find('.trip_value');
          if(points == undefined || points.length == 0) {
            var emptyDay = i + 1;
            alert("第" + emptyDay + "天没有安排行程！");
            return;
          }
          for(var j = 0; j < points.length; j++) {
            point = $(points[j]);
            var pinfo = { 
              'day': i + 1,
              'city': point.data('city'),
              'cityname': point.data('cityname'),
              'place': point.data('place'),
              'varname': point.data('varname'),
              'eventid': point.val(),
              'listorder': 0,
              'date': parseInt('{$starttime}') + (i - 1) * 24 * 3600,
              'money': '0.00'  
            };
            tripData.push(pinfo);
          }
        }
        $.ajax({
          'url': '{:U("Api/Trip/edit")}',
          'dataType': 'JSON',
          'contentType': 'text/xml',
          'type': 'post',
          'processData': false,
          'data': JSON.stringify({
            'tid': '{$tid}',
            'uid': '{$uid}',
            'title': '{$title}',
            'days': '{$trip_days}',
            'starttime': '{$starttime}',
            'endtime': '{$endtime}',
            'uid': '{$uid}',
            'money': '0.00',
            'tripinfo': tripData
          }),
          'success': function(data) {
            if(data.code == 200) {
              window.location.href='{:U("Trip/myTrips")}';
            } else {
              alert(data.msg);
            }
          },
          'error': function(err, data) {
            console.log(err); 
          }
        });
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
