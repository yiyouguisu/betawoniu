<include file="Public:head" />
<div class="header center z-index112 pr f18">
      游记
        <div class="head_go pa">
            <a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span>
        </div>
        <div class="tra_pr pa"><i></i><a href="search-2.html"><img src="__IMG__/search.jpg"></a></div>

</div>

<div class="container">
   <div class="land">
          <div class="tra_list pr z-index112 center f14">
                <div class="tra_li tra_li_on">按时间</div>
                <div class="tra_drop tra_nb">
                          <ul>
                              <li class="month" data-id='0'>不限</li>
                              <li class="month" data-id='1'>1月-2月</li>
                              <li class="month" data-id='2'>2月-3月</li>
                              <li class="month" data-id='3'>3月-4月</li>
                              <li class="month" data-id='4'>4月-5月</li>
                              <li class="month" data-id='5'>5月-6月</li>
                              <li class="month" data-id='6'>6月-7月</li>
                              <li class="month" data-id='7'>7月-8月</li>
                              <li class="month" data-id='8'>8月-9月</li>
                              <li class="month" data-id='9'>9月-10月</li>
                              <li class="month" data-id='10'>10月-11月</li>
                              <li class="month" data-id='11'>11月-12月</li>
                              <li class="month" data-id='12'>12月-1月</li>
                          </ul>
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
                <div class="tra_drop tra_nb">
                          <ul>
                              <li class="xuan" data-id="0" >不限</li>
                              <li class="xuan" data-id="1" >游记</li>
                          </ul>
                </div>   
                <div class="tra_li tra_li_on">排序</div>
                <div class="tra_drop tra_nb">
                          <ul>
                              <li class="order" data-id="0">不限</li>
                              <li class="order" data-id="1">最近</li>
                              <li class="order" data-id="2">评论数</li>
                          </ul>
                </div>   
          </div>

          <div class="land_btm">  
                  <div class="land_c f14">
                        <volist name='dataArray' id='vo'>
                            <a href="{:U('Web/Travel/show',array('id'=>$vo['id']))}">
                                <div class="land_d pr f0">
                                    <div class="land_e vertical"><img src="{$vo.thumb}"></div>
                                    <div class="land_f vertical">
                                        <div class="land_f1 f16">{$vo.title}</div>
                                        <div class="land_f2 f13">{$vo.begintime|date='Y-m-d',###}</div>
                                        <div class="land_f2 f13">{$vo.description}</div>
                                        <div class="land_f3 pa f0">
                                              <div class="land_f4 vertical">
                                                 <a href="{:U('Web/Member/memberHome',array('id'=>$vo['uid']))}"><img src="{$vo.head}"></a>
                                              </div>
                                              <div class="land_h tra_wc vertical">
                                                  <div class="land_h1 f11 vertical">
                                                        <img src="__IMG__/land_d3.png">
                                                        <span>{$vo.reviewnum}</span>条评论
                                                  </div>
                                                  <div class="land_h2 f11 vertical">
                                                        <img src="__IMG__/land_d4.png">
                                                        <span>{$vo.hit}</span>
                                                  </div>
                                              </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </volist>
                  </div>
          </div>    

   </div>
   <div class="tra_tb"><a href="{:U('Web/Member/publicnote')}"><img src="__IMG__/tra_tb.png"></a></div>
   
   <div class="mask"></div>     
</div>

<script>
    var data={'month':'','city':'','xuan':'','order':''};
    $(function(){
        $(".mask").click(function(){
            $(".tra_drop").hide() 
        })
        // 城市
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
        // 月份
        $('.month').click(function(){
            data.month=$(this).data('id');
            console.log(data);
            $.post("{:U('Web/Travel/select')}",data,function(res){
                addhtml(res);
                
            });
        });
        // 区域
        $('#county').change(function(){
            data.city=$('#area').val();
            console.log(data);
            $.post("{:U('Web/Travel/select')}",data,function(res){
                addhtml(res);
            });
        });
        // 筛选
        $('.xuan').click(function(){
            data.xuan=$(this).data('id');
            console.log(data);
            $.post("{:U('Web/Travel/select')}",data,function(res){
                addhtml(res);
            });
        });
        // 排序
        $('.order').click(function(){
            data.order=$(this).data('id');
            console.log(data);
            $.post("{:U('Web/Travel/select')}",data,function(res){
                addhtml(res);
            });
        });

    })
    function addhtml(data){
        console.log(data);
        var land_c=$('.land_c');
        land_c.empty();
        var content='';
        if(data.code==500){
            content+='';
        }
        else{
            $.each(data,function(i,value){
                var url="{:U('Web/Travel/show')}";
                url=url.substr(0,url.length-5);
                url=url+'/id/'+value.id;
                console.log(value.uid);
                var uurl="{:U('Web/Member/memberHome')}";
                uurl=uurl.substr(0,uurl.length-5);
                uurl=uurl+'/id/'+value.uid;
                console.log(uurl);
                content+='<a href="'+url+'"><div class="land_d pr f0"><div class="land_e vertical"><img src='+value.thumb+'></div><div class="land_f vertical"><div class="land_f1 f16">'+value.title+'</div><div class="land_f2 f13">'+value.begintime+'</div><div class="land_f3 pa f0"><div class="land_f4 vertical"><a href='+uurl+'><img src='+value.head+'></a></div><div class="land_h tra_wc vertical"><div class="land_h1 f11 vertical"><img src="__IMG__/land_d3.png"><span>'+value.reviewnum+'</span>条评论</div><div class="land_h2 f11 vertical"><img src="__IMG__/land_d4.png"><span>'+value.reviewnum+'</span></div></div></div></div></div></a>';
            });
        }
        land_c.append(content);
        $(".tra_drop").hide();
        $(".mask").hide();
    }
</script>
</body>
</html>