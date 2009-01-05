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

connect_to();
$sql1 = "SELECT * FROM `customer_general` WHERE `Office` = '$dbase' ORDER BY `DOB` DESC";
$selectResult1 = mysql_query($sql1);

echo( "<h1>Customer Birthdays</h1>" );
echo( "This data is for the next 31 days" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"75%\">" );
echo( "<tr><td><b>First</b></td><td><b>Last</b></td><td><b>DOB</b></td></tr>" );

$color = "#CCFFCCC";
while($row = mysql_fetch_array($selectResult1))
{
	$dob = $row["DOB"];
	$month = substr($dob, 5, 2);
	$day = substr($dob, 8, 2);
	$year = substr($dob, 0, 4);

	$dob = $month."-".$day."-".$year;

	//Define 3 timestamps.  Today, 31 days from now, and customers next birthday
	$timestamp1 = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
	$timestamp2 = date("Ymd",mktime(0,0,0,date("m"),date("d")+31,date("Y")));
	$timestamp3 = date("Ymd",mktime(0,0,0,$month, $day, date("Y")));

	//If timestamp3 is between 1&2, display a row
	if($timestamp3 > $timestamp1 && $timestamp3 < $timestamp2)
	{
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
		echo( ";\"><td>".$row["First_Name"]."</td><td>".$row["Last_Name"]."</td><td>".$dob."</td></tr>" );
	}
}

echo( "</table>" );

?>
