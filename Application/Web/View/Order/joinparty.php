<include file="public:head" />
 <body class="back-f1f1f1">
    <div class="header center z-index112 pr f18 fix-head">
        活动报名
        <div class="head_go pa">
            <a href="{:U('Party/show')}?id={$data.id}">
                <img src="__IMG__/go.jpg">
            </a><span>&nbsp;</span>
        </div>
    </div>
    <div class="container padding_0" style="margin-top:6rem">
        <div class="act_e">
            <div class="act_e1 fl">
                <img src="__IMG__/act_c1.jpg">
            </div>
            <div class="act_e2 fr">
                <div class="act_e3">{$data.title}</div>
                <div>
                    <div class="land_font">
                        <span>时间:</span> {$data.starttime|date='Y-m-d',###} 至{$data.endtime|date='Y-m-d',###}
                    </div>
                    <div class="land_font">
                        <span>地点:</span> {$data.address}
                    </div>
                </div>

            </div>
        </div>
        <form action="{:U('Web/Order/createAct')}" method="post" id='form' onsubmit="return checkform();">
            <div class="we_a" style="margin-bottom:6rem">
                <div class="yr-a we_p2 center">报名人数</div>
                <div class="we_b">
                    <div class="we_b1">
                        <!-- <input type="button" class="we_btn reduce" value="-"> -->
                    </div>
                    <div class="we_b2 center">
                        <input type="number" name='num' class="we_text" value="1" readonly>人
                    </div>
                    <div class="we_b1 right">
                        <!-- <input type="button" class="we_btn add" value="+"> -->
                    </div>
                </div>
                <div class="yr-a we_p2 center" style="margin-top:1rem;">主报名人信息</div>
                <div class="we_d">
                    <div class="lu_b">
                        <input type="text" name="realname" class="lu_text main-partner" value="{$member.realname}" placeholder="真实姓名 :">
                    </div>
                    <div class="lu_b">
                        <input type="text" name="phone" class="lu_text main-partner" value="{$member.phone}" placeholder="电话号码 :">
                    </div>
                    <div class="lu_b">
                        <input type="text" name="idcard" class="lu_text main-partner" value="{$member.idcard}" placeholder="身份证号码 :">
                    </div>
                </div>
                <div class="yr-a we_p2 center" style="margin-top:-1rem;">其他报名人信息</div>
                <div class="name_box">
                    <volist name='people' id='vo'>
                        <div class="name_list">
                            <div class="name_text">{$vo.realname}</div>
                            <input type='hidden' value="{$vo.id}" />
                            <!--<input type="text" class="name_text" placeholder="周生生" disabled="disabled">-->
                            <div class="name_a">
                                <input type="button" class="name_btn" data-id='{$vo.id}' value="编辑">
                                <input type="button" class="name_btn del" data-id='{$vo.id}' value="删除">
                            </div>
                        </div>
                    </volist>
                </div>
                <div class="olist">
                    <a href="{:U('Web/Member/topContacts',array('id'=>$rid))}"><span>+</span>添加</a>
                </div>
                <!--
                <div class="ft12 yr-a padding_2 center" style="padding-top:0">是否有优惠券</div>
                <div class="help_list" style="border-radius:5px;">
                    <div class="help_a ft12 common_click couponstitle">选择优惠券</div>
                </div>
                -->
            </div>
            <div class="ig" style="position:fixed;bottom:0;left:0;right:0">
                <div class="ig_left fl">
                    <div class="ig_a ft14">活动总额 :
                        <span class="ft16">￥<span class="ft16" id='tmoney'>{$data.money}</span> </span>
                    </div>
                    <div class="ig_b ft10">
                        <a href="#" id="price_detail">价格明细 <!-- <img src="__IMG__/arrow.jpg"><span id='details'></span> -->&nbsp;&gt;</a>
                    </div>
                </div>
                <div class="ig_right fr">
                    <input type='hidden' name='money' value='{$data.money}'>
                    <input type='hidden' name='aid' value="{$pid}">
                    <input type="hidden" name="couponsid" value="">
                    <input type="hidden" name="discount" value="0.00">
                    <input type="submit" class='sub' value="提交报名表" style="background:transparent;color:#fff">
                </div>
            </div>
        </form>
    </div>
    <div class="big_mask"></div>
    <div class="common_mask" style="height: 80%;">
        <div class="pyl_top pr ">选择优惠券
            <div class="pyl_close pa">
                <img src="__IMG__/close.jpg">
            </div>
        </div>
        <div class="common_mid" style=" height: 90%;">
            <div class="name_box bianj_child" style="height: 80%;overflow-y: scroll;">
                <volist name='coupon' id='vo'>
                    <div class="prefer_list" data-title="{$vo.title}" data-id="{$vo.id}" data-price="{$vo.price}">
                        <span>{$vo.title}</span>
                    </div>
                </volist>
            </div>
            <div class="snail_d homen_style center f16">
                <a class='addCoupon'>确定添加</a>
            </div>
        </div>
    </div>
    <div id="p_detail" style="position:fixed;left:0;right:0;top:0;bottom:0;z-index:1000;display:none;">
        <div style="position:absolute;left:0;top:6rem;right:0;bottom:0;background:#000;opacity:0.8;"
        id="mask"></div>
        <div style="position:absolute;left:10px;right:10px;height:5rem;top:6rem;border-bottom:1px solid #fff;"></div>
        <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:11.5rem;"></div>
        <div style="position:absolute;height:2rem;left:0;width:100%;top:13.5rem;">
            <span style="width:30%;margin-left:10px;color:#fff;display:inline-block;text-align:left"
            id="d_start">{$data.starttime|date='Y-m-d',###}</span>
            <span style="width:34%;color:#56c3cf;display:inline-block;text-align:center" class="ft14">共<span id="d_people">2</span>人</span>
            <span style="width:30%;color:#fff;display:inline-block;text-align:right" id="d_end">{$data.endtime|date='Y-m-d',###}</span>
        </div>
        <div style="position:absolute;height:2rem;left:0;width:50%;border-right:1px solid #fff;top:15.5rem;"></div>
        <div style="position:absolute;left:10px;right:10px;height:4rem;top:18rem;padding-top:1rem;border-top:1px solid #fff;">
            <span style="width:48%;display:inline-block;color:#fff" class="ft16">活动总额</span>
            <span style="width:48%;display:inline-block;color:#ff5f4c;text-align:right;" class="ft16"
            id="dtotal"></span>
        </div>
    </div>
</body>
<script>
    $(function()
    {   
        aa();
        $(".common_click").click(function()
        {
            $(".big_mask,.common_mask").show()
        })
        $('.prefer_list').click(function()
        {
            $(this).addClass("prefer_cut").siblings().removeClass(
                "prefer_cut");
            console.log(cdata);
        })
        $(".addCoupon").click(function()
        {
            var couponsid = $("div.name_box div.prefer_cut").data(
                "id");
            var price = $("div.name_box div.prefer_cut").data(
                "price");
            var couponstitle = $(
                "div.name_box div.prefer_cut").data(
                "title");
            $(".big_mask,.pyl,.common_mask").hide();
            $('.couponstitle').text(couponstitle);

            $("#discount").text(parseFloat(price).toFixed(2));
            $("input[name='couponsid']").val(couponsid);
            $("input[name='discount']").val(parseFloat(price)
                .toFixed(2));
            aa();
        })
    })
    var money = {$data.money};
    (function() {
        $('.we_text').val(countActPeople());
        total(countActPeople());
    })();

    function aa()
        {
            var thisnum = $('.we_text').val();
            var discount = $("input[name='discount']").val();
            var total = thisnum * money - discount;
            $("#tmoney").text(total);
            $('input[name="money"]').val(total);
            console.log(total);
        }
        // 减少人数
        /*
        $('.reduce').click(function(){
        	var num=countActPeople();
        	var thisnum=$('.we_text').val();
        	if(thisnum<=countActPeople()){
        		return;
        	}
        	else{
        		thisnum--;
        		$('.we_text').val(thisnum);
        		total(thisnum);
        	}
        })
         */
        // 增加人数
        /*
        $('.add').click(function(){
        	var thisnum=$('.we_text').val();
        	console.log(thisnum);
        	thisnum++;
        	console.log(thisnum);
        	$('.we_text').val(thisnum);
        	total(thisnum);
        })
         */
    $('.del').click(function()
    {
        var self = $(this);
        var data = {
            'id': $(this).data('id')
        };
        $.post("{:U('Web/Member/delcookie')}", data, function(res)
        {
            self.parent().parent().remove();
        })
        var thisnum = $('.we_text').val();
        $('.we_text').val(--thisnum);
        total(thisnum);
    })

    function countActPeople()
    {
        var count = $('.name_list').length + 1;
        return count;
    }

    function total(people)
    {
        var total = Number(people) * money;
        $('#tmoney').text(total);
        $('#details').text(people + '人*￥' + money);
        aa();
    }

    function checkform()
    {
        var realname = $("input[name='realname']").val();
        var idcard = $("input[name='idcard']").val();
        var phone = $("input[name='phone']").val();
        var num = $("input[name='num']").val();
        if (realname == '')
        {
            alert("请填写姓名");
            $("input[name='realname']").focus();
            return false;
        }
        else if (idcard == '')
        {
            alert("请填写身份证号码");
            $("input[name='idcard']").focus();
            return false;
        }
        else if (phone == '')
        {
            alert("请填写手机号码");
            $("input[name='phone']").focus();
            return false;
        }
        else if (!/^1[3|4|5|7|8][0-9]{9}$/.test(phone))
        {
            alert("手机号码格式不正确");
            $("input[name='phone']").focus();
            return false;
        }
        else if (!/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/.test(idcard))
        {
            alert("身份证号码错误");
            $("input[name='phone']").focus();
            return false;
        }
        else if (num != ($('.name_list').length + 1))
        {
            alert("报名人数与用户信息数量不一致");
            $("input[name='phone']").focus();
            return false;
        }
        else
        {
            return true;
        }
    }
    $('.main-partner').change(function()
    {
        var mains = $('.main-partner');
        var filled = true;
        for (var i = 0; i < mains.length; i++)
        {
            if (!$(mains[i].val())) filled = false;
        }
        if (filled)
        {
            $('.we_text').val(countActPeople());
            total(countActPeople());
        }
    });
    $('#p_detail').click(function(evt)
    {
        evt.preventDefault();
        $(this).hide();
    });
    $('#price_detail').click(function(evt)
    {
        evt.preventDefault();
        $('#d_people').html(countActPeople());
        var total = Number(countActPeople()) * money;
        $('#dtotal').html(total);
        $('#p_detail').fadeIn('fast');
    });
</script>

</html>
