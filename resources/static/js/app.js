const URL = "http://localhost/project/";

$(document).ready(function () {
  $("#send-comment").click(function () {
    let csrf_token = $("#csrf_token").val();
    let id_product = $("#id_product").val();
    let comment = $("#comment").val();

    let data = {
      csrf_token,
      id_product,
      comment,
    };

    $("#error-message").html("");
    $("#message").html("");

    $.post(URL + "comment", data, function (data) {
      data = JSON.parse(data);

      if (typeof data.error == "object") {
        $.each(data.error, function (key, value) {
          $("#error-" + key).text(value);
        });
        return;
      }

      let typeStatus =
        data.status == "success" ? "alert-success" : "alert-danger";
      $("#message").addClass(typeStatus);
      $("#message").text(data.message);

      if (data.status == "success") {
        setTimeout(function () {
          location.reload();
        }, 200);
      }
    });
  });

  $(".delete_cart").click(function () {
    let el = this;
    let id = $(this).attr("cart_id");
    let data = {
      id,
    };
    $.post(URL + "cart/delete", data, function (data) {
      $(el).closest("tr").css("background", "tomato");
      $(el)
        .closest("tr")
        .fadeOut(800, function () {
          $(this).remove();
        });
        setTimeout(function () {
          location.reload();
        }, 1500);
    });
  });
  $("#add_cart").click(function () {
    let qty = $("#qty").val();
    let slug = $(this).attr("slug");
    location.href = URL+"add-cart/"+slug+"?qty="+qty;
  });
});
