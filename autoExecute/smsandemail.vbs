Dim html
Set html = CreateObject("Msxml2.ServerXMLHTTP.3.0")
html.open "GET", "http://www.snailinns.com/index.php/Api/AutoMessage/smsandemail.html",false
html.send
