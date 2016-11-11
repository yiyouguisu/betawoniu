<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script src="__JS__/jssor.js"></script>
<script src="__JS__/jssor.slider.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?key=&v=1.1&services=true"></script>
<script>
        $(function(){
            var dateInput = $("input.J_date")
            if (dateInput.length) {
                Wind.use('datePicker', function () {
                    dateInput.datePicker();
                });
            }
        })
    </script>
<include file="public:mheader" />
<div class="wrap">
        <div class="Legend_main3">
            <div class="Legend_main3_top">
                <a href="/">首页</a>
                <i>></i>
                <a href="{:U('Home/Hostel/index')}">美宿</a>
                <i>></i>
                <a href="{:U('Home/Hostel/show',array('id'=>$data['id']))}">{$data.title}</a>
            </div>
            <div class="Inn_introduction_main">
                <div class="Inn_introduction_main_top hidden">
                    <span>{$data.title}</span>
                    <i><em>{$data.money|default="0.00"}</em>元起</i>
                </div>
                <div class="hidden Inn_introduction_main_bottom">
                    <div class="middle Inn_introduction_main_bottom2">
                        <div class="Inn_introduction_main_bottom2_1 hidden">
                            <img src="__IMG__/Icon/img44.png" />
                            <span>客栈地址 : <em>{:getarea($data['area'])}{$data.address}</em></span>
                            <a href="#Inn_Four">查看地图</a>
                        </div>
                        <div class="center hidden">
                            <ul class="center_ul hidden middle">
                                {:getevaluation($data['evaluationpercent'])}
                            </ul>
                            <span class="middle"><em>{$data.evaluation|default="0.0"}</em>分</span>
                            <div class="center_ul_list middle">
                                <img src="__IMG__/Icon/img10.png" /><i><em>{$data.reviewnum|default="0"}</em>条评论</i>
                            </div>
                            <div class="middle Event_details8_list2_03 ">
                                <eq name="data['ishit']" value="1">
                                    <img src="__IMG__/dianzan.png" class="zanbg1" data-id="{$data.id}"/>
                                    <else />
                                    <img src="__IMG__/Icon/img9.png" class="zanbg1" data-id="{$data.id}"/>
                                </eq>
                                <i class="zannum">{$data.hit|default="0"}</i>
                            </div>
                        </div>
                    </div>
                    <div class="middle Inn_introduction_main_bottom3">
                        <a href="" class="a1"><img src="__IMG__/Icon/img24.png" /></a>
                        <a href="javascript:;" class="a2">
                            <eq name="data['iscollect']" value="1">
                                <img src="__IMG__/Icon/img25.png" class="shoucang" data-id="{$data.id}"/>
                                <else />
                                <img src="__IMG__/shoucang.png"  class="shoucang" data-id="{$data.id}"/>
                            </eq>
                            收藏
                        </a>
                        <a href="javascript:;" class="a3 travels2_bottom3"><img src="__IMG__/Icon/img26.png" />添加到行程</a>
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
                $SlideDuration: 800,                                //Specifies default duration (swipe) for slide in milliseconds

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
    <div class="wrap">
        <div class="Inn_introduction_main2">
            <div id="slider1_container" style="vertical-align:top; display:inline-block; *display:inline; *zoom:1; position: relative; top: 0px; left: 0px; width: 800px;
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
                <div u="slides" style="cursor: pointer; position: absolute; left: 0px; top: 0px; width: 800px; height: 456px; overflow: hidden;">
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
                <div u="thumbnavigator" class="jssort01" style="position: absolute; width: 800px; height: 100px; left:0px; bottom: 0px;">
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

            <div class="Inn_introduction_main3">
                <div class="Inn_introduction_main3_top">
                    <a href="{:U('Home/Member/detail',array('uid'=>$data['uid']))}">
                        <div>
                            <img src="{$data.head}" />
                        </div>
                        {$data.nickname}
                    </a>
                </div>
                <div class="Inn_introduction_main3_center">
                    <span>
                        <eq name="data['realname_status']" value="1">
                            <img src="__IMG__/Icon/img27.png" />
                            <else />
                            <img src="__IMG__/Icon/img27_1.png" />
                        </eq>
                        实名认证
                    </span>
                    <span>
                        <eq name="data['houseowner_status']" value="1">
                            <img src="__IMG__/Icon/img28.png" />
                            <else />
                            <img src="__IMG__/Icon/img28_1.png" />
                        </eq>
                        个人房东
                    </span>
                </div>
                <div class="Inn_introduction_main3_center2">
                    <ul class="Inn_introduction_main3_center2_ul hidden">
                        <li>
                            <span>{$data['onlinereply']}%</span>
                            <i>在线回复率</i>
                        </li>
                        <li>
                            <span>{$data['evaluationconfirm']}分钟</span>
                            <i>审核确认时间</i>
                        </li>
                        <li>
                            <span>{$data['orderconfirm']}%</span>
                            <i>订单接受率</i>
                        </li>
                    </ul>
                </div>

                <div class="Inn_introduction_main3_bottom">
                    <!-- <a href="" class="a1">预订房间</a> -->
                    <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['uid'],'type'=>'hostel'))}" class="a2">在线咨询房东</a>
                </div>


            </div>
        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            $(".Legend_main3_center_list li").click(function () {
                $(this).addClass("Legend_chang").siblings().removeClass("Legend_chang");
                $(this).parents("ul").siblings().find("li").removeClass("Legend_chang");
            })
            $(".Inn_introduction_main3_center2_ul li").last().css({
                "border-right": "0"
            })
        })
    </script>

    <div class="Inn_introduction_main4">
        <div class="Inn_introduction_main4_01">
            <span>我们发布的活动</span>
        </div>
        <div class="main2_bottom">
            <div class="picScroll-left2">
                <div class="bd">
                    <ul class="picList">
                        <volist name="data['house_owner_activity']" id="vo">
                            <li style="max-width:290px">
                                <div class="pic">
                                    <div class="pr">
                                        <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}" class="show_img"><img src="{$vo.thumb}" style="width:298px;height:191px" /></a>
                                        <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Event_details8_list_01 shoucang_party collect"<else /> class="Event_details8_list_01 shoucang_party"</eq>></div>
                                        <div class="Inn_introduction_main4_02 pa">
                                            <a href="{:U('Home/Member/detail',array('id'=>$v['id']))}" class="middle">
                                                <img src="{$vo.head}" width="30px" height="30px" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="Inn_introduction_main4_03">
                                        <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],10)}</a>
                                        <i class="f14 c999">时间 :<em class="f12 c666">{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em></i>
                                        <i class="f14 c999">地点 :<em class="f14 c666">{$vo.address}</em></i>
                                    </div>
                                </div>
                            </li>
                        </volist>
                    </ul>
                </div>
                <div class="hd">
                    <ul></ul>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        jQuery(".picScroll-left2").slide({
            titCell: ".hd ul",
            mainCell: ".bd ul",
            autoPage: true,
            effect: "leftLoop",
            vis: 4,
            trigger: "click"
        });
    </script>


    <div class="wrap">
        <div class="Inn_introduction_main5">
            <div class="Inn_introduction_main5_tab">
                <ul class="Inn_introduction_main5_tab_ul clearfix">
                    <li><a href="#Inn_one">房间选择</a></li>
                    <li><a href="#Inn_two">美宿描述</a></li>
                    <li><a href="#Inn_Six">评论</a></li>
                    <li><a href="#Inn_Four">交通地图</a></li>
                    <li><a href="#Inn_Three">配套设施</a></li>
                    <li><a href="#Inn_Five">退订规则</a></li>
                    <li><a href="#Inn_Seven">周边美宿</a></li>
                </ul>
            </div>
            <div  name="Inn_one" id="Inn_one">
                 <div class="Inn_introduction_main5_01">
                    <ul class="Release_of_legend_m3t_ul" id="roominfo">
                        <include file="Hostel:room" />
                    </ul>
                    <div class="Inn_introduction_main5_02 getroom">
                         <a href="javascript:;" id="getroom">
                             点击查看全部房间  <em>({$data.roomnum|default="0"})</em>  <img src="__IMG__/Icon/img91.png" />
                         </a>
                    </div>
                 </div>
                 
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var page=2;
        $(function () {
            $("#getroom").click(function(){
                var hid="{$data.id}";
                var posturl = "{:U('Home/Hostel/ajax_getroom')}";
                var p={ "p":page,"num":2,"hid":hid};
                $.post(posturl,p,function(d){
                    if(d.status==1){
                        $("#roominfo").append(d.html);
                        page++;
                    }else{
                        $(".getroom").hide();
                    }
                    
                });
            })
            
            $(".Release_of_legend_m3t_ul>li:last-child").css({
                "border-bottom": "0"
            })
            var $ml = $(".Inn_introduction_main5_tab_ul>li");
            $ml.click(function () {
                $(this).addClass('Inn_introduction_main5_tab_list').siblings().removeClass('Inn_introduction_main5_tab_list');
            });
        })
        
    </script>


    <div class="wrap">
        <div class="Inn_introduction_main6 hidden" name="Inn_two" id="Inn_two">
            <div class="fl Inn_introduction_main6_1">
                <img src="__IMG__/img92.jpg" />
            </div>
            <div class="fl Inn_introduction_main6_2">
                <div>
                    <div class="Inn_introduction_main6_3 Inn_introduction_main6_heigh" style="height:200px">
                        {$data.description}
                    </div>
                </div>
                <div class="Inn_introduction_main7_2_span">
                    <span>查看全部</span>
                </div>
            </div>
        </div>
    </div>
    <div class="wrap">
        <div class="Inn_introduction_main7 hidden" name="Inn_Three" id="Inn_Three">
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
        <div class="Inn_introduction_main8" name="Inn_Four" id="Inn_Four">
            <div style="height:411px;border:#ccc solid 1px;" id="dituContent"></div>
        </div>
    </div>
    <script type="text/javascript">
        //创建和初始化地图函数：
        function initMap() {
            createMap();//创建地图
            setMapEvent();//设置地图事件
            addMapControl();//向地图添加控件
            addMarker();//向地图中添加marker
        }

        //创建地图函数：
        function createMap() {
            var map = new BMap.Map("dituContent");//在百度地图容器中创建一个地图
            var point = new BMap.Point(121.419727, 31.264583);//定义一个中心点坐标
            map.centerAndZoom(point, 13);//设定地图的中心点和坐标并将地图显示在地图容器中
            window.map = map;//将map变量存储在全局
        }

        //地图事件设置函数：
        function setMapEvent() {
            map.enableDragging();//启用地图拖拽事件，默认启用(可不写)
            map.enableScrollWheelZoom();//启用地图滚轮放大缩小
            map.enableDoubleClickZoom();//启用鼠标双击放大，默认启用(可不写)
            map.enableKeyboard();//启用键盘上下左右键移动地图
        }

        //地图控件添加函数：
        function addMapControl() {
            //向地图中添加缩放控件
            var ctrl_nav = new BMap.NavigationControl({ anchor: BMAP_ANCHOR_TOP_LEFT, type: BMAP_NAVIGATION_CONTROL_LARGE });
            map.addControl(ctrl_nav);
            //向地图中添加缩略图控件
            var ctrl_ove = new BMap.OverviewMapControl({ anchor: BMAP_ANCHOR_BOTTOM_RIGHT, isOpen: 1 });
            map.addControl(ctrl_ove);
            //向地图中添加比例尺控件
            var ctrl_sca = new BMap.ScaleControl({ anchor: BMAP_ANCHOR_BOTTOM_LEFT });
            map.addControl(ctrl_sca);
        }

        //标注点数组
        var markerArr = [{ title: "{$data.title}", content: "欢迎光临(●'◡'●)", point: "{$data.lng}|{$data.lat}", isOpen: 1, icon: { w: 23, h: 25, l: 92, t: 21, x: 9, lb: 12 } }
        ];
        //创建marker
        function addMarker() {
            for (var i = 0; i < markerArr.length; i++) {
                var json = markerArr[i];
                var p0 = json.point.split("|")[0];
                var p1 = json.point.split("|")[1];
                var point = new BMap.Point(p0, p1);
                var iconImg = createIcon(json.icon);
                var marker = new BMap.Marker(point, { icon: iconImg });
                var iw = createInfoWindow(i);
                var label = new BMap.Label(json.title, { "offset": new BMap.Size(json.icon.lb - json.icon.x + 10, -20) });
                marker.setLabel(label);
                map.addOverlay(marker);
                label.setStyle({
                    borderColor: "#808080",
                    color: "#333",
                    cursor: "pointer"
                });

                (function () {
                    var index = i;
                    var _iw = createInfoWindow(i);
                    var _marker = marker;
                    _marker.addEventListener("click", function () {
                        this.openInfoWindow(_iw);
                    });
                    _iw.addEventListener("open", function () {
                        _marker.getLabel().hide();
                    })
                    _iw.addEventListener("close", function () {
                        _marker.getLabel().show();
                    })
                    label.addEventListener("click", function () {
                        _marker.openInfoWindow(_iw);
                    })
                    if (!!json.isOpen) {
                        label.hide();
                        _marker.openInfoWindow(_iw);
                    }
                })()
            }
        }
        //创建InfoWindow
        function createInfoWindow(i) {
            var json = markerArr[i];
            var iw = new BMap.InfoWindow("<b class='iw_poi_title' title='" + json.title + "'>" + json.title + "</b><div class='iw_poi_content'>" + json.content + "</div>");
            return iw;
        }
        //创建一个Icon
        function createIcon(json) {
            var icon = new BMap.Icon("http://app.baidu.com/map/images/us_mk_icon.png", new BMap.Size(json.w, json.h), { imageOffset: new BMap.Size(-json.l, -json.t), infoWindowOffset: new BMap.Size(json.lb + 5, 1), offset: new BMap.Size(json.x, json.h) })
            return icon;
        }

        initMap();//创建和初始化地图
    </script>
    <div class="wrap">
        <div class="Inn_introduction_main6 hidden" name="Inn_Five" id="Inn_Five">
            <div class="fl Inn_introduction_main6_1">
                <img src="__IMG__/img94.jpg" />
            </div>
            <div class="fl Inn_introduction_main6_2">
                <div>
                    <div class="Inn_introduction_main9 Inn_introduction_main6_heigh Inn_introduction_main6_3"   style="height:200px">
                    {$data.content}
                    </div>
                </div>
                <div class="Inn_introduction_main7_2_span">
                    <span>查看全部</span>
                </div>
            </div>
        </div>
    </div>

    <div class="wrap">
        <div class="Inn_introduction_main10" name="Inn_Six" id="Inn_Six">
            <div class="Inn_introduction_main10_top hidden">
                <div class="fl Inn_introduction_main10_top_left">
                    <span>评论  <em>({$data.reviewnum|default="0"})</em></span>
                </div>
                <div class="fr Inn_introduction_main10_top_right">
                    <div class="Inn_Star_praise hidden">
                        <ul class="Inn_Star_praise_ul hidden middle">
                            {:getevaluation($data['evaluationpercent'])}
                        </ul>
                        <span class="middle"><em>{$data.evaluation|default="0.0"}</em>分</span>
                    </div>
                </div>
            </div>
            <div class="Inn_introduction_main10_botttom reviewlist" >
                
            </div>
            <script>
                $(function(){
                    var hid="{$data.id}";
                    var geturl = "{:U('Home/Hostel/get_review')}";
                    var p={"isAjax":1,"hid":hid};
                    $.get(geturl,p,function(d){
                        $(".reviewlist").html(d.html);
                    });
                    $('.ajaxpagebar a').live("click",function(){
                        try{    
                            var geturl = $(this).attr('href');
                            var p={"isAjax":1,"hid":hid};
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
        <div class="Event_details7" name="Inn_Seven" id="Inn_Seven">
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
    <div class="Mask3 hide">
        
    </div>
    <div class="travels2_a hide">
        <div class="travels2_a_top pr">
            <span class="f22 c666">
                编辑行程时间
            </span>
            <i class="travels2_a_top2">
                <img src="__IMG__/Icon/img107.png" />
            </i>
        </div>
        <div class="travels2_a_bottom">
            <div class="travels2_a_bottom2">
                <span>行程标题 :</span>
                <input type="text" id="trip_title" />
            </div>
            <div class="travels2_a_bottom3 hidden">
                <div class="travels2_a_bottom4 fl">
                    <span>出发时间 :</span>
                    <input value="{:date('Y-m-d')}" type="text" class="J_date" id="trip_starttime" />
                </div>
                <div class="fr travels2_a_bottom5">
                    <span class="middle">出发天数 :</span>
                    <div class="travels2_a_bottom6 middle hidden">
                        <input type="text" value="1" id="trip_days"/>
                        <i>天</i>
                    </div>
                </div>
            </div>
            <div class="travels2_a2">
                <input type="button" class="addtrip" data-varname="" value="提交" />
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function () {
        $(".Mask3").height($(window).height());
        $(".travels2_bottom3").click(function () {
            var uid="{$user.id}";
            if(uid==''){
                alert("请先登录！");var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                return false;
            }
            if(uid=="{$data.uid}"){
                alert("不能选择自己发布的美宿");
                return false;
            }
            var home_iscachetrip=$.cookie("home_iscachetrip");
            var hid="";
            if(home_iscachetrip){
                var p={};
                p['hid']="{$data.id}";
                $.post("{:U('Home/Trip/ajax_cachetripinfo')}",p,function(data){
                    if(data.code=200){
                        var home_cachetripdo= $.cookie("home_cachetripdo");
                        if(home_cachetripdo=='edit'){
                            window.location.href="{:U('Home/Trip/edit')}";
                        }else if(home_cachetripdo=='add'){
                            window.location.href="{:U('Home/Trip/add')}";
                        }
                    }else{
                        alert("提交失败");
                    }
                })
            }else{
                $(".Mask3").show();
                $(".travels2_a").show();
            }
            
        })
        $(".Mask3,.travels2_a_top2").click(function () {
            $(".Mask3").hide();
            $(".travels2_a").hide();
        })
        $(".addtrip").click(function(){
            var p={};
            var trip_title=$("#trip_title").val();
            if(trip_title==''){
                alert("请填写行程标题！");
                return false;
            }
            var trip_starttime=$("#trip_starttime").val();
            if(trip_starttime==''){
                alert("请选择行程开始时间！");
                return false;
            }
            var trip_days=$("#trip_days").val();
            if(trip_days==''||Number(trip_days)<=0){
                alert("请填写正确行程天数！");
                return false;
            }
            p['hid']="{$data.id}";
            p['title']=trip_title;
            p['starttime']=trip_starttime;
            p['days']=trip_days;
            $.post("{:U('Home/Trip/ajax_cachetripinfo')}",p,function(data){
                if(data.code=200){
                    $(".Mask3").hide();
                    $(".travels2_a").hide();
                    window.location.href="{:U('Home/Trip/add')}";
                }else{
                    alert("提交失败");
                }
            })
            
        })
        $(".zanbg1").live("click",function(){
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
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Party/ajax_hit')}",
                 data: {'aid':aid},
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
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_collect')}",
                 data: {'hid':hid},
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