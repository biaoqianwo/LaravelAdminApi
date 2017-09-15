$(document).ready(function () {
  var url = "http://localhost:8000/";
  $("#login").on("click", function () {
    $.ajax({
      method: "POST",
      url: url + "login",
      crossDomain: true,
      data: {name: $('#name').val(), password: $('#password').val()},
    }).done(function (result) {
      if (result.code == 0) {
        $.cookie('blog_token', result.data.token);
        $.cookie('blog_user_email', JSON.stringify(result.data.user.email));
        window.location.href = './index.html';
      } else {
        alert(result.msg);
      }
    });
  });
});
