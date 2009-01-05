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
$lastYear = $yearIn - 1;
$nextYear = $yearIn +1;

echo( "<h1>Grand Totals for ".$yearIn."</h1>" );
echo( "<h3>View this in <a href=\"grandTotals1.php?&year=".$lastYear."\">".$lastYear."</a> or <a href=\"totals1.php?recip=&year=".$nextYear."\">".$nextYear."</a></h3>" );

//==================================
//=            Billed              =
//==================================



echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=\"100%\">" );
echo( "<tr><td colspan=\"13\"><h2>How much was billed...</h2></td></tr>" );
$color = "#CCFFCC";

echo( "<tr><td><b>Recipient</b></td>
<td><b>Jan</b></a></td>
<td><b>Feb</b></a></td>
<td><b>March</b></a></td>
<td><b>April</b></a></td>
<td><b>May</b></a></td>
<td><b>June</b></a></td>
<td><b>July</b></a></td>
<td><b>Aug</b></a></td>
<td><b>Sept</b></a></td>
<td><b>Oct</b></a></td>
<td><b>Nov</b></a></td>
<td><b>Dec</b></a></td>
</tr>" );

connect_to();

$selectResult1 = mysql_query("SELECT DISTINCT `reason` FROM `franchise_bills` WHERE `Group` = '$group'");
$j = 0;
while($row = mysql_fetch_array($selectResult1))
{
	$j = $j + 1;
	$recipient = $row["reason"];

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
	echo( ";\"><td>".$recipient."</td>" );
	for($i = 1; $i <= 12; $i++)
	{
		$sql3 = "SELECT * FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `reason` = '$recipient' AND `Group` = '$group'";
		$selectResult3 = mysql_query($sql3);
		$runningTotal[$i][$j] = 0;
		while($row2 = mysql_fetch_array($selectResult3))
		{
			$runningTotal[$i][$j] = $runningTotal[$i][$j] + $row2["amount"];
		}
		$runningTotal[$i][$j] = sprintf("%01.2f", $runningTotal[$i][$j]);
		echo( "<td> $".$runningTotal[$i][$j]." </td>" );
		$grandTotal[$i] = $grandTotal[$i] + $runningTotal[$i][$j];
	}	
	echo( "</tr>" );
}
echo( "<tr><td><b>Totals:</b></td>" );
for($i = 1; $i <= 12; $i++)
{
	echo( "<td><b> $".$grandTotal[$i]." </b></td>" );
}
echo( "</tr>" );



//==================================
//=           Received             =
//==================================

echo( "<tr><td colspan =\"13\"><h2>How much was received...</h2></td></tr>" );


$color = "#CCFFCC";

echo( "<tr><td><b>Recipient</b></td>
<td><b>Jan</b></a></td>
<td><b>Feb</b></a></td>
<td><b>March</b></a></td>
<td><b>April</b></a></td>
<td><b>May</b></a></td>
<td><b>June</b></a></td>
<td><b>July</b></a></td>
<td><b>Aug</b></a></td>
<td><b>Sept</b></a></td>
<td><b>Oct</b></a></td>
<td><b>Nov</b></a></td>
<td><b>Dec</b></a></td>
</tr>" );

$selectResult1 = mysql_query("SELECT DISTINCT `reason` FROM `franchise_bills` WHERE `Group` = '$group'");
$j = 0;
while($row = mysql_fetch_array($selectResult1))
{
	$j = $j + 1;
	$recipient = $row["reason"];

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
	echo( ";\"><td>".$recipient."</td>" );
	for($i = 1; $i <= 12; $i++)
	{
		$sql3 = "SELECT * FROM `franchise_bills` WHERE `month` = '$i' AND `year` = '$yearIn' AND `reason` = '$recipient' AND `received` = 'yes' AND `Group` = '$group'";
		$selectResult3 = mysql_query($sql3);
		$runningTotal2[$i][$j] = 0;
		while($row2 = mysql_fetch_array($selectResult3))
		{
			$runningTotal2[$i][$j] = $runningTotal2[$i][$j] + $row2["amount"];
		}
		$runningTotal2[$i][$j] = sprintf("%01.2f", $runningTotal2[$i][$j]);
		echo( "<td> $".$runningTotal2[$i][$j]." </td>" );
		$grandTotal2[$i] = $grandTotal2[$i] + $runningTotal2[$i][$j];
	}	
	echo( "</tr>" );
}
echo( "<tr><td><b>Totals:</b></td>" );
for($i = 1; $i <= 12; $i++)
{
	echo( "<td><b> $".$grandTotal2[$i]." </b></td>" );
}
echo( "</tr>" );


//==================================
//=           Difference           =
//==================================

echo( "<tr><td colspan=\"13\"><h2>A difference of...</h2></td></tr>" );

$color = "#CCFFCC";

echo( "<tr><td><b>Recipient</b></td>
<td><b>Jan</b></a></td>
<td><b>Feb</b></a></td>
<td><b>March</b></a></td>
<td><b>April</b></a></td>
<td><b>May</b></a></td>
<td><b>June</b></a></td>
<td><b>July</b></a></td>
<td><b>Aug</b></a></td>
<td><b>Sept</b></a></td>
<td><b>Oct</b></a></td>
<td><b>Nov</b></a></td>
<td><b>Dec</b></a></td>
</tr>" );

$selectResult1 = mysql_query("SELECT DISTINCT `reason` FROM `franchise_bills` WHERE `Group` = '$group'");
$j = 0;
while($row = mysql_fetch_array($selectResult1))
{
	$j = $j + 1;
	$recipient = $row["reason"];

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
	echo( ";\"><td>".$recipient."</td>" );
	for($i = 1; $i <= 12; $i++)
	{
		$difference = $runningTotal2[$i][$j] - $runningTotal[$i][$j];
		$difference = sprintf("%01.2f", $difference);
		if($difference < 0)
		{
			echo( "<td bgcolor=\"red\"> $".$difference." </td>" );
		}
		elseif( $difference == 0 )
		{
			echo( "<td> $".$difference." </td>" );
		}
		elseif( $difference > 0)
		{
			echo( "<td bgcolor=\"green\"> $".$difference." </td>" );
		}
		
		$grandTotal3[$i] = $grandTotal3[$i] + $difference;
	}	
	echo( "</tr>" );
}
echo( "<tr><td><b>Totals:</b></td>" );
for($i = 1; $i <= 12; $i++)
{
	echo( "<td><b> $".$grandTotal3[$i]." </b></td>" );
}
echo( "</tr>" );

echo( "</table>" );
?>
