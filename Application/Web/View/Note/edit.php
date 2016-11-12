<include file="Public:head" />
<script type="text/javascript" src="__JS__/ajaxfileupload.js"></script>
<script type="text/javascript">
  var areaurl = "{:U('Web/Note/getchildren')}";
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
                          if (items.id == "{$_GET['city']}") {
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
                          if (items.id == "{$_GET['town']}") {
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
<link rel="stylesheet" type="text/css" href="__CSS__/file.css">
<script type="text/javascript" src='__JS__/ajaxfileupload.js'></script>
<body class="back-f1f1f1">
    <div class="header center pr f18 fix-head">
    <span id="page_title">修改游记</span>
    <div class="head_go pa">
      <a href="javascript:history.go(-1);" id="go_back">
          <img src="__IMG__/go.jpg">
      </a>
      <span>&nbsp;</span>
    </div>
    </div>
    <form id='form' action="{:U('Web/Note/edit')}" method="post" style="margin-top:6rem">
        <div class="container">
            <div class="act_c">
                <div class="lu_b">
                    <input type="text" name="title" class="lu_text" placeholder="游记标题：" value="{$data.title}" required>
                </div>
                <div class="lu_b">
                    <textarea class="lu_text" placeholder="游记摘要 ：" name="description" required>{$data.description}</textarea>
                </div>
                <div class="lu_b">
                    <input type="text" name="fee" class="lu_text" placeholder="人均费用：" required value="{$data.fee}">
                </div>
                <div class="lu_b">
                    <input type="text" name="hotels" class="lu_text" placeholder="游记中出现的美宿：" required readonly id="select_hotel" value="{$hostelStr}">
                </div>
                <div class="lu_b  lu_drop">
                    <div class="drop_left fl">地区：
                    </div>
                    <div class="drop_right fl">
                        <select class="lu_select" name="province" id="province" onchange="load(this.value,'city',0)" required>
                          <option value="0">--请选择--</option>
                          <volist name="province" id="vo"> 
                              <option value="{$vo.id}" <if condition="$vo['id'] eq $data['province']">selected</if>>{$vo.name}</option>
                          </volist>
                        </select>

                        <select class="lu_select" name="city" id="city" onchange="load(this.value,'town',0)" required>
                            <option value="0">--请选择--</option>
                            <volist name="city" id="vo"> 
                              <option value="{$vo.id}" <if condition="$vo['id'] eq $data['city']">selected</if>>{$vo.name}</option>
                            </volist>
                        </select>

                        <select class="lu_select" name="town" id="town" onchange="load(this.value,'distinct',0)">
                            <option value="0">--请选择--</option>
                            <volist name="town" id="vo"> 
                              <option value="{$vo.id}" <if condition="$vo['id'] eq $data['town']">selected</if>>{$vo.name}</option>
                            </volist>
                        </select>
                    </div>
                </div>
                <div class="lu_b">
                    <input type="text" name="address" class="lu_text" placeholder="详细地址 :" value="{$data.address}">
                </div>
            </div>
            <div class="yr">
                <div class="yr-a center">出发时间</div>
                <div class="yr-b">
                    <div class="travel_time yr-c center fl" id="start_time" data-target="#starttime">
                        <div class="yr-c1">
                            <img src="__IMG__/date.jpg"></div>
                        <div class="yr-c2">开始时间</div>
                        <div class="yr-c3">
                            <input class="travel_time ggo_text date starttime" id="starttime" type="date" name="begintime" value="{$data.begintime}" style="display:none" required>
                          <span>{$data.begintime}</span>
                        </div>
                    </div>
                    <div class="yr-d fl pr">共<span id='day'>{$data.days}</span>天
					<input type="hidden" name="days" id="days" />
                        <div class="yr_line pa"></div>
                    </div>
                    <div class="yr-c center fl travel_time" id="end_time" data-target="#endtime">
                        <div class="yr-c1">
                            <img src="__IMG__/date.jpg"></div>
                        <div class="yr-c2">结束时间</div>
                        <div class="yr-c3">
                            <input class="ggo_text date endtime" type="date" id="endtime" name="endtime" value="{$data.endtime}"" required  style="display:none">
                          <span>{$data.endtime}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="act_c">
                <div class="tra_dropA">
                    <select name="man">
                        <option value="">请选择活动人物</option>
                        <volist name="noteman" id="vo">
						<option value="{$vo.id}" <if condition="$data['man'] eq $vo['id']">selected="selected"</if>>{$vo.catname}</option>
					</volist>
                    </select>
                </div>
                <div class="tra_dropA">
                    <select name="style">
                        <option value="">请选择活动形式</option>
                        <volist name="notestyle" id="vo">
						<option value="{$vo.id}" <if condition="$data['style'] eq $vo['id']">selected="selected"</if>>{$vo.catname}</option>
					</volist>
                    </select>
                </div>
                <div class="jok_a">发布内容</div>
                <div class="describe_list">
        <!-- 图片list -->
      </div>   
                <input type="button" class="jok_btn jok_red qadd" value="添加图片和描述">
            </div>
            <div class="snail_d center trip_btn f16" style="margin: 2rem 2.5% 0">
                <input type="hidden" name="id" value="{$data.id}" />
                <input type="hidden" name="hid" value="{$hostelVal}" />
                <input type="hidden" name="thumb" value="" />
                <a href="javascript:;" id="save" class="snail_cut">发布</a>
            </div>
        </div>
    </form>
    <div id="time_box" style="position:fixed;bottom:0;left:0;right:0;display:none;">
      <include file="Public:calendar" />
    </div>
    <div style="position:absolute;top:0;left:0;right:0;padding:7rem 10px;background:#fff;height:auto;z-index:1000;display:none" id="hotel_list">
      <ul>
        <volist name="hostel" id="hostel">
          <if condition="$hostel['ischeck'] eq 1">
            <li style="padding:8px;border-bottom:1px solid #efefef" class="ft14 s_h_itm theme_color_blue" data-id="{$hostel.id}">
          <else/>
            <li style="padding:8px;border-bottom:1px solid #efefef" class="ft14 s_h_itm" data-id="{$hostel.id}">
          </if>{$hostel.title}</li>
        </volist>
      </ul>
    </div>
    <script type="text/javascript">
        var xss = 0;
        var i=0;
        var selectHotels = {};
        var rform='',htmladd = '';
        $(function () {
            var content='{$data.imglist}';
            if(content != 'null' && content != ''){
    content=JSON.parse(content);
    console.log(typeof(content));
    $.each(content,function(id,value){
      console.log(value);
      // rform+='<div class="jok_b"><img src="'+value.thumb+'" id="img_'+i+'"><input type="hidden" id="imglist_'+i+'" class="limgs" value="'+value.thumb+'" name="imglist[' + i + '][thumb]"/></div><form id= "uploadForm'+id+'" enctype="multipart/form-data" method="post">  <a href="javascript:;" class="file jok_btn">上传图片<input type="file" name="Filedata" style="width:100%;height:100%" id=""  onchange="doUpload('+id+')"></a></form><div class="lu_b"><input type="text" class="lu_text ltest" placeholder="描述 :" value='+value.content+' name="imglist[' + i + '][content]"></div>'
       htmladd += "<div class=\"imglist\"><div class=\"jok_b\">";
                htmladd += "<img src=\""+value.thumb+"\" id=\"img_" + i + "\">";
                htmladd += "<input type=\"hidden\" class=\"thumb\" value=\""+value.thumb+"\" id=\"imglist_" + i + "\" name=\"imglist[" + i + "][thumb]\">";
                htmladd += "</div>";
                htmladd += "<a href=\"javascript:;\" class=\"file jok_btn\">上传图片";
                htmladd += "<input type=\"file\" name=\"Filedata\" id=\"fileupload_" + i + "\" style=\"width:100%;height:100%\"  onchange=\"ajaxFileUpload(" + i + ")\">";
                htmladd += "</a>";
                htmladd += "<div class=\"lu_b\">";
                htmladd += "<textarea  class=\"lu_text ltest\" placeholder=\"描述 ：\" id=\"content_" + i + "\" name=\"imglist[" + i + "][content]\">"+value.content+"</textarea>";
                htmladd += "</div></div>";
                // var htmltr = $(htmladd);
      i++;
    })
  }
  rform = htmladd;
  xss = i;
    $('.describe_list').append(rform);
            $(".date").change(function () {
                var starttime = $(".starttime").val();
                var endtime = $(".endtime").val();
                if (starttime != '' && endtime != '') {
                    if (Date.parse(endtime) - Date.parse(starttime) < 0) {
                        alert("请填写正确日期");
                        $(".endtime").val();
                        return false;
                    } else {
                        var days = DateDiff(starttime, endtime);
                        $("#days").val(Number(days));
                        $('#day').text(Number(days));
                    }

                }
            });
            $("#save").click(function () {
                var title = $("input[name='title']").val();
                var description = $("textarea[name='description']").val();
                var fee = $("input[name='fee']").val();
                var province = $("select[name='province'] option:selected").val();
                var city = $("select[name='city'] option:selected").val();
                var starttime = $("input[name='starttime']").val();
                var endtime = $("input[name='endtime']").val();
                var man = $("select[name='man'] option:selected").val();
                var style = $("select[name='style'] option:selected").val();
                if (title == '') {
                    alert("请填写游记标题");
                    return false;
                }
                if (description == '') {
                    alert("请填写游记描述");
                    return false;
                }
                if (fee == '') {
                    alert("请填写人均费用");
                    return false;
                }
                if (province == '' || city == '') {
                    alert("请选择地区");
                    return false;
                }
                if (starttime == '' || endtime == '') {
                    alert("请选择时间");
                    return false;
                }
                if (man == '') {
                    alert("请选择游记人物");
                    return false;
                }
                if (style == '') {
                    alert("请选择游记形式");
                    return false;
                }
                $("#form").submit();
            })
            $(".qadd").click(function () {
                var thumb = $("#imglist_" + xss).val();
                var content = $("#content_" + xss).val();
                if (thumb == '' && content == '') {
                    return false;
                }
                
                var htmladd = "<div class=\"imglist\"><div class=\"jok_b\">";
                htmladd += "<img src=\"__IMG__/default.jpg\" id=\"img_" + xss + "\">";
                htmladd += "<input type=\"hidden\" class=\"thumb\" id=\"imglist_" + xss + "\" name=\"imglist[" + xss + "][thumb]\">";
                htmladd += "</div>";
                htmladd += "<a href=\"javascript:;\" class=\"file jok_btn\">上传图片";
                htmladd += "<input type=\"file\" name=\"Filedata\" id=\"fileupload_" + xss + "\" style=\"width:100%;height:100%\"  onchange=\"ajaxFileUpload(" + xss + ")\">";
                htmladd += "</a>";
                htmladd += "<div class=\"lu_b\">";
                htmladd += "<textarea  class=\"lu_text ltest\" placeholder=\"描述 ：\" id=\"content_" + xss + "\" name=\"imglist[" + xss + "][content]\"></textarea>";
                htmladd += "</div></div>";
                // var htmltr = $(htmladd);
                $('.describe_list').append(htmladd);
                xss++;
            })
        });
        //计算天数差的函数，通用  
        function DateDiff(sDate1, sDate2) {    //sDate1和sDate2是2006-12-18格式  
            var aDate, oDate1, oDate2, iDays
            aDate = sDate1.split("-")
            oDate1 = new Date(aDate[1] + '-' + aDate[2] + '-' + aDate[0])    //转换为12-18-2006格式  
            aDate = sDate2.split("-")
            oDate2 = new Date(aDate[1] + '-' + aDate[2] + '-' + aDate[0])
            iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24)    //把相差的毫秒数转换为天数  
            return iDays
        }
        function ajaxFileUpload(i) {
            $.ajaxFileUpload({
                url: "{:U('Web/Public/uploadone')}",
                secureuri: false, //一般设置为false
                fileElementId: "fileupload_" + i,
                secureuri: false,
                dataType: 'text',
                success: function (data, status) {
                    $('#img_' + i).attr('src', data);
                    $('#imglist_' + i).val(data);
                    var thumb = $("input[name='thumb']").val();
                    if (thumb == '') {
                        $("input[name='thumb']").val(data);
                    }
                },
                error: function (data, status, e) { }
            })
            return false;
        }
    </script>
    <script>
      $('#select_hotel').click(function(evt) {
        evt.preventDefault();
        $('#hotel_list').show();
        $('#page_title').html('选择美宿');
        $('#go_back').click(function(evt) {
          evt.preventDefault();
          evt.preventDefault();
          $('#hotel_list').hide();
          $('#page_title').html("修改游记");
          $(this).unbind('click');
          var selectedStr = '';
          var unionStr = '';
          $.each(selectHotels, function(k, v) {
            if(v) {
              selectedStr += v + ',';
              unionStr += k + ',';
            }
          });
          selectedStr.substring(0, selectedStr.length - 1);
          unionStr.substring(0, unionStr.length -1);
          $('#select_hotel').val(selectedStr);
          $('#hid').val(unionStr);
        });
      });
      $('.s_h_itm').click(function(evt) {
        evt.preventDefault();
        var _this = $(this);
        var chosen = _this.data('chosen');
        var id = _this.data('id');
        if(chosen) {
          _this.removeClass('theme_color_blue');   
          _this.data('chosen', 0);
          selectHotels[id] = undefined;
        } else {
          _this.addClass('theme_color_blue');
          _this.data('chosen', 1);
          selectHotels[id] = _this.html();
        }
         
      });
    </script>
    <script>
      $('.travel_time').click(function(evt) {
        evt.preventDefault();
        var _me = $(this);
        $('#time_box').show();
        var target = _me.data('target');
        console.log(target);
        $('.day').unbind('click');
        $('.day').click(function(evt) {
          evt.preventDefault();
          var month = $('.month').html().trim();
          var dat = $(this).html().trim(); 
          if(parseInt(dat) < 10) {
            dat = '0' + dat.toString(); 
          }
          var d = month + '-' + dat;
          $(target).val(d);
          $(target).siblings().html(d);
          $('#time_box').hide();
          var starttime = $('#starttime').val();
          var endtime = $('#endtime').val();
          var sunix = $.myTime.DateToUnix(starttime);
          var eunix = $.myTime.DateToUnix(endtime);
          if(sunix > 0 && eunix > 0) {
            var duration = (eunix - sunix)/(3600 * 24);
            console.log(duration);
            $('#day').html(duration);
          }
        });
      });
    </script>
</body>
</html>
