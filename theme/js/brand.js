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
      // $('#'+id).css({'background-color' : '#E8E2E9'});
      flag = false;
    } else {
      $("#" + id + "_msg")
        .fadeOut(200)
        .hide();
      //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
    }
  }

  //Validate Input box or selection box should not be blank or empty
  check_field("brand");

  if (flag == false) {
    toastr["warning"]("Il y a quelque chose que vous avez oublié de remplir.!");
    return;
  }

  var this_id = this.id;

  if (this_id == "save") {
    //Save start
    //if(confirm("Do You Wants to Save Record ?")){
    e.preventDefault();
    data = new FormData($("#brand-form")[0]); //form name
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
      url: base_url + "brands/newbrand",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        // alert(result);return;
        if (result == "success") {
          //alert("Record Saved Successfully!");
          window.location = base_url + "brands/view";
          return;
        } else if (result == "failed") {
          toastr["error"](
            "Pardon! Impossible d’enregistrer Record.Essayez à nouveau!"
          );
          //	return;
        } else {
          toastr["error"](result);
        }
        $("#" + this_id).attr("disabled", false); //Enable Save or Update button
        $(".overlay").remove();
      },
    });
    //}

    //e.preventDefault
  } //Save end
  else if (this_id == "update") {
    //Save start
    //if(confirm("Do You Wants to Update Record ?")){
    e.preventDefault();
    data = new FormData($("#brand-form")[0]); //form name
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
      url: base_url + "brands/update_brand",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        //alert(result);return;
        if (result == "success") {
          //toastr["success"]("Enregistrement mis à jour avec succès!");
          window.location = base_url + "brands/view";
        } else if (result == "failed") {
          toastr["error"](
            "Pardon! Impossible d’enregistrer Record.Essayez à nouveau!"
          );
          //alert("Sorry! Failed to save Record.Try again");
          //	return;
        } else {
          toastr["error"](result);
        }
        $("#" + this_id).attr("disabled", false); //Enable Save or Update button
        $(".overlay").remove();
      },
    });
    //}

    //e.preventDefault
  } //Save end
});

//On Enter Move the cursor to desigtation Id
function shift_cursor(kevent, target) {
  if (kevent.keyCode == 13) {
    $("#" + target).focus();
  }
}

//update status start
function update_status(id, status) {
  var base_url = $("#base_url").val();
  $.post(
    base_url + "brands/update_status",
    { id: id, status: status },
    function (result) {
      if (result == "success") {
        toastr["success"]("Statut mis à jour avec succès!");
        //alert("Status Updated Successfully!");
        success.currentTime = 0;
        success.play();
        if (status == 0) {
          status = "Inactive";
          var span_class = "label label-danger";
          $("#span_" + id).attr("onclick", "update_status(" + id + ",1)");
        } else {
          status = "Active";
          var span_class = "label label-success";
          $("#span_" + id).attr("onclick", "update_status(" + id + ",0)");
        }

        $("#span_" + id).attr("class", span_class);
        $("#span_" + id).html(status);
        return false;
      } else if (result == "failed") {
        toastr["error"]("Impossible de mettre à jour l’état.Réessayez !");
        failed.currentTime = 0;
        failed.play();

        return false;
      } else {
        toastr["error"](result);
        failed.currentTime = 0;
        failed.play();
        return false;
      }
    }
  );
}
//update status end

//Delete Record start
function delete_brand(q_id) {
  if (confirm("Do You Wants to Delete Record ?")) {
    $(".box").append(
      '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
    );
    $.post("delete_brand", { q_id: q_id }, function (result) {
      //alert(result);return;
      if (result == "success") {
        toastr["success"]("Enregistrement supprimé avec succès!");
        $("#example2").DataTable().ajax.reload();
      } else if (result == "failed") {
        toastr["error"]("Echec de la suppression . Réessayez!");
      } else {
        toastr["error"](result);
      }
      $(".overlay").remove();
      return false;
    });
  } //end confirmation
}
//Delete Record end

function multi_delete() {
  //var base_url=$("#base_url").val();
  var this_id = this.id;

  if (confirm("Are you sure ?")) {
    $(".box").append(
      '<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>'
    );
    $("#" + this_id).attr("disabled", true); //Enable Save or Update button

    data = new FormData($("#table_form")[0]); //form name
    $.ajax({
      type: "POST",
      url: "multi_delete",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      success: function (result) {
        result = result;
        //alert(result);return;
        if (result == "success") {
          toastr["success"]("Enregistrement supprimé avec succès!");
          success.currentTime = 0;
          success.play();
          $("#example2").DataTable().ajax.reload();
          $(".delete_btn").hide();
          $(".group_check").prop("checked", false).iCheck("update");
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
      },
    });
  }
  //e.preventDefault
}
