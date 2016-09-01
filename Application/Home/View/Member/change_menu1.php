<div class="hmain_main2"  style="background: url('{$data.background|default='__IMG__/img51.jpg'}') no-repeat center center;padding: 30px 0 30px 0;    background-size: 1920px 200px;">
        <div class="wrap">
            <div class="middle hmain_main2_1">
                <img src="{$data.head}" />
            </div>
            <div class="middle hmain_main2_2">
                <div class="hmain_main2_2_top">
                    <span class="middle">{$data.nickname|default="未设置"}</span>
                    <eq name="data['realname_status']" value="1"><img src="__IMG__/Icon/img14.png" /></eq>
                    <eq name="data['houseowner_status']" value="1"><img src="__IMG__/Icon/img15.png" /></eq>
                    <a <eq name="data['isattention']" value="1"> class="middle hmain_chang"<else /> class="middle"</eq> href="javascript:;" id="attention">关注</a>
                    <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['id']))}" class="middle">私信</a>
                </div>
                <div class="hmain_main2_2_bottom">
                    <span>{$data.info}</span>
                    <volist name="data['characteristic']" id="vo">
                        <i>
                            {$vo.name}
                        </i>
                    </volist>
                    <volist name="data['hobby']" id="vo">
                        <i>
                            {$vo.name}
                        </i>
                    </volist>
                </div>
            </div>
        </div>
    </div>
    <div <eq name="user['houseowner_status']" value='1'> class="hmain6"<else /> class="hmain3"</eq>>
        <div class="wrap">
            <ul <eq name="user['houseowner_status']" value='1'> class="hmain6_ul hidden"<else /> class="hmain3_ul hidden"</eq>>
                <li <eq name="user['houseowner_status']" value='1'><eq name="current_url" value="Home/Member/detail">class="hmain6_li"</eq><else /> <eq name="current_url" value="Home/Member/detail">class="hmain3_li"</eq></eq>>
                    <a href="{:U('Home/Member/detail',array('uid'=>$data['id']))}">Ta的主页</a>
                </li>
                <li class="">
                    |
                </li>
                <li <eq name="user['houseowner_status']" value='1'><eq name="current_url" value="Home/Member/note">class="hmain6_li"</eq><else /> <eq name="current_url" value="Home/Member/note">class="hmain3_li"</eq></eq>>
                    <a href="{:U('Home/Member/note',array('uid'=>$data['id']))}">Ta的游记</a>
                </li>
                <eq name="user['houseowner_status']" value="1">
                	<li class="">
	                    |
	                </li>
                	<li <eq name="user['houseowner_status']" value='1'><eq name="current_url" value="Home/Member/party">class="hmain6_li"</eq><else /> <eq name="current_url" value="Home/Member/party">class="hmain3_li"</eq></eq>>
	                    <a href="{:U('Home/Member/party',array('uid'=>$data['id']))}">Ta的活动</a>
	                </li>
	                <li class="">
	                    |
	                </li>
	                <li <eq name="user['houseowner_status']" value='1'><eq name="current_url" value="Home/Member/hostel">class="hmain6_li"</eq><else /> <eq name="current_url" value="Home/Member/hostel">class="hmain3_li"</eq></eq>>
	                    <a href="{:U('Home/Member/hostel',array('uid'=>$data['id']))}">Ta的美宿</a>
	                </li>
                </eq>
                <li class="">
                    |
                </li>
                <li <eq name="user['houseowner_status']" value='1'><eq name="current_url" value="Home/Member/review">class="hmain6_li"</eq><else /> <eq name="current_url" value="Home/Member/review">class="hmain3_li"</eq></eq>>
                    <a href="{:U('Home/Member/review',array('uid'=>$data['id']))}">Ta的评论</a>
                </li>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".hmain3_ul li:even").css({
                "width":"410px",
                "text-align":"center"
            })
            $(".hmain3_ul li").first().css({
                "margin-left": "0px"
            })
            $(".hmain3_ul li").last().css({
                "margin-right": "0px"
            })
            $(".hmain6_ul li:even").css({
                "padding-right": "109px",
                "padding-left":"109px"
            })
            $(".hmain6_ul li").first().css({
                "padding-left": "0px"
            })
            $(".hmain6_ul li").last().css({
                "padding-right": "0px"
            })
            $("#attention").click(function(){
                var tuid="{$data.id}";
                $.ajax({
                     type: "POST",
                     url: "{:U('Home/Member/ajax_attention')}",
                     data: {'tuid':tuid},
                     dataType: "json",
                     success: function(data){
                        alert(data.msg)
                        if(data.code==200){
                            $("#attention").toggleClass("hmain_chang");
                            $("#fansnum").text(data.fansnum);
                        }
                     }
                })  
            })
        })
    </script>