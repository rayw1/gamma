<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
$group = $_SESSION["group"];
$user = $_SESS["username"];
$email = $_POST["Email"];
if($valid != 1)
{
	die("INVALID SESSION");
}
if($email == "NONE")
{
	$email = "";
}
if($email == "none")
{
	$email = "";
}

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

//Insert new row into the logbook
$sql1 = "SELECT * FROM `logbook_struct` WHERE `office` = '$dbase' AND `group` = '$group'";
$itemList1 = mysql_query($sql1);

$sql2 = "INSERT INTO `logbook` (";
$sql3 = ") VALUES (";
$sql4 = ")";
if($row1 = mysql_fetch_row($itemList1))
{
	$num = count($row1);

	$first = true;
	for($i = 0; $i < $num; $i++)
	{
		$lasti = $num - 1;
		$fieldname = mysql_field_name($itemList1, $i);
		if($row1[$i] == "Y" || $row1[$i] == "R")
		{
			if($first == false)
			{
				$sql2 .= ( ", " );
				$sql3 .= ( ", " );
			}
			else 
			{
				$first = false;
			}
			if($fieldname == "Date")
			{
				$sql2 .= "`$fieldname`";
				$sql3 .= "'".$_POST["year1"]."-".$_POST["month1"]."-".$_POST["day1"]."'";
				$customfield = 1;
			}
			if($customfield != 1)
			{
				$sql2 .= "`$fieldname`";
				$sql3 .= "'".$_POST[$fieldname]."'";
			}
			$customfield = 0;
		}
		
	}
}

$sql2 .= ", `office`, `group`";
$sql3 .= ", '$dbase', '$group'";

$sql2 .= $sql3;
$sql2 .= $sql4;

$insertResult2 = mysql_query($sql2);

if($insertResult2 == 0)
{
	die("Logbook insert failure");
	log_error("Logbook Insert Failure: $sql2", "logbook_insert.php", $_SESSION["username"], $_SESSION["group"]);
}

$fname = $_POST["FirstName"];
$lname = $_POST["LastName"];

//Farmers list code, to be replaced with Customer Database code
if($company == "Farmers")
{
	$name = $lname;
	$name .= ", ";
	$name .= $fname;
	$sql = "INSERT INTO `farmers` (`Number`, `Name`, `Location`) VALUES ('', '$name', '$dbase')";
	$insertresult = mysql_query($sql);
}


//======================
//=    Customer Db     =
//======================

$dob = $_POST["year2"];
$dob .= "-";
$dob .= $_POST["month2"];
$dob .= "-";
$dob .= $_POST["day2"];

if($_POST["year2"] > (date("Y") - 17))
{
	//they arent 18, its a bad record
	$dob = "0000-00-00";
}

$rnwl1 = $_POST["year3"];
$rnwl1 .= "-";
$rnwl1 .= $_POST["month3"];
$rnwl1 .= "-";
$rnwl1 .= $_POST["day3"];

$rnwl2 = $_POST["year4"];
$rnwl2 .= "-";
$rnwl2 .= $_POST["month4"];
$rnwl2 .= "-";
$rnwl2 .= $_POST["day4"];

$rnwl3 = $_POST["year5"];
$rnwl3 .= "-";
$rnwl3 .= $_POST["month5"];
$rnwl3 .= "-";
$rnwl3 .= $_POST["day5"];

$rnwlName1 = $_POST["ReminderName1"];
$rnwlName2 = $_POST["ReminderName2"];
$rnwlName3 = $_POST["ReminderName3"];

connect_to();

$sql3 = "INSERT INTO `customer_general` (`ID`, `First_Name`, `Last_Name`, `Address`, `City`, `State`, `Zip`, `DOB`, `Email`, `ReminderName1`, `ReminderDate1`, `ReminderName2`, `ReminderDate2`, `ReminderName3`, `ReminderDate3`, `Office`, `Group`) ";
$sql3 .= "VALUES ('', '$fname', '$lname', '".$_POST["Address"]."', '".$_POST["City"]."', '".$_POST["State"]."', '".$_POST["Zip"]."', '$dob', '$email', '$rnwlName1', '$rnwl1', '$rnwlName2', '$rnwl2', '$rnwlName3', '$rnwl3', '$dbase', '$group')";
$insertResult3 = mysql_query($sql3);

if($insertResult3 == 0)
{
	log_error("Customer Insert Failure", "logbook_insert.php", $user, $group);
}

//====================
//= End customer DB  =
//====================

$eid = mysql_insert_id();

if($email != "" && $email != "NONE")
{
	if($company != "Drive")
	{
		$body = "Dear ";
		$body .= $fname;
		$body .= " ";
		$body .= $lname;
		$body .= ",\n\n";
		$body .= "Thank you for your business!  As a valued customer of $group Insurance, you are important to us.  ";
		$body .= "Please feel free to call our office if you have any questions about your policy.  Also feel free to visit our ";
		$body .= "website http://www.alternativesins.com/ for valuable information 24 hours ";
		$body .= "a day.  From there, many customers can get billing and claims information. ";
		$body .= "\n\nOnce again, thank you for your business and please feel free to call or email us with your questions.";
		$body .= "\n\nAlternatives Insurance";
	}
	elseif($company == "Drive")
	{
		$body = "Dear $fname $lname, \n\n
		Thank you for choosing $group Insurance for your insurance needs. I was pleased to help you save money with the purchase of a Drive Insurance from Progressive policy. If you have any questions, please call
		If you know of anyone who would like to experience the same level of service, please forward this e-mail to them and ask them to give me a call.  I would be happy to offer them a free, no obligation quote from one of the many companies we represent. $group Insurance Agency offers competitive rates and superior claims service. 
		We also offer additional insurance products including Auto, Boat, Homeowner, Motorcycle, RV, Commercial, Health and Life from companies like Drive Insurance from Progressive, AIG, SAFECO and Travelers, and many others. We would be pleased to help you with these insurance products.  
		Thanks again for entrusting us with your business.
		Sincerely,\n
		$group Insurance \n";
	}

	mail($email, "Thank You from $group Insurance", $body);

}


echo( "
<script>
location=\"logbook_search.php?yPass=".$_POST["yPass"]."&mPass=".$_POST["mPass"]."\";
</script> 
");
?>
