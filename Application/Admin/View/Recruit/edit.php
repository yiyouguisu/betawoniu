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
            <form method="post"  action="{:U('Admin/Recruit/edit')}">
                <div class="h_a">招聘信息</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            
                            <tr>
                                <th width="80">职位</th>
                                <td>
                                    <span class="must_red">*</span>
                                    <input type="text" name="title" class="input length_6 input_hd" placeholder="请输入职位" id="title" value="{$data.title}">
                                </td>
                            </tr>

                            <tr>
                                <th width="80">所属美宿</th>
                                <td>
                                     <select name="hid">
                                        <option value="">请选择美宿</option>
                                        <volist name="shop" id="vo">
                                            <option value="{$vo.id}" <if condition="$data['hid'] eq $vo['id']">selected</if>>{$vo.title}</option>
                                        </volist>
                                    </select>
                                </td>
                            </tr>
                           <tr id="contenttr">
                                <th>招聘正文</th>
                                <td>
                                    <textarea name="content" id="content" style="width:100%;height:500px;">{$data.content}</textarea>
                                </td>
                            </tr>
                            <tr id="contenttr">
                                <th>联系方式</th>
                                <td>
                                    <textarea name="contact" id="contact" style="width:100%;height:500px;">{$data.contact}</textarea>
                                </td>
                            </tr>
                            <tr>
                                <th>属性</th>
                                <td>
                                  <ul class="switch_list cc ">
                  <li>
                    <label>
                      <input type='radio' name='type' value='1'  <if condition="$data['type'] eq '1' ">checked</if>>
                      <span>推荐</span></label>
                  </li>
                  <li>
                    <label>
                      <input type='radio' name='type' value='0'   <if condition="$data['type'] eq '0' ">checked</if>>
                      <span>不推荐</span></label>
                  </li>
                </ul>
                                </td>
                            </tr>
                              <tr>
                                <th>审核</th>
                                <td>
                                  <ul class="switch_list cc ">
                  <li>
                    <label>
                      <input type='radio' name='status' value='1' <if condition="$data['status'] eq '1' ">checked</if>>
                      <span>审核</span></label>
                  </li>
                  <li>
                    <label>
                      <input type='radio' name='status' value='0' <if condition="$data['status'] eq '0' ">checked</if>>
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
                        <input type="hidden" name="id" value="{$data.id}">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <script src="__JS__/common.js?v"></script>
      <script src="__JS__/content_addtop.js"></script>
</body>
</html>