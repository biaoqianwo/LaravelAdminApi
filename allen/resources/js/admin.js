//$(document).ready(function () {
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
//});
