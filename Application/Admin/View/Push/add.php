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
            .picList li{ float: left; margin-top: 2px; margin-right: 5px;}
        </style>
<body class="J_scroll_fixed">
    <div class="wrap jj">
    
        <include file="Common:Nav"/>
        <div class="common-form">
            <!---->
            <form method="post"  action="{:U('Admin/Push/add')}">
                <div class="h_a">推送信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">推送标题</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入标题" id="title" value="{$data.title}">
                                </td>
                            </tr>
                            <tr>
                                <th>推送摘要</th>
                                <td>
                                    <textarea  name="description" id="description" class="valid" style="width:500px;height:80px;">{$data.description}</textarea>
                                </td>
                            </tr>
                            <tr id="contenttr">
                                <th>内容正文</th>
                                <td>
                                    <textarea  name="content" id="content" style="width:100%;height:500px;">{$data.content}</textarea>
                                </td>
                            </tr>
                            
                              <tr>
                                <th>推送范围</th>
                                <td>
                                  <ul class="switch_list cc ">
                                      <li>
                                        <label>
                                          <input type='radio' name='scale' value='1' checked>
                                          <span>所有用户</span></label>
                                      </li>
                                      
                                      <li>
                                        <label>
                                          <input type='radio' name='scale' value='3' >
                                          <span>特定用户</span></label>
                                      </li>
                                     
                                    </ul>
                                </td>
                            </tr>
                            
                            <tr id="scale1" style="display:none;">
                                <th></th>
                                <td>
                                    <textarea name="name" id="name" class="valid" placeholder="请输入用户名或手机号码,多个以（,）分割" style="width: 100%; height: 150px;"></textarea>
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
      <script type="text/javascript">
        $(function(){
            $("input[name='type']:radio").click(function() {
                if($(this).val()==1) {
                    $("#shop").show();
                    $("#product").show();
                    $("#contenttr").hide();
                }else if($(this).val()==2){
                    $("#shop").hide();
                    $("#product").hide();
                    $("#contenttr").show();
                }
            });
            $("input[name='scale']:radio").click(function () {
                if ($(this).val() == 2) {
                    $("#scale").show();
                    $("#scale1").hide();
                    $("#scale2").hide();
                } else if ($(this).val() == 1) {
                    $("#scale").hide();
                    $("#scale1").hide();
                    $("#scale2").hide();
                } else if ($(this).val() == 3) {
                    $("#scale").hide();
                    $("#scale2").hide();
                    $("#scale1").show();
                } else if ($(this).val() == 4) {
                    $("#scale").hide();
                    $("#scale1").hide();
                    $("#scale2").show();
                }
            });
        });
    </script>
</body>
</html>