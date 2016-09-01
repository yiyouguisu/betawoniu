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
        <div class="hidden Chat_details">
            <div class="fl Chat_details_mian1">
                <div class="Chat_details_mian1_top">
                    <a href="{:U('Home/Member/index')}">
                        <div class="middle Chat_details_mian1_top2">
                            <img src="{$user.head|default='/default_head.png'}" />
                        </div>
                        <span class="middle">{$user.nickname}</span>
                        <eq name="user['realname_status']" value="1">
                            <img class="middle" src="__IMG__/Icon/img27.png" />
                        </eq>
                    </a>
                </div>
                <div class="Chat_details_mian1_bottom">
                    <div class="Chat_details_mian1_bottom2">
                        <span>联系人</span>
                    </div>
                    <div class="Chat_details_main1_bottom3">
                        <ul class="Chat_details_main1_bottom3_ul">
                            
                        </ul>
                    </div>
                </div>
            </div>
            <div class="fl Chat_details_mian2">
                <div class="Chat_details_m2_top">
                    <span class="detailtitle"></span>
                </div>
                <div class="Chat_details_m2_center">
                   
                </div>
                <div class="Chat_details_mian4 pr">
                    <textarea class="content"></textarea>
                    <input type="button" class="bjy-cbh-send" value="发送" />
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
            
        })
    </script>
<include file="public:foot" />
<script src="http://cdn.ronghub.com/RongIMLib-2.1.3.min.js"></script>
    <!-- <script src="assets/js/RongIMLib-2.1.3.js"></script> -->
    

    <script>
        xbUserInfo = {
            id: "{$user.id}",
            nickname: "{$user.nickname}",
            head: "{$user.head|default='/default_head.png'}"
        };

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
                      // rongSendMessage("89","asdfadsfasdf");
                      // rongSendMessage("84","asdf ewrqeasfasgad");
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
                                    
                                    
                                    str+=rongCreateFriendInfo(userInfo);

                                });
                                $('.Chat_details_main1_bottom3_ul').html(str);
                                RongIMClient.getInstance().getTotalUnreadCount({
                                    onSuccess: function(count) {
                                        if (count!=0) {
                                            $('#waitletternum').text(count).show();
                                        }
                                    },
                                    onError: function(error) {
                                    }
                                });
                                var tuid="{$data.id}";
                                if(tuid!=""){
                                  var htmlObj=rongGetFriendListObj(tuid);
                                  if (htmlObj) {
                                      $('.bjy-cbh-send').attr("data-uid",tuid);
                                      htmlObj.click();
                                  }else{
                                      var data = {
                                          id: "{$data.id}",
                                          nickname: "{$data.nickname}",
                                          head: "{$data.head}"
                                      };
                                      var str=rongCreateFriendInfo(data);
                                      $('.Chat_details_main1_bottom3_ul').prepend(str);
                                      $('.Chat_details_main1_bottom3_ul li').eq(0).click();            
                                  }
                                }
                                
                            },'json');

                        },
                        onError: function(error) {
                            console.log('获取会话列表失败')
                        }
                      },null);
                        
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
                      //console.log(message.content.content);
                        if(message.senderUserId!=xbUserInfo['id']){
                            // 发消息的用户id
                            var sendMessageUid=message.senderUserId;
                            // 接收到的消息
                            var receiveMessage=message.content.content;
                            // 判断好友列表中是否有此用户
                            var htmlObj=rongGetFriendListObj(sendMessageUid);
                            if (!htmlObj) {
                                $.ajax({
                                    url: "{:U('Home/Woniu/get_user_info')}",
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {uids: sendMessageUid},
                                    async : false,
                                    success: function(data){
                                        var data=data['data'][0];
                                        var userInfo={
                                            'id': data['id'],
                                            'head': data['head'],
                                            'nickname':val['nickname'],
                                            'showurl':val['showurl'],
                                            'message':list[index]['latestMessage']['content']['content'],
                                            'date': new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds(),
                                        };
                                        htmlObj=$(rongCreateFriendInfo(userInfo));
                                        $('.Chat_details_main1_bottom3_ul').append(htmlObj);
                                    }
                                })
                            }
    
                            // 如果正在聊天 则将消息追加到聊天框中 否则好友列表插入一条
                            if (htmlObj.hasClass('Chat_details_main1_bottom3_chang')) {
                                // 将消息插入对话框中
                                var messageContent={
                                    'direction':'left',
                                    'head': htmlObj.attr('data-head'),
                                    'content':receiveMessage,
                                    'date': new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds()
                                };
                                // 创建消息对象html
                                var messageStr=rongCreateMessage(messageContent);
                                $('.Chat_details_m2_center').append(messageStr);
                                //rongRecountMessage(sendMessageUid,0);
                                rongChangeScrollHeight(99999);
                            }else{
                                // 重新计算未读数量
                                //rongRecountMessage(sendMessageUid,1);    
                            }
                            
                            // 弹框提示
                            // alertStr=htmlObj.attr('data-username')+'：'+receiveMessage;
                            // alert(alertStr);
                        }
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
              }
          }
        });
        /**
         * 创建好友列表的html
         * @param  {obj} userInfo 用户的数据
         */
        function rongCreateFriendInfo(userInfo) {
            var str="<li class=\"\" data-uid=\""+userInfo['id']+"\" data-head=\""+userInfo['head']+"\" data-nickname=\""+userInfo['nickname']+"\">";
                str+="<div class=\"\"><div class=\"middle Chat_details_main1_bottom3_list\">";
                str+="<img src=\""+userInfo['head']+"\" /></div>";
                str+="<div class=\"middle Chat_details_main1_bottom3_list2\"><span>"+userInfo['nickname']+"</span></div>";
                str+="</div></li>";
            return str;
        }
        /**
         * 传递用户id获取在聊天列表中的html对象
         * @param  {integer} uid 用户id
         * @return {obj}     html对象
         */
        function rongGetFriendListObj(uid){
            var obj=$('ul.Chat_details_main1_bottom3_ul li[data-uid='+uid+']');
            obj=obj.length==0 ? undefined : obj;
            return obj;

        }
        /**
         * 组合聊天框中的消息
         * @param  {obj} messageContent 消息内容
         */
        function rongCreateMessage(messageContent){
            if(messageContent['direction']=='left'){
                var str="<div class=\"Chat_details_m2_center3 hidden\">";
                    str+="<div class=\"fl\">";
                    str+="<div class=\"Chat_details_m2_center_5\">";
                    str+="<img src=\""+messageContent['head']+"\"  style='width:85px;height:85px' />";
                    str+="</div>";
                    str+="<div class=\"Chat_details_m2_center3_3 tl\">";
                    str+="<div class=\"Chat_details_m2_center3_4\">";
                    str+="<div class=\"Chat_details_m2_center3_1\"></div>";
                    str+="<label></label>";
                    str+="</div>";
                    str+="<span>"+messageContent['content']+"</span>";
                    str+="<i>"+messageContent['date']+"</i>";
                    str+="</div>";
                    str+="</div>";
                    str+="</div>";

            }else if(messageContent['direction']=='right'){
                var str="<div class=\"Chat_details_m2_center_2 hidden\">";
                    str+="<div class=\"fr\">";
                    str+="<div class=\"Chat_details_m2_center_4 tl\">";
                    str+="<div class=\"Chat_details_m2_center_san\">";
                    str+="</div>";
                    str+="<span>"+messageContent['content']+"</span>";
                    str+="<i>"+messageContent['date']+"</i>";
                    str+="</div>";
                    str+="<div class=\"Chat_details_m2_center_5\">";
                    str+="<img src=\""+messageContent['head']+"\"  style='width:85px;height:85px' />";
                    str+="</div>";
                    str+="</div>";
                    str+="</div>";
            }
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

        /**
         * 调整对话框滚动轴位置
         * @param  {integer} num 滚动轴位置
         */
        function rongChangeScrollHeight(num){
            $('.Chat_details_m2_center').scrollTop(num);
        }
        /**
         * 获取历史记录
         * @param  {integer} uid 用户id
         */
        function rongGetMessage(uid,userInfo,scrollTopNumber){
            // 连接融云服务器。
            RongIMClient.getInstance().getHistoryMessages(RongIMLib.ConversationType.PRIVATE, uid, null, 20, {
                onSuccess: function(list, hasMsg) {
                    // 判断是否获取到数据；如果没有；递归继续获取 作用是针对融云经常不返回数据的bug处理
                    console.log(list)
                    if (list.length==0) {
                        // var currentuid=$(".bjy-cbh-send").data("uid");
                        // console.log(currentuid+''+uid)
                        // $('.Chat_details_m2_center').html(''); 
                        rongGetMessage(uid,userInfo,scrollTopNumber)
                          
                    }else{
                        var str='',
                            messageContent={};
                        $.each(list, function(index, val) {
                            // 判断是自己发的消息；或是对方发的消息
                            if (val['senderUserId']==uid) {
                                messageContent['direction']='left';
                                messageContent['head']=userInfo['head'];
                            }else{
                                messageContent['direction']='right';
                                messageContent['head']=xbUserInfo['head'];
                            }
                            messageContent['content']=val['content']['content'];
                            messageContent['date']=new Date(val['receivedTime']).getFullYear()+'-'+(new Date(val['receivedTime']).getMonth()+1)+'-'+new Date(val['receivedTime']).getDate()+'   '+new Date(val['receivedTime']).getHours()+':'+new Date(val['receivedTime']).getMinutes()+':'+new Date(val['receivedTime']).getSeconds();
                            str +=rongCreateMessage(messageContent);
                        });
                        $('.Chat_details_m2_center').html(str);   
                        rongChangeScrollHeight(scrollTopNumber);                     
                    }

                },
                onError: function(error) {
                    console.log('APP未开启消息漫游或处理异常')
                }
            });        
        }
        $(function(){
            // 点击左侧好友列表；获取历史消息
            $('.Chat_details_main1_bottom3_ul li').live('click',function(event) {
                // 获取用户信息
                var uid=$(this).data('uid'),
                    userInfo={
                        'nickname': $(this).data('nickname'),
                        'head': $(this).data('head'),
                    };
                $('.Chat_details_m2_center').html('');
                // 如果已经选中；则不再获取历史消息
                if (!$(this).hasClass('Chat_details_main1_bottom3_chang')) {
                    $('.bjy-cbh-send').attr("data-uid",uid);
                    rongGetMessage(uid+'',userInfo,99999);
                }
                $(".detailtitle").text($(this).data('nickname'));
                 
                $(this).addClass("Chat_details_main1_bottom3_chang").siblings().removeClass("Chat_details_main1_bottom3_chang");
                // 清空单个用户的未读消息数量
                //rongClearnMessage(uid);
            });

            // 点击发送消息按钮
            $('.bjy-cbh-send').click(function(event) {
                // 获取消息内容和uid
                var str=$('.content').val(),
                    uid=$(this).data("uid");
                if (uid=='') {
                    alert('请选择聊天的好友');
                    return false;
                }
                if (str=='') {
                    alert('请输入聊天内容');
                    return false;
                }
                // 将消息插入对话框中
                var messageContent={
                    'direction':'right',
                    'head':"{$user.head|default='/default_head.png'}",
                    'content':str,
                    'date':new Date().getFullYear()+'-'+(new Date().getMonth()+1)+'-'+new Date().getDate()+'   '+new Date().getHours()+':'+new Date().getMinutes()+':'+new Date().getSeconds()
                };
                var messageStr=rongCreateMessage(messageContent);
                $('.Chat_details_m2_center').append(messageStr);
                // 调整滚动轴到底部
                rongChangeScrollHeight(99999);
                // 发送消息
                rongSendMessage(uid+'',str);
                // 清空消息框中的内容
                $('.content').val('');
                //rongClearnMessage(uid)
            });

            

        })
    </script>