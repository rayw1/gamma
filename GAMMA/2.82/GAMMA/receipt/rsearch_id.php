<?php
//GAMMA V2.7 CERTIFIED
include(getcwd().'/../includes/common.inc');
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
	die("NOT AN ADMIN");
}

style("white");
$rnum = $_POST["rid"];
connect_to();
$sql = "SELECT * FROM `receipt` WHERE `ReceiptID` = '$rnum' AND `office` = '$dbase' AND `group` = '$group'";

echo( "<html>" );
echo( "<h1>Receipt by ID</h1>" );
$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Receipt Select Failure: $sql", "rsearch_id.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain receipts");
}

echo( "<table border = \"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\">" );
echo( "<tr><td>" );
echo( "<b>Receipt ID</b>" );
echo( "</td><td>" );
echo( "<b>First Name</b>" );
echo( "</td><td>" );
echo( "<b>Last Name</b>" );
echo( "</td><td>" );
echo( "<b>Amount</b>" );
echo( "</td><td>" );
echo( "<b>Date and Time</b>" );
echo( "</td><td>" );
echo( "<b>Reason</b>" );
echo( "</td><td>" );
echo( "<b>Policy<br>Number</b>" );
echo( "</td><td>" );
echo( "<b>Payment Method</b>" );
echo( "</td><td>" );
echo( "<b>Check Number</b>" );
echo( "<b>Split Method</b>" );
echo( "</td><td>" );
echo( "<b>Split Amount</b>" );
echo( "</td><td>" );
echo( "<b>Split Check Number</b>" );

echo( "</td><td>" );
echo( "</td><td>" );
echo( "<b>By</b>" );
echo( "</td><td>" );
echo( "<b>To</b>" );
echo( "</td><td>" );
echo( "<b>Completed</b>" );
echo( "</td><td>" );
echo( "<b>Void</b>" );
echo( "</td><td>" );
echo( "<b>Print</b>" );
echo( "</td></tr>" );

$color = "#CCFFCC";
while($row = mysql_fetch_array($itemList))
{

	echo( "<tr style=\"background:" );
	echo( $color );
	echo( ";\"><td>" );
	echo( "<a href = \"receipt_edit.php?rid=" );
	echo( $row["ReceiptID"] );
	echo( "\">" );
	echo( $row["ReceiptID"] );
	echo( "</a></td><td>" );
	echo( $row["FirstName"] );
	echo( "</td><td>" );
	echo( $row["LastName"] );
	echo( "</td><td>$" );
	$amount = sprintf("%01.2f", $row["Amount"]);
	echo( $amount );
	echo( "</td><td>" );
	
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

	echo( $month."/".$day."/".$year." ".$hour.":".$minute.":".$second." ".$meridian."<br>" );
	echo( "</td><td>" );
	echo( $row["Reason"] );
	echo( "</td><td>" );
	echo( $row["PolNum"] );
	echo( "</td><td>" );
	echo( $row["PaymentMethod"] );
	echo( "</td><td>" );
	echo( $row["CheckNumber"] );
	echo( "</td><td>" );
	echo( $row["Method2"] );
	echo( "</td><td>" );
	$amount2 = sprintf("%01.2f", $row["Amount2"]);
	echo( $amount2 );
	echo( "</td><td>" );
	echo( $row["CheckNumber2"] );

	echo( "</td><td>" );
	echo( $row["By"] );
	echo( "</td><td>" );
	echo( $row["To"] );
	echo( "</td><td>" );
	echo( $row["Completed"] );
	echo( "</td><td>" );
	echo( $row["Void"] );
	echo( "</td><td>" );
	echo( "<a href = \"receipt_print.php?rid=" );
	echo( $row["ReceiptID"] );
	echo( "\" target=\"_new\"><img src = \"print.gif\" border = \"0\"></a>" );
	echo( "</td></tr>" );

	if($color == "white")
	{
		$color = "#CCFFCC";
	}
	else
	{
		$color = "white";
	}
}
echo( "</table><br>" );
echo( "<form action=\"rsearch_id.php\" method=\"POST\">" );
echo( "Other receipt: " );
echo( "<input class=\"blue\" type=\"text\" name=\"rid\">" );
echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
echo( "</form>" );
echo( "<br>" );
echo( "Search Options: <a href = \"receipt_search.php\">Noncompleted</a> / ID / <a href = \"rsearch_date.php\">Date</a> / <a href = \"rsearch_name.php\">Name</a> / <a href = \"rsearch_name.php\">Name</a> / <a href=\"rsearch_amount.php\">Amount</a> / <a href=\"rsearch_company.php\">Company</a>" );
?>
