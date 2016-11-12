
<include file="Common:Head" />

<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">搜索</div>
        <form method="get" action="{:U('Admin/Exchangeorder/index')}">
            <input type="hidden" value="1" name="search">
            <div class="search_type cc mb10">
                <div class="mb10"> 
                    <span class="mr20">
                        下单时间：
                        <input type="text" name="start_time" class="input length_2 J_date" value="{$Think.get.start_time}" style="width:80px;">
                        -
                        <input type="text" class="input length_2 J_date" name="end_time" value="{$Think.get.end_time}" style="width:80px;">

                        <button class="btn">搜索</button>
                    </span>
                </div>
            </div>
        </form> 

        <form action="{:U('Admin/Exchangeorder/del')}" method="post" >
            <div class="table_list">
                <table width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <td width="5%"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></td>
                            <td width="15%" align="center" >订单号</td>
                            <td width="10%" align="center" >下单用户</td>
                            <td width="15%" align="center" >美宿名称</td>
                            <td width="10%" align="center" >兑换金额</td>
                            <td width="10%"  align="center" >订单时间</td>
                            <td width="10%"  align="center" >期望入住人数</td>
                            <td width="10%"  align="center" >期望入住时间</td>
                            <td width="12%" align="center" >管理操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <volist name="data" id="vo">
                        <tr class="productshow" data-id="{$vo.id}">
                            <td><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="{$vo.id}"></td>
                            <td align="center" >{$vo.orderid}</td>
                            <td align="center" >{:getuserinfo($vo['uid'])}</td>
                            <td align="center" >{$vo.house}</td>
                            <td align="center" >
                                {$vo.money}
                            </td>
                            <td align="center" >{$vo.inputtime|date="Y-m-d",###}<br/>{$vo.inputtime|date="H:i:s",###}</td>
                            <td align="center" >
                                {$vo.expectnum}
                            </td>
                            <td align="center" >
                                {$vo.expectdate}
                            </td>
                            <td align="center" > 
                                 <if condition="authcheck('Admin/Exchangeorder/delete')">
              <a href="{:U('Admin/Exchangeorder/delete',array('id'=>$vo['id']))}"  class="del">删除</a> 
                <else/>
                 <font color="#cccccc">删除</font>
              </if> 
                            </td>
                        </tr>
                        <tr id="product_{$vo.id}" style="color: rgb(24, 116, 237);background-color: rgb(230, 230, 230);display:none;" >
                            <td colspan="11">
                                <table width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <td width="33.33%" align="center" >真实姓名</td>
                                            <td width="33.33%" align="center" >身份证号</td>
                                            <td width="33.33%" align="center" >联系方式</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <volist name="vo['productinfo']" id="v">
                                            <tr>
                                                <td align="center" >{$v.realname}</td>
                                                <td align="center" >{$v.idcard}</td>
                                                <td align="center" >{$v.tel}</td>
                                            </tr>
                                        </volist>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </volist>
                    </tbody>
                </table>
                <div class="p10">
                    <div class="pages"> {$Page} </div>
                    <label class="mr20"><input type="checkbox" class="J_check_all" data-direction="y" data-checklist="J_check_y">全选</label>   

                    <if condition="authcheck('Admin/Exchangeorder/del')">
                        <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">删除</button>
                    </if>
                    </form>
                </div>
            </div>

            <!-- <div class="btn_wrap">
                <div class="btn_wrap_pd">
                        <form method="post" action="{:U('Admin/Exchangeorderexcel/excel')}">
                            <input type="hidden" value="1" name="search">
                            <input type="hidden" name="start_time" value="{$Think.get.start_time}" >
                            <input type="hidden"  name="end_time" value="{$Think.get.end_time}" >
                            <input type="hidden"  name="Exchangeordersource" value="{$Think.get.Exchangeordersource}" >
                            <input type="hidden"  name="Exchangeordertype" value="{$Think.get.Exchangeordertype}" >
                            <input type="hidden"  name="isthirdparty" value="{$Think.get.isthirdparty}" >
                            <input type="hidden"  name="issend" value="{$Think.get.issend}" >
                            <input type="hidden"  name="storeid" value="{$Think.get.storeid}" >
                            <input type="hidden"  name="keyword" value="{$Think.get.keyword}" >
                            <button class="btn btn_submit mr10 " type="submit" name="submit" value="del">导出当前数据</button>
                        </form> 
                </div>
            </div> -->


    </div>

    <script src="__JS__/common.js?v"></script>
        <script src="__JS__/content_addtop.js"></script>
    <script>
        $(function () {
            $(".productshow a").click(function () {
                var href = $(this).attr("href");
                window.location.href = href;
                return false;
            })
            $(".productshow").click(function () {
                var obj = "#product_" + $(this).data("id");
                $(obj).toggle();
            })

        })
        
    </script>
</body>
</html>