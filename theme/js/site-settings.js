$("#update").on("click", function (e) {
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
      flag = false;
    } else {
      $("#" + id + "_msg")
        .fadeOut(200)
        .hide();
    }
  }

  //Validate Input box or selection box should not be blank or empty
  check_field("site_name");

  if (flag == false) {
    toastr["warning"]("Il y a quelque chose que vous avez oublié de remplir.!");
    return;
  }

  var this_id = this.id;
  if (confirm("Do you wants to update ?")) {
    e.preventDefault();
    data = new FormData($("#site-form")[0]); //form name
    /*Check XSS Code*/
    if (!xss_validation(data)) {
      return false;
    }

    $(".box").append(
      '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
    );
    $("#" + this_id).attr("disabled", true); //Enable Save or Update button
    $.ajax({
      type: "POST",
      url: base_url + "site/update_site",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        //alert(result);//return;
        if (result == "success") {
          toastr["success"]("Enregistrement mis à jour avec succès!");
          success.currentTime = 0;
          success.play();
        } else if (result == "failed") {
          toastr["error"](
            "Pardon! Impossible d’enregistrer Record.Essayez à nouveau!"
          );
          failed.currentTime = 0;
          failed.play();
        } else {
          toastr["error"](result);
          failed.currentTime = 0;
          failed.play();
        }
        $("#" + this_id).attr("disabled", false); //Enable Save or Update button
        $(".overlay").remove();
        return;
      },
    });
  }

  //e.preventDefault
});

//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent, target) {
  if (kevent.keyCode == 13) {
    $("#" + target).focus();
  }
}
