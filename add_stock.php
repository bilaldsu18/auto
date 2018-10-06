<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8">
<title>WAC - Add Stock</title>

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

<script>
    /*$.validator.setDefaults({
     submitHandler: function() { alert("submitted!"); }
     });*/
    $(document).ready(function() {
        $("#supplier").autocomplete("supplier1.php", {
            width: 160,
            autoFill: true,
            selectFirst: true
        });
        $("#category").autocomplete("category.php", {
            width: 160,
            autoFill: true,
            selectFirst: true
        });
        // validate signup form on keyup and submit
        $("#form1").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 200
                },
                stockid: {
                    required: true,
                    minlength: 3,
                    maxlength: 200
                },
                cost: {
                    required: true,

                },
                sell: {
                    required: true,

                }
            },
            messages: {
                name: {
                    required: "Please Enter Stock Name",
                    minlength: "Category Name must consist of at least 3 characters"
                },
                stockid: {
                    required: "Please Enter Stock ID",
                    minlength: "Category Name must consist of at least 3 characters"
                },
                sell: {
                    required: "Please Enter Selling Price",
                    minlength: "Category Name must consist of at least 3 characters"
                },
                cost: {
                    required: "Please Enter Cost Price",
                    minlength: "Category Name must consist of at least 3 characters"
                }
            }
        });

    });
    function numbersonly(e){
        var unicode=e.charCode? e.charCode : e.keyCode
        if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=38 && unicode!=39 && unicode!=40 && unicode!=9){ //if the key isn't the backspace key (which we should allow)
            if (unicode<48||unicode>57)
                return false
        }
    }
</script>
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

    <h3>Stock Management</h3>
    <ul>
    <li><a href="add_stock.php">Add Stock/Product</a></li>
    <li><a href="view_product.php">View Stock/Product</a></li>
    <li><a href="add_category.php">Add Stock Category</a></li>
    <li><a href="view_category.php">view Stock Category</a></li>
    <li><a href="view_stock_availability.php">view Stock Available</a></li>


    </ul>


    </div> <!-- end side-menu -->

<div class="side-content fr">

    <div class="content-module">

    <div class="content-module-heading cf">

    <h3 class="fl">Add Stock </h3>
<span class="fr expand-collapse-text">Click to collapse</span>
<div style="margin-top: 15px;margin-left: 150px"></div>
    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

    </div> <!-- end content-module-heading -->

<div class="content-module-main cf">


    <?php
    //Gump is libarary for Validatoin

    if(isset($_POST['stock_name'])){
    $_POST = $gump->sanitize($_POST);
    $gump->validation_rules(array(
        'stock_name'    	  => 'required|max_len,100|min_len,2',
        'stockid'     => 'required|max_len,200',
        'supplier'     => 'max_len,200',
        'category'     => 'max_len,200'

    ));

    $gump->filter_rules(array(
        'stock_name'    	  => 'trim|sanitize_string|mysql_escape',
        'stockid'     => 'trim|sanitize_string|mysql_escape',
        'category'     => 'trim|sanitize_string|mysql_escape',
        'supplier'     => 'trim|sanitize_string|mysql_escape',
		'quantity'		 => 'trim|sanitize_string|mysql_escape',
		'color'		 => 'trim|sanitize_string|mysql_escape',
		'model'		 => 'trim|sanitize_string|mysql_escape'

    ));

    $validated_data = $gump->run($_POST);
    $name 		= "";
    $stockid 	= "";
    $supplier 	= "";
    $category 	= "";


    if($validated_data === false) {
            echo $gump->get_readable_errors(true);
    } else {



            $stockid=mysql_real_escape_string($_POST['stockid']);
            $stock_name=mysql_real_escape_string($_POST['stock_name']);
            $supplier=mysql_real_escape_string($_POST['supplier']);
            $category=mysql_real_escape_string($_POST['category']);
			$quantity=mysql_real_escape_string($_POST['quantity']);
			$model=mysql_real_escape_string($_POST['model']);
			$color=mysql_real_escape_string($_POST['color']);

        $count = $db->countOf("stock_details","stock_name='$stock_name'");
if($count>0)
{
$data='Dublicat Entry. Please Verify';
                            $msg=$data;//
                            ?>



    <script type="text/javascript">

    alert('<?php echo $msg; ?>');

    </script>
<?php
}
    else
    {

        if($db->query("insert into stock_details(stock_name,quantity,color,model) values('$stock_name','$quantity','$color','$model')"))
        {
           // $db->query("insert into stock_details(id,name,quantity,color,model) values('$stockid','$name','$quantity','$color','$model')");
            $msg=" $name Stock Details Added" ;
            echo"<script>window.open('add_stock.php?msg=$msg','_self')</script>";
        }else
            echo "<br><font color=red size=+1 >Problem in Adding !</font>" ;

    }


}

}

if(isset($_GET['msg'])){
    $msg=$_GET['msg'];

    ?>


    <script type="text/javascript">

        alert('<?php echo $msg; ?>');

    </script>
<?php
}

?>

<form name="form1" method="post" id="form1" action="">


    <table class="form"  border="1" cellspacing="" cellpadding="">
        <tr>
            <?php
            $max = $db->maxOfAll("id", "stock_details");
            $max=$max+1;
            $autoid="SD".$max."";
            ?>
            <td><span class="man">*</span>ID:</td>
            <td><input name="stockid" type="text" id="stockid" readonly="readonly" maxlength="200"  class="round default-width-input" value="<?php echo $autoid; ?>" /></td>

            <td><span class="man">*</span>Name:</td>
            <td><input name="stock_name"placeholder="ENTER PRODUCT NAME" type="text" id="stock_name" maxlength="200"  class="round default-width-input" value="<?php echo $stock_name; ?>" /></td>
			<td><span class="man">*</span>Quantity:</td>
			<td ><input name="quantity"placeholder="ENTER Quantity" type="text" id="quantity" maxlength="200"  class="round default-width-input" value="<?php echo $quantity; ?>" /></td>
		 <tr> 	<td><span class="man">*</span>Color:</td>
			<td><input name="color"placeholder="ENTER Color" type="text" id="color" maxlength="200"  class="round default-width-input" value="<?php echo $color; ?>" /></td>
			<td><span class="man">*</span>Model No:</td>
			<td><input name="model"placeholder="ENTER Model No" type="text" id="model" maxlength="200"  class="round default-width-input" value="<?php echo $model; ?>" /></td>
		</tr>

        <tr>
            <td>Category:</td>
            <td><input name="category" value="" type="text" id="category" maxlength="200"  class="round default-width-input" value="<?php echo $category; ?>" /></td>
		</tr>
		<tr>
		</tr>
<tr>		
            <td colspan='2' align="right">
                <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Add">
                (Control + S)

                <input class="button round red   text-upper"  type="reset" name="Reset" value="Reset"> </td>
        </tr>
    </table>
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