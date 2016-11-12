<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<style>
    .chosen-container {
        margin-right: 12px;
    }
</style>
<script>
    $(function () {
        var min = 0;
        var max = 5000;
        var minmoney = "{$_GET['minmoney']}";
        var maxmoney = "{$_GET['maxmoney']}";
        if (minmoney != "") {
            min = minmoney;
        }
        if (maxmoney != "") {
            max = maxmoney;
        }
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 5000,
            step: 100,
            values: [min, max],
            slide: function (event, ui) {
                $("#amount").val("￥" + ui.values[0] + " - ￥" + ui.values[1]);
            },
            change: function (event, ui) {
                var minmoney = ui.values[0];
                var maxmoney = ui.values[1];
                var url = "{:U('Home/Party/index',array('type'=>$_GET['type'],'catid'=>$_GET['catid'],'keyword'=>$_GET['keyword'],'partytype'=>$_GET['partytype'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}?minmoney=" + minmoney + "&maxmoney=" + maxmoney;
                window.location.href = url;
            }
        });
        $("#amount").val("￥" + $("#slider-range").slider("values", 0) + " - ￥" + $("#slider-range").slider("values", 1));


    });
</script>
<include file="public:mheader" />
<div class="wrap">
    <div class="activity_main">
        <a href="/">首页</a>
        <span>></span>
        <a href="{:U('Home/Party/index')}">活动</a>
    </div>


    <div id="slideBox" class="activity_Box pr">
        <a class="prev" href="javascript:void(0)"></a>
        <a class="next" href="javascript:void(0)"></a>
        <div class="bd">
            <ul>
                <volist name="ad" id="vo">
                    <li>
                        <a href="{$vo.url}" target="_blank">
                            <img title="{$vo.title}" alt="{$vo.title}" src="{$vo.image}" width="1241px" height="346px" />
                        </a>
                    </li>
                </volist>
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        jQuery("#slideBox").slide({
            mainCell: ".bd ul",
            autoPlay: true
        });
    </script>
</div>

<div class="wrap">
    <div class="activity_main2 hidden">
        <div class="fl activity_main2_01">
            <form action="{:U('Home/Party/index')}" method="get">
                <div class="activity_top1">
                    <input type="text" name="keyword" value="{$_GET['keyword']}" class="activity_text1" placeholder="输入活动或关键词进行搜索..." />
                    <input class="activity_sub" type="submit" value="搜索" />
                </div>
            </form>
            <div class="activity_top2 hidden">
                <span onclick="window.location.href='{:U('Home/Party/index',array('type'=>1))}'" <eq name="_GET['type']" value="1"> class="activity_span"</eq>>热门活动</span>
                <span onclick="window.location.href='{:U('Home/Party/index',array('type'=>2))}'" <notempty name="_GET['type']"><eq name="_GET['type']" value="2"> class="activity_span"</eq><else />class="activity_span"</notempty>>最新发布</span>
                <a href="{:U('Home/Party/add')}">
                    <img src="__IMG__/Icon/img19.png" />
                    发布活动
                </a>
            </div>
            <script type="text/javascript">
                var areaurl = "{:U('Home/Party/getchildren')}";
                $(function(){
                    var province="{$_GET['province']}";
                    var city="{$_GET['city']}";
                    if(province!=''){
                      load(province,'city',1);
                    }
                    if(city!=''){
                      load(city,'town',1);
                    }
                })
                function load(parentid, type ,isinit) {
                    $.ajax({
                        type: "GET",
                        url: areaurl,
                        data: { 'parentid': parentid },
                        dataType: "json",
                        success: function (data) {
                            if (type == 'city') {
                                $('#city').html('<option value="">选择市</option>');
                                $('#town').html('<option value="">选择区</option>');
                                if(data!=null){
                                    $.each(data, function (no, items) {
                                        if (items.id == "{$_GET['city']}") {
                                            $('#city').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                                        } else {
                                            $('#city').append('<option value="' + items.id + '">' + items.name + '</option>');
                                        }
                                    });
                                }
                                $('#city').trigger("chosen:updated");
                                $('#town').trigger("chosen:updated");
                            } else if (type == 'town') {
                                $('#town').html('<option value="">选择区</option>');
                                if(data!=null){
                                    $.each(data, function (no, items) {
                                        if (items.id == "{$_GET['town']}") {
                                            $('#town').append('<option value="' + items.id + '"selected>' + items.name + '</option>');
                                        } else {
                                            $('#town').append('<option value="' + items.id + '">' + items.name + '</option>');
                                        }
                                    });
                                }
                                
                                $('#town').trigger("chosen:updated");
                            }
                            var province=$("#province option:selected").val();
                            var city=$("#city option:selected").val();
                            var town=$("#town option:selected").val();
                            console.log(city)
                            if(isinit==0){
                                var url = "{:U('Home/Party/index',array('type'=>$_GET['type'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'partytype'=>$_GET['partytype']))}?province=" + province + "&city=" + city + "&town=" + town;
                                window.location.href = url;
                            }
                            
                            
                        }
                    });
                }
            </script>
            <div class="activity_top3">
                   <div class="activity_top3_01">
                       <span>按位置 :</span>
                       <div class="activity_top3_02" style="width:400px;">
                           <select class="activity_top3_02 chosen-select-no-single" name="province" id="province"   onchange="load(this.value,'city',0)">
                               <option value="">选择省</option>
                                <volist name="province" id="vo"> 
                                    <option value="{$vo.id}" <if condition="$vo['id'] eq $_GET['province']">selected</if>>{$vo.name}</option>
                                </volist>
                           </select>
                           <select class="activity_top3_02 chosen-select-no-single" name="city" id="city"  onchange="load(this.value,'town',0)">
                               <option value="">选择市</option>
                           </select>

                           <select class="activity_top3_02 chosen-select-no-single" name="town" id="town"  onchange="load(this.value,'distinct',0)">
                               <option value="">选择区</option>
                           </select>
                       </div>
                   </div>
                <div class="travels_main4_1 hidden">
                   <span class="f14 c333 middle fl">按特色 :</span>
                    <ul class="hidden">
                        <li <empty name="_GET['catid']"> class="travels_chang"</empty> onclick="window.location.href='{:U('Home/Party/index',array('type'=>$_GET['type'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'partytype'=>$_GET['partytype'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}'">不限</li>
                        <volist name="partycate" id="vo">
                           <li <if condition="$_GET['catid'] eq $vo['id']"> class="travels_chang"</if> onclick="window.location.href='{:U('Home/Party/index',array('type'=>$_GET['type'],'catid'=>$vo['id'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'keyword'=>$_GET['keyword'],'partytype'=>$_GET['partytype']))}'">{$vo.catname}</li>
                        </volist>
                   </ul>
               </div>
                <div class="activity_top3_04">
                       <span>按费用 :</span>
                       <div id="slider-range" class="middle"></div>
                       <input type="text" id="amount" class="middle f12" style="border:0; color:#000; font-weight:bold;">
                   </div>
                <div class="travels_main4_1 hidden">
                    <span class="f14 c333 middle fl">按类型 :</span>
                    <ul class="hidden">
                        <li <empty name="_GET['partytype']"> class="travels_chang"</empty> onclick="window.location.href='{:U('Home/Party/index',array('type'=>$_GET['type'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town']))}'">不限</li>
                        <li <eq name="_GET['partytype']" value="1"> class="travels_chang"</eq> onclick="window.location.href='{:U('Home/Party/index',array('type'=>$_GET['type'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'partytype'=>1))}'">亲子类</li>
                        <li <eq name="_GET['partytype']" value="2"> class="travels_chang"</eq> onclick="window.location.href='{:U('Home/Party/index',array('type'=>$_GET['type'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'partytype'=>2))}'">情侣类</li>
                        <li <eq name="_GET['partytype']" value="3"> class="travels_chang"</eq> onclick="window.location.href='{:U('Home/Party/index',array('type'=>$_GET['type'],'catid'=>$_GET['catid'],'minmoney'=>$_GET['minmoney'],'maxmoney'=>$_GET['maxmoney'],'keyword'=>$_GET['keyword'],'province'=>$_GET['province'],'city'=>$_GET['city'],'town'=>$_GET['town'],'partytype'=>3))}'">家庭出游</li>
                    </ul>
                </div>
            </div>

            <div class="activity_top4">
                <div class="activity_chang">
                    <ul class="activity_chang2_ul">
                        <volist name="party" id="vo">
                            <li>
                                <div class="hidden activity_chang2_list">
                                    <div class="fl activity_chang2_list2 pr">
                                        <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">
                                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" />
                                        </a>
                                        <eq name="vo['type']" value="1">
                                            <div class="pa main4_bottom_list_x">
                                                <img src="__IMG__/Icon/jing.png" style="width: 53px;height: 53px;"/>
                                            </div>
                                        </eq>
                                    </div>
                                    <div class="fl activity_chang2_list3">
                                        <div class="activity_chang2_list3_top">
                                            <a href="{:U('Home/Party/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],25)}</a>
                                        </div>
                                        <div class="activity_chang2_list3_center">
                                            <p>时间 :<em>{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em></p>
                                            <p>地点 :<em>{:getarea($vo['area'])}{$vo.address} </em></p>
                                        </div>
                                        <div class="hmain5_r5_list2_2 hidden">
                                            <div class="fl">
                                                <span class="middle">已参与 :</span>
                                                <volist name="vo['joinlist']" id="v">
                                                    <a href="{:U('Home/Member/detail',array('uid'=>$v['id']))}" class="middle">
                                                        <img src="{$v.head}" width="30px" height="30px" style="border-radius: 50%;" />
                                                    </a>
                                                </volist>
                                                <span>( {$vo.joinnum|default="0"}人 )</span>
                                            </div>
                                            <div class="fr hidden hmain5_r5_list2_3">
                                                <div class="fl hmain5_r5_list2_3_01">
                                                    <img style="margin-right: 3px;" src="__IMG__/Icon/img10.png" /><i>{$vo.reviewnum|default="0"}</i><label>条点评</label>
                                                </div>
                                                <div class="fl hmain5_r5_list2_3_03">
                                                    <eq name="vo['ishit']" value="1">
                                                        <img src="__IMG__/dianzan.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1" data-id="{$vo.id}"/>
                                                        <else />
                                                        <img src="__IMG__/Icon/img9.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1" data-id="{$vo.id}"/>
                                                    </eq>
                                                    <label  class="zannum">{$vo.hit|default="0"}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </volist>
                    </ul>
                    <div class="activity_chang4">
                        {$Page}
                    </div>
                    <div class="" style="width: 2px; height: 80px;"></div>
                </div>
            </div>
        </div>
        <div class="fr activity_main2_02">
            <div class="activity_main2_02-1">
                <div class="activity_main2_02-1_top">
                    <span>热门游记</span>
                </div>
                <ul class="activity_main2_02-1_ul">
                    <volist name="hotnote" id="vo">
                        <li>
                            <div class="activity_main2_02-1_list">
                                <div class="travels_main_x pr">
                                   <img src="{$vo.thumb}" style="width:339px;height:213px" onclick="window.location.href='{:U('Home/Note/show',array('id'=>$vo['id']))}'" />
                                   <div class="travels_main2_img">
                                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            <img src="{$vo.head}"  width="55px" height="55px" />
                                        </a>
                                    </div>
                                </div>
                                <span>{:str_cut($vo['title'],12)}</span>
                                <i>{$vo.inputtime|date="Y-m-d",###}</i>
                                <p>{:str_cut($vo['description'],40)}</p>
                            </div>
                        </li>
                    </volist>
                </ul>
            </div>
            <a href="{:U('Home/Note/index',array('type'=>1))}">点击查看更多游记...</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".chosen-select-no-single").chosen();
        $(".zanbg1").live("click",function(){
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
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Party/ajax_hit')}",
                 data: {'aid':aid},
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
    });
</script>
<include file="public:foot" />
