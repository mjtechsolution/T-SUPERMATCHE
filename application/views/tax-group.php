<!DOCTYPE html>
<html>

<head>
  <!-- TABLES CSS CODE -->
  <?php include "comman/code_css.php"; ?>
  <!-- </copy> -->
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include "sidebar.php"; ?>
    <?php
    if (!isset($tax)) {
      $tax_name = $tax = $q_id = $subtax_ids = $store_id = "";
    }
    ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?= $this->lang->line('tax'); ?>
          <small><?= $this->lang->line('add/edit') ?> Tax</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Acceuil</a></li>
          <li><a href="<?php echo $base_url; ?>tax"><?= $this->lang->line('tax_list'); ?></a></li>
          <li class="active"><?= $this->lang->line('tax'); ?></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- ********** ALERT MESSAGE START******* -->
          <?php include "comman/code_flashdata.php"; ?>
          <!-- ********** ALERT MESSAGE END******* -->
          <!-- right column -->
          <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-primary ">
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" id="tax-form">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                <div class="box-body">

                  <!-- Store Code -->
                  <?php /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>$store_id)); }else{*/
                  echo "<input type='hidden' name='store_id' id='store_id' value='" . get_current_store_id() . "'>";
                  /*}*/ ?>
                  <!-- Store Code end -->

                  <div class="form-group">
                    <label for="tax_name" class="col-sm-2 control-label"><?= $this->lang->line('tax_name'); ?><label class="text-danger">*</label></label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control input-sm " id="tax_name" name="tax_name" placeholder="" value="<?php print $tax_name; ?>" autofocus onkeyup="shift_cursor(event,'tax')">
                      <span id="tax_name_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="subtax_ids" class="col-sm-2 control-label"><?= $this->lang->line('sub_taxes'); ?><label class="text-danger">*</label></label>
                    <div class="col-sm-4">
                      <select class="form-control select2" multiple="multiple" id='subtax_ids' name="subtax_ids[]" data-placeholder="Select Tax's" style="width: 100%;">
                        <?php
                        $query1 = "SELECT * FROM db_tax WHERE (group_bit IS NULL) and store_id=" . get_current_store_id();
                        $q1 = $this->db->query($query1);
                        if ($q1->num_rows($q1) > 0) {
                          echo '<option data-tax="0" value="">-choisir-</option>';
                          foreach ($q1->result() as $res1) {

                            $selected = (strpos($subtax_ids, $res1->id) !== false) ? 'selected' : '';
                            echo "<option $selected data-tax='" . $res1->tax . "' value='" . $res1->id . "'>" . $res1->tax_name . "</option>";
                          }
                        } else {
                        ?>
                          <option value="">No Records Found</option>
                        <?php
                        }
                        ?>
                      </select>
                      <span id="subtax_ids_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tax" class="col-sm-2 control-label"><?= $this->lang->line('tax_percentage'); ?><label class="text-danger">*</label></label>
                    <div class="col-sm-4">
                      <input readonly="" type="text" class="form-control input-sm only_currency" id="tax" name="tax" placeholder="" value="<?php print $tax; ?>" autofocus onkeyup="shift_cursor(event,'save')">
                      <span id="tax_msg" style="display:none" class="text-danger"></span>
                    </div>
                  </div>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-sm-8 col-sm-offset-2 text-center">
                    <!-- <div class="col-sm-4"></div> -->
                    <?php
                    if ($tax != "") {
                      $btn_name = "Update";
                      $btn_id = "update";
                    ?>
                      <input type="hidden" name="q_id" id="q_id" value="<?php echo $q_id; ?>" />
                    <?php
                    } else {
                      $btn_name = "Save";
                      $btn_id = "save";
                    }

                    ?>

                    <div class="col-md-3 col-md-offset-3">
                      <button type="button" id="<?php echo $btn_id; ?>" class=" btn btn-block btn-success" title="Save Data"><?= $this->lang->line('save') ?></button>
                    </div>
                    <div class="col-sm-3">
                      <a href="<?= base_url('dashboard'); ?>">
                        <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard"><?= $this->lang->line('close') ?></button>
                      </a>
                    </div>
                  </div>
                </div>
                <!-- /.box-footer -->
              </form>
            </div>
            <!-- /.box -->

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include "footer.php"; ?>


    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->

  <!-- SOUND CODE -->
  <?php include "comman/code_js_sound.php"; ?>
  <!-- TABLES CODE -->
  <?php include "comman/code_js.php"; ?>

  <script src="<?php echo $theme_link; ?>js/tax-group.js"></script>
  <script type="text/javascript">
    $("#subtax_ids").on("change", function(event) {
      var tax_total = 0;
      $.each($("#subtax_ids option:selected"), function() {
        tax_total += parseFloat($(this).attr('data-tax'));
      });
      $("#tax").val(to_Fixed(tax_total));
    });
  </script>
  <script type="text/javascript">
    <?php if (isset($q_id)) { ?>
      $("#store_id").attr('readonly', true);
    <?php } ?>
  </script>
  <!-- Make sidebar menu hughlighter/selector -->
  <script>
    $(".tax-active-li").addClass("active");
  </script>
</body>

</html>