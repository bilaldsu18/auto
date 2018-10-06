<?php
include_once("init.php");

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
					minlength: 3,
					maxlength: 20
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
				<form name="form1" method="post" id="form1" action="">
                  <p><strong>Add Customer Details </strong> - Add New ( Control +A)</p>
                  <table class="form"  border="1" cellspacing="0" cellpadding="0">
				  <?php
				if(isset($_POST['id']))

            {
			
			$id=mysql_real_escape_string($_POST['id']);
			$name=trim(mysql_real_escape_string($_POST['name']));
			$f_name=trim(mysql_real_escape_string($_POST['f_name']));
			$dob=trim(mysql_real_escape_string($_POST['dob']));
			$nation=trim(mysql_real_escape_string($_POST['nation']));
			$nic=trim(mysql_real_escape_string($_POST['nic']));
			$m_status=trim(mysql_real_escape_string($_POST['m_status']));
			$contact1=trim(mysql_real_escape_string($_POST['contact1']));
			$ph_no=trim(mysql_real_escape_string($_POST['ph_no']));
			$email=trim(mysql_real_escape_string($_POST['email']));
			$c_res=trim(mysql_real_escape_string($_POST['c_res']));
			$address=trim(mysql_real_escape_string($_POST['address']));
			$per_address=trim(mysql_real_escape_string($_POST['per_address']));
			$work=trim(mysql_real_escape_string($_POST['work']));
			$occ=trim(mysql_real_escape_string($_POST['occ']));
			$org=trim(mysql_real_escape_string($_POST['org']));
			$m_inc=trim(mysql_real_escape_string($_POST['m_inc']));
			$w_dur=trim(mysql_real_escape_string($_POST['w_dur']));
			$post=trim(mysql_real_escape_string($_POST['post']));
			$of_add=trim(mysql_real_escape_string($_POST['of_add']));

			
			
				
			if($db->query("UPDATE customer_details  SET customer_name='$name', customer_father='$f_name', customer_dob='$dob', customer_nationality='$nation', customer_cnic='$nic', customer_status='$m_status', customer_cell='$contact1', customer_phone='$ph_no', customer_mail='$email', customer_residence='$c_res', customer_add='$address', customer_per_add='$per_address', customer_work='$work', customer_occup='$occ', customer_org='$org', customer_inc='$m_inc', customer_dura='$w_dur', customer_post='$post', customer_office_add='$of_add' where id=$id"))
			{
                        $data=" $name  Customer Details Updated" ;
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
			else
			echo "<br><font color=red size=+1 >Problem in Updation !</font>" ;
			
			
			}
				
				?>	
				<?php 
				if(isset($_GET['sid']))
				$id=$_GET['sid'];
			
				$line = $db->queryUniqueObject("SELECT * FROM customer_details WHERE id=$id");
				?>
					<form name="form1" method="post" id="form1" action="">
                   <input name="id" type="hidden" value="<?php echo $_GET['sid']; ?>">  
                    <tr>
						<td colspan='4' align='center' style='background-color:#153450;color:white;font-weight:bolder;padding:5px;'>PERSONAL INFORMATION</td>
					</tr>					
					<tr>
						<td colspan='4' ></td>
					</tr>
                    <tr>
                      <td><span class="man">*</span>Name:</td>
                      <td><input name="name" placeholder="ENTER CUSTOMER NAME" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $line->customer_name; ?>" /></td>                     

					  <td><span class="man">*</span>S/O:</td>
                      <td><input name="f_name" placeholder="ENTER FATHER NAME" type="text" id="name" maxlength="200"  class="round default-width-input" value="<?php echo $line->customer_father; ?>" /></td>
                
                    </tr>
					<tr> 
						<td>DOB</td>
						<td><input name='dob' type="date" class="round default-width-input" value="<?php echo $line->customer_dob; ?>" maxlength="200" /></td>
						
						<td>Nationality</td>
						<td><input name='nation' type="text" placeholder='ENTER YOUR NATIONALITY' class="round default-width-input" value="<?php echo $line->customer_nationality; ?>"/></td>
					</tr>
					
					<tr>
						<td>N.I.C #</td>
						<td><input name='nic' type="text" placeholder='ENTER YOUR C.NIC' class="round default-width-input" value="<?php echo $line->customer_cnic; ?>"/></td>
						
						<td>Marital Status</td>
						<td>
							<select name="m_status" id="" class="round default-width-input" > 
								<option><?php echo $line->customer_status; ?></option>
								<option value="married">Married</option>
								<option value="un_married">UN-Married</option>
							</select>
						</td>
					</tr>
					
					<tr> 
						<td>Cell No</td>
						<td><input name="contact1" placeholder="CUSTOMER CELL NO" type="text" id="buyingrate" maxlength="20"   class="round default-width-input" 
					  value="<?php echo $line->customer_cell; ?>" /></td>
						
						<td>Phone No</td>
						<td><input name="ph_no" placeholder="CUSTOMER PHONE NO" type="text" id="buyingrate" maxlength="20"   class="round default-width-input" 
					  value="<?php echo $line->customer_phone; ?>" /></td>
					</tr>					
					
					<tr> 
						<td>Email</td>
						<td><input name="email" placeholder="CUSTOMER E.MAIL" type="text" id="buyingrate" maxlength="20"   class="round default-width-input" 
					  value="<?php echo $line->customer_mail; ?>" /></td>
						
						<td>Residence</td>
						<td>
							<select name="c_res" id="" class="round default-width-input" >
								<option><?php echo $line->customer_residence; ?></option>
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
						value="<?php echo $contact2; ?>"  cols='32' rows='4'><?php echo $line->customer_add; ?></textarea></td>
						<td>Permanent Address:</td>
						<td><textarea name="per_address" placeholder="ENTER PERMANENT ADDRESS" type="text" id="sellingrate"  class="round default-width-textarea" 
						value="<?php echo $contact2; ?>"  cols='32' rows='4'><?php echo $line->customer_per_add; ?></textarea></td>
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
							<select name="work" id="" class="round default-width-input">
								<option><?php echo $line->customer_work; ?></option>
								<option value="salaried">Salaried</option>
								<option value="self employed">Self Employed</option>
							</select>
						</td>
						
						<td>Occupation</td>
						<td><input name='occ' type="text" placeholder="ENTER OCCUPATION / PROFESSION" class="round default-width-input" value="<?php echo $line->customer_occup; ?>"/></td>
					</tr>
					<tr> 
						<td>Organization</td>
						<td><input name='org' type="text" placeholder="ENTER ORGANIZATION NAME" class="round default-width-input" value="<?php echo $line->customer_org; ?>"/></td>
						
						<td>Monthly Income</td>
						<td><input name='m_inc' type="text" placeholder="ENTER MONTHLY INCOME" class="round default-width-input" value="<?php echo $line->customer_inc; ?>"/></td>
					</tr>
					<tr> 
						<td>Duration</td>
						<td><input name='w_dur' type="text" placeholder="ENTER WORK DURATION" class="round default-width-input" value="<?php echo $line->customer_dura; ?>"/></td>
						
						<td>Position</td>
						<td><input name='post' type="text" placeholder="ENTER POSITION / TITLE" class="round default-width-input" value="<?php echo $line->customer_post; ?>"/></td>
					</tr>					
					<tr>
						<td>Office Address:</td>
						<td><textarea name="of_add" placeholder="ENTER Office ADDRESS"type="text" id="sellingrate"  class="round default-width-textarea" 
						value="<?php echo $contact2; ?>"  cols='32' rows='4'><?php echo $line->customer_office_add; ?></textarea></td>
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