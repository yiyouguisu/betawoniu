<volist name="data" id="vo">
    <li class="item">
                    <div class="WeChat_list_main_list">
                        <div class="WeChat_list_main_list1">
                            <span>{$vo.title}</span>
                            <i>{$vo.inputtime|date="m月d日",###}</i>
                        </div>
                        <div class="WeChat_list_main_list2">
                            <a href="{:U('Wx/News/show',array('nid'=>$vo['id']))}">
                                <img src="{$vo.thumb}" />
                                <span>{$vo.description}</span>
                            </a>
                        </div>
                        <div class="WeChat_list_main_list3">
                            <a href="{:U('Wx/News/show',array('nid'=>$vo['id']))}">
                                <span>阅读全文</span>
                                <div>
                                    <img src="__IMG__/WeChat_list/img2.png" />
                                </div>

                            </a>
                        </div>
                    </div>
                </li>
            </volist>
