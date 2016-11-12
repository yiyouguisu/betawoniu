<include file="public:head" />
<body class="back-f1f1f1">
  <div class="header center z-index112 pr f18 fix-head">
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
            <img class="home_ck1" src="__IMG__/hj_a2.jpg"></em>
        <em>
          <a href="{:U('Web/Note/add')}">
            <img src="__IMG__/hj_a3.jpg">
          </a></em>
    </div>
  </div>
  <div class="container padding_0" style="margin-top:6rem">
      <div class="land">
          <div class="lpl_top">
              <div class="lpl_title">
                  <div class="lpl_a">{$data.title}</div>
                  <div class="lpl_b f0">
                      <div class="lpl_b1 vertical">
                          <img style="width:40px;height:40px;border-radius:50%" src="{$data.head}">&nbsp;{$data.nickname}</div>
                      <div class="lpl_b2 vertical"><em>发表于：</em>{$data.inputtime|date='Y-m-d',###}
                         <span class='certical notehit' data-id="{$data.id}" data-hitted="{$data.ishit}">
                              <if condition="$data.ishit eq 1">
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
                              <span class="hotel_item" id="hotel_{$vo.hid}" data-hid="{$vo.hid}" data-uid="{$vo.uid}">{$vo.title}</span>
                          </volist>
                      </div>
                  </div>
                  <div class="lpl_f">
                      <div class="lpl_e1">文中出现过的景点 :</div>
                      <div class="lpl_e2">
                        <volist name="data['note_place']" id="vo">
                          <span class="place_item" data-hid="{$vo.hid}" data-target="#hotel_{$vo.hid}" data-uid="{$vo.uid}" data-type="">
                            {$vo.title}
                          </span>
                        </volist>
                      </div>
                  </div>
                  <div class="mth_c" style="margin:0">
                      <div class="lpl_f">
                          <div class="lpl_e1">已选 :</div>
                          <div class="lpl_e2" id="item_selected">
                          </div>
                      </div>
                  </div>
                  <div class="snail_d center trip_btn f16" style="margin: 0rem;padding:1rem 0">
                      <a href="#" id="add_trip" class="snail_cut">添加到行程</a>
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
                      <volist name='data.reviewlist' id='vp'>
                        <div class="fans_list">
                            <div class="per_tx fl"><img src="{$vp.head}" style="width:36px;height:36px;border-radius:50%"></div>
                            <div class="fans_b per_tr fl">
                                <div class="fans_b1 f16">{$vp.nickname}</div> 
                                <div class="fans_b2 f14">{$vp.content}</div> 
                                <div class="fans_time f13">{$vp.inputtime|date='Y-m-d',###}</div>
                            </div>
                        </div>
                      </volist>
                  </div>
                  <div class="trip_t">
                      <input type="text" placeholder="发布我的评论 ..." class="trip_text fl" id="comment_content">
                      <input type="button" data-head="{$user.head}" data-nickname="{$user.nickname}" value="10+评论" class="trip_button fr" id="submit_comment">
                  </div>
              </div>
          </div>
          <gt name="note_near_hostel_num" value="0">
          <div class="mth pr">
              <div class="mth_top pa">附近民宿推荐</div>
              <div id="dom-effect" class="iSlider-effect"></div>
              <div class="mth_a center">
                  <span>
                      <a href="{:U('Web/Hostel/index')}">查看更多</a></span>
                  <div class="mth_a2"></div>
              </div>
          </div>
          </gt>
          <gt name="note_near_activity_num" value="0">
          <div class="mth pr" style="margin-top: 20px;">
              <div class="mth_top pa">附近活动推荐</div>
              <div id="mth_dom" class="iSlider-effect"></div>
              <div class="mth_a center">
                  <span>
                      <a href="{:U('Web/Party/index')}">查看更多</a></span>
                  <div class="mth_a2"></div>
              </div>
          </div>
          </gt>
      </div>
  </div>
  <div id="new_trip" class="hide">
    <div class="trip_cover"></div>
    <div class="trip_pre_content">
      <div style="padding:10px;font-size:14px;">
        <div style="width:30%" class="fl">
          <a href="#" id="dismiss_edit" style="color:#aaa">取消</a>
        </div> 
        <div style="width:40%;color:#56c3cf" class="fl tc">编辑行程信息</div> 
        <div style="width:30%" class="fl tr">
          <a href="#" style="color:#56c3cf" id="save_trip">保存</a>
        </div> 
        <div style="clear:both"></div>
      </div>
      <div style="padding:10px;">
        <form action="{:U('Trip/add')}" method="post" id="post_add">
          <div class="form-group">
            <input type="hidden" value="" name="hotels">
            <input class="required form-control form-inline" type="text" name="trip_title" placeholder="行程标题：" data-content="行程标题">
          </div>
          <div class="form-group">
            <input class="required form-control form-inline" type="date" name="start_date" placeholder="出发时间：" value="" data-content="出发时间">
          </div>
          <div class="form-group">
            <input class="required form-control form-inline" type="number" name="trip_days" placeholder="出行天数：" data-content="出行天数">
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="mask"></div>
<div class="fish_btm hide">
    <div class="fish_t center">
        <div class="fish_t1">
            <span></span>
            <img src="__IMG__/drop.jpg"></div>
    </div>
    <div class="fish_y">
        <ul>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="__IMG__/hm_a1.jpg"></a></div>
                <div class="fish_y2">微信</div>
            </li>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="__IMG__/hm_a2.jpg"></a></div>
                <div class="fish_y2 fish_y3">微博</div>
            </li>
            <li>
                <div class="fish_y1">
                    <a href=""><img src="__IMG__/hm_a3.jpg"></a></div>
                <div class="fish_y2 fish_y4">QQ</div>
            </li>
        </ul>
    </div>
</div>
  <script src="__JS__/islider.js"></script>
  <script src="__JS__/islider_desktop.js"></script>

  <script>
      
      var note_near_hostel= {$data.note_near_hostel};
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
  
      var note_near_activity= {$data.note_near_activity};
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
          var hitted = obj.data('hitted');
          var url = hitted ? '{:U("Api/Note/unhit")}' : '{:U("Api/Note/hit")}';
          if(!uid){
              alert("请先登录！");
              var p={};
              p['url']="__SELF__";
              $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                  if(data.code=200){
                      window.location.href="{:U('Web/Member/login')}";
                  }
              })
              return false;
          }
          var hitnum=$(this).find("#vcount");
          var nid=$(this).data("id");
          $.ajax({
              type: "POST",
              url: url,
              data: JSON.stringify({'nid':nid, 'uid': uid}),
              dataType: "json",
              processData: false,
              contentTyppe: 'text/xml',
              success: function(data){
                if(data.code==200){
                  if(hitted==1){
                      obj.data('hitted', 0);
                      var num=Number(hitnum.text()) - 1;
                      hitnum.text(num);
                      obj.find("img").attr("src","__IMG__/poin.png");
                  }else if(hitted==0){
                      obj.data('hitted', 1);
                      var num=Number(hitnum.text()) + 1;
                      hitnum.text(num);
                      obj.find("img").attr("src","__IMG__/poin_1.png");
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
  <script>
    var selectedHotel = [];
    $('.hotel_item').click(function(evt) {
      evt.preventDefault();
      var _this = $(this);
      var hid = _this.data('hid');
      if($.inArray(hid, selectedHotel) >=0) {
        return;  
      }
      var clone = _this.clone();
      clone.removeAttr('id');
      clone.click(function(e) {
        e.preventDefault();
        selectedHotel.splice($.inArray($(this).data('hid'), selectedHotel), 1);
        $(this).remove(); 
      });
      selectedHotel.push(hid);
      $('#item_selected').append(clone);
    });
    $('.place_item').click(function(evt) {
      evt.preventDefault();
      var _this = $(this);
      var hid = _this.data('hid');
      var that = $(_this.data('target'));
      console.log(selectedHotel);
      if($.inArray(hid, selectedHotel) >= 0) {
        return; 
      }
      console.log(selectedHotel);
      var clone = that.clone();
      clone.removeAttr('id');
      clone.click(function(e) {
        e.preventDefault();
        selectedHotel.splice($.inArray($(this).data('hid'), selectedHotel), 1);
        $(this).remove(); 
      });
      selectedHotel.push(hid);
      $('#item_selected').append(clone);
    })
  </script>
  <script>
    $('#add_trip').click(function(evt) {
      evt.preventDefault();
      if(selectedHotel.length == 0) {
        alert('请至少选择一个美宿或景点！');
        return;
      }
      $('#new_trip').removeClass('hide');
      $('.mask').hide();
    });
    $('#dismiss_edit').click(function(evt) {
      evt.preventDefault();
      $('#new_trip').addClass('hide');
      $('.required').val('');
    });
    $('#save_trip').click(function(e) {
      e.preventDefault();
      var filled = true;
      var notice = '';
      $('input[name=hotels]').val(selectedHotel.join(','));
      $('.required').each(function(i, t) {
        var val = $(t).val();
        if(!val) {
          filled = false;  
          notice += $(t).data('content') + '必须填写！\n';
        }
      });
      if(filled) {
        $('#post_add')[0].submit();
      } else {
        alert(notice); 
      }
    });
  </script>
  <script>
    $('#submit_comment').click(function(evt) {
      evt.preventDefault();
      var _this = $(this);
      var head = _this.data('head');
      var nickname = _this.data('nickname');
      if(!nickname) {
        alert('请登录后评论！');
        return;
      }
      var content = $('#comment_content').val();
      if(!content || content.length < 10) {
        alert('请发表10个字以上的评论！');
        return;
      }
      $.ajax({
        'url': '{:U("Api/Note/review")}',
        'type': 'post',
        'data': JSON.stringify({
          'uid': '{$user.id}',
          'nid': '{$data.id}',
          'content': content
        }),
        'dataType': 'json',
        'contentType': 'text/xml',
        'processData': false,
        'success': function(data) {
          if(data.code == 200) {
            var dat = new Date();
            var year = dat.getFullYear();
            var month = dat.getMonth() + 1;
            var day = dat.getDate();
            var html = '<div class="fans_list">' + 
                       '<div class="per_tx fl"><img src="upload/land_a.png" style="width:36px;height:36px;border-radius:50%"></div>' +
                       '<div class="fans_b per_tr fl">' +
                       '<div class="fans_b1 f16 nickname"></div>' +
                       '<div class="fans_b2 f14 content"></div>' +
                       '<div class="fans_time f13">' + year + '-' + month + '-' + day + '</div></div>' +
                       '</div>';
            var newComment = $(html);
            newComment.find('.content').html(content);
            newComment.find('img').attr('src', head);
            newComment.find('.nickname').html(nickname);
            $('.trip_fBtm').prepend(newComment);
            var children = $('.trip_fBtm').children();
            if(children.length > 5) {
              $(children[5]).remove();
            }
          } else {
            alert(data.msg); 
          }
        },
        'error': function(err, data) {
          console.log(err); 
        }
      });
    });
  </script>
</body>
</html>
