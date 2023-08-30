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
    <div class="line my"></div>

    <table width="100%">
        <tr>
            <td colspan="3">
                <p>DESTINATAIRE : </p>
            </td>
        </tr>


        <tr>
            <td>
                <div class="destina_content">
                    <?php echo  "<b>" . $this->lang->line('name') . " : </b> " . $customer_name; ?><br />
                    <?php echo (!empty(trim($customer_mobile))) ? "<b>" . $this->lang->line('mobile') . " : </b>" . $customer_mobile . "<br>" : ''; ?>
                    <?php
                    if (!empty($customer_address)) {
                        echo "<b>Addresse : </b>  " . $customer_address;
                    }
                    if (!empty($customer_country)) {
                        echo $customer_country;
                    }
                    if (!empty($customer_state)) {
                        echo "," . $customer_state;
                    }
                    if (!empty($customer_city)) {
                        echo "," . $customer_city;
                    }
                    if (!empty($customer_postcode)) {
                        echo "-" . $customer_postcode;
                    }
                    ?>
                    <br>
                    <?php echo (!empty(trim($customer_email))) ? "<b>" . $this->lang->line('email') . " : </b> " . $customer_email . "<br>" : ''; ?>
                    <?php echo (!empty(trim($customer_gst_no))) ? "<b>" . $this->lang->line('gst_number') . " : </b> " . $customer_gst_no . "<br>" : ''; ?>
                    <?php echo (!empty(trim($customer_tax_number))) ? "<b>" . $this->lang->line('tax_number') . " :</b> " . $customer_tax_number . "<br>" : ''; ?>
                </div>
            </td>
            <td class="flex_td">
                <div class="destina_content">
                    <?= "<b>Mode de paiement : </b>" .  $payment_type . " </br>"; ?>
                    <?= "<b>statut de paiement : </b>" .  $payment_status . " </br>"; ?>
                    <br>
                </div>
            </td>
        </tr>
    </table>


    <div class="title_facture">
        <p>DETAILS DE LA FACTURE</p>
    </div>

    <table width="100%">
        <tr>
            <th width="40%" class="text-left p">
                Description
            </th>
            <th width="15%" class="text-right p">
                Prix Unitaire
            </th>
            <th width="15%" class="text-right p ">
                Quantité
            </th>
            <th width="20%" class="text-right p">
                Total
            </th>
        </tr>
        <?php

        $i = 1;
        $tot_qty = 0;
        $tot_sales_price = 0;
        $tot_tax_amt = 0;
        $tot_discount_amt = 0;
        $tot_unit_total_cost = 0;
        $tot_total_cost = 0;
        $tot_before_tax = 0;
        $tot_price_per_unit = 0;
        $sum_of_tot_price = 0;
        $tax_namee = "";
        $tax = 0;


        $this->db->select("a.description,c.item_name, a.sales_qty,a.tax_type,
                a.price_per_unit, b.tax,a.tax_amt,
                a.discount_input,a.discount_amt, a.unit_total_cost,
                a.total_cost , d.unit_name,c.sku,c.hsn,e.other_charges_tax_id,f.tax_name,f.tax
            ");
        $this->db->where("a.sales_id", $sales_id);

        $this->db->from("db_salesitems a");
        $this->db->join("db_tax b", "b.id=a.tax_id", "left");
        $this->db->join("db_items c", "c.id=a.item_id", "left");
        $this->db->join("db_units d", "d.id = c.unit_id", "left");
        $this->db->join("db_sales e", "e.id = a.sales_id", "left");
        $this->db->join("db_tax f", "f.id = e.other_charges_tax_id", "left");

        //$this->db->limit("10");

        $q2 = $this->db->get();


        foreach ($q2->result() as $res2) {
            $discount = (empty($res2->discount_input) || $res2->discount_input == 0) ? '0' : $res2->discount_input . "%";
            $discount_amt = (empty($res2->discount_amt) || $res2->discount_input == 0) ? '0' : $res2->discount_amt . "";
            $before_tax = $res2->unit_total_cost; // * $res2->sales_qty;
            $tot_cost_before_tax = $before_tax * $res2->sales_qty;

            $price_per_unit = $res2->price_per_unit;
            if ($res2->tax_type == 'Inclusive') {
                $price_per_unit -= ($res2->tax_amt / $res2->sales_qty);
            }

            $tot_price = $price_per_unit * $res2->sales_qty;

            echo '<tr>';

            echo '<td class="f-12 text-left b-r">';
            echo $res2->item_name;
            echo (!empty($res2->description)) ? "<br><i>[" . nl2br($res2->description) . "]</i>" : '';
            echo '</td>';

            echo '<td class="f-12 text-right b-r b-l">' . store_number_format($price_per_unit) . '</td>';
            echo '<td class="f-12 text-right b-r b-l">' . format_qty($res2->sales_qty) . '</td>';


            echo '<td class="f-12 text-right b-l">' . store_number_format($res2->total_cost) . '</td>';
            echo '</tr>';

            $tot_qty += $res2->sales_qty;
            $tot_tax_amt += $res2->tax_amt;
            $tot_discount_amt += $res2->discount_amt;
            $tot_unit_total_cost += $res2->unit_total_cost;
            $tot_before_tax += $before_tax;
            $tot_total_cost += $res2->total_cost;
            $tot_price_per_unit += $price_per_unit;
            $sum_of_tot_price += $tot_price;
            $tax_namee = $res2->tax_name;
            $tax = $res2->tax;
        }
        ?>

    </table>


    <div class="xd"></div>

    <table width="100%">
        <tr width="50%">
            <td width="50%" class="f-12 f-b">
                <p>Commentaire</p>
                <div class="box"><?= $quotation_note ?></div>
            </td>

            <td>
                <table width="100%">

                    <tr>
                        <td width="50%" class="f-12 text-right f-b">
                            <p> Montant HT : </p>
                        </td>
                        <td width="50%" class="f-12 f-b bg-blue b-r">
                            <p><?= store_number_format($res2->total_cost) ?> DH</p>
                        </td>


                    </tr>
                    <tr>
                        <td width="50%" class="f-12 text-right f-b">
                            <p><?= $tax_namee ?> : </p>
                        </td>
                        <td width="50%" class="f-12 f-b bg-blue b-r">
                            <!-- i need tva here -->

                            <p> <?= ($res2->total_cost * ($tax / 100)) ?> DH </p>
                        </td>
                    </tr>
                    <tr>


                        <td width="50%" class="f-12 text-right f-b">
                            <p>Montant TTC : </p>
                        </td>
                        <td width="50%" class="f-12 f-b bg-blue b-r">
                            <p><?= $res2->total_cost + ($res2->total_cost * ($tax / 100))  ?> DH</p>
                        </td>
                    </tr>
                    <tr>

                        <td width="50%" class="f-12 text-right f-b">
                            <p>TTC en Mots : </p>
                        </td>

                        <td width="50%" class="f-12 f-b bg-blue b-r" style="padding-bottom:13px">
                            <?= $this->session->userdata('currency_code') . " " . no_to_words(($res2->total_cost + ($res2->total_cost * ($tax / 100)))) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>


    </table>


    <table width="100%" class="mt absolute">

        <tr>
            <td colspan="2" class="text-center f-12 f-b">
                <b>
                    <?= $store_name ?>
                </b>
                <?= "Neméro CNSS : " . $company_cnss . " -- " . "Neméro RC : " . $company_rc . " -- " . "Numéro IF : " . $company_gst_no . " -- " . "Numéro ICE: " . $company_vat_no . "CIE" . $company_vat_no; ?>
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