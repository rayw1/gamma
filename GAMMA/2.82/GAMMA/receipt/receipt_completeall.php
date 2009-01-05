<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

if($admin < 1)
{
	die("NOT AN ADMIN");
}

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$sql = "SELECT * FROM `receipt` WHERE `Completed` = 'No' AND `office` = '$dbase' AND `group` = '$group'";

$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Receipt Select Failure: $sql", "receipt_completeall.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain receipts");
}


while($row = mysql_fetch_row($itemList))
{
	$id = $row[0];
	$sql2 = "UPDATE `receipt` SET `Completed` = 'Yes' WHERE `ReceiptID` = '$id' AND `office` = '$dbase' AND `group` = '$group'";

	$insertresult2 = mysql_query($sql2);
}
?>
<script>
<!--
location="receipt_search.php";
//-->
</script> 
