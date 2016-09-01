<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/Choujiang/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> <span class="mr20">
                        中奖时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">
                        关键字：
                        <select class="select_2" name="searchtype" style="width:70px;">
                            <option value='0' <if condition=" $searchtype eq '0' "> selected</if>>中奖等级</option>
                            <option value='3' <if condition=" $searchtype eq '3' "> selected</if>>ID</option>
                        </select>
                        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="" placeholder="请输入关键字...">
                        <button class="btn">搜索</button>
                    </span> </div>
            </div>
        </form> 

        <form action="{:U('Admin/Choujiang/action')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="5%" align="center">排序</td>
                            <td width="10%" align="center" >ID</td>
                            <td width="15%"  align="center" >中奖用户</td>
                            <td width="20%" align="center" >奖品名称</td>
                            <td width="20%" align="center" >奖品等级</td>
                            <td width="20%"  align="center" >抽奖时间</td>
                            <td width="15%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr>
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.id}"></td>
                            <td align="center" ><input name='listorders[{$vo.id}]' class="input length_1 mr5"  type='number' size='3' value='{$vo.listorder}' align="center"></td>
                            <td align="center" >{$vo.id}</td>
                            <td align="center" >{:getuserinfo($vo['uid'])}</td> 
                            <td align="center" >{$vo.prize}</td>
                            <td align="center" >
                                <if condition="$vo['rid'] eq 1">一等奖</if>
                                <if condition="$vo['rid'] eq 2">二等奖</if>
                                <if condition="$vo['rid'] eq 3">三等奖</if>
                                <if condition="$vo['rid'] eq 4">四等奖</if>
                                <if condition="$vo['rid'] eq 5">五等奖</if>
                                <if condition="$vo['rid'] eq 6">六等奖</if>
                            </td>
                            <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                            
                            <td align="center" > 
                                <if condition="authcheck('Admin/Choujiang/edit')">
              <a href="{:U('Admin/Choujiang/edit',array('id'=>$vo['id']))}" >修改</a> 
                <else/>
                 <font color="#cccccc">修改</font>
              </if> 
                            <if condition="authcheck('Admin/Choujiang/delete')">
              <a href="{:U('Admin/Choujiang/delete',array('id'=>$vo['id']))}"  class="del">删除</a> 
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
        <div class="btn_wrap">
                <div class="btn_wrap_pd">


                    <if condition="authcheck('Admin/Choujiang/excel')">
                        <form method="post" action="{:U('Admin/Choujiang/excel')}">
                            <!-- <input type="hidden" name="start_time" value="{$Think.post.start_time}" >
                            <input type="hidden"  name="end_time" value="{$Think.post.end_time}" >
                            <input type="hidden"  name="paystatus" value="{$Think.post.paystatus}" >
                            <input type="hidden"  name="status" value="{$Think.post.status}" >
                            <input type="hidden"  name="dailiid" value="{$Think.post.dailiid}" >
                            <input type="hidden"  name="keyword" value="{$Think.post.keyword}" > -->
                            <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">导出所有数据</button>
                        </form> 
                    </if>


                </div>
            </div>

    </div>
<script src="__JS__/common.js?v"></script>
<script src="__JS__/content_addtop.js"></script>
</body>
</html>