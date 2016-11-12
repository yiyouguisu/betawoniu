<include file="public:head" />
<link href="__CSS__/AddStyle.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<style>
	body{
		background:#252c3f;
	}
</style>
<div class="wrap">
        <div class="Immediately_use_main_1">
            <div class="Immediately_use_top_img">
                <img src="__IMG__/image/icon/img2.png" />
            </div>
            <div class="Immediately_use_main_tab">
                <input class="text2" type="text" id="realname" name="realname" value="{$user.nickname}" placeholder="请输入姓名" />
                <input class="text2" type="tel" id="phone" name="phone" value="{$user.phone}" placeholder="请输入手机号码" />
                <input class="text2" type="tel" id="mannum" name="mannum" placeholder="意向入住人数" />
                <input class="text2" type="date" id="date" name="date" value="{$data.in_starttime}" placeholder="意向入住时间" />
                <textarea name="content" id="content" style="font-size:14px;" placeholder="请填写其他可接受的入住日期或者给民宿主人的留言"></textarea>
                <p >请认真填写以上信息，我们就根据这个信息来安排入住！</p>
                <input class="sub save" type="button" value="提交" />
            </div>
            <div class="Immediately_use_bottom_img">
                <img src="__IMG__/image/icon/img3.png" />
            </div>
        </div>
    </div>
<include file="public:foot" />
<script type="text/javascript">
    $(function () {
        // |date='Y-m-d',###
        $(".save").click(function(){
            var phone = $("#phone").val();
            var realname = $("#realname").val();
            var mannum = $("#mannum").val();
            var date = $("#date").val();
            var content = $("#content").val();
            var uid = "{$user.id}";
            var couponsid = "{$couponsid}";
            if (uid == '') {
                $.alert("请先清除微信缓存；方法：手机后台关闭微信应用，再重新打开微信。");
                return false;
            }
            if (phone == '') {
                $.alert("请输入手机号码");
                return false;
            }
            if (realname == '') {
                $.alert("请输入姓名");
                return false;
            }
            if (mannum == '') {
                $.alert("请输入意向入住人数");
                return false;
            }
            if (date == '') {
                $.alert("请选择意向入住时间");
                return false;
            }
            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Wx/Member/ajax_usecoupons')}",
                data: {'phone':phone,'realname':realname,'mannum':mannum,'date':date,'content':content,'couponsid':couponsid,'uid':uid},
                dataType: "json",
                success: function(data){
                    if(data.code==1){
                        $.hideLoading();
                        window.location.href="{:U('Wx/Member/exchangesuccess')}";
                    }else{
                        $.hideLoading();
                        window.location.href="{:U('Wx/Member/exchangeerror')}";
                    }

                }
            });

        })
        
    })
</script>