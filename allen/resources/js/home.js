$(document).ready(function () {
  var url = "http://localhost:8000/",uid = "0c7ef6dad2c34f1495fe09750d5135a7";

  function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"),
      r = window.location.search.substr(1).match(reg);
    if (r != null) {
      return decodeURI(r[2]);
    }
    return null;
  }

  var uuid = GetQueryString("uuid");

  $.ajax({
    method: "GET",
    url: url + "v2/articles/0/10",
    headers: {uid: uid}
  }).done(function (result) {
    if (result.code == 0) {
      var html = '';
      $.map(result.data, function (item) {
        html += '<div class="weui-panel__bd">' +
          '<div class="weui-media-box weui-media-box_text">' +
          '<h4 class="weui-media-box__title"><a href="./view.html?uuid=' + item.uuid + '">' + item.name + '</a></h4>' +
          '<p class="weui-media-box__desc">' + item.html + '</p>' +
          '<ul class="weui-media-box__info">' +
          '<li class="weui-media-box__info__meta">' + item.dateFormat + '</li>' +
          '<li class="weui-media-box__info__meta weui-media-box__info__meta_extra">hot:' + item.click_num + '</li>' +
          '</ul>' +
          '</div>' +
          '</div>';
      });
      $("#articles").append(html);
    }
  });

  $.ajax({
    method: "GET",
    url: url + "v2/articles/0/200",
    headers: {uid: uid}
  }).done(function (result) {
    if (result.code == 0) {
      var html = '';
      $.map(result.data, function (item) {
        html += '<div class="weui-panel__bd">' +
          '<h5 class="weui-media-box__title"><a href="./view.html?uuid=' + item.uuid + '">' + item.name + '</a></h5>' +
          '</div>';
      });
      $("#all").append(html);
    }
  });


  $.ajax({
    method: "GET",
    url: url + "v2/articles/" + uuid,
    headers: {uid: uid}
  }).done(function (result) {
    if (result.code == 0) {
      var html = '', item = result.data;
      html += "<div><h2>" + item.name + "</h2><hr/>" + item.html + "</div>";
      $("#article").append(html);
    }
  });
});