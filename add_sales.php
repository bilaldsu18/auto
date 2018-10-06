<?php include_once("init.php");

if(isset($_POST['payment'])){
    $_POST = $gump->sanitize($_POST);

    $gump->validation_rules(array(
        'payment'=> 'required|max_len,100|min_len,1'




    ));

    $gump->filter_rules(array(
        'payment'    	  => 'trim|sanitize_string|mysql_escape'


    ));

    $validated_data = $gump->run($_POST);
    $stock_name 	= "";
    $stockid 	= "";
    $payment     = "";
    $bill_no 	= "";


    if($validated_data === false) {
        echo $gump->get_readable_errors(true);
    } else {
        $username = $_SESSION['username'];

        $stockid=mysql_real_escape_string($_POST['stockid']);
        $bill_no =mysql_real_escape_string($_POST['bill_no']);
        $customer=mysql_real_escape_string($_POST['supplier']);
        $address=mysql_real_escape_string($_POST['address']);
        $contact=mysql_real_escape_string($_POST['contact']);
        $cust_cat=mysql_real_escape_string($_POST['cust_cat']);
        $count = $db->countOf("customer_details", "customer_name='$customer'");
        if($count==0)
        {
            $db->query("insert into customer_details(customer_name,customer_address,customer_contact1) values('$customer','$address','$contact')");
        }
        $stock_name=$_POST['stock_name'];
        $quty=$_POST['quty'];
        $date=mysql_real_escape_string($_POST['date']);
        $sell=$_POST['sell'];
        $total=$_POST['total'];
        $payable=$_POST['subtotal'];
        $description=mysql_real_escape_string($_POST['description']);
        $due=mysql_real_escape_string($_POST['duedate']);
        $payment=mysql_real_escape_string($_POST['payment']);
        $discount=mysql_real_escape_string($_POST['discount']);
        if($discount==""){
            $discount=00;
        }
        $dis_amount=mysql_real_escape_string($_POST['dis_amount']);
        if($dis_amount==""){
            $dis_amount=00;
        }
        $subtotal=mysql_real_escape_string($_POST['payable']);
        $balance=mysql_real_escape_string($_POST['balance']);
        $installment=mysql_real_escape_string($_POST['installment']);
        $inst_amount=mysql_real_escape_string($_POST['inst_amount']);
        $mode=mysql_real_escape_string($_POST['mode']);
        $cheque_no=mysql_real_escape_string($_POST['cheque_no']);
        $cheque_date=mysql_real_escape_string($_POST['cheque_date']);
        $tax=mysql_real_escape_string($_POST['tax']);
        if($tax==""){
            $tax=00;
        }
        $tax_dis=mysql_real_escape_string($_POST['tax_dis']);
        $temp_balance = $db->queryUniqueValue("SELECT balance FROM customer_details WHERE customer_name='$customer'");
        $temp_balance = (int) $temp_balance +  (int) $balance;
        $db->execute("UPDATE customer_details SET balance=$temp_balance WHERE customer_name='$customer'");
        $max = $db->maxOfAll("id", "stock_entries");
        $max=$max+1;
        $autoid="SD".$max."";
        for($i=0;$i<count($stock_name);$i++){
            $gar1_name=$_POST['gar1_name'];
            $gar1_fname=$_POST['gar1_fname'];
            $gar1_cnic=$_POST['gar1_cnic'];
            $gar1_tel=$_POST['gar1_tel'];
            $gar1_cell=$_POST['gar1_cell'];
            $gar1_add=$_POST['gar1_add'];
            $gar2_name=$_POST['gar2_name'];
            $gar2_fname=$_POST['gar2_fname'];
            $gar2_cnic=$_POST['gar2_cnic'];
            $gar2_tel=$_POST['gar2_tel'];
            $gar2_cell=$_POST['gar2_cell'];
            $gar2_add=$_POST['gar2_add'];
            $name1=$stock_name[$i];
            $reg_no=$_POST['reg_no'][$i];
            $eng_no=$_POST['eng_no'][$i];
            $chas_no=$_POST['chas_no'][$i];
            $rate=$_POST['sell'][$i];
            $quantity=$_POST['quty'][$i];
            $total=$_POST['total'][$i];
            $selected_date=$_POST['date'];
            $selected_date=strtotime( $selected_date );
            $mysqldate = date( 'Y-m-d H:i:s', $selected_date );
            $username = $_SESSION['username'];

            $count = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");

            if($count >= 1)
            {
                $db->query("insert into stock_sales (tax,tax_dis,discount,dis_amount,grand_total,transactionid,stock_name,gar1_name,gar1_fname,gar1_cnic,gar1_tel,gar1_cell,gar1_add,gar2_name,gar2_fname,gar2_cnic,gar2_tel,gar2_cell,gar2_add,reg_no,eng_no,chas_no,selling_price,quantity,amount,date,username,customer_id,cust_cat,subtotal,payment,balance,installment,inst_amount,due,mode,cheque_no,cheque_date,description,count1,billnumber)
                            values($tax,'$tax_dis',$discount,$dis_amount,$payable,'$autoid','$name1','$gar1_name','$gar1_fname','$gar1_cnic','$gar1_tel','$gar1_cell','$gar1_add','$gar2_name','$gar2_fname','$gar2_cnic','$gar2_tel','$gar2_cell','$gar2_add','$reg_no','$eng_no','$chas_no',$rate,$quantity,$total,'$mysqldate','$username','$customer','$cust_cat',$subtotal,$payment,$balance,$installment,$inst_amount,'$due','$mode','$cheque_no','$cheque_date','$description',$i+1,'$bill_no')");

                $amount = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");
                $amount1 = $amount - $quantity;

                $db->query("insert into stock_entries (stock_id,stock_name,quantity,opening_stock,closing_stock,date,username,type,salesid,total,count1,billnumber)
                                                 values('$autoid','$name1',$quantity,$amount,$amount1,'$mysqldate','$username','sales','$autoid',$total,$i+1,'$bill_no')");
                //echo "<br><font color=green size=+1 >New Sales Added ! Transaction ID [ $autoid ]</font>" ;
                $db->query("INSERT INTO `payment_details`(stck_id,`total_amount`, `discount_amount`, `payable_amount`, `first_payment`, `remaining_amount`, `recovery_month`, `instal_amount`)
                    VALUES('$autoid',$payable,$dis_amount,$subtotal,$payment,$balance,$installment,$inst_amount)");

                $amount = $db->queryUniqueValue("SELECT quantity FROM stock_avail WHERE name='$name1'");
                $amount1 = $amount - $quantity;
                $db->execute("UPDATE stock_avail SET quantity=$amount1 WHERE name='$name1'");

            }
            else
            {
                echo "<br><font color=green size=+1 >There is no enough stock deliver for $name1! Please add stock !</font>" ;
            }
        }
        $msg="Sales Added successfully Ref: ". $_POST['stockid']."" ;
        header("Location:add_sales.php?msg=$msg");
        echo "<script>window.open('add_sales_print.php?sid=$autoid','myNewWinsr','width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no');</script>";
        //echo "<script>window.open('add_sales_print.php?sid=$autoid','myNewWinsr','width=620,height=800,toolbar=0,menubar=no,status=no,resizable=yes,location=no,directories=no');</script>";
        //$msg="<br><font color=green size=6px >Parchase order Added successfully Ref: [". $_POST['stockid']."] !</font>" ;
        //header("Location: add_purchase.php?msg=$msg");

    }
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<title>WAC - Add Sales</title>

<!-- Stylesheets -->
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="js/date_pic/date_input.css">
<link rel="stylesheet" href="lib/auto/css/jquery.autocomplete.css">

<!-- Optimize for mobile devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

<!-- jQuery & JS files -->
<?php include_once("tpl/common_js.php"); ?>
<script src="js/script.js"></script>
<script src="js/date_pic/jquery.date_input.js"></script>
<script src="lib/auto/js/jquery.autocomplete.js "></script>

<script type="text/javascript">

    $(document).ready(function (){
// Cheque files
        $("#type").change(function(){

            var type=$("#type").val();
            if(type=='Cheque'){
                $("#cheque_row").fadeIn('slow');
                $("#cheque2").fadeIn('slow');
            }
            else{
                $("#cheque_row").hide('slow');
                $("#cheque2").hide('slow');

            }

        });
    });

    $(function() {

        $("#supplier").autocomplete("customer1.php", {
            width: 160,
            autoFill: true,
            selectFirst: true
        });
        $("#item").autocomplete("stock.php", {
            width: 160,
            autoFill: true,
            mustMatch: true,
            selectFirst: true
        });
        $("#item").blur(function()
        {
            document.getElementById('total').value=document.getElementById('sell').value * document.getElementById('quty').value
        });
        $("#item").blur(function(){
            $.post('check_item_details.php', {stock_name1: $(this).val() },
                function(data){

                    $("#sell").val(data.sell);
                    $("#stock").val(data.stock);
                    $('#guid').val(data.guid);
                    if(data.sell!=undefined)
                        $("#0").focus();


                }, 'json');
        });
        $("#supplier").blur(function(){
            $.post('check_customer_details.php', {stock_name1: $(this).val() },
                function(data){
                    $("#address").val(data.address1);
                    $("#contact1").val(data.contact1);
                    if(data.address1!=undefined)
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

</script>
<script>
    /*$.validator.setDefaults({
     submitHandler: function() { alert("submitted!"); }
     });*/
    $(document).ready(function() {
        document.getElementById('bill_no').focus();
        // validate signup form on keyup and submit
        $("#form1").validate({
            rules: {
                bill_no: {
                    required: true,
                    minlength: 3,
                    maxlength: 200
                },
                stockid: {
                    required: true
                },
                grand_total: {
                    required: true
                },
                supplier: {
                    required: true
                },
                payment: {
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
                payment: {
                    required: "Please Enter Payment"
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
    function numbersonly(e){
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=27 && unicode!=38 && unicode!=39 && unicode!=40 && unicode!=9){ //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57)
                return false
        }
    }
</script>
<script type="text/javascript">

// Installment Amount

    function install(){

        var bal = document.getElementById('balance').value;
        var install = document.getElementById('installment').value;
        var result = bal/install;
        document.getElementById('inst_amount').value = result;
    }


function remove_row(o) {
    var p=o.parentNode.parentNode;
    p.parentNode.removeChild(p);
}
function add_values(){

        if(document.getElementById('edit_guid').value==""){
            if(unique_check()){
                if(document.getElementById('item').value!="" && document.getElementById('quty').value!="" && document.getElementById('sell').value!="" &&  document.getElementById('total').value!="" &&  document.getElementById('eng_no').value!="" ){

                    if(document.getElementById('quty').value!=0){
                        code=document.getElementById('item').value;
                        reg_no=document.getElementById('reg_no').value;
                        eng_no=document.getElementById('eng_no').value;
                        chas_no=document.getElementById('chas_no').value;
                        sell=document.getElementById('sell').value;
                        quty=document.getElementById('quty').value;
                        disc=document.getElementById('stock').value;
                        total=document.getElementById('total').value;
                        item=document.getElementById('item').value;
                        //item=document.getElementById('guid').value;
                        main_total=document.getElementById('posnic_total').value;
                        roll=parseInt(document.getElementById('roll_no').value);

                        $('<tr id="'+eng_no+'"><td><lable id="'+eng_no+'roll" class=jibi007 >'+roll+'</label></td>' +
                            '<td><input type=hidden value="'+item+'" id="'+eng_no+'id" >' +
                            '<input type=text name="stock_name[]" value="'+item+'" id="'+eng_no+'st"  class="round  my_with" readonly="readonly" ></td>' +
                            '<td><input type=text name=reg_no[] readonly="readonly" value="'+reg_no+'" id="'+eng_no+'r" class="round  my_with"  ></td>' +
                            '<td><input type=text name=eng_no[] readonly="readonly" value="'+eng_no+'" id="'+eng_no+'e" class="round  my_with"  ></td>' +
                            '<td><input type=text name=chas_no[] readonly="readonly" value="'+chas_no+'" id="'+eng_no+'h" class="round  my_with"  ></td>' +
                            '<td><input type=text name=sell[] readonly="readonly" value="'+sell+'" id="'+eng_no+'s" class="round  my_with"   ></td>' +
                            '<td><input type=text name=quty[] readonly="readonly" value="'+quty+'" id="'+eng_no+'q" class="round  my_with"  ></td>' +
                            '<td><input type=text name=stock[] readonly="readonly" value="'+disc+'" id="'+eng_no+'p" class="round  my_with"  ></td>' +
                            '<td><input type=text name=jibi[] readonly="readonly" value="'+total+'" id="'+eng_no+'to" class="round  my_with" >' +
                            '<input type=hidden name=total[] id="'+eng_no+'my_tot" value="'+main_total+'"> </td>' +
                            '<td><input type=button value="" id="'+eng_no+'" style="width:30px;border:none;height:30px;background:url(images/edit_new.png)" class="round" onclick="edit_stock_details(this.id)"  ></td>' +
                            '<td><input type=button value="" id="'+eng_no+'" style="width:30px;border:none;height:30px;background:url(images/close_new.png)" class="round" onclick=reduce_balance("'+eng_no+'");$(this).closest("tr").remove(); ></td>' +
                            '</tr>').fadeIn("slow").appendTo('#item_copy_final');
                        document.getElementById('reg_no').value="";
                        document.getElementById('eng_no').value="";
                        document.getElementById('chas_no').value="";
                        document.getElementById('sell').value="";
                        document.getElementById('quty').value="1";
                        document.getElementById('stock').value="";
                        document.getElementById('roll_no').value=roll+1;
                        document.getElementById('total').value="";
                        document.getElementById('item').value="";
                        document.getElementById('guid').value="";
                        if(document.getElementById('grand_total').value==""){
                            document.getElementById('grand_total').value=main_total;
                        }else{
                            document.getElementById('grand_total').value=parseFloat(document.getElementById('grand_total').value)+parseFloat(main_total);
                        }
                        document.getElementById('main_grand_total').value=parseFloat(document.getElementById('grand_total').value);
                        document.getElementById(eng_no+'st').value=code;
                        document.getElementById(eng_no+'to').value=total;
                    }else{
                        alert('No Stock Available For This Item');
                    }
                }else{
                    alert('Please Fill All Field');
                }
            }
        }else{
            id=document.getElementById('edit_guid').value;
            document.getElementById(id+'st').value=document.getElementById('item').value;
            document.getElementById(id+'r').value=document.getElementById('reg_no').value;
            document.getElementById(id+'e').value=document.getElementById('eng_no').value;
            document.getElementById(id+'h').value=document.getElementById('chas_no').value;
            document.getElementById(id+'s').value=document.getElementById('sell').value;
            document.getElementById(id+'q').value=document.getElementById('quty').value;
            document.getElementById(id+'p').value=document.getElementById('stock').value;
            document.getElementById(id+'to').value=document.getElementById('total').value;
            document.getElementById(id+'id').value=id;

            document.getElementById(id+'my_tot').value=document.getElementById('posnic_total').value;

            var GrndTotal = 0;
            $('#item_copy_final [name="total[]"]').each(function(){
                GrndTotal += parseInt($(this).val() );
            });
            $('#grand_total, #main_grand_total').val(GrndTotal);

            //document.getElementById('grand_total').value=parseFloat(document.getElementById('grand_total').value)+parseFloat(document.getElementById('posnic_total').value)-parseFloat(document.getElementById(id+'my_tot').value);
            //document.getElementById('main_grand_total').value=parseFloat(document.getElementById('grand_total').value);

            document.getElementById('reg_no').value="";
            document.getElementById('eng_no').value="";
            document.getElementById('chas_no').value="";
            document.getElementById('sell').value="";
            document.getElementById('quty').value="1";
            document.getElementById('stock').value="";
            document.getElementById('total').value="";
            document.getElementById('item').value="";
            document.getElementById('guid').value="";
            document.getElementById('edit_guid').value="";
        }

    discount_amount();
}
function total_amount(){
    balance_amount();

    document.getElementById('total').value=document.getElementById('sell').value * document.getElementById('quty').value
    document.getElementById('posnic_total').value=document.getElementById('total').value;
    //  document.getElementById('total').value = '$ ' + parseFloat(document.getElementById('total').value).toFixed(2);
    if(document.getElementById('item').value===""){
        document.getElementById('item').focus();
    }
}
function edit_stock_details(id) {
    document.getElementById('item').value=document.getElementById(id+'st').value;
    document.getElementById('reg_no').value=document.getElementById(id+'r').value;
    document.getElementById('eng_no').value=document.getElementById(id+'e').value;
    document.getElementById('chas_no').value=document.getElementById(id+'h').value;
    document.getElementById('sell').value=document.getElementById(id+'s').value;
    document.getElementById('quty').value=document.getElementById(id+'q').value;
    document.getElementById('stock').value=document.getElementById(id+'p').value;
    document.getElementById('total').value=document.getElementById(id+'to').value;

    document.getElementById('guid').value=id;
    document.getElementById('edit_guid').value=id;

}
function unique_check(){
    var ItemDuplicateVal = '';
    var RegDuplicateVal = '';
    var EngDuplicateVal = '';
    var ChasDuplicateVal = '';
    var dupItem = '';
    var StopUnit = false;

    var ItemName = $('#form1 #item').val();
    var RegNum = $('#form1 #reg_no').val();
    var EngNum = $('#form1 #eng_no').val();
    var ChasNum = $('#form1 #chas_no').val();

    var CombVal = ItemName+', '+RegNum+', '+EngNum+', '+ChasNum+', '

    $('#item_copy_final [name="stock_name[]"], [name="reg_no[]"], [name="eng_no[]"], [name="chas_no[]"], ').each(function(){
        dupItem += $(this).val()+', ';
        if(CombVal == dupItem){
            StopUnit = true
        }
    });
    //if(!document.getElementById(document.getElementById('guid').value) || document.getElementById('edit_guid').value==document.getElementById('guid').value){
    if(StopUnit == false){
        return true;
    }else{
        alert("This Item is already added In This Purchase - ("+dupItem+")");
        document.getElementById('item').focus();
        document.getElementById('reg_no').value="";
        document.getElementById('eng_no').value="";
        document.getElementById('chas_no').value="";
        document.getElementById('sell').value="";
        document.getElementById('quty').value="1";
        document.getElementById('stock').value="";
        document.getElementById('total').value="";
        document.getElementById('item').value="";
        document.getElementById('guid').value="";
        document.getElementById('edit_guid').value="";
        return false;
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
function formatCurrency(fieldObj)
{
    if (isNaN(fieldObj.value)) { return false; }
    fieldObj.value = '$ ' + parseFloat(fieldObj.value).toFixed(2);
    return true;
}
function balance_amount(){
    if(document.getElementById('payable_amount').value!="" && document.getElementById('payment').value!=""){
        data=parseFloat(document.getElementById('payable_amount').value);
        document.getElementById('balance').value=data-parseFloat(document.getElementById('payment').value);
        if(parseFloat(document.getElementById('payable_amount').value) >= parseFloat(document.getElementById('payment').value)){

        }else{
            if(document.getElementById('payable_amount').value!=""){
                document.getElementById('balance').value='000.00';
                document.getElementById('payment').value=parseFloat(document.getElementById('payable_amount').value);
            }else{
                document.getElementById('balance').value='000.00';
                document.getElementById('payment').value="";
            }
        }
    }else{
        document.getElementById('balance').value="";
    }
}
function stock_size(){
    if(parseFloat(document.getElementById('quty').value) > parseFloat(document.getElementById('stock').value)){
        document.getElementById('quty').value=parseFloat(document.getElementById('stock').value);

        console.log();
    }
}
function discount_amount(){

    if(document.getElementById('grand_total').value!=""){
        document.getElementById('disacount_amount').value=parseFloat(document.getElementById('grand_total').value)*(parseFloat(document.getElementById('discount').value))/100;

    }
    if(document.getElementById('discount').value==""){
        document.getElementById('disacount_amount').value="";
    }

    discont=parseFloat(document.getElementById('disacount_amount').value);
    if(document.getElementById('disacount_amount').value==""){
        discont=0;
    }
    document.getElementById('payable_amount').value=parseFloat(document.getElementById('grand_total').value)-discont;
    if(parseFloat(document.getElementById('payment').value)>parseFloat(document.getElementById('payable_amount').value)){
        document.getElementById('payment').value=parseFloat(document.getElementById('payable_amount').value);

    }
}
function discount_as_amount(){
    if(parseFloat(document.getElementById('disacount_amount').value) > parseFloat(document.getElementById('grand_total').value))
        document.getElementById('disacount_amount').value="";

    if(document.getElementById('grand_total').value!=""){
        if(parseFloat(document.getElementById('disacount_amount').value) < parseFloat(document.getElementById('grand_total').value))
        { discont=parseFloat(document.getElementById('disacount_amount').value);

            document.getElementById('payable_amount').value=parseFloat(document.getElementById('grand_total').value)-discont;
            if(parseFloat(document.getElementById('payment').value)>parseFloat(document.getElementById('payable_amount').value)){
                document.getElementById('payment').value=parseFloat(document.getElementById('payable_amount').value);

            }
        }else{
            // document.getElementById('disacount_amount').value=parseFloat(document.getElementById('grand_total').value)-1;
        }
    }
}
function reduce_balance(id){
    var minus=parseFloat(document.getElementById(id+"my_tot").value);
    document.getElementById('grand_total').value=parseFloat(document.getElementById('grand_total').value)-minus;
    document.getElementById('main_grand_total').value=parseFloat(document.getElementById('grand_total').value);
    discount_amount();
    var elements = document.getElementsByClassName('jibi007');
    var j=1;
    var my_id=id+'roll';
    for (var i = 0; i < elements.length; i++) {
        elements[0].value=1;
        if(parseFloat(document.getElementById(my_id).innerHTML)==i){
            elements[i].innerHTML =parseFloat(elements[i-1].innerHTML)
        }else{
            if(i!=0){
                elements[i].innerHTML =parseFloat(elements[i-1].innerHTML)+1;
                j++;
            }
        }
        document.getElementById('roll_no').value=elements.length;
    }
    //console.log(id);
}
function discount_type(){
    if(document.getElementById('round').checked){
        document.getElementById("discount").readOnly=true;
        document.getElementById("disacount_amount").readOnly=false;
        if(parseFloat(document.getElementById('grand_total'))!=""){
            document.getElementById('disacount_amount').value="";
            document.getElementById('discount').value="";
            discount_amount();
        }
    }else{
        document.getElementById("discount").readOnly=false;
        document.getElementById("disacount_amount").readOnly=true;
    }
}
function discount_type_per(){
    if(document.getElementById('round').checked){
        document.getElementById("disacount_amount").value="";
        document.getElementById('discount').disabled=false;
        document.getElementById("discount").readOnly=false;
        document.getElementById("disacount_amount").readOnly=true;
        document.getElementById("disacount_amount").style.background="#D9DBDD";

    }else{
        document.getElementById("disacount_amount").style.background='white';
        document.getElementById('discount').disabled=true;
        document.getElementById("discount").readOnly=true;
        document.getElementById("disacount_amount").readOnly=false;
        if(parseFloat(document.getElementById('grand_total'))!=""){
            document.getElementById('disacount_amount').value="";
            document.getElementById('discount').value="";
            discount_amount();
        }
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

    <h3>Sales Management</h3>
    <ul>
        <li><a href="add_sales.php">Add Sales</a></li>
        <li><a href="view_sales.php">View Sales</a></li>
    </ul>

</div> <!-- end side-menu -->

<div class="side-content fr">

<div class="content-module">

<div class="content-module-heading cf">

    <h3 class="fl">Add Sales</h3>
    <span class="fr expand-collapse-text">Click to collapse</span>
    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

</div> <!-- end content-module-heading -->

<div class="content-module-main cf">


<?php
//Gump is libarary for Validatoin
if(isset($_GET['msg'])){
    $data=$_GET['msg'];
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

<form name="form1" method="post" id="form1" action="">
    <input type="hidden" id="posnic_total" >
    <input type="hidden" id="roll_no" value="1" >

    <div class="mytable_row "><br>
        <table class="form "  border="0" cellspacing="0" cellpadding="0">
            <tr>  <td>&nbsp; </td> <td>&nbsp; </td>
                <?php
                $max = $db->maxOfAll("id","stock_entries");
                $max=$max+3;
                $autoid="PR".$max."";
                ?>
                <td>Stock ID:</td>
                <td>
                    <input name="stockid" type="text" id="stockid" readonly="readonly" maxlength="200"  class="round default-width-input" style="width:130px " value="<?php echo $autoid ?>" />
                </td>

                <td>Date:</td>
                <td>
                    <input  name="date" id="test1" placeholder="" value="<?php echo date('d-m-Y');?>" type="text" id="name" maxlength="200"  class="round default-width-input"  />
                </td>
                <td>&nbsp; </td>  <td>&nbsp; </td>  <td ><span class="man">*</span>Bill No:<input type="hidden"> </td>

                <td><input name="bill_no" placeholder="ENTER BILL NO" type="text" id="bill_no" maxlength="200"  class="round default-width-input" style="width:120px " /></td>

            </tr>
            <tr>  <td>&nbsp; </td> <td>&nbsp; </td>
                <td><span class="man">*</span>Customer:</td>
                <td><input name="supplier" placeholder="ENTER CUSTOMER" type="text" id="supplier"  maxlength="200"  class="round default-width-input"  style="width:130px " /></td>

                <td>Address:</td>
                <td><input name="address" placeholder="ENTER ADDRESS" type="text" id="address" maxlength="200"  class="round default-width-input"  /></td>

                <td>&nbsp; </td> <td>&nbsp; </td> <td >contact:&nbsp; &nbsp; &nbsp; </td>
                <td><input name="contact" placeholder="ENTER CONTACT" type="text" id="contact1" maxlength="200"  class="round default-width-input" onkeypress="return numbersonly(event)" style="width:120px " /></td>

            </tr>
            <tr></tr>
            <tr>
                <td colspan='10' align='center'>
                    Customer Category
                    <select name="cust_cat" id="cust_cat" class="round default-width-input my_with">
                        <option value="null">--Select Category--</option>
                        <option value="Cash">Cash</option>
                        <option value="Lease">Lease</option>
                        <option value="Dealer">Dealer</option>
                    </select>
                </td>
            </tr>
        </table>
        <br>

    </div><br>

    <div align='center'>
        <table class="form "  border="2" cellspacing="0" cellpadding="0" style='width:80%'>
            <tr style='font-size: 1.2em;font-weight: bolder;'>
                <td colspan='12' align='center'>Guarantor 1</td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" name='gar1_name' placeholder='ENTER GUARANTOR NAME' class="round default-width-input" style="width:180px "/></td>

                <td>S/O:</td>
                <td><input type="text" name='gar1_fname' placeholder='ENTER GUARANTOR FATHER' class="round default-width-input" style="width:180px "/></td>

                <td>CNIC:</td>
                <td><input type="text" name='gar1_cnic' placeholder='ENTER GUARANTOR NIC' class="round default-width-input" style="width:180px "/></td>

            </tr>
            <tr>
                <td>Tel. No:</td>
                <td><input type="text" name='gar1_tel' placeholder='ENTER GUARANTOR NAME' class="round default-width-input" style="width:180px "/></td>

                <td>Cell No:</td>
                <td><input type="text" name='gar1_cell' placeholder='ENTER GUARANTOR FATHER' class="round default-width-input" style="width:180px "/></td>

                <td>Address:</td>
                <td><textarea name="gar1_add" id="" cols="24" rows="" placeholder='ENTER GUARANTOR ADDRESS'></textarea></td>

            </tr>
            <tr style='font-size: 1.2em;font-weight: bolder;'>
                <td colspan='12' align='center'>Guarantor 2</td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><input type="text" name='gar2_name' placeholder='ENTER GUARANTOR NAME' class="round default-width-input" style="width:180px "/></td>

                <td>S/O:</td>
                <td><input type="text" name='gar2_fname' placeholder='ENTER GUARANTOR FATHER' class="round default-width-input" style="width:180px "/></td>

                <td>CNIC:</td>
                <td><input type="text" name='gar2_cnic' placeholder='ENTER GUARANTOR NIC' class="round default-width-input" style="width:180px "/></td>

            </tr>
            <tr>
                <td>Tel. No:</td>
                <td><input type="text" name='gar2_tel' placeholder='ENTER GUARANTOR NAME' class="round default-width-input" style="width:180px "/></td>

                <td>Cell No:</td>
                <td><input type="text" name='gar2_cell' placeholder='ENTER GUARANTOR FATHER' class="round default-width-input" style="width:180px "/></td>

                <td>Address:</td>
                <td><textarea name="gar2_add" id="" cols="24" rows="" placeholder='ENTER GUARANTOR ADDRESS'></textarea></td>

            </tr>
        </table>
    </div>

    <div align="center">
        <input type="hidden" id="guid">
        <input type="hidden" id="edit_guid">

        <table class="form" border='1'>
            <tr>
                <td>Name:</td>
                <td>Reg_no:</td>
                <td>Eng_no:</td>
                <td>Chas_no:</td>
                <td>Sell Price:</td>
                <td>Quantity:</td>

                <td>Avail Stock:</td>
                <td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</td>
                <td> &nbsp;</td>
            </tr>
            <tr>

                <td><input name=""  type="text" id="item"  maxlength="200"  class="round default-width-input my_with"    /></td>
                <td><input name=""  type="text" id="reg_no"  maxlength="200"  class="round default-width-input my_with"    /></td>
                <td><input name=""  type="text" id="eng_no"  maxlength="200"  class="round default-width-input my_with"    /></td>
                <td><input name=""  type="text" id="chas_no"  maxlength="200"  class="round default-width-input my_with"   /></td>
                <td><input name=""  type="text" id="sell"  maxlength="200"  class="round default-width-input my_with"    onkeyup="total_amount();"/></td>
                <td><input name=""  type="text" id="quty" value='1' maxlength="200" readonly='true'  class="round default-width-input my_with" /></td>
                <td><input name=""  type="text" id="stock" readonly="readonly" maxlength="200"  class="round  my_with"   /></td>
                <td><input name=""  type="text" id="total" maxlength="200"  class="round default-width-input my_with" /></td>
                <td><input type="button" onclick="add_values()" onkeyup=" balance_amount();" id="add_new_code"  style="margin-left:30px; width:30px;height:30px;border:none;background:url(images/add_new.png)" class="round"> </td>

            </tr>
        </table>

        <div style="overflow:auto ;max-height:300px;  ">
            <table class="form" id="item_copy_final" style="margin-left:45px ">

            </table>
        </div>
    </div>

    <div class="mytable_row ">
        <table class="form" >
            <tr>
                <td> &nbsp;</td> <td colspan='2'> <input type="checkbox" id="round" onclick="discount_type_per()" >Discount As Percentage</td>
                <td></td> </tr>
            <tr></tr>
            <tr>
                <td> &nbsp;</td>
                <td>Discount %<input type="text" maxlength="3" disabled class="round" onkeyup=" discount_amount(); " onkeypress="return numbersonly(event);" name="discount" id="discount" >
                </td>
                <td>Discount Amount:<input type="text"  onkeypress="return numbersonly(event);"  onkeyup=" discount_as_amount(); "  class="round" id="disacount_amount" name="dis_amount" >
                </td>
                <td>Grand Total:<input type="hidden" readonly="readonly" id="grand_total" name="subtotal" >
                    <input type="text" id="main_grand_total" readonly="readonly" class="round default-width-input"  style="text-align:right;width: 120px" >
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td> &nbsp;</td>
                <td>Payment:<input type="text"  class="round" onkeyup=" balance_amount(); " onkeypress="return numbersonly(event);" name="payment" id="payment" >
                </td>
                <td>Balance:<input type="text"  class="round" readonly="readonly" id="balance" name="balance" >
                </td>
                <td>Payable Amount:<input type="hidden" readonly="readonly" id="grand_total"  >
                    <input type="text" id="payable_amount" readonly="readonly" name="payable" class="round default-width-input"  style="text-align:right;width: 120px" >
                </td>
                <td>Installment: <input type="text" id='installment' required='true' onkeyup='install()' name='installment' class="round default-width-input" style="width: 120px"/></td>
                <td>Installment Amount: <input type="text" id='inst_amount' readonly='true' name='inst_amount' class="round default-width-input"  style="width: 120px"/></td>
            </tr>
            <tr></tr>
            <tr> <td>&nbsp;</td>
                <td>Mode
                    <select name="mode" id='type' >
                        <option value="Cash">Cash</option>
                        <option value="Cheque">Cheque</option>
                        <option value="Other">Other</option>
                    </select>
                </td>
            </tr>
            <tr id='cheque_row' style='display:none'><td>&nbsp;</td><td>&nbsp;</td>
                <td>Cheque No:
                    <input type="text" name='cheque_no' id='cheque_no' class="round"/></td>

                <td>Cheque Date:
                    <input type="date" name='cheque_date' id='cheque_date' class="round"/></td>
            </tr>
            <tr></tr>
            </tr>
            <tr><td>&nbsp;</td>
                <td>
                    Due Date:<input type="date" name="duedate" id="duedate"  class="round" style='width:150px;height:20px'>
                </td>
                <td> Tax:<input type="text" name="tax" onkeypress="return numbersonly(event);"></td>
                <td>Tax Description:<input type="text" name="tax_dis"> </td>
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
        </table>
    </div>
</form>

</div> <!-- end content-module-main -->
</div> <!-- end content-module -->
</div></div> <!-- end full-width -->
</div> <!-- end content -->
<!-- FOOTER -->
<div id="footer">
    

</div> <!-- end footer -->

</body>
</html>