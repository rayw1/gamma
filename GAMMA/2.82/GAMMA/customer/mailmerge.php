<?php
//GAMMA V2.7 CERTIFIED
session_start();
$office = $_SESSION["office"];
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
$now = date("Ymd");
include(getcwd().'/../includes/common.inc');
if($valid != 1)
{
	die("INVALID SESSION");
}
connect_to();

header("Content-type: application/txt");
header("Content-Disposition: attachment; filename=mailmerge.csv");

$result1 = mysql_query("SELECT * FROM `customer_general` WHERE `office` = '$office' AND `group` = '$group'");

if($result1 == 0)
{
	die("No data found");
}

echo( "FirstName, LastName, Address, City, State, Zip\n");

while($row = mysql_fetch_array($result1))
{
	if($row["First_Name"] != "" && $row["Last_Name"] != "" && $row["Address"] != "" && $row["City"] != "" && $row["State"] != "" && $row["Zip"] != "")
	{
		echo( $row["First_Name"].",".$row["Last_Name"].",".$row["Address"].",".$row["City"].",".$row["State"].",".$row["Zip"]."\n");
	}
}
?>
