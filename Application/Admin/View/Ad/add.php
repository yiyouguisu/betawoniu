<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap jj">
        <!--   <div class="nav">
          <ul class="cc">
                <li ><a href="{:U('Admin/Menu/index')}">后台菜单管理</a></li>
                <li class="current"><a href="{:U('Admin/Menu/add')}">添加菜单</a></li>
              </ul>
        </div>-->
        <include file="Common:Nav"/>
        <div class="common-form">
            <!---->
            <form method="post"  action="{:U('Admin/Ad/add')}">
                <div class="h_a">广告信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">广告分类</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <select class="select_2" name="catid">
                                        <option value="" >请选择广告分类</option>
                                        {$category}
                                    </select>
                                </td>
                            </tr>
                            
                            <tr>
                                <th width="80">标题</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入标题" id="title" value="{$data.title}">
                                   
                                </td>
                            </tr>
                            <tr>
                                <th width="80">广告类型</th>
                                <td>
                                  <ul class="switch_list cc ">
                                    <li>
                                        <label><input type='radio' name='type' value='0' checked><span>默认广告</span></label>
                                    </li>
                                    <li>
                                        <label><input type='radio' name='type' value='1' ><span>美宿广告</span></label>
                                    </li>
                                    <li>
                                        <label><input type='radio' name='type' value='2' ><span>活动广告</span></label>
                                    </li>
                                    <li>
                                        <label><input type='radio' name='type' value='3' ><span>游记广告</span></label>
                                    </li>
                                    <li>
                                        <label><input type='radio' name='type' value='4' ><span>平台活动广告</span></label>
                                    </li>
                                  </ul>
                                </td>
                            </tr>
                            <tr id="hostel" style="display:none;">
                                <th width="80">广告链接美宿</th>
                                <td>
                                     <select name="hid">
                                        <option value="">请选择美宿</option>
                                        <volist name="hostel" id="vo">
                                            <option value="{$vo.id}">{$vo.title}</option>
                                        </volist>
                                    </select>
                                </td>
                            </tr>
                            <tr id="party"  style="display:none;">
                                <th width="80">广告链接活动</th>
                                <td>
                                     <select name="nid">
                                        <option value="">请选择活动</option>
                                        <volist name="party" id="vo">
                                            <option value="{$vo.id}">{$vo.title}</option>
                                        </volist>
                                    </select>
                                </td>
                            </tr>
                            <tr id="note" style="display:none;">
                                <th width="80">广告链接游记</th>
                                <td>
                                     <select name="aid">
                                        <option value="">请选择游记</option>
                                        <volist name="note" id="vo">
                                            <option value="{$vo.id}">{$vo.title}</option>
                                        </volist>
                                    </select>
                                </td>
                            </tr>
                            <tr id="url"  style="display:none;">
                                <th width="80">广告地址</th>
                                <td>
                                    <input type="text" name="url" class="input length_6 input_hd" placeholder="请输入链接" id="url" value="{$data.url}">
                                    <span class="gray">请填写带http://的链接</span>
                                </td>
                            </tr>

                            <tr id="logo">
                                <th>图片：</th>
                                <td><input type="text" name="image" id="image" class="input length_5" value="" style="float: left"  runat="server" ondblclick='image_priview(this.value);'>&nbsp; <input type="button" class="button" value="选择上传" id="uploadify" >    <span class="gray"> 双击文本框查看图片</span></td>
                            </tr>
                            <tr>
                                <th>广告描述</th>
                                <td>
                                    <textarea  name="description" id="description" class="valid" style="width:500px;height:80px;">{$data.description}</textarea>
                                    
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
                      <input type='radio' name='status' value='0' >
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

    <link rel="stylesheet" type="text/css"  href="__PUBLIC__/Public/uploadify/uploadify.css" />
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="__PUBLIC__/Public/uploadify/uploadify.js"></script>
    <script type="text/javascript">
        $(function(){
            $("#uploadify").uploadify({
                'uploader'  : '__PUBLIC__/Public/uploadify/uploadify.swf',//所需要的flash文件
                'cancelImg' : '__PUBLIC__/Public/uploadify/cancel.gif',//单个取消上传的图片
                // 'script' : '__PUBLIC__/Public/uploadify/uploadify.php',//实现上传的程序
                'script'    : "{:U('Admin/Public/uploadone')}",//实现上传的程序
                'method'    : 'post',
                'folder'    : '/Uploads/images/',//服务端的上传目录
                'auto'      : true,//自动上传
                'multi'     : true,//是否多文件上传
                'fileDesc': 'Image(*.jpg;*.gif;*.png)',//对话框的文件类型描述
                'fileExt': '*.jpg;*.jpeg;*.gif;*.png',//可上传的文件类型
                'sizeLimit': '',//限制上传文件的大小2m(比特b)
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
            $("input[name='type']:radio").click(function() {
                if($(this).val()==1){
                    $("#hostel").show();
                    $("#party").hide();
                    $("#note").hide();
                    $("#url").hide();
                }else if($(this).val()==2) {
                    $("#hostel").hide();
                    $("#party").show();
                    $("#note").hide();
                    $("#url").hide();
                }else if($(this).val()==3){
                    $("#hostel").hide();
                    $("#party").hide();
                    $("#note").show();
                    $("#url").hide();
                }else if($(this).val()==4){
                    $("#hostel").hide();
                    $("#party").hide();
                    $("#note").hide();
                    $("#url").show();
                }else if($(this).val()==0) {
                    $("#hostel").hide();
                    $("#party").hide();
                    $("#note").hide();
                    $("#url").hide();
                }
            });
        });
    </script>
</body>
</html>