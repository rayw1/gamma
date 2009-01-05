<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
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

$yearIn = mysql_real_escape_string($_GET["year"]);
$recipIn = mysql_real_escape_string($_GET["recip"]);
$lastYear = $yearIn - 1;
$nextYear = $yearIn +1;

echo( "<h1>Totals for ".$recipIn." in ".$yearIn."</h1>" );
echo( "<h3>View this in <a href=\"totals1.php?recip=".$recipIn."&year=".$lastYear."\">".$lastYear."</a> or <a href=\"totals1.php?recip=".$recipIn."&year=".$nextYear."\">".$nextYear."</a></h3>" );

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
$color = "#CCFFCC";

echo( "<tr><td><b>Month</b></td><td><b>Amount</b></td></tr>" );

for($i = 1; $i <= 12; $i++)
{
	$sql1 = "SELECT `Amount` FROM `franchise_bills` WHERE `reason` = '$recipIn' AND `month` = '$i' AND `year` = '$yearIn' AND `Group` = '$group'";
	$selectResult1 = mysql_query($sql1);
	
	$runningTotal = 0;
	
	while($row = mysql_fetch_array($selectResult1))
	{	
		$runningTotal = $runningTotal + $row["Amount"];
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
	echo( "</td><td>$".$runningTotal."</td></tr>" );
}

echo( "</table>" );

?>
