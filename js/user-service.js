var UserService = {

  init: function() {
    $('#signupForm').validate({
      submitHandler: function(form) {
        var new_user = Object.fromEntries((new FormData(form)).entries());
        console.log(new_user);
        UserService.add(new_user);
        toastr.info("Adding ...");
      }
    });
  },
  register_user: function(user_id){
    $('#signupForm').validate({
      submitHandler: function(form) {
        var new_user = Object.fromEntries((new FormData(form)).entries());
        console.log(new_user);
        UserService.add(new_user);
        toastr.info("Adding ...");
      }
    });
  },

  add:function(new_user){
    $.ajax({
      url: 'rest/users/',
      type: 'POST',
      data: JSON.stringify(new_user),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
          $("#signupModal").modal("hide");
          toastr.success("Added !");
      }
    });
  },
}
