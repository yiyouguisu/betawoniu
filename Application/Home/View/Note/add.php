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
       <div class="activity_main">
           <a href="/">首页</a>
           <span>></span>
           <a href="{:U('Home/Note/index')}">游记</a>
           <span>></span>
           <a href="{:U('Home/Note/add')}">发布游记</a>
       </div>
       <div class="activity2_main">
           <span>上传游记缩略图</span>
           <i>图片建议选择尺寸400像素 X 250像素 的图片</i>
           <ul class="hidden activity2_main_ul">
               <li class="fl">
                   <a href="javascript:;">
                       <input type="button" value="选择上传" id="uploadify">
                   </a>
               </li>
               <li class="fl thumb">
                   
               </li>
           </ul>
       </div>
   </div>

    <div class="wrap">
      <form action="{:U('Home/Note/add')}" method="post">
        <div class="activity2_main2">
            <div class="activity2_main2_01">
                <span class="middle">游记标题 : </span>
                <input class="middle text4" style="width:670px;" type="text" name="title" value="" required/>
            </div>

            <div class="activity2_main2_01">
                <span class="middle">出发时间 : </span>
                <div class="activity2_main2_text1 middle">
                    <i>入住时间 :</i>
                    <input id="d5221" class="J_date starttime" type="text" name="begintime" required/>
                </div>
                <i><input type="text" id="days" name="days" value="0" style="    width: 20px;border: none;color: #21a7bb;">天</i>
                <div class="activity2_main2_text1 middle">
                    <i>离店时间 :</i>
                    <input id="d5222" class="J_date endtime" type="text" name="endtime" required/>
                </div>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">游记中的美宿 : </span>
                <div class="activity2_main2_x pr middle">
                    <span>请选择文中出现的美宿</span>
                    <div class="pa activity2_main2_y hide">
                        <ul class="activity2_main2_y_ul">
                            <volist name="hostel" id="vo">
                                <li data-id="{$vo.id}">
                                    <i>{$vo.title}</i>
                                </li>
                            </volist>
                        </ul>
                        <div class="activity2_main2_sub">
                            <input class="addhostel" type="button" value="确         定" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="activity2_main2_01">
                <span class="middle">人均费用 : </span>
                <div class="middle activity2_main2_text2">
                    <input type="text" value="" name="fee" value="" required/>
                    <i>元/人</i>
                </div>
                <span class="middle">人物 : </span>
                <div class="middle activity2_main2_text3">
                    <select class="sc-wd chosen-select-no-single" name="man">
                        <option value="">请选择人物</option>
                        <volist name="noteman" id="vo">
                          <option value="{$vo.id}">{$vo.catname}</option>
                        </volist>
                    </select>
                </div>
                <div class="middle activity2_main2_text4">

                </div>
                <span class="middle">形式 : </span>
                <div class="middle activity2_main2_text3">
                    <select class="sc-wd chosen-select-no-single" name="style">
                      <option value="">请选择形式</option>
                        <volist name="notestyle" id="vo">
                          <option value="{$vo.id}">{$vo.catname}</option>
                        </volist>
                    </select>
                </div>
            </div>
            <div class="activity2_main2_01">
                <span class="middle">游记地址 : </span>
                <div class="middle activity2_main2_text3" style="width: 45%;">
                    <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" required name="province" id="province" onchange="load(this.value,'city')">
                        <option value="">选择省</option>
                        <volist name="province" id="vo"> 
                            <option value="{$vo.id}">{$vo.name}</option>
                        </volist>
                    </select>
                    <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" required name="city" id="city" onchange="load(this.value,'town')">
                        <option value="">选择市</option>
                    </select>
                    <select class="middle activity2_main2_text3 sc-wd chosen-select-no-single" name="town" id="town">
                        <option value="">选择区</option>
                    </select>
                </div>
                <input type="text" name="address" class="activity2_main2_text5 middle" style="width:430px"/>
            </div>
            <div class="Release_of_legend_main2">
                <span>游记摘要  : </span>
                <textarea style="height: 100px;" name="description" ></textarea>
            </div>
            <div class="travels3_main">
                <span>游记内容 : </span>
                <div class="travels3_main2">
                    <i>上传游记素材图片 ：</i>
                    <div class="hidden travels3_main2_a"  id="content_0">
                        <div class="fl travels3_main2_b">
                            <span class="upload" id="uploadbtn_0" data-id="imglist_0" data-thumbid="img_0"></span>
                        </div>
                        <div class="fl travels3_main2_b img" id="img_0"><!-- <img src="__IMG__/img42.jpg" /> --></div>
                        <div class="fl travels3_main2_c">
                            <input type="hidden" class="thumb" id="imglist_0" name="imglist[0][thumb]" value="">
                            <textarea placeholder="描述 ：" name="imglist[0][content]"></textarea>
                        </div>
                    </div>
                    <div class="travels3_main2_d">
                        <a href="javascript:;" class="qadd">增加图片和描述</a>
                    </div>
                </div>
                <div class="travels3_main_tab">
                    <input type="hidden" name="thumb" value="" />
                    <input type="hidden" name="hid" value="" />
                    <input class="sub" type="submit" value="发布游记" />
                    <input class="reset" type="reset" value="重置" />
                </div>
            </div>

        </div>
      </form>
    </div>
    <script>
    $(function () {
        $(".chosen-select-no-single").chosen();
        $(".activity2_main2_x span").click(function () {
            $(this).siblings().slideToggle(200);
            $(this).toggleClass("activity2_main2_span3");
        })
        $(".activity2_main2_y_ul li").click(function () {
            $(this).toggleClass("activity2_main2_y_list");
        })
        $(".addhostel").click(function(){
            var hid="";
            $(".activity2_main2_y_ul li.activity2_main2_y_list").each(function(){
                if(hid==""){
                    hid=$(this).data("id");
                }else{
                    hid+=","+$(this).data("id");
                }
            })
            $("input[name='hid']").val(hid);
            $(".activity2_main2_x span").removeClass("activity2_main2_span3").siblings().slideToggle(200);
        })
    });

    </script>
    <link rel="stylesheet" type="text/css"  href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
    $(function(){
        $(".upload").each(function(){
            if($(this).attr("id")!='uploadbtn_0'){
                inituploadify($(this));
            }
            
        })
    })
   function inituploadify(a){
    a.uploadify({
        'uploader'  : '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
        'cancelImg' : '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
        //'script' : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
        'script'    : "{:U('Home/Public/uploadone')}",//实现上传的程序
        'method'    : 'post',
        'auto'      : true,//自动上传
        'multi'     : false,//是否多文件上传
        'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
        'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
        'sizeLimit': '',//限制上传文件的大小2m(比特b)
        'queueSizeLimit' :10, //可上传的文件个数
        'buttonImg': '__PUBLIC__/Public/uploadify/upload.gif',//替换上传钮扣
        'width': 202,//buttonImg的大小
        'height': 152,
        onComplete: function (evt, queueID, fileObj, response, data) {
            data=eval("("+response+")");
            if(data.status==1){
                var obj="#"+$(evt.currentTarget).attr("data-id");
                $(obj).val(data.msg);
                var thumobj="#"+$(evt.currentTarget).attr("data-thumbid");
                $(thumobj).html("<img src='"+data.msg+"' style=\"width:202px;height:152px\"  />").next(".travels3_main2_c").css("width",775);
            }else{
                alert(data.msg);
            }

        }
    });
   }
   </script>
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
    <script type="text/javascript">
        var xss=0;
        $(function () {
            $(".qadd").click(function() {
                xss++;
                var htmladd="<div class=\"hidden travels3_main2_a\" id=\"content_"+xss+"\">";
                    htmladd +="<div class=\"fl travels3_main2_b\">";
                    htmladd +="<span class=\"upload\" id=\"uploadbtn_"+xss+"\" data-id=\"imglist_"+xss+"\" data-thumbid=\"img_"+xss+"\"></span>";
                    htmladd +="</div>";
                    htmladd +="<div class=\"fl travels3_main2_b img\" id=\"img_"+xss+"\"></div>";
                    htmladd +="<div class=\"fl travels3_main2_c\">";
                    htmladd +="<input type=\"hidden\" class=\"thumb\" id=\"imglist_"+xss+"\" name=\"imglist["+xss+"][thumb]\">";
                    htmladd +="<textarea placeholder=\"描述 ：\" name=\"imglist["+xss+"][content]\"></textarea>";
                    htmladd +="</div>";
                    htmladd +="</div>";
                var htmltr=  $(htmladd);
                    $(".travels3_main2_d").before(htmltr);
                    inituploadify(htmltr.find(".upload"));
            })
            
            
        });
    </script>
<include file="public:foot" />