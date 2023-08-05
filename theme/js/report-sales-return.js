$("#view,#view_all").on("click", function () {
  var from_date = document.getElementById("from_date").value;
  var to_date = document.getElementById("to_date").value;
  var customer_id = document.getElementById("customer_id").value;
  if (from_date == "") {
    toastr["warning"]("Sélectionner la date!");
    document.getElementById("from_date").focus();
    return;
  }

  if (to_date == "") {
    toastr["warning"]("Sélectionnez à ce jour!");
    document.getElementById("to_date").focus();
    return;
  }

  if (this.id == "view_all") {
    var view_all = "yes";
  } else {
    var view_all = "no";
  }

  $(".box").append(
    '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
  );
  $.post(
    $("#base_url").val() + "reports/show_sales_return_report",
    {
      customer_id: customer_id,
      view_all: view_all,
      from_date: from_date,
      to_date: to_date,
      store_id: $("#store_id").val(),
      warehouse_id: $("#warehouse_id").val(),
    },
    function (result) {
      //alert(result);
      setTimeout(function () {
        $("#tbodyid").empty().append(result);
        $(".overlay").remove();
      }, 0);
    }
  );
});
