<include file="public:head" />
<body class="back-f1f1f1">
<div class="container padding_0">
   <div class="land">
                <div class="act_g pr">
                    <div class="act_g1"><img src="{$data.thumb}"></div>
                    <div class="history pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.png"></a><span>&nbsp;</span></div>
                    <div class="recom_c pa"><div class="recom_gg collect <if condition='$data.iscollect eq 1'>recom_c_cut</if> "  data-id="{$data.id}"></div>
                                            <span><a href=""><img src="__IMG__/share.png"></a></span>
                                            <span><a href=""><img src="__IMG__/recom_a3.png"></a></span>
                    </div>
                    <div class="act_g2 f16 center pa">
                            <em>￥</em><span>{$data.money}</span><em>起</em>
                    </div>
               </div>  

               
               <div class="det_box">
                       <div class="act_k">
                            <div class="act_k1 vertical">{$data.title}</div>
                            <div class="act_k2 vertical hit" data-id="{$data.id}" >
                                <if condition='$data.ishit eq 1'>
                                  <img src="__IMG__/poin_1.png">
                                <else/>
                                  <img src="__IMG__/poin.png">
                                </if>
                                {$data.hit}
                            </div>
                       </div>
                       
                       <div class="edg">
                           <div class="edg_a fl">
                                      <div class="edg_b">{$data.evaluation}<span>分</span></div>
                                      <div class="edg_c">
                                          <span><img src="__IMG__/star.png"></span>
                                          <span><img src="__IMG__/star.png"></span>
                                          <span><img src="__IMG__/star.png"></span>
                                          <span><img src="__IMG__/star.png"></span>
                                          <span><img src="__IMG__/star.png"></span>
                                      </div>
                           </div>
                           <a href="homestay-2.html"><div class="edg_d fr">
                               <img src="__IMG__/edg_a1.jpg"> {$data.reviewnum}条评论 <span><img src="__IMG__/arrow.jpg"></span>
                           </div></a>
                       </div>
                       
                       <div class="vb_a">
                            <div class="land_font pr">
                                <span>地址:</span> {$data.address}
                                <div class="vb_a1 pa">
                                      <img src="__IMG__/add_e.png">距你  5.6km
                                </div>        
                            </div> 
                            
                            <div class="vb_b"><img src="__IMG__/map_2.jpg"></div>
                       </div>
                       
 
               </div>
               
               <div class="snake">
                    <div class="vb_c1 snake_a center">我们的房间</div>
                        <volist name='data["room"]' id='vo'>
                            <a href="{:U('Web/Hostel/room',array('id'=>$vo['rid'],'hid'=>$data['id']))}">
                                <div class="snake_list f14">
                                       <div class="land_d pr f0">
                                            <div class="land_e vertical"><img src="{$vo.thumb}"></div>
                                            <div class="land_f vertical">
                                                  <div class="land_f1 f16">{$vo.title}</div>
                                                  <div class="land_f2 f13">{$data.area}M<sup>2</sup> {$vo.bedtype}</div>
                                                  <div class="land_f3 pa f0">
                                                        <div class="land_money f20"><em>￥</em> {$vo.money}
                                                                                     <span>起</span>
                                                        </div>
                                                  </div>
                                            </div>
                                       </div>
                                </div>
                            </a>
                        </volist>
                        
                        <div class="scr_d snake_b center">显示全部{$roomcount}个房间<img src="__IMG__/drop_f.jpg"></div> 
               </div>
               
               <div class="vb_d center">
                    <div class="land_a center">
                            <div class="land_a1 snake_c"><a href="homestay-1.html"><img src="__IMG__/land_a.png"></a></div>
                            <div class="land_a2 home_d1 margin_05 f16">蔡小亮</div>
                            <div class="home_d2 margin_05">
                                  <div class="home_d3 vertical mr_4"><img src="__IMG__/home_a1.png">实名认证</div>
                            </div>                  
                    </div>
                    <div class="vb_d1"><a href=""><img src="__IMG__/vb_a.jpg">在线咨询</a></div> 
                    <div style="height:1rem"></div>
               </div>
               
               <div class="vb_c ">
                    <div class="vb_c1 center">民宿描述</div>
                    <div class="vb_c2">
                            {$data.description}
                    </div>
                    <div class="vb_c3 snake_click"><a href="javascript:;">查看完整民宿描述</a></div>
               </div>
               
               <div class="vb_c" style="padding-bottom:0;">
                    <div class="vb_c1 center">配套设施</div>
                    <div class="snake_btm">
                        <foreach name="roomcate" item="vo" key="k" >
                            <div class="snake_e">
                                <volist name='vo' id='svo'>
                                    <div class="snake_e1"><img src="{$svo.thumb}">{$svo.catname}</div>
                                </volist>
                                
                            </div>
                        </foreach>
                    </div>
               </div>
               
               <div class="snake_m ">
                    <div class="vb_c1 center snake_kl" style="margin:0 2.5%;">退订规则</div>
                    {$data.content}
                    <div class="snake_small">该规则由房东制定</div>
               </div>
               
               <div class="mth pr">
                   <div class="mth_top pa">附近活动推荐</div>
                   <div id="mth_dom" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
               
               <div class="mth pr" style="margin-top:20px;">
                   <div class="mth_top pa">附近民宿推荐</div>
                   <div id="dom-effect" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
     
              
   </div>   
</div>


<div class="big_mask"></div>
<div class="pyl">
    <div class="pyl_top pr">房间简介
        <div class="pyl_close pa"><img src="__IMG__/close.jpg"></div>
    </div>
    <div class="pyl_font">
        <foreach name="data['imglist']" item="vo" key="k" >
            <img src="{$vo}">
        </foreach>
         <div class="snail_d homen_style center f16" >
                <a href="javescript:;" class="common_click" style="width:100%">我知道了</a>
         </div>
    </div>
    
    

</div>

<script type="text/javascript">
  $(function(){
    collect();
    hit();
  })
    function collect(){
        // 收藏
        $('.collect').click(function(){
          var self=$(this);
          var id=self.data('id');
          var data={'type':2,'id':id};
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
        })
    }

    function hit(){
        // 收藏
        $('.hit').click(function(){
          var self=$(this);
          var id=self.data('id');
          var data={'type':2,'id':id};
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
        })
    }
</script>
<include file="public:Recommend" />


</body>

</html>