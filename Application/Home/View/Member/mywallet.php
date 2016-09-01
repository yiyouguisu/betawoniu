<include file="public:head" />
<link href="__CSS__/jqtransform.css" rel="stylesheet" />
    <script src="__JS__/jquery.jqtransform.js"></script>
    <script language="javascript">
        $(function () {
            $('.jqtransform').jqTransform();
        });
    </script>
<include file="public:mheader" />
        <div class="wrap hidden">
            <div class="pd_main1">
                <include file="Member:change_menu" />
                <div class="fl pd_main3">
                    <div class="pd_main17">
                        <div class="pd_main17_top">
                            <span>我的钱包</span>
                        </div>

                        <div class="">
                            <div class="pd_main17_chang_bg2">
                                <div class="pd_main17_chang_bg3">
                                    <span>待提现余额 :</span>
                                    <i>￥<em>{$account.usemoney|default="0.00"}</em></i>
                                </div>
                                <div class="pd_main17_chang_bg3">
                                    <span>即将到帐金额 :</span>
                                    <label>￥<em>{$account.waitmoney|default="0.00"}</em></label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <ul class="pd_main17_ul hidden">
                                <li class="fl pd_main17_list">
                                    <span>余额提现</span>
                                </li>
                                <li class="fl">
                                    <span>钱包使用记录</span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <div class="pd_main17_1 pd_main17_chang_bg">
                                <div class="pd_main17_4">
                                    <div class="pd_main17_x">
                                        <div class="pd_main17_2 middle">
                                            <span>输入提现金额：</span>
                                            <input type="text" name="money" value="" />
                                        </div>
                                    </div>
                                    <div class="pd_main17_x">
                                        <div class="pd_main17_2 middle">
                                            <span>输入支付宝账号：</span>
                                            <input type="text" name="alipayaccount" value="{$user.alipayaccount}" />
                                        </div>
                                    </div>
                                    <div class="pd_main17_x">
                                        <div class="pd_main17_2 middle">
                                            <span>输入支付宝账户姓名：</span>
                                            <input type="text" name="realname" value="{$user.realname}" />
                                        </div>
                                        <div class="middle pd_main17_3">
                                            <input type="button" class="withdraw" value="提款" />
                                        </div>
                                    </div>
                                </div>
                                <div class="personal_data3_b">
                                    <span>提现规则：</span>
                                    <p>{$site.withdrawrule}</p>
                                </div>
                            </div>
                            <div class="pd_main17_chang_bg pd_d hide" id="DataList">
                                <include file="Member:morelist_walletlog" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function () {
                $('.ajaxpagebar a').live("click",function(){
                    try{    
                        var geturl = $(this).attr('href');
                        var p={"isAjax":1};
                        $.get(geturl,p,function(d){
                            $("#DataList").html(d.html);
                        });
                    }catch(e){};
                    return false;
                })
                $(".withdraw").click(function(){
                    var uid="{$user.id}";
                    if(uid==''){
                        alert("请先登录！");var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                        return false;
                    }
                    var usemoney="{$account.usemoney}";
                    var money=$("input[name='money']").val();
                    var realname=$("input[name='realname']").val();
                    var alipayaccount=$("input[name='alipayaccount']").val();
                    if(money==''){
                        alert("请填写提现金额");
                        return false;
                    }else if(money>usemoney){
                        alert("提现金额超出提现范围");
                        return false;
                    }else if(realname==''){
                        alert("请填写支付宝账户姓名");
                        return false;
                    }else if(alipayaccount==''){
                        alert("请填写支付宝账号");
                        return false;
                    }else{
                        var p={};
                        p['uid']=uid;
                        p['money']=money;
                        p['realname']=realname;
                        p['alipayaccount']=alipayaccount;
                        p['fee']=0.00;
                        $.post("{:U('Home/Member/withdraw')}",p,function(data){
                            data=eval("("+data+")");
                            if(data.code==200){
                                alert("申请提现成功");
                                location.reload();
                            }else{
                                alert("申请提现失败");
                            }
                        })
                    }
                })
                $(".pd_main3_bottom input").click(function () {
                    $(this).parents().addClass("pd_main3_bottom2").siblings().removeClass("pd_main3_bottom2");
                })
                $(".pd_main4_bottom3_ul li").click(function () {
                    $(this).toggleClass("pd_main4_bottom3_chang");
                })
                $(".pd_main4_bottom5_ul li").click(function () {
                    $(this).toggleClass("pd_main4_bottom5_chang");
                })
                var $ml = $(".pd_main17_ul li");
                $ml.click(function () {
                    $(".pd_main17_chang_bg").hide();
                    $(this).addClass('pd_main17_list').siblings().removeClass('pd_main17_list');
                    var cs = $(".pd_main17_chang_bg")[getObjectIndex(this, $ml)];
                    $(cs).show();
                });
            })
            function getObjectIndex(a, b) {
                for (var i in b) {
                    if (b[i] == a) {
                        return i;
                    }
                }
                return -1;
            }
        </script>

<include file="public:foot" />