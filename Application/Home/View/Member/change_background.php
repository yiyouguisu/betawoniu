<include file="public:head" />
<include file="public:mheader" />
<div class="wrap hidden">
        <div class="pd_main1">
            <include file="Member:change_menu" />
            <div class="fl pd_main3">
                <div class="pd_main3_top hidden">
                    <div class="middle">
                        <label class="f24 c333">我的背景</label>
                    </div>
                </div>
                <div class="scbj_main2">
                    <span id="uploadify"></span>
                    <i>支持jpg、png、jpeg、bmp，图片大小5M以内</i>
                </div>
                
                <div class="scbj_main" id="preview-hidden">
                    <img src="{$user.background|default='__IMG__/img51.jpg'}" style="width: 956px;height: auto;"/>
                </div>


                <form method="post" action="{:U('Home/Member/change_background')}"  onsubmit="return checkCoords();">
                    <input type="hidden" name="background" value="{$user.background|default='__IMG__/img51.jpg'}" id="image">
                    <input type="hidden" id="x" name="x" /> 
                    <input type="hidden" id="y" name="y" /> 
                    <input type="hidden" id="w" name="w" /> 
                    <input type="hidden" id="h" name="h" /> 
                    <div class="pd_main7_bottom9">
                        <input class="pd_main9_btn" type="submit" value="保存" />
                        <input class="pd_main9_reset" type="reset" value="取消" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <link rel="stylesheet" type="text/css"  href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script src="__PUBLIC__/Public/js/jquery.Jcrop.js"></script>
    <link rel="stylesheet" href="__PUBLIC__/Public/css/jquery.Jcrop.css" type="text/css" />
    <script type="text/javascript">

        function checkCoords() {  
              if (parseInt(jQuery('#w').val())>0) return true;  
              alert('请选择需要裁切的图片区域.');  
              return false; 
            }; 

        $(function(){
            $("#uploadify").uploadify({
                'uploader'  : '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg' : '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                'script': "{:U('Home/Public/uploadone')}",//实现上传的程序
                'method'  : 'post',
                'folder'  : '/Uploads/images',//服务端的上传目录
                'auto'    : true,//自动上传
                'multi'   : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png;*.jpeg;*.bmp)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png;*.jpeg;*.bmp',//可上传的文件类型
                'sizeLimit': "",//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '__PUBLIC__/Public/uploadify/changehead.gif',//替换上传钮扣
                'width'   : 142,//buttonImg的大小
                'height'  : 40,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    data=eval("("+response+")");
                    if(data.status!=1){
                        alert(data.msg);
                        return false;
                    }
                    $("#upfileResult").remove();
                    getResult(data.msg);//获得上传的文件路径
                    var preview = $('#preview-hidden');
                    //绑定需要裁剪的图片
                    var img = $('<img style=\"width: 956px;height: auto;\"/>');
                    preview.html(img);
                    preview.children('img').attr('src',data.msg);
                    var crop_img = preview.children('img');
                    crop_img.attr('id',"upfileResult");
                    var img = new Image();
                    img.src = data.msg;
                    $('#upfileResult').Jcrop({
                      bgColor:'#333',   //选区背景色
                      bgFade:true,      //选区背景渐显
                      fadeTime:1000,    //背景渐显时间
                      allowSelect:true, //是否可以选区，
                      allowResize:true, //是否可以调整选区大小
                      aspectRatio: 9.6,     //约束比例
                      minSize : [956,100],
                      // boxWidth : 1920,
                      // boxHeight : 200,
                      onChange: showPreview,
                      onSelect: showPreview,
                      setSelect:[ 0, 0, 956, 100],
                  });
                }
            });
            // $('#upfileResult').Jcrop({
            //           bgColor:'#333',   //选区背景色
            //           bgFade:true,      //选区背景渐显
            //           fadeTime:1000,    //背景渐显时间
            //           allowSelect:true, //是否可以选区，
            //           allowResize:true, //是否可以调整选区大小
            //           aspectRatio: 1,     //约束比例
            //           minSize : [50,50],
            //           boxWidth : 440,
            //           boxHeight : 440,
            //           onChange: showPreview,
            //           onSelect: showPreview,
            //           setSelect:[ 0, 0, 200, 200],
            //       });
            function getResult(content){
                $("#image").val(content);
            };
            
            
            function showPreview(coords){
              var CutJson = {};
              var img_width = $('#upfileResult').width();
              var img_height = $('#upfileResult').height();
              if (parseInt(coords.w) > 0)
              {
                jQuery('#x').val(coords.x); //选中区域左上角横  
                jQuery('#y').val(coords.y); //选中区域左上角纵坐标   
                jQuery('#w').val(coords.w); //选中区域的宽度  
                jQuery('#h').val(coords.h); //选中区域的高度 
              }
            }
        });
    </script>
<include file="public:foot" />