<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<style type="text/css">
 body{
     background:#21283b;
 }
.hk_a { overflow:hidden;}
.hk_a a { height:5rem;line-height:5rem;display:block;text-align:center; font-size:1.6rem;color:#999999;
          width:50%;float:left;border-bottom:1px solid #cccccc;}
.hk_a a.hk_cut {border-bottom:1px solid #56c3cf;color:#56c3cf }	
.hk_b {width: 85%;margin: 10px auto 30px;}
.hk_b img{ width:100%; }
.hk_c { }
.hk_d  { width:80%;margin:0 auto;text-align:center;}
.hk_d img { width:100%;max-width:557px; }	  
.hk_e { top: 0%;width: 43%;margin: auto;height: 50.8%;left: 0;right: 0;bottom: 4.8%;}
.hk_e img { max-width:191px;width: 72%;margin-top: 15%;}
.hk_f { text-align:center;margin-top:3rem;}
.hk_f1 { display:inline-block;width:36%;height:3rem;line-height:3rem;background:#ff715f;border-radius:5px;
         font-size:1.5rem;color:#fff;}
.hk_f2 p {color:#FFFFFF;}
.hk_f2 { margin-top:1rem;}
.inninfo_box{width: 96%;margin: 7px auto;background-color: #FFFFFF;height: 60px;}
.inninfo_box .box_left{float: left;height: 100%;}
.inninfo_box .box_left img{height: 52px;margin: 4px;}
.inninfo_box .box_right{float: left;margin: 7px; margin-left: 10px;}
.inninfo_box .box_right .innname{font-size: 1.6rem;line-height: 2rem;}
</style>
<script type="text/javascript" src="__JS__/awardRotate.js"></script>
<script>
    $(function (){

        $('.pointer').bind("touchstart", function (event) {
            // event.preventDefault();
            $('.pointer img').attr("src","/Public/Wx/img/tp_a11.png");
        });
        $('.pointer').bind("touchend", function (event) {
            // event.preventDefault();
            $('.pointer img').attr("src","/Public/Wx/img/tp_a1.png");
        });

        var rotateTimeOut = function (){
            $('#rotate').rotate({
                angle:0,
                animateTo:2160,
                duration:8000,
                callback:function (){
                    alert('网络超时，请检查您的网络设置！');
                }
            });
        };
        var bRotate = false;

        $('.pointer').click(function (){
            var dataJson = {};
            if($('#innid').val() != ''){
                dataJson = {'innid':$('#innid').val()};
            }
            $.showLoading("正在查询...");
            $.ajax({ 
                  type: 'POST', 
                  url: "{:U('Wx/Vote/ajax_checkvotecount')}",
                  data:dataJson,
                  dataType: 'json', 
                  error: function() { 
                    $.hideLoading();
                      alert('Sorry，出错了！'); 
                      return false; 
                  }, 
                  success: function(json) { 
                    $.hideLoading();
                      if(json.status == 1){
                        //每日首次
                        layer.open({
                          content: '今天是您首次抽奖，不扣除投票券，确定抽奖？',
                          style:'width:70%;margin:auto;',
                          btn: ['确定', '取消'],
                          yes: function(index){
                            makevote();
                            layer.close(index);
                          },
                          no: function(index){
                            layer.close(index);
                          }
                        });
                      }else{
                        layer.open({
                          content: '今天是您非首次抽奖，需扣除10张投票券，确定抽奖？',
                          style:'width:70%;margin:auto;',
                          btn: ['确定', '取消'],
                          yes: function(index){
                            makevote();
                            layer.close(index);
                          },
                          no: function(index){
                            layer.close(index);
                          }
                        });
                      }
                  } 
              }); 

           //if(bRotate)return;
             
        });
    });
    var makevote = function(){
      var dataJson = {};
            if($('#innid').val() != ''){
                dataJson = {'innid':$('#innid').val()};
            }
            $.showLoading("");
            $.ajax({ 
                  type: 'POST', 
                  url: "{:U('Wx/Vote/makevote')}",
                  data:dataJson,
                  dataType: 'json', 
                  error: function() { 
                    $.hideLoading();
                      alert('Sorry，出错了！'); 
                      return false; 
                  }, 
                  success: function(json) { 
                    $.hideLoading();
                    if(json.success==true){
                      
                      $("#rotate").bind('click').css("cursor", "default"); 
                      var angle = 360-json.data; //指针角度  
                      $("#rotate").rotate({ 
                          duration: 3000,//转动时间 ms 
                          angle: 0, //从0度开始 
                          animateTo: 3600 + angle,//转动角度  
                          easing: $.easing.easeOutSine, //easing扩展动画效果 
                          callback: function() { 
                              $.alert(json.msg);
                              
                              bRotate = !bRotate;
                          } 
                      }); 
                    }else if(json.success==false){
                      alert(json.msg);
                    }
                      
                  } 
              });
    }
    function rnd(n, m){
        return Math.floor(Math.random()*(m-n+1)+n)
    }
</script>
<div class="hk_box">
        <!-- <div class="hk_a">
             <a href="{:U('Wx/Vote/turntable')}" class="hk_cut">大转盘抽奖</a>
             <a href="{:U('Wx/Vote/index')}">抽奖结果</a>
        </div> -->
        <div class="inninfo_box">
          <div class="box_left"><img src="{$inn.logo}"></div>
          <div class="box_right">
            <p class="innname">{$inn.name}</p>
            <p class="innaddr">地址：{$inn.address}</p>
          </div>
        </div>
        <div class="hk_b"><img src="__IMG__/tp_a2.png"></div>
        <input type="text" id="innid" value="{$innid}" hidden="true">
        <div class="hk_c">
            <div class="hk_d pr"><img id="rotate" src="__IMG__/tp_a3.png">
                   <div class="hk_e pa pointer" style="cursor:pointer;"><img src="__IMG__/tp_a1.png"></div>
            </div>
        </div> 
        
        <div class="hk_f">
              <div class="hk_f1">奖项设置</div>
              <div class="hk_f2">
                  <volist name="gift" id="vo">
                  <p> <eq name="vo['rank']" value="1">一等奖</eq>
                      <eq name="vo['rank']" value="2">二等奖</eq>
                      <eq name="vo['rank']" value="3">三等奖</eq>
                      <eq name="vo['rank']" value="4">四等奖</eq>
                      <eq name="vo['rank']" value="5">五等奖</eq>:{$vo.prize}</p>
                  </volist>
              </div>
        </div>  
        
        <div class="hk_f">
              <div class="hk_f1">活动时间</div>
              <div class="hk_f2">
                  <p>活动开始时间：  {$site.party_starttime}</p>
                  <p>活动结束时间：  {$site.party_endtime}</p>
              </div>
        </div>  
        
        <div class="hk_f" style="padding-bottom:4rem;">
              <div class="hk_f1">活动规则</div>
              <div class="hk_f2">
                  {$turntablerule}
              </div>
        </div>     
</div>
<include file="public:foot" />
