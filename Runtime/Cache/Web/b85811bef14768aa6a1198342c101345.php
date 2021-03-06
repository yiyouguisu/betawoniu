<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
    <meta name="keywords" content="<?php echo ($site["sitekeywords"]); ?>" />
    <meta name="description" content="<?php echo ($site["sitedescription"]); ?>" />
    <meta name="format-detection" content="telephone=no" />
    <link href="favicon.ico" rel="SHORTCUT ICON">
    <title><?php echo ($site["sitetitle"]); ?></title>
    <link rel="stylesheet" href="/Public/Web/css/base.css">
    <link rel="stylesheet" href="/Public/Web/css/style.css">
    <link rel="stylesheet" href="/Public/Web/css/jquery-ui.min.css">
    <script src="/Public/Web/js/jquery-1.11.1.min.js"></script>
    <script src="/Public/Web/js/Action.js"></script>
    <script src="/Public/Web/js/TouchSlide.1.1.js"></script>
</head>
<body>

<script type="text/javascript" src='/Public/Web/js/ajaxfileupload.js'></script>
<body class="back-f1f1f1">
    <div class="header center z-index112 pr f18">实名认证
      <div class="head_go pa" onclick="history.go(-1)">
          <img src="/Public/Web/images/go.jpg"></div>
    </div>

    <div class="container">
        <div class="son_top pr f0">
            <div class="son_a vertical">
                <img id='head' src="<?php echo ($data["head"]); ?>"></div>
            <div class="son_b vertical">
                <div class="son_b1 f18"><?php echo ($data["nickname"]); ?></div>
            </div>
            <div class="set_a  xm_click pa">
                <a href="javascript:;">更换头像<img src="/Public/Web/images/set_right.jpg"></a></div>
        </div>
        <form id='form' action="<?php echo U('Web/Member/realname');?>" method="post">
            <div class="act_c">
                <div class="lu_b">
                    <input type="text" class="lu_text" placeholder="真实姓名 :" name="realname" />
                </div>

                <div class="lu_b">
                    <input type="text" class="lu_text" placeholder="身份证号码 :" name="idcard" />
                </div>
            </div>
            <div class="hm_b">上传证件照 :</div>
            <div class="hm_c">正面 :</div>
            <div class="hm_d">
                <ul>
                    <li>
                        <img src="/Public/Web/images/hm_c1.jpg" id="upz">
                        <input type='hidden' value='' name='idcard_front' id='idcard_front' />
                    </li>
                    <li class="file" id='zfile'></li>
                </ul>
            </div>
            <div class="hm_c">反面 :</div>
            <div class="hm_d">
                <ul>
                    <li>
                        <img src="/Public/Web/images/hm_c1.jpg" id="upf">
                        <input type='hidden' value='' name='idcard_back' id="idcard_back" />
                    </li>
                    <li class="file" id='ffile'></li>
                </ul>
            </div>
            <div class="set_c" style="margin: -1rem 2.5% 0">
                <div class="snail_d center trip_btn f16">
                    <a id='sub' class="snail_cut ">提交认证信息</a>
                </div>
            </div>
        </form>
    </div>
    <div class="big_mask"></div>
    <div class="fish_btm" style="display: none;">
        <div class="fish_t center">
            <div class="fish_t1 fish_wt">
                <span></span>
                <img src="/Public/Web/images/drop.jpg"></div>
        </div>

        <div class="fish_s xm_ht">
            <!--                    <div class="fish_list">
                       <div class="snail_d center f16">
                            <a href="" class="snail_cut"><img src="/Public/Web/images/xm_a1.jpg">拍一张照片</a>
                       </div>
                   </div>   -->
            <div class="fish_list">
                <div class="snail_d center f16">
                    <form id="uploadForm2" enctype="multipart/form-data" method="post" onchange="doUpload2()" />
                        <div class="snail_d center f16 pr">
                            <a class="snail_cut">
                                <img src="/Public/Web/images/xm_a2.jpg">从相册选择</a>
                            <input type="file" name="Filedata" style='width: 100%; height: 4rem; position: absolute; left: 0; top: 0; opacity: 0;' value="从相册选择" />
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            var z = '<form id= "uploadForm" enctype="multipart/form-data" method="post" ><div class="file_img"><img src="/Public/Web/images/hm_c2.jpg" id="zheng"></div><input type="file"  name="Filedata" class="input_file"  onchange="doUpload()" ></form> ';
            $('#zfile').append(z);
            var f = '<form id= "uploadForm1"><div class="file_img"><img src="/Public/Web/images/hm_c2.jpg"></div><input type="file" name="Filedata" onchange="doUpload1()" class="input_file"></form>';
            $('#ffile').append(f);
        });
        function doUpload() {
            var formData = new FormData($("#uploadForm")[0]);
            $.ajax({
                url: "<?php echo U('Web/Public/uploadone');?>",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata) {
                    console.log(returndata);
                    $('#upz').attr('src', returndata);
                    $('#idcard_front').val(returndata)
                },
                error: function (returndata) {
                    alert('失败');
                }
            });
        }
        function doUpload1() {
            var formData = new FormData($("#uploadForm1")[0]);
            $.ajax({
                url: "<?php echo U('Web/Public/uploadone');?>",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata) {
                    $('#upf').attr('src', returndata);
                    $('#idcard_back').val(returndata);
                },
                error: function (returndata) {
                    alert(returndata);
                }
            });
        }
        function doUpload2() {
            var formData = new FormData($("#uploadForm2")[0]);
            $.ajax({
                url: "<?php echo U('Web/Public/uploadone');?>",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata) {
                    $('#head').attr('src', returndata);
                    var imgdata = { 'url': returndata };
                    $.post("<?php echo U('Web/Member/uphead');?>", imgdata, function (res) {
                        $(".fish_btm").animate({ bottom: -1000 }, 1000);
                        $(".big_mask,.fish_btm").hide()
                    })
                },
                error: function (returndata) {
                    alert(returndata);
                }
            });
        }
        $('#sub').click(function () {
            $('#form').submit();
        });
    </script>
</body>

</html>