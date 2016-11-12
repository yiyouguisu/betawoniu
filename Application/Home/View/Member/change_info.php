<include file="public:head" />
<link href="__CSS__/jqtransform.css" rel="stylesheet" />
<script src="__JS__/jquery.jqtransform.js"></script>
<script language="javascript">
    $(function () {
        $('.jqtransform').jqTransform();
        var dateInput = $("input.J_date");
        if (dateInput.length) {
            Wind.use('datePicker', function () {
                dateInput.datePicker({
                    onHide:function(){
                        var birthday=$(".J_date").val();
                        if(birthday!=''){
                            
                        }
                        
                        
                    }
                });
                
            });
        }
        var province='{$userinfo.province}';
        var city='{$userinfo.city}';
        var province1='{$userinfo.province1}';
        var city1='{$userinfo.city1}';
        if(province!=''){
          load(province,'city');
        }
        if(city!=''){
          load(city,'town');
        }
        if(province1!=''){
          getaddress(province1,'city');
        }
        if(city1!=''){
          getaddress(city1,'town');
        }
    });
    function load(parentid,type){
      $.ajax({
         type: "POST",
         url: "{:U('Home/Member/ajax_area')}",
         data: {'parentid':parentid},
         dataType: "json",
         success: function(data){
                    if(type=='city'){
                      $('#city').html('<option value="">市/县</option>');
                      $('#town').html('<option value="">镇/区</option>');
                      $.each(data,function(no,items){
                        if(items.id=='{$userinfo.city}'){
                            $('#city').append('<option value="'+items.id+'"selected>'+items.name+'</option>');
                        }else{
                            $('#city').append('<option value="'+items.id+'">'+items.name+'</option>');
                        }
                      });
                      fix_select('select#city');
                    }else if(type=='town'){
                      $('#town').html('<option value="">镇/区</option>');
                      $.each(data,function(no,items){
                        if(items.id=='{$userinfo.town}'){
                            $('#town').append('<option value="'+items.id+'"selected>'+items.name+'</option>');
                        }else{
                            $('#town').append('<option value="'+items.id+'">'+items.name+'</option>');
                        }
                      });
                      fix_select('select#town');
                    }
                  }
      });
    }
    function getaddress(parentid,type){
      $.ajax({
         type: "POST",
         url: "{:U('Home/Member/ajax_area')}",
         data: {'parentid':parentid},
         dataType: "json",
         success: function(data){
                    if(type=='city'){
                      $('#city1').html('<option value="">市/县</option>');
                      $('#town1').html('<option value="">镇/区</option>');
                      $.each(data,function(no,items){
                        if(items.id=='{$userinfo.city1}'){
                            $('#city1').append('<option value="'+items.id+'"selected>'+items.name+'</option>');
                        }else{
                            $('#city1').append('<option value="'+items.id+'">'+items.name+'</option>');
                        }
                      });
                      fix_select('select#city1');
                    }else if(type=='town'){
                      $('#town1').html('<option value="">镇/区</option>');
                      $.each(data,function(no,items){
                        if(items.id=='{$userinfo.town1}'){
                            $('#town1').append('<option value="'+items.id+'"selected>'+items.name+'</option>');
                        }else{
                            $('#town1').append('<option value="'+items.id+'">'+items.name+'</option>');
                        }
                      });
                      fix_select('select#town1');
                    }
                  }
      });
    }
    function fix_select(selector) { 
        var i=$(selector).parent().find('div,ul').remove().css('zIndex'); 
        $(selector).unwrap().removeClass('jqTransformHidden').jqTransSelect(); 
        $(selector).parent().css('zIndex', i); 
    } 
    
</script>
<include file="public:mheader" />
<div class="wrap hidden">
    <div class="pd_main1">
        <include file="Member:change_menu" />
        <div class="fl pd_main3">
            <div class="pd_main3_top hidden">
                <div class="middle">
                    <label class="f24 c333">个人信息</label>
                </div>
                <div class="middle pd_main3_top2">
                    <i class="c999 f12 middle">资料完善度</i>
                    <div class="pr pd_main3_top2_01 middle">
                        <div class="pa pd_main3_top2_02" style="width:{$parsent}%;"></div>
                        <label>{$parsent}%</label>
                    </div>
                </div>
                <div class="tr middle pd_main3_top3 hidden">
                    <eq name="user['realname_status']" value="0">
                        <a href="{:U('Home/Member/realname')}">
                            <img src="__IMG__/Icon/img65.png" />实名认证
                        </a>
                    </eq>
                </div>
            </div>
            <form class="jqtransform" id="form" action="{:U('Home/Member/change_info')}" method="post">
                <div class="pd_main3_bottom">
                    <label>名称 :</label>
                    <input type="text" name="nickname" value="{$user.nickname}" />
                </div>
                <div class="pd_main3_bottom">
                    <label>性别 :</label>
                    <div class="">
                        <input type="radio" name="sex" value="1" <eq name="user['sex']" value="1">checked</eq> /><i>男性</i>
                    </div>
                    <div>
                        <input type="radio" name="sex" value="2" <eq name="user['sex']" value="2">checked</eq>/><i>女性</i>
                    </div>
                    <div>
                        <input type="radio" name="sex" value="0" <eq name="user['sex']" value="0">checked</eq>/><i>保密</i>
                    </div>
                </div>
                <div class="pd_main3_bottom">
                    <label>出生日期 :</label>
                    <input type="text" name="birthday" class="J_date" value="{$user.birthday}" />
                </div>
                <div class="pd_main7_bottom">
                    <label>居住地：</label>
                    <select name="province" id="province" style="width:120px;" onchange="load(this.value,'city')">
                      <option value="">省/直辖市</option>
                      <volist name="province" id="vo"> 
                        <option value="{$vo.id}" <if condition="$vo['id'] eq $userinfo['province']">selected</if>>{$vo.name}</option>
                      </volist>
                    </select>          
                    <select name="city" id="city" style="width:80px;"  onchange="load(this.value,'town')">
                      <option value="">市/县</option>
                    </select>
                    <select name="town" style="width:80px;" id="town">
                      <option value="">镇/区</option>
                    </select>
                </div>
                <div class="pd_main7_bottom">
                    <label>故乡：</label>
                    <select name="province1" id="province1" style="width:120px;" onchange="getaddress(this.value,'city')">
                      <option value="">省/直辖市</option>
                      <volist name="province" id="vo"> 
                        <option value="{$vo.id}" <if condition="$vo['id'] eq $userinfo['province1']">selected</if>>{$vo.name}</option>
                      </volist>
                    </select>          
                    <select name="city1" id="city1" style="width:80px;"  onchange="getaddress(this.value,'town')">
                      <option value="">市/县</option>
                    </select>
                    <select name="town1" style="width:80px;" id="town1">
                      <option value="">镇/区</option>
                    </select>
                </div>
                <div class="pd_main7_bottom">
                    <label>学历：</label>
                    <select name="education">
                        <option value="">请选择学历</option>
                        <option <if condition="'博士' eq $userinfo['education']">selected</if>>博士</option>
                        <option <if condition="'硕士' eq $userinfo['education']">selected</if>>硕士</option>
                        <option <if condition="'本科' eq $userinfo['education']">selected</if>>本科</option>
                        <option <if condition="'专科' eq $userinfo['education']">selected</if>>专科</option>
                    </select>
                </div>
                <div class="pd_main3_bottom">
                    <label>学校：</label>
                    <input type="text" name="school" value="{$user.school}" />
                </div>
                <div class="pd_main7_bottom">
                    <label>属相：</label>
                    <select name="zodiac">
                        <option value="">请选择属相</option>
                        <option <if condition="'子鼠' eq $userinfo['zodiac']">selected</if>>子鼠</option>
                        <option <if condition="'丑牛' eq $userinfo['zodiac']">selected</if>>丑牛</option>
                        <option <if condition="'寅虎' eq $userinfo['zodiac']">selected</if>>寅虎</option>
                        <option <if condition="'卯兔' eq $userinfo['zodiac']">selected</if>>卯兔</option>
                        <option <if condition="'辰龙' eq $userinfo['zodiac']">selected</if>>辰龙</option>
                        <option <if condition="'巳蛇' eq $userinfo['zodiac']">selected</if>>巳蛇</option>
                        <option <if condition="'午马' eq $userinfo['zodiac']">selected</if>>午马</option>
                        <option <if condition="'未羊' eq $userinfo['zodiac']">selected</if>>未羊</option>
                        <option <if condition="'申猴' eq $userinfo['zodiac']">selected</if>>申猴</option>
                        <option <if condition="'酉鸡' eq $userinfo['zodiac']">selected</if>>酉鸡</option>
                        <option <if condition="'戌狗' eq $userinfo['zodiac']">selected</if>>戌狗</option>
                        <option <if condition="'亥猪' eq $userinfo['zodiac']">selected</if>>亥猪</option>
                    </select>
                </div>
                <div class="pd_main7_bottom">
                    <label>星座：</label>
                    <select name="constellation">
                        <option value="">请选择星座</option>
                        <option <if condition="'水瓶座' eq $userinfo['constellation']">selected</if>>水瓶座</option>
                        <option <if condition="'双鱼座' eq $userinfo['constellation']">selected</if>>双鱼座</option>
                        <option <if condition="'白羊座' eq $userinfo['constellation']">selected</if>>白羊座</option>
                        <option <if condition="'金牛座' eq $userinfo['constellation']">selected</if>>金牛座</option>
                        <option <if condition="'双子座' eq $userinfo['constellation']">selected</if>>双子座</option>
                        <option <if condition="'巨蟹座' eq $userinfo['constellation']">selected</if>>巨蟹座</option>
                        <option <if condition="'狮子座' eq $userinfo['constellation']">selected</if>>狮子座</option>
                        <option <if condition="'处女座' eq $userinfo['constellation']">selected</if>>处女座</option>
                        <option <if condition="'天秤座' eq $userinfo['constellation']">selected</if>>天秤座</option>
                        <option <if condition="'天蝎座' eq $userinfo['constellation']">selected</if>>天蝎座</option>
                        <option <if condition="'射手座' eq $userinfo['constellation']">selected</if>>射手座</option>
                        <option <if condition="'摩羯座' eq $userinfo['constellation']">selected</if>>摩羯座</option>
                    </select>
                </div>
                <div class="pd_main7_bottom">
                    <label>血型：</label>
                    <select name="bloodtype">
                        <option value="">请选择血型</option>
                        <option <if condition="'A型' eq $userinfo['bloodtype']">selected</if>>A型</option>
                        <option <if condition="'B型' eq $userinfo['bloodtype']">selected</if>>B型</option>
                        <option <if condition="'AB型' eq $userinfo['bloodtype']">selected</if>>AB型</option>
                        <option <if condition="'O型' eq $userinfo['bloodtype']">selected</if>>O型</option>
                    </select>
                </div>
                <div class="pd_main3_bottom">
                    <label>个性签名：</label>
                    <input type="text" name="info" value="{$user.info}" />
                </div>
            
                <div class="pd_main4_bottom">
                    <div class="pd_main4_bottom2" style="overflow: hidden;">
                        <span>个人标签：</span>
                        <i class="c333 f16">特性</i>
                        
                    </div>
                    <div class="pd_main4_bottom3 hidden">

                        <ul class="pd_main4_bottom3_ul">
                            <volist name="characteristic" id="vo">
                                <li data-value="{$vo.value}" <in name="vo['value']" value="$user.characteristic">class="pd_main4_bottom3_chang"</in>>
                                    <span>{$vo.name}</span>
                                    <input name="characteristic[]" type="hidden" <in name="vo['value']" value="$user.characteristic"> value="{$vo.value}"<else />value=""</in> class="characteristic">
                                </li>
                            </volist>
                        </ul>
                        <div class="pd_main4_bottom5">
                            <i></i>
                        </div>
                        <if condition="count($characteristic) gt 16">
                            <div class="pd_main4_bottom4 pd_main4_bottom6">
                                <span>更多</span>
                                <img src="__IMG__/Icon/img33.png" />
                            </div>
                        </if>
                    </div>
                    
                    <div class="pd_main4_bottom5">
                        <div class="hidden">
                            <label>爱好</label>
                        </div>
                        <ul class="pd_main4_bottom5_ul">
                            <volist name="hobby" id="vo">
                                <li data-value="{$vo.value}" <in name="vo['value']" value="$user.hobby">class="pd_main4_bottom5_chang"</in>>
                                    <span>{$vo.name}</span>
                                    <input name="hobby[]" type="hidden" <in name="vo['value']" value="$user.hobby"> value="{$vo.value}"<else />value=""</in> class="hobby">
                                </li>
                            </volist>
                        </ul>
                    </div>
            </div>
            <div class="pd_main5">

            </div>
            <div class="pd_main6">
                <a href="javascript:;" id="save">保存</a>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".pd_main3_bottom input").click(function () {
                $(this).parents().addClass("pd_main3_bottom2").siblings().removeClass("pd_main3_bottom2");
            })
            $(".pd_main4_bottom3_ul li").click(function () {
                var obj=$(this);
                if(!obj.hasClass("pd_main4_bottom3_chang")){
                    var size=$(".pd_main4_bottom3_ul li.pd_main4_bottom3_chang").size();
                    if(size>=3){
                      alert("至多选3个");
                      return false;
                    }
                    obj.find(".characteristic").val(obj.data("value"));
                }else{
                    obj.find(".characteristic").val("");
                }
                $(this).toggleClass("pd_main4_bottom3_chang");
            })
            $(".pd_main4_bottom5_ul li").click(function () {
                var obj=$(this);
                if(!obj.hasClass("pd_main4_bottom5_chang")){
                    var size=$(".pd_main4_bottom5_ul li.pd_main4_bottom5_chang").size();
                    if(size>=3){
                      alert("至多选3个");
                      return false;
                    }
                    obj.find(".hobby").val(obj.data("value"));
                }else{
                    obj.find(".hobby").val("");
                }
                $(this).toggleClass("pd_main4_bottom5_chang");
            })
           
            //更多

            var li_length = $(".pd_main4_bottom3_ul li").length;
            if (li_length > 16) {

                $(".pd_main4_bottom4 span").text("更多");
                $(".pd_main4_bottom3_ul").find("li:gt(16)").hide();
            }
            else {
                $(".pd_main4_bottom4 span").text("");
            }

            //更多
            $(".pd_main4_bottom4").click(function () {
                if ($(this).hasClass("pd_main4_bottom6")) {
                    $(".pd_main4_bottom4 span").text("收起");
                    $(".pd_main4_bottom3_ul").find("li:gt(16)").show();
                    $(this).removeClass("pd_main4_bottom6");
                }
                else {
                    $(".pd_main4_bottom4 span").text("更多");
                    $(".pd_main4_bottom3_ul").find("li:gt(16)").hide();
                    $(this).addClass("pd_main4_bottom6")
                }
            });
        $("#save").click(function(){
            $("#form").submit();
        })
    })
</script>
<include file="public:foot" />