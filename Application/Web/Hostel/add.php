<include file="public:head" />
<include file="public:upload" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <script src="__JS__/WdatePicker.js"></script>
    <script src="__JS__/work.js"></script>
        <script type="text/javascript" charset="utf-8" src="__Editor__/UEditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="__Editor__/UEditor/ueditor.all.min.js"></script>
<script type="text/javascript" charset="utf-8" src="__Editor__/UEditor/lang/zh-cn/zh-cn.js"></script>
<script>
    $(function(){
        var url="{:U('Home/Ueditor/index')}";
        var ue = UE.getEditor('content',{
            serverUrl :url,
            UEDITOR_HOME_URL:'__Editor__/UEditor/',
        });
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
                            var days=DateDiff(starttime,endtime);
                            console.log(days)
                            $("#days").val(Number(days));
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
<style>
  .chosen-container{
    width: 150px;
      margin-right: 23px;
  }
</style>
<script type="text/javascript">
                var areaurl = "{:U('Home/Party/getchildren')}";
                function load(parentid, type) {
                    $.ajax({
                        type: "GET",
                        url: areaurl,
                        data: { 'parentid': parentid },
                        dataType: "json",
                        success: function (data) {
                            if (type == 'city') {
                                $('#city').html('<option value="">选择市</option>');
                                $('#town').html('<option value="">选择区</option>');
                                if(data!=null){
                                    $.each(data, function (no, items) {
                                        if (items.id == "{$_GET['city']}") {
                                            $('#city').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                                        } else {
                                            $('#city').append('<option value="' + items.id + '">' + items.name + '</option>');
                                        }
                                    });
                                }
                                $('#city').trigger("chosen:updated");
                                $('#town').trigger("chosen:updated");
                            } else if (type == 'town') {
                                $('#town').html('<option value="">选择区</option>');
                                if(data!=null){
                                    $.each(data, function (no, items) {
                                        if (items.id == "{$_GET['town']}") {
                                            $('#town').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                                        } else {
                                            $('#town').append('<option value="' + items.id + '">' + items.name + '</option>');
                                        }
                                    });
                                }
                                
                                $('#town').trigger("chosen:updated");
                            }
                            
                            
                        }
                    });
                }
            </script>
    <script>
        $(function () {
            $("#slider-range").slider({
                range: true,
                min: 0,
                max: 500,
                values: [75, 300],
                slide: function (event, ui) {
                    $("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
                }
            });
            $("#amount").val("$" + $("#slider-range").slider("values", 0) +
              " - $" + $("#slider-range").slider("values", 1));
        });
    </script>
<include file="public:mheader" />
<div class="wrap">
        <div class="Legend_main3">
            <div class="Legend_main3_top">
                <a href="">首页</a>
                <i>></i>
                <a href="">名宿</a>
                <i>></i>
                <a href="">发布民宿</a>
            </div>
            <div class="Release_of_legend_temporary">
                <div class="activity2_main">
                    <span>上传名宿缩略图</span>
                    <i>图片建议选择尺寸400像素 X 250像素 的图片</i>
                    <ul class="hidden activity2_main_ul">
                        <li class="fl">
                            <a href="">
                                <img src="__IMG__/img41.jpg" />
                            </a>
                        </li>
                        <li class="fl">
                            <img src="__IMG__/img42.jpg" />
                        </li>
                    </ul>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">民宿名称 :</span>
                    <input class="middle text4" style="width:670px;" type="text" />
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">民宿地址 : </span>
                    <div class="middle activity2_main2_text3">
                        <select class="sc-wd chosen-select-no-single">
                            <option>主题</option>
                            <option value="花前月下">花前月下</option>
                            <option value="闭月羞花">闭月羞花</option>
                            <option value="花前月下">花前月下</option>
                            <option value="闭月羞花">闭月羞花</option>
                        </select>
                    </div>
                    <div class="middle activity2_main2_text3">
                        <select class="sc-wd chosen-select-no-single">
                            <option>亲子类</option>
                            <option value="亲子类">亲子类</option>
                            <option value="情侣类">情侣类</option>
                            <option value="亲子类">亲子类</option>
                            <option value="情侣类">情侣类</option>
                        </select>
                    </div>
                    <input type="text" class="activity2_main2_text5 middle" />
                </div>
                <div style="margin-bottom:20px;"></div>
                <div class="activity2_main">
                    <span>上传民宿展示图</span>
                    <i>图片建议选择尺寸730像素 X 415像素 的图片 (建议上传7张以上)</i>
                    <ul class="hidden activity2_main_ul">
                        <li class="fl">
                            <a href="">
                                <img src="__IMG__/img41.jpg" />
                            </a>
                        </li>
                        <li class="fl">
                            <img src="__IMG__/img42.jpg" />
                        </li>
                    </ul>
                </div>
                <div style="border-bottom:1px solid #e3e3e3;"></div>
                <div class="Release_of_legend_main2">
                    <span>民宿描述 : </span>
                    <textarea></textarea>
                </div>
                <div class="Release_of_legend_main3">
                    <div class="Release_of_legend_main3_top">
                        <span>添加房间 : </span>
                    </div>
                    <div class="Release_of_legend_main3_bottom">
                        <ul class="Release_of_legend_m3t_ul">
                            <li>
                                <div class="hidden Release_of_legend_m3t_list">
                                    <div class="fl Release_of_legend_m3t_list2">
                                        <a href="">
                                            <img src="__IMG__/img74.jpg" />
                                        </a>
                                    </div>
                                    <div class="fl Release_of_legend_m3t_list3">
                                        <div class="top">
                                            <a href="">蓝色妖姬景点主题套房</a>
                                        </div>
                                        <div class="center hidden">
                                            <ul class="center_ul hidden middle">
                                                <li><img src="__IMG__/Icon/img42.png" /></li>
                                                <li><img src="__IMG__/Icon/img42.png" /></li>
                                                <li><img src="__IMG__/Icon/img42.png" /></li>
                                                <li><img src="__IMG__/Icon/img42.png" /></li>
                                                <li><img src="__IMG__/Icon/img43.png" /></li>
                                            </ul>
                                            <span class="middle"><em>8.8</em>分</span>
                                            <div class="center_ul_list middle">
                                                <img src="__IMG__/Icon/img10.png" /><i><em>188</em>条评论</i>
                                            </div>
                                        </div>
                                        <div class="center2">
                                            <span>房间面积：<em>56m2 </em></span>
                                            <span>床型信息：<em>大床（1张）</em></span>
                                            <span>最多入住：<em>3人</em></span>
                                        </div>
                                        <div class="bottom">
                                            <i><img src="__IMG__/images/bingxiang_red.png" /><em>独立卫浴</em></i>
                                            <i><img src="__IMG__/images/wifi_red.png" /><em>wifi</em></i>
                                            <i><img src="__IMG__/images/xiyi_red.png" /><em>衣服</em></i>
                                        </div>
                                    </div>
                                    <div class="fr Release_of_legend_m3t_list4">
                                        <i><em>580</em>元起</i>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="hidden Release_of_legend_m3t_list">
                                    <div class="fl Release_of_legend_m3t_list2">
                                        <a href="">
                                            <img src="__IMG__/img74.jpg" />
                                        </a>
                                    </div>
                                    <div class="fl Release_of_legend_m3t_list3">
                                        <div class="top">
                                            <a href="">蓝色妖姬景点主题套房</a>
                                        </div>
                                        <div class="center hidden">
                                            <ul class="center_ul hidden middle">
                                                <li><img src="__IMG__/Icon/img42.png" /></li>
                                                <li><img src="__IMG__/Icon/img42.png" /></li>
                                                <li><img src="__IMG__/Icon/img42.png" /></li>
                                                <li><img src="__IMG__/Icon/img42.png" /></li>
                                                <li><img src="__IMG__/Icon/img43.png" /></li>
                                            </ul>
                                            <span class="middle"><em>8.8</em>分</span>
                                            <div class="center_ul_list middle">
                                                <img src="__IMG__/Icon/img10.png" /><i><em>188</em>条评论</i>
                                            </div>
                                        </div>
                                        <div class="center2">
                                            <span>房间面积：<em>56m2 </em></span>
                                            <span>床型信息：<em>大床（1张）</em></span>
                                            <span>最多入住：<em>3人</em></span>
                                        </div>
                                        <div class="bottom">
                                            <i><img src="__IMG__/images/bingxiang_red.png" /><em>独立卫浴</em></i>
                                            <i><img src="__IMG__/images/wifi_red.png" /><em>wifi</em></i>
                                            <i><img src="__IMG__/images/xiyi_red.png" /><em>衣服</em></i>
                                        </div>
                                    </div>
                                    <div class="fr Release_of_legend_m3t_list4">
                                        <i><em>580</em>元起</i>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Release_of_legend_m3t_ul li").last().css({
                "border-bottom":"0"
            });
            $(".Legend_main3_center_list li").click(function () {
                $(this).addClass("Legend_chang").siblings().removeClass("Legend_chang");
                $(this).parents("ul").siblings().find("li").removeClass("Legend_chang");
            })
            $(".Legend_main3_center_label").click(function () {
                var $labale = $(this).html();
                if ($labale == "更多") {
                    $(this).html("收起");
                    $(".Legend_main3_ul2").show();
                } else {
                    $(this).html("更多");
                    $(".Legend_main3_ul2").hide();
                }
            })
            $(".chosen-select-no-single").chosen();
            $(".Legend_main3_center_list").last().css({
                "border-bottom":"0px"
            })
        })
    </script>
    <div class="wrap">
        <div class="Release_of_legend_m4">
            <div class="Release_of_legend_m4_top">
                <span>添加房间：</span>
            </div>
            <div class="activity2_main">
                <span>上传活动缩略图</span>
                <i>图片建议选择尺寸400像素 X 250像素 的图片</i>
                <ul class="hidden activity2_main_ul">
                    <li class="fl">
                        <a href="">
                            <img src="__IMG__/img41.jpg" />
                        </a>
                    </li>
                    <li class="fl">
                        <img src="__IMG__/img42.jpg" />
                    </li>
                </ul>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">房间名称 : </span>
                <input class="middle text4" style="width:670px;" type="text" />
            </div>
            <div class="activity2_main2_01">
                <span class="middle">房间费用 : </span>
                <div class="middle activity2_main2_text2">
                    <input type="text" value="500" />
                    <i>元/人</i>
                </div>
                <span class="middle">房间面积 : </span>
                <div class="middle activity2_main2_text2">
                    <input type="text" value="60" />
                    <i>m2</i>
                </div>
                <span class="middle">床型 : </span>
                <div class="middle activity2_main2_text3">
                    <select class="sc-wd chosen-select-no-single">
                        <option>大型床</option>
                        <option value="亲子类">亲子类</option>
                        <option value="情侣类">情侣类</option>
                        <option value="亲子类">亲子类</option>
                        <option value="情侣类">情侣类</option>
                    </select>
                </div>
            </div>
            <div style="margin-bottom:25px;"></div>
            <div class="activity2_main">
                <span>上传房间展示图</span>
                <i>图片建议选择尺寸730像素 X 415像素 的图片 (建议上传7张以上)</i>
                <ul class="hidden activity2_main_ul">
                    <li class="fl">
                        <a href="">
                            <img src="__IMG__/img41.jpg" />
                        </a>
                    </li>
                    <li class="fl">
                        <img src="__IMG__/img42.jpg" />
                    </li>
                </ul>
            </div>
            <div class="Release_of_legend_m4_list">
                <span>房间简介 : </span>
                <textarea></textarea>
            </div>

            <div class="Release_of_legend_m4_list2">
                <div class="Release_of_legend_m4_list3">
                    <span>配套设施 : </span>
                    <i>( 可多选 )</i>
                    <label>其中 “ 特”为 重点推荐的配套设施，勾选后可重点在房间列表展示，最多可以选择三个</label>
                </div>
                <div class="Release_of_legend_m4_list4 hidden">
                    <ul class="Release_of_legend_m4_ul hidden">
                        <li class="">
                            <div class="Release_of_legend_a1 Release_of_legend_m4_span fl">
                                <span>无线网络</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a2 fl">
                                <span>洗衣服务</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a3 fl">
                                <span>停车场</span>
                            </div>
                            <i class="Release_of_legend_a1_i2 fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a4 fl">
                                <span>厨房</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a5 fl">
                                <span>洗衣机</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a6 fl">
                                <span>自行车租赁</span>
                            </div>
                            <i class="Release_of_legend_a1_i2 fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a7 fl">
                                <span>接机接站</span>
                            </div>
                            <i class="Release_of_legend_a1_i2 fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a8 fl">
                                <span>冰箱</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a9 fl">
                                <span>游泳池</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a10 fl">
                                <span>24小时热水</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a11 fl">
                                <span>可携带宠物</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a12 fl">
                                <span>空调暖气</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a13 fl">
                                <span>可烧烤</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a14 fl">
                                <span>健身房</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                        <li>
                            <div class="Release_of_legend_a15 fl">
                                <span>免费长途电话</span>
                            </div>
                            <i class="Release_of_legend_a1_i fl">特</i>
                        </li>
                    </ul>
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>便利设施 : </span>
                    <input type="text" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>浴室 : </span>
                    <input type="text" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>媒体科技 : </span>
                    <input type="text" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>食品饮食 : </span>
                    <input type="text" />
                </div>
                <div class="Release_of_legend_m4_bottom2">
                    <input class="Release_of_legend_m4_sub" type="submit" value="发布房间" />
                    <input class="Release_of_legend_m4_reset" type="reset" value="重置" />
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Release_of_legend_m4_ul div").click(function () {
                $(this).toggleClass("Release_of_legend_m4_span")
            })
        })
    </script>
    <div class="wrap">
        <div class="Release_of_legend_m5">
            <span>退订规则 : </span>
            <textarea></textarea>
            <input type="submit" value="发布民宿" />
        </div>
    </div>
<include file="public:foot" />