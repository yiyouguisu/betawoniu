<include file="public:head" />
<include file="public:mheader" />

	<include file="Member:member" />
    <div class="order_main2">
        <div class="wrap clearfix">
            <include file="Member:member_left2" />
            <div class="fl order_main2_2">
                <div class="order_main2_201">
                    <p>我的订单</p>
                    <div class="order_main2_201_list">
                        <a href="{:U('Home/Member/myorder_hostel')}" class="order_list_a1">美宿</a>
                        <a href="{:U('Home/Member/myorder_party')}" class="">活动</a>
                    </div>
                    <div class="order_main2_201_list2">
                        <span class="order_list_a2" data="all" onclick="showBorrow(this);">全部订单</span>
                        <span  data="waitpay" onclick="showBorrow(this);">未付款</span>
                        <span  data="waitreview" onclick="showBorrow(this);">待审核</span>
                        <span  data="done" onclick="showBorrow(this);">已完成</span>
                    </div>
                    <div id="DataList">
                        <include file="Member:morelist_hostelorder" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="My_message_details_main2 hide">
        <div class="My_message_details_main3">
        </div>
        <div class="My_message_details_main4">
            <div class="My_message_details_m4top">
                <span>请输入不通过的理由</span>
                <div class="My_message_details_m4topf"></div>
            </div>
            <div class="My_message_details_m4bottom">
                <span id="remark"></span>
                
            </div>
        </div>
    </div>
    <div class="Mask3 hide">
    </div>
    <script type="text/javascript">
        $(function(){
            $(".remark").live("click",function(){
                var obj=$(this);
                var remark=obj.data("remark");
                $("#remark").text(remark);
                $(".My_message_details_main2").show();
                $("html,body").css({
                    "overflow-y": "hidden",
                })
                
            })
            $(".My_message_details_main3,.My_message_details_m4topf").click(function () {
                $(".My_message_details_main2").hide();
                $("html,body").css({
                    "overflow-y": "auto",
                })
            })
        })
        function showBorrow(obj){
            $(obj).blur();
            var varname=$(obj).attr("data");
            var p={ "varname":varname,"isAjax":1};
            $(obj).addClass("order_list_a2").siblings().removeClass("order_list_a2");
            $.get("{:U('Home/Member/myorder_hostel')}",p,function(d){
                if(d.status==1){
                    $("#DataList").html(d.html);
                    $("#DataList").find('img.pic').lazyload({
                       effect: 'fadeIn'
                    });
                }else{
                    // alert("出错了");   
                }
            });
        }
        
        $('.ajaxpagebar a').live("click",function(){
            try{    
                var geturl = $(this).attr('href');
                var index = $(".order_main2_201_list2 span.order_list_a2").index();
                if(index==0){
                    var varname='all';
                }else if(index==1){
                    var varname='waitpay';
                }else if(index==2){
                    var varname='waitreview';
                }else if(index==3){
                    var varname='done';
                }
                var p={ "varname":varname,"isAjax":1};
                $.get(geturl,p,function(d){
                    $("#DataList").html(d.html);
                    $("#DataList").find('img.pic').lazyload({
                       effect: 'fadeIn'
                    });
                });
            }catch(e){};
            return false;
        })
    </script>
<include file="public:foot" />