<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav" />
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/House/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10">
                    <span class="mr20">
                        时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">
                        关键字：
                        <select class="select_2" name="searchtype" >
                            <option value='0' <if condition=" $searchtype eq '0' "> selected</if>>用户名</option>
                            <option value='3' <if condition=" $searchtype eq '3' "> selected</if>>手机</option>
                            <option value='4' <if condition=" $searchtype eq '4' "> selected</if>>ID</option>
                        </select>
                        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="" placeholder="请输入关键字...">
                        <button class="btn">搜索</button>
                    </span>
                </div>
            </div>
        </form>

        <form action="{:U('Admin/House/action')}" method="post">
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="10%" align="center">ID</td>
                            <td width="15%" align="center">用户昵称</td>
                            <td width="15%" align="center">手机号码</td>
                            <td width="20%" align="center">抽奖码</td>
                            <td width="20%" align="center">获取时间</td>
                            <td width="20%" align="center">管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <volist name="data" id="vo">
                            <tr>
                                <td align="center">{$vo.id}</td>
                                <td align="center">{$vo.nickname}</td>
                                <td align="center">{$vo.phone}</td>
                                <td align="center">{$vo.code}</td>
                                <td align="center">{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                                <td align="center">
                                        <a href="{:U('Admin/House/pool',array('pid'=>$vo['uid'],'id'=>$hid))}">下级抽奖码</a>
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

    <script src="__JS__/common.js?v"></script>
</body>
</html>