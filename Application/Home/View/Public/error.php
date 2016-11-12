<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>提示信息</title>
<script type="text/javascript" src="/Public/Public/js/jquery.js"></script>
    </head>
    <body>
        <div class="wrap">
            <style>

                #error_tips{
                    font-size: 12px;
                    border:1px solid #d4d4d4;
                    background:#fff;
                    -webkit-box-shadow: #ccc 0 1px 5px;
                    -moz-box-shadow: #ccc 0 1px 5px;
                    -o-box-shadow:#ccc 0 1px 5px;
                    box-shadow: #ccc 0 1px 5px;
                    filter: progid: DXImageTransform.Microsoft.Shadow(Strength=3, Direction=180, Color='#ccc');
                    width:500px;
                    margin:50px auto;
                }
                #error_tips h2{
                    font:bold 14px/40px Arial;
                    height:40px;
                    padding:0 20px;
                    color:#666;
                }
                .error_cont{
                    padding:20px 20px 30px 80px;
                    background:url(__IMG__/tips/light.png) 20px 20px no-repeat;
                    line-height:1.8;
                }
                .error_return{
                    padding:10px 0 0 0;
                }
                ul,li{
                    list-style: none;
                    margin: 0;
                    padding: 0;
                }
                .btn {
                    color: #333;
                    background:#e6e6e6 url(__IMG__/tips/btn.png);
                    border: 1px solid #c4c4c4;
                    border-radius: 2px;
                    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
                    padding:4px 10px;
                    display: inline-block;
                    cursor: pointer;
                    font-size:100%;
                    line-height: normal;
                    text-decoration:none;
                    overflow:visible;
                    vertical-align: middle;
                    text-align:center;
                    zoom: 1;
                    white-space:nowrap;
                    font-family:inherit;
                    _position:relative;
                    margin:0;
                }
                a.btn{
                    *padding:5px 10px 2px !important;
                }     
            </style>
            <div id="error_tips">
                <h2>{$msgTitle}</h2>
                <div class="error_cont">
                    <ul>
                        <li>{$error}</li>
                    </ul>
                    <div class="error_return"><a href="<?php echo($jumpUrl); ?>" id="href" class="btn">确定</a>  <b id="wait"><?php echo($waitSecond); ?></b></div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function(){
                var wait = document.getElementById('wait'),href = document.getElementById('href').href;
                var interval = setInterval(function(){
                    var time = --wait.innerHTML;
                    if(time <= 0) {
                        location.href = href;
                        clearInterval(interval);
                    };
                }, 1000);
            });
        </script>
    </body>
</html>