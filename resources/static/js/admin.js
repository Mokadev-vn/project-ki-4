const URL = "http://localhost/project/";

$(document).ready(function () {
  $("#login").click(function () {
    let csrf_token = $("#csrf_token").val();
    let username = $("#username").val();
    let password = $("#password").val();

    let data = {
      csrf_token,
      username,
      password,
    };

    $("#error-password").html("");
    $("#error-username").html("");

    postData("login", data).then(function (data) {
      if (data.status == "success") {
        setTimeout(function () {
          if (data.role == 1) {
            location.href = URL + "admin";
            return;
          }
          location.href = URL;
        }, 1000);
      }
    });
  });

  $("#register").click(function () {
    let csrf_token = $("#csrf_token").val();
    let full_name = $("#full_name").val();
    let username = $("#username").val();
    let email = $("#email").val();
    let birthday = $("#birthday").val();
    let password = $("#password").val();
    let cf_password = $("#CfPassword").val();

    let data = {
      csrf_token,
      full_name,
      username,
      birthday,
      password,
      cf_password,
      email,
    };

    $("#error-password").html("");
    $("#error-username").html("");
    $("#error-cf_password").html("");
    $("#error-email").html("");
    $("#error-full_name").html("");
    $("#error-birthday").html("");

    postData("register", data).then(function (data) {
      if (data.status == "success") {
        // setTimeout(function () {
        //   location.href = URL;
        // }, 1000);
      }
    });
  });

  $("#reset-password").click(function () {
    let csrf_token = $("#csrf_token").val();
    let username = $("#username").val();

    let data = {
      csrf_token,
      username,
    };

    $("#error-username").html("");

    postData("reset-password", data).then(function (data) {
      if (data.status == "success") {
        setTimeout(function () {
          location.href = URL;
        }, 3500);
      }
    });
  });

  $("#changer-reset-password").click(function () {
    let csrf_token = $("#csrf_token").val();
    let username = $("#username").val();
    let hash = $("#hash").val();
    let password = $("#password").val();
    let re_password = $("#re-password").val();

    let data = {
      csrf_token,
      password,
      re_password,
    };

    $("#error-password").html("");
    $("#error-re-password").html("");

    postData("reset-password/" + username + "/" + hash, data).then(function (
      data
    ) {
      if (data.status == "success") {
        setTimeout(function () {
          location.href = URL + "login";
        }, 3500);
      }
    });
  });

  // product
  $("#add-product").click(function () {
    let csrf_token = $("#csrf_token").val();
    let name = $("#product-name").val();
    let description = $("#description").val();
    let price = $("#price").val();
    let sale = $("#sale").val();
    let status = $("#status").val();
    let category = $("#category").val();
    let image = $("#image-product").prop("files")[0];

    $("#error-name").html("");
    $("#error-price").html("");
    $("#error-sale").html("");
    $("#error-status").html("");
    $("#error-category").html("");

    let dataPost = new FormData();

    dataPost.append("csrf_token", csrf_token);
    dataPost.append("name", name);
    dataPost.append("price", price);
    dataPost.append("sale", sale);
    dataPost.append("status", status);
    dataPost.append("category", category);
    dataPost.append("description", description);
    dataPost.append("image", image);

    ajaxData("POST", "admin/product/create", dataPost).then((data) => {
      if (data.status == "success") {
        setTimeout(function () {
          window.location.href = URL + "admin/product";
        }, 3500);
      }
    });
  });

  $("#update-product").click(function () {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;

    let csrf_token = $("#csrf_token").val();
    let id = $("#id").val();
    let name = $("#product-name").val();
    let description = $("#description").val();
    let price = $("#price").val();
    let sale = $("#sale").val();
    let status = $("#status").val();
    let category = $("#category").val();
    let coupon = $("#coupon").val();
    let image = $("#image-product").prop("files")[0];

    $("#message").html("");
    $("#error-name").html("");
    $("#error-price").html("");
    $("#error-sale").html("");
    $("#error-status").html("");
    $("#error-coupon").html("");
    $("#error-category").html("");

    let dataPost = new FormData();

    dataPost.append("csrf_token", csrf_token);
    dataPost.append("name", name);
    dataPost.append("price", price);
    dataPost.append("sale", sale);
    dataPost.append("coupon", coupon);
    dataPost.append("status", status);
    dataPost.append("category", category);
    dataPost.append("description", description);
    dataPost.append("image", image);

    ajaxData("POST", "admin/product/" + id + "/update", dataPost).then(
      (data) => {
        if (data.status == "success") {
          setTimeout(function () {
            location.reload();
          }, 3500);
        }
      }
    );
  });

  $(".delete-product").click(function () {
    let el = this;
    let id = $(this).attr("id_product");
    swal({
      title: "Are you sure?",
      text: "It will permanently deleted !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Deleted!",
    }).then(function (result) {
      if (result.value) {
        $.post(
          URL + "admin/product/delete",
          {
            id,
          },
          function (data, status) {
            data = JSON.parse(data);
            if (data.error) {
              swal("Delete Error!", "Error.......", "warning");
              return;
            }

            swal("Deleted!", "Your product has been deleted.", "success");

            $(el).closest("tr").css("background", "tomato");
            $(el)
              .closest("tr")
              .fadeOut(800, function () {
                $(this).remove();
              });
          }
        );
      }
    });
  });

  $("#delete-products").click(function () {
    let getInput = $(".input-change:checkbox:checked");
    data = "";
    listId = [];
    getInput.each(function (i, el) {
      data += el.value + ",";
      listId.push(el.value);
    });

    swal({
      title: "Are you sure?",
      text: "It will permanently deleted !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Deleted!",
    }).then(function (result) {
      if (result.value) {
        $.post(
          URL + "admin/product/delete",
          {
            id: data,
          },
          function (data, status) {
            data = JSON.parse(data);
            if (data.error) {
              swal("Delete error!", "Error......", "warning");
              return;
            }
            swal("Deleted!", "Your products has been deleted.", "success");
            listId.forEach(function (v) {
              $("#" + v)
                .closest("tr")
                .css("background", "tomato");
              $("#" + v)
                .closest("tr")
                .fadeOut(800, function () {
                  $(this).remove();
                });
            });
          }
        );
      }
    });
  });

  // end product

  // category
  $("#add-category").click(function () {
    let csrf_token = $("#csrf_token").val();
    let name = $("#category-name").val();
    let show_index = $("#show_index").val();
    let image = $("#image-category").prop("files")[0];

    let dataPost = new FormData();

    dataPost.append("csrf_token", csrf_token);
    dataPost.append("name", name);
    dataPost.append("show_index", show_index);
    dataPost.append("image", image);

    $("#error-name").html("");
    $("#error-show_index").html("");
    $("#error-image").html("");

    ajaxData("POST", "admin/category/create", dataPost).then((data) => {
      if (data.status == "success") {
        setTimeout(function () {
          window.location.href = URL + "admin/category";
        }, 1000);
      }
    });
  });

  $("#update-category").click(function () {
    let csrf_token = $("#csrf_token").val();
    let name = $("#category-name").val();
    let show_index = $("#show_index").val();
    let id = $("#category-id").val();
    let image = $("#image-category").prop("files")[0];

    let dataPost = new FormData();

    dataPost.append("csrf_token", csrf_token);
    dataPost.append("name", name);
    dataPost.append("show_index", show_index);
    dataPost.append("image", image);

    $("#error-name").html("");
    $("#error-show_index").html("");
    $("#error-image").html("");

    ajaxData("POST", "admin/category/" + id + "/update", dataPost).then(
      (data) => {
        if (data.status == "success") {
          setTimeout(function () {
            window.location.reload();
          }, 1000);
        }
      }
    );
  });

  $(".delete-category").click(function () {
    let el = this;
    let id = $(this).attr("id_category");
    swal({
      title: "Are you sure?",
      text: "It will permanently deleted !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Deleted!",
    }).then(function (result) {
      if (result.value) {
        $.post(URL + "admin/category/delete", { id }, function (data, status) {
          data = JSON.parse(data);
          if (data.error) {
            swal("Delete error!", "Error..........", "warning");
            return;
          }
          swal("Deleted!", "Your category has been deleted.", "success");
          $(el).closest("tr").css("background", "tomato");
          $(el)
            .closest("tr")
            .fadeOut(800, function () {
              $(this).remove();
            });
        });
      }
    });
  });

  $("#delete-categories").click(function () {
    let getInput = $(".input-change:checkbox:checked");
    data = "";
    listId = [];
    getInput.each(function (i, el) {
      data += el.value + ",";
      listId.push(el.value);
    });

    swal({
      title: "Are you sure?",
      text: "It will permanently deleted !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Deleted!",
    }).then(function (result) {
      if (result.value) {
        $.post(
          URL + "admin/category/delete",
          {
            id: data,
          },
          function (data, status) {
            data = JSON.parse(data);
            if (data.error) {
              swal("Delete error!", "Error.........", "warning");
              return;
            }
            swal("Deleted!", "Your categories has been deleted.", "success");
            listId.forEach(function (v) {
              $("#" + v)
                .closest("tr")
                .css("background", "tomato");
              $("#" + v)
                .closest("tr")
                .fadeOut(800, function () {
                  $(this).remove();
                });
            });
          }
        );
      }
    });
  });
  // end category

  $("#update-member").click(function () {
    let csrf_token = $("#csrf_token").val();
    let full_name = $("#full_name").val();
    let username = $("#username").val();
    let birthday = $("#birthday").val();
    let email = $("#email").val();
    let active = $("#active").val();
    let role = $("#role").val();

    let data = {
      csrf_token,
      full_name,
      email,
      birthday,
      active,
      role,
    };

    $("#message").html("");
    $("#error-full_name").html("");
    $("#error-email").html("");
    $("#error-active").html("");
    $("#error-role").html("");

    postData("admin/user/" + username + "", data).then(function (data) {
      if (data.status == "success") {
        setTimeout(function () {
          window.location.reload();
        }, 1000);
      }
    });
  });

  $(".delete-member").click(function () {
    let el = this;
    let username = $(this).attr("username");
    swal({
      title: "Are you sure?",
      text: "It will permanently deleted !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Deleted!",
    }).then(function (result) {
      if (result.value) {
        $.post(URL + "admin/user/delete", { username }, function (
          data,
          status
        ) {
          data = JSON.parse(data);
          if (data.error) {
            swal("Delete error!", "Error..........", "warning");
            return;
          }
          swal("Deleted!", "Your category has been deleted.", "success");
          $(el).closest("tr").css("background", "tomato");
          $(el)
            .closest("tr")
            .fadeOut(800, function () {
              $(this).remove();
            });
        });
      }
    });
  });

  // contact

  $("#reply-email").click(function () {
    let csrf_token = $("#csrf_token").val();
    let title = $("#title").val();
    let email = $("#email").val();
    let id = $("#id").val();
    let message = $("#message").val();

    let data = {
      csrf_token,
      title,
      email,
      id,
      message,
    };

    $("#error-title").html("");
    $("#error-message").html("");

    postData("admin/contact/" + id, data).then(function (data) {
      if (data.status == "success") {
        setTimeout(function () {
          location.reload();
        }, 3500);
      }
    });
  });

  $("#check-all").click(function (event) {
    let input = $(this).children()[0];
    if (input.checked) {
      $(":checkbox").each(function () {
        this.checked = true;
      });
    } else {
      $(":checkbox").each(function () {
        this.checked = false;
      });
    }
  });

  $(".delete-comment").click(function () {
    let el = this;
    let id = $(this).attr("id_comment");
    swal({
      title: "Are you sure?",
      text: "It will permanently deleted !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Deleted!",
    }).then(function (result) {
      if (result.value) {
        $.post(
          URL + "admin/comment/delete",
          {
            id,
          },
          function (data, status) {
            data = JSON.parse(data);
            if (data.error) {
              swal("Delete Error!", "Error.......", "warning");
              return;
            }

            swal("Deleted!", "Your product has been deleted.", "success");

            $(el).closest("tr").css("background", "tomato");
            $(el)
              .closest("tr")
              .fadeOut(800, function () {
                $(this).remove();
              });
          }
        );
      }
    });
  });

  $(".input-change").change(() => {
    let totalCheckbox = $(".input-change:checkbox").length;
    let totalChecked = $(".input-change:checkbox:checked").length;

    if (totalCheckbox == totalChecked) {
      $("#check-all").children()[0].checked = true;
    } else {
      $("#check-all").children()[0].checked = false;
    }
  });

  $(".return-a").click(function () {
    let href = $(this).attr("href");
    location.href = href;
  });

  var PieChart = (function () {
    // Variables

    var $chart = $("#chart-pie-category");

    // Methods

    function init($this) {
      getData("admin/api/chart").then(function (data) {
        let total = [];
        let labels = [];
        data.forEach(function (value) {
          total.push(value.total);
          labels.push(value.name);
        });

        var pieChart = new Chart($this, {
          type: "pie",
          data: {
            labels: labels,
            datasets: [
              {
                data: total,
                backgroundColor: [
                  Charts.colors.theme["danger"],
                  Charts.colors.theme["success"],
                  Charts.colors.theme["primary"],
                  Charts.colors.theme["secondary"],
                  Charts.colors.theme["info"],
                  Charts.colors.theme["warning"],
                  Charts.colors.theme["default"],
                ],
                label: "Dataset 1",
              },
            ],
            warningonsive: true,
            legend: {
              position: "top",
            },
            animation: {
              animateScale: true,
              animateRotate: true,
            },
          },
        });

        // Save to jQuery object

        $this.data("chart", pieChart);
      });
    }

    // Events

    if ($chart.length) {
      init($chart);
    }
  })();

  // user
  $("#update-profile").click(function () {
    let csrf_token = $("#csrf_token").val();
    let full_name = $("#full_name").val();
    let email = $("#email").val();
    let birthday = $("#birthday").val();

    let image = $("#avatar").prop("files")[0];

    let dataPost = new FormData();

    dataPost.append("csrf_token", csrf_token);
    dataPost.append("full_name", full_name);
    dataPost.append("email", email);
    dataPost.append("birthday", birthday);
    dataPost.append("image", image);

    $("#error-full_name").html("");
    $("#error-email").html("");
    $("#error-birthday").html("");
    $("#error-image").html("");

    ajaxData("POST", "profile/", dataPost).then(
      (data) => {
        if (data.status == "success") {
          setTimeout(function () {
            window.location.reload();
          }, 1000);
        }
      }
    );
  });

  $("#change-password").click(function () {
    let csrf_token = $("#csrf_token").val();
    let old_password = $("#old_password").val();
    let password = $("#password").val();
    let re_password = $("#rePassword").val();

    let data = {
      csrf_token,
      old_password,
      password,
      re_password,
    };
    $("#error-old_password").html("");
    $("#error-password").html("");
    $("#error-rePassword").html("");

    postData("user/change-password", data).then(function (
      data
    ) {
      if (data.status == "success") {
        setTimeout(function () {
          location.href = URL +"profile";
        }, 3500);
      }
    });
  });



});

async function postData(url, params) {
  let result = await $.post(URL + url, params, function (data) {
    data = JSON.parse(data);

    if (typeof data.error == "object") {
      $.each(data.error, function (key, value) {
        $("#error-" + key).text(value);
      });
      return;
    }

    let typeStatus = data.status == "success" ? "success" : "warning";
    notify("Successfully", data.message, typeStatus);
  });
  return JSON.parse(result);
}

async function ajaxData(method, url, params) {
  let result = await $.ajax({
    type: method,
    url: URL + url,
    contentType: false,
    processData: false,
    data: params,
    success: function (data) {
      data = JSON.parse(data);
      if (typeof data.error == "object") {
        $.each(data.error, function (key, value) {
          $("#error-" + key).text(value);
        });
        return;
      }

      let typeStatus = data.status == "success" ? "success" : "warning";
      notify("Successfully", data.message, typeStatus);

      // let classStatus =
      //   data.status == "success" ? "alert-success" : "alert-warning";
      // $("#message").append(
      //   '<div class="alert ' +
      //     classStatus +
      //     '" role="alert">' +
      //     data.message +
      //     "</div>"
      // );
    },
  });
  return JSON.parse(result);
}

async function getData(url) {
  let result = await $.get(URL + url, function (data) {
    return data;
  });

  return JSON.parse(result);
}

function notify(
  title,
  message,
  type = "default",
  placement = "top",
  align = "center",
  icon = "ni ni-bell-55",
  animIn = "animated bounceIn",
  animOut = "animated bounceOut"
) {
  $.notify(
    {
      icon: icon,
      title: title,
      message: message,
      url: "",
    },
    {
      element: "body",
      type: type,
      allow_dismiss: true,
      placement: {
        from: placement,
        align: align,
      },
      offset: {
        x: 15,
        y: 15,
      },
      spacing: 10,
      z_index: 1080,
      delay: 1000,
      timer: 1500,
      url_target: "_blank",
      mouse_over: false,
      animate: {
        enter: animIn,
        exit: animOut,
      },
      template:
        '<div data-notify="container" class="alert alert-dismissible alert-{0} alert-notify" role="alert">' +
        '<span class="alert-icon" data-notify="icon"></span> ' +
        '<div class="alert-text"</div> ' +
        '<span class="alert-title" data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        "</div>" +
        '<button type="button" class="close" data-notify="dismiss" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
        "</div>",
    }
  );
}
