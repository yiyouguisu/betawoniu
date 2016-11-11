<include file="Common:Head" />
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
        <include file="Common:Nav"/>
        <div class="h_a">聊天记录详情</div>
        <a name="top" id="top"></a>
            <div class="table_list">
            <volist name="data" id="vo">
            <if condition="$vo.fromUserId eq $uid">  
                <table width="100%" align="center" style="width:80%; line-height:20px;">
                    <tr>
                        <td></td>
                        <td align="right"><h3><b>{$vo.fnickname}</b></h3></td>
                    </tr>
                    <tr>
                        <td style="text-align:right; padding-right:10px; background:#e4e3e3">{$vo.messagetime|date="Y/m/d H:i:s",###}<br />
                            <eq name="vo['objectName']" value="RC:TxtMsg">{$vo.messagecontent}</eq>
                            <eq name="vo['objectName']" value="RC:ImgMsg"><img src="data:image/png;base64,{$vo.messagecontent}"/></eq>
                        </td>
                        <td width="108" align="right" style="background:#e4e3e3"><img src="{$vo.fhead}" width="52" height="52" /></td>
                    </tr>
                </table>
              
            <else />
                <table width="100%" align="center" style="width:80%;line-height:20px;">
                    <tr>
                        <td align="left"><h3><b>{$vo.fnickname}</b></h3></td>
                    </tr>
                    <tr>
                        <td  width="108" align="left" style="background:#e4e3e3"><img src="{$vo.fhead}" width="52" height="52" /></td>
                        <td  style="text-align:left; padding-left:10px;background:#e4e3e3">{$vo.messagetime|date="Y/m/d H:i:s",###}<br />
                            <eq name="vo['objectName']" value="RC:TxtMsg">{$vo.messagecontent}</eq>
                            <eq name="vo['objectName']" value="RC:ImgMsg"><img src="data:image/png;base64,{$vo.messagecontent}"/></eq>
                        </td>
                    </tr>
                </table>
              
            </if>
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