$(document).ready(function () {
  var url = "http://mini.lixiang80.com/";
  var token = $.cookie('blog_token');

  function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"),
      r = window.location.search.substr(1).match(reg);
    if (r != null) {
      return decodeURI(r[2]);
    }
    return null;
  }

  var uuid = GetQueryString("uuid");

  if (token == null) {
    window.location.href = './login.html';
  }

  $("#logout").on("click", function () {
    $.cookie('blog_token', null);
    $.cookie('blog_user_email', null);
    window.location.href = '../html/index.html';
  });

  $.ajax({
    method: "GET",
    url: url + "v1/articles/0/10",
    headers: {token: token}
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
          '<li class="weui-media-box__info__meta weui-media-box__info__meta_extra"><a href="./edit.html?uuid=' + item.uuid + '">编辑</a></li>' +
          '</ul>' +
          '</div>' +
          '</div>';
      });
      $("#articles").append(html);
    }
  });

  $.ajax({
    method: "GET",
    url: url + "v1/articles/0/200",
    headers: {token: token}
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
    url: url + "v1/articles/" + uuid,
    headers: {token: token}
  }).done(function (result) {
    if (result.code == 0) {
      var html = '', item = result.data;
      html += "<div><h2>" + item.name + "</h2><hr/>" + item.html + "</div>";
      $("#article").append(html);
    }
  });


  //初始化SimpleMDE
  var simplemde = new SimpleMDE({
    autosave: {
      enabled: true,
      uniqueId: "MyUniqueID",
      delay: 1000
    },
    status: ["autosave", "lines", "words"],
    spellChecker: false,
    element: document.getElementById("detail"),
    promptURLs: true,
    toolbar: [
      "bold", "italic", "strikethrough", "heading", "code", "quote", "unordered-list",
      "ordered-list", "clean-block", "link", "image", "table", "horizontal-rule", "preview", "side-by-side", "fullscreen", "guide",
      {
        name: "uploadImage",//自定义上传图片
        action: function customFunction(editor) {
          var inputElement = $('<input type="file">');
          inputElement.change(function () {
            var fd = new FormData();
            fd.append('file', inputElement[0].files[0]);
            $.ajax({
              url: url + "v1/files/store",
              type: "POST",
              data: fd,
              headers: {token: token},
              contentType: false,
              processData: false,
              cache: false
            }).done(function (result) {
              simplemde.value((simplemde.value() + '\n![](' + result.data.url + ')'));
            });
          });
          inputElement.click();
        },
        className: "fa fa-star",
        title: "Upload Image"
      }
    ]
  });

  //store
  $("#article_add").on('click', function () {
    console.log(simplemde.value());
    $.ajax({
      method: "POST",
      url: url + "v1/articles",
      data: {name: $("#name").val(), detail: simplemde.value()},
      headers: {token: token}
    }).done(function (result) {
      if (result.code == 0) {
        window.location.href = './index.html';
      } else {
        alert(result.msg);
      }
    });
  });

  $.ajax({
    method: "GET",
    url: url + "v1/articles/" + uuid,
    headers: {token: token}
  }).done(function (result) {
    if (result.code == 0) {
      $("#name").val(result.data.name);
      simplemde.value(result.data.detail);
    }
  });

  //store
  $("#article_edit").on('click', function () {
    console.log(simplemde.value());
    $.ajax({
      method: "POST",
      url: url + "v1/articles/" + uuid,
      data: {name: $("#name").val(), detail: simplemde.value()},
      headers: {token: token}
    }).done(function (result) {
      window.location.href = "./index.html";
    });
  });
});
