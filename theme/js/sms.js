/*Email validation code end*/
$("#send").on("click", function (e) {
  var base_url = $("#base_url").val();
  /*Initially flag set true*/
  var flag = true;

  function check_field(id) {
    if (!$("#" + id).val()) {
      //Also check Others????
      $("#" + id + "_msg")
        .fadeIn(200)
        .show()
        .html("Champ obligatoire")
        .addClass("required");
      $("#" + id).css({ "background-color": "#E8E2E9" });
      flag = false;
    } else {
      $("#" + id + "_msg")
        .fadeOut(200)
        .hide();
      $("#" + id).css({ "background-color": "#FFFFFF" }); //White color
    }
  }

  //Validate Input box or selection box should not be blank or empty
  check_field("mobile");
  check_field("message");

  if (flag == false) {
    toastr["warning"]("Il y a quelque chose que vous avez oublié de remplir.!");
    return;
  }

  var this_id = this.id;

  //swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
  if (confirm("Are you sure ?")) {
    //confirmation start
    $(".box").append(
      '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
    );
    $("#" + this_id).attr("disabled", true); //Enable Save or Update button
    e.preventDefault();
    data = new FormData($("#sms-form")[0]); //form name
    $.ajax({
      type: "POST",
      url: base_url + "sms/send_message",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        // alert(result);//return;
        result = result;
        if (result == "success") {
          toastr["success"]("SMS Sent Successfully!");
          $("#mobile,#message").val("");
          //return;
        } else if (result == "failed") {
          toastr["error"]("Pardon! Impossible d’envoyer des SMS. Réessayez!");
        } else {
          toastr["error"](result);
        }
        $("#" + this_id).attr("disabled", false); //Enable Save or Update button
        $(".overlay").remove();
      },
    });
  } //confirmation sure
  //}); //confirmation end
});

//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent, target) {
  if (kevent.keyCode == 13) {
    $("#" + target).focus();
  }
}

$("#update").on("click", function (e) {
  var base_url = $("#base_url").val();

  var this_id = this.id;

  // swal({ title: "Are you sure?",icon: "warning",buttons: true,dangerMode: true,}).then((sure) => {
  if (confirm("Are you sure ?")) {
    //confirmation start
    $(".box").append(
      '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
    );
    $("#" + this_id).attr("disabled", true); //Enable Save or Update button
    e.preventDefault();
    data = new FormData($("#api-form")[0]); //form name
    $.ajax({
      type: "POST",
      url: base_url + "sms/api_update",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        //alert(result);//return;

        if (result == "success") {
          //window.location=base_url+"sales";
          location.reload();
        } else if (result == "failed") {
          toastr["error"](
            "Pardon! Échec de l’enregistrement de l’enregistrement.Réessayez"
          );
        } else {
          swal(result);
        }

        $("#" + this_id).attr("disabled", false); //Enable Save or Update button
        $(".overlay").remove();
      },
    });
  } //confirmation sure
  //}); //confirmation end
});
