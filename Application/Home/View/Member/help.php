<include file="public:head" />
<include file="public:mheader" />
<div class="wrap hidden">
        <div class="pd_main1">
            <include file="Member:change_menu" />
            <div class="fl pd_main3">
                <div class="pd_main10_top">
                    <span>帮助手册</span>
                     <eq name="user['realname_status']" value="0">
                        <a href="{:U('Home/Member/realname')}" >
                            <img src="__IMG__/Icon/img65.png" />实名认证
                        </a>
                    </eq>
                </div>
                <div class="pd_maina">
                    <a href="javascript:void(0);" class="pd_maina2">软件使用说明</a>
                    <a href="javascript:void(0);">常见问题</a>
                </div>
                <div class="">
                    <div class="pd_main15_change">
                        <div class="pd_main16">
                            {$instruction}
                        </div>
                    </div>
                    <div class="pd_main15_change hide">
                        <div class="pd_main15">
                            <ul class="pd_main15_ul">
                                <volist name="data" id="vo">
                                    <li>
                                        <a href="{:U('Home/Member/helpshow',array('id'=>$vo['id']))}">
                                            <img src="__IMG__/Icon/img69.png" />{$vo.title}
                                        </a>
                                    </li>
                                </volist>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    $(function () {
        var $ml = $(".pd_maina a");
        $ml.click(function () {
            $(this).addClass("pd_maina2").siblings().removeClass("pd_maina2");
            $(".pd_main15_change").hide();
            var cs = $(".pd_main15_change")[getObjectIndex(this, $ml)];
            $(cs).show();
        });
    })
    function getObjectIndex(a, b) {
        for (var i in b) {
            if (b[i] == a) {
                return i;
            }
        }
        return -1;
    }
</script>
<include file="public:foot" />