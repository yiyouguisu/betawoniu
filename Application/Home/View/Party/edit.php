<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
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
        var ue = UE.getEditor('cancelrule',{
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
                            if(Date.parse(endtime) - Date.parse(starttime)<0){
                                alert("请填写正确日期");
                                $(".endtime").val();
                                return false;
                            }else{
                                var days=DateDiff(starttime,endtime);
                                console.log(days)
                                $("#days").val(Number(days));
                            }
                            
                        }
                        
                        
                    }
                });
                
            });
        }
        var province='{$data.province}';
        var city='{$data.city}';
        if(province!=''){
          load(province,'city');
        }
        if(city!=''){
          load(city,'town');
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
<div class="wrap">
       <div class="activity_main">
           <a href="/">首页</a>
           <span>></span>
           <a href="{:U('Home/Party/index')}">活动</a>
           <span>></span>
           <a href="{:U('Home/Party/edit',array('id'=>$data['id']))}">修改活动</a>
       </div>
       <div class="activity2_main">
           <span>上传活动缩略图</span>
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
   </div>

    <div class="wrap">
        <form action="{:U('Home/Party/edit')}" method="post">
            <div class="activity2_main2">
                <div class="activity2_main2_01">
                    <span class="middle">活动标题 : </span>
                    <input class="middle text4" style="width:670px;" type="text" name="title" value="{$data.title}" required/>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">适用美宿 : </span>
                    <div class="activity2_main2_select middle">
                        <select name="hid">
                            <option value="">请选择适用美宿</option>
                            <volist name="hostel" id="vo">
                                <option value="{$vo.id}" <if condition="$data['hid'] eq $vo['id']">selected</if>>{$vo.title}</option>
                            </volist>
                        <select>
                    </div>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">活动时间 : </span>
                    <div class="activity2_main2_text1 middle">
                        <i>开始时间 :</i>
                        <input id="d5221" class="J_date starttime" type="text" name="starttime" value="{$data.starttime}" required/>
                    </div>
                    <i><input type="text" id="days" value="{$data.days}" style="    width: 20px;border: none;color: #21a7bb;">天</i>
                    <div class="activity2_main2_text1 middle">
                        <i>结束时间 :</i>
                        <input id="d5222" class="J_date endtime" type="text" name="endtime" value="{$data.endtime}" required/>
                    </div>
                    <div class="middle" style="margin-right:80px;"></div>
                    <span class="middle">活动人数</span>
                    <div class="middle activity_main2_text2 hidden">
                        <div class="activity_main2_text3 middle">
                            <input type="text" value="{$data.start_numlimit}" class="middle" name="start_numlimit"/>
                            <span class="middle">人</span>
                        </div>
                        <i class="middle">至</i>
                        <div class="activity_main2_text3 middle">
                            <input type="text" class="middle" value="{$data.end_numlimit}" name="end_numlimit"/>
                            <span class="middle">人</span>
                        </div>
                    </div>
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">活动费用 : </span>
                    <div class="middle activity2_main2_text2">
                        <input type="text" value="{$data.money}" name="money"required/>
                        <i>元/人</i>
                    </div>
                    <div <eq name="data['isfree']" value="1"> class="middle activity2_a activity2_b"<else /> class="middle activity2_a"</eq>>免费活动</div>
                    <span class="middle">特色 : </span>
                    <div class="middle activity2_main2_text3">
                        <select class="sc-wd chosen-select-no-single" name="catid" required>
                            <option value="">请选择特色</option>
                            <volist name="partycate" id="vo">
                            	<option value="{$vo.id}" <if condition="$data['catid'] eq $vo['id']">selected</if>>{$vo.catname}</option>
                            </volist>
                        </select>
                    </div>
                    <div class="middle activity2_main2_text4">

                    </div>
                    <span class="middle">类型 : </span>
                    <div class="middle activity2_main2_text3">
                        <select class="sc-wd chosen-select-no-single" name="partytype" required>
                            <option value="">请选择类型</option>
                            <option value="1" <if condition="$data['partytype'] eq 1">selected</if>>亲子类</option>
                            <option value="2" <if condition="$data['partytype'] eq 2">selected</if>>情侣类</option>
                            <option value="3" <if condition="$data['partytype'] eq 3">selected</if>>家庭出游</option>
                        </select>
                    </div>
                </div>
                
                <div class="activity2_main2_01">
                    <span class="middle">活动地址 : </span>
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
                
                 <!--8-9添加 begin-->
                <div class="Release_of_legend_x"  style="margin-top: 20px;">
                    <span class="middle">促销活动 : </span>
                    <div class="middle Release_of_legend_y">
                        <span>活动报名满</span>
                        <div>
                            <input type="text" name="vouchersrange" value="{$data.vouchersrange}" required />
                            <i>元</i>
                        </div>
                        <span>金额送</span>
                        <div>
                            <input type="text" name="vouchersdiscount" value="{$data.vouchersdiscount}" required/>
                            <i>元</i>
                        </div>
                        <span>金额的抵用券</span>
                    </div>
                </div>

                <!--end-->
                <div class="Release_of_legend_main2">
                    <span>活动摘要  : </span>
                    <textarea style="width: 100%; height: 200px;" name="description" >{$data.description}</textarea>
                </div>
                <div class="Release_of_legend_main2">
                    <span>取消报名规则  : </span>
                    <textarea style="height: 100px;" name="cancelrule"  id="cancelrule" >{$data.cancelrule}</textarea>
                </div>
                <div class="activity3">
                    <span style="font-size: 26px;color: #333333;display: block;line-height: 75px;">活动内容 : </span>
                    <div class="activity3_01">
                        <textarea name="content" id="content" style="width: 100%; height: 500px;">{$data.content}</textarea>
                    </div>
                    <div class="activity3_tab">
                        <input type="hidden" name="thumb" value="{$data.thumb}" />
                        <input type="hidden" name="id" value="{$data.id}" />
                        <input type="hidden" name="isfree" value="{$data.isfree}" />
                        <input class="sub" type="submit" value="修改活动" />
                        <input class="reset" type="reset" value="重置" />
                    </div>

                </div>
            </div>
        </form>
    </div>
    <script>
    $(function () {
        $(".chosen-select-no-single").chosen();
        $(".activity2_a").click(function () {
            if($(this).hasClass("activity2_b")){
                $("input[name='isfree']").val("0");
            }else{
                $("input[name='isfree']").val("1");
            }
            $(this).toggleClass("activity2_b");
        })
    });
    </script>
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
        });
    </script>

<include file="public:foot" />