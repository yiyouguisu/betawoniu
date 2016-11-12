<include file="public:head" />
<include file="public:mheader" />

	<include file="Member:member" />
    <div class="order_main2">
        <div class="wrap clearfix">
            <include file="Member:member_left2" />
            <div class="fl order_main2_2">
                <div class="order_main2_201">
                    <p>我的发布</p>
                    <div class="order_main2_201_list">
                        <a href="javascript:;" data="hostel" onclick="showBorrow(this);" class="order_list_a1">我发布的美宿</a>
                        <a href="javascript:;" data="party" onclick="showBorrow(this);" class="">我发布的活动</a>
                    </div>
                    <div class="order_main2_201_list2">
                        <span data="1" onclick="showBorrow_status(this);" class="order_list_a2" style="width: 50%;">已审核</span>
                        <span data="0" onclick="showBorrow_status(this);"  style="width: 50%;">未审核</span>
                    </div>
                    <div class="order_main3" id="DataList">
                        <include file="Member:morelist_myrelease" />
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $(".hostel_delete").live("click",function(){
                if(confirm("确认删除吗？")){
                    var obj=$(this);
                    var hid=obj.data("id");
                    try{
                        var p={"hid":hid};
                        $.post("{:U('Home/Hostel/ajax_delete')}",p,function(d){
                            if(d.status==1){
                                obj.parents("li").remove();
                            }else{
                                alert(d.msg);
                            }
                        });
                    }catch(e){};
                }
                
            })
            $(".party_delete").live("click",function(){
                if(confirm("确认删除吗？")){
                    var obj=$(this);
                    var aid=obj.data("id");
                    try{
                        var p={"aid":aid};
                        $.post("{:U('Home/Party/ajax_delete')}",p,function(d){
                            if(d.status==1){
                                obj.parents("li").remove();
                            }else{
                                alert(d.msg);
                            }
                        });
                    }catch(e){};
                }
                
            })
            $(".hostel_switchoff").live("click",function(){
                var obj=$(this);
                var msg = "";
                var isoff = 0;
                if(obj.attr("data-isoff") == '0'){
                    msg = "确认下架吗？";
                    isoff = 1;
                }
                else{
                    msg = "确认启用吗？";
                    isoff = 0;
                }
                if(confirm(msg)){
                    
                    var hid=obj.data("id");
                    recordId = hid;
                    try{
                        var p={"id":hid,"isoff":isoff};
                        $.post("{:U('Home/Hostel/ajax_switchoff')}",p,function(d){
                            if(d.status==1){
                                // obj.parents("li").remove();
                                alert("修改成功！");
                                $(".hostel_switchoff").each(function(){
                                    if($(this).attr("data-id") == recordId){
                                        if($(this).attr("data-isoff") == 1){
                                            $(this).attr("data-isoff","0");
                                            $(this).val("下架");
                                        }else{
                                            $(this).attr("data-isoff","1");
                                            $(this).val("启用");
                                        }
                                    }
                                });

                            }else{
                                alert(d.info);
                            }
                        });
                    }catch(e){};
                }
                
            })
            var recordId = 0;
            $(".party_switchoff").live("click",function(){
                var obj=$(this);
                var msg = "";
                var isoff = 0;
                if(obj.attr("data-isoff") == '0'){
                    msg = "确认下架吗？";
                    isoff = 1;
                }
                else{
                    msg = "确认启用吗？";
                    isoff = 0;
                }
                if(confirm(msg)){
                    
                    var pid=obj.data("id");
                    recordId = pid;
                    try{
                        var p={"id":pid,"isoff":isoff};
                        $.post("{:U('Home/Party/ajax_switchoff')}",p,function(d){
                            if(d.status==1){
                                // obj.parents("li").remove();
                                alert("修改成功！");
                                $(".party_switchoff").each(function(){
                                    if($(this).attr("data-id") == recordId){
                                        if($(this).attr("data-isoff") == 1){
                                            $(this).attr("data-isoff","0");
                                            $(this).val("下架");
                                        }else{
                                            $(this).attr("data-isoff","1");
                                            $(this).val("启用");
                                        }
                                    }
                                });
                            }else{
                                alert(d.info);
                            }
                        });
                    }catch(e){};
                }
                
            })
        })
        function showBorrow(obj){
            var varname=$(obj).attr("data");
            var p={ "varname":varname,"status":1,"isAjax":1};
            $(obj).addClass("order_list_a1").siblings().removeClass("order_list_a1");
            $.get("{:U('Home/Member/myrelease')}",p,function(d){
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
        function showBorrow_status(obj){
            var index = $(".order_main2_201_list a.order_list_a1").index();
            if(index==0){
                var varname='hostel';
            }else if(index==1){
                var varname='party';
            }
            var status=$(obj).attr("data");
            var p={ "varname":varname,"status":status,"isAjax":1};
            $(obj).addClass("order_list_a2").siblings().removeClass("order_list_a2");
            $.get("{:U('Home/Member/myrelease')}",p,function(d){
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
                var index = $(".order_main2_201_list a.order_list_a1").index();
                if(index==0){
                    var varname='hostel';
                }else if(index==1){
                    var varname='party';
                }
                var index1 = $(".order_main2_201_list2 span.order_list_a2").index();
                if(index1==0){
                    var status='1';
                }else if(index==1){
                    var status='0';
                }
                var p={ "varname":varname,"status":status,"isAjax":1};
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