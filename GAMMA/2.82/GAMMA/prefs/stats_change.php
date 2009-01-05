<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
if($valid != 1)
{
	die( "INVALID SESSION" );
}
if($admin < 1)
{
	die( "ADMIN TOO LOW" );
}

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$dname = $_POST["display"];
$color = $_POST["color"];
$addressIn = $_POST["address"];
$phoneIn = $_POST["phone"];

$addressIn = nl2br($addressIn);

$sql = "UPDATE `statistics` SET `DisplayName` = '$dname', `Color` = '$color', `Phone` = '$phoneIn', `Address` = '$addressIn' WHERE `Database` = '$office'";
$result = mysql_query($sql);

if($result == 0)
{
	log_error("Could not obtain update statistics", "stats_change.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not change your preferences");
}
else
{
	echo( "<script>
         <!--
         location=\"prefs.php\";
         //-->
         </script> " );
}
?>
