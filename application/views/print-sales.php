<?php
require_once 'vendor/autoload.php';  // Adjust the autoload path as needed

use Dompdf\Dompdf;
use Dompdf\Options;
?>

<!DOCTYPE html>
<html>
<title><?= $page_title; ?></title>

<head>
    <?php $this->load->view('comman/code_css.php'); ?>
    <link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />

    <style>
        @page {
            margin: 10px 20px 90px 20px;
        }

        .facture_number_header {
            color: gray;
            font-size: 12px;
            font-weight: normal;
            text-align: left !important;
        }

        .my {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        td {
            padding-top: 5px;
            padding-right: 5px;
            padding-left: 5px;
        }

        .logo img {

            width: 120px;
        }

        .company_details p {
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
            margin-bottom: 3px;
        }

        .company_name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;

        }

        .facture_details {
            background: #E5E5f5;
            padding: 5px 20px;
            width: 100%;
        }

        .facture_details p:first-child {
            margin-top: 10px;
            color: #0c5690;
            font-size: 25px;
            letter-spacing: 2px;
            font-weight: bold;
            text-align: center;
            line-height: 20px;
            margin-top: 20px;

        }

        .facture_details p:nth-child(2) {
            margin-top: 10px;
            color: #0c5690;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-align: center;
        }

        .line {
            width: 100%;
            height: 1px;
            background: #000;
            margin: 10px 0px;
        }

        .dates,
        .dates span {
            text-align: left;
            font-size: 12px;
            margin-bottom: 10px;

        }

        .destina_title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .destina_content {
            font-size: 12px;
            margin-bottom: 10px;
        }

        .p {
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 14px;
        }

        .flex_td {
            display: flex;
            justify-content: start;
            align-items: center;
        }

        .title_facture {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        th {
            font-size: 12px;
            font-weight: bold;
            background: #0c5690;
            color: white;
            padding: 5px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .f-12 {
            font-size: 12px;
        }

        .f-b {
            font-weight: bold;
        }

        .bg-blue {
            background: #0c5690;
            color: white;
        }

        .b-r {
            border-bottom: 2px solid white;
        }

        .box {
            border: 1px solid black;
            padding: 5px;
            height: 40px;
            width: 100%;
            overflow: hidden;
        }

        .mt {
            margin-top: 45px;
        }

        .absolute {
            position: absolute;
            bottom: 0px;
            width: 100%;

        }

        .b-l {

            border-left: 1px solid #0c5690;
        }

        .b-r {
            border-right: 1px solid #0c5690;
        }

        .xd {
            height: 2px;
            width: 100%;
            background: #0c5690;
        }
    </style>
</head>

<body onload="window.print();"><!-- window.print() -->
    <?php


    $q1 = $this->db->query("select * from db_store where status=1 and id=" . get_current_store_id());
    $res1 = $q1->row();
    $store_name = $res1->store_name;
    $company_mobile = $res1->mobile;
    $company_phone = $res1->phone;
    $company_email = $res1->email;
    $company_country = $res1->country;
    $company_state = $res1->state;
    $company_city = $res1->city;
    $company_address = $res1->address;
    $company_gst_no = $res1->gst_no;
    $company_vat_no = $res1->vat_no;
    $company_cnss = $res1->cnss;
    $company_rc = $res1->rc;
    $store_logo = (!empty($res1->store_logo)) ? $res1->store_logo : store_demo_logo();
    $store_website = $res1->store_website;
    $bank_details = $res1->bank_details;
    $terms_and_conditions = ""; //$res1->sales_terms_and_conditions;
    $image_file = ($res1->show_signature && !empty($res1->signature)) ? $res1->signature : '';

    $q3 = $this->db->query("SELECT *

                           FROM db_customers a,
                           db_sales b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$sales_id' 
                           ");


    $res3 = $q3->row();
    $customer_name = $res3->customer_name;
    $customer_mobile = $res3->mobile;
    $customer_phone = $res3->phone;
    $customer_email = $res3->email;
    $customer_country = get_country($res3->country_id);
    $customer_state = get_state($res3->state_id);
    $customer_address = $res3->address;
    $customer_postcode = $res3->postcode;
    $customer_gst_no = $res3->gstin;
    $customer_tax_number = $res3->tax_number;
    $customer_opening_balance = $res3->opening_balance;
    $quotation_date = show_date($res3->sales_date);
    $expire_date = (!empty($res3->expire_date)) ? show_date($res3->expire_date) : '';
    $created_time = $res3->created_time;
    $reference_no = $res3->reference_no;
    $quotation_code = $res3->sales_code;
    $sales_note = $res3->sales_note;
    $quotation_status = $res3->sales;
    $created_by = $res3->created_by;
    $previous_due = $res3->customer_previous_due;
    $total_due = $res3->customer_total_due;
    $payment_status = $res3->payment_status;


    $subtotal = $res3->subtotal;
    $grand_total = $res3->grand_total;
    $other_charges_input = $res3->other_charges_input;
    $other_charges_tax_id = $res3->other_charges_tax_id;
    $other_charges_amt = $res3->other_charges_amt;
    $paid_amount = $res3->paid_amount;
    $discount_to_all_input = $res3->discount_to_all_input;
    $discount_to_all_type = $res3->discount_to_all_type;
    $discount_to_all_type = ($discount_to_all_type == 'in_percentage') ? '%' : 'Fixed';
    $tot_discount_to_all_amt = $res3->tot_discount_to_all_amt;
    $round_off = $res3->round_off;
    $payment_status = $res3->payment_status;

    $shipping_country = '';
    $shipping_state = '';
    $shipping_city = '';
    $shipping_address = '';
    $shipping_postcode = '';
    if (!empty($res3->shippingaddress_id)) {
        $Q2 = $this->db->select("c.country,s.state,a.city,a.postcode,a.address")
            ->where("a.id", $res3->shippingaddress_id)
            ->from("db_shippingaddress a")
            ->join("db_country c", "c.id = a.country_id", 'left')
            ->join("db_states s", "s.id = a.state_id", 'left')
            ->get();
        if ($Q2->num_rows() > 0) {
            $shipping_country = $Q2->row()->country;
            $shipping_state = $Q2->row()->state;
            $shipping_city = $Q2->row()->city;
            $shipping_address = $Q2->row()->address;
            $shipping_postcode = $Q2->row()->postcode;
        }
    }

    $q4 = $this->db->query("SELECT *
                           FROM db_salespayments 
                           WHERE `sales_id`='$sales_id' 
                           ");

    $res4 = $q4->row();
    $payment_type = $res4->payment_type;
    ?>

    <caption>

        <span class="facture_number_header">
            Facture N° <?= $quotation_code ?>
        </span>

    </caption>
    <table>
        <tr>
            <td width="20%">

                <div class="logo">
                    <img src="<?= base_url(get_facture_logo()) ?>" alt="logo" />
                </div>
            </td>
            <td width="45%">
                <div class="company_details">
                    <p class="company_name"><?= $store_name ?></p>
                    <p class="company_address"><?= $company_address ?></p>
                    <p class="company_phone">
                        <?= $company_phone ?>, <?= $company_mobile ?>
                    </p>
                    <p class="company_email"><?= $company_email ?></p>
                    <p class="company_website"><?= $store_website ?></p>
                </div>
            </td>
            <td width="35%">
                <div class="facture_details">
                    <p>Facture</p>
                    <p> Facture N° <?= $quotation_code ?></p>
                    <div class=" line"></div>
                    <div class="dates">
                        Date d'émisson : <span><?= $quotation_date ?></span>
                    </div>
                </div>
            </td>
        </tr>


    </table>




    <!-- <caption>
        <center>
            <span style="font-size: 11px;text-transform: uppercase;">
                This is Computer Generated Invoice
            </span>
        </center>
    </caption> -->
</body>

</html>