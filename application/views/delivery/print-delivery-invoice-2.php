<!DOCTYPE html>
<html>
<title><?= $page_title; ?></title>

<head>
    <?php $this->load->view('comman/code_css.php'); ?>
    <link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />

    <style>
        header {
            position: fixed;
            top: -210px;
            left: 0px;
            right: 0px;


        }

        footer {
            position: fixed;
            bottom: -53px;
            left: 0px;
            right: 0px;
        }

        .page {
            position: relative;
            font-size: 12px;


        }


        .page:before {
            transform: translateY(-5px);
            content: " page : " counter(page) " de ";
        }



        .page-break {
            page-break-after: auto;
        }


        @page {
            margin: 240px 20px 70px 20px;
        }

        .facture_number_header {
            color: gray;
            font-size: 12px;
            font-weight: normal;
            text-align: left !important;
            width: 100%;
        }

        .my {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .py{
            padding-top: 15px;
            padding-bottom: 15px;
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

        .flex-bet {
            display: flex;
            justify-content: space-between;
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
            background:#0c5690 !important;
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
            position: fixed;
            bottom: 0px;
            width: 100%;

        }


        .b-l {

            border-left: 1px solid black;
        }

        .b-r {
            border-right: 1px solid #0c5690;
        }

        .xd {
            height: 2px;
            width: 100%;
            background: #0c5690;
        }

        .b-b {
            border-bottom: 1px solid black;
        }

        .b-t {
            border-top: 1px solid black;
        }
        .sign{
            margin-top: 30px;
            bottom: 30px;
            width: 100%;

        }
        .border-1{
            border: 1px solid #0c5690;
            height: 40px;
        }
        .h-4{
            height: 80px;
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
    $company_cnss = $res1->cnss;
    $company_rc = $res1->rc;
    $company_gst_no = $res1->gst_no;
    $company_vat_no = $res1->vat_no;
    $store_logo = (!empty($res1->store_logo)) ? $res1->store_logo : store_demo_logo();
    $store_website = $res1->store_website;
    $bank_details = $res1->bank_details;
    $terms_and_conditions = ""; //$res1->sales_terms_and_conditions;
    $image_file = ($res1->show_signature && !empty($res1->signature)) ? $res1->signature : '';

    $q3 = $this->db->query("SELECT *

                           FROM db_customers a,
                           db_delivery b 
                           WHERE 
                           a.`id`=b.`customer_id` AND 
                           b.`id`='$delivery_id' 
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
    $delivery_date = show_date($res3->delivery_date);
    $expire_date = (!empty($res3->expire_date)) ? show_date($res3->expire_date) : '';
    $created_time = $res3->created_time;
    $reference_no = $res3->reference_no;
    $delivery_code = $res3->delivery_code;
    $delivery_note = $res3->delivery_note;
    $delivery_status = $res3->delivery_status;
    $created_by = $res3->created_by;
    $previous_due = $res3->customer_previous_due;
    $total_due = $res3->customer_total_due;


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


    ?>

    <header>
        <caption>

            <div class="facture_number_header  ">

                <table width=100%>
                    <tr>
                        <td class="text-left ">
                        Livraison N° <?= $delivery_code   ?>
                        </td>

                    </tr>
                </table>
            </div>

        </caption>



        <table width="95%">
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
                        <p>Livraison</p>
                        <p> Livraison N° <?= $delivery_code ?></p>
                        <div class=" line"></div>
                        <div class="dates">
                            Date d'émisson : <span><?= $delivery_date ?></span>
                    
                        </div>
                    </div>
                </td>
            </tr>


        </table>
        <div class="line my"></div>
    </header>


    <footer>
        <table width="100%" class="b-t">

            <tr class="bg-blue">
                <td colspan="2" class="text-left     f-12 f-b" style="line-height: 20px; padding-bottom:10px">
                    <?= "Neméro CNSS : " . $company_cnss . " -- " . "Neméro RC : " . $company_rc . " -- " . "Numéro IF : " . $company_gst_no . " -- " . "Numéro ICE : " . $company_vat_no; ?>
                </td>
                <td width="11.8%">
                    <div class=" page f-b">
                    </div>
                </td>
            </tr>
        </table>

    </footer>

    </table>


    <div class="page-break">
        <table width="100%">
            <tr>
                <td colspan="3">
                    <p><b>DESTINATAIRE : </b></p>
                </td>
            </tr>

           
            <tr>
                <td>
                    <div class="destina_content">
                        <?php echo $this->lang->line('name') . ": " . $customer_name; ?><br />
                        <?php echo (!empty(trim($customer_mobile))) ? $this->lang->line('mobile') . ": " . $customer_mobile . "<br>" : ''; ?>
                        <?php
                        if (!empty($customer_address)) {
                            echo $customer_address;
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
                        <?php echo (!empty(trim($customer_email))) ? $this->lang->line('email') . ": " . $customer_email . "<br>" : ''; ?>
                        <?php echo (!empty(trim($customer_gst_no))) ? $this->lang->line('gst_number') . ": " . $customer_gst_no . "<br>" : ''; ?>
                        <?php echo (!empty(trim($customer_tax_number))) ? $this->lang->line('tax_number') . ": " . $customer_tax_number . "<br>" : ''; ?>
                    </div>
                </td>


            </tr>
        </table>


        <div class="title_facture">
            <p>DETAILS DU LIVRAISON</p>
        </div>

        <table width="100%">
            <tr>
                <th width="40%" class="text-left">
                    Description
                </th>
           
                <th width="15%" class="text-right">
                    Quantité
                </th>


             
            </tr>

            <?php
            $i = 1;
            $tot_qty = 0;
            $tot_delivery_price = 0;
            $tot_tax_amt = 0;
            $tot_discount_amt = 0;
            $tot_unit_total_cost = 0;
            $tot_total_cost = 0;
            $tot_before_tax = 0;
            $tax_namee = "";
            $tax = 0;
            // $q2 = $this->db->query("SELECT a.description,c.item_name, a.delivery_qty,
            //                               a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
            //                               a.discount_input,a.discount_amt, a.unit_total_cost,
            //                               a.total_cost , d.unit_name,c.hsn
            //                               FROM 
            //                               db_deliveryitems AS a,db_tax AS b,db_items AS c , db_units as d
            //                               WHERE 
            //                               d.id = c.unit_id and
            //                               c.id=a.item_id AND b.id=a.tax_id AND a.delivery_id='$delivery_id'");

            $this->db->select(" a.description,c.item_name, a.delivery_qty,
                                  a.price_per_unit, b.tax,b.tax_name,a.tax_amt,
                                  a.discount_input,a.discount_amt, a.unit_total_cost,
                                  a.total_cost , d.unit_name,c.hsn,e.other_charges_tax_id,f.tax_name,f.tax
                              ");
            $this->db->where("a.delivery_id", $delivery_id);
            $this->db->from("db_deliveryitems a");
            $this->db->join("db_tax b", "b.id=a.tax_id", "left");
            $this->db->join("db_items c", "c.id=a.item_id", "left");
            $this->db->join("db_units d", "d.id = c.unit_id", "left");
            $this->db->join("db_delivery e", "e.id = a.delivery_id", "left");
            $this->db->join("db_tax f", "f.id = e.other_charges_tax_id", "left");
            $q2 = $this->db->get();

            foreach ($q2->result() as $res2) {
                $discount = (empty($res2->discount_input) || $res2->discount_input == 0) ? '0' : $res2->discount_input . "%";
                $discount_amt = (empty($res2->discount_amt) || $res2->discount_input == 0) ? '0' : $res2->discount_amt . "";
                $before_tax = $res2->unit_total_cost; // * $res2->delivery_qty;
                $tot_cost_before_tax = $before_tax * $res2->delivery_qty;


                echo '<tr >';

                echo "<td class='text-left f-12'>";
                echo $res2->item_name;
                echo (!empty($res2->description)) ? "<br><i>[" . nl2br($res2->description) . "]</i>" : '';
                echo "</td>";
                





                echo "<td class='text-right f-12' style='padding-bottom:10px'>" . store_number_format($res2->delivery_qty)   . "</td>";

                //echo "<td style='text-align: right;'>".$discount."</td>";


                //echo "<td colspan='2' class='text-right'>".number_format($before_tax,2)."</td>";
                //echo "<td class='text-right'>".$res2->price_per_unit."</td>";

               
                echo "</tr>";
                $tot_qty += $res2->delivery_qty;
                $tot_delivery_price += $res2->price_per_unit;
                $tot_tax_amt += $res2->tax_amt;
                $tot_discount_amt += $res2->discount_amt;
                $tot_unit_total_cost += $res2->unit_total_cost;
                $tot_before_tax += $before_tax;
                $tot_total_cost += $res2->total_cost;
                $tax_namee = $res2->tax_name;
                $tax = $res2->tax;
            }
            ?>
            <tr class="bg-blue" style="padding-bottom:10px">
                <td>

                </td>
                <td class="text-right f-12 " style="padding-bottom:6px">
                     <?= $tot_qty ?>
                </td>
                
            </tr>

        </table>

        <div class="line my"></div>

        <table width=100% class="sign">
            <tr>
                <td style="padding:0" width="50%"  class=" text-center py">
                <p class="py"><u>Signature du client</u></p>
                    <div class="  h-4">

                    </div>
                </td>

                <td style="padding:0" width="50%" class=" text-center  b-l">    
                   <p class="py"><u>Signature du fournisseur</u></p>
                    <div class=" h-4">

                    </div>
                
            </tr>
            

        </table>
       
    </div>


</body>

</html>