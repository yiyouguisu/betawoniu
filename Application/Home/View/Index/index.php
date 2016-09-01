<include file="public:head" />
<script>
    $(function(){
        var dateInput = $("input.J_date")
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker({});
            });
        }
    })
</script>
<div class="main">
    <include file="public:header" />
    <div class="wrap main_center">
        <a href="javascript:;"  class="travels2_bottom3">
            <img src="__IMG__/Icon/img2.png" />
        </a>
    </div>
    <div class="main_bottom">
        <div class="wrap">
            <div class="main_bottom1">
                    <div class="main_bottom1_t">
                        <span class="main_bottom1_tbg">美宿搜索</span>
                        <span>游记搜索</span>
                        <span>活动搜索</span>
                    </div>
                    <div>
                        <div class="main_bottom1_tbg2">
                            <form action="{:U('Home/Hostel/index')}" method="get">
                                <div class="main_bottom2">
                                    <div class="text1 middle">
                                        <input type="text" placeholder="目的地 :" />
                                    </div>
                                    <div class="text2 middle">
                                        <input type="text" class="J_date" name="starttime" placeholder="入住时间 :" />
                                    </div>
                                    <div class="text2 middle">
                                        <input type="text" class="J_date" name="endtime" placeholder="退房时间 :" />
                                    </div>
                                    <div class="text3 middle">
                                        <input type="text" name="keyword" placeholder="请输入美宿名称等关键词搜索..." />
                                    </div>
                                    <span class="middle">搜索</span>
                                </div>
                            </form>
                        </div>
                        <div class="main_bottom1_tbg2 hide">
                            <form action="{:U('Home/Note/index')}" method="get">
                                <div class="main_bottom2">
                                    <div class="text2 middle">
                                        <input type="text" class="J_date" name="begintime" placeholder="出发时间 :" />
                                    </div>
                                    <div class="text2 middle">
                                        <input type="text" class="J_date" name="endtime" placeholder="结束时间 :" />
                                    </div>
                                    <div class="text3 middle">
                                        <input type="text" name="keyword" placeholder="请输入游记名称等关键词搜索..." />
                                    </div>
                                    <input type="submit" class="middle" value="搜索" style="border:none;cousor:pointer">
                                    <!-- <span class="middle">搜索</span> -->
                                </div>
                            </form>
                        </div>
                        <div class="main_bottom1_tbg2 hide">
                            <form action="{:U('Home/Party/index')}" method="get">
                                <div class="main_bottom2">
                                    <div class="text2 middle">
                                        <input type="text" class="J_date" name="starttime" placeholder="出发时间 :" />
                                    </div>
                                    <div class="text2 middle">
                                        <input type="text" class="J_date" name="endtime" placeholder="结束时间 :" />
                                    </div>
                                    <div class="text3 middle">
                                        <input type="text" name="keyword" placeholder="请输入活动名称等关键词搜索..." />
                                    </div>
                                    <input type="submit" class="middle" value="搜索" style="border:none;cousor:pointer">
                                    <!-- <span class="middle">搜索</span> -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="main_bottom3 hidden">
                        <span class="fl">热门目的地：</span>
                        <volist name="hotdestination" id="vo">
                            <a href="{:U('Home/Hostel/index',array('city'=>$vo['city']))}">{$vo.cityname}</a>
                        </volist>
                    </div>
                </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        var $ml = $(".main_bottom1_t span");
        $ml.click(function () {
            $(this).addClass("main_bottom1_tbg").siblings().removeClass("main_bottom1_tbg");
            $(".main_bottom1_tbg2").hide();
            var cs = $(".main_bottom1_tbg2")[getObjectIndex(this, $ml)];
            $(cs).show();
        });
    });
    function getObjectIndex(a, b) {
        for (var i in b) {
            if (b[i] == a) {
                return i;
            }
        }
        return -1;
    }
</script>
<div class="wrap">
    <div class="main2">
        <div class="main2_top">
            <span>热门美宿城市</span>
            <label>和你在另一个地方遇见美好</label>
        </div>
        <div class="main2_bottom">
            <div class="picScroll-left">
                <div class="bd">
                    <ul class="picList">
                        <volist name="hotcity" id="vo">
                            <li>
                                <div class="pic">
                                    <a href="{:U('Home/Hostel/index',array('city'=>$vo['id']))}" target="_blank" style="position:relative;display: block;">
                                        <img alt="{$vo.name}" title="{$vo.name}" class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" />
                                        <div class="abc" style=" position: absolute;left: 0px;top: 0px;width: 288px;height: 100%;background: rgba(0,0,0,0.50);z-index: 999;color: #fff;">
                                            <span style="font-size: 37px;margin-top: 64px;display: block;">{$vo.name}</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </volist>
                    </ul>
                </div>
                <div class="hd">
                    <ul></ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(".picScroll-left").slide({
        titCell: ".hd ul",
        mainCell: ".bd ul",
        autoPage: true,
        effect: "leftLoop",
        vis: 4,
        trigger: "click"
    });
</script>

<div class="wrap">
    <div class="main4">
        <div class="main4_top">
            <span>热门美宿推荐</span>
        </div>
        <div class="main4_bottom">
            <ul class="main4_bottom_ul">
                <volist name="hothostel" id="vo">
                    <li>
                        <div class="main4_bottom_list pr">
                            <a href="javascript:;">
                                <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width:399px;height:250px"  onclick="window.location.href='{:U('Home/Hostel/show',array('id'=>$vo['id']))}'"/>
                                <div class="pa main4_bottom_list1"></div>
                            </a>
                            <!-- <div class="main4_bottom_list2 pa">
                                <img src="__IMG__/Icon/img8.png" />
                            </div> -->
                            <div data-id="{$vo.id}" <eq name="vo['iscollect']" value="1">class="Event_details8_list_01 shoucang_hostel collect"<else /> class="Event_details8_list_01 shoucang_hostel"</eq>></div>
                            <div class="main4_bottom_list3 pa">
                                <i>￥</i><span>{$vo.money|default="0.00"}</span><label>起</label>
                            </div>
                            <div class="main4_bottom_list4 pa">
                                <span>{$vo.evaluation|default="0"}</span><i>分</i>
                            </div>
                            <div class="main4_bottom_list5 pa">
                                <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                    <img src="{$vo.head}">
                                </a>
                            </div>
                            
                        </div>
                        <div class="main_bottom_text">
                            <div class="main_bottom_textl">
                                <span onclck="window.location.href='{:U('Home/Hostel/show',array('id'=>$vo['id']))}'">{:str_cut($vo['title'],15)}</span>
                                <div class="fr main_bottom_textl1">
                                    <eq name="vo['ishit']" value="1">
                                        <img src="__IMG__/dianzan.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="{$vo.id}"/>
                                        <else />
                                        <img src="__IMG__/Icon/img9.png" style="margin-left: 20px; margin-right: 3px;"  class="zanbg1_hostel" data-id="{$vo.id}"/>
                                    </eq>
                                    <i class="zannum">{$vo.hit|default="0"}</i>
                                </div>
                            </div>
                            <div class="main_bottom_text2">
                                <img src="__IMG__/Icon/img10.png" />
                                <i>{$vo.reviewnum|default="0"}</i>
                                <span>条点评</span>
                            </div>
                        </div>
                    </li>
                </volist>
            </ul>
        </div>
        <a href="{:U('Home/Hostel/index')}">点击查看更多...</a>
    </div>
</div>

<div class="wrap">
    <div class="main5 hidden">
        <div class="fl main5_top">
            <div class="main5_top1 hidden">
                <span class="fl add_color">热门游记</span>
                <span class="fl">最新发布</span>
                <a href="{:U('Home/Note/add')}">
                    <img src="__IMG__/Icon/img11.png" />发布游记
                </a>
            </div>
            <div>
                <div class="main5_top2">
                    <ul class="main5_top2_ul">
                        <volist name="hotnote" id="vo">
                            <li>
                                <div class="hidden main5_top2_list">
                                    <div class="fl main5_top2_01">
                                        <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">
                                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" />
                                        </a>
                                    </div>
                                    <div class="fl main5_top2_02">
                                        <div class="main5_list1">
                                            <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">{$vo.title}</a>
                                        </div>
                                        <div class="main5_list2">
                                            <span>{$vo.inputtime|date="Y-m-d",###}</span>
                                            <p>{:str_cut($vo['description'],200)}</p>
                                        </div>
                                        <div class="main5_list3 hidden">
                                            <div class="fl main5_list3_01">
                                                <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                                    <i>by</i>
                                                    <img src="{$vo.head}" width="16px" height="16px" style=" border-radius: 50%;"/>
                                                    <span>{$vo.nickname}</span>
                                                </a>
                                            </div>
                                            <div class="fr main5_list3_02">
                                                <div class="main5_list3_03">
                                                    <img src="__IMG__/Icon/img10.png" />
                                                    <span><em>{$vo.reviewnum|default="0"}</em>条点评</span>
                                                </div>
                                                <a href="javascript:;" class="main5_list3_04">
                                                    <eq name="vo['ishit']" value="1">
                                                        <img src="__IMG__/dianzan.png" class="zanbg1" data-id="{$vo.id}"/>
                                                        <else />
                                                        <img src="__IMG__/Icon/img9.png" class="zanbg1" data-id="{$vo.id}"/>
                                                    </eq>
                                                    <i class="zannum">{$vo.hit|default="0"}</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </volist>
                        
                    </ul>
                    <div class="main5_a">
                        <a href="{:U('Home/Note/index',array('type'=>1))}">点击查看更多游记...</a>
                    </div>
                </div>
                <div class="main5_top2 hide">
                    <ul class="main5_top2_ul">
                       <volist name="newnote" id="vo">
                            <li>
                                <div class="hidden main5_top2_list">
                                    <div class="fl main5_top2_01">
                                        <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">
                                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" />
                                        </a>
                                    </div>
                                    <div class="fl main5_top2_02">
                                        <div class="main5_list1">
                                            <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">{$vo.title}</a>
                                        </div>
                                        <div class="main5_list2">
                                            <span>{$vo.inputtime|date="Y-m-d",###}</span>
                                            <p>{:str_cut($vo['description'],200)}</p>
                                        </div>
                                        <div class="main5_list3 hidden">
                                            <div class="fl main5_list3_01">
                                                <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                                    <i>by</i>
                                                    <img src="{$vo.head}" width="16px" height="16px" />
                                                    <span>{$vo.nickname}</span>
                                                </a>
                                            </div>
                                            <div class="fr main5_list3_02">
                                                <div class="main5_list3_03">
                                                    <img src="__IMG__/Icon/img10.png" />
                                                    <span><em>{$vo.reviewnum|default="0"}</em>条点评</span>
                                                </div>
                                                <a href="javascript:;" class="main5_list3_04">
                                                    <eq name="vo['ishit']" value="1">
                                                        <img src="__IMG__/dianzan.png" class="zanbg1" data-id="{$vo.id}"/>
                                                        <else />
                                                        <img src="__IMG__/Icon/img9.png" class="zanbg1" data-id="{$vo.id}"/>
                                                    </eq>
                                                    <i class="zannum">{$vo.hit|default="0"}</i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </volist>
                    </ul>
                    <div class="main5_a">
                        <a href="{:U('Home/Note/index',array('type'=>2))}">点击查看更多游记...</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="fl main5_bottom">
            <div class="main5_bottom1">
                <span>热门活动</span>
            </div>
            <ul class="main5_bottom_ul">
                <volist name="hotparty" id="vo">
                    <li>
                        <div class="main5_bottom_list">
                            <div class="main5_bottom_list_img pr">
                                <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" width="339px" height="213px" onclick="window.location.href='{:U('Home/Party/show',array('id'=>$vo['id']))}'" />
                                <div class="pa main5_bottom_list_img2">
                                    <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                        <img src="{$vo.head}" />
                                    </a>
                                </div>
                            </div>
                            <div class="main5_bottom_list_text">
                                <span>{:str_cut($vo['title'],15)}</span>

                                <i>时间：<em>{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</em></i>
                                <i>时间：<em>{$vo.address} </em></i>
                            </div>
                        </div>
                    </li>
                </volist>
            </ul>
            <div class="main5_a">
                <a href="{:U('Home/Party/index')}">点击查看更多活动...</a>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".main5_bottom_ul li").last().css({
            "margin-bottom": "33px"
        })
        var $ml = $(".main5_top1 span");
        $ml.click(function () {
            $(this).addClass("add_color").siblings().removeClass("add_color");
            $(".main5_top2").hide();
            var cs = $(".main5_top2")[getObjectIndex(this, $ml)];
            $(cs).show();
        });
    })
    function getObjectIndex(a, b) {
        for (var i in b) {
            if (b[i] == a) {
                return i;
            }
        }
        return -1;
    }
</script>
<script type="text/javascript">
    $(function () {
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
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_hit')}",
                 data: {'hid':hid},
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
        $(".shoucang").live("click",function(){
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
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Party/ajax_collect')}",
                 data: {'aid':aid},
                 dataType: "json",
                 success: function(data){
                            if(data.status==1){
                              if(data.type==1){
                                obj.attr("src","/Public/Home/images/Icon/img25.png");
                              }else if(data.type==2){
                                obj.attr("src","/Public/Home/images/shoucang.png");
                              }
                            }else if(data.status==0){
                              alert("收藏失败！");
                            }
                          }
              });
          });
        $(".shoucang_party").live("click",function(){
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
            var aid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Party/ajax_collect')}",
                 data: {'aid':aid},
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
            var hid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Hostel/ajax_collect')}",
                 data: {'hid':hid},
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
            <input type="text" id="trip_title" />
        </div>
        <div class="travels2_a_bottom3 hidden">
            <div class="travels2_a_bottom4 fl">
                <span>出发时间 :</span>
                <input value="{:date('Y-m-d')}" type="text" class="J_date" id="trip_starttime" />
            </div>
            <div class="fr travels2_a_bottom5">
                <span class="middle">出发天数 :</span>
                <div class="travels2_a_bottom6 middle hidden">
                    <input type="text" value="1" id="trip_days"/>
                    <i>天</i>
                </div>
            </div>
        </div>
        <div class="travels2_a2">
            <input type="button" class="addtrip" data-varname="" value="提交" />
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
      $(".addtrip").click(function(){
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
          p['title']=trip_title;
          p['starttime']=trip_starttime;
          p['days']=trip_days;
          $.post("{:U('Home/Trip/ajax_cachetripinfo')}",p,function(data){
              if(data.code=200){
                  $(".Mask3").hide();
                  $(".travels2_a").hide();
                  window.location.href="{:U('Home/Trip/add')}";
              }else{
                  alert("提交失败");
              }
          })
          
      })
      
  })
</script>
<include file="public:foot" />
