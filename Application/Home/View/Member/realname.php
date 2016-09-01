<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <script src="__JS__/WdatePicker.js"></script>
    <script src="__JS__/work.js"></script>
    <style>
        #idcard_front img{
            width: 298px;
            height: 169px;
        }
        #idcard_back img{
            width: 298px;
            height: 169px;
        }
    </style>
<include file="public:mheader" />
<div class="wrap">
       <div class="activity_main">
           <a href="/">首页</a>
           <span>></span>
           <a href="{:U('Home/Member/realname')}">申请实名认证</a>
       </div>
   </div>

    <div class="wrap">
        <form action="{:U('Home/Member/realname')}" method="post" onsubmit="return checkform();">
            <script type="text/javascript">
                    function checkform() {
                        var realname = $("input[name='realname']").val();
                        var idcard = $("input[name='idcard']").val();
                        var idcard_front = $("input[name='idcard_front']").val();
                        var idcard_back = $("input[name='idcard_back']").val();
                        var alipayaccount = $("input[name='alipayaccount']").val();
                        if (realname == '') {
                            alert("真实姓名不能为空");
                            $("input[name='realname']").focus();
                            return false;
                        } else if (idcard == '') {
                            alert("身份证号码不能为空");
                            $("input[name='idcard']").focus();
                            return false;
                        } else if(!checkcard(idcard)){
                            alert("手机号码格式不正确");
                            $("input[name='phone']").focus();
                            return false;
                        } else if (idcard_front == '') {
                            alert("请上传正面证件照");
                            return false;
                        } else if (idcard_back == '') {
                            alert("请上传反面证件照");
                            return false;
                        } else if (alipayaccount == '') {
                            alert("请填写支付宝账号");
                            return false;
                        }  else {
                            return true;
                        }
                    }
                </script>
            <div class="activity2_main2">
                <div class="activity2_main2_01">
                    <span class="middle">真实姓名 : </span>
                    <input class="middle text4" style="width:185px;" type="text" name="realname" />
                </div>
                <div class="activity2_main2_01">
                    <span class="middle">身份证号 : </span>
                    <input class="middle text4" style="width:670px;" type="text" name="idcard" />
                </div> 
                <div class="activity2_main2_01">
                    <span class="middle">支付宝账号 : </span>
                    <input class="middle text4" style="width:185px;" type="text" name="alipayaccount"  />
                </div>
                <div class="landlord1 hidden">
                    <span>上传证件照 : </span>
                    <i>正面 :</i>
                    <ul class="landlord1_ul">
                        <li>
                            <span>
                                <input type="button" value="选择上传" id="uploadify">
                            </span>
                        </li>
                        <li id="idcard_front">
                            
                        </li>
                    </ul>
                    <i>反面 :</i>
                    <ul class="landlord1_ul">
                        <li>
                            <span>
                                <input type="button" value="选择上传" id="uploadify1">
                            </span>
                        </li>
                        <li id="idcard_back">
                            
                        </li>
                    </ul>
                    <div class="landlord2"></div>
                    <input type="hidden" name="idcard_front" value="" />
                    <input type="hidden" name="idcard_back" value="" />
                    <input class="lan_sub" type="submit" value="提交认证信息" />
                </div>
            </div>
        </form>
    </div>
    <script>
    $(function () {
        $(".chosen-select-no-single").chosen();
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
                'buttonImg': '__PUBLIC__/Public/uploadify/authupload.gif',//替换上传钮扣
                'width': 298,//buttonImg的大小
                'height': 169,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    data=eval("("+response+")");
                    if(data.status==1){
                        $("#idcard_front").html("<img src='"+data.msg+"' width='298px' height='169px' />");
                        $("input[name='idcard_front']").val(data.msg);
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
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/authupload.gif',//替换上传钮扣
                'width': 298,//buttonImg的大小
                'height': 169,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    data=eval("("+response+")");
                    if(data.status==1){
                        $("#idcard_back").html("<img src='"+data.msg+"' width='298px' height='169px'/>");
                        $("input[name='idcard_back']").val(data.msg);
                    }else{
                        alert(data.msg);
                    }
                    
                }
            });
        });
    </script>
<include file="public:foot" />