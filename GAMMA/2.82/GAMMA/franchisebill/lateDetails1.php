<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 3)
{
	die( "Admin too low" );
}

connect_to();
$thisYear = date("Y");
$thisMonth = date("m");

echo( "<h1>Overdue Details</h1>" );

//==================================
//=         Overdue Code           =
//==================================

$thisYear = date("Y");
$thisMonth = date("m");

$sql0 = "SELECT * FROM `franchise_bills` WHERE `sent` = 'yes' AND `received` = 'no' AND `Group` = '$group' ORDER BY `office`";
$selectResult0 = mysql_query($sql0);


while($row = mysql_fetch_array($selectResult0))
{
	$due = $row["due"];
	$month = substr($due, 5, 2);
	$day = substr($due, 8, 2);
	$year = substr($due, 0, 4);
	$timestamp = date("Ymd", mktime(0,0,0,$month,$day,$year));
	$timestamp2 = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));

	if ($timestamp < $timestamp2)
	{
		$dbase = $row["office"];
		$sql1 = "SELECT * FROM `statistics` WHERE `database` = '$dbase' LIMIT 1";
		$selectResult1 = mysql_query($sql1);
		$tempRow = mysql_fetch_array($selectResult1);
		$amount = sprintf("%01.2f", $row["amount"]);
		if($row["ID"] != "")
		{
			echo( $tempRow["DisplayName"]." owes you $".$amount." for ".$row["reason"]."<br>" );
		}
	}
}

?>
