<include file="Common:Head" />
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

    .picList li {
        float: left;
        margin-top: 2px;
        margin-right: 5px;
    }
</style>
<body class="J_scroll_fixed">
    <div class="wrap jj">
        <include file="Common:Nav" />
        <div class="common-form">
            <form method="post" action="{:U('Admin/Inn/add')}">
                <div class="h_a">评选美宿信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">美宿名称</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="name" class="input length_6 input_hd" placeholder="请输入名称" id="title" value="{$data.name}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">美宿地址</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="address" class="input length_6 input_hd" placeholder="请输入地址" id="address" value="{$data.address}">
                                </td>
                            </tr>
                            <tr id="img">
                                <th>美宿logo：</th>
                                <td>
                                    <div class="thumb" style="display:inline-block;"><img src="{$data.logo}"  width='200px' height='132px'></div><input type="hidden" id="logo" name="logo" value="{$data.logo}" style="float: left"  runat="server">&nbsp; <input type="button" class="button" value="选择上传" id="uploadify" ><span class="gray">*logo图片的尺寸必须为600*400</span>
                                </td>
                            </tr>
                            <tr id="imagelist">
                                <th>美宿描述：</th>
                                <td>
                                    <fieldset class="blue pad-10">
                                        <legend>图片</legend>
                                        <center><div class="onShow" id="nameTip">您最多每次可以同时上传 <font color="red">3</font> 张,双击图片移除</div></center>
                                        <ul id="albums" class="picList">
                                            <notempty name="imglist">
                                                <volist name="imglist" id="vo">
                                                    <li id='imglist{$i}'>
                                                        <img class="img" src='{$vo.thumb}' style='width:210px;' title='移除' >
                                                        <input type='hidden' name="imglist[{$key}][thumb]" value='{$vo.thumb}'/>
                                                    </li>
                                                </volist>
                                            </notempty>
                                        </ul>
                                    </fieldset>
                                    <div class="bk10"></div>
                                    <input type="button" class="button btn_submit" value="选择上传" id="uploadify1">
                                </td>
                            </tr>
                            <tr>
                                <th>描述:</th>
                                <td>
                                    <textarea name="description" id="description" class="valid" style="width:500px;height:80px;">{$data.description}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th width="80">美宿主人名称:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="ownner" class="input length_6 input_hd" placeholder="请输入美宿主人名称" id="ownner" value="{$data.ownner}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">主人联系方式:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="contact" class="input length_6 input_hd" placeholder="请输入主人联系方式" id="contact" value="{$data.contact}">
                                </td>
                            </tr>
                            <tr>
                                <th>参与试睡抽奖:</th>
                                <td>
                                    <ul class="switch_list cc ">
                                        <li>
                                            <label>
                                                <input type='radio' name='isvote' value='1'  <if condition="$data['isvote'] eq '1' ">checked</if>>
                                                <span>是</span>
                                            </label>
                                        </li>
                                        <li>
                                            <label>
                                                <input type='radio' name='isvote' value='0'   <if condition="$data['isvote'] eq '0' ">checked</if>>
                                                <span>否</span>
                                            </label>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <th>试睡时间:</th>
                                <td>
                                    <input type="text" name="starttime" class="input length_2 J_date" value="{$data.starttime}" style="width:120px;">
                                    
                                    <input type="text" class="input length_2 J_date" name="endtime" value="{$data.endtime}" style="width:120px;">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">奖品数量:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="roomnum" class="input length_6 input_hd" placeholder="请输入奖品数量" id="roomnum" value="{$data.roomnum}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">一等奖:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize1desc" class="input length_6 input_hd" placeholder="请输入一等奖" id="prize1desc" value="{$data.prize1desc}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">一等奖数量:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize1" class="input length_6 input_hd" placeholder="请输入一等奖数量" id="prize1" value="{$data.prize1}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">二等奖:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize2desc" class="input length_6 input_hd" placeholder="请输入二等奖" id="prize2desc" value="{$data.prize2desc}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">二等奖数量:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize2" class="input length_6 input_hd" placeholder="请输入二等奖数量" id="prize2" value="{$data.prize2}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">三等奖:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize3desc" class="input length_6 input_hd" placeholder="请输入三等奖" id="prize3desc" value="{$data.prize3desc}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">三等奖数量:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize3" class="input length_6 input_hd" placeholder="请输入三等奖数量" id="prize3" value="{$data.prize3}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">四等奖:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize4desc" class="input length_6 input_hd" placeholder="请输入四等奖" id="prize4desc" value="{$data.prize4desc}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">四等奖数量:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize4" class="input length_6 input_hd" placeholder="请输入四等奖数量" id="prize4" value="{$data.prize4}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">五等奖:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize5desc" class="input length_6 input_hd" placeholder="请输入五等奖" id="prize5desc" value="{$data.prize5desc}">
                                </td>
                            </tr>
                            <tr>
                                <th width="80">五等奖数量:</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="prize5" class="input length_6 input_hd" placeholder="请输入五等奖数量" id="prize5" value="{$data.prize5}">
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
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
        var xss=parseInt({$key})||0;
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
                'buttonImg': '__PUBLIC__/Public/uploadify/upload.gif',//替换上传钮扣
                'width': 202,//buttonImg的大小
                'height': 152,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    //alert(response);
                    $(".thumb").html("<img src='"+response+"' width='200px' height='132px'  />");
                    $("input[name='logo']").val(response);
                }
            });

            var imgg = $("#image");
            function getResult(content) {
                imgg.val(content);
            }

            $("#uploadify1").uploadify({
                'uploader': '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg': '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                //'script'  : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script': "{:U('Admin/Public/upload')}",//实现上传的程序
                'method': 'get',
                'folder': '/Uploads/images',//服务端的上传目录
                'auto': true,//自动上传
                'multi': true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': "",//限制上传文件的大小2m(比特b)
                'queueSizeLimit': 10, //可上传的文件个数
                'buttonImg': '__PUBLIC__/Public/uploadify/add.gif',//替换上传钮扣
                'width': 80,//buttonImg的大小
                'height': 26,
                onComplete: function (evt, queueID, fileObj, response, data) {
                    // alert(response);
                    getResultimglist(response, queueID);//获得上传的文件路径
                }
            });
            var albums = $("#albums");
            var str = "";
            function getResultimglist(content, queueID) {
                str = "<li id='imglist" + xss + "'>";
                str=str+"<img class='img' src='" + content + "' style='width:200px;height:132px' title='移除'>";
                str = str+"<input type='hidden' name=\"imglist["+xss+"][thumb]\" value='" + content + "' style='width:310px;' class='input'>";
                str = str+"</li>";
                albums.append(str);
                xss++;
                $(".img").dblclick(function(){
                    $(this).parent("li").remove();
                });
            }
            $(".img").dblclick(function(){
                $(this).parent("li").remove();
            });
        });
    </script>
</body>
</html>