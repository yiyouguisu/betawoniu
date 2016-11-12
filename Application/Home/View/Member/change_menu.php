<div class="fl pd_main2">
    <ul class="pd_main2_ul">
        <if condition="$user['houseowner_status'] eq 1">
            <li <eq name="current_url" value="Home/Member/change_info">class="pd_main2_li pd_b" <else />class="pd_b" </eq>>
                <a href="{:U('Home/Member/change_info')}">
                    <span>房东信息</span>
                </a>
            </li>
            <else />
            <li <eq name="current_url" value="Home/Member/change_info">class="pd_main2_li pd_b" <else />class="pd_b" </eq>>
                <a href="{:U('Home/Member/change_info')}">
                    <span>个人信息</span>
                </a>
            </li>
        </if>
        
        <li <eq name="current_url" value="Home/Member/change_head">class="pd_main2_li pd_b2" <else />class="pd_b2" </eq>>
            <a href="{:U('Home/Member/change_head')}">
                <span>我的头像</span>
            </a>
        </li>
        <li <eq name="current_url" value="Home/Member/change_background">class="pd_main2_li7 pd_b7" <else />class="pd_b7" </eq>>
            <a href="{:U('Home/Member/change_background')}">
                <span>上传背景图片</span>
            </a>
        </li>
        <if condition="$user['houseowner_status'] eq 1">
            <li <eq name="current_url" value="Home/Member/mywallet">class="pd_main2_li pd_b3" <else />class="pd_b3" </eq>>
                <a href="{:U('Home/Member/mywallet')}">
                    <span>我的钱包</span>
                </a>
            </li>
        </if>
        <li <eq name="current_url" value="Home/Member/save">class="pd_main2_li pd_b4" <else />class="pd_b4" </eq>>
            <a href="{:U('Home/Member/save')}">
                <span>账号安全</span>
            </a>
        </li>
        <li <eq name="current_url" value="Home/Member/linkman">class="pd_main2_li pd_b5" <else />class="pd_b5" </eq>>
            <a href="{:U('Home/Member/linkman')}">
                <span>常用联系人</span>
            </a>
        </li>
        <!-- <li <eq name="current_url" value="Home/Member/help">class="pd_main2_li pd_b6" <else />class="pd_b6" </eq>>
            <a href="{:U('Home/Member/help')}">
                <span>帮助手册</span>
            </a>
        </li> -->
    </ul>
</div>