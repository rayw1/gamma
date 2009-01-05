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

$yearIn = $_GET["year"];
$officeIn = $_GET["office"];
$lastYear = $yearIn - 1;
$nextYear = $yearIn +1;

connect_to();

$sql0 = "SELECT `DisplayName` FROM `statistics` WHERE `Database` = '$officeIn' AND `Group` = '$group'";
$selectResult0 = mysql_query($sql0);

$tempRow = mysql_fetch_array($selectResult0);

echo( "<h1>Totals for ".$tempRow["DisplayName"]." in ".$yearIn."</h1>" );
echo( "<h3>View this in <a href=\"officeTotals1.php?office=".$officeIn."&year=".$lastYear."\">".$lastYear."</a> or <a href=\"officeTotals1.php?office=".$officeIn."&year=".$nextYear."\">".$nextYear."</a></h3>" );

echo( "<input type=\"hidden\" name=\"year\" value=\"".$yearIn."\">" );
echo( "<input type=\"hidden\" name=\"office\" value=\"".$officeIn."\">" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
$color = "#CCFFCC";

echo( "<tr><td><b>Month</b></td><td><b>Amount</b></td><td><b>Paid</b></td><td><b>Remaining</b></td></tr>" );

for($i = 1; $i <= 12; $i++)
{
	$sql1 = "SELECT `amount` FROM `franchise_bills` WHERE `office` = '$officeIn' AND `month` = '$i' AND `year` = '$yearIn'";
	$selectResult1 = mysql_query($sql1);
	
	$sql2 = "SELECT * FROM `franchise_bills` WHERE `office` = '$officeIn' AND `month` = '$i' AND `year` = '$yearIn' AND `received` = 'yes'";
	$selectResult2 = mysql_query($sql2);
	
	$paidToDate = 0;
	while($tempRow = mysql_fetch_array($selectResult2))
	{
		$paidToDate = $paidToDate + $tempRow["amount"];
	}

	$runningTotal = 0;
	
	while($row = mysql_fetch_array($selectResult1))
	{	
		$runningTotal = $runningTotal + $row["amount"];
	}
	
	echo( "<tr><td>" );
	
	if($i == 1)
	{
		echo( "January" );
	}
	elseif($i == 2)
	{
		echo( "February" );
	}
	elseif($i == 3)
	{
		echo( "March" );
	}
	elseif($i == 4)
	{
		echo( "April" );
	}
	elseif($i == 5)
	{
		echo( "May" );
	}
	elseif($i == 6)
	{
		echo( "June" );
	}
	elseif($i == 7)
	{
		echo( "July" );
	}
	elseif($i == 8)
	{
		echo( "August" );
	}
	elseif($i == 9)
	{
		echo( "September" );
	}
	elseif($i == 10)
	{
		echo( "October" );
	}
	elseif($i == 11)
	{
		echo( "November" );
	}
	elseif($i == 12)
	{
		echo( "December" );
	}
	
	$runningTotal = sprintf("%01.2f", $runningTotal);
	$paidToDate = sprintf("%01.2f", $paidToDate);
	$remainder = $runningTotal - $paidToDate;
	
	echo( "</td><td>$".$runningTotal."</td><td> $".$paidToDate."</td><td> $".$remainder."</td></tr>" );
}

echo( "</table>" );

?>
