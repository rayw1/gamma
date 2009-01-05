<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
style("white");
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($admin < 2)
{
	die( "Admin too low" );
}

$passMonth = $_GET["month"];
$passYear = $_GET["year"];

echo( "<h1>Franchise Bill for ".$passMonth."-".$passYear."</h1>" );

connect_to();

$sql1 = "SELECT * FROM `franchise_bills` WHERE `office` = '$office' AND `month` = '$passMonth' AND `year` = '$passYear'";
$selectResult1 = mysql_query($sql1);

echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"50%\">" );
$color = "#CCFFCC";

echo( "<tr><td><b>Reason</b></td><td><b>Amount</b></td></tr>" );

while($row = mysql_fetch_array($selectResult1))
{
	if($row["due"] != "0000-00-00")
	{
		$year = substr($row["due"], 0, 4);
		$month = substr($row["due"], 5, 2);
		$day = substr($row["due"], 8, 2);
	}

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
	echo( ";\">" );

	$amount = sprintf("%01.2f", $row["amount"]);
	
	$runningTotal = $runningTotal + $amount;

	echo( "<td>".$row["reason"]."</td><td>$".$amount."</td></tr>" );

}
$runningTotal = sprintf("%01.2f", $runningTotal);
echo( "<tr><td><b>Total:</b></td><td>$".$runningTotal."</td></tr>" );
echo( "</table>" );
echo( "
Make one check payable to Alternatives Insurance Group and mail to:<br>
Alternatives Insurance Group<br>
7710 Carondelet Ave<br>
Suite 505<br>
Clayton, MO 63105<br>
<br>
" );

echo( "<b>Due date:</b> ".$month."-".$day."-".$year );

?>

