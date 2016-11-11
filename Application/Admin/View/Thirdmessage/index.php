<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">聊天列表</div>
        <a name="top" id="top"></a>
            <div class="table_list">
            <volist name="messagelist" id="vo">
                <table width="100%" align="center" style="width:100%;line-height:20px;">
                    <tr>
                        <td align="left"><h3><b>{:getuserinfo($vo['id'])}</b></h3></td>
                    </tr>
                    <tr>
                        <td  width="108" align="left" style="background:#e4e3e3"><img src="{$vo.head}" width="74" height="74" /></td>
                        <td  style="text-align:left; padding-left:10px;background:#e4e3e3">{$vo.messagetime|date="Y/m/d H:i:s",###}<br />
                            <eq name="vo['objectName']" value="RC:TxtMsg">{$vo.messagecontent}</eq>
                            <eq name="vo['objectName']" value="RC:ImgMsg"><img src="data:image/png;base64,{$vo.messagecontent}"/></eq>
                        </td>
                        <td  width="300" align="right" style="background:#e4e3e3">
                            <a href="{:U('Admin/Thirdmessage/log',array('uid'=>$data['id'],'tuid'=>$vo['id']))}" >
                                <button class="btn btn_submit mr10 ">查看对话记录</button>
                            </a>
                        </td>
                    </tr>
                </table>
            </volist>
            <div class="p10">
            </div>
            </div>
         
            <div class="btn_wrap">
                <div class="btn_wrap_pd">
                     <a href="#top"><button class="btn btn_submit mr10 ">返回顶部</button></a>
                </div>
            </div>
    </div>

    <script src="__JS__/common.js?v"></script>
</body>
</html>