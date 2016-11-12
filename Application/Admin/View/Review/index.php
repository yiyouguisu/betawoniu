<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">

        <include file="Common:Nav" />

        <div class="table_list">
            <div class="h_a">搜索</div>
            <form method="get" action="{:U('Admin/review/index')}">
                <input type="hidden" value="1" name="search">
                <div class="search_type cc mb10">
                    <div class="mb10">
                        <span class="mr20">
                            评论时间：
                            <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                            -
                            <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">
                            评论类型：
                            <select class="select_2" name="varname" style="width:80px;">
                                <option value=""  <empty name="Think.get.varname">selected</empty>>全部</option>
                                <option value="note" <if condition=" $Think.get.varname eq 'note'"> selected</if>>游记</option>
                                <option value="party" <if condition=" $Think.get.varname eq 'party'"> selected</if>>活动</option>
                                <option value="hostel" <if condition=" $Think.get.varname eq 'hostel'"> selected</if>>美宿</option>
                                <option value="room" <if condition=" $Think.get.varname eq 'room'"> selected</if>>房间</option>
                                <option value="trip" <if condition=" $Think.get.varname eq 'trip'"> selected</if>>行程</option>
                            </select>
                            关键字：
                            <select class="select_2" name="searchtype">
                                <option value='0' <if condition=" $searchtype eq '0' "> selected</if>>内容</option>
                                <option value='1' <if condition=" $searchtype eq '1' "> selected</if>>反馈人</option>
                                <option value='2' <if condition=" $searchtype eq '2' "> selected</if>>ID</option>
                            </select>
                            <input type="text" class="input length_2" name="keyword" value="" placeholder="请输入关键字...">
                            <input type="hidden" class="input length_2" name="uid" value="{$_GET['uid']}" >
                            <button class="btn">搜索</button>
                        </span>
                    </div>
                </div>
            </form>
            <form action="{:U('Admin/review/del')}" method="get">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="4%" align="center"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="4%" align="center">序号</td>
                            <td width="10%" align="center">用户名</td>
                            <td width="20%" align="left">标题</td>
                            <td width="35%" align="left">内容</td>
                            <td width="12%" align="center">发布时间</td>
                            <td width="8%" align="center">操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <foreach name="data" item="vo">
                            <tr>
                                <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.id}"></td>
                                <td align="center">{$vo.id}</td>
                                <td align="center">{:getuserinfo($vo['uid'])}</td>
                                <td align="left">【{$vo.vaname}】{$vo.title}</td>
                                <td align="left">{$vo.content}</td>
                                <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                                <td align="center">
                                    <if condition="authcheck('Admin/review/delete')">
                                        <a href="{:U('Admin/review/delete',array('id'=>$vo['id']))}" class="del">删除 </a>
                                        <else />
                                        <font color="#cccccc">删除 </font>
                                    </if>
                                </td>
                            </tr>
                        </foreach>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages"> {$Page} </div>
                </div>
        </div>
        <div class="btn_wrap">
            <div class="btn_wrap_pd">
                <label class="mr20">
                    <input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选
                </label>
                <if condition="authcheck('Admin/review/del')">
                    <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">删除</button>
                </if>
            </div>
        </div>
        </form>
    </div>
    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
</body>
</html>