<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../includes/common.inc');
connect_to();
style("white");
$valid = $_SESSION["validsession"];
$dbase = mysql_real_escape_string($_GET["dbase"]);
$id = mysql_real_escape_string($_GET["id"]);
$admin = $_SESSION["admin"];
$office = $_SESSION["office"];

if($valid != 1)
{
	die("INVALID SESSION");
}
if($office != $dbase && $admin <= 2)
{
	log_error("General Security Failure", "customer_profile.php", $_SESSION["username"], $_SESSION["group"]);
	die( "General Security Failure: Possibly Malformed URI" );	
}

$sql0 = "SELECT * FROM `customer_general` WHERE `ID` = '$id'";
$items0 = mysql_query($sql0);
if($items0 == 0)
{
	echo("Couldnt get customer info");
	log_error("Customer List Select Failure: $sql0", "customer_profile.php", $_SESSION["username"], $_SESSION["group"]);
}
$result0 = mysql_fetch_array($items0);

$lastName = $result0["Last_Name"];
$firstName = $result0["First_Name"];

echo( "<h1>".$lastName.", ".$firstName."</h1>" );

echo( "<h3>Policies in Log Book:</h3>" );
$sql1 = "SELECT * FROM `logbook` WHERE `LastName` = '$lastName' AND `FirstName` = '$firstName'";
$items1 = mysql_query($sql1);
if($items1 == 0)
{
	echo("Couldnt get customer logbook info");
}

echo( "<p><table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\">" );
$i = 0;
$item = 0;
$color = "#CCFFCC";
while($row = mysql_fetch_array($items1))
{
	$item++;
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

	//$num = count($row);
	$num = mysql_num_fields($items1);
	
	if($i == 0)
	{
		for($i = 0; $i < $num; $i++)
		{
			echo( "<td><b>" );
			echo(replace_chars(mysql_field_name($items1, $i)));
			echo( "</b></td>" );
		}
		echo ("</tr><tr>");
	}

	$i = 0;
	for($i = 0 ; $i < $num; $i++)
	{
		echo( "<td>" );
		if(mysql_field_name($items1, $i) == "Number")
		{

			echo( $item );

		}
		else
		{
			echo( $row[$i] );
		}
		echo( "</td>" );

	}
	echo( "</tr>" );

}

echo( "</table></p>" );

echo( "<h3>Receipts found:</h3>" );
$sql2 = "SELECT * FROM `receipt` WHERE `LastName` = '$lastName' AND `FirstName` = '$firstName'";
$items2 = mysql_query($sql2);
if($items2 == 0)
{
	echo("Couldnt get customer receiptbook info");
}
echo( "<p><table border = \"0\" cellspacing=\"0\" cellpadding=\"4\" width = \"100%\">" );
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
echo( "<b>Payment Method</b>" );
echo( "</td><td>" );
echo( "<b>Check Number</b>" );
echo( "</td><td>" );
echo( "<b>By</b>" );
echo( "</td><td>" );
echo( "<b>To</b>" );
echo( "</td><td>" );
echo( "<b>Completed</b>" );
echo( "</td></tr>" );

$color = "#CCFFCC";
while($row = mysql_fetch_array($items2))
{

	echo( "<tr style=\"background:" );
	echo( $color );
	echo( ";\"><td>" );
	echo( $row["ReceiptID"] );
	echo( "</td><td>" );
	echo( $row["FirstName"] );
	echo( "</td><td>" );
	echo( $row["LastName"] );
	echo( "</td><td>$" );
	$amount = sprintf("%01.2f", $row["Amount"]);
	echo( $amount );
	echo( "</td><td>" );
	echo( $row["Date_Time"] );
	echo( "</td><td>" );
	echo( $row["Reason"] );
	echo( "</td><td>" );
	echo( $row["PaymentMethod"] );
	echo( "</td><td>" );
	echo( $row["CheckNumber"] );
	echo( "</td><td>" );
	echo( $row["By"] );
	echo( "</td><td>" );
	echo( $row["To"] );
	echo( "</td><td>" );
	echo( $row["Completed"] );
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
echo( "</table></p>" );

echo( "<h3>Email Address:</h3>" );

echo( "<p><a href=\"customer_email_edit1.php?id=$id&dbase=$dbase\">".$result0["Email"]."</a></p>" );

echo( "<p><b>Notice! This information tries to be as accurate as possible, but duplicate names and data inconsistancies will occur.  The GAMMA system can only make guesses and assumptions based on the data input into the logbook and receiptbook.  Please double check the data before making a crucial decision.</b></p>" );
?>
