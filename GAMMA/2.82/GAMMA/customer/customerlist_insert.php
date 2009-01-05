<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$group = $_SESSION["group"];
$dbase = $_SESSION["office"];
if($valid != 1)
{
  die("INVALID SESSION");
}

include(getcwd().'/../includes/common.inc');
style("white");
connect_to();

$fname = mysql_real_escape_string($_POST["First_Name"]);
$lname = mysql_real_escape_string($_POST["Last_Name"]);
$email = mysql_real_escape_string($_POST["Email"]);

$dob = mysql_real_escape_string($_POST["year2"]);
$dob .= "-";
$dob .= mysql_real_escape_string($_POST["month2"]);
$dob .= "-";
$dob .= mysql_real_escape_string($_POST["day2"]);

$rnwl1 = mysql_real_escape_string($_POST["year3"]);
$rnwl1 .= "-";
$rnwl1 .= mysql_real_escape_string($_POST["month3"]);
$rnwl1 .= "-";
$rnwl1 .= mysql_real_escape_string($_POST["day3"]);

$rnwl2 = mysql_real_escape_string($_POST["year4"]);
$rnwl2 .= "-";
$rnwl2 .= mysql_real_escape_string($_POST["month4"]);
$rnwl2 .= "-";
$rnwl2 .= mysql_real_escape_string($_POST["day4"]);

$rnwl3 = mysql_real_escape_string($_POST["year5"]);
$rnwl3 .= "-";
$rnwl3 .= mysql_real_escape_string($_POST["month5"]);
$rnwl3 .= "-";
$rnwl3 .= mysql_real_escape_string($_POST["day5"]);

$rnwlName1 = mysql_real_escape_string($_POST["ReminderName1"]);
$rnwlName2 = mysql_real_escape_string($_POST["ReminderName2"]);
$rnwlName3 = mysql_real_escape_string($_POST["ReminderName3"]);

$sql3 = "INSERT INTO `customer_general` (`ID`, `First_Name`, `Last_Name`, `Address`, `City`, `State`, `Zip`, `DOB`, `Email`, `Office`, `Group`, `ReminderName1`, `ReminderDate1`, `ReminderName2`, `ReminderDate2`, `ReminderName3`, `ReminderDate3`) ";
$sql3 .= "VALUES ('', '$fname', '$lname', '".mysql_real_escape_string($_POST["Address"])."', '".mysql_real_escape_string($_POST["City"])."', '".mysql_real_escape_string($_POST["State"])."', '".mysql_real_escape_string($_POST["Zip"])."', '$dob', '$email', '$dbase', '$group', '$rnwlName1', '$rnwl1', '$rnwlName2', '$rnwl2', '$rnwlName3', '$rnwl3')";
mysql_query($sql3);

echo("
<script>
<!--
location=\"customer_search.php\";
//-->
</script> 
");

?>
