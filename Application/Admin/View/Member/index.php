<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">

<include file="Common:Nav"/>

   <div class="table_list">
         <div class="h_a">搜索</div>
        <form method="post" action="{:U('Admin/Member/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> <span class="mr20">
                      注册时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.post.start_time}" style="width:80px;">
                       -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.post.end_time}" style="width:80px;">
                      性别：
                        <select class="select_1" name="sex">
                            <option value="" <empty name="Think.post.sex">selected</empty>>全部</option>
                            <option value="1" <if condition=" $Think.post.sex eq '1'"> selected</if>>男</option>
                            <option value="2" <if condition=" $Think.post.sex eq '2'"> selected</if>>女</option>
                        </select>
                        关键字：
                        <select class="select_2" name="searchtype" >
                        <option value='0' <if condition=" $searchtype eq '0' "> selected</if>>用户名</option>
                         <option value='3' <if condition=" $searchtype eq '3' "> selected</if>>手机</option>
                         <option value='4' <if condition=" $searchtype eq '4' "> selected</if>>ID</option>
                        </select>
                        <input type="text" class="input length_2" name="keyword" value="" placeholder="请输入关键字...">
                        <button class="btn">搜索</button>
                    </span> </div>
            </div>
        </form> 
   <table width="100%" cellspacing="0">
       <thead>
          <tr>
            <td width="4%" align="center" >序号</td>
            <td width="12%" align="center" >用户名</td>
            <td width="6%" align="center" >用户类型</td>
            <td width="5%" align="center" >性别</td>
            <td width="10%" align="center" >手机号</td>
            <td width="6%"  align="center" >评论数</td>
            <td width="6%"  align="center" >订单数</td>
            <td width="10%" align="center" >最后登录时间</td>
            <td width="6%"  align="center" >登陆次数</td>
            <td width="10%"  align="center" >注册时间</td>
            <td width="10%"  align="center" >推荐码</td>
            <td width="7%" align="center" >操作</td> 
          </tr>
        </thead>
        <tbody>
        <foreach name="data" item="vo">
          <tr>
            <td align="center">{$vo.id}</td>
            <td align="center">{:getuserinfo($vo['id'])}</td>
            <td align="center">
              <if condition="$vo.houseowner_status eq 0">个人</if>
              <if condition="$vo.houseowner_status eq 1">房东</if>
            </td>
            <td align="center">
              <if condition="$vo.sex eq 0">未知</if>
              <if condition="$vo.sex eq 1">男</if>
              <if condition="$vo.sex eq 2">女</if>
            </td>
            <td align="center" >{$vo.phone}</td>
            <td align="center" ><a href="{:U('Admin/Review/index',array('uid'=>$vo['id']))}">{$vo.reviewnum|default="0"}次</a></td>
            <td align="center" ><a href="{:U('Admin/Order/index',array('uid'=>$vo['id']))}">{$vo.ordernum|default="0"}单</a></td>
            <td align="center">
              <empty name="vo.lastlogin_time">
                用户还未登录
                <else />
                {$vo.lastlogin_time|date="Y-m-d",###}</br>
                {$vo.lastlogin_time|date="H:i:s",###}
              </empty>
            </td>
            <td align="center" >{$vo.login_num}次</td>
            <td align="center" >
              {$vo.reg_time|date="Y-m-d",###}</br>
              {$vo.reg_time|date="H:i:s",###}
            </td>
              <td align="center" >{$vo.tuijiancode}</td>
                <td  align="center" >
                    <if condition="authcheck('Admin/Review/index')">
                            <a href="{:U('Admin/Review/index',array('uid'=>$vo['id']))}" >评论管理 </a>  |
                            <else/>
                            <font color="#cccccc">评论管理</font> |
                        </if>  
                  <if condition="authcheck('Admin/Member/edit')">
                            <a href="{:U('Admin/Member/edit',array('id'=>$vo['id']))}" >修改基本资料 </a>  |
                            <else/>
                            <font color="#cccccc">修改基本资料</font> |
                        </if>  
                        <if condition="authcheck('Admin/Member/del')">
                            <a href="{:U('Admin/Member/del',array('id'=>$vo['id']))}"  class="del">删除 </a>  |
                            <else/>
                            <font color="#cccccc">删除 </font>  |
                        </if> 
                    <eq name="vo['status']" value="1">
                         <if condition="authcheck('Admin/Member/setstatus')">
                            <a href="{:U('Admin/Member/setstatus',array('id'=>$vo['id'],'status'=>0))}" >禁用 </a>
                            <else/>
                            <font color="#cccccc">禁用</font>
                        </if>  
                    <else/>
                        <if condition="authcheck('Admin/Member/setstatus')">
                            <a href="{:U('Admin/Member/setstatus',array('id'=>$vo['id'],'status'=>1))}" >启用 </a>
                            <else/>
                            <font color="#cccccc">启用</font>
                        </if>  
                    </eq>
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
<script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
</body>
</html>