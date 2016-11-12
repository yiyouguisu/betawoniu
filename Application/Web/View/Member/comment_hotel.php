<include file="public:head" />
<body class="back-1">
  <div class="header center pr f18 fix-head">
      点评
      <div class="head_go pa">
        <a href="javascript:history.go(-1);">
          <img src="__IMG__/go.jpg">
        </a>
      </div>
  </div>
  <div class="container" style="margin-top:6rem">
      <div class="land">
          <div class="land_c back_fff  f14">
              <div class="land_d pr  f0">
                  <div class="land_e vertical">
                      <img src="{$hotel.thumb}" style="width:100px;height:80px;">
                  </div>
                  <div class="land_f vertical">
                    <div class="land_f1 f16">{$hotel.title}</div>
                    <div class="rev_a f14">{$hotel.room_name}</div>
                  </div>
              </div>
          </div>
          <div class="rev_b">
              <div class="rev_list">
                  <div class="rev_b1 vertical">整洁卫生 :</div>
                  <div class="rev_b2 vertical" id="neat">
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                  </div>
              </div>

              <div class="rev_list">
                  <div class="rev_b1 vertical">安全程度 :</div>
                  <div class="rev_b2 vertical" id="safe">
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                  </div>
              </div>

              <div class="rev_list">
                  <div class="rev_b1 vertical">描述相符 :</div>
                  <div class="rev_b2 vertical" id="match">
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                  </div>
              </div>

              <div class="rev_list">
                  <div class="rev_b1 vertical">交通位置 :</div>
                  <div class="rev_b2 vertical" id="position">
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                  </div>
              </div>

              <div class="rev_list">
                  <div class="rev_b1 vertical">性价比 :</div>
                  <div class="rev_b2 vertical" id="cost">
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                      <div class="rev_d"></div>
                  </div>
              </div>
          </div>
          <div class="rev_e">
              <textarea class="help_area rev_area" name="your_comment" id="comment" placeholder="您的点评"></textarea>
          </div>
          <!--
          <div class="hm_b">上传图片 :</div>
          <div class="hm_d" id="img_list">
              <ul>
                  <li>
                      <label for="fileupload">
                        <img src="__IMG__/hm_c2.jpg">
                        <input type="file" name="head" id="fileupload" class="head-input fileupload" style="display:none">
                      </label>
                  </li>
              </ul>
          </div>
          -->
          <div class="edit disnone">
            <div id="clipArea"></div>
            <div class="gn">
                <p>提示：您可以放大、缩小、左右旋转编辑图片</p>
                <span class="close">返回上页</span>
                <span id="clipBtn">生成照片</span>
            </div>
            <!-- <div id="view"></div> -->
          </div>
          <div class="bv">
              <div class="bv_a">
                  <input type="checkbox" id="sec" class="chk_1" id="isanonymous">
                  <label for="sec"></label> <span>匿名点评</span>
              </div>
              <div class="snail_d center trip_btn f16">
                  <a href="javascript:;" class="snail_cut jk_click" id="go">提交</a>
              </div>
          </div>
      </div>
  </div>
<script src="__JS__/iscroll-zoom.js"></script>
<script src="__JS__/hammer.js"></script>
<script src="__JS__/lrz.all.bundle.js"></script>
<script src="__JS__/jquery.photoClip.js"></script>
<script type="text/javascript" src="__JS__/jquery.ui.widget.js"></script>
<script type="text/javascript" src="__JS__/jquery.fileupload.js"></script>
<script>
  $(function(){
    //上传头像
    var clipArea = new bjj.PhotoClip("#clipArea", {
      size: [$(window).width()*0.9, $(window).width()*0.9], // 截取框的宽和高组成的数组。默认值为[260,260]
      file: ".fileupload", // 上传图片的<input type="file">控件的选择器或者DOM对象
      view: "#view", // 显示截取后图像的容器的选择器或者DOM对象
      ok: "#clipBtn", // 确认截图按钮的选择器或者DOM对象
      loadStart: function(file) {console.log("start");$(".photo-clip-view").addClass("zairu");}, //开始加载的回调函数。this指向 fileReader 对象，并将正在加载的 file 对象作为参数传入
      loadComplete: function(src) {console.log("complete");$(".photo-clip-view").removeClass("zairu");}, // 加载完成的回调函数。this指向图片对象，并将图片地址作为参数传入
      loadError: function(event) {console.log("error");}, // 加载失败的回调函数。this指向 fileReader 对象，并将错误事件的 event 对象作为参数传入
      clipFinish: function(dataURL) {
        BindImg(dataURL);
      }, // 裁剪完成的回调函数。this指向图片对象，会将裁剪出的图像数据DataURL作为参数传入
    });
    $(".fileupload").click(function() {
      $('.edit').show();
    });
    $(".close").click(function(){
      $('.edit').hide();
    });

  });

  function BindImg (url){
    var html = '<li><img src="' + url + '" style="width:105px;height:80px"></li>';
  }
  function go(evt) {
    evt.preventDefault();
    var content = $('#comment').val();
    if(!content) {
      alert('评论内容不能为空！');
      return;
    }
    var neat = $('#neat').find('.rev_cut').length;
    var safe = $('#safe').find('.rev_cut').length;
    var match = $('#match').find('.rev_cut').length;
    var position = $('#position').find('.rev_cut').length;
    var cost = $('#cost').find('.rev_cut').length;
    var isanonymous = $('#isanonymous').is(':checked') ? 1 : 0;
    rawPost('{:U("Api/Order/evaluate")}', {
        'uid': '{$uid}',
        'orderid': '{$orderid}', 
        'hid': '{$hotel.hid}',
        'neat': neat,
        'safe': safe,
        'match': match,
        'position': position,
        'cost': cost,
        'content': content,
        'isanonymous': isanonymous
      }, function(data) {
        if(data.code == 200) {
          alert('评论成功！');
          window.location.href="{:U('Order/hotel_order_detail')}?orderid={$orderid}";
        } else {
          alert(data.msg); 
        }
      }, function(err, data) {
        console.log(err); 
      });
  }
  $('#go').click(go);
</script>
</body>
</html>
