<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <script src="__JS__/jquery.jqtransform.js"></script>
<include file="public:mheader" />
    <div style="background:#f4f4f4;">
        <div class="wrap">
            <div style="padding-top:28px;"></div>
            <div class="payment hidden">
                <div class="middle payment_main_01">
                    <span>填写预订信息</span>
                </div>
                <div class="middle payment_main_03">
                    <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
                    <span>支付钱款</span>
                </div>
                <div class="middle payment_main_04">
                    <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
                    <span>报名成功</span>
                </div>
            </div>
        </div>
        <div class="wrap">
            <form action="{:U('Home/Order/dojoinparty')}" method="post" onsubmit="return checkform();">
                <script>
                    function checkform(){
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
                        }else{
                            return true;
                        }
                        
                    }

                </script>
                <div class="Fill_in_order2_main1">
                    <span>活动信息 :</span>
                    <div class="payment_main3">
                        <div class="hidden payment_main3_01">
                            <div class="fl payment_main3_02">
                                <a href="{:U('Home/Party/show',array('id'=>$data['id']))}">
                                    <img src="{$data.thumb}" style="width:184px;height:115px"/>
                                </a>
                            </div>
                            <div class="fl payment_main3_03">
                                <a href="{:U('Home/Party/show',array('id'=>$data['id']))}" class="f28 c333">{$data.title}</a>

                                <div class="Activity_Registration_a">
                                    <div class="middle Activity_Registration_b">
                                        <span>活动人数 : <em>{$data.start_numlimit|default="0"}-{$data.end_numlimit|default="0"}人</em></span>
                                    </div>
                                    <div class="Activity_Registration_c middle">
                                        <span>已参与 :</span>
                                        <volist name="data['joinlist']" id="v">
                                            <a href="{:U('Home/Member/detail',array('uid'=>$v['id']))}" class="middle">
                                                <img src="{$v.head}" width="30px" height="30px" />
                                            </a>
                                        </volist>
                                        <i>( {$data.joinnum|default="0"}人 )</i>
                                    </div>
                                </div>
                                <div class="my_home7_list3_03">
                                    <img src="__IMG__/Icon/img44.png" />
                                    <span class="f14 c333">地址 : <em>{:getarea($data['area'])}{$data.address}  </em></span>
                                </div>
                            </div>
                            <div class="fl payment_main3_04">
                                <div class="payment_main3_04_01">
                                    <span>房东：</span>
                                    <a href="{:U('Home/Member/detail',array('uid'=>$data['uid']))}" class="payment_main3_04_01_1">
                                        <div>
                                            <img src="{$data.head}" width="48px" height="48px" />
                                        </div>
                                        <i>{$data.nickname}</i>
                                    </a>
                                    <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['uid']))}" class="payment_main3_04_01_2">在线聊天</a>
                                </div>
                                <div class="payment_main3_04_02">
                                    <span>活动时间：</span>
                                    <i class="f14 c333"><em class="c333 f14">{$data.starttime|date="Y年m月d日",###}</em></i>
                                    <label>至<label>
                                    <i class="f14 c333"><em class="c333 f14">{$data.endtime|date="Y年m月d日",###}</em></i>
                                </div>
                                <div class="payment_main3_04_02">
                                    <span>活动费用：</span>
                                    <i class="c333 f14">￥{$data.money|default="0.00"}人</i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span>参与者信息 :</span>
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
                    <span>主报人信息 :</span>
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
                                        <input type="text" name="realname" value="{$user.realname}" required/>
                                    </td>
                                    <td>
                                        <input type="text" name="idcard" value="{$user.idcard}" required />
                                    </td>
                                    <td>
                                        <input type="text" name="phone" value="{$user.phone}" required/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <span>活动费用 :</span>
                    <div class="Fill_in_order2_div_public Fill_in_order2_main5">
                        <div class="Fill_in_order2_main5_2">
                            <span class="f14 c999">是否有优惠券 ：</span>
                            <i class="Fill_in_order2_main5_2_i">选择优惠券</i>
                            <span id="couponstitle"></span>
                        </div>
                        <div style="height:25px;border-bottom: 1px solid #e5e5e5;"></div>
                        <div class="payment_main4 hidden">
                            <div class="fl payment_main4_1">
                                <span>￥<em id="money">{$data.money|default="0.00"}</em></span>
                                <i>（活动费用 x <i id="mannum">1</i>人）</i>
                                <label>—</label>
                                <span>￥<em id="discount">0.00</em></span>
                                <i>（优惠券）</i>
                                <div>=</div>
                                <span>￥<em id="total">0.00</em></span>
                            </div>
                            <div class="payment_main4_3 fr">
                                <span class="f16 c666">应付金额 : </span>
                                <i class="f14">￥<em class="f25 total">0.00</em></i>
                            </div>
                        </div>
                    </div>
                    <div class="payment_main6 hidden">
                        <input type="hidden" name="money" value="0.00">
                        <input type="hidden" name="couponsid" value="">
                        <input type="hidden" name="discount" value="0.00">
                        <input type="hidden" name="num" value="1">
                        <input type="hidden" name="memberids" value="">
                        <input type="hidden" name="aid" value="{$data['id']}">
                        <input type="hidden" name="orderid" value="{$orderid}">
                        <input type="submit" value="提交报名表" />
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
                    <li class="linkman" data-id="{$vo.id}" id="linkman_{$vo.id}" data-idcard="{$vo.idcard}">
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
                    <li class="coupons"  data-title="{$vo.title}" data-id="{$vo.id}" data-price="{$vo.price}">
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
            $(".mask").height($(document).height());
            $(".mask2").height($(document).height());
            $(".Fill_in_order2_a_bottom_ul li").live("click",function () {
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
                var end_numlimit="{$data.end_numlimit}";
                var str="";
                $("ul.linkmanlist li.Fill_in_order2_a_bottom_list").each(function(){
                    var linkmanid=$(this).data("id");
                    var realname=$(this).find(".realname").text();
                    var phone=$(this).find(".phone").text();
                    var idcard=$(this).data("idcard");
                    str+="<tr><td><input type=\"text\" value=\""+realname+"\" /></td><td><input type=\"text\" value=\""+idcard+"\" /></td><td><input type=\"text\" value=\""+phone+"\" /></td><td><a href=\"javascript:;\" class='delmebmer' data-id="+linkmanid+">删除</a></td></tr>";
                })
                var mannum=$("ul.linkmanlist li.Fill_in_order2_a_bottom_list").length;
                if(mannum>parseInt(end_numlimit)){
                    alert("人数超过限制");
                    return false;
                }
                $("#mannum").text(mannum+1);
                $("#last").before(str);
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
            var money="{$data.money}";
            var mannum=$("ul.linkmanlist li.Fill_in_order2_a_bottom_list").length;
            $("input[name='num']").val(mannum+1);
            var discount=$("input[name='discount']").val();
            var total=parseFloat(parseFloat(money)*parseInt(mannum+1)-parseFloat(discount)).toFixed(2);
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
        });
    </script>
    <include file="public:foot" />
