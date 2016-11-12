<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script>
    $(function () {

    });
</script>
<include file="public:mheader" />
<div class="wrap">
    <div class="activity_main">
        <a href="/">首页</a>
        <span>></span>
        <a href="{:U('Home/Note/index')}">游记</a>
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
            <form action="{:U('Home/Note/index')}" method="get">
                <div class="activity_top1">
                    <input type="text" name="keyword" value="{$_GET['keyword']}" class="activity_text1" placeholder="输入游记或关键词进行搜索..." />
                    <input class="activity_sub" type="submit" value="搜索" />
                </div>
            </form>
            <div class="activity_top2 hidden">
                <span onclick="window.location.href='{:U('Home/Note/index',array('type'=>1))}'" <eq name="_GET['type']" value="1"> class="activity_span"</eq>>热门游记</span>
                <span onclick="window.location.href='{:U('Home/Note/index',array('type'=>2))}'" <notempty name="_GET['type']"><eq name="_GET['type']" value="2"> class="activity_span"</eq><else />class="activity_span"</notempty>>最新发布</span>
                <a href="{:U('Home/Note/add')}">
                    <img src="__IMG__/Icon/pen.png" />
                    发布游记
                </a>
            </div>
            <div class="travels_main4">
                   <div class="travels_main4_1 hidden">
                       <span class="f14 c333 middle fl">按时间 :</span>
                       <ul class="hidden">
                           <li <empty name="_GET['month']"> class="travels_chang"</empty> onclick="window.location.href='{:U('Home/Note/index',array('type'=>$_GET['type'],'city'=>$_GET['city'],'keyword'=>$_GET['keyword']))}'">不限</li>
                           <?php
                                for ($i=1; $i <= 12; $i++) { 
                                    # code...
                                    if($_GET['month']!=$i){
                                        echo "<li onclick=\"window.location.href='".U('Home/Note/index',array('type'=>$_GET['type'],'month'=>$i,'keyword'=>$_GET['keyword']))."'\">".$i."月</li>";
                                    }else{
                                        echo "<li class=\"travels_chang\" onclick=\"window.location.href='".U('Home/Note/index',array('type'=>$_GET['type'],'month'=>$i,'keyword'=>$_GET['keyword']))."'\">".$i."月</li>";
                                    }
                                     
                                }
                           ?>
                       </ul>
                   </div>
                   <div class="travels_main4_1 hidden">
                       <span class=" fl f14 c333">热门城市 :</span>
                       <div class="fl hidden travels_main4_2">
                           <ul class="fl" id="menu_city">
                               <li <empty name="_GET['city']"> class="travels_chang"</empty> onclick="window.location.href='{:U('Home/Note/index',array('type'=>$_GET['type'],'month'=>$_GET['month'],'keyword'=>$_GET['keyword']))}'">全国</li>
                               <volist name="hotcity" id="vo" offset="0" length="11">
                                   <li onclick="window.location.href='{:U('Home/Note/index',array('type'=>$_GET['type'],'month'=>$_GET['month'],'keyword'=>$_GET['keyword'],'city'=>$vo['id']))}'" <if condition="$_GET['city'] eq $vo['id']"> class="travels_chang"</if>>{$vo.name}</li>
                               </volist>
                           </ul>
                           <label class="fr f12 c333 travels_main4_1_label ishidden">更多</label>
                           <ul class="travels_main4_2_ul2 hide">
                               <volist name="hotcity" id="vo" offset="11">
                                   <li onclick="window.location.href='{:U('Home/Note/index',array('type'=>$_GET['type'],'month'=>$_GET['month'],'keyword'=>$_GET['keyword'],'city'=>$vo['id']))}'" <if condition="$_GET['city'] eq $vo['id']"> class="travels_chang"</if>>{$vo.name}</li>
                               </volist>
                           </ul>
                       </div>
                   </div>
               </div>
            <div>
                <div class="main5_top2">
                    <ul class="main5_top2_ul">
                        <volist name="note" id="vo">
                            <li>
                                <div class="hidden main5_top2_list">
                                    <div class="fl main5_top2_01 pr">
                                        <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">
                                            <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" />
                                        </a>
                                        <eq name="vo['type']" value="1">
                                            <div class="pa main4_bottom_list_x">
                                                <img src="__IMG__/Icon/jing.png" style="width: 53px;height: 53px;"/>
                                            </div>
                                        </eq>
                                    </div>
                                    <div class="fl main5_top2_02">
                                        <div class="main5_list1">
                                            <a href="{:U('Home/Note/show',array('id'=>$vo['id']))}">{:str_cut($vo['title'],25)}</a>
                                        </div>
                                        <div class="main5_list2">
                                            <span>{$vo.inputtime|date="Y-m-d",###}</span>
                                            <p>{:str_cut($vo['description'],200)}</p>
                                        </div>
                                        <div class="main5_list3 hidden">
                                            <div class="fl main5_list3_01">
                                                <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                                    <i>by</i>
                                                    <img src="{$vo.head}" width="16px" height="16px" style="border-radius: 50%;" />
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
                    <div class="travels_main3"></div>
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
                    <span>热门活动</span>
                </div>
                <ul class="activity_main2_02-1_ul">
                    <volist name="hotparty" id="vo">
                        <li>
                            <div class="travels_main pr">
                                <div class="travels_main_x pr">
                                    <img src="{$vo.thumb}" style="width:339px;height:213px" onclick="window.location.href='{:U('Home/Party/show',array('id'=>$vo['id']))}'" />
                                     <div class="travels_main2_img" >
                                        <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            <img src="{$vo.head}"  width="55px" height="55px" />
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="travels_main2">
                                    <p>{$vo.title}</p>
                                    <div>
                                        <i>时间 :</i><span class="c666 f12">{$vo.starttime|date="Y-m-d",###} - {$vo.endtime|date="Y-m-d",###}</span>
                                    </div>
                                    <div>
                                        <i>地点 :</i><span class="c666 f14">{$vo.address} </span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </volist>
                </ul>
            </div>
            <a href="{:U('Home/Party/index')}">点击查看更多活动...</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".chosen-select-no-single").chosen();
        $(".travels_main4_1 i").click(function () {
            $(this).addClass("travels_chang").siblings().removeClass("travels_chang");
        })
        $(".travels_main4_1_label").click(function () {
                var $labale = $(this).html();
                if ($labale == "更多") {
                    $(this).html("收起");
                    $(".travels_main4_2_ul2").show();
                } else {
                    $(this).html("更多");
                    $(".travels_main4_2_ul2").hide();
                }
            })
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
            var nid=$(this).data("id");
            $.ajax({
                 type: "POST",
                 url: "{:U('Home/Note/ajax_hit')}",
                 data: {'nid':nid},
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
