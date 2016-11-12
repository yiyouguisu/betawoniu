<include file="public:head" />
<body class="back-f1f1f1">
    <div class="header center z-index112 pr f18">
        <div class="head_go pa" onclick="history.go(-1)">
            <img src="__IMG__/go.jpg"></div>
        <div class="tra_pr hd_ck pa">
            <em>
                <if condition='$data["iscollect"] eq 1'>
                   <img src="__IMG__/hj_a1_1.jpg" class='collect' data-id="{$data.id}">
                <else/>
                   <img src="__IMG__/hj_a1.jpg" class='collect' data-id="{$data.id}">
                </if>
            </em>
            <em>
                <img src="__IMG__/hj_a2.jpg"></em>
            <em>
                <img src="__IMG__/hj_a3.jpg"></em>
        </div>
    </div>
    <div class="container padding_0">
        <div class="land">
            <div class="lpl_top">
                <div class="lpl_title">
                    <div class="lpl_a">{$data.title}</div>
                    <div class="lpl_b f0">
                        <div class="lpl_b1 vertical">
                            <img src="{$data.head}">{$data.nickname}</div>
                        <div class="lpl_b2 vertical"><em>发表于：</em>{$data.inputtime|date='Y-m-d',###}
                           <span class='certical notehit' data-id="{$data.id}">
                               <if condition="$data['ishit'] eq 1">
                                  <img src="__IMG__/poin_1.png"> 
                                <else/>
                                  <img src="__IMG__/poin.png"> 
                                </if>
                               <span id='vcount' style="margin-left: 0;">{$data.hit|default="0"}</span>
                           </span>
                        </div>
                    </div>
                </div>

                <div class="lpl_c">
                    <div class="lpl_c1">
                        <span>
                            <img src="__IMG__/gh_a2.jpg">出发时间： </span>
                        <em>{$data.begintime|date='Y-m-d',###}</em></div>
                    <div class="lpl_c1">
                        <span>
                            <img src="__IMG__/gh_a1.jpg">人均费用： </span>
                        <em>￥{$data.fee}</em></div>
                    <div class="lpl_c1">
                        <span>
                            <img src="__IMG__/gh_a3.jpg">人物： </span>
                        <em>{$data.noteman}</em></div>
                    <div class="lpl_c1">
                        <span>
                            <img src="__IMG__/gh_a4.jpg">出行天数： </span>
                        <em>{$data.days|default="0"}天</em></div>
                    <div class="lpl_c1">
                        <span>
                            <img src="__IMG__/gh_a5.jpg">形式： </span>
                        <em>{$data.notestyle}</em></div>
                    <div class="clearfix"></div>
                </div>

                <div class="lpl_d">
                    <volist name="data['content']" id="vo">
                        <div class="lpl_d2">{$vo.content}</div>
                        <notempty name="vo['thumb']">
                            <div class="lpl_d2"><img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" /></div>
                        </notempty>
                    </volist>
                </div>

                <div class="lpl_e">
                    <div class="lpl_f">
                        <div class="lpl_e1">文中出现过的民宿 :</div>
                        <div class="lpl_e2">
                            <volist name="data['note_hostel']" id="vo">
                                <span data-hid="{$vo.hid}" data-uid="{$vo.uid}">{$vo.title}</span>
                            </volist>
                        </div>
                    </div>
                    <div class="lpl_f">
                        <div class="lpl_e1">文中出现过的景点 :</div>
                        <div class="lpl_e2">
                            <span>西湖</span>
                            <span>太湖</span>
                            <span>杭州灵隐寺</span>
                            <volist name="data['note_place']" id="vo">
                              <span data-hid="{$vo.hid}" data-uid="{$vo.uid}">
                                {$vo.title}
                              </span>
                          </volist>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lpl_conments">
                <div class="trip_f">
                    <div class="trip_f1">评论区
                      <div class="trip_f2">
                          <img src="__IMG__/land_d3.png">
                          <span>{$data.reviewnum|default="0"}</span>条评论
                      </div>
                    </div>
                    <div class="trip_fBtm">
                        <volist name='comment' id='vp'>
                          <div class="fans_list">
                              <div class="per_tx fl"><img src="{$vp.head}"></div>
                              <div class="fans_b per_tr fl">
                                  <div class="fans_b1 f16">{$vp.nickname}</div> 
                                  <div class="fans_b2 f14">{$vp.content}</div> 
                                  <div class="fans_time f13">{$vp.inputtime|date='Y-m-d',###}</div>
                              </div>
                          </div>
                        </volist>
                    </div>
                    <div class="trip_t">
                        <input type="text" placeholder="发布我的评论 ..." class="trip_text fl">
                        <input type="button" value="90+ 评论" class="trip_button fr"
                            onclick="location.href='{:U('Web/Review/index',array('type'=>0,'id'=>$id))}'">
                    </div>
                </div>
            </div>

            <div class="mth pr">
                <div class="mth_top pa">附近民宿推荐</div>
                <div id="dom-effect" class="iSlider-effect"></div>
                <div class="mth_a center">
                    <span>
                        <a href="{:U('Web/Hostel/index')}">查看更多</a></span>
                    <div class="mth_a2"></div>
                </div>
            </div>

            <div class="mth pr" style="margin-top: 20px;">
                <div class="mth_top pa">附近活动推荐</div>
                <div id="mth_dom" class="iSlider-effect"></div>
                <div class="mth_a center">
                    <span>
                        <a href="{:U('Web/Party/index')}">查看更多</a></span>
                    <div class="mth_a2"></div>
                </div>
            </div>

            <div class="mth_c">
                <div class="lpl_f">
                    <div class="lpl_e1">已选 :</div>
                    <div class="lpl_e2">
                        <!-- <span>君悦</span>
                        <span>儒家</span>
                        <span>西湖森林客栈</span> -->
                    </div>
                </div>
            </div>
            <div class="snail_d center trip_btn f16" style="margin: 0rem">
                <a href="person-3.html" class="snail_cut">添加到行程</a>
            </div>
        </div>
    </div>
    <script src="__JS__/islider.js"></script>
    <script src="__JS__/islider_desktop.js"></script>

    <script>
        
        var note_near_hostel={$data.note_near_hostel};
        var domList = [];
        $.each(note_near_hostel,function(i,value){
          domList[i]={
            'height' : '100%',
            'width' : '100%',
            'content' :'<div class="recom_list pr"><div class="recom_a recomhostel pr"><img src="'+value.thumb+'"><div class="recom_g f18 center pa"><div class="recom_g1 fl"><em>￥</em>'+value.money+'<span>起</span></div><div class="recom_g2 fl">'+value.evaluation+'<span>分</span></div></div></div><div class="recom_e"><div class="land_f1 recom_e1 f16">'+value.address+'</div><div class="recom_f"><div class="recom_f1 recom_hong f12 fl"><img src="__IMG__/add_e.png">距你  '+value.distance+'km</div><div class="recom_f2 fr"><div class="land_h recom_f3 vertical"><div class="land_h2 vertical"><img src="__IMG__/poin.png"> <span>'+value.hit+'</span></div><div class="land_h1 vertical"><img src="__IMG__/land_d3.png"><span>'+value.reviewnum+'</span>条评论</div></div></div></div></div></div>'
          };
        });
        var islider4 = new iSlider({
            data: domList,
            dom: document.getElementById("dom-effect"),
            type: 'dom',
            animateType: 'depth',
            isAutoplay: false,
            isLooping: true,
        });
        islider4.bindMouse();
    
        var note_near_activity={$data.note_near_activity};
        var mthList = [];
        $.each(note_near_activity,function(i,value){
            var html='';
            html+='<div class="recom_list"><div class="recom_a recomparty pr"><img src="'+value.thumb+'"></div><div class="recom_e">';
            html+='<div class="land_f1 recom_e1 f16">'+value.title+'</div>';
            html+='<div class="recom_k">';
            html+='<div class="land_font"><span>时间:</span> '+value.starttime+' 至'+value.endtime+'</div>';
            html+=' <div class="land_font"><span>地点:</span> '+value.address+' </div>';
            html+='</div></div></div>';
            mthList[i]={
              'height' : '100%',
              'width' : '100%',
              'content' :html
            };
        });
        var islider4 = new iSlider({
              data: mthList,
              dom: document.getElementById("mth_dom"),
              type: 'dom',
              animateType: 'depth',
              isAutoplay: false,
              isLooping: true,
        });
        islider4.bindMouse();
  
    </script>
    <script type="text/javascript">
        $(function () {
            $(".notehit").live("click",function(){
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
                var hitnum=$(this).find("#vcount");
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
                                obj.find("img").attr("src","__IMG__/poin_1.png");
                            }else if(data.type==2){
                                var num=Number(hitnum.text()) - 1;
                                hitnum.text(num);
                                obj.find("img").attr("src","__IMG__/poin.png");
                            }
                        }else if(data.status==0){
                            alert("点赞失败！");
                        }
                    }
                });
            });
            $(".collect").live("click",function(){
                var obj=$(this);
                var uid='{$user.id}';
                if(!uid){
                    alert("请先登录！");
                    var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Web/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Web/Member/login')}";
                        }
                    })
                    return false;
                }
                var nid=$(this).data("id");
                $.ajax({
                    type: "POST",
                    url: "{:U('Web/Note/ajax_collect')}",
                    data: {'nid':nid},
                    dataType: "json",
                    success: function(data){
                        if(data.status==1){
                            if(data.type==1){
                                obj.attr("src","__IMG__/hj_a1_1.jpg");
                            }else if(data.type==2){
                                obj.attr("src","__IMG__/hj_a1.jpg");
                            }
                        }else if(data.status==0){
                            alert("收藏失败！");
                        }
                    }
                });
            });
       
        });
    </script>
</body>
</html>
