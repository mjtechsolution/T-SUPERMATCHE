<!DOCTYPE html>
<html>

<head>
   <!-- TABLES CSS CODE -->
   <?php $this->load->view('comman/code_css.php'); ?>
   <!-- </copy> -->
</head>

<body class="hold-transition skin-blue sidebar-mini">
   <div class="wrapper">
      <?php $this->load->view('sidebar'); ?>
      <?php
      $CI = &get_instance();
      if (!isset($variant_name)) {
         $variant_code = $variant_name = $description = $store_id = "";
      }
      ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
            <h1>
               <?= $page_title; ?>
               <small><?= $this->lang->line('add/edit') ?> Variante</small>
            </h1>
            <ol class="breadcrumb">
               <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Acceuil</a></li>
               <li><a href="<?php echo $base_url; ?>variants/view"><?= $this->lang->line('variants_list'); ?></a></li>
               <li class="active"><?= $page_title; ?></li>
            </ol>
         </section>
         <!-- Main content -->
         <section class="content">
            <div class="row">
               <!-- right column -->
               <div class="col-md-12">
                  <!-- Horizontal Form -->
                  <div class="box box-info ">
                     <div class="box-header with-border">
                        <h3 class="box-title">Veuillez saisir des données valides</h3>
                     </div>
                     <!-- /.box-header -->
                     <!-- form start -->
                     <form class="form-horizontal" id="variant-form" onkeypress="return event.keyCode != 13;">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                        <div class="box-body">
                           <!-- Store Code -->
                           <?php /*if(store_module() && is_admin()) {$this->load->view('store/store_code',array('show_store_select_box'=>true,'store_id'=>$store_id)); }else{*/
                           echo "<input type='hidden' name='store_id' id='store_id' value='" . get_current_store_id() . "'>";
                           /*}*/ ?>
                           <!-- Store Code end -->
                           <div class="form-group">
                              <label for="variant" class="col-sm-2 control-label"><?= $this->lang->line('variant_name'); ?><label class="text-danger">*</label></label>
                              <div class="col-sm-4">
                                 <input type="text" class="form-control input-sm" id="variant" name="variant" placeholder="" onkeyup="shift_cursor(event,'description')" value="<?php print $variant_name; ?>" autofocus>
                                 <span id="variant_msg" style="display:none" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="description" class="col-sm-2 control-label"><?= $this->lang->line('description'); ?></label>
                              <div class="col-sm-4">
                                 <textarea type="text" class="form-control" id="description" name="description" placeholder=""><?php print $description; ?></textarea>
                                 <span id="description_msg" style="display:none" class="text-danger"></span>
                              </div>
                           </div>
                        </div>
                        <!-- /.box-footer -->
                        <div class="box-footer">
                           <div class="col-sm-8 col-sm-offset-2 text-center">
                              <!-- <div class="col-sm-4"></div> -->
                              <?php
                              if (isset($q_id)) {
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
      <?php $this->load->view('footer'); ?>
      <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
   </div>
   <!-- ./wrapper -->
   <!-- SOUND CODE -->
   <?php $this->load->view('comman/code_js_sound'); ?>
   <!-- TABLES CODE -->
   <?php $this->load->view('comman/code_js'); ?>
   <script src="<?php echo $theme_link; ?>js/variants/variants.js"></script>
   <script type="text/javascript">
      <?php if (isset($q_id)) { ?>
         $("#store_id").attr('readonly', true);
      <?php } ?>
   </script>
   <!-- Make sidebar menu hughlighter/selector -->
   <script>
      $(".<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");
   </script>
</body>

</html>