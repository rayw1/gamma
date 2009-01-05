<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$rnum = $_GET["rid"];
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `receipt` WHERE `ReceiptID` = '$rnum' AND `office` = '$dbase' AND `group` = '$group'";

$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Receipt Select Failure: $sql", "receipt_print.php", $_SESSION["username"], $_SESSION["group"]);
	die("Receipt NOT found");
}

while($row = mysql_fetch_array($itemList))
{
	$first = $row["FirstName"];
	$last = $row["LastName"];
	$amount = $row["Amount"];
	$amount = sprintf("%01.2f", $amount);

	$amount2 = $row["Amount2"];
	$amount2 = sprintf("%01.2f", $amount2);
	$method2 = $row["Method2"];
	$checknum2 = $row["CheckNumber2"];

	$reason = $row["Reason"];
	$method = $row["PaymentMethod"];
	$checknum = $row["CheckNumber"];
	$uname = $row["By"];
	$to = $row["To"];
	$polnum = $row["PolNum"];

	$day = substr($row["Date_Time"], 8, 2);
	$month = substr($row["Date_Time"], 5, 2);
	$year = substr($row["Date_Time"], 0, 4);
	$hour = substr($row["Date_Time"], 11, 2);
	$minute = substr($row["Date_Time"], 14, 2);
	$second = substr($row["Date_Time"], 17, 2);

	if($hour > 12)
	{
		$hour = $hour - 12;
		$meridian = "PM";
	}
	elseif($hour == 12)
	{
		$meridian = "PM";
	}
	elseif($hour == 0)
	{
		$hour = 12;
		$meridian = "AM";
	}
	else
	{
		$meridian = "AM";
	}

	$now = $month."/".$day."/".$year." ".$hour.":".$minute.":".$second." ".$meridian;
}

$sql0 = "SELECT * FROM `statistics` WHERE `Database` = '$dbase'";

$items = mysql_query($sql0);

$result = mysql_fetch_array($items);

echo( "<center><body onload=\"window.print()\"></body>" );
echo( "<table border=\"0\"><tr><td>" );
echo( "<img src = \"images/".$group.".jpg\" border = 0></td></tr>" );
echo( "<tr><td><center>".$result["Address"]."</center></td></tr>");
echo( "<tr><td><center>".$result["Phone"]."</center></td></tr>");
echo( "<tr><td><center><h1>Receipt</h1></center></td></tr></table>" );
echo( "<br><br><br><table border=\"0\" cellpadding=\"1\"><tr><td>Date:</td><td> " );
echo( $now );
echo( "</td></tr><tr><td>" );
echo( "Receipt Number:</td><td> " );
echo( $rnum );
echo( "</td></tr><tr><td>" );
echo( "Name: </td><td>" );
echo( $first );
echo( " " );
echo( $last );
echo( "</td></tr><tr><td>" );
echo( "Amount: </td><td>$" );
echo( $amount );
echo( "</td></tr><tr><td>" );
echo( "Reason: </td><td>" );
echo( $reason );
echo( "</td></tr><tr><td>" );
echo( "Policy Number:</td><td>" );
echo( $polnum );
echo( "</td></tr><tr><td>" );
echo( "Payment Method: </td><td>");
echo( $method );
echo( "</td></tr><tr><td>" );
echo( "Check Number: </td><td>" );
echo( $checknum );
echo( "</td></tr>" );
if($amount2 != 0)
{
	echo( "<tr><td colspan=\"2\"><b><center>Split Payment</center></b></td></tr>" );
	echo( "<tr><td>Amount: </td><td>$ $amount2 </td></tr>" );
	echo( "<tr><td>Method: </td><td> $method2 </td></tr>" );
	echo( "<tr><td>Check Number: </td><td> $checknum2 </td></tr>" );
}
echo( "<tr><td>To: </td><td>" );
echo( $to );
echo( "</td></tr><tr><td>" );
echo( "By: </td><td>" );
echo( $uname );
echo( "</td></tr>" );
echo( "</table><br><br><br><br><br><br><table border=\"0\"><tr><td>" );
echo( "Disclaimer: Policy is null and void if payment is not honored by bank,<br>" );
echo( "or if payment is being made after your cancellation effective date.<br>" );
echo( "Receipt of payment by agent does not guarantee reinstatement of policy<br>" );
echo( "if payment is made after the cancellation effective date.<br>" );
echo( "</td></tr></table>" );

if($_GET["bridge"] == "yes")
{
	$paid = $amount + $amount2;
	echo( "<form action=\"../logbook/logbook.php\" method=\"post\">" );
	echo( "<input type=\"hidden\" name=\"FirstName\"  value=\"$first\">
	<input type=\"hidden\" name=\"LastName\" value=\"$last\">
	<input type=\"hidden\" name=\"Paid\" value=\"$paid\">
	<input type=\"hidden\" name=\"PolicyNumber\" value=\"$polnum\">
	<input type=\"Button\" value=\"Bridge\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\">");
}

echo( "</html>" );
?>
