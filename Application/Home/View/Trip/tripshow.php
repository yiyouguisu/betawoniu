<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script>
    $(function(){
        var dateInput = $("input.J_date")
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker();
            });
        }
    })
</script>
<include file="public:mheader" />
<div style="background:#efefef;" class="hidden">
    <div class="wrap">
        <div class="activity_main">
            <a href="/">首页</a>
            <span>></span>
            <a href="{:U('Home/Trip/index')}">行程</a>
            <span>></span>
            <a href="{:U('Home/Trip/tripshow',array('id'=>$data['id']))}">行程详情</a>
        </div>
        <div class="">
            <div class="Edit_stroke_main">
                <div class="Edit_stroke_main_top">
                    <span>{$data.title}</span>
                    <p>( {$data.description} )</p>
                    <label>{$data.starttime|date="Y年m月d日",###} 至 {$data.endtime|date="Y年m月d日",###}</label>
                    <i>进行中</i>
                    <div style="padding-bottom:28px;"></div>
                </div>
                <div class="Edit_stroke_main_bottom">
                    <ul class="Edit_stroke_main_bottom_ul">
                        <volist name="data['tripinfo']" id="vo">
                            <volist name="vo['eventcity']" id="v">
                                <li>
                                    <div class="hidden Edit_stroke_main_bottom_list" style="font-size: 0;">
                                        <div class="middle Edit_stroke_main_bottom_list_1">
                                            <span>{$vo.date|date="m月d日",###}</span>
                                        </div>
                                        <div class="middle Edit_stroke_main_bottom_list_c">
                                            <span>{$v.cityname}</span>
                                            <i>{$v.place}</i>
                                        </div>
                                        <div class="middle Edit_stroke_main_bottom_list_r">
                                            <volist name="v['event']" id="k">
                                                <div class="Edit_stroke_main_bottom_r1">
                                                    <span class="middle">{:str_cut($k['event'],10)}</span>
                                                    <eq name="k['pay_status']" value="1">
                                                        <div class="middle Edit_stroke_main_bottom_r1a2">
                                                            <i>已付</i>
                                                        </div>
                                                        <else />
                                                        <div class="Edit_stroke_main_bottom_r1a1 middle">
                                                            <i class="middle">未付</i>
                                                            <a href="{:U('Home/Order/show',array('orderid'=>$k['orderid']))}" class="middle">去支付</a>
                                                        </div>
                                                    </eq>
                                                </div>
                                            </volist>
                                        </div>
                                    </div>
                                </li>
                            </volist>
                        </volist>
                    </ul>
                    
                    <div class="Edit_stroke_main_bottom2">
                        <input type="text" id="radio2" <eq name="data['ispublic']" value="1"> class="Edit_stroke_radio setpublic Edit_stroke_radio2"<else /> class="Edit_stroke_radio setpublic"</eq> /><label for="radio2">公开我的行程</label>
                    </div>
                </div>
                <div class="Edit_stroke_main2">
                    <span class="travels2_bottom3">编辑我的行程</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="Mask3 hide">
        
</div>
<div class="travels2_a hide">
    <div class="travels2_a_top pr">
        <span class="f22 c666">
            编辑行程时间
        </span>
        <i class="travels2_a_top2">
            <img src="__IMG__/Icon/img107.png" />
        </i>
    </div>
    <div class="travels2_a_bottom">
        <div class="travels2_a_bottom2">
            <span>行程标题 :</span>
            <input type="text" id="trip_title" value="{$data.title}" />
        </div>
        <div class="travels2_a_bottom3 hidden">
            <div class="travels2_a_bottom4 fl">
                <span>出发时间 :</span>
                <input value="{$data.starttime|date='Y-m-d',###}" type="text" class="J_date" id="trip_starttime" />
            </div>
            <div class="fr travels2_a_bottom5">
                <span class="middle">出发天数 :</span>
                <div class="travels2_a_bottom6 middle hidden">
                    <input type="text" value="{$data.days|default='0'}" id="trip_days"/>
                    <i>天</i>
                </div>
            </div>
        </div>
        <div class="travels2_a2">
            <input type="button" class="edittrip" data-tid="{$data.id}" value="提交" />
        </div>
    </div>
</div>
<script type="text/javascript">
        $(function () {
            $(".Mask3").height($(window).height());
            $(".travels2_bottom3").click(function () {
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
                $(".Mask3").show();
                $(".travels2_a").show();
            })
            $(".Mask3,.travels2_a_top2").click(function () {
                $(".Mask3").hide();
                $(".travels2_a").hide();
            })
            $(".edittrip").click(function(){
                var p={};
                var trip_title=$("#trip_title").val();
                if(trip_title==''){
                    alert("请填写行程标题！");
                    return false;
                }
                var trip_starttime=$("#trip_starttime").val();
                if(trip_starttime==''){
                    alert("请选择行程开始时间！");
                    return false;
                }
                var trip_days=$("#trip_days").val();
                if(trip_days==''||Number(trip_days)<=0){
                    alert("请填写正确行程天数！");
                    return false;
                }
                p['id']="{$data.id}";
                p['title']=trip_title;
                p['starttime']=trip_starttime;
                p['days']=trip_days;
                $.post("{:U('Home/Trip/ajax_editcachetrip')}",p,function(data){
                    if(data.code=200){
                        $(".Mask3").hide();
                        $(".travels2_a").hide();
                        window.location.href="{:U('Home/Member/login')}";
                    }else{
                        alert("提交失败");
                    }
                })
                
            })
            $(".setpublic").click(function(){
                var p={};
                p['tid']="{$data.id}";
                if($(this).hasClass("Edit_stroke_radio2")){
                    p['ispublic']=0;
                }else{
                    p['ispublic']=1;
                }
                $(this).toggleClass("Edit_stroke_radio2");
                $.post("{:U('Home/Trip/ajax_setpublic')}",p,function(data){
                    if(data.code==200){
                        
                    }else{
                        alert(data.msg);
                    }
                })
            })
        })
</script>
<include file="public:foot" />