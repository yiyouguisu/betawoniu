<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav" />


        <form action="{:U('Admin/Partycate/listorder')}" method="post">
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <td width="5%" align="center">排序</td>
                            <td width="5%" align="center">ID</td>
                            <td width="45%" align="left">特色名称</td>
                            <td width="15%" align="center">添加时间</td>
                            <td width="15%" align="center">管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <volist name="data" id="vo">
                        <tr>
                            <td align="center" ><input name='listorders[{$vo.id}]' class="input length_1 mr5"  type='number' size='3' value='{$vo.listorder}' align="center"></td>
                            <td align="center" >{$vo.id}</td>
                            <td align="left" >{$vo.catname}</td>
                            <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                            <td align="center" > 
                              <a href="{:U('Admin/Partycate/edit',array('id'=>$vo['id']))}" >修改</a> 
                              <a href="{:U('Admin/Partycate/delete',array('id'=>$vo['id']))}"  class="del">删除</a>  
                            </td>
                        </tr>
                    </volist>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages">{$Page} </div>
                </div>
            </div>

            <div class="btn_wrap">
                <div class="btn_wrap_pd">
                    <if condition="authcheck('Admin/Partycate/listorder')">
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="listorder" >排序</button>
                    </if>


                </div>
            </div>
        </form>
    </div>

    <script src="__JS__/common.js?v"></script>
</body>
</html>