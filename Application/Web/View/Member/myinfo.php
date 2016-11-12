<include file="Public:head" />
<body>
<div class="header center pr f18">
      个人信息
  <div class="head_go pa" onclick="window.location.href='{:U('Web/Member/index')}'">
    <img src="__IMG__/go.jpg" style="">
  </div>
</div>
<div class="edit disnone">
            <div id="clipArea"></div>
            <div class="gn">
                <p>提示：您可以放大、缩小、左右旋转编辑图片</p>
                <span class="close">返回上页</span>
                <span id="clipBtn">生成照片</span>
            </div>
            <!-- <div id="view"></div> -->
          </div>
<div class="container">
   <div class="land">
          
          <div class="son_top f0" style="position:relative;">
              <div class="son_a vertical">
                <label style="display:block" for="fileupload">
                  <input type="file" name="head" id="fileupload" class="head-input fileupload">
                  <img src="{$data.head}" id="headphoto" style="width:60px;height:60px;border-radius:35px;">
                </label>
              </div>
              <div class="son_b vertical">
                <div class="son_b1 f18">{$data.nickname}</div>
                <div class="son_b2 f14">关注: {$follow} <span>粉丝: {$fans}</span></div>
              </div>
              <div class="set_a  xm_click pa">
                <input type="file" name="head" id="fileupload" class="head-input fileupload">
                <a href="javascript:;">更换头像<img src="__IMG__/set_right.jpg"></a></div>
          </div>
          <div class="land_btm">
                <div class="ht_colot"></div>
                <div class="det_box arrow_jk">
                      <a href="{:U('Web/Member/editphone')}"><div class="det_list">
                            <div class="det_a fl">手机 :</div>
                            <div class="det_b fr">{$data.phone}</div>
                      </div></a>
                      <a href="{:U('Web/Member/editsex')}"><div class="det_list">
                            <div class="det_a fl">性别 :</div>
                            <div class="det_b fr">
                            	<if condition="$data['sex'] eq 1">
                            		男
              								<elseif condition="$data['sex'] eq 2" />
              									女
              								<else /> 
              									未知
              								</if>
                            </div>
                      </div></a>
                      <a href="{:U('Web/Member/editbirthday')}"><div class="det_list">
                            <div class="det_a fl">出生日期 :</div>
                            <div class="det_b fr">{$data.birthday|date='Y年m月d日',###}</div>
                      </div></a>
                      <a href="{:U('Web/Member/editinfo')}"><div class="det_list">
                            <div class="det_a fl">个性签名 :</div>
                            <div class="det_b fr">{$data.info}</div>
                      </div></a>
                      <a href="{:U('Web/Member/edithometown')}"><div class="det_list">
                            <div class="det_a fl">故乡 :</div>
                            <div class="det_b fr">
                            	<volist name='hometown' id='vo'>
                            		{$vo}
                            	</volist>
                            </div>
                      </div></a>
                      <a href="{:U('Web/Member/editarea')}"><div class="det_list">
                            <div class="det_a fl">所在地 :</div>
                            <div class="det_b fr">
								<volist name='area' id='vo'>
                            		{$vo}
                            	</volist>
                            </div>
                      </div></a>
                      <div class="det_list">
                            <div class="det_a fl">学历 :</div>
                            <div class="det_b fr">
                              <select class="xuex_select education">
                                  <option value="博士" <if condition="$data['education'] eq 博士">selected="selected"</if> >博士</option>
                                  <option value="B型" <if condition="$data['education'] eq 硕士">selected="selected"</if> >硕士</option>
                                  <option value="AB型" <if condition="$data['education'] eq 本科">selected="selected"</if> >本科</option>
                                  <option value="O型" <if condition="$data['education'] eq 专科">selected="selected"</if> >专科</option>
                                  <option value="其他" <if condition="$data['education'] eq 其他">selected="selected"</if> >其他</option>
                              </select>
                            </div>
                      </div>

                     <a href="{:U('Web/Member/editschool')}"><div class="det_list">
                            <div class="det_a fl">学校 :</div>
                            <div class="det_b fr">{$data.school}</div>
                      </div></a>

                      <div class="det_list">
                            <div class="det_a fl">属相 :</div>
                            <div class="det_b fr">
                              <select class="xuex_select zodiac">
                                  <option value="子鼠" <if condition="$data['zodiac'] eq 子鼠">selected="selected"</if> >子鼠</option>
                                  <option value="丑牛" <if condition="$data['zodiac'] eq 丑牛">selected="selected"</if> >丑牛</option>
                                  <option value="寅虎" <if condition="$data['zodiac'] eq 寅虎">selected="selected"</if> >寅虎</option>
                                  <option value="卯兔" <if condition="$data['zodiac'] eq 卯兔">selected="selected"</if> >卯兔</option>
                                  <option value="辰龙" <if condition="$data['zodiac'] eq 辰龙">selected="selected"</if> >辰龙</option>
                                  <option value="巳蛇" <if condition="$data['zodiac'] eq 巳蛇">selected="selected"</if> >巳蛇</option>
                                  <option value="午马" <if condition="$data['zodiac'] eq 午马">selected="selected"</if> >午马</option>
                                  <option value="未羊" <if condition="$data['zodiac'] eq 未羊">selected="selected"</if> >未羊</option>
                                  <option value="申猴" <if condition="$data['zodiac'] eq 申猴">selected="selected"</if> >申猴</option>
                                  <option value="酉鸡" <if condition="$data['zodiac'] eq 酉鸡">selected="selected"</if> >酉鸡</option>
                                  <option value="戌狗" <if condition="$data['zodiac'] eq 戌狗">selected="selected"</if> >戌狗</option>
                                  <option value="亥猪" <if condition="$data['zodiac'] eq 亥猪">selected="selected"</if> >亥猪</option>
                              </select>
                            </div>
                      </div>
                      <div class="det_list">
                            <div class="det_a fl">星座 :</div>
                            <div class="det_b fr">
                              <select class="xuex_select constellation">
                                  <option value="白羊座" <if condition="$data['constellation'] eq 白羊座">selected="selected"</if> >白羊座</option>
                                  <option value="金牛座" <if condition="$data['constellation'] eq 金牛座">selected="selected"</if> >金牛座</option>
                                  <option value="双子座" <if condition="$data['constellation'] eq 双子座">selected="selected"</if> >双子座</option>
                                  <option value="巨蟹座" <if condition="$data['constellation'] eq 巨蟹座">selected="selected"</if> >巨蟹座</option>
                                  <option value="狮子座" <if condition="$data['constellation'] eq 狮子座">selected="selected"</if> >狮子座</option>
                                  <option value="处女座" <if condition="$data['constellation'] eq 处女座">selected="selected"</if> >处女座</option>
                                  <option value="天秤座" <if condition="$data['constellation'] eq 天秤座">selected="selected"</if> >天秤座</option>
                                  <option value="天蝎座" <if condition="$data['constellation'] eq 天蝎座">selected="selected"</if> >天蝎座</option>
                                  <option value="射手座" <if condition="$data['constellation'] eq 射手座">selected="selected"</if> >射手座</option>
                                  <option value="摩羯座" <if condition="$data['constellation'] eq 摩羯座">selected="selected"</if> >摩羯座</option>
                                  <option value="水瓶座" <if condition="$data['constellation'] eq 水瓶座">selected="selected"</if> >水瓶座</option>
                                  <option value="双鱼座" <if condition="$data['constellation'] eq 双鱼座">selected="selected"</if> >双鱼座</option>
                              </select>
                            </div>
                      </div>

                     <div class="det_list">
                            <div class="det_a fl">血型 :</div>
                            <div class="det_b fr">
                                 <select class="xuex_select blood">
                                      <option value="A型" <if condition="$data['bloodtype'] eq A型">selected="selected"</if> >A型</option>
                                      <option value="B型" <if condition="$data['bloodtype'] eq B型">selected="selected"</if> >B型</option>
                                      <option value="AB型" <if condition="$data['bloodtype'] eq AB型">selected="selected"</if> >AB型</option>
                                      <option value="O型" <if condition="$data['bloodtype'] eq O型">selected="selected"</if> >O型</option>
                                 </select>
                            </div>
                      </div>
                      <a href="{:U('Web/Member/edithobby')}"><div class="det_list">
                            <div class="det_a fl">个性标签 :</div>
                            <div class="det_b fr" style="overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{$hobbyAndCharac}</div>
                      </div></a>
                </div>
                <eq name="$data[realname_status]" value="0">
                  <div class="fg_d son_btn ggt_href"><a href="{:U('Web/Member/realname')}">我要实名认证</a></div>
                </eq>
          </div>	

   </div>	   	
</div>
<script src="__JS__/iscroll-zoom.js"></script>
<script src="__JS__/hammer.js"></script>
<script src="__JS__/lrz.all.bundle.js"></script>
<script src="__JS__/jquery.photoClip.js"></script>
<script type="text/javascript" src="__JS__/jquery.ui.widget.js">
<script type="text/javascript" src="__JS__/jquery.fileupload.js">
<script>

</script>
<script type="text/javascript">
  $(function(){
    //上传头像
    var clipArea = new bjj.PhotoClip("#clipArea", {
      size: [$(window).width()*0.9, $(window).width()*0.9], // 截取框的宽和高组成的数组。默认值为[260,260]
      // outputSize: [640, 640], // 输出图像的宽和高组成的数组。默认值为[0,0]，表示输出图像原始大小
      //outputType: "jpg", // 指定输出图片的类型，可选 "jpg" 和 "png" 两种种类型，默认为 "jpg"
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

    // 更新血型
    var blood=$('.blood');
    blood.change(function(){
      console.log($(this).val());
      var data={'blood':$(this).val()};
      $.post("{:U('Web/Member/myinfo')}",data,function(res){
        alert(res.msg)
      });
    });
    // 更新学历
    var education=$('.education');
    education.change(function(){
      console.log($(this).val());
      var data={'education':$(this).val()};
      $.post("{:U('Web/Member/myinfo')}",data,function(res){
        alert(res.msg)
      });
    }); 
    // 属相
    var zodiac=$('.zodiac');
    zodiac.change(function(){
      console.log($(this).val());
      var data={'zodiac':$(this).val()};
      $.post("{:U('Web/Member/myinfo')}",data,function(res){
        alert(res.msg)
      });
    });    
    // 星座
    var constellation=$('.constellation');
    constellation.change(function(){
      console.log($(this).val());
      var data={'constellation':$(this).val()};
      $.post("{:U('Web/Member/myinfo')}",data,function(res){
        alert(res.msg)
      });
    }); 

  });
  var BindImg = function(url){
    $("#headphoto").attr("src",url);
    $('.edit').hide();
    var data={'headphoto':url};
    var index = layer.open({type: 2});
    $.post("{:U('Web/Member/myinfo')}",data,function(res){
      layer.close(index);
      if(res.code == 200)
        layer.open({
          content: res.msg
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
      else
        layer.open({
          content: '更新失败，请重试！'
          ,skin: 'msg'
          ,time: 2 //2秒后自动关闭
        });
    });
  }
</script>
</body>

</html>
