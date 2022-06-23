var UserService = {
  init: function(){
    var token = localStorage.getItem("token");
    if (token){
      window.location.replace("index.html");
    }
    $('#login-form').validate({
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        UserService.login(entity);
      }
    });
    $('#driver-register-form').validate({
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        UserService.register(entity);
      }
    });
    $('#passenger-register-form').validate({
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        UserService.register(entity);
      }
    });
  },

  login: function(entity){
    $.ajax({
      url: 'rest/login',
      type: 'POST',
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        console.log(result);
        localStorage.setItem("token", result.token);
        localStorage.setItem("username", entity.username); //to be used for ordering rides
        window.location.replace("index.html");
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },

  register: function(entity){
    $.ajax({
      url: 'rest/register',
      type: 'POST',
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        console.log(result);
        //send welcome email
        console.log(entity);
        window.location.replace("login.html");
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },

  logout: function(){
    localStorage.clear();
    window.location.replace("login.html");
  },
}
