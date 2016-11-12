<div id="chat_window" class="hide">
  <div class="chat_mask">
  </div>
  <div class="chat_frame">
    <div class="chat_head">
      <div class="head_go pa" id="close_chat">
        <img src="__IMG__/go.jpg">
      </div>
      <h3 id="chat_title" style="font-size:20px;color:#fff;text-align:center;"></h3>
    </div>
    <div class="chat_content"  style="height:auto;bottom:0">
      <div id="c_content">
      </div>
    </div>
    <div class="chat_foot" style="background:#efefef">
      <div class="chat_input_box">
        <table width="100%">
          <tbody>
            <tr>
              <td align="center">
                <textarea type="text" class="chat_input" id="chat_words"></textarea>
              </td>
              <td width="48" align="center">
                <img src="__IMG__/Icon/img31.png" class="c_w_a_item" id="emoji_ctrl">
              </td>
              <td width="48" align="center" id="img_container"> 
                <img src="__IMG__/Icon/img32.png" class="c_w_a_item" id="img_picker">
              </td>
              <td width="48" align="center">
                <button id="chat_send_btn" style="padding:7px 5px;border:1px solid #000;border-radius:3px;font-size:12px;">发送</button>
              </td>
            </tr>
            <tr id="emoji_box" class="hide" data-status="0">
              <td colspan="4">
                <div id="rongyun_emoji" style="padding:5px;height:120px;overflow-y:scroll">
                </div>
              </td>
            <tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div style="position:fixed;top:0;left:0;right:0;bottom:0;z-index:10002;background:#000;display:none" id="picture_box">
    <img src="" id="zoom_picture" style="width:100%;position:relative;">   
  </div>
</div>
<script src="https://cdn.ronghub.com/RongIMLib-2.2.4.min.js"></script>
<script src="https://cdn.ronghub.com/RongEmoji-2.2.4.min.js"></script> 
<script src="https://cdn.ronghub.com/RongUploadLib-2.2.4.min.js"></script> 
<script src="__JS__/chat.js"></script>
