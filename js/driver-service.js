var DriverService = {
  init: function() {
    var token = localStorage.getItem("token");
    if (token){
      DriverService.list();
    }
  },
  list: function() {
    $.ajax({
      url: "rest/drivers",
      type: "GET",
      //beforeSend: function(xhr) {
        //xhr.setRequestHeader('Authorization', localStorage.getItem('token'));
      //},
      success: function(data) {
        $("#driver-list").html("");
        var html = "";
        for (let i = 0; i < data.length; i++) {
          html += `
          <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
            <img src="assets/profile-picture.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
            <div class="d-flex gap-2 w-100 justify-content-between">
              <div>
                <h6 class="mb-0">Driver name: ` + data[i].username + `</h6>
                <h6 class="mb-0">Licence ID: ` + data[i].licence_id + `</h6>
                <p class="mb-0 opacity-75">Price: 20KM</p>
              </div>
              <button type="button" class="btn btn-primary edit-category-button" onclick="#">Order ride</button>

            </div>
          </a>`;
        }
        $("#driver-list").html(html);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        toastr.error(XMLHttpRequest.responseJSON.message);
        UserService.logout();
      }
    });
  },
}
