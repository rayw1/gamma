<?php
//GAMMA V2.7 CERTIFIED
$id = $_GET["eid"];

include(getcwd().'/../includes/common.inc');
connect_to();

$sql = "DELETE FROM `customer_general` WHERE `ID` = '$id'";

$insertresult = mysql_query($sql);

if($insertresult == 1)
{
	echo( "Address Removed from Database" );
}
else
{
	log_error("Customerlist Delete Failure: $sql", "customerlist_delete.php", $_SESSION["username"], $_SESSION["group"]);
	die( "Failed to remove Address" );
}
?>
