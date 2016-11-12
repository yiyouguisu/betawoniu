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
		background:#21283b;
	}
</style>
<div class="wrap">
        <div class="MDC">
            <div class="More_draw_code_main">
                <div class="More_draw_code_main_top">
                    <span>{$data.title}</span>
                    <div class="">
                        <img class="middle" src="__IMG__/image/icon/time.png" />
                        <i class="middle">开奖时间 :<em>{$data.endtime|date="Y-m-d",###} </em></i>
                    </div>
                </div>
                <div class="More_draw_code_main_center">
                    <table class="MDC_tab">
                        <thead>
                            <tr>
                                <td>序号</td>
                                <td>抽奖码</td>
                                <td>获取时间</td>
                                <td>是否中奖</td>
                            </tr>
                        </thead>
                        <tbody>
                            <volist name="data['pool']" id="vo">
                                <tr>
                                    <td>{$vo.number}</td>
                                    <td>{$vo.code}</td>
                                    <td>{$vo.inputtime|date="Y-m-d",###}</td>
                                    <if condition="$data.ischoujiang eq 1">
                                        <if condition="$vo.status eq 1">
                                            <td class="MDC_tr">是</td>
                                            <else />
                                            <td>否</td>
                                        </if>
                                        <else />
                                        <td>--</td>
                                    </if>
                                </tr>
                            </volist>
                        </tbody>
                    </table>
                    <div style="margin-bottom:25%;"></div>
                </div>
                <div class="MDC_bottom"><span>共<em>{$data.num|default="0"}</em>张</span></div>
            </div>
        </div>
    </div>

<include file="public:foot" />