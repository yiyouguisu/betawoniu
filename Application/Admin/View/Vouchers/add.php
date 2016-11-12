<include file="Common:Head" />
<include file="Common:ueditor" />
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
            <form method="post" action="{:U('Admin/Vouchers/add')}">
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
                            
                            <tr id="logo">
                                <th>展示图：</th>
                                <td>
                                    <input type="text" name="thumb" id="image" class="input length_5" value="{$data.thumb}" style="float: left" runat="server" ondblclick='image_priview(this.value);'>&nbsp;
                                    <input type="button" class="button" value="选择上传" id="uploadify">
                                    <span class="gray">双击文本框查看图片</span></td>
                            </tr>
                            <tr>
                                <th width="100">用途分类</th>
                                <td>
                                  <ul class="switch_list cc ">
                                      <li>
                                        <label>
                                          <input type='radio' name='voucherstype' value='all' checked>
                                          <span>全部</span></label>
                                      </li>
                                      <li>
                                        <label>
                                          <input type='radio' name='voucherstype' value='hostel' >
                                          <span>美宿</span></label>
                                      </li>
                                      <li>
                                        <label>
                                          <input type='radio' name='voucherstype' value='party'>
                                          <span>活动</span></label>
                                      </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th width="100">适用范围</th>
                                <td>
                                  <ul class="switch_list cc ">
                                      <li>
                                        <label>
                                          <input type='radio' name='voucherscale' value='all' checked>
                                          <span>全部</span></label>
                                      </li>
                                      <li>
                                        <label>
                                          <input type='radio' name='voucherscale' value='area' >
                                          <span>区域范围</span></label>
                                      </li>
                                      <li>
                                        <label>
                                          <input type='radio' name='voucherscale' value='assign'>
                                          <span>特定</span></label>
                                      </li>
                                    </ul>
                                </td>
                            </tr>

                            <tr id="area" style="display:none;">
                                <th>城市</th>
                                <td>
                                    <select class="select_1" name="city"  style="width:100px;">
                                        <option value="">全部</option>
                                        <volist name="city" id="vo">
                                            <option value="{$vo.id}" >{$vo.name}</option>
                                        </volist>
                                    </select>
                                </td>
                            </tr>
                            <tr id="hostel" style="display:none;">
                                <th width="80">优惠券适用美宿</th>
                                <td>
                                    <ul class="switch_list cc hostelmorelist">
                                        <volist name="hostel" id="vo">
                                            <li style="width: 260px;">
                                                <label>
                                                    <input type='checkbox' name='hid[]' value='{$vo.id}'><span>{:str_cut($vo['title'],10)}</span></label>
                                            </li>
                                        </volist>
                                    </ul>
                                    <a href="javascript:;" class="hostelmore">加载更多</a>
                                </td>
                            </tr>
                            <tr id="party" style="display:none;">
                                <th width="80">优惠券适用活动</th>
                                <td>
                                    <ul class="switch_list cc partymorelist">
                                        <volist name="party" id="vo">
                                            <li style="width: 260px;">
                                                <label>
                                                    <input type='checkbox' name='aid[]' value='{$vo.id}'><span>{:str_cut($vo['title'],10)}</span></label>
                                            </li>
                                        </volist>
                                    </ul>
                                    <a href="javascript:;" class="partymore">加载更多</a>
                                </td>
                            </tr>
                            <script>
                                $(function () {
                                    var hp = 2;
                                    $(".hostelmore").click(function () {
                                        $.get("{:U('Admin/Vouchers/ajax_getmorehostel')}",{"p":pp},function(data){
                                                var ahtml="";
                                                $.each(data,function(index,item){
                                                    ahtml += "<li style=\"width: 260px;\">";
                                                    ahtml += "<label>";
                                                    ahtml += "<input type='checkbox' name='hid[]' value='" + item.id + "'><span>" + item.title + "</span></label>";
                                                    ahtml += "</li>";
                                                })
                                                $(".hostelmorelist").append(ahtml);
                                                hp++;
                                        });
                                    })
                                    var pp = 2;
                                    $(".partymore").click(function () {
                                        $.get("{:U('Admin/Vouchers/ajax_getmoreparty')}",{"p":pp},function(data){
                                                var ahtml="";
                                                $.each(data,function(index,item){
                                                    ahtml += "<li style=\"width: 260px;\">";
                                                    ahtml += "<label>";
                                                    ahtml += "<input type='checkbox' name='aid[]' value='" + item.id + "'><span>" + item.title + "</span></label>";
                                                    ahtml += "</li>";
                                                })
                                                $(".partymorelist").append(ahtml);
                                                pp++;
                                        });
                                    })
                                })
                            </script>
                            <tr id="pricestr">
                                <th>优惠券价格</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="price" class="input length_2" placeholder="请输入优惠券价格" id="price" value="{$data.price}">
                                </td>
                            </tr>
                            <tr id="pricestr">
                                <th>兑换积分</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="exchange_integral" class="input length_2" placeholder="请输入兑换积分（不可兑换为-1）" id="exchange_integral" value="-1">
                                </td>
                            </tr>
                            <tr>
                                <th>优惠券适用规则</th>
                                <td>消费满<input type="text" name="range" class="input length_2"  placeholder="请输入优惠券金额" id="range" value="{$data.range}">元可使用
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
                                <th>优惠券使用说明</th>
                                <td>
                                    <textarea name="content" id="content" class="valid" style="width: 100%; height: 500px;">{$data.content}</textarea>
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
            $("input[name='voucherstype']:radio").click(function () {
                var voucherscale=$("input[name='voucherscale']:checked").val();
                if ($(this).val() == "all") {
                    if (voucherscale == "all") {
                        $("#area").hide();
                        $("#hostel").hide();
                        $("#party").hide();
                    } else if (voucherscale == "area") {
                        $("#area").show();
                        $("#hostel").hide();
                        $("#party").hide();
                    } else if (voucherscale == "assign") {
                        $("#area").hide();
                        $("#hostel").show();
                        $("#party").show();
                    }
                } else if ($(this).val() == "hostel") {
                    if (voucherscale == "all") {
                        $("#area").hide();
                        $("#hostel").hide();
                        $("#party").hide();
                    } else if (voucherscale == "area") {
                        $("#area").show();
                        $("#hostel").hide();
                        $("#party").hide();
                    } else if (voucherscale == "assign") {
                        $("#area").hide();
                        $("#hostel").show();
                        $("#party").hide();
                    }
                } else if ($(this).val() == "party") {
                    if (voucherscale == "all") {
                        $("#area").hide();
                        $("#hostel").hide();
                        $("#party").hide();
                    } else if (voucherscale == "area") {
                        $("#area").show();
                        $("#hostel").hide();
                        $("#party").hide();
                    } else if (voucherscale == "assign") {
                        $("#area").hide();
                        $("#hostel").hide();
                        $("#party").show();
                    }
                }
            });
            $("input[name='voucherscale']:radio").click(function () {
                var voucherstype=$("input[name='voucherstype']:checked").val();
                if ($(this).val() == "all") {
                    $("#area").hide();
                    $("#hostel").hide();
                    $("#party").hide();
                } else if ($(this).val() == "area") {
                    $("#area").show();
                    $("#hostel").hide();
                    $("#party").hide();
                } else if ($(this).val() == "assign") {
                    $("#area").hide();
                    if(voucherstype=="hostel"){
                        $("#hostel").show();
                        $("#party").hide();
                    }else if(voucherstype=="party"){
                        $("#party").show();
                        $("#hostel").hide();
                    }else if(voucherstype=="all"){
                        $("#hostel").show();
                        $("#party").show();
                    }
                }
            });
        });
    </script>
</body>
</html>
