<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
connect_to();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$uname = $_SESSION["username"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$id = mysql_real_escape_string($_GET["id"]);

$sql1 = "SELECT * FROM `calendar` WHERE `ID` = '$id'";
$selectResult1 = mysql_query($sql1);
$row = mysql_fetch_array($selectResult1);

if($row["creator"] != $uname)
{
	die( "You are not the creator of this calendar object" );
}

$day = substr($row["date_time"], 8, 2);
$month = substr($row["date_time"], 5, 2);
$year = substr($row["date_time"], 0, 4);

$sql2 = "DELETE FROM `calendar` WHERE `ID` = '$id'";

echo("Attempting to delete ID " . $id . "<br>");
mysql_query($sql2);

echo( "
<script>
<!--
location=\"calendar.php?month=".$month."&day=".$day."&year=".$year."&hour=00&min=00\";
//-->
</script> 
" );
?>
