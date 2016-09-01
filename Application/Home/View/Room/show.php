<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script src="__JS__/jssor.js"></script>
<script src="__JS__/jssor.slider.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<script src='__JS__/moment.min.js'></script>
<script src='__JS__/fullcalendar.min.js'></script>
<script src='__JS__/lang-all.js'></script>
<link href="__CSS__/fullcalendar.print.css" rel="stylesheet" />
<link href="__CSS__/fullcalendar.min.css" rel="stylesheet" />
<link href="__CSS__/fullcalendar.css" rel="stylesheet" />    
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script>
    $(function(){
        var dateInput = $("input.J_date")
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker({
                    onHide:function(){
                        var starttime=$(".starttime").val();
                        var endtime=$(".endtime").val();
                        console.log(starttime)
                        console.log(endtime)
                        if(starttime!=''&&endtime!=''){
                            if(Date.parse(endtime) - Date.parse(starttime)==0){
                                alert("请填写正确日期");
                                $(".endtime").val();
                                return false;
                            }else{
                                var rid="{$data.rid}";
                                $.post("{:U('Home/Room/ajax_checkdate')}",{"rid":rid,"starttime":starttime,"endtime":endtime},function(d){
                                    if(d.code==200){
                                        var days=DateDiff(starttime,endtime);
                                        console.log(days)
                                        $("#days").val(Number(days));
                                        $("#totalmoney").text(d.totalmoney);
                                        $("input[name='totalmoney']").val(d.totalmoney);
                                    }else{
                                        alert("您选择的日期包含不合法日期");
                                        $(".endtime").val();
                                        return false;
                                    }
                                });
                            }

                        }
                        
                        
                    }
                });
                
            });
        }
    })
    //计算天数差的函数，通用  
   function  DateDiff(sDate1,  sDate2){    //sDate1和sDate2是2006-12-18格式  
       var  aDate,  oDate1,  oDate2,  iDays  
       aDate  =  sDate1.split("-")  
       oDate1  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])    //转换为12-18-2006格式  
       aDate  =  sDate2.split("-")  
       oDate2  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])  
       iDays  =  parseInt(Math.abs(oDate1  -  oDate2)  /  1000  /  60  /  60  /24)    //把相差的毫秒数转换为天数  
       return  iDays  
   }    

</script>
<include file="public:mheader" />
<div class="wrap">
        <div class="Legend_main3">
            <div class="Legend_main3_top">
                <a href="/">首页</a>
                <i>></i>
                <a href="{:U('Home/Hostel/index')}">美宿</a>
                <i>></i>
                <a href="{:U('Home/Hostel/show',array('id'=>$data['hid']))}">{$data.hostel}</a>
            </div>
            <div class="Inn_introduction_main">
                <div class="Inn_introduction_main_top hidden">
                    <span>{$data.title}</span>
                    <i><em>{$data.money|default="0.00"}</em>元起</i>
                </div>
                <div class="hidden Inn_introduction_main_bottom">
                    <div class="middle Inn_introduction_main_bottom2">
                        <div class="center hidden">
                            <ul class="center_ul hidden middle">
                                {:getevaluation($data['evaluationpercent'])}
                            </ul>
                            <span class="middle"><em>{$data.evaluation|default="0.0"}</em>分</span>
                            <div class="center_ul_list middle">
                                <img src="__IMG__/Icon/img10.png" /><i><em>{$data.reviewnum|default="0"}</em>条评论</i>
                            </div>
                        </div>
                        <div class="bottom">
                            <volist name="data['support']" id="vo">
                                <i>
                                    <img src="{$vo.red_thumb}" /><em>{$vo.catname}</em>
                                </i>
                            </volist>
                        </div>
                        <div class="center2">
                            <span>房间面积：<em>{$data.area|default="0.0"}m2 </em></span>
                            <span>床型信息：<em>{$data.bedtype}</em></span>
                            <span>房间数：<em>{$data.mannum|default="0"}人</em></span>
                        </div>
                    </div>
                    <div class="middle Inn_introduction_main_bottom3">
                        <a href="" class="a1"><img src="__IMG__/Icon/img24.png" /></a>
                        <a href="javascript:;" class="a2">
                            <eq name="data['iscollect']" value="1">
                                <img src="__IMG__/Icon/img25.png" class="shoucang" data-id="{$data.rid}"/>
                                <else />
                                <img src="__IMG__/shoucang.png"  class="shoucang" data-id="{$data.rid}"/>
                            </eq>
                            收藏
                        </a>
                        <!-- <a href="" class="a3"><img src="__IMG__/Icon/img26.png" />添加到行程</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQuery(document).ready(function ($) {

            var _SlideshowTransitions = [
            //Fade in L
                { $Duration: 1200, x: 0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade out R
                , { $Duration: 1200, x: -0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade in R
                , { $Duration: 1200, x: -0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade out L
                , { $Duration: 1200, x: 0.3, $SlideOut: true, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

            //Fade in T
                , { $Duration: 1200, y: 0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out B
                , { $Duration: 1200, y: -0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade in B
                , { $Duration: 1200, y: -0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade out T
                , { $Duration: 1200, y: 0.3, $SlideOut: true, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

            //Fade in LR
                , { $Duration: 1200, x: 0.3, $Cols: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out LR
                , { $Duration: 1200, x: 0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade in TB
                , { $Duration: 1200, y: 0.3, $Rows: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade out TB
                , { $Duration: 1200, y: 0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

            //Fade in LR Chess
                , { $Duration: 1200, y: 0.3, $Cols: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out LR Chess
                , { $Duration: 1200, y: -0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 12 }, $Easing: { $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade in TB Chess
                , { $Duration: 1200, x: 0.3, $Rows: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out TB Chess
                , { $Duration: 1200, x: -0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 3 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }

            //Fade in Corners
                , { $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }
            //Fade out Corners
                , { $Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] }, $SlideOut: true, $ChessMode: { $Column: 3, $Row: 12 }, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Top: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2, $Outside: true }

            //Fade Clip in H
                , { $Duration: 1200, $Delay: 20, $Clip: 3, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade Clip out H
                , { $Duration: 1200, $Delay: 20, $Clip: 3, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade Clip in V
                , { $Duration: 1200, $Delay: 20, $Clip: 12, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            //Fade Clip out V
                , { $Duration: 1200, $Delay: 20, $Clip: 12, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $JssorEasing$.$EaseOutCubic, $Opacity: $JssorEasing$.$EaseLinear }, $Opacity: 2 }
            ];

            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 1500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 760,                                //Specifies default duration (swipe) for slide in milliseconds

                $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                },

                $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                },

                $ThumbnailNavigatorOptions: {                       //[Optional] Options to specify and enable thumbnail navigator or not
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 10,                             //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 360                          //[Optional] The offset position to park thumbnail
                }
            };
            var imglist="{$imglist}";
            if(imglist!=""){
                var jssor_slider1 = new $JssorSlider$("slider1_container", options);
                //responsive code begin
                //you can remove responsive code if you don't want the slider scales while window resizes
                function ScaleSlider() {
                    var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                    if (parentWidth)
                        jssor_slider1.$ScaleWidth(Math.max(Math.min(parentWidth, 760), 300));
                    else
                        window.setTimeout(ScaleSlider, 30);
                }
            
                ScaleSlider();

                $(window).bind("load", ScaleSlider);
                $(window).bind("resize", ScaleSlider);
                $(window).bind("orientationchange", ScaleSlider);
            }
            
            //responsive code end
        });
    </script>
    <script>

    $(document).ready(function () {


        /* initialize the external events
		-----------------------------------------------------------------*/

        $('#external-events div.external-event').each(function () {
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });

        
        /* initialize the calendar
		-----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var currentLangCode = 'zh-cn';




        $('#calendar').fullCalendar({
           
            header: {
                left: 'prev',
                center: 'title,monthNames',
                right: 'next'
            },
            lang: currentLangCode,
            editable: true,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');

                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);

                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;

                // render the event on the calendar
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }

            },
            columnFormat: {
                week: 'ddd M-d', // Mon 9/7		
            },
            eventClick: function(event) {
                if (event.url) {
                    window.open(event.url);
                    return false;
                }
            },
            monthNames: ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"],
            events: {$data['jsonlist']},
        });


    });

    </script>
    <div class="wrap">
        <div class="Inn_introduction_main2 hidden">
            <div class="Hotel_Details_main fl">
                <div id="slider1_container" style="vertical-align:top; display:inline-block; *display:inline; *zoom:1; position: relative; top: 0px; left: 0px; width: 740px;
        height: 556px; background: #fff; overflow: hidden;">
                    <!-- Loading Screen -->
                    <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                        <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #fff; top: 0px; left: 0px;width: 100%;height:100%;">
                        </div>
                        <div style="position: absolute; display: block; background: url(img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
                        </div>
                    </div>
                    <!-- Slides Container -->
                    <div u="slides" style="cursor: pointer; position: absolute; left: 0px; top: 0px; width: 780px; height: 456px; overflow: hidden;">
                        <volist name="imglist" id="vo">
                            <div>
                                <img u="image" src="{$vo}" /><!--显示的大图-->
                                <img u="thumb" src="{$vo}" /><!--小图片-->
                            </div>
                        </volist>
                    </div>
                    <!-- Arrow Left -->
                    <span u="arrowleft" class="jssora05l hide" style="width: 40px; height: 40px; top: 158px; left: 8px;"></span><!--左箭头-->
                    <span u="arrowright" class="jssora05r hide" style="width: 40px; height: 40px; top: 158px; right: 8px"></span><!--右箭头-->
                    <div u="thumbnavigator" class="Hotel_Details_main2" style="position: absolute; width: 780px; height: 100px; left:0px; bottom: 0px;">
                        <div u="slides" style="cursor: pointer;">
                            <div u="prototype" class="p" style="position: absolute; width: 107px; height: 72px; top: 0; left: 0;">
                                <div class=w><div u="thumbnailtemplate" style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></div></div>
                                <div class=c>
                                </div>
                            </div>
                        </div>
                        <!-- Thumbnail Item Skin End -->
                    </div>
                    <!-- Thumbnail Navigator Skin End -->
                </div>
                <div class="Hotel_Details_main3">
                    <div class="Hotel_Details_main4" style="height:305px;    overflow: hidden;">
                        <i>房间简介</i>
                        {$data.content}
                    </div>
                    <div class="Hotel_Details_main5">
                        <span>查看全部</span>
                    </div>
                </div>
            </div>
            <div class="Hotel_Details_a fl">
                <form id="bookform" action="{:U('Home/Order/bookroom')}" method="post">
                    <div class="Hotel_Details_b">
                        <span class="middle">
                            离住
                        </span>
                        <div class="pr middle">
                            <input type="text" class="J_date starttime" name="starttime" value="" />
                            <img src="__IMG__/Icon/img116.png" />
                        </div>
                        <span class="middle">
                            至
                        </span>
                        <div class="pr middle">
                            <input type="text" class="J_date endtime" name="endtime" value="" />
                            <img src="__IMG__/Icon/img116.png" />
                        </div>
                    </div>

                    <div id=''>
                        <div id='calendar'></div>
                        <div style='clear:both'></div>
                    </div>

                    <div class="Hotel_Details_c">
                        <div class="Hotel_Details_c2">
                            <i class="middle">入住人数 :</i>
                            <div class="Hotel_Details_c3 middle">
                                <span class="prev2 f18 mannum" onselectstart="return false;">+</span>
                                <i id="mannum">0</i>
                                <input type="hidden" name="mannum" value="0">
                                <span class="next2 f24 mannum" onselectstart="return false;">-</span>
                            </div>
                        </div>
                        <div class="Hotel_Details_c2">
                            <i class="middle">入住间数 :</i>
                            <div class="Hotel_Details_c3 middle">
                                <span class="prev2 f18 roomnum" onselectstart="return false;">+</span>
                                <i id="roomnum">0</i>
                                <input type="hidden" name="roomnum" value="0">
                                <span class="next2 f24 roomnum" onselectstart="return false;">-</span>
                            </div>
                        </div>
                    </div>
                    <div class="Hotel_Details_d">
                        <div>
                            <i class="f18 c333"> 价格 :</i>
                            <span><em id="totalmoney">{$data.money|default="0.00"}</em>元</span>
                        </div>
                        <input type="hidden" name="totalmoney" value="0.00">
                        <input type="hidden" name="rid" value="{$data.rid}">
                        <a href="javascript:;" id="book"> 
                            我要预订
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $("#book").click(function(){
                var starttime=$("input[name='starttime']").val();
                var endtime=$("input[name='endtime']").val();
                var mannum=$("input[name='mannum']").val();
                var roomnum=$("input[name='roomnum']").val();
                var totalmoney=$("input[name='totalmoney']").val();
                if(starttime==''){
                    alert("请选择入住起始时间");
                    return false;
                }else if(endtime==''){
                    alert("请选择入住结束时间");
                    return false;
                }else if(mannum==0){
                    alert("请选择入住人数");
                    return false;
                }else if(roomnum==0){
                    alert("请选择入住间数");
                    return false;
                }
                $("#bookform").submit();
            })
            $(".Legend_main3_center_list li").click(function () {
                $(this).addClass("Legend_chang").siblings().removeClass("Legend_chang");
                $(this).parents("ul").siblings().find("li").removeClass("Legend_chang");
            })
            $(".Inn_introduction_main3_center2_ul li").last().css({
                "border-right": "0"
            })

            $(".Hotel_Details_main5 span").click(function () {
                var $main7_span = $(this).html();
                if ($main7_span == "查看全部") {
                    $(this).html("收起");
                    $(".Hotel_Details_main4").css({"height":"auto","min-height":"305px"});
                }
                else if ($main7_span == "收起")
                {
                    $(this).html("查看全部");
                    $(".Hotel_Details_main4").css({"overflow":"hidden","height":"305px"});
                }
            })

            $(".Hotel_Details_c3 .prev2").click(function () {
                var i = $(this).siblings("i").html();
                i++;
                $(this).siblings("i").html(i);
                if($(this).hasClass("mannum")){
                    $("input[name='mannum']").val(i);
                }else if($(this).hasClass("roomnum")){
                    $("input[name='roomnum']").val(i);
                }
            })
            $(".Hotel_Details_c3 .next2").click(function () {
                var i = $(this).siblings("i").html();
                if (i<=1) {
                    alert("不能再小了。");
                } else {
                    i--;
                    $(this).siblings("i").html(i);
                    if($(this).hasClass("mannum")){
                        $("input[name='mannum']").val(i);
                    }else if($(this).hasClass("roomnum")){
                        $("input[name='roomnum']").val(i);
                    }
                }
            })
        })
    </script>


    <div class="wrap">
        <div class="Inn_introduction_main7 hidden">
            <div class="fl Inn_introduction_main7_1">
                <img src="__IMG__/img93.jpg" />
            </div>
            <div class="fl Inn_introduction_main7_2">
                <div>
                    <ul class="Inn_introduction_main7_2_ul Inn_introduction_main6_heigh Inn_introduction_main6_3"  style="height:200px">
                        <volist name="support" id="vo">
                            <li>
                                <img src="{$vo.gray_thumb}" /><span>{$vo.catname}</span>
                            </li>
                        </volist>
                    </ul>
                </div>
                <div class="Inn_introduction_main7_2_span">
                    <span>查看全部</span>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Inn_introduction_main7_2_span span").click(function () {
                var $main7_span = $(this).html();
                if ($main7_span == "查看全部") {
                    $(this).html("收起");
                    $(this).parents(".Inn_introduction_main7_2_span").siblings().find(".Inn_introduction_main6_3").css({"height":"auto","min-height":"200px"});
                }
                else if ($main7_span == "收起")
                {
                    $(this).html("查看全部");
                    $(this).parents(".Inn_introduction_main7_2_span").siblings().find(".Inn_introduction_main6_3").css("height",200);
                }
            })
        })
    </script>
    

    <div class="wrap">
        <div class="Hotel_Details_main7">
            <div class="Hotel_Details_main7_1">
                <span>便利设施</span>
                <i>{$data.conveniences}</i>
            </div>
            <div class="Hotel_Details_main7_1">
                <span>浴室</span>
                <i>{$data.bathroom}</i>
            </div>
            <div class="Hotel_Details_main7_1">
                <span>媒体科技</span>
                <i>{$data.media}</i>
            </div>
            <div class="Hotel_Details_main7_1">
                <span>食品饮食</span>
                <i>{$data.food}</i>
            </div>
        </div>
    </div>

    <div class="wrap">
        <div class="Inn_introduction_main10">
            <div class="Inn_introduction_main10_top hidden">
                <div class="fl Inn_introduction_main10_top_left">
                    <span>评论  <em>({$data.reviewnum|default="0"})</em></span>
                </div>
                <div class="fr Inn_introduction_main10_top_right">
                    <div class="Inn_Star_praise hidden">
                        <ul class="Inn_Star_praise_ul hidden middle">
                            {:getevaluation($data['evaluationpercent'])}
                        </ul>
                        <span class="middle"><em>{$data.evaluation|default="10.0"}</em>分</span>
                    </div>
                </div>
            </div>
            <div class="Inn_introduction_main10_botttom reviewlist" >
                
            </div>
            <script>
            $(function(){
                var rid="{$data.rid}";
                var geturl = "{:U('Home/Room/get_review')}";
                var p={"isAjax":1,"rid":rid};
                $.get(geturl,p,function(d){
                    $(".reviewlist").html(d.html);
                });
                $('.ajaxpagebar a').live("click",function(){
                    try{    
                        var geturl = $(this).attr('href');
                        var p={"isAjax":1,"rid":rid};
                        $.get(geturl,p,function(d){
                            $(".reviewlist").html(d.html);
                        });
                    }catch(e){};
                    return false;
                })
            })
            </script>
        </div>
    </div>
    <div class="wrap">
        <div class="Event_details7">
            <span>周边美宿推荐</span>
            <div class="Event_details8 hidden">
                <ul class="Event_details8_ul clearfix">
                    <volist name="data['house_near_hostel']" id="vo">
                        <li class="fl">
                            <div class="Event_details8_li">
                                <div class="Event_details8_list">
                                    <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}" class="Event_details8_a">
                                        <img src="{$vo.thumb}">
                                    </a>
                                    <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Event_details8_list_01 shoucang_hostel collect"<else /> class="Event_details8_list_01 shoucang_hostel"</eq>></div>
                                    <div class="Event_details8_list_02 pa">
                                        <i>￥</i>
                                        <span>{$vo.money|default="0.00"}</span>
                                        <label>起</label>
                                    </div>
                                    <div class="Event_details8_list_03 pa">
                                        <span>{$vo.evaluation|default="0"}</span><i>分</i>
                                    </div>
                                    <div class="Event_details8_list_04 pa">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            <img src="{$vo.head}">
                                        </a>
                                    </div>
                                </div>
                                <div class="Event_details8_list2">
                                    <span onclck="window.location.href='{:U('Home/Hostel/show',array('id'=>$vo['id']))}'">{:str_cut($vo['title'],10)}</span>
                                    <div class="hidden Event_details8_list2_01">
                                        <div class="fl Event_details8_list2_02">
                                            <img src="__IMG__/Icon/img10.png" />
                                            <i><em>{$vo.reviewnum|default="0"}</em>条点评</i>
                                        </div>
                                        <div class="fr Event_details8_list2_03 tr">
                                            <eq name="vo['ishit']" value="1">
                                                <img src="__IMG__/dianzan.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="{$vo.id}"/>
                                                <else />
                                                <img src="__IMG__/Icon/img9.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="{$vo.id}"/>
                                            </eq>
                                            <i class="zannum">{$vo.hit|default="0"}</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </volist>
                </ul>
            </div>
        </div>
        <div class="Event_details7">
            <span>周边活动推荐</span>
            <div class="Event_details8 hidden">
                <ul class="Event_details8_ul clearfix">
                    <volist name="data['house_near_activity']" id="vo">
                        <li class="fl">
                            <div class="Event_details8_li">
                                <div class="Event_details8_list">
                                    <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}" class="Event_details8_a">
                                        <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" />
                                    </a>
                                    <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Event_details8_list_01 shoucang_party collect"<else /> class="Event_details8_list_01 shoucang_party"</eq>></div>
                                    <div class="Event_details8_list_04 pa">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            <img src="{$vo.head}">
                                        </a>
                                    </div>
                                </div>
                                <div class="Event_details8_list3">
                                    <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],10)}</a>
                                    <div>
                                        <i class="c999 f14">
                                            时间 :<em class="f12 c666">{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em>
                                        </i>
                                    </div>
                                    <div>
                                        <i class="c999 f14">
                                            地点 :<em class="f12 c666">{$vo.address} </em>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </volist>
                </ul>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function () {
        $(".shoucang").live("click",function(){
            var obj=$(this);
            var uid='{$user.id}';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
              return false;
            }
            var rid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Room/ajax_collect')}",
                 data: {'rid':rid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                obj.attr("src","/Public/Home/images/Icon/img25.png");
                              }else if(data.type==2){
                                obj.attr("src","/Public/Home/images/shoucang.png");
                              }
                            }else if(data.status==0){
                              alert("收藏失败！");
                            }
                          }
              });
          });
        $(".zanbg1_hostel").live("click",function(){
            var obj=$(this);
            var uid='{$user.id}';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
              return false;
            }
            var hitnum=$(this).siblings(".zannum");
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_hit')}",
                 data: {'hid':hid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                var num=Number(hitnum.text()) + 1;
                                hitnum.text(num);
                                obj.attr("src","/Public/Home/images/dianzan.png");
                              }else if(data.type==2){
                                var num=Number(hitnum.text()) - 1;
                                hitnum.text(num);
                                obj.attr("src","/Public/Home/images/Icon/img9.png");
                              }
                            }else if(data.status==0){
                              alert("点赞失败！");
                            }
                          }
              });
          });
        $(".shoucang_party").live("click",function(){
            var obj=$(this);
            var uid='{$user.id}';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
              return false;
            }
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Party/ajax_collect')}",
                 data: {'aid':aid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                obj.addClass("collect");
                              }else if(data.type==2){
                                obj.removeClass("collect");
                              }
                            }else if(data.status==0){
                              alert("收藏失败！");
                            }
                          }
              });
          });
        $(".shoucang_hostel").live("click",function(){
            var obj=$(this);
            var uid='{$user.id}';
            if(!uid){
              alert("请先登录！");
                var p={};
                p['url']="__SELF__";
                $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                    if(data.code=200){
                        window.location.href="{:U('Home/Member/login')}";
                    }
                })
              return false;
            }
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_collect')}",
                 data: {'hid':hid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                obj.addClass("collect");
                              }else if(data.type==2){
                                obj.removeClass("collect");
                              }
                            }else if(data.status==0){
                              alert("收藏失败！");
                            }
                          }
              });
          });
    });
</script>
<include file="public:foot" />