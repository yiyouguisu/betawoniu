<include file="public:head" />
<include file="public:mheader" />

	<include file="Member:change_menu1" />
    <div class="order_main2">
        <div class="wrap clearfix">
            <include file="Member:member_left1" />
            <div class="My_travels_main fl">
                <div class="My_travels_main2">
                    <div class="My_travels_main2_top hidden">
                        <span class="fl c333 f30">Ta的游记</span>
                    </div>
                    <div class="My_travels_main3" id="DataList">
                        <include file="Member:morelist_note" />
                    </div>
                </div>
                
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $('.ajaxpagebar a').live("click",function(){
            try{    
                var geturl = $(this).attr('href');
                var p={"isAjax":1};
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