<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
    <link href="__CSS__/chosen.css" rel="stylesheet" />
    <script src="__JS__/jquery-ui.min.js"></script>
    <link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
    <script src="__JS__/jquery.jqtransform.js"></script>
<include file="public:mheader" />
<div style="background:#f4f4f4;">
        <div class="wrap">
            <div class="payment_main2 clearfix">
                <div class="activity_main">
                    <a href="/">首页</a>
                    <span>></span>
                    <a href="{:U('Home/Party/add')}">活动发布</a>
                </div>
                <div class="Landlord_confirmation_main">
                    <div class="Landlord_confirmation_main_1">
                        <div class="Landlord_confirmation_main_2 hidden">
                            <img src="__IMG__/Icon/img73.png" />
                            <span>恭喜！您的活动发布成功</span>
                            <label>我们会在24小时内尽快审核，审核通过后会第一时间通知您</label>
                        </div>
                    </div>
                </div>
                <span class="Landord_confirmation_span">精选美宿推荐 :</span>
                <div class="Landord_confirmation_main6 hidden">
                    <ul class="Landord_confirmation_main6_ul">
                        <volist name="data['party_near_hostel']" id="vo">
                            <li>
                                <div class="Landord_confirmation_main6_list">
                                    <div class="pr Landord_confirmation_main6_list2">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            <img src="{$vo.head}">
                                        </a>
                                        <div class="pa Landord_confirmation_main6_list2_01">
                                            <i>￥<em>{$vo.money|default="0.00"}</em></i><span>起</span>
                                        </div>
                                        <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Landord_confirmation_main6_list2_02 shoucang_hostel collect"<else /> class="Landord_confirmation_main6_list2_02 shoucang_hostel"</eq>></div>
                                    </div>
                                    <div class="Landord_confirmation_main6_list_list3">
                                        <a href="{:U('Home/Hostel/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],10)}</a>
                                        <div class="hidden">
                                            <div class="fl">
                                                <img src="__IMG__/Icon/img10.png" />
                                                <span class="f14 c999"><em>{$vo.reviewnum|default="0"}</em>条点评</span>
                                            </div>
                                            <div class="fr tr cur">
                                                <eq name="vo['ishit']" value="1">
                                                    <img src="__IMG__/dianzan.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="{$vo.id}"/>
                                                    <else />
                                                    <img src="__IMG__/Icon/img9.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="{$vo.id}"/>
                                                </eq>
                                                <i class="zannum">{$vo.hit|default="0"}</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </volist>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<include file="public:foot" />