<include file="Public:head" />
<body>
<div class="header center z-index112 pr f18">
      设置个性标签
     <div class="head_go pa"><a href="" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></a><span>&nbsp;</span></div>
</div>

<div class="container">
   <div class="hm">
         <div class="dress_title hm_color">特性 :</div>
         <div class="dress_b hm_click1 center f16">
             <ul id="charac">
                 <volist name="hobbyData" id="vo">
                    <li id='{$vo['value']}'>{$vo['name']}</li>
                 </volist>
             </ul>
         </div>
         
         <div class="dress_title hm_color">爱好 :</div>
         <div class="dress_b hm_click2 center f16">
             <ul id="hobby">
                <volist name="characData" id="vo">
                    <li id='{$vo['value']}'>{$vo['name']}</li>
                 </volist>
             </ul>
         </div>
         
         <div class="set_c" style="margin:0 2.5% 0">
             <div class="snail_d center trip_btn f16">
                      <a href="javascript:;" class="snail_cut">修改</a>
             </div>
         </div>
    </div>   

</div>

<script type="text/javascript">
    var hobby = '{$tags.hobby}',charac = '{$tags.characteristic}';
    $(function() {
        var hobbyArry = hobby.split(',');
        var characArry = charac.split(',');
        var hobbyCount = hobbyArry.length;
        var characCount = characArry.length;
        if(hobby == ''){
            hobbyCount = 0;
        }
        if(charac == '')
            characCount = 0;
        for(var i = 0; i < hobbyArry.length; i ++){
            var item = "#" + hobbyArry[i];
            $(item).addClass('hm_cut');
        }
        for(var i = 0; i < characArry.length; i ++){
            var item = '#' + characArry[i];
            $(item).addClass('hm_cut');
        }

        $('li').click(function(){
            var parent = $(this).parent()[0];
            if($(this).hasClass('hm_cut')){
                if(parent.id == 'hobby')
                    hobbyCount --;
                else
                    characCount --;
                $(this).removeClass('hm_cut');
            }
            else{
                
                if(parent.id == 'hobby'){
                    if(hobbyCount == 3)
                        layer.open({
                            content: '最多选择3个爱好！'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                    else{
                        hobbyCount ++;
                        $(this).addClass('hm_cut');
                    }
                }else{
                    if(characCount == 3)
                        layer.open({
                            content: '最多选择3个特性！'
                            ,skin: 'msg'
                            ,time: 2 //2秒后自动关闭
                        });
                    else{
                        characCount ++;
                        $(this).addClass('hm_cut');
                    }
                }
            }
        });

        //点击修改
        $('.snail_cut').click(function(){
            var datahobby = '',datacharac = '';
            $('#hobby li').each(function(){
                if($(this).hasClass('hm_cut'))
                    datahobby += $(this).attr('id') + ',';
            });
            datahobby=datahobby.substring(0,datahobby.length-1)
            $('#charac li').each(function(){
                if($(this).hasClass('hm_cut'))
                    datacharac += $(this).attr('id') + ',';
            });
            datacharac=datacharac.substring(0,datacharac.length-1)
            $.showLoading("正在提交中...");
            $.ajax({
                type: "POST",
                url: "{:U('Web/Member/edithobby')}",
                data: {
                    hobby:datahobby,
                    charac:datacharac
                },
                dataType: "json",
                success: function(data) {
                    if (data.code == 200) {
                        $.hideLoading();
                        layer.open({
                            content: '修改成功！',
                            btn: '确定',
                            shadeClose: false,
                            yes: function(){
                                window.location.href = "{:U('Web/Member/myinfo')}";
                            }
                        });
                    } else {
                        $.hideLoading();
                        $.alert(data.msg);
                        return false;
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $.hideLoading();
                    $.alert('系统错误！');
                }
            });
        });
    });
</script>

</body>

</html>