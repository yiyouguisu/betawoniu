Dim html
Set html = CreateObject("Msxml2.ServerXMLHTTP.3.0")
html.open "GET", "http://www.snailinns.com/index.php/Api/AutoDb/backupBackground.html",false
html.send
