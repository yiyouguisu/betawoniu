<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
        <include file="Common:Nav"/>

        <form action="{:U('Admin/Coupons/action')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%" align="center" >ID</td>
                            <td width="15%" align="center" >中奖类别</td>
                            <td width="10%" align="center" >用户昵称</td>
                            <td width="10%" align="center" >手机号码</td>
                            <td width="10%" align="center" >抽奖码总数</td>
                            <td width="10%" align="center" >抽奖码</td>
                            <td width="13%"  align="center" >有效时间</td>
                            <td width="12%"  align="center" >中奖时间</td>
                             <td width="12%"  align="center" >短信通知</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr>
                            <td align="center" >{$vo.id}</td>
                            <td align="center" >{$vo.title}</td>
                            <td align="center" >{$vo.username}</td>
                            <td align="center" >{$vo.phone}</td>
                            <td align="center" >{$vo.num|default="0"}</td>
                            <td align="center" >{$vo.code}</td>
                            <td align="center" >{$vo.validity_starttime|date="Y-m-d H:i:s",###}--{$vo.validity_endtime|date="Y-m-d H:i:s",###}</td>
                            <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                            <if condition="$vo.hassms eq 1 ">
                                <td align="center" >已通知</td>
                            <else /> 
                                <td align="center" ><a href="{:U('Admin/Vote/postsms',array('coid'=>$vo['id']))}"  >短信单发</a>    </td>
                            </if>
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
    <script src="__JS__/content_addtop.js"></script>
</body>
</html>