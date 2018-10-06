<?php
include_once("init.php");
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>WAC - Files Records</title>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- jQuery & JS files -->
    <?php include_once("tpl/common_js.php"); ?>
    <script src="js/script.js"></script>
    <script  src="dist/js/jquery.ui.draggable.js"></script>
    <script src="dist/js/jquery.alerts.js"></script>
    <link rel="stylesheet"  href="dist/js/jquery.alerts.css" >

    <script LANGUAGE="JavaScript">
        <!--
        // Nannette Thacker http://www.shiningstar.net
        console.log();
        function confirmSubmit(id,table,dreturn)
        { 	     jConfirm('You Want Delete Customer', 'Confirmation Dialog', function (r) {
            if(r){
                console.log();
                $.ajax({
                    url: "delete.php",
                    data: { id: id, table:table,return:dreturn},
                    success: function(data) {
                        window.location = "view_files.php";
                        jAlert('Custmer Is Deleted', 'POSNIC');
                    }
                });
            }
            return r;
        });
        }
        function confirmDeleteSubmit()
        {
            var flag=0;
            var field=document.forms.deletefiles;
            for (i = 0; i < field.length; i++){
                if(field[i].checked ==true){
                    flag=flag+1;
                }
            }
            if (flag <1) {
                jAlert('You must check one and only one checkbox', 'POSNIC');
                return false;
            }else{
                jConfirm('You Want Delete Customer', 'Confirmation Dialog', function (r) {
                    if(r){

                        document.deletefiles.submit();}
                    else {
                        return false ;
                    }
                });
            }
        }
        function confirmLimitSubmit()
        {
            if(document.getElementById('search_limit').value!=""){
                document.limit_go.submit();
            }else{
                return false;
            }
        }
        function checkAll()
        {
            var field=document.forms.deletefiles;
            for (i = 0; i < field.length; i++)
                field[i].checked = true ;
        }
        function uncheckAll()
        {
            var field=document.forms.deletefiles;
            for (i = 0; i < field.length; i++)
                field[i].checked = false ;
        }
        // -->
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
<div class="page-full-width cf" >
<div class="side-menu fl" >

    <h3>File Records</h3>
    <ul>
        <li><a href="add_files.php">Add File Records</a></li>
        <li><a href="view_files.php">View File Records</a></li>
    </ul>

</div> <!-- end side-menu -->

<div class="side-content fr" style="width:100%;">

<div>

<div class="content-module-heading cf" >

    <h3 class="fl">File Records</h3>
    <span class="fr expand-collapse-text">Click to collapse</span>
    <span class="fr expand-collapse-text initial-expand">Click to expand</span>

</div> <!-- end content-module-heading -->

<div class="content-module-main cf">


<table>
    <form action="" method="post" name="search" >
        <input name="searchtxt" type="text" class="round my_text_box" placeholder="Search" >
        &nbsp;&nbsp;<input name="Search" type="submit" class="my_button round blue   text-upper" value="Search">
    </form>
    <form action="" method="get" name="limit_go">
        Page per Record<input name="limit" type="text" class="round my_text_box" id="search_limit" style="margin-left:5px;" value="<?php if(isset($_GET['limit'])) echo $_GET['limit']; else echo "10"; ?>" size="3" maxlength="3">
        <input name="go"  type="button" value="Go" class=" round blue my_button  text-upper" onclick="return confirmLimitSubmit()">
    </form>
</table>
<table border='1'>
<?php

$SQL = "SELECT * FROM  file_records";
if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
    $SQL = "SELECT * FROM  customer_details WHERE registration_excise  LIKE '%".$_POST['searchtxt']."%' OR customer_address LIKE '%".$_POST['searchtxt']."%' OR customer_contact1 LIKE '%".$_POST['searchtxt']."%' OR customer_contact1 LIKE '%".$_POST['searchtxt']."%'";
}

$tbl_name="customer_details";		//your table name

// How many adjacent pages should be shown on each side?

$adjacents = 3;

/*

   First get total number of rows in data table.

   If you have a WHERE clause in your query, make sure you mirror it here.

*/

$query = "SELECT COUNT(*) as num FROM $tbl_name";
if(isset($_POST['Search']) AND trim($_POST['searchtxt'])!="")
{
    $query = "SELECT COUNT(*) as num FROM  file_records WHERE name  LIKE '%".$_POST['searchtxt']."%' OR f_name LIKE '%".$_POST['searchtxt']."%' OR chas_no LIKE '%".$_POST['searchtxt']."%'";
}
$total_pages = mysql_fetch_array(mysql_query($query));
$total_pages = $total_pages[num];

/* Setup vars for query. */

$targetpage = "view_customers.php"; 	//your file name  (the name of this file)

$limit = 10; 								//how many items to show per page
if(isset($_GET['limit']) && is_numeric($_GET['limit'])){
    $limit=$_GET['limit'];
    $_GET['limit']=10;
}
$page = $_GET['page'];
if($page)
    $start = ($page - 1) * $limit; 			//first item to display on this page
else
    $start = 0;								//if no page var is given, set start to 0
/* Get data. */

/* Setup page vars for display. */
if ($page == 0) $page = 1;					//if no page var is given, default to 1.
$prev = $page - 1;							//previous page is page - 1
$next = $page + 1;							//next page is page + 1
$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;						//last page minus 1
/*

    Now we apply our rules and draw the pagination object.

    We're actually saving the code to a variable in case we want to draw it more than once.

*/
$pagination = "";
if($lastpage > 1)
{
    $pagination .= "<div >";
    //previous button
    if ($page > 1)
        $pagination.= "<a href=\"view_files.php?page=$prev&limit=$limit\" class=my_pagination >Previous</a>";
    else
        $pagination.= "<span class=my_pagination>Previous</span>";
    //pages

    if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up

    {

        for ($counter = 1; $counter <= $lastpage; $counter++)

        {

            if ($counter == $page)

                $pagination.= "<span class=my_pagination>$counter</span>";

            else

                $pagination.= "<a href=\"view_files.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";

        }

    }

    elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some

    {

        //close to beginning; only hide later pages

        if($page < 1 + ($adjacents * 2))

        {

            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

            {

                if ($counter == $page)

                    $pagination.= "<span class=my_pagination>$counter</span>";

                else

                    $pagination.= "<a href=\"view_files.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";

            }

            $pagination.= "...";

            $pagination.= "<a href=\"view_files.php?page=$lpm1&limit=$limit\" class=my_pagination>$lpm1</a>";

            $pagination.= "<a href=\"view_files.php?page=$lastpage&limit=$limit\" class=my_pagination>$lastpage</a>";

        }
        //in middle; hide some front and some back
        elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
        {
            $pagination.= "<a href=\"view_files.php?page=1&limit=$limit\" class=my_pagination>1</a>";
            $pagination.= "<a href=\"view_files.php?page=2&limit=$limit\" class=my_pagination>2</a>";
            $pagination.= "...";
            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span  class=my_pagination>$counter</span>";
                else
                    $pagination.= "<a href=\"view_files.php?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
            }
            $pagination.= "...";
            $pagination.= "<a href=\"view_files.php?page=$lpm1&limit=$limit\" class=my_pagination>$lpm1</a>";
            $pagination.= "<a href=\"view_files.php?page=$lastpage&limit=$limit\" class=my_pagination>$lastpage</a>";
        }
        //close to end; only hide early pages
        else
        {
            $pagination.= "<a href=\"$view_files.php?page=1&limit=$limit\" class=my_pagination>1</a>";
            $pagination.= "<a href=\"$view_files.php?page=2&limit=$limit\" class=my_pagination>2</a>";
            $pagination.= "...";
            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<span class=my_pagination >$counter</span>";
                else
                    $pagination.= "<a href=\"$targetpage?page=$counter&limit=$limit\" class=my_pagination>$counter</a>";
            }
        }
    }
    //next button

    if ($page < $counter - 1)

        $pagination.= "<a href=\"view_files.php?page=$next&limit=$limit\" class=my_pagination>Next</a>";
    else
        $pagination.= "<span class= my_pagination >Next</span>";
    $pagination.= "</div>\n";
}

?>
<tr style="text-align: left">
    <th style='width:15%;'>Name</th>
    <th style='width:15%;'>S/O</th>
    <th style='width:11%;'>Contact</th>
    <th style='width:10%;'>Chas.No</th>
    <th style='width:10%;'>Eng.No</th>
    <th style='width:9%;'>Reg.No</th>
    <th style='width:10%;'>File.Delivered</th>
    <th style='width:10%;'>Order By</th>
    <th style='width:10%;'>Options</th>
</tr>
<?php
$i=1; $no=$page-1; $no=$no*$limit;
$sql = "SELECT * FROM file_records LIMIT $start, $limit ";
if(isset($_POST['Search'])){
    $searchtxt = $_POST['searchtxt'];
    $sql= "SELECT * FROM  file_records WHERE name  LIKE '%$searchtxt%' OR f_name LIKE '%$searchtxt%' OR eng_no = '$searchtxt' OR contact = '$searchtxt'  OR reg_no = '$searchtxt' OR chas_no LIKE '%$searchtxt%'  LIMIT $start, $limit";
}
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{
    ?>
    <tr>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['f_name']; ?></td>
        <td><?php echo $row['contact']; ?></td>
        <td><?php echo $row['chas_no']; ?></td>
        <td><?php echo $row['eng_no']; ?></td>
        <td><?php echo $row['reg_no']; ?></td>
        <td><?php echo $row['file_del']; ?></td>
        <td><?php echo $row['order']; ?></td>
        <td>
            <a href="update_files.php?sid=<?php echo $row['id'];?>&table=file_records&return=view_files.php"	class="table-actions-button ic-table-edit">
            </a> &nbsp;
            <a  href="javascript:confirmSubmit(<?php echo $row['id'];?>, 'file_records','view_files.php')" class="table-actions-button ic-table-delete"></a>
        </td>

    </tr>
    <?php $i++; } ?>
<tr>
    <td align="center" colspan='13'><div style="margin-left:20px;"><?php echo $pagination; ?></div></td>
</tr>
</table>
</form>
</div>
</div>
<div id="footer">
  
</div> <!-- end footer -->
</body>
</html>