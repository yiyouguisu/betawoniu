<include file="Common:Head" />
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
            <form method="post"  action="{:U('Admin/Gift/edit')}">
                <div class="h_a">奖品信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">奖品名称</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="id" value="{$data.id}" style="display:none">
                                    <input type="text" name="prize" class="input length_6 input_hd" placeholder="请输入奖品名称" id="prize" value="{$data.prize}">
                                    
                                </td>
                            </tr>
                            
                            <tr>
                                <th width="80">奖品等级 </th>
                                <td>
                                    <span class="must_red">*</span>
                                    <select class="select_2" name="rank">
                                        <option value="0" <if condition="$data['rank'] eq 0">selected</if>>请选择奖品等级</option>
                                        <option value="1" <if condition="$data['rank'] eq 1">selected</if>>一等奖</option>
                                        <option value="2" <if condition="$data['rank'] eq 2">selected</if>>二等奖</option>
                                        <option value="3" <if condition="$data['rank'] eq 3">selected</if>>三等奖</option>
                                        <option value="4" <if condition="$data['rank'] eq 4">selected</if>>四等奖</option>
                                        <option value="5" <if condition="$data['rank'] eq 5">selected</if>>五等奖</option>
                                        <option value="6" <if condition="$data['rank'] eq 6">selected</if>>六等奖</option>
                                        
                                    </select>
                                    
                                </td>
                            </tr>
                            <tr>
                                <th>权重</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="v" class="input length_6 input_hd" placeholder="请填写中奖概率" id="v" value="{$data.v}">
                                    <span class="gray">请填写中奖权重</span>
                                </td>
                            </tr>
                            <tr>
                                <th>最小角度</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="min" class="input length_6 input_hd" placeholder="请填写最小角度" id="min" value="{$data.min}">
                                    <span class="gray">请填写最小角度</span>
                                </td>
                            </tr>
                            <tr>
                                <th>最大角度</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="max" class="input length_6 input_hd" placeholder="请填写最大角度" id="max" value="{$data.max}">
                                    <span class="gray">请填写最大角度</span>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">中奖提示语</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="remark" class="input length_6 input_hd" placeholder="请输入中奖提示语" id="remark" value="{$data.remark}">
                                </td>
                            </tr>
                            <!-- <tr>
                                <th >奖品有效时间</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="validity_starttime" class="input length_2 J_date" value="{$data.validity_starttime|date='Y-m-d',###}">~<input type="text" name="validity_endtime" class="input length_2 J_date" value="{$data.validity_endtime|date='Y-m-d',###}">
                                </td>
                            </tr>
                            <tr>
                                <th>奖品数量</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="num" class="input length_6 input_hd" placeholder="请填写奖品数量" id="num" value="{$data.num}">
                                    <span class="gray">请填写奖品数量</span>
                                </td>
                            </tr>
                            <tr>
                                <th>每日奖品数量</th>
                                <td>
                                    <input type="text" name="daynum" class="input length_6 input_hd" placeholder="请填写奖品数量" id="daynum" value="{$data.daynum}">
                                    <span class="gray">请填写每日奖品数量</span>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <script src="__JS__/common.js?v"></script>
      <script src="__JS__/content_addtop.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('content',{toolbar : 'Full'});
    </script>
    <link rel="stylesheet" type="text/css"  href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#uploadify").uploadify({
                'uploader'  : '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg' : '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                'script'    : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                //'script'  : "{:U('Admin/Public/upload')}",//实现上传的程序
                'method'    : 'get',
                'folder'    : '/Uploads/images',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': 2100000,//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width'     : 80,//buttonImg的大小
                'height'    : 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    getResult(response);//获得上传的文件路径
                }
            });
          
            var imgg = $("#image");
            function getResult(content){        
                imgg.val(content);
            }

            var imgg1 = $("#image2");
            function getResult1(content){        
                imgg1.val(content);
            }
            
               $("#uploadify2").uploadify({
                'uploader'  : '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg' : '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                'script'    : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                //'script'  : "{:U('Admin/Public/upload')}",//实现上传的程序
                'method'    : 'get',
                'folder'    : '/Uploads/images',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': 2100000,//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width'     : 80,//buttonImg的大小
                'height'    : 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    // alert(response);
                
                    getResult1(response);//获得上传的文件路径
                }
            });
             $("#uploadify1").uploadify({
                'uploader'  : '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg' : '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                'script'    : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                //'script'  : "{:U('Admin/Public/upload')}",//实现上传的程序
                'method'    : 'get',
                'folder'    : '/Uploads/images',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': 2100000,//限制上传文件的大小2m(比特b)
                'queueSizeLimit' :10, //可上传的文件个数
                'buttonImg' : '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width'     : 80,//buttonImg的大小
                'height'    : 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    // alert(response);
                    getResultimglist(response,queueID);//获得上传的文件路径
                }
            });
            var albums = $("#albums");
            var str="";
            function getResultimglist(content,queueID){
                str= "<li id='"+queueID+"'><input type='text' name='imglist[]' value='"+content+"' style='width:310px;' class='input' ondblclick='image_priview(this.value);'><a href=\"javascript:remove_div('"+queueID+"')\">移除</a></li>";
                albums.append(str);
            }
            if ($("input[name='islink']:checkbox").attr("checked")) {
                $("#linktr").show();
                $("#contenttr").hide();
            } else {
                $("#contenttr").show();
                $("#linktr").hide();
            }
            $("input[name='islink']:checkbox").click(function() {
                if ($(this).attr("checked")) {
                    $("#linktr").show();
                    $("#contenttr").hide();
                } else {
                    $("#contenttr").show();
                    $("#linktr").hide();
                }
            })
        });
    </script>
</body>
</html>