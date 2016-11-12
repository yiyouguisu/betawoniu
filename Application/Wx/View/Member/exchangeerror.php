<include file="public:head" />
<link href="__CSS__/AddStyle.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<script src="__JS__/jquery-1.11.1.min.js"></script>
    <script src="__JS__/jquery.carousel.js"></script>
    <link href="__CSS__/carousel.css" rel="stylesheet" />
    <!--<link href="__CSS__/default.css" rel="stylesheet" />-->
    <script src="__JS__/islider.js"></script>
    <script src="__JS__/islider_desktop.js"></script>
<style>
	body{
		background:#252c3f;
	}
    .recom_a img{
        width: 100%;
    }
</style>
<div class="wrap">
        <div class="wrap2">
            <div class="Submit_successfully">
                <div class="Submission_failed_main1">
                    <img src="__IMG__/image/icon/fail.png" />
                    <span>对不起，您的信息提交失败！</span>
                    <i>请确认您填写的信息是否正确后，再请重新提交</i>
                    <a href="{:U('Wx/Member/reward')}">确认</a>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-bottom:260px;"></div>
    <div class="" style="position:fixed; left:0px;bottom:0px; background: #252c3f;">
        <div class="Submit_successfully_main2">
            <div class="Submit_main2_top">
                <a href="{:U('Wx/News/index')}">更多活动  <em>({$totalnum|default="0"})</em></a>
            </div>
            <div id="dom-effect" class="iSlider-effect"></div>
        </div>
    </div>
    <script>

    var domList = {$jsonStr};

    //滚动dom
    var islider4 = new iSlider({
        data: domList,
        dom: document.getElementById("dom-effect"),
        type: 'dom',
        animateType: 'depth',
        isAutoplay: false,
        isLooping: true,
    });

    </script>
<include file="public:foot" />