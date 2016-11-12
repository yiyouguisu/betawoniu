<div class="order_main3">
    <ul class="order_main3_ul">
        <volist name="data" id="vo">
            <li>
                <div class="hidden">
                    <div class="fl order_main3_list">
                        <a href="{:U('Home/Party/show',array('id'=>$vo['productinfo']['aid']))}">
                            <img src="{$vo.productinfo.thumb}" style="width:142px;height:88px" />
                        </a>
                    </div>
                    <div class="fl order_main3_list2">
                        <div class="order_main3_list2_top hidden">
                            <a href="{:U('Home/Party/show',array('id'=>$vo['productinfo']['aid']))}" class="f24 c333 fl">{$vo.productinfo.title}</a>
                            <a href="{:U('Home/Order/partyshow',array('orderid'=>$vo['orderid']))}" class="fr order_main3_list2_top_a2">查看订单详情 ></a>
                        </div>
                        <div class="order_main3_list2_bottom hidden">
                            <div class="fl order_main3_list2_bottom5">
                                <span class="f14 c999">时间 :<em class="c666 f12">{$vo.productinfo.starttime|date="Y-m-d",###} - {$vo.productinfo.endtime|date="Y-m-d",###}</em></span>
                                <span class="f14 c999">地点 :<em class="c666 f14">{:getarea($vo['productinfo']['area'])}{$vo.productinfo.address} </em></span>
                            </div>

                            <if condition="$vo['uid'] neq $user['id']">
                                <eq name="vo['status']" value="2">
                                    <div class="fr order_main3_list2_bottom3 ">
                                        <i>待付款</i>
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="3">
                                    <div class="fr order_main3_list2_bottom6 ">
                                        <eq name="vo['refund_status']" value="2">
                                            <i>退订成功</i>
                                            <else />
                                            <i>已取消</i>
                                        </eq>
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="4">
                                    <div class="fr order_main3_list2_bottom2 ">
                                        <if condition="$vo['endtime'] lt time()">
                                            <i>已完成</i>
                                            <else />
                                            <eq name="vo['refund_status']" value="0">
                                                <i>待参加</i>
                                            </eq>
                                            <eq name="vo['refund_status']" value="1">
                                                <i>退订</i>
                                                <a href="{:U('Home/Woniu/refundorderreview',array('orderid'=>$vo['orderid']))}">去审核</a>
                                            </eq>
                                            <eq name="vo['refund_status']" value="2">
                                                <i>退订成功</i>
                                            </eq>
                                            <eq name="vo['refund_status']" value="3">
                                                <i>审核失败</i>
                                                <a href="javascript:;" class="remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a>
                                            </eq>
                                        </if>
                                    </div>
                                </eq>
                                <else />
                                <eq name="vo['status']" value="2">
                                    <div class="fr order_main3_list2_bottom3 ">
                                        <a href="{:U('Home/Order/joinpay',array('orderid'=>$vo['orderid']))}">去支付</a>
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="3">
                                    <div class="fr order_main3_list2_bottom6 ">
                                        <eq name="vo['refund_status']" value="2">
                                            <i>退订成功</i>
                                            <else />
                                            <i>已取消</i>
                                        </eq>
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="4">
                                    <div class="fr order_main3_list2_bottom2 ">
                                        <if condition="$vo['endtime'] lt time()">
                                            <i>已完成</i>
                                            <else />
                                            <eq name="vo['refund_status']" value="0">
                                                <i>待参加</i>
                                            </eq>
                                            <eq name="vo['refund_status']" value="1">
                                                <i>退订</i>
                                                <a href="javascript:;">待审核</a>
                                            </eq>
                                            <eq name="vo['refund_status']" value="2">
                                                <i>退订成功</i>
                                            </eq>
                                            <eq name="vo['refund_status']" value="3">
                                                <i>审核失败</i>
                                                <a href="javascript:;" class="remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a>
                                            </eq>
                                        </if>
                                    </div>
                                </eq>
                            </if>
                        </div>
                    </div>
                </div>
            </li>
        </volist>
    </ul>
</div>
<div style="height:20px;"></div>
<div class="activity_chang4 ajaxpagebar">
    {$Page}
</div>