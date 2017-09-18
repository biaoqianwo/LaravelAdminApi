//$(document).ready(function () {
var url = "http://mini.lixiang80.com/", uid = "6983920469a6431ea5b4ce2862aebc31";

function GetQueryString(name) {
  var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"),
    r = window.location.search.substr(1).match(reg);
  if (r != null) {
    return decodeURI(r[2]);
  }
  return null;
}

var uuid = GetQueryString("uuid");
//});