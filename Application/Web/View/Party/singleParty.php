<include file="public:head" />
<body class="back-f1f1f1">

<div class="container padding_0">
   <div class="land">
<!--                <div class="act_g pr">
                    <div class="act_g1"><img src="{$data.thumb}"></div>
                    <div class="recom_c pa"><div class="recom_gg collect <if condition='$data.iscollect eq 1'>recom_c_cut</if> "></div>
                                            <span><a href-""><img src="__IMG__/recom_a3.png"></a></span>
                    </div>
                    <div class="act_g2 f16 center pa">
                            报名费：<em>￥</em><span>{$data.money|default="0.00"}/ 人</span>
                    </div>
               </div>  
               
               <div class="det_box">
                       <div class="act_k">
                            <div class="act_k1 vertical">{$data.title}</div>
                            <div class="act_k2 certical">
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
                                <span>时间:</span> {$data.starttime|date="Y-m-d",###} 至{$data.endtime|date="Y-m-d",###}       
                            </div> 
                            <div class="land_font">
                                <span>地点:</span> {$data.address}      
                            </div> 
                            <div class="land_font pr">
                                <span>人数:</span> 限定{$data.start_numlimit|default='0'}-{$data.end_numlimit|default='0'}人
                                <div class="vb_a1 pa">
                                      <img src="__IMG__/add_e.png">距你  5.6km
                                </div>        
                            </div> 
                            
                            <div class="vb_b"><img src="__IMG__/map_2.jpg"></div>
                            <div class="recom_s f14">
                                  已参与：
                                  <span>
                                      <volist name='data["joinlist"]' id="svo">
                                        <img src="{$svo.head}">
                                      </volist>
                                  </span>
                                  <em>(..{$data.joinnum}人)</em>
                            </div>
                       </div>
                       
 
               </div> -->
               
               <div class="vb_c ">
                    <div class="vb_c1 center">活动简介</div>
                    {$data.content}
               </div>
               
<!--                <div class="vb_d center">
                    <div class="vb_c1 ">活动发起人</div>
                    <div class="land_a center">
                            <div class="land_a1"><img src="{$data.head}"></div>
                            <div class="land_a2 home_d1 margin_05 f16">{$data.nickname}</div>
                            <div class="home_d2 margin_05">
                                  <div class="home_d3 vertical mr_4"><img src="__IMG__/home_a1.png">实名认证</div>
                            </div>                  
                    </div>
                    <div class="vb_d1"><a href=""><img src="__IMG__/vb_a.jpg">在线咨询</a></div> 
               </div>
                  
               <div class="lpl_conments">
                    <div class="trip_f">
                            <div class="trip_f1">评论区
                 <div class="trip_f2">
                        <img src="__IMG__/land_d3.png">
                        <span>{$data.reviewnum}</span>条评论
                 </div>
            </div>
                            <div class="trip_fBtm">
                                 <volist name="data['reviewlist']" id='vo'>
                                    <div class="fans_list">
                                        <div class="per_tx fl"><img src="{$vo.head}"></div>
                                        <div class="fans_b per_tr fl">
                                            <div class="fans_b1 f16">{$vo.nickname}</div> 
                                            <div class="fans_b2 f14">{$vo.content}</div> 
                                            <div class="fans_time f13">{$vo.inputtime|date='Y-m-d',###}</div>
                                        </div>
                                    </div> 
                                 </volist>
                            </div>
            
                            <div class="trip_t">
                                  <input type="text" placeholder="发布我的评论 ..." class="trip_text fl">
                                  <input type="button" value="90+ 评论" class="trip_button fr" 
                                       onclick="location.href='{:U('Web/Review/index',array('type'=>1,'id'=>$id))}'">
                            </div>
                     </div>
               </div>
               
               <div class="mth pr">
                   <div class="mth_top pa">附近民宿推荐</div>
                   <div id="dom-effect" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
               
               <div class="mth pr" style="margin-top:20px;">
                   <div class="mth_top pa">附近活动推荐</div>
                   <div id="mth_dom" class="iSlider-effect"></div>
                   <div class="mth_a center">
                              <span><a href="">查看更多</a></span>
                              <div class="mth_a2"></div>
                    </div>
               </div>
     
               <div style="height:2rem"></div>  
               <div class="snail_d center trip_btn f16" style="margin:2rem 0 0">
                            <a href="{:U('Web/Party/enroll',array('id'=>$id))}" class="snail_cut">我要报名</a>
               </div>   
 -->   </div>   
</div>
<script type="text/javascript">
  $(function(){
    // 收藏
    $('.collect').click(function(){
      var id={$id};
      var data={'type':1,'id':id};
      console.log(data);
      $.post("{:U('Web/Ajaxapi/collection')}",data,function(res){
        console.log(res);
        if(res.code==200)
        {
          $('.collect').addClass('recom_c_cut');
        }
        else if(res.code==300){
          $('.collect').removeClass('recom_c_cut');
        }
        else{
          alert(res.msg);
        }
      });
    })
    // 点赞 vertical
    $('.certical').click(function(){
      var id={$id};
      var data={'type':1,'id':id};
      $.post("{:U('Web/Ajaxapi/hit')}",data,function(res){
        console.log(res);
        if(res.code==200)
        {
          var hit=$('#vcount').text();
          $('#vcount').text(Number(hit)+1)// $('.collect').addClass('recom_c_cut');
          $('.certical').find('img').attr('src','__IMG__/poin_1.png');
        }
        else if(res.code==300){
          var hit=$('#vcount').text();
          $('#vcount').text(Number(hit)-1)// $('.collect').addClass('recom_c_cut');
          $('.certical').find('img').attr('src','__IMG__/poin.png');
        }
        else{
          alert(res.msg);
        }
      });
    })

  })
</script>

<include file="public:Recommend" />

</body>

</html>