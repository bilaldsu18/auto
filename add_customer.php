<?php
include_once("init.php");

//Gump is libarary for Validatoin

if(isset($_POST['name'])){
    $_POST = $gump->sanitize($_POST);
    $gump->validation_rules(array(
        'name'    	  => 'required|max_len,100|min_len,3',
        'f_name'      => 'required|max_len,100|min_len,3',
        'dob'    	  => 'max_len,100',
        'nation'      => 'max_len,100',
        'nic'    	  => 'max_len,100',
        'm_status'    => 'max_len,100',
        'contact1'    => 'max_len,20',
        'ph_no'    	  => 'max_len,100',
        'email'    	  => 'max_len,100',
        'c_res'    	  => 'max_len,100',
        'address'     => 'max_len,200',
        'per_address' => 'max_len,200',
        'work'    	  => 'max_len,100',
        'occ'    	  => 'max_len,100',
        'org'    	  => 'max_len,100',
        'm_inc'    	  => 'max_len,100',
        'w_dur'    	  => 'max_len,100',
        'post'    	  => 'max_len,100',
        'of_add'      => 'max_len,100'



    ));

    $gump->filter_rules(array(
        'name'    	  => 'trim|sanitize_string|mysql_escape',
        'f_name'    	  => 'trim|sanitize_string|mysql_escape',
        'dob'    	  => 'trim|sanitize_string|mysql_escape',
        'nation'    	  => 'trim|sanitize_string|mysql_escape',
        'nic'    	  => 'trim|sanitize_string|mysql_escape',
        'm_status'    	  => 'trim|sanitize_string|mysql_escape',
        'contact1'    => 'trim|sanitize_string|mysql_escape',
        'ph_no'    	  => 'trim|sanitize_string|mysql_escape',
        'email'    	  => 'trim|sanitize_string|mysql_escape',
        'c_res'    	  => 'trim|sanitize_string|mysql_escape',
        'address'     => 'trim|sanitize_string|mysql_escape',
        'per_address'    	  => 'trim|sanitize_string|mysql_escape',
        'work'    	  => 'trim|sanitize_string|mysql_escape',
        'occ'    	  => 'trim|sanitize_string|mysql_escape',
        'org'    	  => 'trim|sanitize_string|mysql_escape',
        'm_inc'    	  => 'trim|sanitize_string|mysql_escape',
        'w_dur'    	  => 'trim|sanitize_string|mysql_escape',
        'post'    	  => 'trim|sanitize_string|mysql_escape',
        'of_add'      => 'trim|sanitize_string|mysql_escape'

    ));

    $validated_data = $gump->run($_POST);
    $name    	  = "";
    $f_name    	  = "";
    $dob    	  = "";
    $nation    	  = "";
    $nic    	  = "";
    $m_status     = "";
    $contact1     = "";
    $ph_no    	  = "";
    $email    	  = "";
    $c_res    	  = "";
    $address      = "";
    $per_address  = "";
    $work    	  = "";
    $occ   	 	  = "";
    $org    	  = "";
    $m_inc    	  = "";
    $w_dur    	  = "";
    $post    	  = "";
    $of_add    	  = "";

    if($validated_data === false) {
        echo $gump->get_readable_errors(true);
    } else {


        $name		  = mysql_real_escape_string($_POST['name']);
        $f_name    	  = mysql_real_escape_string($_POST['f_name']);
        $dob    	  = mysql_real_escape_string($_POST['dob']);
        $nation    	  = mysql_real_escape_string($_POST['nation']);
        $nic    	  = mysql_real_escape_string($_POST['nic']);
        $m_status     = mysql_real_escape_string($_POST['m_status']);
        $contact1	  = mysql_real_escape_string($_POST['contact1']);
        $ph_no    	  = mysql_real_escape_string($_POST['ph_no']);
        $email    	  = mysql_real_escape_string($_POST['email']);
        $c_res    	  = mysql_real_escape_string($_POST['c_res']);
        $address	  = mysql_real_escape_string($_POST['address']);
        $per_address  = mysql_real_escape_string($_POST['per_address']);
        $work    	  = mysql_real_escape_string($_POST['work']);
        $occ   	 	  = mysql_real_escape_string($_POST['occ']);
        $org    	  = mysql_real_escape_string($_POST['org']);
        $m_inc    	  = mysql_real_escape_string($_POST['m_inc']);
        $w_dur    	  = mysql_real_escape_string($_POST['w_dur']);
        $post    	  = mysql_real_escape_string($_POST['post']);
        $of_add    	  = mysql_real_escape_string($_POST['post']);

        $photo_name=$_FILES['photo']['name'];
        $tmp_name=$_FILES['photo']['tmp_name'];
        if(empty($photo_name)){
            $photo_name='dummy.png';
        }
        $ext = pathinfo($photo_name, PATHINFO_EXTENSION);

        move_uploaded_file($tmp_name,"picture/$name.$ext");

        $count = $db->countOf("customer_details", "customer_name='$name'");
        if($count==1)
        {

            $data='Dublicat Entry. Please Verify';
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

            if($db->query("insert into customer_details values(NULL,'$name','$f_name','$dob','$nation ','$nic ','$m_status','$contact1','$ph_no','$email','$c_res','$address','$per_address','$work','$occ','$org','$m_inc','$w_dur','$post','$of_add',0)"))
            {
                $msg=" $name Customer Details Added " ;
                header("Location: add_customer.php?msg=$msg");
                exit();
            }
            else
                echo "<div class='error-box round'>Problem in Adding !</div>" ;

        }
    }
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WAC - Add Customer</title>

    <!-- Stylesheets -->
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">

    <!-- Optimize for mobile devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">

        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            background-color: #FFFFFF;
        }

        *{
            padding: 0px;
            margin: 0px;
        }
        #vertmenu {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 100%;
            width: 160px;
            padding: 0px;
            margin: 0px;
        }

        #vertmenu h1 {
            display: block;
            background-color:#FF9900;
            font-size: 90%;
            padding: 3px 0 5px 3px;
            border: 1px solid #000000;
            color: #333333;
            margin: 0px;
            width:159px;
        }

        #vertmenu ul {
            list-style: none;
            margin: 0px;
            padding: 0px;
            border: none;
        }
        #vertmenu ul li {
            margin: 0px;
            padding: 0px;
        }
        #vertmenu ul li a {
            font-size: 80%;
            display: block;
            border-bottom: 1px dashed #C39C4E;
            padding: 5px 0px 2px 4px;
            text-decoration: none;
            color: #666666;
            width:160px;
        }

        #vertmenu ul li a:hover, #vertmenu ul li a:focus {
            color: #000000;
            background-color: #eeeeee;
        }
        .style1 {color: #000000}
        div.pagination {

            padding: 3px;

            margin: 3px;

        }



        div.pagination a {

            padding: 2px 5px 2px 5px;

            margin: 2px;

            border: 1px solid #AAAADD;



            text-decoration: none; /* no underline */

            color: #000099;

        }

        div.pagination a:hover, div.pagination a:active {

            border: 1px solid #000099;



            color: #000;

        }

        div.pagination span.current {

            padding: 2px 5px 2px 5px;

            margin: 2px;

            border: 1px solid #000099;



            font-weight: bold;

            background-color: #000099;

            color: #FFF;

        }

        div.pagination span.disabled {

            padding: 2px 5px 2px 5px;

            margin: 2px;

            border: 1px solid #EEE;



            color: #DDD;

        }



    </style>
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
                    address: {
                        minlength: 3,
                        maxlength: 500
                    },
                    contact1: {
                        minlength: 3,
                        maxlength: 20
                    },
                    contact2: {
                        minlength: 3
                    }
                },
                messages: {
                    name: {
                        required: "Please enter a Customer Name",
                        minlength: "Customer must consist of at least 3 characters"
                    },
                    address: {
                        minlength: "Customer Address must be at least 3 characters long",
                        maxlength: "Customer Address must be at least 3 characters long"
                    }
                }
            });

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

            <h3>Customers Management</h3>
            <ul>
                <li><a href="add_customer.php">Add Customer</a></li>
                <li><a href="view_customers.php">View Customers</a></li>
            </ul>

        </div> <!-- end side-menu -->

        <div class="side-content fr">

            <div class="content-module">

                <div class="content-module-heading cf">

                    <h3 class="fl">Add Customer</h3>
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

                    <form name="form1" method="post" id="form1" action="" enctype="multipart/form-data">

                        <p><strong>Add Customer Details </strong> - Add New ( Control +A)</p>
                        <table class="form"  border="1" cellspacing="0" cellpadding="0">
                            <tr>
                                <td colspan='4' align='center' style='background-color:#153450;color:white;font-weight:bolder;padding:5px;'>PERSONAL INFORMATION</td>
                            </tr>
                            <tr>
                                <td colspan='4' ></td>
                            </tr>
                            <tr>
                                <td><span class="man">*</span>Name:</td>
                                <td><input name="name" placeholder="ENTER CUSTOMER NAME" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $name; ?>" /></td>

                                <td><span class="man">*</span>S/O:</td>
                                <td><input name="f_name" placeholder="ENTER FATHER NAME" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $name; ?>" /></td>

                            </tr>
                            <tr>
                                <td>DOB</td>
                                <td><input name='dob' type="date" class="round default-width-input my_with" maxlength="200" style='width:250px'/></td>

                                <td>Nationality</td>
                                <td><input name='nation' type="text" placeholder='ENTER YOUR NATIONALITY' class="round default-width-input"/></td>
                            </tr>

                            <tr>
                                <td>N.I.C #</td>
                                <td><input name='nic' type="text" placeholder='ENTER YOUR C.NIC' class="round default-width-input"/></td>

                                <td>Marital Status</td>
                                <td>
                                    <select name="m_status" id="" class="round default-width-input my_with" style='width:250px'>
                                        <option value="null">--Select--</option>
                                        <option value="married">Married</option>
                                        <option value="un_married">UN-Married</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Cell No</td>
                                <td><input name="contact1" placeholder="CUSTOMER CELL NO" type="text" id="buyingrate" maxlength="20"   class="round default-width-input"
                                           value="<?php echo $contact1; ?>" /></td>

                                <td>Phone No</td>
                                <td><input name="ph_no" placeholder="CUSTOMER PHONE NO" type="text" id="buyingrate" maxlength="20"   class="round default-width-input"
                                           value="<?php echo $contact1; ?>" /></td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td><input name="email" placeholder="CUSTOMER E.MAIL" type="text" id="buyingrate" maxlength="20"   class="round default-width-input"
                                           value="<?php echo $contact1; ?>" /></td>

                                <td>Residence</td>
                                <td>
                                    <select name="c_res" id="" class="round default-width-input my_with" style='width:250px'>
                                        <option value="null">--Select--</option>
                                        <option value="own">Own</option>
                                        <option value="parents">Parents</option>
                                        <option value="rent">Rent</option>
                                        <option value="other">Other</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Present Address:</td>
                                <td><textarea name="address" placeholder="ENTER PRESENT ADDRESS"type="text" id="sellingrate"  class="round default-width-textarea"
                                              value="<?php echo $contact2; ?>"  cols='32' rows='4'></textarea></td>
                                <td>Permanent Address:</td>
                                <td><textarea name="per_address" placeholder="ENTER PERMANENT ADDRESS" type="text" id="sellingrate"  class="round default-width-textarea"
                                              value="<?php echo $contact2; ?>"  cols='32' rows='4'></textarea></td>
                            </tr>
                            <tr>
                                <td colspan='4'>
                                    <input type="file" name='photo' value='Upload Picture'/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan='4' align='center' style='background-color:#153450;color:white;font-weight:bolder;padding:5px;'>WORK DETAILS</td>
                            </tr>
                            <tr>
                                <td colspan='4' ></td>
                            </tr>
                            <tr>
                                <td>Work</td>
                                <td>
                                    <select name="work" id="" class="round default-width-input my_with" style='width:250px'>
                                        <option value="null">--Select--</option>
                                        <option value="salaried">Salaried</option>
                                        <option value="self employed">Self Employed</option>
                                    </select>
                                </td>

                                <td>Occupation</td>
                                <td><input name='occ' type="text" placeholder="ENTER OCCUPATION / PROFESSION" class="round default-width-input"/></td>
                            </tr>
                            <tr>
                                <td>Organization</td>
                                <td><input name='org' type="text" placeholder="ENTER ORGANIZATION NAME" class="round default-width-input"/></td>

                                <td>Monthly Income</td>
                                <td><input name='m_inc' type="text" placeholder="ENTER MONTHLY INCOME" class="round default-width-input"/></td>
                            </tr>
                            <tr>
                                <td>Duration</td>
                                <td><input name='w_dur' type="text" placeholder="ENTER WORK DURATION" class="round default-width-input"/></td>

                                <td>Position</td>
                                <td><input name='post' type="text" placeholder="ENTER POSITION / TITLE" class="round default-width-input"/></td>
                            </tr>
                            <tr>
                                <td>Office Address:</td>
                                <td><textarea name="of_add" placeholder="ENTER Office ADDRESS"type="text" id="sellingrate"  class="round default-width-textarea"
                                              value="<?php echo $contact2; ?>"  cols='32' rows='4'></textarea></td>
                                <td colspan='2'>
                                    <input  class="button round blue image-right ic-add text-upper" type="submit" name="Submit" value="Add">
                                    (Control + S)
                                    <input class="button round red text-upper" type="reset" name="Reset" value="Reset">
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