<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
    <link href="__CSS__/base.css" rel="stylesheet" />
    <script src="__JS__/iscroll-zoom.js"></script>
    <script src="__JS__/hammer.js"></script>
    <script src="__JS__/lrz.all.bundle.js"></script>
    <script src="__JS__/jquery.photoClip.js"></script>
    
    <style>
    body {
        background: #21283b;
    }
    .disnone{
        display: none;
    }
    </style>
    <div class="vote_apply">
        <div class="edit disnone">
            <div id="clipArea"></div>
            <div class="gn">
                <p>提示：您可以放大、缩小、左右旋转编辑图片</p>
                <span class="close">返回上页</span>
                <span id="clipBtn">生成照片</span>
            </div>
            <!-- <div id="view"></div> -->
        </div>
        <div class="title_box">
            <h1>{$title}</h1>
        </div>
        <div class="subform">
            <input type="text" class="text2" id="name" value="{$inn.name}" placeholder="美宿名称" />
            <input type="text" class="text2" id="address" value="{$inn.address}" placeholder="美宿地址" />
            <label>美宿logo图片:</label>
            <br/>
            <div class="img_box">
                <input type="file" class="po file" accept="image/*">
                <img id="logo" src="__IMG__/vote/partyin.png" class="nodata">
            </div>
            <label>美宿介绍:</label>
            <br/>
            <ul>
                <li>
                    <input type="file" class="po file" accept="image/*">
                    <img id="li1" src="__IMG__/vote/partyin.png" class="nodata">
                </li>
                <li>
                    <input type="file" class="po file" accept="image/*">
                    <img id="li2" src="__IMG__/vote/partyin.png" class="nodata">
                </li>
                <li>
                    <input type="file" class="po file" accept="image/*">
                    <img id="li3" src="__IMG__/vote/partyin.png" class="nodata">
                </li>
            </ul>
            <!-- <img src="../../Wx/img/vote/partyin.png">
            <img src="../../Wx/img/vote/partyin.png">
            <img src="../../Wx/img/vote/partyin.png"> -->
            <br/>
            <textarea id="description" value="{$inn.description}" placeholder="美宿介绍"></textarea>
            <input type="text" class="text2" id="ownner" value="{$inn.ownner}" placeholder="美宿主人名称" />
            <input type="phone" class="text2" id="contact" value="{$inn.contact}" placeholder="主人联系方式" />
            <div class="vote_div">
                <label>参与抽奖活动:</label>&nbsp;&nbsp;&nbsp;
                <label>
                    <input name="partyin" class="text5" type="radio" value="1" checked="checked" />&nbsp;是 </label>
                <label>&nbsp;&nbsp;&nbsp;
                    <input name="partyin" class="text5" type="radio" value="2" />&nbsp;否 </label>
                <br/>
            </div>
            <div class="vote_apply" id="vote_div">
                <label>奖品有效时间:</label>
                <input id="starttime" class="text3" type="date" value="" />
                <label>至</label>
                <input id="endtime" class="text3" type="date" value="" />
                <input type="number" class="text2" id="roomnum" value="{$inn.roomnum}" placeholder="奖品数量" />
                <input type="text" class="text2" id="prize1desc" value="{$innprize.prize1desc}" placeholder="一等奖" />
                <input type="number" class="text2" id="prize1" value="{$innprize.prize1}" placeholder="一等奖数量" />
                <input type="text" class="text2" id="prize2desc" value="{$innprize.prize2desc}" placeholder="二等奖" />
                <input type="number" class="text2" id="prize2" value="{$innprize.prize2}" placeholder="二等奖数量" />
                <input type="text" class="text2" id="prize3desc" value="{$innprize.prize3desc}" placeholder="三等奖" />
                <input type="number" class="text2" id="prize3" value="{$innprize.prize3}" placeholder="三等奖数量" />
                <input type="text" class="text2" id="prize4desc" value="{$innprize.prize4desc}" placeholder="四等奖" />
                <input type="number" class="text2" id="prize4" value="{$innprize.prize4}" placeholder="四等奖数量" />
                <input type="text" class="text2" id="prize5desc" value="{$innprize.prize5desc}" placeholder="五等奖" />
                <input type="number" class="text2" id="prize5" value="{$innprize.prize5}" placeholder="五等奖数量" />
            </div>
        </div>
        <div class="rool_box">
            <p>报名规则:</p>
            <p>1、如是填写以下必须信息</p>
            <p>2、信息提交后我们将在最快时间内审核，通过后即可参与投票</p>
            <p>3、详情可以咨询公众号：蜗牛客慢生活</p>
        </div>
        <button class="text4" onclick="SubmitForm()">立即提交</button>
    </div>
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
    var obj = null;  //记录点击的是哪个图片框
    $(function() {

        // $('.text3').bind('input propertychange', function() {  
        //     $(this).val('2012-04-06'); 
        // });  

        var clipArea = new bjj.PhotoClip("#clipArea", {
            size: [$(window).width()*0.9, $(window).width()*0.6], // 截取框的宽和高组成的数组。默认值为[260,260]
            // outputSize: [640, 640], // 输出图像的宽和高组成的数组。默认值为[0,0]，表示输出图像原始大小
            //outputType: "jpg", // 指定输出图片的类型，可选 "jpg" 和 "png" 两种种类型，默认为 "jpg"
            file: ".file", // 上传图片的<input type="file">控件的选择器或者DOM对象
            view: "#view", // 显示截取后图像的容器的选择器或者DOM对象
            ok: "#clipBtn", // 确认截图按钮的选择器或者DOM对象
            loadStart: function(file) {console.log("start");$(".photo-clip-view").addClass("zairu");
}, // 开始加载的回调函数。this指向 fileReader 对象，并将正在加载的 file 对象作为参数传入
            loadComplete: function(src) {console.log("complete");$(".photo-clip-view").removeClass("zairu");
}, // 加载完成的回调函数。this指向图片对象，并将图片地址作为参数传入
            loadError: function(event) {console.log("error");}, // 加载失败的回调函数。this指向 fileReader 对象，并将错误事件的 event 对象作为参数传入
            clipFinish: function(dataURL) {
                BindImg(dataURL);
            }, // 裁剪完成的回调函数。this指向图片对象，会将裁剪出的图像数据DataURL作为参数传入
        });
        $(".file").click(function() {
            $('.edit').show();
            obj = $(this);
        });
        $(".close").click(function(){
            $('.edit').hide();
        });
    })
    var BindImg = function(url){
        if(obj == null){
            $.alert("error");
            return ;
        }
        obj.parent().children('img').attr("src",url);
        obj.parent().children('img').removeClass("nodata");
        obj.parent().children('img').addClass("hasdata");
        obj = null;
        $('.edit').hide();
    }
    var SubmitForm = function() {
        var name = $("#name").val();
        if(name == ''){
            $.alert("美宿名称不能为空！");
            return ;
        }
        var address = $("#address").val();
        if(address == ''){
            $.alert("美宿地址不能为空！");
            return ;
        }
        var description = $("#description").val();
        if(description == ''){
            $.alert("美宿介绍不能为空！");
            return ;
        }
        var ownner = $("#ownner").val();
        if(ownner == ''){
            $.alert("美宿主人不能为空！");
            return ;
        }
        var contact = $("#contact").val();
        if(contact == ''){
            $.alert("美宿主人联系方式不能为空！");
            return ;
        }
        var isvote = $("input[name='partyin']:checked").val();
        var logo = $("#logo").attr("src");
        var des1 = $("#li1").attr("src");
        var des2 = $("#li2").attr("src");
        var des3 = $("#li3").attr("src");
        if(logo == '/Public/Wx/img/vote/partyin.png'){
            $.alert("logo图片必须上传！");
            return;
        }   
        if(des1 == '/Public/Wx/img/vote/partyin.png')
            des1 = '';
        if(des2 == '/Public/Wx/img/vote/partyin.png')
            des2 = '';
        if(des3 == '/Public/Wx/img/vote/partyin.png')
            des3 = '';
        var starttime, endtime, couponlevelone, couponlevelsec, couponlevelthd, roomnum;
        if (isvote == 1) {
            starttime = $("#starttime").val();
            if(starttime == ''){
                $.alert("奖品有效开始时间不能为空！");
                return ;
            }
            endtime = $("#endtime").val();
            if(endtime == ''){
                $.alert("奖品有效结束时间不能为空！");
                return ;
            }
            if(starttime > endtime){
                $.alert("奖品有效开始时间不能大于结束时间！");
                return ;
            }
            roomnum = $("#roomnum").val();
            if(roomnum == ''){
                $.alert("奖品数量不能为空！");
                return ;
            }
            prize1 = $("#prize1").val();
            if(prize1 == ''){
                $.alert("一等奖数量不能为空！");
                return ;
            }
            prize2 = $("#prize2").val();
            if(prize2 == ''){
                $.alert("二等奖数量不能为空！");
                return ;
            }
            prize3 = $("#prize3").val();
            if(prize3 == ''){
                $.alert("三等奖数量不能为空！");
                return ;
            }
            prize4 = $("#prize4").val();
            if(prize4 == ''){
                $.alert("四等奖数量不能为空！");
                return ;
            }
            prize5 = $("#prize5").val();
            if(prize5 == ''){
                $.alert("五等奖数量不能为空！");
                return ;
            }
            prize1desc = $("#prize1desc").val();
            if(prize1desc == ''){
                $.alert("一等奖描述不能为空！");
                return ;
            }
            prize2desc = $("#prize2desc").val();
            if(prize2desc == ''){
                $.alert("二等奖描述不能为空！");
                return ;
            }
            prize3desc = $("#prize3desc").val();
            if(prize3desc == ''){
                $.alert("三等奖描述不能为空！");
                return ;
            }
            prize4desc = $("#prize4desc").val();
            if(prize4desc == ''){
                $.alert("四等奖描述不能为空！");
                return ;
            }
            prize5desc = $("#prize5desc").val();
            if(prize5desc == ''){
                $.alert("五等奖描述不能为空！");
                return ;
            }
            if(roomnum != prize1 * 1 + prize2 * 1 + prize3 * 1 + prize4 * 1 + prize5 * 1){
                $.alert("奖品数量应等于各奖品数量之和！");
                return ;
            }
        }
        // var  = $("#").val();
        // var  = $("#").val();
        $.showLoading("正在提交中...");
        $.ajax({
            type: "POST",
            url: "{:U('Wx/Vote/ajax_submit')}",
            data: {
                'name': name,
                'address': address,
                'logo':logo,
                'des1':des1,
                'des2':des2,
                'des3':des3,
                'description': description,
                'ownner': ownner,
                'contact': contact,
                'isvote': isvote,
                'starttime': starttime,
                'endtime': endtime,
                'roomnum': roomnum,
                'prize1': prize1,
                'prize2': prize2,
                'prize3': prize3,
                'prize4': prize4,
                'prize5': prize5,
                'prize1desc': prize1desc,
                'prize2desc': prize2desc,
                'prize3desc': prize3desc,
                'prize4desc': prize4desc,
                'prize5desc': prize5desc
            },
            dataType: "json",
            success: function(data) {
                if (data.code == 1) {
                    $.hideLoading();
                    layer.open({
                        content: '申请提交成功，我们将会尽快审核！',
                        btn: '确定',
                        shadeClose: false,
                        yes: function(){
                            window.location.href = "{:U('Wx/Vote/index')}";
                        }
                    });
                } else {
                    $.hideLoading();
                    $.alert(data.msg);
                    return false;
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $.hideLoading();
                $.alert('系统错误！');
            }
        });
    }

    $(".text5").change(function() {
        var $selectedvalue = $("input[name='partyin']:checked").val();
        if ($selectedvalue == 1) {
            $('#vote_div').removeClass('disnone');
        } else {
            $('#vote_div').addClass('disnone');
        }
    });
    </script>
<include file="public:foot" />
