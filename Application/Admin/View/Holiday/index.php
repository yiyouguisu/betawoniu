<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">

<include file="Common:Nav"/>
<form name="myform" action="{:U('Admin/Holiday/listorder')}" method="post">
   <div class="table_list">
   <table width="100%" cellspacing="0">
       <thead>
          <tr>
            <td align='center'>排序</td>
            <td width="4%" align="center" >序号</td>
            <td width="12%" align="center" >节假日名称</td>
            <td width="12%" align="center" >起始时间</td>
            <td width="12%" align="center" >结束时间</td>
            <td width="12%" align="center" >天数</td>
            <td width="12%" align="center" >添加时间</td> 
            <td width="12%" align="center" >修改时间</td> 
            <td width="12%" align="center" >管理操作</td>
          </tr>
        </thead>
        <tbody>
     
          
        <foreach name="data" item="vo">
          <tr>
            <td align='center'><input name='listorders[{$vo.id}]' type='number' size='3' value='{$vo.listorder}' class='input length_1'></td>
            <td align="center">{$vo.id}</td>
            <td align="center" >{$vo.name}</td>
            <td align="center" >{$vo.startdate|date="Y-m-d",###}</td>
            <td align="center">{$vo.enddate|date="Y-m-d",###}</td>
            <td align="center" >{$vo.days}天</td>
            <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
            <td align="center">
              <empty name="vo.updatetime">
                <span style="color:gray">未修改</span>
                <else />
                {$vo.updatetime|date="Y-m-d H:i:s",###}
              </empty>
            </td>
            <td  align="center" >
              <a href="{:U('Admin/Holiday/edit', array('id' => $vo['id']))}">修改</a>  |
              <a href="{:U('Admin/Holiday/delete', array('id' => $vo['id']))}">删除</a>
            </td> 
          </tr>
         </foreach>
        </tbody>
      </table>
            <div class="p10">
                    <div class="pages"> {$Page} </div>
                </div>
   </div>
</div>
<div class="btn_wrap">
      <div class="btn_wrap_pd">
        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">排序</button>
      </div>
      </form>
    </div>
<script src="__JS__/common.js?v"></script>
<script src="__JS__/content_addtop.js"></script>
</body>
</html>