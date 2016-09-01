<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/Tag/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> 
                    <span class="mr20">
                        最后使用时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">
                        关键字：
                        <select class="select_2" name="searchtype" style="width:70px;">
                            <option value='0' <if condition=" $searchtype eq '0' "> selected</if>>美宿</option>
                            <option value='1' <if condition=" $searchtype eq '1' "> selected</if>>景点</option>
                            <option value='3' <if condition=" $searchtype eq '3' "> selected</if>>ID</option>
                        </select>
                        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="" placeholder="请输入关键字...">
                        <button class="btn">搜索</button>
                        <button type="button" onclick="omnipotent('selectid','{:U('Admin/Tag/tagimport')}','导入',1,600,220)" class="btn" style="margin-left: 20px;">导入</button>
                        <button type="button" onclick="window.location.href='{:U('Admin/Tag/downloadtpl')}'" class="btn" style="margin-left: 20px;">下载导入模板</button>
                    </span> </div>
            </div>
        </form> 

        <form action="{:U('Admin/Tag/action')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="5%" align="center" >ID</td>
                            <!-- <td width="10%" align="center" >Tag名称</td> -->
                            <td width="20%" align="center" >美宿</td>
                            <td width="20%" align="center" >景点</td>
                            <td width="10%" align="center" >信息总数</td>
                            <td width="15%"  align="center" >最后使用时间</td>
                            <td width="15%"  align="center" >最近访问时间</td>
                            <td width="20%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr>
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.tagid}"></td>
                            <td align="center">{$vo.id}</td>
                            <!-- <td align="center">{$vo.tag}</td> -->
                            <td align="center">{$vo.hostel}</td>
                            <td align="center">{$vo.place}</td>
                            <td align="center">{$vo.hits|default="0"}</td>
                            <td align="center">
                                 <empty name="vo.lastusetime">
                                    未使用
                                    <else />
                                    {$vo.lastusetime|date="Y-m-d H:i:s",###}
                                  </empty>
                            </td>
                            <td align="center">
                                <empty name="vo.lasthittime">
                                    未访问
                                    <else />
                                    {$vo.lasthittime|date="Y-m-d H:i:s",###}
                                  </empty>
                            </td>
                            <td align="center" > 
                                <if condition="authcheck('Admin/Tag/edit')">
              <a href="{:U('Admin/Tag/edit',array('id'=>$vo['id']))}" >修改</a> 
                <else/>
                 <font color="#cccccc">修改</font>
              </if> 
                            <if condition="authcheck('Admin/Tag/delete')">
              <a href="{:U('Admin/Tag/delete',array('id'=>$vo['id']))}"  class="del">删除</a> 
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
         
            <div class="btn_wrap">
                <div class="btn_wrap_pd">
                    <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>   
                        <if condition="authcheck('Admin/Tag/del')">
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