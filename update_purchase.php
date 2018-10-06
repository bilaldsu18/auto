<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<title>WAC - Update Purchases</title>

<!-- Stylesheets -->
<!--<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>-->
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="js/date_pic/date_input.css">
<link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">

<!-- Optimize for mobile devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<!-- jQuery & JS files -->
<?php include_once("tpl/common_js.php"); ?>
<script src="js/date_pic/jquery.date_input.js"></script>
<script src="lib/auto/js/jquery.autocomplete.js "></script>
<script src="js/script.js"></script>
<script>
/*$.validator.setDefaults({
 submitHandler: function() { alert("submitted!"); }
 });*/
$(document).ready(function() {

    // validate signup form on keyup and submit
    $("#form1").validate({
        rules: {
            bill_no: {
                required: true,
                minlength: 3

            },
            stockid: {
                required: true
            },
            grand_total: {
                required: true
            },
            supplier: {
                required: true
            }
        },
        messages: {
            supplier: {
                required: "Please Enter Supplier"
            },
            stockid: {
                required: "Please Enter Stock ID"
            },
            grand_total: {
                required: "Add Stock Items"
            },
            bill_no: {
                required: "Please Enter Bill Number",
                minlength: "Bill Number must consist of at least 3 characters"
            }
        }
    });

});
$(function() {
    $("#supplier").autocomplete("supplier1.php", {
        width: 160,
        autoFill: true,
        selectFirst: true
    });
    $("#item").autocomplete("stock_purchse.php", {
        width: 160,
        autoFill: true,
        mustMatch: true,
        selectFirst: true
    });
    $("#item").blur(function()
    {
        document.getElementById('total').value=document.getElementById('cost').value * document.getElementById('quty').value
    });
    $("#item").blur(function()
    {


        $.post('check_item_details.php', {stock_name1: $(this).val() },
            function(data){
                $("#cost").val(data.cost);
                $("#sell").val(data.sell);
                $("#stock").val(data.stock);
                $('#guid').val(data.guid);
                if(data.cost!=undefined)
                    $("#0").focus();


            }, 'json');




    });
    $("#supplier").blur(function()
    {


        $.post('check_supplier_details.php', {stock_name1: $(this).val() },
            function(data){

                $("#address").val(data.address);
                $("#contact1").val(data.contact1);

                if(data.address!=undefined)
                    $("#0").focus();

            }, 'json');




    });
    $('#test1').jdPicker();
    $('#test2').jdPicker();



    var hauteur=0;
    $('.code').each(function(){
        if($(this).height()>hauteur) hauteur = $(this).height();
    });

    $('.code').each(function(){ $(this).height(hauteur); });
});

function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=38 && unicode!=39 && unicode!=40){ //if the key isn't the backspace key (which we should allow)
        if (unicode<48||unicode>57)
            return false
    }
}
function edit_stock_details(id) {
    document.getElementById('display').style.display="block";
    document.getElementById('item').value=document.getElementById(id+'st').value;
    document.getElementById('reg_no').value=document.getElementById(id+'r').value;
    document.getElementById('eng_no').value=document.getElementById(id+'e').value;
    document.getElementById('chas_no').value=document.getElementById(id+'h').value;
    document.getElementById('stock').value=document.getElementById(id+'p').value;
    document.getElementById('quty').value=document.getElementById(id+'q').value;
    document.getElementById('total').value=document.getElementById(id+'to').value;
    document.getElementById('posnic_total').value=document.getElementById(id+'to').value;

    document.getElementById('guid').value=id;
    document.getElementById('edit_guid').value=id;

}
function clear_data() {
    document.getElementById('display').style.display="none";

    document.getElementById('item').value="";
    document.getElementById('reg_no').value="";
    document.getElementById('eng_no').value="";
    document.getElementById('chas_no').value="";
    document.getElementById('stock').value="";
    document.getElementById('quty').value="";
    document.getElementById('total').value="";
    document.getElementById('posnic_total').value="";

    document.getElementById('guid').value="";
    document.getElementById('edit_guid').value="";

}
function add_values(){

    if(unique_check()){

        document.getElementById('posnic_total').value=document.getElementById('total').value;

        if(document.getElementById('edit_guid').value==""){
            if(document.getElementById('item').value!="" && document.getElementById('quty').value!="" && document.getElementById('cost').value!="" && document.getElementById('total').value!="" && document.getElementById('eng_no').value!=""){
                code=document.getElementById('item').value;
                reg_no=document.getElementById('reg_no').value;
                eng_no=document.getElementById('eng_no').value;
                chas_no=document.getElementById('chas_no').value;
                disc=document.getElementById('stock').value;
                quty=document.getElementById('quty').value;
                total=document.getElementById('total').value;
                item=document.getElementById('guid').value;
                main_total=document.getElementById('posnic_total').value;

                $('<tr id="'+eng_no+'">' +
                    '<td><input type=hidden value="'+item+'" id="'+eng_no+'id" ><input type=text name="stock_name[]"  id="'+eng_no+'st" style="width: 150px" class="round  my_with" ></td>' +
                    '<td><input type=text name=reg_no[] readonly="readonly" value="'+reg_no+'" id="'+eng_no+'r" class="round  my_with" style="text-align:right;" ></td>' +
                    '<td><input type=text name=eng_no[] readonly="readonly" value="'+eng_no+'" id="'+eng_no+'e" class="round  my_with" style="text-align:right;" ></td>' +
                    '<td><input type=text name=chas_no[] readonly="readonly" value="'+chas_no+'" id="'+eng_no+'h" class="round  my_with" style="text-align:right;" ></td>' +
                    '<td><input type=text name=stock[] readonly="readonly" value="'+disc+'" id="'+eng_no+'p" class="round  my_with" style="text-align:right;" ></td>' +
                    '<td><input type=text name=quty[] readonly="readonly" value="'+quty+'" id="'+eng_no+'q" class="round  my_with" style="text-align:right;" ></td>' +
                    '<td><input type=text name=jibi[] readonly="readonly" value="'+total+'" id="'+eng_no+'to" class="round  my_with" style="width: 120px;margin-left:20px;text-align:right;" ><input type=hidden name=total[] id="'+eng_no+'my_tot" value='+main_total+'> </td>' +
                    '<td><input type=button value="" id="'+eng_no+'" style="width:30px;border:none;height:30px;background:url(images/edit_new.png)" class="round" onclick="edit_stock_details(this.id)"  ></td>' +
                    '<td><input type=button value="" id="'+eng_no+'" style="width:30px;border:none;height:30px;background:url(images/close_new.png)" class="round" onclick= $(this).closest("tr").remove() ></td>' +
                    '</tr>').fadeIn("slow").appendTo('#item_copy_final');
                document.getElementById('reg_no').value="";
                document.getElementById('eng_no').value="";
                document.getElementById('chas_no').value="";
                document.getElementById('stock').value="";
                document.getElementById('quty').value="";
                document.getElementById('total').value="";
                document.getElementById('item').value="";
                document.getElementById('guid').value="";

                if(document.getElementById('grand_total').value==""){
                    document.getElementById('grand_total').value=main_total;
                }
                else{
                    document.getElementById('grand_total').value=parseFloat(document.getElementById('grand_total').value)+parseFloat(main_total);
                }
                document.getElementById('main_grand_total').value=parseFloat(document.getElementById('grand_total').value);
                document.getElementById(eng_no+'st').value=code;
                document.getElementById(eng_no+'to').value=total;
            }else{
                alert('Please provide all required fields.');
            }
        }else{
            id=document.getElementById('edit_guid').value;
            document.getElementById(id+'st').value=document.getElementById('item').value;
            document.getElementById(id+'r').value=document.getElementById('reg_no').value;
            document.getElementById(id+'e').value=document.getElementById('eng_no').value;
            document.getElementById(id+'h').value=document.getElementById('chas_no').value;
            document.getElementById(id+'p').value=document.getElementById('stock').value;
            document.getElementById(id+'q').value=document.getElementById('quty').value;
            document.getElementById(id+'to').value=document.getElementById('total').value;

            var GrndTotal = 0;
            $('#item_copy_final [name="total[]"]').each(function(){
                GrndTotal += parseInt($(this).val() );
            });
            //$('#grand_total, #main_grand_total').val(GrndTotal);
            $('#grand_total').val(GrndTotal);

            //data1=document.getElementById('grand_total').value + document.getElementById('posnic_total').value - document.getElementById(id+'my_tot').value;
            data1=parseFloat(GrndTotal);
            document.getElementById('main_grand_total').value=data1;
            document.getElementById('grand_total').value=data1;
            document.getElementById(id+'to').value=document.getElementById('total').value;

            //document.getElementById('grand_total').value=parseFloat(document.getElementById('grand_total').value)+parseFloat(document.getElementById('total').value);
            //alert(parseFloat(document.getElementById(id+'my_tot').value));
            //alert(parseFloat(document.getElementById('posnic_total').value));
            balance_amount();
            //alert(data1);

            //document.getElementById(id+'my_tot').value=document.getElementById('posnic_total').value;
            document.getElementById('reg_no').value="";
            document.getElementById('eng_no').value="";
            document.getElementById('chas_no').value="";
            document.getElementById('stock').value="";
            document.getElementById('quty').value="";
            document.getElementById('total').value="";
            document.getElementById('item').value="";
            document.getElementById('guid').value="";
            document.getElementById('edit_guid').value="";
        }
        document.getElementById('display').style.display="none";

    }
}
function unique_check(){
    var ItemDuplicateVal = '';
    var RegDuplicateVal = '';
    var EngDuplicateVal = '';
    var ChasDuplicateVal = '';
    var dupItem = '';
    var StopUnit = false;

    /*var ItemName = $('#item').val();
    var RegNum = $('#reg_no').val();
    var EngNum = $('#eng_no').val();
    var ChasNum = $('#chas_no').val();

    var CombVal = ItemName+', '+RegNum+', '+EngNum+', '+ChasNum+', '

    $('#item_copy_final [name="stock_name[]"], [name="reg_no[]"], [name="eng_no[]"], [name="chas_no[]"], ').each(function(){
        dupItem += $(this).val()+', ';
        if(CombVal == dupItem){
            StopUnit = true
        }
    });*/

    //if(!document.getElementById(document.getElementById('guid').value) || document.getElementById('edit_guid').value==document.getElementById('guid').value){
    if(StopUnit == false){
        return true;

    }else{

        alert("This Item is already added In This Purchase");
        document.getElementById('item').focus();
        id=document.getElementById('edit_guid').value;

        document.getElementById('item').focus();
        document.getElementById('item').value=document.getElementById(id+'st').value;
        document.getElementById('reg_no').value=document.getElementById(id+'r').value;
        document.getElementById('eng_no').value=document.getElementById(id+'e').value;
        document.getElementById('chas_no').value=document.getElementById(id+'h').value;
        document.getElementById('stock').value=document.getElementById(id+'p').value;
        document.getElementById('quty').value=document.getElementById(id+'q').value;
        document.getElementById('total').value=document.getElementById(id+'to').value;
        document.getElementById('guid').value=id;
        document.getElementById('edit_guid').value=id;
        return false;


    }
}
function total_amount(){
    document.getElementById('total').value=document.getElementById('cost').value * document.getElementById('quty').value
    document.getElementById('posnic_total').value=document.getElementById('total').value;
    // document.getElementById('total').value = '$ ' + parseFloat(document.getElementById('total').value).toFixed(2);
    balance_amount();
}
function balance_amount(){
    if(document.getElementById('grand_total').value!="" && document.getElementById('payment').value!=""){
        data=parseFloat(document.getElementById('grand_total').value);
        document.getElementById('balance').value=data-parseFloat(document.getElementById('payment').value);
        console.log();
        if(parseFloat(document.getElementById('grand_total').value) >= parseFloat(document.getElementById('payment').value)){

            document.getElementById('balance').value=parseFloat(document.getElementById('grand_total').value)-parseFloat(document.getElementById('payment').value);
        }else{
            if(document.getElementById('grand_total').value!=""){
                document.getElementById('balance').value='000.00';
                document.getElementById('payment').value=parseFloat(document.getElementById('grand_total').value);
            }else{
                document.getElementById('balance').value='000.00';
                document.getElementById('payment').value="";
            }
        }
    }else{
        document.getElementById('balance').value="";
    }


}
function quantity_chnage(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=13 && unicode!=9){
    }
    else{
        add_values();
        document.getElementById("item").focus();

    }
    if (unicode!=27){
    }
    else{

        document.getElementById("item").focus();
    }
}

function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=27 && unicode!=38 && unicode!=39 && unicode!=40 && unicode!=9){ //if the key isn't the backspace key (which we should allow)
        if (unicode<48||unicode>57)
            return false
    }
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

    <h3>Purchase Management</h3>
    <ul>
        <li><a href="add_purchase.php">Add Purchase</a></li>
        <li><a href="view_purchase.php">View Purchase </a></li>
    </ul>

</div> <!-- end side-menu -->

<div class="side-content fr">

<div class="content-module">

<div class="content-module-heading cf">

    <h3 class="fl">Update Purchase</h3>
    <span class="fr expand-collapse-text">Click to collapse</span>
    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

</div> <!-- end content-module-heading -->

<div class="content-module-main cf">

<?php
if(isset($_POST['supplier']) and isset($_POST['stock_name']))
{
    $billnumber=mysql_real_escape_string($_POST['bill_no']);
    $autoid=mysql_real_escape_string($_POST['id']);

    $supplier=mysql_real_escape_string($_POST['supplier']);
    $payment=mysql_real_escape_string($_POST['payment']);
    $balance=mysql_real_escape_string($_POST['balance']);
    $address=mysql_real_escape_string($_POST['address']);
    $contact=mysql_real_escape_string($_POST['contact']);
    $count = $db->countOf("supplier_details", "supplier_name='$supplier'");
    if($count==0)
    {
        $db->query("insert into supplier_details(supplier_name,supplier_address,supplier_contact1) values('$supplier','$address','$contact')");
    }
    $temp_balance = $db->queryUniqueValue("SELECT balance FROM supplier_details WHERE supplier_name='$supplier'");
    $temp_balance = (int) $temp_balance + (int) $balance;
    $db->execute("UPDATE supplier_details SET balance=$temp_balance WHERE supplier_name='$supplier'");
    $selected_date=$_POST['due'];
    $selected_date=strtotime( $selected_date );
    //$mysqldate = date( 'Y-m-d', $selected_date );
    $mysqldate = date( 'Y-m-d H:i:s', $selected_date );
    $due=$mysqldate;
    $mode=mysql_real_escape_string($_POST['mode']);
    $cheque_no=mysql_real_escape_string($_POST['cheque_no']);
    $cheque_date=mysql_real_escape_string($_POST['cheque_date']);
    $description=mysql_real_escape_string($_POST['description']);

    $namet=$_POST['stock_name'];
    $reg_no=$_POST['reg_no'];
    $eng_no=$_POST['eng_no'];
    $chas_no=$_POST['chas_no'];
    $quantityt=$_POST['quanitity'];
    $totalt=$_POST['total'];

    $subtotal=mysql_real_escape_string($_POST['subtotal']);

    $username=$_SESSION['username'];

    $i=0;
    $j=1;


    $selected_date=$_POST['date'];
    $selected_date=strtotime( $selected_date );
    $mysqldate = date( 'Y-m-d H:i:s', $selected_date );

    foreach($reg_no as $reg_no1)
    {
        $name1 = $namet[$i];
        $quantity=$_POST['quantity'][$i];
        $brate=$_POST['cost'][$i];
        $srate=$_POST['sell'][$i];
        $total=$_POST['total'][$i];
        $sysid=$_POST['gu_id'][$i];

        $count = $db->countOf("stock_avail", "name='$name1'");

        $amount = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");
        $oldquantity = $db->queryUniqueValue("SELECT quantity FROM stock_entries WHERE id='$sysid' ");
        $amount1 = ($amount + $quantity) - $oldquantity;

        //for($ind=0; $ind<count($reg_no); $ind++){
         $updStmnt = "UPDATE stock_entries SET stock_name='$name1',reg_no='$reg_no[$i]',eng_no='$eng_no[$i]',chas_no='$chas_no[$i]', stock_supplier_name='$supplier', quantity='$quantity',  opening_stock='$amount', closing_stock='$amount1', date='$mysqldate', username='$username', type='entry', total='$total', payment='$payment', balance='$balance', mode='$mode', cheque_no='$cheque_no', cheque_date='$cheque_date', description='$description', due='$selected_date 00:00:00', subtotal='$subtotal', billnumber='$billnumber' WHERE id='$sysid'";
        $db->query($updStmnt);
        //}

        $db->execute("UPDATE stock_avail SET quantity=$amount1 WHERE name='$name1'");


        //INSERT INTO `stock`.`stock_entries` (`id`, `stock_id`, `stock_name`, `stock_supplier_name`, `category`, `quantity`, `company_price`, `selling_price`, `opening_stock`, `closing_stock`, `date`, `username`, `type`, `salesid`, `total`, `payment`, `balance`, `mode`, `description`, `due`, `subtotal`, `count1`)
        //VALUES (NULL, '$autoid1', '$name1', '$supplier', '', '$quantity', '$brate', '$srate', '$amount', '$amount1', '$mysqldate', 'sdd', 'entry', 'Sa45', '432.90', '2342.90', '24.34', 'cash', 'sdflj', '2010-03-25 12:32:02', '45645', '1');
        $i++;
        $j++;
    }
    $data="Parchase order Updated successfully Ref: [ $autoid] " ;
    $msg='<p style=color:#153450;font-family:gfont-family:Georgia, Times New Roman, Times, serif>'.$data.'</p>';//
    ?>

    <script  src="dist/js/jquery.ui.draggable.js"></script>
    <script src="dist/js/jquery.alerts.js"></script>
    <script src="dist/js/jquery.js"></script>
    <link rel="stylesheet"  href="dist/js/jquery.alerts.css" >

    <script type="text/javascript">

        jAlert('<?php echo  $msg; ?>', 'POSNIC');

    </script>
<?php


}
?>
<?php
if(isset($_GET['sid']))
    $id=$_GET['sid'];
$line = $db->queryUniqueObject("SELECT * FROM stock_entries WHERE stock_id='$id'");
?>
<form name="form1" method="post" id="form1" action="">
    <div class="mytable_row ">
        <input type="hidden" id="posnic_total" >
        <input type="hidden" name="id" value="<?php echo $id ?>" >

        <table class="form"  border="0" cellspacing="0" cellpadding="0">
            <tr>
                <?php
                $max = $db->maxOfAll("id","stock_sales");
                $max=$max+1;
                $autoid="PR".$max."";
                ?>
                <td>Stock ID:</td>
                <td><input name="stockid" type="text" id="stockid" readonly="readonly" maxlength="200"  class="round default-width-input" style="width:130px "  value="<?php echo $line->stock_id  ; ?>" /></td>

                <td>Date:</td>
                <td><input  name="date" id="test1" placeholder="" value="<?php echo $line->date ; ?> " type="text" id="name" maxlength="200"  class="round default-width-input"  /></td>
                <td><span class="man">*</span>Bill No:</td>
                <td><input name="bill_no" placeholder="ENTER BILL NO" type="text" id="bill_no" maxlength="200" value="<?php echo $line->billnumber ; ?> " class="round default-width-input" style="width:120px " /></td>

            </tr>
            <tr></tr>
            <tr>
                <td><span class="man">*</span>Supplier:</td>
                <td><input name="supplier" placeholder="ENTER SUPPLIER" type="text" id="supplier" value="<?php echo $line->stock_supplier_name 	 ; ?> "  maxlength="200"  class="round default-width-input"  style="width:130px " /></td>

                <td>Address:</td>
                <td><input name="address" placeholder="ENTER ADDRESS" type="text" value="<?php $quantity = $db->queryUniqueValue("SELECT supplier_address FROM supplier_details WHERE supplier_name='".$line->stock_supplier_name."'"); echo $quantity; ?>" id="address" maxlength="200"  class="round default-width-input"  /></td>

                <td>contact:</td>
                <td><input name="contact" placeholder="ENTER CONTACT" type="text" value="<?php $quantity = $db->queryUniqueValue("SELECT supplier_contact1 FROM supplier_details WHERE supplier_name='".$line->stock_supplier_name."'"); echo $quantity; ?>" id="contact1" maxlength="200"  class="round default-width-input" onkeypress="return numbersonly(event)" style="width:120px " /></td>

            </tr>
        </table>
    </div>

    <br>
    <input type="hidden" id="guid">
    <input type="hidden" id="edit_guid">
    <table id="hideen_display">
        <tr >
            <td>Name:</td>
            <td>Reg.no</td>
            <td>Eng.no</td>
            <td>Chas.no</td>
            <td>Avail Stock</td>
            <td>Quantity:</td>
            <td>Cost:</td>
        </tr>
    </table>
    <!--jhskfgskjfnks-->
    <table class="form" id="display" style="display:none;width:100%;" border='1'>
        <tr >
            <td><input name=""  type="text" id="item"  maxlength="200"  class="round default-width-input my_with" /></td>
            <td><input name=""  type="text" id="reg_no"  maxlength="200"  class="round default-width-input my_with"/></td>
            <td><input name=""  type="text" id="eng_no"  maxlength="200"   class="round  my_with" /></td>
            <td><input name=""  type="text" id="chas_no"  maxlength="200"  class="round my_with"/></td>
            <td><input name=""  type="text" id="stock" readonly="readonly" maxlength="200"  class="round  my_with"/></td>
            <td><input name=""  type="text" id="quty" readonly="readonly" maxlength="200"  class="round  my_with" /></td>
            <td><input name=""  type="text" id="total" maxlength="200"  class="round default-width-input" style="width:120px;  margin-left: 20px" /></td>
            <td><input type="button" onclick="balance_amount();add_values();" id="add_new_code"  style="margin-left:20px; width:30px;height:30px;border:none;background:url(images/save.png)" class="round">
            </td>
            <td> <input type="button" value="" id="cancel" onclick="clear_data()" style="width:30px;float: right; border:none;height:30px;background:url(images/close_new.png)">
            </td>
        </tr>
    </table>
    <input type="hidden" id="guid">
    <input type="hidden" id="edit_guid">


    <div style="overflow:auto ;max-height:300px;  ">

        <table class="form" id="item_copy_final" border='1'>
            <?php
            $sid=$line->stock_id;

            /*
            $max = $db->maxOf("count1", "stock_entries", "stock_id='$sid'");
            for($i=1; $i<=$max; $i++)
            {*/
            $stock_name = $quantity = $reg_no = $eng_no = $chas_no = $total = $stock_id =  [];
            $line1 = mysql_query("SELECT id,stock_name, quantity, reg_no, eng_no, chas_no, total ,stock_id FROM stock_entries WHERE stock_id='$sid'");
            while($fRows = mysql_fetch_array($line1)){
                $ent_id[] = $fRows['id'];
                $stock_name[] = $fRows['stock_name'];
                $quantity[] = $fRows['quantity'];
                $reg_no[] = $fRows['reg_no'];
                $eng_no[] = $fRows['eng_no'];
                $chas_no[] = $fRows['chas_no'];
                $total[] = $fRows['total'];
                $stock_id[] = $fRows['stock_id'];
            }


            for($i=0; $i<count($ent_id); $i++){
                $item= $db->queryUniqueValue("SELECT stock_id FROM stock_details WHERE stock_name='$stock_name[$i]'");
                ?>
                <tr>
                    <td><input name="stock_name[]"  type="text" id="<?php echo $ent_id[$i]."st"?>" maxlength="100"  readonly="readonly"  class="round default-width-input my_with"
                               value="<?php echo $stock_name[$i] ; ?>" /></td>
                    <td>
                        <input name="reg_no[]"  type="text" id="<?php echo $ent_id[$i]."r"?>" readonly="readonly" maxlength="200"   class="round  my_with"  value="<?php  echo $reg_no[$i] ; ?>" />
                    </td>
                    <td>
                        <input name="eng_no[]"  type="text" id="<?php echo $ent_id[$i]."e"?>" readonly="readonly" maxlength="200"   class="round  my_with"  value="<?php echo $eng_no[$i] ;?>" />
                    </td>
                    <td>
                        <input name="chas_no[]"  type="text" id="<?php echo $ent_id[$i]."h"?>" readonly="readonly" maxlength="200"   class="round  my_with"  value="<?php echo $chas_no[$i] ; ?>" />
                    </td>
                    <td>
                        <input name="stock[]"  type="text" id="<?php echo $ent_id[$i]."p"?>" readonly="readonly" maxlength="200"   class="round  my_with"  value="<?php $avlStk = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$stock_name[$i]'"); echo $avlStk; ?>" />
                    </td>
                    <td>
                        <input name="quantity[]"  type="text" id="<?php echo $ent_id[$i]."q"?>" maxlength="20"  class="round my_with"
                               value="<?php echo $quantity[$i] ; ?>" readonly="readonly" onkeypress="return numbersonly(event)" />
                    </td>
                    <td>
                        <input name="total[]"  type="text" id="<?php echo $ent_id[$i]."to"?>" readonly="readonly" maxlength="20" style="margin-left:20px;"  class="round default-width-input my_with"
                               value="<?php echo $total[$i]  ; ?>" />
                    </td>
                    <td>
                        <input type="hidden" id="<?php echo $ent_id[$i];?>"><input type="hidden" name="gu_id[]" value="<?php echo /*$line1->id*/$ent_id[$i]  ?>"></td>
                    <td><input type=button value="" id="<?php echo $ent_id[$i];?>" style="width:30px;border:none;height:30px;background:url(images/edit_new.png)" class="round" onclick="edit_stock_details(this.id)"  ></td>
                </tr>

            <?php
            }
            ?>
        </table>
    </div>

    <div class="mytable_row ">

        <table class="form">
            <tr> <td> &nbsp;</td>
                <td>Payment:<input type="text"  class="round" value="<?php  echo $line->payment ; ?>" onkeyup=" balance_amount(); return numbersonly(event);"  name="payment" id="payment" >
                </td>
                <td> &nbsp;</td>
                <td>Balance:<input type="text"  class="round" value="<?php echo $line->balance ; ?>" id="balance" name="balance" >
                </td>
                <td> &nbsp;</td>

                <td> &nbsp;</td><td> &nbsp;</td><td> &nbsp;</td><td> &nbsp;</td>
                <td>Grand Total:<input type="hidden" readonly="readonly" id="grand_total" value="<?php echo $line->subtotal ; ?>" name="subtotal" >
                    <input type="text" id="main_grand_total" class="round default-width-input" value="<?php echo $line->subtotal ; ?>" style="text-align:right;width: 120px" >
                </td>
            </tr> </table>
        <table>
            <tr>
                <td>Mode
                    <select name="mode">
                        <option value="Cash" <?php if($line->mode == 'Cash'){echo "selected='selected' ";} ?> >Cash</option>
                        <option value="Cheque" <?php if($line->mode == 'Cheque'){echo "selected='selected' ";} ?> >Cheque</option>
                        <option value="Other" <?php if($line->mode == 'Other'){echo "selected='selected' ";} ?> >Other</option>
                    </select>
                </td>
                <td>Cheque No:
                    <input type="text" name='cheque_no' value="<?php echo $line->cheque_no ; ?>" id='cheque_no' class="round"/></td>

                <td>Cheque Date:
                    <input type="date" name='cheque_date' value="<?php echo $line->cheque_date ; ?>" id='cheque_date' class="round"/></td>
            <tr>
                <td>
                    Due Date:<input type="date" name="due" id="test2" value="<?php echo $line->due;?>" class="round">
                </td>
                <td>Description
                    <textarea name="description"><?php  echo $line->description ;  ?></textarea></td>
            </tr>
        </table>
        <table class="form">
            <tr>
                <td>
                    <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Add">
                </td><td>			(Control + S)
                    <input class="button round red   text-upper"  type="reset" name="Reset" value="Reset"> </td>
                <td> &nbsp;</td> <td> &nbsp;</td>
            </tr>
        </table></div>
</form>


</div> <!-- end content-module-main -->


</div> <!-- end content-module -->



</div> <!-- end full-width -->

</div> <!-- end content -->



<!-- FOOTER -->
<div id="footer">
    

</div> <!-- end footer -->

</body>
</html>