<div id="note_list_frame" class="page_frame hide">
    <div class="header center z-index112 pr f18">
        游记
        <div class="head_go pa">
            <a href="#" id="n_l_back">
                <img src="__IMG__/go.jpg">
            </a>
            <span>&nbsp;</span>
        </div>
        <div class="tra_pr pa"><i></i>
            <a href="search-2.html">
                <img src="__IMG__/search.jpg">
            </a>
        </div>
    </div>
    <div class="container">
        <div class="land">
            <div class="tra_list pr z-index112 center f14">
                <div class="tra_li tra_li_on">按时间</div>
                <div class="tra_drop tra_nb">
                    <ul>
                        <li>不限</li>
                        <li>1月-2月</li>
                        <li>2月-3月</li>
                        <li>3月-4月</li>
                        <li>4月-5月</li>
                        <li>5月-6月</li>
                        <li>6月-7月</li>
                        <li>7月-8月</li>
                        <li>8月-9月</li>
                        <li>9月-10月</li>
                        <li>10月-11月</li>
                        <li>11月-12月</li>
                        <li>12月-1月</li>
                    </ul>
                </div>
                <div class="tra_li tra_li_on">按位置</div>
                <div class="tra_drop">
                    <div class="tra_dropA_box">
                        <div class="tra_dropA">
                            <select>
                                <option>浙江省</option>
                                <option>江苏省</option>
                            </select>
                        </div>
                        <div class="tra_dropA">
                            <select>
                                <option>杭州市</option>
                                <option>苏州市</option>
                            </select>
                        </div>
                        <div class="tra_dropA">
                            <select>
                                <option>西湖区</option>
                                <option>园区</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="tra_li tra_li_on">筛选</div>
                <div class="tra_drop tra_nb">
                    <ul>
                        <li>不限</li>
                        <li>攻略</li>
                        <li>游记</li>
                    </ul>
                </div>
                <div class="tra_li tra_li_on">排序</div>
                <div class="tra_drop tra_nb">
                    <ul>
                        <li>不限</li>
                        <li>最近</li>
                        <li>评论数</li>
                    </ul>
                </div>
            </div>
            <div class="land_btm">
                <div class="land_c f14" id="note_list_container">
                </div>
            </div>
        </div>
        <!--
        <div class="tra_tb">
            <a href="">
                <img src="__IMG__/tra_tb.png">
            </a>
        </div>
        -->
        <div class="mask"></div>
    </div>
</div>

<script>
    $(function()
    {
        $(".mask").click(function()
        {
            $(".tra_drop").hide()
        })
    })
</script>


<script>
    $(function()
    {
        var oWeight = window.screen.availWidth * 0.3;
        console.log(oWeight);
        var oHeight = oWeight * 80 / 100;
        $(".land_e img").height(oHeight);
    })
</script>
<script>
  var noteList = $('#note_list_frame');
  $.ajax({
    'url': '{:U("Api/Note/get_note")}',
    'dataType': 'json',
    'data': JSON.stringify({
      'p': 1,
      'num': 12
    }),
    'contentType': 'text/xml',
    'processData': false,
    'type': 'post',
    'success': function(data) {
      console.log(data); 
      if(data.code == 200) {
        makeNoteList(data.data);
      } else {

      }
    },
    'error': function(err, data) {
      console.log(err); 
    }
  });
  function makeNoteList(data) {
    var itemHtml = '<a href="#" data-id="" class="note_detail" style="display:block">' +
                   '<div class="land_d pr f0">' +
                   '<div class="land_e vertical">' +
                   '<img src="__IMG__/land_d1.jpg" class="note_list_banner">' +
                   '</div>' +
                   '<div class="land_f vertical">' +
                   '<div class="land_f1 f16 note_list_title"></div>' +
                   '<div class="land_f2 f13 note_list_time"></div>' +
                   '<div class="interv_font"></div>' +
                   '<div class="land_f3 pa f0">' +
                   '<div class="land_f4 vertical">' +
                   '<img src="__IMG__/land_d2.png" class="note_list_head">' +
                   '</div>' +
                   '<div class="land_h tra_wc vertical">' +
                   '<div class="land_h1 f11 vertical">' +
                   '<img src="__IMG__/land_d3.png">' +
                   '<span>188</span>条评论' +
                   '</div>' +
                   '<div class="land_h2 f11 vertical">' +
                   '<img src="__IMG__/land_d4.png">' +
                   '<span>68</span>' +
                   '</div>' +
                   '</div>' +
                   '</div>' +
                   '</div>' +
                   '</div>' +
                   '</a>';
    for(var i = 0; i < data.length; i++) {
      var item = data[i];
      var newNote = $(itemHtml).clone();
      console.log(item.head);
      newNote.find('.note_list_banner').attr('src', item.thumb);
      newNote.find('.note_list_title').html(item.title);
      newNote.find('.note_list_head').attr('src', item.head);
      newNote.find('.interv_font').html(item.description);
      newNote.find('.note_list').html($.myTime.UnixToDate(item.inputtime));
      newNote.data('id', item.id);
      newNote.click(function(evt) {
        evt.preventDefault();
        var _this = $(this);
        var id = _this.data('id');
        console.log(id);
        $.ajax({
          url: '{:U("Api/Note/show")}',
          data: JSON.stringify({ "id": id }),
          dataType: 'JSON', 
          processData: false, 
          contentType: 'text/xml', 
          type: 'post',
          success: function(data) {
            if(data.code == 200) {
              showNoteDetail(data.data);
            } else {
              alert(data.msg);
            }
          },
          error: function(err, data) {
            console.log(err); 
          }
        });
      })
      $('#note_list_container').append(newNote);
    }
  }
  function showNoteDetail(data) {
    console.log(data);
    var noteDetail = $('#note_detail_frame');
    noteDetail.find('.n_d_head').attr('src', data.head);
    noteDetail.find('.n_d_title').html(data.title);
    noteDetail.find('.n_d_time').html($.myTime.UnixToDate(data.inputtime));
    noteDetail.find('#n_d_join').data('id', data.id);
    noteDetail.find('#n_d_join').data('city', data.cityname);
    noteDetail.find('#n_d_join').data('title', data.title);
    noteDetail.removeClass('hide');
    noteList.addClass('hide');
  }
  $('#n_l_back').click(function(evt) {
    evt.preventDefault();
    $('#note_list_frame').addClass('hide');
  });
</script>
