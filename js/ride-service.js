var RideService = {
  //init is to make sure user is logged in, it can be called from a html page
  init: function() {
    var token = localStorage.getItem("token");
    if (token) {
      window.location.replace("index.html");
    }
  },

  //order ride form validation, called in order-ride.html
  validate_order_ride: function() {
    $('#order-ride-form').validate({
      submitHandler: function(form) {
        $("#current_username").val(localStorage.getItem("username"));
        $("#driver_name").val("Driver username"); //need to get the actual username using DOM manipulation
        var entity = Object.fromEntries((new FormData(form)).entries());
        RideService.order_ride(entity);
      }
    });
  },

  //display payment options after ride has been paid for
  order_ride: function(entity) {
    $.ajax({
      url: 'rest/rides',
      type: 'POST',
      data: JSON.stringify(entity),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        DriverService.toggle_order_ride_modal();
        $("#driver-list").html(`
        <div class="padded-top container">
            <div class="row">
                <div class="text-center">
                  <h4 class="mb-0">Ride completed.</h6>
                  <h4 class="mb-5">Total price:<b>20 KM</b></h6>
                  <button type="button" class="btn btn-outline-danger btn-lg btn-block" onclick="RideService.process_ride_payment()">Finalize and pay</button>
                  <button type="button" class="btn btn-outline-danger btn-lg btn-block" onclick="window.location.replace('leave-review.html')">Leave a review (placeholder!)</button>
              </div>
            </div>
        </div>`);
        RideService.set_ride_id();
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },

  //set ride id for payment as the last recorded ride id
  set_ride_id: function() {
    $.ajax({
      url: 'rest/lastrideid',
      type: 'GET',
      success: function(data) {
        localStorage.setItem("ride_id", data.id);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  },

  //add payment record
  process_ride_payment: function() {
    var payment = {
      ride_id: localStorage.getItem("ride_id")
    }
    $.ajax({
      url: 'rest/ridepayments',
      type: 'POST',
      data: JSON.stringify(payment),
      contentType: "application/json",
      dataType: "json",
      success: function(result) {
        toastr.success("Sucessfully paid");
        window.location.replace("index.html");
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
      }
    });
  }
}
