<?php
//GAMMA V2.7 CERTIFIED
session_start();
$valid = $_SESSION["validsession"];
if($valid != 1)
{
	die("INVALID SESSION");
}

include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();

$name = mysql_real_escape_string($_POST["name"]);
$address = mysql_real_escape_string($_POST["address"]);
$city = mysql_real_escape_string($_POST["city"]);
$state = mysql_real_escape_string($_POST["state"]);
$zip = mysql_real_escape_string($_POST["zip"]);
$num = mysql_real_escape_string($_POST["number"]);

$sql = "UPDATE `companyaddress` SET `Name` = '$name', `Address` = '$address', `City` = '$city', `State` = '$state', `Zip` = '$zip', `Date` = NOW() WHERE `Number` = '$num'";

$insertresult = mysql_query($sql);

if($insertresult == 1)
{
}
else
{
	log_error("Company Address Update Failure: $sql", "companyAddress_update.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write Failure<br>" );
}

echo( "
	<script>
	<!--
	location=\"companyAddress_search.php\";
	//-->
	</script> 
	" );

?>
