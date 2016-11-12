<include file="public:head" />
<include file="public:mheader" />
<div class="wrap hidden">
        <div class="pd_main1">
            <include file="Member:change_menu" />
            <div class="fl pd_main3">
                <div class="pd_main10_top">
                    <span>常用联系人</span>
                    <eq name="user['realname_status']" value="0">
                        <a href="{:U('Home/Member/realname')}" >
                            <img src="__IMG__/Icon/img65.png" />实名认证
                        </a>
                    </eq>
                </div>
                <div class="Top_contacts_m">
                    <div class="Top_contacts_m2">
                        <div class="Top_contacts_m2_1">
                            <div class="Top_contacts_m2_1_top">
                                <span>添加联系人</span>
                            </div>
                            <div class="Top_contacts_m2_1_bottom">
                                <div class="Top_contacts_m2_1_bottom2 middle">
                                    <span class="f16 c333">姓名 ：</span>
                                    <input type="text" name="realname" value="" style="width:118px;margin-right:43px;" />
                                </div>
                                <div class="Top_contacts_m2_1_bottom2 middle">
                                    <span class="f16 c333">身份证号码 ：</span>
                                    <input type="text" name="idcard" value="" style="width:293px;margin-right:43px;" />
                                </div>
                                <div class="Top_contacts_m2_1_bottom2 middle">
                                    <span class="f16 c333">手机号码 ：</span>
                                    <input type="text" name="phone" value="" style="width:186px;" />
                                </div>
                            </div>
                            <div class="Top_contacts_m2_1_bottom3">
                                <div class="Top_contacts_m2_1_bottom3-1">
                                    <input type="hidden" name="lmid" value="">
                                    <span id="add" style="cursor:pointer;">添加</span>
                                </div>
                            </div>
                        </div>
                        <div class="Top_contacts_m2_tab">
                            <div class="Top_contacts_m2_1_top">
                                <span>全部联系人</span>
                            </div>
                            <div class="Top_contacts_m2_tab2">
                                <ul class="Top_contacts_m2_tab_ul">
                                    <volist name="data" id="vo">
                                        <li>
                                            <div class="middle Top_contacts_m2_tab_list">
                                                <span class="realname">{$vo.realname}</span>
                                            </div>
                                            <div class="middle Top_contacts_m2_tab_list2">
                                                <span class="idcard">{$vo.idcard}</span>
                                            </div>
                                            <div class="middle Top_contacts_m2_tab_list3">
                                                <span class="phone">{$vo.phone}</span>
                                            </div>
                                            <div class="Top_contacts_m2_tab_list4 middle">
                                                <i class="edit" data-id="{$vo.id}">编辑</i>
                                                <span class="delete" data-id="{$vo.id}">删除</span>
                                            </div>
                                        </li>
                                    </volist>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $("#add").click(function(){
            var realname=$("input[name='realname']").val();
            if(realname==''){
                alert("姓名不能为空！");
                $("input[name='realname']").focus();
                return false;
            }
            var idcard=$("input[name='idcard']").val();
            if(idcard==''){
                alert("身份证号码不能为空！");
                $("input[name='idcard']").focus();
                return false;
            }
            var phone=$("input[name='phone']").val();
            if(phone==''){
                alert("手机号码不能为空！");
                $("input[name='phone']").focus();
                return false;
            }else if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone)) {
                alert("手机号码格式不正确");
                $("input[name='phone']").focus();
                return false;
            } 
            var lmid=$("input[name='lmid']").val();
            if(lmid==''){
                var url="{:U('Home/Member/ajax_add_linkman')}";
            }else{
                var url="{:U('Home/Member/ajax_edit_linkman')}";
            }
            $.ajax({
                     type: "POST",
                     url: url,
                     data: {'lmid':lmid,'realname':realname,'idcard':idcard,'phone':phone},
                     dataType: "json",
                     success: function(data){
                        alert(data.msg)
                        if(data.code==200){
                           window.location.reload();
                        }
                     }
                })  

        })
        $(".edit").click(function(){
            $("input[name='realname']").val($(this).parents("li").find(".realname").text());
            $("input[name='idcard']").val($(this).parents("li").find(".idcard").text());
            $("input[name='phone']").val($(this).parents("li").find(".phone").text());
            $("input[name='lmid']").val($(this).data("id"));
            $("#add").text("修改");
        })
        $(".delete").click(function(){
            var obj=$(this);
            var lmid=obj.data("id");
            if(confirm("确定删除吗？")){
                $.ajax({
                     type: "POST",
                     url: "{:U('Home/Member/ajax_del_linkman')}",
                     data: {'lmid':lmid},
                     dataType: "json",
                     success: function(data){
                        alert(data.msg)
                        if(data.code==200){
                           obj.parents("li").remove(); 
                        }
                     }
                })  
            }else{
                return false;
            }
        })
    })
</script>
<include file="public:foot" />