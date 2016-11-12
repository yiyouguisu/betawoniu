<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<script>
  $(function(){
      var dateInput = $("input.J_date")
      if (dateInput.length) {
          Wind.use('datePicker', function () {
              dateInput.datePicker();
          });
      }
  })
</script>
<include file="public:mheader" />
  <div class="wrap">
     <div class="activity_main">
         <a href="/">首页</a>
         <span>></span>
         <a href="{:U('Home/Trip/mytrip')}">我定制的行程</a>
     </div>
  </div>

   <div class="wrap">
       <div class="activity_main2 hidden">
           <div class="fl Open_stroke_a">
               <div class="Open_stroke_r_top">
                   <a href="{:U('Home/Trip/index')}">公开行程</a>
                   <a href="{:U('Home/Trip/mytrip')}" class="Open_stroke_r_topa1">我定制的行程</a>
               </div>
               <div class="Open_stroke_r_bottom">
                   <ul class="Open_stroke_r_bottom_ul">
                      <volist name="trip" id="vo">
                       <li>
                           <a href="{:U('Home/Trip/tripshow',array('id'=>$vo['id']))}">
                               <span>{$vo.title}</span>
                               <i>时间 :  <em>{$vo.starttime|date="Y年m月d日",###} - {$vo.endtime|date="Y年m月d日",###}</em></i>
                           </a>
                       </li>
                     </volist>
                   </ul>
                   <div class="activity_chang4">
                       {$Page}
                   </div>
                   <div class="Open_stroke_r_a">
                       <a href="javascript:;" class="travels2_bottom3">定制新的行程</a>
                   </div>
                   <div style="margin-bottom:82px;"></div>
               </div>
           </div>
           <div class="fr activity_main2_02">
               <!-- <div class="Open_stroke_l_top">
                   <a href="">
                       <img src="__IMG__/img100.jpg" />
                   </a>
               </div> -->
               <div class="Open_stroke_main">
                   <div class="activity_main2_02-1">
                       <div class="activity_main2_02-1_top">
                           <span>热门游记</span>
                       </div>
                       <ul class="activity_main2_02-1_ul">
                          <volist name="hotnote" id="vo">
                              <li>
                                  <div class="activity_main2_02-1_list pr">
                                      <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" width="339px" height="213px" onclick="window.location.href='{:U('Home/Party/show',array('id'=>$vo['id']))}'" />
                                      <span>{:str_cut($vo['title'],10)}</span>
                                      <i>{$vo.inputtime|date="Y-m-d",###}</i>
                                      <p>{:str_cut($vo['description'],40)}</p>
                                      <div class="activity_main2_02-1_list_img">
                                          <a href="{:U('Home/Member/detail',array('uid'=>$vo['uid']))}">
                                            <img src="{$vo.head}"  width="55px" height="55px" />
                                          </a>
                                      </div>
                                  </div>
                              </li>
                          </volist>
                       </ul>
                   </div>
                   <a href="{:U('Home/Note/index',array('type'=>1))}">
                       点击查看更多游记...
                   </a>
               </div>
           </div>
       </div>
   </div>
<div class="Mask3 hide">
        
</div>
<div class="travels2_a hide">
    <div class="travels2_a_top pr">
        <span class="f22 c666">
            编辑行程时间
        </span>
        <i class="travels2_a_top2">
            <img src="__IMG__/Icon/img107.png" />
        </i>
    </div>
    <div class="travels2_a_bottom">
        <div class="travels2_a_bottom2">
            <span>行程标题 :</span>
            <input type="text" id="trip_title" />
        </div>
        <div class="travels2_a_bottom3 hidden">
            <div class="travels2_a_bottom4 fl">
                <span>出发时间 :</span>
                <input value="{:date('Y-m-d')}" type="text" class="J_date" id="trip_starttime" />
            </div>
            <div class="fr travels2_a_bottom5">
                <span class="middle">出发天数 :</span>
                <div class="travels2_a_bottom6 middle hidden">
                    <input type="text" value="1" id="trip_days"/>
                    <i>天</i>
                </div>
            </div>
        </div>
        <div class="travels2_a2">
            <input type="button" class="addtrip" data-varname="" value="提交" />
        </div>
    </div>
</div>
<script type="text/javascript">
  $(function () {
      $(".Mask3").height($(window).height());
      $(".travels2_bottom3").click(function () {
          var uid="{$user.id}";
          if(uid==''){
              alert("请先登录！");var p={};
                    p['url']="__SELF__";
                    $.post("{:U('Home/Public/ajax_cacheurl')}",p,function(data){
                        if(data.code=200){
                            window.location.href="{:U('Home/Member/login')}";
                        }
                    })
              
              return false;
          }
          $(".Mask3").show();
          $(".travels2_a").show();
      })
      $(".Mask3,.travels2_a_top2").click(function () {
          $(".Mask3").hide();
          $(".travels2_a").hide();
      })
      $(".addtrip").click(function(){
          var p={};
          var trip_title=$("#trip_title").val();
          if(trip_title==''){
              alert("请填写行程标题！");
              return false;
          }
          var trip_starttime=$("#trip_starttime").val();
          if(trip_starttime==''){
              alert("请选择行程开始时间！");
              return false;
          }
          var trip_days=$("#trip_days").val();
          if(trip_days==''||Number(trip_days)<=0){
              alert("请填写正确行程天数！");
              return false;
          }
          p['title']=trip_title;
          p['starttime']=trip_starttime;
          p['days']=trip_days;
          $.post("{:U('Home/Trip/ajax_cachetripinfo')}",p,function(data){
              if(data.code=200){
                  $(".Mask3").hide();
                  $(".travels2_a").hide();
                  window.location.href="{:U('Home/Trip/add')}";
              }else{
                  alert("提交失败");
              }
          })
          
      })
      
  })
</script>
<include file="public:foot" />