(function(window) {
  var wind = window;
  var chatBox = $('#chat_window');
  var closeChat = $('#close_chat');
  var chatInput = $('#chat_words');
  var chatContent = $('#c_content');
  var chatScrollBox = $(chatContent.parent());
  var chatFriends = $('.chat_friends');
  var emojiCtrl = $('#emoji_ctrl');
  var emojiBox = $('#emoji_box');
  var chatReceiveHtml = '<div class="chat_item chat_left"><a href=""><img class="chead" src="__IMG__/kt.png"></a><div class="bubble"><pre class="bubble_words" id=""></pre></div><div style="clear:both"></div></div>';
  var chatSendHtml = '<div class="chat_item chat_right"><a href=""><img class="chead" src="__IMG__/kt.png"></a><div class="bubble"><pre class="bubble_words" id=""></pre></div><div style="clear:both"></div></div>';
  var chatReceiveItem = $(chatReceiveHtml);
  var chatSendItem = $(chatSendHtml);
  var Chat = {};
  var myPhoto = '';
  var moreHistory = true;
  var init = true;
  var sendBtn = $('#chat_send_btn');
  var conversationType = RongIMLib.ConversationType.PRIVATE;
  var imgBox = $('#picture_box');

  var targetId, targetHead, targetToken, targetNick;
  chatBox.show = function() {
    $(this).removeClass('hide');
  };
  chatBox.hide = function() {
    $(this).addClass('hide');
    chatContent.html('');
  };
  emojiCtrl.click(function(evt) {
    evt.preventDefault();
    var stat = emojiBox.data('status');
    if(!stat) {
      emojiBox.removeClass('hide');
      emojiBox.data('status', 1);
    } else {
      emojiBox.addClass('hide');
      emojiBox.data('status', 0);
    }
  });
  imgBox.click(function(evt) {
    evt.preventDefault();
    $(this).fadeOut('fast'); 
  });

  //关闭聊天窗口
  closeChat.click(function(evt) {
    evt.preventDefault(); 
    moreHistory = true;
    init = true;
    chatBox.hide();
  });

  //输入框点击完成即发送信息
  sendBtn.click(function(evt) {
    evt.preventDefault();
    var txt = chatInput.val();
    console.log(txt);
    if(txt.length) {
      chatInput.val('');
      Chat.sendText(RongIMLib.RongIMEmoji.symbolToEmoji(txt), '', targetId.toString());
      emojiBox.addClass('hide');
    }
  });

  //点击好友列表，开始聊天
  chatFriends.click(function(evt) {
    evt.preventDefault();
    var that = $(this);
    chatBox.show(); 
    targetId = that.data('targetid');
    targetHead = that.data('targethead');
    targetToken = that.data('targettoken');
    targetNick = that.data('nickname');
    $('#chat_title').html(targetNick);
    console.log(Chat);
    Chat.getHistory();
    RongIMLib.RongUploadLib.getInstance().reload('IMAGE', 'FILE');
    $.ajax({
      url: '/index.php/Web/Member/chatting',
      dataType: 'json',
      data: {
        'targetId': targetId
      },
      type: 'post',
      success: function(data) {
        console.log(data); 
      },
      error: function(err, data) {
        console.log(err); 
      }
    });
  });

  //消息窗口滚动监听事件，下拉加载聊天历史纪录
  chatScrollBox.on('scroll', function(evt) {
    var that = $(this);
    if(that.scrollTop() == 0) {
      if(!moreHistory) {
        alert('没有更多聊天记录了！');
      } else {
        init = false;
        Chat.getHistory();     
      }  
    }
  });
  

     
  //融云运行管理函数
  var RongFunc = function (userToken) {
    init = true;
    moreHistory = true;
    RongIMLib.RongIMClient.init("cpj2xarljz3ln");

    //融云emoji表情
    RongIMLib.RongIMEmoji.init();
    var emojis = RongIMLib.RongIMEmoji.emojis; 
    for(var i = 0; i < emojis.length; i++) {
      var emoji = $(emojis[i]);
      emoji.click(function(evt) {
        var that = $(this);
        evt.preventDefault();
        var name = that.children()[0].getAttribute('name');
        var txt = chatInput.val() ? chatInput.val() : '';
        txt += name;
        chatInput.val(txt);
      });
      $('#rongyun_emoji').append(emoji);
    }

    //连接状态监听器
    RongIMClient.setConnectionStatusListener({
      onChanged: function (status) {
        console.log(status);
        switch (status) {
          case RongIMLib.ConnectionStatus.CONNECTED:
            console.log('Connected.');
            break;
          case RongIMLib.ConnectionStatus.CONNECTING:
            console.log('Connecting.');
            break;
          case RongIMLib.ConnectionStatus.DISCONNECTED:
            console.log('Disconnected.');
            break;
          case RongIMLib.ConnectionStatus.KICKED_OFFLINE_BY_OTHER_CLIENT:
            console.log('Other device login.');
            break;
          case RongIMLib.ConnectionStatus.NETWORK_UNAVAILABLE:
            console.log('NETWORK ERR');
            break;
        }
      } 
    });

    //消息监听器
    RongIMClient.setOnReceiveMessageListener({
      onReceived: function(msg) {
        switch(msg.messageType) {
          case RongIMClient.MessageType.TextMessage:  
            console.log(msg);
            var text = RongIMLib.RongIMEmoji.emojiToHTML(msg.content.content);
            var ci = chatReceiveItem.clone();
            ci.find('pre').html(text);
            ci.find('img.chead').attr('src', targetHead);
            ci.find('a').attr('href', '/index.php/Web/Member/memberHome?id=' );
            chatContent.append(ci);
            $('#chat_title').html(targetNick);
            break;
          case RongIMClient.MessageType.ImageMessage:  
            console.log(msg);
            var obj = msg.content.content;
            var ci = chatReceiveItem.clone();
            var text = '<img data-src="' + msg.content.imageUri + '" src="data:image/png;base64,' + obj + '" style="width:40%">';
            ci.find('pre').html(text);
            ci.find('img.chead').attr('src', targetHead);
            ci.find('a').attr('href', '/index.php/Web/Member/memberHome?id=' );
            chatContent.append(ci);
            $('#chat_title').html(targetNick);
            break;
          case RongIMClient.MessageType.RichContentMessage:  
            console.log(msg);
            break;
          case RongIMClient.MessageType.InfomationNotificationMessage:  
            console.log(msg);
            break;
          case RongIMClient.MessageType.UnknowMessage:  
            console.log(msg);
            break;
        }
      } 
    });

    //链接服务器
    RongIMClient.connect(userToken, {
      onSuccess: function(userId)  {
        console.log("Login successfully.", userId);
        initUploadPlugins();
      },
      onTokenIncorrect: function () {
        console.log('Invalid token.'); 
      },
      onError: function(errorCode) {
        var info = '';
        switch (errorCode) {
          case RongIMLib.ErrorCode.TIMEOUT:   
            info = 'Over time.';
            break;
          case RongIMLib.ErrorCode.UNKNOW_ERROR:
            info = 'Unknwon error.';
            break;
          case RongIMLib.ErrorCode.UNACCEPTABLE_PaROTOCOL_VERSION:   
            info = 'Wrong agreement.';
            break;
          case RongIMLib.ErrorCode.IDENTIFIER_REJECTED:   
            info = 'Wrong appKey.';
            break;
          case RongIMLib.ErrorCode.SERVER_UNAVAILABLE:   
            info = 'Sever error.';
            break;
        }
        console.log(info);
      }
    });


    //聊天操作对象.
    Chat = {
      //发送文本消息.
      sendText: function (msg, extra, targetId) {
        var msg = new RongIMLib.TextMessage({'content': msg, 'extra': extra});
        sendMessage(msg, targetId, 'text');
      },

      //发送图片消息
      sendImg: function(base64Str, imgUri, targetId) {
        var msg = new RongIMLib.ImageMessage({
          content: base64Str,
          imageUri: imgUri
        });
        sendMessage(msg, targetId, 'img');
      },

      //获取历史消息
      getHistory: function() {
        var timestrap = init ? 0 : null;
        RongIMLib.RongIMClient
        .getInstance()
        .getHistoryMessages(
          conversationType, 
          targetId.toString(), 
          timestrap, 
          20, 
          {
            onSuccess: function(list, hasMsg) {
              console.log(list);
              listHistory(list);
              moreHistory = hasMsg;
            },
            onError: function(error) {
              console.log("GetHistoryMessages,errorcode:" + error); 
            }
          });
      }
    };

    //初始化融云upload插件.
    function initUploadPlugins() {
      //图片上传配置
      var imgArray = [];
      var imageOpts = {
        drop_element: 'img_container',
        container: 'img_container',
        browse_button: 'img_picker'
      };

      //文件上传配置
      var fileOpts = {
        drop_element: 'image_container',
        container: 'image_container',
        browse_button: 'chat_file_picker'
      }

      //初始化upload插件.
      RongIMLib.RongUploadLib.init(imageOpts, fileOpts);

      RongIMLib.RongUploadLib.getInstance().setListeners({
        onFileAdded: function(file) {
          imgArray.push(file);
          RongIMLib.RongUploadLib.getInstance().start(conversationType, targetId.toString());
        },
        onBeforeUpload: function(file) {
          console.log('before upload');
        },
        onUploadProgress: function(file) {
          console.log('upload progress.'); 
        },
        onFileUploaded: function(file, message, type) {
          console.log('img uploaded.'); 
          Chat.sendImg(message.content.content, message.content.imageUri, targetId.toString());
        },
        onError: function(err, errTip) {
          console.log('error occur.'); 
        },
        onUploadComplete: function() {
          console.log('all imgs uploaded.'); 
        }
      });
    };

    //显示历史消息
    function listHistory(list) {
      for(var i = list.length - 1; i >= 0; i--) {
        var item = list[i];
        var content;
        switch (item.content.messageName) {
          case 'TextMessage':
            content =  RongIMLib.RongIMEmoji.emojiToHTML(item.content.content);
            break;
          case 'ImageMessage':
            content = '<img class="chat_imgs" data-src="' + item.content.imageUri + '" src="data:image/png;base64,' + item.content.content+ '">';
            break;
        }
        if(item.senderUserId == targetId) {
          var ci = chatReceiveItem.clone();
          ci.find('pre').html(content);
          ci.find('img.chead').attr('src', targetHead);
          ci.find('a').attr('href', '/index.php/Web/Member/memberHome?id=' + item.senderUserId );
          if(item.content.messageName == 'ImageMessage') {
            ci.find('img.chat_imgs').data('src', item.content.imageUri); 
            ci.find('img.chat_imgs').click(function(evt) {
              evt.preventDefault();
              imgBox.find('img').attr('src', $(this).data('src'));
              imgBox.show();
            });
          }
          chatContent.prepend(ci);
        } else {
          var ri = chatSendItem.clone();  
          ri.find('pre').html(content);
          ri.find('img.chead').attr('src', myPhoto);
          ri.find('a').attr('href', '/index.php/Web/Member/memberHome?id=' + item.senderUserId  );
          chatContent.prepend(ri);
        }
      }
      if(init)
        $(chatContent.parent()).scrollTop(chatContent.scrollHeight());
    }

    //显示图片消息
    function showImageMessage (msg) {
      var ri = chatSendItem.clone();  
      var imgMsg = '<img data-src="' + msg.content.imageUri + '" src="data:image/png;base64,' + msg.content.content + '" style="width:100%">';
      ri.find('pre').html(imgMsg);
      ri.find('img.chead').attr('src', myPhoto);
      ri.find('a').attr('href', '/index.php/Web/Member/memberHome?id=' );
      console.log(ri);
      chatContent.append(ri);
    }

    function sendMessage(msg, targetId, messageType) {
      RongIMClient
        .getInstance()
        .sendMessage(conversationType, targetId, msg, {
          onSuccess: function(response) {
            if(messageType == 'text') {
              var si = chatSendItem.clone();
              si.find('pre').html(RongIMLib.RongIMEmoji.emojiToHTML(response.content.content));
              si.find('img.chead').attr('src', myPhoto);
              chatContent.append(si);
            } else if (messageType == 'img') {
              showImageMessage(response); 
            }
            chatScrollBox.scrollTop(chatContent.scrollHeight());
          },
          onError: function(errorCode, message) {
            var info = '';
            switch (errorCode) {
              case RongIMLib.ErrorCode.TIMEOUT:
                info = 'Time out.';
                break;
              case RongIMLib.ErrorCode.UNKNOWN_ERROR:
                info = 'Unknow error.';
                break;
              case RongIMLib.ErrorCode.REJECTED_BY_BLACKLIST:
                info = 'Black name list.';
                break;
              case RongIMLib.ErrorCode.NOT_IN_DISCUSSION:
                info = 'Not in discussion.';
                break;
              case RongIMLib.ErrorCode.NOT_IN_GROUP:
                info = 'Not in group';
                break;
              case RongIMLib.ErrorCode.NOT_IN_CHATROOM:
                info = 'Not in chatroom.';
                break;
            }
            console.log('Send fail: ', + info);
          }
        });
    }
  };

  //获取用户的融云token.
  $.ajax({
    url: '/index.php/Web/Member/rongToken', 
    dataType: 'json',
    type: 'post',
    success: function(data) {
      if(data.code) {
        console.log(data);
        RongFunc(data.res.token);
        myPhoto = data.res.head;
      } else {
        console.log(data.msg);
      }
    },
    error: function(err, data) {
      console.log(err); 
    }
  });

})(window);
