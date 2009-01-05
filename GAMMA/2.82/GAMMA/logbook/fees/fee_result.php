<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 1)
{
	die("ADMIN TOO LOW");
}


$year1 = $_POST["year1"];
$month1 = $_POST["month1"];
$day1 = $_POST["day1"];

$year2 = $_POST["year2"];
$month2 = $_POST["month2"];
$day2 = $_POST["day2"];

$agent = $_POST["Agent"];

$chargeBack = $_POST["ChargeBack"];

$date1 = $year1;
$date1 .= "-";
$date1 .= $month1;
$date1 .= "-";
$date1 .= $day1;

$date2 = $year2;
$date2 .= "-";
$date2 .= $month2;
$date2 .= "-";
$date2 .= $day2;


//includes
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();

//variables
$sql = "SELECT * FROM `logbook` WHERE `Date` >= '$date1' AND `Date` <= '$date2' AND `Agent` = '$agent' AND `office` = '$dbase' AND `group` = '$group'";
$x = 0;
$totalFees = 0;
$adjustedFees = 0;

echo( "<html>" );

echo( "<h1>Fees for ".$agent."</h1>" );
echo( "Results for dates from " );
echo( $date1 );
echo( " to " );
echo( $date2 );
echo( "<br>" );


$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Logbook Select Failure: $sql", "fee_result.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain logbook");
}

echo("<table border =\"0\" cellspacing=\"2\" cellpadding=\"2\">");
while($row = mysql_fetch_row($itemList))
{
	$num = count($row);
	$i = 0;
	$z = 0;
	for($i = 0 ; $i < $num; $i++)
	{
		if(mysql_field_name($itemList, $i) == "Fee")
		{
			echo("<tr>");
			//display who and add the total fees up
			for($z = 0 ; $z < $num; $z++)
			{

				if(mysql_field_name($itemList, $z) == "FirstName")
				{
					echo( "<td>".$row[$z]."</td>" );
				}
				if(mysql_field_name($itemList, $z) == "LastName")
				{
					echo( "<td>".$row[$z]."</td>" );
				}
				if(mysql_field_name($itemList, $z) == "Company")
				{
					echo( "<td>".$row[$z]."</td>" );
				}

			}
			$totalFees += $row[$i];
			echo("<td>$".$row[$i]."</td></tr>");
		}
	}
}
echo("</table>");

//Calcuate adjusted fees
if($agent == "ChrisPark")
{
	$adjustedFees = $totalFees/2;
}
else 
{
	$adjustedFees = $totalFees;
}

$adjustedFees = $adjustedFees + $chargeBack;

//Make them look pretty
$totalFees = sprintf("%01.2f", $totalFees);
$adjustedFees = sprintf("%01.2f", $adjustedFees);
$chargeBack = sprintf("%01.2f", $chargeBack);

echo( "<p><b>Total Broker Fees for ".$agent.":</b> $".$totalFees."<br>");
echo( "<b>Broker Fee Charge Back for ".$agent.":</b> $".$chargeBack."<br>");
echo( "<b>Adjusted Broker Fees for ".$agent.":</b> $".$adjustedFees."</p>");

//Commission
echo("<h1>Commission for ".$agent."</h1>" );

echo("<table border =\"0\" cellspacing=\"2\" cellpadding=\"2\">");

for($i = 0; $i <= 9; $i++)
{
	$companyVarName = "Company$i";
	$costVarName = "cost$i";
	if($_POST[$costVarName] != "")
	{
		echo("<tr><td>".$_POST[$companyVarName].":</td><td> $".$_POST[$costVarName]."</td></tr>");
		$totalCommission += $_POST[$costVarName];
	}
}

echo("</table>");

$totalCommission = sprintf("%01.2f", $totalCommission);
echo( "<p><b>Total Commission for ".$agent.":</b> $".$totalCommission."</p>");

$grandTotal = $totalCommission + $adjustedFees;
$grandTotal = sprintf("%01.2f", $grandTotal);
echo( "<h2>Total of Broker Fees and Commission for ".$agent.": $".$grandTotal."</h2>" );

echo("Comments:<br><textarea name=\"Comments\" cols=\"60\" rows=\"10\"></textarea>");
?>
