<%@EnableSessionState=False codepage=65001%>
<%
Option Explicit

Response.Charset	= "utf-8"
Response.CodePage	= 65001

dim objXML, url

url = "http://www.ibw.cn/mianze.htm"

set objXML = Server.CreateObject("MSXML2.ServerXMLHTTP")
objXML.Open "GET", url, false
objXML.Send
Response.Write objXML.ResponseText
set objXML = nothing
%>