<include file="Common:Head" />
<script>
    $(function(){
        var dateInput = $("input.J_date");
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker({
                    onHide:function(){
                        var startdate=$(".startdate").val();
                        var enddate=$(".enddate").val();
                        if(startdate!=''&&enddate!=''){
                            var days=DateDiff(startdate,enddate);
                            $("#days").val(Number(days));
                        }
                        
                        
                    }
                });
                
            });
        }
    });    
     //计算天数差的函数，通用  
   function  DateDiff(sDate1,  sDate2){    //sDate1和sDate2是2006-12-18格式  
       var  aDate,  oDate1,  oDate2,  iDays  
       aDate  =  sDate1.split("-")  
       oDate1  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])    //转换为12-18-2006格式  
       aDate  =  sDate2.split("-")  
       oDate2  =  new  Date(aDate[1]  +  '-'  +  aDate[2]  +  '-'  +  aDate[0])  
       iDays  =  parseInt(Math.abs(oDate1  -  oDate2)  /  1000  /  60  /  60  /24)    //把相差的毫秒数转换为天数  
       return  iDays  
   } 
    </script>
<body class="J_scroll_fixed">
    <div class="wrap jj">
        <include file="Common:Nav"/>
        <div class="common-form">
            <form method="post" action="{:U('Admin/Holiday/add')}">
                <div class="h_a">基本信息</div>
                <div class="table_list">
                    <table cellpadding="0" cellspacing="0" class="table_form" width="100%">
                        <tbody>
                            <tr>
                                <td width="100">名称:</td>
                                <td><input type="text" class="input" name="name" id="name" value="" ></td>
                            </tr>
                            <tr>
                                <td>时间</th>
                                <td>
                                    <input type="text" name="startdate" class="input length_2 J_date startdate" value="{$data.startdate}" style="width:120px;" required>
                                    <input type="text" name="days" class="input length_2 input_hd" placeholder="天数" id="days" value="{$data.days}" required>
                                    <input type="text" class="input length_2 J_date enddate" name="enddate" value="{$data.enddate}" style="width:120px;" required>
                                </td>
                            </tr>
                            <tr>
                                <td>状态:</td>
                                <td><select name="status">
                                        <option value="1" >启用</option>
                                        <option value="0" >禁用</option>
                                    </select></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="">
                    <div class="btn_wrap_pd">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="__JS__/common.js?v"></script>
    
</body>
</html>