<include file="Common:Head" />
<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <!-- <div class="nav">
          <ul class="cc">
                <li class="current"><a href="{:U('Admin/Menu/index')}">后台菜单管理</a></li>
                <li ><a href="{:U('Admin/Menu/add')}">添加菜单</a></li>
              </ul>
        </div>-->
        <include file="Common:Nav" />
        <!-- -->
        <div class="h_a">站点配置</div>
        <div class="table_full">
            <form method='post' class="J_ajaxForm" id="myform" action="{:U('Admin/Config/index')}">
                <table cellpadding="0" cellspacing="0" width="100%" class="table_form">
                    <tr>
                        <th width="140">站点名称:</th>
                        <td>
                            <input type="text" class="input" name="sitename" value="{$Site.sitename}" size="40"></td>
                    </tr>
                    <tr>
                        <th width="140">网站域名:</th>
                        <td>
                            <input type="text" class="input" name="siteurl" value="{$Site.siteurl}" size="40">
                            <span class="gray">请以“/”结尾，当前域名 {$URL}</span></td>
                    </tr>
                    <tr>
                        <th width="140">网站标题:</th>
                        <td>
                            <input type="text" class="input" name="sitetitle" value="{$Site.sitetitle}" size="40"></td>
                    </tr>
                    <tr>
                        <th width="140">网站关键字:</th>
                        <td>
                            <input type="text" class="input" name="sitekeywords" value="{$Site.sitekeywords}" size="40">
                            <span class="gray">请以“,”分割</span></td>
                    </tr>
                    <tr>
                        <th width="140">网站描述:</th>
                        <td>
                            <textarea name="sitedescription" style="width: 350px; height: 100px;">{$Site.sitedescription}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th width="140">网站电话:</th>
                        <td>
                            <input type="text" class="input" name="sitetel" value="{$Site.sitetel}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">网站Email:</th>
                        <td>
                            <input type="text" class="input" name="siteemail" value="{$Site.siteemail}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">网站微博:</th>
                        <td>
                            <input type="text" class="input" name="siteweibo" value="{$Site.siteweibo}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">公司地址:</th>
                        <td>
                            <input type="text" class="input" name="siteaddress" value="{$Site.siteaddress}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">版权信息:</th>
                        <td>
                            <input type="text" class="input" name="sitecopyright" value="{$Site.sitecopyright}" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th width="140">备案号:</th>
                        <td>
                            <input type="text" class="input" name="siteicp" value="{$Site.siteicp}" size="40">
                        </td>
                    </tr>
                    
                    <tr>
                        <th>评选活动详情图片：</th>
                        <td>
                            <input type="text" name="vote_image" id="vote_image" class="input length_5" value="{$Site.vote_image}" style="float: left" ondblclick='image_priview(this.value);'>&nbsp;
                            <input type="button" class="button upload" value="选择上传" id="uploadbtn_vote_image" data-id="vote_image">
                            <span class="gray">双击文本框查看图片</span></td>
                    </tr>
                    <tr>
                        <th>评选活动描述:</th>
                        <td>
                            <textarea name="vote_description" style="width: 350px; height: 100px;">{$Site.vote_description}</textarea>
                        </td>
                    </tr>
   
                </table>
                <div class="btn_wrap">
                    <div class="btn_wrap_pd">
                        <button class="btn btn_submit mr10 J_ajax_submit_btn" type="submit">提交</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="__JS__/common.js?v"></script>
    <script src="__JS__/content_addtop.js"></script>
    <include file="Common:upload" />
</body>
</html>