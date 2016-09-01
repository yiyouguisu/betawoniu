<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/Couponsgiven/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> <span class="mr20">
                        赠送时间:
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">
                        
                        
                        <button class="btn">搜索</button>
                    </span> </div>
            </div>
        </form> 

        <form action="{:U('Admin/Couponsgiven/del')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="5%" align="center" >ID</td>
                            <td width="10%" align="center" >用户</td>
                            <td width="10%" align="center" >被赠送人姓名</td>
                            <td width="10%" align="center" >被赠送人手机号码</td>
                            <td width="15%" align="center" >优惠券名称</td>
                            <td width="10%" align="center" >所属美宿</td>
                            <td width="15%" align="center" >有效时间</td>
                            <td width="15%"  align="center" >赠送时间</td>
                            <td width="15%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr>
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.id}"></td>
                            <td align="center" >{$vo.id}</td>
                            <td align="center">{:getuserinfo($vo['uid'])}</td>
                            <td align="center">{$vo.nickname}</td>
                            <td align="center" >{$vo.phone}</td>
                            <td align="center" >{$vo.title}</td>
                            <td align="center" >{$vo.house}</td>
                            <td align="center" >{$vo.validity_starttime|date="Y-m-d",###}--{$vo.validity_endtime|date="Y-m-d",###}</td>
                            <td align="center" >{$vo.inputtime|date="Y-m-d H:i:s",###}</td>
                            <td align="center" > 
              <a href="{:U('Admin/Couponsgiven/delete',array('id'=>$vo['id']))}"  class="del">删除</a> 

                                
                               
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
                     
                        <if condition="authcheck('Admin/Couponsgiven/del')">
                              <button class="btn btn_submit mr10 " type="submit" name="submit" value="companydel">删除</button>
                        </if>
                    
                   
                    
                </div>
            </div>
        </form>
    </div>

    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
</body>
</html>