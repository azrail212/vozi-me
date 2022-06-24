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

  validate_update: function(){
    $('#edit-profile-form').validate({
      submitHandler: function(form) {
        var entity = Object.fromEntries((new FormData(form)).entries());
        UserService.update(entity);
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

  set_user_id:function(){
    $.ajax({
      url: 'rest/' + localStorage.getItem("username"),
      type: 'GET',
      success: function(data) {
        localStorage.setItem("user_id", data.id);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },

  update: function() {
    var user = {};
    var new_email = $('#email').val();
    var new_password = $('#password').val();

    if (new_email){
      user.email=new_email;
    }

    if (new_password>=8){
      user.password=new_password;
    }

    $.ajax({
      url: 'rest/users/' + localStorage.getItem("user_id"),
      type: 'PUT',
      data: JSON.stringify(user),
      contentType: "application/json",
      dataType: "json",
      // beforeSend: function(xhr) {
      //   xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      // },
      success: function(result) {
        toastr.success("Changes saved. Use your new credentials next time you login");
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
          toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },

  delete: function(id) {
    $.ajax({
      url: 'rest/users/' + localStorage.getItem("user_id"),
      type: 'DELETE',
      // beforeSend: function(xhr){
      //   xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      // },
      success: function(result) {
        toastr.success("Account deleted.");
        UserService.logout();
      },

      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },
}
