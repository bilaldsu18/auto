<?php
include_once("init.php");

$line = $db->queryUniqueObject("SELECT * FROM customer_details  WHERE customer_name='".$_POST['stock_name1']."'");
$address=$line->customer_add;
$contact1=$line->customer_cell;

if($line!=NULL)
{

$arr = array ("address1"=>"$address","contact1"=>"$contact1");
echo json_encode($arr);

}
else
{
$arr1 = array ("no"=>"no");
echo json_encode($arr1);

}
?>