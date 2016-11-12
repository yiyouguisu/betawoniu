(function () {
  var domain = window.location.host;
  var es = new EventSource('http://' + domain + '/index.php/Autopush/today_weblog');
  es.onmessage = function(e) {
    var obj = JSON.parse(e.data);
    console.log(obj);
    var users=obj.users;
    var hostelorder_count = obj.hostelorder.count;
    var hostelorder = obj.hostelorder.money;
    var partyorder_count = obj.partyorder.count;
    var partyorder = obj.partyorder.money;
    var waitchecknote = obj.waitchecknote;
    var waitcheckparty = obj.waitcheckparty;
    var waitcheckhostel = obj.waitcheckhostel;
    var realname = obj.realname;
    var houseowner = obj.houseowner;
    var withdraw = obj.withdraw;

    $('#users').html(users+"人");
    $('#hostelorder_count').html(hostelorder_count+"单");
    $('#hostelorder').html(hostelorder);
    $('#partyorder_count').html(partyorder_count+"单");
    $('#partyorder').html(partyorder);
    $('#waitchecknote').html(waitchecknote+"篇");
    $('#waitcheckparty').html(waitcheckparty+"个");
    $('#waitcheckhostel').html(waitcheckhostel+"间");
    $('#realname').html(realname);
    $('#houseowner').html(houseowner);
    $('#withdraw').html(withdraw);
  };
  es.addEventListener('myevent', function(e) {
     console.log(e.data);
  });
})();
