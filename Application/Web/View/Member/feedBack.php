<include file="Public:head" />
<body>
<div class="header center pr f18">
      意见反馈
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
</div>

<div class="container">
    <form id='form' action="{:U('Web/Member/feedback')}" method="post">
        <div class="help_box">
            <div class="help_m"><input type="text" name='title' class="help_text" placeholder="意见标题 :"></div>
            <div class="help_m"><textarea name='content' class="help_area">您的意见 :</textarea></div>
            <div class="help_m help_n">
                <div class="snail_d center f16">
                    <a class="snail_cut">发布</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
$(function(){
    $('.snail_cut').click(function(){
        $('#form').submit();
    })
});
</script>
</body>
</html>