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
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
            <h1>
               <?= $page_title; ?>
               <small></small>
            </h1>
            <ol class="breadcrumb">
               <li><a href="<?php echo $base_url; ?>dashboard"><i class="fa fa-dashboard"></i> Acceuil</a></li>
               <li class="active"><?= $page_title; ?></li>
            </ol>
         </section>
         <!-- Main content -->
         <section class="content">
            <div class="row">
               <!-- right column -->
               <div class="col-md-12">
                  <!-- Horizontal Form -->
                  <div class="box box-primary ">
                     <div class="box-header with-border">
                        <h3 class="box-title">Please Enter Valid Information</h3>
                     </div>
                     <!-- /.box-header -->
                     <!-- form start -->
                     <form class="form-horizontal" id="report-form" onkeypress="return event.keyCode != 13;">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" id="base_url" value="<?php echo $base_url;; ?>">
                        <div class="box-body">
                           <div class="form-group">
                              <!-- Store Code -->
                              <?php if (store_module() && is_admin()) {
                                 $this->load->view('store/store_code', array('show_store_select_box' => true, 'store_id' => get_current_store_id(), 'div_length' => 'col-sm-3', 'show_all' => 'true', 'form_group_remove' => 'true'));
                              } else {
                                 echo "<input type='hidden' name='store_id' id='store_id' value='" . get_current_store_id() . "'>";
                              } ?>
                              <!-- Store Code end -->

                           </div>
                           <div class="form-group">
                              <!-- Warehouse Code -->
                              <?php

                              if (true) {
                                 $this->load->view('warehouse/warehouse_code', array('show_warehouse_select_box' => true, 'div_length' => 'col-sm-3', 'show_all' => 'true', 'form_group_remove' => 'true', 'show_all_option' => true));
                              } else {
                                 echo "<input type='hidden' name='warehouse_id' id='warehouse_id' value='" . get_store_warehouse_id() . "'>";
                              }
                              ?>
                              <!-- Warehouse Code end -->

                              <label for="item_id" class="col-sm-2 control-label"><?= $this->lang->line('item_type'); ?></label>
                              <div class="col-sm-3">
                                 <select class="form-control select2 " id="item_type" name="item_type">
                                    <option value="">-Tous-</option>
                                    <option value="Items">Items</option>
                                    <option value="Services">Services</option>

                                 </select>
                                 <span id="item_id_msg" style="display:none" class="text-danger"></span>
                              </div>

                           </div>
                           <div class="form-group">
                              <label for="category_id" class="col-sm-2 control-label"><?= $this->lang->line('category'); ?></label>
                              <div class="col-sm-3">
                                 <select class="form-control select2 " id="category_id" name="category_id">
                                    <option value="">-Tous-</option>
                                    <?= get_categories_select_list(null, get_current_store_id()); ?>
                                 </select>
                                 <span id="category_id_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <label for="item_id" class="col-sm-2 control-label"><?= $this->lang->line('item_name'); ?></label>
                              <div class="col-sm-3">
                                 <select class="form-control select2 " id="item_id" name="item_id">
                                 </select>
                                 <span id="item_id_msg" style="display:none" class="text-danger"></span>
                              </div>
                           </div>
                           <div class="form-group">
                              <label for="from_date" class="col-sm-2 control-label"><?= $this->lang->line('from_date'); ?></label>
                              <div class="col-sm-3">
                                 <div class="input-group date">
                                    <div class="input-group-addon">
                                       <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" id="from_date" name="from_date" value="<?php echo show_date(date('d-m-Y')); ?>">
                                 </div>
                                 <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
                              </div>
                              <label for="to_date" class="col-sm-2 control-label"><?= $this->lang->line('to_date'); ?></label>
                              <div class="col-sm-3">
                                 <div class="input-group date">
                                    <div class="input-group-addon">
                                       <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right datepicker" id="to_date" name="to_date" value="<?php echo show_date(date('d-m-Y')) ?>">
                                 </div>
                                 <span id="Sales_date_msg" style="display:none" class="text-danger"></span>
                              </div>
                           </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                           <div class="col-sm-8 col-sm-offset-2 text-center">
                              <div class="col-md-3 col-md-offset-3">
                                 <button type="button" id="view" class=" btn btn-block btn-success" title="Save Data">Afficher</button>
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
         <section class="content">
            <div class="row">
               <!-- right column -->
               <div class="col-md-12">
                  <div class="box">
                     <div class="box-header">
                        <h3 class="box-title"><?= $this->lang->line('records_table'); ?></h3>
                        <?php $this->load->view('components/export_btn', array('tableId' => 'report-data')); ?>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body table-responsive no-padding">
                        <table class="table table-bordered table-hover " id="report-data">
                           <thead>
                              <tr class="bg-blue">
                                 <th style="">#</th>
                                 <?php if (store_module() && is_admin()) { ?>
                                    <th style=""><?= $this->lang->line('store_name'); ?></th>
                                 <?php } ?>

                                 <th style=""><?= $this->lang->line('item_name'); ?></th>
                                 <th style=""><?= $this->lang->line('category'); ?></th>
                                 <th style=""><?= $this->lang->line('quantity'); ?></th>

                              </tr>
                           </thead>
                           <tbody id="tbodyid">
                           </tbody>
                        </table>
                     </div>
                     <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
               </div>
            </div>
         </section>
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
   <!-- TABLE EXPORT CODE -->
   <?php include "comman/code_js_export.php"; ?>
   <script src="<?php echo $theme_link; ?>js/sheetjs.js" type="text/javascript"></script>

   <script src="<?php echo $theme_link; ?>js/ajaxselect/item_select_ajax.js"></script>
   <script>
      //Item Selection Box Search
      function getItemSelectionId() {
         return '#item_id';
      }
      //Item Selection Box Search - END
   </script>


   <script type="text/javascript">
      var base_url = $("#base_url").val();
      $("#store_id").on("change", function() {
         var store_id = $(this).val();
         //Load Items
         autoLoadFirstItem();

         //Load Categories
         load_category_list();

         //Ajax to load warehouses
         $.post(base_url + "sales/get_warehouse_select_list", {
            store_id: store_id
         }, function(result) {
            result = '<option value="">-Tous-</option>' + result;
            $("#warehouse_id").html('').append(result).select2();
         });
      });

      $("#category_id, #item_type").on("change", function() {
         autoLoadFirstItem();
      });

      //Ajax to load categories
      function load_category_list() {
         var store_id = $("#store_id").val();
         $.post(base_url + "sales/get_categories_select_list", {
            store_id: store_id
         }, function(result) {
            result = '<option value="">-Tous-</option>' + result;
            $("#category_id").html('').append(result).select2();
         });
      }
   </script>
   <script type="text/javascript">
      function load_records() {

         $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');


         data = new FormData($('#report-form')[0]); //form name
         /*Check XSS Code*/
         if (!xss_validation(data)) {
            return false;
         }

         $(".box").append('<div class="overlay"><i class="fa fa-refresh fa-spin"></i></div>');
         $("#view").attr('disabled', true); //Enable Save or Update button
         $.ajax({
            type: 'POST',
            url: base_url + 'reports/show_sales_summary_report',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {

               $("#tbodyid").empty().append(result);

               $("#view").attr('disabled', false); //Enable Save or Update button
               $(".overlay").remove();

            }
         });

      }


      $("#view").on("click", function() {
         check_field("from_date");
         check_field("to_date");

         load_records();

      });


      function check_field(id) {

         if (!$("#" + id).val()) //Also check Others????
         {

            $('#' + id + '_msg').fadeIn(200).show().html('Champ obligatoire').addClass('required');
            // $('#'+id).css({'background-color' : '#E8E2E9'});
            flag = false;
         } else {
            $('#' + id + '_msg').fadeOut(200).hide();
            //$('#'+id).css({'background-color' : '#FFFFFF'});    //White color
         }
      }
   </script>
   <!-- Make sidebar menu hughlighter/selector -->
   <script>
      $(".<?php echo basename(__FILE__, '.php'); ?>-active-li").addClass("active");
   </script>
</body>

</html>