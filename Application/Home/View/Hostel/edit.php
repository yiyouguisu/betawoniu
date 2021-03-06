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

<style>
  .chosen-container{
    width: 150px;
      margin-right: 23px;
  }
  .delimglist{
    cursor: pointer;
    position: absolute;right: 0px;top: 0px;width: 40px;height: 23px;line-height: 23px; color: #000;font-size: 15px;text-align: center;opacity: 0.5;
  }
</style>
<script type="text/javascript">
    $(function(){
        var url="{:U('Home/Ueditor/index')}";
        UE.getEditor('content',{
            serverUrl :url,
            UEDITOR_HOME_URL:'__Editor__/UEditor/',
        });
        UE.getEditor('roomcontent',{
            serverUrl :url,
            UEDITOR_HOME_URL:'__Editor__/UEditor/',
        });
        UE.getEditor('description',{
            serverUrl :url,
            UEDITOR_HOME_URL:'__Editor__/UEditor/',
        });
        // UE.getEditor('bookremark',{
        //     serverUrl :url,
        //     UEDITOR_HOME_URL:'__Editor__/UEditor/',
        // });
        var province='{$data.province}';
        var city='{$data.city}';
        if(province!=''){
          load(province,'city');
        }
        if(city!=''){
          load(city,'town');
        }
    })
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
                            if (items.id == "{$data['city']}") {
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
                            if (items.id == "{$data['town']}") {
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
<include file="public:mheader" />
<form action="{:U('Home/Hostel/edit')}" method="post">
    <div class="wrap">
        <div class="Legend_main3">
            <div class="Legend_main3_top">
                <a href="/">首页</a>
                <i>></i>
                <a href="{:U('Home/Hostel/index')}">美宿</a>
                <i>></i>
                <a href="{:U('Home/Hostel/edit',array('id'=>$data['id']))}">修改美宿</a>
            </div>
            <div class="Release_of_legend_temporary">
                <div class="activity2_main">
                    <span>上传美宿缩略图</span>
                    <i>图片建议选择尺寸400像素 X 250像素 的图片</i>
                    <ul class="hidden activity2_main_ul">
                        <li class="fl">
                           <a href="javascript:;">
                               <input type="button" value="选择上传" id="uploadify">
                           </a>
                       </li>
                       <li class="fl thumb">
                           <img src="{$data.thumb}"/>
                       </li>
                    </ul>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">美宿名称 :</span>
                    <input class="middle text4" style="width:670px;" type="text" name="title" value="{$data.title}" required/>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">适用景点 : </span>
                    <div class="activity2_main2_select middle">
                        <select name="place">
                            <option value="">请选择适用景点</option>
                            <volist name="place" id="vo">
                                <option value="{$vo.id}" <if condition="$data['place'] eq $vo['id']">selected</if>>{$vo.title}</option>
                            </volist>
                        <select>
                    </div>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">美宿地址 : </span>
                    <div class="middle activity2_main2_text3" style="width: 45%;">
                        <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" required name="province" id="province" onchange="load(this.value,'city')">
                            <option value="">选择省</option>
                            <volist name="province" id="vo"> 
                                <option value="{$vo.id}" <if condition="$data['province'] eq $vo['id']">selected</if>>{$vo.name}</option>
                            </volist>
                        </select>
                        <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" required name="city" id="city" onchange="load(this.value,'town')">
                            <option value="">选择市</option>
                        </select>
                        <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" name="town" id="town">
                            <option value="">选择区</option>
                        </select>
                    </div>
                    <input type="text" name="address" value="{$data.address}" class="activity2_main2_text5 middle" style="width:430px"/>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">美宿特色 : </span>
                    <div class="middle activity2_main2_text3">
                        <select class="sc-wd chosen-select-no-single" name="catid" required>
                            <option value="">请选择特色</option>
                            <volist name="hostelcate" id="vo">
                                <option value="{$vo.id}" <if condition="$data['catid'] eq $vo['id']">selected</if>>{$vo.catname}</option>
                            </volist>
                        </select>
                    </div>
                    <span class="middle" style="margin-left: 140px;">美宿类型 : </span>
                    <div class="middle activity2_main2_text3">
                        <select class="sc-wd chosen-select-no-single" name="style" required>
                            <option value="">请选择类型</option>
                            <volist name="hosteltype" id="vo">
                                <option value="{$vo.id}" <if condition="$data['style'] eq $vo['id']">selected</if>>{$vo.catname}</option>
                            </volist>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:20px;"></div>
                <div class="activity2_main">
                    <span>上传美宿展示图</span>
                    <i>图片建议选择尺寸730像素 X 415像素 的图片 (建议上传7张以上)</i>
                    <ul class="hidden activity2_main_ul imglist" >
                        <li class="fl">
                           <a href="javascript:;">
                               <input type="button" value="选择上传" id="uploadify1">
                           </a>
                       </li>
                       <volist name="imglist" id="vo">
                            <li class="fl pr">
                                <img src="{$vo}"/>
                                <input type='hidden' name='imglist[]' value="{$vo}" />
                                <input type="button" class="delimglist" value="删除" >
                            </li>
                       </volist>
                    </ul>
                </div>
                <div style="border-bottom:1px solid #e3e3e3;"></div>
                <div class="Release_of_legend_main2">
                    <span>美宿描述 : </span>
                    <textarea name="description"  id="description" style="width: 100%; height: 200px;">{$data.description}</textarea>
                </div>
                <!--8-9添加 begin-->
                <div class="Release_of_legend_x">
                    <span class="middle">促销活动 : </span>
                    <div class="middle Release_of_legend_y">
                        <span>美宿预定满</span>
                        <div>
                            <input type="text" name="vouchersrange"  value="{$data.vouchersrange}" required />
                            <i>元</i>
                        </div>
                        <span>金额送</span>
                        <div>
                            <input type="text" name="vouchersdiscount"  value="{$data.vouchersdiscount}" required/>
                            <i>元</i>
                        </div>
                        <span>金额的抵用券</span>
                    </div>
                </div>

                <!--end-->

                <div style="border-bottom:1px solid #e3e3e3;"></div>
                <div class="Release_of_legend_main2">
                    <span>退订提醒 : </span>
                    <textarea name="bookremark"  id="bookremark" style="width: 100%; height: 200px;">{$data.bookremark}</textarea>
                </div>
                <div class="Release_of_legend_main3">
                    <div class="Release_of_legend_main3_top">
                        <span>添加房间 : </span>
                    </div>
                    <div class="Release_of_legend_main3_bottom">
                        <ul class="Release_of_legend_m3t_ul roomlist">
                            <volist name="data['room']" id="vo">
                                <li id="room_{$vo.rid}">
                                    <div class="hidden Release_of_legend_m3t_list">
                                        <div class="fl Release_of_legend_m3t_list2">
                                            <a href="{:U('Home/Room/show',array('id'=>$vo['rid']))}">
                                                <img src="{$vo.thumb}" style="width:256px;height:160px"/>
                                            </a>
                                        </div>
                                        <div class="fl Release_of_legend_m3t_list3">
                                            <div class="top">
                                                <a href="{:U('Home/Room/show',array('id'=>$vo['rid']))}">{$vo.title}</a>
                                            </div>
                                            <div class="center hidden">
                                                <ul class="center_ul hidden middle">
                                                    <li><img src="__IMG__/Icon/img42.png" /></li>
                                                    <li><img src="__IMG__/Icon/img42.png" /></li>
                                                    <li><img src="__IMG__/Icon/img42.png" /></li>
                                                    <li><img src="__IMG__/Icon/img42.png" /></li>
                                                    <li><img src="__IMG__/Icon/img42.png" /></li>
                                                </ul>
                                                <span class="middle"><em>{$vo.evaluation|default="10.0"}</em>分</span>
                                                <div class="center_ul_list middle">
                                                    <img src="__IMG__/Icon/img10.png" /><i><em>{$vo.reviewnum|default="0"}</em>条评论</i>
                                                </div>
                                            </div>
                                            <div class="center2">
                                                <span>房间面积：<em>{$vo.area|default="0.0"}平米 </em></span>
                                                <span>床型信息：<em>{$vo.bedtype}</em></span>
                                                <span>最多入住：<em>{$vo.mannum|default="0"}人</em></span>
                                            </div>
                                            <div class="bottom">
                                                <volist name="vo['support']" id="v">
                                                    <i>
                                                        <img src="{$v.red_thumb}" /><em>{$v.catname}</em>
                                                    </i>
                                                </volist>
                                            </div>
                                        </div>
                                        <div class="fr Release_of_legend_m3t_list4" style="text-align: center; width: 224px;">
                                            <i><em>{$vo.money|default="0.0"}</em>元起</i>
                                            <input type="button" class="delroom" data-id="{$vo.rid}" value="删除" />
                                            <input type="button" class="editroom" data-id="{$vo.rid}" value="修改" />
                                        </div>
                                    </div>
                                </li>
                            </volist>
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
                <span>上传房间缩略图</span>
                <i>图片建议选择尺寸400像素 X 250像素 的图片</i>
                <ul class="hidden activity2_main_ul">
                    <li class="fl">
                       <a href="javascript:;">
                           <input type="button" value="选择上传" id="uploadify2">
                       </a>
                    </li>
                    <li class="fl rthumb">
                       
                    </li>
                </ul>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">房间名称 : </span>
                <input class="middle text4 room" style="width:503px; margin-right:140px;" type="text" name="roomtitle" id="roomtitle"  />

                <span class="middle">房间数量 : </span>
                <div class="middle activity2_main2_text2" style="margin-right:0px;">
                    <input type="text" class="room" value="" name="roommannum" id="roommannum" />
                    <i>间</i>
                </div>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">房间费用 : </span>
                <i class="f16 c666 middle">平时价格：</i>
                <div class="middle activity2_main2_text2">
                    <input type="text" class="room" value="" name="nomal_money" id="nomal_money" />
                    <i>元/间</i>
                </div>
                <i class="f16 c666 middle">周末价格：</i>
                <div class="middle activity2_main2_text2">
                    <input type="text"  class="room"value="" name="week_money" id="week_money" />
                    <i>元/间</i>
                </div>
                <i class="f16 c666 middle">节假日价格：</i>
                <div class="middle activity2_main2_text2" style="margin-right:0px;">
                    <input type="text" class="room" value="" name="holiday_money" id="holiday_money" />
                    <i>元/间</i>
                </div>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">房间面积 : </span>
                <div class="middle activity2_main2_text2">
                    <input type="text" class="room" value="" name="roomarea" id="roomarea" />
                    <i>平米</i>
                </div>
                <span class="middle">床型 : </span>
                <div class="middle activity2_main2_text3">
                    <select class="sc-wd chosen-select-no-single room" name="roomtype">
                        <option value="">请选择床型</option>
                        <volist name="bedcate" id="vo">
                            <option value="{$vo.id}">{$vo.catname}</option>
                        </volist>
                    </select>
                </div>
            </div>
            
            <div style="margin-bottom:25px;"></div>
            <div class="activity2_main">
                <span>上传房间展示图</span>
                <i>图片建议选择尺寸730像素 X 415像素 的图片 (建议上传7张以上)</i>
                <ul class="hidden activity2_main_ul roomimglist">
                    <li class="fl uploadli">
                       <a href="javascript:;">
                           <input type="button" value="选择上传" id="uploadify3">
                       </a>
                    </li>
                </ul>
            </div>
            <div class="Release_of_legend_m4_list">
                <span>房间简介 : </span>
                <textarea class="room" name="roomcontent" id="roomcontent"  style="width: 100%; height: 200px;"></textarea>
            </div>

            <div class="Release_of_legend_m4_list2">
                <div class="Release_of_legend_m4_list3">
                    <span>配套设施 : </span>
                    <i>( 可多选 )</i>
                    <label>其中 “ 特”为 重点推荐的配套设施，勾选后可重点在房间列表展示，最多可以选择三个</label>
                </div>
                <div class="Release_of_legend_m4_list4 hidden">
                    <ul class="Release_of_legend_m4_ul hidden">
                        <volist name="support" id="vo">
                            <li class="room support">
                                <div data-id="{$vo.id}" data-hot="{$vo.ishot}" class="Release_of_legend_a1 fl" style="background: url('{$vo.gray_thumb}') no-repeat 9px center;    background-size: 24px 24px;">
                                    <span>{$vo.catname}</span>
                                </div>
                                <i data-id="{$vo.id}" class="hotsupport Release_of_legend_a1_i fl">特</i>
                            </li>
                        </volist>
                    </ul>
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>便利设施 : </span>
                    <input type="text" class="room" name="conveniences" id="conveniences" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>浴室 : </span>
                    <input type="text" class="room" name="bathroom" id="bathroom" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>媒体科技 : </span>
                    <input type="text" class="room" name="media" id="media" />
                </div>
                <div class="Release_of_legend_m4_bottom">
                    <span>食品饮食 : </span>
                    <input type="text" class="room" name="food" id="food" />
                </div>
                <div class="Release_of_legend_m4_bottom2">
                    <input type="hidden" name="rid" id="rid" value=""/>
                    <input type="hidden" name="roomthumb" id="roomthumb" value=""/>
                    <input type="hidden" name="roomsupport" id="roomsupport" value=""/>
                    <input type="hidden" name="roomhotsupport" id="roomhotsupport" value=""/>
                    <input class="Release_of_legend_m4_sub addroom" type="button" value="发布房间" />
                    <input class="Release_of_legend_m4_reset" type="reset" value="重置" />
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var rid=parseInt({$roomnum})||0;
        $(function () {
            $(".Release_of_legend_a1_i").click(function(){
                if($(this).siblings(".Release_of_legend_m4_ul div").hasClass("Release_of_legend_m4_span")){
                    var hitnum=$(".Release_of_legend_a1_i2").length;
                    if(hitnum>=3&&!$(this).hasClass("Release_of_legend_a1_i2")){
                        alert("最多可以选择三个");
                        return false;
                    }else{
                        $(this).toggleClass("Release_of_legend_a1_i2");
                        aa();
                    }
                }
                
            })
            $(".Release_of_legend_m4_ul div").click(function () {
                $(this).toggleClass("Release_of_legend_m4_span")
                aa();
            })
            $(".delimglist").live("click",function(){
                if(confirm("确认删除吗？")){
                    $(this).parent("li").remove();
                }
            })
            $(".delroom").live("click",function(){
                var obj=$(this);
                if(confirm("确认删除吗？")){
                    var p={};
                    p['rid']=$(this).data("id");
                    $.post("{:U('Home/Hostel/ajax_deleteroom')}",p,function(d){
                        if(d.code==200){
                            obj.parents("li").remove();
                        }else{
                            alert(d.msg);
                            return false;
                        }
                    });
                    
                }
            })
            $(".editroom").live("click",function(){
                var obj=$(this);
                var p={};
                p['rid']=obj.data("id");
                $.post("{:U('Home/Hostel/ajax_editroom')}",p,function(d){
                    if(d.code==200){
                        $("input[name='roomtitle']").val(d.data.title);
                        $("input[name='roomthumb']").val(d.data.thumb);
                        $(".rthumb").html("<img src='"+d.data.thumb+"'/>");
                        $("input[name='roommannum']").val(d.data.mannum);
                        $("input[name='nomal_money']").val(d.data.nomal_money);
                        $("input[name='week_money']").val(d.data.week_money);
                        $("input[name='holiday_money']").val(d.data.holiday_money);
                        $("input[name='roomarea']").val(d.data.area);
                        $("select[name='roomtype']").val(d.data.roomtype);
                        $("textarea[name='roomcontent']").val(d.data.content);
                        UE.getEditor('roomcontent').setContent(d.data.content,false);
                        $("input[name='roomsupport']").val(d.data.support);
                        $("input[name='roomhotsupport']").val(d.data.hotsupport);
                        $("input[name='conveniences']").val(d.data.conveniences);
                        $("input[name='bathroom']").val(d.data.bathroom);
                        $("input[name='media']").val(d.data.media);
                        $("input[name='food']").val(d.data.food);
                        $.each(d.data.imglist,function(index,item){
                            $(".roomimglist").append("<li class=\"fl pr\"><img src='"+item+"'/><input type='hidden' name='roomimglist[]' value='"+item+"' /><input type=\"button\" class=\"delimglist\" value=\"删除\" ></li>");
                        })
                        $.each(d.data.support,function(index,item){
                            $(".support").each(function(){
                                if($(this).find("div").data("id")==item){
                                    $(this).find("div").addClass("Release_of_legend_m4_span");
                                }
                            })
                        })
                        $.each(d.data.hotsupport,function(index,item){
                            $(".support").each(function(){
                                if($(this).find(".hotsupport").data("id")==item){
                                    $(this).find(".hotsupport").addClass("Release_of_legend_a1_i2");
                                }
                            })
                        })
                        obj.parents("li").remove();
                        $("input[name='rid']").val(obj.data("id"));
                        $(".addroom").val("修改房间");
                    }else{
                        alert(d.msg);
                        return false;
                    }
                });
            })
            $(".addroom").click(function(){
                var title=$("input[name='roomtitle']").val();
                if(title==""){
                    alert("请填写房间标题");
                    return false;
                }
                var thumb=$("input[name='roomthumb']").val();
                if(title==""){
                    alert("请上传房间缩略图");
                    return false;
                }
                var mannum=$("input[name='roommannum']").val();
                if(title==""){
                    alert("请填写入住人数");
                    return false;
                }
                var nomal_money=$("input[name='nomal_money']").val();
                if(title==""){
                    alert("请填写房间平时价格");
                    return false;
                }
                var week_money=$("input[name='week_money']").val();
                if(title==""){
                    alert("请填写房间周末价格");
                    return false;
                }
                var holiday_money=$("input[name='holiday_money']").val();
                if(title==""){
                    alert("请填写房间节假日价格");
                    return false;
                }
                var area=$("input[name='roomarea']").val();
                if(title==""){
                    alert("请填写房间面积");
                    return false;
                }
                var roomtype=$("select[name='roomtype']").val();
                if(title==""){
                    alert("请选择房间床型");
                    return false;
                }
                var orid=$("input[name='rid']").val();
                var content=$("textarea[name='roomcontent']").val();
                var support=$("input[name='roomsupport']").val();
                var hotsupport=$("input[name='roomhotsupport']").val();
                var conveniences=$("input[name='conveniences']").val();
                var bathroom=$("input[name='bathroom']").val();
                var media=$("input[name='media']").val();
                var food=$("input[name='food']").val();
                var imglist="";
                $("input[name='roomimglist[]']").each(function(){
                    var img=$(this).val();
                    if(imglist==""){
                        imglist=img;
                    }else{
                        imglist+="|"+img;
                    }
                })
                
                var p={};
                if(orid!=""){
                    p['rid']=orid;
                }else{
                    p['rid']=rid;
                }
                p['title']=title;
                p['thumb']=thumb;
                p['mannum']=mannum;
                p['nomal_money']=nomal_money;
                p['week_money']=week_money;
                p['holiday_money']=holiday_money;
                p['area']=area;
                p['roomtype']=roomtype;
                p['content']=content;
                p['support']=support;
                p['hotsupport']=hotsupport;
                p['conveniences']=conveniences;
                p['bathroom']=bathroom;
                p['media']=media;
                p['food']=food;
                p['imglist']=imglist;

                $.post("{:U('Home/Hostel/ajax_cacheroom')}",p,function(d){
                    if(d.code==200){
                        $(".roomlist").append(d.html);
                        $("input[name='roomtitle']").val("");
                        $("input[name='roomthumb']").val("");
                        $("input[name='roommannum']").val("");
                        $("input[name='nomal_money']").val("");
                        $("input[name='week_money']").val("");
                        $("input[name='holiday_money']").val("");
                        $("input[name='roomarea']").val("");
                        $("select[name='roomtype']").val("");
                        $("textarea[name='roomcontent']").val("");
                        UE.getEditor('roomcontent').setContent('',false);
                        $("input[name='roomsupport']").val();
                        $("input[name='roomhotsupport']").val();
                        $("input[name='conveniences']").val("");
                        $("input[name='bathroom']").val("");
                        $("input[name='media']").val("");
                        $("input[name='food']").val("");
                        $(".Release_of_legend_m4_ul div").removeClass("Release_of_legend_m4_span");
                        $(".Release_of_legend_a1_i").removeClass("Release_of_legend_a1_i2");
                        $(".rthumb").html("");
                        $(".uploadli").siblings().remove();
                        rid++;
                    }else{
                        alert(d.msg);
                        return false;
                    }
                });
            })
        })
        function aa(){
            var str="";
            $(".room .Release_of_legend_m4_span").each(function(index,item){
                var id=$(this).data("id");
                if(str==""){
                    str=id;
                }else{
                    str+=","+id;
                }
            })
            $("input[name='roomsupport']").val(str);
            var str="";
            $(".room .Release_of_legend_a1_i2").each(function(index,item){
                var id=$(this).data("id");
                if(str==""){
                    str=id;
                }else{
                    str+=","+id;
                }
            })
            $("input[name='roomhotsupport']").val(str);
        }
    </script>
    <div class="wrap">
        <div class="Release_of_legend_m5">
            <span>退订规则 : </span>
            <textarea name="content" id="content" style="width: 100%; height: 200px;">{$data.content}</textarea>
            <input type="hidden" name="thumb" value="{$data.thumb}" />
            <input type="hidden" name="id" value="{$data.id}" />
            <input type="submit" value="修改美宿" />
        </div>
    </div>
</form>
<link rel="stylesheet" type="text/css" href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#uploadify").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Home/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    data=eval("("+response+")");
                    if(data.status==1){
                        $(".thumb").html("<img src='"+data.msg+"'/>");
                        $("input[name='thumb']").val(data.msg);
                    }else{
                        alert(data.msg);
                    }
                    
                }
            });
            $("#uploadify1").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Home/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '__PUBLIC__/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    data=eval("("+response+")");
                    if(data.status==1){
                        $(".imglist").append("<li class=\"fl pr\"><img src='"+data.msg+"'/><input type='hidden' name='imglist[]' value='"+data.msg+"' /><input type=\"button\" class=\"delimglist\" value=\"删除\" ></li>");
                    }else{
                        alert(data.msg);
                    }
                }
            });
            $("#uploadify2").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Home/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    data=eval("("+response+")");
                    if(data.status==1){
                        $(".rthumb").html("<img src='"+data.msg+"'/>");
                        $("input[name='roomthumb']").val(data.msg);
                    }else{
                        alert(data.msg);
                    }
                    
                }
            });
            $("#uploadify3").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Home/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '__PUBLIC__/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    data=eval("("+response+")");
                    if(data.status==1){
                        $(".roomimglist").append("<li class=\"fl pr\"><img src='"+data.msg+"'/><input type='hidden' name='roomimglist[]' value='"+data.msg+"' /><input type=\"button\" class=\"delimglist\" value=\"删除\" ></li>");
                    }else{
                        alert(data.msg);
                    }
                }
            });
        });
    </script>
<include file="public:foot" />