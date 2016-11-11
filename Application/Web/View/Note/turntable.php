<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<style type="text/css">
 body{
     background:#fbfbfb;
 }
.hk_a { overflow:hidden;}
.hk_a a { height:5rem;line-height:5rem;display:block;text-align:center; font-size:1.6rem;color:#999999;
          width:50%;float:left;border-bottom:1px solid #cccccc;}
.hk_a a.hk_cut {border-bottom:1px solid #56c3cf;color:#56c3cf }	
.hk_b img{ width:100%; }
.hk_c { margin-top:-20%;}
.hk_d  { width:74%;margin:0 auto;text-align:center;}
.hk_d img { width:100%;max-width:557px; }	  
.hk_e { top: 0%;width: 43%;margin: auto;height: 50.8%;left: 0;right: 0;bottom: 4.8%;}
.hk_e img { max-width:191px;}
.hk_f { text-align:center;margin-top:3rem;}
.hk_f1 { display:inline-block;width:36%;height:5rem;line-height:5rem;background:#ff715f;border-radius:5px;
         font-size:1.6rem;color:#fff;}
.hk_f2 p { font-size:1.4rem;color:#666666;line-height:2rem;}
.hk_f2 { margin-top:1rem;}

</style>
<script type="text/javascript" src="__JS__/awardRotate.js"></script>
<script>
    $(function (){
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
           //if(bRotate)return;
            $.ajax({ 
                  type: 'POST', 
                  url: "{:U('Wx/Choujiang/make')}",
                  dataType: 'json', 
                  error: function() { 
                      alert('Sorry，出错了！'); 
                      return false; 
                  }, 
                  success: function(json) { 
                    if(json.status==1){
                      $("#rotate").bind('click').css("cursor", "default"); 
                      var angle = json.angle; //指针角度  
                      $("#rotate").rotate({ 
                          duration: 3000,//转动时间 ms 
                          angle: 0, //从0度开始 
                          animateTo: 3600 + angle,//转动角度  
                          easing: $.easing.easeOutSine, //easing扩展动画效果 
                          callback: function() { 
                              //alert(json.content);
                              if (json.rid != 6) {
                                  $.alert(json.content, function () {
                                      window.location.href = "{:U('Wx/Vote/turntablelog')}";
                                  })
                              } else {
                                  alert(json.content)
                              }
                              
                              bRotate = !bRotate;
                          } 
                      }); 
                    }else if(json.status==0){
                      alert(json.content);
                    }
                      
                  } 
              }); 
        });
    });
    function rnd(n, m){
        return Math.floor(Math.random()*(m-n+1)+n)
    }
</script>
<div class="hk_box">
        <div class="hk_a">
             <a href="{:U('Wx/Vote/turntable')}" class="hk_cut">大转盘抽奖</a>
             <a href="{:U('Wx/Vote/index')}">抽奖结果</a>
        </div>
        <div class="hk_b"><img src="__IMG__/tp_a2.png"></div>
        
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
                      <eq name="vo['rank']" value="5">五等奖</eq>：  {$vo.prize}</p>
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
