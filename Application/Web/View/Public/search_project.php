<include file="Public:head" />
<div>
    </div>
    <div class="header center pr f18">
      搜索
      <div class="head_go pa">
          <a href="javascript:history.go(-1);">
              <img src="__IMG__/go.jpg">
          </a>
      </div>
    </div>
    <div class="container">
        <div class="land_c">
            <div class="search_box fich_box" style="margin:0 0 1.5rem" id="search_box">
                <input type="text" class="search_text" placeholder="搜索游记／活动／美宿" id="keyword">
                <input type="button" class="search_btn" id="go_search">
            </div>
            <div id="search_result" style="display:none">
              <div class="search_a center search_b f16">
                  搜索结果
              </div>
              <div class="search_c f18" id="note_box">
                <div class="search_c_title">游记 :</div>
                <div id="note_list">
                </div>
              </div>
              <div class="search_c f18" id="house_box">
                <div class="search_c_title">美宿 :</div>
                <div id="hotel_list">
                </div>
              </div>
              <div class="search_c f18" id="party_box">
                <div class="search_c_title">活动 :</div>
                <div id="party_list">
                </div>
              </div>
            </div>
            <div id="search_history">
              <div class="search_a center search_b f12" style="padding:5px 0">
                  搜索历史
              </div>
              <ul id="search_history_list">
                <li>
                  <a class="fr" href="javascript:cleanStorage();" style="color:#666;display:block;background:#efefef;padding:5px;border-radius:5px;margin:5px;">清除历史数据</a>
                  <div style="clear:both"></div>
                </li>
              <ul>                   
            </div>
        </div>
    </div>
</body>
<script>
  var lStorage = window.localStorage;
  var uid = '{$uid}';
  $('#keyword').focus(function() {
    $('#search_result').hide();
    $('#search_history').fadeIn('fast');
    searchList();
  })
  $('#go_search').click(function(evt) {
    evt.preventDefault(); 
    var keyword = $('#keyword').val();
    saveStorage(keyword);
    $('#search_history').hide();
    $('#search_result').fadeIn('fast');
    $.ajax({
      'url': '{:U("Api/Query/search")}',
      'data': JSON.stringify({
        'keyword': keyword
      }),
      'dataType': 'json',
      'type': 'post',
      'contentType': 'text/xml',
      'processData': false,
      'success': function(data) {
        if(data.code == 200) {
          console.log(data.data);
          makeSearchList(data.data); 
        }
      },
      'error': function(err, data) {
        console.log(err); 
      }
    });
  });
  function makeSearchList(data) {
    var hotels = '';
    var notes = '';
    var parties = '';
    $.each(data.house, function(i, value) {
      hotels += '<a href="{:U("Hostel/show")}?id=' + value.id + '" style="padding:3px;display:block">' +
        '<div class="land_d pr f0">' +
        '<div class="land_e vertical">' +
        '<img src="' + value.thumb + '" style="width:100px;height:80px;">' +
        '</div>' +
        '<div class="land_f vertical" style="width:64%">' +
        '<div class="land_f1 f16">' + value.title +'</div>' +
        '<div class="land_f2 f13">' +
        '<div class="land_money"><span>￥</span>' + value.money + '<span>起</span>' +
        '</div>' +
        '</div>' +
        '<div class="land_f3 pa f0">' +
        '<div class="land_f4 vertical">' +
        '<img src="' + value.head + '" style="width:30px;height:30px;">' +
        '</div>' +
        '<div class="land_h tra_wc vertical">' +
        '<div class="land_h1 f11 vertical">' +
        '<img src="__IMG__/land_d3.png">' +
        '<span>' + value.reviewnum + '</span>条评论' +
        '</div>' +
        '<div class="land_h2 f11 vertical">' +
        '<img src="__IMG__/land_d4.png">&nbsp;' +
        '<span>' + value.hit + '</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</a>';
    });
    $('#hotel_list').html('');
    $('#hotel_list').append(hotels);
    $.each(data.note, function(i, value) {
      notes += '<a href="{:U("Note/show")}?id=' + value.id + '" style="display:block">' +
      '<div class="land_d pr f0">' +
      '<div class="land_e vertical">' +
      '<img src="' + value.thumb + '" style="width:100px;height:80px;">' +
      '</div>' +
      '<div class="land_f vertical" style="width:64%">' +
      '<div class="land_f1 f16">' + value.title + '</div>' +
      '<div class="interv_font" style="height:1.5rem"><p class="over_ellipsis">' + value.description + '</p></div>' +
      '<div class="land_f2 f13">2015-5-6</div>' + 
      '<div class="land_f3 pa f0">' +
      '<div class="land_f4 vertical">' +
      '<img src="' + value.head + '" style="width:30px;height:30px;">' + 
      '</div>' + 
      '<div class="land_h tra_wc vertical">' +
      '<div class="land_h1 f11 vertical">' +
      '<img src="__IMG__/land_d3.png">' +
      '<span>' + value.reviewnum + '</span>条评论' +
      '</div>' +
      '<div class="land_h2 f11 vertical">' +
      '<img src="__IMG__/land_d4.png">&nbsp;' +
      '<span>' + value.hit + '</span>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</div>' +
      '</a>';
    });
    $('#note_list').html('');
    $('#note_list').append(notes);
    $.each(data.party, function(i, value) {
      parties += '<a href="{:U("party/show")}?id=' + value.id + '">' +
      '<div class="land_d pr f0">' +
      '<div class="land_e vertical">' +
      '<img src="' + value.thumb + '" style="width:100px;height:80px">' +
      '</div>' +
      '<div class="land_f vertical">' +
      '<div class="land_f1 f16" style="margin-bottom:2rem">' + value.title + '</div>' +
      '<br>' +
      '<div style="color:#666;font-size:12px;">时间：' + $.myTime.UnixToDate(value.starttime) + '至' + $.myTime.UnixToDate(value.endtime)+ '</div>' +
      '<div style="color:#666;font-size:12px;">地点：' + value.address + '</div>' +
      '</div>' +
      '</div>' +
      '</a>';
    });
    $('#party_list').html('');
    $('#party_list').append(parties);
  }
  function saveStorage(keyword) {
    var arr;
    if(!lStorage.keywords) {
      arr = []; 
    } else {
      arr = JSON.parse(lStorage.keywords);
    }
    var index;
    if((index = $.inArray(keyword, arr)) >= 0) {
      arr.splice(index, 1); 
    }
    arr.push(keyword);
    lStorage.keywords = JSON.stringify(arr);
  }
  function readStorage() {
    if(!lStorage.keywords) return [];
    return JSON.parse(lStorage.keywords);
  }
  function cleanStorage() {
    if(lStorage.keywords)
      lStorage.clean('keywords');
  }
  window.onload = searchList();
  function searchList() {
    var keywords = undefined;
    var list = '';
    keywords = readStorage();
    $('#search_history_list').html('');
    $.each(keywords, function(i, keyword) {
      list = '<li style="padding:5px;font-size:14px;color:#666">' + keyword + '</li>';
      $('#search_history_list').prepend(list);
    });
    $('#search_history_list > li').click(function(evt) {
      evt.preventDefault();
      var keyword = $(this).html();
      $('#keyword').val(keyword);
      $('#go_search').click();
    })
  };
</script>
</html>
