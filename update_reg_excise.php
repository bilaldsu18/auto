<?php
include_once("init.php");

?>
<!DOCTYPE html>

<html lang="en">
<head>

    <meta charset="utf-8">
    <title>WAC - Edit Registration</title>

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
            <h3>Registration Excise</h3>
            <ul>
                <li><a href="add_reg_excise.php">Add Reg.Excise</a></li>
                <li><a href="view_reg_excise.php">View Reg.Excise</a></li>
            </ul>

        </div> <!-- end side-menu -->
        <div class="side-content fr">
            <div class="content-module">
                <div class="content-module-heading cf">
                    <h3 class="fl">Update Registration Excise Book</h3>
                    <span class="fr expand-collapse-text">Click to collapse</span>
                    <span class="fr expand-collapse-text initial-expand">Click to expand</span>
                </div> <!-- end content-module-heading -->

                <?php
                if(isset($_POST['id']))

                {

                    $id=mysql_real_escape_string($_POST['id']);
                    $reg_date =  trim(mysql_real_escape_string($_POST['reg_date']));
                    $care_of =  trim(mysql_real_escape_string($_POST['care_of']));
                    $name =  trim(mysql_real_escape_string($_POST['name']));
                    $f_name =  trim(mysql_real_escape_string($_POST['f_name']));
                    $contact =  trim(mysql_real_escape_string($_POST['contact']));
                    $reg_no =  trim(mysql_real_escape_string($_POST['reg_no']));
                    $eng_no =  trim(mysql_real_escape_string($_POST['eng_no']));
                    $chas_no =  trim(mysql_real_escape_string($_POST['chas_no']));
                    $file_rec =  trim(mysql_real_escape_string($_POST['file_rec']));
                    $status =  trim(mysql_real_escape_string($_POST['status']));
                    $no_plateR =  trim(mysql_real_escape_string($_POST['no_plateR']));
                    $no_plateD =  trim(mysql_real_escape_string($_POST['no_plateD']));

                    if($db->query("UPDATE registration_excise  SET reg_date ='$reg_date', care_of='$care_of', name='$name', f_name='$f_name', contact='$contact', reg_no='$reg_no', eng_no='$eng_no', chas_no='$chas_no', file_rec='$file_rec', status='$status', no_plateR='$no_plateR', no_plateD='$no_plateD' where id=$id"))
                    {
                        $data=" $name  Supplier Details Updated" ;
                        $msg='<p style=color:#153450;font-family:gfont-family:Georgia, Times New Roman, Times, serif>'.$data.'</p>';//
                        ?>

                        <script  src="dist/js/jquery.ui.draggable.js"></script>
                        <script src="dist/js/jquery.alerts.js"></script>
                        <script src="dist/js/jquery.js"></script>
                        <link rel="stylesheet"  href="dist/js/jquery.alerts.css" >

                        <script type="text/javascript">

                            jAlert('<?php echo  $msg; ?>', 'POSNIC' );

                        </script>
                    <?php
                    }
                    else
                        echo "<br><font color=red size=+1 >Problem in Updation !</font>" ;

                }

                ?>
                <div class="content-module-main cf">
                          <?php
                    if(isset($_GET['sid']))
                        $id=$_GET['sid'];

                    $line = $db->queryUniqueObject("SELECT * FROM registration_excise WHERE id=$id");
                    ?>
                    <form name="form1" method="post" id="form1" action="">
                        <table class="form"  border="0" cellspacing="0" cellpadding="">
                            <input name="id" type="hidden" value="<?php echo $_GET['sid']; ?>">
                            <tr>
                                <td><span class="man">*</span>Reg.Date:</td>
                                <td><input name="reg_date" type="date" id="reg_date" class="round default-width-input my_with" style='width:245px;height:18px;' value="<?php echo $line->reg_date ; ?>"/></td>
                                <td><span class="man">*</span>C/Of:</td>
                                <td><input name="care_of" placeholder="ENTER REFERENCE" type="text" id="care_of" maxlength="200"  class="round default-width-input" value="<?php echo $line->care_of ; ?>"/></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td><span class="man">*</span>Name:</td>
                                <td><input name="name"placeholder="ENTER NAME" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $line->name ; ?>"/></td>
                                <td><span class="man">*</span>S/O:</td>
                                <td><input name="f_name"placeholder="ENTER FATHER NAME" type="text" id="f_name" maxlength="200"  class="round default-width-input" value="<?php echo $line->f_name ; ?>"/></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>Contact:</td>
                                <td><input name="contact" placeholder="ENTER CONTACT NO" type="text" id="contact" maxlength="20"   class="round default-width-input"
                                           value="<?php echo $line->contact ; ?>" /></td>
                                <td>Reg.No:</td>
                                <td> <input name="reg_no"placeholder="ENTER REG.NO" type="text" id="reg_no" maxlength="20"  class="round default-width-input" value="<?php echo $line->reg_no ; ?>"/></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>Eng.No:</td>
                                <td><input name="eng_no" placeholder="ENTER ENG.NO" type="text" id="eng_no" maxlength="20"   class="round default-width-input"
                                           value="<?php echo $line->eng_no ; ?>" /></td>
                                <td>Chas.No:</td>
                                <td> <input name="chas_no"placeholder="ENTER CHAS.NO" type="text" id="chas_no" maxlength="20"  class="round default-width-input" value="<?php echo $line->chas_no ; ?>" /></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>File Rec:</td>
                                <td><input name="file_rec"  type="date" id="file_rec" maxlength="20"  style='width:245px;height:18px;'  class="round default-width-input" value="<?php echo $line->file_rec ; ?>"/></td>
                                <td>Status:</td>
                                <td> <input name="status"placeholder="ENTER A / F" type="text" id="status" maxlength="20"  class="round default-width-input" value= "<?php echo $line->status ; ?>"/></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>No.Plate Received:</td>
                                <td><input name="no_plateR"  type="date" id="no_plateR" maxlength="20" style='width:245px;height:18px;'  class="round default-width-input" value="<?php echo $line->no_plateR ; ?>"/></td>
                                <td>No.Plate Delivered:</td>
                                <td> <input name="no_plateD"placeholder="ENTER DELIVERY STATUS" type="text" id="no_plateD" maxlength="20"  class="round default-width-input" value="<?php echo $line->no_plateD ; ?>"/></td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td colspan='4' align='right'>
                                    <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Save">
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