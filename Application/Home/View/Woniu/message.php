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
            <a href="{:U('Home/Woniu/index')}">蜗牛</a>
            <span>></span>
            <a href="{:U('Home/Woniu/message')}">我的消息</a>
        </div>
    </div>


    <div class="wrap">
        <div class="Snail_home_main hidden">
            <div class="fl Snail_home_ml">
                <ul class="Snail_home_ml_ul">
                    <li class=""><!--Snail_home_ml_list-->
                        <a href="{:U('Home/Woniu/index')}">我的好友</a>
                    </li>
                    <li class="">
                        <!--Snail_home_ml_list2-->
                        <a href="{:U('Home/Woniu/chat')}">正在聊天</a>
                    </li>
                    <li class="Snail_home_ml_list2"><!--Snail_home_ml_list3-->
                        <a href="{:U('Home/Woniu/message')}">我的消息</a>
                    </li>
                </ul>
            </div>
            <div class="fl Snail_home_mr">
                <div class="Snail_home_c">
                    <ul class="Snail_home_c_ul">
                        <volist name="data" id="vo">
                            <if condition="$vo['varname'] eq 'applyrealnamesuccess'" > 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;"  <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'successbookhouse'" /> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq>  data-id="{$vo.id}" data-href="{:U('Home/Order/show',array('orderid'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'applyhouseownersuccess'" /> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'refundreviewsuccess'" /> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Order/show',array('orderid'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'withdrawsuccess'" /> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Home/Member/mywallet')}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'applyrealnamefail'" />
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Home/Member/realname')}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'failbookhouse'" />
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Order/show',array('orderid'=>$vo['value']))}">
                                         <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'applyhouseownerfail'" />
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Member/houseowner')}">
                                         <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'withdrawfail'" />
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Member/mywallet')}">
                                         <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'refundreviewfail'" />
                                <li class="Snail_home_c_color2">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Order/show',array('orderid'=>$vo['value']))}">
                                         <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'payordersuccess'" />
                                <li class="Snail_home_c_color3">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Order/show',array('orderid'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'applybookhouse'"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Home/Woniu/show',array('id'=>$vo['id']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                        <div class="middle Snail_home_c_list2 tr">
                                            <i>查看详细 <img src="__IMG__/Icon/img119.png" /></i>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'brefundhostelapply' or $vo['varname'] eq 'brefundpartyapply'"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Home/Woniu/refundreview',array('id'=>$vo['id']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                        <div class="middle Snail_home_c_list2 tr">
                                            <i>查看详细 <img src="__IMG__/Icon/img119.png" /></i>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'refundhostelapply' or $vo['varname'] eq 'refundpartyapply'"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Home/Order/show',array('orderid'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'successreviewnote'" /> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Note/show',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'successreviewparty'" /> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Party/show',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'successreviewhostel'" /> 
                                <li class="Snail_home_c_color">
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Hostel/show',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'failreviewnote' or $vo['varname'] eq 'failreviewparty' or $vo['varname'] eq 'failreviewhostel'" />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Home/Woniu/reviewshow',array('id'=>$vo['id']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                        <div class="middle Snail_home_c_list2 tr">
                                            <i>查看详细 <img src="__IMG__/Icon/img119.png" /></i>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'waitcheck'"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="$vo['varname'] eq 'getcoupons'"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}" data-href="{:U('Home/Memmber/couponsshow',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="($vo['varname'] eq 'notehit') OR ($vo['varname'] eq 'notecollect') OR ($vo['varname'] eq 'notereview')"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Note/show',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="($vo['varname'] eq 'partyhit') OR ($vo['varname'] eq 'partycollect') OR ($vo['varname'] eq 'partyreview')"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Party/show',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="($vo['varname'] eq 'hostelhit') OR ($vo['varname'] eq 'hostelcollect') OR ($vo['varname'] eq 'hostelreview')"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Hostel/show',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="($vo['varname'] eq 'roomhit') OR ($vo['varname'] eq 'roomcollect') OR ($vo['varname'] eq 'roomreview')"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Room/show',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="($vo['varname'] eq 'triphit') OR ($vo['varname'] eq 'tripcollect') OR ($vo['varname'] eq 'tripreview')"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Trip/show',array('id'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <elseif condition="($vo['varname'] eq 'fattention') OR ($vo['varname'] eq 'tattention')"  />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}"  data-href="{:U('Home/Member/detail',array('uid'=>$vo['value']))}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            <else />
                                <li>
                                    <a href="javascript:;" <eq name="vo['status']" value="0">class="operation redirect"<else />class="redirect"</eq> data-id="{$vo.id}">
                                        <eq name="vo['status']" value="0"><div class="My_news_main_02_float"></div></eq>
                                        <div class="middle Snail_home_c_list">
                                            <span>{$vo.content}</span>
                                            <p>{$vo.inputtime|date="Y-m-d H:i:s",###} </p>
                                        </div>
                                    </a>
                                </li>
                            </if>
                        </volist>
                    </ul>
                </div>

                <div class="travels_main3"></div>
                    <div class="activity_chang4">
                        {$Page}
                    </div>
                <div class="" style="width: 2px; height: 80px;"></div>
            </div>
        </div>
    </div>
<script>
    $(function(){
        $(".operation").click(function(){
            var obj=$(this);
            var mid=obj.data("id");
            var locationurl=obj.data("href");
            $.post("{:U('Home/Woniu/updatestatus')}",{"mid":mid},function(d){
                d=eval("("+d+")");
                if(d.code==200){
                    obj.find(".My_news_main_02_float").remove();
                    if(locationurl){
                        window.location.href=locationurl;
                    }
                }else{
                    alert(d.msg);
                }
            });
        })
        $(".redirect").click(function(){
            var obj=$(this);
            var locationurl=obj.data("href");
            if(locationurl){
                window.location.href=locationurl;
            }
        })
    })
</script>
<include file="public:foot" />
