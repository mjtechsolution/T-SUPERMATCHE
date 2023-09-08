<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Dompdf;
use Dompdf\Options;

class Delivery extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load_global();
		$this->load->model('delivery_model', 'delivery');
		$this->load->helper('sms_template_helper');
	}

	public function is_sms_enabled()
	{
		return is_sms_enabled();
	}

	public function index()
	{
		$this->permission_check('quotation_view');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('delivery_list');
		$this->load->view('delivery/delivery_list', $data);
	}
	public function add()
	{
		$this->permission_check('quotation_add');
		$data = $this->data;
		$data['page_title'] = $this->lang->line('delivery_add');
		$this->load->view('delivery/delivery', $data);
	}



	public function delivery_save_and_update()
	{
		$this->form_validation->set_rules('delivery_date', 'delivery Date', 'trim|required');
		$this->form_validation->set_rules('customer_id', 'Customer Name', 'trim|required');

		if ($this->form_validation->run() == TRUE) {
			$result = $this->delivery->verify_save_and_update();
			echo $result;
		} else {
			echo "Veuillez remplir les champs obligatoires (marqués par un *).";
		}
	}


	public function update($id)
	{
		$this->belong_to('db_sales', $id);
		$this->permission_check('quotation_edit');
		$data = $this->data;
		$data = array_merge($data, array('sales_id' => $id));
		$data['page_title'] = $this->lang->line('delivery');
		$this->load->view('delivery/delivery', $data);
	}


	public function ajax_list()
	{
		$list = $this->delivery->get_datatables();

		$data = array();
		$no = $_POST['start'];
		foreach ($list as $delivery) {

			$no++;
			$row = array();
			$row[] = '<input type="checkbox" name="checkbox[]" value=' . $delivery->id . ' class="checkbox column_checkbox" >';

			$str = '';
			if ($delivery->sales_status != '')
				$str = "<span title='Converted to Sales Invoice' class='label label-success' style='cursor:pointer'> Converted </span>";
			$row[] = show_date($delivery->delivery_date) . "<br>" . $str;
			$row[] = (!empty($delivery->expire_date)) ? show_date($delivery->expire_date) : '';

			$row[] = $delivery->delivery_code;

			$row[] = $delivery->reference_no;
			$row[] = $delivery->customer_name;

			$row[] = store_number_format($delivery->grand_total);
			$row[] = ($delivery->created_by);

			$str1 = base_url() . 'delivery/update/';

			$str2 = '<div class="btn-group" title="View Account">
										<a class="btn btn-primary btn-o dropdown-toggle" data-toggle="dropdown" href="#">
											Action <span class="caret"></span>
										</a>
										<ul role="menu" class="dropdown-menu dropdown-light pull-right">';

		

			if ($this->permissions('quotation_view'))
				$str2 .= '<li>
												<a title="View Invoice" href="' . base_url() . 'delivery/invoice/' . $delivery->id . '" >
													<i class="fa fa-fw fa-eye text-blue"></i>View delivery
												</a>
											</li>';

			if ($this->permissions('quotation_edit'))
				$str2 .= '<li>
												<a title="Update Record ?" href="' . $str1 . $delivery->id . '">
													<i class="fa fa-fw fa-edit text-blue"></i>Modifier
												</a>
											</li>';

			if ($this->permissions('quotation_add') || $this->permissions('quotation_edit'))
				$str2 .= '<li>
												<a title="Take Print" target="_blank" href="' . base_url() . 'delivery/print_invoice/' . $delivery->id . '">
													<i class="fa fa-fw fa-print text-blue"></i>Print
												</a>
											</li>

											<li>
												<a title="Download PDF" target="_blank" href="' . base_url() . 'delivery/pdf/' . $delivery->id	 . '">
													<i class="fa fa-fw fa-file-pdf-o text-blue"></i>PDF
												</a>
											</li>';

			if ($this->permissions('quotation_delete'))
				$str2 .= '<li>
												<a style="cursor:pointer" title="Delete Record ?" onclick="delete_delivery(\'' . $delivery->id . '\')">
													<i class="fa fa-fw fa-trash text-red"></i>Supprimer
												</a>
											</li>
											
										</ul>
									</div>';

			$row[] = $str2;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->delivery->count_all(),
			"recordsFiltered" => $this->delivery->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
	public function update_status()
	{
		$this->permission_check('quotation_edit');
		$id = $this->input->post('id');
		$status = $this->input->post('status');


		$result = $this->delivery->update_status($id, $status);
		return $result;
	}
	public function delete_delivery()
	{
		$this->permission_check_with_msg('quotation_delete');
		$id = $this->input->post('q_id');
		echo $this->delivery->delete_delivery($id);
	}
	public function multi_delete()
	{
		$this->permission_check_with_msg('quotation_delete');
		$ids = implode(",", $_POST['checkbox']);
		echo $this->delivery->delete_delivery($ids);
	}


	//Table ajax code
	public function search_item()
	{
		$q = $this->input->get('q');
		$result = $this->delivery->search_item($q);
		echo $result;
	}
	public function find_item_details()
	{
		$id = $this->input->post('id');

		$result = $this->delivery->find_item_details($id);
		echo $result;
	}

	//delivery invoice form
	public function invoice($id)
	{
		$this->belong_to('db_delivery', $id);
		if (!$this->permissions('quotation_view')) {
			$this->show_access_denied_page();
		}
		$data = $this->data;
		$data = array_merge($data, array('delivery_id' => $id));
		$data['page_title'] = $this->lang->line('delivery_invoice');
		$this->load->view('delivery/delivery-invoice', $data);
	}

	//Print delivery invoice 
	public function print_invoice($delivery_id)
	{
		$this->belong_to('db_delivery', $delivery_id);
		if (!$this->permissions('quotation_add') && !$this->permissions('quotation_edit')) {
			$this->show_access_denied_page();
		}
		$data = $this->data;
		$data = array_merge($data, array('delivery_id' => $delivery_id));
		$data['page_title'] = 'Livraison';

		$this->load->view('delivery/print-delivery-invoice', $data);
	}


	public function pdf($delivery_id)
	{
		if (!$this->permissions('quotation_add') && !$this->permissions('quotation_edit')) {
			$this->show_access_denied_page();
		}

		$data = $this->data;
		$data['page_title'] = $this->lang->line('quotation_invoice');
		$data = array_merge($data, array('sales_id' => $sales_id,'delivery_id' => $delivery_id));

		$this->load->view('delivery/print-delivery-invoice-2', $data);



		// Get output html
		$html = $this->output->get_output();
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new Dompdf($options);

		// Load HTML content
		$dompdf->loadHtml($html, 'UTF-8');

		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('A4', 'portrait');/*landscape or portrait*/

		// Render the HTML as PDF
		$dompdf->render();
		$pdf = $dompdf->getCanvas();
		$font = $dompdf->getFontMetrics()->getFont("Arial", "normal");
		$size = 9;
		$pageCount = $dompdf->getCanvas()->get_page_count();
		// hiegth -10
		$x = $dompdf->getCanvas()->get_height() - 32;
		$y = $dompdf->getCanvas()->get_width() - 27;
		// color gray

		for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
			$pdf->page_text($y, $x,  "$pageCount", $font, $size, array(12, 12, 12));
		}

		// Output the generated PDF (1 = download and 0 = preview)
		$dompdf->stream("delivery_$delivery_id-" . date('M') . "_" . date('d') . "_" . date('Y'), array("Attachment" => 0));
	}




	/*v1.1*/
	public function return_row_with_data($rowcount, $item_id)
	{
		echo $this->delivery->get_items_info($rowcount, $item_id);
	}
	public function return_delivery_list($sales_id)
	{
		echo $this->delivery->return_delivery_list($sales_id);
	}

	public function show_pay_now_modal()
	{
		$this->permission_check_with_msg('quotation_view');
		$delivery_id = $this->input->post('delivery_id');
		echo $this->delivery->show_pay_now_modal($delivery_id);
	}
	public function save_payment()
	{
		$this->permission_check_with_msg('quotation_add');
		echo $this->delivery->save_payment();
	}
	public function view_payments_modal()
	{
		$this->permission_check_with_msg('quotation_view');
		$delivery_id = $this->input->post('delivery_id');
		echo $this->delivery->view_payments_modal($delivery_id);
	}
	public function get_customers_select_list()
	{
		echo get_customers_select_list(null, $_POST['store_id']);
	}
	public function get_items_select_list()
	{
		echo get_items_select_list(null, $_POST['store_id']);
	}
	public function get_tax_select_list()
	{
		echo get_tax_select_list(null, $_POST['store_id']);
	}
	/*Get warehouse select list*/
	public function get_warehouse_select_list()
	{
		echo get_warehouse_select_list(null, $_POST['store_id']);
	}
	//Print delivery Payment Receipt
	public function print_show_receipt($payment_id)
	{
		if (!$this->permissions('quotation_add') && !$this->permissions('quotation_edit')) {
			$this->show_access_denied_page();
		}
		$data = $this->data;
		$data['page_title'] = $this->lang->line('payment_receipt');
		$data = array_merge($data, array('payment_id' => $payment_id));
		$this->load->view('print-cust-payment-receipt', $data);
	}

	public function get_users_select_list()
	{
		echo get_users_select_list($this->session->userdata("role_id"), $_POST['store_id']);
	}
}