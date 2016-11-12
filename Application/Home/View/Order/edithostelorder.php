<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script src="__JS__/WdatePicker.js"></script>
<script src="__JS__/work.js"></script>
<script>
    $(function(){
        var starttime="{$data.productinfo.starttime|date='Y-m-d',###}";
        var endtime="{$data.productinfo.endtime|date='Y-m-d',###}";
        var days=DateDiff(starttime,endtime);
        $("#days").text(Number(days)+"天");
        $("#day").text(Number(days));
        $("input[name='days']").val(Number(days));
        aa();
        var dateInput = $("input.J_date")
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker({
                    onHide:function(){
                        var starttime=$(".starttime").val();
                        var endtime=$(".endtime").val();
                        var roomnum=$("input[name='roomnum']").val();
                        var nowdate="{:date('Y-m-d')}";
                        if(Date.parse(starttime)-Date.parse(nowdate)<0){
                            alert("请填写正确日期");
                            $(".starttime").val();
                            return false;
                        }
                        if(starttime!=''&&endtime!=''){
                            if(Date.parse(endtime) - Date.parse(starttime)<=0){
                                alert("请填写正确日期");
                                $(".endtime").val();
                                return false;
                            }else{
                                var rid="{$data.productinfo.rid}";
                                $.post("{:U('Home/Room/ajax_checkdate')}",{"rid":rid,"starttime":starttime,"endtime":endtime,"roomnum":roomnum},function(d){
                                    if(d.code==200){
                                        var days=DateDiff(starttime,endtime);
                                        console.log(days)
                                        $("#days").text(Number(days)+"天");
                                        $("#day").text(Number(days));
                                        $("input[name='days']").val(Number(days));
                                        $("#totalmoney").text(d.totalmoney);
                                        aa();
                                    }else{
                                        alert("您选择的日期包含不合法日期");
                                        $(".endtime").val();
                                        return false;
                                    }
                                });
                            }

                        }
                        
                        
                    }
                });
                
            });
        }
    })
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
<include file="public:mheader" />
	<div style="background:#f4f4f4;">
        <div class="wrap">
            <div style="padding-top:28px;"></div>
            <div class="payment hidden">
                <div class="fl payment_main_11">
                    <span>填写订单</span>
                </div>
                <div class="fl payment_main_12">
                    <!--灰色样式类名 payment_main_02    蓝色样式类名payment_main_05-->
                    <span>房东确认</span>
                </div>
                <div class="fl payment_main_13">
                    <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
                    <span>支付钱款</span>
                </div>
                <div class="fl payment_main_14">
                    <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
                    <span>预订完成</span>
                </div>
            </div>
        </div>
        <div class="wrap">
        	<form action="{:U('Home/Order/editorder_hostel')}" method="post" onsubmit="return checkform();">
                <script>
                    function checkform(){
                        var mannum=$("ul.linkmanlist li.Fill_in_order2_a_bottom_list").length;
                        var defaultmannum=$("input[name='num']").val();
                        var realname=$("input[name='realname']").val();
                        var idcard=$("input[name='idcard']").val();
                        var phone=$("input[name='phone']").val();
                        if(realname==''){
                            alert("请填写姓名");
                            $("input[name='realname']").focus();
                            return false;
                        }else if(idcard==''){
                            alert("请填写身份证号码");
                            $("input[name='idcard']").focus();
                            return false;
                        }else if(phone==''){
                            alert("请填写手机号码");
                            $("input[name='phone']").focus();
                            return false;
                        }else if(mannum!=parseInt(defaultmannum)-1){
                            alert("入住人数信息不相符");
                            return false;
                        }else{
                            return true;
                        }
                    }
                </script>
	            <div class="Fill_in_order2_main1">
	                <span>入住信息 :</span>
	                <div class="Fill_in_order2_div_public Fill_in_order2_main1_1">
	                    <div>
	                        <span>房源信息 ：</span>
	                        <a href="{:U('Home/Hostel/show',array('id'=>$data['productinfo']['hid']))}" style="font-size:14px;color:#21a7bb; border:0px; margin:0px;padding:0px;width:1000px;text-align:left;">{$data.productinfo.hostel}</a>
	                    </div>
	                    <div>
	                        <span>房东名称 ：</span>
	                        <i>{$houseowner.nickname}</i><a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['productinfo']['houseownerid']))}">在线聊天</a>
	                    </div>
	                    <div>
	                        <span>入住时段 ：</span>
	                        <div class="Fill_in_order2_main1_2 middle">
	                            <label>入住：</label>
	                            <input type="text" name="starttime" class="J_date starttime" value="{$data.productinfo.starttime|date='Y-m-d',###}" />
	                        </div>
	                        <div class="Fill_in_order2_main1_3">
	                            <i id="days">{$data.productinfo.days|default="0"}天</i>
	                        </div>
	                        <div class="Fill_in_order2_main1_2 middle">
	                            <label>离店：</label>
	                            <input type="text" name="endtime" class="J_date endtime" value="{$data.productinfo.endtime|date='Y-m-d',###}" />
	                        </div>
	                    </div>
	                    <div>
	                        <span>入住人数 ：</span>
	                        <div class="Hotel_Details_c3 middle">
                                <span class="next2 f24 mannum" onselectstart="return false;">-</span>
                                <i id="mannum">{$data.productinfo.num|default="0"}</i>
                                <input type="hidden" name="num" value="{$data.productinfo.num|default="0"}">
                                <span class="prev2 f18 mannum" onselectstart="return false;">+</span>
                            </div>
	                    </div>
                        <div>
                            <span>入住间数 ：</span>
                            <div class="Hotel_Details_c3 middle">
                                <span class="next2 f24 roomnum" onselectstart="return false;">-</span>
                                <i id="roomnum">{$data.productinfo.roomnum|default="0"}</i>
                                <input type="hidden" name="roomnum" value="{$data.productinfo.roomnum|default="0"}">
                                <span class="prev2 f18 roomnum" onselectstart="return false;">+</span>
                            </div>
                        </div>
                        
	                </div>
	                <span>入住人信息 :</span>
	                <div class="Fill_in_order2_main2 Fill_in_order2_div_public">
                        <table class="Fill_in_order2_main2_tab">
                            <thead>
                                <tr>
                                    <td>姓名</td>
                                    <td>身份证号码</td>
                                    <td>手机号码</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="joinlist">
                                <tr>
                                    <td>
                                        <input type="text" name="realname" value="{$data.productinfo.realname}" required/>
                                    </td>
                                    <td>
                                        <input type="text" name="idcard" value="{$data.productinfo.idcard}" required />
                                    </td>
                                    <td>
                                        <input type="text" name="phone" value="{$data.productinfo.phone}" required/>
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                                <volist name="data['productinfo']['book_member']" id="vo">
                                    <tr>
                                        <td>
                                            <input type="text" value="{$vo.realname}" />
                                        </td>

                                        <td>
                                            <input type="text" value="{$vo.idcard}" />
                                        </td>
                                        <td>
                                            <input type="tel" value="{$vo.phone}" />
                                        </td>
                                        <td>
                                            <a href="javascript:;" class='delmebmer' data-id="{$vo.linkmanid}">删除</a>
                                        </td>
                                    </tr>
                                </volist>
                                <tr id="last">
                                    <td>
                                        <input type="text" value="" class="addlinkman_realname" />
                                    </td>

                                    <td>
                                        <input type="text" value="" class="addlinkman_idcard" />
                                    </td>
                                    <td>
                                        <input type="tel" value="" class="addlinkman_phone" />
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="Fill_in_order2_main3">
                            <input class="Fill_in_order2_sub2 addlinkman" type="button" value="添加入住人" />
                            <span class="Fill_in_order2_sub3 fr">选择常用联系人</span>
                        </div>
                    </div>
	                <span>预订人信息 :</span>
	                <div class="Fill_in_order2_div_public Fill_in_order2_main4">
                        <table class="Fill_in_order2_main4_tab">
                            <thead>
                                <tr>
                                    <td>姓名</td>
                                    <td>身份证号码</td>
                                    <td>手机号码</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input type="text" name="realname" value="{$data.productinfo.realname}" required/>
                                    </td>
                                    <td>
                                        <input type="text" name="idcard" value="{$data.productinfo.idcard}" required />
                                    </td>
                                    <td>
                                        <input type="text" name="phone" value="{$data.productinfo.phone}" required/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <span>订单费用信息 :</span>
                    <div class="Fill_in_order2_div_public Fill_in_order2_main5">
                        <div class="Fill_in_order2_main5_2">
                            <span class="f14 c999">是否有优惠券 ：</span>
                            <i class="Fill_in_order2_main5_2_i">选择优惠券</i>
                            <span id="couponstitle">{$data['couponstitle']}</span>
                        </div>
                        <div style="height:25px;border-bottom: 1px solid #e5e5e5;"></div>
                        <div class="payment_main4 hidden">
                            <div class="fl payment_main4_1">
                                <span>￥<em id="totalmoney">{$data.totalmoney|default="0.00"}</em></span>
                                <i>（房费 x <i id="roomnum_1">{$data.productinfo.roomnum|default="0"}</i>间）</i>
                                <label>—</label>
                                <span>￥<em id="discount">{$data.discount|default="0.00"}</em></span>
                                <i>（优惠券）</i>
                                <div>=</div>
                                <span>￥<em id="total">{$data.money|default="0.00"}</em></span>
                            </div>
                            <div class="payment_main4_3 fr">
                                <span class="f16 c666">应付金额 : </span>
                                <i class="f14">￥<em class="f25 total">{$data.money|default="0.00"}</em></i>
                            </div>
                        </div>
                    </div>
	                
	                <div class="payment_main6 hidden">
                        <input type="hidden" name="money" value="{$data.money|default='0.00'}">
                        <input type="hidden" name="couponsid" value="{$data.couponsid}">
                        <input type="hidden" name="discount" value="{$data.discount|default='0.00'}">
                        <input type="hidden" name="memberids" value="">
                        <input type="hidden" name="days" value="0">
                        <input type="hidden" name="rid" value="{$data['productinfo']['rid']}">
                        <input type="hidden" name="orderid" value="{$data['orderid']}">
                        <input type="submit" value="提交订单" />
	                </div>
	            </div>
	        </form>
        </div>
    </div>
    <div class="Fill_in_order2_a hide">
        <div class="Fill_in_order2_a_top">
            <span>选择常用联系人</span>
            <i class="fr Fill_in_order2_a_top_i">
                <img src="__IMG__/Icon/img107.png" />
            </i>
        </div>
        <div class="Fill_in_order2_a_bottom">
            <ul class="Fill_in_order2_a_bottom_ul linkmanlist">
                <volist name="linkman" id="vo">
                    <li <in name="vo['id']" value="$data.productinfo.memberids">class="linkman Fill_in_order2_a_bottom_list" <else />class="linkman" </in> data-id="{$vo.id}"  data-idcard="{$vo.idcard}" id="linkman_{$vo.id}">
                        <input type="hidden" class="idcard" value="{$vo.idcard}">
                        <span class="f16 realname">{$vo.realname}</span>
                        <i class="fr phone">{$vo.phone}</i>
                    </li>
                </volist>
            </ul>
            <div class="Fill_in_order2_a_bottom2">
                <span id="addlinkman">确定</span>
                <i onclick="window.location.href='{:U('Home/Member/linkman')}'">编辑联系人</i>
            </div>
        </div>
    </div>
    <div class="Fill_in_order2_b hide">
        <div class="Fill_in_order2_a_top">
            <span>选择优惠券</span>
            <i class="fr Fill_in_order2_b_top_i">
                <img src="__IMG__/Icon/img107.png" />
            </i>
        </div>
        <div class="Fill_in_order2_a_bottom">
            <ul class="Fill_in_order2_b_bottom_ul coupons">
                <volist name="coupons" id="vo">
                    <li <eq name="data['couponsid']" value="$vo.id">class="coupons Fill_in_order2_b_bottom_list" <else />class="coupons" </eq> data-title="{$vo.title}" data-id="{$vo.id}" data-price="{$vo.price}">
                        <span class="f16 c000">{$vo.title}</span>
                        <label class="fr">金额: <em>{$vo.price}</em></label>
                    </li>
                </volist>
            </ul>
            <div class="Fill_in_order2_a_bottom2">
                <span id="choosecoupons">确定</span>
            </div>
        </div>
    </div>
    <div class="mask hide"></div>
    <div class="mask2 hide"></div>
    <script type="text/javascript">
        $(function () {
            aa();
            $(".mask").height($(document).height());
            $(".mask2").height($(document).height());
            $(".Fill_in_order2_a_bottom_ul li").click(function () {
                $(this).toggleClass("Fill_in_order2_a_bottom_list");
            })
            $(".Fill_in_order2_sub3").click(function () {
                $(".Fill_in_order2_a").show();
                $(".mask").show();
            })
            $(".mask,.Fill_in_order2_a_top_i").click(function () {
                $(".Fill_in_order2_a").hide();
                $(".mask").hide();
            })
            $(".Fill_in_order2_main5_2_i").click(function () {
                $(".Fill_in_order2_b").show();
                $(".mask2").show();
            })
            $(".Fill_in_order2_b_bottom_ul li").click(function () {
                $(this).addClass("Fill_in_order2_b_bottom_list").siblings().removeClass("Fill_in_order2_b_bottom_list");                
            })
            $(".mask2,.Fill_in_order2_b_top_i").click(function () {
                $(".Fill_in_order2_b").hide();
                $(".mask2").hide();
            })
            $(".addlinkman").click(function(){
                var end_numlimit="{$data.end_numlimit}";
                var realname=$(".addlinkman_realname").val();
                var idcard=$(".addlinkman_idcard").val();
                var phone=$(".addlinkman_phone").val();
                if(realname==''){
                    alert("请填写姓名！");return false;
                }
                if(phone==''){
                    alert("请填写手机号码！");return false;
                }
                if(idcard==''){
                    alert("请填写身份证号码！");return false;
                }
                var p={};
                p['realname']=realname;
                p['phone']=phone;
                p['idcard']=idcard;
                $.post("{:U('Home/Member/ajax_add_linkman')}",p,function(data){
                    data=eval("("+data+")");
                    if(data.code==200){
                        var linkmanid=data.linkmanid;
                        var str="<tr><td><input type=\"text\" value=\""+realname+"\" /></td><td><input type=\"text\" value=\""+idcard+"\" /></td><td><input type=\"text\" value=\""+phone+"\" /></td><td><a href=\"javascript:;\" class='delmebmer' data-id="+linkmanid+">删除</a></td></tr>";
                        $("#last").before(str);

                        var str="<li class=\"linkman Fill_in_order2_a_bottom_list\" data-id='"+linkmanid+"' id=\"linkman_"+linkmanid+"\" data-idcard='"+idcard+"''>";
                            str+="<input type=\"hidden\" class=\"idcard\" value=\""+idcard+"\">";
                            str+="<span class=\"f16 realname\">"+realname+"</span>";
                            str+="<i class=\"fr phone\">"+phone+"</i></li>";
                        $(".linkmanlist").append(str);
                        $(".addlinkman_realname").val("");
                        $(".addlinkman_idcard").val("");
                        $(".addlinkman_phone").val("");
                    }else{
                        alert(data.msg);
                    }
                });

                var mannum=$("ul.linkmanlist li.Fill_in_order2_a_bottom_list").length;
                if(mannum>parseInt(end_numlimit)){
                    alert("人数超过限制");
                    return false;
                }
                $("#mannum").text(mannum+1);
                aa();
            })
            $("#addlinkman").click(function(){
                var numlimit=$("input[name='num']").val();
                var str="";
                $("ul.linkmanlist li.Fill_in_order2_a_bottom_list").each(function(){
                    var linkmanid=$(this).data("id");
                    var realname=$(this).find(".realname").text();
                    var phone=$(this).find(".phone").text();
                    var idcard=$(this).find(".idcard").val();
                    str+="<tr><td><input type=\"text\" value=\""+realname+"\" /></td><td><input type=\"text\" value=\""+idcard+"\" /></td><td><input type=\"text\" value=\""+phone+"\" /></td><td><a href=\"javascript:;\" class='delmebmer' data-id="+linkmanid+">删除</a></td></tr>";
                })
                var mannum=$("ul.linkmanlist li.Fill_in_order2_a_bottom_list").length;
                if(mannum>parseInt(numlimit)){
                    alert("人数超过限制");
                    return false;
                }
                
                var headstr=$("#joinlist tr:eq(0)").html();
                var footstr=$("#joinlist tr:last").html();
                $("#joinlist").html("<tr>"+headstr+"</tr>"+str+"<tr>"+footstr+"</tr>");
                $(".Fill_in_order2_a").hide();
                $(".mask").hide();
                aa();
            })
            $("#choosecoupons").click(function(){
                var couponsid=$("ul.coupons li.Fill_in_order2_b_bottom_list").data("id");
                var price=$("ul.coupons li.Fill_in_order2_b_bottom_list").data("price");
                var couponstitle=$("ul.coupons li.Fill_in_order2_b_bottom_list").data("title");
                $("#discount").text(parseFloat(price).toFixed(2));
                $("input[name='couponsid']").val(couponsid);
                $("input[name='discount']").val(parseFloat(price).toFixed(2));
                $("#couponstitle").text(couponstitle);
                $(".Fill_in_order2_b").hide();
                $(".mask2").hide();
                aa();
            })
            $(".delmebmer").live("click",function(){
                var linkmanid=$(this).data("id");
                $(this).parents("tr").remove();
                $("#linkman_"+linkmanid).removeClass("Fill_in_order2_a_bottom_list");
                aa();
            })
        })
        function aa(){
            var money=$("#totalmoney").text();
            var mannum=$("input[name='num']").val();
            var roomnum=$("input[name='roomnum']").val();
            var days=$("input[name='days']").val();
            var discount=$("input[name='discount']").val();
            var total=parseFloat(parseFloat(money)*parseInt(roomnum)-parseFloat(discount)).toFixed(2);
            $("#total").text(total);
            $(".total").text(total);    
            $("input[name='money']").val(total);
            var memberids="";
            $("ul.linkmanlist li.Fill_in_order2_a_bottom_list").each(function(){
                var linkmanid=$(this).data("id");
                if(memberids==""){
                    memberids=linkmanid;
                }else{
                    memberids+=","+linkmanid;
                }
            })
            $("input[name='memberids']").val(memberids);
        }
    </script>
    <script>
        $(function () {
            $(".chosen-select-no-single").chosen();
            $(".Hotel_Details_c3 .prev2").click(function () {
                var i = $(this).siblings("i").html();
                i++;
                $(this).siblings("i").html(i);
                if($(this).hasClass("mannum")){
                    $("input[name='num']").val(i);
                    $("#mannum").text(i);
                }else if($(this).hasClass("roomnum")){
                    $("input[name='roomnum']").val(i);
                    $("#roomnum").text(i);
                    $("#roomnum_1").text(i);
                    var starttime=$(".starttime").val();
                    var endtime=$(".endtime").val();
                    var roomnum=i;
                    if(starttime!=''&&endtime!=''){
                        if(Date.parse(endtime) - Date.parse(starttime)==0){
                            alert("请填写正确日期");
                            $(".endtime").val();
                            return false;
                        }else{
                            var rid="{$data.productinfo.rid}";
                            $.post("{:U('Home/Room/ajax_checkdate')}",{"rid":rid,"starttime":starttime,"endtime":endtime,"roomnum":roomnum},function(d){
                                if(d.code==200){
                                    $("#totalmoney").text(d.totalmoney);
                                    $("input[name='totalmoney']").val(d.totalmoney);
                                }
                            });
                        }

                    }
                }
                aa();
            })
            $(".Hotel_Details_c3 .next2").click(function () {
                var i = $(this).siblings("i").html();
                if (i<=1) {
                    alert("不能再小了。");
                } else {
                    i--;
                    $(this).siblings("i").html(i);
                    if($(this).hasClass("mannum")){
                        $("input[name='num']").val(i);
                        $("#mannum").text(i);
                    }else if($(this).hasClass("roomnum")){
                        $("input[name='roomnum']").val(i);
                        $("#roomnum").text(i);
                        $("#roomnum_1").text(i);
                        var starttime=$(".starttime").val();
                        var endtime=$(".endtime").val();
                        var roomnum=i;
                        if(starttime!=''&&endtime!=''){
                            if(Date.parse(endtime) - Date.parse(starttime)==0){
                                alert("请填写正确日期");
                                $(".endtime").val();
                                return false;
                            }else{
                                var rid="{$data.productinfo.rid}";
                                $.post("{:U('Home/Room/ajax_checkdate')}",{"rid":rid,"starttime":starttime,"endtime":endtime,"roomnum":roomnum},function(d){
                                    if(d.code==200){
                                        $("#totalmoney").text(d.totalmoney);
                                        $("input[name='totalmoney']").val(d.totalmoney);
                                    }
                                });
                            }

                        }
                    }
                }
                aa();
            })
        });
    </script>
<include file="public:foot" />