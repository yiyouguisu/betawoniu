<include file="public:head" />
<include file="public:mheader" />

	<include file="Member:member" />
    <div class="order_main2">
        <div class="wrap clearfix">
            <include file="Member:member_left2" />
            <div class="my_comments_main fl">
                <div class="my_comments_main2">
                    <div class="my_comments_main2_head">
                        <span class="f24 c333">我的评论</span>
                    </div>
                    <div class="my_comments_main2_head2">
                        <ul class="my_comments_main2_head2_ul clearfix">
                            <li class="my_comments_main2_head2_list">
                                <a href="javascript:;" data="all" onclick="showBorrow(this);">
                                    全部
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data="hostel" onclick="showBorrow(this);">
                                    美宿
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data="note" onclick="showBorrow(this);">
                                    游记
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data="party" onclick="showBorrow(this);">
                                    活动
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data="trip" onclick="showBorrow(this);">
                                    行程
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="my_comments_main2_body" id="DataList">
                        <include file="Member:morelist_myreview" />
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
            $(obj).parent("li").addClass("my_comments_main2_head2_list").siblings().removeClass("my_comments_main2_head2_list");
            $.get("{:U('Home/Member/myreview')}",p,function(d){
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
                var index = $(".my_comments_main2_head2_ul li.my_comments_main2_head2_list").index();
                if(index==0){
                    var varname='all';
                }else if(index==1){
                    var varname='hostel';
                }else if(index==2){
                    var varname='note';
                }else if(index==3){
                    var varname='party';
                }else if(index==4){
                    var varname='trip';
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
        
        $(".reviewdel").live("click",function(){
            if(confirm("确认删除吗？")){
                var obj=$(this);
                var rid=obj.data("id");
                try{
                    var p={"rid":rid};
                    $.post("{:U('Home/Member/ajax_deletereview')}",p,function(d){
                        if(d.status==1){
                            obj.parents("li").remove();
                        }else{
                            alert(d.msg);
                        }
                    });
                }catch(e){};
            }
            
        })
    </script>

<include file="public:foot" />