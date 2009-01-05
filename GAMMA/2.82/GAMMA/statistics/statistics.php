<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
if($valid == 1)
{
	echo( "<head> <META HTTP-EQUIV=\"Refresh\" CONTENT=\"900; URL=statistics.php\"></head>" );
}
else
{
	die("INVALID SESSION");
}

$FirstofM = date("Y");
$FirstofM .= "-";
$FirstofM .= date("m");
$FirstofM .= "-01 00:00:00";

$LastofM = date("Y");
$LastofM .= "-";
$LastofM .= date("m");
$LastofM .= "-31 23:59:59";

$FirstofY = date("Y");
$FirstofY .= "-01-01 00:00:00";

$LastofY = date("Y");
$LastofY .= "-12-31 23:59:59";

$FirstofD = date("Y");
$FirstofD .= "-";
$FirstofD .= date("m");
$FirstofD .= "-";
$FirstofD .= date("d");
$FirstofD .= " 00:00:00";

$LastofD = date("Y");
$LastofD .= "-";
$LastofD .= date("m");
$LastofD .= "-";
$LastofD .= date("d");
$LastofD .= " 23:59:59";

echo( "<h1>" );
echo( date("F") );
echo( " Policy Totals</h1>" );

echo( "<table border=\"0\">" );

connect_to();
$sql0 = "SELECT * FROM `statistics` WHERE `Group` = '$group' ORDER BY 'DisplayName'";

$items = mysql_query($sql0);

while($result = mysql_fetch_array($items))
{
	if($result["Database"] != "alttest")
	{
		$tempNumWritten = loggraph($result["DisplayName"], $result["Database"], $result["Color"], $FirstofM, $LastofM, $group);
	}
	$numWritten = $tempNumWritten + $numWritten;
}

echo( "</table><br>Number of Policies total this month: <b>$numWritten</b><br>" );

echo( "<h1>" );
echo( date("l") );
echo( " Receipt Totals</h1>" );

echo( "<table border=\"0\">" );

$items = mysql_query($sql0);

while($result = mysql_fetch_array($items))
{
	receiptgraph($result["DisplayName"], $result["Database"], $result["Color"], $FirstofD, $LastofD, $group);
}

echo( "</table>" );

if($admin >= 3)
{
	echo( "<h1>" );
	echo( date("l") );
	echo( " Quote Totals</h1>" );
	echo( "<table border=\"0\">" );
	$items = mysql_query($sql0);
	while($result = mysql_fetch_array($items))
	{
		quotegraph($result["Color"], $result["DisplayName"], $result["Database"], $FirstofD, $LastofD);	
	}
	echo( "</table>" );
	
}

if($admin >= 1)
{
	echo( "<a href = \"stats_custom.php\">Custom Statistics</a><br>" );
}



function loggraph($oname, $dbase, $gcol, $d1, $d2, $group)
{
	connect_to();
	$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$d1' AND `Date` <= '$d2' AND `office` = '$dbase' AND `group` = '$group'";
	$itemList = mysql_query($sql);

	if(mysql_num_rows($itemList) > 0)
	{
		echo( "<tr><td>" );
		echo( $oname );
		echo( ":</td><td>" );


		$i = 0;

		echo( "<img src=\"images/" );
		echo( $gcol );
		echo( "l.jpg\" border=\"0\">" );
		while($row = mysql_fetch_row($itemList))
		{
			$i = $i+1;
			echo( "<img src=\"images/" );
			echo( $gcol );
			echo( ".jpg\" border=\"0\">" );
		}
		echo( "<img src=\"images/" );
		echo( $gcol );
		echo( "r.jpg\" border=\"0\">" );

		echo( " <b>" );
		echo( $i );

		echo( "</b></td></tr>" );
	}
	return $i;
}

function receiptgraph($oname, $dbase, $gcol, $d1, $d2, $group)
{
	connect_to();
	$sql = "SELECT COUNT(*) FROM `receipt` WHERE `Date_Time` >= '$d1' AND `Date_Time` <= '$d2' AND `Void` != 'Yes' AND `office` = '$dbase' AND `group` = '$group'";
	$itemList = mysql_query($sql);
	
	$receiptCount = mysql_fetch_row($itemList);
	if($receiptCount[0] > 0)
	{
		echo( "<tr><td>" );
		echo( $oname );
		echo( ":</td><td>" );
		
		echo( "<img src=\"images/" );
		echo( $gcol );
		echo( "l.jpg\" border=\"0\">" );
		
		for($i = 1; $i <= $receiptCount[0]; $i++)
		{
			echo( "<img src=\"images/" );
			echo( $gcol );
			echo( ".jpg\" border=\"0\">" );
		}
		echo( "<img src=\"images/" );
		echo( $gcol );
		echo( "r.jpg\" border=\"0\">" );
		
		echo( " <b>" );
		echo( $receiptCount[0] );
		echo( "</b></td></tr>" );
	}
}

function quotegraph($gcol, $dname, $dbase, $d1, $d2)
{
	connect_to();
	$sql1 = "SELECT * FROM `quotes` WHERE `office` = '$dbase' AND `OriginTime` >= '$d1' AND `OriginTime` <= '$d2'";
	
	$selectResult1 = mysql_query($sql1);

	echo("<tr><td>$dname</td><td>");
	
	echo( "<img src=\"images/" );
	echo( $gcol );
	echo( "l.jpg\" border=\"0\">" );
	
	$i = 0;
	while($row = mysql_fetch_array($selectResult1))
	{
		$i++;
		echo( "<img src=\"images/" );
		echo( $gcol );
		echo( ".jpg\" border=\"0\">" );
	}
	
	echo( "<img src=\"images/" );
	echo( $gcol );
	echo( "r.jpg\" border=\"0\">" );
	
	echo("<b> $i</b></td></tr>");

}

?>
