<include file="Public:head" />
<div class="header center pr f18">意见反馈
      <div class="head_go pa" onclick="history.go(-1)">
          <img src="__IMG__/go.jpg"></div>
</div>

<div class="container">
    <form id='form' action="{:U('Web/Member/feedback')}" method="post">
        <div class="help_box">
            <div class="help_m">
                <input type="text" name='title' id="title" class="help_text" placeholder="意见标题 :"></div>
            <div class="help_m">
                <textarea name='content' id="content" class="help_area" placeholder="您的意见 :"></textarea></div>
            <div class="help_m help_n">
                <div class="snail_d center f16">
                    <a class="snail_cut">发布</a>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">
    $(function () {
        $('.snail_cut').click(function () {
            var uid = "{$user.id}";
            if (uid == '') {
                alert("请先登录！"); var p = {};
                p['url'] = "__SELF__";
                $.post("{:U('Web/Public/ajax_cacheurl')}", p, function (data) {
                    if (data.code = 200) {
                        window.location.href = "{:U('Web/Member/login')}";
                    }
                })
                return false;
            }
            var title = $("#title").val();
            if (title == '') {
                alert("请输入意见标题！");
                return false;
            }
            var content = $("#content").val();
            if (content == '') {
                alert("请输入意见内容！");
                return false;
            }
            $('#form').submit();
        })
    });
</script>
<include file="Public:foot" />
