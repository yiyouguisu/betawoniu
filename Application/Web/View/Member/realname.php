<include file="Public:head" />
<script type="text/javascript" src='__JS__/ajaxfileupload.js'></script>
<body class="back-f1f1f1">
    <div class="header center z-index112 pr f18 fix-head">实名认证
      <div class="head_go pa" onclick="history.go(-1)">
        <img src="__IMG__/go.jpg">
      </div>
    </div>
    <div class="container" style="margin-top:6rem">
        <div class="son_top pr f0">
            <div class="son_a vertical">
                <img id='head' src="{$data.head}" style="width:60px;height:60px;"></div>
            <div class="son_b vertical">
                <div class="son_b1 f18">{$data.nickname}</div>
            </div>
            
        </div>
        <form id='form' action="{:U('Web/Member/realname')}" method="post">
            <div class="act_c">
                <div class="lu_b">
                    <input type="text" class="lu_text" placeholder="真实姓名 :" name="realname" value="{$apply_info.realname}"/>
                </div>

                <div class="lu_b">
                    <input type="text" class="lu_text" placeholder="身份证号码 :" name="idcard" value="{$apply_info.idcard}">
                </div>

                <div class="lu_b">
                    <input type="text" class="lu_text" placeholder="支付宝帐号 :" name="aliPay"  value="{$apply_info.alipayaccount}"/>
                </div>
            </div>
            <div class="hm_b">上传证件照 :</div>
            <div class="hm_c">正面 :</div>
            <div class="hm_d">
                <ul>
                    <li>
                        <img src="{$apply_info.idcard_front}" id="upz">
                        <input type='hidden' value='{$apply_info.idcard_front}' name='idcard_front' id='idcard_front' />
                    </li>
                    <li class="file" id='zfile'></li>
                </ul>
            </div>
            <div class="hm_c">反面 :</div>
            <div class="hm_d">
                <ul>
                    <li>
                        <img src="{$apply_info.idcard_back}" id="upf">
                        <input type='hidden' value='{$apply_info.idcard_back}' name='idcard_back' id="idcard_back" />
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
                <img src="__IMG__/drop.jpg"></div>
        </div>

        <div class="fish_s xm_ht">
            <div class="fish_list">
                <div class="snail_d center f16">
                    <form id="uploadForm2" enctype="multipart/form-data" method="post" onchange="doUpload2()" />
                        <div class="snail_d center f16 pr">
                            <a class="snail_cut">
                                <img src="__IMG__/xm_a2.jpg">从相册选择</a>
                            <input type="file" name="Filedata" style='width: 100%; height: 4rem; position: absolute; left: 0; top: 0; opacity: 0;' value="从相册选择" />
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            var z = '<form id= "uploadForm" enctype="multipart/form-data" method="post" ><div class="file_img"><img src="__IMG__/hm_c2.jpg" id="zheng"></div><input type="file"  name="Filedata" class="input_file"  onchange="doUpload()" ></form> ';
            $('#zfile').append(z);
            var f = '<form id= "uploadForm1"><div class="file_img"><img src="__IMG__/hm_c2.jpg"></div><input type="file" name="Filedata" onchange="doUpload1()" class="input_file"></form>';
            $('#ffile').append(f);
        });
        function doUpload() {
            var formData = new FormData($("#uploadForm")[0]);
            $.ajax({
                url: "{:U('Web/Public/uploadone')}",
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
                url: "{:U('Web/Public/uploadone')}",
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
                url: "{:U('Web/Public/uploadone')}",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (returndata) {
                    $('#head').attr('src', returndata);
                    var imgdata = { 'url': returndata };
                    $.post("{:U('Web/Member/uphead')}", imgdata, function (res) {
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
