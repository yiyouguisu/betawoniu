<include file="Public:head" />
<body>
<div class="header center pr f18">
      蜗牛客
      <div class="address f14 pa"><a href="search-3.html">城市<img src="__IMG__/address.png"></a></div>
</div>

<div class="container">
    <div id="slideBox" class="slideBox">
        <div class="bd">
                  <ul>
                      <!-- <li><a class="pic" href="login.html"><img src="__IMG__/banner.jpg" /></a></li> -->
                      <volist name='Advertisement' id='vo'>
                          <li><a class="pic" href="#"><img src="{$vo.image}" /></a></li>
                      </volist>
                  </ul>
        </div>

        <div class="hd">
              <ul></ul>
        </div>
    </div>   

    <div class="land_c">
         <div class="search_box">
              <input type="text" class="search_text" placeholder="输入目的地、景点、民宿等关键词...">
              <input type="button" class="search_btn">
         </div>
         <!-- <button class='btn'>test</button> -->
         <div class="nav center">
             <a href="{:U('Web/Travel/index')}"><img src="__IMG__/tb_a1.png"> 游记</a>
             <a href="{:U('Web/Party/index')}"><img src="__IMG__/tb_a2.png"> 活动</a>
             <a href="{:U('Web/Hostel/index')}"><img src="__IMG__/tb_a3.png"> 民宿</a>
         </div>     
    </div>

    <div class="recom  recom_ppt">
               <div class="recom_title f18 center">推荐游记</div>
                <volist name='notedate' id='vo'>
                  <div class="recom_list pr">
                    <div class="recom_a pr">
                      <a href="{:U('Web/Travel/show',array('id'=>$vo['id']))}">
                        <img src="{$vo.thumb}">
                      </a>
                      <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}"><div class="recom_d pa"><img src="{$vo.head}"></div></a>
                    </div>
                    <div class="recom_b pa"><img src="__IMG__/recom_a1.png"></div>
                    <div class="recom_c pa"><div class="recom_gg tcollect <if condition='$vo.iscollect eq 1'>recom_c_cut</if>" data-id="{$vo.id}"></div></div>

                    <div class="recom_e">
                      <div class="land_f1 recom_e1 f16">{$vo.title}</div>
                      <div class="recom_f">
                        <div class="recom_f1 f12 fl">{$vo.inputtime|date='Y-m-d',###}</div>
                        <div class="recom_f2 fr">
                          <div class="land_h recom_f3 vertical">
                            <div class="land_h2 f12 vertical thit" data-id="{$vo.id}">
                              <if condition='$vo.ishit eq 1'>
                                <img src="__IMG__/poin_1.png">
                              <else/>
                                <img src="__IMG__/poin.png">
                              </if>
                              <span class="vcount">{$vo.hit}</span>
                            </div>
                            <div class="land_h1 f12 vertical">
                              <img src="__IMG__/land_d3.png">
                              <span>{$vo.value}</span>条评论 
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </volist>
    </div>

    <div class="recom">
             <div class="recom_title f18 center" style="color:#56c3cf">推荐活动</div>
             <volist name='party' id='vo'>
                <div class="recom_list pr">
                     <div class="recom_a pr">
                           <a href="{:U('Web/Party/show',array('id'=>$vo['id']))}"><img src="{$vo.thumb}"></a>
                           <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}"><div class="recom_d pa"><img src="{$vo.head}"></div></a>
                     </div>
                     <div class="recom_c pa"><div class="recom_gg pcollect <if condition='$vo.iscollect eq 1'>recom_c_cut</if>" data-id="{$vo.id}"></div></div>
             
                    <div class="recom_e">
                           <div class="land_f1 recom_e1 f16">{$vo.title}</div>
                           <div class="recom_k">
                                    <div class="land_font">
                                        <span>时间:</span> {$vo.starttime|date='Y-m-d',###} 至{$vo.endtime|date='Y-m-d',###}       
                                    </div> 
                                    <div class="land_font">
                                        <span>地点:</span> {$vo.address}        
                                    </div> 
                          </div>
                          <div class="recom_s f14">
                              已参与：
                              <span>
                                <volist name='vo["joinlist"]' id='svo'>
                                  <img src="{$svo.head}">
                                </volist>
                              </span>
                              <em>(..{$vo.joinnum|default ='0'}人)</em>
                          </div>
                    </div>
                </div>
             </volist> 
    </div> 

    <div class="recom">
               <div class="recom_title f18 center" style="color:#ff715f">推荐民宿</div>
               <volist name='hotel' id='vo'>
                  <div class="recom_list pr">
                         <div class="recom_a pr">
                              <a href="{:U('Web/Hostel/show',array('id'=>$vo['id']))}"><img src="{$vo.thumb}"></a>
                               <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}"><div class="recom_d pa"><img src="{$vo.head}"></div></a>
                               <div class="recom_g f18 center pa">
                                   <div class="recom_g1 fl"><em>￥</em>{$vo.money}<span>起</span></div>
                                   <div class="recom_g2 fl">{$co.evaluation}<span>分</span></div>
                               </div>
                         </div>
                         <div class="recom_c pa"><div class="recom_gg hcollect <if condition='$vo.iscollect eq 1'>recom_c_cut</if>" data-id="{$vo.id}"></div></div>
                        <div class="recom_e">
                               <div class="land_f1 recom_e1 f16">{$vo.title}</div>
                               <div class="recom_f">
                                <div class="recom_f1 recom_hong f12 fl"><img src="__IMG__/add_e.png">距你  {$vo.distance}km</div>
                                    <div class="recom_f2 fr">
                                        <div class="land_h recom_f3 vertical">
                                              <div class="land_h2 f12 vertical hhit" data-id="{$vo.id}">
                                                <if condition='$vo.ishit eq 1'>
                                                  <img src="__IMG__/poin_1.png">
                                                <else/>
                                                  <img src="__IMG__/poin.png">
                                                </if>
                                                <span class="vcount">{$vo.hit}</span>
                                              </div>
                                              <div class="land_h1 f12 vertical">
                                                    <img src="__IMG__/land_d3.png">
                                                    <span>{$vo.reviewnum}</span>条评论
                                              </div>
                                          </div>
                                    </div>
                               </div>
                        </div>
                    </div>

               </volist>
    </div>
    <div style="height:8rem"></div>   
    
</div>


<include file="Public:foot" />

<script type="text/javascript">
        TouchSlide({ 
          slideCell:"#slideBox",
          titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
          mainCell:".bd ul", 
          effect:"leftLoop", 
          autoPage:true,//自动分页
          autoPlay:true //自动播放
        });
</script>
<script>
getLocation();
function getLocation(){
  if (navigator.geolocation){
    navigator.geolocation.getCurrentPosition(showPosition);
  }
  else{
    console.log("该浏览器不支持获取地理位置。");
  }
}
function showPosition(position){
  console.log(position.coords.longitude);
  console.log(position.coords.latitude);
  // 经度
  // alert(position.coords.longitude);
  // // 纬度
  // alert(position.coords.latitude);
  var data={'ad':position.coords.longitude+','+position.coords.latitude};
  $.post("{:U('Web/Index/latitude_longitude')}",data,function(res){
    // alert(res);
  });
//   x.innerHTML="纬度: " + position.coords.latitude + 
//   "<br>经度: " +  position.coords.longitude;
}
// $('.btn').click(function(){
//   var data={'ad':'121.420159,31.231738'};
//   $.post("{:U('Web/Index/latitude_longitude')}",data,function(res){
//     alert(res);
//   });
// })
$(function(){
  // 游记点赞、收藏
  var thit=$('.thit');
  thit.click(function(){
    hit($(this),0);
  });
  var tcollect=$('.tcollect');
  tcollect.click(function(){
    collect($(this),0);
  });
  // 活动收藏
  var pcollect=$('.pcollect');
  pcollect.click(function(){
    collect($(this),0);
  });
  // 名宿点赞、收藏
  var hhit=$('.hhit');
  var hcollect=$('.hcollect');
  hhit.click(function(){
    hit($(this),2);
  });
  hcollect.click(function(){
    collect($(this),2);
  });
});


function hit(obj,type){
    // 收藏
    var self=obj;
    var id=self.data('id');
    var data={'type':type,'id':id};
    var hit=self.text();
    console.log(data);
    $.post("{:U('Web/Ajaxapi/hit')}",data,function(res){
      console.log(res);
      if(res.code==200)
      {
          self.find('span').text(Number(hit)+1)
          self.find('img').attr('src','__IMG__/poin_1.png');
      }
      else if(res.code==300){
          self.find('span').text(Number(hit)-1)
          self.find('img').attr('src','__IMG__/poin.png');
      }
      else{
        alert(res.msg);
      }
    });
}
function collect(obj,type){
    // 收藏
    var self=obj;
    var id=self.data('id');
    var data={'type':type,'id':id};
    console.log(data);
    $.post("{:U('Web/Ajaxapi/collection')}",data,function(res){
      console.log(res);
      if(res.code==200)
      {
        self.addClass('recom_c_cut');
      }
      else if(res.code==300){
        self.removeClass('recom_c_cut');
      }
      else{
        alert(res.msg);
      }
    }); 
}

</script>
</body>
</html>