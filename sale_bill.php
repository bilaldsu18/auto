<?php
include_once("init.php");// Use session variable on this page. This function must put on the top of page.
if(!isset($_SESSION['username']) || $_SESSION['usertype'] !='admin'){ // if session variable "username" does not exist.
    header("location:index.php?msg=Please%20login%20to%20access%20admin%20area%20!"); // Re-direct to index.php
}
else
{
    if(isset($_GET['transactionid'])){
        $transactionid=$_GET['transactionid'];
    }
    else{
        $transactionid="";
    }

    ?>
    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
    <html>
    <head>
        <title>Sale Report</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <style type="text/css" media="print">
        .hide{display:none}
    </style>
    <script type="text/javascript">
        function printpage() {
            document.getElementById('printButton').style.visibility="hidden";
            window.print();
            document.getElementById('printButton').style.visibility="visible";
        }
    </script>
    <body>
    <input name="print" type="button" value="Print" id="printButton" onClick="printpage()">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
        <td style='text-align: center;font-size: 1.5em;'>
            <?php $line4 = $db->queryUniqueObject("SELECT * FROM store_details ");
            ?>
            <strong><?php echo $line4->name?></strong>
        </td>
    </tr>
    <tr>
        <td align="center"><strong>Address: </strong><?php echo $line4->address; ?>,<?php echo $line4->place; ?>,<?php echo $line4->city; ?> Pakistan.</td>
    </tr>
    <tr>
        <td align="center">
            <strong>Website: <?php echo $line4->web; ?>&nbsp;&nbsp;&nbsp;Email: <?php echo $line4->email; ?>&nbsp;&nbsp;&nbsp;Phone: <?php echo $line4->phone; ?></strong>
        </td>
    </tr>
    <tr>
    <table border='1' style='width:100%;' cellspacing='0' cellpading='10'>
    <tr>
        <td colspan='3' align="center">
            <span style='background-color: blue;font-size: 1.1em;color:white;font-weight: bolder;border-radius: 0px 10px 0px 10px;padding:0px;'>Personal Information</span>
        </td>
    </tr>
    <?php
    $result = $db->query("SELECT * FROM customer_details inner join stock_sales where customer_details.customer_name = stock_sales.customer_id AND transactionid= '$transactionid' group by transactionid");
    while ($line = $db->fetchNextObject($result)) {
       $ph_name = $line->customer_id;
        ?>
        <tr>
            <td>
                <strong>Customer Name: </strong>
                &nbsp;<?php echo $line->customer_id; ?>
            </td>
            <td>
                <strong>Father Name: </strong>
                &nbsp;<?php echo $line->customer_father; ?>
            </td>
            <td>
                <strong>Date Of Birth: </strong>
                &nbsp;<?php echo $line->customer_dob; ?>
            </td>

            </td>
        </tr>
        <tr>
            <td>
                <strong>Nationality: </strong>
                &nbsp;<?php echo $line->customer_nationality; ?>
            </td>
            <td>
                <strong>C.nic No: </strong>
                &nbsp;<?php echo $line->customer_cnic; ?>
            </td>
            <td>
                <strong>Marital Status: </strong>
                &nbsp;<?php echo $line->customer_status; ?>
            </td>

        </tr>
        <tr>
            <td>
                <strong>Cell No: </strong>
                &nbsp;<?php echo $line->customer_cell; ?>
            </td>
            <td>
                <strong>Phone No: </strong>
                &nbsp;<?php echo $line->customer_phone; ?>
            </td>
            <td>
                <strong>E.Mail: </strong>
                &nbsp;<?php echo $line->customer_mail; ?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Present Add:</strong>
                &nbsp; <?php echo $line->customer_add;?>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Permanent Add:</strong>
                &nbsp; <?php echo $line->customer_per_add;?>
            </td>
        </tr>

        <tr>
            <td colspan='3' align="center">
                <span style='background-color: blue;font-size: 1.1em;color:white;font-weight: bolder;border-radius: 0px 10px 0px 10px;padding:0px;'>Work Details</span>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Work: </strong>
                &nbsp;<?php echo $line->customer_work; ?>
            </td>
            <td>
                <strong>Occupation: </strong>
                &nbsp;<?php echo $line->customer_occup; ?>
            </td>
            <td>
                <strong>Organization: </strong>
                &nbsp;<?php echo $line->customer_org; ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Monthly Income: </strong>
                &nbsp;<?php echo $line->customer_inc; ?>
            </td>
            <td>
                <strong>Duration: </strong>
                &nbsp;<?php echo $line->customer_dura; ?>
            </td>
            <td>
                <strong>Position: </strong>
                &nbsp;<?php echo $line->customer_post; ?>
            </td>
        </tr>
        <tr>
            <td colspan='3'>
                <strong>Office Address:</strong>
                &nbsp; <?php echo $line->customer_office_add; ?>
            </td>
        </tr>
    <?php } ?>
    <?php
    $result = $db->query("SELECT * FROM stock_sales where transactionid= '$transactionid' group by transactionid");
    while ($line = $db->fetchNextObject($result)) {
        ?>
        <tr>
            <td colspan='3' align="center">
                <span style='background-color: blue;font-size: 1.1em;color:white;font-weight: bolder;border-radius: 0px 10px 0px 10px;padding:0px;'>Guarantor 1</span>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Name: </strong>
                &nbsp;<?php echo $line->gar1_name; ?>
            </td>
            <td>
                <strong>Father Name: </strong>
                &nbsp;<?php echo $line->gar1_fname; ?>
            </td>
            <td>
                <strong>C.Nic: </strong>
                &nbsp;<?php echo $line->gar1_cnic; ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Tell No: </strong>
                &nbsp;<?php echo $line->gar1_tel; ?>
            </td>
            <td>
                <strong>Cell No: </strong>
                &nbsp;<?php echo $line->gar1_cell; ?>
            </td>
            <td>
                <strong>Sign: </strong>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Address: </strong>
                &nbsp;<?php echo $line->gar1_add; ?>
            </td>
        </tr>

        <tr>
            <td colspan='3' align="center">
                <span style='background-color: blue;font-size: 1.1em;color:white;font-weight: bolder;border-radius: 0px 10px 0px 10px;padding:0px;'>Guarantor 2</span>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Name: </strong>
                &nbsp;<?php echo $line->gar2_name; ?>
            </td>
            <td>
                <strong>Father Name: </strong>
                &nbsp;<?php echo $line->gar2_fname; ?>
            </td>
            <td>
                <strong>C.Nic: </strong>
                &nbsp;<?php echo $line->gar2_cnic; ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Tell No: </strong>
                &nbsp;<?php echo $line->gar2_tel; ?>
            </td>
            <td>
                <strong>Cell No: </strong>
                &nbsp;<?php echo $line->gar2_cell; ?>
            </td>
            <td>
                <strong>Sign: </strong>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <strong>Address: </strong>
                &nbsp;<?php echo $line->gar2_add; ?>
            </td>
        </tr>

        <tr>
            <td colspan='3' align="center">
                <span style='background-color: blue;font-size: 1.1em;color:white;font-weight: bolder;border-radius: 0px 10px 0px 10px;padding:0px;'>Purchasing</span>
            </td>
        </tr>

<!--    bike detail        -->

    <?php
    $result = $db->query("SELECT * FROM stock_sales where transactionid= '$transactionid'");
    while ($line2 = $db->fetchNextObject($result)) {
        ?>
        <tr>
            <td colspan="3">
                <table border='0' cellspacing='0' width='100%'>
                    <tr>
                        <td style='width: 25%'>
                            <strong>Name: </strong>
                            &nbsp;<?php echo $line2->stock_name; ?>
                        </td>
                        <td style='width: 25%'>
                            <strong>Reg.No: </strong>
                            &nbsp;<?php echo $line2->reg_no; ?>
                        </td>
                        <td style='width: 25%'>
                            <strong>Eng.No: </strong>
                            &nbsp;<?php echo $line2->eng_no; ?>
                        </td>
                        <td style='width: 25%'>
                            <strong>Chas.No: </strong>
                            &nbsp;<?php echo $line2->chas_no; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    <?php } ?>

<!--    bike detail        -->

        <tr>
            <td>
                <strong>Purchasing Date: </strong>
                &nbsp; <?php echo $line->date;  ?>
            </td>
            <td>
                <strong>Payable Amount: </strong>
                &nbsp;<?php echo $line->subtotal; ?>
            </td>
            <td>
                <strong>Receive Amount: </strong>
                &nbsp;<?php echo $line->payment; ?>
            </td>
        </tr>

        <tr>
            <td>
                <strong>Remaining Amount: </strong>
                &nbsp;<?php echo $line->balance; ?>
            </td>
            <td>
                <strong>Installment: </strong>
                &nbsp;<?php echo $line->installment; ?>
            </td>
            <td>
                <strong>Installment Amount: </strong>
                &nbsp;<?php echo $line->inst_amount; ?>
            </td>
        </tr>
        <tr>



        </tr>
    <?php } ?>
    </table>
    <div style="border: 1px solid gray;float:left;width:25%;margin: 2% 0% 2% 6%;height:100px">Customer Sign</div>
    <div style="border: 1px solid gray;float:left;width:25%;margin: 2% 0% 2% 6%;height:100px">Customer Thumb</div>
    <div style="border: 1px solid gray;float:left;width:150px;margin: 2% 0% 2% 6%;height:150px">
        <img src="picture/<?php echo $ph_name ?>.jpg" style='width:150px;height:150px;'/>
    </div>
    </table>
    </body>
    </html>
<?php

}
?>
