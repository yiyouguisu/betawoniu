<include file="public:head" />
<include file="public:mheader" />

    <include file="Member:change_menu1" />
    <div class="hmain4">
        <div class="wrap hmain5 hidden">
            <div class="fl hmain5_l">
                <div class="hmain5_l1">
                    <div class="hmain5_l2 hidden">
                        <div class="fl hmain5_l3">
                            <p id="attentionnum">{$data.attentionnum|default="0"}</p>
                            <span>关注</span>
                        </div>
                        <div class="fl hmain5_l3">
                            <p id="fansnum">{$data.fansnum|default="0"}</p>
                            <span>粉丝</span>
                        </div>
                    </div>
                    <div class="hmain5_l4">
                        <div class="hmain5_l401">
                            <span>注册时间：</span>
                            <i>{$data.reg_time|date="Y-m-d",###}</i>
                        </div>
                        <div class="hmain5_l401">
                            <span>最后登录：</span>
                            <i>
                                <notempty name="data['lastlogin_time']">
                                    {$data.lastlogin_time|date="Y-m-d",###}
                                    <else />
                                    尚未登录
                                </notempty>
                            </i>
                        </div>
                    </div>
                    <eq name="data['houseowner_status']" value="1">
                        <div class="hmain5_l5">
                            <span>Ta的美宿：</span>
                            <i>{:str_cut($hostel[0]['title'],10)}</i><label>（{$hostel.0.roomnum|default="0"}间房）</label>
                        </div>
                        <a href="{:U('Home/Member/hostel')}">查看更多房东信息</a>
                    </eq>
                </div>
                <div class="hmain5_l6 hidden">
                    <span>今日访问</span>
                    <ul class="hmain5_l6_ul hidden">
                        <volist name="data['viewlist']" id="vo">
                            <li class="fl">
                                <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                    <img src="{$vo.head}" style="width:58px;height:58px;    border-radius: 50%;"/>
                                    <i>{$vo.nickname}</i>
                                </a>
                            </li>
                        </volist>
                    </ul>

                    <div class="hmain5_l6_2">
                        <p>累计访问：<em>{$data.viewnum|default="0"}</em></p>
                        <p>今日访问：<em>{$data.todayviewnum|default="0"}</em></p>
                    </div>
                </div>
                <div class="hmain5_l7">
                    <span>Ta住过的美宿</span>
                    <i>( {$myhostelnum|default="0"} )</i>
                    <ul class="hmain5_l7_ul">
                        <volist name="myhostel" id="vo">
                            <li>
                                <div class="hmain5_l7_ul1 hidden">
                                    <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">
                                        <div class="fl hmain5_l7_ul2">
                                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:83px;height:52px" />
                                        </div>
                                        <div class="fl hmain5_l7_ul3">
                                            <span>{$vo.title}</span>
                                            <i>入住时间：<em>{$vo.starttime|date="Y-m-d",###}</em></i>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </volist>
                    </ul>
                   <!--  <a href="">
                        查看更多
                    </a> -->
                </div>
                <div class="hmain5_l7">
                    <span>Ta参加过的活动</span>
                    <i>( {$mypartynum|default="0"} )</i>
                    <ul class="hmain5_l7_ul">
                        <volist name="myparty" id="vo">
                            <li>
                                <div class="hmain5_l7_ul1 hidden">
                                    <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">
                                        <div class="fl hmain5_l7_ul2">
                                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg"  style="width:83px;height:52px" />
                                        </div>
                                        <div class="fl hmain5_l7_ul3">
                                            <span>{:str_cut($vo['title'],15)}</span>
                                            <i>活动时间：<em>{$vo.starttime|date="Y-m-d",###}</em></i>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </volist>
                    </ul>
                    <!-- <a href="">
                        查看更多
                    </a> -->
                </div>
            </div>
            <div class="fl hmain5_r">
            	<eq name="user['houseowner_status']" value="1">
            		<div class="hmain5_r1">
	                    <ul>
	                        <li>
	                            <div class="hmain5_r1_top">
	                                <span>Ta的美宿</span>
	                            </div>
                                <volist name="hostel" id="vo">
    	                            <div class="hmain5_r1_bottom hidden">
    	                                <div class="fl hmain5_r1_bottom01 pr">
    	                                    <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">
    	                                        <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:245px;height:153px" />
    	                                    </a>
    	                                    <div class="main4_bottom_list2 pa">
    	                                        <img src="__IMG__/Icon/img8.png" />
    	                                    </div>
    	                                </div>
    	                                <div class="fl hmain5_r1_bottom02">
    	                                    <div class="hmain5_r2 hidden">
    	                                        <div class="fl">
    	                                            <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">{$vo.title}</a><i>{$vo.evaluation|default="0.0"}<em>分</em></i>
    	                                        </div>
    	                                        <div class="fr hmain5_r2r">
    	                                            <label><em>￥</em>{$vo.money|default="0.00"}<em>起</em></label>
    	                                        </div>
    	                                    </div>
    	                                    <div class="hmain5_r3">
    	                                        <p>{$vo.description}</p>
    	                                    </div>
    	                                    <div class="hmain5_r4">
    	                                        <div class="fl">
    	                                            <span>房间 :</span><i>{$vo.roomnum|default="0"}间</i>
    	                                        </div>
    	                                        <div class="fr hidden">
    	                                            <div class="fl">
    	                                                <img src="__IMG__/Icon/img10.png" />
    	                                                <label>{$vo.reviewnum|default="0"}</label><label>条点评</label>
    	                                            </div>
    	                                            <div class="fl hmain5_r4_01">
    	                                                <img src="__IMG__/Icon/img9.png" />
    	                                                <label>{$vo.hit|default="0"}</label>
    	                                            </div>
    	                                        </div>
    	                                    </div>
    	                                </div>
    	                            </div>
                                </volist>
	                        </li>
	                    </ul>
                        <a style="display: block;font-size: 16px;color: #999999;text-align: center;border: 1px solid #d1d1d1;line-height: 50px;height: 50px;" href="{:U('Home/Member/hostel',array('uid'=>$data['id']))}">点击查看更多</a>
	                </div>
            	</eq>
                <div class="hmain5_r5">
                    <div>
                        <div class="hmain5_r5_top">
                            <span>Ta的游记</span>
                        </div>
                        <ul class="hmain5_r5_ul">
                            <volist name="note" id="vo">
                                <li>
                                    <div class="hmain5_r5_list hidden">
                                        <div class="fl hmain5_r5_list1">
                                            <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">
                                                <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:202px; height:153px" />
                                            </a>
                                        </div>
                                        <div class="fl hmain5_r5_list2">
                                            <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">{$vo.title}</a>
                                            <i>{$vo.inputtime|date="Y-m-d",###}</i>
                                            <p>{:str_cut($vo['description'],30)}</p>
                                            <div class="hmain5_r5_list2_2 hidden">
                                                <div class="fl hidden hmain5_r5_list2_3">
                                                    <div class="fl">
                                                        <img style="margin-right:3px;" src="__IMG__/Icon/img10.png" /><i>{$vo.reviewnum|default="0"}</i><label>条点评</label>
                                                    </div>
                                                    <div class="fl">
                                                        <img style="margin-left:20px;margin-right:3px;" src="__IMG__/Icon/img9.png" /><label>{$vo.hit|default="0"}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </volist>
                        </ul>
                        <a href="{:U('Home/Member/note',array('uid'=>$data['id']))}">点击查看更多</a>
                    </div>
                </div>
                <div class="hmain5_r6">
                    <div>
                        <div class="hmain5_r6_1">
                            <span>Ta的评论</span>
                        </div>
                        <ul class="hmain5_r6_ul">
                            <volist name="review" id="vo">
                                <eq  name="vo['varname']" value="note">
                                    <li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],20)}</a><span class="hmain5_r6_ul1_a">游记</span>
                                            </div>
                                            <p>{$vo.content}</p>
                                            <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                                        </div>
                                    </li>
                                </eq>
                                <eq  name="vo['varname']" value="party">
                                    <li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],20)}</a><span class="hmain5_r6_ul1_a2">活动</span>
                                            </div>
                                            <p>{$vo.content}</p>
                                            <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                                        </div>
                                    </li>
                                </eq>
                                <eq  name="vo['varname']" value="hostel">
                                    <li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],20)}</a><span class="hmain5_r6_ul1_a1">美宿</span>
                                            </div>
                                            <p>{$vo.content}</p>
                                            <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                                        </div>
                                    </li>
                                </eq>
                                <eq  name="vo['varname']" value="trip">
                                    <li>
                                        <div class="hmain5_r6_ul1">
                                            <div>
                                                <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],20)}</a><span class="hmain5_r6_ul1_a3">行程</span>
                                            </div>
                                            <p>{$vo.content}</p>
                                            <span>发表于 <em>{$vo.inputtime|date="Y-m-d H:i:s",###}</em></span>
                                        </div>
                                    </li>
                                </eq>
                            </volist>  
                        </ul>

                        <a href="{:U('Home/Member/review',array('uid'=>$data['id']))}">点击查看更多</a>

                    </div>
                </div>

                <div class="hmain5_r7">
                    <div>
                        <div class="hmain5_r5_top">
                            <span>Ta的行程</span>
                        </div>
                        <ul class="hmain5_r7_ul">
                            <volist name="trip" id="vo">
                                <li>
                                    <div class="hmain5_r7_ul1">
                                        <a href="{:U('Home/Trip/show',array('id'=>$vo['id']))}">
                                            <div>
                                                <span>{$vo.title}</span><eq name="vo['status']"><label class="hmain5_r7_ul1a">已完成</label><else /><label class="hmain5_r7_ul1a2">进行中</label></eq>
                                            </div>
                                            <i>时间 :<em class="f14 c333">{$vo.starttime|date="Y年m月d日",###} - {$vo.endtime|date="Y年m月d日",###}</em></i>
                                        </a>
                                    </div>
                                </li>
                            </volist>
                        </ul>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".hmain5_l6_2 p").last().css({
                "border-top": "0px"
            })
        })
    </script>

    <script type="text/javascript">
        $(function () {
            $(".hmain5_l3").last().css({
                "border-right": "0px",
            })
        })
    </script>
<include file="public:foot" />