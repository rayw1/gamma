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
if($admin < 2)
{
	die( "Admin too low" );
}

connect_to();
$thisYear = date("Y");
$thisMonth = date("m");

echo( "<h1>My Franchise Bills</h1>" );

if($admin >= 3)
{
	//==================================
	//=        Function Links          =
	//==================================	
	echo( "<p><a href = \"makerecipient1.php\"><img src=\"../images/add.gif\" border=\"0\"></a></p>" );
	echo( "<p><a href = \"duedates1.php?year=".$thisYear."\">Set due dates and send bills</a></p>" );
	
	//==================================
	//=         Overdue Code           =
	//==================================
	$thisYear = date("Y");
	$thisMonth = date("m");

	$sql0 = "SELECT * FROM `franchise_bills` WHERE `sent` = 'yes' AND `received` = 'no' AND `Group` = '$group'";
	$selectResult0 = mysql_query($sql0);


	if($row = mysql_fetch_array($selectResult0))
	{
		$row = mysql_fetch_array($selectResult0);
		$due = $row["due"];
		$month = substr($due, 5, 2);
		$day = substr($due, 8, 2);
		$year = substr($due, 0, 4);
		$timestamp = date("Ymd", mktime(0,0,0,$month,$day,$year));
		$timestamp2 = date("Ymd",mktime(0,0,0,date("m"),date("d"),date("Y")));

		if ($timestamp < $timestamp2)
		{
			echo( "<h1><font color=\"red\"><a href=\"lateDetails1.php\">There are overdue statements!</a></font></h1>" );
		}
	}

	//==================================
	//=        Recipient Table         =
	//==================================
	echo( "Payment Recipients:" );
	$sql0 = "SELECT DISTINCT `reason` FROM `franchise_bills` WHERE `Group` = '$group'";
	$selectResult0 = mysql_query($sql0);

	echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
	echo( "<tr><td><b>Recipient</b></td><td><b>Received Payments</b></td><td><b>Totals</b></td></tr>" );

	while($row = mysql_fetch_array($selectResult0))
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
		echo( ";\"><td><a href=\"recipient1.php?year=".$thisYear."&month=".$thisMonth."&recip=".$row["reason"]."\">".$row["reason"]."</a></td><td><a href=\"received1.php?year=".$thisYear."&recip=".$row["reason"]."\">Process</a></td><td><a href=\"totals1.php?recip=".$row["reason"]."&year=".$thisYear."\">Totals</a></td></tr>" );
	}
	echo( "<tr><td></td><td></td><td><a href=\"grandTotals1.php?year=".$thisYear."\">Grand Totals</a></td></tr>" );
	echo( "</table>" );
	

	//==================================
	//=         Offices Table          =
	//==================================	
	echo( "Offices:" );
	$sql2 = "SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY `OfficeNumber`";
	$selectResult2 = mysql_query($sql2);

	echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">" );
	echo( "<tr><td><b>Office</b></td><td><b>Received Payments</b></td><td><b>Totals</b></td></tr>" );

	while($row = mysql_fetch_array($selectResult2))
	{
		if($row["Database"] != "alttest")
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
			echo( ";\"><td>".$row["OfficeNumber"]." - ".$row["DisplayName"]."</td><td><a href=\"officePayments1.php?year=".$thisYear."&office=".$row["Database"]."\">Process</a></td><td><a href=\"officeTotals1.php?office=".$row["Database"]."&year=".$thisYear."\">Totals</a></td></tr>" );
		}
	}
	echo( "</table>" );

}

//==================================
//=      View Statement Code       =
//==================================
echo( "View my franchise bill for the following month:<br> " );
$sql1 = "SELECT DISTINCT `month` , `year` , `sent` FROM `franchise_bills` WHERE `office` = '$office' ORDER BY `year` DESC, `month` DESC";
$selectResult1 = mysql_query($sql1);


while($row = mysql_fetch_array($selectResult1))
{
	if($row["sent"] == "yes")
	{
		echo( "<a href=\"getbill.php?month=".$row["month"]."&year=".$row["year"]."\">".$row["month"]."-".$row["year"]."</a><br>" );
	}
}

?>
