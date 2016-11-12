<include file="common:head" />
<body class="j_scroll_fixed">
    <div class="wrap j_check_wrap">
        <include file="common:nav" />
        <div class="h_a">搜索</div>
        <form method="get" action="{:u('admin/trip/index')}" onsubmit="return checkLegal();">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10">
                    <span class="mr20">
                        开始时间：
                        <input type="date" name="start_time" class="input length_2 j_date" value="{$Think.get.start_time}" style="width:115px;">
                        结束时间：
                        <input type="date" class="input length_2 j_date" name="end_time" value="{$Think.get.end_time}" style="width:115px;">
                        创建时间：
                        <input type="date" class="input length_2 j_date" name="input_start" value="{$Think.get.input_start}" style="width:115px;"> -
                        <input type="date" class="input length_2 j_date" name="input_end" value="{$Think.get.input_end}" style="width:115px;">
                        行程状态：
                        <select class="select_2" name="status" style="width:70px;">
                            <option value=""  <empty name="think.get.status">selected</empty>>全部</option>
                            <option value="1" <if condition=" $think.get.status eq '1'"> selected</if>>未开始</option>
                            <option value="2" <if condition=" $think.get.status eq '2'"> selected</if>>进行中</option>
                            <option value="3" <if condition=" $think.get.status eq '3'"> selected</if>>已结束</option>
                        </select>
                        关键字：
                        <select class="select_2" name="searchtype" style="width:70px;">
                            <option value='0' <if condition=" $searchtype eq '0' "> selected</if>>标题</option>
                            <option value='1' <if condition=" $searchtype eq '1' "> selected</if>>描述</option>
                            <option value='2' <if condition=" $searchtype eq '2' "> selected</if>>用户名</option>
                            <option value='3' <if condition=" $searchtype eq '3' "> selected</if>>手机号</option>
                        </select>
                        <input type="text" class="input length_2" name="keyword" style="width:150px;" value="{$Think.get.keyword}" placeholder="请输入关键字...">
                        <button class="btn">搜索</button>
                    </span>
                </div>
            </div>
        </form>

        <form action="{:u('admin/hostel/action')}" method="post">
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%" align="center">id</td>
                            <td width="10%" align="center">标题</td>
                            <td width="10%" align="center">描述</td>
                            <td width="15%" align="center">时间</td>
                            <td width="4%" align="center">天数</td>
                            <td width="8%" align="center">状态</td>
                            <td width="5%" align="center">公开</td>
                            <td width="15%" align="center">创建时间</td>
                            <td width="8%" align="center">用户名</td>
                            <td width="8%" align="center">手机号</td>
                            <td width="12%" align="center">管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <volist name="data" id="vo">
                            <tr>
                                <td align="center">{$vo.id}</td>
                                <td align="center">{$vo.title}</td>
                                <td align="center">
                                  {$vo.description}
                                </td>
                                <td align="center">
                                  {$vo.starttime|date="Y-m-d",###} 到 {$vo.endtime|date="Y-m-d",###}
                                </td>
                                <td align="center">{$vo.days}</td>
                                <td align="center">{$vo.status}</td>
                                <td align="center">
                                  <if condition="$vo.ispublic eq 0">
                                    否
                                  <else />
                                    是
                                  </if>
                                </td>
                                <td align="center">{$vo.inputtime|date="Y-m-d H:i:s", ###}</td>
                                <td align="center">{$vo.username}</td>
                                <td align="center">{$vo.phone}</td>
                                <td align="center">
                                  <button class="btn btn_submit mr10">查看</button>
                                  <button class="delete-trip btn btn_submit mr10" data-title="{$vo.title}" data-id="{$vo.id}" data-url="{:U('Trip/delete')}">删除</button>
                                </td>
                            </tr>
                        </volist>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages"> {$Page} </div>
                </div>
            </div>
        </form>
    </div>
    <script src="__js__/common.js?v"></script>
    <script src="__js__/content_addtop.js"></script>
    <script>
      $('.delete-trip').click(function(evt) {
        evt.preventDefault();
        var that = $(this);
        var title = that.data('title');
        var conf = confirm('您确定要删除行程：' + title);
        if(conf) {
          var url = that.data('url');
          var id = that.data('id');
          $.ajax({
            url: url,
            data: { 'id': id },
            dataType: 'json',
            type: 'post',
            success: function(data) {
              if(data.code) {
                alert('行程 ' + title + ' 已删除！');
                window.location.reload();
              } else {
                alert(data.res);
              }
            },
            error: function(err, data) {
              alert('网络错误，请联系系统管理员！');
            }
          });
        }
      });
    </script>
</body>
</html>
