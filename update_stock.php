<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WAC - Update Stock</title>

    <!-- Stylesheets -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script>
        /*$.validator.setDefaults({
         submitHandler: function() { alert("submitted!"); }
         });*/
        $(document).ready(function() {

            // validate signup form on keyup and submit
            $("#form1").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 200
                    },

                    cost: {
                        required: true

                    },
                    sell: {
                        required: true

                    }
                },
              
            });
        });
        function numbersonly(e){
            var unicode=e.charCode? e.charCode : e.keyCode
            if (unicode!=8 && unicode!=46 && unicode!=37 && unicode!=38 && unicode!=39 && unicode!=40){ //if the key isn't the backspace key (which we should allow)
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
                    <h3 class="fl">Update Stock</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>
                </div> <!-- end content-module-heading -->
                <div class="content-module-main cf">
                    <form name="form1" method="post" id="form1" action="">
                        <p><strong>Add Stock Details </strong> - Add New ( Control + U)</p>
                        <table class="form"  border="1" cellspacing="0" cellpadding="0">
                            <?php
                            if(isset($_POST['id']))
                            {
                                $id=mysql_real_escape_string($_POST['sid']);
                                $stkID=mysql_real_escape_string($_POST['stock_id']);
                                $stock_name=  trim(mysql_real_escape_string($_POST['stock_name']));
                                $category=  trim(mysql_real_escape_string($_POST['category']));

                                $updStkDet = $db->query("UPDATE stock_details  SET stock_name ='$stock_name' where id='$id'	");
															
                               // $updStkAvb = $db->query("UPDATE `stock_avail` SET name ='$name' WHERE `stockID`='$stkID'");
                            }
                            if($updStkDet)
                            {
                               // $data=" $stock_name    Details Updated" ;
                                //$msg='<p style=color:#153450;font-family:gfont-family:Georgia, Times New Roman, Times, serif>'.$data.'</p>';//
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
                            else
                                //echo "<br><font color=red size=+1 >Problem in Updation !</font>" ;
                            ?>
                            <?php
                            if(isset($_GET['sid']))
                                $id=$_GET['sid'];
                            $line = $db->queryUniqueObject("SELECT * FROM stock_details WHERE id=$id");
                            ?>
                            <form name="form1" method="post" id="form1" action="">

                                <input name="id" type="hidden" value="<?php echo $_GET['sid']; ?>">
                                <tr>
                                    <td>Stock ID</td>
                                    <td>
                                        <input name="stock_id" type="text" readonly="readonly" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $line->stock_id ; ?> "/>
                                    </td>
                                    <td><span class="man">*</span>Name:</td>
                                    <td><input name="name"placeholder="ENTER PRODUCT NAME" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $line->stock_name ; ?> "/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Category:</td>
                                    <td><input name="category"  type="text" id="category" maxlength="200"  class="round default-width-input" value="<?php echo $line->category ; ?> " /></td>
                                    <td colspan='2' align="right">
                                        <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Save">
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