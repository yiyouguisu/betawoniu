<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav" />
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/Inn/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10">
                    <span class="mr20">
                        时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">
                        审核：
                        <select class="select_2" name="status" style="width:70px;">
                            <option value=""  <empty name="Think.get.status">selected</empty>>全部</option>
                            <option value="2" <if condition=" $Think.get.status eq '2'"> selected</if>>审核</option>
                            <option value="1" <if condition=" $Think.get.status eq '1'"> selected</if>>未审核</option>
                        </select>
                        关键字：
                        <select class="select_2" name="searchtype" style="width:70px;">
                            <option value='0' <if condition=" $searchtype eq '0' "> selected</if>>名称</option>
                            <option value='1' <if condition=" $searchtype eq '1' "> selected</if>>介绍</option>
                            <option value='2' <if condition=" $searchtype eq '2' "> selected</if>>用户名</option>
                            <option value='3' <if condition=" $searchtype eq '3' "> selected</if>>ID</option>
                        </select>
                        <input type="text" class="input length_2" name="keyword" style="width:200px;" value="" placeholder="请输入关键字...">
                        <button class="btn">搜索</button>
                    </span>
                </div>
            </div>
        </form>

        <form action="{:U('Admin/Inn/action')}" method="post">
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <!-- <td width="5%" align="center">排序</td> -->
                            <td width="5%" align="center">ID</td>
                            <td width="25%" align="left">名称</td>
                            <td width="10%" align="center">是否参加抽奖</td>
                            <td width="10%" align="center">投票数</td>
                            <td width="15%" align="center">发布时间</td>
                            <td width="15%" align="center">发布人</td>
                            <td width="20%" align="center">管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                        <volist name="data" id="vo">
                            <tr>
                                <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.id}"></td>
                                <!-- <td align="center"><input name='listorders[{$vo.id}]' class="input length_1 mr5" type='number' size='3' value='{$vo.listorder}' align="center"></td> -->
                                <td align="center">{$vo.id}</td>
                                <td align="left">
                                    <if condition="$vo.status eq 1"> <span style="color: red">[未审核]</span></if>
                                    <if condition="$vo.status eq 3"> <span style="color: red">[未通过]</span></if>
                                    <if condition="$vo.status eq 4"> <span style="color: red">[已下架]</span></if>
                                    <span title="{$vo.name}">{$vo.sortname}</span>
                                </td>
                                <td align="center">
                                    <if condition="$vo.isvote eq 1">
                                        是
                                    <else />
                                        否
                                    </if>
                                </td>
                                <td align="center">{$vo.votenum|default="0"}</td>
                                <!-- <td align="center">{$vo.hit|default="0"}</td> -->
                                <!-- <td align="center">{$vo.view|default="0"}</td> -->
                                <td align="center">{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                                <td align="center">{$vo.ownner}</td>
                                <td align="center">
                                    <eq name="vo['status']" value="1">
                                        <if condition="authcheck('Admin/Inn/review')">
                                            <a href="javascript:;" onClick="omnipotent('selectid','{:U('Admin/Inn/review',array('id'=>$vo['id']))}','审核',1,700,300)">审核</a>
                                        <else/>
                                            <font color="#cccccc">审核</font>
                                        </if> 
                                    </eq>
                                    <eq name="vo['status']" value="2">
                                        <if condition="authcheck('Admin/Inn/setoff')">
                                            <a href="{:U('Admin/Inn/setoff',array('id'=>$vo['id']))}" onclick="if(confirm('确定下架?')==false)return false;">下架</a>
                                        <else/>
                                            <font color="#cccccc">下架</font>
                                        </if> 
                                    </eq> 
                                    <eq name="vo['status']" value="4">
                                        <if condition="authcheck('Admin/Inn/seton')">
                                            <a href="{:U('Admin/Inn/seton',array('id'=>$vo['id']))}" onclick="if(confirm('确定启用?')==false)return false;">启用</a>
                                        <else/>
                                            <font color="#cccccc">启用</font>
                                        </if> 
                                    </eq>                                       
                                    <a href="{:U('Admin/Inn/edit',array('id'=>$vo['id']))}">修改</a>
                                    <eq name="vo['status']" value="1">
                                        <if condition="authcheck('Admin/Inn/delete')">
                                            <a href="{:U('Admin/Inn/delete',array('id'=>$vo['id']))}"  class="del">删除</a> 
                                        <else/>
                                            <font color="#cccccc">删除</font>
                                        </if> 
                                    </eq>             
                                </td>
                            </tr>
                        </volist>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages"> {$Page} </div>
                </div>
            </div>

            <!-- <div class="btn_wrap">
                <div class="btn_wrap_pd">
                    <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="listorder">排序</button>
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="review">审核通过</button>
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="unreview">审核不通过</button>
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="pushs">推荐</button>
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="unpushs">取消推荐</button>
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">删除</button>
                </div>
            </div> -->
        </form>
    </div>

    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
</body>
</html>