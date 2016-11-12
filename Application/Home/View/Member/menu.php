<div <eq name="user['houseowner_status']" value='1'> class="wrap hidden legend_main"<else /> class="wrap hidden my_home2_01"</eq>>
    <ul <eq name="user['houseowner_status']" value='1'> class="legend_main_ul fl"<else /> class="my_home2_ul fl"</eq>>
        <li <eq name="current_url" value="Home/Member/index">class="fl legend_main_chang" <else />class="fl" </eq>>
            <a href="{:U('Home/Member/index')}"><eq name="user['houseowner_status']" value='1'>房东主页<else />个人主页</eq></a>
        </li>
        <li <if condition="$current_url eq 'Home/Member/mycoupons' or $current_url eq 'Home/Member/couponsshow'">class="fl legend_main_chang" <else />class="fl" </if>>
            <a href="{:U('Home/Member/mycoupons')}">我的优惠券</a>
        </li>
        <li <if condition="$current_url eq 'Home/Member/myorder_hostel' or $current_url eq 'Home/Member/myorder_party'">class="fl legend_main_chang" <else />class="fl" </if>>
            <a href="{:U('Home/Member/myorder_hostel')}">我的订单</a>
        </li>
        <li <eq name="current_url" value="Home/Member/mynote">class="fl legend_main_chang" <else />class="fl" </eq>>
            <a href="{:U('Home/Member/mynote')}">我的游记</a>
        </li>
        <li <eq name="current_url" value="Home/Member/myreview">class="fl legend_main_chang" <else />class="fl" </eq>>
            <a href="{:U('Home/Member/myreview')}">我的评论</a>
        </li>
        <li <eq name="current_url" value="Home/Member/mycollect">class="fl legend_main_chang" <else />class="fl" </eq>>
            <a href="{:U('Home/Member/mycollect')}">我的收藏</a>
        </li>
        <eq name="user['houseowner_status']" value='1'>
            <li <eq name="current_url" value="Home/Member/mywallet">class="fl legend_main_chang" <else />class="fl" </eq>>
                <a href="{:U('Home/Member/mywallet')}">我的钱包</a>
            </li>
            <li <eq name="current_url" value="Home/Member/myrelease">class="fl legend_main_chang" <else />class="fl" </eq>>
                <a href="{:U('Home/Member/myrelease')}">我的发布</a>
            </li>
        </eq>
    </ul>
    <eq name="user['houseowner_status']" value="0">
        <a href="{:U('Home/Member/houseowner')}">申请成为房东</a>
    </eq>
</div>