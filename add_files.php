<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>

    <meta charset="utf-8">
    <title>WAC - Add Files</title>

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
                    eng_no: {
                        required: true,
                        minlength: 3,
                        maxlength: 200
                    },
                    chas_no: {
                        required: true,
                        minlength: 3,
                        maxlength: 200
                    },
                    contact: {
                        minlength: 3,
                        maxlength: 20
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a supplier Name",
                        minlength: "Supplier must consist of at least 3 characters"
                    }
                };
        });

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
            <h3>Files Record</h3>
            <ul>
                <li><a href="add_files.php">Add Files Delivery</a></li>
                <li><a href="view_files.php">View Files Delivery</a></li>
            </ul>
        </div> <!-- end side-menu -->
        <div class="side-content fr">
            <div class="content-module">
                <div class="content-module-heading cf">
                    <h3 class="fl">Files Record</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>
                </div> <!-- end content-module-heading -->
                <div class="content-module-main cf">
                    <?php
                    //Gump is libarary for Validatoin

                    if(isset($_POST['name'])){
                        $_POST = $gump->sanitize($_POST);
                        $gump->validation_rules(array(
                            'contact'    	  => 'required',
                            'name'    	  => 'required|max_len,100|min_len,3',
                            'f_name'    	  => 'required|max_len,100|min_len,3',
                        ));
                        $gump->filter_rules(array(
                            'name'    	      => 'trim|sanitize_string|mysql_escape',
                            'f_name'    	  => 'trim|sanitize_string|mysql_escape',
                            'contact'         => 'trim|sanitize_string|mysql_escape',
                            'reg_no'    	  => 'trim|sanitize_string|mysql_escape',
                            'eng_no'    	  => 'trim|sanitize_string|mysql_escape',
                            'chas_no'    	  => 'trim|sanitize_string|mysql_escape',
                            'file_del'    	  => 'trim|sanitize_string|mysql_escape',
                            'order'    	  => 'trim|sanitize_string|mysql_escape',
                        ));
                        $validated_data = $gump->run($_POST);
                        $name    	        = "";
                        $f_name    	  = "";
                        $contact         = "";
                        $reg_no    	    = "";
                        $eng_no    	     = "";
                        $chas_no    	  = "";
                        $file_del    	      = "";
                        $order    	          = "";

                        if($validated_data === false) {
                            echo $gump->get_readable_errors(true);
                        } else {
                            $name=mysql_real_escape_string($_POST['name']);
                            $f_name=mysql_real_escape_string($_POST['f_name']);
                            $contact=mysql_real_escape_string($_POST['contact']);
                            $reg_no=mysql_real_escape_string($_POST['reg_no']);
                            $eng_no=mysql_real_escape_string($_POST['eng_no']);
                            $chas_no=mysql_real_escape_string($_POST['chas_no']);
                            $file_del=mysql_real_escape_string($_POST['file_del']);
                            $order=mysql_real_escape_string($_POST['order']);
                            $count = $db->countOf("registration_excise", "name='$name'");
                            if($count==1)
                            {
                                $data='Delicate Entry. Please Verify';
                                $msg='<p style=color:red;font-family:gfont-family:Georgia, Times New Roman, Times, serif>'.$data.'</p>';//
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
                            {
                                if($db->query("insert into file_records values(NULL,'$name','$f_name','$contact','$reg_no','$eng_no','$chas_no','$file_del','$order')"))
                                {
                                    $msg="$name  Customer Details Added" ;
                                    echo"
						 <script>window.open('add_files.php?msg=$msg','_self');</script>
						 ";
                                }
                                else
                                    echo "<br><font color=red size=+1 >Problem in Adding !</font>" ;

                            }
                        }
                    }
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
                        <table class="form"  border="0" cellspacing="0" cellpadding="">
                            <tr></tr>
                            <tr>
                                <td><span class="man">*</span>Name:</td>
                                <td><input name="name"placeholder="ENTER NAME" type="text" id="name" maxlength="200"  class="round default-width-input"/></td>
                                <td><span class="man">*</span>S/O:</td>
                                <td><input name="f_name"placeholder="ENTER FATHER NAME" type="text" id="f_name" maxlength="200"  class="round default-width-input"/></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>Contact:</td>
                                <td><input name="contact" placeholder="ENTER CONTACT NO" type="text" id="contact" maxlength="20"   class="round default-width-input"
                                           value="<?php echo $contact1; ?>" /></td>
                                <td>Reg.No:</td>
                                <td> <input name="reg_no"placeholder="ENTER REG.NO" type="text" id="reg_no" maxlength="20"  class="round default-width-input" /></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>Eng.No:</td>
                                <td><input name="eng_no" placeholder="ENTER ENG.NO" type="text" id="eng_no" maxlength="20"   class="round default-width-input"
                                           value="<?php echo $contact1; ?>" /></td>
                                <td>Chas.No:</td>
                                <td> <input name="chas_no"placeholder="ENTER CHAS.NO" type="text" id="chas_no" maxlength="20"  class="round default-width-input" /></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>File Deliver:</td>
                                <td><input name="file_del"  type="date" id="file_del" maxlength="20"  style='width:245px;height:18px;'  class="round default-width-input"/></td>
                                <td>Order:</td>
                                <td> <input name="order" placeholder="ORDER BY" type="text" id="order" maxlength="20"  class="round default-width-input" /></td>
                            </tr>
                            <tr></tr>
                            <tr></tr>
                            <tr>
                                <td colspan='4' align='right'>
                                    <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Add">
                                </td>
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