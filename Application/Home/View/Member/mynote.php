<include file="public:head" />
<include file="public:mheader" />

	<include file="Member:member" />
    <div class="order_main2">
        <div class="wrap clearfix">
            <include file="Member:member_left1" />
            <div class="My_travels_main fl">
                <div class="My_travels_main2">
                    <div class="My_travels_main2_top hidden">
                        <span class="fl c333 f30">我发布的游记</span>
                        <a href="{:U('Home/Note/add')}" class="fr">
                            <img src="__IMG__/Icon/img11.png" />发布游记
                        </a>
                    </div>
                    <div class="My_travels_main3" id="DataList">
                        <include file="Member:morelist_mynote" />
                    </div>
                </div>
                
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $(".note_delete").live("click",function(){
                if(confirm("确认删除吗？")){
                    var obj=$(this);
                    var nid=obj.data("id");
                    try{
                        var p={"nid":nid};
                        $.post("{:U('Home/Note/ajax_delete')}",p,function(d){
                            if(d.status==1){
                                obj.parents("li").remove();
                            }else{
                                alert(d.msg);
                            }
                        });
                    }catch(e){};
                }
                
            })
        })
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