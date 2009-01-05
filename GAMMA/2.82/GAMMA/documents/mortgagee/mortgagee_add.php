<?php
//GAMMA V2.7 CERTIFIED
session_start();
include(getcwd().'/../../includes/common.inc');
style("white");
connect_to();
$valid = $_SESSION["validsession"];
$admin = $_SESSION["admin"];
$dbase = $_SESSION["office"];
if($valid != 1)
{
	die("INVALID SESSION");
}

$name = mysql_real_escape_string($_POST["name"]);
$address = mysql_real_escape_string($_POST["address"]);
$city = mysql_real_escape_string($_POST["city"]);
$state = mysql_real_escape_string($_POST["state"]);
$zip = mysql_real_escape_string($_POST["zip"]);

$sql = "INSERT INTO `mortgagee` (`Number`, `Name`, `Address`, `City`, `State`, `Zip`, `Date`) VALUES ('', '$name', '$address', '$city', '$state', '$zip', NOW())";

$insertresult = mysql_query($sql);

if($insertresult == 1)
{
}
else
{
	log_error("Mortgagee Insert Failure: $sql", "mortgagee_add.php", $_SESSION["username"], $_SESSION["group"]);
	die( "MySQL Write1 Failure" );
}

echo( "
	<script>
	<!--
	location=\"mortgagee_search.php\";
	//-->
	</script> 
	" );

?>
