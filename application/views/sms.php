<!DOCTYPE html>
<html>

<head>
  <!-- FORM CSS CODE -->
  <?php include "comman/code_css.php"; ?>
  <!-- </copy> -->
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include "sidebar.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <?= $this->lang->line('send_sms'); ?>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Acceuil</a></li>
          <li class="active"><?= $this->lang->line('send_sms'); ?></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="row">
          <!-- right column -->
          <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="col-md-6">
              <div class="box box-primary">

                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="sms-form" onkeypress="return event.keyCode != 13;">
                  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="mobile"><?= $this->lang->line('mobile'); ?> <span class="text-danger">*</span></label>
                      <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile 1,Mobile 2,...">
                      <span id="mobile_msg" style="display:none" class="text-danger"></span>
                    </div>
                    <div class="form-group">
                      <label for="message"><?= $this->lang->line('message'); ?> <span class="text-danger">*</span></label>
                      <textarea type="text" class="form-control" id="message" name="message" placeholder=""></textarea>
                      <span id="message_msg" style="display:none" class="text-danger"></span>
                    </div>

                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                    <div class="col-md-3 col-md-offset-3">
                      <button type="button" id="send" class=" btn btn-block btn-success" title="Save Data">Send</button>
                    </div>
                    <div class="col-sm-3">
                      <a href="<?= base_url('dashboard'); ?>">
                        <button type="button" class="col-sm-3 btn btn-block btn-warning close_btn" title="Go Dashboard"><?= $this->lang->line('close') ?></button>
                      </a>
                    </div>

                  </div>
                </form>
              </div>
              <!-- /.box -->
            </div>


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

  <script src="<?php echo $theme_link; ?>js/sms.js"></script>
  <!-- Make sidebar menu hughlighter/selector -->
  <script>
    $(".<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");
  </script>

</body>

</html>