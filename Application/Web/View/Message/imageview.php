<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0" />
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no" />
    <title>蔬果先生</title>
    <link href="__CSS__/weixin.global.css" rel="stylesheet" type="text/css" />
    <link href="__CSS__/weixin.master.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="__JS__/weixin.jquery.js"></script>
    <script type="text/javascript" src="__JS__/weixin.global.js"></script>
    <style type="text/css">
        /*内容*/
        .page_info {
            width: 100%;
            height: auto;
            overflow: auto;
            position: absolute;
            left: 0px;
            top: 55px;
            z-index: 1;
        }
        /*底部*/
        .page_foot {
            width: 100%;
            height: 54px;
            color: #ffffff;
            background-color: #ffffff;
            text-align: center;
            position: fixed;
            left: 0px;
            bottom: 0px;
            z-index: 3;
        }
    </style>
    <script type="text/javascript">
        $(function () {
            $(".item").click(function () {
                var pid = $(this).attr('pid');
                location.href = "{:U('Web/Product/infoview')}?id=" + pid;
            })
        })
    </script>
</head>
<body>
    <div id="page_head" class="page_head">
        <div class="l"><a id="toolReturn" class="return" href="{:U('Web/Message/index')}" target="_self"></a></div>
        <h1>优惠促销</h1>
    </div>
    <div id="page_info" class="page_info">
        <div class="messageImage">
            <volist name="list" id="vo">
              <div class="item" pid="{$vo.pid}">
                 <div class="image"><a href="{:U('Web/Product/infoview',array('id'=>$vo['pid']))}" target="_self"><img alt="" src="{$vo.thumb}" /></a></div>
                 <div class="infos">
                    <div class="title"><a href="{:U('Web/Product/infoview',array('id'=>$vo['pid']))}" target="_self">{$vo.title}</a></div>
                    <div class="mdate">{$vo.startDate}</div>
                    <div class="marks">
                       {$vo.description}
                    </div>
                 </div>
              </div>
           </volist>
        </div>
    </div>
</body>
</html>
