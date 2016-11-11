<div class="order_main3">
    <ul class="order_main3_ul">
        <volist name="data" id="vo">
            <li>
                <div class="hidden">
                    <div class="fl order_main3_list">
                        <a href="{:U('Home/Room/show',array('id'=>$vo['productinfo']['rid']))}">
                            <img src="{$vo.productinfo.thumb}" style="width:142px;height:88px" />
                        </a>
                    </div>
                    <div class="fl order_main3_list2">
                        <div class="order_main3_list2_top hidden">
                            <a href="{:U('Home/Room/show',array('id'=>$vo['productinfo']['rid']))}" class="f24 c333 fl">{$vo.productinfo.title}</a>
                            <a href="{:U('Home/Order/hostelshow',array('orderid'=>$vo['orderid']))}" class="fr order_main3_list2_top_a2">查看订单详情 ></a>
                        </div>
                        <div class="order_main3_list2_bottom hidden">
                            <div class="fl hidden order_main3_list2_bottom4">
                                <i class="f22">￥</i><span class="f36">{$vo.money|default="0.00"}</span><label class="f18"></label>
                            </div>
                            <if condition="$vo['uid'] neq $user['id']">
                                <eq name="vo['status']" value="1">
                                    <div class="fr order_main3_list2_bottom6 ">
                                        <i>预定</i>
                                        <a href="{:U('Home/Woniu/orderreview',array('orderid'=>$vo['orderid']))}">去审核</a>
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="2">
                                    <div class="fr order_main3_list2_bottom3 ">
                                        <a href="javascript:;">待付款</a>
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="3">
                                    <div class="fr order_main3_list2_bottom7 ">
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
                                            <eq name="vo['evaluate_status']" value="0">
                                                <a href="javascript:;">待评价</a>
                                                <else />
                                                <a href="javascript:;">已完成</a>
                                            </eq>
                                            <else />
                                            <eq name="vo['refund_status']" value="0">
                                                <a href="javascript:;">待入住</a>
                                            </eq>
                                            <eq name="vo['refund_status']" value="1">
                                                <i>退订</i>
                                                <a href="{:U('Home/Woniu/refundorderreview',array('orderid'=>$vo['orderid']))}">去审核</a>
                                            </eq>
                                            <eq name="vo['refund_status']" value="2">
                                                <i>已退订</i>
                                            </eq>
                                            <eq name="vo['refund_status']" value="3">
                                                <i>审核失败</i>
                                                <a href="javascript:;" class="remark" data-remark="{$vo.refundreview_remark}"  style="background: #8c8e85;">失败原因</a>
                                            </eq>
                                        </if>   
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="5">
                                    <div class="fr order_main3_list2_bottom7 ">
                                        <i>审核失败</i>
                                        <a href="javascript:;" class="remark" data-remark="{$vo.review_remark}">失败原因</a>
                                    </div>
                                </eq>
                                <else />
                                <eq name="vo['status']" value="1">
                                    <div class="fr order_main3_list2_bottom6 ">
                                        <i>预定</i>
                                        <a href="javascript:;">待审核</a>
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="2">
                                    <div class="fr order_main3_list2_bottom3 ">
                                        <a href="{:U('Home/Order/bookpay',array('orderid'=>$vo['orderid']))}">去支付</a>
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="3">
                                    <div class="fr order_main3_list2_bottom7 ">
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
                                            <eq name="vo['evaluate_status']" value="0">
                                                <a href="{:U('Home/Order/evaluate',array('orderid'=>$vo['orderid']))}">我要评价</a>
                                                <else />
                                                <a href="javascript:;">已完成</a>
                                            </eq>
                                            <else />
                                            <eq name="vo['refund_status']" value="0">
                                                <a href="javascript:;">待入住</a>
                                            </eq>
                                            <eq name="vo['refund_status']" value="1">
                                                <i>退订</i>
                                                <a href="javascript:;">待审核</a>
                                            </eq>
                                            <eq name="vo['refund_status']" value="2">
                                                <i>已退订</i>
                                            </eq>
                                            <eq name="vo['refund_status']" value="3">
                                                <i>审核失败</i>
                                                <a href="javascript:;" class="remark" data-remark="{$vo.refundreview_remark}" style="background: #8c8e85;">失败原因</a>
                                            </eq>
                                        </if>
                                            
                                    </div>
                                </eq>
                                <eq name="vo['status']" value="5">
                                    <div class="fr order_main3_list2_bottom7 ">
                                        <i>审核失败</i>
                                        <a href="javascript:;" class="remark" data-remark="{$vo.review_remark}">失败原因</a>
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