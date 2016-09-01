<include file="public:head" />
<body class="back-f1f1f1">
<div class="header center z-index112 pr f18">
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
      <div class="tra_pr hd_ck pa">
        <em>
          <if condition='$data["iscollect"] eq 1'>
            <img src="__IMG__/hj_a1_1.jpg" class='collect'>
          <else/>
            <img src="__IMG__/hj_a1.jpg" class='collect'>
          </if>
        </em>
        <em><img src="__IMG__/hj_a2.jpg"></em>
        <em><img src="__IMG__/hj_a3.jpg"></em>
      </div>
</div>
<div class="container padding_0">
   <div class="land">
               <div class="lpl_top">
                      <div class="lpl_title">
                           <div class="lpl_a">{$data.title}</div>
                           <div class="lpl_b f0">
                                 <div class="lpl_b1 vertical"><img src="{$data.head}">{$data.nickname}</div>
                                 <div class="lpl_b2 vertical"><em>发表于：</em>{$data.inputtime|date='Y-m-d',###}
                                       <span class='certical'>
                                            <if condition='$data.ishit eq 1'>
                                              <img src="__IMG__/poin_1.png"> 
                                            <else/>
                                              <img src="__IMG__/poin.png"> 
                                            </if>
                                          <span id='vcount'>{$data.hit}</span>
                                      </span>
                                 </div>
                           </div>
                      </div>
              
                      <div class="lpl_c">
                            <div class="lpl_c1"><span><img src="__IMG__/gh_a2.jpg">出发时间 </span><em>{$data.begintime|date='Y-m-d',###}</em></div>
                            <div class="lpl_c1"><span><img src="__IMG__/gh_a1.jpg">人均费用 </span><em>{$data.fee}</em></div>
                            <div class="lpl_c1"><span><img src="__IMG__/gh_a3.jpg">人物 </span><em>{$data.nmame}</em></div>
                            <div class="lpl_c1"><span><img src="__IMG__/gh_a4.jpg">出行天数 </span><em>{$data.days}</em></div>
                            <div class="lpl_c1"><span><img src="__IMG__/gh_a5.jpg">形式 </span><em>{$data.dname}</em></div>
                            <div class="clearfix"></div>
                      </div>
                      
                      <div class="lpl_d">
                        <volist name="data['imglist']" id="vo">
                            {$vo.content}
                            <div class="lpl_d2"><img src="{$vo.thumb}"></div>
                        </volist>   
                      </div>
                      
                      <div class="lpl_e">
                           <div class="lpl_f">
                                   <div class="lpl_e1">文中出现过的民宿 :</div>
                                   <div class="lpl_e2">
                                        <span>君越</span>
                                        <span>儒家</span>
                                        <span>西湖森林客栈</span>
                                        <span>凯啼猫客栈</span>
                                   </div> 
                           </div>
                           <div class="lpl_f">       
                                   <div class="lpl_e1">文中出现过的景点 :</div>
                                   <div class="lpl_e2">
                                        <span>西湖</span>
                                        <span>太湖</span>
                                        <span>杭州灵隐寺</span>
                                   </div>
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
                                 <volist name='comment' id='vp'>
                                    <div class="fans_list">
                                        <div class="per_tx fl"><img src="{$vp.head}"></div>
                                        <div class="fans_b per_tr fl">
                                            <div class="fans_b1 f16">{$vp.nickname}</div> 
                                            <div class="fans_b2 f14">{$vp.content}</div> 
                                            <div class="fans_time f13">{$vp.inputtime|date='Y-m-d',###}</div>
                                        </div>
                                    </div>
                                 </volist>
                            </div>
            
                            <div class="trip_t">
                                  <input type="text" placeholder="发布我的评论 ..." class="trip_text fl">
                                  <input type="button" value="90+ 评论" class="trip_button fr" 
                                       onclick="location.href='{:U('Web/Review/index',array('type'=>0,'id'=>$id))}'">
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
               
               <div class="mth_c">
                   <div class="lpl_f">       
                                       <div class="lpl_e1">已选 :</div>
                                       <div class="lpl_e2">
                                            <span>君悦</span>
                                            <span>儒家</span>
                                            <span>西湖森林客栈</span>
                                       </div>
                   </div>
               </div>
               <div class="snail_d center trip_btn f16" style="margin:0rem">
                            <a href="person-3.html" class="snail_cut">添加到行程</a>
               </div>     
   </div>   
</div>
<include file="public:Recommend" />
<script type="text/javascript">
  $(function(){
    // 收藏
    var id=$('#getid').val();
    $('.collect').click(function(){
      var data={'type':0,'id':id};
      console.log(data);
      $.post("{:U('Web/Ajaxapi/collection')}",data,function(res){
        console.log(res);
        if(res.code==200)
        {
          $('.collect').attr('src','__IMG__/hj_a1_1.jpg');
        }
        else if(res.code==300){
          $('.collect').attr('src','__IMG__/hj_a1.jpg');
        }
        else{
          alert(res.msg);
        }
      });
    })
    // 点赞 vertical
    $('.certical').click(function(){
      var data={'type':0,'id':id};
      var hit=$('#vcount').text();
      console.log(data);
      $.post("{:U('Web/Ajaxapi/hit')}",data,function(res){
        console.log(res);
        if(res.code==200)
        {
          $('#vcount').text(Number(hit)+1)// $('.collect').addClass('recom_c_cut');
          $('.certical').find('img').attr('src','__IMG__/poin_1.png');
        }
        else if(res.code==300){
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
</body>

</html>