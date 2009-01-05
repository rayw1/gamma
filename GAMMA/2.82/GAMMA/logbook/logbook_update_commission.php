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

include(getcwd().'/../includes/common.inc');
style("white");

connect_to();

$date1 = $_POST["date1"];
$date2 = $_POST["date2"];
$yPass = $_POST["yPass"];
$mPass = $_POST["mPass"];

$sql1 = "SELECT * FROM `logbook` WHERE `Date` >= '$date1' AND `Date` <= '$date2' AND `office` = '$dbase' AND `group` = '$group' ORDER BY `Date`";

$itemList1 = mysql_query($sql1);

if($itemList1 == 0)
{
	log_error("Logbook Select Failure: $sql1", "logbook_update_commission.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain logbook");
}

$i = 0;

while($row = mysql_fetch_array($itemList1))
{
	$i++;
	$id = $row["Number"];
	
	$varName = "commission".$id;
	
	if($_POST[$varName])
	{
		$sql2 = "UPDATE `logbook` SET `Commission_Paid` = 'yes' WHERE `Number` = '$id' AND `office` = '$dbase' AND `group` = '$group'";
		$updateResult2 = mysql_query($sql2);
	}
	else 
	{
		$sql2 = "UPDATE `logbook` SET `Commission_Paid` = 'no' WHERE `Number` = '$id' AND `office` = '$dbase' AND `group` = '$group'";
		$updateResult2 = mysql_query($sql2);
	}
}

echo( "
<script>
location=\"logbook_search.php?yPass=".$yPass."&mPass=".$mPass."\";
</script> 
");
?>
