<include file="Common:Head" />
<include file="Common:upload" />
<include file="Common:ueditor" />
<style type="text/css">
            .col-auto {
                overflow: hidden;
                _zoom: 1;
                _float: left;
                border: 1px solid #c2d1d8;
            }
            .col-right {
                float: right;
                width: 210px;
                overflow: hidden;
                margin-left: 6px;
                border: 1px solid #c2d1d8;
            }

            body fieldset {
                border: 1px solid #D8D8D8;
                padding: 10px;
                background-color: #FFF;
            }
            body fieldset legend {
                background-color: #F9F9F9;
                border: 1px solid #D8D8D8;
                font-weight: 700;
                padding: 3px 8px;
            }
            .picList li{ float: left; margin-top: 2px; margin-right: 5px;}
        </style>
<body class="J_scroll_fixed">
    <div class="wrap jj">
    
        <include file="Common:Nav"/>
        <div class="common-form">
            <!---->
            <form method="post"  action="{:U('Admin/Product/padd')}">
                <div class="h_a">产品信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">类别</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <select class="select_2" name="subcatid">
                                        <option value="" >请选择类别</option>
                                        {$category}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">产品名称</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入产品名称" id="title" value="{$data.title}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">产品编号</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="productnumber" class="input length_6 input_hd" placeholder="请输入产品编号" id="productnumber" value="{$data.productnumber}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">产品品牌</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="brand" class="input length_6 input_hd" placeholder="请输入产品品牌" id="brand" value="{$data.brand}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">产品规格</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="standard" class="input input_hd update" placeholder="请输入产品规格" id="standard" value="{$data.standard}">
                                    <select name="unit">
                                        <option value="">请选择产品单位</option>
                                        <volist name="ProductUnitConfig" id="vo">
                                            <option value="{$vo.value}">{$vo.title}</option>
                                        </volist>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>商品类型</th>
                                <td>
                                  <ul class="switch_list cc ">
                                    <li>
                                        <label><input type='radio' name='type' value='1' checked><span>一般商品</span></label>
                                    </li>
                                    <li>
                                        <label><input type='radio' name='type' value='2'><span>团购商品</span></label>
                                    </li>
                                    <li>
                                        <label><input type='radio' name='type' value='3' ><span>预购商品</span></label>
                                    </li>
                                    <li>
                                        <label><input type='radio' name='type' value='4' ><span>称重商品</span></label>
                                    </li>
                                  </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>列表页商品图：</br>120*120</th>
                                <td>
                                    <input type="text" name="thumb" id="thumb" class="input length_5" value="{$data.thumb}" style="float: left"  runat="server" ondblclick='image_priview(this.value);'>&nbsp; <input type="button" class="button upload" value="选择上传" id="thumbbtn" data-id="thumb"> <span class="gray"> 双击文本框查看图片</span>
                                </td>
                            </tr>
                            <tr>
                                <th>首页广告图：</br>750*300</th>
                                <td>
                                    <input type="text" name="extrathumb" id="extrathumb" class="input length_5" value="{$data.extrathumb}" style="float: left"  runat="server" ondblclick='image_priview(this.value);'>&nbsp; <input type="button" class="button upload" value="选择上传"  id="extrathumbbtn" data-id="extrathumb"> <span class="gray"> 双击文本框查看图片</span>
                                </td>
                            </tr>
                            <tr>
                                <th>产品原价</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="oldprice" class="input input_hd" placeholder="请输入产品原价" id="oldprice" value="{$data.oldprice}">
                                </td>
                            </tr>
                            <tr>
                                <th>产品现价</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="nowprice" class="input input_hd update" placeholder="请输入产品现价" id="nowprice" value="{$data.nowprice}">
                                </td>
                            </tr>
                            <tr class="product2" style="display:none;">
                                <th>到期时间</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="expiretime" class="input input_hd J_datetime" placeholder="请选择到期时间" id="expiretime" value="{$data.expiretime}">
                                </td>
                            </tr>
                            <tr class="product3" style="display:none;">
                                <th>出售时间</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="selltime" class="input input_hd J_datetime" placeholder="请选择出售时间" id="selltime" value="{$data.selltime}">
                                </td>
                            </tr>
                            <tr class="product3" style="display:none;">
                                <th>预付金额</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="advanceprice" class="input input_hd" placeholder="请输入产品预付金额" id="advanceprice" value="{$data.advanceprice}">
                                </td>
                            </tr>
                            <tr class="product4" style="display:none;">
                                <th>产品单价</th>
                                <td><span class="must_red">*</span>
                                    <input type="text" name="price" class="input input_hd" placeholder="请输入产品单价" id="price" value="{$data.price}" readonly>
                                </td>
                            </tr>
                            <tr class="product5" style="display:none;">
                                <th>购买基数</th>
                                <td>
                                    <input type="number" name="step" class="input input_hd" placeholder="请输入产品购买基数" id="step" value="0">
                                </td>
                            </tr>
                            <tr>
                                <th>产品库存</th>
                                <td><span class="must_red">*</span>
                                    <input type="number" name="stock" min="0" class="input input_hd" placeholder="请输入产品库存" id="stock" value="{$data.stock}">
                                </td>
                            </tr>
                            <tr>
                                <th>所属仓库</th>
                                <td><span class="must_red">*</span>
                                    <select name="storehouse">
                                        <option value="">请选择所属仓库</option>
                                        <volist name="storehouse" id="vo">
                                            <option value="{$vo.id}">{$vo.title}</option>
                                        </volist>
                                    </select>   
                                </td>
                            </tr>
                            <tr>
                                <th>产品描述</th>
                                <td><span class="must_red">*</span>
                                    <textarea  name="description" id="description" class="valid" style="width:500px;height:80px;">{$data.description}</textarea>
                                </td>
                            </tr>
                            
                              <tr>
                                <th>详情页轮播图：</br>750*400</th>
                                <td>
                                    <fieldset class="blue pad-10">
                                        <legend>图片列表</legend>
                                        <center><div class="onShow" id="nameTip">您最多每次可以同时上传 <font color="red">10</font> 张,双击文本框查看图片</div></center>
                                        <ul id="balbums" class="picList"></ul>
                                    </fieldset>

                                    <div class="bk10"></div>
                                    <input type="button" class="button btn_submit" value="选择上传" id="uploadify2" > </td>
                            </tr>
                            <tr>
                                <th>图文详情：</br>750*自定义</th>
                                <td>
                                    <fieldset class="blue pad-10">
                                        <legend>图片列表</legend>
                                        <center><div class="onShow" id="nameTip">您最多每次可以同时上传 <font color="red">10</font> 张,双击文本框查看图片</div></center>
                                        <ul id="albums" class="picList"></ul>
                                    </fieldset>

                                    <div class="bk10"></div>
                                    <input type="button" class="button btn_submit" value="选择上传" id="uploadify1" > </td>
                            </tr>
                            <!-- <tr>
                                <th>产品详情</th>
                                <td><span class="must_red">*</span>
                                    <textarea  name="content" id="content"   style="width:100%;height:500px;">{$data.content}</textarea>
                                </td>
                            </tr> -->
                            
                            <tr class="product1">
                                <th>属性</th>
                                <td>
                                  <ul class="switch_list cc ">
                  <li>
                    <label>
                      <input type='radio' name='ishot' value='1' >
                      <span>促销产品</span></label>
                  </li>
                  <li>
                    <label>
                      <input type='radio' name='ishot' value='0'  checked>
                      <span>默认</span></label>
                  </li>
                </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>下架</th>
                                <td>
                                  <ul class="switch_list cc ">
                  <li>
                    <label>
                      <input type='radio' name='isoff' value='1' >
                      <span>是</span></label>
                  </li>
                  <li>
                    <label>
                      <input type='radio' name='isoff' value='0'  checked>
                      <span>否</span></label>
                  </li>
                </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>置顶</th>
                                <td>
                                  <ul class="switch_list cc ">
                  <li>
                    <label>
                      <input type='radio' name='isindex' value='1' >
                      <span>是</span></label>
                  </li>
                  <li>
                    <label>
                      <input type='radio' name='isindex' value='0' checked>
                      <span>否</span></label>
                  </li>
                </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <input type="hidden" name="storeid" value="{$store.id}">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <script src="__JS__/common.js?v"></script>
      <script src="__JS__/content_addtop.js"></script>
    <link rel="stylesheet" type="text/css"  href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function(){
			 $("#uploadify1").uploadify({
                'uploader'	: '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg'	: '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'	: '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script'	: "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method'	: 'get',
                'folder'	: '/Uploads/images',//服务端的上传目录
                'auto'		: true,//自动上传
                'multi'		: true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': "",//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg'	: '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width'		: 80,//buttonImg的大小
                'height'	: 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    var str= "<li id='"+queueID+"'><input type='text' name='imglist[]' value='"+response+"' style='width:310px;' class='input' ondblclick='image_priview(this.value);'><a href=\"javascript:remove_div('"+queueID+"')\">移除</a></li>";
                    $("#albums").append(str);
                }
            });
            
            $("#uploadify2").uploadify({
                'uploader'  : '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg' : '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'  : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script'    : "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method'    : 'get',
                'folder'    : '/Uploads/images',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': "",//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width'     : 80,//buttonImg的大小
                'height'    : 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    var bstr= "<li id='"+queueID+"'><input type='text' name='backimglist[]' value='"+response+"' style='width:310px;' class='input' ondblclick='image_priview(this.value);'><a href=\"javascript:remove_div('"+queueID+"')\">移除</a></li>";
                    $("#balbums").append(bstr);
                }
            });
            $(".update").keyup(function(){
                var nowprice=$("input[name='nowprice']").val();
                var standard=$("input[name='standard']").val();
                if(nowprice!=''&&standard!=''){
                    var price=parseFloat(nowprice)/parseInt(standard);
                    $("input[name='price']").val(parseFloat(price).toFixed(3));
                }
                
            })
            $("input[name='type']:radio").click(function() {
                if ($(this).val() == 1) {
                    $(".product1").show();
                    $(".product2").hide();
                    $(".product3").hide();
                    $(".product4").hide();
                    $(".product5").hide();
                } else if ($(this).val() == 2) {
                    $(".product1").hide();
                    $(".product2").show();
                    $(".product3").hide();
                    $(".product4").hide();
                    $(".product5").show();
                } else if ($(this).val() == 3) {
                    $(".product1").hide();
                    $(".product2").hide();
                    $(".product3").show();
                    $(".product4").hide();
                    $(".product5").show();
                } else if ($(this).val() == 4) {
                    $(".product1").hide();
                    $(".product2").hide();
                    $(".product3").hide();
                    $(".product4").show();
                    $(".product5").hide();
                }
            });
        });
    </script>
</body>
</html>