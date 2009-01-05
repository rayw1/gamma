<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die( "Admin too low" );
}

$yearIn = $_POST["year"];
$officeIn = $_POST["office"];

connect_to();

for($i = 1; $i <= 12; $i++)
{
	$varname = "paidToDate_".$i;
	
	$tempValue = $_POST[$varname];
	
	$sql1 = "UPDATE `franchise_bills` SET `paidToDate` = '$tempValue' WHERE `month` = '$i' AND `year` = '$yearIn' AND`office` = '$officeIn'";
	$updateResult1 = mysql_query($sql1);
}


echo( "
<script>
location=\"franchisebill.php\";
</script> 
");
?>
