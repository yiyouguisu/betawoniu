<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />
<include file="public:mheader" />
	<div class="wrap">
	   <div class="activity_main">
	       <a href="/">首页</a>
	       <span>></span>
	       <a href="{:U('Home/Trip/index')}">公开行程</a>
	   </div>
	</div>

   <div class="wrap">
       <div class="activity_main2 hidden">
           <div class="fl Open_stroke_a">
               <div class="Open_stroke_r_top">
                   <a href="{:U('Home/Trip/index')}" class="Open_stroke_r_topa1">公开行程</a>
                   <a href="{:U('Home/Trip/mytrip')}">我定制的行程</a>
               </div>
               <div class="Open_stroke_r_bottom">
                   <ul class="Open_stroke_r_bottom_ul">
                      <volist name="trip" id="vo">
                       <li>
                           <a href="{:U('Home/Trip/show',array('id'=>$vo['id']))}">
                               <span>{$vo.title}</span>
                               <i>时间 :  <em>{$vo.starttime|date="Y年m月d日",###} - {$vo.endtime|date="Y年m月d日",###}</em></i>
                           </a>
                       </li>
                     </volist>
                   </ul>
                   <div class="activity_chang4">
                       {$Page}
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
                                      <img class="pic" data-original="{$vo.thumb}" src="__IMG__/default.jpg" width="339px" height="213px" onclick="window.location.href='{:U('Home/Note/show',array('id'=>$vo['id']))}'" />
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

<include file="public:foot" />