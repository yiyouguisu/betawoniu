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
            <form method="post"  action="{:U('Admin/Tag/add')}">
                <div class="h_a">信息详情</div>
                <div class="table_full">
                    <table width="100%" class="table_form contentWrap">
                        <tbody>
                            <tr>
                                <th width="80">标签：</th>
                                <td><input type="text" name="tag" value="{$data.tag}" class="input"/></td>
                            </tr>
                            <tr>
                                <th width="80">美宿：</th>
                                <td><input type="text" name="hostel" value="{$data.hostel}" class="input"/></td>
                            </tr>
                            <tr>
                                <th width="80">景点：</th>
                                <td><input type="text" name="place" value="{$data.place}" class="input"/>
                                </td>
                            </tr>
                              <tr>
                                <th>热门</th>
                                <td>
                                  <ul class="switch_list cc ">
                  <li>
                    <label>
                      <input type='radio' name='ishot' value='1'>
                      <span>是</span></label>
                  </li>
                  <li>
                    <label>
                      <input type='radio' name='ishot' value='0' checked >
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
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
     <script src="__JS__/common.js?v"></script>

</body>
</html>