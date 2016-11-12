<include file="public:head" />
<body class="back-f1f1f1">
    <div class="container padding_0">
        <div class="land">
          <div class="act_g pr">
              <div class="act_g1">
                  <img src="{$data.thumb}">
              </div>
              <div class="history pa">
                  <a href="javascript:history.go(-1);" style="display:block;">
                      <img src="__IMG__/go.png">
                  </a><span>&nbsp;</span>
              </div>
              <div class="recom_c pa">
                  <div class="recom_gg collect <if condition='$data.iscollect eq 1'>recom_c_cut</if>"
                  data-id="{$data.rid}"></div>
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
                  <div class="act_k2 vertical hit" data-id="{$data.rid}">
                      <if condition='$data.ishit eq 1'>
                          <img src="__IMG__/poin_1.png">
                          <else/>
                          <img src="__IMG__/poin.png">
                      </if>
                      <span class="vcount">{$data.hit}</span>
                  </div>
              </div>

              <div class="edg">
                  <div class="edg_a fl">
                      <div class="edg_b">8.8<span>分</span>
                      </div>
                      <div class="edg_c">
                          <span><img src="__IMG__/star.png"></span>
                          <span><img src="__IMG__/star.png"></span>
                          <span><img src="__IMG__/star.png"></span>
                          <span><img src="__IMG__/star.png"></span>
                          <span><img src="__IMG__/star.png"></span>
                      </div>
                  </div>
                  <a href="homestay-2.html">
                      <div class="edg_d fr">
                          <img src="__IMG__/edg_a1.jpg">{$data.reviewnum}条评论 <span><img src="__IMG__/arrow.jpg"></span>
                      </div>
                  </a>
              </div>

              <div class="wx_box">
                  <div class="wx_top">
                      <div class="wx_list">
                          <div class="wx_a">
                              <div class="wx_b vertical">
                                  <img src="__IMG__/wx_a9.jpg">建筑面积 :</div>
                              <div class="wx_c vertical">{$data.area}m²</div>
                          </div>

                          <div class="wx_a">
                              <div class="wx_b vertical">
                                  <img src="__IMG__/wx_a10.jpg">房间数：</div>
                              <div class="wx_c vertical">{$data.mannum}间</div>
                          </div>
                      </div>
                      
                      <volist name='data["support"]' id='vo'>
                          <div class="wx_list">
                              <volist name='vo' id='svo'>
                                  <div class="wx_a">
                                      <div class="wx_b vertical">
                                          <img src="{$svo.gray_thumb}">
                                      </div>
                                      <div class="wx_c vertical">{$svo.catname}</div>
                                  </div>
                              </volist>
                          </div>
                      </volist>
                  </div>
                  <div class="wx_btm">
                      <div class="wx_list">
                          <div class="wx_d">便利设施 :</div>
                          <div class="wx_e">{$data.conveniences}</div>
                      </div>

                      <div class="wx_list">
                          <div class="wx_d">浴室 :</div>
                          <div class="wx_e">{$data.bathroom}</div>
                      </div>

                      <div class="wx_list">
                          <div class="wx_d">媒体科技 :</div>
                          <div class="wx_e">{$data.media}</div>
                      </div>

                      <div class="wx_list" style="border-bottom:0;">
                          <div class="wx_d">食品饮品 :</div>
                          <div class="wx_e">{$data.food}</div>
                      </div>
                  </div>

              </div>
          </div>



          <div class="vb_c ">
              <div class="vb_c1 center">房间简介</div>
              <div class="vb_c2">
                  <p>{$data.content}</p>
              </div>
              <div class="vb_c3 snake_click"><a href="javascript:;">查看完整美宿房间简介</a>
              </div>
          </div>
          <div class="vb_c ">
            <div class="vb_c1 center">可约日期</div>
            <div id="time_choose_box">
               <include file="Public:calendar" />
            </div>
            <br>
            <div class="act_href center" style="margin:0;">
                <a href="{:U('Web/Order/bookroom',array('id'=>$data['rid'],'hid'=>$hid))}">我要预定</a>
            </div>
          </div>
        </div>
        <div class="big_mask"></div>
        <div class="pyl">
            <div class="pyl_top pr">房间简介
                <div class="pyl_close pa">
                    <img src="__IMG__/close.jpg">
                </div>
            </div>
            <div class="pyl_font" style="height:85%;-webkit-overflow-scrolling:touch;overflow:auto">
                <iframe style="overflow:scroll;width:100%;height:auto;border:0;" src="{:U('Web/Room/app_show')}?id={$data.rid}" scrolling="no">
                </iframe>
                <div class="snail_d homen_style center f16">
                    <a href="javescript:;" class="common_click" style="width:100%">我知道了</a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(function()
            {
                collect();
                hit();
            })

            function collect()
            {
                // 收藏
                $('.collect').click(function()
                {
                    var self = $(this);
                    var id = self.data('id');
                    var data = {
                        'type': 3,
                        'id': id
                    };
                    console.log(data);
                    $.post("{:U('Web/Ajaxapi/collection')}", data,
                        function(res)
                        {
                            console.log(res);
                            if (res.code == 200)
                            {
                                self.addClass('recom_c_cut');
                            }
                            else if (res.code == 300)
                            {
                                self.removeClass(
                                    'recom_c_cut');
                            }
                            else
                            {
                                alert(res.msg);
                            }
                        });
                })
            }

            function hit()
            {
                // 收藏
                $('.hit').click(function()
                {
                    var self = $(this);
                    var id = self.data('id');
                    var data = {
                        'type': 4,
                        'id': id
                    };
                    var hit = self.text();
                    console.log(data);
                    $.post("{:U('Web/Ajaxapi/hit')}", data,
                        function(res)
                        {
                            console.log(res);
                            if (res.code == 200)
                            {
                                self.find('span').text(Number(
                                    hit) + 1)
                                self.find('img').attr('src',
                                    '__IMG__/poin_1.png');
                            }
                            else if (res.code == 300)
                            {
                                self.find('span').text(Number(
                                    hit) - 1)
                                self.find('img').attr('src',
                                    '__IMG__/poin.png');
                            }
                            else
                            {
                                alert(res.msg);
                            }
                        });
                })
            }
        </script>
</body>
<script>
  
</script>
</html>
