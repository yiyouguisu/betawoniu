<include file="public:head" />
<include file="public:mheader" />

	<include file="Member:member" />
    <div class="order_main2">
        <div class="wrap clearfix">
            <include file="Member:member_left2" />
            <div class="my_comments_main fl">
                <div class="my_comments_main2">
                    <div class="my_comments_main2_head">
                        <span class="f24 c333">我的优惠券</span>
                    </div>
                    <div class="my_comments_main2_head2 clearfix">
                        <ul class="my_comments_main2_head2_ul clearfix fl">
                            <li class="my_comments_main2_head2_list">
                                <a href="javascript:;" data="waituse" onclick="showBorrow(this);">
                                    未使用
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data="usedone" onclick="showBorrow(this);">
                                    已使用
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data="enddone" onclick="showBorrow(this);">
                                    已过期
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="My_coupons_main" id="DataList">
                        <include file="Member:morelist_mycoupons" />
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
            $.get("{:U('Home/Member/mycoupons')}",p,function(d){
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
                    var varname='waituse';
                }else if(index==1){
                    var varname='usedone';
                }else if(index==2){
                    var varname='enddone';
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