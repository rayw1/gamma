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

$today = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));
$today45 = date("Ymd",mktime(0,0,0,date("m"),date("d")+45,date("Y")));

connect_to();
$sql3 = "SELECT * FROM `customer_general` WHERE `ReminderDate1` > '$today' AND `ReminderDate1` <= '$today45' AND `office` = '$dbase' AND `group` = '$group'";
$selectResult3 = mysql_query($sql3);

$sql4 = "SELECT * FROM `customer_general` WHERE `ReminderDate2` > '$today' AND `ReminderDate2` <= '$today45' AND `office` = '$dbase' AND `group` = '$group'";
$selectResult4 = mysql_query($sql4);

$sql5 = "SELECT * FROM `customer_general` WHERE `ReminderDate3` > '$today' AND `ReminderDate3` <= '$today45' AND `office` = '$dbase' AND `group` = '$group'";
$selectResult5 = mysql_query($sql5);

echo( "<h1>Reminders</h1>" );
echo( "This data is for the next 45 days" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"75%\">" );
echo( "<tr><td><b>First</b></td><td><b>Last</b></td><td><b>Reminder</b.</td><td><b>Date</b></td></tr>" );

$color = "#CCFFCCC";
while($row = mysql_fetch_array($selectResult3))
{
	$date = $row["ReminderDate1"];
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
	echo( ";\"><td>".$row["First_Name"]."</td><td>".$row["Last_Name"]."</td><td>".$row["ReminderName1"]."</td><td>".$date."</td></tr>" );

}

while($row = mysql_fetch_array($selectResult4))
{
	$date = $row["ReminderDate2"];
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
	echo( ";\"><td>".$row["First_Name"]."</td><td>".$row["Last_Name"]."</td><td>".$row["ReminderName2"]."</td><td>".$date."</td></tr>" );

}

while($row = mysql_fetch_array($selectResult5))
{
	$date = $row["ReminderDate3"];
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
	echo( ";\"><td>".$row["First_Name"]."</td><td>".$row["Last_Name"]."</td><td>".$row["ReminderName3"]."</td><td>".$date."</td></tr>" );

}

echo( "</table>" );

?>
