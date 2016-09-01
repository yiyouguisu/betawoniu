<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script src="__JS__/WdatePicker.js"></script>
<script src="__JS__/work.js"></script>
<include file="public:mheader" />

<div class="Legend_comment">
        <div class="wrap">
            <div class="Legend_comment_main1">
                <span>美宿点评 :</span>
                <div class="Legend_comment_main1_1 hidden">
                    <div class="Legend_comment_main1_2 fl">
                        <a href="{:U('Home/Hostel/show',array('id'=>$data['hid']))}">
                            <img src="{$data['thumb']}" style="width:184px;height:115px" />
                        </a>
                    </div>
                    <div class="fl Legend_comment_main1_3">
                        <div class="hidden Legend_comment_main1_6">
                            <a href="{:U('Home/Hostel/show',array('id'=>$data['hid']))}" class="f28 c333 fl">{$data['hostel']}</a>
                            <i>{$data.evaluation|default="0.0"}<em>分</em></i>
                        </div>
                        <div class="Legend_comment_main1_4">
                            <img src="__IMG__/Icon/img44.png" /><span class="c333 f14">客栈地址 :<em>{:getarea($data['area'])}{$data.address}</em></span>
                        </div>
                        <div class="Legend_comment_main1_5">
                            <span class="middle">房东：</span>
                            <a href="{:U('Home/Woniu/chatdetail',array('uid'=>$data['houseownerid']))}" class="middle">
                                <div>
                                    <img src="{$data.head}" style="width:24px;height:24px" />
                                </div>
                                <em>{$data.nickname}</em>
                            </a>
                        </div>
                    </div>
                    
                </div>
                <div class="Legend_comment_main2">
                    <div class="Legend_comment_main2_1">
                        <span class="middle">整洁卫生：</span>
                        <ul class="Legend_comment_main2_1_ul middle neat">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="Legend_comment_main2_1">
                        <span class="middle">安全程度：</span>
                        <ul class="Legend_comment_main2_1_ul middle safe">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="Legend_comment_main2_1">
                        <span class="middle">描述相符：</span>
                        <ul class="Legend_comment_main2_1_ul middle match">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="Legend_comment_main2_1">
                        <span class="middle">交通位置：</span>
                        <ul class="Legend_comment_main2_1_ul middle position">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="Legend_comment_main2_1">
                        <span class="middle">性价比：</span>
                        <ul class="Legend_comment_main2_1_ul middle cost">
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="Legend_comment_main2_2">
                        <span>评价内容：</span>
                        <textarea id="content" name="content"></textarea>
                    </div>
                    <div class="Legend_comment_main2_3">
                        <input class="sub2 save" type="button" value="确定" />
                        <input class="checkbox2" type="checkbox" id="isanonymous" name="isanonymous" value="1" /><span class="f14 c333">匿名点评</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            $(".Legend_comment_main2_1_ul li").click(function () {
                $(this).addClass("Legend_comment_chang")
                $(this).prevAll().addClass("Legend_comment_chang")
                $(this).nextAll().removeClass("Legend_comment_chang")
            })
            $(".save").click(function(){
                var neat=$("ul.neat li.Legend_comment_chang").length;
                var safe=$("ul.safe li.Legend_comment_chang").length;
                var match=$("ul.match li.Legend_comment_chang").length;
                var position=$("ul.position li.Legend_comment_chang").length;
                var cost=$("ul.cost li.Legend_comment_chang").length;
                var content=$("#content").val();
                if(content==''){
                    alert("请填写评论内容！");
                    return false;
                }
                var isanonymous=$("#isanonymous").prop("checked")?1:0;
                var orderid="{$data.orderid}";
                var p={};
                p['neat']=neat*2;
                p['safe']=safe*2;
                p['match']=match*2;
                p['position']=position*2;
                p['cost']=cost*2;
                p['content']=content;
                p['isanonymous']=isanonymous;
                p['orderid']=orderid;
                $.post("{:U('Home/Order/doevaluate')}",p,function(data){
                    data=eval("("+data+")");
                    if(data.code==200){
                        alert("评价成功！");
                        window.location.href="{:U('Home/Member/myorder_hostel')}";
                    }else{
                        alert("评价失败！");
                    }
                })
            })
        })
    </script>
<include file="public:foot" />