<include file="Public:head" />
<div class="header center pr f18 fix-head">蜗牛客
  <div class="address f14 pa">
    <a href="{:U('Public/search')}">{$city['name']|default='城市'}<img src="__IMG__/address.png"></a>
  </div>
</div>
<div class="container" style="margin-top:6rem">
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>
                <volist name='ad' id='vo'>
                    <li>
                      <if condition="$vo.hid gt 0">
                        <a class="pic" href="{:U('Hostel/show')}?id={$vo.hid}">
                      <elseif condition="$vo.nid gt 0" />
                        <a class="pic" href="{:U('Note/show')}?id={$vo.nid}">
                      <elseif condition="$vo.aid gt 0" />
                        <a class="pic" href="{:U('Party/show')}?id={$vo.aid}">
                      <else />
                        <a class="pic" href="{$vo.url}">
                      </if>
                        <img src="{$vo.image}" style="height:200px;width:100%">
                      </a>
                    </li>
                </volist>
            </ul>
        </div>
        <div class="hd">
            <ul></ul>
        </div>
    </div>
    <div class="land_c">
        <div class="search_box" id="search_box" data-url="{:U('Public/search_project')}">
            <input type="text" class="search_text" placeholder="输入目的地、景点、美宿等关键词...">
            <input type="button" class="search_btn">
        </div>
        <!-- <button class='btn'>test</button> -->
        <div class="nav center">
            <a href="{:U('Web/Note/index')}">
                <img src="__IMG__/tb_a1.png">
                游记</a>
            <a href="{:U('Web/Hostel/index')}">
                <img src="__IMG__/tb_a3.png">
                美宿</a>
            <a href="{:U('Web/Party/index')}">
                <img src="__IMG__/tb_a2.png">
                活动</a>
        </div>
    </div>
    <div class="recom  recom_ppt">
        <div class="recom_title f18 center">推荐游记</div>
        <volist name="data['note']" id='vo'>
          <div class="recom_list pr">
            <div class="recom_a pr">
              <a href="{:U('Web/Note/show',array('id'=>$vo['id']))}">
                   <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width: 100%;height: 60vw;">
              </a>
              <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}"><div class="recom_d pa"><img src="{$vo.head}"></div></a>
            </div>
            <div class="recom_b pa"><eq name="vo['type']" value="1"><img src="__IMG__/recom_a1.png"></eq></div>
            <div class="recom_c pa"><div class="recom_gg notecollect <if condition='$vo.iscollect eq 1'>recom_c_cut</if>" data-id="{$vo.id}"></div></div>
            <div class="recom_e">
              <div class="land_f1 recom_e1 f16">{$vo.title}</div>
              <div class="recom_f">
                <div class="recom_f1 f12 fl">{$vo.inputtime|date='Y-m-d',###}</div>
                <div class="recom_f2 fr">
                  <div class="land_h recom_f3 vertical">
                    <div class="land_h2 f12 vertical notehit" data-id="{$vo.id}">
                      <if condition='$vo.ishit eq 1'>
                        <img src="__IMG__/poin_1.png">
                      <else/>
                        <img src="__IMG__/poin.png">
                      </if>
                      <span class="vcount">{$vo.hit|default="0"}</span>
                    </div>
                    <div class="land_h1 f12 vertical">
                      <img src="__IMG__/land_d3.png">
                      <span>{$vo.reviewnum|default="0"}</span>条评论 
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </volist>
    </div>


    <div class="recom">
        <div class="recom_title f18 center" style="color: #ff715f">推荐美宿</div>
        <volist name="data['house']" id='vo'>
                  <div class="recom_list pr">
                         <div class="recom_a pr">
                              <a href="{:U('Web/Hostel/show',array('id'=>$vo['id']))}"><img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width: 100%;height: 60vw"></a>
                               <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}">
                                  <div class="recom_d pa"><img src="{$vo.head}"></div>
                               </a>
                               <div class="recom_g f18 center pa">
                                   <div class="recom_g1 fl"><em>￥</em>{$vo.money|default="0.00"}<span>起</span></div>
                                   <div class="recom_g2 fl">{$co.evaluation|default="10.0"}<span>分</span></div>
                               </div>
                         </div>
                         <div class="recom_c pa"><div class="recom_gg hostelcollect <if condition='$vo.iscollect eq 1'>recom_c_cut</if>" data-id="{$vo.id}"></div></div>
                        <div class="recom_e">
                               <div class="land_f1 recom_e1 f16">{$vo.title}</div>
                               <div class="recom_f">
                                <div class="recom_f1 recom_hong f12 fl">
                                  <img src="__IMG__/add_e.png">距你<span class="distance" data-lat="{$vo.lng}" data-lng="{$vo.lat}">0.00</span>公里
                                </div>
                                    <div class="recom_f2 fr">
                                        <div class="land_h recom_f3 vertical">
                                              <div class="land_h2 f12 vertical hostelhit" data-id="{$vo.id}">
                                                <if condition='$vo.ishit eq 1'>
                                                  <img src="__IMG__/poin_1.png">
                                                <else/>
                                                  <img src="__IMG__/poin.png">
                                                </if>
                                                <span class="vcount">{$vo.hit|default="0"}</span>
                                              </div>
                                              <div class="land_h1 f12 vertical">
                                                    <img src="__IMG__/land_d3.png">
                                                    <span>{$vo.reviewnum|default="0"}</span>条评论
                                              </div>
                                          </div>
                                    </div>
                               </div>
                        </div>
                    </div>

               </volist>
    </div>
    <div class="recom">
        <div class="recom_title f18 center" style="color: #56c3cf">推荐活动</div>
        <volist name="data['party']" id='vo'>
                <div class="recom_list pr">
                     <div class="recom_a pr">
                           <a href="{:U('Web/Party/show',array('id'=>$vo['id']))}"><img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" style="width: 100%;height: 60vw"></a>
                           <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}"><div class="recom_d pa"><img src="{$vo.head}"></div></a>
                     </div>
                     <div class="recom_c pa"><div class="recom_gg partycollect <if condition='$vo.iscollect eq 1'>recom_c_cut</if>" data-id="{$vo.id}"></div></div>
             
                    <div class="recom_e">
                           <div class="land_f1 recom_e1 f16">{$vo.title}</div>
                           <div class="recom_k">
                                    <div class="land_font">
                                        <span>时间:</span> {$vo.starttime|date='Y-m-d',###} 至{$vo.endtime|date='Y-m-d',###}       
                                    </div> 
                                    <div class="land_font">
                                        <span>地点:</span> {:getarea($vo['area'])}{$vo.address}        
                                    </div> 
                          </div>
                          <div class="recom_s f14">
                              已参与：
                              <span>
                                <volist name='vo["joinlist"]' id='v'>
                                  <img src="{$v.head}">
                                </volist>
                              </span>
                              <em>(..{$vo.joinnum|default ='0'}人)</em>
                          </div>
                    </div>
                </div>
             </volist>
    </div>
    <div style="height: 8rem"></div>

</div>
<script type="text/javascript">
    TouchSlide({
        slideCell: "#slideBox",
        titCell: ".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
        mainCell: ".bd ul",
        effect: "leftLoop",
        autoPage: true,//自动分页
        autoPlay: true //自动播放
    });
</script>
<script>
    $(function () {
        $(".notehit").click(function () {
            var obj = $(this);
            var uid = '{$user.id}';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "__SELF__";
                $.post("{:U('Web/Public/ajax_cacheurl')}", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "{:U('Web/Member/login')}";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var nid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "{:U('Web/Note/ajax_hit')}",
                data: { 'nid': nid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.notecollect').click(function () {
            var obj = $(this);
            var uid = '{$user.id}';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "__SELF__";
                $.post("{:U('Web/Public/ajax_cacheurl')}", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "{:U('Web/Member/login')}";
                    }
                })
                return false;
            }
            var nid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "{:U('Web/Note/ajax_collect')}",
                data: { 'nid': nid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
        $(".partyhit").click(function () {
            var obj = $(this);
            var uid = '{$user.id}';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "__SELF__";
                $.post("{:U('Web/Public/ajax_cacheurl')}", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "{:U('Web/Member/login')}";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var aid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "{:U('Web/Party/ajax_hit')}",
                data: { 'aid': aid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.partycollect').click(function () {
            var obj = $(this);
            var uid = '{$user.id}';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "__SELF__";
                $.post("{:U('Web/Public/ajax_cacheurl')}", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "{:U('Web/Member/login')}";
                    }
                })
                return false;
            }
            var aid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "{:U('Web/Party/ajax_collect')}",
                data: { 'aid': aid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
        $(".hostelhit").click(function () {
            var obj = $(this);
            var uid = '{$user.id}';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "__SELF__";
                $.post("{:U('Web/Public/ajax_cacheurl')}", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "{:U('Web/Member/login')}";
                    }
                })
                return false;
            }
            var hitnum = $(this).find('span');
            var hid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "{:U('Web/Hostel/ajax_hit')}",
                data: { 'hid': hid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            var num = Number(hitnum.text()) + 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin_1.png");
                        } else if (data.type == 2) {
                            var num = Number(hitnum.text()) - 1;
                            hitnum.text(num);
                            obj.find('img').attr("src", "/Public/Web/images/poin.png");
                        }
                    } else if (data.status == 0) {
                        alert("点赞失败！");
                    }
                }
            });
        });
        $('.hostelcollect').click(function () {
            var obj = $(this);
            var uid = '{$user.id}';
            if (!uid) {
                alert("请先登录！");
                var p = {};
                p['url'] = "__SELF__";
                $.post("{:U('Web/Public/ajax_cacheurl')}", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "{:U('Web/Member/login')}";
                    }
                })
                return false;
            }
            var hid = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "{:U('Web/Hostel/ajax_collect')}",
                data: { 'hid': hid },
                dataType: "json",
                success: function (data) {
                    if (data.status == 1) {
                        if (data.type == 1) {
                            obj.addClass('recom_c_cut');
                        } else if (data.type == 2) {
                            obj.removeClass('recom_c_cut');
                        }
                    } else if (data.status == 0) {
                        alert("收藏失败！");
                    }
                }
            });
        });
    });
</script>
<script>
  $('#search_box').click(function(evt) {
    evt.preventDefault();
    var url = $(this).data('url');
    window.location.href = url;
  
  });
</script>
<script>
  function getHotelDistance(lat, lng) {
    $('.distance').each(function(i, t) {
      var _this = $(t);
      var dest_lat = _this.data('lng');
      var dest_lng = _this.data('lat');
      $.ajax({
        'url': '{:U("Api/Map/get_distance_for_web")}?o_lat=' + lat + '&o_lng=' + lng + '&d_lat=' + dest_lat + '&d_lng=' + dest_lng,
        'type': 'get',
        'dataType': 'text',
        'success': function(data) {
          _this.html(data);
        },
        'error': function(err) {
          console.log(err); 
        }
      });
    });
  };
</script>
<include file="Public:foot" />
