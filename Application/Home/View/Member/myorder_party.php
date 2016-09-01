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
                        <a href="{:U('Home/Member/myorder_hostel')}" class="">美宿</a>
                        <a href="{:U('Home/Member/myorder_party')}" class="order_list_a1">活动</a>
                    </div>
                    <div class="order_main2_201_list2">
                        <span class="order_list_a2" style="width:441px;" data="done" onclick="showBorrow(this);">已完成</span>
                        <span style="width:441px;"  data="waitpay" onclick="showBorrow(this);">未付款</span>
                    </div>
                    <div id="DataList">
                        <include file="Member:morelist_partyorder" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        function showBorrow(obj){
            $(obj).blur();
            var varname=$(obj).attr("data");
            var p={ "varname":varname,"isAjax":1};
            $(obj).addClass("order_list_a2").siblings().removeClass("order_list_a2");
            $.get("{:U('Home/Member/myorder_party')}",p,function(d){
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
                    var varname='done';
                }else if(index==1){
                    var varname='waitpay';
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