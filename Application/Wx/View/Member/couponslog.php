<include file="public:head" />
<link href="__CSS__/Style.css" rel="stylesheet" />
<link href="__CSS__/base.css" rel="stylesheet" />
<div class="Use_record wrap">
    <ul class="Use_record_main">
        <div class="item_list infinite_scroll">
            <include file="Member:morelist_log" />
        </div>
        <div id="more"><a href="{:U('Wx/Member/couponslog',array('isAjax'=>1,'p'=>2))}"></a></div>
    </ul>
</div>
<include file="public:foot" />
