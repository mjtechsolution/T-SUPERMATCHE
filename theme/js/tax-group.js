$("#save,#update").on("click", function (e) {
  var base_url = $("#base_url").val();
  //Initially flag set true
  var flag = true;

  function check_field(id) {
    if (!$("#" + id).val()) {
      //Also check Others????
      $("#" + id + "_msg")
        .fadeIn(200)
        .show()
        .html("Champ obligatoire")
        .addClass("required");
      //$('#'+id).css({'background-color' : '#E8E2E9'});
      flag = false;
    } else {
      $("#" + id + "_msg")
        .fadeOut(200)
        .hide();
      //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
    }
  }

  //Validate Input box or selection box should not be blank or empty
  check_field("tax_name");
  check_field("tax");

  if (flag == false) {
    toastr["warning"]("Il y a quelque chose que vous avez oublié de remplir.!");
    return;
  }

  var this_id = this.id;

  if (this_id == "save") {
    //Save start
    //if(confirm("Are you sure ?")){
    e.preventDefault();
    data = new FormData($("#tax-form")[0]); //form name
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
      url: base_url + "tax_group/newtax",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        //alert(result);return;
        if (result == "success") {
          //alert("Record Saved Successfully!");
          window.location = base_url + "tax";
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
    // } //confirmation sure

    //e.preventDefault
  } //Save end
  else if (this_id == "update") {
    //update start

    //if(confirm("Are you sure ?")){
    e.preventDefault();
    data = new FormData($("#tax-form")[0]); //form name
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
      url: base_url + "tax_group/update_tax",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        //alert(result);return;
        if (result == "success") {
          //toastr["success"]("Enregistrement mis à jour avec succès!");
          window.location = base_url + "tax";
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
    //}//confirmation sure

    //e.preventDefault
  } //update end
});
