<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script src="__JS__/WdatePicker.js"></script>
<script src="__JS__/work.js"></script>
<include file="public:mheader" />
<div style="background:#f4f4f4;">
        <div class="wrap">
            <div style="padding-top:28px;"></div>
            <div class="payment hidden">
                <div class="fl payment_main_11">
                    <span>填写订单</span>
                </div>
                <div class="fl payment_main_15">
                    <!--灰色样式类名 payment_main_02    蓝色样式类名payment_main_05-->
                    <span>房东确认</span>
                </div>
                <div class="fl payment_main_13">
                    <!--灰色样式类名 payment_main_03    蓝色样式类名payment_main_06-->
                    <span>支付钱款</span>
                </div>
                <div class="fl payment_main_14">
                    <!--灰色样式类名 payment_main_04    蓝色样式类名payment_main_07-->
                    <span>预订完成</span>
                </div>
            </div>
        </div>
        <div class="wrap">
            <div class="payment_main2 clearfix">
                <span class="payment_main2_span">房东确认信息 :</span>
                <div class="Landlord_confirmation_main">
                    <div class="Landlord_confirmation_main_1">
                        <div class="Landlord_confirmation_main_2">
                            <img src="__IMG__/Icon/img73.png" />
                            <span>您的订单已经提交</span>
                            <i>请耐心等待房东的确认，确认后我们通过消息或短信第一时间通知您</i>
                        </div>
                        <div class="Landlord_confirmation_main_3 hidden">
                            <div class="fl Landlord_confirmation_main_4">
                                <span class="f14 c999">房东 ：</span>
                                <a href="{:U('Home/Member/detail',array('uid'=>$data['uid']))}" class="Landlord_confirmation_main_4a">{$data.nickname}</a>
                                <a href="{:U('Home/Woniu/chatdetail',array('tuid'=>$data['uid']))}" class="Landlord_confirmation_main_4a2">在线聊天</a>
                            </div>
                            <div class="fr Landlord_confirmation_main_5">
                                <i class="f14 c666">该房东平均确定时间：<em> {$data['evaluationconfirm']}分钟</em></i>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="Landord_confirmation_span">该房东的其他房间推荐 :</span>
                <div class="Landord_confirmation_main6 hidden">
                    <ul class="Landord_confirmation_main6_ul">
                        <volist name="house_owner_room" id="vo">
                            <li>
                                <div class="Landord_confirmation_main6_list">
                                    <div class="pr Landord_confirmation_main6_list2">
                                        <a href="{:U('Home/Room/show',array('id'=>$vo['id']))}">
                                            <img src="{$vo.thumb}" style="width:280px;height:175px">
                                        </a>
                                        <div class="pa Landord_confirmation_main6_list2_01">
                                            <i>￥<em>{$vo.money|default="0.00"}</em></i><span>起</span>
                                        </div>
                                        <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Landord_confirmation_main6_list2_02 pa shoucang_hostel collect"<else /> class="Landord_confirmation_main6_list2_02 pa shoucang_hostel"</eq>></div>
                                    </div>
                                    <div class="Landord_confirmation_main6_list_list3">
                                        <a href="{:U('Home/Room/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],10)}</a>
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
<script type="text/javascript">
        $(function () {
            $(".zanbg1_hostel").live("click",function(){
                var obj=$(this);
                var uid='{$user.id}';
                if(!uid){
                    alert("请先登录！");
                    var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                    return false;
                }
                var hitnum=$(this).siblings(".zannum");
                var rid=$(this).data("id");
                $.ajax({
                     type: "POST",
                     url: "{:U('Home/Room/ajax_hit')}",
                     data: {'rid':rid},
                     dataType: "json",
                     success: function(data){
                                if(data.status==1){
                                  if(data.type==1){
                                    var num=Number(hitnum.text()) + 1;
                                    hitnum.text(num);
                                    obj.attr("src","/Public/Home/images/dianzan.png");
                                  }else if(data.type==2){
                                    var num=Number(hitnum.text()) - 1;
                                    hitnum.text(num);
                                    obj.attr("src","/Public/Home/images/Icon/img9.png");
                                  }
                                }else if(data.status==0){
                                  alert("点赞失败！");
                                }
                              }
                  });
              });
            
            $(".shoucang_hostel").live("click",function(){
                var obj=$(this);
                var uid='{$user.id}';
                if(!uid){
                    alert("请先登录！");
                    var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
                    return false;
                }
                var rid=$(this).data("id");
                $.ajax({
                     type: "POST",
                     url: "{:U('Home/Room/ajax_collect')}",
                     data: {'rid':rid},
                     dataType: "json",
                     success: function(data){
                                if(data.status==1){
                                  if(data.type==1){
                                    obj.addClass("collect");
                                  }else if(data.type==2){
                                    obj.removeClass("collect");
                                  }
                                }else if(data.status==0){
                                  alert("收藏失败！");
                                }
                              }
                  });
              });
        });
    </script>
<include file="public:foot" />