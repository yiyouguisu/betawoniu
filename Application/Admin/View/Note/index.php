<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/Note/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> <span class="mr20">
                        时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">
                        审核状态：
                        <select class="select_2" name="status" style="width:70px;">
                            <option value=""  <empty name="Think.get.status">selected</empty>>全部</option>
                            <option value="1" <if condition=" $Think.get.status eq '1'"> selected</if>>待审核</option>
                            <option value="2" <if condition=" $Think.get.status eq '2'"> selected</if>>审核成功</option>
                            <option value="3" <if condition=" $Think.get.status eq '3'"> selected</if>>审核失败</option>
                        </select>
                        关键字：
                        <select class="select_2" name="searchtype" style="width:70px;">
                            <option value='0' <if condition=" $searchtype eq '0' "> selected</if>>标题</option>
                            <option value='1' <if condition=" $searchtype eq '1' "> selected</if>>简介</option>
                            <option value='2' <if condition=" $searchtype eq '2' "> selected</if>>用户名</option>
                            <option value='3' <if condition=" $searchtype eq '3' "> selected</if>>ID</option>
                        </select>
                        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="" placeholder="请输入关键字...">
                        <button class="btn">搜索</button>
                    </span> </div>
            </div>
        </form> 

        <form action="{:U('Admin/Note/action')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="5%" align="center">排序</td>
                            <td width="5%" align="center" >ID</td>
                            <td width="45%" align="left" >标题</td>
                            <!-- <td width="10%" align="left" >游记类型</td> -->
                            <td width="15%"  align="center" >发布时间</td>
                            <td width="10%"  align="center" >发布人</td>
                            <td width="15%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr>
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.id}"></td>
                            <td align="center" ><input name='listorders[{$vo.id}]' class="input length_1 mr5"  type='number' size='3' value='{$vo.listorder}' align="center"></td>
                            <td align="center" >{$vo.id}</td>
                            <td align="left" >
                                <if condition="$vo.status eq 1"> <span style="color: gray">[待审核]</span></if>
                                <if condition="$vo.status eq 2"> <span style="color: green">[审核成功]</span></if>
                                <if condition="$vo.status eq 3"> <span style="color: red">[审核失败]</span></if>
                                <if condition="$vo.type eq 1"> <span style="color: red">[精品]</span></if>
                                <if condition="$vo.isindex eq 1"> <span style="color: red">[推]</span></if>
                               <span title="{$vo.title}">{$vo.sortitle}</span></td>
                            <!-- <td align="left" ><eq name="vo['notetype']" value="1">游记</eq><eq name="vo['notetype']" value="2">攻略</eq></td> -->
                            <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                            <td align="center" >{$vo.username}</td>
                            <td align="center" > 
                                <eq name="vo['status']" value="1">
                                    <if condition="authcheck('Admin/Note/review')">
                                      <a href="javascript:;" onClick="omnipotent('selectid','{:U('Admin/Note/review',array('id'=>$vo['id']))}','审核',1,700,300)">审核</a>
                                      <else/>
                                      <font color="#cccccc">审核</font>
                                    </if> 
                                </eq>
                                <eq name="vo['isoff']" value="0">
                                     <if condition="authcheck('Admin/Note/setoff')">
                                        <a href="{:U('Admin/Note/setoff',array('id'=>$vo['id'],'isoff'=>1))}" >下架 </a>
                                        <else/>
                                        <font color="#cccccc">下架</font>
                                    </if>  
                                <else/>
                                    <if condition="authcheck('Admin/Note/setoff')">
                                        <a href="{:U('Admin/Note/setoff',array('id'=>$vo['id'],'isoff'=>0))}" >启用 </a>
                                        <else/>
                                        <font color="#cccccc">启用</font>
                                    </if>  
                                </eq>
                                <if condition="authcheck('Admin/Note/edit')">
                                    <a href="{:U('Admin/Note/edit',array('id'=>$vo['id']))}" >修改</a> 
                                    <else/>
                                    <font color="#cccccc">修改</font>
                                </if> 
                                <if condition="authcheck('Admin/Note/delete')">
                                    <a href="{:U('Admin/Note/delete',array('id'=>$vo['id']))}"  class="del">删除</a> 
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
                     <if condition="authcheck('Admin/Note/listorder')">
                                  <button class="btn btn_submit mr10 " type="submit" name="submit" value="listorder" >排序</button>
                        </if> 
                         <if condition="authcheck('Admin/Note/jinpins')">
                             <button class="btn btn_submit mr10 " type="submit" name="submit" value="jinpins">精品</button>
                        </if>
                      <if condition="authcheck('Admin/Note/unjinpins')">
                             <button class="btn btn_submit mr10 " type="submit" name="submit" value="unjinpins">取消精品</button>
                        </if>
                    <if condition="authcheck('Admin/Note/pushs')">
                             <button class="btn btn_submit mr10 " type="submit" name="submit" value="pushs">推荐</button>
                        </if>
                      <if condition="authcheck('Admin/Note/unpushs')">
                             <button class="btn btn_submit mr10 " type="submit" name="submit" value="unpushs">取消推荐</button>
                        </if>
                        <if condition="authcheck('Admin/Note/del')">
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