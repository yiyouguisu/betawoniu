<include file="public:head" />
<script src="__JS__/chosen.jquery.js"></script>
<link href="__CSS__/chosen.css" rel="stylesheet" />
<script src="__JS__/jquery-ui.min.js"></script>
<link href="__CSS__/jquery-ui.min.css" rel="stylesheet" />

<include file="public:mheader" />
<div class="wrap">
        <div class="activity_main">
            <a href="/">首页</a>
            <span>></span>
            <a href="{:U('Home/Woniu/index')}">蜗牛</a>
            <span>></span>
            <a href="{:U('Home/Woniu/chat')}">正在聊天</a>
        </div>
    </div>


    <div class="wrap">
        <div class="Snail_home_main hidden">
            <div class="fl Snail_home_ml">
                <ul class="Snail_home_ml_ul">
                    <li class=""><!--Snail_home_ml_list-->
                        <a href="{:U('Home/Woniu/index')}">我的好友</a>
                    </li>
                    <li class="Snail_home_ml_list2">
                        <!--Snail_home_ml_list2-->
                        <a href="{:U('Home/Woniu/chat')}">正在聊天</a>
                    </li>
                    <li class=""><!--Snail_home_ml_list3-->
                        <a href="{:U('Home/Woniu/message')}">我的消息</a>
                    </li>
                </ul>
            </div>
            <div class="fl Snail_home_mr">
                <div class="Are_chatting_main">
                    <ul class="Are_chatting_main_ul"  style="overflow-y: scroll;height: 520px;margin-bottom: 100px;">
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
<include file="public:foot" />
<script type="text/javascript">
      if(navigator.userAgent.indexOf("MSIE 9")!=-1){
        window.WEB_XHR_POLLING = true;
      }
    </script>

    <script src="http://cdn.ronghub.com/RongIMLib-2.1.3.min.js"></script>

    <script>
    RongIMClient.init("cpj2xarljz3ln");
    var token = "{$user.rongyun_token}";

    RongIMClient.connect(token, {
        onSuccess: function(userId) {
          console.log("Login successfully." + userId);
        },
        onTokenIncorrect: function() {
          console.log('token无效');
        },
        onError:function(errorCode){
              var info = '';
              switch (errorCode) {
                case RongIMLib.ErrorCode.TIMEOUT:
                  info = '超时';
                  break;
                case RongIMLib.ErrorCode.UNKNOWN_ERROR:
                  info = '未知错误';
                  break;
                case RongIMLib.ErrorCode.UNACCEPTABLE_PaROTOCOL_VERSION:
                  info = '不可接受的协议版本';
                  break;
                case RongIMLib.ErrorCode.IDENTIFIER_REJECTED:
                  info = 'appkey不正确';
                  break;
                case RongIMLib.ErrorCode.SERVER_UNAVAILABLE:
                  info = '服务器不可用';
                  break;
              }
              console.log(errorCode);
            }
      });
      // 设置连接监听状态 （ status 标识当前连接状态）
       // 连接状态监听器
       RongIMClient.setConnectionStatusListener({
          onChanged: function (status) {
              switch (status) {
                  //链接成功
                  case RongIMLib.ConnectionStatus.CONNECTED:
                      console.log('链接成功');
                      
                      RongIMClient.getInstance().getConversationList({
                        onSuccess: function(list) {
                            console.log(list);
                            var uids;
                            $.each(list, function(index, val) {
                                if (index==0) {
                                    uids=val['targetId']
                                }else{
                                    uids+=','+val['targetId'];
                                }
                            });
                            console.log(uids);
                            // 获取好友列表的用户数据
                            $.post("{:U('Home/Woniu/get_user_info')}", {'uids': uids}, function(data) {
                               console.log(data);
                                var str='';
                                $.each(data, function(index, val) {
                                    var userInfo={
                                        'id':val['id'],
                                        'head':val['head'],
                                        'nickname':val['nickname'],
                                        'showurl':val['showurl'],
                                        'message':list[index]['latestMessage']['content']['content']
                                    };
                                    var times=list[index]['latestMessage']['sentTime'];
                                    // 获取最后一条消息的时间
                                    userInfo['date']=new Date(times).getHours()+':'+new Date(times).getMinutes()+':'+new Date(times).getSeconds();
                                    // 获取未读消息数量统计
                                    var conversationtype = RongIMLib.ConversationType.PRIVATE; // 私聊
                                    RongIMClient.getInstance().getUnreadCount(conversationtype,userInfo['id'],{
                                        onSuccess: function(count) {
                                            userInfo['count']=count;
                                        },
                                            onError: function(error) {
                                        }
                                    });
                                    
                                    str+=rongCreateFriendInfo(userInfo);

                                });
                                $('.Are_chatting_main_ul').html(str);
                                // 获取未读消息的总数
                                RongIMClient.getInstance().getTotalUnreadCount({
                                    onSuccess: function(count) {
                                        if (count!=0) {
                                            $('#waitletternum').text(count).show();
                                        }
                                    },
                                    onError: function(error) {
                                    }
                                });
                            },'json');
                            // // 删除好友列表
                            // RongIMClient.getInstance().removeConversation(RongIMLib.ConversationType.PRIVATE,'89',{
                            //    onSuccess:function(isClear){
                            //             // isClear true 清除成功 ， false 清除失败
                            //    },
                            //    onError:function(){
                            //        //清除遇到错误。
                            //    }
                            // });
                        },
                        onError: function(error) {
                            console.log('获取会话列表失败')
                        }
                      },null);
                        // rongSendMessage("89","asdfadsfasdf");
                        // rongSendMessage("84","asdf ewrqeasfasgad");
                      break;
                  //正在链接
                  case RongIMLib.ConnectionStatus.CONNECTING:
                      console.log('正在链接');
                      break;
                  //重新链接
                  case RongIMLib.ConnectionStatus.DISCONNECTED:
                      console.log('断开连接');
                      break;
                  //其他设备登录
                  case RongIMLib.ConnectionStatus.KICKED_OFFLINE_BY_OTHER_CLIENT:
                      console.log('其他设备登录');
                      break;
                    //网络不可用
                  case RongIMLib.ConnectionStatus.NETWORK_UNAVAILABLE:
                    console.log('网络不可用');
                    break;
                  }
          }});

       // 消息监听器
       RongIMClient.setOnReceiveMessageListener({
          // 接收到的消息
          onReceived: function (message) {
              // 判断消息类型
              switch(message.messageType){
                  case RongIMClient.MessageType.TextMessage:
                         // 发送的消息内容将会被打印
                      console.log(message.content.content);
                      break;
                  case RongIMClient.MessageType.VoiceMessage:
                      // 对声音进行预加载                
                      // message.content.content 格式为 AMR 格式的 base64 码
                      RongIMLib.RongIMVoice.preLoaded(message.content.content);
                      break;
                  case RongIMClient.MessageType.ImageMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.DiscussionNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.LocationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.RichContentMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.DiscussionNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.InformationNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.ContactNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.ProfileNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.CommandNotificationMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.CommandMessage:
                      // do something...
                      break;
                  case RongIMClient.MessageType.UnknownMessage:
                      // do something...
                      break;
                  default:
                      // 自定义消息
                      // do something...
                      break;
                console.log(message.content.content);
              }
          }
      });
        function rongSendMessage(targetId){
            // 定义消息类型,文字消息使用 RongIMLib.TextMessage
           //var msg = new RongIMLib.TextMessage({content:"hello",extra:"附加信息"});
           //或者使用RongIMLib.TextMessage.obtain 方法.具体使用请参见文档
           var msg = RongIMLib.TextMessage.obtain("hello");
           var conversationtype = RongIMLib.ConversationType.PRIVATE; // 私聊
           //var targetId = "89"; // 目标 Id
           RongIMClient.getInstance().sendMessage(conversationtype, targetId, msg, {
                  // 发送消息成功
                  onSuccess: function (message) {
                      //message 为发送的消息对象并且包含服务器返回的消息唯一Id和发送消息时间戳
                      console.log("Send successfully");
                  },
                  onError: function (errorCode,message) {
                      var info = '';
                      switch (errorCode) {
                          case RongIMLib.ErrorCode.TIMEOUT:
                              info = '超时';
                              break;
                          case RongIMLib.ErrorCode.UNKNOWN_ERROR:
                              info = '未知错误';
                              break;
                          case RongIMLib.ErrorCode.REJECTED_BY_BLACKLIST:
                              info = '在黑名单中，无法向对方发送消息';
                              break;
                          case RongIMLib.ErrorCode.NOT_IN_DISCUSSION:
                              info = '不在讨论组中';
                              break;
                          case RongIMLib.ErrorCode.NOT_IN_GROUP:
                              info = '不在群组中';
                              break;
                          case RongIMLib.ErrorCode.NOT_IN_CHATROOM:
                              info = '不在聊天室中';
                              break;
                          default :
                              info = x;
                              break;
                      }
                      console.log('发送失败:' + info);
                  }
              }
          );
        }
        /**
         * 创建好友列表的html
         * @param  {obj} userInfo 用户的数据
         */
        function rongCreateFriendInfo(userInfo) {
            var str="<li onclick=\"window.location.href='/index.php/Home/Woniu/chatdetail/tuid/"+userInfo['id']+"'\"><div class=\"clearfix Are_chatting_main_list\">";
                str+="<div class=\"fl Are_chatting_main_list2\">";
                str+="<a href=\""+userInfo['showurl']+"\"><div><img src=\""+userInfo['head']+"\" /></div></a></div>";
                str+="<div class=\"fl Are_chatting_main_list3\"><a href=\""+userInfo['showurl']+"\">"+userInfo['nickname']+"</a><i>"+userInfo['message']+"</i><span>"+userInfo['date']+"</span></div>";
                str+="</div></li>";
            return str;
        }
        /**
         * 发送消息
         * @param  {integer} uid  用户id
         * @param  {string}  word 发送的消息
         */
        function rongSendMessage(uid,word){
             // 定义消息类型,文字消息使用 RongIMLib.TextMessage
             var msg = RongIMLib.TextMessage.obtain(word);
             var conversationtype = RongIMLib.ConversationType.PRIVATE; // 私聊
             var targetId = uid; // 目标 Id
             RongIMClient.getInstance().sendMessage(conversationtype, targetId, msg, {
                // 发送消息成功
                onSuccess: function (message) {
                    //message 为发送的消息对象并且包含服务器返回的消息唯一Id和发送消息时间戳
                    console.log("Send successfully");
                },
                onError: function (errorCode,message) {
                    var info = '';
                    switch (errorCode) {
                        case RongIMLib.ErrorCode.TIMEOUT:
                            info = '超时';
                            break;
                        case RongIMLib.ErrorCode.UNKNOWN_ERROR:
                            info = '未知错误';
                            break;
                        case RongIMLib.ErrorCode.REJECTED_BY_BLACKLIST:
                            info = '在黑名单中，无法向对方发送消息';
                            break;
                        case RongIMLib.ErrorCode.NOT_IN_DISCUSSION:
                            info = '不在讨论组中';
                            break;
                        case RongIMLib.ErrorCode.NOT_IN_GROUP:
                            info = '不在群组中';
                            break;
                        case RongIMLib.ErrorCode.NOT_IN_CHATROOM:
                            info = '不在聊天室中';
                            break;
                        default :
                            info = x;
                            break;
                    }
                    console.log('发送失败:' + info);
                }
            });
             
               
        }
    </script>