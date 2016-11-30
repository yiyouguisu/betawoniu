<include file="public:head" />
<body class="back-f1f1f1">
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=7XTgXXqefgTIH3cwTLsbnR7P&s=1"></script>
    <div class="header center z-index112 pr f18 fix-head">
        活动详细
        <div class="head_go pa">
            <a href="{:U('party/index')}">
                <img src="__IMG__/go.jpg">
            </a><span>&nbsp;</span>
        </div>
        <div class="tra_pr hd_ck pa"><em>&nbsp;</em><em><img src="__IMG__/hj_a2.jpg"></em>
        </div>
    </div>
    <div class="container padding_0" style="margin-top:6rem">
        <div class="land">
            <div class="act_g pr">
                <div class="act_g1">
                    <img src="{$data.thumb}" style="width: 100%;height: 60vw;">
                </div>
                <div class="recom_c pa">
                    <div class="recom_gg collect <if condition='$data.iscollect eq 1'>recom_c_cut</if> "></div>
                    <span><a href-""><img src="__IMG__/recom_a3.png"></a></span>
                </div>
                <div class="act_g2 f16 center pa">
                    报名费：<em>￥</em><span>{$data.money|default="0.00"}</span>
                </div>
            </div>

            <div class="det_box">
                <div class="act_k">
                    <div class="act_k1 vertical">{$data.title}</div>
                    <div class="act_k2 vertical" id="go_zan">
                        <if condition='$data.ishit eq 1'>
                            <img src="__IMG__/poin_1.png">
                            <else/>
                            <img src="__IMG__/poin.png">
                        </if>
                        <span id='vcount'>{$data.hit}</span>
                    </div>
                </div>
                <div class="vb_a">
                    <div class="land_font">
                        <span>时间:</span> {$data.starttime|date="Y-m-d",###} 至 {$data.endtime|date="Y-m-d",###}
                    </div>
                    <div class="land_font">
                        <span>地点:</span> {:getarea($data['area'])}{$data.address}
                    </div>
                    <div class="land_font pr">
                        <span>人数:</span> 限定{$data.start_numlimit|default='0'}-{$data.end_numlimit|default='0'}人
                        <div class="vb_a1 pa">
                            <img src="__IMG__/add_e.png">距你 {$data.distance.distance.text}
                        </div>
                    </div>

                    <div id="map_container" style="height:150px;margin:10px;"></div>
                    <div class="recom_s f14">
                        已参与：
                        <span>
                                      <volist name='data["joinlist"]' id="svo">
                                        <img src="{$svo.head}" style="width:40px;height:40px;">
                                      </volist>
                                  </span>
                        <em>(..{$data.joinnum}人)</em>
                    </div>
                </div>


            </div>

            <div class="vb_c ">
                <div class="vb_c1 center">活动简介</div>
                <div class="vb_c2">{$data.content}</div>
            </div>

            <div class="vb_d center">
                <div class="vb_c1 ">活动发起人</div>
                <div class="land_a center">
                    <div class="land_a1" style="width:auto">
                        <a href="{:U('member/memberHome')}?id={$data.uid}" style="display:block">
                            <img src="{$data.head}" style="width:80px;height:80px;">
                        </a>
                    </div>
                    <div class="land_a2 home_d1 margin_05 f16">{$data.nickname}</div>
                    <div class="home_d2 margin_05">
                        <div class="home_d3 vertical mr_4">
                            <img src="__IMG__/home_a1.png">实名认证</div>
                    </div>
                </div>
                <div class="vb_d1">
                    <a href="">
                        <img src="__IMG__/vb_a.jpg">在线咨询</a>
                </div>
            </div>

            <div class="lpl_conments">
                <div class="trip_f">
                    <div class="trip_f1">评论区
                        <div class="trip_f2">
                            <a href="{:U('Party/allComment')}?id={$data.id}" class="ft12" style="color:#56c3cf">
                                <img src="__IMG__/land_d3.png">
                                <span>{$data.reviewnum}</span>条评论
                            </a>
                        </div>
                    </div>
                    <div class="trip_fBtm" id="comment_list">
                        <volist name="data['reviewlist']" id='vo'>
                            <div class="fans_list" style="padding:8px 0">
                                <div class="per_tx fl">
                                    <img src="{$vo.head}" style="width:40px;height:40px;border-radius:50%">
                                </div>
                                <div class="fans_b per_tr fl">
                                    <div class="fans_b1 f16" style="margin-top:0">{$vo.nickname}</div>
                                    <div class="fans_b2 f14">{$vo.content}</div>
                                    <div class="fans_time f13">{$vo.inputtime|date='Y-m-d',###}</div>
                                </div>
                            </div>
                        </volist>
                    </div>
                    <div class="trip_t">
                        <input type="text" id="mycomment" placeholder="发布我的评论 ..." class="trip_text fl">
                        <input type="button" value="10+评论" class="trip_button fr" id="deliver_comment">
                    </div>
                </div>
            </div>

            <div class="mth pr" id="slide-hotel">
                <div class="mth_top pa">附近美宿推荐</div>
                <div id="dom-effect" class="iSlider-effect"></div>
                <div class="mth_a center">
                    <span><a href="">查看更多</a></span>
                    <div class="mth_a2"></div>
                </div>
            </div>

            <div class="mth pr"  id="slide-activity">
                <div class="mth_top pa">附近活动推荐</div>
                <div id="mth-dom" class="iSlider-effect"></div>
                <div class="mth_a center">
                    <span><a href="">查看更多</a></span>
                    <div class="mth_a2"></div>
                </div>
            </div>
            <div style="height:2rem"></div>
            <div class="snail_d center trip_btn f16" style="margin:2rem 0 0;border-radius:0;">
                <notempty name="expire">
                    <a href="javascript:void(0);" class="" style="border-radius:0">活动已结束</a>
                    <else />
                    <notempty name="joined">
                        <a href="javascript:void(0);" class="" style="border-radius:0">您已报名</a>
                        <else />
                        <notempty name="full">
                            <a href="javascript:void(0);" class="" style="border-radius:0">报名人数已满</a>
                            <else />
                            <a href="{:U('Web/Order/joinparty',array('id'=>$id))}" style="border-radius:0" id="go_join" class="snail_cut">我要报名</a>
                        </notempty>
                    </notempty>
                </notempty>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function()
        {
            // 收藏
            $('.collect').click(function()
            {
                var id = {
                    $id
                };
                var data = {
                    'type': 1,
                    'id': id
                };
                console.log(data);
                $.post("{:U('Web/Ajaxapi/collection')}", data,
                    function(res)
                    {
                        if (res.code == 200)
                        {
                            $('.collect').addClass(
                                'recom_c_cut');
                        }
                        else if (res.code == 300)
                        {
                            $('.collect').removeClass(
                                'recom_c_cut');
                        }
                        else
                        {
                            alert(res.msg);
                        }
                    });
            });
            // 点赞 vertical
            $('#go_zan').click(function()
            {
                var id = {
                    $id
                };
                var data = {
                    'type': 1,
                    'id': id
                };
                $.post("{:U('Web/Ajaxapi/hit')}", data,
                    function(res)
                    {
                        console.log(res);
                        if (res.code == 200)
                        {
                            var hit = $('#vcount').text();
                            $('#vcount').text(Number(hit) +
                                    1) // $('.collect').addClass('recom_c_cut');
                            $('.vertical').find('img').attr(
                                'src',
                                '__IMG__/poin_1.png');
                        }
                        else if (res.code == 300)
                        {
                            var hit = $('#vcount').text();
                            $('#vcount').text(Number(hit) -
                                    1) // $('.collect').addClass('recom_c_cut');
                            $('.vertical').find('img').attr(
                                'src',
                                '__IMG__/poin.png');
                        }
                        else
                        {
                            alert(res.msg);
                        }
                    });
            })
        })
         $('#deliver_comment').click(function(evt)
        {
            evt.preventDefault();
            var comment = $('#mycomment').val();
            if (!comment || comment.length < 10)
            {
                alert('评论字数不能少于10个。');
                return;
            }
            $.ajax(
            {
                'url': '{:U("Api/Activity/review")}',
                'data': JSON.stringify(
                {
                    'uid': '{$member.id}',
                    'aid': '{$data.id}',
                    'content': comment
                }),
                'dataType': 'json',
                'type': 'post',
                'processData': false,
                'contentType': 'text/xml',
                'success': function(data)
                {
                    if (data.code == 200)
                    {
                        var timestamp = Date.parse(new Date());
                        var html =
                            '<div class="fans_list">' +
                            '<div class="per_tx fl"><img src="{$member.head}"></div>' +
                            '<div class="fans_b per_tr fl">' +
                            '<div class="fans_b1 f16">{$member.nickname}</div>' +
                            '<div class="fans_b2 f14">' +
                            comment + '</div>' +
                            '<div class="fans_time f13"></div>' +
                            '</div>' +
                            '</div>';
                        $('#comment_list').prepend(html);
                        var comments = $('#comment_list')
                            .children();
                        $('#mycomment').val('');
                        if (comments.length > 5)
                        {
                            $(comments[comments.length -
                                1]).remove();
                        }
                    }
                    else
                    {
                        alert('评论失败！');
                    }
                },
                'error': function(err, data)
                {
                    alert('网络错误！');
                }
            });

        });
    </script>
    <script>
        var map = new BMap.Map("map_container"); // 创建地图实例  
        var point = new BMap.Point({$data.lng}, {$data.lat}); // 创建点坐标  
        map.centerAndZoom(point, 15);
        var marker = new BMap.Marker(point); // 创建标注    
        map.addOverlay(marker);
    </script> 
    <script src="__JS__/islider.js"></script>
    <script src="__JS__/islider_desktop.js"></script>
    <script>
        $.ajax({
          'url': '{:U("Api/Activity/get_activity_nearhostel")}',
          'data': JSON.stringify({
            'p': 1,
            'num': 10,
            'aid': '{$data.id}'
          }),
          'dataType': 'json',
          'type': 'post',
          'processData': false,
          'contentType': 'text/xml',
          'success': function(data) {
            if(data.code == 200) {
              if(data.data.num == 0) {
                $('#slide-hotel').hide();
              } else {
                var domList = makeList(data.data); 
                var islider4 = new iSlider({
                    data: domList,
                    dom: document.getElementById("dom-effect"),
                    type: 'dom',
                    animateType: 'depth',
                    isAutoplay: false,
                    isLooping: true,
                });
                islider4.bindMouse();
              }
            } else {
            }
          },
          'error': function(err, data) {
            console.log(err); 
          }
        });
        $.ajax({
          'url': '{:U("Api/Activity/get_activity_nearactivity")}',
          'data': JSON.stringify({
            'p': 1,
            'num': 10,
            'aid': '{$data.id}'
          }),
          'dataType': 'json',
          'type': 'post',
          'processData': false,
          'contentType': 'text/xml',
          'success': function(data) {
            if(data.code == 200) {
              var domList = makeList(data.data); 
              var islider4 = new iSlider({
                  data: domList,
                  dom: document.getElementById("mth-dom"),
                  type: 'dom',
                  animateType: 'depth',
                  isAutoplay: false,
                  isLooping: true,
              });
              islider4.bindMouse();
            } else {
              $('#slide-activity').hide();
            }
          },
          'error': function(err, data) {
            console.log(err); 
          }
        });

        function makeList(data) {
          var domList = [];
          for(var i = 0; i < data.length; i++) {
            var item = data[i];
            var html='';
            html+='<div class="recom_list"><div class="recom_a pr"><img src="' + item.thumb + '" style=""></div><div class="recom_e">';
            html+='<div class="land_f1 recom_e1 f16" style="line-height:normal">' + item.title + '</div>';
            html+='<div class="recom_k">';
            html+='<div class="land_font"><span>时间:</span>' + $.myTime.UnixToDate(item.starttime) + '至' + $.myTime.UnixToDate(item.endtime) + '</div>';
            html+=' <div class="land_font"><span>地点:</span>' + item.address + '</div>';
            html+='</div></div></div>';
            var obj = {
              'height': '100%',
              'width': '100%',
              'content': html
            };
            domList.push(obj);
          }
          return domList;
        }
        $('#go_join').click(function(evt) {
          evt.preventDefault();
          var is_owner = '{$is_owner}';
          if(is_owner) {
            alert('不能报名参加自己的活动！');  
          } else {
            var href = $(this).attr('href');
            window.location.href = href;
          }
        });
    </script>
    <include file="public:Recommend" />
</body>
</html>
