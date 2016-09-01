<include file="public:head" />

<body>
<div class="header center z-index112 pr f18">
      活动
      <div class="head_go pa"><a href="javascript:history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
      <div class="tra_pr pa"><i></i><a href="search-2.html"><img src="__IMG__/search.jpg"></a></div>
</div>

<div class="container">
   <div class="land">
          <div class="tra_list pr z-index112 center f14">
                <div class="tra_li tra_li_on">按特色</div>
                <div class="tra_drop">
                    <div class="act_pad">
                        <div class="dress_box">
                             <div class="dress_b act_a moch_click center f14">
                                 <ul>
                                    <volist name='partycate' id='vo'>
                                      <li class="partycate" data-id='{$vo.id}'>{$vo.catname}</li>
                                    </volist>
                                 </ul>
                             </div>
                       </div>
                    </div>
                </div>
                
                <div class="tra_li tra_li_on">按时间</div>
                <div class="tra_drop">
                    <img src="__IMG__/dt_a.jpg">
                </div>
                <div class="tra_li tra_li_on">按位置</div>
                <div class="tra_drop">
                    <div class="tra_dropA_box">
                         <div class="tra_dropA">
                            <select id='area'>
                                <option value='0'>---请选择-</option>
                                <foreach name="areaArray" item="vo">
                                    <option value="{$vo.id}">{$vo.name}</option>
                                </foreach>
                            </select>
                         </div>
                         <div class="tra_dropA">
                            <select id='city'>
                                <option value='0'>---请选择-</option>
                            </select>
                         </div>
                         <div class="tra_dropA">
                            <select id='county'>
                                <option value='0'>---请选择-</option>
                            </select>
                         </div>
                     </div>
                </div>
                <div class="tra_li tra_li_on">筛选</div>
                <div class="tra_drop">
                    <div class="act_scring">
                        <div class="scr_top">
                              <div class="scr_e1" style="margin-bottom:2rem;">活动费用</div> 
                              <div class="scr_b" style="margin-bottom:2rem;">
                                   <div id="slider-range"></div>
                                   <div class="number">
                                       <div class="number_a fl">￥0</div>
                                       <div class="number_b fr">￥5000</div>
                                   </div>
                              </div>
                              <div class="scr_c"></div> 
                              <div class="scr_d center gratis">免费活动</div> 
                        </div> 
                        <div class="scr_btm">
                             <div class="dress_box">
                                     <div class="scr_e1">按类型 :</div>
                                     <div class="dress_b act_a moch_click center f14">
                                         <ul>
                                             <li class='partytype'>不限</li>
                                             <li class='partytype'>亲子类</li>
                                             <li class='partytype'>情侣类</li>
                                             <li class='partytype'>家庭出游</li>
                                         </ul>
                                     </div>
                                     <div class="snail_d scr_e2 center f16">
                                            <a class='clear' class="mr_4">清除筛选</a>
                                            <a class="sub snail_cut">确定</a>
                                      </div>
                              </div> 
                        </div>        
                    </div>
                </div>
          </div>

          <div class="land_btm">
                <volist name='party' id='vo'>
                  <div class="recom_list pr">
                     <div class="recom_a pr">
                           <a href="{:U('Web/Party/show',array('id'=>$vo['id']))}"><img src="{$vo.thumb}"></a>
                           <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}"><div class="recom_d pa"><img src="{$vo.head}"></div></a>
                     </div>
                     <div class="recom_c pa"><div class="recom_gg collect <if condition='$vo.iscollect eq 1'>recom_c_cut</if>" data-id="{$vo.id}"></div></div>
                     <div class="recom_e">
                           <div class="land_f1 recom_e1 f16">{$vo.title}</div>
                           <div class="recom_k">
                                    <div class="land_font">
                                        <span>时间:</span> {$vo.starttime|date='Y-m-d',###} 至{$vo.endtime|date='Y-m-d',###}      
                                    </div> 
                                    <div class="land_font">
                                        <span>地点:</span>{$vo.address}      
                                    </div> 
                          </div>
                          <div class="recom_s f16">
                              已参与：
                              <span id="sapn">
                                  <foreach name="vo['joinhead']" item="svo" key="k">
                                      <img src='{$svo.head}'>
                                  </foreach>
                              </span>
                              <em>({$vo.joinnum|default="0"}人)</em>
                          </div>
                    </div>
                 </div>
                </volist>
          </div>    

   </div>  
   <div class="mask"></div>     
</div>
<script src="__JS__/jquery-ui.min.js.js"></script>
<script>
var falg=true;
  $(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 5000,
      values: [ 75, 3000 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
      }
    });
    // $( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
    //   " - $" + $( "#slider-range" ).slider( "values", 1 ) );
  });
</script>


<script>

    var data={'partycate':'','city':'','minmoney':0,'maxmoney':0,'partytype':''};
   $(function(){
        collect();
        $(".moch_click li").click(function(){
           $(this).addClass("hm_cut").siblings().removeClass("hm_cut")
        })

        $('#area').change(function(){
            var city=$('#city');
            city.empty();
            var data={'id':$(this).val()};
            console.log(data);
            $.post("{:U('Web/Travel/ajaxcity')}",data,function(res){
                var option='<option>--请选择--</option>';
                $.each(res,function(i,value){
                    option+='<option value='+value.id+'>'+value.name+'</option>';
                });
                city.append(option);
            });
        });
        // 区域
        $('#city').change(function(){
            var county=$('#county');
            county.empty();
            var data={'id':$(this).val()};
            $.post("{:U('Web/Travel/ajaxcity')}",data,function(res){
                var option='<option>--请选择--</option>';
                $.each(res,function(i,value){
                    option+='<option value='+value.id+'>'+value.name+'</option>';
                });
                county.append(option);
            });
        });
        $('#county').change(function(){
          var area=$('#area').val()+','+$('#city').val()+','+$(this).val();
          console.log(area);
          if($('#city').val()==$(this).val()){
            area=$('#area').val()+','+$('#city').val();
          }
          data['city']=area;
          $.post("{:U('Web/Party/select')}",data,function(res){
            console.log(res);
            addlist(res);
            collect();
          })
        });
        $('.gratis').click(function(){
          falg=false;
        })
        var partytype=0;
        $('.partytype').click(function(){
          partytype=$(this).index();
        })
        $('.sub').click(function(){
          if(falg){
            data['minmoney']=$( "#slider-range" ).slider( "values", 0 );
            data['maxmoney']=$( "#slider-range" ).slider( "values", 1 );
          }
          else{
            data['minmoney']=0;
            data['maxmoney']=0;
          }
          data['partytype']=partytype
          console.log(data);
          $.post("{:U('Web/Party/select')}",data,function(res){
            console.log(res);
            addlist(res);
            collect();
          })
          
        });
        $('.partycate').click(function(){
          data['partycate']=$(this).data('id');
          $.post("{:U('Web/Party/select')}",data,function(res){
            console.log(res);
            addlist(res);
            collect();
          })
        });  
   })
  function collect(){
    // 收藏
    $('.collect').click(function(){
      var self=$(this);
      var id=self.data('id');
      var data={'type':1,'id':id};
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
  function addlist(data){
    $('.land_btm').empty();
    // 添加内容
    if(data.code==200){
      var content='';
      $.each(data.data,function(i,value){
          var url="{:U('Web/Party/show')}";
          url=url.substr(0,url.length-5);
          url=url+'/id/'+value.id
          var uurl="{:U('Web/Member/memberHome')}";
          console.log(uurl);
          uurl=uurl.substr(0,uurl.length-5);
          uurl=uurl+'/id/'+value.uid;

          content+='<div class="recom_list pr"><div class="recom_a pr"><a href="'+url+'"><img src="'+value.thumb+'"></a>';
          content+='<a href='+uurl+'><div class="recom_d pa"><img src='+value.head+'></a></div></div><div class="recom_c pa">';
          if(value.iscollect==1){
            content+='<div class="recom_gg collect recom_c_cut" data-id="'+value.id+'"></div></div>';
          }
          else{
            content+='<div class="recom_gg collect" data-id="'+value.id+'"></div></div>';
          }
          content+='<div class="recom_e"><div class="land_f1 recom_e1 f16">'+value.title+'</div>';
          content+='<div class="recom_k"><div class="land_font"><span>时间:</span>'+value.starttime+'至'+value.endtime+'';
          content+='</div><div class="land_font"><span>地点:</span>'+value.address+'</div></div><div class="recom_s f16">';
          content+='已参与：<span id="sapn">';
          var imglist=''
          $.each(value.joinhead,function(i,val){
            imglist+='<img src='+val.head+'>'
          });
          content+=imglist;
          content+='</span><em>('+value.joinnum+'人)</em></div></div></div>';
      });
      $('.land_btm').append(content);
    }
  }


   
  
            
            
        
  





</script>
</body>

</html>