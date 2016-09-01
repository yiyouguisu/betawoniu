//首页
	
	$(function(){
	     $(".recom").last().css("border","0")//去边框
	     $(".recom_gg").click(function(){ //收藏效果切换
		    $(this).toggleClass("recom_c_cut")	 
		 })
	})

//搜索结果
$(function(){
	 $(".search_a2").click(function(){
        $(".search_list").remove()

	 })

})


//游记
$(function(){
    $(".tra_li").last().css("borderRight","0")//游记标题去border
	$(".tra_nb li").click(function(){//更换样式
		 $(this).addClass("tra_dropCut").siblings().removeClass("tra_dropCut")
    })
	
})

//我的点评评分
$(function(){
    $(".rev_d").click(function(){
       $(this).addClass("rev_cut")
	   $(this).prevAll().addClass("rev_cut")
	   $(this).nextAll().removeClass("rev_cut")
	
	})
})


//我的游记点击切换状态
$(function(){
   $(".fish-a").click(function(){
	   $(this).toggleClass("fish-a_cut")   
   })
   
   //点击下面收缩
   $(".fish_wt").click(function(){
	   $(".fish_btm").animate({bottom:-1000},1000)   
   })	
})

//游记页筛选点击效果
$(function(){
	 $(".tra_li").click(function(){
		 $(this).addClass("tra_li_cut").siblings().removeClass("tra_li_cut") 
		 $(".mask").css("display","block")
		 $(this).next().fadeIn().siblings(".tra_drop").hide()
     })
	 $(".tra_click ul li").click(function(){
		 $(this).addClass("tra_dropCut").siblings().removeClass("tra_dropCut")  
     })
	 
	 $(".tra_dropA").click(function(){
	     $(this).addClass("tra_dropB").siblings().removeClass("tra_dropB")	 
     })
})

//行程切换
$(function(){
   $(".trip_a span").click(function(){
	   $(this).parent(".trip_a").addClass("trip_cut")
	   .parents(".trip_list").siblings().find(".trip_a").removeClass("trip_cut")      
   })	
   
   $(".trip_a").last().find("span").css("fontSize","2.6rem")
   $(".trip_b").last().hide()
   
   //去行程详情页最后一个border
   $(".bich_list").last().css("border","0")
   
   //点击弹窗
   $(".jk_click").click(function(){
	   $(".mask,.lu_box").show();  
   })
   
   $(".mask").click(function(){
	   $(".mask,.lu_box,.tra_drop").hide();  
   })
})

//活动
$(function(){
   $(".wc .land_d").last().css('border','0')	
})

//我的个人
$(function(){
   $(".home_ck1").click(function(){
     $(".mask,.fish_btm").show()	
   })	
   
   $(".hm_click1 li").click(function(){
	   $(this).addClass("hm_cut").siblings().removeClass("hm_cut")   
   })
   
   $(".hm_click2 li").click(function(){
	   $(this).addClass("hm_cut").siblings().removeClass("hm_cut")   
   })
   
   $(".xm_click").click(function(){  //更换头像显示
	    $(".big_mask,.fish_btm").show()
   })
   
   $(".big_mask").click(function(){  //更换头像隐藏
	    $(".big_mask,.fish_btm").hide()
   })
	   
})

//民宿
$(function(){
   $(".stay_left ul li").click(function(){
	    $(this).addClass("stay_leftCut").siblings().removeClass("stay_leftCut")
		$(".stay_right ul").hide().eq($(".stay_left li").index(this)).show()
   })
   
   $(".stay_right ul li").click(function(){
	    $(this).addClass("stay_rightCut").siblings().removeClass("stay_rightCut")
   })
   
   //弹窗
   $(".snake_click").click(function(){
	  $(".big_mask,.pyl").show() 
   })
   
   $(".big_mask,.pyl_close").click(function(){
	    $(".big_mask,.pyl,.common_mask").hide() 
	})
})

//7.22新增

//活动报名人数点击
// $(function(){
//    $(".add").click(function(){
// 	  var textVal=$(this).parent(".we_b1").siblings(".we_b2").find(".we_text")
// 	  var num=$(this).parent(".we_b1").siblings(".we_b2").find(".we_text").val();
// 	  num++ ;
// 	  textVal.val(num)
      
   
//    })
   
//    $(".reduce").click(function(){
// 	  var textVal=$(this).parent(".we_b1").siblings(".we_b2").find(".we_text")
// 	  var num=$(this).parent(".we_b1").siblings(".we_b2").find(".we_text").val();
	 
// 	  if(num>1){
// 	      num-- ;
// 		  textVal.val(num) 
// 	  }
	  
   
//    })
   
  
// })

