<include file="public:head" />
<div class="register pr">
        <div class="Sign_inm2">
            <img src="__IMG__/img33.jpg" />
        </div>
        <div class="wrap">
            <div class="register1" style="height:392px !important;">
                <div class="Sign_in_img">
                    <img src="__IMG__/Icon/img17.png" />
                </div>
                <div class="Information_perfect_a">
                    <div class="Information_perfect_a_top">
                        <span>
                            个人信息完善
                        </span>
                    </div>
                    <div class="Information_perfect_a_bottom">
                        <input type="text" class="Information_perfect_a_text nickname" placeholder="您的昵称 :" />
                        <div class="Information_perfect_a_bottom2">
                            <span>选择性别 :</span>
                            <div class="hidden Information_perfect_a_bottom3">
                                <label class="fl label1" data-id="1">男</label>
                                <label class="fr" data-id="2">女</label>
                            </div>
                        </div>
                        <input type="button" value="进入首页" class="Information_perfect_a_sub save" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Information_perfect_a_bottom3 label").click(function () {
                $(this).addClass("label1").siblings().removeClass("label1");
            })
            $(".Sign_inm2").height($(window).height());
            $(".Sign_inm2").width($(window).width());

            $(".save").click(function(){
            	var sex=$(".Information_perfect_a_bottom3 label.label1").data('id');
            	var nickname=$(".nickname").val();
            	if(nickname==''){
            		alert("请填写昵称");
            		return false;
            	}
            	var p={ "sex":sex,"nickname":nickname};
            	$.post("{:U('Home/Member/doaddinfo')}",p,function(d){
                    d=eval("("+d+")");
                    if(d.code==200){
                        window.location.href="{:U('Home/Member/index')}";
                    }else{
                        alert(d.msg);
                    }
                });
            })
            
        })
    </script>
</body>
</html>