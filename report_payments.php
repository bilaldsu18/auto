
<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>WAC - Payment</title>

    <!-- Stylesheets -->
    <!--<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>-->
    <link rel="stylesheet" href="css/style.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>


    <style type="text/css" media="print">
        .hide{display:none}
    </style>
    <script type="text/javascript">
        function printpage() {
            document.getElementById('printButton').style.visibility="hidden";
            window.print('');
            document.getElementById('printButton').style.visibility="visible";

        }
    </script>

</head>

<body>

<!-- TOP BAR -->
<?php include_once("tpl/top_bar.php"); ?>
<!-- end top-bar -->

<!-- HEADER -->
<?php include ('tpl/nav.php');?>
<!-- end header -->

<!-- MAIN CONTENT -->
<div id="content">

    <div class="page-full-width cf">

        <div class="side-menu fl">
            <h3>Payment</h3>
            <ul>
                <li><a href="view_payments.php">Payments</a></li>
                <li><a href="view_out_standing.php">Out standings</a></li>
            </ul>
        </div> <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Reports Payment</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

                </div> <!-- end content-module-heading -->

                <div class="content-module-main cf" id='table'>

                   <table border='1'>
<!--                       <input name="print" type="button" value="Print" id="printButton" onClick="printpage()">-->
                       <?php
                       if(isset($_GET['sid'])){
                           $transaction_id = $_GET['sid'];

//`1  `
                 /*      $result = $db->query("SELECT * FROM customer_details inner join transactions inner join stock_sales where customer_details.customer_name = transactions.customer=stock_sales.customer_id AND rid='$transaction_id' group by rid");*/

                           $result = $db->query("SELECT * FROM customer_details inner join transactions where customer_details.customer_name = transactions.customer AND rid='$transaction_id' group by rid");

                       while ($line = $db->fetchNextObject($result)) {

                       ?>

                          <tr>
                              <td style='width:15%;font-weight: bold;'>Name</td>
                              <td><?php echo $line->customer; ?></td>
                              <td style='width:15%;font-weight: bold;'>S/o</td>
                              <td><?php echo $line->customer_father; ?></td>
                              <td style='width:15%;font-weight: bold;'>Contact</td>
                              <td><?php echo $line->customer_cell; ?></td>
                          </tr>
                       <tr>
                           <td style='font-weight: bold;'>C.nic</td>
                           <td><?php echo $line->customer_cnic; ?></td>
                           <td style=';font-weight: bold;'>Address</td>
                           <td  colspan='3'><?php echo $line->customer_add; ?></td>
                       </tr>
              <?php } ?>
              <?php
                           $result = $db->query("SELECT * FROM stock_sales where transactionid= '$transaction_id' group by transactionid");
                           while ($line2 = $db->fetchNextObject($result)) {
                               ?>
                       <tr>
                           <td colspan='6' style='text-align: center;font-weight: bolder;font-size: 1.2em;'>
                           GUARANTOR STATUS
                           </td>
                       </tr>
                       <tr>
                           <td style='font-weight: bold;'>G.1 Name</td>
                           <td><?php echo $line2->gar1_name; ?></td>
                           <td style='font-weight: bold;'>S.O</td>
                           <td><?php echo $line2->gar1_fname; ?></td>
                           <td style='font-weight: bold;'>Contact No</td>
                           <td><?php echo $line2->gar1_cell; ?></td>
                       </tr>
                       <tr>
                           <td style='font-weight: bold;'>Address:</td>
                           <td colspan='5'><?php echo $line2->gar1_add; ?></td>
                       </tr>
                       <tr>
                           <td style='font-weight: bold;'>G.2 Name</td>
                           <td><?php echo $line2->gar2_name; ?></td>
                           <td style='font-weight: bold;'>S.O</td>
                           <td><?php echo $line2->gar2_fname; ?></td>
                           <td style='font-weight: bold;'>Contact No</td>
                           <td><?php echo $line2->gar2_cell; ?></td>
                       </tr>
                       <tr>
                           <td style='font-weight: bold;'>Address:</td>
                           <td colspan='5'><?php echo $line2->gar2_add; ?></td>
                       </tr>

                         <tr>
                           <td colspan='6' style='text-align: center;font-weight: bolder;font-size: 1.2em;'>
                               PURCHASING
                           </td>
                       </tr>
                           <?php
                           $result = $db->query("SELECT * FROM stock_sales where transactionid= '$transaction_id'");
                           while ($line3 = $db->fetchNextObject($result)) {
                               ?>
                               <tr>
                       <tr>
                                   <td colspan="6">
                                       <table border='0' cellspacing='0' cellpading='0' width='100%'>
                                           <tr>
                                               <td style=';font-weight: bold;width: 25%'>
                                                   <strong>Bike Name: </strong>
                                                   &nbsp;<?php echo $line3->stock_name; ?>
                                               </td>
                                               <td style='width: 25%'>
                                                   <strong>Reg.No: </strong>
                                                   &nbsp;<?php echo $line3->reg_no; ?>
                                               </td>
                                               <td style='width: 25%'>
                                                   <strong>Eng.No: </strong>
                                                   &nbsp;<?php echo $line3->eng_no; ?>
                                               </td>
                                               <td style='width: 25%'>
                                                   <strong>Chas.No: </strong>
                                                   &nbsp;<?php echo $line3->chas_no; ?>
                                               </td>
                                           </tr>
                                       </table>
                                   </td>
                       </tr>
                <?php }?>
                               <?php
                               $result1 = $db->query("SELECT * FROM `payment_details` WHERE `stck_id`= '$transaction_id'");
                               while ($line4 = $db->fetchNextObject($result1)) {
                                   ?>

                       <tr>
                           <td style='font-weight: bold;'>Delivery Date</td>
                           <td><?php echo $line2->date; ?></td>
                           <td style='font-weight: bold;'>Advance Rs.</td>
                           <td><?php echo $line4->first_payment; ?></td>
                           <td style='font-weight: bold;'>Istall Rs.</td>
                           <td><?php echo $line4->instal_amount; ?></td>
                       </tr>
                       <tr>
                           <td style='font-weight: bold;'>Clearing Months</td>
                           <td><?php echo $line4->recovery_month; ?></td>
                           <td style='font-weight: bold;'>Total Amount</td>
                           <td><?php echo $line4->payable_amount; ?></td>
                           <td style='font-weight: bold;'>Bank Record</td>
                           <td><?php echo $line2->mode; ?></td>
                       </tr>

                   </table>
                    <form method='post'>
                    <table border='1'>
                        <tr>
                            <th>Date</th>
                            <th>Slip No</th>
                            <th>Recieve</th>
                            <th>Balance</th>
                            <th>Total Amount</th>
                        </tr>
                        <?php
                        $result1 = $db->query("SELECT * FROM `payment_details` WHERE `stck_id`= '$transaction_id'");
                        while ($line4 = $db->fetchNextObject($result1)) {
                        ?>

                        <tr>
                            <td width="100"><?php echo $line2->date; ?></td>
                            <td width="100"><?php echo $line2->billnumber; ?></td>
                            <td width="100"><?php echo $line4->first_payment;?></td>
                            <td width="100"><?php echo $line4->remaining_amount;?></td>
                            <td width="100"><?php echo $line4->payable_amount;?></td>

                        </tr>

                            <?php
                            $result1 = $db->query("SELECT * FROM `transactions` WHERE `rid`= '$transaction_id'");
                            while ($line5 = $db->fetchNextObject($result1)) {
                                ?>

                            <tr>
                                <td width="100"><?php echo $line5->due; ?></td>
                                <td width="100"><?php echo $line5->slip_no; ?></td>
                                <td width="100"><?php echo $line5->payment;?></td>
                                <td width="100"><?php echo $line5->balance;?></td>
                                <td width="100"><?php echo $line4->payable_amount;?></td>

                            </tr>

                        <?php } } } } } ?>
                    </table>
                    </form>

                </div>
            </div>
            <div id="footer">
                <p>Developed By :<a href="http://www.webappcare.com">WEB APP CARE</a>.</p>
            </div> <!-- end footer -->

</body>
</html>
