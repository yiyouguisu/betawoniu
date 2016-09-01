<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap jj">
        <!--   <div class="nav">
          <ul class="cc">
                <li ><a href="{:U('Admin/Menu/index')}">后台菜单管理</a></li>
                <li class="current"><a href="{:U('Admin/Menu/add')}">添加菜单</a></li>
              </ul>
        </div>-->
        <include file="Common:Nav" />
        <div class="common-form">
            <!---->
            <form method="post" action="{:U('Admin/Coupons/add')}">
                <div class="h_a">优惠券信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">优惠券名称</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入标题" id="title" value="{$data.title}">
                                </td>
                            </tr>
                            <tr>
                                <th>优惠券类型</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='radio' name='type' value='1' checked><span>全额抵用券</span></label>
                                        </li>
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='radio' name='type' value='2'><span>5折抵用券</span></label>
                                        </li>
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='radio' name='type' value='3'><span>8折抵用券</span>
                                            </label>
                                        </li>
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='radio' name='type' value='4'><span>投票兑换券</span>
                                            </label>
                                        </li>
                                        <li style="width: 130px;">
                                            <label>
                                                <input type='radio' name='type' value='5'><span>邀请投票兑换券</span>
                                            </label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">优惠券适用美宿</th>
                                <td>
                                    <ul class="switch_list cc morelist">
                                        <volist name="shop" id="vo">
                                            <li style="width: 130px;">
                                                <label>
                                                    <input type='checkbox' name='hid[]' value='{$vo.id}'><span>{$vo.title}</span></label>
                                            </li>
                                        </volist>
                                    </ul>
                                    <a href="javascript:;" class="more">加载更多</a>
                                </td>
                            </tr>
                            <script>
                                $(function () {
                                    var p = 2;
                                    $(".more").click(function () {
                                        $.ajax({
                                            url: "{:U('Admin/Coupons/ajax_getmore')}",
                                            async: false,
                                            data: { p: p },
                                            success: function (data) {
                                                data = eval("(" + data + ")");
                                                if (data != null && data.length > 0) {
                                                    for (var i = 0; i < data.length; i++) {
                                                        var ahtml = "<li style=\"width: 130px;\">";
                                                        ahtml += "<label>";
                                                        ahtml += "<input type='checkbox' name='hid[]' value='" + data[i].id + "'><span>" + data[i].title + "</span></label>";
                                                        ahtml += "</li>";
                                                    }
                                                    $(".morelist").append(ahtml);
                                                    p++;
                                                }
                                            }
                                        });
                                    })
                                })
                            </script>
                            <tr id="logo">
                                <th>展示图：</th>
                                <td>
                                    <input type="text" name="thumb" id="image" class="input length_5" value="{$data.thumb}" style="float: left" runat="server" ondblclick='image_priview(this.value);'>&nbsp;
                                    <input type="button" class="button" value="选择上传" id="uploadify">
                                    <span class="gray">双击文本框查看图片</span></td>
                            </tr>
                            <tr id="pricestr"  style="display:none">
                                <th>优惠券价格</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="price" class="input length_2" placeholder="请输入优惠券价格" id="price" value="{$data.price}">
                                </td>
                            </tr>
                            <tr id="percentstr" style="display:none">
                                <th>兑换比例</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="percent" class="input length_2" placeholder="请输入优惠券兑换比例" id="percent" value="{$data.percent}">%
                                </td>
                            </tr>
                            <tr id="vstr">
                                <th>中奖几率</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="v" class="input length_2" placeholder="请输入中奖几率" id="v" value="{$data.v}">%
                                </td>
                            </tr>
                            <tr>
                                <th>优惠券有效时间</th>
                                <td>
                                    <input type="text" name="validity_starttime" class="input length_2 J_date" value="{$data.validity_starttime}" style="width: 120px;">
                                    -
                                    <input type="text" class="input length_2 J_date" name="validity_endtime" value="{$data.validity_endtime}" style="width: 120px;">
                                </td>
                            </tr>
                            <tr>
                                <th>优惠券使用规则</th>
                                <td>
                                    <textarea name="content" id="description" class="valid" style="width: 500px; height: 150px;">{$data.content}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>审核</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label>
                                                <input type='radio' name='status' value='1' checked>
                                                <span>审核</span></label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='status' value='0'>
                                                <span>未审核</span></label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>

    <link rel="stylesheet" type="text/css" href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function () {
            $("#uploadify").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method': 'post',
                'folder': '/Uploads/images/',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    getResult(response);//获得上传的文件路径
                }
            });
            var imgg = $("#image");
            function getResult(content) {
                imgg.val(content);
            }
            $("input[name='type']:radio").click(function () {
                if ($(this).val() == 5) {
                    $("#percentstr").show();
                    $("#pricestr").show();
                    $("#vstr").hide();
                } else {
                    if ($(this).val() == 4) {
                        $("#vstr").hide();
                        $("#pricestr").show();
                    } else {
                        $("#vstr").show();
                        $("#pricestr").hide();
                    }
                    $("#percentstr").hide();
                }
            });

        });
    </script>
</body>
</html>