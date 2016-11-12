<include file="Public:head" />
<div class="header center pr f18 fix-head">
      定位城市
      <div class="head_go pa" onclick="history.go(-1)"><img src="__IMG__/go.jpg"></div>
</div>

<div class="container" style="width:100%">
    <div class="land_c" style="margin-top:6rem;">
         <div class="search_box fich_box">
              <input type="text" class="search_text" placeholder="输入相关关键词搜索..." id="search-input">
              <button class="search_btn fr" style="font-size:16px;">取消</button>
         </div>
         <div class="search_a dress_a f16" style="padding-top:0">
              <div class="search_a1 fl">当前选定城市 :</div>
              <notempty name="city">
                <div class="search_a2 fr" id="selected_city" style="margin-right:3px">{$city['name']}</div>
              </notempty>
         </div>
    </div>
    <div style="width:100%;padding:5px" id="search-list">
    </div>

    <div class="dress_box regular">
         <div class="dress_title f16">热门城市：</div>
         <div class="dress_b center f16">
             <ul>
                <volist name="hots" id="hot">
                  <li>
                    <a href="{$referUrl}?city={$hot['id']}" style="color:#999;display:block">{$hot['name']}</a>
                  </li>
                </volist>
             </ul>
         </div>
         <div class="dress_title f16">全部城市：</div>
         <volist name="sorted" id="fletter">
          <div class="dress_c" style="margin:5px 0 10px 0">
              <div class="dress_d center f16" id="list_tab_{$key}" style="width:95%">{$key}</div>
              <div class="dress_e f14">
                <volist name="fletter" id="city">
                  <div class="dress_e1">
                    <a href="{$referUrl}?city={$city['id']}" class="city_item" data-content="{$city['name']}" style="color:#666;font-size:16px;padding:5px;display:block" data-cid="{$city['id']}">{$city['name']}</a>
                  </div>
                </volist>
              </div>
          </div>
         </volist>
    </div>
    <div class="right_floor center f12 regular" style="position:fixed;right:0;top:16rem;overflow-y:scroll;z-index:1000;margin-bottom:6rem">
        <div class="floor_a"><a href="#list_tab_A">A</a></div>
        <div class="floor_a"><a href="#list_tab_B">B</a></div>
        <div class="floor_a"><a href="#list_tab_C">C</a></div>
        <div class="floor_a"><a href="#list_tab_D">D</a></div>
        <div class="floor_a"><a href="#list_tab_E">E</a></div>
        <div class="floor_a"><a href="#list_tab_F">F</a></div>
        <div class="floor_a"><a href="#list_tab_G">G</a></div>
        <div class="floor_a"><a href="#list_tab_H">H</a></div>
        <div class="floor_a"><a href="#list_tab_I">I</a></div>
        <div class="floor_a"><a href="#list_tab_J">J</a></div>
        <div class="floor_a"><a href="#list_tab_K">K</a></div>
        <div class="floor_a"><a href="#list_tab_L">L</a></div>
        <div class="floor_a"><a href="#list_tab_M">M</a></div>
        <div class="floor_a"><a href="#list_tab_N">N</a></div>
        <div class="floor_a"><a href="#list_tab_O">O</a></div>
        <div class="floor_a"><a href="#list_tab_P">P</a></div>
        <div class="floor_a"><a href="#list_tab_Q">Q</a></div>
        <div class="floor_a"><a href="#list_tab_R">R</a></div>
        <div class="floor_a"><a href="#list_tab_S">S</a></div>
        <div class="floor_a"><a href="#list_tab_T">T</a></div>
        <div class="floor_a"><a href="#list_tab_U">U</a></div>
        <div class="floor_a"><a href="#list_tab_V">V</a></div>
        <div class="floor_a"><a href="#list_tab_W">W</a></div>
        <div class="floor_a"><a href="#list_tab_X">X</a></div>
        <div class="floor_a"><a href="#list_tab_Y">Y</a></div>
        <div class="floor_a"><a href="#list_tab_Z">Z</a></div>
    </div>
</div>
</script>
</body>
<script type="text/javascript">
var searchInput = $('#search-input');
var searchList = $('#search-list');
var citys = $('.city_item');
searchInput.focus(function(evt) {
  evt.preventDefault();
  $('.regular').hide();
  $('#search-input').fadeIn('fast');
  $('.search_btn').addClass('cancel-btn').removeClass('search_btn');
  $('.cancel-btn').click(function(evt) {
    evt.preventDefault();
    $('#search-input').hide();
    $('.regular').fadeIn('fast');
    $(this).addClass('search_btn').removeClass('cancel-btn');
  });
});
searchInput.bind('input propertychange', function() {
  searchList.html('');
  var _me = $(this);
  var value = _me.val();
  var matchArray = [];
  citys.each(function(i, t) {
    var _this = $(t); 
    var name = _this.data('content');
    var index;
    if((index = name.indexOf(value)) >= 0 && value.length > 0) {
      if(!matchArray[index]) {
        matchArray[index] = [];
      }
      matchArray[index].push(_this);
    }
  });
  console.log(matchArray);
  for(var i = 0; i < matchArray.length; i++) {
    for(var j = 0; j < matchArray[i].length; j++) {
      searchList.append(matchArray[i][j].clone());
    } 
  }
})
</script>
</html>
