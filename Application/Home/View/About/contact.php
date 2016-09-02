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
            <a href="{:U('Home/About/contact')}">联系我们</a>
        </div>
    </div>

    <div class="wrap">
        <div class="About_us hidden">
            <div class="fl About_us_left">
                <ul class="About_us_ul">
                    <li <eq name="current_url" value="Home/About/index">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/index')}">
                            关于我们
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/question">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/question')}">
                            常见问题
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/contact">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/contact')}">
                            联系我们
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/privacy">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/privacy')}">
                            隐私政策
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/service">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/service')}">
                            服务条款
                        </a>
                    </li>
                    <li <eq name="current_url" value="Home/About/feedback">class="About_us_list"</eq>>
                        <a href="{:U('Home/About/feedback')}">
                            投诉建议
                        </a>
                    </li>
                </ul>
            </div>
            <div class="fl About_us_right">
                <div class="About_us_right_top">
                    <span>联系我们</span>
                </div>
                <div class="About_us_right_head">
                    <p>{$data.content}</p>
                </div>
            </div>
        </div>
    </div>
<include file="public:foot" />