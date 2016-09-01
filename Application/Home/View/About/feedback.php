<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<include file="public:mheader" />
<div class="wrap">
        <div class="activity_main">
            <a href="/">首页</a>
            <span>></span>
            <a href="{:U('Home/About/feedback')}">投诉建议</a>
        </div>
    </div>

    <div class="wrap">
        <div class="About_us hidden">
            <div class="fl About_us_left">
                <ul class="About_us_ul">
                    <li <eq name="current_url" value="Home/About/index">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/index')}">
                            关于我们
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/question">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/question')}">
                            常见问题
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/contact">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/contact')}">
                            联系我们
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/privacy">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/privacy')}">
                            隐私政策
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/service">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/service')}">
                            服务条款
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/feedback">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/feedback')}">
                            投诉建议
                        </a>
                    </li>
                </ul>
            </div>
            <div class="fl Complaints">
                <div class="Complaints_top">
                    <span>投诉与建议</span>
                </div>
                <div class="Complaints_center">
                    <span>意见标题：</span>
                    <input type="text" id="title"  name="title"/>
                </div>
                <div class="Complaints_bottom">
                    <span>您的意见：</span>
                    <textarea id="content" placeholder="请在这里输入您的建议或者意见，谢谢！" name="content"></textarea>
                    <i>最少输入<em id="textCount">10</em>个字以上。</i>
                </div>
                <div class="Complaints_bottom2 hidden">
                    <input type="button" value="提      交" class="save" />
                </div>
            </div>
        </div>
    </div>
<include file="public:foot" />
<script>
    $(function(){
        $(".save").click(function(){
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
            var title=$("#title").val();
            if(title==''){
                alert("请输入意见标题！");
                return false;
            }
            var content=$("#content").val();
            if(content==''){
                alert("请输入意见内容！");
                return false;
            }
            var a=$("#content").val().length;
            if(a<10){
                alert("最少输入10个字以上!");
                return false;
            }
            $.post("{:U('Home/About/dofeedback')}",{"title":title,"content":content,"uid":uid},function(d){
                d=eval("("+d+")");
                if(d.code==200){
                    alert(d.msg)
                    $("#title").val("");
                    $("#content").val("");
                }else{
                    alert(d.msg);
                }
            });
        })
    })
</script>