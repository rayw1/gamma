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
	die("NOT AN ADMIN");
}

$rnum = $_GET["rid"];
include(getcwd().'/../includes/common.inc');
style("white");
connect_to();
$sql = "SELECT * FROM `receipt` WHERE `ReceiptID` = '$rnum' AND `office` = '$dbase' AND `group` = '$group'";
$itemList = mysql_query($sql);

if($itemList == 0)
{
	log_error("Receipt Select Failure: $sql", "receipt_edit.php", $_SESSION["username"], $_SESSION["group"]);
	die("Could not obtain receipts");
}
else
{
	echo( "<h1>Receipt Edit</h1>" );
}

while($row = mysql_fetch_array($itemList))
{
	$amount = $row["Amount"];
	$amount = sprintf("%01.2f", $amount);
	
	echo( "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
	<form action=\"receipt_update.php\" method=\"post\">" );
	echo( "<tr><td>Receipt Number:</td><td><input class=\"blue\" name=\"rnum\" type=\"hidden\" value=\"".$row["ReceiptID"]."\">".$row["ReceiptID"]."</td></tr>" );
	echo( "<tr><td>First Name:</td><td><input class=\"blue\" type=\"text\" name=\"First\" value=\"".$row["FirstName"]."\"></td></tr>" );
	echo( "<tr><td>Last Name:</td><td><input class=\"blue\" type=\"text\" name=\"Last\" value=\"".$row["LastName"]."\"></td></tr>" );
	echo( "<tr><td>Amount:</td><td>$<input class=\"blue\" name=\"Amount\" type=\"text\" size=\"10\" maxlength=\"8\" value=\"$amount\">" );
	echo( "<tr><td>Reason:</td><td>
	<select name=\"Reason\">
      <option value=\"Payment on Policy\"");

	if($row["Reason"] == "Payment on Policy")
	{
		echo( " selected" );
	}

	echo( ">Payment on Policy</option>
      <option value=\"New Business Downpayment\"");

	if($row["Reason"] == "New Business Downpayment")
	{
		echo( " selected" );
	}

	echo( ">New Business Downpayment</option>
      <option value=\"New Business Pay In Full\"");

	if($row["Reason"] == "New Business Pay In Full")
	{
		echo( " selected" );
	}

	echo( ">New Business Pay In Full</option>
      <option value=\"Replace Bad Check\"");
      
	if($row["Reason"] == "Replace Bad Check")
	{
		echo( " selected" );
	}
      
      echo( ">Replace Bad Check</option>
    </select></td></tr>" );

	echo( "<tr><td>Policy Number:</td><td><input class=\"blue\" name=\"PolNum\" value=\"".$row["PolNum"]."\"></td></tr>" );

	echo( "<tr><td>Payment Method:</td><td>" );
	echo( "<select name=\"Method\">" );
	echo( "<option value=\"Cash\"" );
	if( $row["PaymentMethod"] == "Cash")
	{
		echo( " selected" );
	}
	echo( ">Cash</option>" );
	
	echo( "<option value=\"EFT\"" );
	if( $row["PaymentMethod"] == "EFT")
	{
		echo( " selected" );
	}
	echo( ">EFT</option>" );	
	echo( "<option value=\"Check (Deposited)\"");
	if( $row["PaymentMethod"] == "Check (Deposited)")
	{
		echo( " selected" );
	}
	echo( ">Check (Deposited)</option>" );
	echo( "<option value=\"Check (Mailed)\"");
	if( $row["PaymentMethod"] == "Check (Mailed)")
	{
		echo( " selected" );
	}
	echo( ">Check (Mailed)</option>" );
	echo( "<option value=\"Check (Online)\"");
	if( $row["PaymentMethod"] == "Check (Online)")
	{
		echo( " selected" );
	}
	echo( ">Check (Online)</option>" );
	echo( "<option value=\"Money Order\"");
	if( $row["PaymentMethod"] == "Money Order")
	{
		echo( " selected" );
	}
	echo( ">Money Order</option>" );
	echo( "<option value=\"Credit Card (Office)\"");
	if( $row["PaymentMethod"] == "Credit Card (Office)")
	{
		echo( " selected" );
	}
	echo( ">Credit Card (Office)</option>" );
	echo( "<option value=\"Credit Card (Online)\"");
	if( $row["PaymentMethod"] == "Credit Card (Online)")
	{
		echo( " selected" );
	}
	echo( ">Credit Card (Online)</option>" );
	echo( "</select></td></tr>" );

	echo( "<tr><td>Check Number:</td><td><input class=\"blue\" type=\"text\" name=\"CheckNumber\" value=\"" );
	echo( $row["CheckNumber"] );
	echo( "\">(if applicable)" );
	echo( "</td></tr>" );

	echo( "<tr><td colspan=\"2\"><center><b>Split Payment</b></center></td></tr>" );
	$amount2 = $row["Amount2"];
	$amount2 = sprintf("%01.2f", $amount2);
	echo( "<tr><td>Amount:</td><td>$<input class=\"blue\" name=\"Amount2\" type=\"text\" size=\"10\" maxlength=\"8\" value=\"".$amount2."\"> Example: 82.50</td></tr>" );
	echo( "<tr><td>Payment Method: </td><td>" );
	echo( "<select name=\"Method2\">" );
	echo( "<option value=\"Cash\"" );
	if( $row["Method2"] == "Cash")
	{
		echo( " selected" );
	}
	echo( ">Cash</option>" );
	
	echo( "<option value=\"EFT\"" );
	if( $row["PaymentMethod"] == "EFT")
	{
		echo( " selected" );
	}
	echo( ">EFT</option>" );	
	
	echo( "<option value=\"Check (Deposited)\"");
	if( $row["Method2"] == "Check (Deposited)")
	{
		echo( " selected" );
	}
	echo( ">Check (Deposited)</option>" );
	echo( "<option value=\"Check (Mailed)\"");
	if( $row["Method2"] == "Check (Mailed)")
	{
		echo( " selected" );
	}
	echo( ">Check (Mailed)</option>" );
	echo( "<option value=\"Check (Online)\"");
	if( $row["Method2"] == "Check (Online)")
	{
		echo( " selected" );
	}
	echo( ">Check (Online)</option>" );
	echo( "<option value=\"Money Order\"");
	if( $row["Method2"] == "Money Order")
	{
		echo( " selected" );
	}
	echo( ">Money Order</option>" );
	echo( "<option value=\"Credit Card (Office)\"");
	if( $row["Method2"] == "Credit Card (Office)")
	{
		echo( " selected" );
	}
	echo( ">Credit Card (Office)</option>" );
	echo( "<option value=\"Credit Card (Online)\"");
	if( $row["Method2"] == "Credit Card (Online)")
	{
		echo( " selected" );
	}
	echo( ">Credit Card (Online)</option>" );
	echo( "</select></td></tr>" );

	echo( "<tr><td>Check Number:</td><td><input class=\"blue\" type=\"text\" name=\"CheckNumber2\" value=\"" );
	echo( $row["CheckNumber2"] );
	echo( "\">(if applicable)" );
	echo( "</td></tr>" );
	echo( "<tr><td>To:</td><td><input class=\"blue\" type=\"text\" name=\"To\" value=\"".$row["To"]."\"></td></tr>" );
	echo( "<tr><td>Complete:</td><td><select name=\"Complete\">" );

	echo( "<option value=\"Yes\"" );
	
	if($row["Completed"] == "Yes")
	{
		echo( " selected" );
	}
	
	echo( ">Yes</option>" );
	echo( "<option value=\"No\"" );
	
	if($row["Completed"] == "No")
	{
		echo( " selected" );
	}
	
	echo( ">No</option>" );
	echo( "</select></td></tr>" );
	
	echo( "<tr><td>Void:</td><td><select name=\"Void\">" );
	echo( "<option value=\"Yes\"" );
	
	if($row["Void"] == "Yes")
	{
		echo( " selected" );
	}
	
	echo( ">Yes</option>" );
	echo( "<option value=\"No\"" );
	
	if($row["Void"] == "No")
	{
		echo( " selected" );
	}
	
	echo( ">No</option>" );
	echo( "</select></td></tr>" );
	echo( "</table>" );
	echo( "<input type=\"Button\" value=\"Submit\" onclick=\"javascript:this.value='Please Wait';this.disabled=1;document.forms[0].submit()\"> " );
	echo( "</form>" );
}

?>
