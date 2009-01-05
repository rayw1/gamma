<?php
//GAMMA V2.7 CERTIFIED
session_start();
if($_SESSION["validsession"] != 1)
{
	die( "Invalid Session" );
}
$admin = $_SESSION["admin"];
$uname = $_SESSION["username"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];

include(getcwd().'/../includes/common.inc');
style("white");

//Define 2 timestamps, one 6mo ago and one 5mo ago
$timestamp1 = date("Ymd",mktime(0,0,0,date("m"),date("d")-182,date("Y")));
$timestamp2 = date("Ymd",mktime(0,0,0,date("m"),date("d")-151,date("Y")));

connect_to();
$sql1 = "SELECT * FROM `logbook` WHERE `Date` >= '$timestamp1' AND `Date` <= '$timestamp2' AND `office` = '$dbase' AND `group` = '$group'";
$selectResult1 = mysql_query($sql1);

echo( "<h1>Customer Renewals</h1>" );
echo( "This data is for the next 31 days" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"75%\">" );
echo( "<tr><td><b>First</b></td><td><b>Last</b></td><td><b>Date Written</b></td></tr>" );

$color = "#CCFFCCC";
while($row = mysql_fetch_array($selectResult1))
{
	$date = $row["Date"];
	$month = substr($date, 5, 2);
	$day = substr($date, 8, 2);
	$year = substr($date, 0, 4);

	$date = $month."-".$day."-".$year;

	if($color == "white")
	{
		$color = "#CCFFCC";
	}
	else
	{
		$color = "white";
	}

	echo( "<tr style=\"background:" );
	echo( $color );
	echo( ";\"><td>".$row["FirstName"]."</td><td>".$row["LastName"]."</td><td>".$date."</td></tr>" );

}

echo( "</table>" );

?>
