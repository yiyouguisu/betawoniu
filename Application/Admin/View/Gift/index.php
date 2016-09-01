<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <form action="{:U('Admin/Gift/action')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%" align="center" >ID</td>
                            <td width="10%" align="center" >奖品等级</td>
                            <td width="15%" align="center" >奖品名称</td>
                            <td width="10%" align="center" >中奖概率</td>
                            <td width="10%" align="center" >最小角度</td>
                            <td width="10%" align="center" >最大角度</td>
                            <!-- <td width="10%" align="center" >奖品数量</td>
                            <td width="10%" align="center" >每日奖品数量</td> -->
                            <td width="15%"  align="center" >添加时间</td>
                            <td width="10%"  align="center" >添加人</td>
                            <td width="20%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr>
                            <td align="center" >{$vo.id}</td>
                            <td align="center" >
                                <if condition="$vo['rank'] eq 1">一等奖</if>
                                <if condition="$vo['rank'] eq 2">二等奖</if>
                                <if condition="$vo['rank'] eq 3">三等奖</if>
                                <if condition="$vo['rank'] eq 4">四等奖</if>
                                <if condition="$vo['rank'] eq 5">五等奖</if>
                                <if condition="$vo['rank'] eq 6">六等奖</if>
                            </td>
                            <td align="center" >{$vo.prize}</td>
                            <td align="center" >{$vo.v}%</td>
                            <td align="center" >{$vo.min}°</td>
                            <td align="center" >{$vo.max}°</td>
                            <!-- <td align="center" >
                                <if condition="$vo['num'] eq ''">不限制</if>
                                <if condition="$vo['num'] neq ''">{$vo.num}</if>
                            </td>
                            <td align="center" >
                                <if condition="$vo['daynum'] eq ''">未设置</if>
                                <if condition="$vo['daynum'] neq ''">{$vo.daynum}</if>
                            </td> -->
                            <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                            <td align="center" >{$vo.username}</td>
                            <td align="center" > 
                                <if condition="authcheck('Admin/Gift/edit')">
              <a href="{:U('Admin/Gift/edit',array('id'=>$vo['id']))}" >修改</a> 
                <else/>
                 <font color="#cccccc">修改</font>
              </if> 
                            <if condition="authcheck('Admin/Gift/delete')">
              <a href="{:U('Admin/Gift/delete',array('id'=>$vo['id']))}"  class="del">删除</a> 
                <else/>
                 <font color="#cccccc">删除</font>
              </if> 
                                
                               
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