<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$uname = $_SESSION["username"];
if($valid != 1)
{
	die("INVALID SESSION");
}
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$id = mysql_real_escape_string($_GET["id"]);

$query2 = mysql_query("SELECT * FROM `calendar` WHERE `ID` = '$id'");
$row2 = mysql_fetch_array($query2);

$day = substr($row2["date_time"], 8, 2);
$month = substr($row2["date_time"], 5, 2);
$year = substr($row2["date_time"], 0, 4);
$hour = substr($row2["date_time"], 11, 2);

if($hour > 12)
{
	$hour = $hour - 12;
	$meridian = "PM";
}
elseif($hour == 12)
{
	$meridian = "PM";
}
elseif($hour == 0)
{
	$hour = 12;
	$meridian = "AM";
}
else
{
	$meridian = "AM";
}

$minute = substr($row2["date_time"], 14, 2);

echo( "<h2>".$row2["subject"]."</h2>" );
echo( $month."/".$day."/".$year." ".$hour.":".$minute." ".$meridian."<br>" );
echo( "<p>".$row2["message"]."</p>" );

?>

